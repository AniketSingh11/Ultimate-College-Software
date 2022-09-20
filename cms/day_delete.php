<? ob_start(); ?>
<?php
include("includes/config.php");

$did = $_GET['did'];
 $delete="Delete from day where d_id='$did' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:day.php?msg=dsucc");
}
?>
<? ob_flush(); ?>