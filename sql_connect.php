<?php
$dbHost = "localhost:3306";
$dbUserAndName = "root";
$dbPass = "";
$db = "cs405_project";

mysql_connect ($dbHost, $dbUserAndName, $dbPass) or die("Cannot connect to host $dbHost with user $dbUserAndName and the password provided.");
mysql_select_db ($db) or die ("Database $dbUserAndName not found on host $dbHost");
?>