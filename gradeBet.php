<?php
session_start();



$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

$id = htmlentities($json_obj['id']);
$home_team = htmlentities($json_obj['home_team']);
$home_score = htmlentities($json_obj['home_score']);
$away_score = htmlentities($json_obj['away_score']);
$away_team = htmlentities($json_obj['away_team']);
$username = $_SESSION['username'];



require 'database.php';

$stmt = $mysqli->prepare("select description from wagers where username=? and event_id=? and status='pending'");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
$stmt->bind_param('ss', $username, $id);
$stmt->execute();
$stmt->bind_result($description);
echo "\n";
while($row = $result->fetch_assoc()){
    if (strpos($description,"ML")){ #checks if its a ML or spread
        if (strpos($description,$home_team)){ #checks if the team bet on is the home team
            if($home_score > $away_score){ 
                #Home team won
                $status = 'win';  
            }else{
                #Away team won
                $status = 'loss';
            }
        }
            else{ #It is an away team
            if($home_score > $away_score){ 
                $status = 'loss';
            }else{
                $status = 'win';
            }
        }
    }else{ #It is a spread
        $int_var = (int)filter_var($description, FILTER_SANITIZE_NUMBER_INT); #from https://www.geeksforgeeks.org/how-to-extract-numbers-from-string-in-php/
        if(strpos($description,"-")){ #Checks to see if its a - spread
            if (strpos($description,$home_team)){ #checks if the team bet on is the home team
                if($home_score-$int_var > $away_score){
                    $status = 'win';
                }else{
                    $status = 'loss';
                }
        }else{  #it is the away team
            if ($home_score < $away_score-$int_var){
                $status = 'win';
            }else{
                $status = 'loss';
        }
    }

    }else{ #It is a + spread
        if (strpos($description,$home_team)){ #checks if the team bet on is the home team
            if($home_score+$int_var > $away_score){
                $status = 'win';
            }else{
                $status = 'loss';
            }
    }else{  #it is the away team
        if ($home_score < $away_score+$int_var){
            $status = 'win';
        }else{
            $status = 'loss';
    }
}
}

    $stmt1 = $mysqli->prepare("update wagers set status='win' where description=? and username=? and event_id=? and status='pending'");
    if(!$stmt1){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt1->bind_param('sss', $description, $username, $id);
    $stmt1->execute();
    $stmt1->close();





 }
}
$stmt->close();
// Check amount lost

?>