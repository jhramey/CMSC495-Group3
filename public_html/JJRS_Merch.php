<?php
session_start();
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
            require_once "config.php";

            // Get images from the database
            $query = $link->query("SELECT * FROM store");

            if($query->num_rows > 0){
                while($row = $query->fetch_assoc()){
                    $imageURL = $row["pic"];
                    $cost = $row["cost"];
                    $item_id = $row["id"];

        ?>
        <div id="item">
            <img id="item-image" src="<?php echo $imageURL; ?>" alt="" />
            <p>Price: $<?php echo $cost;?></p>
            <button id="cart-button" type="button" value=<?php echo $item_id;?>>Add To Cart</button>
            <button id="wish-button" type="button" value=<?php echo $item_id;?>>Add To Wishlist</button>
        </div>
        <div id="space"></div>
        <?php }
        }else{ ?>
            <p>No image(s) found...</p>
        <?php } ?>

        <!--
        <div id="item">
            <h3>Black T-Shirt</h3>
            <img id="item-image" src="images\black-tshirt.jpg">
            <p>Price: $15</p>
            <button id="cart-button" type="button">Add To Cart</button>
            <button id="wish-button" type="button">Add To Wishlist</button>
        </div>
        <div id="space"></div>
        <div id="item">
            <h3>Black Hat</h3>
            <img id="item-image" src="images\black-hat.jpg">
            <p>Price: $10</p>
            <button id="cart-button" type="button">Add To Cart</button>
            <button id="wish-button" type="button">Add To Wishlist</button>
        </div>
        <div id="space"></div>
        <div id="item">
            <h3>Blue Jeans</h3>
            <img id="item-image" src="images\blue-jeans.jpg">
            <p>Price: $20</p>
            <button id="cart-button" type="button">Add To Cart</button>
            <button id="wish-button" type="button">Add To Wishlist</button>
        </div> -->
    </body>
</html>