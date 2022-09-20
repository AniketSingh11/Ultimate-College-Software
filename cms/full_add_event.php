<?php
include("includes/config.php");
// Values received via ajax
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
//$url = $_POST['url'];

// connection to the database
$sql="INSERT INTO evenement (title,start,end) VALUES
('$title','$start','$end')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

?>
