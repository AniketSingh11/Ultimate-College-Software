<?php
ob_start();
error_reporting(0);
session_start();
// Make Database Connection
$con = mysql_connect("127.0.0.1", "pkvwmdqm_christs", "Christs@2016") or die("Couldn't make connection.");
$db = mysql_select_db("pkvwmdqm_christ", $con) or die("Couldn't select database");
?>