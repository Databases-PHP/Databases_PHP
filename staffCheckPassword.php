<?php
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
?>

