<?php
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
        return true;
    }
    
    return false;
}
?>

