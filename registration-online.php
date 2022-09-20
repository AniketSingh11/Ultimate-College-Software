<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
//include("sms/includes/config.php");
include("sms/includes/config.php");
	$month=date("m");
	
 
	$year=date("Y");	
if($month>=3){
		$yearlist=mysql_query("SELECT * FROM year WHERE s_year=$year"); 
		$year=mysql_fetch_array($yearlist);
		$acyear=$year['ay_id'];
		$acname=$year['y_name'];
}else if($month<3){
	$yearlist=mysql_query("SELECT * FROM year WHERE e_year=$year"); 
		$year=mysql_fetch_array($yearlist);
		$acyear=$year['ay_id'];
		$acname=$year['y_name'];
}

$l_yearname=$year['s_year'];
$s_yearname=$l_yearname-1;

		$yearlist1=mysql_query("SELECT * FROM year WHERE s_year=$s_yearname AND e_year=$l_yearname"); 
		$year1=mysql_fetch_array($yearlist1);
		$acyear1=$year1['ay_id'];

/*$boardlist1=mysql_query("SELECT * FROM board"); 
			$board1=mysql_fetch_array($boardlist1);
		 	$bid=$board1['b_id'];
			*/
			 
if (isset($_POST['submit']))
{
	//header("Location:registration.php?msg=succ");
	//die();
	$admin_no=mysql_real_escape_string($_POST['admin_no']);
	$fname=mysql_real_escape_string($_POST['fname']);
	$lname=mysql_real_escape_string($_POST['lname']);
	$p_name=mysql_real_escape_string($_POST['p_name']);
	$m_name=mysql_real_escape_string($_POST['m_name']);
	
	$dob=mysql_real_escape_string($_POST['dob']);
	$gender=mysql_real_escape_string($_POST['gender']);
	
	$religion=mysql_real_escape_string($_POST['religion']);
	$email=mysql_real_escape_string($_POST['email']);
	$phone=mysql_real_escape_string($_POST['phone']);
	$phone1=mysql_real_escape_string($_POST['phone1']);
	$phone2=mysql_real_escape_string($_POST['phone2']);
	$phone3=mysql_real_escape_string($_POST['phone3']);
	$address1=mysql_real_escape_string($_POST['address1']);
	$village=mysql_real_escape_string($_POST['village']);
	$country=mysql_real_escape_string($_POST['country']);
	$state=mysql_real_escape_string($_POST['state']);
	$pincode=mysql_real_escape_string($_POST['pincode']);
	$lschool=mysql_real_escape_string($_POST['lschool']);
	
	$bid=mysql_real_escape_string($_POST['b_id']);
	$cid=mysql_real_escape_string($_POST['cid']);
	
	$pid=mysql_real_escape_string($_POST['p_id']);
	$ssid=mysql_real_escape_string($_POST['ss_id1']);
	
	
	$cid1=mysql_real_escape_string($_POST['cid1']);
	
	$pbid=mysql_real_escape_string($_POST['pbid']);
	$pmid=mysql_real_escape_string($_POST['pmid']);
	$ypid=mysql_real_escape_string($_POST['ypid']);
 
	
	
	if($pid){
    $cid=$cid1;
	 }
	 
	  $query = "SELECT * FROM class WHERE c_id ='$cid'"; 
  $result = mysql_query($query);
  $row = mysql_fetch_assoc($result);
   $section_name=$row['c_name'];
   //if (stripos($section_name, 'XI') !== false) {
    if($section_name=="XI STD" || $section_name=="XI"){
       $group_name=mysql_real_escape_string($_POST['group_id']);
       $ele_mark=$_POST['tamil1'].",".$_POST['tamil2'].",".$_POST['english1'].",".$_POST['english2'].",".$_POST['maths'].",".$_POST['science'].",".$_POST['social'].",".$_POST['total'].",".$_POST['percent'];
      $ele_prefer=$_POST['pre1'].",".$_POST['pre2'].",".$_POST['pre3'];
       $ele_pass=$_POST['appear_on1'].",".$_POST['appear_on2'].",".$_POST['appear_on3'].",".$_POST['appear_on4'].",".$_POST['appear_on5'].",".$_POST['appear_on6'].",".$_POST['appear_on7'];
        
   }else{
       $group_name="";
       $ele_mark="";
       $ele_prefer="";
       $ele_pass="";
   }
	 
	$todaydate=date("d/m/Y H:i:s");
	
	$adminlist1=mysql_query("SELECT * FROM admin_no_count WHERE id='2'"); 
								  $admincount1=mysql_fetch_array($adminlist1);	
								  $adminno1=$admincount1['count'];
								  $adminno2=$adminno1+1;
								 $admin_number1="PRE".str_pad($adminno1, 5, '0', STR_PAD_LEFT);
			//$photo=$admin_number1.".jpg";					 
	
	$newfilename = $admin_number1 . $file_ext;		
		 $sql="INSERT INTO pre_admission (pa_admission_no,firstname,lastname,dob,gender,reg,fathersname,email,address1,city_id,country,state,pin,phone_number,phone1,phone2,phone3,c_id,m_name,b_id,ay_id,p_id,ss_id,std_value,ele_mark,ele_group,ele_prefer,ele_pass,p_board,p_class,y_pass,lschool) VALUES
('$admin_number1','$fname','$lname','$dob','$gender','$religion','$p_name','$email','$address1','$village','$country','$state','$pincode','$phone','$phone1','$phone2','$phone3','$cid','$m_name','$bid','$acyear','$pid','$ssid','$section_name','$ele_mark','$group_name','$ele_prefer','$ele_pass','$pbid','$pmid','$ypid','$lschool')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=$id = mysql_insert_id();
    if($result){			
		$sql1=mysql_query("UPDATE admin_no_count SET count='$adminno2' WHERE id='2'");
        header("Location:registration-online.php?msg=succ");
    }
    exit;
}
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  
  <!-- DNS prefetch -->
  <link rel=dns-prefetch href="//fonts.googleapis.com">
  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>School/College Management</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->
  <link rel="stylesheet" href="sms/css/style.css"> <!-- Generic style (Boilerplate) -->
  <link rel="stylesheet" href="sms/css/960.fluid.css"> <!-- 960.gs Grid System -->
  <link rel="stylesheet" href="sms/css/main.css"> <!-- Complete Layout and main styles -->
  <link rel="stylesheet" href="sms/css/buttons.css"> <!-- Buttons, optional -->
  <link rel="stylesheet" href="sms/css/lists.css"> <!-- Lists, optional -->
  <link rel="stylesheet" href="sms/css/icons.css"> <!-- Icons, optional -->
  <link rel="stylesheet" href="sms/css/notifications.css"> <!-- Notifications, optional -->
  <link rel="stylesheet" href="sms/css/typography.css"> <!-- Typography -->
  <link rel="stylesheet" href="sms/css/forms.css"> <!-- Forms, optional -->
  <link rel="stylesheet" href="sms/css/tables.css"> <!-- Tables, optional -->
  <link rel="stylesheet" href="sms/css/charts.css"> <!-- Charts, optional -->
  <link rel="stylesheet" href="sms/css/jquery-ui-1.8.15.custom.css"> <!-- jQuery UI, optional -->
  <!-- end CSS-->
  
  <!-- Fonts 
  <link href="//fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">-->
  <!-- end Fonts-->
<link rel="stylesheet" href="sms/css/metallic.css" type="text/css">
  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="sms/js/libs/modernizr-2.0.6.min.js"></script>
  
    <link rel="stylesheet" href="sms/Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
  <link rel="stylesheet" href="sms/payroll/js/plugins/select2/select2.css" type="text/css" />
</head>
<body id="top" style=" background-image:url(../img/container/navigation/nav-bg1.png);">
  <!-- Begin of #container -->
  <div id="container">
  	<!-- Begin of #header -->
    <div id="header-surround"><header id="header">
    	
    	<!-- Place your logo here -->
		<center>
<img src="logo_big.png" alt="School/College Management"/>
</center>
		
    </header></div>    <!--! end of #header -->   
    <?php 	 
					$adminlist=mysql_query("SELECT * FROM admin_no_count WHERE id='2'"); 
								  $admincount=mysql_fetch_array($adminlist);								  
								  $adminno=$admincount['count'];								  
								 $admin_number="PRE".str_pad($adminno, 5, '0', STR_PAD_LEFT);
								  ?> 
    		<div class="container_12" style="width:950px; margin:0 auto;">			
			<div class="grid_12">
				<h1>Online Registration</h1>                
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully registered!!!</div>
            <?php }?>    
                <div class="block-border" id="normal_student">
					<div class="block-header">
						<h1>Online Registration</h1><span></span>
					</div>
					<form id="validate-form1" class="block-content form" name="register" action="" method="post" enctype="multipart/form-data">
						<div id="test"></div>
                        <div class="clear"></div>
                        <div class="_25">
							<p>
                                <label for="textfield">Pre Admin NO : <span class="error">*</span></label>
                                <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $admin_number;?>" readonly  />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">First Name: <span class="error">*</span></label>
                                <input id="textfield" name="fname" class="required" type="text" value="" placeholder="Enter your First name"/>
                                <input id="textfield" name="admin_no" class="required" type="hidden" value="<?php echo $admin_number;?>" readonly  />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Last Name:</label>
                                <input id="textfield" name="lname" type="text" value="" placeholder="Enter your last name" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father / Guardian Name: <span class="error">*</span></label>
                                <input id="textfield" name="p_name" class="required" type="text" value="" placeholder="Father / Guardian name"/>
                            </p>
						</div>
                        <div class="clear"></div>
                        <div class="_25">
							<p>
                                <label for="textfield">Mother's Name : </label>
                                <input id="textfield" name="m_name" type="text" value="" placeholder="Mother's name" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date Of Birth : <span class="error">*</span></label>
                                <input id="datepicker1" name="dob" readonly title="Select Date Of Birth" class="required" type="text" value="" placeholder="Date Of Birth" />
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
                                <label for="textfield">Religion : <span class="error">*</span></label>
                                <input id="textfield" name="religion" class="required" type="text" value=""  placeholder="Enter Your Religion"/>
                            </p>
						</div>
                        <div class="clear"></div>
                        <div class="_50">
							<p>
                                <label for="textfield">Email <span class="error">*</span>:</label>
                                <input id="textfield" name="email" class="required" type="text" value="" placeholder="Email Id"/>
                            </p>
						</div>
                        <div class="clear"></div>
                        <div class="_50">
							<p><label for="textarea">Address : <span class="error">*</span></label><textarea id="textarea" name="address1" class="required" rows="5" cols="40"></textarea></p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">City: <span class="error">*</span></label>
                                <input id="textfield" name="village" class="required" type="text" value="" placeholder="City Name"/>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">State : <span class="error">*</span></label>
                                <input id="textfield" name="state" class="required" type="text" value="Tamilnadu" placeholder="State" />
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Country : <span class="error">*</span></label>
                                <input id="textfield" name="country" class="required" type="text" value="India"  placeholder="Country"/>
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Pin Code : <span class="error">*</span></label>
                                <input id="textfield" name="pincode" class="required" type="text" value="" placeholder="Pincode" />
                            </p>
						</div>
                         <div class="clear"></div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father/Guardian Phone No: <span class="error">*</span></label>
                                <input id="textfield" name="phone" class="required" type="text" value="" placeholder="Phone No" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Additional Phone No 1 : </label>
                                <input id="textfield" name="phone1" type="text" value="" placeholder="Additional Phone No1"/>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Additional Phone No 2 :</label>
                                <input id="textfield" name="phone2" type="text" value="" placeholder="Additional Phone No2"/>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Additional Phone No 3 : </label>
                                <input id="textfield" name="phone3"  type="text" value="" placeholder="Additional Phone No3"/>
                            </p>
						</div>
                        <div class="clear"></div>
                        
                          <div class="_25">
							<p>
                                <label for="textfield">Previous Select Board: <span class="error">*</span></label>
                                <select name="pbid" class="required" id="pbid">
                                <option value="">Select Board</option>
                               	<option value="State Board">State Board</option>
                                <option value="CBSE Board">CBSE Board</option>
                                <option value="ICSE">ICSE</option>
                                <option value="-">Not Aplicable</option>
                               </select>
                            </p>
						</div>
						
						<div class="_25">
							<p>
                                <label for="textfield">Previous Studies Medium: <span class="error">*</span></label>
                                <select name="pmid" class="required" id="pmid">
                                <option value="">Select</option>                               
                                <option value="Tamil">Tamil</option>
                                <option value="English">English</option>
                                <option value="Telugu">Telugu</option>
                                 <option value="Others">Others</option>
                                 <option value="-">Not Aplicable</option>
                               </select>
                            </p>
						</div>
                        
                        <div class="_25">
							<p>
                                <label for="textfield">Previous Studies School: <span class="error">*</span></label>
                                <input id="lschool" name="lschool" class="required" type="text" value="" placeholder="Previous School"/>
                            </p>
						</div>
						
						
                        <div class="_25">
							<p>
                                <label for="textfield">Year of Passing: <span class="error">*</span></label>
                                <select name="ypid" class="required" id="ypid">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==date("Y")){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                           		  <option value="-">Not Aplicable</option>
                               </select>
                            </p>
						</div>
                        <div class="clear"></div>
                          <div class="_25">
							<p>
                                <label for="textfield">Select Board: <span class="error">*</span></label>
                                <select name="b_id" class="required" id="bid" onchange="showCategoryboard(this.value)">
                                <option value="">Select Board</option>
                                <?php 
							$qry=mysql_query("SELECT * FROM board");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ ?>
                				<option value="<?php echo $row['b_id']; ?>"><?php echo $row['b_name']; ?></option>
                  <?PHP } ?>
                  </select>
                            </p>
						</div>
                        
                        <div class="_25">
							<p>
                                <label for="textfield">Select Class: <span class="error">*</span></label>
                                <select onchange="standard(this.value)" name="cid" id="cid" class="required">
                                <option value="">Select Class</option>
                                <?php 
						/*	$qry=mysql_query("SELECT * FROM class where b_id='$bid' AND ay_id='$acyear'");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ */ ?>
                				<!--  <option value="<?php echo $row['c_id']; ?>"><?php echo $row['c_name']; ?></option>-->
                  <?PHP // } ?>
                  </select>
                            </p>
						</div>
						
						
                        <div id="class">    
                         </div>
                         <div id="eleven_mark" style="display: none;">
                         <div class="_100" >
                         <table class="table" >
                         <tr>
                         <th width="10%" ><center>S.No</center></th>
                      <th ><center>Subject</center></th>
                      <th width="20%"><center>Mark</center></th>
                       <th width="20%"><center>Subject Year Of Passing</center></th>
                      </tr>
                      
                       <tr>
                         <td><center>1</center></th>
                         <td><center>Tamil 1st Paper</center></th>
                        <td><center> <input type="text" name="tamil1" id="tamil1" class="txt required" placeholder="Tamil mark" max="100" ></center></td>
                        <td><select name="appear_on1" id="appear_on1">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==date("Y")){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                        </tr>
                        <tr>
                         <td><center>2</center></th>
                         <td><center>Tamil 2nd Paper</center></th>
                        <td><center> <input type="text" name="tamil2" id="tamil2" class="txt required" placeholder="Tamil mark" max="100" ></center></td>
                        <td><select name="appear_on2" id="appear_on2">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==date("Y")){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                        </tr>
                           <tr>
                           <td><center>3</center></th>
                          <td><center>English 1st Paper</center></td>
                           <td><center> <input type="text" name="english1" id="english1" class="txt required" placeholder="English mark" max="100"></center></td>
                             <td><select name="appear_on3" id="appear_on3">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==date("Y")){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                           </tr>
                           
                            <tr>
                             <tr>
                           <td><center>4</center></th>
                          <td><center>English 2nd Paper</center></td>
                           <td><center> <input type="text" name="english2" id="english2" class="txt required" placeholder="English mark" max="100"></center></td>
                             <td><select name="appear_on4" id="appear_on4">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==date("Y")){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                           </tr>
                           
                            <tr>
                            <td><center>5</center></th>
                          <td> <center>Mathematics</center> </td>
                           <td><center> <input type="text" name="maths" id="maths" class="txt required" placeholder="Mathematics mark" max="100"></center></td>
                             <td><select name="appear_on5" id="appear_on5">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==date("Y")){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                           </tr>
                           
                            <tr>
                            <td><center>6</center></th>
                          <td> <center>Science</center> </td>
                          <td><center> <input type="text" name="science" id="science" class="txt required" placeholder="Science mark" max="100"></center></td>
                            <td><select name="appear_on6" id="appear_on6">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==date("Y")){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                          </tr>
                          
                            <td><center>7</center></th>
                          <td><center> Social Science </center></td>
                           <td><center> <input  type="text"  name="social" id="social" class="txt required" placeholder=" Social Science mark" max="100"></center></td>
                             <td><select name="appear_on7" id="appear_on7">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==date("Y")){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                            </tr>
                           <tr>
                           <td></th>
                          <td><center> Total</center> </td>
                           <td><center> <input type="text" id="total" name="total" id="textfield" readonly></center></td>
                         </tr>
                         <tr>
                           <td></th>
                          <td><center> Percentage</center> </td>
                           <td><center> <input  type="text" id="percent" name="percent" id="textfield" readonly></center></td>
                         </tr>                       
  </table>                         
                          </div>
                          <div class="clear"></div>
                         <!--  <div class="_25">
							<p>
                                <label for="textfield">Select Group: <span class="error">*</span></label>
                                <select name="group_id"  id="group_id">
                                  <option value="">Select Group</option>
                                <option value="Computer Science">Computer Science</option>
                                  <option value="Biology">Biology</option>
                                    <option value="Commerce(Computer Science)">Commerce(Computer Science)</option>
                                      <option value="Commerce">Commerce</option>
                                        
                  </select>
                            </p>
						</div>--><h1>Select Group</h1>
						  <div class="_50">
                               <p>
                                <label for="select">1st Preference: <span class="error">*</span> </label>
                                 <select name="pre1" class="required"  id="pre1">
                                  <option value="">Select Group</option>
                                	<option value="Computer Science">Mathematics, Physics, Chemistry, Computer Science</option>
                                  	<option value="Biology">Mathematics, Physics, Chemistry, Biology</option>
                                    <option value="Commerce(Computer Science)">Commerce, Accountancy, Economics, Computer Science</option>
                                    <option value="Commerce">Commerce, Accountancy, Economics, Business Mathematics.</option>                                   </select>
                                </div>
                           <div class="_50">
                               <p>
                                <label for="select">2nd Preference: <span class="error">*</span>  </label>
                                 <select name="pre2" class="required" id="pre2">
                                  <option value="">Select Group</option>
                                  <option value="Computer Science">Mathematics, Physics, Chemistry, Computer Science</option>
                                  <option value="Biology">Mathematics, Physics, Chemistry, Biology</option>
                                  <option value="Commerce(Computer Science)">Commerce, Accountancy, Economics, Computer Science</option>
                                      <option value="Commerce">Commerce, Accountancy, Economics, Business Mathematics.</option>                                   </select>
                                </div>
                          <div class="_50">
                               <p>
                                <label for="select">3rd Preference: <span class="error">*</span>  </label>
                                 <select name="pre3" class="required"  id="pre3">
                                  <option value="">Select Group</option>
                                 <option value="Computer Science">Mathematics, Physics, Chemistry, Computer Science</option>
                                  <option value="Biology">Mathematics, Physics, Chemistry, Biology</option>
                                    <option value="Commerce(Computer Science)">Commerce, Accountancy, Economics, Computer Science</option>
                                      <option value="Commerce">Commerce, Accountancy, Economics, Business Mathematics.</option>                                   </select>
                                </div>
                            <!--    
                                <div class="_25">
							<p>
                                <label for="textfield">Appeared on : </label>
                                <input id="textfield" name="appear_on"  type="text" value="March 2015"/>
                            </p>
						</div> --> 
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
</div>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="sms/js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="sms/js/libs/jquery-1.6.2.min.js"><\/script>')</script>

  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="sms/js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
 <!-- <script defer src="sms/js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>  jQuery UI -->
  <script defer src="sms/js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="sms/js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="sms/js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="sms/js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
  <script defer src="sms/js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="sms/js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="sms/js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="sms/js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="sms/js/common.js"></script> <!-- Generic functions -->
  <script defer src="sms/js/script.js"></script> <!-- Generic scripts -->
  <script defer src="sms/js/zebra_datepicker.js"></script>
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		$("#sibling").change(function(){
        var thiss = $(this);
		//var stid = document.first.st_id.value;
        var value = thiss.val(); 
		$.get("sms/psibling.php",{value:value},function(data){
			$( "#test" ).html(data);
						$( "#datepicker" ).Zebra_DatePicker({
						format: 'd/m/Y',
						view: 'years'
						});	
						$( "#datepicker1" ).Zebra_DatePicker({
						format: 'd/m/Y',
						view: 'years'
						});	
						
        });
    });
	
			var validateform = $("#validate-form").validate();
			var validateform = $("#validate-form1").validate();
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		/*
		 * Datepicker
		 */
				
		
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y',
		view: 'years',
      	  onSelect: function(date) {
          	  
        		var dob=date;
          		var year=Number(dob.substr(6,4));
          		var month=Number(dob.substr(3,2))-1;
          		var day=Number(dob.substr(0,2));
          		 
          		var today=new Date();
          		var age=today.getFullYear()-year;
          		if(today.getMonth()<month || (today.getMonth()==month && today.getDate()<day)){age--;}

          		if(age<=2){
          		//alert("Your Child age is less than 3 years Which Below  our School Standard");

          		if(confirm('Your Child age is less than 3 years Which Below  our School Standard.. Do you continue?')){

          		}else{

               window.location.href='';     
               
          		}		
          		
          		}
          }
		 
    });	

		
	
			$(".txt").each(function () {
		
							$(this).keyup(function () {
								showtotal();
							});
						});
				
				
	});	
	
	function showtotal() {
        if (document.register.english1.value == null ||
document.register.tamil1.value == null || (document.register.maths.value == null) ||
(document.register.science.value == null || document.register.social.value == null)) {
            document.register.total.value = "";
        }
       else {
            var a = Number(document.register.english1.value);
            var a1= Number(document.register.english2.value);
            var c = Number(document.register.tamil1.value);
            var c1 = Number(document.register.tamil2.value);
            var e = Number(document.register.maths.value);
      var f = Number(document.register.science.value);
      var g = Number(document.register.social.value);
      var total= Number(a+c+e+f+g+a1+c1);
      var persent =((total/700)*100).toFixed(2)+'%';
      //alert(z);
            document.register.total.value = (total);
      document.register.percent.value = (persent);
        }


    }
	
	
$("#poor").change(function(){
	if(this.checked) {
			$('#poor_student').show();
		$('#normal_student').hide();
	}else{
		$('#poor_student').hide();
		$('#normal_student').show();				
	}
});	
            
			
	$("#poor").change(function(){
			if(this.checked) {
       			$('#poor_student').show();
				$('#normal_student').hide();
			}else{
				$('#poor_student').hide();
				$('#normal_student').show();				
			}
    	});	

          function standard(n)
          {
        	var std=$("#cid option[value="+n+"]").text()
	      $("#eleven_mark input").removeClass("required");
        	$("#eleven_mark select").removeClass("required");
        	$("#eleven_mark").hide();
        	if(std==="XI STD"|| std==="XI"){
        		$("#eleven_mark input").addClass("required");
        		$("#eleven_mark select").addClass("required");
        		$("#eleven_mark").show();
        
        	}
          }
          function standard1(n)
          {
              
        	var std=$("#cid1 option[value="+n+"]").text()
	      $("#eleven_mark1 input").removeClass("required");
        	$("#eleven_mark1 select").removeClass("required");
        	$("#eleven_mark1").hide();
        	if(std==="XI STD"|| std==="XI"){
        		$("#eleven_mark1 input").addClass("required");
        		$("#eleven_mark1 select").addClass("required");
        		$("#eleven_mark1").show();
        
        	}
          }
	
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
 <script type="text/javascript" src="sms/javascripts/jquery.easyui.min.js"></script> 
<script type="text/javascript">
    function showCategoryboard(str) {
    	
		if (str == "") {
            document.getElementById("cid").innerHTML = "";
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
                document.getElementById("cid").innerHTML = xmlhttp.responseText;
               
                
            }
        }
		xmlhttp.open("GET", "sms/preadmission-classlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }	
	function showCategoryboard1(str) {
        if (str == "") {
            document.getElementById("cid1").innerHTML = "";
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
                document.getElementById("cid1").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "sms/preadmission-classlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }	  
</script>  
<script type="text/javascript" src="sms/js/jquery-1.9.1.min.js"></script>
<script src="sms/js/jquery-migrate-1.2.1.js"></script>
</body>
</html>
<? ob_flush(); ?>