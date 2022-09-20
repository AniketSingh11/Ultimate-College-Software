<? ob_start(); ?>
<?php 

include("../includes/config.php");
include("includes/log_permission_delete_header.php");

if($_SESSION['admin_type']=="0" || in_array("driver_list.php", $permissions_record_delete) ){
if($nid=$_GET['id'])
{
 $path = "../img/driver";

$query_d="select * from driver where d_id='$nid'";
$result=mysql_query($query_d);
$result_d=mysql_fetch_array($result);

if($result_d["photo"]!="") 
{
    $image=$result_d["photo"];
	unlink($path."/".$image);
}
$query="delete from driver where d_id='$nid'";
$result=mysql_query($query);

if($result)
{
	header("location:driver_list.php?msg=delete_succ");
}
else
{
	header("location:driver_list.php?msg=err");
}
}
?>

<?php 
if($img_id=$_GET['img_id'])
{
	$path = "../img/driver";

$query_del="select * from driver where d_id='$img_id'";

$result_del=mysql_query($query_del);
$img_delete=mysql_fetch_array($result_del);
$lastphoto=$img_delete["photo"];
if($lastphoto && $lastphoto!="driver_male.png" && $lastphoto!="driver_female.png"){
   unlink($path."/".$lastphoto);
}

$del_query="update driver set photo ='' where d_id='$img_id' ";

$result_img=mysql_query($del_query);

if($result_img)
{
	header("location:driver_edit.php?id=$img_id");
}

}
}
else
{
	header("location:driver_list.php");
}
?>
<? ob_flush(); ?>