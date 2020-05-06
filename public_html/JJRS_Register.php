<?php
session_start();
// Include config file
require_once "config.php";

$firstName = $lastName = "";
$firstName_err = $lastName_err = "";
$attempts = "";
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
   
   
    // Validate Name
    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
   
    if(empty($firstName)) {
        $firstName_err = "Please enter a first name.";
    } else if (preg_match('[\W]', $firstName)) {
        $firstName_err = "First name cannot contain special characters";
    }

    if(empty($lastName)) {
        $lastName_err = "Please enter a last name.";
    } else if (preg_match('[\W]', $lastName)) {
        $lastName_err = "Last name cannot contain special characters";
    }
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($firstName_err) && empty($lastName_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
       
        // Prepare an insert statement
        $sql = "INSERT INTO users (firstName, lastName, username, password, attempts) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $param_firstName, $param_lastName, $param_username, $param_password, $param_attempts);
            
            // Set parameters
            $param_firstName = $firstName;
            $param_lastName = $lastName;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash       
	    $param_attempts = 0;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: JJRS_Login.php");
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
    <head>
        <title>JJRS Register</title>
        <link rel="stylesheet" type="text/css" href="JJRS_CSS.css">
    </head>
    <body>
        <?php include('navbar.php'); ?>
        <form id="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="firstName">First name:</label>
            <br>
            <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
            <span class="error"> <?php echo $firstName_err;?></span>
            <br>
            <label for="lastName">Last name:</label>
            <br>
            <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>">
            <span class="error"> <?php echo $lastName_err;?></span>
            <br>
            <label for="username">Username:</label>
            <br>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>">
            <span class="error"> <?php echo $username_err;?></span>
            <br>
            <label for="password">Password:</label>
            <br>
            <input type="password" id="password" name="password" value="">
            <span class="error"> <?php echo $password_err;?></span>
            <br>
            <label for="confirmPassword">Confirm Password:</label>
            <br>
            <input type="password" id="confirmPassword" name="confirm_password" value="">
            <span class="error"> <?php echo $confirm_password_err;?></span>
            <br><br>
            <input type="submit" value="Register">

        </form>
    </body>
</html>