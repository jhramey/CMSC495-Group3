<?php
session_start();

require_once "config.php";
include("alterTable.php");
$statusMsg = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!$_SESSION["loggedin"]) {
        header("location: JJRS_Login.php");
    }

    if(isset(($_POST["addToCart"]))) {
        // Add item to cart
        addItem($link, "cart", $_POST["addToCart"]);
    } else if(isset(($_POST["addToWish"]))) {
        // Add item to wishlist
        addItem($link, "wishlist", $_POST["addToWish"]);
    } else {
        $statusMsg = "An error has occurred";
    }    
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>JJRS Product</title>
        <link rel="stylesheet" type="text/css" href="JJRS_CSS.css">
    </head>
    <body>
        <?php include('navbar.php'); ?>
        <div style="height:25px;"></div>
        <div id="filter-div">
            <form id="filter">
                <select id="type">
                    <option value="shirt">Shirt</option>
                    <option value="hat">Hat</option>
                    <option value="pants">Pants</option>
                </select>
                <select id="color">
                    <option value="black">Black</option>
                    <option value="blue">blue</option>
                    <option value="red">Pants</option>
                </select>
                <div class="slidecontainer">
                    <h3>Price Range: <span id="price"></span></h3>
                    <input type="range" min="1" max="100" value="50" class="slider" id="price-slider">
                </div>
                <input type="submit" value="Filter">
            </form>
        </div>
        <?php
            // Get images from the database
            $query = $link->query("SELECT * FROM store");

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
                <button id="cart-button" type="submit" value=<?php echo $item_id;?> name="addToCart">Add To Cart</button>
                <button id="wish-button" type="submit" value=<?php echo $item_id;?> name="addToWish">Add To Wishlist</button>
            </form>
        </div>
        <div id="space"></div>
        <?php }
        }else{ ?>
            <p>No image(s) found...</p>
        <?php } ?>
        <h1><?php echo $statusMsg;?></h1>
    </body>
</html>