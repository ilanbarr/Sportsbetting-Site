<?php
session_start();



$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

$bet_description = htmlentities($json_obj['bet_description']);
$bet_amount = htmlentities($json_obj['bet_amount']);
$bet_price = htmlentities($json_obj['bet_price']);
$bet_event = htmlentities($json_obj['bet_event']);
$username = $_SESSION['username'];
$bet_win = $bet_amount * $bet_price;
$status = "pending";
$event_id = htmlentities($json_obj['event_id']);


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





if($available_credit-$bet_amount >=0){


$stmt = $mysqli->prepare("insert into wagers (description, event, risk, win, username, status, event_id) values (?,?,?,?,?,?,?)");

if(!$stmt){

    echo json_encode(array(
        "success" => false,
        "message" => "Query Prep Failed: %s\n" . $mysqli->error
    ));
    exit;
}
$stmt->bind_param('ssiisss', $bet_description,$bet_event,$bet_amount, $bet_win, $username, $status, $event_id);
$stmt->execute();
$stmt->close();

echo json_encode(array(
    "success" => true,
    "message" => "You succesfully added a wager" . $credit
));
exit;
}else{
    echo json_encode(array(
        "success" => false,
        "message" => "Noth Enough Credit: %s\n" . $mysqli->error
    ));
}


?>