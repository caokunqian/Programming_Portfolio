<?php
// Start PHP session to manage game state across page reloads.
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['restart'])) {
        // Clear session data to restart the game
        session_destroy();
        session_start();
    }
    // Redirect to clean POST request and refresh the game
    header("Location: script3.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game</title>
    <style>
        body { font-family: 'Arial', sans-serif; background: #f4f4f9; }
        .title { color: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet); font-size: 28px; font-weight: bold; text-align: center; background-image: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet); -webkit-background-clip: text; color: transparent; }
        .instructions { background: beige; padding: 10px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: 10px; font-size: 16px; }
        .game-container { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; padding: 10px; max-width: 600px; margin: auto; }
        .card { width: 100px; height: 100px; background: #ddd; display: flex; justify-content: center; align-items: center; font-size: 20px; color: #333; border-radius: 8px; cursor: pointer; }
        .hidden { background: #666; }
        button { padding: 8px 16px; margin: 10px; font-size: 18px; cursor: pointer; }
        .counter { text-align: center; font-size: 18px; }
    </style>
</head>
<body>
    <h1 class="title">Memory Game</h1>
    <div class="instructions">
        <p>A simple Memory Game. Try to find all matching pairs of cards. Click on two cards to flip them. If they match, they'll stay flipped. If not, try again!</p>
    </div>
    <div class="game-container" id="gameBoard"></div>
    <div class="counter">
        Attempts: <span id="attempts">0</span><br>
        Score: <span id="score">0</span>
    </div>
    <div>
        <button onclick="restartGame();">Restart Game (New Cards)</button>
        <button onclick="tryAgain();">Try Again (Same Cards)</button>
        <button onclick="resetCount();">Reset Count</button>
    </div>

    <script>
        const cards = ['A', 'A', 'B', 'B', 'C', 'C', 'D', 'D', 'E', 'E', 'F', 'F', 'G', 'G', 'H', 'H'];
        let selectedCards = [];
        let matchedCards = [];
        let attempts = 0;
        let score = 0;

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
        }

        function setupBoard() {
            shuffleArray(cards);
            const gameBoard = document.getElementById('gameBoard');
            gameBoard.innerHTML = '';
            cards.forEach((card, index) => {
                const cardElement = document.createElement('div');
                cardElement.classList.add('card', 'hidden');
                cardElement.dataset.cardValue = card;
                cardElement.dataset.index = index;
                cardElement.onclick = flipCard;
                gameBoard.appendChild(cardElement);
            });
        }

        function flipCard() {
            const cardValue = this.dataset.cardValue;
            const cardIndex = this.dataset.index;

            if (!selectedCards.includes(cardIndex) && !matchedCards.includes(cardValue)) {
                this.classList.remove('hidden');
                this.textContent = cardValue;
                selectedCards.push(cardIndex);

                if (selectedCards.length === 2) {
                    attempts++;
                    document.getElementById('attempts').textContent = attempts;
                    const firstCard = document.querySelector(`.card[data-index="${selectedCards[0]}"]`);
                    const secondCard = this;

                    if (firstCard.dataset.cardValue === secondCard.dataset.cardValue) {
                        matchedCards.push(firstCard.dataset.cardValue);
                        score += 10; // 5 points per matched card
                        document.getElementById('score').textContent = score;
                        selectedCards = [];
                    } else {
                        setTimeout(() => {
                            firstCard.classList.add('hidden');
                            secondCard.classList.add('hidden');
                            firstCard.textContent = '';
                            secondCard.textContent = '';
                            selectedCards = [];
                        }, 100);
                    }
                }
            }
        }

        function restartGame() {
            selectedCards = [];
            matchedCards = [];
            attempts = 0;
            score = 0;
            document.getElementById('attempts').textContent = attempts;
            document.getElementById('score').textContent = score;
            setupBoard();
        }

        function tryAgain() {
            selectedCards = [];
            matchedCards.forEach(matchedCardValue => {
                const matchedCards = document.querySelectorAll(`.card[data-card-value="${matchedCardValue}"]`);
                matchedCards.forEach(card => card.classList.remove('hidden'));
            });
            setupBoard();
        }

        function resetCount() {
            attempts = 0;
            score = 0;
            document.getElementById('attempts').textContent = attempts;
            document.getElementById('score').textContent = score;
        }

        window.onload = setupBoard;
    </script>
</body>
</html>
