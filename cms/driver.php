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
				<li class="no-hover">Drivers Management</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Drivers Management</h1>
                <a href="driver_add.php"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png">Add New</button></a>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
            <div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Drivers Management</h1>
						<ul class="tabs" style="margin-right:60px;">
							<li><a href="#tab-1">Driver</a></li>
							<li><a href="#tab-2">Non-Driver</a></li>
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
                                    <th><center>Driver ID</center></th>
                                    <th><center>Driver Name</center></th>
                                    <th>Gender</th>
                                    <th>Expriences</th>
                                    <th>DOB</th>
                                    <th>Phone No</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM driver WHERE d_type='Driver' ");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['driver_id']; ?></center></td>
                                <td><center><?php echo $row['fname']." ".$row['lname'];  ?></center></td>
                                <td><center><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></center></td>
                                <td><center><?php echo $row['expriences']; ?></center></td>
                                <td><center><?php echo $row['dob']; ?></center></td>
                                <td><center><?php echo $row['phone_no']; ?></center></td>
                                <td><center><img src="./img/driver/<?php echo $row['photo']; ?>" alt="driver photo" width="40" height="40"></center></td>
                                <td><center><?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
                                <td width="100px">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="driver_edit.php?did=<?php echo $row['d_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="driver_delete.php?did=<?php echo $row['d_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="driver_prt.php?did=<?php echo $row['d_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $row['driver_id']; ?>, This Staff details" style="display: none;">
                                <center><img src="./img/driver/<?php echo $row['photo']; ?>" alt="staff photo" width="60" height="60"></center>
				<p>Driver ID : <strong><?php echo $row['driver_id']; ?></strong></p>
                
                 <p>First Name : <strong><?php echo $row['fname']; ?></strong></p> 
                
                <p>Last Name : <strong><?php echo $row['lname']; ?></strong>  </p>   
                
                <p>Driver Type : <strong><?php echo $row['d_type']; ?></strong>  </p>   
                
                <p>Father's Name : <strong><?php echo $row['d_pname']; ?></strong>  </p>   
                
                <p>Date Of Birth :  <strong><?php echo $row['dob']; ?> </strong></p>   
                
                <p>Gender: <strong><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $row['reg']; ?></strong>  </p>   
                
                <p>Blood Group  :  <strong><?php echo $row['blood']; ?></strong>  </p>   
                
                <p>Position : <strong><?php echo $row['position']; ?></strong> </p>   
                
                <p>Expriences : <strong> <?php echo $row['expriences']; ?></strong></p>   
                
                <p>Email : <strong><?php echo $row['email']; ?></strong> </p>   
                
                <p>Phone No : <strong><?php echo $row['phone_no']; ?></strong>  </p>   
                
                <p>Residence Address : <strong><?php echo $row['address']; ?></strong> </p>   
                
                <p>City  : <strong><?php echo $row['city']; ?></strong>  </p>   
                
                <p>Country : <strong><?php echo $row['country']; ?></strong> </p>   
                
                <p>Pin Code : <strong><?php echo $row['pincode']; ?></strong> </p>  
                
                <center> <?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
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
                                    <th><center>Driver ID</center></th>
                                    <th><center>Driver Name</center></th>
                                    <th>Gender</th>
                                    <th>expriences</th>
                                    <th>DOB</th>
                                    <th>Phone No</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM driver WHERE d_type='Non-Driver' ");
							$count1=1;
			  while($row=mysql_fetch_array($qry))
        		{ ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count1; ?></center></td>
								<td><center><?php echo $row['driver_id']; ?></center></td>
                                <td><center><?php echo $row['fname']." ".$row['lname'];  ?></center></td>
                                <td><center><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></center></td>
                                <td><center><?php echo $row['expriences']; ?></center></td>
                                <td><center><?php echo $row['dob']; ?></center></td>
                                <td><center><?php echo $row['phone_no']; ?></center></td>
                                <td><center><img src="./img/driver/<?php echo $row['photo']; ?>" alt="driver photo" width="40" height="40"></center></td>
                                <td><center><?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
                                <td width="100px">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog1<?php echo $count1;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="driver_edit.php?did=<?php echo $row['d_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="driver_delete.php?did=<?php echo $row['d_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="driver_prt.php?did=<?php echo $row['d_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog1<?php echo $count1;?>" title="<?php echo $row['driver_id']; ?>, This Staff details" style="display: none;">
                                <center><img src="./img/driver/<?php echo $row['photo']; ?>" alt="staff photo" width="60" height="60"></center>
				<p>Driver ID : <strong><?php echo $row['driver_id']; ?></strong></p>
                
                 <p>First Name : <strong><?php echo $row['fname']; ?></strong></p> 
                
                <p>Last Name : <strong><?php echo $row['lname']; ?></strong>  </p>   
                
                <p>Driver Type : <strong><?php echo $row['d_type']; ?></strong>  </p>   
                
                <p>Father/Husband Name : <strong><?php echo $row['d_pname']; ?></strong>  </p>   
                
                <p>Date Of Birth :  <strong><?php echo $row['dob']; ?> </strong></p>   
                
                <p>Gender: <strong><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $row['reg']; ?></strong>  </p>   
                
                <p>Blood Group  :  <strong><?php echo $row['blood']; ?></strong>  </p>   
                
                <p>Position : <strong><?php echo $row['position']; ?></strong> </p>   
                
                <p>Expriences : <strong> <?php echo $row['expriences']; ?></strong></p>   
                
                <p>Email : <strong><?php echo $row['email']; ?></strong> </p>   
                
                <p>Phone No : <strong><?php echo $row['phone_no']; ?></strong>  </p>   
                
                <p>Residence Address : <strong><?php echo $row['address']; ?></strong> </p>   
                
                <p>City  : <strong><?php echo $row['city']; ?></strong>  </p>   
                
                <p>Country : <strong><?php echo $row['country']; ?></strong> </p>   
                
                <p>Pin Code : <strong><?php echo $row['pincode']; ?></strong> </p>  
                
                <center> <?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
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