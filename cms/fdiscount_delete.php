<? ob_start(); ?>
<?php
include("includes/config.php");

$fdisid = $_GET['fdisid'];
 $delete="Delete from fdiscount where fdis_id='$fdisid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:fdiscount.php?msg=dsucc");
}
?>
<? ob_flush(); ?>