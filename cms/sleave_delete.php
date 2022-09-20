<? ob_start(); ?>
<?php
include("includes/config.php");

$slid = $_GET['slid'];
 $delete="Delete from staff_leave where id='$mid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:sleave.php?slid=$slid&msg=dsucc");
}
?>
<? ob_flush(); ?>