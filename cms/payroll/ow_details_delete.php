<? ob_start(); ?>
<?php 

include("../includes/config.php");

if($_SESSION['admin_type']=="0" || in_array("ow_list.php", $permissions_record_delete) ){
if($nid=$_GET['id'])
{
 $path = "../img/others";
$query_d="select * from others where o_id='$nid'";
$result=mysql_query($query_d);
$result_d=mysql_fetch_array($result);

if($result_d["photo"]!="") 
{
    $image=$result_d["photo"];
	unlink($path."/".$image);
}
/*$del_sal=mysql_query("delete from staff_sal where d_id='$nid'");
$del_mon_sal=mysql_query("delete from staff_mon_sal where d_id='$nid'");
$del_loan=mysql_query("delete from staff_loan where d_id='$nid'");
$del_leave=mysql_query("delete from staff_leave where d_id='$nid'");*/
$query="delete from others where o_id='$nid'";
$result=mysql_query($query);

if($result)
{
	header("location:ow_list.php?msg=delete_succ");
}
else
{
	header("location:ow_list.php?msg=err");
}
}
?>

<?php 
if($img_id=$_GET['img_id'])
{
$path = "../img/others";
$query_del="select * from others where o_id='$img_id'";
$result_del=mysql_query($query_del);
$img_delete=mysql_fetch_array($result_del);
$lastphoto=$img_delete["photo"];
if($lastphoto && $lastphoto!="mstaff_small.png" && $lastphoto!="fstaff_small.png"){
   unlink($path."/".$lastphoto);
}
$del_query="update others set photo ='' where o_id='$img_id' ";
$result_img=mysql_query($del_query);
if($result_img)
{
	header("location:ow_details_edit.php?id=$img_id");
}
}
}
else
{
	header("location:ow_list.php");
}
?>
<? ob_flush(); ?>