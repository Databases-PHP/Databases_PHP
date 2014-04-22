//take the item ID and quantity number and update the Item table appropiately
$query = "update Item set Item.numberInStock=$newQuantity where (I.itemID = $inItemID);";
            $result = mysql_query ($query);
<?php
function staffUpdateInventory($inID, $inNewQuantity) {
    include "sql_connect.php";
    $query = "update Item set Item.numberInStock=$newQuantity where (I.itemID = $inItemID);";
    $result = mysql_query ($query);
    return true;
}
?>

