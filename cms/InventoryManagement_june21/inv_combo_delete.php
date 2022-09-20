<? ob_start(); ?>
<?php
include("../includes/config.php");

$bid = $_GET['com_parentid'];
 $delete="DELETE inv_combo_parent,inv_combo FROM inv_combo_parent INNER JOIN inv_combo on (inv_combo.com_parent_id= inv_combo_parent.com_parent_id) where inv_combo_parent.com_parent_id = '$bid' ";
    $result=mysql_query($delete);
    if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
header("Location:inv_combo.php?msg=dsucc");
}
?><? ob_flush(); ?>