<?php
$dbHost = "mysql.cs.uky.edu";
$dbUserAndName = "adhe223";
$dbPass = "u0656360";

$_TABLE_NAME = "Staff";
$_STAFF_ID_FIELD = "staffID";
$_STAFF_PASSWORD_FIELD = "password";

mysql_connect ($dbHost, $dbUserAndName, $dbPass) or die ("Cannot connect to host $dbHost with user $dbUserAndName and the password provided.");
mysql_select_db ($dbUserAndName) or die ("Database $dbUserAndName not found on host $dbHost");
?>