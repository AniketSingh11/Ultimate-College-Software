<? ob_start(); ?>
<?php
include("includes/config.php");

$tid = $_GET['tid'];
 $delete="Delete from report_temp where t_id='$tid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:exp_filterstudent_temp.php?msg=dsucc");
}
?>
<? ob_flush(); ?>