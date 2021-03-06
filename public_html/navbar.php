<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="JJRS_CSS.css">
    </head>
    <body>
        <div id="header">
            <div id="left-header">
                <h1>JJRS Merch</h1>
            </div>
            <div id="right-space">
                <?php
                    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['username'] == "admin") {
                        echo '<h2 style="display:inline;">Hello, ' . $_SESSION['firstName'] . ' </h2><a href="logout.php">
                        <button id="login-register" style="float:none">Logout</button></a>
	                    <a href="AdminPage.php">
 			                <button id="login-register" style="float:none">AdminPage</button>
                        </a>';
                    } elseif (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['username'] != "admin") {
                        echo '<h2 style="display:inline;">Hello, ' . $_SESSION['firstName'] . ' </h2><a href="logout.php">
                        <button id="login-register" style="float:none">Logout</button> </a>';
                    } else {
                        echo '<a href="JJRS_Login.php">
                        <button id="login-register">Login</button>
                        </a>
                        <a href="JJRS_Register.php">
                            <button id="login-register">Register</button>
                        </a>';
                    }
                ?>
            </div>
        </div>
        <div id="link-bar">
            <div id="link">
                <a id="navigate" href="index.php">
                    <h2>HOME</h2>
                </a>
            </div>
            <div id="link">
                <a id="navigate" href="JJRS_Merch.php">
                    <h2>MERCH</h2>
                </a>
            </div>
            <div id="link">
                <a id="navigate" href="JJRS_Account.php">
                    <h2>ACCOUNT</h2>
                </a>
            </div>
            <div id="link">
                <a id="navigate" href="JJRS_Cart.php">
                    <h2>CART</h2>
                </a>
            </div>
        </div>
    </body>
</html>