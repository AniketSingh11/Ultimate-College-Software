<? ob_start(); ?>
<?php
include("includes/config.php");

$eid = $_GET['e_id'];
 $delete="Delete from experience_certificate where e_id='$eid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:exp_certificate_list.php?msg=dsucc");
}
?>
<? ob_flush(); ?>