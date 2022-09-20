<? ob_start(); ?>
<?php
include("includes/config.php");

$tcid = $_GET['tcid'];
$bid = $_GET['bid'];
 $delete="Delete from tc_xi where id='$tcid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:tc_xi.php?bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>