<? ob_start(); ?>
<?php
include("includes/config.php");

$nid = $_GET['nid'];
 $delete="Delete from news where n_id='$nid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:news.php?msg=dsucc");
}
?>
<? ob_flush(); ?>