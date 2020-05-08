<?php
session_start();

require_once "config.php";
include("alterTable.php");
$statusMsg = "";
$price_err = "";

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
            <form id="filter" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="type">Filter By Type:</label>
                <select id="type" name="filter[type]">
                    <option/>
                    <option value="shirt">Shirt</option>
                    <option value="hat">Hat</option>
                    <option value="pants">Pants</option>
                </select>
                <br>
                <label for="color">Filter By Color:</label>
                <select id="color" name="filter[color]">
                    <option/>
                    <option value="black">Black</option>
                    <option value="blue">Blue</option>
                    <option value="green">Green</option>
                    <option value="red">Red</option>
                </select>
                <br>
                <label for="price">Filter By Price: </label>
                $
                <input type="text" id="price" name="filter[lowPrice]" value="">
                to $
                <input type="text" id="price" name="filter[highPrice]" value="">
                <br>
                <input type="submit" value="Filter">
            </form>
        </div>
        <br>
        <?php
            $sql = "SELECT * FROM store";
            $message = "Filters were not used! Only numberic characters can be entered for a price filter.";
            $price_err = "<script type='text/javascript'>alert('$message');</script>";

            // If a filter has been set
            if(isset($_POST["filter"])) {
                $filter = $_POST["filter"];

                if(!empty($filter['type'])) {
                    $type = "type='" . $filter['type'] . "' AND ";
                }

                if(!empty($filter['color'])) {
                    $color = "color='" . $filter['color'] . "' AND ";
                }

                if(!empty($filter['lowPrice']) && !empty($filter['highPrice'])) {
                    if(is_numeric($filter['lowPrice']) && is_numeric($filter['highPrice'])) {
                        $price = "cost >= '" . $filter['lowPrice'] . "' AND cost <= '" .  $filter['highPrice'] . "' AND ";
                    } else {
                        echo $price_err;
                    }
                } elseif(!empty($filter['lowPrice'])) {
                    if(is_numeric($filter['lowPrice'])) {
                        $price = "cost >= '" . $filter['lowPrice'] . "' AND ";
                    } else {
                        echo $price_err;
                    }
                } elseif(!empty($filter['highPrice'])) {
                    if(is_numeric($filter['highPrice'])) {
                        $price .= "cost <= '" .  $filter['highPrice'] . "' AND ";
                    } else {
                        echo $price_err;
                    }
                }
            }
                if(!empty($type) || !empty($color) || !empty($price)) {
                    $sql .= " WHERE ";
                    if(!empty($type)) {
                        $sql .= $type;
                    }
                    if(!empty($color)) {
                        $sql .= $color;
                    }
                    if(!empty($price)) {
                        $sql .= $price;
                    }
                    $sql = substr($sql,0,-5);
                }

            // Get images from the database
            $query = $link->query($sql);

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