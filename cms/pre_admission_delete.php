<? ob_start(); ?>
<?php
include("includes/config.php");

$paid = $_GET['paid'];

 $delete="Delete from pre_admission where pa_id='$paid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:pre_admission.php?msg=dsucc");
}
?>
<? ob_flush(); ?>