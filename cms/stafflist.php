<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/subject_management.php"); 
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
				<li class="no-hover">Staff List</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
        <div class="container_12">
			<div class="grid_12">
				<h1>Staff List</h1>
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>Academic  Year list</h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Staff ID</center></th>
                                    <th><center>Staff Name</center></th>
                                    <th>Gender</th>
                                    <th>Position</th>
                                    <th>Photo</th>
                                    <?php
									$qry1=mysql_query("SELECT * FROM board");
								  while($row1=mysql_fetch_array($qry1))
									{ ?>
                                    <th><?php echo $row1['b_name'];?></th>
                            <?php } ?>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM staff WHERE s_type='Teaching' ");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ $stid=$row['st_id'];
				?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['staff_id']; ?></center></td>
                                <td><center><?php echo $row['fname']." ".$row['mname']." ".$row['lname'];  ?></center></td>
                                <td><center><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></center></td>
                                <td><center><?php echo $row['position']; ?></center></td>
                                <td><center><img src="./img/staff/<?php echo $row['photo']; ?>" alt="staff photo" width="40" height="40"></center></td>
                                <?php
									$qry1=mysql_query("SELECT * FROM board");
								  while($row1=mysql_fetch_array($qry1))
									{ ?>
                                    <td><center>
                                <a href="staff-assign.php?stid=<?php echo $stid;?>&bid=<?php echo $row1['b_id'];?>" title="Assign Class" ><button class="btn btn-small btn-success">Assign Class</button></a>
                                </center></td>
                            <?php } ?>
                                <td width="50px">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="staff_prt.php?stid=<?php echo $row['st_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $row['staff_id']; ?>, This Staff details" style="display: none;">
                                <center><img src="./img/staff/<?php echo $row['photo']; ?>" alt="staff photo" width="60" height="60"></center>
				<p>Staff ID : <strong><?php echo $row['staff_id']; ?></strong></p>
                
                 <p>First Name : <strong><?php echo $row['fname']; ?></strong></p> 
                
                <p>Middle Name : <strong><?php echo $row['mname']; ?></strong>  </p>   
                
                <p>Last Name : <strong><?php echo $row['lname']; ?></strong>  </p>   
                
                <p>Staff Type : <strong><?php echo $row['s_type']; ?></strong>  </p>   
                
                <p>Father's Name : <strong><?php echo $row['s_pname']; ?></strong>  </p>   
                
                <p>Date Of Birth :  <strong><?php echo $row['dob']; ?> </strong></p>   
                
                <p>Gender: <strong><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $row['reg']; ?></strong>  </p>   
                
                <p>Blood Group  :  <strong><?php echo $row['blood']; ?></strong>  </p>   
                
                <p>Position : <strong><?php echo $row['position']; ?></strong> </p>   
                
                <p>Expriences : <strong></strong> <?php echo $row['expriences']; ?></p>   
                
                <p>Email : <strong><?php echo $row['email']; ?></strong> </p>   
                
                <p>Phone No : <strong><?php echo $row['phone_no']; ?></strong>  </p>   
                
                <p>Residence Address1 : <strong><?php echo $row['address1']; ?></strong> </p>   
                
                <p>Residence Address2 : <strong><?php echo $row['address2']; ?></strong>  </p>   
                
                <p>Town or village Name  : <strong><?php echo $row['city']; ?></strong>  </p>   
                
                <p>Country : <strong><?php echo $row['country']; ?></strong> </p>   
                
                <p>Pin Code : <strong><?php echo $row['pincode']; ?></strong> </p>
                
                <?php $rid=$row['r_id'];
				$spid=$row['sp_id'];
				if($rid){ 
				//$rid1=$invoice['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  $row5=mysql_fetch_array($qry5);
				?>
                <p>Bus Route Name : <strong><?php echo $row5['r_name']; ?></strong> </p>   
                <?php } if($spid){
					 $qry6=mysql_query("SELECT * FROM stopping WHERE sp_id=$spid"); 
								  $row6=mysql_fetch_array($qry6);?>				
                <p>Stopping Point : <strong><?php echo $row6['sp_name']; ?></strong> </p> 
                
                <?php } ?>
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
					</div>
				</div>
			</div>
            <div class="clear height-fix"></div>

		</div>
			</div> <!--! end of #main-content -->
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