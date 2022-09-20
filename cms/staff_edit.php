<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/staff.php");
  function is_valid_type($file) {
    $valid_types = array("image/jpg","image/jpeg", "image/png", "image/bmp", "image/gif");
    if (in_array($file['type'], $valid_types))
        return 1;
    return 0;
}
 if (isset($_POST['submit']))
{
	$staff_id=mysql_real_escape_string($_POST['staff_id']);
	$fname=mysql_real_escape_string($_POST['fname']);
	$mname=mysql_real_escape_string($_POST['mname']);
	$lname=mysql_real_escape_string($_POST['lname']);
	$p_name=mysql_real_escape_string($_POST['p_name']);
	$s_type=mysql_real_escape_string($_POST['s_type']);
	$dob=mysql_real_escape_string($_POST['dob']);
	
	$date_split1= explode('/', $dob);		 
		 $date_month=$date_split1[1];
		 $date_day=$date_split1[0];
		 $date_year=$date_split1[2];
		 
		 
	$gender=mysql_real_escape_string($_POST['gender']);
	$reg=mysql_real_escape_string($_POST['reg']);
	$blood=mysql_real_escape_string($_POST['blood']);
	$position=mysql_real_escape_string($_POST['position']);
	$expriences=mysql_real_escape_string($_POST['expriences']);
	$phone=mysql_real_escape_string($_POST['phone']);
	$address1=mysql_real_escape_string($_POST['address1']);
	$address2=mysql_real_escape_string($_POST['address2']);
	$city=mysql_real_escape_string($_POST['city']);
	$country=mysql_real_escape_string($_POST['country']);
	$pincode=mysql_real_escape_string($_POST['pincode']);
	$email1=mysql_real_escape_string($_POST['email1']);
	$status=mysql_real_escape_string($_POST['status']);
	$stid=mysql_real_escape_string($_POST['stid']);
	
	$rid=$_POST['rid'];
	$spid=$_POST['spid'];
	$busfeestype=$_POST['busfeestype'];
	
	$join_date=mysql_real_escape_string($_POST['j_date']);
	$qualification=mysql_real_escape_string($_POST['qualify']);
	
	$lastphoto=$_POST['photo'];
	$extension = end(explode(".",$_FILES["file"]["name"]));
	$TARGET_PATH = "./img/staff/";
	$image = $_FILES['file'];
	$filesize = $_FILES["file"]["size"];
	$TARGET_PATH .=$staff_id.".".$extension;
	$img_name=$staff_id.".".$extension;
	//unlink($TARGET_PATH."".$lastphoto);
	
	//echo $TARGET_PATH."".$lastphoto;
	echo '<pre>'; print_r($image); echo '</pre>';
	
	if($image[error]!=4){
		
		if (!is_valid_type($image) || $filesize>1000000) {
   	 		//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
    		header("Location: staff_edit.php?stid=$stid&msg=eronimg");
    		exit;
			}
			
			if(($lastphoto !='mstaff_small.png') && ($lastphoto !='fstaff_small.png')){ 
			unlink("./img/staff/".$lastphoto);
			}
		
			if (move_uploaded_file($image['tmp_name'], $TARGET_PATH)) {
$sql="UPDATE staff SET staff_id='$staff_id',fname='$fname',mname='$mname',lname='$lname',s_type='$s_type',s_pname='$p_name',dob='$dob',day='$date_day',month='$date_month',year='$date_year',gender='$gender',reg='$reg',blood='$blood',position='$position',expriences='$expriences',email='$email1',phone_no='$phone',address1='$address1',address2='$address2',city='$city',country='$country',pincode='$pincode',photo='".$img_name."',status='$status',r_id='$rid',sp_id='$spid',busfeestype='$busfeestype',qualf='$qualification',doj='$join_date' WHERE st_id='$stid'";

		$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
			if($result){
				header("Location:staff_edit.php?stid=$stid&msg=succ");
			}
			exit;
			} else {
				//$_SESSION['error'] = "Could not upload file.  Check read/write persmissions on the directory";
				header("Location:staff_edit.php?stid=$stid&msg=eronfile");
				exit;
			}
	
	}else{
		if(($lastphoto =='mstaff_small.png') || ($lastphoto =='fstaff_small.png')){ 
		if($gender=='M'){
				$photo="mstaff_small.png";
			}else{
				$photo="fstaff_small.png";
			}	
		}else{
			$photo=$lastphoto;
		}
		 $sql="UPDATE staff SET staff_id='$staff_id',fname='$fname',mname='$mname',lname='$lname',s_type='$s_type',s_pname='$p_name',dob='$dob',day='$date_day',month='$date_month',year='$date_year',gender='$gender',reg='$reg',blood='$blood',position='$position',expriences='$expriences',email='$email1',phone_no='$phone',address1='$address1',address2='$address2',city='$city',country='$country',pincode='$pincode',photo='$photo',status='$status',r_id='$rid',sp_id='$spid',busfeestype='$busfeestype',qualf='$qualification',doj='$join_date' WHERE st_id='$stid'";

		$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
			if($result){
				header("Location:staff_edit.php?stid=$stid&msg=succ");
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
				<li class="no-hover"><a href="staff.php" title="Home">Staff Management</a></li>
                <li class="no-hover">Edit Staff Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit staff Details</h1>                
			<a href="staff.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
						<h1>Edit staff Details</h1><span></span>
					</div>
                    <?php 
					$stid=$_GET['stid'];
							$stafflist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								  $staff=mysql_fetch_array($stafflist);
								  ?>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_25">
							<p>
                                <label for="textfield">Staff ID : <span class="error">*</span></label>
                                <input id="textfield" name="staff_id" class="required" type="text" readonly value="<?php  echo $staff['staff_id'];?>" />
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
                                <label for="textfield">Middle Name :</label>
                                <input id="textfield" name="mname"  type="text" value="<?php  echo $staff['mname'];?>" />
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
								<label for="select">Staff Type : <span class="error">*</span></label>
								<select name="s_type" class="required">
                                	<option value="<?php echo $staff['s_type']; ?>" selected="selected"><?php echo $staff['s_type']; ?></option>
									<option value="Teaching">Teaching</option>
									<option value="Non-Teaching">Non-Teaching</option>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father's Name : <span class="error">*</span></label>
                                <input id="textfield" name="p_name" class="required" type="text" value="<?php  echo $staff['s_pname'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Gender :<span class="error">*</span></label>
								<select name="gender"><?php $gen=$staff['gender'];?>
									<option value="M" <?php if($staff['gender']=='M'){ echo 'selected'; }?>>Male</option>
									<option value="F" <?php if($staff['gender']=='F'){ echo 'selected'; }?>>Female</option>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date Of Birth : <span class="error">*</span></label>
                                <input id="datepicker1" name="dob" class="required" type="text" value="<?php  echo $staff['dob'];?>" />
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
                                <label for="textfield">Joining Date : <span class="error">*</span></label>
                                <input id="j_date" name="j_date" class="required"  type="text" value="<?php  echo $staff['doj'];?>" />
                            </p>
						</div>
						
                        <div class="_25">
							<p>
                                <label for="textfield">Position :</label>
                                <input id="textfield" name="position"  type="text" value="<?php  echo $staff['position'];?>" />
                            </p>
						</div>
                         <div class="_50">
							<p>
                                <label for="textfield">Expriences:</label>
                                <input id="textfield" name="expriences"  type="text" value="<?php  echo $staff['expriences'];?>" />
                            </p>
						</div>
						 <div class="_50">
							<p>
                                <label for="textfield">Qualification : <span class="error">*</span></label>
                                <input id="qualify" name="qualify"  class="required" type="text" value="<?php  echo $staff['qualf'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Email : <span class="error">*</span></label>
                                <input id="textfield" name="email1"  class="reqiured" type="text" value="<?php  echo $staff['email'];?>" />
                            </p>
						</div>
                          <div class="_50">
							<p>
                                <label for="textfield">Phone No : <span class="error">*</span></label>
                                <input id="textfield" name="phone" class="reqiured"  type="text" value="<?php  echo $staff['phone_no'];?>" />
                            </p>
						</div>
                         <div class="_50">
							<p><label for="textarea">Residence Address1 : <span class="error">*</span></label><textarea id="textarea" name="address1" class="required" rows="5" cols="40"><?php  echo $staff['address1'];?></textarea></p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Residence Address2 :</label><textarea id="textarea" name="address2" rows="5" cols="40"><?php  echo $staff['address2'];?></textarea></p>
						</div> 
                        <div class="_50">
							<p>
                                <label for="select">Town or village Name : <span class="error">*</span></label>
                                <input id="textfield" name="city" class="required" type="text" value="<?php  echo $staff['city'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="select">Country : <span class="error">*</span></label>
                                <input id="textfield" name="country" class="required" type="text" value="<?php  echo $staff['country'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Pin Code :</label>
                                <input id="textfield" name="pincode"  type="text" value="<?php  echo $staff['pincode'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Route Master : </label>
                                <select name="rid" id="rid" onchange="showCategory(this.value)">
											<option value="0" <?php $rid=$staff['r_id'];
											 if($rid=='0'){ echo 'selected'; }?>>Not Bus Staff</option>	
                                            <option value="1" <?php if($rid=='1'){ echo 'selected'; }?>>Bus Staff</option>											
								</select>
							</p>
						</div>
                         <div id="eleven_mark" <?php if(!$rid){ echo 'style="display: none;"';}?>>
                        <div class="_25">
							<p>
								<label for="select">Stopping Point :</label>
                               		<?php $spid=$staff['sp_id'];
											$result1 = mysql_query("SELECT * FROM trstopping WHERE status='1'") or die(mysql_error());
                                            echo '<select name="spid" id="spid"> <option value="0">Please select</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($spid==$row1['stop_id']){
                                                echo "<option value='{$row1['stop_id']}' selected>{$row1['stop_name']}</option>\n";
												}else{
												echo "<option value='{$row1['stop_id']}'>{$row1['stop_name']}</option>\n";	
												}
                                            endwhile;
                                            echo '</select>';
											?>										
							</p>
						</div>
                        <div class="_25">
							<p>
                            <?php 
							$fesstypearray=array("Regural Bus","Sp.Bus","Onetime Sp.Bus","Onetime");
							?>	
								<label for="select">Bus Type:</label>
                               <select name="busfeestype" id="busfeestype">
                               <?php
							   $busfeestype=$row['busfeestype'];
				for ($cmonth = 0; $cmonth <= 3; $cmonth++) { 
				if($busfeestype==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected" ><?php echo $fesstypearray[$cmonth]?></option>
            <?php }else { ?>
            <option value="<?php echo $cmonth;?>" ><?php echo  $fesstypearray[$cmonth]?></option>            
            <?php } }?>									
								</select>
							</p>
						</div>
                        </div>
                        <div class="_25">
							<p>
								<label for="file">Upload a Staff Photo</label>
								<input type="file" name="file" id="file"/>
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
                            <input type="hidden" class="medium" name="stid" value="<?php echo $_GET['stid'];?>" >
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
		$( "#j_date" ).Zebra_DatePicker({
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
  <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
    function showCategory(str) {
        if (str == "") {
            document.getElementById("spid").innerHTML = "";
            return;
        }
		if(str){
        		$("#eleven_mark").show();        
        	}
		if(str==0){
        		$("#eleven_mark").hide();        
        	}
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("spid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "stoppinglist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script>  
</body>
</html>
<? ob_flush(); ?>