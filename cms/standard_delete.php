<? ob_start(); ?>
<?php
include("includes/config.php");

$cid = $_GET['cid'];
$bid = $_GET['bid'];
 $delete="Delete from class where c_id='$cid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:standard.php?bid=$bid&msg=dsucc");
}
?>
<? ob_flush(); ?>