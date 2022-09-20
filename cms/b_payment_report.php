<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");  
 
 $montharray=array("","June","July","August","September","October","November","December","January","February","March","April","May"); 
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
                <li class="no-hover"><a  title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li> Month Fee Paid Report</li>
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
            <?php $msg=$_GET['msg'];
			if($msg=="err"){?>			
            <div class="alert error"><span class="hide">x</span>Please Select Valid Months!!!</div>
            <?php } ?>
            <div class="block-border">
					<div class="block-header">
						<h1>Select Paid type , Board and Class , Section/group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get" action="">
                    <div class="_25">
							<p>
								<label for="select">Select Month From: <span class="error">*</span></label>
                                <select name="from" id="from" class="txt">
                                	<?php
									for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
									?>
									<option value="<?php echo $cmonth;?>"><?php echo  $montharray[$cmonth]?></option>
                                    <?php } ?>
                               </select>
                       </p>
						</div>
                        <div class="_25">
							<p>
								<?php
                                            $result1 = mysql_query("SELECT * FROM route") or die(mysql_error());
                                            echo '<select name="rid" id="rid" class="required"> <option value="">Select Route Master</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['r_id']}'>{$row1['r_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
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
                            <input type="hidden" class="medium" name="bid" value="<?php echo $bid;?>" >
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
             <?php 
			 		$from=$_GET['from'];
					$to=$_GET['to'];
					$cid=$_GET['cid'];
					$sid=$_GET['sid'];
					$filt=$_GET['filt'];
					if(!$filt){
						$filt="all";
					}					
					if($from && $to){
					
					if($to < $from){
						header("Location:b_payment_report.php?msg=err");
					}
					if(!empty($rid)) {
						$classlist=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  $class=mysql_fetch_array($classlist);
								  $vid=$class['v_id'];
							$did=$class['d_id'];
							$sdid=$class['sd_id'];
								$vehiclelist=mysql_query("SELECT * FROM vehicle WHERE v_id=$vid"); 
								$vehicle=mysql_fetch_array($vehiclelist);
								$driverlist=mysql_query("SELECT * FROM driver WHERE d_id=$did"); 
								$driver=mysql_fetch_array($driverlist);
								$driverlist1=mysql_query("SELECT * FROM driver WHERE d_id=$sdid"); 
								$driver1=mysql_fetch_array($driverlist1);
								
								  $myarray = array();
								  $qry=mysql_query("SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID");
								  while($row=mysql_fetch_array($qry))
									{
										array_push($myarray,$row['stop_id']);										
									}
									}
					
				?>
                <div class="grid_12"><br>
                <a href="mpayment_student_export1.php?from=<?php echo $from."&to=".$to."&cid=".$cid."&sid=".$sid."&bid=".$bid."&acid=".$acyear."&filt=".$filt;?>" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Report <?php if($from==$to){ echo "(".$montharray[$from].")"; }else{ echo "(".$montharray[$from]."-".$montharray[$to].")"; }?></button></a>
                <div class="_25" style="float:right">
                <label for="select">Filter by :</label>
                                	<select name="filt" id="filt" onchange="change_function1()">
                                    <option value="all" <?php if($filt=="all"){echo "selected";}?>>All</option>
                                    <option value="np" <?php if($filt=="np"){echo "selected";}?>>None-paid</option>
                                    <option value="p" <?php if($filt=="p"){echo "selected";}?>>Paid</option>
								</select>
                 </div>
                <h1>Month Fee Paid Report <?php if($from==$to){ echo "(".$montharray[$from].")"; }else{ echo "(".$montharray[$from]."-".$montharray[$to].")"; }?> - <?php  echo $class['r_name'];?></h1>
                <div class="block-border">
					<div class="block-header">
                    	<h1> Month Fee Paid Report <?php if($from==$to){ echo "(".$montharray[$from].")"; }else{ echo "(".$montharray[$from]."-".$montharray[$to].")"; }?> - <?php  echo $class['r_name'];?></h1>                       
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
                                    <th>Class-Section</th>
                                    <th>Boarding Point</th>
                                    <?php for($i=$from;$i<=$to;$i++){?>
                                    <th><?php echo $montharray[$i];?></th>
									<?php } ?>
                                    <th>fee Paid Detail</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM student WHERE sp_id IN (".implode(',',$myarray).") AND ay_id=$acyear ORDER BY FIND_IN_SET(sp_id, '".implode(',',$myarray)."')");
							$count=1;
						  while($student=mysql_fetch_array($qry))
							{	
								  $ssid=$student['ss_id'];
								  
								  $ss_id=$ssid;
								$student=mysql_fetch_array(mysql_query("SELECT * FROM student where ss_id='$ss_id'"));
								$ss_gender=$student['gender'];
								  $cid1=$student['c_id'];
								  $sid1=$student['s_id'];
								  $s_type=$student['stype'];
								  $mlate_join=$student['mlate_join'];
								  $fdisid1=$student['fdis_id'];
								  
								  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $class1=mysql_fetch_array($classlist1);
								  
								  $sectionlist1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $section1=mysql_fetch_array($sectionlist1);	
								  
								  
								  $qry4=mysql_query("SELECT * FROM fdiscount WHERE fdis_id='$fdisid1'"); 
								  $discount1=mysql_fetch_array($qry4);
								  
								  $spid1=$row['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $fesstypearray1=array("Regural Bus","Sp.Bus","Onetime Sp.Bus","Onetime Bus"); 
								  $busfeestype1=$row['busfeestype'];
								  
								  $tot=0;
								$totalamount=0;
								      $tquery=mysql_query("SELECT * FROM mfrate WHERE c_id=$cid1 AND b_id=$bid AND ay_id=$acyear AND rate='$s_type' AND s_id=$sid21 AND fg_id=$fgid1 ORDER BY fgd_id");
								      while($row2=mysql_fetch_array($tquery)){
										  
									 $ffgid=$row2['fg_id'];
									 $ffgdid=$row2['fgd_id'];
									//die();
									$frid=$row2['fr_id'];
									
									if($ffgid){ /************************ School Fees start*********************************/									
									
									$fgrouplist=mysql_query("SELECT * FROM mfgroup WHERE fg_id=$ffgid");
									$ffgroup=mysql_fetch_array($fgrouplist);
									
									$ftyid=$ffgroup['fty_id'];
									
									$fendmonth=$ffgroup['end'];
									
									if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
														$ftypevalue=$ftype['fty_value'];													
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
								$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
																  $class=mysql_fetch_array($classlist);
										$class['dis_value'];										
										$frateid2=$ffgid;
					 $fratefrom2='1';
					 //$frateto2=$ftypevalue;
					 if($ftypevalue==1 && $mpdid){
					 	 $frateto2=intval($dismonth);
					 }else{
						 $frateto2=$ftypevalue;
					 }
						 
					 $frateamount2=$class['dis_value'];
					 if($ftypevalue==1){
					 $totalamount +=$frateamount2*$tomonth;
					 }else{
					 $totalamount +=$frateamount2;
					 }
					 $fullpaid2=0;
					 $f_to12=0;
					 
					 
										if(!empty($frid) && $ftypevalue=='1') { 
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ssid. "' AND c_status!='1'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							$fratelist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							if($ftypevalue==1){
								$f_to12=$mlate_join;	
							}else{
								$f_to12="";	
							}
								
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
									  }		
								 }
								}
								//echo $f_to12;
								if($f_to12>=$to && $filt=="p"){
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
                                <?php for($i=$from;$i<=$to;$i++){?>
                                    <td><center><?php if($f_to12>=$i){
												  echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>';}
												else{ 
												 echo '<a original-title="NonePaid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/cross.png"/></a>'; }?></center></td>
									<?php } ?>
                                <td class="view"><center><a href="mfeesinvoice_single.php?cid=<?php echo $cid1;?>&sid=<?php echo $sid1;?>&ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>" target="_blank"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php $count++; } else if($f_to12<$to && $filt=="np"){
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
                                <?php for($i=$from;$i<=$to;$i++){?>
                                    <td><center><?php if($f_to12>=$i){
												 echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>';}
												else{ 
												 echo '<a original-title="NonePaid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/cross.png"/></a>'; }?></center></td>
									<?php } ?>
                                <td class="view"><center><a href="mfeesinvoice_single.php?cid=<?php echo $cid1;?>&sid=<?php echo $sid1;?>&ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>" target="_blank"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php  $count++;} else if($filt=="all"){
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
                                <?php for($i=$from;$i<=$to;$i++){?>
                                    <td><center><?php if($f_to12>=$i){
												  echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>';}
												else{ 
												 echo '<a original-title="NonePaid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/cross.png"/></a>'; }?></center></td>
									<?php } ?>
                                <td class="view"><center><a href="mfeesinvoice_single.php?cid=<?php echo $cid1;?>&sid=<?php echo $sid1;?>&ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>" target="_blank"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php  $count++;}
										}
								 }
					
				}/************************ School Fees end*********************************/
									 } ?>                            																
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
	 window.location.href = 'm_payment_income_report1.php?bid='+cid;	  
	} 
	function change_function1() { 
     var cid =document.getElementById('filt').value;
	 window.location.href = 'm_payment_income_report1.php?filt='+cid+'<?php echo "&from=$from&to=$to&cid=$cid&sid=$sid&bid=$bid"?>';	  
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
                document.getElementById("sid").innerHTML = "<option value=''>All</option>"+xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script> 
</body>
</html>
<? ob_flush(); ?>