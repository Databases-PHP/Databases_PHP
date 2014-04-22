<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Staff Page</title>
    </head>
    <body>
<?php
//can do same as staffPage.php plus see sale statistics and decide on a sales promotion (change the price)
?>
        <h1>Manager Page</h1>
        <?php
        //need to be able to view inventory (list of all items and their quantity).
        // Note: this page is the same as unregisteredShop.php
        ?>
         <a href="viewInventory.php">View Inventory</a>
        <p><br></p>
        <?php
        //need to be able to update inventory (same as view, but with editable text boxes to update quantity)
        ?>
        <a href="updateInventory.php">Update Inventory</a>
        <p><br></p>
        <?php
        //need to be able to see a list of pending orders (components, price, customer info)
        // can also "ship" an order if all components are available, order status changes from pending to shipp$
        // and the quantities in the inventory are appropiately decreased (if ahavent already done)
        // if the components are not available, redirect to a page listing the missing pieces
        ?>
        <a href="viewAndShipOrders.php">View / Ship Orders</a>

	<?php //view list of all items and sales history in the previous week/month/year
		//set promotion rate for specific item
	?>
	<p><br></p>
	<a href="salesStatistics.php">Sales Statistics</a>

	<p><br></p>
        <a href="itemPromotion.php">Item Promotion</a>


    </body>
</html>

