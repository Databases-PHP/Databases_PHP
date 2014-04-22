<!DOCTYPE html>
<?php
include "usefulQueries.php";
session_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Registered Customer Shop</title>
    </head>
    <body>
    <?php
    //Print the top toolbar based on whether this is a manager or not
    $staffID = $_SESSION['staffLoggedIn'];
    $managerBool = isManager($staffID);
    if ($managerBool) {
        //Print the manager version
        ?>
        <table border="1"><tr><th><a href = "index.php">Home</a></th><th><a href = "viewInventory.php">View Inventory</a></th><th><a href="updateInventory.php">Update Inventory</a></th><th><a href = "viewAndShipOrders.php">View / Ship Orders</a></th><th><a href="salesStatistics.php">Sales Stats</a></th><th><a = href="itemPromotion.php">Item Promotions</a></th></table><br>
        <?php
    } else {
        //Print the normal staff version
        ?>
        <table border="1"><tr><th><a href = "index.php">Home</a></th><th><a href = "viewInventory.php">View Inventory</a></th><th><a href="updateInventory.php">Update Inventory</a></th><th><a href = "viewAndShipOrders.php">View / Ship Orders</a></th></table><br>
        <?php
    }
        include "sql_connect.php";

	if(isset($_POST['update'])){
		$itemID = $_POST['itemID'];
		$itemQuantity = $_POST['itemQuantity'];

		$sql = "UPDATE Item SET numberInStock = $itemQuantity WHERE itemID = $itemID ";
		$retval = mysql_query($sql);
		if(! $retval)
		{
			echo "Did not update";
		}
		unset($_POST['update']);
	}

		$query = "select * from Item";
        	$result = mysql_query ($query);
	        $num = mysql_numrows ($result);

	        echo "<table border='1'><tr><th>Item ID</th><th>Item Name</th><th>Price</th><th># In Stock</th>";

        	for ($i = 0; $i < $num; $i++) {

                	$itemID = mysql_result ($result, $i, "itemID");
                	$numberInStock = mysql_result ($result, $i, "numberInStock");
                	$name = mysql_result ($result, $i, "name");
                	$price = mysql_result ($result, $i, "price");
                	echo "<tr>";
                	echo "<td>$itemID</td> <td>$name</td> <td>$price</td> <td>$numberInStock</td>";
                	echo "</tr>";
		}
        	echo "</table>";
     ?>

		 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        ItemID to update: <input type="number" name="itemID">
                        New Quantity: <input type="number" name="itemQuantity">
                        <input name ="update" type="submit" id="update" value="Update">
                </form>

    </body>
</html>

