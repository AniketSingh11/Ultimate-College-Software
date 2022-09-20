<? ob_start(); ?>
<?php
include("includes/config.php");

$nid = $_GET['nid'];
 $delete="Delete from visitor where id='$nid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:visitor.php?msg=dsucc");
}
?>
<? ob_flush(); ?>