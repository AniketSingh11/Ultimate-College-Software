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
	$dob=$_POST['dob'];
	
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
	
	$join_date=$_POST['j_date'];
	$qualification=mysql_real_escape_string($_POST['qualify']);
	
	$rid=$_POST['rid'];
	$spid=$_POST['spid'];
	$busfeestype=$_POST['busfeestype'];
	$extension = end(explode(".",$_FILES["file"]["name"]));
	
	$TARGET_PATH = "./img/staff/";
	$filesize = $_FILES["file"]["size"];
	$image = $_FILES['file'];
	$TARGET_PATH .=$staff_id.".".$extension;
	
	$img_name=$staff_id.".".$extension;
	//echo '<pre>'; print_r($image); echo '</pre>';
	
	$adminlist1=mysql_query("SELECT * FROM staff_no_count WHERE id='1'"); 
								  $admincount1=mysql_fetch_array($adminlist1);	
								  $adminno1=$admincount1['count'];
								  $adminno2=$adminno1+1;
								 $admin_number1="CH".str_pad($adminno1, 3, '0', STR_PAD_LEFT);
	
	if($image[error]!=4){
			
			if (!is_valid_type($image) || $filesize>1000000) {
   	 		//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
    		header("Location: staff_add.php?msg=eronimg");
    		exit;
			}
			if (move_uploaded_file($image['tmp_name'], $TARGET_PATH)) {
				$sql="INSERT INTO staff (staff_id,fname,mname,lname,s_type,s_pname,dob,day,month,year,gender,reg,blood,position,expriences,email,password,phone_no,address1,address2,city,country,pincode,photo,status,r_id,sp_id,busfeestype,qualf,doj) VALUES
('$admin_number1','$fname','$mname','$lname','$s_type','$p_name','$dob','$date_day','$date_month','$date_year','$gender','$reg','$blood','$position','$expriences','$email1','$staff_id','$phone','$address1','$address2','$city','$country','$pincode','" .$img_name. "','1','$rid','$spid','$busfeestype','$qualification','$join_date')";
				$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				if($result){
					$sql1=mysql_query("UPDATE staff_no_count SET count='$adminno2' WHERE id='1'");
					 header("Location:staff_add.php?msg=succ");
				}
			} else {
				//$_SESSION['error'] = "Could not upload file.  Check read/write persmissions on the directory";
				header("Location:staff_add.php?msg=eronfile");
				exit;
			}

			
	} else {
		//echo "without image";
			if($gender=='M'){
				$photo="mstaff_small.png";
			}else{
				$photo="fstaff_small.png";
			}	
		$sql="INSERT INTO staff (staff_id,fname,mname,lname,s_type,s_pname,dob,day,month,year,gender,reg,blood,position,expriences,email,password,phone_no,address1,address2,city,country,pincode,photo,status,r_id,sp_id,busfeestype,qualf,doj) VALUES
('$admin_number1','$fname','$mname','$lname','$s_type','$p_name','$dob','$date_day','$date_month','$date_year','$gender','$reg','$blood','$position','$expriences','$email1','$staff_id','$phone','$address1','$address2','$city','$country','$pincode','$photo','1','$rid','$spid','$busfeestype','$qualification','$join_date')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
		$sql1=mysql_query("UPDATE staff_no_count SET count='$adminno2' WHERE id='1'");
        header("Location:staff_add.php?msg=succ");
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
                <li class="no-hover">Add New Staff Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New staff Details</h1>                
			<a href="staff.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } else if($msg=="eronimg"){?>			
            <div class="alert error"><span class="hide">x</span>Please upload image file type only jpg,png,gif and also file siz less then 1MB !!!</div>
            <?php } else if($msg=="eronfile"){?>			
            <div class="alert error"><span class="hide">x</span>Some Error on your upload image!!!</div>
            <?php } 
			$adminlist=mysql_query("SELECT * FROM staff_no_count WHERE id='1'"); 
								  $admincount=mysql_fetch_array($adminlist);	  
								  
								  $adminno=$admincount['count'];
								  
								 $admin_number="CH".str_pad($adminno, 3, '0', STR_PAD_LEFT); ?>
				<div class="block-border">
					<div class="block-header">
						<h1>Add New staff Details</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_25">
							<p>
                                <label for="textfield">Staff ID : <span class="error">*</span></label>
                                <input id="textfield" name="staff_id" class="required" type="text" value="<?php echo $admin_number;?>" readonly />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">First Name : <span class="error">*</span></label>
                                <input id="textfield" name="fname" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Middle Name :</label>
                                <input id="textfield" name="mname"  type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Last Name : <span class="error">*</span></label>
                                <input id="textfield" name="lname" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Staff Type : <span class="error">*</span></label>
								<select name="s_type" class="required">
									<option value="">Select one</option>
									<option value="Teaching">Teaching</option>
									<option value="Non-Teaching">Non-Teaching</option>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father's Name : <span class="error">*</span></label>
                                <input id="textfield" name="p_name" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Gender : <span class="error">*</span></label>
								<select name="gender" class="required">
									<option value="">Select one</option>
									<option value="M">Male</option>
									<option value="F">Female</option>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date Of Birth : <span class="error">*</span></label>
                                <input id="datepicker1" name="dob" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Religion : <span class="error">*</span></label>
                                <select name="reg" class="required">
                                      <option value="" selected="selected">Select</option>
                                      <option value="Buddhist">Buddhist</option>
                                      <option value="Christian">Christian</option>
                                      <option value="Hindu">Hindu</option>
                                      <option value="Jain">Jain</option>
                                      <option value="Muslim">Muslim</option>
                                      <option value="Parsi">Parsi</option>
                                      <option value="Sikh">Sikh</option>
                                 </select>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Blood Group :</label>
                                <select  name='blood' id='blood' class="required">
                                    <option value="" selected="selected" >Select</option>
                                    <OPTION VALUE="A +ve">A +ve </OPTION>
                                    <OPTION VALUE="A -ve">A -ve </OPTION>
                                    <OPTION VALUE="B +ve">B +ve </OPTION>
                                    <OPTION VALUE="B -ve">B -ve </OPTION>
                                    <OPTION VALUE="O +ve">O +ve </OPTION>
                                    <OPTION VALUE="O -ve">O -ve </OPTION>
                                    <OPTION VALUE="AB +ve">AB +ve </OPTION>
                                    <OPTION VALUE="AB -ve">AB -ve </OPTION>
                                </select>
                            </p>
						</div>
						  <div class="_25">
							<p>
                                <label for="textfield">Joining Date : <span class="error">*</span></label>
                                <input id="j_date" name="j_date" class="required"  type="text" value="" />
                            </p>
						</div>
						 <div class="_25">
							<p>
                                <label for="textfield">Position :</label>
                                <input id="textfield" name="position"  type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Expriences:</label>
                                <input id="textfield" name="expriences"  type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Qualification : <span class="error">*</span></label>
                                <input id="qualify" name="qualify"  class="required" type="text" value="" />
                            </p>
						</div>
                        
						
						 <div class="_50">
							<p>
                                <label for="textfield">Email : <span class="error">*</span></label>
                                <input id="textfield" name="email1"  class="required" type="text" value="" />
                            </p>
						</div>
                          <div class="_50">
							<p>
                                <label for="textfield">Phone No : <span class="error">*</span></label>
                                <input id="textfield" name="phone" class="required"  type="text" value="" />
                            </p>
						</div>
						
                         <div class="_50">
							<p><label for="textarea">Residence Address1 : <span class="error">*</span></label><textarea id="textarea" name="address1" class="required" rows="5" cols="40"></textarea></p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Residence Address2 :</label><textarea id="textarea" name="address2" rows="5" cols="40"></textarea></p>
						</div> 
                        <div class="_50">
							<p>
                                <label for="select">Town or village Name : <span class="error">*</span></label>
                                <input id="textfield" name="city" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="select">Country : <span class="error">*</span></label>
                                <input id="textfield" name="country" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Pin Code :</label>
                                <input id="textfield" name="pincode"  type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Transport Type : </label>
                                	<select name="rid" id="rid" onchange="showCategory(this.value)">
											<option value="0">Not Bus Staff</option>	
                                            <option value="1">Bus Staff</option>											
									</select>
							</p>
						</div>
                        <div id="eleven_mark" style="display: none;">
                        <div class="_25">
							<p>
								<label for="select">Stopping Point :</label>
                               <select name="spid" id="spid">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Bus Type:</label>
                               <select name="busfeestype" id="busfeestype">
											<option value="0">Regular Bus</option>
                                            <option value="1">Sp.Bus</option>
                                            <option value="2">Onetime Sp.Bus</option>
                                            <option value="3">Onetime fees</option>												
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