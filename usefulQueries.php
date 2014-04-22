<?php
function pendingOrderExist($orderID) {
    include "sql_connect.php";
    
    $query = "select * from CustomerOrder CO where CO.orderID = $orderID and CO.orderStatus = 'Pending'";
    $result = mysql_query($query);
    $numRows = mysql_num_rows($result);
    
    if ($numRows == 0) {
        return false;
    }
    
    return true;
}

function showInventory() {
    include "sql_connect.php";

    $query = "select * from Item";
    $result = mysql_query ($query);

    $num = mysql_numrows ($result);

    echo "<table border='1'><tr><th>Item ID</th><th>Item Name</th><th>Price</th><th># In Stock</th>";

    for ($i = 0; $i < $num; $i++) {
            echo "<tr>";
            $itemID = mysql_result ($result, $i, "itemID");
            $numberInStock = mysql_result ($result, $i, "numberInStock");
            $name = mysql_result ($result, $i, "name");
            $price = mysql_result ($result, $i, "price");
            echo "<td>$itemID</td> <td>$name</td> <td>$price</td> <td>$numberInStock</td>";
            echo "</tr>";
    }	

    echo "</table>";
}

function getQuantInStock($itemID) {
    include "sql_connect.php";
    
    $query = "select I.numberInStock from Item I where I.itemID = $itemID";
    $result = mysql_query($query);
    
    return mysql_result($result, 0);
}

//change status of order to "Shipped"
function changeStatusOfOrder($orderID) {
    include "sql_connect.php";
    $query = "UPDATE CustomerOrder SET orderStatus = 'Shipped' WHERE orderID = $orderID";

    if(mysql_query ($query)){
	return true;
    }
    else{
        return false;
    }
}

function isManager($staffID) {
    include "sql_connect.php";
    $query = "select S.isManager from Staff S where staffID = $staffID";
    $result = mysql_query($query);
    
    return mysql_result($result, 0);
}

function checkForAllComponents($orderID) {
    include "sql_connect.php";
	//Check OrderHasItem.quantity of each item that matches orderID against
	// Item.numberInStock. If any rows return, there order isn't filled
    $query = "select * from OrderHasItem OHI, Item I where OHI.orderID = $orderID AND OHI.itemID = I.itemID AND OHI.quantity > I.numberInStock";

    $result = mysql_query ($query);
    if($result){
    }else{
	echo "\nCouldn't check for all parts of order!";
    }
    $num = mysql_numrows ($result);

    if ($num > 0) {
        return false;
    } else {
        return true;
    }
}

//check to see if any of the order's components don't meet the quantity the user specified.
function outputMissingComponents($orderID) {
    session_start();
    $_SESSION['orderID'] = $orderID; 
    header('Location: /~adhe223/outputComponents.php');//http:www.cs.uky.edu/~adhe223/outputComponents.php');
    /*
    include "sql_connect.php";
        //Check OrderHasItem.quantity of each item that matches orderID against
        // Item.numberInStock. If any rows return, there order isn't filled
    $query = "select OHI.itemID, OHI.quantity, I.numberInStock from OrderHasItem OHI, Item I where OHI.orderID = $oderID AND OHI.itemID = I.itemID AND OHI.quantity > I.numberInStock";

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
     */
}

function customerCheckPassword($inID, $inPassword) {
    include "sql_connect.php";
    
    $query = "select C1.password from Customer C1 where (C1.customerID = $inID);";
    $result = mysql_query ($query);
    $password = mysql_result ($result, 0);
    
    if ($password == $inPassword) {
        return true;
    } else {
        return false;
    }
}

function customerRegister ($inID, $inPassword) {
    include "sql_connect.php";
    
    $query = "select * from Customer C1 where (C1.customerID = $inID);";
    $result = mysql_query ($query);
    $rows = mysql_numrows ($result);
    
    if ($rows > 0) {
        //Already a customer registered with that id
        return false;
    }
    
    //Add the new customer to the database
    $customerID = trim ($inID);
    
    if ($customerID == "") {
        return false;
    }     
    
    //Now add
    $query = "insert into Customer values('$customerID', '$inPassword');";
    if (mysql_query ($query)) {
        //Now add a cart into Cart with the same ID as customer ID (this was guaranteed to be unique)
        $query2 = "insert into Cart values('$customerID', '$customerID');";
        if (mysql_query ($query2)) {
            return true;
        } else {
            //Big problem
            echo "Big problem! Cart was not created but the user was added! This shouldn't be reachable.";
            return false;
        }
    }
    
    return false;
}

function addToCart($inCustomerID, $inItemID, $inQuant) {
    //echo "Beginning addToCart(...)!";
    include "sql_connect.php";
    if ($inItemID == "" || $inQuant == "") {
        echo "\nAdding to cart failed because the values are blank!";
        return false;
    }
    
    //Find the cartID associated with this customer
    $query = "select C.cartID from Cart C where (C.customerID = $inCustomerID);";
    $result = mysql_query ($query);
    if ($result == FALSE) {
        echo "\nFinding the customers cart failed!";
        return false;
    }
    $inCartID = mysql_result ($result, 0);
    
    //Check if there is enough inventory
    $query2 = "select i.numberInStock from Item i where (i.itemID = $inItemID);";
    $result2 = (mysql_query ($query2)); 
    if ($result2 == FALSE) {
        echo "\nQuerying the number of items in inventory failed!";
        return false;
    }
    $quantInStock = mysql_result ($result2, 0);
    if ($quantInStock >= $inQuant) {
        //Add to cart. First check if the same cart already has some of this item. If so, update the number value
	//echo "inCartID: $inCartID";
        $query3 = "select * from CartHasItem CHI where CHI.itemID = $inItemID and CHI.cartID = $inCartID";
        $result3 = mysql_query($query3);
        $numRows = mysql_numrows($result3);
        if ($numRows > 0) {
            //Item exists in cart. Update the quantity variable
            $oldQuant = mysql_result ($result3, 0, "itemQuantity");
            $newQuant = $oldQuant + $inQuant;
            $query4 = "update CartHasItem set itemQuantity=$newQuant where CartHasItem.itemID = $inItemID and CartHasItem.cartID = $inCartID";
            if (mysql_query($query4)) {
                echo "Successfully updated the item quantity in cart!";
                return true;
            } else {
                echo "Failed to update the quantity of the item in the cart!";
            }
        } else {
            //Item does not exist in cart yet. Add
            $query6 = "insert into CartHasItem values ($inItemID, $inCartID, $inQuant)";
            
            if (mysql_query ($query6)) {
                //Succeeded
                return true;
            } else {
                //Failed
                echo "\nThe query to add items to the cart failed!";
                return false;
            }
        }
    } else {
        echo "\nThere aren't enough of the item in stock or you have entered an invalid item!";
        return false;
    }
}

function staffCheckIfManager($inID) {
    include "sql_connect.php";

    $query = "select S1.isManager from Staff S1 where (S1.staffID = $inID);";
    $result = mysql_query ($query);
    $manager = mysql_result ($result, 0);

    return $manager;
}

function staffCheckPassword($inID, $inPassword) {
    include "sql_connect.php";
    
    $query = "select S1.password from Staff S1 where (S1.staffID = $inID);";
    $result = mysql_query ($query);
    $password = mysql_result ($result, 0);
    
    if ($password == $inPassword) {
        return true;
    } else {
        return false;
    }
}

function staffUpdateInventory($inID, $inNewQuantity) {
    include "sql_connect.php";
    $query = "update Item set Item.numberInStock=$newQuantity where (I.itemID = $inItemID);";
    $result = mysql_query ($query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

?>
