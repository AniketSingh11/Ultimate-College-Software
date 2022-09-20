<? ob_start(); ?>
<?php
include("../includes/config.php");

$cid = $_GET['cid'];
$sid = $_GET['sid'];
 $delete="Delete from section where s_id='$sid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:section.php?cid=$cid&msg=dsucc");
}
?>
<? ob_flush(); ?>