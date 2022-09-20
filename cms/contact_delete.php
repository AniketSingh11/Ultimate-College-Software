<? ob_start(); ?>
<?php
include("includes/config.php");

$ctid = $_GET['ctid'];
 $delete="Delete from contact where ct_id='$ctid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:contact_details.php?msg=dsucc");
}
?>
<? ob_flush(); ?>