<? ob_start(); ?>
<?php
include("includes/config.php");

$incid = $_GET['incid'];
 $delete="Delete from in_category where inc_id='$incid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:income_category.php?msg=dsucc");
}
?>
<? ob_flush(); ?>