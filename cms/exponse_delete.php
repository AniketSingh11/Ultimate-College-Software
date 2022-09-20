<? ob_start(); ?>
<?php
include("includes/config.php");

$excid = $_GET['excid'];
$exid = $_GET['exid'];
 $delete="Delete from exponses where ex_id='$exid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:exponse.php?excid=$excid&msg=dsucc");
}
?>
<? ob_flush(); ?>