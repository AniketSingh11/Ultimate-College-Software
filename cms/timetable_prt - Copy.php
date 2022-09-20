<?php 
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
include("checking_page/timetable_management.php");

$cid=$_GET['cid'];
$sid=$_GET['sid'];
$bid=$_GET['bid'];		
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>School Management Solution</title>
<html
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<link rel="stylesheet" href="css/style.css"> <!-- Generic style (Boilerplate) -->
  <link rel="stylesheet" href="css/960.fluid.css"> <!-- 960.gs Grid System -->
  <link rel="stylesheet" href="css/lists.css"> <!-- Lists, optional -->
  <link rel="stylesheet" href="css/forms.css"> <!-- Forms, optional -->
  <link rel="stylesheet" href="css/tables.css"> <!-- Tables, optional -->
  <!-- end CSS-->
  
  <!-- Fonts -->
  <link href="//fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
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
    margin-top:-362px;
	height:200px;
	margin-left:-960px !important;
   
  }
  .block-content-invoice1{
	  width:1000px;
	  margin:30px
		border-radius: 3px;
		position: relative;
		padding: 10px 0;
		border: 2px solid #a9a6a6;
		  }
</style>
 						<div id="invoice" class="widget widget-plain">	
						<div class="block-content-invoice1" style="border:none;">
                        <center><h2><?php echo $class['c_name']."-".$section['s_name'];?> TimeTable</h2>
                        <?php 
					$qrye=mysql_query("SELECT * FROM day WHERE ay_id=$acyear");
					$d_total=mysql_num_rows($qrye);
					$ttlist=mysql_query("SELECT * FROM timetable_timing WHERE c_id='$cid' AND b_id='$bid' AND ay_id='$acyear'"); 
								  $ttiming=mysql_fetch_array($ttlist);
								  if($ttiming){
									$stime=$ttiming['s_time'];
									$duration=$ttiming['duration'];
									$p_total=$ttiming['p_total'];
									$b1_time=$ttiming['b1_time'];
									$b1_period=$ttiming['b1_period'];
									$b2_time=$ttiming['b2_time'];
									$b2_period=$ttiming['b2_period'];
									$lunch_time=$ttiming['lunch_time'];
									$lunch_period=$ttiming['lunch_period1'];
									$ds_time=$ttiming['ds_time'];
									$ds_period=$ttiming['ds_period'];
									 $p_total1=$p_total;
									if($b1_period){
										$p_total1++;
									}if($b2_period){
										$p_total1++;
									}if($lunch_period){
										$p_total1++;
									}if($ds_period){
										$p_total1++;
									}
								  }else {
									$dttlist=mysql_query("SELECT * FROM timetable_timing WHERE c_id='0' AND b_id='0' AND ay_id=$acyear"); 
								  $dttiming=mysql_fetch_array($dttlist);
								    $stime=$dttiming['s_time'];
									$duration=$dttiming['duration'];
									$p_total=$dttiming['p_total'];
									$b1_time=$dttiming['b1_time'];
									$b1_period=$dttiming['b1_period'];
									$b2_time=$dttiming['b2_time'];
									$b2_period=$dttiming['b2_period'];
									$lunch_time=$dttiming['lunch_time'];
									$lunch_period=$dttiming['lunch_period1'];
									$ds_time=$dttiming['ds_time'];
									$ds_period=$dttiming['ds_period'];
									$p_total1=$p_total;
									if($b1_period){
										$p_total1++;
									}if($b2_period){
										$p_total1++;
									}if($lunch_period){
										$p_total1++;
									}if($ds_period){
										$p_total1++;
									}
								  }
								  
					$timelist1=mysql_query("SELECT * FROM timetable WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear"); 
								   $timetable1=mysql_fetch_array($timelist1);	
					  ?>
						<table id="table-example" class="table1" >
							<thead style="border-top:1px solid #B0B0B0;">
								<tr>
                                	<th>Day</th>
                                	<?php
									$b1_period1=$b1_period;
									$b2_period1=$b2_period;
									$lunch_period1=$lunch_period;
									$ds_period1=$ds_period;
									$period=1;
									 $p_total1;
									 $selectedTime = $stime;
									  for($i=1;$i<=$p_total1;$i++){ 
									 $duration1="+".$duration." minutes";									
									 $endTime = strtotime("$duration1", strtotime($selectedTime));
									  ?>
									<?php if($period==$b1_period1+1){?>
                                    <th></th>
                                    <?php $b1_period1=0;
									$duration2="+".$b1_time." minutes";
									$endTime = strtotime("$duration2", strtotime($selectedTime));
									$selectedTime=date('h:i:s A', $endTime);
									 } elseif($period==$b2_period1+1){?>
                                    <th></th>
                                    <?php $b2_period1=0; 
									$duration3="+".$b2_time." minutes";
									$endTime = strtotime("$duration3", strtotime($selectedTime));
									$selectedTime=date('h:i:s A', $endTime);
									} elseif($period==$lunch_period1+1){ ?>
                                    <th></th>
                                    <?php $lunch_period1=0;
									$duration4="+".$lunch_time." minutes";
									$endTime = strtotime("$duration4", strtotime($selectedTime));
									$selectedTime=date('h:i:s A', $endTime);
									 } elseif($period==$ds_period1+1){ ?>
                                    <th></th>
									<?php $ds_period1=0;
									$duration5="+".$ds_time." minutes";
									$endTime = strtotime("$duration5", strtotime($selectedTime));
									$selectedTime=date('h:i:s A', $endTime);
									}else{ ?>
                                    <th class="vertical1"><center><?php echo $period;?> <br><span style="font-size:10px;">( <?php echo date('h:i A',strtotime($selectedTime));?> TO <br><?php echo date('h:i A', $endTime);?> )</span></center></th>
                                     <?php $period++; 
									 $selectedTime=date('h:i:s A', $endTime); } } ?>
								</tr>
							</thead>
							<tbody>
								<tr class="gradeX">
									<td></td>
                                 <?php
									$period=1;
									  for($i=1;$i<=$p_total1;$i++){ 
									  ?>
									<?php if($period==$b1_period+1){?>
                                    <td class="vertical" rowspan="<?php echo $d_total+1; ?>"><strong>Break</strong></td>
                                    <?php $b1_period=0; } elseif($period==$b2_period+1){?>
                                    <td class="vertical" rowspan="<?php echo $d_total+1; ?>"><strong>Break</strong></td>
                                    <?php $b2_period=0; } elseif($period==$lunch_period+1){ ?>
                                    <td class="vertical" rowspan="<?php echo $d_total+1; ?>"><strong>Lunch</strong></td>
                                    <?php $lunch_period=0; } elseif($period==$ds_period+1){ ?>
                                    <td class="vertical" rowspan="<?php echo $d_total+1; ?>" style="z-index:1;"><strong>Dairy Sign</strong></td>
									<?php }else{ ?>
                                    <td></td>
                                     <?php $period++; } } ?>
								</tr>
                                <?php 
							$qry=mysql_query("SELECT * FROM day WHERE ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					 $did=$row['d_id'];
					//die();
								   $timelist=mysql_query("SELECT * FROM timetable WHERE c_id=$cid AND s_id=$sid AND d_id=$did AND b_id=$bid AND ay_id=$acyear"); 
								   $timetable=mysql_fetch_array($timelist);	
								   if($timetable){
									   $tt_id=$timetable['tt_id'];
								   $p1=$timetable['p1'];
								   $p2=$timetable['p2'];
								   $p3=$timetable['p3'];
								   $p4=$timetable['p4'];
								   $p5=$timetable['p5'];
								   $p6=$timetable['p6'];
								   $p7=$timetable['p7'];
								   $p8=$timetable['p8'];
								   $peroid = array($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8);
								   //echo $peroid[3];
								  
								  
					?>
                                <tr class="gradeC">
                                	<td class="hover"><?php echo $row['d_name'];?></td>
                                    <?php  for($i=0;$i<8;$i++){
									  $subid=$peroid[$i];
									  $timeli=mysql_query("SELECT * FROM subject WHERE sub_id='$subid'"); 
									  $row2=mysql_fetch_array($timeli);
									  //die();
									  $slid=$row2['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
									  if($row2){ ?>
                                      <td class="hover"><?php echo $slist['s_name'];?></td>
                                      <?php }else{
									   $qry1=mysql_query("SELECT * FROM extraperoid WHERE ep_code='$subid'");
									   $row1=mysql_fetch_array($qry1); ?>
                                    <td class="hover"><?php echo $row1['ep_name'];?></td>
                                    <?php } } ?>                                                                   
								</tr>
                                <?php } } ?>                                                              						
							</tbody>
                            <tr><td colspan="13"></td></tr> 
						</table>                        
                  <br><br>
                  <table id="table-example" class="table">
							<thead>
								<tr>
									<th width="10%">S.No</th>
                                    <th><center>Subject Code</center></th>
                                    <th><center>Subject Name</center></th>
                                    <th><center>Staff Name</center></th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$stid=$row['st_id'];
					$slid=$row['sl_id'];
								   $subjectlist=mysql_query("SELECT * FROM subjectlist WHERE sl_id=$slid"); 
								   $slist=mysql_fetch_array($subjectlist);
								   $stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								   $staff=mysql_fetch_array($stafflist);	
								   $paper=$slist['paper'];
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td width="150px"><center><?php echo $slist['s_code'];?></center></td>
                                <td><center><?php echo $slist['s_name']; if($paper==1){ echo " (Two Paper) ";}?></center></td>
                                <td><center><?php if($stid){ echo $staff['fname']." ".$staff['mname']." ".$staff['lname'];}else {echo '-';} ?></center></td>
                              
								</tr> 
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
			</div>
            </div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>

</body></html>