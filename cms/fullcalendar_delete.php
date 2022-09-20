<? ob_start(); ?>
<?php
include("includes/config.php");
$id = $_GET['id'];
$sdate = $_GET['sdate'];
 $delete="Delete from evenement where id='$id' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:fullcalendar.php?sdate=$sdate&msg=dsucc");
}
?>
<? ob_flush(); ?>