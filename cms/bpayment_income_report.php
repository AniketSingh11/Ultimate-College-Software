<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 function paid_amount($b,$c,$s,$acyear,$ssid)
								  {
								      $fi=array();
									  $ptotal=0;
								      $tquery2=mysql_query("select * from bfinvoice  where ss_id='$ssid' and c_id='$c'and bid='$b' and  ay_id='$acyear'");
								      while($trow2=mysql_fetch_array($tquery2)){
								          $fi_id=$trow2["fi_id"];
								  
								           $ptotal=$trow2['fi_total']+$ptotal;
								      }
								      return $ptotal;
								      	
								  } 
?>
 <link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
</head>

<body id="top">

  <!-- Begin of #container -->
  <div id="container">
  	<!-- Begin of #header -->
    <?php include("includes/header.php");
	$ptype1=$_GET['ptype'];
					$rid=$_GET['rid'];?>
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
    	
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li>Bus Fee Paid Report</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Paid type , Route Master</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get" action="">
                    <div class="_50">
							<p>
								<label for="select">Select Paid type : <span class="error">*</span></label>
                       <select name="ptype" id="ptype" class="required">
                       <option value="">Please Select</option>
						  <option value="All">Full Fee Paid</option>
                          <option value="Pand">Payment pending</option>
                          <option value="Non">None Paid</option>
                        </select>
               			</p>
						</div>
						<div class="_50">
							<p>
								<label for="select">Route Master : <span class="error">*</span></label>
                                	<?php
                                            $result1 = mysql_query("SELECT * FROM route") or die(mysql_error());
                                            echo '<select name="rid" id="rid" class="required"> <option value="">Select Route Master</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
												//if($rid==$row1['r_id']){
                                                //echo "<option value='{$row1['r_id']}' selected>{$row1['r_name']}</option>\n";
												//}else{
													echo "<option value='{$row1['r_id']}'>{$row1['r_name']}</option>\n";
												//}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
             <?php 			 							
					if($ptype1 && $rid){ 
					
					if($ptype1=='All'){
						$ptypename="Fully Paid";
					}else if($ptype1=='Non'){
						$ptypename="Non Pay";
					}else if($ptype1=='Pand'){
						$ptypename="Payment Pending";
					}
					
					//echo $ptype1;
					
					if(!empty($rid)) {$classlist=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  $route=mysql_fetch_array($classlist);
								   $vid=$route['v_id'];
							$did=$route['d_id'];
							$sdid=$route['sd_id'];
								$vehiclelist=mysql_query("SELECT * FROM vehicle WHERE v_id=$vid"); 
								$vehicle=mysql_fetch_array($vehiclelist);
								$driverlist=mysql_query("SELECT * FROM driver WHERE d_id=$did"); 
								$driver=mysql_fetch_array($driverlist);
								$driverlist1=mysql_query("SELECT * FROM driver WHERE d_id=$sdid"); 
								$driver1=mysql_fetch_array($driverlist1);
								  }
				?>
                <div class="grid_12"><br>
                <h1>Bus Fee Paid Report (<?php echo $route['r_name'];?> )</h1>
                <a href="bpayment_income_export.php?rid=<?php echo $rid;?>&ayid=<?php echo $acyear;?>&ptype=<?php echo $ptype1;?>" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Download Report</button></a>
                <span style="margin:0px 10px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/truck--plus.png"> Vehicle No - <strong><?php echo $vehicle['v_no']; ?></strong> &nbsp; | &nbsp;<img src="img/icons/packs/fugue/16x16/user-thief-baldie.png"> Driver Name - <strong><?php echo $driver['fname']." ".$driver['lname']; ?></strong> &nbsp; | &nbsp;<img src="img/icons/packs/fugue/16x16/user-yellow-female.png"> Bus Assistant - <strong><?php echo $driver1['fname']." ".$driver1['lname']; ?></strong></span> 
                <div class="block-border">
					<div class="block-header">
                    	<h1>Bus Fee Paid Report (<?php echo $route['r_name'];?> )</h1>                       
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
                                    <th>Route Name</th>
                                    <th>Stopping</th>
                                    <th>fee Paid Detail</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
                            $myrt=$route['r_name'];
							$qry="SELECT * FROM student WHERE ay_id='" . $acyear. "' and r_id=1";
							if(!empty($rid)) { $qry .= " AND route = '" . $myrt. "'"; }	
							$qry=mysql_query($qry);
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$ssid=$row['ss_id'];
					  $ss_gender=$row['	gender'];
					  $cid=$row['c_id'];
					  $sid=$row['s_id'];
					  $bid=$row['b_id'];
					  $s_type=$row['stype'];
					  $fdisid1=$row['fdis_id'];
					  $rid=$row['r_id'];
					  $spid=$row['sp_id'];
					  $busfeestype=$row['busfeestype'];
					  $mlate_join=$row['mlate_join'];
					  $blate_join=$row['blate_join'];
					  //echo "<br>";
				 				$nonpay=0;
								$pendpay=0;
								$fullpay=0;
				 
				 $totalpending=0;
				 $totalamount=0;
				 
				 $rid1=$row['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid1"); 
								  $row5=mysql_fetch_array($qry5);
								  
								  $spid1=$row['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_array($classlist1);
								  
								  $sectionlist1=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section1=mysql_fetch_array($sectionlist1);	
								  
								  $boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board1=mysql_fetch_array($boardlist);
				
				$sql1=mysql_query("SELECT * FROM busfees WHERE r_id=$rid AND sp_id=$spid AND ay_id=$acyear");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$bfid=$row2['bf_id'];
									$ftyid=$row2['ftyid'];
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
														$ftypevalue=$ftype['fty_value'];
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 				
									$fendmonth=$row2['end'];
					 				if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
									
									
									if($f_to12){
										$tcalfrom=$f_to12+1;
									}else{
										$tcalfrom=1;
									}
										
									
									
					 $fesstypearray=array("fees","sp_fees","sp_fees_onetime","one_time"); 
					 
					 $tablefield=$fesstypearray[$busfeestype];
					 $frateamount2=$row2[$tablefield]; 
					 $fullpaid2=0;
					 //$f_to12=0;
					 		if($ftypevalue==1){
								$f_to12=$blate_join;	
							}else{
								$f_to12="";	
							}
							
							
							
							//echo $f_to12;
							
										if(!empty($bfid)) { 
					 $qry3="SELECT * FROM bfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "'";
							
							$qry3=mysql_query($qry3);
						while($row3=mysql_fetch_array($qry3))
							{
								$f_to12=$row3['fto'];
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
								 }
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
						//$frateto12=$fratefrom2+$frateto2;
						$frateto12=$fratefrom2;
						if($frateto12>$tomonth){
							$frateto12=$tomonth;
							
						}
						
						//$frateamount12=(($frateto12-$fratefrom2)/$frateto2)*$frateamount2;							
						//echo '(('.$frateto12.'-('.$fratefrom2.'-1))/'.$frateto2.')*'.$frateamount2;
						$frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;
						
					}else {
							$frateto12=$frateto2;
							$frateamount12=$frateamount2;							
						}
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						 $frateamount2;
						 $rmonth=($tomonth-$fratefrom2)+1;
						 
						if($frateamount12>0){
							$totalpending +=$frateamount12*$rmonth;
							//echo $bfid.",".$fratefrom2.",".$frateto12.",".$frateamount12.",".$ftyid.",".$ftypevalue.",".$frateamount12.",".$frateamount2.",".$tomonth;
						 }
										
									}
					
					$totalamount=(($tomonth-$tcalfrom)+1)*$frateamount2;
					$paid=paid_amount($bid,$cid,$sid,$acyear,$ssid);
								
								if(!$paid){
									  $nonpay++;
								  }if($totalpending){
									  $pendpay++;
								  }
								  if(!$totalpending && $paid){
									  $fullpay++;
								  }
								
							/*echo  "Total Fees :".$totalamount;
							  echo "<br>";
							  echo  "Total Paid   :".$paid;
							  echo "<br>";
							  echo  "Total Pending :".$totalpending;
							   echo "<br>";
							    echo  "nonpay :".$nonpay;
							   echo "<br>";
							  echo  "pendpay :".$pendpay;
							   echo "<br>";
							  echo  "fullpay :".$fullpay;
							  echo "<br>";*/
							  //die();
							// echo $nonpaid;
							if($fullpay && $pendpay==0 && $ptype1=="All"){
								//echo "full";
							
								//die();
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['admission_number']; ?></center></td>
                                <td><center><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></center></td>
                                <td><center><?php echo $row['fathersname']; ?></center></td>
                                <td><center><?php echo $row['doa']; ?></center></td>
                                <td><center><?php echo $board1['b_name'];?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                 <td><center><?php echo $route['r_name']; ?></center></td>
                                <td><center><?php echo $row6['stop_name']; ?></center></td>
                                <td class="view"><center><a href="bfeesinvoice_single.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php 
							$count++;
							} if(($pendpay && !$nonpay) && $ptype1=='Pand'){?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['admission_number']; ?></center></td>
                                <td><center><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></center></td>
                                <td><center><?php echo $row['fathersname']; ?></center></td>
                                <td><center><?php echo $row['doa']; ?></center></td>
                                <td><center><?php echo $board1['b_name'];?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                 <td><center><?php echo $route['r_name']; ?></center></td>
                                <td><center><?php echo $row6['stop_name']; ?></center></td>
								<td><center><a href="bfeesinvoice_single.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
							<?php $count++; } if($nonpay!=0 && $ptype1=='Non'){?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['admission_number']; ?></center></td>
                                <td><center><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></center></td>
                                <td><center><?php echo $row['fathersname']; ?></center></td>
                                <td><center><?php echo $row['doa']; ?></center></td>
                                <td><center><?php echo $board1['b_name'];?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                 <td><center><?php echo $route['r_name']; ?></center></td>
                                <td><center><?php echo $row6['stop_name']; ?></center></td>
								<td></td>
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
  'iDisplayLength': 50
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