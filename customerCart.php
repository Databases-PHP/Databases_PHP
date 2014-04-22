<!DOCTYPE html>
<?php
session_start();
$customerID = $_SESSION['customerLoggedIn'];
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Your Cart</title>
    </head>
    <body>        
        <table border="1"><tr><th><a href = "index.php">Home</a></th><th><a href = "registeredShop.php">Shop</a></th><th><a = href="customerCart.php">Cart</a></th><th><a href="customerOrders.php">Orders</a></th></table>
        
	<?php
        include "sql_connect.php";
        $orderID = null;
        $continue = true;
        
        if (isset($_POST['Purchase'])) {
            //Make sure the cart has items in it
            $itemsQ = "select * from CartHasItem where cartID = $customerID";
            $itemsInCart = mysql_query($itemsQ);
            $numRows = mysql_num_rows($itemsInCart);

            if ($numRows <= 0) {
                $continue = false;
                echo "There aren't any items in the cart!";
            }

            //If items are in cart, continue
            if ($continue) {
                //Create order, which is auto increment
                $addOrderQ = "insert into CustomerOrder values(NULL, 'Pending', NOW(), $customerID)";
                if (mysql_query($addOrderQ)) {
                    //Successfully created order
                    //Get the order ID
                    $orderID = mysql_insert_id();
                } else {
                    echo "<p>Order creation failed!</p>";
                }

                //First get itemID and quantity from CartHasItem
                $getItemQ = "select CHI.itemID, CHI.itemQuantity from CartHasItem as CHI where CHI.cartID = $customerID";
                $result = mysql_query($getItemQ);
                if (!$result) {           
                    echo "<p>Failed to get the itemID and quantity from CartHasItem</p>";
                }

                //Now create an entry in OrderHasItem
                $num = mysql_numrows($result);
                for ($i = 0; $i < $num; $i++) {
                    //Get data
                    $itemID = mysql_result($result, $i, "itemID");
                    $quantity = mysql_result($result, $i, "itemQuantity");

                    //insert record
                    $insertOHIQ = "insert into OrderHasItem values($orderID, $itemID, $quantity)";
                    if (!mysql_query($insertOHIQ)) {
                        echo "<p>Failed to insert into OrderHasItem!</p>";
                    }
                }

                //Set boolean to see if this operation is done. NEED TO DO!!!!!!
                //Remove data from CartHasItem. Delete every entry when cartID = customerID.
                $deleteCHIQ = "delete from CartHasItem where CartHasItem.cartID = $customerID";
                if (!mysql_query($deleteCHIQ)) {
                    echo "<p>Failed to delete from CartHasItem!</p>";
                }
            }

            unset($_POST['Purchase']);
        }
        
        $query = "select CHI.itemID, I.name, CHI.itemQuantity, I.price from CartHasItem CHI, Item I where CHI.cartID = $customerID and I.itemID = CHI.itemID";
        $result = mysql_query ($query);
	if(!$result){
            echo "Failed to Load Cart";
	}

        $num = mysql_numrows ($result);
        echo "<table border='1'><tr><th>Item ID</th><th>Item Name</th><th>Quantity</th><th>Price per Unit</th>";
	$totalprice = 0;
        for ($i = 0; $i < $num; $i++) {
                $itemID = mysql_result ($result, $i, "CHI.itemID");
                $name = mysql_result ($result, $i, "I.name");
                $quantity = mysql_result ($result, $i, "CHI.itemQuantity");
		$price = mysql_result($result, $i, "I.price");
                echo "<tr>";
                echo "<td>$itemID</td> <td>$name</td> <td>$quantity</td> <td>$price</td>";
                echo "</tr>";
		$totalprice = $totalprice + ($quantity * $price);
        }

        echo "</table>";
 
	echo "\n Total Price: $ $totalprice";
        ?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	    <input type="submit" name="Purchase" value="Purchase">
        </form>
    </body>
</html>

<?php
function itemsInCart($inCustomerID) { 
    include "sql_connect.php";
    

}


?>

