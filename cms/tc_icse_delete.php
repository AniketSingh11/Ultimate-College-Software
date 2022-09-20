<? ob_start(); ?>
<?php
include("includes/config.php");

$id = $_GET['id'];
$bid = $_GET['bid'];
 $delete="Delete from tc_icse where id='$id' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:tc_icse.php?bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>