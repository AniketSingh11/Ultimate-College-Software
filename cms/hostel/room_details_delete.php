<? ob_start(); ?>
<?php 

include("../includes/config.php");
if($id=$_GET['id'])
{
    $err_msg="";
$query="select * from hms_room where hr_id='$id'";
$res=mysql_query($query) or die(mysql_error());
while($row=mysql_fetch_array($res))
{    
$no_cart=$row["no_cart"];
$available_qty=$row["available_qty"];


if($no_cart==$available_qty){
}
else{
    $err_msg.="Close this Hostel Room Student Details then After Delete Room !! &nbsp;";
}


}


if($err_msg=="")
{
   
    
    $del_sal=mysql_query("update hms_room set status='1' where hr_id='$id'");
    $del_sal=mysql_query("update hms_room_cart set status='1' where hr_id='$id'");
    
	 header("location:room_details_list.php?msg=delete_succ");
	 
}
else
{   
       //  $err_msg="Return the remaining book then After Delete Category !! &nbsp;";
	     header("location:room_details_list.php?msg=err&err_msg=$err_msg");
}
}
?>

 
<? ob_flush(); ?>