<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playerName = $_POST['playerName'];
    $playerName = htmlspecialchars(trim($playerName));

    session_start();
    $_SESSION['playerName'] = $playerName;

    header("Location: game.php");
    exit;
}
?>
