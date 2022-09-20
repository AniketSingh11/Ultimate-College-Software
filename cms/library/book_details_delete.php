<? ob_start(); ?>
<?php 

include("../includes/config.php");
if($id=$_GET['id'])
{
    $err_msg="";
$query="select * from lms_book where  b_id='$id'";
$res=mysql_query($query) or die(mysql_error());
$row=mysql_fetch_array($res);
$oldqty=$row["qty"];
$oldavilable_qty=$row["avilable_qty"];


if($oldqty==$oldavilable_qty){
}
else{
    $err_msg="Return the remaining book then After Delete Book !! &nbsp;";
}

if($err_msg=="")
{

    $del_sal=mysql_query("update lms_book set status='1' where b_id='$id'");
    
    $del_sal=mysql_query("update lms_book_snumber set status='1' where b_id='$id'");
    
	header("location:book_details_list.php?msg=delete_succ");
}
else
{
	header("location:book_details_list.php?msg=err&err_msg=$err_msg");
}
}
?>

 
<? ob_flush(); ?>