<? ob_start(); ?>
<?php
include("includes/config.php");

$fgdid = $_GET['fgdid'];
$delete="Delete from mfgroup_detail where fgd_id='$fgdid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:mfgroup_detail.php?msg=dsucc");
}
?>
<? ob_flush(); ?>