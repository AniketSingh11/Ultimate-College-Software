<?php
ob_start();
error_reporting(0);
session_start();
// Make Database Connection
$con = mysql_connect("spmodernschool.db.8367826.hostedresource.com", "spmodernschool", "Magic@12") or die("Couldn't make connection.");
$db = mysql_select_db("spmodernschool", $con) or die("Couldn't select database");
?>