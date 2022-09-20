<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 ?>
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
                <li class="no-hover"><a href="board_select_sanalysis.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Studentwise Result Analysis</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="board_select_sanalysis.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
            <?php if(!$_GET['roll']){ ?>
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Exam , Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get">
                    <div class="_50">
							<p>
								<label for="select" class="requered">Exam : <span class="error">*</span></label>
                                	<?php
                                            $classl1 = "SELECT e_id,e_name FROM exam where ay_id=$acyear";
                                            $result11 = mysql_query($classl1) or die(mysql_error());
                                            echo '<select name="eid" id="eid" class="required"> <option value="">Select Exam</option>';
											while ($row11 = mysql_fetch_assoc($result11)):
                                                echo "<option value='{$row11['e_id']}'>{$row11['e_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
						<div class="_50">
                            <p>
                            <label for="required">Student Roll No:</label>
                            <input type="text" name="roll" class="biginput" class="requered" id="autocomplete" /> 
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
            <?php }if($_GET['roll']){
					
					$roll=$_GET['roll'];
					$classes=explode("-",$roll);  
					//print_r($classes);
					$rollno=$classes[0];  
					$studentname=$classes[1]; 
					$eid=$_GET['eid']; 

					//die();
					
					$studentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$acyear"); 
								  $student=mysql_fetch_array($studentlist);
								  if(!$student || !$eid){
									  header("Location:result_analysis_student.php?bid=$bid");
								  }
								  $ssid=$student['ss_id'];
								  $ss_gender=$student['	gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
							
			}
							
				if($cid && $sid && $eid){
							$examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
									if($subid){
							$subjectlist=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.sub_id=$subid AND b.extra_sub=0 ORDER BY b.sl_id ASC");
								  $subject=mysql_fetch_array($subjectlist);
								 $slid1=$subject['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid1'"); 
								   $slist1=mysql_fetch_array($subjectlist1);
								   $paper=$slist1['paper'];
								  	  }
							 	  //echo $class['c_name']."-".$section['s_name'];
								  $classl1 = mysql_query("SELECT e_id,e_name FROM exam where ay_id=$acyear");
                                            while ($row11 = mysql_fetch_assoc($classl1)){
												if($row11['e_id'] < $eid){
													$lastexam=$row11['e_id'];
												}
											}
											//echo $lastexam;
								  ?>
                                  <a href="result_analysis_student.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Compare New One </button></a>
		<div class="grid_12">
				<h1><?php echo $student['firstname']." ".$student['lastname'];?> - Result Analysis (<?php echo $class['c_name']."-".$section['s_name'];?> )</h1>
           </div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
`                    <?php  if($lastexam){
								//echo $lastexam;
								$examlist12=mysql_query("SELECT * FROM exam WHERE e_id=$lastexam"); 
								  $exam12=mysql_fetch_array($examlist12);
								  //echo $exam12['e_name'];
							}?>
                    	<h1>Result Analysis ( <?php echo $exam['e_name']; if($lastexam){ echo " Vs ".$exam12['e_name']; }?> )</h1>                        
                        <span></span>
					</div>
					<div class="block-content">
                    <div class="tab-content" style="height:250px;">
                    	<div id="container-speed3" style="width: 230px; height: 170px; float: left"></div>
						<div id="container-speed1" style="width: 230px; height: 170px; float: left"></div>
                        <div id="container-speed" style="width: 230px; height: 170px; float: left"></div>
                        <div id="container-speed4" style="width: 230px; height: 170px; float: left"></div>
                        </div>
                        <div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            
             <?php 
		/* pass parcentage */
		$qyr12=mysql_query("SELECT * FROM student WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
		
		$totalstudents=mysql_num_rows($qyr12);
		$pssfail=0;
			  while($pstudent=mysql_fetch_array($qyr12))
        		{
					$pssid=$pstudent['ss_id'];
		$qr12=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
		$pssfail1=0;
			  while($row1=mysql_fetch_array($qr12))
        		{ 
				$subid1=$row1['sub_id']; 
					$qry451=mysql_query("SELECT * FROM result WHERE c_id='$cid' AND s_id='$sid' AND e_id='$eid' AND sub_id='$subid1' AND ss_id='$pssid' AND result='FAIL' AND ay_id='$acyear'");
					$rowsada1=mysql_fetch_array($qry451);
					//echo $rowsada1['result'];
					if($rowsada1){
						$pssfail1++;
					}	
						//echo $pssfail1;			
				}
				//echo $pssfail1;
				if($pssfail1){
				$pssfail++;
				}
				}
				if($totalstudents){
					//echo $totalstudents."/".$pssfail;
					$avgpass=(($totalstudents-$pssfail)/$totalstudents)*100;
				}
		
		/* Average mark	*/
		 $qry12=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
			  		$topmark=0;
					$totalmarklist=0;
					$totalmark=0;
			  while($row1=mysql_fetch_array($qry12))
        		{ $subid1=$row1['sub_id']; 
					$qry45=mysql_query("SELECT * FROM result WHERE c_id='$cid' AND s_id='$sid' AND e_id='$eid' AND sub_id='$subid1' AND ay_id='$acyear'");
					$nopass=mysql_num_rows($qry45);
					$totalmarklist +=$nopass;
					while($row123=mysql_fetch_array($qry45))
        		{
					if($topmark < $row123['mark']){
						$topmark=$row123['mark'];
					}
					$totalmark +=$row123['mark'];					
				}
				 }
				 //echo $topmark."/ ".$totalmarklist." / ".$totalmark; 
				 $avg=0;
				 if($totalmark && $totalmarklist){
				 $avg=$totalmark / $totalmarklist;
				 }
			if($lastexam){	 
				 /* pass parcentage  LAST EXAM*/
		$qyr12=mysql_query("SELECT * FROM student WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
		
		$totalstudents=mysql_num_rows($qyr12);
		$pssfail=0;
			  while($pstudent=mysql_fetch_array($qyr12))
        		{
					$pssid=$pstudent['ss_id'];
		$qr12=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
		$pssfail1=0;
			  while($row1=mysql_fetch_array($qr12))
        		{ 
				$subid1=$row1['sub_id']; 
					$qry451=mysql_query("SELECT * FROM result WHERE c_id='$cid' AND s_id='$sid' AND e_id='$lastexam' AND sub_id='$subid1' AND ss_id='$pssid' AND result='FAIL' AND ay_id='$acyear'");
					$rowsada1=mysql_fetch_array($qry451);
					//echo $rowsada1['result'];
					if($rowsada1){
						$pssfail1++;
					}	
						//echo $pssfail1;			
				}
				//echo $pssfail1;
				if($pssfail1){
				$pssfail++;
				}
				}
				if($totalstudents){
					//echo $totalstudents."/".$pssfail;
					$avgpass1=(($totalstudents-$pssfail)/$totalstudents)*100;
				}
		
		/* Average mark	LAST EXAM*/
		 $qry123=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
			  		$topmark=0;
					$totalmarklist=0;
					$totalmark=0;
			  while($row13=mysql_fetch_array($qry123))
        		{ $subid1=$row13['sub_id']; 
					$qry453=mysql_query("SELECT * FROM result WHERE c_id='$cid' AND s_id='$sid' AND e_id='$lastexam' AND sub_id='$subid1' AND ay_id='$acyear'");
					$nopass=mysql_num_rows($qry453);
					$totalmarklist +=$nopass;
					while($row1233=mysql_fetch_array($qry453))
        		{
					if($topmark < $row1233['mark']){
						$topmark=$row1233['mark'];
					}
					$totalmark +=$row1233['mark'];					
				}
				 }
				 //echo $topmark."/ ".$totalmarklist." / ".$totalmark; 
				 $avg1=0;
				 if($totalmark && $totalmarklist){
				 $avg1=$totalmark / $totalmarklist;
				 }
			}
			
			/*---- Top Total mark --*/
			
			$sstotal=0;
					$ssid11=0;
							$qry12=mysql_query("SELECT * FROM student WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
			  while($row1=mysql_fetch_array($qry12))
        		{ 
				    $sstotal1=0;
					$ssid12=$row1['ss_id'];
					$qry121=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
			  while($row14=mysql_fetch_array($qry121))
        		{ 
				$subid1=$row14['sub_id']; 
					$qry5=mysql_query("SELECT * FROM result WHERE c_id='$cid' AND s_id='$sid' AND e_id='$eid' AND ss_id='$ssid12' AND sub_id='$subid1' AND ay_id='$acyear'");
					$row23=mysql_fetch_array($qry5);
					$sstotal1 +=$row23['mark'];
				}
				if($sstotal < $sstotal1){
					$sstotal=$sstotal1;
					$ssid11=$ssid12;					
				}
				}
				//echo $sstotal." / ".$ssid11; 
				
				/*---- Top Total mark Last exam --*/
			if($lastexam){
			       $ssstotal=0;
					$sssid11=0;
							$qry12a=mysql_query("SELECT * FROM student WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
			  while($row1a=mysql_fetch_array($qry12a))
        		{ 
				    $ssstotal1=0;
					$sssid12=$row1a['ss_id'];
					$qry121a=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
			  while($row14a=mysql_fetch_array($qry121a))
        		{ 
				$subid1=$row14a['sub_id']; 
					$qry5a=mysql_query("SELECT * FROM result WHERE c_id='$cid' AND s_id='$sid' AND e_id='$lastexam' AND ss_id='$sssid12' AND sub_id='$subid1' AND ay_id='$acyear'");
					$row23a=mysql_fetch_array($qry5a);
					$ssstotal1 +=$row23a['mark'];
				}
				if($ssstotal < $ssstotal1){
					$ssstotal=$ssstotal1;
					$sssid11=$sssid12;					
				}
				}
				//echo $ssstotal." / ".$sssid11; 
			}
				 ?>
            
                        <div class="grid_6">
				<div class="block-border">
					<div class="block-header">
						<h1><?php echo $exam['e_name']." Exam";?></h1><span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>Subject</th>
                                    <th>Result</th>
									<th>Mark</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry12=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
			  	$stotal=0;
				$cavgmark=0;
				$ctlist=mysql_num_rows($qry12);				
			  while($row1=mysql_fetch_array($qry12))
        		{ 
				$slid=$row1['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
				$topmark1=0;
					$tpass=0;
					$tfail=0;
				$subid1=$row1['sub_id']; 
					$qry45=mysql_query("SELECT * FROM result WHERE c_id='$cid' AND s_id='$sid' AND e_id='$eid' AND ss_id='$ssid' AND sub_id='$subid1' AND ay_id='$acyear'");
					$row123=mysql_fetch_array($qry45);
        		?>
								<tr class="gradeX" style="border-top:dotted 1px #000;">
                                	<?php 
									$style="background-color:#57d869;";
									if($row123['result']=='FAIL'){
										$style="background-color:#F34245;color:#FFFFFF;";
										}?>
									<td style=" <?php echo $style;?> "><?php echo $slist['s_name'];?></td>
                                    <td style=" <?php echo $style;?> "><?php echo $row123['result'];?></td>
									<td style=" <?php echo $style;?> "><?php echo $row123['mark'];?></td>
								</tr>
                       <?php $stotal +=$row123['mark'];  }
					   if($stotal){
					   $cavgmark=$stotal/$ctlist;}
					    ?>
                       			<tr class="gradeX" style="border-top:dotted 1px #9B9B9B;">
									<td colspan="2" style="background-color:#008fc4; color:#FFF">Total</td>
									<td style="background-color:#008fc4; color:#FFF"><?php echo $stotal;?></td>
								</tr>
							</tbody>
						</table>
                        <ul class="overview-list">
                    		<li><a href="javascript:void(0);">Class Pass Percentage  - <span style="width:80px; font-size:13px;"><?php echo number_format($avgpass,2); ?> %</span></a></li>
							<li><a href="javascript:void(0);">Class Average Mark  -<span style="width:80px; font-size:13px;"><?php echo number_format($avg,2); ?></span></a></li>
                            <li><a href="javascript:void(0);">Class Top Total -<span style="width:80px; font-size:13px;"><?php echo $sstotal; ?></span></a></li>
						</ul>
					</div>
				</div>
			</div>
            <?php if($lastexam){?>
            <div class="grid_6">
				<div class="block-border">
					<div class="block-header">
						<h1>Last Exam ( <?php echo $exam12['e_name'];?> )</h1><span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>Subject</th>
                                    <th>result</th>
									<th>Mark</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry12=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
			  	$stotal1=0;
				$cavgmark1=0;
				$ctlist1=mysql_num_rows($qry12);	
			  while($row1=mysql_fetch_array($qry12))
        		{ 
				$slid=$row1['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
				$topmark1=0;
					$tpass=0;
					$tfail=0;
				$subid1=$row1['sub_id']; 
					$qry45=mysql_query("SELECT * FROM result WHERE c_id='$cid' AND s_id='$sid' AND e_id='$lastexam' AND ss_id='$ssid' AND sub_id='$subid1' AND ay_id='$acyear'");
					$row123=mysql_fetch_array($qry45);
        		?>
								<tr class="gradeX" style="border-top:dotted 1px #000;">
                                <?php 
									$style="background-color:#57d869;";
									if($row123['result']=='FAIL'){
										$style="background-color:#F34245;color:#FFFFFF;";
										}?>
									<td style=" <?php echo $style;?> "><?php echo $slist['s_name'];?></td>
                                    <td style=" <?php echo $style;?> "><?php echo $row123['result'];?></td>
									<td style=" <?php echo $style;?> "><?php echo $row123['mark'];?></td>
								</tr>
                       <?php $stotal1 +=$row123['mark'];  }
					   if($stotal1){
					   $cavgmark1=$stotal1/$ctlist1; }?>
                       			<tr class="gradeX" style="border-top:dotted 1px #9B9B9B;">
									<td colspan="2" style="background-color:#008fc4; color:#FFF">Total</td>
                                    <td style="background-color:#008fc4; color:#FFF"><?php echo $stotal1;?></td>
								</tr>
							</tbody>
						</table>
                        <ul class="overview-list">
                    		<li><a href="javascript:void(0);">Class Pass Percentage - <span style="width:80px; font-size:13px;"><?php echo number_format($avgpass1,2); ?> %</span></a></li>
							<li><a href="javascript:void(0);">Class Average Mark -<span style="width:80px; font-size:13px;"><?php echo number_format($avg1,2); ?></span></a></li>
                            <li><a href="javascript:void(0);">Class Top Total - <span style="width:80px; font-size:13px;"><?php echo $ssstotal; ?></span></a></li>
						</ul>
					</div>
				</div>
			</div>
            <?php } ?>
            		</div>
				</div>
            </div> 
            <div class="clear height-fix"></div>
<?php } ?>
		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <!--<script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>  jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  <?php if(!$_GET['roll']){ include("auto.php"); ?>
  <link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
<?php }else{?>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <?php } ?>
		<style type="text/css">
${demo.css}
		</style>
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
		
		$(function () {
    var gaugeOptions = {

        chart: {
            type: 'solidgauge'
        },

        title: null,

        pane: {
            center: ['50%', '85%'],
            size: '140%',
            startAngle: -90,
            endAngle: 90,
            background: {
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                innerRadius: '60%',
                outerRadius: '100%',
                shape: 'arc'
            }
        },
        tooltip: {
            enabled: false
        },
        // the value axis
        yAxis: {
            stops: [
                [0.1, '#DF5353'], // green
                [0.5, '#DDDF0D'], // yellow
                [0.8, '#6cdf50'], // red
				[0.9, '#55BF3B'], // red
				[0.95, '#247e0e'] // red
            ],
            lineWidth: 0,
            minorTickInterval: null,
            tickPixelInterval: 400,
            tickWidth: 0,
            title: {
                y: -70
            },
            labels: {
                y: 16
            }
        },
        plotOptions: {
            solidgauge: {
                dataLabels: {
                    y: 5,
                    borderWidth: 0,
                    useHTML: true
                }
            }
        }
    };
    // The speed gauge
    $('#container-speed').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 1000,
            title: {
                text: 'last exam - Total Mark (<?php if($lastexam){ echo $exam12['e_name'];}?>)'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Total Mark',
            data: [0],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                       '<span style="font-size:12px;color:silver">Total Mark</span></div>'
            },
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    }));
	// The speed gauge
    $('#container-speed1').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: '<?php echo $exam['e_name']." -";?> Average Mark'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Exam Average Marks',
            data: [0],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                       '<span style="font-size:12px;color:silver">percentage</span></div>'
            },
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    }));
	// The speed gauge
    $('#container-speed3').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 1000,
            title: {
                text: '<?php echo $exam['e_name']." -";?> Total Mark'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Total Mark',
            data: [0],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                       '<span style="font-size:12px;color:silver">percentage</span></div>'
            },
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    }));
	 $('#container-speed4').highcharts(Highcharts.merge(gaugeOptions, {
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Last Exam -Avg Mark (<?php if($lastexam){ echo $exam12['e_name'];}?>)'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Total Mark',
            data: [0],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                       '<span style="font-size:12px;color:silver">percentage</span></div>'
            },
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    }));
 // Bring life to the dials
    setInterval(function () {
        // Speed
        var chart = $('#container-speed').highcharts(),
            point,
            newVal,
            inc;

        if (chart) {
            point = chart.series[0].points[0];
            point.update(<?php echo $stotal1;?>);
        }
		
		var chart = $('#container-speed1').highcharts(),
            point,
            newVal,
            inc;

        if (chart) {
            point = chart.series[0].points[0];
            point.update(<?php echo number_format($cavgmark,2);?>);
        }
		
		var chart = $('#container-speed3').highcharts(),
            point,
            newVal,
            inc;

        if (chart) {
            point = chart.series[0].points[0];
            point.update(<?php echo $stotal;?>);
        }
		
		var chart = $('#container-speed4').highcharts(),
            point,
            newVal,
            inc;

        if (chart) {
            point = chart.series[0].points[0];
            point.update(<?php echo number_format($cavgmark1,2);?>);
        }
    }, 2000);		
		
		// Result Compare With Last Exam
    $('#container1').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Result Compare with last Exam'
        },
        xAxis: {
            categories: [<?php $qry1=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
			  while($row1=mysql_fetch_array($qry1))
        		{ 
				$slid=$row1['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
				$sname=$slist['s_name']; echo "'".$sname."',"; } ?>]
        },
        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of mark'
            }
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>';
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'Mark',
            data: [<?php $qry1=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
			  while($row1=mysql_fetch_array($qry1))
        		{ $subid1=$row1['sub_id']; 
					$qry=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ss_id='$ssid' AND ay_id=$acyear");
					$nopass=mysql_fetch_array($qry);
				   echo $nopass['mark'].",";
				 } ?>],
            stack: 'male'
        }, <?php if($lastexam){?> {
            name: 'Lastexam-Mark',
            data: [<?php $qry1=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
			  while($row1=mysql_fetch_array($qry1))
        		{ $subid1=$row1['sub_id']; 
					$qry=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$lastexam AND sub_id=$subid1 AND ss_id='$ssid' AND ay_id=$acyear");
					$nopass1=mysql_fetch_array($qry);
				   echo $nopass1['mark'].",";
				 } ?>],
            stack: 'female'
        }<?php } ?>]
    });

});
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'result_analysis_student.php?bid='+cid;	  
	} 
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
<script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/highcharts-more.js"></script>

<script src="highcharts/js/modules/solid-gauge.src.js"></script>
</body>
</html>
<? ob_flush(); ?>