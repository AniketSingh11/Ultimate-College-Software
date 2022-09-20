<? ob_start(); ?>
<?php
include("includes/config.php");

$stid = $_GET['stid'];
 $delete="Delete from staff where st_id='$stid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:staff.php?msg=dsucc");
}
?>
<? ob_flush(); ?>