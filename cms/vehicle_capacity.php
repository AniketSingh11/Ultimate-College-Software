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
				<li class="no-hover">Vehicle Management</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Bus Capacity</h1>
                <a href="vehicle_capacity_report_exp.php?ayid=<?php echo $acyear;?>&type=all" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Over All Report</button></a> &nbsp; | &nbsp;
                <a href="vehicle_capacity_report_exp.php?ayid=<?php echo $acyear;?>&type=normal" style="margin-left:10px;"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Normal Timing Report</button></a> &nbsp; | &nbsp;
                <a href="vehicle_capacity_report_exp.php?ayid=<?php echo $acyear;?>&type=special" style="margin-left:10px;"><button class="btn btn-small btn-error" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Special Timing Report</button></a>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
            <div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Bus Cpacity</h1>
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
                                    <th><center>Bus No</center></th>
                                    <th><center>Bus Reg.No</center></th>
                                    <th><center>Bus Model No</center></th>
                                    <th><center>Route Name</center></th>
                                    <th><center>Bus Capacity</center></th>
                                    <th><center>Student Capacity</center></th>
                                    <th><center>Staff Capacity</center></th>
                                    <th><center>Vacancy</center></th>
                                    <th><center>Image</center></th>
                                    <th><center>Status</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM vehicle");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
						$vid=$row['v_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE v_id=$vid"); 
								  $row5=mysql_fetch_array($qry5);
								  $rid=$row5['r_id'];
								  
								  $myarray = array();
								  $spqry=mysql_query("SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID");
								  while($sprow=mysql_fetch_array($spqry))
									{
										array_push($myarray,$sprow['stop_id']);										
									}
								  
								  $stucount=0;
								  $staffcount=0;
								  if($rid){
								  $qry1=mysql_query("SELECT * FROM student WHERE sp_id IN (".implode(',',$myarray).") AND busfeestype='0' AND ay_id=$acyear");
								  $stucount=mysql_num_rows($qry1);
								
								  
								  $qry2=mysql_query("SELECT * FROM staff WHERE sp_id IN (".implode(',',$myarray).") AND busfeestype='0'");
								  $staffcount=mysql_num_rows($qry2);
								    }
								  $vacancy=$row['v_capacity']-($stucount+$staffcount);
								  /*$spid1=$invoice['sp_id'];
								  $qry6=mysql_query("SELECT * FROM stopping WHERE sp_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);*/
								  
								  $qry7=mysql_query("SELECT * FROM bustiming WHERE r_id='$rid' AND btime_type='Normal'");
								  $row7=mysql_fetch_array($qry7);
								 
				?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['v_no']; ?></center></td>
                                <td><center><?php echo $row['v_regno']; ?></center></td>
                                <td><center><?php echo $row['v_mno']; ?></center></td>
                                <td><center><?php echo $row5['r_name']; ?></center></td>
                                <td><center><?php echo $row['v_capacity']; ?></center></td>
                                <td><center><?php echo $stucount; ?></center></td>
                                <td><center><?php echo $staffcount; ?></center></td>
                                <td><center><?php echo $vacancy; ?></center></td>
                                <td><center><img src="./img/vehicle/<?php echo $row['photo']; ?>" alt="staff photo" width="40" height="40"></center></td>
                                <td><center><?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
								<td>
                                <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                </tr> 
                                <div id="info-dialog<?php echo $count;?>" title="Vehicle No : <?php echo $row['v_no']; ?> details" style="display: none; width:">
                                <center><img src="./img/vehicle/<?php echo $row['photo']; ?>" alt="staff photo" width="60"></center>
				<p>Bus No : <strong><?php echo $row['v_no']; ?></strong></p>
                
                 <p>Bus Reg.No : <strong><?php echo $row['v_regno']; ?></strong></p> 
                 
                <p>Bus Company Name : <strong><?php echo $row['v_cname']; ?></strong>  </p> 
                
                <p>Bus Model No : <strong><?php echo $row['v_mno']; ?></strong>  </p>   
                
                <p>Bus Capacity : <strong><?php echo $row['v_capacity']; ?></strong>  </p>  
                
                <p>No of Students : <strong><?php echo $stucount; ?></strong>  </p>  
                
                <p>No of Staffs : <strong><?php echo $staffcount; ?></strong>  </p>  
                
                <p>Vacancy : <strong><?php echo $vacancy; ?></strong>  </p>
                
                <p>Morning Timing : <strong><?php echo $row7['m_from']." - ".$row7['m_to']; ?></strong>  </p>  
                
                <p>Evening Timing : <strong><?php echo $row7['e_from']." - ".$row7['e_to']; ?></strong>  </p>   
                
                <center> <?php if($row['status']=='1'){ ?>
                
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
                </div>
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
                                    <th><center>Bus No</center></th>
                                    <th><center>Bus Reg.No</center></th>
                                    <th><center>Bus Model No</center></th>
                                    <th><center>Bus Capacity</center></th>
                                    <th><center>Student Capacity</center></th>
                                    <th><center>Staff Capacity</center></th>
                                    <th><center>Vacancy</center></th>
                                    <th><center>Image</center></th>
                                    <th><center>Status</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM vehicle");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
						$vid=$row['v_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE v_id=$vid"); 
								  $row5=mysql_fetch_array($qry5);
								  
								  $stucount=0;
								  $staffcount=0;
								  $rid=$row5['r_id'];
								  if($rid){
								  $qry1=mysql_query("SELECT * FROM student WHERE r_id=$rid AND (busfeestype='1' OR busfeestype='1') AND ay_id=$acyear");
								  $stucount=mysql_num_rows($qry1);
								  
								  $qry2=mysql_query("SELECT * FROM staff WHERE r_id=$rid AND (busfeestype='1' OR busfeestype='1')");
								  $staffcount=mysql_num_rows($qry2);
								  }
								  $vacancy=$row['v_capacity']-($stucount+$staffcount);
								  /*$spid1=$invoice['sp_id'];
								  $qry6=mysql_query("SELECT * FROM stopping WHERE sp_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);*/
								  $qry7=mysql_query("SELECT * FROM bustiming WHERE r_id='$rid' AND btime_type='Special'");
								  $row7=mysql_fetch_array($qry7);
				?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['v_no']; ?></center></td>
                                <td><center><?php echo $row['v_regno']; ?></center></td>
                                <td><center><?php echo $row['v_mno']; ?></center></td>
                                <td><center><?php echo $row['v_capacity']; ?></center></td>
                                <td><center><?php echo $stucount; ?></center></td>
                                <td><center><?php echo $staffcount; ?></center></td>
                                <td><center><?php echo $vacancy; ?></center></td>
                                <td><center><img src="./img/vehicle/<?php echo $row['photo']; ?>" alt="staff photo" width="40" height="40"></center></td>
                                <td><center><?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
								<td>
                                <a href="javascript:void(0);" onclick="$('#info-dialog1<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                </tr> 
                                <div id="info-dialog1<?php echo $count;?>" title="Vehicle No : <?php echo $row['v_no']; ?> details" style="display: none; width:">
                                <center><img src="./img/vehicle/<?php echo $row['photo']; ?>" alt="staff photo" width="60"></center>
				<p>Bus No : <strong><?php echo $row['v_no']; ?></strong></p>
                
                 <p>Bus Reg.No : <strong><?php echo $row['v_regno']; ?></strong></p> 
                 
                <p>Bus Company Name : <strong><?php echo $row['v_cname']; ?></strong>  </p> 
                
                <p>Bus Model No : <strong><?php echo $row['v_mno']; ?></strong>  </p>   
                
                <p>Bus Capacity : <strong><?php echo $row['v_capacity']; ?></strong>  </p>  
                
                <p>No of Students : <strong><?php echo $stucount; ?></strong>  </p>  
                
                <p>No of Staffs : <strong><?php echo $staffcount; ?></strong>  </p>  
                
                <p>Vacancy : <strong><?php echo $vacancy; ?></strong>  </p>   
                
                <p>Morning Timing : <strong><?php echo $row7['m_from']." - ".$row7['m_to']; ?></strong>  </p>  
                
                <p>Evening Timing : <strong><?php echo $row7['e_from']." - ".$row7['e_to']; ?></strong>  </p>  
                
                <center> <?php if($row['status']=='1'){ ?>
                
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
                </div>
                                 <?php 
							$count++;
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
		$('#table-example').dataTable();
		$('#table-example1').dataTable();
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
  
</body>
</html>
<? ob_flush(); ?>