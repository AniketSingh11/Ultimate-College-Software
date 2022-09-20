<?php
include("includes/config.php");
$id = $_POST['id'];
$sql = "DELETE from evenement WHERE id=".$id;
$result=mysql_query($sql);
?>
