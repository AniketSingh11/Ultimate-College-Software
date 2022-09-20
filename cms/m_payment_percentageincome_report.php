<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 
 function paid_amount($b,$c,$s,$acyear,$ssid)
								  {
								      $fi=array();
								      $tquery2=mysql_query("select * from mfinvoice  where ss_id='$ssid' and c_id='$c' and s_id='$s' and bid='$b' and  ay_id='$acyear' AND c_status!='1' AND i_status='0'");
								      while($trow2=mysql_fetch_array($tquery2)){
								          $fi_id=$trow2["fi_id"];
								  
								          array_push($fi,$fi_id);
								      }
								      	
								      $fis=implode(",",$fi);
								  
								  
								      $ptotal=0;
								      $tquery1=mysql_query("select * from fsalessumarry  where  fi_id IN ($fis) and fr_id!='0'  ");
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
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
								  $ptype1=$_GET['perrange'];
								  $cid=$_GET['cid'];
								  $sid=$_GET['sid'];
								  
								  $perrange1=$_GET["perrange1"];
								  $perrange2=$_GET["perrange2"];
								  
								  
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a  title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li> Fee Paid Report Percentage</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
             <a href="board_select_percentagepaid.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
					  <span>Percentage range:</span>
					  <span id="perrange" style="border:0; color:#f6931f; font-weight:bold;"></span>
                           <input id="perrange1" name="perrange1" value="<?=$perrange1?>" style="display: none;" ><input id="perrange2" name="perrange2" value="<?=$perrange2?>" style="display: none;">
					<div id="rangeSlider1" class="slider-secondary" style="margin-top: 1em;"></div>
					  </div>
					
                    
						<div class="_25">
							<p>
								<label for="select">Standard : </label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid"  onchange="showCategory(this.value)"> <option value="">Select Class</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                               ?><option value='<?php echo $row1['c_id'];?>' <?php if($row1['c_id']==$cid){echo "selected"; }?>><?php echo $row1['c_name'];?></option> 
											<?php
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
			 	
				 
					if($perrange2 && $bid){ 
					
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
                <a href="mpayment_incomestudent_export.php?perrange1=<?php echo $perrange1."&perrange2=".$perrange2."&cid=".$cid."&sid=".$sid."&bid=".$bid."&acid=".$acyear;?>" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Report</button></a>
                <h1>Fee Paid Report </h1>
                <div class="block-border">
					<div class="block-header">
                    	<h1> Fee Paid Report </h1>                       
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
							//$studentlist .= " AND ss_id=53";
							$studentlist=mysql_query($studentlist) or die(mysql_error());
							$count=1;
			  while($student=mysql_fetch_array($studentlist))
        		{
								  $nonpay=0;
								$pendpay=0;
								$fullpay=0;
							  
								  $ssid=$student['ss_id'];
								  
								  $ss_id=$ssid;
								$student=mysql_fetch_array(mysql_query("SELECT * FROM student where ss_id='$ss_id'"));
								$ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  $s_type=$student['stype'];
								  $mlate_join=$student['mlate_join'];
								  $fdisid1=$student['fdis_id'];
								  
								  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_array($classlist1);
								  
								  $sectionlist1=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section1=mysql_fetch_array($sectionlist1);	
								  
								  
								  $qry4=mysql_query("SELECT * FROM fdiscount WHERE fdis_id='$fdisid1'"); 
								  $discount1=mysql_fetch_array($qry4);
								  
								  $mpdid=$student['mpd_id'];
								  $discount=0;
								  if($mpdid){
									  $paytypelist=mysql_query("SELECT * FROM mpaydiscount WHERE mpd_id=$mpdid"); 
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
								      $tquery=mysql_query("SELECT * FROM mfrate WHERE c_id=$cid AND b_id=$bid AND ay_id=$acyear AND rate='$s_type' AND s_id=$sid21 ORDER BY fgd_id");
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
										if(!empty($frid)) { 
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
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
									
									
									$fgrouplist=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$ffgdid");
									$ffgroup=mysql_fetch_array($fgrouplist);
														$ftypevalue=12;
								$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
																  $class=mysql_fetch_array($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgdid;
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
							
							//echo $qry1;
							$qry3=mysql_query($qry3);							
							
							$fratelist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							$f_to12="";	
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
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
							 $totalamount +=$frateamount2;
						 }
				}/************************ Other Fees end*********************************/
									}
								  
								  $qry1=mysql_query("SELECT * FROM mfinvoice WHERE bid=$bid AND ss_id='$ss_id' AND ay_id=$acyear");
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
					$paid=paid_amount($bid,$cid,$sid,$acyear,$ss_id);
				}
				
				
							/*echo  "Total Fees :".$totalamount;
							  echo "<br>";
							  echo  "Total Paid   :".$total;
							  echo "<br>";
							  echo  "Total Pending :".$tot;
							   echo "<br>";*/
							   
							   
							      $total1=$totalamount;
							      $paid=$totalamount-$tot;
							     
							      $percentage_1=$total1*($perrange1/100);
							      
							      $percentage_2=$total1*($perrange2/100);
							     
							      
							      if($paid >= $percentage_1 && $paid <= $percentage_2 && $total1!=0){
							      //if($total!=0 ){
								  
								  if(!empty($cid)) {$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist); }
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	   }
								  $s_type=$student['stype'];
								  $fdisid1=$student['fdis_id'];
								  
							$discountlist=mysql_query("SELECT * FROM fdiscount WHERE fdis_id=$fdisid1"); 
								  $discount=mysql_fetch_array($discountlist);
							 
					?>
							  	<tr class="gradeX">
							  		<td class="sno center"><center><?php  echo $count; ?></center></td>
								<!-- <td class="sno center"><center><?php  echo $paid; ?></center></td> -->
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $student['doa']; ?></center></td>
                                <td><center><?php echo $board['b_name'];?></center></td>
                                <td><center><?php echo $class['c_name']."/".$section['s_name']; ?></center></td>
                                <td><center><?php echo  $discount['fdis_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
                                <td class="view"><center><a href="mfeesinvoice_single.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                             
                                
							<?php $count++; } 
        		    } //pecentage
							?>                            																
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
 

  <!-- scripts concatenated and minified via ant build script
    
  -->
  <script defer src="js/plugins.js"></script>  lightweight wrapper for consolelog, optional -->
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
  <?php if($perrange2 || $perrange2==0 && $_GET['perrange2'] ){
      $pmin=$perrange1;
      $pmax=$perrange2;

	    }else{
	        $pmin="40";
	        $pmax="60";
	    
}?>
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
  

  <!--   <script src="payroll/js/demos/sliders.js"></script> -->
   
 
<script type="text/javascript">

$().ready(function() {
	var s=$("#cid").val();
	 
	if(s!=""){
		showCategory(s);
	}
$( "#rangeSlider1" ).slider({
		range: true,
		min: 0,
		max: 100,
		values: [ <?=$pmin?>, <?=$pmax?> ],
		slide: function( event, ui ) {
			$( "#perrange" ).text (ui.values[ 0 ] + " % " +" - " + ui.values[ 1 ]+" %" );
			$( "#perrange1" ).val (ui.values[ 0 ]);
			$( "#perrange2" ).val (ui.values[ 1 ]);
		}
		
	});
$( "#perrange" ).text(  $( "#rangeSlider1" ).slider( "values", 0 )+ " % " +
		" - " + $( "#rangeSlider1" ).slider( "values", 1 )+" % " );
	$( "#perrange1" ).val (<?=$pmin?>);
	$( "#perrange2" ).val (<?=$pmax?>);

 
});		

function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'm_payment_percentageincome_report.php?bid='+cid;	  
	}	
	

  
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
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str+"&sid=<?=$_GET['sid']?>", true);
        xmlhttp.send();
    }    
</script> 
<style>
.ui-slider {
  position: relative;
  text-align: left;
}
.ui-slider .ui-slider-handle {
  position: absolute;
  z-index: 2;
  width: 25px;
  height: 16px;
  background: url(payroll/img/jquery/handle.png) no-repeat;
  border: none;
  cursor: pointer;
}
.ui-slider .ui-slider-handle:hover {
  background-position: 0 -16px;
}
.ui-slider .ui-slider-handle:active {
  background-position: 0 -16px;
}
.ui-slider .ui-slider-range {
  position: absolute;
  z-index: 1;
  height: 6px;
  font-size: .7em;
  display: block;
  border: 1px solid #FFF;
  border-bottom-left-radius: 6px;
  border-top-left-radius: 6px;
  border-bottom-right-radius: 6px;
  border-top-right-radius: 6px;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2);
  -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2);
  background: #ccc;
  border-color: #b3b3b3;
}
.ui-slider.slider-primary .ui-slider-range {
  background: #e5412d;
  border-color: #c62b19;
}
.ui-slider.slider-secondary .ui-slider-range {
  background: #f0ad4e;
  border-color: #ec971f;
}
.ui-slider.slider-tertiary .ui-slider-range {
  background: #888888;
  border-color: #6f6f6f;
}
.ui-slider.slider-success .ui-slider-range {
  background: #5cb85c;
  border-color: #449d44;
}
.ui-slider.slider-warning .ui-slider-range {
  background: #ff751a;
  border-color: #e65c00;
}
.ui-slider.slider-danger .ui-slider-range {
  background: #d9534f;
  border-color: #c9302c;
}
.ui-slider.slider-info .ui-slider-range {
  background: #3498db;
  border-color: #217dbb;
}
.ui-slider-horizontal {
  height: 12px;
}
.ui-slider-horizontal .ui-slider-handle {
  top: -4px;
  margin-left: -0.6em;
}
.ui-slider-horizontal .ui-slider-range {
  top: -1px;
  height: 110%;
}
.ui-slider-horizontal .ui-slider-range-min {
  left: 0;
}
.ui-slider-horizontal .ui-slider-range-max {
  right: 0;
}
.ui-slider-vertical {
  width: 11px;
  height: 100px;
}
.ui-slider-vertical .ui-slider-handle {
  left: -3px;
  margin-left: 0;
  margin-bottom: -0.6em;
  width: 15px;
  height: 24px;
  background: url(payroll/img/jquery/handle-vertical.png) no-repeat;
}
.ui-slider-vertical .ui-slider-handle:hover {
  background-position: 0 -24px;
}
.ui-slider-vertical .ui-slider-handle:active {
  background-position: 0 -24px;
}
.ui-slider-vertical .ui-slider-range {
  left: 0;
  width: 9px;
}
.ui-slider-vertical .ui-slider-range-min {
  bottom: 0;
}
.ui-slider-vertical .ui-slider-range-max {
  top: 0;
}
</style>
</body>
</html>
<? ob_flush(); ?>