<? ob_start(); ?>
<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("includes/config.php"); 
session_start();

$date = date_default_timezone_set('Asia/Kolkata');

$check=$_SESSION['email'];

$query=mysql_query("select email,id from admin_login where email='$check' ");

$data=mysql_fetch_array($query);

$email=$data['email'];
$adminid=$data['id'];
$user=$_SESSION['uname'];

$sacyear=$_SESSION['acyear'];

if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

$syear=$ay['s_year'];
$eyear=$ay['e_year'];

if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:../timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}
if(!isset($check))
{	
header("Location:404.php");
}
include("checking_page/payroll.php");
$sacyear=$_SESSION['acyear'];
if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

$syear=$ay['s_year'];
$eyear=$ay['e_year'];

$bid=$_GET['bid'];
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
?>
<script>
function hide_button(){
     document.getElementById('print').style.visibility='hidden';
	 document.getElementById('print').style.display='none';
     window.print();
     document.body.onmousemove = doneyet;
}
</script>
  </head>
 <body style="background:#FFFFFF;">
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
  
<style type="text/css" media="all">
  img.adjusted {
    position: absolute;
    z-index: -1;
    width: 100%;
   
  }
  .Invitation {
    position: relative;
    width: 950px;
    margin-top:-362px;
	height:200px;
	margin-left:-960px !important;
   
  }
  .block-content-invoice1{
	  width:950px;
	  margin:30px
		border-radius: 3px;
		position: relative;
		padding: 10px;
		/*border: 2px solid #a9a6a6;*/
		  }
.table td, .table th
{
	padding:10px;
	text-align:center;
}
</style>
<?php $rid=$_GET['rid'];
			$date=$_GET['date'];
			$routename= "All ";
			$sdate_split1= explode('/', $date);		 
		  $sdate_day=$sdate_split1[0];
		  $sdate_month=$sdate_split1[1];
		  $sdate_year=$sdate_split1[2];
		  $startdate= $sdate_year.$sdate_month.$sdate_day; ?>
 						<div id="invoice" class="widget widget-plain">	
						<div class="block-content-invoice1">
                        
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
<h3>TODAY BOARDING POINT STUDENT COUNT (<?php echo $sdate_day."/".$sdate_month."/".$sdate_year; ?>)</h3>
	<?php
			
		  				if($rid!="all"){
									$classlist=mysql_query("SELECT r_name FROM route WHERE r_id=$rid"); 
								  	$class=mysql_fetch_assoc($classlist);
									$routename=$class['r_name'];
								}
				?>
                       <div class="modal-body">
        <table class="table" width="100%" cellpadding="0" cols="0" border="1" style="border-collapse:collapse;">
							<thead>
								<tr>
									<th>S.No</th>
									<th><center>Route Name</center></th>
                                    <th colspan="3"><center>Actual Total</center></th>
                                    <th><center>Boys</center></th>
                                    <th><center>Girls</center></th>
                                    <th><center>Total</center></th>
								</tr>
							</thead>
							<tbody>
                            <tr class="gradeX">
								<td class="sno center"></td>
								<td></td>
                                <td><center>Boys</center></td>
                                <td><center>Girls</td>
                                <td><center>Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <tr>
                            <?php 
							$atotal=0; $ttotal=0; $tboys=0; $tgirls=0; $tgirls=0; $totalboys=0; $totalgirls=0;
							$routeqry="SELECT r_id,r_name FROM route";
							if($rid!="all"){
								$routeqry .=" WHERE r_id=$rid";
							}
					$route=mysql_query($routeqry);
							$count=1;
			  while($rlist=mysql_fetch_assoc($route))
        		{		
							$rid1=$rlist['r_id'];
							$myarray = array();
								  $qry=mysql_query("SELECT * FROM trstopping WHERE r_id=$rid1 ORDER BY ListingID");
								  while($row=mysql_fetch_assoc($qry))
									{
										array_push($myarray,$row['stop_id']);										
									}
						$total=0; $boys=0; $girls=0; $totalstudent=0; $aboys=0; $agirls=0;			
							$qry=mysql_query("SELECT ss_id,gender,c_id,s_id,b_id FROM student WHERE sp_id IN (".implode(',',$myarray).") AND ay_id=$acyear ORDER BY FIND_IN_SET(sp_id, '".implode(',',$myarray)."')");
			  while($row=mysql_fetch_assoc($qry))
        		{
					$totalstudent++;
					$ssid=$row['ss_id'];
					$gender=$row['gender'];
					$cid=$row['c_id'];
				$sid=$row['s_id'];
						  $bid=$row['b_id'];
								    
						  $spid1=$row['sp_id'];
						  if($gender=="M"){
							$aboys++;
							}else if($gender=="F"){
								$agirls++;
							}
						  	  
						  $select_record2=mysql_query("SELECT att_id FROM attendance WHERE c_id=$cid AND s_id=$sid AND day=$sdate_day AND month=$sdate_month AND year=$sdate_year AND ay_id=$acyear AND ss_id=$ssid AND (result=1 OR (result='off' AND result_half='M'))");
					if($monthday=mysql_fetch_assoc($select_record2)){
						if($gender=="M"){
							$boys++;
						}else if($gender=="F"){
							$girls++;
						}
					}
				}
				$total=$boys+$girls;
				$atotal +=$totalstudent;
				$totalboys +=$aboys;
				$totalgirls +=$agirls;
				$ttotal +=$total;
				$tboys +=$boys;
				$tgirls +=$girls;
				?><tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $rlist['r_name']; ?></center></td>
                                <td><center><?php echo $aboys; ?></center></td>
                                <td><center><?php echo $agirls; ?></center></td>
                                <td><center><?php echo $totalstudent; ?></center></td>
                                <td><center><?php echo $boys;  ?></center></td>
                                <td><center><?php echo $girls; ?></center></td>
                                <td><center><?php echo $total; ?></center></td>
                                </tr>
                                 <?php 
					$count++;
					}?>             
                    		<tr class="gradeX">
								<td colspan="2"><center><b>Total</b></center></td>
                                <td><center><b><?php echo $totalboys; ?></b></center></td>
                                <td><center><b><?php echo $totalgirls; ?></b></center></td>
                                <td><center><b><?php echo $atotal; ?></b></center></td>
                                <td><center><b><?php echo $tboys;  ?></b></center></td>
                                <td><center><b><?php echo $tgirls; ?></b></center></td>
                                <td><center><b><?php echo $ttotal; ?></b></center></td> 
                                </tr>                																
							</tbody>
						</table>
      </div>
            </div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>


</body>
 </html>