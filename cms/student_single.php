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
	$sibling=mysql_real_escape_string($_POST['sibling']);
	
	$pid=mysql_real_escape_string($_POST['p_id']);
	$ssid1=mysql_real_escape_string($_POST['ss_id1']);
	
	$cid1=mysql_real_escape_string($_POST['c_id1']);
	$sid1=mysql_real_escape_string($_POST['s_id1']);
	$admin_no1=mysql_real_escape_string($_POST['admin_no1']);
	
	$bid1=mysql_real_escape_string($_POST['b_id1']);
	
	
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
	$date_split1= explode('/', $dob);		 
		 $date_month=$date_split1[1];
		 $date_day=$date_split1[0];
		 $date_year=$date_split1[2];
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
	
	/*$leaving=mysql_real_escape_string($_POST['leaving']);
	$notc=mysql_real_escape_string($_POST['tc']);
	$dol=mysql_real_escape_string($_POST['dol']);
	$reason_leaving=mysql_real_escape_string($_POST['reason_leaving']);
	$gone=mysql_real_escape_string($_POST['gone']);*/
	
	$remarks=mysql_real_escape_string($_POST['remarks']);
	$sid=mysql_real_escape_string($_POST['sid']);
	$cid=mysql_real_escape_string($_POST['cid']);
	$bid=mysql_real_escape_string($_POST['bid']);
	$stype=mysql_real_escape_string($_POST['stype']);
	$fdis_id=mysql_real_escape_string($_POST['category']);	
	$rid=mysql_real_escape_string($_POST['rid']);
	$spid=mysql_real_escape_string($_POST['spid']);
	$busfeestype=mysql_real_escape_string($_POST['busfeestype']);	
	$todaydate=date("d/m/Y H:i:s");
	
	$adminlist1=mysql_query("SELECT * FROM admin_no_count WHERE id='1'"); 
								  $admincount1=mysql_fetch_array($adminlist1);	
								  $adminno1=$admincount1['count'];
								  $adminno2=$adminno1+1;
								 $admin_number1="SMS".str_pad($adminno1, 5, '0', STR_PAD_LEFT);
			//$photo=$admin_number1.".jpg";					 
			
	 $uploadtype=mysql_real_escape_string($_POST['uploadtype']);
	
	 if($uploadtype=="Attachfile" )
	 {
	 
	$TARGET_PATH = "./img/student/";
	$image = $_FILES['file'];
	$filesize = $_FILES["file"]["size"];
	$TARGET_PATH .= $image['file'];
	//echo '<pre>'; print_r($image); echo '</pre>';
	//die();
	
	$filename = addslashes($_FILES["file"]["name"]);
	 if (!is_valid_type($image)) {
   	 		//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
    	header("Location:student_single.php?cid=$cid&sid=$sid&bid=$bid&msg=eronfile");
			echo $uploadtype;
    		exit;
			}
	 }else{
	  
	 $filename = $admin_number1.".jpg";
	 if(file_exists('jpegcam/htdocs/' .$filename)){
  $check=1;
 copy('jpegcam/htdocs/'.$filename, "img/student/".$filename);
 unlink('jpegcam/htdocs/' .$filename);
}else{
$filename="";
}
	  
	 }
	 
	
	
	$filecon=$matriID;
	
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	//$filesize = $_FILES["file"]["size"];
	
	$newfilename = $admin_number1 . $file_ext;
	if($filename!=""){
			
			
			$TARGET_PATH .=$newfilename;
			
			 
			if (move_uploaded_file($image['tmp_name'], $TARGET_PATH) || $check==1) {
		 $sql="INSERT INTO student (ss_id,admission_number,firstname,lastname,dob,day,month,year,gender,blood,nation,reg,caste,sub_caste,fathersname,email,password,address1,address2,city_id,country,pin,phone_number,user_status,joined_date,c_id,s_id,fathersocupation,p_income,m_name,m_occup,m_income,doa,mother_tongue,height,weight,remarks,b_id,stype,fdis_id,r_id,sp_id,busfeestype,ay_id,photo) VALUES
('','$admin_number1','$fname','$lname','$dob','$date_day','$date_month','$date_year','$gender','$blood','$belong','$religion','$caste','$subcaste','$p_name','$email','$admin_number1','$address1','$address2','$village','$country','$pincode','$phone','1','$todaydate','$cid','$sid','$p_occup','$p_income','$m_name','$m_occup','$m_income','$doa','$m_tongue','$height','$weight','$remarks','$bid','$stype','$fdis_id','$rid','$spid','$busfeestype','$acyear','$newfilename')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

$lastid = mysql_insert_id();

if($sibling && $pid){
	
	$siblinglist=mysql_query("SELECT * FROM sibling WHERE ss_id=$ssid1 AND p_id=$pid"); 
		  $sibling2=mysql_num_rows($siblinglist);
	if(!$sibling2){
		$sql1=mysql_query("INSERT INTO sibling (p_id,ss_id,c_id,s_id,b_id,ay_id,admin_no) VALUES
('$pid','$ssid1','$cid1','$sid1','$bid1','$acyear','$admin_no1')");
	}
	
	$sql1="INSERT INTO sibling (p_id,ss_id,c_id,s_id,b_id,ay_id,admin_no) VALUES
('$pid','$lastid','$cid','$sid','$bid','$acyear','$admin_number1')";
	$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
	$qry=mysql_query("UPDATE parent SET sibling='1' WHERE p_id='$pid'");
	$qry=mysql_query("UPDATE student SET p_id='$pid' WHERE ss_id='$lastid'");	
}else{
$sql1="INSERT INTO parent (p_name,password,phone_number,user_status,joined_date,c_id,s_id,ocupation,ay_id,ss_id,email,admin_no,b_id) VALUES
('$p_name','$phone','$phone','1','$todaydate','$cid','$sid','$p_occup','$acyear','$lastid','$email','$admin_number1','$bid')";
$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
$lastid1 = mysql_insert_id();
$qry=mysql_query("UPDATE student SET p_id='$lastid1' WHERE ss_id='$lastid'");
}
    if($result && $result1){		
		$sql1=mysql_query("UPDATE admin_no_count SET count='$adminno2' WHERE id='1'");		
        header("Location:student_single.php?cid=$cid&sid=$sid&bid=$bid&msg=succ");
    }
    exit;
	} else {
				header("Location:student_single.php?cid=$cid&sid=$sid&bid=$bid&msg=eronfile");
				exit;
			}			
	} else {
		
		$photo=$admin_number1.".JPG";
		  $sql="INSERT INTO student (ss_id,admission_number,firstname,lastname,dob,day,month,year,gender,blood,nation,reg,caste,sub_caste,fathersname,email,password,address1,address2,city_id,country,pin,phone_number,user_status,joined_date,c_id,s_id,fathersocupation,p_income,m_name,m_occup,m_income,doa,mother_tongue,height,weight,remarks,b_id,stype,fdis_id,r_id,sp_id,busfeestype,ay_id,photo) VALUES
('','$admin_number1','$fname','$lname','$dob','$date_day','$date_month','$date_year','$gender','$blood','$belong','$religion','$caste','$subcaste','$p_name','$email','$admin_number1','$address1','$address2','$village','$country','$pincode','$phone','1','$todaydate','$cid','$sid','$p_occup','$p_income','$m_name','$m_occup','$m_income','$doa','$m_tongue','$height','$weight','$remarks','$bid','$stype','$fdis_id','$rid','$spid','$busfeestype','$acyear','$photo')";
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid = mysql_insert_id();
if($sibling && $pid){	
	$siblinglist=mysql_query("SELECT * FROM sibling WHERE p_id=$pid AND ss_id=$ssid1"); 
		  $sibling2=mysql_num_rows($siblinglist);
		  
	if($sibling2<1){
		$sql1=mysql_query("INSERT INTO sibling (p_id,ss_id,c_id,s_id,b_id,ay_id,admin_no) VALUES
('$pid','$ssid1','$cid1','$sid1','$bid1','$acyear','$admin_no1')");
	}
	
	$sql1="INSERT INTO sibling (p_id,ss_id,c_id,s_id,b_id,ay_id,admin_no) VALUES
('$pid','$lastid','$cid','$sid','$bid','$acyear','$admin_number1')";
$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
$qry=mysql_query("UPDATE parent SET sibling='1' WHERE p_id='$pid'");
$qry=mysql_query("UPDATE student SET p_id='$pid' WHERE ss_id='$lastid'");	
}else{
$sql1="INSERT INTO parent (p_name,password,phone_number,user_status,joined_date,c_id,s_id,ocupation,ay_id,ss_id,email,admin_no,b_id) VALUES
('$p_name','$phone','$phone','1','$todaydate','$cid','$sid','$p_occup','$acyear','$lastid','$email','$admin_number1','$bid')";
$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
$lastid1 = mysql_insert_id();
$qry=mysql_query("UPDATE student SET p_id='$lastid1' WHERE ss_id='$lastid'");
}
    if($result && $result1){
				
		$sql1=mysql_query("UPDATE admin_no_count SET count='$adminno2' WHERE id='1'");
        header("Location:student_single.php?cid=$cid&sid=$sid&bid=$bid&msg=succ");
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
    <link rel="stylesheet" href="payroll/js/plugins/select2/select2.css" type="text/css" />
    <!-- Begin of #main -->
    <div id="main" role="main">
    				<?php 
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $bid=$class['b_id'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	 // echo $class['c_name']."-".$section['s_name'];
								 
								 $adminlist=mysql_query("SELECT * FROM admin_no_count WHERE id='1'"); 
								  $admincount=mysql_fetch_array($adminlist);	  
								  
								  $adminno=$admincount['count'];
								  
								 $admin_number="SMS".str_pad($adminno, 5, '0', STR_PAD_LEFT);
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="board_select.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="standard.php?bid=<?php echo $bid;?>" title="Standard list">Standard list</a></li>
                <li class="no-hover"><a href="section.php?cid=<?php echo $cid; ?>" title="Section/Group"><?php  echo $class['c_name'];?> Section/Group list</a></li>
                <li class="no-hover"><a href="student.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>" title="Home"> <?php echo $class['c_name']."-".$section['s_name'];?> student list</a></li>
                <li class="no-hover">Add Single Student</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New Student details (<?php echo $class['c_name']."-".$section['s_name'];?>)</h1>                
			<a href="student.php?cid=<?php echo $cid; ?>&sid=<?php echo $sid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php }else if($msg=="eronfile"){?>			
            <div class="alert error"><span class="hide">x</span>Please Upload this type of file only (.png , .jpg , .Gif) AND also file size lessthen 1MB!!!</div>
            <?php } ?>
             <span style="float:right; margin-right:10%;"><label><input type="checkbox" name="sibling" id="poor" value="1" style="width:auto; " /> If Student have Sibling</label></span>  <br>   
            
				  <div class="block-border" >
					<div class="block-header">
						<h1>Add New Student Details</h1><span></span>
					</div>
					<form id="validate-form" style="display:none;" class="block-content form poor_student" action="" method="post" enctype="multipart/form-data">
                    	<div class="_25">
                                    <p>
                                        <label for="textfield">Admin NO : <span class="error">*</span></label>
                                        <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $admin_number;?>" readonly  />
                                    </p>
                                </div>
                                    <div class="_25">
                                    <p>
                                        <label for="textfield">Select Sibling </label>
                                        <select name="select-2"  class="form-control select2-input" id="sibling" style="width:100%">
										<option value="">Please Select</option>
                                        <?php
											$sql = mysql_query("SELECT * FROM student WHERE ay_id=$acyear");
											while ($thisrow = mysql_fetch_array($sql)){	
											$sname=$thisrow['firstname']." ".$thisrow['lastname'];?>
										<option value="<?php echo $thisrow['ss_id'];?>"><?php echo $thisrow['admission_number']."-".$sname;?></option>
                                        <?php } ?>
									</select>
                                    </p>
                                    </div>
                                    <div id="test"></div>
									
									
									
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
								<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				 
                
                
                
					<form id="validate-form1" class="block-content form normal_student" action="" method="post" enctype="multipart/form-data">
                    	<div class="_25">
							<p>
                                <label for="textfield">Admin NO : <span class="error">*</span></label>
                                <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $admin_number;?>" readonly  />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">First Name: <span class="error">*</span></label>
                                <input id="textfield" name="fname" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Last Name:</label>
                                <input id="textfield" name="lname" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father / Guardian Name: <span class="error">*</span></label>
                                <input id="textfield" name="p_name" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield"> Father / Guardian Occupation: <span class="error">*</span></label>
                                <input id="textfield" name="p_occup" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father / Guardian Income:</label>
                                <input id="textfield" name="p_income" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Mother's Name : </label>
                                <input id="textfield" name="m_name" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Mother's Occupation : </label>
                                <input id="textfield" name="m_occup" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield"> Mother's Monthly Income: </label>
                                <input id="textfield" name="m_income" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date of admission : </label>
                                <input id="datepicker" name="doa" type="text" value="" />
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
								<label for="select">Gender : <span class="error">*</span></label>
								<select name="gender" class="required">
									<option value="">Select one</option>
									<option value="M">Male</option>
									<option value="F">Female</option>
								</select>
							</p>
						</div>
                        <div class="clear"></div>
                        <div class="_25">
							<p>
                                <label for="textfield">Nationality:</label>
                                <input id="textfield" name="belong" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Email :</label>
                                <input id="textfield" name="email" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Phone : <span class="error">*</span></label>
                                <input id="textfield" name="phone" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Religion : <span class="error">*</span></label>
                                <input id="textfield" name="religion" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Caste : <span class="error">*</span></label>
                                <input id="textfield" name="caste" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Subcaste :</label>
                                <input id="textfield" name="subcaste" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Blood Group : <span class="error">*</span></label>
                                <input id="textfield" name="blood" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Residence Address1 : <span class="error">*</span></label><textarea id="textarea" name="address1" class="required" rows="5" cols="40"></textarea></p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Residence Address2 :</label><textarea id="textarea" name="address2" rows="5" cols="40"></textarea></p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">City or village Name : <span class="error">*</span></label>
                                <input id="textfield" name="village" class="required" type="text" value="" />
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
                                <label for="textfield">Pin Code : <span class="error">*</span></label>
                                <input id="textfield" name="pincode" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Mother Tongue : <span class="error">*</span></label>
                                <input id="textfield" name="m_tongue" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Height : </label>
                                <input id="textfield" name="height" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Weight : </label>
                                <input id="textfield" name="weight" type="text" value="" />
                            </p>
						</div>
                        <div class="_100">
							<p><label for="textarea">Remarks :</label>
                            <textarea id="textarea" name="remarks" rows="5" cols="40"></textarea></p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Student Category :</label>
									<select name="category" class="required">
                                    <?php 
									$sql1=mysql_query("SELECT * FROM fdiscount");
									while($row2=mysql_fetch_assoc($sql1))
									{ ?>
												<option value="<?php echo $row2['fdis_id'];?>"><?php echo $row2['fdis_name'];?></option>
                                <?php }?>
											</select>								
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Student Type : <span class="error">*</span></label>
								<select name="stype" class="required">
									<option value="Old">Old Student</option>
									<option value="New">New Student</option>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Route Master : </label>
                                	<?php
                                            $result1 = mysql_query("SELECT * FROM route") or die(mysql_error());
                                            echo '<select name="rid" id="rid" onchange="showCategory(this.value)"> <option value="0">Not Bus Student</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['r_id']}'>{$row1['r_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Stopping Point :</label>
                               <select name="spid" id="spid">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Fees Rate Type:</label>
                               <select name="busfeestype" id="busfeestype">
											<option value="0">Normal Fees</option>
                                            <option value="1">Sp.Fees</option>
                                            <option value="2">Onetime Sp.Fees</option>											
								</select>
							</p>
						</div>
						
						<div id="move_div1">
							 
						</div>
						
						<div id="webcam_full">
						 <div class="_50">
							<p>
								<label for="select">Upload Type:</label>
                               <select name="uploadtype" onChange="stdimage(this.value)" id="uploadtype">
							   <option value="Attachfile">Attach file</option>
											<option value="Webcam">Webcam</option>
                                            
                                            											
								</select>
							</p>
						</div>
						
						 <div class="_50" id="attach_file">
							<p>
								<label for="select">Attach File:</label>
                               <input type='file' name='file'>
							</p>
						</div>
						
						
						<script type="text/javascript" src="jpegcam/htdocs/webcam.js"></script>
						
	
	<!-- Configure a few settings -->
	<script language="JavaScript">
		webcam.set_api_url( 'jpegcam/htdocs/test.php?id=<?=$admin_number?>' );
		webcam.set_quality( 90 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>
	
	<!-- Next, write the movie to the page at 320x240 -->
	<script language="JavaScript">
		document.write( webcam.get_html(320, 240) );
	</script>
	
	<!-- Some buttons for controlling things -->
	<br/><div id="web_status" style="display:none;">
		<input type=button style="width:20%;" class="btn btn-small" value="Configure..." onClick="webcam.configure()"/>
		&nbsp;&nbsp;
		<input type=button style="width:20%;" class="btn btn-small btn-success" value="Capture" onClick="webcam.freeze()">
		&nbsp;&nbsp;
		<input type=button style="width:20%;" class="btn btn-small btn-warning" value="Upload" onClick="do_upload()">
		&nbsp;&nbsp;
		<input type=button style="width:20%;" class="btn btn-small btn-error" value="Reset" onClick="webcam.reset()">
		
	</div>
	
	<!-- Code to handle the server response (see test.php) -->
	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function do_upload() {
			// upload to server
			document.getElementById('upload_results').innerHTML = '<h1>Uploading...</h1>';
			webcam.upload();
		}
		
		function my_completion_handler(msg) {
			// extract URL out of PHP output
			if (msg.match(/(http\:\/\/\S+)/)) {
				var image_url = RegExp.$1;
				// show JPEG image in page
				$("#upload_results").html("");
				document.getElementById('upload_results').innerHTML = 
					'<h1>Upload Successful!</h1>' + 
					'<h3>JPEG URL: ' + image_url + '</h3>' + 
					'<img src="' + image_url + '">';
				
				// reset camera for another shot
				webcam.reset();
			}
			else alert("PHP Error: " + msg);
		}
	</script>
	
	</td><td width=50>&nbsp;</td><td valign=top>
		<div   id="upload_results" style="background-color:#eee;"></div>
	</td></tr></table>
                       </div> 
						
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
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
	
	$("#webcam_movie").hide();
		$("#sibling").change(function(){
        var thiss = $(this);
		//var stid = document.first.st_id.value;
        var value = thiss.val(); 
		 $( "#webcam_full" ).insertAfter( "#move_div1" );
		$.get("sibling.php",{value:value},function(data){
			$( "#test" ).html(data);
			$( "#webcam_full" ).insertAfter( "#move_div" );
						$( "#datepicker" ).Zebra_DatePicker({
						format: 'd/m/Y'
						});	
						$( "#datepicker1" ).Zebra_DatePicker({
						format: 'd/m/Y'
						});	
							$(".Zebra_DatePicker").css('top', "303px");
		$(".Zebra_DatePicker .dp_monthpicker").css('width', "303px");
		$(".Zebra_DatePicker .dp_yearpicker").css('width', "303px");
        });
    });
			
			var validateform = $("#validate-form").validate();
			var validateform = $("#validate-form1").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });			
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });			
		$( "#datepicker2" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
	
		$(".Zebra_DatePicker").css('top', "303px");
		$(".Zebra_DatePicker .dp_monthpicker").css('width', "303px");
		$(".Zebra_DatePicker .dp_yearpicker").css('width', "303px");
	$("#webcam").scriptcam({
					showMicrophoneErrors:false,
					onError:onError,
					cornerRadius:20,
					cornerColor:'e3e5e2',
					onWebcamReady:onWebcamReady,
					uploadImage:'upload.gif',
					onPictureAsBase64:base64_tofield_and_image
				});	
					
	});
	
	
	
	function stdimage(n)
	{
	if(n=="Webcam"){
	$("#webcam_movie").show();
	$("#web_status").show();
	$("#upload_results").show();
	 $("#attach_file").hide();
	}else{
	$("#webcam_movie").hide();
	$("#web_status").hide();
	$("#upload_results").hide();
	$("#attach_file").show();
	
	
	}
	
	}
	
	
	
	function base64_tofield() {
				$('#formfield').val($.scriptcam.getFrameAsBase64());
			};
			function base64_toimage() {
				$('#image').attr("src","data:image/png;base64,"+$.scriptcam.getFrameAsBase64());
			};
			function base64_tofield_and_image(b64) {
				$('#formfield').val(b64);
				$('#image').attr("src","data:image/png;base64,"+b64);
			};
			function changeCamera() {
				$.scriptcam.changeCamera($('#cameraNames').val());
			}
			function onError(errorId,errorMsg) {
				$( "#btn1" ).attr( "disabled", true );
				$( "#btn2" ).attr( "disabled", true );
				alert(errorMsg);
			}			
			function onWebcamReady(cameraNames,camera,microphoneNames,microphone,volume) {
				$.each(cameraNames, function(index, text) {
					$('#cameraNames').append( $('<option></option>').val(index).html(text) )
				}); 
				$('#cameraNames').val(camera);
			}			
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
	function showCategory1(str) {
		if (str == "") {
            document.getElementById("spid1").innerHTML = "";
            return;
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
                document.getElementById("spid1").innerHTML = xmlhttp.responseText;
            }
        }
		xmlhttp.open("GET", "stoppinglist.php?mmtid=" + str, true);
        xmlhttp.send();
    }  
	
	$("#poor").change(function(){
			if(this.checked) {
       			$('.poor_student').show();
				 
				 $( "#webcam_full" ).insertAfter( "#move_div" );
				$('.normal_student').hide();
			}else{
			$( "#webcam_full" ).insertAfter( "#move_div1" );
				$('.poor_student').hide();
				$('.normal_student').show();				
			}
    	});	
</script>  
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script src="js/jquery-migrate-1.2.1.js"></script>
  <script src="payroll/js/plugins/select2/select2.js"></script>
  <script>
$(function () {
	$('.select2-input').select2({
					placeholder: "Select..."
				});
			// Just for the demo
			$('#time-2').val ('');

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