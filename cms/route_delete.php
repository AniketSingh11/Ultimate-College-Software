<? ob_start(); ?>
<?php
include("includes/config.php");

$rid = $_GET['rid'];
 $delete="Delete from route where r_id='$rid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:route.php?msg=dsucc");
}
?>
<? ob_flush(); ?>