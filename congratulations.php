<?php
session_start();

if (!isset($_SESSION['playerName'])) {
    header("");
    exit;
}

$playerName = $_SESSION['playerName'];

// Get the score from the query parameters
$score = isset($_GET['score']) ? $_GET['score'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congratulations!</title>
    <link rel="stylesheet" href="style.css">
</head>


<body>
<div class="navbar">
        <a href="index.html">Home</a>
        <a href="score.php">Score</a>
        <a href="#" onclick="exitGame()">Quit</a>
         </div>

    <div class="con">
    
        <h1>Congratulations, <?php echo $playerName; ?>!</h1>
        <p>You guessed the correct number! Your score: <?php echo $score; ?></p>

        <!-- Play Again Button -->
        <form action="game.php" method="post">
            <button type="submit" name="playAgain">Play Again</button>
        </form>

        <!-- View Scores Button -->
        <a href="score.php" class="view-scores-button">View Scores</a>
    </div>
    <script src="script.js"></script>
<script>
function exitGame() {
    // Add any logic needed before exiting the game
    alert('Exiting the game...');
    window.location.href = 'index.html'; // Redirect to the home page
}
</script>

</body>
</html>
