<? ob_start(); ?>
<?php
include("includes/config.php");

$eid = $_GET['eid'];
 $delete="Delete from exam where e_id='$eid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:exam.php?msg=dsucc");
}
?>
<? ob_flush(); ?>