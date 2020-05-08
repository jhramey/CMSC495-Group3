<?php
session_start();
require_once "config.php";

if(isset(($_POST["order_view"]))) {
    $sql = "SELECT * FROM orders where orderNumber=" . $_POST["order_view"];
    if($result = mysqli_query($link, $sql)) {
        while ($row = $result->fetch_row()) {
            $orderDetails = "Order Number: $row[0]<br>";
            $orderDetails .= "User ID: $row[1]<br>";
            $orderDetails .= "First Name: $row[2]<br>";
            $orderDetails .= "Last Name: $row[3]<br>";
            $orderDetails .= "Address: $row[4]<br>";
            $orderDetails .= "Items Purchased:<br>";

            foreach(json_decode($row[5]) as $item) {
                $orderDetails .= "<br>Name: $item[0]";
                $orderDetails .= "<br>Quantity: $item[1]";
                $orderDetails .= "<br>Cost per Item: $item[2]<br>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>JJRS Customer Orders</title>
        <link rel="stylesheet" type="text/css" href="JJRS_CSS.css">
    </head>
    <body>
        <?php include('navbar.php'); ?>
        <h3>Customer Orders:</h3>

        <?php
            $sql = "SELECT * FROM orders";
            if($result = mysqli_query($link, $sql)) {
                if (mysqli_num_rows($result)==0) {
                    $statusMsg = "There are no customer orders at this time...";
                } else {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Order Number</th>";
                    echo "<th>User ID</th>";
                    echo "<th>First Name</th>";
                    echo "<th>Last Name</th>";
                    echo "<th>View Order</th>";
                    echo "</tr>";
                    while ($row = $result->fetch_row()) {
                        echo "<tr>";
                        echo "<th>$row[0]</th>";
                        echo "<th>$row[1]</th>";
                        echo "<th>$row[2]</th>";
                        echo "<th>$row[3]</th>";
                        echo "<th>";
                        echo "<form method='post'>";
                        echo "<button type='submit' name='order_view' value=$row[0]>View</button>";
                        echo "</form";
                        echo "</th>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    mysqli_free_result($result);
                }
            } else {
            $statusMsg = "There was an error reading the orders!";
        } ?>
        <h2><?php echo $statusMsg;?></h2>
        <h2><?php echo $orderDetails;?></h2>
    </body>
</html>