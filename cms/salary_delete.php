<? ob_start(); ?>
<?php
include("includes/config.php");

$mid = $_GET['mid'];
$syid = $_GET['syid'];
 $delete="Delete from salary where sy_id='$syid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:salary_mng.php?mid=$mid&msg=dsucc");
}
?>
<? ob_flush(); ?>