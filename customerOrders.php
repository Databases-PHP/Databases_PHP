<!DOCTYPE html>
<?php
session_start();
$customerID = $_SESSION['customerLoggedIn'];
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Your Orders</title>
    </head>
    <body>
        <table border="1"><tr><th><a href = "index.php">Home</a></th><th><a href = "registeredShop.php">Shop</a></th><th><a = href="customerCart.php">Cart</a></th><th><a href="customerOrders.php">Orders</a></th></table>
        
        <?php        
	//view list of customer orders
        include "sql_connect.php";
        
        //Find all order tied to this customer id
        $query = "select * from CustomerOrder CO where CO.customerID = $customerID";
        $customerOrders = mysql_query($query);        
        $numRow = mysql_numrows ($customerOrders);
        
        //Loop over the rows and create tables for each
        for ($i = 0; $i < $numRow; $i++) {
            $orderID = mysql_result($customerOrders, $i, "orderID");
            $status = mysql_result($customerOrders, $i, "orderStatus");
            $time = mysql_result($customerOrders, $i, "TimeStamp");
            
            //Print the order #, status, and timestamp
            echo "<p>OrderID: $orderID   Status: $status     Time: $time</p>";
            
            //Get the item in order and display them in a table
            $getItemsQ = "select OHI.itemID, OHI.quantity from OrderHasItem OHI where OHI.orderID = $orderID";
            $orderItems = mysql_query($getItemsQ);
            $rowNum = mysql_numrows($orderItems);
            
            //Loop over the items and print out a table to display    
            echo "<table border='1'><tr><th>Item ID</th><th>Item Name</th><th>Quantity</th><th>Price per Unit</th>";
            
            for ($j = 0; $j < $rowNum; $j++) {
                //Get the item name and then query its info
                $itemID = mysql_result ($orderItems, $j, "itemID");
                $quantity = mysql_result ($orderItems, $j, "quantity");
                
                //Query for the name andprice of item
                $getNameAndPrice = "select I.name, I.price from Item I where I.itemID = $itemID";
                $nameAndPrice = mysql_query($getNameAndPrice);
                $itemName = mysql_result ($nameAndPrice, 0, "name");      //will only be one row since itemIDs are unique
                $itemPrice = mysql_result ($nameAndPrice, 0, "price");
                
                //Now display row
                echo "<tr>";
                echo "<td>$itemID</td> <td>$itemName</td> <td>$quantity</td> <td>$itemPrice</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>

    </body>
</html>



