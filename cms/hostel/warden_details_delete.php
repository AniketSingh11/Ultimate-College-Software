<? ob_start(); ?>
<?php 

include("../includes/config.php");
if($id=$_GET['id'])
{
    
 
 $del_sal=mysql_query("update hms_worker set status='1' where hw_id='$id'");
    
	 header("location:warden_details_list.php?msg=delete_succ");
	 
}
else
{   
          $err_msg="Failed";
	     header("location:warden_details_list.php?msg=err&err_msg=$err_msg");
}
 
?>

 
<? ob_flush(); ?>