<!DOCTYPE html>
<?php
session_start();
include "viewAndShipOrders.php";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Output Missing Components</title>
    </head>
    <body>
	<?php
	include "sql_connect.php";
        //Check OrderHasItem.quantity of each item that matches orderID against
        // Item.numberInStock. If any rows return, there order isn't filled
	$orderID = $_SESSION['orderID'];
	$query = "select OHI.itemID, OHI.quantity, I.numberInStock from OrderHasItem OHI, Item I where OHI.orderID = $orderID AND OHI.itemID = I.itemID AND OHI.quantity > I.numberInStock";
        $result = mysql_query ($query);
        $num = mysql_numrows ($result);
        echo "\nMissing Components\n";
        echo "<table border='1'><tr><th>Item ID</th><th>Quantity Requested</th><th># In Stock</th>";

        for($i = 0; $i < $num; $i++){
        	$itemID = mysql_result($result, $i, "OHI.itemID");
        	$orderQuantity = mysql_result($result, $i, "OHI.quantity");
        	$numberInStock = mysql_result($result, $i, "I.numberInStock");
        	echo "<tr>";
        	echo "<td>$itemID</td> <td>$orderQuantity</td> <td>$numberInStock</td>";
        	echo "</tr>";
        }

	?>
    </body>
</html>
