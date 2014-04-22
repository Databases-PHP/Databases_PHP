<!DOCTYPE html>
<?php
include "usefulQueries.php";
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Manager Promotion Price</title>
    </head>
    <body>
	<table border="1"><tr><th><a href = "index.php">Home</a></th><th><a href = "viewInventory.php">View Inventory</a></th><th><a = href="updateInventory.php">Update Inventory</a></th><th><a href = "viewAndShipOrders.php">View / Ship Orders</a></th><th><a href="salesStatistics.php">Sales Stats</a></th><th><a = href="itemPromotion.php">Item Promotions</a></th></table>
	<br>
        <?php
        include "sql_connect.php";
	if (isset($_POST['SetPrice'])) {
	    $price = $_POST['price'];
            $itemID = $_POST['itemID'];
	    $sql = "UPDATE Item SET price = $price WHERE itemID = $itemID ";
	    $result = mysql_query($sql);
            
            unset($_POST['SetPrice']);
        }

        showInventory();
        ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            ItemID to Promote: <input type="number" name="itemID">
            New Price: <input type="number" name="price">
            <input type="submit" name="SetPrice" id="SetPrice" value="Set Price">
        </form>
    </body>
</html>

