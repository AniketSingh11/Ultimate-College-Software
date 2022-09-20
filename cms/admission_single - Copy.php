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
	
	$remarks=mysql_real_escape_string($_POST['remarks']);
	$sid=mysql_real_escape_string($_POST['sid']);
	
	$paid=mysql_real_escape_string($_POST['paid']);
	
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
	
	$newfilename = $admin_number1 . $file_ext;
	if($image[error]!=4){
			
			if (!is_valid_type($image) || $filesize>1000000) {
   	 		//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
    		header("Location:admission_single.php?bid=$bid&msg=eronimg");
    		exit;
			}
			$TARGET_PATH .=$newfilename;
			if (move_uploaded_file($image['tmp_name'], $TARGET_PATH)) {
		 $sql="INSERT INTO student (ss_id,admission_number,firstname,lastname,dob,gender,blood,nation,reg,caste,sub_caste,fathersname,email,password,address1,address2,city_id,state,country,pin,phone_number,user_status,joined_date,c_id,s_id,fathersocupation,p_income,m_name,m_occup,m_income,doa,mother_tongue,height,weight,remarks,b_id,stype,fdis_id,r_id,sp_id,busfeestype,ay_id,photo,pa_id) VALUES
('','$admin_number1','$fname','$lname','$dob','$gender','$blood','$belong','$religion','$caste','$subcaste','$p_name','$email','$admin_number1','$address1','$address2','$village','$state','$country','$pincode','$phone','1','$todaydate','$cid','$sid','$p_occup','$p_income','$m_name','$m_occup','$m_income','$doa','$m_tongue','$height','$weight','$remarks','$bid','$stype','$fdis_id','$rid','$spid','$busfeestype','$acyear','$newfilename','$paid')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

$lastid = mysql_insert_id();

$sql1="INSERT INTO parent (p_name,password,phone_number,user_status,joined_date,c_id,s_id,ocupation,ay_id,ss_id,email,admin_no,b_id) VALUES
('$p_name','$phone','$phone','1','$todaydate','$cid','$sid','$p_occup','$acyear','$lastid','$email','$admin_number1','$bid')";

$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
    if($result && $result1){
		
		$sql1=mysql_query("UPDATE admin_no_count SET count='$adminno2' WHERE id='1'");	
		$sql1=mysql_query("UPDATE pre_admission SET c_id='$cid',b_id='$bid',admin_id='$admin_number1',allocat='1' WHERE pa_id='$paid'");	
        header("Location:admission_single.php?bid=$bid&msg=succ&lid=$lastid");
    }
    exit;
	} else {
				header("Location:admission_single.php?bid=$bid&msg=eronfile");
				exit;
			}

			
	} else {
		
		$photo=$admin_number1.".JPG";
		 $sql="INSERT INTO student (ss_id,admission_number,firstname,lastname,dob,gender,blood,nation,reg,caste,sub_caste,fathersname,email,password,address1,address2,city_id,state,country,pin,phone_number,user_status,joined_date,c_id,s_id,fathersocupation,p_income,m_name,m_occup,m_income,doa,mother_tongue,height,weight,remarks,b_id,stype,fdis_id,r_id,sp_id,busfeestype,ay_id,photo,pa_id) VALUES
('','$admin_number1','$fname','$lname','$dob','$gender','$blood','$belong','$religion','$caste','$subcaste','$p_name','$email','$admin_number1','$address1','$address2','$village','$state','$country','$pincode','$phone','1','$todaydate','$cid','$sid','$p_occup','$p_income','$m_name','$m_occup','$m_income','$doa','$m_tongue','$height','$weight','$remarks','$bid','$stype','$fdis_id','$rid','$spid','$busfeestype','$acyear','$photo','$paid')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

$lastid = mysql_insert_id();

$sql1="INSERT INTO parent (p_name,password,phone_number,user_status,joined_date,c_id,s_id,ocupation,ay_id,ss_id,email,admin_no,b_id) VALUES
('$p_name','$phone','$phone','1','$todaydate','$cid','$sid','$p_occup','$acyear','$lastid','$email','$admin_number1','$bid')";

$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
    if($result && $result1){				
		$sql1=mysql_query("UPDATE admin_no_count SET count='$adminno2' WHERE id='1'");
		$sql1=mysql_query("UPDATE pre_admission SET c_id='$cid',b_id='$bid',admin_id='$admin_number1',allocat='1' WHERE pa_id='$paid'");
        header("Location:admission_single.php?bid=$bid&msg=succ&lid=$lastid");
    }
    exit;
		
	}
}		
?>
 <link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
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
		$bid=$_GET['bid'];
		$lid=$_GET['lid'];
		if($lid){
			$adminlist=mysql_query("SELECT * FROM student WHERE ss_id=$lid"); 
								  $anim=mysql_fetch_array($adminlist);
								  $rno=$anim['admission_number'];
								  $rname=$anim['firstname']."".$anim['lastname'];
								  
								  $totalstring=$rno."-".$rname;
								  
								  $cid=$anim['c_id'];
								  $sid=$anim['s_id'];
		}
		/*$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);*/
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="admission.php" title="Admission">Admission</a></li>
				<li class="no-hover">Student Admission</li> 
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
				<h1><a href="admission.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>  Admission <?php if($lid){ ?><a href="student_prt.php?ssid=<?php echo $lid;?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-warning"><img src="img/icons/packs/fugue/16x16/printer--plus.png"> Student Detail Print </button></a>  <a href="billing.php?roll=<?php echo $totalstring."&bid=".$bid;?>" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success"><img src="img/icons/packs/fugue/16x16/piggy-bank.png"> Last Admission Fees Payment </button></a> <?php } ?></h1>
                <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php }else if($msg=="eronfile"){?>			
            <div class="alert error"><span class="hide">x</span>Please Upload this type of file only (.png , .jpg , .Gif) AND also file size lessthen 1MB!!!</div>
            <?php } ?>
                <?php if($_GET['roll']){ 
				$roll=$_GET['roll'];
					$classes=explode("-",$roll);  
					//print_r($classes);
					$rollno=$classes[0];  
					$studentname=$classes[1];
					
					$studentlist2=mysql_query("SELECT * FROM pre_admission WHERE pa_admission_no='$rollno'"); 
								  $row=mysql_fetch_array($studentlist2);
								  
								  $cid=$row['c_id'];							
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
					
				$adminlist=mysql_query("SELECT * FROM admin_no_count WHERE id='1'"); 
								  $admincount=mysql_fetch_array($adminlist);	  
								  
								  $adminno=$admincount['count'];
								  
								 $admin_number="SMS".str_pad($adminno, 5, '0', STR_PAD_LEFT);
								 if(!$row){
			header("location:admission_single.php?bid=$bid");
		}
		?>
					<div class="block-border">
					<div class="block-header">
						<h1>Add New Student Details</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
                        <div class="_25">
                                <p>
                                    <label for="textfield">Pre Admin NO : <span class="error">*</span></label>
                                    <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $rollno;?>" readonly  />
                                </p>
                            </div>
						<div class="_25">
							<p>
                                <label for="textfield">Admin NO : <span class="error">*</span></label>
                                <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $admin_number;?>" readonly  />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">First Name: <span class="error">*</span></label>
                                <input id="textfield" name="fname" class="required" type="text" value="<?php echo $row['firstname'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Last Name:</label>
                                <input id="textfield" name="lname" type="text" value="<?php echo $row['lastname'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father / Guardian Name: <span class="error">*</span></label>
                                <input id="textfield" name="p_name" class="required" type="text" value="<?php echo $row['fathersname'];?>" />
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
                                <label for="textfield">Father / Guardian Monthly Income:</label>
                                <input id="textfield" name="p_income" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Mother's Name : </label>
                                <input id="textfield" name="m_name" type="text" value="<?php echo $row['m_name'];?>" />
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
                                <label for="textfield">Date of admission : <span class="error">*</span></label>
                                <input id="datepicker" name="doa" type="text" value="<?php echo date("d/m/Y");?>" class="required" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date Of Birth : <span class="error">*</span></label>
                                <input id="datepicker1" name="dob" class="required" type="text" value="<?php echo $row['dob'];?>" />
                            </p>
						</div>
                       <div class="_25">
							<p>
								<label for="select">Gender : <span class="error">*</span></label>
								<select name="gender"><?php $gen=$row['gender'];?>
									<option value="M" <?php if($row['gender']=='M'){ echo 'selected'; }?>>Male</option>
									<option value="F" <?php if($row['gender']=='F'){ echo 'selected'; }?>>Female</option>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Nationality:</label>
                                <input id="textfield" name="belong" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Religion : <span class="error">*</span></label>
                                <input id="textfield" name="religion" class="required" type="text" value="<?php echo $row['reg'];?>" />
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
                        <div class="_25">
							<p>
                                <label for="textfield">Email :</label>
                                <input id="textfield" name="email" type="text" value="<?php echo $row['email'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Phone : <span class="error">*</span></label>
                                <input id="textfield" name="phone" class="required" type="text" value="<?php echo $row['phone_number'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Residence Address1 : <span class="error">*</span></label><textarea id="textarea" name="address1" class="required" rows="5" cols="40"><?php echo $row['address1'];?></textarea></p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Residence Address2 :</label><textarea id="textarea" name="address2" rows="5" cols="40"></textarea></p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">City or village Name : <span class="error">*</span></label>
                                <input id="textfield" name="village" class="required" type="text" value="<?php echo $row['city_id'];?>" />
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">State : <span class="error">*</span></label>
                                <input id="textfield" name="state" class="required" type="text" value="<?php echo $row['state'];?>" />
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Country : <span class="error">*</span></label>
                                <input id="textfield" name="country" class="required" type="text" value="<?php echo $row['country'];?>" />
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Pin Code : <span class="error">*</span></label>
                                <input id="textfield" name="pincode" class="required" type="text" value="<?php echo $row['pin'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Remarks :</label>
                            <textarea id="textarea" name="remarks" rows="5" cols="40"></textarea></p>
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
                        <div class="_25">
							<p>
                                <label for="textfield">Mother Tongue : <span class="error">*</span></label>
                                <input id="textfield" name="m_tongue" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                                <input id="textfield" name="cid1" class="required" type="text" value="<?php echo $class['c_name'];?>" readonly />
							</p>
						</div>
                         <div class="clear"></div>
                        <div class="_25">
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
                        <div class="_25">
							<p>
								<label for="select">Student Type : <span class="error">*</span></label>
								<select name="stype" class="required">
									<option value="Old">Old Student</option>
									<option value="New" selected>New Student</option>
								</select>
							</p>
						</div>
                        <div class="_25">
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
								<label for="select">Fees Rate Type:</label>
                               <select name="busfeestype" id="busfeestype">
											<option value="0">Normal Fees</option>
                                            <option value="1">Sp.Fees</option>
                                            <option value="2">Onetime Sp.Fees</option>											
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="file">Upload a Student Photo</label>
								<input type="file" name="file" id="file"/>
                                <!--<div style="width:330px;float:left;">
                                    <div id="webcam">
                                    </div>
                                    <div style="margin:5px;">
                                        <img src="js/web/webcamlogo.png" style="vertical-align:text-top"/>
                                        <select id="cameraNames" size="1" onChange="changeCamera()" style="width:245px;font-size:10px;height:25px;">
                                        </select>
                                    </div>
                                </div>
                                <div style="width:135px;float:left;">
                                    <p><button class="btn btn-small" id="btn1" onclick="base64_tofield()">Snapshot to form</button></p>
                                    <p><button class="btn btn-small" id="btn2" onclick="base64_toimage()">Snapshot to image</button></p>
                                </div>
                                <div style="width:200px;float:left;">
                                    <p><textarea id="formfield" style="width:190px;height:70px;"></textarea></p>
                                    <p><img id="image" style="width:200px;height:153px;"/></p>
                                </div>
							</p>
						</div>    
                        <div class="_50">
							<p>
								<a href="#"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/camera--plus.png"> Take Photo From WebCam </button></a>--> 
							</p>
						</div>                     
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $row['c_id'];?>" >
                            <input type="hidden" class="medium" name="paid" value="<?php echo $row['pa_id'];?>" >
                            <input type="hidden" class="medium" name="bid" value="<?php echo $row['b_id'];?>" >
								<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
				<?php	} else {
		?>
        <div class="field-group">
                            <form id="validate-form" class="block-content form" method="get" action="">
                            <div class="_25">
                            <p>
                            <label for="required">Pre Admission No:</label>
                            <input type="text" name="roll" class="biginput" id="autocomplete" /> 
                            </p>
                            </div>
                            <div class="_25">
                            <p style="margin-top:25px;">
                            <input name="bid" value="<?php echo $bid;?>" type="hidden" />
                            <button type="submit" name="" class="btn btn-error">Submit</button>
                             </p>
                            </div>
                            </form>											
                        </div> <!-- .field-group -->        
        <?php  } ?>
        <div class="clear height-fix"></div>
        </div>
        </div>
        </div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");
	?>
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <!--<script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>  jQuery UI -->
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

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="Book_inventory/js/jquery.autocomplete.min.js"></script>
<script type="text/javascript">
$(function(){
  var currencies = [
    <?php
$sql = mysql_query("SELECT * FROM pre_admission WHERE status='1' AND allocat='0' AND ay_id=$acyear");
while ($thisrow = mysql_fetch_array($sql)){	
$sname=$thisrow['firstname']." ".$thisrow['lastname'];
echo "{ value:'$thisrow[pa_admission_no]-$sname', name:'$thisrow[firstname]', reg:'$thisrow[reg]', cid:'$thisrow[c_id]', sid:'$thisrow[s_id]'},";
}
?>  
  ];
  
  // setup autocomplete function pulling from currencies[] array
  $('#autocomplete').autocomplete({
    lookup: currencies
  });

});
</script>
<script type="text/javascript">
$().ready(function() {
	var validateform = $("#validate-form").validate();
	$( "#datepicker" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });			
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });			   
});
</script>
</body>
</html>
<? ob_flush(); ?>