<?php
// Make Database Connection
$con = mysql_connect("localhost", "tameasyi_user", "tameasyi_user@123") or die("Couldn't make connection.");
$db = mysql_select_db("tameasyi_college", $con) or die("Couldn't select database");
?>