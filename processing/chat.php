<?php

session_start();

require_once "config.php";  
$receiver = $_REQUEST["q"];
$username = $_SESSION["username"];



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
                $message_sent[$row["id"]] = array($row["message_sent"], $row["date_of_sending"]);
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
                $message_recived[$row["id"]] = array($row["message_recived"], $row["date_of_sending"]);
            }
        }

foreach ($message_sent as $key => $value) {

        unset($message_sent[$key]);
        $message_sent[$key."s"] = $value;
            
    }
foreach ($message_recived as $key => $value) {

        unset($message_recived[$key]);
        $message_recived[$key."r"] = $value;
            
    }

$messages = array_merge($message_sent,$message_recived);
uksort($messages, "strnatcmp");
foreach ($messages as $key => $value) {
    unset($messages[$key]);
    $messages[substr($key,-1).substr($key,0,-1)] = $value;
} 



echo json_encode($messages);
?>