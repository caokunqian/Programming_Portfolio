<?php
// Continue the session or start a new one
session_start();

function updatePollOptions() {
    // Filter out empty options and reset the session variables
    $new_options = array_filter($_POST['poll_option'], function($value) { return $value !== ''; });
    $_SESSION['poll'] = array_values($new_options);
    $_SESSION['poll_results'] = array_fill_keys($_SESSION['poll'], 0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clear'])) {
        // Clear the poll results and options
        unset($_SESSION['poll_results']);
        unset($_SESSION['poll']);
        $_SESSION['show_results'] = false; // Hide results after clearing
    } elseif (isset($_POST['vote']) && isset($_POST['choice'])) {
        // Record a vote
        $_SESSION['poll_results'][$_POST['choice']] = ($_SESSION['poll_results'][$_POST['choice']] ?? 0) + 1;
        $_SESSION['show_results'] = false; // Show results after voting
    } elseif (isset($_POST['view_results'])) {
        // Show the results
        $_SESSION['show_results'] = true;
    } elseif (isset($_POST['hide_results'])) {
        // Hide the results
        $_SESSION['show_results'] = false;
    } elseif (isset($_POST['update_options'])) {
        updatePollOptions();
        $_SESSION['show_results'] = false; // Hide results after updating options
    }
}


// Initialize variables
$poll_options = $_SESSION['poll'] ?? ['Option 1', 'Option 2', 'Option 3'];
$poll_results = $_SESSION['poll_results'] ?? array_fill_keys($poll_options, 0);
$show_results = $_SESSION['show_results'] ?? false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Poll Maker</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; }
        .title { font-size: 28px; text-align: center; margin-top: 20px; background-image: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet); color: transparent; -webkit-background-clip: text; }
        .instructions { background: beige; padding: 10px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: 10px auto; font-size: 16px; text-align: center; max-width: 600px; }
        .button { padding: 8px 16px; margin: 10px; font-size: 18px; cursor: pointer; }
        .centered { text-align: center; }
        .poll-option-input { margin-bottom: 5px; display: block; width: 80%; margin-left: auto; margin-right: auto; }
        .buttons-container { text-align: center; }
        .back-to-main-button {
    position: fixed; /* Fixed position */
    top: 10px; /* 10px from the top */
    right: 10px; /* 10px from the right */
    background-color: #FF3B30; /* Red background */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    z-index: 1000; /* Make sure it's above other items */
}

.back-to-main-button:hover {
    background-color: #4CAF50; /* Green background on hover */
}

    </style>
</head>
<body>
    <h1 class="title">Online Poll Maker</h1>
    <div class="instructions">
        <p>This is a polling tool. You can create your poll with custom options, share it, and see results in real-time. </p>
        <p>Use the buttons to manage your poll. The default result is hidden, click the button to see it</p>
    </div>
    <button class="back-to-main-button" onclick="window.location.href='index.php';">Back to Main Page</button>

    <form action="script4.php" method="post" class="centered">
        <div>
            <?php foreach ($poll_options as $option): ?>
                <label>
                    <input type="radio" name="choice" value="<?= htmlspecialchars($option) ?>"> <?= htmlspecialchars($option) ?>
                </label><br>
            <?php endforeach; ?>
            <button type="submit" name="vote" class="button">Vote</button>
        </div>

        <div class="buttons-container">
            <?php if ($show_results): ?>
                <button type="submit" name="hide_results" class="button">Hide Results</button>
            <?php else: ?>
                <button type="submit" name="view_results" class="button">View Results</button>
            <?php endif; ?>
            <button type="submit" name="clear" class="button">Clear Poll</button>
            <button type="submit" name="update_options" class="button">Update Options</button>
        </div>

        <?php if ($show_results): ?>
            <div>
                <p>Results:</p>
                <?php foreach ($poll_results as $option => $count): ?>
                    <p><?= htmlspecialchars($option) ?>: <?= $count ?> votes</p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div>
            <p>Edit Poll Options:</p>
            <?php foreach ($poll_options as $index => $option): ?>
                <input type="text" name="poll_option[]" class="poll-option-input" value="<?= htmlspecialchars($option) ?>" placeholder="Option <?= $index + 1 ?>">
            <?php endforeach; ?>
            <button type="submit" name="update_options" class="button">Update Options</button>
        </div>
    </form>
</body>
</html>
