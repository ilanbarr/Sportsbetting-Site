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
        <h1>Betting Site</h1>
        <?php
        #display either log in button or log out button with 
            if (isset($_SESSION['username'])){
                $token = $_SESSION['token'];
                echo "You are currently logged in as: " . $_SESSION['username'];
                echo "<form action='logout.php' method='get'> <input type='submit' value='Logout'></form><br>";
        
                    $username = $_SESSION['username'];
                    require 'database.php';
                    $stmt = $mysqli->prepare("select Sum(win) from wagers where username=? and status='win'");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                    $stmt->bind_result($balance_win);
                    echo "\n";
                    while($stmt->fetch()){
                    }
                    $stmt->close();
                    $stmt = $mysqli->prepare("select Sum(risk) from wagers where username=? and status='loss'");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                    $stmt->bind_result($balance_loss);
                    echo "\n";
                    while($stmt->fetch()){
                    }
                    $stmt->close();
                    
                    $balance = $balance_win - $balance_loss;

               
               
               
                echo "Balance: " . $balance . '<br>'; #call data base and retrieve balance
                echo "Credit: "   .'<br>'; #call data base and retreive balance
                echo "Pending: " .  '<br>' ;#call data base and retreive pending


            }
            ?>
            
                fetch('')

                GET https://api.the-odds-api.com/v4/sports/?apiKey=YOUR_API_KEY


            </script>




    </body>
</html>