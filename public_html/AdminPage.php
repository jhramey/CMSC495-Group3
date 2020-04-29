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
<font size ="+2">
 Product Name: <input type="text" id="fname" size="40" name="fname"><br>
 <label for="type">Type:</label>
<select id="tpye">
	<option value="shirt">Shirt</option>
	<option value="hat">Hat</option>
	<option value="pants">Pants</option>
</select>


<br>
 <label for="color">Color:</label>
<select id="tpye">
	<option value="red">Red</option>
	<option value="blue">Blue</option>
	<option value="green">Green</option>
</select>
<br>
 Cost: <input type="text" id="info" size="40" name="info">
<br>
URL to Image of Product: <input type="text" id="pic" size="80 name="pic">	
<br>
</font>
<button type="button" onclick="myFunction();">Submit</button>
   <?php include('bottombar.php'); ?>
    </body>
</html>