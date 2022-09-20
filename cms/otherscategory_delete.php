<? ob_start(); ?>
<?php
include("head_top.php"); 
//include("includes/config.php");


$oc_id = $_GET['oc_id'];
 

 
 $delete="Delete from others_category where  oc_id='$oc_id'";
    $result=mysql_query($delete);
 
header("Location:others_categorylist.php?msg=dsucc");
 
?>
<? ob_flush(); ?>