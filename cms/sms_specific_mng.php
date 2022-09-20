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
				<li class="no-hover">Specific SMS Management</li>
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">			
			<div class="grid_12">
				<h1>Specific SMS Management</h1>
                <a href="#" title="add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> SMS to Specific Staffs</button></a> | <a href="sms_student_add.php" title="add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> SMS to Specific Students</button></a> |
                
               <a href="#" title="add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> SMS to Specific Others Staffs</button></a> |
                  <a href="#" title="add"><button class="btn btn-small btn-success"><img src="img/icons/packs/fugue/16x16/table--plus.png"> SMS to Specific Driver</button></a> 
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Circular Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
            <div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Specific SMS Management</h1>
						<ul class="tabs" style="margin-right:60px;">
							<li><a href="#tab-1">SMS To Specific Staff </a></li>
							<li><a href="#tab-2">SMS To Specific Student </a></li>
							<li><a href="#tab-3">SMS To Other Staff </a></li>
							<li><a href="#tab-4">SMS To Driver </a></li>
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
                                    <th>Date</th>
                                    <th><center>Staff Name</center></th>
                                    <th><center>Phone No</center></th>
                                    <th><center>Title</center></th>
                                    <th><center>Msg Details</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM mobile_sms_specific WHERE st_id AND ay_id=$acyear ORDER BY id DESC");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				$stid=$row['st_id'];
				$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								  $staff=mysql_fetch_array($stafflist);
								?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['date']; ?></center></td>
                                <td><center><?php echo $staff['fname']." ".$staff['lname']; ?></center></td>
                                <td><center><?php echo $staff['phone_no']; ?></center></td>
                                <td><center><?php echo $row['title']; ?></center></td>
                                <td><center><?php echo $row['msg'];  ?></center></td>
                                <td width="100px">
                                <a href="javascript:void(0);" onclick="$('#info-dialog1<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog1<?php echo $count;?>" title="SMS Details" style="display: none;">
                                
				<p>date : <strong><?php echo $row['date']; ?></strong></p>
                
                <p>Staff Name : <strong><?php echo $staff['fname']." ".$staff['lname']; ?></strong></p>
                
                <p>Phone No : <strong><?php echo $staff['phone_no']; ?></strong></p>
                
                 <p>Title : <strong><?php echo $row['title']; ?></strong></p> 
                
                <p>Msg Details : <strong><?php echo $row['msg']; ?></strong>  </p>   
                
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
							<table id="table-example2" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Date</th>
                                    <th><center>student Name</center></th>
                                    <th><center>Phone No</center></th>
                                    <th><center>Title</center></th>
                                    <th><center>Msg Details</center></th>
                                    <th>Board</th>
                                    <th>Class-Section</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry1=mysql_query("SELECT * FROM mobile_sms_specific WHERE ss_id AND ay_id=$acyear ORDER BY id DESC");
							$count11=1;
			  while($row1=mysql_fetch_array($qry1))
        		{ 
				$ssid=$row1['ss_id'];
				$studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student=mysql_fetch_array($studentlist);
						$bid1=$row1['b_id'];
								  $boardlist1=mysql_query("SELECT * FROM board WHERE b_id=$bid1"); 
								  $board1=mysql_fetch_array($boardlist1);
						$cid1=$row1['c_id'];
								  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $class1=mysql_fetch_array($classlist1);
						$sid1=$row1['s_id'];
								  $sectionlist1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $section1=mysql_fetch_array($sectionlist1);
								  ?>
								<tr class="gradeX">
                                <td class="sno center"><center><?php echo $count11; ?></center></td>
								<td><center><?php echo $row1['date']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['phone_number']; ?></center></td>
                                <td><center><?php echo $row1['title']; ?></center></td>
                                <td><center><?php echo $row1['msg'];  ?></center></td>
                                <td><center><?php if($board1['b_name']){ echo $board1['b_name'];}?></center></td>
                                <td><center><?php echo $class1['c_name']."-".$section1['s_name']; ?></center></td>
                                <td width="100px">
                                <a href="javascript:void(0);" onclick="$('#info-dialog11<?php echo $count11;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog11<?php echo $count11;?>" title="SMS Details" style="display: none;">
                                
				<p>date : <strong><?php echo $row1['date']; ?></strong></p>
                
                 <p>Student Name : <strong><?php echo $student['firstname']." ".$student['lastname']; ?></strong></p>
                 
                 <p>Phone No : <strong><?php echo $student['phone_number']; ?></strong></p>
                 
                 <p>Title : <strong><?php echo $row1['title']; ?></strong></p> 
                
                <p>Msg Details : <strong><?php echo $row1['msg']; ?></strong>  </p>
                
                <p>Board: <strong><?php if($board1['b_name']){ echo $board1['b_name'];} ?></strong>  </p>
                
                <p>Class/Section : <strong><?php echo $class1['c_name']."-".$section1['s_name']; ?></strong></p>
                
                </div>
                                 <?php 
							$count11++;
							} ?>                               																
							</tbody>
						</table>
                        <br>
						</div>		
						
						<div id="tab-3" class="tab-content">
                        <br>
							<table id="table-example3" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Date</th>
                                    <th><center>OtherStaff Name</center></th>
                                    <th><center>Phone No</center></th>
                                    <th><center>Title</center></th>
                                    <th><center>Msg Details</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM mobile_sms_specific WHERE o_id AND ay_id=$acyear ORDER BY id DESC");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				$stid=$row['o_id'];
				$stafflist=mysql_query("SELECT * FROM others WHERE o_id=$stid"); 
								  $staff=mysql_fetch_array($stafflist);
								?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['date']; ?></center></td>
                                <td><center><?php echo $staff['fname']." ".$staff['lname']; ?></center></td>
                                <td><center><?php echo $staff['phone_no']; ?></center></td>
                                <td><center><?php echo $row['title']; ?></center></td>
                                <td><center><?php echo $row['msg'];  ?></center></td>
                                <td width="100px">
                                <a href="javascript:void(0);" onclick="$('#info-dialog111<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog1<?php echo $count;?>" title="SMS Details" style="display: none;">
                                
				<p>date : <strong><?php echo $row['date']; ?></strong></p>
                
                <p>Staff Name : <strong><?php echo $staff['fname']." ".$staff['lname']; ?></strong></p>
                
                <p>Phone No : <strong><?php echo $staff['phone_no']; ?></strong></p>
                
                 <p>Title : <strong><?php echo $row['title']; ?></strong></p> 
                
                <p>Msg Details : <strong><?php echo $row['msg']; ?></strong>  </p>   
                
                </div>
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
                        <br>
						</div>	
						
						
						
						<div id="tab-4" class="tab-content">
                        <br>
							<table id="table-example4" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Date</th>
                                    <th><center>Driver Name</center></th>
                                    <th><center>Phone No</center></th>
                                    <th><center>Title</center></th>
                                    <th><center>Msg Details</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM mobile_sms_specific WHERE d_id AND ay_id=$acyear ORDER BY id DESC");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				$stid=$row['d_id'];
				$stafflist=mysql_query("SELECT * FROM driver WHERE d_id=$stid"); 
								  $staff=mysql_fetch_array($stafflist);
								?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['date']; ?></center></td>
                                <td><center><?php echo $staff['fname']." ".$staff['lname']; ?></center></td>
                                <td><center><?php echo $staff['phone_no']; ?></center></td>
                                <td><center><?php echo $row['title']; ?></center></td>
                                <td><center><?php echo $row['msg'];  ?></center></td>
                                <td width="100px">
                                <a href="javascript:void(0);" onclick="$('#info-dialog1111<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog1<?php echo $count;?>" title="SMS Details" style="display: none;">
                                
				<p>date : <strong><?php echo $row['date']; ?></strong></p>
                
                <p>Staff Name : <strong><?php echo $staff['fname']." ".$staff['lname']; ?></strong></p>
                
                <p>Phone No : <strong><?php echo $staff['phone_no']; ?></strong></p>
                
                 <p>Title : <strong><?php echo $row['title']; ?></strong></p> 
                
                <p>Msg Details : <strong><?php echo $row['msg']; ?></strong>  </p>   
                
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
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
  <script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	$('#table-example').dataTable();
		$('#table-example1').dataTable();
		$('#table-example2').dataTable();
		$('#table-example3').dataTable();
		$('#table-example4').dataTable();
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