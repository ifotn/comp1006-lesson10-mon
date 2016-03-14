<?php ob_start();  // start the output buffer

// read the selected game_id from the url's querystring using GET
$game_id = $_GET['game_id'];

// if game_id is a number
if (is_numeric($game_id)) {

    // connect
    require_once('db.php');

    // write and run the delete query
    $sql = "DELETE FROM games WHERE game_id = :game_id";

    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':game_id', $game_id, PDO::PARAM_INT);
    $cmd->execute();

    // disconnect
    $conn = null;

    // redirect back to games.php
    header('location:games.php');
}

// clear the output buffer
ob_flush();
?>