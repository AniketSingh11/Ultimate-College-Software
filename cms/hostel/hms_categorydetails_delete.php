<? ob_start(); ?>
<?php 

include("../includes/config.php");
if($id=$_GET['id'])
{
    $err_msg="";
$query="select * from hms_room where category='$id'";
$res=mysql_query($query) or die(mysql_error());
while($row=mysql_fetch_array($res))
{    
$no_cart=$row["no_cart"];
$available_qty=$row["available_qty"];


if($no_cart==$available_qty){
}
else{
    $err_msg.="Close this Hostel Student Details then After Delete Hostel !! &nbsp;";
}


}


if($err_msg=="")
{
   
    $del_sal=mysql_query("update hms_category set status='1' where h_id='$id'");
    $del_sal=mysql_query("update hms_floor set status='1' where category='$id'");
    $del_sal=mysql_query("update hms_room set status='1' where category='$id'");
    $del_sal=mysql_query("update hms_room_cart set status='1' where category='$id'");
    
	 header("location:hms_categorydetails_list.php?msg=delete_succ");
}
else
{   
       //  $err_msg="Return the remaining book then After Delete Category !! &nbsp;";
	     header("location:hms_categorydetails_list.php?msg=err&err_msg=$err_msg");
}
}
?>

 
<? ob_flush(); ?>