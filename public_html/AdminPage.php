<?php
require_once "config.php";


$name = $type = $color = "";
$cost = $quan = $pic = "";
$name_err = $type_err = $color_err = "";
$cost_err = $quan_err = $pic_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){


    // Validate Product Name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a Product Name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM store WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $name_err = "This product name is already taken.";
                } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate type
    if(empty(trim($_POST["type"]))){
        $type_err = "Please select a type.";     
 
    } else{
        $type = trim($_POST["type"]);
    }
    
      // Validate color
    if(empty(trim($_POST["color"]))){
        $color_err = "Please select a color.";     
    } else{
        $color = trim($_POST["color"]);
    }

   // Validate cost
    if(empty(trim($_POST["cost"]))){
        $cost_err = "Please enter a cost.";     
    } else{
        $cost = trim($_POST["cost"]);
    } 

   // Validate quantity
    if(empty(trim($_POST["quan"]))){
        $quan_err = "Please enter a quantity.";     
    } else{
        $quantity = trim($_POST["quantity"]);
    }
   // Validate Picture
     if(empty(trim($_POST["pic"]))){
        $pic_err = "Please enter a URL to a picture.";     
    } else{
        $pic = trim($_POST["pic"]);
    }



    // Check input errors before inserting in database
    if(empty($name_err) && empty($type_err) && empty($confirm_password_err) && empty($color_err) && empty($quan_err) && empty($pic_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO store (name, type, color, cost, quan, pic) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss" ,$param_name, $param_type, $param_color, $param_cost, $param_quan, $param_pic);
            
            // Set parameters
            $param_name = $name;
            $param_type = $type;
            $param_color =$color;
            $param_cost =$cost;
            $param_quan =$quan;
            $param_pic = $pic;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
               
            } else{
                echo "Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($link);
}





?>








<!DOCTYPE html>
<html>
    <head>
        <title>Admin Page</title>
        <link rel="stylesheet" type="text/css" href="JJRS_CSS.css">
    </head>
    <body>
        <?php include('navbar.php'); ?>
       <h1>Admin Page</h1>
	<div class="row">
	<button>Home</button>
	<button>Orders</button>
	</div>
<form id="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<font size ="+2">
 Product Name: <input type="text" id="name" size="40" name="name" value="<?php echo $name; ?>">
<br>
 <label for="type">Type:</label>
<select id="type" value="<?php echo $type; ?>">
	<option value="shirt">Shirt</option>
	<option value="hat">Hat</option>
	<option value="pants">Pants</option>
</select>


<br>
 <label for="color">Color:</label>
<select id="color"  value="<?php echo $color; ?>">
	<option value="red">Red</option>
	<option value="blue">Blue</option>
	<option value="green">Green</option>
</select>
<br>
 Cost: <input type="text" id="cost" size="20" name="cost"  value="<?php echo $cost; ?>">
<br>
Quantity: <input type="text" id="quantity" size="20" name="quan"  value="<?php echo $quan; ?>">
<br>
URL to Image of Product: <input type="text" id="pic" size="80 name="pic"  value="<?php echo $pic; ?>">	
<br>
</font>
<input type="submit" value="submit">
 </form>
   <?php include('bottombar.php'); ?>
    </body>
</html>