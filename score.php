<?php
session_start();

if (!isset($_SESSION['playerName'])) {
    header("Location: index.html");
    exit;
}

$playerName = $_SESSION['playerName'];

// Fetch all scores and total score for the player
$scoresData = getScores($playerName);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number Guessing Game - Scores</title>
    <link rel="stylesheet" href="style.css">
</head>


<body>

<div class="navbar">
        <a href="index.html">Home</a>
        <a href="score.php">Score</a>
        <a href="#" onclick="exitGame()">Quit</a>
         </div>

    <div class="sc">
        <h1>Scores for <?php echo $playerName; ?></h1>

        <?php
        if ($scoresData) {
            $scores = $scoresData['individualScores'];
            $totalScore = $scoresData['totalScore'];

            echo '<ul>';
            foreach ($scores as $score) {
                echo '<li>' . $score['score'] . '</li>';
            }
            echo '</ul>';

            echo '<p>Total Score: ' . $totalScore . '</p>';
        } else {
            echo '<p>No scores available.</p>';
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

<?php

function getScores($playerName) {
    $mysqli = new mysqli("localhost", "'root@'localhost", "root", "number_guessing_game");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Fetch individual scores
    $stmt = $mysqli->prepare("SELECT score FROM scores WHERE player_name = ? ORDER BY score DESC");
    $stmt->bind_param("s", $playerName);
    $stmt->execute();
    $result = $stmt->get_result();
    $individualScores = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Fetch total score
    $stmt = $mysqli->prepare("SELECT SUM(score) AS total FROM scores WHERE player_name = ?");
    $stmt->bind_param("s", $playerName);
    $stmt->execute();
    $result = $stmt->get_result();
    $totalScore = $result->fetch_assoc()['total'];
    $stmt->close();

    $mysqli->close();

    return [
        'individualScores' => $individualScores,
        'totalScore' => $totalScore,
    ];
    
}
?>
