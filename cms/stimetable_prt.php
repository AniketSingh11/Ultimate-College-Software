<?php 
include("includes/config.php");

session_start();

$check=$_SESSION['email'];

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
?>
<?php include 'print_header.php';?>
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
	  width:950px;
	  margin:30px
		border-radius: 3px;
		position: relative;
		padding: 10px 0;
		border: 2px solid #a9a6a6;
		  }
</style>
 						<div id="invoice" class="widget widget-plain">	
						<div class="block-content-invoice1">
                        <center><h2>Staff : <?php echo $user;?> - TimeTable</h2>
                        <?php 
					$timelist1=mysql_query("SELECT * FROM timetable WHERE ay_id=$acyear"); 
								   $timetable1=mysql_fetch_array($timelist1);		
					  ?>
						<table id="table-example" class="table1" >
							<thead style="border-top:1px solid #B0B0B0;">
								<tr>
                                	<th width="100px">Day</th>
									<th>I</th>
									<th>II</th>
									<th></th>
									<th>III</th>
                                    <th>IV</th>
                                    <th></th>
                                    <th>V</th>
                                    <th>VI</th>
                                    <th></th>
                                    <th>VII</th>
                                    <th>VIII</th>
                                    <th></th>
								</tr>
							</thead>
							<tbody>
								<tr class="gradeX">
									<td></td>
                                    <td></td>
									<td></td>
                                    <td class="vertical" rowspan="6">Break</td>
									<td></td>
									<td></td>
                                    <td class="vertical" rowspan="6">Lunch</td>
                                    <td></td>
									<td></td>
                                    <td class="vertical" rowspan="6">Break</td>
                                    <td></td>
									<td></td>
                                    <td class="vertical" rowspan="6" style="z-index:1;">DairySign</td>
								</tr>
                                <?php 
							$qry=mysql_query("SELECT * FROM day WHERE ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					 $did=$row['d_id'];
					//die();
								  $timelist=mysql_query("SELECT * FROM timetable WHERE d_id=$did AND ay_id=$acyear"); 
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
                                	<td class="hover"><strong><?php echo $row['d_name'];?></strong></td>
                                    <?php  for($i=0;$i<8;$i++){
									  $subid=$peroid[$i];
									  $timeli=mysql_query("SELECT * FROM subject WHERE sub_id='$subid'"); 
									   $row2=mysql_fetch_array($timeli);
									   $slid=$row2['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);	
									  //die();
									  if($row2['st_id']==$stid){ 
									  	$cid=$row2['c_id'];
										$sid=$row2['s_id'];
										$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
									  ?>
                                      <td class="hover"><?php echo $class['c_name']."-".$section['s_name']."<br>(".$slist['s_name'].")";?></td>
                                      <?php } else{ ?>
								    <td class="hover">&nbsp;</td>
                                    <?php } } ?>                                                                   
								</tr>
                                <?php } } ?>                                                               						
							</tbody>
                            <tr><td colspan="13"></td></tr> 
                            <tr>
                                <td></td>
                                <td class="vertical1">9.30 AM - <br>10.10 AM</td>
                                <td class="vertical1">10.10 AM - <br>10.50 AM</td>
                                <td></td>
                                <td class="vertical1">11.00 AM  - <br>11.40AM</td>
                                <td class="vertical1">11.40 AM - <br>12.20 PM</td>
                                <td></td>
                                <td class="vertical1">1.00 PM - <br>1.40 PM</td>
                                <td class="vertical1">1.40 PM - <br>2.20 PM</td>
                                <td></td>
                                <td class="vertical1">2.30 PM - <br>3.10 PM</td>
                                <td class="vertical1">3.10 PM - <br>3.50 PM</td>
                                <td></td>
                                </tr> 
                                <tr><td colspan="13"></td></tr> 
						</table>                        
                  
			</div>
            </div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>

</body></html>