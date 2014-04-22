<!DOCTYPE html>
<?php
include "usefulQueries.php";
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>View and Ship Orders</title>
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
        if (isset($_POST['Ship'])){
            //Check if this is a real order that is pending
	    $orderID = $_POST['orderID'];
            $orderExists = pendingOrderExist($orderID);
            if (!$orderExists) {
                echo "That is not an existing order number or that order has already shipped!";
            }
            //check to see if order has already been shipped
            //check to see if all components of the order are availabe
            $success = checkForAllComponents($orderID);
            if ($success) {               
                //change status of orderID to 'Shipped'
		$changed_status = changeStatusOfOrder($orderID);
                if($changed_status){
                    if ($orderExists) {
                        echo "Order $orderID has Shipped";
                    }

                    //Select the items in the order
                    $getItemsQ = "select OHI.itemID, OHI.quantity from OrderHasItem OHI where OHI.orderID = $orderID";
                    $items = mysql_query($getItemsQ);
                    $numItemTypes = mysql_num_rows($items);

                    //Iterate over the items and decrement the appropriate amount from inventory
                    for ($i = 0; $i < $numItemTypes; $i++) {
                        $itemID = mysql_result ($items, $i, "itemID");
                        $quantity = mysql_result ($items, $i, "quantity");

                        //Calculate the number currently in stock
                        $quantInStock = getQuantInStock($itemID);
                        
                        //Calculate the new amount in stock
                        $newQuant = $quantInStock - $quantity;

                        //Now update the count in inventory
                        $updateQuantQ = "update Item set Item.numberInStock=$newQuant where Item.itemID = $itemID";
                        mysql_query($updateQuantQ);
                    }
                }else{
                    echo "Order failed to Ship\n";
                }
            }else{
		//output missing components
		outputMissingComponents($_POST['orderID']);
	    }

            unset($_POST['Ship']);
        }

	?>
	 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            OrderID to Ship: <input type="number" name="orderID">
            <input type="submit" name="Ship" value="Ship" id="Ship">
	</form>
	<?php

	$query = "select * from CustomerOrder where orderStatus = 'Pending'";
        $customerOrders = mysql_query($query);
        $numRow = mysql_numrows ($customerOrders);

        //Loop over the rows and create tables for each
        for ($i = 0; $i < $numRow; $i++) {
	    $customerID = mysql_result($customerOrders, $i, "customerID");
            $orderID = mysql_result($customerOrders, $i, "orderID");
            $status = mysql_result($customerOrders, $i, "orderStatus");
            $time = mysql_result($customerOrders, $i, "TimeStamp");

            //Print the order #, status, and timestamp
            echo "OrderID: $orderID\t CustomerID: $customerID\t Time: $time";

            //Get the item in order and display them in a table
            $getItemsQ = "select OHI.itemID, OHI.quantity from OrderHasItem OHI where OHI.orderID = $orderID";
            $orderItems = mysql_query($getItemsQ);
            $rowNum = mysql_numrows($orderItems);

            //Loop over the items and print out a table to display
            echo "<table border='1'><tr><th>Item ID</th><th>Item Name</th><th>Quantity</th><th>Price per Unit</th>";
	    $totalprice = 0;
            for ($j = 0; $j < $rowNum; $j++) {
                //Get the item name and then query its info
                $itemID = mysql_result ($orderItems, $j, "itemID");
                $quantity = mysql_result ($orderItems, $j, "quantity");

                //Query for the name andprice of item
                $getNameAndPrice = "select I.name, I.price from Item I where I.itemID = $itemID";
                $nameAndPrice = mysql_query($getNameAndPrice);
                $itemName = mysql_result ($nameAndPrice, 0, "name");      //will only be one row since itemIDs are unique
                $itemPrice = mysql_result ($nameAndPrice, 0, "price");
		$totalprice = $totalprice + ($itemPrice * $quantity);
                //Now display row
                echo "<tr>";
                echo "<td>$itemID</td> <td>$itemName</td> <td>$quantity</td> <td>$itemPrice</td>";
                echo "</tr>";
            }
	    echo "\tTotal Price: $totalprice";
            echo "</table>";
		?>
		<br>
	<?php
        }
        ?>

    </body>
</html>



