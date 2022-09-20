<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");  
 
 function paid_amount($b,$c,$s,$acyear,$ssid)
								  {
								      $fi=array();
								      $tquery2=mysql_query("select fi_id from mfinvoice  where ss_id='$ssid' and c_id='$c' and bid='$b' and  ay_id='$acyear'");
								      while($trow2=mysql_fetch_array($tquery2)){
								          $fi_id=$trow2["fi_id"];
								  
								          array_push($fi,$fi_id);
								      }
								      	
								      $fis=implode(",",$fi);
								  
								  
								      $ptotal=0;
								      $tquery1=mysql_query("select amount from fsalessumarry  where  fi_id IN ($fis) and fr_id!='0'  ");
								      $d=0;
								      while($trow1=mysql_fetch_array($tquery1)){
								          $d=$d+1;
								          $ptotal=$trow1['amount']+$ptotal;
								           
								      }
								      //  echo $d."-".$ptotal."<br>";
								      return $ptotal;
								      	
								  }
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
			$boardlist1=mysql_query("SELECT b_id,b_name FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT b_name FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a  title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
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
                                            $classl = "SELECT b_id,b_name FROM board";
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
					
					if(!empty($sid)) {$classlist=mysql_query("SELECT c_name FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist); }
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT s_name FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	   }
					
				?>
                <div class="grid_12"><br>
                <a href="mpayment_student_export.php?ptype=<?php echo $ptype1."&cid=".$cid."&sid=".$sid."&bid=".$bid."&acid=".$acyear;?>" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Report <?php echo "( ".$ptypename." )";?></button></a>
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
                                    <th>Class-Section</th>
                                    <th>Student Category</th>
                                    <th width="4%">Student type</th>
                                    <th>Total Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Pending</th>
                                    <?php if($ptype1!="Non"){?>
                                    <th>fee Paid Detail</th>
                                    <?php } ?>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$studentlist="SELECT ss_id FROM student WHERE b_id='" . $bid. "' AND ay_id='" . $acyear. "'";
							if(!empty($cid)) { $studentlist .= " AND c_id = '" . $cid. "'"; }
							if(!empty($sid)) { $studentlist .= " AND s_id = '" . $sid. "'"; }
							//$studentlist .= " LIMIT 3,1";
							$studentlist=mysql_query($studentlist);
							$count=1;
							
			  while($student=mysql_fetch_array($studentlist))
        		{
								
								$nonpay=0;
								$pendpay=0;
								$fullpay=0;
							  
								  $ssid=$student['ss_id'];
								  
								  $ss_id=$ssid;
								$student=mysql_fetch_array(mysql_query("SELECT gender,c_id,s_id,stype,mlate_join,fdis_id,mpd_id,admission_number ,firstname,lastname,fathersname FROM student where ss_id='$ss_id'"));
								$ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  $s_type=$student['stype'];
								  $mlate_join=$student['mlate_join'];
								  $fdisid1=$student['fdis_id'];
								  
								  $classlist1=mysql_query("SELECT c_name FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_array($classlist1);
								  
								  $sectionlist1=mysql_query("SELECT s_name FROM section WHERE s_id=$sid"); 
								  $section1=mysql_fetch_array($sectionlist1);	
								  
								  
								  $qry4=mysql_query("SELECT fdis_name FROM fdiscount WHERE fdis_id='$fdisid1'"); 
								  $discount1=mysql_fetch_array($qry4);
								  
								  $mpdid=$student['mpd_id'];
								  $discount=0;
								  if($mpdid){
									  $paytypelist=mysql_query("SELECT value,discount FROM mpaydiscount WHERE mpd_id=$mpdid"); 
								  	  $mpaydiscount=mysql_fetch_array($paytypelist);
									  $dismonth=$mpaydiscount['value'];
									  $disamount=$mpaydiscount['discount'];	
								  }
								   if(($class1['c_name']=="XI STD") || ($class1['c_name']=="XII STD") || ($class1['c_name']=="XI") || ($class1['c_name']=="XII")){
									 $sid21 = $sid;
								  }else {
									  $sid21 = "0";
								  }	
								  
								  $tot=0;
								$totalamount=0;
								      $tquery=mysql_query("SELECT fg_id,fgd_id,fr_id FROM mfrate WHERE c_id=$cid AND b_id=$bid AND ay_id=$acyear AND rate='$s_type' AND s_id=$sid21 ORDER BY fgd_id");
								      while($row2=mysql_fetch_array($tquery)){
										  
										   
									 $ffgid=$row2['fg_id'];
									 $ffgdid=$row2['fgd_id'];
									//die();
									$frid=$row2['fr_id'];
									
									if($ffgid){ /************************ School Fees start*********************************/									
									
									$fgrouplist=mysql_query("SELECT fty_id,end FROM mfgroup WHERE fg_id=$ffgid");
									$ffgroup=mysql_fetch_array($fgrouplist);
									
									$ftyid=$ffgroup['fty_id'];
									
									$fendmonth=$ffgroup['end'];
									
									if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
							
								$ftypelist=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
														$ftypevalue=$ftype['fty_value'];													
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
								$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
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
										if(!empty($frid)) { 
					 $qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							$fratelist1=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
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
								$fsummaylist=mysql_query("SELECT fto FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
									  }		
								 }
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
						
								if($frateto2>1){						
									$frateto12=$fratefrom2+$frateto2;
								}else{
									$frateto12=$fratefrom2;
								}
								
						if($frateto12>$tomonth){
							$frateto12=$tomonth;							
						}
						if($ftypevalue==1 && $mpdid){
								 $frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2*$frateto2;
							 }else{
								 $frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;
							 }
							 $rmonth=$tomonth-$frateto12;
													
					}else {
							$frateto12=$frateto2;
							
							if($frateto12>$tomonth){
								$frateto12=$tomonth;							
							}
							
							if($ftypevalue==1 && $mpdid){
								 $frateamount12=$frateamount2*$frateto12;
							 }else{
								 $frateamount12=$frateamount2;
							 }	
							 $rmonth=$tomonth-$frateto12;					
						}
						
						if($frateto12==$tomonth && ($ftypevalue==1 && $mpdid)){
							$discount=1;
						}
						
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						 if($rmonth){
							$frateamount12=$frateamount12*($rmonth+1);
						}
						if($frateamount12>0){
							$tot +=$frateamount12;
						 }
				}/************************ School Fees end*********************************/
				
				if($ffgdid){ /************************ Other Fees start*********************************/									
									
									
									/*$fgrouplist=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$ffgdid");
									$ffgroup=mysql_fetch_array($fgrouplist);*/
														$ftypevalue=12;
								$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
																  $class=mysql_fetch_array($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgdid;
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
							
							//echo $qry1;
							$qry3=mysql_query($qry3);							
							
							$fratelist1=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							$f_to12="";	
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT fto FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==12){										 										   
										 $fullpaid2++;
									  }		
								 }
								// $fullpaid;
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
								if($frateto2>1){						
									$frateto12=$fratefrom2+$frateto2;
								}else{
									$frateto12=$fratefrom2;
								}
						//$frateto12=$fratefrom2+$frateto2;
						if($frateto12>12){
							$frateto12=12;
							
						}
						
						$frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;							
					}else {
							$frateto12=$frateto2;
							$frateamount12=$frateamount2;							
						}
						 $fratefrom2;
						 $frateto12;
						  $frateamount12;
						if($frateamount12>0){
							$tot +=$frateamount12;
						 }
						 $totalamount +=$frateamount2;
				}/************************ Other Fees end*********************************/
									}
								  
								  $qry1=mysql_query("SELECT fi_total FROM mfinvoice WHERE bid=$bid AND ss_id='$ss_id' AND ay_id=$acyear");
							$total=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$tamount=$row1['fi_total'];
					$total +=$tamount;		

					$fdis=$student['fdis_id'];
					$stype=$student['stype'];
					
					if($stype=="Old")
					{
					    $ftype="0";
					}else{
					    $ftype="0,1";
					}
					//$paid=paid_amount($bid,$cid,$sid,$acyear,$ss_id);
				}
								  
								  
								  
								  if(!$total){
									  $nonpay++;
								  }if($tot){
									  $pendpay++;
								  }
								  if(!$tot && $total){
									  $fullpay++;
								  }
								  
							  $totalamount=number_format($totalamount,2);
							  $total=number_format($total,2);
							  $tot=number_format($tot,2);
							 
							if($fullpay && $pendpay==0 && $ptype1=="All"){
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                <td><center><?php echo $discount1['fdis_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
                                <td><center><?php echo $totalamount;?></center></td>
                                <td><center><?php echo $total;?></center></td>
                                <td><center><?php echo $tot;?></center></td>
                                <td class="view"><center><a href="mstudent_feesinvoice.php?ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>" target="_blank"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php 
							$count++;
							} if(($pendpay && !$nonpay) && $ptype1=='Pand'){
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                <td><center><?php echo  $discount1['fdis_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
                                <td><center><?php echo $totalamount;?></center></td>
                                <td><center><?php echo $total;?></center></td>
                                <td><center><?php echo $tot;?></center></td>
                                <td class="view"><center><a href="mstudent_feesinvoice.php?ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>" target="_blank"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php 
							$count++;
							} if($nonpay!=0 && $ptype1=='Non'){?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                <td><center><?php echo  $discount1['fdis_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
                                <td><center><?php echo $totalamount;?></center></td>
                                <td><center><?php echo $total;?></center></td>
                                <td><center><?php echo $tot;?></center></td>
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
	 window.location.href = 'm_payment_income_report.php?bid='+cid;	  
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