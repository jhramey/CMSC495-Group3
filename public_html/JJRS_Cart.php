<?php
session_start();
require_once "config.php";

if(!$_SESSION["loggedin"]) {
    header("location: JJRS_Login.php");
} else {
    $param_user_id = trim($_SESSION["id"]);
}
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

        <?php
            // Get images from the database
            $query = $link->query("SELECT store.pic, store.cost, store.id FROM cart, store WHERE cart.item_id=store.id AND cart.user_id='$param_user_id'");

            if($query->num_rows > 0){
                while($row = $query->fetch_assoc()){
                    $imageURL = $row["pic"];
                    $cost = $row["cost"];
                    $item_id = $row["id"];
        ?>
        <div id="item">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <img id="item-image" src="<?php echo $imageURL; ?>" alt="" />
                <p>Price: $<?php echo $cost;?></p>
                <button id="cart-button" type="submit" value=<?php echo $item_id;?> name="removeFromCart">Remove From Cart</button>
            </form>
        </div>
        <div id="space"></div>
        <?php }
        }else{ ?>
            <p>Cart is empty...</p>
        <?php } ?>
    </body>
</html>