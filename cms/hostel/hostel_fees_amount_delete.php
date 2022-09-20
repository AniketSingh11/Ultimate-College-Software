<? ob_start(); ?>
<?php 

include("../includes/config.php");
if($id=$_GET['id'])
{
    $err_msg="";
  
 


if($err_msg=="")
{
   
    $del_sal=mysql_query("update hms_fees_structure set status='1' where hfs_id='$id'");
  
    
	 header("location:hostel_fees_amount.php?msg=delete_succ");
	 
}
 
 
}
?>

 
<? ob_flush(); ?>