<? ob_start(); ?>
<?php
include("includes/config.php");

$paid = $_GET['paid'];
$bid = $_GET['bid'];
$cid = $_GET['cid'];

 $delete="Delete from pre_admission where pa_id='$paid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:pre_admission_select.php?bid=$bid&cid=$cid&msg=dsucc");
}
?>
<? ob_flush(); ?>