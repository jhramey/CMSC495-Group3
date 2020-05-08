<?php

session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

//Include config with database info
require_once "config.php";

$username = $password = "";
//Errors are blank so we can dynamically change the error
$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username is empty
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)) {
        // Prepare a select statement

        $sql = "SELECT id, firstName, username, password, attempts FROM users WHERE username = ?";
       
        if($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters

            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1) {                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $firstName, $username, $hashed_password, $attempts);
                    if(mysqli_stmt_fetch($stmt)) {
                            if(password_verify($password, $hashed_password)) {
                                // Password is correct, so start a new session
                                $attempts = 0;

                                $sql = "UPDATE users SET attempts = '$attempts' WHERE id = '$id'";
                                if(mysqli_query($link, $sql)){
                                    $password_err = "Password Attempts Reset.";
                                }
                            } else {
                                $password_err = "The password you entered was not valid.";
                            } 
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Password Reset</title>
        <link rel="stylesheet" type="text/css" href="JJRS_CSS.css">
    </head>
    <body>
        <?php include('navbar.php'); ?>
        <h1> Reset Password Form</h1>
       <form id="reset" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           
            <label for="username">Enter Username:</label>
            <br>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>">
            <span class="error"> <?php echo $username_err;?></span>
            <br>
            <label for="password">Last Password:</label>
            <br>
            <input type="password" id="password" name="password" value="">
            <span class="error"> <?php echo $password_err;?></span>      
            <br><br>
            <input type="submit" value="Reset">
        </form>
    <?php include('bottombar.php'); ?>
    </body>
</html>