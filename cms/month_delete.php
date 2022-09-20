<? ob_start(); ?>
<?php
include("includes/config.php");

$ayid = $_GET['ayid'];
$mid = $_GET['mid'];
 $delete="Delete from month where m_id='$mid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:month.php?ayid=$ayid&msg=dsucc");
}
?>
<? ob_flush(); ?>