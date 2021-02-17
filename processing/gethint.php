<?php
// Array with names
/*
$a[] = "Anna";
$a[] = "Brittany";
$a[] = "Cinderella";
$a[] = "Diana";
$a[] = "Eva";
$a[] = "Fiona";
$a[] = "Gunda";
$a[] = "Hege";
$a[] = "Inga";
$a[] = "Johanna";
$a[] = "Kitty";
$a[] = "Linda";
$a[] = "Nina";
$a[] = "Ophelia";
$a[] = "Petunia";
$a[] = "Amanda";
$a[] = "Raquel";
$a[] = "Cindy";
$a[] = "Doris";
$a[] = "Eve";
$a[] = "Evita";
$a[] = "Sunniva";
$a[] = "Tove";
$a[] = "Unni";
$a[] = "Violet";
$a[] = "Liza";
$a[] = "Elizabeth";
$a[] = "Ellen";
$a[] = "Wenche";
$a[] = "Vicky";
*/


session_start();

require_once "config.php";  
//echo $_GET["q"];
$receiver = $_REQUEST["q"];
$username = $_SESSION["username"];
//echo $receiver;
//$receiver = "asder";
//$username = "admin";



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