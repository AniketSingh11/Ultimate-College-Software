<? ob_start(); ?>
<?php
include("includes/config.php");

 	$did=$_GET['did'];
	$bid=$_GET['bid'];
	$cids=$_GET['cid'];

$delete="Delete from discount where d_id='$did' ";
$result1=mysql_query($delete);

 $delete="Delete from discount_value where d_id='$did' ";
    $result=mysql_query($delete);
    if(!$result || !$result1)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:discount_mng.php?bid=$bid&cid=$cids&msg=dsucc");
}
?>
<? ob_flush(); ?>