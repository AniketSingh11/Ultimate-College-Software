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
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>				
                <li class="no-hover">Route Stop Details</li>
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
								<label for="select">Route Master : <span class="error">*</span></label>
                                	<?php
                                            $result1 = mysql_query("SELECT * FROM route") or die(mysql_error());
                                            echo '<select name="rid" id="rid" class="required"> <option value="">Select Route Master</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['r_id']}'>{$row1['r_name']}</option>\n";
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
					$rid=$_GET['rid'];
					if($rid){							 
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
								  ?>
			<div class="grid_12">
				<h1><?php  echo $class['r_name'];?> - Route Student/Staff Boarding Point Details</h1>
                <a href="boarding_point_report_exp.php?rid=<?php echo $rid;?>&ayid=<?php echo $acyear;?>" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Download Report</button></a>
                <a href="busstage_pdf.php?rid=<?php echo $rid;?>&ayid=<?php echo $acyear;?>" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Pdf Report</button></a>
                <span style="margin:0px 10px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/truck--plus.png"> Vehicle No - <strong><?php echo $vehicle['v_no']; ?></strong> &nbsp; | &nbsp;<img src="img/icons/packs/fugue/16x16/user-thief-baldie.png"> Driver Name - <strong><?php echo $driver['fname']." ".$driver['lname']; ?></strong> &nbsp; | &nbsp;<img src="img/icons/packs/fugue/16x16/user-yellow-female.png"> Bus Assistant - <strong><?php echo $driver1['fname']." ".$driver1['lname']; ?></strong></span>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php }?>  
           </div>
            <div class="grid_12">
            	<div class="block-border">
					<div class="block-header">
                    	<h1><?php  echo $class['r_name'];?> - Route Stop Details</h1>
                        <span></span>
					</div>
					<div class="block-content">
                    	<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Admin No/Staff ID<center></th>
                                    <th><center>Student/Staff Name</center></th>
                                    <th><center>Class-Section( Board )</center></th>
                                    <th>Boarding Point</th>
                                    <th>Bus Type</th>
                                    <th><center>Type</center></th>                                    
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM student WHERE sp_id IN (".implode(',',$myarray).") AND ay_id=$acyear ORDER BY FIND_IN_SET(sp_id, '".implode(',',$myarray)."')");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$cid=$row['c_id'];
				$sid=$row['s_id'];
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
								  
								  $bid=$row['b_id'];
								$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								    
								  $spid1=$row['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $fesstypearray1=array("Regural Bus","Sp.Bus","Onetime Sp.Bus","Onetime Bus"); 
								  $busfeestype1=$row['busfeestype'];
								  
								  ?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['admission_number']; ?></center></td>
                                <td><center><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname'];  ?></center></td>
                                <td><center><?php echo $class['c_name']." / ".$section['s_name']." ( ".$board['b_name']." )"; ?></center></td>
                                <td><center><?php echo $row6['stop_name']; ?></center></td>
                                <td><center><?php echo $fesstypearray1[$busfeestype1]; ?></center></td>
                                <td><center>Student</center></td>
                                 <?php 
							$count++;
							} 
							
							
							$qry=mysql_query("SELECT * FROM staff WHERE sp_id IN (".implode(',',$myarray).") AND status=1");
			  while($row=mysql_fetch_array($qry))
        		{
								  $spid1=$row['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $fesstypearray1=array("Regural Bus","Sp.Bus","Onetime Sp.Bus","Onetime Bus"); 
								  $busfeestype1=$row['busfeestype'];
								  
								  ?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['staff_id']; ?></center></td>
                                <td><center><?php echo $row['fname']." ".$row['mname']." ".$row['lname'];  ?></center></td>
                                <td><center> - </center></td>
                                <td><center><?php echo $row6['stop_name']; ?></center></td>
                                <td><center><?php echo $fesstypearray1[$busfeestype1]; ?></center></td>
                                <td><center>Staff</center></td>
                                 <?php 
							$count++;
							} ?>                              																
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
  
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
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