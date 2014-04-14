<?php
function staffCheckPassword($inID, $inPassword) {
    $dbHost = "localhost:3306";
    $dbUserAndName = "root";
    $dbPass = "";
    $db = "cs405_project";

    $_TABLE_NAME = "Staff";
    $_STAFF_ID_FIELD = "staffID";
    $_STAFF_PASSWORD_FIELD = "password";
    
    mysql_connect ($dbHost, $dbUserAndName, $dbPass) or printf("Could not connect to database!");    //("Cannot connect to host $dbHost with user $dbUserAndName and the password provided.");
    mysql_select_db ($db) or printf("Selecting database failed!");//die ("Database $dbUserAndName not found on host $dbHost");

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

