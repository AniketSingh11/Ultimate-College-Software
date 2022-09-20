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
				<li class="no-hover">Permission Management</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Permission Management</h1>
                <a href="permission_add.php"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
            <div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Permission Management</h1>
						<ul class="tabs" style="margin-right:60px;">
							<li><a href="#tab-1">Student</a></li>
							<li><a href="#tab-2">Staff</a></li>
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
                                    <th><center>Admin No</center></th>
                                    <th><center>Student Name</center></th>
                                    <th>Board</th>
                                    <th>Class/Section</th>
                                    <th>date</th>
                                    <th>reason</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM permission WHERE type='1' AND ay_id='$acyear'");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				$ssid=$row['ss_id'];
				$studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student=mysql_fetch_array($studentlist);
				
							$cid=$student['c_id'];
							$sid=$student['s_id'];
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
									$bid=$student['b_id'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
				?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $board['b_name'];?></center></td>
                                <td><center><?php echo $class['c_name']."-".$section['s_name']; ?></center></td>
                                <td><center><?php echo $row['date']; ?></center></td>
                                <td><center><?php echo $row['reason']; ?></center></td>
                                <td width="100px">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="permission_edit.php?pid=<?php echo $row['p_id'];?>&type=<?php echo $row['type'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="permission_delete.php?pid=<?php echo $row['p_id'];?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="permission_prt.php?pid=<?php echo $row['p_id'];?>&type=<?php echo $row['type'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $row['staff_id']; ?>, This Staff details" style="display: none;">
				<center><img src="./img/student/<?php echo $student['photo']; ?>" alt="student photo" width="60" height="60"></center>
				<p>Admin NO : <strong><?php echo $student['admission_number']; ?></strong></p>
                
                 <p>First Name : <strong><?php echo $student['firstname']; ?></strong></p> 
                
                <p>Last Name : <strong><?php echo $student['lastname']; ?></strong>  </p>   
                
                <p>Father / Guardian Name: <strong><?php echo $student['fathersname']; ?></strong>  </p>   
                
                <p>Father / Guardian Occupation : <strong><?php echo $student['fathersocupation']; ?></strong>  </p> 
                
                <p>Father / Guardian Monthly Income : <strong><?php echo $student['p_income']; ?></strong>  </p> 
                
                <p>Mother's Name : <strong><?php echo $student['m_name']; ?></strong>  </p> 
                
                <p>Mother's Occupation : <strong><?php echo $student['m_occup']; ?></strong>  </p> 
                
                <p>Mother's Monthly Income : <strong><?php echo $student['m_income']; ?></strong>  </p>   
                
                <p>Date of admission :  <strong><?php echo $student['doa']; ?></strong>  </p>   
                
                <p>Date Of Birth : <strong><?php echo $student['dob']; ?></strong> </p>   
                
                <p>Gender : <strong><?php if($student['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Nationality : <strong><?php echo $student['nation']; ?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $student['reg']; ?></strong> </p>   
                
                <p>Caste : <strong><?php echo $student['caste']; ?></strong>  </p>   
                
                <p>Subcaste : <strong><?php echo $student['sub_caste']; ?></strong>  </p>   
                
                <p>Blood Group : <strong><?php echo $student['blood']; ?></strong> </p>   
                
                <p>Email : <strong><?php echo $student['email']; ?></strong> </p>  
                
                <p>Phone : <strong><?php echo $student['phone_number']; ?></strong>  </p>   
                
                <p>Residence Address1 : <strong><?php echo $student['address1']; ?></strong>  </p>   
                
                <p>Residence Address2 : <strong><?php echo $student['address2']; ?></strong> </p>   
                
                <p>Town or village Name : <strong><?php echo $student['city_id']; ?></strong> </p>   
                
                <p>Country : <strong><?php echo $student['country']; ?></strong> </p> 
                
                <p>Pin Code : <strong><?php echo $student['pin']; ?></strong> </p>   
                
                <p>Mother Tongue of the Pubil : <strong><?php echo $student['mother_tongue']; ?></strong> </p>   
                
                <p>Height : <strong><?php echo $student['height']; ?></strong> </p>
                
                <p>Weight : <strong><?php echo $student['weight']; ?></strong> </p>
                
                <p>Remarks : <strong><?php echo $student['remarks']; ?></strong> </p>
              
              </center>
                </div>
                				
			</div> <!--! end of #info-dialog -->
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
                                    <th><center>Staff ID</center></th>
                                    <th><center>Staff Name</center></th>
                                    <th>Gender</th>
                                    <th>Position</th>
                                    <th>Email</th>
                                    <th>date</th>
                                    <th>reason</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM permission WHERE type='2' AND ay_id='$acyear'");
							$count1=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				$stid=$row['st_id'];
				$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								  $staff=mysql_fetch_array($stafflist);
								  ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count1; ?></center></td>
								<td><center><?php echo $staff['staff_id']; ?></center></td>
                                <td><center><?php echo $staff['fname']." ".$staff['mname']." ".$staff['lname'];  ?></center></td>
                                <td><center><?php if($staff['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></center></td>
                                <td><center><?php echo $staff['position']; ?></center></td>
                                <td><center><?php echo $staff['email']; ?></center></td>
                                <td><center><?php echo $row['date']; ?></center></td>
                                <td><center><?php echo $row['reason']; ?></center></td>
                                <td width="100px">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog1<?php echo $count1;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="permission_edit.php?pid=<?php echo $row['p_id'];?>&type=<?php echo $row['type'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="permission_delete.php?pid=<?php echo $row['p_id'];?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="permission_prt.php?pid=<?php echo $row['p_id'];?>&type=<?php echo $row['type'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog1<?php echo $count1;?>" title="<?php echo $staff['staff_id']; ?>, This Staff details" style="display: none;">
                                <center><img src="./img/staff/<?php echo $staff['photo']; ?>" alt="staff photo" width="60" height="60"></center>
				<p>Staff ID : <strong><?php echo $staff['staff_id']; ?></strong></p>
                
                 <p>First Name : <strong><?php echo $staff['fname']; ?></strong></p> 
                
                <p>Middle Name : <strong><?php echo $staff['mname']; ?></strong>  </p>   
                
                <p>Last Name : <strong><?php echo $staff['lname']; ?></strong>  </p>   
                
                <p>Staff Type : <strong><?php echo $staff['s_type']; ?></strong>  </p>   
                
                <p>Father's Name : <strong><?php echo $staff['s_pname']; ?></strong>  </p>   
                
                <p>Date Of Birth :  <strong><?php echo $staff['dob']; ?> </strong></p>   
                
                <p>Gender: <strong><?php if($staff['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $staff['reg']; ?></strong>  </p>   
                
                <p>Blood Group  :  <strong><?php echo $staff['blood']; ?></strong>  </p>   
                
                <p>Position : <strong><?php echo $staff['position']; ?></strong> </p>   
                
                <p>Expriences : <strong></strong> <?php echo $staff['expriences']; ?></p>   
                
                <p>Email : <strong><?php echo $staff['email']; ?></strong> </p>   
                
                <p>Phone No : <strong><?php echo $staff['phone_no']; ?></strong>  </p>   
                
                <p>Residence Address1 : <strong><?php echo $staff['address1']; ?></strong> </p>   
                
                <p>Residence Address2 : <strong><?php echo $staff['address2']; ?></strong>  </p>   
                
                <p>Town or village Name  : <strong><?php echo $staff['city']; ?></strong>  </p>   
                
                <p>Country : <strong><?php echo $staff['country']; ?></strong> </p>   
                
                <p>Pin Code : <strong><?php echo $staff['pincode']; ?></strong> </p>  
                
                </div>
                				
			</div> <!--! end of #info-dialog -->
                                 <?php 
							$count1++;
							} ?>                               																
							</tbody>
						</table>
                        <br>
						</div>						
					</div>
					<!--<div class="block-content dark-bg">
						<p>You see an other example on the <a href="charts.html">Charts-Page</a>.</p>
					</div>-->
				</div>
				<!--<div class="block-border">
					<div class="block-header">
                    	<h1>Staffs Management</h1>
                        <span></span>
					</div>
                    <div class="block-content">
						
					</div>
				</div>-->
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
  
</body>
</html>
<? ob_flush(); ?>