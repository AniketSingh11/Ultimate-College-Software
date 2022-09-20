<? ob_start(); ?>
<?php
include("includes/config.php");

$did = $_GET['did'];
 $delete="Delete from d_allowance where d_id='$did' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:driver_allowancelist.php?msg=dsucc&s_date=$_GET[s_date]&e_date=$_GET[e_date]");
}
?>
<? ob_flush(); ?>