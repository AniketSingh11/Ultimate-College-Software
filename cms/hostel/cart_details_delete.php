<? ob_start(); ?>
<?php 

include("../includes/config.php");
if($id=$_GET['id'])
{
   $hrc_id=$_GET['cid']; 
    
    $err_msg="";
$query="select * from hms_room where hr_id='$id'";
$res=mysql_query($query) or die(mysql_error());
while($row=mysql_fetch_array($res))
{    
$no_cart=$row["no_cart"];
$available_qty=$row["available_qty"];



}

$query="select * from hms_room_cart where hrc_id='$hrc_id' and room_status='1' ";
$res=mysql_query($query) or die(mysql_error());
$chk=0;
while($row=mysql_fetch_array($res))
{

$chk=1;

$err_msg.="Beds/Cart Already Assigned..";

}


if($err_msg=="")
{
   
    
   
    $del_sal=mysql_query("update hms_room_cart set room_status='0',status='1' where hrc_id='$hrc_id'");
    
    
    $no_cart=$no_cart-1;
    $available_qty=$available_qty-1;
    
    $del_sal=mysql_query("update hms_room set no_cart='$no_cart',available_qty='$available_qty' where hr_id='$id'");
    
	 header("location:cart_details_list.php?id=$id&msg=delete_succ");
	 
}
else
{   
       //  $err_msg="Return the remaining book then After Delete Category !! &nbsp;";
	     header("location:cart_details_list.php?id=$id&msg=err&err_msg=$err_msg");
}
}
?>

 
<? ob_flush(); ?>