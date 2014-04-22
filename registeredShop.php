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
        <table border="1"><tr><th><a href = "index.php">Home</a></th><th><a href = "registeredShop.php">Shop</a></th><th><a = href="customerCart.php">Cart</a></th><th><a href="customerOrders.php">Orders</a></th></table>
        
        <?php
        //Retrieve the logged in customer's id
        $customerID = $_SESSION['customerLoggedIn'];
        echo "<p>Welcome Customer $customerID!</p>";

        if (isset($_POST['AddToCart']) && is_numeric($_POST['itemID']) && is_numeric($_POST['quantity'])) {
            global $customerID;
	    $success = addToCart($customerID, $_POST['itemID'], $_POST['quantity']);
            if ($success == TRUE) {
		$quantity = $_POST['quantity'];
		$itemID = $_POST['itemID'];
                echo "<p> $quantity of item $itemID were added to your cart!</p>";
            }

            unset($_POST['AddToCart']);
            unset($_POST['itemID']);
            unset($_POST['quantity']);
        }
 	//else{
        include "sql_connect.php";

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
	//}
        ?>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            ItemID to add to cart: <input type="number" name="itemID"> 
            Quantity to add: <input type="number" name="quantity"> 
            <input type="submit" name="AddToCart" value="Add to cart">
        </form>
    </body>
</html>
