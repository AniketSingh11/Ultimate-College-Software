<? ob_start(); ?>
<?php
include("includes/config.php");

$excid = $_GET['excid'];
 $delete="Delete from ex_category where exc_id='$excid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:exponses_category.php?msg=dsucc");
}
?>
<? ob_flush(); ?>