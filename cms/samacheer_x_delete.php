<? ob_start(); ?>
<?php
include("includes/config.php");

$sxid = $_GET['sxid'];
$bid = $_GET['bid'];
 $delete="Delete from samacheer_x where id='$sxid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:samacheer_x.php?bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>