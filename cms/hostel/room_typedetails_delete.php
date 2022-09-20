<? ob_start(); ?>
<?php 

include("../includes/config.php");
if($id=$_GET['id'])
{
    $err_msg="";
    $room=array();
    $qry1=mysql_query("select * from hms_room where room_type='$id'");
    while($row1=mysql_fetch_array($qry1))
    {
        $hr_id=$row1["hr_id"];
       array_push($room,$hr_id); 
       
    }
   $room_id=join(",",$room);
 
  
$query="select * from hms_room where hr_id in ('$room_id')";
$res=mysql_query($query) or die(mysql_error());
while($row=mysql_fetch_array($res))
{    
$no_cart=$row["no_cart"];
$available_qty=$row["available_qty"];
$hr_id=$row["hr_id"];

if($no_cart==$available_qty){
}
else{
    $err_msg.="Close this Hostel Roomtype Student Details then After Delete Roomtype !! &nbsp;";
}


}


if($err_msg=="")
{
   
    $del_sal=mysql_query("update hms_room_type set status='1' where hrt_id='$id'");
    $del_sal=mysql_query("update hms_room set status='1' where hr_id in ('$room_id')");
    $del_sal=mysql_query("update hms_room_cart set status='1' where hr_id in ('$room_id')");
    
	 header("location:room_typedetails_list.php?msg=delete_succ");
	 
}
else
{   
       //  $err_msg="Return the remaining book then After Delete Category !! &nbsp;";
	     header("location:room_typedetails_list.php?msg=err&err_msg=$err_msg");
}
 
}
?>

 
<? ob_flush(); ?>