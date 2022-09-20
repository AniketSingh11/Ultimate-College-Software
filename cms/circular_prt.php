<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("includes/config.php");

session_start();

$check=$_SESSION['email'];

$query=mysql_query("select email,id from admin_login where email='$check' ");

$data=mysql_fetch_array($query);

$email=$data['email'];
$adminid=$data['id'];
$user=$_SESSION['uname'];

$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}

if(!isset($email))
{
	
header("Location:404.php");
}
 
$ex_id=$_GET['exid'];	
?>
<?php include 'print_header.php';?>
<style>
.ctable
{
	width:100%; border-collapse:collapse; margin:0px auto;
}
.ctable td
{
	padding-left:10px;
}
</style>
<html
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 
<script>
function hide_button(){
     document.getElementById('print').style.visibility='hidden';
	 document.getElementById('print').style.display='none';
     window.print();
     document.body.onmousemove = doneyet;
}

/*function download_doc(ano){
	
	var url = 'http://localhost/Erp_School/'+'admin/download_cert?id='+ano+'&type=bonafide';
	window.open(url,'_blank');
}
function doneyet()
{
  document.getElementById('butt').style.visibility='visible';
}*/
</script> 
     <?php 
					$count=1;
					$qry5=mysql_query("SELECT * FROM circular WHERE cl_id=$_GET[clid]");
			  $row5=mysql_fetch_array($qry5);
			  
			  $title=$row5['title'];
			  $desc=$row5['descript'];
			  
			  $type=$row5['type'];
			  $c_id=$row5['c_id'];
			  $sectionlist=mysql_query("SELECT * FROM class WHERE c_id=$c_id");
			  $section=mysql_fetch_array($sectionlist);
			  $class_name=$section["c_name"];
			  
			  $s_id=$row5['s_id'];
        			?>
 		<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png" style="margin-top:-30%; margin-bottom:-20%;"></a></div>
<div   id="printablediv" style="font-size:22px; line-height:22px;">


<center>
 <div style="width:236mm; margin:0px; height:40.1mm; min-height:40.1mm; border-bottom:2px solid #01a8ff; padding-bottom:20px; display:inline-block;" id="Table_01">
                            <div style="text-align:left; width:50.00mm; float:left;">
                                <div><img src="img/logo1.png" width="160px" height="160px"></div>
                            </div>
                            <div style="text-align:center;width:185.75mm; float:left; padding-top:25px;">
                                <h5 style="padding:0px; padding-bottom:3px; margin:0px; letter-spacing:2px; color:red; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:46px; ; font-weight:bold;">SCHOOL/COLLEGE MANAGEMENT SYSTEM</h5>

                                <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-weight:bold; font-size:18px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Hetauda, Nepal</h5>
                               <!-- <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-size:16px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Contact : 044-32429897, 26790694, Email : christischool@gmail.com, Web: www.christschool.co.in</h5>-->
                            </div>
                        </div>
</center>
 
 <div style="width:100%; float:left; line-height:36px;">
<div style="float:left; width:50%; text-align:left; margin-left:5%; font-size:22px;"><?php echo "SPMS/".$row5['cl_year']."/".$row5['ref_number']; ?></div>
<div style="float:left; width:40%; text-align:right; margin-right:3%; font-size:22px;">Date: <?=$row5["cl_day"]."/".$row5["cl_month"]."/".$row5["cl_year"];?></div>
</div>
 
<!-- <b style="float:right;">Date : <?=$row5["cl_day"]."/".$row5["cl_month"]."/".$row5["cl_year"];?></b>
<b> Ref No : <?=$row5["ref_number"];?></b>
 <center><h3 class="title"><?php echo $title; ?></h3></center>-->
 <center><h2 style="line-height:46px;font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:30px;"><?php echo $title; ?></h2></center>
 <h3 style="line-height:32px;font-size:22px; font-weight: bold;">Circular to : <?php echo $row5["type"];?></h3>

    <?php echo $desc; ?>
            </div>            
		 
</body></html>