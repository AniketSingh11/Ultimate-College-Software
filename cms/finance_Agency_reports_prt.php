<?php 
include("includes/config.php");
error_reporting(E_ALL ^ E_NOTICE);

session_start();

$check=$_SESSION['email'];

$sacyear=$_SESSION['acyear'];

if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_assoc($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_assoc($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];


$syear=$ay['s_year'];
$eyear=$ay['e_year'];
 

if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}

if(!isset($check))

{
	
header("Location:404.php");

}
							$contid=$_GET['contid'];
							$conduct=mysql_query("SELECT * FROM conduct WHERE con_id=$contid"); 
							//$row=mysql_fetch_assoc($conduct);
					
?>
<?php include 'print_header.php';?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
function hide_button(){
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
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="margin-top:2%;">
<div style="float:right;" id="print"> 
<b style="color:red;"><input  type="checkbox" <?php if($_GET['show']=="hide"){?>checked="checked" <?php }?> name="show" id="show" value="full">Without Background</b>
<b style="color:red;"><input  type="checkbox" <?php if($_GET['lastyear']){?>checked="checked" <?php }?> name="lastyear" id="lastyear" value="1">With Lastyear Pending</b>
<a onclick="hide_button();"  title="Print this certificate">
<img src="img/printer.png" style="margin-top:-30%; margin-bottom:-20%;"></a><br>
Agency: 
<?php
$gaid=$_GET['aid'];
$lastyear=$_GET['lastyear'];
$classl = "SELECT a_id,a_name FROM agency WHERE status=0 ORDER BY a_name ASC";
			$result1 = mysql_query($classl) or die(mysql_error());
			echo '<select name="type" id="show1" >';
			echo "<option value=''>All</option>\n";
			while ($row1 = mysql_fetch_assoc($result1)):
			if($row1['a_id']==$gaid){
				echo "<option value='{$row1['a_id']}' selected>{$row1['a_name']}</option>\n";
			}else{
				echo "<option value='{$row1['a_id']}'>{$row1['a_name']}</option>\n";
			}
			endwhile;
			echo '</select>';
			?><br><a href="finance_agency_excel.php?aid=<?php echo $gaid; ?>&lastyear=<?php echo $lastyear; ?>" style="background: #6DA42B;
    background: -moz-linear-gradient(top, #CAE0B0 0%, #A6CB7A 2%, #6DA42B 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#CAE0B0), color-stop(2%,#A6CB7A), color-stop(100%,#6DA42B));
    background: -webkit-linear-gradient(top, #CAE0B0 0%, #A6CB7A 2%,#6DA42B 100%);
    background: -o-linear-gradient(top, #CAE0B0 0%, #A6CB7A 2%,#6DA42B 100%);
    background: -ms-linear-gradient(top, #CAE0B0 0%, #A6CB7A 2%,#6DA42B 100%);
    background: linear-gradient(top, #CAE0B0 0%, #A6CB7A 2%,#6DA42B 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#A6CB7A', endColorstr='#6DA42B');
    border-color: #888;font-size: 13px;
    padding: 8px 12px;background-repeat: repeat-x;
    background-position: 0 0;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    line-height: normal;
    color: #FFF;
    display: inline-block;
    margin: 0;
    position: relative;
    border: none;
    border-width: 1px;
    border-style: solid;
    cursor: pointer;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    text-shadow: 1px 1px 1px rgba(0,0,0,.25);
    -moz-box-shadow: 1px 1px 1px rgba(0,0,0,.25);
    -webkit-box-shadow: 1px 1px 1px rgba(0,0,0,.25);
    box-shadow: 1px 1px 1px rgba(0,0,0,.25);
    -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.3);
    -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.3);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.3);
" target="_blank" class="btn btn-green">Download Excel</a></div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->  
<style type="text/css">
  img.adjusted {
    position: absolute;
    z-index: -1;
    width: 100%;   
  }
  .Invitation {
    position: relative;
    width: 950px;
    margin-top:-360px;
	height:400px;
	margin-left:-960px !important;
  }
  .financetable
  {
	border-collapse:collapse;
	text-align:center;  
  }
  /*.financetable th, td 
  {
	  padding:5px;
  }*/
</style>
 <?php if($_GET['show']!="hide"){?>
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
 <?php }?>

  <?php 
				$contid=$_GET['contid'];
				$conduct=mysql_query("SELECT * FROM conduct WHERE con_id=$contid"); 
							//$row=mysql_fetch_assoc($conduct);
					
  ?>
<div style="max-height:500px;">
<h2 style="line-height:46px; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:30px;">AGENCY WISE FINANCE REPORTS</h2>
<table class="financetable" width="100%" border="1" cellpadding="0" cellspacing="0" id="Table_01">
   <tr>
   <th>S.No</th>
   <th>Agency</th>
   <th>Bill Details</th>
   </tr>
   <?php 
   					$totalbill=0;
   					$totalamount=0;
					$totalcbill=0;
					$totalcamount=0;
					$totalpamount=0;
					$qery="SELECT a_id,a_name FROM agency";
					if($gaid){
						$qery .=" WHERE a_id=$gaid";
					}
					$qery .=" ORDER BY a_name ASC";
   $agencylist=mysql_query($qery);
							$count=1;
			  while($agency=mysql_fetch_assoc($agencylist))
        		{
					
					$tamount=0;
					$tcbill=0;
					$tcamount=0;
					$tpamount=0;					
							$aid=$agency['a_id'];							
							$qry2="SELECT distinct a.* FROM exponses a LEFT JOIN exponses_bill_summary b ON a.ex_id = b.ex_id AND b.ay_id=$acyear WHERE (a.ay_id=$acyear OR b.ay_id=$acyear";
							if($lastyear){
								$qry2 .=" OR (a.ay_id<$acyear AND status=0))";
							}else{
								$qry2 .=")";
							}
							if($aid){
								$qry2 .=" AND a.aid=$aid";
							}
							$qry2 .=" ORDER BY a.ex_id DESC";
							$qry=mysql_query($qry2);
							$excount=mysql_num_rows($qry);
					if($excount>0){		
			  ?>
   <tr>
   <td><?=$count?></td>
   <td><?=$agency['a_name']?></td>
   <td>
   <table border="1" width="100%" style="border-collapse:collapse;">
   <tr>
   <th>Bill No</th>
   <th>Date</th>
   <th>Amount</th>
   <th>Closed Date</th>
   <th>Closed Amount</th>
   <th>Pending Amount</th>
   </tr>
   <?php while($row=mysql_fetch_assoc($qry))
        		{
					$aid1=$row['aid'];
					$exid=$row['ex_id'];
					$excid1=$row['exc_id'];
					$exsid1=$row['exs_id'];
					$status=$row['status']; 
					$type=$row['type']; 
					$cdate="";
					$camount="";
					$pending="";
					$epid="";
					$cayid=$row['ay_id'];
					
						$ayear1=mysql_query("SELECT e_year FROM year WHERE ay_id='$cayid'");
						$ay1=mysql_fetch_assoc($ayear1);
						$myarray = array();
						$ceyear=$ay1['e_year'];
						$ayear2=mysql_query("SELECT ay_id FROM year WHERE (e_year>='$ceyear' AND e_year<='$eyear')");
						while($ay2=mysql_fetch_assoc($ayear2)){
							array_push($myarray,$ay2['ay_id']);	
						}
						$amount=$row['amount'];
					if(!$amount){
						$amount=0;
					}
					?>
   <tr>
   <td><?php echo $row['r_no']; ?></td>
   <td><?php echo $cdate=$row['date_day']."/".$row['date_month']."/".$row['date_year']; ?></td>
   <td>Rs.<?php echo number_format($amount,2); ?></td>
   <td><?php if($type=="0"){ $cdate=$row['date_day']."/".$row['date_month']."/".$row['date_year']; if($cdate){ echo $cdate; $tcbill++; }else { echo "-";}}else{ 
   		if($status=='1'){
			$exsam1=mysql_query("SELECT ep_id FROM exponses_bill_summary WHERE ex_id=$exid ORDER BY ep_id DESC"); 
							$exsamry1=mysql_fetch_assoc($exsam1);
							$epid1=$exsamry1['ep_id'];
							if($epid1){
								$bexsam1=mysql_query("SELECT date_day,date_month,date_year FROM exponses_bill WHERE ep_id=$epid1"); 
								$bexsamry1=mysql_fetch_assoc($bexsam1);
									$cdate=$bexsamry1['date_day']."/".$bexsamry1['date_month']."/".$bexsamry1['date_year'];
							 }
		}else{
			$cdate="";
		}
		if($cdate){ echo $cdate; $tcbill++; }else { echo "-";}
   }
   ?> </td>
   <td><?php if($type==0){ 
   								$camount=$row['amount'];
							  	
								if($camount){ echo "Rs.".number_format($camount,2); $tcamount +=$camount; }else { echo "-";}}else{
									
								//$exsam=mysql_query("SELECT * FROM exponses_bill_summary WHERE ex_id=$exid AND ay_id=$acyear");
								$exsam=mysql_query("SELECT * FROM exponses_bill_summary WHERE ex_id=$exid");
							$exbillcounts =mysql_num_rows($exsam);
							 if($exbillcounts=='0'){ echo "-"; }
							 else if($exbillcounts=='1' && $status=='1'){
									 $exsamry=mysql_fetch_assoc($exsam);
								$epid=$exsamry['ep_id'];
								if($epid){
									$bexsam=mysql_query("SELECT * FROM exponses_bill WHERE ep_id=$epid"); 
									$bexsamry=mysql_fetch_assoc($bexsam);
										$cdate=$bexsamry['date_day']."/".$bexsamry['date_month']."/".$bexsamry['date_year'];
										$camount=$row['amount'];
										$pending=0;
								 }
								 echo "Rs.".number_format($camount,2);
								 $tcamount +=$camount;
							 }else{
							 ?>
   		<table border="1" width="100%" style="border-collapse:collapse;">
   <tr>
   <th>Date</th>
   <th>Amount</th>
   </tr>
   <?php 
  	 while($exsamry=mysql_fetch_assoc($exsam)){
								$epid=$exsamry['ep_id'];
								if($epid){
									$bexsam=mysql_query("SELECT * FROM exponses_bill WHERE ep_id=$epid"); 
									$bexsamry=mysql_fetch_assoc($bexsam);
										$cdate=$bexsamry['date_day']."/".$bexsamry['date_month']."/".$bexsamry['date_year'];
										$camount=$exsamry['amount'];
										$tcamount +=$camount;
								 } ?>
   <tr>
   <td><?=$cdate?></td>
   <td><?php echo "Rs.".number_format($camount,2);?></td>
   </tr>
   <?php } ?>
   </table>
   <?php } }
   $tamount +=$row['amount']; ?>
   </td>
   <td><?php  
   				$totalpayamount=0;
			if(!empty($myarray)){
   				$qry12=mysql_query("SELECT amount FROM exponses_bill_summary WHERE ex_id=$exid AND ay_id IN (".implode(',',$myarray).") ");
			  while($row12=mysql_fetch_array($qry12))
        		{
					$totalpayamount+=$row12['amount'];
				}
				}
				$pending=$row['pending'];
				if($totalpayamount){
					$pending=$row['amount']-$totalpayamount;
				}
				if(!$pending && $status=="0"){
					$pending=$row['amount'];
				}
   	if($pending){ echo "Rs.".number_format($pending,2);  $tpamount +=$pending;}else { echo "-";}?></td>
   </tr>
   <?php } ?>
   <tr>
   <td>
   <table width="100%">
   <tr><td><b>No.B:</b></td><td><b><?=$excount?></b></td></tr>
   </table>
   </td>
   <td>
   <table width="100%">
   <tr><td><b>No.D:</b></td><td><b><?=$excount?></b></td></tr>
   </table>
   </td>
   <td>
   <table width="100%">
   <tr><td><b>T:</b></td><td><b>Rs.<?php echo number_format($tamount,2); ?></b></td></tr>
   </table>
   </td>
   <td>
   <table width="100%">
   <tr><td><b>No.CB:</b></td><td><b><?=$tcbill?></b></td></tr>
   </table>
   </td>
   <td>
   <table width="100%">
   <tr><td><b>C.T:</b></td><td><b>Rs.<?php echo number_format($tcamount,2); ?></b></td></tr>
   </table>
   </td>
   <td>
   <table width="100%" >
   <tr><td><b>P.T:</b></td><td><b>Rs.<?php echo number_format($tpamount,2); ?></b></td></tr>
   </table>   
   </td>
   </tr>
   </table>
   </td>
   </tr>
   <?php $totalbill +=$excount;
   					$totalamount +=$tamount;
					$totalcbill +=$tcbill;
					$totalcamount +=$tcamount;
					$totalpamount +=$tpamount; $count++; } } ?>
   <tr>
   <td colspan="2"><b>Overall Details</b></td>
   <td>
   <table border="1" width="100%" style="border-collapse:collapse;">
    <tr>
   <td>
   <table width="100%">
   <tr><td><b>No.B:</b></td><td><b><?=$totalbill?></b></td></tr>
   </table>
   </td>
   <td>
   <table width="100%">
   <tr><td><b>No.D:</b></td><td><b><?=$totalbill?></b></td></tr>
   </table>
   </td>
   <td>
   <table width="100%">
   <tr><td><b>T:</b></td><td><b>Rs.<?php echo number_format($totalamount,2); ?></b></td></tr>
   </table>
   </td>
   <td>
   <table width="100%">
   <tr><td><b>No.CB:</b></td><td><b><?=$totalcbill?></b></td></tr>
   </table>
   </td>
   <td>
   <table width="100%">
   <tr><td><b>C.T:</b></td><td><b>Rs.<?php echo number_format($totalcamount,2); ?></b></td></tr>
   </table>
   </td>
   <td>
   <table width="100%" >
   <tr><td><b>P.T:</b></td><td><b>Rs.<?php echo number_format($totalpamount,2); ?></b></td></tr>
   </table>   
   </td>
   </tr>
   </table>
   </td>
   </tr>
</table>
</div>
</div>
 <script>
$().ready(function() {
	$("#show").change(function(){
		if(this.checked) {	 
		window.location.href='finance_Agency_reports_prt.php?lastyear=<?=$lastyear?>&aid=<?=$gaid?>&show=hide';
		}else{
			window.location.href='finance_Agency_reports_prt.php?lastyear=<?=$lastyear?>&aid=<?=$gaid?>&show=show';
		}	
	});	
	$("#lastyear").change(function(){
		if(this.checked) {
		window.location.href='finance_Agency_reports_prt.php?lastyear=1&aid=<?=$gaid?>';
		}else{
			window.location.href='finance_Agency_reports_prt.php?aid=<?=$gaid?>';
		}	
	});	
	$("#show1").change(function(){
		var a=this.value;
		window.location.href='finance_Agency_reports_prt.php?lastyear=<?=$lastyear?>&aid='+a;
	});	
});
 	 
</script>
</body></html>