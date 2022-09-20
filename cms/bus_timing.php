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
				<li class="no-hover">Bus Timing Management</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Bus Timing Management</h1>
                <a href="bustiming_add.php" title="add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
            <div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Bus Timing Management</h1>
						<ul class="tabs" style="margin-right:60px;">
							<li><a href="#tab-1">Normal-Timing</a></li>
							<li><a href="#tab-2">Special-Timing</a></li>
						</ul>
                        <span></span>
					</div>
					<div class="block-content tab-container">
						<div id="tab-1" class="tab-content">
							<br>
							<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Route Name</center></th>
                                    <th><center>Vehicle No</center></th>
                                    <th><center>Driver Name</center></th>
                                    <th><center>Bus Assistant</center></th>
                                    <th><center>Morning Timing</center></th>
                                    <th><center>Evening Timing</center></th>
                                    <th><center>Stoppings</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM bustiming WHERE btime_type='Normal' AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
						$rid=$row['r_id'];
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
						?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $class['r_name']; ?></center></td>
                                <td><center><?php echo $vehicle['v_no']; ?></center></td>
                                <td><center><?php echo $driver['fname']." ".$driver['lname']; ?></center></td>
                                <td><center><?php echo $driver1['fname']." ".$driver1['lname']; ?></center></td>
                                <td><center><?php echo $row['m_from']." - ".$row['m_to']; ?></center></td>
                                <td><center><?php echo $row['e_from']." - ".$row['e_to']; ?></center></td>
                                <td><center><a href="bstopping.php?rid=<?php echo $class['r_id'];?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
                                <td width="80px">
                                 <a href="bustiming_edit.php?btimeid=<?php echo $row['btime_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="bustiming_delete.php?btimeid=<?php echo $row['btime_id'];?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 </td>
								</tr> 
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
                        <br>
						</div>
						<div id="tab-2" class="tab-content">
                        <br>
							<table id="table-example1" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Route Name</center></th>
                                    <th><center>Vehicle No</center></th>
                                    <th><center>Driver Name</center></th>
                                    <th><center>Bus Assistant</center></th>
                                    <th><center>Morning Timing</center></th>
                                    <th><center>Evening Timing</center></th>
                                    <th><center>Stoppings</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM bustiming WHERE btime_type='Special' AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
						$rid=$row['r_id'];
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
								$driver1=mysql_fetch_array($driverlist1);?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $class['r_name']; ?></center></td>
                                <td><center><?php echo $vehicle['v_no']; ?></center></td>
                                <td><center><?php echo $driver['fname']." ".$driver['lname']; ?></center></td>
                                <td><center><?php echo $driver1['fname']." ".$driver1['lname']; ?></center></td>
                                <td><center><?php echo $row['m_from']." - ".$row['m_to']; ?></center></td>
                                <td><center><?php echo $row['e_from']." - ".$row['e_to']; ?></center></td>
                                <td><center><a href="bstopping.php?rid=<?php echo $class['r_id'];?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
                                <td width="80px">
                                 <a href="bustiming_edit.php?btimeid=<?php echo $row['btime_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="bustiming_delete.php?btimeid=<?php echo $row['btime_id'];?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 </td>
								</tr> 
                                 <?php 
							$count1++;
							} ?>                               																
							</tbody>
						</table>
                        <br>
						</div>						
					</div>
				</div>
			</div>
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
	$('#table-example').dataTable();
	$('#table-example1').dataTable();
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
			validateform.resetForm();
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		/*
		 * DataTables
		 */
		
		$("#tab-panel-1").createTabs();
		
	});
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>