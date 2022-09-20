<? ob_start(); ?>
<?php
include("includes/config.php");
$stid = $_GET['stid'];
$subid = $_GET['subid'];
$bid = $_GET['bid'];
 $delete="Delete from subject where sub_id='$subid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:staff-assign.php?stid=$stid&bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>