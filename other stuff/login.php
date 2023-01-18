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
        <h1>Betting Site Login</h1>
        <form action="login.php" method="POST">
            <label>Username:</label>
            <input type="text" maxlength='20' name="new_username" required>
            <label>Password:</label>
            <input type="text" maxlength='20' name="new_password" required>
            <input type="submit" value="Register">
        </form>

        <form action="login.php" method="POST">
            <label>Username:</label>
            <input type="text" maxlength='20' name="username" required>
            <label>Password:</label>
            <input type="text" maxlength='20' name="password" required>
            <input type="submit" value="Log in">
        </form>

        <form action="home.php" method="get">
            <input type="submit" value="Return to main page.">
        </form>

        <?php

if (!isset($_SESSION['username'])){
    #echo $_SESSION['username'];
    #echo "You are not logged in yet.";
}
else{
    echo "You are logged in as " . $_SESSION['username'] . ". Remember to logout before trying to register log in as another user.";
}

        #login user code

        #you can't try to login as another user if you are already logged as one user
        #you need to logout first before logging in
            #https://stackoverflow.com/questions/12896766/check-form-input-length-via-php-with-maxlength-tag
            if (isset($_POST['username']) && isset($_POST['password']) && !isset($_SESSION['username'])){
                
                $username = $_POST['username'];
                $password = $_POST['password'];
                #$password = password_hash($password, PASSWORD_BCRYPT);

                require 'database.php';
                #check if username already taken
                $stmt2 = $mysqli->prepare("select COUNT(username) from users where username=?");
                if(!$stmt2){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                $stmt2->bind_param('s', $username);
                $stmt2->execute();
                $stmt2->bind_result($count);
                echo "\n";
                while($stmt2->fetch()){
                }
                $stmt2->close();

                if ($count==1){
                    #check if password is correct
                    $stmt3 = $mysqli->prepare("select salthash from users where username=?");
                    if(!$stmt3){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    $stmt3->bind_param('s', $username);
                    $stmt3->execute();
                    $stmt3->bind_result($hashedpw);
                    echo "\n";
                    while($stmt3->fetch()){
                    }
                    $stmt3->close();
                    if (password_verify($password, $hashedpw)){
                        echo "Congrats " . $username . ", you have successfully logged in.";
                        #set active user and start session
                        
                        $_SESSION['username'] = $username;
                        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); // generate a 32-byte random string
                        // In PHP 7, you can use the following, better technique:
                        // $_SESSION['token'] = bin2hex(random_bytes(32));
                        #echo "sesh" . $_SESSION['username'];
                    }
                    else{
                        echo "You have entered the incorrect password for " . $username . ", please try again.";
                    }
                }
                else{
                    echo "Username does not exist. Please register.";
                }
            }
            
        ?>

        <?php
        #register new user code
        #you can only register when you are logged out
            #https://stackoverflow.com/questions/12896766/check-form-input-length-via-php-with-maxlength-tag
            if (isset($_POST['new_username']) && isset($_POST['new_password']) && !isset($_SESSION['username'])){
                
                $new_username = $_POST['new_username'];
                $new_password = $_POST['new_password'];
                $new_password = password_hash($new_password, PASSWORD_BCRYPT);

                require 'database.php';
                #check if username already taken
                $stmt = $mysqli->prepare("select COUNT(username) from users where username=?");
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                $stmt->bind_param('s', $new_username);
                $stmt->execute();
                $stmt->bind_result($count);
                echo "\n";
                while($stmt->fetch()){
                }
                $stmt->close();

                if ($count==0){
                    #insert the user
                    $stmt1 = $mysqli->prepare("insert into users (username, salthash) values (?, ?)");
                    if(!$stmt1){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    $stmt1->bind_param('ss', $new_username, $new_password);
                    $stmt1->execute();
                    $stmt1->close();
                    echo "You successfully created a new account with username: " . $new_username . ". You will need to log in now with your username and password.";
                }
                else{
                    echo "Username already taken.";
                }

            }
            
        ?>

    </body>
</html>