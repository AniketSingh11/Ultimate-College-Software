<?php 
include("includes/config.php");
error_reporting(E_ALL ^ E_NOTICE);

session_start();

$check=$_SESSION['email'];

$query=mysql_query("select email from admin_login where email='$check' ");

$data=mysql_fetch_array($query);

$email=$data['email'];
$user=$_SESSION['uname'];
$sacyear=$_SESSION['acyear'];
if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);
}

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
	  $bid=mysql_real_escape_string($_GET['bid']);
	  $ayid=mysql_real_escape_string($_GET['ayid']);
	  
	  $boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$yearlist=mysql_query("SELECT * FROM year WHERE ay_id=$ayid"); 
								  $ayear=mysql_fetch_array($yearlist);	
								  
								  $acyear_name=$ayear['s_year']."-".substr($ayear['e_year'],-2);
?>
<?php include 'print_header.php';?>
 <link rel="stylesheet" href="css/idcard.css"> 
<style type="text/css">
/*.profile-table td{
	 border:1px solid #2D2D2D;
	 padding-left:10px;
}
.small{font-size:10px;}
.bgcolor{background-color:#D0D0D0;}
.column {
float: left;
    margin: 20px;
    padding-bottom: 1000px;
    margin-bottom: -1000px;
}*/
</style>    
</head>
<div style="position:absolute;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
<body id="printablediv" onload="hide_button();">
<?php 
$count=1;
	$classl = mysql_query("SELECT c_id,c_name FROM class WHERE b_id='$bid' AND ay_id='$ayid'");
	while ($class = mysql_fetch_assoc($classl)){
		$cid=$class['c_id'];
		$sectionlist=mysql_query("SELECT * FROM section WHERE c_id='$cid' AND ay_id='$ayid'");
	while ($section=mysql_fetch_assoc($sectionlist)){
				$sid=$section['s_id'];	
		$sql = "SELECT * FROM student where `c_id`='$cid' AND `s_id`='$sid' AND `b_id`='$bid' AND `ay_id`='$ayid'";
$query = mysql_query($sql);
	while($rs = mysql_fetch_array($query)) { 
		$string=$class['c_name'];
			if($string[0]=="G"){
			$gradename=str_replace("G","Grade ",$class['c_name']);
			}else{
				$gradename=$class['c_name'];
			}
			$spid=$rs['sp_id'];
			
			if($spid){
					 $qry6=mysql_query("SELECT stop_name FROM trstopping WHERE stop_id='$spid'"); 
								  $row6=mysql_fetch_array($qry6);
								  $stopname=$row6['stop_name'];
			}
			if(!$stopname){
				$stopname=" - ";
			}
		$studentname=$rs['firstname']." ".$rs['lastname'];
		if($count%4==1){
			echo '<div class="container">';		
		?>
        <div class="backcolumn-left">   		
        <div class="body-content">
        <div style="text-align:center; padding-top:180px; color:#012bff;"><span><b><?php //echo $acyear_name;?></b></span></div>
        </div>
   </div>
   <?php }else if($count%4==2){?>
        <div class="backcolumn-center">
   		<div class="body-content">
        <div style="text-align:center; padding-top:180px; color:#012bff;"><span><b><?php //echo $acyear_name;?></b></span></div>
        </div>
   </div>
   <?php }else if($count%4==3){?>
   <div class="backcolumn-right">
   		<div class="body-content">
        <div style="text-align:center; padding-top:180px; color:#012bff;"><span><b><?php //echo $acyear_name;?></b></span></div>
        </div>
   </div>
   <?php }else if($count%4==0){?>
   <div class="backcolumn-right">
   		<div class="body-content">
        <div style="text-align:center; padding-top:180px; color:#012bff;"><span><b><?php //echo $acyear_name;?></b></span></div>
        </div>
   </div>
        <?php
   }
		if($count%4==0){
			echo '</div> <div class="clearfix"></div>';		
		}
		
	$count++;
	}
	}
	}?>
</div>
</body>
<script type="text/javascript" src="js/jquery.js"></script>
<script>
function hide_button(){
     document.getElementById('print').style.visibility='hidden';
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
</html>