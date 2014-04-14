<?php
$dbHost = "localhost:3306";
$dbUserAndName = "root";
$dbPass = "";
$db = "cs405_project";

$_TABLE_NAME = "Staff";
$_STAFF_ID_FIELD = "staffID";
$_STAFF_PASSWORD_FIELD = "password";

mysql_connect ($dbHost, $dbUserAndName, $dbPass) or printf("Could not connect to database!");    //("Cannot connect to host $dbHost with user $dbUserAndName and the password provided.");
mysql_select_db ($db) or printf("Selecting database failed!");//die ("Database $dbUserAndName not found on host $dbHost");

$query = "select * from $_TABLE_NAME";
$result = mysql_query ($query);

$num = mysql_numrows ($result);

echo "<table border='1'><tr><th>Staff ID</th><th>Password</th>";

for ($i = 0; $i < $num; $i++) {
        echo "<tr>";
        $staffID = mysql_result ($result, $i, $_STAFF_ID_FIELD);
        $password = mysql_result ($result, $i, $_STAFF_PASSWORD_FIELD);
        echo "<td>$staffID</td> <td>$password</td>";
        echo "</tr>";
}	

echo "</table>";

?>

