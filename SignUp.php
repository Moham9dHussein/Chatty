<?php

require_once "processing/config.php";;
 

$username = $password = $phone = $firstn = $lastn = "";
$username_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $sql = "SELECT id FROM accounts WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = trim($_POST["uname"]);
            
            
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["uname"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt);
        }
    // Check input errors before inserting in database
    if(empty($username_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO accounts (username, password, first_name, last_name, phone) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_password, $param_fname, $param_lname, $param_phone);
            
            
            $param_username = $username;
            $param_password = trim($_POST["pword"]); // 
            $param_fname    = trim($_POST["fname"]);
            $param_lname    = trim($_POST["lname"]);
            $param_phone    = trim($_POST["phone"]);
            
            
            if(mysqli_stmt_execute($stmt)){
            
                header("location: Login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
    
    
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    href="https://fonts.googleapis.com/css?family=Raleway"
    rel="stylesheet"
  />
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      background-color: #ffffff;
    }

    #regForm {
      background-color: #fafafa9c;
      margin: 100px auto;
      font-family: Raleway;
      padding: 40px;
      width: 40%;
      min-width: 300px;
    }
    .img-container {
      text-align: center;
    }
    .whatsapp {
      width: 60px;
      height: 60px;
      margin: 5px 0;
    }

    h1 {
      text-align: center;
    }

    input {
      padding: 10px;
      width: 100%;
      font-size: 17px;
      font-family: Raleway;
      border: 1px solid #aaaaaa;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
      background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
      display: none;
    }

    button {
      background-color: #4caf50;
      color: #ffffff;
      border: none;
      padding: 10px 20px;
      font-size: 17px;
      font-family: Raleway;
      cursor: pointer;
    }

    button:hover {
      opacity: 0.8;
    }

    #prevBtn {
      background-color: #bbbbbb;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
      height: 15px;
      width: 15px;
      margin: 0 2px;
      background-color: #bbbbbb;
      border: none;
      border-radius: 50%;
      display: inline-block;
      opacity: 0.5;
    }

    .step.active {
      opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
      background-color: #4caf50;
    }
  </style>
  <body>
    <form id="regForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <div class="img-container">
        <a href="index.php">
          <img src="./images/1.png" alt="Login" class="whatsapp" />
        </a>
      </div>
      <h1>Sign Up</h1>
      <!-- One "tab" for each step in the form: -->
      <span class="help-block"><?php echo $username_err; ?></span>
      <div class="tab">
        <br />
        <p>
          <input
            placeholder="First name..."
            oninput="this.className = ''"
            name="fname"
          />
        </p>
        <p>
          <input
            placeholder="Last name..."
            oninput="this.className = ''"
            name="lname"
          />
        </p>
      </div>
      <div class="tab">
        <br />
        <p>
          <input
            placeholder="Phone..."
            oninput="this.className = ''"
            name="phone"
          />
        </p>
      </div>

      <div class="tab">
        Login Info:
        <p>
          <input
            placeholder="Username..."
            oninput="this.className = ''"
            name="uname"
          />
        </p>
        <p>
          <input
            placeholder="Password..."
            oninput="this.className = ''"
            name="pword"
            type="password"
          />
        </p>
      </div>
      <div style="overflow: auto">
        <div style="float: right">
          <button type="button" id="prevBtn" onclick="nextPrev(-1)">
            Previous
          </button>
          <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
      </div>
      <!-- Circles which indicates the steps of the form: -->
      <div style="text-align: center; margin-top: 40px">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
      </div>

    </form>

    <script>
      var currentTab = 0; // Current tab is set to be the first tab (0)
      showTab(currentTab); // Display the current tab

      function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName('tab');
        x[n].style.display = 'block';
        //... and fix the Previous/Next buttons:
        if (n == 0) {
          document.getElementById('prevBtn').style.display = 'none';
        } else {
          document.getElementById('prevBtn').style.display = 'inline';
        }
        if (n == x.length - 1) {
          document.getElementById('nextBtn').innerHTML = 'Submit';
          document.getElementById('nextBtn').name = 'Submit';
        } else {
          document.getElementById('nextBtn').innerHTML = 'Next';
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n);
      }

      function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName('tab');
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = 'none';
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
          // ... the form gets submitted:
          document.getElementById('regForm').submit('');
          return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
      }

      function validateForm() {
        // This function deals with validation of the form fields
        var x,
          y,
          i,
          valid = true;
        x = document.getElementsByClassName('tab');
        y = x[currentTab].getElementsByTagName('input');
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
          // If a field is empty...
          if (y[i].value == '') {
            // add an "invalid" class to the field:
            y[i].className += ' invalid';
            // and set the current valid status to false
            valid = false;
          }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
          document.getElementsByClassName('step')[currentTab].className +=
            ' finish';
        }
        return valid; // return the valid status
      }

      function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i,
          x = document.getElementsByClassName('step');
        for (i = 0; i < x.length; i++) {
          x[i].className = x[i].className.replace(' active', '');
        }
        //... and adds the "active" class on the current step:
        x[n].className += ' active';
      }
    </script>
  </body>
</html>
