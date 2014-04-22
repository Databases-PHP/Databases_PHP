<?php
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
        echo "\nThere aren't enough in stock!";
        return false;
    }
}
?>
