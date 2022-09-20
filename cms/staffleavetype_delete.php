<? ob_start(); ?>
<?php
include("includes/config.php");

$ltid = $_GET['ltid'];
$mid = $_GET['mid'];
 $delete="Delete from leavetype where lt_id='$ltid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:staffleavetype.php?mid=$mid&msg=dsucc");
}
?>
<? ob_flush(); ?>