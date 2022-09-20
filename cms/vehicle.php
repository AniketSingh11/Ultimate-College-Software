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
				<h1>Vehicle Management</h1>
                <a href="vehicle_add.php" title="add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>Vehicle Management</h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Vehicle No</center></th>
                                    <th><center>Vehicle Reg.No</center></th>
                                    <th><center>Vehicle Model No</center></th>
                                    <th><center>Vehicle Capacity</center></th>
                                     <th><center>Image</center></th>
                                     <th><center>Insurance Expire</center></th>
                                     <th><center>Vehicle FC  Expire</center></th>
                                     <th><center>Pollution Expire</center></th>
                                     <th><center>Tax FC  Expire</center></th>
                                     <th><center>Permit Expire</center></th>
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
                $date=date("Y-m-d");
        		    ?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['v_no']; ?></center></td>
                                <td><center><?php echo $row['v_regno']; ?></center></td>
                                <td><center><?php echo $row['v_mno']; ?></center></td>
                                <td><center><?php echo $row['v_capacity']; ?></center></td>
                                <td><center><img src="./img/vehicle/<?php echo $row['photo']; ?>" alt="staff photo" width="40" height="40"></center></td>
                                <td><center><?php if($row['vin_enddate'] > $date ){ ?>
                                <button class="btn btn-small btn-success" ><?=$row['vin_enddate']?></button><?php }else{?><button class="btn btn-small btn-error" ><?=$row['vin_enddate']?></button> <?php } ?>
                                </center></td>
                                  <td><center><?php if($row['vfc_enddate'] > $date){ ?>
                                <button class="btn btn-small btn-success" ><?=$row['vfc_enddate']?></button><?php }else{?><button class="btn btn-small btn-error" ><?=$row['vfc_enddate']?></button> <?php } ?>
                                </center></td>
                                <td><center><?php if($row['pollution_enddate'] > $date){ ?>
                                <button class="btn btn-small btn-success" ><?=$row['pollution_enddate']?></button><?php }else{?><button class="btn btn-small btn-error" ><?=$row['pollution_enddate']?></button> <?php } ?>
                                </center></td>
                                <td><center><?php if($row['tax_enddate'] > $date){ ?>
                                <button class="btn btn-small btn-success" ><?=$row['tax_enddate']?></button><?php }else{?><button class="btn btn-small btn-error" ><?=$row['tax_enddate']?></button> <?php } ?>
                                </center></td>
                                <td><center><?php if($row['permit_enddate'] > $date){ ?>
                                <button class="btn btn-small btn-success" ><?=$row['permit_enddate']?></button><?php }else{?><button class="btn btn-small btn-error" ><?=$row['permit_enddate']?></button> <?php } ?>
                                </center></td>
                                <td><center><?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
								<td class="action">
                                <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                <a href="vehicle_edit.php?vid=<?php echo $row['v_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="vehicle_delete.php?vid=<?php echo $row['v_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="Vehicle No : <?php echo $row['v_no']; ?> details" style="display: none; width:">
                                <center><img src="./img/vehicle/<?php echo $row['photo']; ?>" alt="staff photo" width="60"></center>
				<p>Vehicle No : <strong><?php echo $row['v_no']; ?></strong></p>
                
                 <p>Vehicle Reg.No : <strong><?php echo $row['v_regno']; ?></strong></p> 
                 
                <p>Vehicle Company Name : <strong><?php echo $row['v_cname']; ?></strong>  </p> 
                
                <p>Vehicle Model No : <strong><?php echo $row['v_mno']; ?></strong>  </p>   
                
                <p>Vehicle Capacity : <strong><?php echo $row['v_capacity']; ?></strong>  </p>   
                
                <center> <?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
                </div>
                                 <?php 
							$count++;

							} ?>                               																
							</tbody>
						</table>
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