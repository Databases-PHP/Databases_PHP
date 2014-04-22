<?php
function staffCheckIfManager($inID) {
    include "sql_connect.php";

    $query = "select S1.isManager from Staff S1 where (S1.staffID = $inID);";
    $result = mysql_query ($query);
    $manager = mysql_result ($result, 0);

    return $manager;
}
?>

