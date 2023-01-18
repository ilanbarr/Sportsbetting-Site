<?php
    session_start();
    session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <link href="home.css" type="text/css"  rel="stylesheet">
        <title>Barr's Bets</title>
    </head>
    <body>
        <h1>Betting Site Logout Page Page</h1>

        <form action="home.php" method="get">
            <input type="submit" value="Return to main page.">
        </form>

        <form action='login.php' method='get'>
            <input type='submit' value='Login/Register'>
        </form>
        

    </body>
</html>