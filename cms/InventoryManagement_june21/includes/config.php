<?php
// Make Database Connection
$con = mysql_connect("localhost", "root", "") or die("Couldn't make connection.");
$db = mysql_select_db("book_inventory", $con) or die("Couldn't select database");
?>