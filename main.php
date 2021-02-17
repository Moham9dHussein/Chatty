<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "processing/config.php";


$username = $_SESSION["username"];


function isActive($use,$link,$i) {
    $sql="SELECT * FROM accounts WHERE username='$use'";
    $result = mysqli_query($link, $sql);
    if($result === FALSE) { 
        die(mysql_error());
    }
    else{
        $row = mysqli_fetch_array($result);
        if ($row[0] == 1) {
            echo '<li id="'.$i.'">
            <div class="d-flex bd-highlight">
            <div class="img_cont">
            <img src="images/1.png" class="rounded-circle user_img">
            <span class="online_icon"></span>
            </div>
            <div class="user_info">
            <span id="user_head'.$i.'">'.$use.'</span>
            <p>online</p>
            </div>
            </div>
            </li>';
        }else{
            echo '<li id="'.$i.'">
            <div class="d-flex bd-highlight">
            <div class="img_cont">
            <img src="images/1.png" class="rounded-circle user_img">
            <span class="online_icon offline"></span>
            </div>
            <div class="user_info">
            <span id="user_head'.$i.'">'.$use.'</span>
            <p>offline</p>
            </div>
            </div>
            </li>';
        }


    }
}
function listContacts($username,$link) {
    $sql="SELECT DISTINCT receiver_username FROM chat WHERE sender_username='$username'";
    $result = mysqli_query($link, $sql);
    if($result === FALSE) { 
        die(mysql_error());
    }
    else{
        $lcontacts = array();
        while($row = mysqli_fetch_assoc($result)) {
            $lcontacts[] = $row['receiver_username'];
        }
    }

       $sql2="SELECT DISTINCT sender_username FROM chat WHERE receiver_username='$username'";
    $result = mysqli_query($link, $sql2);
    if($result === FALSE) { 
        die(mysql_error());
    }
    else{
        
        while($row = mysqli_fetch_assoc($result)) {
        	$cont = $row['sender_username'];
        	if (!in_array($cont, $lcontacts)) {
        		$lcontacts[] = $cont;
        	}
            
        }
        for ($x = 0; $x < count($lcontacts); $x++) {


            isActive($lcontacts[$x], $link, $x);
        }





    }}
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{ font: 14px sans-serif; text-align: center; }
        </style>
        <title>Chat</title>
        <link rel="stylesheet" href="Style/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="Style/css/style.css">
        <script src="Style/js/jquery.min.js"></script>
        <script src="Style/js/mCustomScrollbar.min.js"></script>
    </head>
    <body>
        <div class="container-fluid h-100">
        	<div class="page-header">
            <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        </div>
        <p>
            <a href="../../processing/logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        </p>
            <div class="row justify-content-center h-100">
                <div class="col-md-4 col-xl-3 chat">
                    <div class="card mb-sm-3 mb-md-0 contacts_card">
                        <!--The Search bar-->
                        <div class="card-header">
                            <div class="input-group">
                                <input type="text" oninput='onInput()' id="searchBar" list="sugg"  placeholder="Search..." name="" class="form-control search" onkeyup="showHint(this.value)">
                                <datalist id="sugg">

								</datalist>

                                <div class="input-group-prepend">
                                    <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <!--The Left side-->
                        <div class="card-body contacts_body">
                            <ui class="contacts" id="myui" >
                                <?php listContacts($username,$link); ?>
                            </ui>
                        </div>
                        <!--The Left side
                        <div class="card-footer">

                        </div>-->
                    </div>
                </div>
                <div class="col-md-8 col-xl-6 chat">
                    <div class="card">
                        <div class="card-header msg_head" id="heady">
                        </div>
                        <div class="card-body msg_card_body" id="chatBox">


                        </div>


                        <div class="card-footer" id="myfooter">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="Style/js/myjs.js"></script>
        
    </body>
    </html>