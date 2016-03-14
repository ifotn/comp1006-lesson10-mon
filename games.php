<?php  ob_start();

// authentication check
require_once ('auth.php');

// set page title and embed header
$page_title = null;
$page_title = 'Video Game Listings';
require_once('header.php'); ?>

<h1>Video Games</h1>

<?php

// add an error handler in case anything breaks
try {
    // connect
        require_once('db.php');

    // write the query to fetch the game data
        $sql = "SELECT * FROM games ORDER BY name";

    // run the query and store the results into memory
        $cmd = $conn->prepare($sql);
        $cmd->execute();
        $games = $cmd->fetchAll();

    // start the table and add the headings
        echo '<table class="table table-striped"><thead><th>Name</th><th>Age Limit</th>
        <th>Release Date</th><th>Size</th><th>Edit</th><th>Delete</th></thead><tbody>';

        /* loop through the data, creating a new table row for each game
        and putting each value in a new column */
        foreach ($games as $game) {
            echo '<tr><td>' . $game['name'] . '</td>
            <td>' . $game['age_limit'] . '</td>
            <td>' . $game['release_date'] . '</td>
            <td>' . $game['size'] . '</td>
            <td><a href="game.php?game_id=' . $game['game_id'] . '">Edit</a></td>
            <td>
            <a href="delete-game.php?game_id=' . $game['game_id'] .
                '" onclick="return confirm(\'Are you sure?\');">
                Delete</a></td></tr>';
        }

    // close the table
        echo '</tbody></table>';

    // disconnect
        $conn = null;
}
catch (Exception $e) {
    // send ourselves an email
    mail('georgian2015@hotmail.com', 'Games Listing Error', $e);

    // redirect to the error page
    header('location:error.php');
}

// embed footer
require_once('footer.php');
ob_flush();
?>
