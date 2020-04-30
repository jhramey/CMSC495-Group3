<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>JJRS Cart</title>
        <link rel="stylesheet" type="text/css" href="JJRS_CSS.css">
    </head>
    <body>
        <?php include('navbar.php'); ?>
        <div style="height:25px;"></div>
        <a href="JJRS_Checkout.php">
            <button id="checkout-button" type="button">Checkout</button>
        </a>
        <div style="height:25px;"></div>
        <div id="item">
            <h3>Black T-Shirt</h3>
            <img id="item-image" src="images\black-tshirt.jpg">
            <p>Price: $15</p>
            <button id="cart-button" type="button">Remove From Cart</button>
        </div>
        <div id="space"></div>
        <div id="item">
            <h3>Black Hat</h3>
            <img id="item-image" src="images\black-hat.jpg">
            <p>Price: $10</p>
            <button id="cart-button" type="button">Remove From Cart</button>
        </div>
    </body>
</html>