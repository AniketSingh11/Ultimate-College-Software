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
  <link rel="stylesheet" href="skippr/css/jquery.skippr.css">
  <!-- end CSS-->
  
  <!-- Fonts -->
  <link href="//fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
<style type="text/css">

::-webkit-scrollbar {
    display: none;
}
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
html, body {
  height: 100%;
  width: 100%;
  -webkit-font-smoothing: antialiased;
  font-family: "Helvetica Neue", "HelveticaNeue", "Helvetica-Neue", Helvetica, Arial, sans-serif; }

.yellow {
  background-color: #ffdb56;
  overflow:auto;}
.green {
  background-color: #55FF88;
  overflow:auto;}
.red {
  background-color: #FF5575;
  overflow:auto;}    
.orange {
  background-color: #FFB955;
  overflow:auto;
  }
.pick {
  background-color: #FF55C9;
  overflow:auto;
  }  
.blue {
  background-color: #8498F9;
  overflow:auto;
  }
    
.btn {
  width: 200px;
  height: 55px;
  border: 2px solid white;
  color: white;
  -webkit-transition: all 0.25s ease;
  -moz-transition: all 0.25s ease;
  transition: all 0.25s ease;
  cursor: pointer;
  line-height: 220%; }
  .btn:hover {
    background-color: white;
    color: #ffdb56; }

.hero {
  width: 100%;
  height: 80%;
  min-height: 500px;
  position: relative; }
  .hero .container {
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    width: 80%;
    height: 80%;
    z-index: 999; }
  .hero .tagline {
    font-family: "Helvetica Neue", "HelveticaNeue", "Helvetica-Neue", Helvetica, Arial, sans-serif;
    font-weight: bold;
    letter-spacing: -3px;
    width: 40%;
    padding: 8% 0 0 0;
    float: left;
    color: white; }
    .hero .tagline p {
      font-size: 4rem;
      line-height: 4rem;
      margin-top: 10px; }
      @media (max-width: 1450px) {
        .hero .tagline p {
          font-size: 2.8rem;
          line-height: 2.8rem;
          letter-spacing: -2px; } }
      @media (max-width: 600px) {
        .hero .tagline p {
          font-size: 2rem; } }
    .hero .tagline h1 {
      font-weight: bold;
      font-size: 7rem;
      letter-spacing: -0.25rem;
      line-height: 7rem; }
      @media (max-width: 1450px) {
        .hero .tagline h1 {
          font-size: 5rem;
          line-height: 5rem; } }
    @media (max-width: 1450px) {
      .hero .tagline {
        padding: 9% 0 0 0; } }
    @media (max-width: 800px) {
      .hero .tagline {
        float: none;
        width: 100%;
        margin-bottom: 70px; } }
  .hero .downloads {
    float: right;
    width: 40%;
    color: white;
    font-family: "Helvetica Neue", "HelveticaNeue", "Helvetica-Neue", Helvetica, Arial, sans-serif;
    font-weight: bold;
    letter-spacing: -1px;
    font-size: 1.5rem;
    height: 100%;
    position: relative; }
    .hero .downloads .btn-container {
      position: absolute;
      left: 50%;
      top: 50%;
      -webkit-transform: translate(-50%, -50%);
      -moz-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      -o-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      width: 100%; }
      .hero .downloads .btn-container .btn {
        float: right;
        text-align: center;
        margin-left: 20px; }
        @media (max-width: 800px) {
          .hero .downloads .btn-container .btn {
            float: left;
            margin: 20px 20px 0 0; } }
    @media (max-width: 800px) {
      .hero .downloads {
        float: none;
        width: 100%;
        height: auto; } }

.content {
  width: 80%;
  height: auto;
  margin: 0 auto;
  color: #464646;
  letter-spacing: -1px;
  padding: 75px 0 75px 0; }
  .content h2 {
    font-size: 3rem;
    font-weight: bold;
    margin: 0 0 10px 0; }
  .content p {
    font-size: 1.4rem;
    font-weight: normal; }
  .content code {
    display: block;
    min-height: 100px;
    width: 100%;
    margin: 20px 0 20px 0;
    padding: 10px 0; }

code {
  background-color: #464646;
  color: #ffdb56;
  font-size: 1rem; }
  @media (max-width: 800px) {
    code {
      font-size: .8rem; } }
  @media (max-width: 600px) {
    code {
      font-size: .5rem; } }

#code-header {
  margin-bottom: 0px; }

#code-footer {
  margin-top: 0px; }

.code-comment {
  font-style: italic;
  color: gray; }

hr {
  margin: 50px 0; }

.download {
  position: relative;
  width: 100%;
  height: 250px;
  background-color: #ffdb56;
  margin-top: 100px;
  color: white;
  font-weight: bold;
  letter-spacing: -1px;
  font-size: 1.5rem; }
  .download h1 {
    font-weight: bold;
    font-size: 7rem;
    letter-spacing: -0.25rem;
    line-height: 7rem; }
    @media (max-width: 1450px) {
      .download h1 {
        font-size: 5rem;
        line-height: 5rem; } }
  .download .btn {
    text-align: center; }
  .download > div {
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    width: 80%; }
    .download > div > * {
      float: left; }
    .download > div .btn-container {
      width: 500px;
      float: right;
      margin-top: 10px; }
      .download > div .btn-container .btn {
        float: right;
        margin-left: 20px; }
  @media (max-width: 800px) {
    .download {
      display: none; } }

footer {
  width: 100%;
  height: 400px;
  background-color: #464646;
  position: relative; }
  footer .info {
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    font-size: 1.25rem;
    letter-spacing: -1px; }
    footer .info a {
      color: white; }

.new-option {
  background-color: #e74c3c;
  color:white;
  font-weight:bold;
  padding: 0px 7px 3px 7px;
  margin-right:5px;
}

</style>
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="random">
<?php 

/*$a=array("red","green");
array_push($a,"blue","yellow");
print_r($a);
$already=0;
foreach ($a as &$value) {
    if($value=="red1"){
		$already=1;
	}
}
echo $already;*/
					
					$a=array();
					$already=0;
					$colorclass=array("yellow","green","red","orange","pick","blue"); 
							$topsubjectlist=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
			  while($topsubject=mysql_fetch_array($topsubjectlist))
        		{
					$stid=$topsubject['st_id'];
					
					$topsubjectlist1=mysql_query("SELECT * FROM subject WHERE st_id=$stid AND ay_id=$acyear");
			  while($topsubject1=mysql_fetch_array($topsubjectlist1))
        		{
					$cid1=$topsubject1['c_id'];
					$sid1=$topsubject1['s_id'];
					
					$checking=$cid1."-".$sid1;
					
					foreach ($a as &$value) {
						if($value==$checking){
							$already=1;
						}
					}
					
					if(!$already){					
					array_push($a,$cid1."-".$sid1);
					$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $section=mysql_fetch_array($sectionlist);	
					
					?>
                <div class="<?php echo $colorclass[array_rand($colorclass)];?>">
                <div align="center" id="printablediv" >  <!-- ImageReady Slices (Bonafide(1).jpg) -->
 						<div id="invoice" class="widget widget-plain">	
						<div class="block-content-invoice1" style="border:none;">
                        <center><h2><?php echo $class['c_name']."-".$section['s_name'];?> TimeTable</h2>
                        <?php 
					$qrye=mysql_query("SELECT * FROM day WHERE ay_id=$acyear");
					$d_total=mysql_num_rows($qrye);
					$ttlist=mysql_query("SELECT * FROM timetable_timing WHERE c_id='$cid1' AND b_id='$bid' AND ay_id='$acyear'"); 
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
								  
					$timelist1=mysql_query("SELECT * FROM timetable WHERE c_id=$cid1 AND s_id=$sid1 AND b_id=$bid AND ay_id=$acyear"); 
								   $timetable1=mysql_fetch_array($timelist1);	
					  ?>
						<table id="table-example" class="table1" style="background:#FFFFFF;" >
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
								   $timelist=mysql_query("SELECT * FROM timetable WHERE c_id=$cid1 AND s_id=$sid1 AND d_id=$did AND b_id=$bid AND ay_id=$acyear"); 
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
<br><br><br>
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
							$qry=mysql_query("SELECT * FROM subject WHERE c_id=$cid1 AND s_id=$sid1 AND ay_id=$acyear");
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
                
                </div>
                <?php } $already=0; } } ?>
            </div>
            

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="skippr/js/jquery.skippr.js"></script>
        <script>
            $(document).ready(function() {
                $("#random").skippr();
            });
        </script>
</body></html>