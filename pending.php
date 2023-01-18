<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <link href="home.css" type="text/css"  rel="stylesheet">
        <title>Barr's Bets</title>
    </head>
    <body>
        <h1>Betting Site Pending Page</h1>

        <form action="home.php" method="get">
            <input type="submit" value="Return to main page.">
        </form>
        <form >
            <input type = "button" value="Grade Bets" id="grade">
        </form>
        <script src=checkScores.js>
            </script>

        <?php
        require 'database.php';
        $username = $_SESSION['username'];
        $stmt = $mysqli->prepare("SELECT `betId`, `date_placed`, `description`, `event`, `risk`, `win`, `username`, `status` FROM `wagers` WHERE username=? and status = 'pending'");
        

        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('s', $username);
        $stmt->execute();
        
        $result = $stmt->get_result();
        echo "<table>";
        echo "<tr><td>" . "Bet ID" . "</td><td>" . "Date Placed" . "</td><td>" . "Description" . "</td><td>" .  "Event" . "</td><td>" . "Risk" . "</td><td>"  . "To Win" . "</td><td>" . "Status" . "</td><td>" .  "</td></tr>";

        while($row = $result->fetch_assoc()){
            echo "<tr><td>" . htmlspecialchars($row['betId']) . "</td><td>" . htmlspecialchars($row['date_placed']) . "</td><td>" . htmlspecialchars($row['description']) . "</td><td>" . htmlspecialchars($row['event']) . "</td><td>" . htmlspecialchars($row['risk']) . "</td><td>" . htmlspecialchars($row['win']) . "</td><td>" . htmlspecialchars($row['status']) . "</td></tr>";

         } echo "\n";
         echo "</table>";

        $stmt->close();
        
        ?>
    </body>
</html>