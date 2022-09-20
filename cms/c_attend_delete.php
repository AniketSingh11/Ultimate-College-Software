<? ob_start(); ?>
<?php
include("includes/config.php");

$cattid = $_GET['cattid'];
 $delete="Delete from c_attend where catt_id='$cattid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:c_attend.php?msg=dsucc");
}
?>
<? ob_flush(); ?>