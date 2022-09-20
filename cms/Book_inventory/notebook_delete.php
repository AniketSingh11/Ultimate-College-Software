<? ob_start(); ?>
<?php
include("../includes/config.php");

$nid = $_GET['nid'];
 $delete="Delete from notebook_purchese where n_id='$nid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:notebook_purchese.php?msg=dsucc");
}
?><? ob_flush(); ?>