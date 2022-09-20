<? ob_start(); ?>
<?php
include("includes/config.php");

$aid = $_GET['aid'];
$delete = "Delete from agency_advance where adv_id='$aid' ";
$result = mysql_query($delete);
if (!$result) {
    die("Query Failed: " . mysql_error());
} else {
    header("Location:agency_advance.php?msg=dsucc");
}
?>
<? ob_flush(); ?>