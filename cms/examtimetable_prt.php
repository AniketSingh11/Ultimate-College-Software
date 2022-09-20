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

$cid=$_GET['cid'];
$sid=$_GET['sid'];
$bid=$_GET['bid'];		
$eid=$_GET['eid'];
 $examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);
								  $classname=$class['c_name'];	
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
                        <center><h2><?php echo $class['c_name']; 
						if(($classname == 'XI STD') || ($classname == 'XII STD') || ($classname == 'XI') || ($classname == 'XII')){ 
						echo "-".$section['s_name']; }?> - <?php echo $exam['e_name'];?> Exam TimeTable</h2>
                    	<table id="table-example" class="table" style="border:1px solid #848282">
							<thead>
								<tr style="border-top:1px solid #848282">
									<th width="25px"><center>S.No</center></th>
                                    <th width="150px;"><center>Date (DD/MM/YYYY)</center></th>
                                    <th width="13%;"><center>Day</center></th>
                                    <th><center>Subject Name</center></th>                                    
                                    <th><center>Timing</center></th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							
							if(($classname == 'XI STD') || ($classname == 'XII STD') || ($classname == 'XI') || ($classname == 'XII')){
							$qry=mysql_query("SELECT * FROM examtimetable WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND b_id=$bid AND ay_id=$acyear");
							}else{
								$qry=mysql_query("SELECT * FROM examtimetable WHERE c_id=$cid AND e_id=$eid AND b_id=$bid AND ay_id=$acyear");
							}
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
						$slid=$row['sub_id'];
								   $subjectlist=mysql_query("SELECT * FROM subjectlist WHERE sl_id=$slid AND extra_sub=0"); 
								   $subject=mysql_fetch_array($subjectlist);	
						?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['date']; ?></center></td>
                                <td><center><?php echo $row['day']; ?></center></td>
                                <td><center><?php echo $subject['s_name']; ?></center></td>
                                <td><center><?php echo $row['ftime']." - ".$row['ttime']; ?></center></td>
                                </tr> 
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>                       
                  <br><br>
                  
			</div>
            </div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>

</body></html>