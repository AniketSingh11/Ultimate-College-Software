<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");  
?>
 <link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
</head>

<body id="top">

  <!-- Begin of #container -->
  <div id="container">
  	<!-- Begin of #header -->
    <?php include("includes/header.php");?>
    <!--! end of #header -->
    
    <div class="fix-shadow-bottom-height"></div>
	
	<!-- Begin of Sidebar -->
    <aside id="sidebar">
    	
    	<!-- Search -->
    	    	<?php include("includes/search.php"); ?>
 <!--! end of #search-bar -->
		
		<!-- Begin of #login-details -->
		<?php include("includes/login-details.php");?>
         <!--! end of #login-details -->
    	
    	<!-- Begin of Navigation -->
    	<?php include("nav.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    	<?php 
		$bid=$_GET['bid'];
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_paid.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li> Fee Paid Report</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="board_select_paid.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div class="_25" style="float:right">
                <label for="select">Board :</label>
                                	<?php
                                            $classl = "SELECT * FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="bid" id="bid" class="required" onchange="change_function()">';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($bid ==$row1['b_id']){
                                                echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
												} else {
												echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Paid type , Board and Class , Section/group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get" action="">
                    <div class="_50">
							<p>
								<label for="select">Select Paid type : <span class="error">*</span></label>
                       <select name="ptype" id="ptype" class="required">
                       		<option value="">Select Paid type</option>
						  <option value="All">Full Fee Paid</option>
                          <!--<option value="Half">Half Fee Paid</option>-->
                          <option value="Pand">Payment pending</option>
                          <option value="Non">None Paid</option>
                        </select>
               			</p>
						</div>
						<div class="_25">
							<p>
								<label for="select">Standard : </label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid"  onchange="showCategory(this.value)"> <option value="">Select Class</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Section / Group : </label>
                               <select name="sid" id="sid">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                        
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
             <?php 
			 		$ptype1=$_GET['ptype'];
					$cid=$_GET['cid'];
					$sid=$_GET['sid'];
					
					if($ptype1 && $bid){ 
					
					if($ptype1=='All'){
						$ptypename="Fully Paid";
					}else if($ptype1=='Non'){
						$ptypename="Non Pay";
					}else if($ptype1=='Pand'){
						$ptypename="Payment Pending";
					}
					//echo $ptype1;
					
					if(!empty($sid)) {$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist); }
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	   }
								  
					
					/*$qry1="SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "'";
							if(!empty($bid) && $bid!='All') { $qry1 .= " AND bid = '" . $bid. "'"; }
							$qry1=mysql_query($qry1);
							$total=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$total +=$row1['fi_total'];
				}*/
				?>
                <div class="grid_12"><br>
                <a href="payment_student_export.php?ptype=<?php echo $ptype1."&cid=".$cid."&sid=".$sid."&bid=".$bid."&acid=".$acyear;?>" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Report <?php echo "( ".$ptypename." )";?></button></a>
                <h1>Fee Paid Report <?php echo "( ".$ptypename." )";?></h1>
                <div class="block-border">
					<div class="block-header">
                    	<h1> Fee Paid Report <?php echo "( ".$ptypename." )";?></h1>                       
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <th>Parent's name</th>
                                    <th>Date of Admin</th>
                                    <th>Board</th>
                                    <th>Class-Section</th>
                                    <th>Student Category</th>
                                    <th width="4%">Student type</th>
                                    <?php if($ptype1!="Non"){?>
                                    <th>fee Paid Detail</th>
                                    <?php } ?>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$studentlist="SELECT * FROM student WHERE b_id='" . $bid. "' AND ay_id='" . $acyear. "'";
							if(!empty($cid)) { $studentlist .= " AND c_id = '" . $cid. "'"; }
							if(!empty($sid)) { $studentlist .= " AND s_id = '" . $sid. "'"; }
							//$studentlist .= " LIMIT 3,1";
							$studentlist=mysql_query($studentlist);
							$count=1;
			  while($student=mysql_fetch_array($studentlist))
        		{
								  $ssid=$student['ss_id'];
								  //echo "<br>";
								  $ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  if(!empty($sid)) {$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist); }
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	   }
								  $s_type=$student['stype'];
								  $fdisid1=$student['fdis_id'];
								  
							$discountlist=mysql_query("SELECT * FROM fdiscount WHERE fdis_id=$fdisid1"); 
								  $discount=mysql_fetch_array($discountlist);
								  
								  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_array($classlist1);
								  
								  if(($class1['c_name']=="XI STD") || ($class1['c_name']=="XII STD")){
									 $sid21 = $sid;
								  }else {
									  $sid21 = "0";
								  }			
							
							
							$fdisid2=$fdisid1;
				$fcount=1;
				$fullpay=0;
				$pendpay=0;
				$nonpay=0;
				 $qry=mysql_query("SELECT * FROM frate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid21");
						  while($row=mysql_fetch_array($qry))
							{ 
							$total1=0;
							$frid=$row['fr_id'];
							$fgid2=$row['fg_id'];
							$fgrouplist=mysql_query("SELECT * FROM fgroup WHERE fg_id=$fgid2");
											  $fgroup=mysql_fetch_array($fgrouplist);	
											  $grouptype=$fgroup['ftype'];	
									if($grouptype!="other"){		  
				$qry3=mysql_query("SELECT * FROM fgroup_detail where fg_id=$fgid2");													
									  while($row3=mysql_fetch_array($qry3))
										{
											$fgdid=$row3['fgd_id'];
											$type=$row3['type'];
											$ftype="";	
											//echo $row3['name']."-";
											if($s_type=="New"){
									  $frvaluelist=mysql_query("SELECT * FROM frate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND fgd_id=$fgdid AND ay_id=$acyear"); 
								  }else{
									  $frvaluelist=mysql_query("SELECT * FROM frate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND fgd_id=$fgdid AND ay_id=$acyear AND ftype='0'"); 
								  }											
								
								$pending=0;	
								$pending=0;	
								$ptype=1;
								$paid=0;	
					$qry5=mysql_query("SELECT * FROM finvoice WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND bid=$bid AND ay_id=$acyear and c_status!='1'");
			  while($row5=mysql_fetch_array($qry5))
        		{
					$ffi_id=$row5['fi_id'];	
									$qry6=mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id AND fgd_id=$fgdid AND type='terms'");
							  $row6=mysql_fetch_array($qry6);
							  $paid +=$row6['amount'];
							  if($row6['payment']){
								  $pending = $row6['pamount'];
							  } else if($row6['payment']=="0"){
								  $pending =0;
								  $ptype=0;
							  }
					}
								  $frvalue=mysql_fetch_array($frvaluelist);
								  if($frvalue){
								  $total1 +=$frvalue['dis_value'];								  
								  }
								  } 
								  if($pending && $ptype=="1"){
									 $pendpay +=1;
									  //$paid=$total1-$pending;
								  }else if(!$pending && $ptype=="0"){
									 $fullpay +=1;
								  }else{
									 $nonpay +=1;
								  }
								  //echo $paid;
								  //die();
								   $cartid=$frid.$fcount;
								  //echo $fgroup['fg_name']."-";
								  //echo $total1."<br>";
								  //if($pending1){
								  	//		echo $ssid."-".$pending1."<br>";
								  $fcount++;
								  //}
									}else{
										
										$qry3=mysql_query("SELECT * FROM fgroup_detail where fg_id=$fgid2");													
									  while($row3=mysql_fetch_array($qry3))
										{
											$fgdid=$row3['fgd_id'];
											$type=$row3['type'];
											$ftype="";		
											//echo $row3['name']."-";										
				$frvaluelist=mysql_query("SELECT * FROM frate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND fgd_id=$fgdid AND ay_id=$acyear AND ftype='0'"); 
								$pending=0;	
								$ptype=1;
								$paid=0;		
					$qry5=mysql_query("SELECT * FROM finvoice WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND bid=$bid AND ay_id=$acyear and c_status!='1'");
			  while($row5=mysql_fetch_array($qry5))
        		{
					$ffi_id=$row5['fi_id'];	
									$qry6=mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id AND fgd_id=$fgdid AND type='other'");
							  $row6=mysql_fetch_array($qry6);
							  $paid +=$row6['amount'];
							  if($row6['payment']){
								  $pending = $row6['pamount'];
							  } else if($row6['payment']=="0"){
								  $pending = 0;
								  $ptype=0;
							  }
					}
								  $frvalue=mysql_fetch_array($frvaluelist);
								  if($frvalue){
									  $total1=$frvalue['dis_value'];
									  if($pending && $ptype=="1"){
									 	 $pendpay +=1;
								  }else if(!$pending && $ptype=="0"){
									  $fullpay +=1;
								  }else{
									  $nonpay +=1;
								  }
								  //echo $pending1;
								    $cartid=$frid.$fcount;
								   //echo $row3['name']."-";
								  //echo $frvalue['dis_value']."<br>";
								  $fcount++;							  
								  }
								  }	
									}
								  }
								  
								  
								  
								  
								  
								  
								  
							/* echo  $fullpay;
							  echo "<br>";
							  echo  $pendpay;
							  echo "<br>";
							  echo  $nonpay;
							  echo "<br>";
							  echo "<br>";*/
							 
							if($fullpay!=0 && !$pendpay && !$nonpay && $ptype1=="All"){
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $student['doa']; ?></center></td>
                                <td><center><?php echo $board['b_name'];?></center></td>
                                <td><center><?php echo $class['c_name']."/".$section['s_name']; ?></center></td>
                                <td><center><?php echo  $discount['fdis_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
                                <td class="view"><center><a href="feesinvoice_single.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php 
							$count++;
							} if((($pendpay && $fullpay) || ($pendpay && !$nonpay) || ($fullpay && $nonpay)) && $ptype1=='Pand'){
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $student['doa']; ?></center></td>
                                <td><center><?php echo $board['b_name'];?></center></td>
                                <td><center><?php echo $class['c_name']."/".$section['s_name']; ?></center></td>
                                <td><center><?php echo  $discount['fdis_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
                                <td class="view"><center><a href="feesinvoice_single.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php 
							$count++;
							} if($nonpay!=0 && !$pendpay && !$fullpay && $ptype1=='Non'){?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $student['doa']; ?></center></td>
                                <td><center><?php echo $board['b_name'];?></center></td>
                                <td><center><?php echo $class['c_name']."/".$section['s_name']; ?></center></td>
                                <td><center><?php echo  $discount['fdis_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
							<?php $count++; } } ?>                            																
							</tbody>
						</table>
					</div>
				</div>			
		<div class="clear height-fix"></div>
        </div>
        <?php } ?>
        </div>
        </div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");
	?>
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
  <script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	$('#table-example').dataTable({
  'iDisplayLength': 25
});
// Code that uses jQuery's $ can follow here.
});
// Code that uses other library's $ can follow here.
</script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).datepicker();
		$( "#datepicker1" ).datepicker();
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'payment_income_report.php?bid='+cid;	  
	} 
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->  
  <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
    function showCategory(str) {
        if (str == "") {
            document.getElementById("sid").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("sid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script> 
</body>
</html>
<? ob_flush(); ?>