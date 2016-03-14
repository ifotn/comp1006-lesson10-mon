<!DOCTYPE html>
<html>
<head>
    <title>Saving your Game...</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>
<body>

<a href="game.php" title="Add a Game">Add a New Game</a>
<a href="games.php" title="Game Listings">View Games</a>

<?php
// store the form inputs in variables
$name = $_POST['name'];
$age_limit = $_POST['age_limit'];
$release_date = $_POST['release_date'];
$size = $_POST['size'];

// add game_id in case we are editing
$game_id = $_POST['game_id'];

// create a flag to track the completion status of the form
$ok = true;

// do our form validation before saving
if (empty($name)) {
    echo 'Name is required<br />';
    $ok = false;
}

if (empty($age_limit) || !is_numeric($age_limit)) {
    echo 'Age limit is required and must be a number<br />';
    $ok = false;
}

if (empty($release_date) || !is_numeric($release_date)) {
    echo 'Release date is required and must be a number<br />';
    $ok = false;
}

if (empty($size) || !is_numeric($size)) {
    echo 'Size is required and must be a number<br />';
    $ok = false;
}

// save ONLY IF the form is complete
if ($ok) {

    // connecting to the database
    require_once('db.php');

    // if we have an existing game_id, run an update
    if (!empty($game_id)) {
        $sql = "UPDATE games SET name = :name, age_limit = :age_limit,
          release_date = :release_date, size = :size WHERE game_id = :game_id";
    }
    else {
        // set up an SQL command to save the new game
        $sql = "INSERT INTO games (name, age_limit, release_date, size)
          VALUES (:name, :age_limit, :release_date, :size)";
    }

    // set up a command object
    $cmd = $conn->prepare($sql);

    // fill the placeholders with the 4 input variables
    $cmd->bindParam(':name', $name, PDO::PARAM_STR, 50);
    $cmd->bindParam(':age_limit', $age_limit, PDO::PARAM_INT);
    $cmd->bindParam(':release_date', $release_date, PDO::PARAM_INT);
    $cmd->bindParam(':size', $size, PDO::PARAM_INT);

    // add the game_id param if updating
    if (!empty($game_id)) {
        $cmd->bindParam(':game_id', $game_id, PDO::PARAM_INT);
    }

    // execute the insert
    $cmd->execute();

    // show message
    echo "Game Saved";

    // disconnecting
    $conn = null;

    // send confirmation email

}
?>
</body>
</html>