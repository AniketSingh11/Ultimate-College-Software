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
	$driver_id=mysql_real_escape_string($_POST['driver_id']);
	$fname=mysql_real_escape_string($_POST['fname']);
	$lname=mysql_real_escape_string($_POST['lname']);
	$p_name=mysql_real_escape_string($_POST['p_name']);
	$d_type=mysql_real_escape_string($_POST['d_type']);
	$dob=mysql_real_escape_string($_POST['dob']);
	$gender=mysql_real_escape_string($_POST['gender']);
	$reg=mysql_real_escape_string($_POST['reg']);
	$blood=mysql_real_escape_string($_POST['blood']);
	$position=mysql_real_escape_string($_POST['position']);
	$expriences=mysql_real_escape_string($_POST['expriences']);
	$phone=mysql_real_escape_string($_POST['phone']);
	$address=mysql_real_escape_string($_POST['address']);
	$address1=mysql_real_escape_string($_POST['address1']);
	$city=mysql_real_escape_string($_POST['city']);
	$country=mysql_real_escape_string($_POST['country']);
	$pincode=mysql_real_escape_string($_POST['pincode']);
	$email1=mysql_real_escape_string($_POST['email1']);
	$status=mysql_real_escape_string($_POST['status']);
	$did=mysql_real_escape_string($_POST['did']);
	$l_type=mysql_real_escape_string($_POST['l_type']);
	$l_no=mysql_real_escape_string($_POST['l_no']);
	
	$lastphoto=$_POST['photo'];
	
	$TARGET_PATH = "./img/driver/";
	$image = $_FILES['file'];
	$filesize = $_FILES["file"]["size"];
	$TARGET_PATH .= $image['name'];
	
	//unlink($TARGET_PATH."".$lastphoto);
	
	//echo $TARGET_PATH."".$lastphoto;
	echo '<pre>'; print_r($image); echo '</pre>';
	
	if($image[error]!=4){
		
		if (!is_valid_type($image) || $filesize>1000000) {
   	 		//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
    		header("Location:driver_edit.php?did=$did&msg=eronimg");
    		exit;
			}
			
			if(($lastphoto !='driver_male.png') && ($lastphoto !='driver_female.png')){ 
			unlink("./img/driver/".$lastphoto);
			}
		
			if (move_uploaded_file($image['tmp_name'], $TARGET_PATH)) {
$sql="UPDATE driver SET driver_id='$driver_id',fname='$fname',lname='$lname',d_type='$d_type',d_pname='$p_name',dob='$dob',gender='$gender',reg='$reg',blood='$blood',position='$position',expriences='$expriences',email='$email1',phone_no='$phone',address='$address',address1='$address1',city='$city',country='$country',pincode='$pincode',photo='".$image['name']."',status='$status',l_type='$l_type',l_no='$l_no' WHERE d_id='$did'";

		$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
			if($result){
				header("Location:driver_edit.php?did=$did&msg=succ");
			}
			exit;
			} else {
				//$_SESSION['error'] = "Could not upload file.  Check read/write persmissions on the directory";
				header("Location:driver_edit.php?did=$did&msg=eronfile");
				exit;
			}
	
	}else{
		
		if(($lastphoto =='driver_male.png') || ($lastphoto =='driver_female.png')){ 
		if($gender=='M'){
				$photo="driver_male.png";
			}else{
				$photo="driver_female.png";
			}	
		}else{
			$photo=$lastphoto;
		}
		
		$sql="UPDATE driver SET driver_id='$driver_id',fname='$fname',lname='$lname',d_type='$d_type',d_pname='$p_name',dob='$dob',gender='$gender',reg='$reg',blood='$blood',position='$position',expriences='$expriences',email='$email1',phone_no='$phone',address='$address',address1='$address1',city='$city',country='$country',pincode='$pincode',photo='$photo',status='$status',l_type='$l_type',l_no='$l_no' WHERE d_id='$did'";

		$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
			if($result){
				header("Location:driver_edit.php?did=$did&msg=succ");
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
				<li class="no-hover"><a href="driver.php" title="Home">Driver Management</a></li>
                <li class="no-hover">Edit Driver Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Driver Details</h1>                
			<a href="driver.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php } else if($msg=="eronimg"){?>			
            <div class="alert error"><span class="hide">x</span>Please upload image file type only jpg,png,gif and also file siz less then 1MB !!!</div>
            <?php } else if($msg=="eronfile"){?>			
            <div class="alert error"><span class="hide">x</span>Some Error on your upload image!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Driver Details</h1><span></span>
					</div>
                    <?php 
					$did=$_GET['did'];
							$stafflist=mysql_query("SELECT * FROM driver WHERE d_id=$did"); 
								  $staff=mysql_fetch_array($stafflist);
								  ?>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_25">
							<p>
                                <label for="textfield">Driver ID : <span class="error">*</span></label>
                                <input id="textfield" name="driver_id" class="required" type="text" value="<?php  echo $staff['driver_id'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">First Name : <span class="error">*</span></label>
                                <input id="textfield" name="fname" class="required" type="text" value="<?php  echo $staff['fname'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Last Name : <span class="error">*</span></label>
                                <input id="textfield" name="lname" class="required" type="text" value="<?php  echo $staff['lname'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Driver Type : <span class="error">*</span></label>
								<select name="d_type" class="required">
                                	<option value="<?php echo $staff['d_type']; ?>" selected="selected"><?php echo $staff['d_type']; ?></option>
									<option value="Driver">Driver</option>
									<option value="Non-Driver">Non-Driver</option>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Father's / Husband's Name : <span class="error">*</span></label>
                                <input id="textfield" name="p_name" class="required" type="text" value="<?php  echo $staff['d_pname'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Date Of Birth : <span class="error">*</span></label>
                                <input id="datepicker1" name="dob" class="required" type="text" value="<?php  echo $staff['dob'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Gender :<span class="error">*</span></label>
								<select name="gender"><?php $gen=$staff['gender'];?>
									<option value="M" <?php if($staff['gender']=='M'){ echo 'selected'; }?>>Male</option>
									<option value="F" <?php if($staff['gender']=='F'){ echo 'selected'; }?>>Female</option>
								</select>
							</p>
						</div>
                        <?php $religionlist=array("Buddhist","Christian","Hindu","Jain","Muslim","Parsi","Sikh"); 
                        echo '<div class="_25">
							<p>
                                <label for="textfield">Religion : <span class="error">*</span></label>
								<select  name="reg" id="reg" class="required">
                                    <option value="" selected="selected" >Select</option>';
									$religionvalue=$staff['reg'];
									for ($cmonth = 0; $cmonth <= 6; $cmonth++) {
										if($religionvalue==$religionlist[$cmonth]){
                                    echo '<OPTION VALUE="'.$religionlist[$cmonth].'" selected>'.$religionlist[$cmonth].'</OPTION>';
										}else{
									echo '<OPTION VALUE="'.$religionlist[$cmonth].'">'.$religionlist[$cmonth].'</OPTION>';		
										}
									}
                                    echo '</select>
                            </p>
						</div>';  ?>
                        <?php $bloodlist=array("A +ve","A -ve","B +ve","B -ve","O +ve","O -ve","AB +ve","AB -ve");  ?>
                        <div class="_25">
							<p>
                                <label for="textfield">Blood Group : <span class="error">*</span></label>
                                <select  name="blood" id="blood" class="required">
                                    <option value="" selected="selected" >Select</option>
                                <?php $bloodvalue=$staff['blood'];
									for ($cmonth = 0; $cmonth <= 7; $cmonth++) {
										if($bloodvalue==$bloodlist[$cmonth]){
                                    	echo '<OPTION VALUE="'.$bloodlist[$cmonth].'" selected>'.$bloodlist[$cmonth].'</OPTION>';
										}else{
										echo '<OPTION VALUE="'.$bloodlist[$cmonth].'">'.$bloodlist[$cmonth].'</OPTION>';		
										}
									} ?>
                                    </select>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Position :</label>
                                <input id="textfield" name="position"  type="text" value="<?php  echo $staff['position'];?>" />
                            </p>
						</div>
                         <div class="_25">
							<p>
                                <label for="textfield">Expriences:</label>
                                <input id="textfield" name="expriences"  type="text" value="<?php  echo $staff['expriences'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Email : <span class="error">*</span></label>
                                <input id="textfield" name="email1"  class="reqiured" type="text" value="<?php  echo $staff['email'];?>" />
                            </p>
						</div>
                          <div class="_25">
							<p>
                                <label for="textfield">Phone No : <span class="error">*</span></label>
                                <input id="textfield" name="phone" class="reqiured"  type="text" value="<?php  echo $staff['phone_no'];?>" />
                            </p>
						</div>
                         <div class="_50">
							<p><label for="textarea">Residence address : <span class="error">*</span></label><textarea id="textarea" name="address" class="required" rows="5" cols="40"><?php  echo $staff['address'];?></textarea></p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Permanent Address : <span class="error">*</span></label><textarea id="textarea" name="address1" class="required" rows="5" cols="40"><?php  echo $staff['address1'];?></textarea></p>
						</div>
                        <div class="_50">
							<p>
                                <label for="select">City : <span class="error">*</span></label>
                                <input id="textfield" name="city" class="required" type="text" value="<?php  echo $staff['city'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="select">Country : <span class="error">*</span></label>
                                <input id="textfield" name="country" class="required" type="text" value="<?php  echo $staff['country'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Pin Code : <span class="error">*</span></label>
                                <input id="textfield" name="pincode" class="required" type="text" value="<?php  echo $staff['pincode'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
								<label for="file">Upload a Driver Photo</label>
								<input type="file" name="file" id="file"/>
							</p>
						</div>
                        <?php $llist=array("Driver's licences","Motorcycle licences","Commercial licences","Heavy trailer endorsement","House trailer endorsement for towing heavy RVS","Riding mopeds and scootersDriver's licences");  ?>
                        <div class="_25">
							<p>
                                <label for="textfield">License Type : <span class="error">*</span></label>
                                <select  name="l_type" id="l_type" class="required">
                                    <option value="" selected="selected" >Select</option>
                                <?php $lvalue=$staff['l_type'];
									for ($cmonth = 0; $cmonth <= 5; $cmonth++) {
										if($lvalue==$llist[$cmonth]){
                                    	echo '<OPTION VALUE="'.$llist[$cmonth].'" selected>'.$llist[$cmonth].'</OPTION>';
										}else{
										echo '<OPTION VALUE="'.$llist[$cmonth].'">'.$llist[$cmonth].'</OPTION>';		
										}
									} ?>
                                    </select>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">License No : <span class="error">*</span></label>
                                <input id="textfield" name="l_no" class="required" type="text" value="<?=$staff['l_no']?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Active Status :</label>
									<select name="status">
												<option value="1" <?php if($staff['status']=='1'){ echo 'selected'; }?>>Enabled</option>
								<option value="0" <?php if($staff['status']=='0'){ echo 'selected'; }?>>Disabled</option>
											</select>								
							</p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="did" value="<?php echo $_GET['did'];?>" >
                             <input type="hidden" class="medium" name="photo" value="<?php  echo $staff['photo'];?>" >
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
  <script defer src="js/zebra_datepicker.js"></script>
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		$( "#datepicker1" ).Zebra_DatePicker({
						format: 'd/m/Y'
						});	
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