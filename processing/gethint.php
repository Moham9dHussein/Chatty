<?php
// Array with names


session_start();

require_once "config.php";  
$receiver = $_REQUEST["q"];
$username = $_SESSION["username"];



$sql = "SELECT username FROM `accounts` WHERE `username`<>'$username';";


$result = mysqli_query($link, $sql);


if($result === FALSE) 
        {
            die(mysql_error());
        }else
        {
            $a = array();
            while($row = mysqli_fetch_assoc($result)) 
            {
              $a[] = $row['username'];


            }
        }




// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = array();

// lookup all hints from array if $q is different from ""
if ($q !== "") {
  $q = strtolower($q);
  $len=strlen($q);
  foreach($a as $name) {
    if (stristr($q, substr($name, 0, $len))) {
      
        $hint[] = $name;
      
    }
  }
}

// Output "no suggestion" if no hint was found or output correct values
echo empty($hint) === TRUE ? "no suggestion" : json_encode($hint);
?>