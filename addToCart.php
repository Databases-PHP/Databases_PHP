<?php
function addToCart($inCartID, $inItemID, $inQuant) {
    include "sql_connect.php";

    //Check if there is enough inventory
    $query = "select i.numberInStock from Item i where (i.itemID = $inItemID);";
    $result = mysql_query ($query);
    $quantInStock = mysql_result ($result, 0);
    
    if ($quantInStock >= $inQuant) {
        //Add to cart
        $query = "insert into CartHasItem values('$inItemID', '$inCartID', '$inQuantity');";
        if (mysql_query ($query)) {
            //Completed successfully
            return true;
        } else {
            //Failed
            return false;
        }
    } else {
        echo "There aren't enough in stock! Please press back and try again.";
        return false;
    }
}
?>
