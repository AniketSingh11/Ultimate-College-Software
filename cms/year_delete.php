<? ob_start(); ?>
<?php
include("includes/config.php");

$ayid = $_GET['ayid'];
 $delete="Delete from year where ay_id='$ayid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:year.php?msg=dsucc");
}
?>
<? ob_flush(); ?>