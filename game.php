<?php
session_start();

if (!isset($_SESSION['playerName'])) {
    header("Location: index.html");
    exit;
}

$playerName = $_SESSION['playerName'];

// Number Guessing Game Logic
$secretNumber = rand(1, 10);  // Change the range as needed
$attempts = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guess = isset($_POST['guess']) ? $_POST['guess'] : null;

    if ($guess !== null) {
        $attempts++;

        if ($guess == $secretNumber) {
            // Player guessed correctly
            $score = 10 - $attempts;  // Adjust the scoring logic as needed
            saveScore($playerName, $score);

            // Redirect to congratulations page
            header("Location: congratulations.php?score=$score");
            exit;
        }
    }
}

function saveScore($playerName, $score) {
    $mysqli = new mysqli("localhost", "'root'@'localhost", "root", "number_guessing_game");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("INSERT INTO scores (player_name, score) VALUES (?, ?)");
    $stmt->bind_param("si", $playerName, $score);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number Guessing Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
        .navbar {
            background-color: black;
            color: white;
            padding: 10px; /* Adjust padding as needed */
            text-align: left ; /*left align the text */
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px; /* Add some margin between links */
        }

        .navbar a:hover {
            text-decoration: underline; /* Add underline on hover */
        }
    </style>

<body>

        <div class="navbar">
        <a href="index.html">Home</a>
        <a href="score.php">Score</a>
        <a href="#" onclick="exitGame()">Quit</a>
         </div>

    <div class="game">
        <h1>Welcome, <?php echo $playerName; ?>, to the Number Guessing Game!</h1>
        
        <!-- Number Guessing Game Form -->
        <form action="game.php" method="post">
            <label for="guess">Enter your guess (1-10):</label>
            <input type="number" id="guess" name="guess" min="1" max="10" required>
            <button type="submit">Submit</button>
        </form>

        <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Your existing logic for handling incorrect guesses
        if ($guess !== null && $guess != $secretNumber) {
            echo "<div class='footer'><p>Sorry, $playerName! Try again.</p></div>";
        }
    }
    ?>

     <script>
       function exitGame() {
       // Add any logic needed before exiting the game
        alert('Exiting the game...');
        window.location.href = 'index.html'; // Redirect to the home page
    }
    </script>
    </body>
    </html>
