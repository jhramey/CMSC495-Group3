<?php
require_once "config.php";

// Add item to a table using an item ID
function addItem($link, $table, $item_id) {
    global $statusMsg;
    $param_user_id = trim($_SESSION["id"]);

    // Prepare a select statement
    $sql = "SELECT * FROM {$table} WHERE user_id = ? AND item_id = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $param_user_id, $item_id);            
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Store result
            mysqli_stmt_store_result($stmt);
                            
            // Check if cart exists
            if(mysqli_stmt_num_rows($stmt) == 1)  {
                mysqli_stmt_bind_result($stmt, $user_id, $item_id, $quantity, $dateAdded);
                if(mysqli_stmt_fetch($stmt)) {
                    $dateAdded = date("Y-m-d");
                    $newQuantity = $quantity + 1;
                    $sql = "UPDATE {$table} SET quantity = '$newQuantity' WHERE user_id = '$user_id' AND item_id = '$item_id'";
                    if(mysqli_query($link, $sql)){
                        $statusMsg = "Successfully updated quantity of item in $table";
                    } else {
                        $statusMsg = "Updating quantity in database was unsuccessful.";
                    }
                }
            } else {
                $dateAdded = date("Y-m-d");
                $sql = "INSERT INTO {$table} (user_id, item_id, quantity, dateAdded) VALUES ('$param_user_id','$item_id', 1, '$dateAdded')";
                if(mysqli_query($link, $sql)){
                    $statusMsg = "Successfully added item to $table";
                } else {
                    $statusMsg = "Error adding item to $table.";
                }
            }
        }
    }
}

// Remove item from table using item ID
function removeItem($link, $table, $item_id) {
    global $statusMsg;
    $param_user_id = trim($_SESSION["id"]);

    // Prepare a select statement
    $sql = "SELECT * FROM {$table} WHERE user_id = ? AND item_id = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $param_user_id, $item_id);            
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Store result
            mysqli_stmt_store_result($stmt);
                            
            // Check if cart exists
            if(mysqli_stmt_num_rows($stmt) == 1)  {
                mysqli_stmt_bind_result($stmt, $user_id, $item_id, $quantity, $dateAdded);
                if(mysqli_stmt_fetch($stmt)) {
                    if($quantity > 1) {
                        $newQuantity = $quantity - 1;
                        $sql = "UPDATE {$table} SET quantity = '$newQuantity' WHERE user_id = '$user_id' AND item_id = '$item_id'";
                        if(mysqli_query($link, $sql)){
                            $statusMsg = "Successfully removed 1 quantity of item in $table";
                        } else {
                            $statusMsg = "Removing 1 quantity in $table was unsuccessful.";
                        }
                    } else if ($quantity == 1) {
                        $sql = "DELETE FROM {$table} WHERE user_id='$user_id' and item_id='$item_id'";
                        if(mysqli_query($link, $sql)){
                            $statusMsg = "Successfully removed item from $table";
                        } else {
                            $statusMsg = "Error removing item from $table.";
                        }
                    } else {
                        $statusMsg = "Error has occured that item is in table but does not have any quantity";
                    }
                }
            } else {
                $statusMsg = "Error item is not in $table";
            }
        }
    }
}
?>