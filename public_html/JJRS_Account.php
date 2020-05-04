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
        <title>JJRS Account</title>
        <link rel="stylesheet" type="text/css" href="JJRS_CSS.css">
    </head>
    <body>
        <?php include('navbar.php'); ?>
        <h3>Your Wishlist:</h3>

        <?php
            // Get images from the database
            $query = $link->query("SELECT store.pic, store.cost, store.id FROM wishlist, store WHERE wishlist.item_id=store.id AND wishlist.user_id='$param_user_id'");

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
                <button id="wish-button" type="submit" value=<?php echo $item_id;?> name="removeFromWish">Remove From Wishlist</button>
            </form>
        </div>
        <div id="space"></div>
        <?php }
        }else{ ?>
            <p>Wishlist is empty...</p>
        <?php } ?>
    </body>
</html>