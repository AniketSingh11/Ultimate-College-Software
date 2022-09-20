<? ob_start(); ?>
<?php
include("includes/config.php");

$lid = $_GET['l_id'];
 $delete="Delete from letter_pad where l_id='$lid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:letterpad_list.php?msg=dsucc");
}
?>
<? ob_flush(); ?>