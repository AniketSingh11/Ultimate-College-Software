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
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                 <li class="no-hover"><a href="board_select_exam.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="javascript: window.history.go(-1)" title="Exam Results Management">Exam Results Management</a></li>                <li class="no-hover">Result Analysis</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <?php
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$eid=$_GET['eid'];
							$subid=$_GET['subid'];
							
							
				if($cid && $sid && $eid){
							$examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							if($subid){
							$subjectlist=mysql_query("SELECT * FROM subject WHERE sub_id=$subid AND extra_sub=0"); 
								  $subject=mysql_fetch_array($subjectlist);
								  $slid1=$subject['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid1' AND extra_sub=0"); 
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
		<div class="grid_12">
				<h1><?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result Analysis</h1>
                <a href="javascript: window.history.go(-1)" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
                    	<div id="container-speed3" style="width: 300px; height: 200px; float: left"></div>
						<div id="container-speed1" style="width: 300px; height: 200px; float: left"></div>
                        <div id="container-speed" style="width: 300px; height: 200px; float: left"></div>
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
		$qr12=mysql_query("SELECT * FROM subject WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
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
		 $qry12=mysql_query("SELECT * FROM subject WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
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
		$qr12=mysql_query("SELECT * FROM subject WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
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
					
					$avgpass1=(($totalstudents-$pssfail)/$totalstudents)*100;
				}
		
		/* Average mark	LAST EXAM*/
		 $qry123=mysql_query("SELECT * FROM subject WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
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
				 ?>
            
                        <div class="grid_4">
				<div class="block-border">
					<div class="block-header">
						<h1><?php echo $exam['e_name']." Exam";?></h1><span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>Subject</th>
									<th>Pass</th>
									<th>Fail</th>
                                    <th>%</th>
									<th>Top Mark</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry12=mysql_query("SELECT * FROM subject WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
			  while($row1=mysql_fetch_array($qry12))
        		{ 
				$slid=$row1['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid' AND extra_sub=0"); 
								   $slist=mysql_fetch_array($subjectlist1);
				$topmark1=0;
					$tpass=0;
					$tfail=0;
				$subid1=$row1['sub_id']; 
					$qry45=mysql_query("SELECT * FROM result WHERE c_id='$cid' AND s_id='$sid' AND e_id='$eid' AND sub_id='$subid1' AND ay_id='$acyear'");
					$nopass=mysql_num_rows($qry45);
					$totalmarklist +=$nopass;
					while($row123=mysql_fetch_array($qry45))
        		{
					if($topmark1 < $row123['mark']){
						$topmark1=$row123['mark'];
					}
					if($row123['result']=='PASS'){
						$tpass++;
					}else if($row123['result']=='FAIL'){
						$tfail++;
					}					
				}
				if($tpass){
				$paspercent=($tpass/$nopass)*100;
				}
				?>
								<tr class="gradeX" style="border-top:dotted 1px #000;">
									<td><?php echo $slist['s_name'];?></td>
									<td style="background-color:#57d869;"><?php echo $tpass;?></td>
									<td style="background-color:#F34245; color:#FFF"><?php echo $tfail;?></td>
                                    <td style="background-color:#deb713;"><?php echo round($paspercent);?></td>
									<td class="center" style="background-color:#008fc4; color:#FFF"><?php echo $topmark1;?></td>									
								</tr>
                       <?php  } ?>
							</tbody>
						</table>
                        <ul class="overview-list">
                    		<li><a href="javascript:void(0);">Exam Pass   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - <span style="width:80px; font-size:13px;"><?php echo number_format($avgpass,2); ?> %</span></a></li>
							<li><a href="javascript:void(0);">Average Mark -<span style="width:80px; font-size:13px;"><?php echo number_format($avg,2); ?></span></a></li>
						</ul>
					</div>
				</div>
			</div>
            <?php if($lastexam){?>
            <div class="grid_4">
				<div class="block-border">
					<div class="block-header">
						<h1>Last Exam ( <?php echo $exam12['e_name'];?> )</h1><span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>Subject</th>
									<th>Pass</th>
									<th>Fail</th>
                                    <th>%</th>
									<th>Top Mark</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry12=mysql_query("SELECT * FROM subject WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
			  while($row1=mysql_fetch_array($qry12))
        		{ 
				$slid=$row1['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid' AND extra_sub=0"); 
								   $slist=mysql_fetch_array($subjectlist1);
				$topmark1=0;
					$tpass=0;
					$tfail=0;
				$subid1=$row1['sub_id']; 
					$qry45=mysql_query("SELECT * FROM result WHERE c_id='$cid' AND s_id='$sid' AND e_id='$lastexam' AND sub_id='$subid1' AND ay_id='$acyear'");
					$nopass=mysql_num_rows($qry45);
					$totalmarklist +=$nopass;
					while($row123=mysql_fetch_array($qry45))
        		{
					if($topmark1 < $row123['mark']){
						$topmark1=$row123['mark'];
					}
					if($row123['result']=='PASS'){
						$tpass++;
					}else if($row123['result']=='FAIL'){
						$tfail++;
					}					
				}
				if($tpass){
				$paspercent=($tpass/$nopass)*100;
				}
				?>
								<tr class="gradeX" style="border-top:dotted 1px #000;">
									<td><?php echo $slist['s_name'];?></td>
									<td style="background-color:#57d869;"><?php echo $tpass;?></td>
									<td style="background-color:#F34245; color:#FFF"><?php echo $tfail;?></td>
                                    <td style="background-color:#deb713;"><?php echo round($paspercent);?></td>
									<td class="center" style="background-color:#008fc4; color:#FFF"><?php echo $topmark1;?></td>									
								</tr>
                       <?php  } ?>
							</tbody>
						</table>
                        <ul class="overview-list">
                    		<li><a href="javascript:void(0);">Exam Pass   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - <span style="width:80px; font-size:13px;"><?php echo number_format($avgpass1,2); ?> %</span></a></li>
							<li><a href="javascript:void(0);">Average Mark -<span style="width:80px; font-size:13px;"><?php echo number_format($avg1,2); ?></span></a></li>
						</ul>
					</div>
				</div>
			</div>
            <?php } 
			
			$sstotal=0;
					$ssid11=0;
							$qry12=mysql_query("SELECT * FROM student WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
			  while($row1=mysql_fetch_array($qry12))
        		{ 
				    $sstotal1=0;
					$ssid12=$row1['ss_id'];
					$qry121=mysql_query("SELECT * FROM subject WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
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
				?>
            <div class="grid_4">
				<div class="block-border">
					<div class="block-header">
						<h1>Top Student</h1><span></span>
					</div>
					<div class="block-content">
                    <ul class="overview-list">
                    <?php 
					$studentlist=mysql_query("SELECT * FROM student WHERE ss_id='$ssid11'"); 
								  $studentl=mysql_fetch_array($studentlist);
					?>
                    		<li><a href="javascript:void(0);">Admission No - <span style="width:80px; font-size:13px;"><?php echo $studentl['admission_number']; ?></span></a></li>
							<li><a href="javascript:void(0);">Student Name - <span style="width:80px; font-size:13px;"><?php echo $studentl['firstname']." ".$studentl['lastname']; ?></span></a></li>
						</ul>
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>Subject</th>
									<th>Mark</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry12=mysql_query("SELECT * FROM subject WHERE c_id='$cid' AND s_id='$sid' AND ay_id='$acyear'");
			  	$stotal=0;
			  while($row1=mysql_fetch_array($qry12))
        		{ 
				$slid=$row1['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid' AND extra_sub=0"); 
								   $slist=mysql_fetch_array($subjectlist1);
				$topmark1=0;
					$tpass=0;
					$tfail=0;
				$subid1=$row1['sub_id']; 
					$qry45=mysql_query("SELECT * FROM result WHERE c_id='$cid' AND s_id='$sid' AND e_id='$eid' AND ss_id='$ssid11' AND sub_id='$subid1' AND ay_id='$acyear'");
					$row123=mysql_fetch_array($qry45);
        		?>
								<tr class="gradeX" style="border-top:dotted 1px #000;">
                                <?php 
									$style="background-color:#57d869;"; ?>
									<td style=" <?php echo $style;?> "><?php echo $slist['s_name'];?></td>
									<td style=" <?php echo $style;?> "><?php echo $row123['mark'];?></td>
								</tr>
                       <?php $stotal +=$row123['mark'];  } ?>
                       			<tr class="gradeX" style="border-top:dotted 1px #9B9B9B;">
									<td style="background-color:#008fc4; color:#FFF">Total</td>
									<td style="background-color:#008fc4; color:#FFF"><?php echo $stotal;?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
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
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
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
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		/*
		 * DataTables
		 */
		
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
            max: 100,
            title: {
                text: 'Top Mark'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Top Mark',
            data: [0],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                       '<span style="font-size:12px;color:silver">Mark</span></div>'
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
                text: 'Exam Average Mark'
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
            max: 100,
            title: {
                text: 'Exam Pass'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Exam Pass',
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
            point.update(<?php echo $topmark;?>);
        }
		
		var chart = $('#container-speed1').highcharts(),
            point,
            newVal,
            inc;

        if (chart) {
            point = chart.series[0].points[0];
            point.update(<?php echo number_format($avg,2);?>);
        }
		
		var chart = $('#container-speed3').highcharts(),
            point,
            newVal,
            inc;

        if (chart) {
            point = chart.series[0].points[0];
            point.update(<?php echo number_format($avgpass,2);?>);
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
            categories: [<?php $qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
			  while($row1=mysql_fetch_array($qry1))
        		{ 
				$slid=$row1['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid' AND extra_sub=0"); 
								   $slist=mysql_fetch_array($subjectlist1);
				$sname=$slist['s_name']; echo "'".$sname."',"; } ?>]
        },
        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of Students'
            }
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'Pass',
            data: [<?php $qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
			  while($row1=mysql_fetch_array($qry1))
        		{ $subid1=$row1['sub_id']; 
					$qry=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND result='PASS' AND ay_id=$acyear");
					$nopass=mysql_num_rows($qry);
				   echo $nopass.",";
				 } ?>],
            stack: 'male'
        }, {
            name: 'Fail',
            data: [<?php $qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
			  while($row1=mysql_fetch_array($qry1))
        		{ $subid1=$row1['sub_id']; 
					$qry=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND result='FAIL' AND ay_id=$acyear");
					$nofail=mysql_num_rows($qry);
				   echo $nofail.",";
				 } ?>],
            stack: 'male'
        },<?php if($lastexam){?> {
            name: 'Lastexam-Pass',
            data: [<?php $qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
			  while($row1=mysql_fetch_array($qry1))
        		{ $subid1=$row1['sub_id']; 
					$qry=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$lastexam AND sub_id=$subid1 AND result='PASS' AND ay_id=$acyear");
					$nopass=mysql_num_rows($qry);
				   echo $nopass.",";
				 } ?>],
            stack: 'female'
        }, {
            name: 'Lastexam-Fail',
            data: [<?php $qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
			  while($row1=mysql_fetch_array($qry1))
        		{ $subid1=$row1['sub_id']; 
					$qry=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$lastexam AND sub_id=$subid1 AND result='FAIL' AND ay_id=$acyear");
					$nofail=mysql_num_rows($qry);
				   echo $nofail.",";
				 } ?>],
            stack: 'female'
        } <?php } ?>]
    });

});
	});
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