<? ob_start(); ?>
<?php
include("includes/config.php");

$sxid = $_GET['sxid'];
$bid = $_GET['bid'];
 $delete="Delete from samacheer_itox where id='$sxid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:samacheer_itox.php?bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>