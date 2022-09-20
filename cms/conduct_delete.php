<? ob_start(); ?>
<?php
include("includes/config.php");

$contid = $_GET['contid'];
 $delete="Delete from conduct where con_id='$contid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:conduct.php?msg=dsucc");
}
?>
<? ob_flush(); ?>