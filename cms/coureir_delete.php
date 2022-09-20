<? ob_start(); ?>
<?php
include("includes/config.php");

$nid = $_GET['nid'];
 $delete="Delete from courier where id='$nid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:coureirs.php?msg=dsucc");
}
?>
<? ob_flush(); ?>