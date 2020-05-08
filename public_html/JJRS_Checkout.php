<?php
session_start();

//Include config with database info
require_once "config.php";

if(!$_SESSION["loggedin"]) {
    header("location: JJRS_Login.php");
} else {
    $user_id = trim($_SESSION["id"]);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    $address = $_POST["address"];
    $creditCard = trim($_POST["credit-card"]);
    $total = 0;
    
    $firstName_err = $lastName_err = "";
    $address_err="";
    $creditCard_err = "";

    // Validate First Name
    if(empty($firstName)) {
        $firstName_err = "Please enter a first name.";
    } else if (preg_match('[\W]', $firstName)) {
        $firstName_err = "First name cannot contain special characters";
    }

    // Validate Last Name
    if(empty($lastName)) {
        $lastName_err = "Please enter a last name.";
    } else if (preg_match('[\W]', $lastName)) {
        $lastName_err = "Last name cannot contain special characters";
    }
    
    // Validate Credit Card Number
    if(strlen($creditCard) != 16) {
        $creditCard_err = "Credit card number must be 16 characters in length!";
    } else if (preg_match('[\D]', $creditCard)) {
        $creditCard_err = "Credit card number must only contain digits";
    }

    // Validate Address isnt empty
    if(empty($address)) {
        $address_err = "Please enter an address";
    }

    // If no errors
    if(empty($firstName_err) && empty($lastName_err) && empty($creditCard_err) && empty($address_err)) {

        // QUERY TO GET ITEM ID and ITEM NAME
        $sql = "SELECT store.name, cart.quantity, store.cost FROM cart INNER JOIN store ON store.id = cart.item_id WHERE user_id = {$user_id}";
        
        if($result = mysqli_query($link, $sql)) {
            if(mysqli_num_rows($result)==0) {
                $statusMsg = "Cart is empty";
                $emptyCart = true;
            } else {
                while ($row = $result->fetch_row()) {
                    $items[] = $row;
                }
                mysqli_free_result($result);
            }
        }

        if(!$emptyCart) {
            // Prepare an insert statement
            $sql = "INSERT INTO orders (user_id, firstName, lastName, address, items) VALUES (?, ?, ?, ?, ?)";
            
            if($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "issss", $param_user_id, $param_firstName, $param_lastName, $param_address, $param_items);
                
                // Set parameters
                $param_user_id = $user_id;
                $param_firstName = $firstName;
                $param_lastName = $lastName;
                $param_address = $address;
                $param_items = json_encode($items);

                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)) {
                    $statusMsg = "FirstName = $firstName<br>LastName = $lastName<br>Address = $address<br>";
                    $statusMsg .= "<br>Your credit card has been billed for the following items: ";
                    foreach($items as $item) {
                        $statusMsg .= "<br>&#9;Name: $item[0]&#9;Cost: $$item[2]";
                        $total += $item[2];
                    }
                    $statusMsg .= "<br><br>Total order cost: $" . number_format((float)$total, 2, '.', '');
                    $sql = "DELETE FROM cart WHERE user_id=$param_user_id";
                    if(!mysqli_query($link, $sql)) {
                        echo "ERROR: " . mysqli_error($link);
                    }
                } else {
                    echo "ERROR: " . mysqli_error($link);
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>JJRS Cart</title>
        <link rel="stylesheet" type="text/css" href="JJRS_CSS.css">
    </head>
    <body>
        <div id="header">
            <h1>JJRS Merch</h1>
        </div>
        <form id="checkout" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="firstName">First name:</label>
            <br>
            <input type="text" id="firstName" name="firstName" value="">
            <span class="error"><?php echo $firstName_err;?></span>
            <br>
            <label for="lastName">Last name:</label><br>
            <input type="text" id="lastName" name="lastName" value="">
            <span class="error"><?php echo $lastName_err;?></span>
            <br>
            <label for="credit-card">Card Number:</label>
            <br>
            <input type="text" id="credit-card" name="credit-card" value="">
            <span class="error"><?php echo $creditCard_err;?></span>
            <br>
            <label for="address">Address:</label>
            <br>
            <input type="text" id="address" name="address" value="">
            <span class="error"><?php echo $address_err;?></span>
            <br>
            <br>
                <input type="submit" value="Finish Checkout">
                <a href="index.php">back</a>
        </form>
        <h1><?php echo $statusMsg;?></h1>
    </body>
</html>