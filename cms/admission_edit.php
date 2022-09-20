<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/admission.php");
   function is_valid_type($file) {
    $valid_types = array("image/jpg","image/jpeg", "image/png", "image/bmp", "image/gif");
    if (in_array($file['type'], $valid_types))
        return 1;
    return 0;
}
 if (isset($_POST['submit']))
{	
	$pid1=mysql_real_escape_string($_POST['pid']);
	
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
	
	$doa=mysql_real_escape_string($_POST['doa']);
	$dob=mysql_real_escape_string($_POST['dob']);
	$gender=mysql_real_escape_string($_POST['gender']);
	
	
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
	$state=mysql_real_escape_string($_POST['state']);
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
	//$rid=mysql_real_escape_string($_POST['rid']);
	$mode=mysql_real_escape_string($_POST['mode']);
	$rid=0;
	if($mode=="School Van"){
		$rid=1;
	}
	$spid=mysql_real_escape_string($_POST['spid']);
	$busfeestype=mysql_real_escape_string($_POST['busfeestype']);	
	$status=mysql_real_escape_string($_POST['status']);	
	
	$lastphoto=$_POST['photo'];
	
	$TARGET_PATH = "./img/student/";
	$image = $_FILES['file'];
	$filesize = $_FILES["file"]["size"];
	$TARGET_PATH .= $image['file'];
	
	$filename = addslashes($_FILES["file"]["name"]);
	$filecon=$matriID;
	
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	$filesize = $_FILES["file"]["size"];
	
	$newfilename = $admin_no . $file_ext;
	if($image[error]!=4){
			
			if (!is_valid_type($image) || $filesize>1000000) {
   	 		//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
    		header("Location:admission_edit.php?ssid=$ssid&bid=$bid&msg=eronimg");
    		exit;
			}
			$TARGET_PATH .=$newfilename;
			if (move_uploaded_file($image['tmp_name'], $TARGET_PATH)) {
	$sql="UPDATE student SET firstname='$fname',lastname='$lname',middlename='$mname',dob='$dob',gender='$gender',blood='$blood',nation='$belong',reg='$religion',caste='$caste',sub_caste='$subcaste',fathersname='$p_name',email='$email',address1='$address1',address2='$address2',city_id='$village',state='$state',country='$country',pin='$pincode',phone_number='$phone',phone1='$phone1',phone2='$phone2',phone3='$phone3',user_status='$status',fathersocupation='$p_occup',p_income='$p_income',m_name='$m_name',m_occup='$m_occup',m_income='$m_income',from_school='$from_school',doa='$doa',mother_tongue='$m_tongue',height='$height',weight='$weight',std_leaving='$leaving',no_date_tran='$notc',dol='$dol',reason_leaving='$reason_leaving',remarks='$remarks',b_id='$bid',stype='$stype',fdis_id='$fdis_id',r_id='$rid',sp_id='$spid',busfeestype='$busfeestype',ay_id='$acyear',photo='$newfilename',mode='$mode' WHERE ss_id='$ssid'";
	
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

$sql1="UPDATE parent SET p_name='$p_name',phone_number='$phone',phone1='$phone1',phone2='$phone2',phone3='$phone3',ocupation='$p_occup',ay_id='$acyear',email='$email',b_id='$bid' WHERE p_id='$pid1'";
	
$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
$qry=mysql_query("UPDATE student SET p_id='$pid1' WHERE ss_id='$ssid'");
    if($result && $result1){
        header("Location:admission_edit.php?ssid=$ssid&bid=$bid&msg=succ");
    }
    exit;
	} else {
				//$_SESSION['error'] = "Could not upload file.  Check read/write persmissions on the directory";
				header("Location:admission_edit.php?ssid=$ssid&bid=$bid&msg=eronfile");
				exit;
			}

			
	} else {
			$photo=$admin_no.".JPG";
		$sql="UPDATE student SET firstname='$fname',lastname='$lname',middlename='$mname',dob='$dob',gender='$gender',blood='$blood',nation='$belong',reg='$religion',caste='$caste',sub_caste='$subcaste',fathersname='$p_name',email='$email',address1='$address1',address2='$address2',city_id='$village',state='$state',country='$country',pin='$pincode',phone_number='$phone',user_status='$status',fathersocupation='$p_occup',p_income='$p_income',m_name='$m_name',m_occup='$m_occup',m_income='$m_income',from_school='$from_school',doa='$doa',mother_tongue='$m_tongue',height='$height',weight='$weight',std_leaving='$leaving',no_date_tran='$notc',dol='$dol',reason_leaving='$reason_leaving',remarks='$remarks',b_id='$bid',stype='$stype',fdis_id='$fdis_id',r_id='$rid',sp_id='$spid',busfeestype='$busfeestype',ay_id='$acyear',photo='$photo',mode='$mode' WHERE ss_id='$ssid'";
		
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

$sql1="UPDATE parent SET p_name='$p_name',phone_number='$phone',ocupation='$p_occup',ay_id='$acyear',email='$email',b_id='$bid' WHERE p_id='$pid1'";
$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
$qry=mysql_query("UPDATE student SET p_id='$pid1' WHERE ss_id='$ssid'");
    if($result && $result1){
        header("Location:admission_edit.php?ssid=$ssid&bid=$bid&msg=succ");
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
							$ssid=$_GET['ssid'];
								  $bid=$_GET['bid'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid");
							$board=mysql_fetch_array($boardlist);
								 $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $row=mysql_fetch_array($studentlist);	 
								  $cid=$row['c_id'];
								  $classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  
								  $pid=$row['p_id'];
								  if(!$pid){
									  $parentlist=mysql_query("SELECT * FROM sibling WHERE ss_id=$ssid"); 
								  	  $parent=mysql_fetch_array($parentlist);
									  $pid=$parent['p_id'];
								  }
								  if(!$pid){
									  $parentlist=mysql_query("SELECT * FROM parent WHERE ss_id=$ssid"); 
								  	  $parent=mysql_fetch_array($parentlist);
									  $pid=$parent['p_id'];									  
								  }
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_admin.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li class="no-hover"><a href="admission.php?bid=<?php echo $bid;?>" title="admission Student list">Admission Student List</a></li>  
                <li class="no-hover">Edit Student Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Student Details (<?php echo $class['c_name']."-".$section['s_name'];?>)</h1>                
			<a onclick="history.go(-1);" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
                                <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $row['admission_number']; ?>" readonly />
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
                                <label for="textfield">Father / Guardian Income:</label>
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
                        <div class="clear"></div>
                        <div class="_25">
							<p>
                                <label for="textfield">Nationality :</label>
                                <input id="textfield" name="belong" type="text" value="<?php echo $row['nation']; ?>" />
                            </p>
						</div>
                        <?php $religionlist=array("Buddhist","Christian","Hindu","Jain","Muslim","Parsi","Sikh"); 
                        echo '<div class="_25">
							<p>
                                <label for="textfield">Religion : <span class="error">*</span></label>
								<select  name="religion" id="religion" class="required">
                                    <option value="">Select</option>';
									$religionvalue=$row['reg'];
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
                        <?php $castelist=array("GENERAL","SC","ST","OBC","CHRISTIAN","MUSLIM","OTHERS");  ?>
                        <div class="_25">
							<p>
                                <label for="textfield">Community : <span class="error">*</span></label>
                                <select  name="caste" id="caste" class="required">
                                    <option value="" selected="selected" >Select</option>
                                <?php $castevalue=$row['caste'];
                                	  $comm=array("BC","MBC","DNC","SC","ST","SC(A)","OC","BC (M)","REFUGEE"); 
									for ($cmonth = 0; $cmonth <count($comm); $cmonth++) {
										if($castevalue==$comm[$cmonth]){
                                    echo '<OPTION VALUE="'.$comm[$cmonth].'" selected>'.$comm[$cmonth].'</OPTION>';
										}else{
									echo '<OPTION VALUE="'.$comm[$cmonth].'">'.$comm[$cmonth].'</OPTION>';		
										}
									} ?>
                                    </select>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Caste : </label>
                                <input id="textfield" name="subcaste" type="text" value="<?php echo $row['sub_caste']; ?>" />
                            </p>
						</div>
                        <?php $bloodlist=array("A +ve","A -ve","A1 +ve","A1 -ve","A2 +ve","A2 -ve","B +ve","B -ve","O +ve","O -ve","AB +ve","AB -ve","A1B +ve","A1B -ve");  ?>
                        <div class="_25">
							<p>
                                <label for="textfield">Blood Group : <span class="error">*</span></label>
                                <select  name="blood" id="blood" class="required">
                                    <option value="" selected="selected" >Select</option>
                                <?php $bloodvalue=$row['blood'];
									for ($cmonth = 0; $cmonth <= 13; $cmonth++) {
										if($bloodvalue==$bloodlist[$cmonth]){
                                    	echo '<OPTION VALUE="'.$bloodlist[$cmonth].'" selected>'.$bloodlist[$cmonth].'</OPTION>';
										}else{
										echo '<OPTION VALUE="'.$bloodlist[$cmonth].'">'.$bloodlist[$cmonth].'</OPTION>';		
										}
									} ?>
                                    </select>
                            </p>
						</div>
                        <div class="_50">
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
						 <div class="_25">
							<p>
                                <label for="textfield">Additional Phone : </label>
                                <input id="textfield" name="phone" class="required" type="text" value="<?php echo $row['phone2']; ?>" />
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
								<label for="select">State : <span class="error">*</span></label>
                                <input id="textfield" name="state" class="required" type="text" value="<?php echo $row['state']; ?>" />
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
                                <label for="textfield">Mother Tongue: <span class="error">*</span></label>
                                <input id="textfield" name="m_tongue" class="required" type="text" value="<?php echo $row['mother_tongue']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Additional Phone No 1 : </label>
                                <input id="textfield" name="phone1" type="text" value="<?php echo $row['phone1'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Additional Phone No 2 :</label>
                                <input id="textfield" name="phone2" type="text" value="<?php echo $row['phone2'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Additional Phone No 3 : </label>
                                <input id="textfield" name="phone3"  type="text" value="<?php echo $row['phone3'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Remarks :</label><textarea id="textarea" name="remarks" rows="8" cols="40"><?php echo $row['remarks']; ?></textarea></p>
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
                        <div class="_25">
							<p>
								<label for="select">Student Type :</label>
									<select name="stype" class="required">
												<option value="Old" <?php if($row['stype']=='Old'){ echo 'selected'; }?>>Old Student</option>
								<option value="New" <?php if($row['stype']=='New'){ echo 'selected'; }?>>New Student</option>
											</select>								
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Active Status :</label>
									<select name="status">
												<option value="1" <?php if($row['user_status']=='1'){ echo 'selected'; }?>>Enabled</option>
								<option value="0" <?php if($row['user_status']=='0'){ echo 'selected'; }?>>Disabled</option>
											</select>								
							</p>
						</div>
                      <?php $modelist=array("School Van","Private Van","Car","Auto","Two Wheeler","Goverment Bus","By Walk","Others"); 
                        echo '<div class="_25">
							<p>
                                <label for="textfield">Mode of Transport : <span class="error">*</span></label>
								<select  name="mode" id="mode" class="required" onchange="showCategory(this.value)">
                                    <option value="">Select</option>';
									$modevalue=$row['mode'];
									for ($cmonth = 0; $cmonth <= 4; $cmonth++) {
										if($modevalue==$modelist[$cmonth]){
                                    echo '<OPTION VALUE="'.$modelist[$cmonth].'" selected>'.$modelist[$cmonth].'</OPTION>';
										}else{
									echo '<OPTION VALUE="'.$modelist[$cmonth].'">'.$modelist[$cmonth].'</OPTION>';		
										}
									}
                                    echo '</select>
                            </p>
						</div>';  
							$rid=$row['r_id'];
						?>
                        <div class="clear"></div>
                        <div id="eleven_mark" <?php if(!$rid){ echo 'style="display: none;"';}?>>
                        <div class="_25">
							<p>
								<label for="select">Stopping Point :</label>
                               		<?php $spid=$row['sp_id'];
										$result1 = mysql_query("SELECT * FROM trstopping WHERE status='1'") or die(mysql_error());
                                            echo '<select name="spid" id="spid"> <option value="0">Please select</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($spid==$row1['stop_id']){
                                                echo "<option value='{$row1['stop_id']}' selected>{$row1['stop_name']}</option>\n";
												}else{
												echo "<option value='{$row1['stop_id']}'>{$row1['stop_name']}</option>\n";	
												}
                                            endwhile;
                                            echo '</select>'; ?>
							</p>
						</div>
                        <div class="_25">
							<p>
                            <?php 
				$fesstypearray=array("Normal Fees","Sp.Fees","Onetime Sp.Fees","Onetime Fees"); 
				?>	
								<label for="select">Fees Rate Type:</label>
                               <select name="busfeestype" id="busfeestype">
                               <?php
							   $busfeestype=$row['busfeestype'];
				for ($cmonth = 0; $cmonth <= 3; $cmonth++) { 
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
                        </div>
                         <div class="_50">
							<p>
								<label for="file">Upload a Student Photo</label>
								<input type="file" name="file" id="file"/>
							</p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>">
                            <input type="hidden" class="medium" name="ssid" value="<?php echo $_GET['ssid'];?>">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $bid;?>">
                            <input type="hidden" class="medium" name="pid" value="<?php echo $pid;?>">
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
  <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
    function showCategory(str) {
        if (str == "") {
            document.getElementById("spid").innerHTML = "";
            return;
        }
		if(str == 'School Van'){
        		$("#eleven_mark").show();        
        	}else{
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