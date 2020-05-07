<?php
session_start();
require_once "config.php";

if ($_SESSION['username'] != "admin") {
   header('Location: NotAdmin.php');

}

$statusMsg = "";
$name = $type = $color = "";
$cost = $quantity = "";
$name_err = $type_err = $color_err = "";
$cost_err = $quantity_err = "";

// File Upload Variables
$targetDir = "images/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
$fileStatusMsg = "";


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
    if(empty(trim($_POST["quantity"]))){
        $quantity_err = "Please enter a quantity.";     
    } else{
        $quantity = trim($_POST["quantity"]);
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($type_err) && empty($confirm_password_err) && empty($color_err) && empty($quantity_err)) {

        // Validate Picture after confirming other values are satisfied
        if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg','gif','pdf');
            if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                    // True if successful
                } else{
                    $fileStatusMsg = "Sorry, there was an error uploading your file.";
                }
            } else{
                $fileStatusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
            }
        } else{
            $fileStatusMsg = 'Please select a file to upload.';
        }
        
        // Prepare an insert statement
        $sql = "INSERT INTO store (name, type, color, cost, quantity, pic) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssdis" ,$param_name, $param_type, $param_color, $param_cost, $param_quantity, $param_pic);
            
            // Set parameters
            $param_name = $name;
            $param_type = $type;
            $param_color = $color;
            $param_cost = $cost;
            $param_quantity = $quantity;
            $param_pic = $targetFilePath;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $statusMsg = "Item has been successfully uploaded to the store!";
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
    <br>
        <form id="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <font size ="+2">
                Product Name: <input type="text" id="name" size="40" name="name">
                <span class="error"> <?php echo $name_err;?></span>
                <br>
                <label for="type">Type:</label>
                <select name="type" id="type">
                    <option value="">Select Type</option>
                    <option value="shirt">Shirt</option>
                    <option value="hat">Hat</option>
                    <option value="pants">Pants</option>
                </select>
                <span class="error"> <?php echo $type_err;?></span>
                <br>
                <label for="color">Color:</label>
                <select name="color" id="color">
                    <option value="">Select Color</option>
                    <option value="black">Black</option>
                    <option value="blue">Blue</option>
                    <option value="green">Green</option>
                    <option value="red">Red</option>
                </select>
                <span class="error"> <?php echo $color_err;?></span>
                <br>
                Cost: $<input type="number" name="cost" min="0.01" step="0.01" max="2500"/>
                <span class="error"> <?php echo $cost_err;?></span>
                <br>
                Quantity: <input type="number" name="quantity" id="quantity" min="0" max="100">
                <span class="error"> <?php echo $quantity_err;?></span>
                <br>
                Image of Product: <input type="file" id="file" size="80" name="file">
                <span class="error"> <?php echo $fileStatusMsg;?></span>	
                <br>
                <input type="submit" name= "submit" value="Upload">
            </font>
        </form>
        <h1><?php echo $statusMsg;?></h1>
    <br>
        <?php include('bottombar.php'); ?>
    </body>
</html>