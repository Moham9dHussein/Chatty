<?php

session_start();


if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: main.php");
    exit;
      }


require_once "processing/config.php";


$username = $password = "";
$username_err = $password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
  $username = trim($_POST["username"]);
  $password = trim($_POST["pass"]);
        $sql = "SELECT id, username, password FROM accounts WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    

                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if($password == $hashed_password){

                            session_start();
                            

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;


                                $sqlup="UPDATE `accounts` SET `status` = 1 WHERE username = '$username'";
                                $result = mysqli_query($link, $sqlup);
                                if($result === FALSE) { 
                                    die(mysql_error());
                                }                           
                            
                            header("location: main.php");
                        } else{

                            $password_err = "The password you entered was not valid.";
                            
                        }
                    }
                } else{

                    $username_err = "No account found with that username.";
                    
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }

    mysqli_close($link);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Chatty</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/message.png" />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="Style/css/bootstrap.min.css"
    />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="Style/css/font-awesome.min.css"
    />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="Style/css/material-design-iconic-font.min.css"
    />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="Style/css/animate.css" />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="Style/css/hamburgers.min.css"
    />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="Style/css/animsition.min.css"
    />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="Style/css/select2.min.css"
    />
    <!--===============================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="Style/css/daterangepicker.css"
    />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="Style/css/util.css" />
    <link rel="stylesheet" type="text/css" href="Style/css/main.css" />
    <!--===============================================================================================-->
  </head>
  <body>
    <div class="limiter">
      <div class="container-login100">
        <div class="wrap-login100 p-t-85 p-b-20">
          <form class="login100-form validate-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <span class="login100-form-title p-b-70"> Login</span>
            <span class="login100-form-avatar">
              <img src="images/1s.png" alt="AVATAR" />
            </span>

            <div
              class="wrap-input100 validate-input m-t-85 m-b-35 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>"
              data-validate="Enter username"
            >
              <input class="input100" type="text" name="username" value="<?php echo $username; ?>" placeholder="Username"/>
              <span class="help-block"><?php echo $username_err; ?></span>
               <!--<span class="focus-input100" placeholder="Username"></span>-->
            </div>

            <div
              class="wrap-input100 validate-input m-b-50 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>"
              data-validate="Enter password" 
            >
              <input class="input100" type="password" name="pass" placeholder="Password"/>
              <span class="help-block"><?php echo $password_err; ?></span>
              <!--<span class="focus-input100" data-placeholder="Password"></span>-->
            </div>

            <div class="container-login100-form-btn">
              <button class="login100-form-btn" type="submit"name='submit'>Login</button>
            </div>

            <ul class="login-more p-t-190">
              <li class="m-b-8">
                <span class="txt1"> Forgot </span>

                <a href="#" class="txt2"> Username / Password? </a>
              </li>

              <li>
                <span class="txt1"> Don’t have an account? </span>

                <a href="SignUp.php" class="txt2"> Sign up </a>

              </li>
            </ul>
          </form>
        </div>
      </div>
    </div>

    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="Style/js/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="Style/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="Style/js/popper.js"></script>
    <script src="Style/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="Style/js/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="Style/js/moment.min.js"></script>
    <script src="Style/js/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="Style/js/countdowntime.js"></script>
    <!--===============================================================================================
    <script src="js/main.js"></script>-->
  </body>
</html>
