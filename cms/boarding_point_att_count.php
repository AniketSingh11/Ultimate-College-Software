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
    	<?php include("nav.php");
		$today=date("d/m/Y");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>				
                <li class="no-hover">Today Boarding Point Count</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">        		
			<div class="container_12">		
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Route Master</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get" action="student_mng.php">
						<div class="_50">
							<p>
								<label for="select">Route Master :</label>
                                		<?php
                                            $result1 = mysql_query("SELECT * FROM route") or die(mysql_error());
                                            echo '<select name="rid" id="rid"> 
											<option value="all">All</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['r_id']}'>{$row1['r_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Date : <span class="error">*</span></label>
                               <input id="datepicker" name="date" class="required" type="text" value="<?php echo $today;?>" /> 	
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
					$rid=$_GET['rid'];
					$date=$_GET['date'];
					$routename= "All ";
					if($rid){	
					
					$sdate_split1= explode('/', $date);		 
		  $sdate_day=$sdate_split1[0];
		  $sdate_month=$sdate_split1[1];
		  $sdate_year=$sdate_split1[2];
		  $startdate= $sdate_year.$sdate_month.$sdate_day;
		  						 
							 	if($rid!="all"){
									$classlist=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  	$class=mysql_fetch_assoc($classlist);
								  	$vid=$class['v_id'];
									$did=$class['d_id'];
									$sdid=$class['sd_id'];
									$vehiclelist=mysql_query("SELECT * FROM vehicle WHERE v_id=$vid"); 
									$vehicle=mysql_fetch_assoc($vehiclelist);
									$driverlist=mysql_query("SELECT * FROM driver WHERE d_id=$did"); 
									$driver=mysql_fetch_assoc($driverlist);
									$driverlist1=mysql_query("SELECT * FROM driver WHERE d_id=$sdid"); 
									$driver1=mysql_fetch_assoc($driverlist1);
									$routename=$class['r_name'];
								}
								  ?>
			<div class="grid_12">
				<h1><?php  echo $routename;?> - Route Student Boarding Point (<?php echo $sdate_day."/".$sdate_month."/".$sdate_year; ?>)</h1>
                <a href="boarding_point_att_count_prt.php?rid=<?php echo $rid;?>&ayid=<?php echo $acyear;?>&date=<?php echo $date;?>" style="margin-left:10px;" target="_blank" ><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Print Report</button></a>
                <?php if($rid!="all"){ ?>
                <span style="margin:0px 10px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/truck--plus.png"> Vehicle No - <strong><?php echo $vehicle['v_no']; ?></strong> &nbsp; | &nbsp;<img src="img/icons/packs/fugue/16x16/user-thief-baldie.png"> Driver Name - <strong><?php echo $driver['fname']." ".$driver['lname']; ?></strong> &nbsp; | &nbsp;<img src="img/icons/packs/fugue/16x16/user-yellow-female.png"> Bus Assistant - <strong><?php echo $driver1['fname']." ".$driver1['lname']; ?></strong></span>
                <?php } ?>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php }?>  
           </div>
            <div class="grid_12">
            	<div class="block-border">
					<div class="block-header">
                    	<h1><?php  echo $routename;?> - Route Stop Details (<?php echo $sdate_day."/".$sdate_month."/".$sdate_year; ?>)</h1>
                        <span></span>
					</div>
					<div class="block-content">
                    	<table class="table" border="1">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Route Name<center></th>
                                    <th colspan="3">Actual Total</th> 
                                    <th><center>Boys</center></th>
                                    <th><center>Girls</center></th>
                                    <th>Total</th>            
								</tr>
							</thead>
							<tbody>
                            <tr class="gradeX">
								<td class="sno center"></td>
								<td></td>
                                <td><center>Boys</center></td>
                                <td><center>Girls</td>
                                <td><center>Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <tr>
                            <?php 
							$atotal=0; $ttotal=0; $tboys=0; $tgirls=0; $totalboys=0; $totalgirls=0;
							$routeqry="SELECT r_id,r_name FROM route";
							if($rid!="all"){
								$routeqry .=" WHERE r_id=$rid";
							}
					$route=mysql_query($routeqry);
							$count=1;
			  while($rlist=mysql_fetch_assoc($route))
        		{		
							$rid1=$rlist['r_id'];
							$myarray = array();
								  $qry=mysql_query("SELECT * FROM trstopping WHERE r_id=$rid1 ORDER BY ListingID");
								  while($row=mysql_fetch_assoc($qry))
									{
										array_push($myarray,$row['stop_id']);										
									}
						$total=0; $boys=0; $girls=0; $totalstudent=0;	 $aboys=0; $agirls=0;		
							$qry=mysql_query("SELECT ss_id,gender,c_id,s_id,b_id FROM student WHERE sp_id IN (".implode(',',$myarray).") AND ay_id=$acyear ORDER BY FIND_IN_SET(sp_id, '".implode(',',$myarray)."')");
			  while($row=mysql_fetch_assoc($qry))
        		{
					$totalstudent++;
					$ssid=$row['ss_id'];
					$gender=$row['gender'];
					$cid=$row['c_id'];
				$sid=$row['s_id'];
						  $bid=$row['b_id'];								    
						  $spid1=$row['sp_id'];	
						  	if($gender=="M"){
							$aboys++;
							}else if($gender=="F"){
								$agirls++;
							}					  	  
						  $select_record2=mysql_query("SELECT att_id FROM attendance WHERE c_id=$cid AND s_id=$sid AND day=$sdate_day AND month=$sdate_month AND year=$sdate_year AND ay_id=$acyear AND ss_id=$ssid AND (result=1 OR (result='off' AND result_half='M'))");
					if($monthday=mysql_fetch_assoc($select_record2)){
						if($gender=="M"){
							$boys++;
						}else if($gender=="F"){
							$girls++;
						}
					}
				}
				$total=$boys+$girls;
				$atotal +=$totalstudent;
				$totalboys +=$aboys;
				$totalgirls +=$agirls;
				$ttotal +=$total;
				$tboys +=$boys;
				$tgirls +=$girls;
				?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $rlist['r_name']; ?></center></td>
                                <td><center><?php echo $aboys; ?></center></td>
                                <td><center><?php echo $agirls; ?></center></td>
                                <td><center><?php echo $totalstudent; ?></center></td>
                                <td><center><?php echo $boys;  ?></center></td>
                                <td><center><?php echo $girls; ?></center></td>
                                <td><center><?php echo $total; ?></center></td>
                                <tr>
                                 <?php 
					$count++;
					}?>            
                    			<tr class="gradeX">
								<td colspan="2"><center><b>Total</b></center></td>
                                <td><center><b><?php echo $totalboys; ?></b></center></td>
                                <td><center><b><?php echo $totalgirls; ?></b></center></td>
                                <td><center><b><?php echo $atotal; ?></b></center></td>
                                <td><center><b><?php echo $tboys;  ?></b></center></td>
                                <td><center><b><?php echo $tgirls; ?></b></center></td>
                                <td><center><b><?php echo $ttotal; ?></b></center></td> 
                                </tr>                 																
							</tbody>
						</table>
					</div>
				</div>
                
			</div><?php } ?>
            <div class="clear height-fix"></div>

		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->
    
    <?php include("includes/footer.php");?>
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
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  <script defer src="js/zebra_datepicker.js"></script>
  
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'd/m/Y'
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
  
</body>
</html>
<? ob_flush(); ?>