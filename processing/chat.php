<?php

session_start();

require_once "config.php";  
//echo $_GET["q"];
$receiver = $_REQUEST["q"];
$username = $_SESSION["username"];
//echo $receiver;
//$receiver = "asder";
//$username = "admin";



$sql1 = "SELECT `message_body` AS 'message_sent' ,`id` , date_of_sending FROM `chat` WHERE `sender_username`='$username' AND `receiver_username`='$receiver' GROUP BY id;";


$sql2 = "SELECT `message_body` AS 'message_recived' ,`id`, date_of_sending FROM `chat` WHERE `sender_username`='$receiver' AND `receiver_username`='$username' GROUP BY id;";

$result1 = mysqli_query($link, $sql1);
$result2 = mysqli_query($link, $sql2);

if($result1 === FALSE) 
        {
            die(mysql_error());
        }else
        {
            $message_sent = array();
            while($row = mysqli_fetch_assoc($result1)) 
            {
                //array_push($message_sent[$row["id"]], array($row["message_sent"], $row["date_of_sending"]));
                $message_sent[$row["id"]] = array($row["message_sent"], $row["date_of_sending"]);
                //$message_sent[$row["id"]] = $row["message_sent"];
            }
        }
if($result2 === FALSE) 
        {
            die(mysql_error());
        }else
        {
            $message_recived = array();
            while($row = mysqli_fetch_assoc($result2)) 
            {
                //array_push($message_recived[$row["id"]], array($row["message_recived"], $row["date_of_sending"]));
                $message_recived[$row["id"]] = array($row["message_recived"], $row["date_of_sending"]);
                //$message_recived[$row["id"]] = $row["message_recived"];
            }
        }

foreach ($message_sent as $key => $value) {

        unset($message_sent[$key]);
        $message_sent[$key."s"] = $value;
        //$message_sent[$key."s"] = $value;
            
    }
//ksort($message_sent);
foreach ($message_recived as $key => $value) {

        unset($message_recived[$key]);
        $message_recived[$key."r"] = $value;
            
    }
//ksort($message_recived);
$messages = array_merge($message_sent,$message_recived);
//ksort($messages);
uksort($messages, "strnatcmp");
foreach ($messages as $key => $value) {
    unset($messages[$key]);
    $messages[substr($key,-1).substr($key,0,-1)] = $value;
}
//natsort($messages); 

//array_multisort($messages, SORT_ASC,  SORT_NATURAL );

echo json_encode($messages);
/*
foreach ($messages as $key => $value) {
    echo $value.$key;
    echo " ";
}
*/
    /*
    foreach ($messages as $key => $value) {
    if (substr($key, -1) == "r") {
        recived_messeage($username,$link);
    }elseif (substr($key, -1) == "s") {
        sent_messeage($username,$link);
    }
        
    }*/


?>