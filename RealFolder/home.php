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
                echo "<form action='login.php' method='get'> <input type='submit' value='Login/Register'></form><br>";
                echo "<form action='calc.html' method='get'> <input type='submit' value='Calculators'></form><br>";
                
        
                    $username = $_SESSION['username'];
                    require 'database.php';
                    // Check amount won
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
                    // Check amount lost
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



                    // Check pending
                    $stmt = $mysqli->prepare("select Sum(risk) from wagers where username=? and status='pending'");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                    $stmt->bind_result($pending);
                    echo "\n";
                    while($stmt->fetch()){
                    }
                    $stmt->close();


                    // Check credit
                    $stmt = $mysqli->prepare("select (credit) from users where username=? ");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                    $stmt->bind_result($initial_credit);
                    echo "\n";
                    while($stmt->fetch()){
                    }
                    $stmt->close();
                    
                 
                    $available_credit = $initial_credit + $balance - $pending;
                 
               
               
               
                echo "Balance: " . $balance . '<br>'; #call data base and retrieve balance
                echo "Available Credit: "   .   $available_credit .  '<br>'; #call data base and retreive balance
                echo "Pending: " . $pending .  '<br>' ;#call data base and retreive pending

            }
            ?>

           


            <form action='history.php' method='get'> <input type='submit' value='History'></form>
            <form action='pending.php' method='get'> <input type='submit' value='Pending'></form>
            <form action='parlay.html' method='get'> <input type='submit' value='Parlay'></form>


          

             
            <script src=getAPI.js>
            </script>
            <div id="Header"> 
            </div>


        <div id="Odds">
            Odds
        </div>
    
     

    </body>
</html>