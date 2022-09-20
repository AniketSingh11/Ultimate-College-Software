<? ob_start(); ?>
<?php
include("includes/config.php");

$qid = $_GET['qid'];

$delete="Delete from quotation where q_id='$qid' ";
$result1=mysql_query($delete);

 $delete="Delete from quotation_amount where q_id='$qid' ";
    $result=mysql_query($delete);
    if(!$result || !$result1)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:quotation_list.php?msg=dsucc");
}
?>
<? ob_flush(); ?>