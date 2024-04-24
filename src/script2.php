<?php
session_start();

define('SIZE', 4); // 4x4 grid
$score = 0;
$board = [];

function initBoard() {
    if (!isset($_SESSION['board'])) {
        $board = array_fill(0, SIZE, array_fill(0, SIZE, 0));
        addRandomTile($board);
        addRandomTile($board);
        $_SESSION['board'] = $board;
        $_SESSION['score'] = 0;
        $_SESSION['moves'] = 0;
    }
}

function addRandomTile(&$board) {
    $emptyTiles = [];
    for ($i = 0; $i < SIZE; $i++) {
        for ($j = 0; $j < SIZE; $j++) {
            if ($board[$i][$j] == 0) {
                $emptyTiles[] = [$i, $j];
            }
        }
    }
    if (count($emptyTiles) > 0) {
        list($x, $y) = $emptyTiles[array_rand($emptyTiles)];
        $board[$x][$y] = (rand(0, 100) > 89) ? 4 : 2;
    }
}

function canMove($board) {
    for ($i = 0; $i < SIZE; $i++) {
        for ($j = 0; $j < SIZE; $j++) {
            if ($board[$i][$j] == 0) {
                return true;
            }
            if ($i < SIZE - 1 && $board[$i][$j] == $board[$i + 1][$j]) {
                return true;
            }
            if ($j < SIZE - 1 && $board[$i][$j] == $board[$i][$j + 1]) {
                return true;
            }
        }
    }
    return false;
}

function rotateBoard(&$board, $clockwise = true) {
    $newBoard = array();
    for ($i = 0; $i < SIZE; $i++) {
        $newBoard[$i] = array();
        for ($j = 0; $j < SIZE; $j++) {
            if ($clockwise) {
                $newBoard[$i][$j] = $board[SIZE - $j - 1][$i];
            } else {
                $newBoard[$i][$j] = $board[$j][SIZE - $i - 1];
            }
        }
    }
    $board = $newBoard;
}

function transposeBoard(&$board) {
    $transposed = array();
    for ($i = 0; $i < SIZE; $i++) {
        for ($j = 0; $j < SIZE; $j++) {
            $transposed[$j][$i] = $board[$i][$j];
        }
    }
    $board = $transposed;
}

function reverseRows(&$board) {
    for ($i = 0; $i < SIZE; $i++) {
        $board[$i] = array_reverse($board[$i]);
    }
}


function moveTiles(&$board, $direction) {
    $hasChanged = false;
    // Improved handling for the reversal of rows and transposition
    if ($direction === 'w' || $direction === 's') {
        transposeBoard($board);
    }

    if ($direction === 's' || $direction === 'd') {
        reverseRows($board);
    }

    for ($i = 0; $i < SIZE; $i++) {
        $oldLine = $board[$i];
        $newLine = array_values(array_filter($oldLine, function($value) { return $value != 0; }));
        $newLine = mergeLine($newLine);
        $newLine = array_pad($newLine, SIZE, 0);

        if ($direction === 's' || $direction === 'd') {
            $newLine = array_reverse($newLine);
        }

        if ($board[$i] !== $newLine) {
            $board[$i] = $newLine;
            $hasChanged = true;
        }
    }

    if ($direction === 'w' || $direction === 's') {
        transposeBoard($board);
    }

    return $hasChanged;
}

function mergeLine($line) {
    for ($i = 0; $i < count($line) - 1; $i++) {
        if ($line[$i] == $line[$i + 1]) {
            $line[$i] *= 2;
            $_SESSION['score'] += $line[$i];
            array_splice($line, $i + 1, 1); // Remove the merged element
            $line[] = 0; // Maintain the size by adding zero at the end
        }
    }
    return $line;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['restart'])) {
        session_destroy();
        session_start();
        initBoard();
        header("Location: script2.php"); // Redirect to clean POST request
        exit();
    }

    $direction = $_POST['direction'] ?? '';
    $board = $_SESSION['board'];
    $score = $_SESSION['score'];

    if (moveTiles($board, $direction)) {
        addRandomTile($board);
        $_SESSION['board'] = $board;
        $_SESSION['moves']++;
    }

    if (!canMove($board)) {
        $_SESSION['message'] = "Game over! Total moves: {$_SESSION['moves']}, Score: {$_SESSION['score']}";
    } else {
        unset($_SESSION['message']); // Clear any previous messages
    }
    
}

initBoard();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>2048 Game</title>
    <form id="restartForm" action="script2.php" method="post">
    <input type="hidden" name="restart" value="1">
</form>
    <style>
        body { font-family: Arial, sans-serif; }
        .game-container { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; max-width: 400px; margin: auto; }
        .tile { width: 90px; height: 90px; display: flex; align-items: center; justify-content: center; background-color: #f0e4d7; font-size: 24px; font-weight: bold; color: #776e65; }
        button { padding: 10px; margin: 5px; }
        #message { 
            color: red; 
            font-size: 32px; 
            text-align: center; 
            position: fixed; /* Center the message */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 2px solid red;
            border-radius: 10px;
            z-index: 1000; /* Ensure it's on top */
        }
        #overlay {
            display: none; /* Hide by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Black background with opacity */
            z-index: 999; /* Under the message */
        }
        /* Show overlay and message when game over */
        .game-over #overlay,
        .game-over #message {
            display: block;
        }
    </style>
</head>
<body class="<?= isset($_SESSION['message']) ? 'game-over' : '' ?>">
    <div id="overlay"></div>
    <h2>2048 Game</h2>
    <p>Use WASD or arrow keys to move the tiles. Merge them to reach 2048!</p>
    <form action="script2.php" method="post">
        <div class="game-container">
            <?php foreach ($_SESSION['board'] as $row) : ?>
                <?php foreach ($row as $value) : ?>
                    <div class="tile"><?= $value ? $value : '' ?></div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
        <div>
            <button name="direction" value="w">Up</button>
            <button name="direction" value="a">Left</button>
            <button name="direction" value="s">Down</button>
            <button name="direction" value="d">Right</button>
            <button type="submit" name="restart">Restart</button>
        </div>
    </form>
    <?php if (isset($_SESSION['message'])): ?>
    <div id="message">
        <?= $_SESSION['message'] ?>
        <form action="script2.php" method="post">
            <button type="submit" name="restart">Restart Now</button>
        </form>
    </div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Existing keydown event listener
    document.body.addEventListener('keydown', function(e) {
        switch(e.key) {
            case 'ArrowUp':
            case 'w': document.querySelector('button[value="w"]').click(); break;
            case 'ArrowLeft':
            case 'a': document.querySelector('button[value="a"]').click(); break;
            case 'ArrowDown':
            case 's': document.querySelector('button[value="s"]').click(); break;
            case 'ArrowRight':
            case 'd': document.querySelector('button[value="d"]').click(); break;
        }
    });



    // Automatic restart logic
    if (document.body.classList.contains('game-over')) {
        setTimeout(function() {
            document.getElementById('restartForm').submit();
        }, 5000);
    }
});
</script>

</body>


</html>
