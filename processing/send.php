<?php  

session_start();

require_once "config.php";  
$username = $_SESSION["username"];


$data = json_decode(file_get_contents("php://input"));

$name = $data->rname;
$msg = $data->message;




// Insert record
$sql = "INSERT into chat(sender_username,receiver_username,message_body) values('$username','$name','$msg')";
if(mysqli_query($link,$sql)){
   echo 1; 
}else{
   echo 0;
}

?>