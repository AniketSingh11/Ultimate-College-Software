<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 function is_valid_type($file) {
    $valid_types = array("image/jpg","image/jpeg", "image/png", "image/bmp", "image/gif");
    if (in_array($file['type'], $valid_types))
        return 1;
    return 0;
}

 if (isset($_POST['submit']))
{
	$v_no=$_POST['v_no'];
	$v_regno=$_POST['v_regno'];
	$v_mno=$_POST['v_mno'];
	$v_cname=$_POST['v_cname'];
	$v_capacity=$_POST['capacity'];
	
	$vin_startdate=trim($_POST['vin_startdate']);
	$vin_startdate = str_replace('/', '-', $vin_startdate);
	$vin_startdate=date('Y-m-d', strtotime($vin_startdate));
	
	$vin_enddate=trim($_POST['vin_enddate']);
	$vin_enddate = str_replace('/', '-', $vin_enddate);
	$vin_enddate=date('Y-m-d', strtotime($vin_enddate));
	
	$vfc_startdate=trim($_POST['vfc_startdate']);
	$vfc_startdate = str_replace('/', '-', $vfc_startdate);
	$vfc_startdate=date('Y-m-d', strtotime($vfc_startdate));
	
	$vfc_enddate=$_POST['vfc_enddate'];
	$vfc_enddate = str_replace('/', '-', $vfc_enddate);
	$vfc_enddate=date('Y-m-d', strtotime($vfc_enddate));
	
	$pollution_startdate=trim($_POST['pollution_startdate']);
	$pollution_startdate = str_replace('/', '-', $pollution_startdate);
	$pollution_startdate=date('Y-m-d', strtotime($pollution_startdate));
	
	$pollution_enddate=$_POST['pollution_enddate'];
	$pollution_enddate = str_replace('/', '-', $pollution_enddate);
	$pollution_enddate=date('Y-m-d', strtotime($pollution_enddate));
	
	$tax_startdate=trim($_POST['tax_startdate']);
	$tax_startdate = str_replace('/', '-', $tax_startdate);
	$tax_startdate=date('Y-m-d', strtotime($tax_startdate));
	
	$tax_enddate=$_POST['tax_enddate'];
	$tax_enddate = str_replace('/', '-', $tax_enddate);
	$tax_enddate=date('Y-m-d', strtotime($tax_enddate));
	
	$permit_startdate=trim($_POST['permit_startdate']);
	$permit_startdate = str_replace('/', '-', $permit_startdate);
	$permit_startdate=date('Y-m-d', strtotime($permit_startdate));
	
	$permit_enddate=$_POST['permit_enddate'];
	$permit_enddate = str_replace('/', '-', $permit_enddate);
	$permit_enddate=date('Y-m-d', strtotime($permit_enddate));
	
	
	
	
	$TARGET_PATH = "./img/vehicle/";
	$image = $_FILES['file'];
	$TARGET_PATH .= $image['name'];
	//echo '<pre>'; print_r($image); echo '</pre>';
	
	if($image[error]!=4){
			
			if (!is_valid_type($image)) {
   	 		//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
    		header("Location:vehicle_add.php?ids=eronimg");
    		exit;
			}
			if (move_uploaded_file($image['tmp_name'], $TARGET_PATH)) {				
				$sql="INSERT INTO vehicle (v_no,v_regno,v_mno,v_cname,v_capacity,photo,status,vin_startdate,vin_enddate,vfc_startdate,vfc_enddate,pollution_startdate,pollution_enddate,tax_startdate,tax_enddate,permit_startdate,permit_enddate) VALUES
('$v_no','$v_regno','$v_cname','$v_mno','$v_capacity','" . $image['name'] . "','1','$vin_startdate','$vin_enddate','$vfc_startdate','$vfc_enddate','$pollution_startdate','$pollution_enddate','$tax_startdate','$tax_enddate','$permit_startdate','$permit_enddate')";
				$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				if($result){
					 header("Location:vehicle_add.php?msg=succ");
				}
			} else {
				//$_SESSION['error'] = "Could not upload file.  Check read/write persmissions on the directory";
				header("Location:vehicle_add.php?msg=eronfile");
				exit;
			}

			
	} else {
		//echo "without image";
				$photo="vehile_avatar.png";
				
		$sql="INSERT INTO vehicle (v_no,v_regno,v_mno,v_cname,v_capacity,photo,status,vin_startdate,vin_enddate,vfc_startdate,vfc_enddate,pollution_startdate,pollution_enddate,tax_startdate,tax_enddate,permit_startdate,permit_enddate) VALUES
('$v_no','$v_regno','$v_mno','$v_cname','$v_capacity','$photo','1','$vin_startdate','$vin_enddate','$vfc_startdate','$vfc_enddate','$pollution_startdate','$pollution_enddate','$tax_startdate','$tax_enddate','$permit_startdate','$permit_enddate')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:vehicle_add.php?msg=succ");
    }
    exit;
	}
}

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
				<li class="no-hover"><a href="vehicle.php" title="Home">Vehicle Management</a></li>
                <li class="no-hover">Add New Vehicle Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New Vehicle Details</h1>                
			<a href="vehicle.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add New Vehicle Details</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_100">
							<p>
                                <label for="textfield">Vehicle No : <span class="error">*</span></label>
                                <input id="textfield" name="v_no" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Vehicle Reg.no : <span class="error">*</span></label>
                                <input id="textfield" name="v_regno" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Vehicle Model No :</label>
                                <input id="textfield" name="v_mno"  type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Vehicle Company Name :</label>
                                <input id="textfield" name="v_cname"  type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Vehicle Capacity : <span class="error">*</span> </label>
                                <input id="textfield" name="capacity" class="required" type="text" value="" />
                            </p>
						</div>
						
						<div class="_25">
							<p>
                                <label for="textfield">Insurance Start Date  : <span class="error">*</span></label>
                                <input id="datepicker1" name="vin_startdate" class="required" type="text" value="" />
                            </p>
						</div>
						<div class="_25">
							<p>
                                <label for="textfield">Insurance End Date : <span class="error">*</span> </label>
                                <input id="datepicker2" name="vin_enddate" class="required" type="text" value="" />
                            </p>
						</div>
						
						<div class="_25">
							<p>
                                <label for="textfield">Vehicle FC Start Date : <span class="error">*</span> </label>
                                <input id="datepicker3" name="vfc_startdate" class="required" type="text" value="" />
                            </p>
						</div>
						  
						<div class="_25">
							<p>
                                <label for="textfield">Vehicle FC End Date : <span class="error">*</span> </label>
                                <input id="datepicker4" name="vfc_enddate" class="required" type="text" value="" />
                            </p>
						</div>
                        
                        <div class="_25">
							<p>
                                <label for="textfield">Pollution Start Date : <span class="error">*</span> </label>
                                <input id="datepicker5" name="pollution_startdate" class="required" type="text" value="" />
                            </p>
						</div>
						  
						<div class="_25">
							<p>
                                <label for="textfield">Pollution FC End Date : <span class="error">*</span> </label>
                                <input id="datepicker6" name="pollution_enddate" class="required" type="text" value="" />
                            </p>
						</div>
                        
                        <div class="_25">
							<p>
                                <label for="textfield">Tax Start Date : <span class="error">*</span> </label>
                                <input id="datepicker7" name="tax_startdate" class="required" type="text" value="" />
                            </p>
						</div>
						  
						<div class="_25">
							<p>
                                <label for="textfield">Tax FC End Date : <span class="error">*</span> </label>
                                <input id="datepicker8" name="tax_enddate" class="required" type="text" value="" />
                            </p>
						</div>
                        
                        <div class="_25">
							<p>
                                <label for="textfield">Permit Start Date : <span class="error">*</span> </label>
                                <input id="datepicker9" name="permit_startdate" class="required" type="text" value="" />
                            </p>
						</div>
						  
						<div class="_25">
							<p>
                                <label for="textfield">Permit FC End Date : <span class="error">*</span> </label>
                                <input id="datepicker10" name="permit_enddate" class="required" type="text" value="" />
                            </p>
						</div>
					 
					    <div class="_100">
							<p>
								<label for="file">Upload a Vehicle Photo</label>
								<input type="file" name="file" id="file"/>
							</p>
						</div>
						
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
								<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
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
  
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		$( "#datepicker1" ).datepicker({ dateFormat: 'dd/mm/yy' });
		$( "#datepicker2" ).datepicker({ dateFormat: 'dd/mm/yy' });
		$( "#datepicker3" ).datepicker({ dateFormat: 'dd/mm/yy' });
		$( "#datepicker4" ).datepicker({ dateFormat: 'dd/mm/yy' });
		$( "#datepicker5" ).datepicker({ dateFormat: 'dd/mm/yy' });
		$( "#datepicker6" ).datepicker({ dateFormat: 'dd/mm/yy' });
		$( "#datepicker7" ).datepicker({ dateFormat: 'dd/mm/yy' });
		$( "#datepicker8" ).datepicker({ dateFormat: 'dd/mm/yy' });
		$( "#datepicker9" ).datepicker({ dateFormat: 'dd/mm/yy' });
		$( "#datepicker10" ).datepicker({ dateFormat: 'dd/mm/yy' });
	});
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>