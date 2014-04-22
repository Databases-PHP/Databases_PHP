<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sales Statistics</title>
    </head>
    <body>

	<table border="1"><tr><th><a href = "index.php">Home</a></th><th><a href = "viewInventory.php">View Inventory</a></th><th><a = href="updateInventory.php">Update Inventory</a></th><th><a href = "viewAndShipOrders.php">View / Ship Orders</a></th><th><a href="salesStatistics.php">Sales Stats</a></th><th><a = href="itemPromotion.php">Item Promotions</a></th></table>
	<br>
	<form method = 'post'>
	<select name = "timeframe">
		<option value = "week">Week</option>
		<option value = "month">Month</option>
		<option value = "year">Year</option>
	</select>
	<input type="submit"/>
	</form>
	<?php
	include "sql_connect.php";
	//View the list of all items and sales history in the previous (week, month, or year)
	//get all orders in selected time frame
	if(isset($_POST['timeframe'])){
	$timeFrame = $_POST['timeframe'];
	echo "Sales Statistics from the past $timeFrame";
	if($timeFrame == "week"){
		$sql = "select * from CustomerOrder where (DATE (TimeStamp) >= CURDATE() - INTERVAL 7 DAY)";
	}else if($timeFrame == "month"){
		$sql = "select * from CustomerOrder where (DATE (TimeStamp) >= CURDATE() - INTERVAL 1 MONTH)";
	}else if($timeFrame == "year"){
		$sql = "select * from CustomerOrder where (DATE (TimeStamp) >= CURDATE() - INTERVAL 1 YEAR)";
	}
	$result = mysql_query($sql);
	if(! $result){
		echo "failed query";
	}
	$numrows = mysql_numrows($result);
	$item1Count = 0;
	$item2Count = 0;
	$item3Count = 0;
	$item4Count = 0;
	for($i =0; $i < $numrows; $i++){
		$orderID = mysql_result($result, $i, "orderID");
		$sql2 = "select itemID, quantity from OrderHasItem where orderID = $orderID";
		$result2 = mysql_query($sql2);
		if(! $result2){
                echo "failed query";
	        }

		$numrows2 = mysql_numrows($result2);
		for($j = 0; $j < $numrows2; $j++){
			$itemID = mysql_result($result2, $j, "itemID");
			$quantity = mysql_result($result2, $j, "quantity");
			if($itemID == 1){ $item1Count = $item1Count + $quantity;}
			else if($itemID == 2){ $item2Count = $item2Count + $quantity;}
			else if($itemID == 3){ $item3Count = $item3Count + $quantity;}
			else if($itemID == 4){ $item4Count = $item4Count + $quantity;}
		}
	}
	$query = "select * from Item";
    	$result = mysql_query ($query);

    	$num = mysql_numrows ($result);

    	echo "<table border='1'><tr><th>Item ID</th><th>Item Name</th><th>Number Sold</th>";

    	for ($i = 0; $i < $num; $i++) {
            echo "<tr>";
            $itemID = mysql_result ($result, $i, "itemID");
            $name = mysql_result ($result, $i, "name");
            echo "<td>$itemID</td> <td>$name</td> ";
		if($itemID == 1){ echo"<td>$item1Count</td>";}
		else if($itemID == 2){  echo"<td>$item2Count</td>";}
                else if($itemID == 3){  echo"<td>$item3Count</td>";}
                else if($itemID == 4){  echo"<td>$item4Count</td>";}

            echo "</tr>";
    	}

    	echo "</table>";
	}
	?>



	</body>
</html>
