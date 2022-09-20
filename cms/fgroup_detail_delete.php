<? ob_start(); ?>
<?php
include("includes/config.php");

$fgid = $_GET['fg_id'];
$fgdid = $_GET['fgdid'];
$delete="Delete from fgroup_detail where fgd_id='$fgdid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:fgroup_detail.php?fg_id=$fgid&msg=dsucc");
}
?>
<? ob_flush(); ?>