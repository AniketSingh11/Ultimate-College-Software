<? ob_start(); ?>
<?php
include("../includes/config.php");

$cid = $_GET['cid'];
 $delete="Delete from class where c_id='$cid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:std.php?msg=dsucc");
}
?>
<? ob_flush(); ?>