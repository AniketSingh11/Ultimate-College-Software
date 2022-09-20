<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/standard.php");
 
  function is_valid_type($file) {
    $valid_types = array("image/jpg","image/jpeg", "image/png", "image/bmp", "image/gif");
    if (in_array($file['type'], $valid_types))
        return 1;
    return 0;
}

 if (isset($_POST['submit']))
{
	$admin_no=mysql_real_escape_string($_POST['admin_no']);
	$fname=mysql_real_escape_string($_POST['fname']);
	$mname=mysql_real_escape_string($_POST['mname']);
	$lname=mysql_real_escape_string($_POST['lname']);
	$p_name=mysql_real_escape_string($_POST['p_name']);
	$p_occup=mysql_real_escape_string($_POST['p_occup']);
	$p_income=mysql_real_escape_string($_POST['p_income']);
	$m_name=mysql_real_escape_string($_POST['m_name']);
	$m_occup=mysql_real_escape_string($_POST['m_occup']);
	$m_income=mysql_real_escape_string($_POST['m_income']);
	
	/*$from_school=mysql_real_escape_string($_POST['from_school']);
	$eslc=mysql_real_escape_string($_POST['eslc']);
	$tc=mysql_real_escape_string($_POST['produced']);*/
	
	$doa=mysql_real_escape_string($_POST['doa']);
	$dob=mysql_real_escape_string($_POST['dob']);
	$gender=mysql_real_escape_string($_POST['gender']);
	
	/*$protected=mysql_real_escape_string($_POST['protected']);*/
	
	$belong=mysql_real_escape_string($_POST['belong']);
	$religion=mysql_real_escape_string($_POST['religion']);
	$caste=mysql_real_escape_string($_POST['caste']);
	$subcaste=mysql_real_escape_string($_POST['subcaste']);
	$blood=mysql_real_escape_string($_POST['blood']);
	$email=mysql_real_escape_string($_POST['email']);
	$phone=mysql_real_escape_string($_POST['phone']);
	$address1=mysql_real_escape_string($_POST['address1']);
	$address2=mysql_real_escape_string($_POST['address2']);
	$village=mysql_real_escape_string($_POST['village']);
	$country=mysql_real_escape_string($_POST['country']);
	$pincode=mysql_real_escape_string($_POST['pincode']);
	$m_tongue=mysql_real_escape_string($_POST['m_tongue']);
	$height=mysql_real_escape_string($_POST['height']);
	$weight=mysql_real_escape_string($_POST['weight']);
	
	$leaving=mysql_real_escape_string($_POST['leaving']);
	$notc=mysql_real_escape_string($_POST['tc']);
	$dol=mysql_real_escape_string($_POST['dol']);
	$reason_leaving=mysql_real_escape_string($_POST['reason_leaving']);
	
	$remarks=mysql_real_escape_string($_POST['remarks']);
	$sid=mysql_real_escape_string($_POST['sid']);
	$cid=mysql_real_escape_string($_POST['cid']);
	$ssid=mysql_real_escape_string($_POST['ssid']);
	$bid=mysql_real_escape_string($_POST['bid']);
	$stype=mysql_real_escape_string($_POST['stype']);
	$fdis_id=mysql_real_escape_string($_POST['category']);	
	$rid=mysql_real_escape_string($_POST['rid']);
	$spid=mysql_real_escape_string($_POST['spid']);
	$busfeestype=mysql_real_escape_string($_POST['busfeestype']);	
	$status=mysql_real_escape_string($_POST['status']);	
	
	$lastphoto=$_POST['photo'];
	
	$TARGET_PATH = "./img/student/";
	$image = $_FILES['file'];
	$filesize = $_FILES["file"]["size"];
	$TARGET_PATH .= $image['file'];
	//echo '<pre>'; print_r($image); echo '</pre>';
	//die();
	
	$filename = addslashes($_FILES["file"]["name"]);
	$filecon=$matriID;
	
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	$filesize = $_FILES["file"]["size"];
	
	$newfilename = $admin_no . $file_ext;
	if($image[error]!=4){
			
			if (!is_valid_type($image) || $filesize>1000000) {
   	 		//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
    		header("Location:student_edit.php?cid=$cid&sid=$sid&ssid=$ssid&msg=eronimg");
    		exit;
			}
			$TARGET_PATH .=$newfilename;
			if (move_uploaded_file($image['tmp_name'], $TARGET_PATH)) {
	$sql="UPDATE student SET admission_number='$admin_no',firstname='$fname',lastname='$lname',middlename='$mname',dob='$dob',gender='$gender',blood='$blood',nation='$belong',reg='$religion',caste='$caste',sub_caste='$subcaste',fathersname='$p_name',email='$email',address1='$address1',address2='$address2',city_id='$village',country='$country',pin='$pincode',phone_number='$phone',user_status='$status',fathersocupation='$p_occup',p_income='$p_income',m_name='$m_name',m_occup='$m_occup',m_income='$m_income',from_school='$from_school',doa='$doa',mother_tongue='$m_tongue',height='$height',weight='$weight',std_leaving='$leaving',no_date_tran='$notc',dol='$dol',reason_leaving='$reason_leaving',remarks='$remarks',b_id='$bid',stype='$stype',fdis_id='$fdis_id',r_id='$rid',sp_id='$spid',busfeestype='$busfeestype',ay_id='$acyear',photo='$newfilename' WHERE ss_id='$ssid'";
	
		
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

$sql1="UPDATE parent SET p_name='$p_name',phone_number='$phone',ocupation='$p_occup',ay_id='$acyear',email='$email',admin_no='$admin_no',b_id='$bid' WHERE ss_id='$ssid'";
	
$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
    if($result && $result1){
        header("Location:student_edit.php?cid=$cid&sid=$sid&ssid=$ssid&msg=succ");
    }
    exit;
	} else {
				//$_SESSION['error'] = "Could not upload file.  Check read/write persmissions on the directory";
				header("Location:student_edit.php?cid=$cid&sid=$sid&ssid=$ssid&msg=eronfile");
				exit;
			}

			
	} else {
		/*if(($lastphoto =='student_boy.png') || ($lastphoto =='student_girl.png')){ 
		if($gender=='M'){
				$photo="student_boy.png";
			}else{
				$photo="student_girl.png";
			}	
		}else{*/
			$photo=$admin_no.".JPG";
		//}
		$sql="UPDATE student SET admission_number='$admin_no',firstname='$fname',lastname='$lname',middlename='$mname',dob='$dob',gender='$gender',blood='$blood',nation='$belong',reg='$religion',caste='$caste',sub_caste='$subcaste',fathersname='$p_name',email='$email',address1='$address1',address2='$address2',city_id='$village',country='$country',pin='$pincode',phone_number='$phone',user_status='$status',fathersocupation='$p_occup',p_income='$p_income',m_name='$m_name',m_occup='$m_occup',m_income='$m_income',from_school='$from_school',doa='$doa',mother_tongue='$m_tongue',height='$height',weight='$weight',std_leaving='$leaving',no_date_tran='$notc',dol='$dol',reason_leaving='$reason_leaving',remarks='$remarks',b_id='$bid',stype='$stype',fdis_id='$fdis_id',r_id='$rid',sp_id='$spid',busfeestype='$busfeestype',ay_id='$acyear',photo='$photo' WHERE ss_id='$ssid'";
	
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

$sql1="UPDATE parent SET p_name='$p_name',phone_number='$phone',ocupation='$p_occup',ay_id='$acyear',email='$email',admin_no='$admin_no',b_id='$bid' WHERE ss_id='$ssid'";
	
$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
    if($result && $result1){
        header("Location:student_edit.php?cid=$cid&sid=$sid&ssid=$ssid&msg=succ");
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
    				<?php 
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$ssid=$_GET['ssid'];
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $bid=$class['b_id'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	 // echo $class['c_name']."-".$section['s_name'];
								 $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $row=mysql_fetch_array($studentlist);	 
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="board_select.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="standard.php?bid=<?php echo $bid;?>" title="Standard list">Standard list</a></li>
                <li class="no-hover"><a href="section.php?cid=<?php echo $cid; ?>" title="Section/Group"><?php  echo $class['c_name'];?> Section/Group list</a></li>
                <li class="no-hover"><a href="student.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>" title="student list"><?php echo $class['c_name']."-".$section['s_name'];?> student list</a></li>
                <li class="no-hover">Edit Student Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Student Details (<?php echo $class['c_name']."-".$section['s_name'];?>)</h1>                
			<a href="student.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php } else if($msg=="eronfile"){?>			
            <div class="alert error"><span class="hide">x</span>Please Upload this type of file only (.png , .jpg , .Gif) AND also file size lessthen 1MB!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Student Details</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_25">
							<p>
                                <label for="textfield">Admin NO : <span class="error">*</span></label>
                                <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $row['admission_number']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">First Name of Pupil :<span class="error">*</span></label>
                                <input id="textfield" name="fname" class="required" type="text" value="<?php echo $row['firstname']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Last Name of Pupil :</label>
                                <input id="textfield" name="lname" type="text" value="<?php echo $row['lastname']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield"> Father / Guardian Name:<span class="error">*</span></label>
                                <input id="textfield" name="p_name" class="required" type="text" value="<?php echo $row['fathersname']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father / Guardian Occupation:<span class="error">*</span></label>
                                <input id="textfield" name="p_occup" class="required" type="text" value="<?php echo $row['fathersocupation']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father / Guardian Monthly Income:</label>
                                <input id="textfield" name="p_income" type="text" value="<?php echo $row['p_income']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Mother's Name : </label>
                                <input id="textfield" name="m_name" type="text" value="<?php echo $row['m_name']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Mother's Occupation : </label>
                                <input id="textfield" name="m_occup" type="text" value="<?php echo $row['m_occup']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield"> Mother's Monthly Income: </label>
                                <input id="textfield" name="m_income" type="text" value="<?php echo $row['m_income']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date of admission :</label>
                                <input id="datepicker" name="doa" type="text" value="<?php echo $row['doa']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date Of Birth :<span class="error">*</span></label>
                                <input id="datepicker1" name="dob" class="required" type="text" value="<?php echo $row['dob']; ?>" />
                            </p>
						</div>
                       <div class="_25">
							<p>
								<label for="select">Gender :<span class="error">*</span></label>
								<select name="gender"><?php $gen=$row['gender'];?>
									<option value="M" <?php if($row['gender']=='M'){ echo 'selected'; }?>>Male</option>
									<option value="F" <?php if($row['gender']=='F'){ echo 'selected'; }?>>Female</option>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Nationality :</label>
                                <input id="textfield" name="belong" type="text" value="<?php echo $row['nation']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Religion :<span class="error">*</span></label>
                                <input id="textfield" name="religion" class="required" type="text" value="<?php echo $row['reg']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Caste : <span class="error">*</span></label>
                                <input id="textfield" name="caste" class="required" type="text" value="<?php echo $row['caste']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Subcaste : </label>
                                <input id="textfield" name="subcaste" type="text" value="<?php echo $row['sub_caste']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Blood Group : <span class="error">*</span></label>
                                <input id="textfield" name="blood" class="required" type="text" value="<?php echo $row['blood']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Email :</label>
                                <input id="textfield" name="email" type="text" value="<?php echo $row['email']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Phone : <span class="error">*</span></label>
                                <input id="textfield" name="phone" class="required" type="text" value="<?php echo $row['phone_number']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Residence Address1 : <span class="error">*</span></label><textarea id="textarea" name="address1" class="required" rows="5" cols="40"><?php echo $row['address1']; ?></textarea></p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Residence Address2 :</label><textarea id="textarea" name="address2" rows="5" cols="40"><?php echo $row['address2']; ?></textarea></p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Town or village Name : <span class="error">*</span></label>
                                <input id="textfield" name="village" class="required" type="text" value="<?php echo $row['city_id']; ?>" />								
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Country : <span class="error">*</span></label>
                                <input id="textfield" name="country" class="required" type="text" value="<?php echo $row['country']; ?>" />								
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Pin Code : <span class="error">*</span></label>
                                <input id="textfield" name="pincode" class="required" type="text" value="<?php echo $row['pin']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Mother Tongue of the Pubil : <span class="error">*</span></label>
                                <input id="textfield" name="m_tongue" class="required" type="text" value="<?php echo $row['mother_tongue']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Height : </label>
                                <input id="textfield" name="height" type="text" value="<?php echo $row['height']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Weight : </label>
                                <input id="textfield" name="weight" type="text" value="<?php echo $row['weight']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Std. on leaving :</label>
                                <input id="textfield" name="leaving" type="text" value="<?php echo $row['std_leaving']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">No. & Date of Transfer Certificate produced :</label>
                                <input id="textfield" name="notc"  type="text" value="<?php echo $row['no_date_tran']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date of leaving :</label>
                                <input id="datepicker2" name="dol"  type="text" value="<?php echo $row['dol']; ?>" />
                            </p>
						</div>
                         <div class="_25">
							<p>
                                <label for="textfield">Reason for leaving :</label>
                                <input id="textfield" name="reason_leaving"  type="text" value="<?php echo $row['reason_leaving']; ?>" />
                            </p>
						</div>
                        <div class="_100">
							<p><label for="textarea">Remarks :</label><textarea id="textarea" name="remarks" rows="5" cols="40"><?php echo $row['remarks']; ?></textarea></p>
						</div>
                        <div class="_100">
							<p>
								<label for="select">Student Category :</label>
									<select name="category" class="required">
                                    <?php 
									$fdis_id=$row['fdis_id'];
									$sql1=mysql_query("SELECT * FROM fdiscount");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									if($fdis_id==$row2['fdis_id']){?>
                                    <option value="<?php echo $row2['fdis_id'];?>" selected><?php echo $row2['fdis_name'];?></option>
                                    <?php } else { ?>
												<option value="<?php echo $row2['fdis_id'];?>"><?php echo $row2['fdis_name'];?></option>
                                <?php } }?>
											</select>								
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Student Type :</label>
									<select name="stype" class="required">
												<option value="Old" <?php if($row['stype']=='Old'){ echo 'selected'; }?>>Old Student</option>
								<option value="New" <?php if($row['stype']=='New'){ echo 'selected'; }?>>New Student</option>
											</select>								
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Active Status :</label>
									<select name="status">
												<option value="1" <?php if($row['user_status']=='1'){ echo 'selected'; }?>>Enabled</option>
								<option value="0" <?php if($row['user_status']=='0'){ echo 'selected'; }?>>Disabled</option>
											</select>								
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Route Master : </label>
                                	<?php
											$rid=$row['r_id'];
                                            $result1 = mysql_query("SELECT * FROM route") or die(mysql_error());
                                            echo '<select name="rid" id="rid" onchange="showCategory(this.value)"> <option value="0">Not Bus Student</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($rid==$row1['r_id']){
                                                echo "<option value='{$row1['r_id']}' selected>{$row1['r_name']}</option>\n";
												}else{
												echo "<option value='{$row1['r_id']}'>{$row1['r_name']}</option>\n";	
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Stopping Point :</label>
                               <select name="spid" id="spid">
                               		<?php $spid=$row['sp_id'];
											if(!$spid || $spid==0){?>
											<option value="0">Please select</option>
                                            <?php } else{ 
											$query = mysql_query("SELECT * FROM stopping WHERE sp_id = '$spid'"); 
											$row4 = mysql_fetch_assoc($query);
											?>
                                            <option value="<?php echo $row4['sp_id'];?>"><?php echo $row4['sp_name'];?></option>
                                            <?php } ?>											
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
                            <?php 
				$fesstypearray=array("Normal Fees","Sp.Fees","Onetime Sp.Fees"); 
				?>	
								<label for="select">Fees Rate Type:</label>
                               <select name="busfeestype" id="busfeestype">
                               <?php
							   $busfeestype=$row['busfeestype'];
				for ($cmonth = 0; $cmonth <= 2; $cmonth++) { 
				if($busfeestype==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected" ><?php echo $fesstypearray[$cmonth]?></option>
            <?php }else { ?>
            <option value="<?php echo $cmonth;?>" ><?php echo  $fesstypearray[$cmonth]?></option>            
            <?php } }?>	
											<!--<option value="0">Normal Fees</option>
                                            <option value="1">Sp.Fees</option>
                                            <option value="2">Onetime Sp.Fees</option>	-->										
								</select>
							</p>
						</div>
                         <div class="_100">
							<p>
								<label for="file">Upload a Student Photo</label>
								<img src="img/student/<?php echo $row['photo'];?>" width="50">
								<input type="file" name="file" id="file"/>
							</p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                            <input type="hidden" class="medium" name="ssid" value="<?php echo $_GET['ssid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
                            <input type="hidden" class="medium" name="bid" value="<?php echo $bid;?>" >
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
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
		$( "#datepicker2" ).Zebra_DatePicker({
        format: 'm/d/Y'
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