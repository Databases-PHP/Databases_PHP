<?php
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
?>