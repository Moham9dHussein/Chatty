<?php
// Initialize the session
session_start();

require_once "config.php";

$username = $_SESSION["username"];

$sqlup="UPDATE `accounts` SET `status` = 0 WHERE username = '$username'";
$result = mysqli_query($link, $sqlup);
if($result === FALSE) { 
    die(mysql_error());
}                     
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: ../index.php");
exit;
?>