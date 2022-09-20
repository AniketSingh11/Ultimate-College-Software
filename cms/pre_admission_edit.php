<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");
 include("checking_page/admission.php");
  $paid=$_GET['paid'];

 if (isset($_POST['submit']))
{
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
	
	
	
	
	
	$pbid=mysql_real_escape_string($_POST['pbid']);
	$pmid=mysql_real_escape_string($_POST['pmid']);
	$ypid=mysql_real_escape_string($_POST['ypid']);
	
	
	
		 
	$query = "SELECT * FROM class WHERE c_id ='$cid'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$section_name=$row['c_name'];
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
	
	
	
 $sql="UPDATE pre_admission SET firstname='$fname',lastname='$lname',dob='$dob',gender='$gender',reg='$religion',fathersname='$p_name',email='$email',address1='$address1',city_id='$village',country='$country',state='$state',pin='$pincode',phone_number='$phone',phone1='$phone1',phone2='$phone2',phone3='$phone3',c_id='$cid',m_name='$m_name',b_id='$bid',std_value='$section_name',ele_mark='$ele_mark',ele_group='$group_name',ele_prefer='$ele_prefer',ele_pass='$ele_pass',p_board='$pbid',p_class='$pmid',y_pass='$ypid',lschool='$lschool' WHERE pa_id='$paid'";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:pre_admission_edit.php?paid=$paid&msg=succ");
    }
    exit;
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
					$studentlist=mysql_query("SELECT * FROM pre_admission WHERE pa_id=$paid"); 
								  $row=mysql_fetch_array($studentlist);
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="pre_admission.php" title="Home">Pre Admission</a></li>
                <li class="no-hover">Pre Admission Student Edit</li>
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">			
			<div class="grid_12">
				<h1>Pre Admission Student Edit</h1>                
			<a href="pre_admission.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php }else if($msg=="eronfile"){?>			
            <div class="alert error"><span class="hide">x</span>Please Upload this type of file only (.png , .jpg , .Gif) AND also file size lessthen 1MB!!!</div>
            <?php } ?>            
				<div class="block-border">
					<div class="block-header">
						<h1>Pre Admission Student Add</h1><span></span>
					</div>
					<form id="validate-form" name="register" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_25">
							<p>
                                <label for="textfield">Pre Admin NO : <span class="error">*</span></label>
                                <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $row['pa_admission_no'];?>" readonly  />
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
                                <label for="textfield">Mother's Name : </label>
                                <input id="textfield" name="m_name" type="text" value="<?php echo $row['m_name'];?>" />
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
                                <label for="textfield">Religion : <span class="error">*</span></label>
                                <input id="textfield" name="religion" class="required" type="text" value="<?php echo $row['reg'];?>" />
                            </p>
						</div>
                        <div class="clear"></div>
                        <div class="_50">
							<p><label for="textarea">Address : <span class="error">*</span></label><textarea id="textarea"  style="height: 93px;" name="address1" class="required" rows="5" cols="40"><?php echo $row['address1'];?></textarea></p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">City: <span class="error">*</span></label>
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
                        <div class="_25">
							<p>
                                <label for="textfield">Email <span class="error">*</span>:</label>
                                <input id="textfield" name="email" class="required" type="text" value="<?php echo $row['email'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father / Guardian Phone No: <span class="error">*</span></label>
                                <input id="textfield" name="phone" class="required" type="text" value="<?php echo $row['phone_number'];?>" />
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
						
						
						 <div class="_25">
							<p>
                                <label for="textfield">Previous Select Board: <span class="error">*</span></label>
                                <select name="pbid" id="pbid">
                                <option value="">Select Board</option>
                               <option value="State Board" <?php if($row['p_board']=="State Board"){echo "selected"; }?>>State Board</option>
                                <option value="CBSE Board" <?php if($row['p_board']=="CBSE Board"){ echo "selected"; }?>>CBSE Board</option>
                                <option value="ICSE" <?php if($row['p_board']=="ICSE"){ echo "selected"; }?>>ICSE</option>
                                <option value="-" <?php if($row['p_board']=="-"){ echo "selected"; }?>>Not Aplicable</option>
                               </select>
                            </p>
						</div>
						<div class="_25">
							<p>
                                <label for="textfield">Previous Studies Medium: <span class="error">*</span></label>
                                <select name="pmid" id="pmid">
                                <option value="">Select</option>
                               
                                <option value="Tamil" <?php if($row['p_class']=="Tamil"){echo "selected"; }?>>Tamil</option>
                                <option value="English" <?php if($row['p_class']=="English"){echo "selected"; }?>>English</option>
                                <option value="Telugu" <?php if($row['p_class']=="Telugu"){echo "selected"; }?>>Telugu</option>
                                 <option value="Others" <?php if($row['p_class']=="Others"){echo "selected"; }?>>Others</option>
                                 <option value="-" <?php if($row['p_class']=="-"){echo "selected"; }?>>Not Aplicable</option>
                               </select>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Previous Studies School: <span class="error">*</span></label>
                                <input id="lschool" name="lschool" class="required" type="text" value="<?php echo $row['lschool'];?>" placeholder="Previous School"/>
                            </p>
						</div>
                        <div class="clear"></div>
                        <div class="_25">
							<p>
                                <label for="textfield">Year of Passing: <span class="error">*</span></label>
                                <select name="ypid" id="ypid">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==$row['y_pass']){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select>
                            </p>
						</div>
						<div class="_25">
							<p>
                                <label for="textfield">Select Board: <span class="error">*</span></label>
                                <select name="b_id" id="bid" onchange="showCategoryboard(this.value)">
                                
                                <?php 
							$qry1=mysql_query("SELECT * FROM board");
							$bid=$row['b_id'];
							$cid=$row['c_id'];
							
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  
			  while($row1=mysql_fetch_array($qry1))
        		{ 
				if($bid==$row1['b_id']){?>
                				<option value="<?php echo $row1['b_id']; ?>" selected><?php echo $row1['b_name']; ?></option>
                  <?PHP }else { ?>
                  		<!--  <option value="<?php echo $row1['b_id']; ?>"><?php echo $row1['b_name']; ?></option>-->
                  <?PHP }  }?>
                  
                  </select>
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                               <select name="cid" id="cid" onchange="standard(this.value)" class="required">
											<option value="<?php echo $row['c_id']; ?>"><?php echo $class['c_name'];?></option>											
								</select>
							</p>
						</div>
						<?php 
						$ele_mark=explode(",",$row['ele_mark']);
						$sel_group=$row['ele_group'];
						$ele_prefer=explode(",",$row['ele_prefer']);
						$ele_pass=explode(",",$row['ele_pass']);
						$std_value=$row['std_value'];
						?>
						  <div id="eleven_mark" <?php if($std_value=="XI STD"||$std_value=="XI"){}else{?>style="display: none;"<?php }?>>
                         <div class="_100" >
                         <table class="table"  >
                         <tr>
                         <th width="10%" ><center>S.No</center></th>
                      <th ><center>Subject</center></th>
                      <th width="10%"><center>Mark</center></th>
                      <th width="20%"><center>Subject Year Of Passing</center></th>
                      </tr>
                         <tr>
                         <td><center>1</center></th>
                         <td><center>Tamil 1st Paper</center></th>
                        <td><center> <input type="text" name="tamil1" class="txt" value="<?=$ele_mark[0]?>" id="textfield" max="100" ></center></td>
                         <td><select name="appear_on1" id="appear_on1">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==$ele_pass[0]){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                        </tr>
                         <tr>
                         <td><center>2</center></th>
                         <td><center>Tamil 2nd Paper</center></th>
                        <td><center> <input type="text" name="tamil2" class="txt" value="<?=$ele_mark[1]?>" id="textfield" max="100" ></center></td>
                         <td><select name="appear_on2" id="appear_on2">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==$ele_pass[0]){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                        </tr>
                           <tr>
                           <td><center>3</center></th>
                          <td><center>English 1st Paper</center></td>
                           <td><center> <input type="text" name="english1" class="txt" value="<?=$ele_mark[2]?>" id="textfield" max="100"></center></td>
                            <td><select name="appear_on3" id="appear_on3">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==$ele_pass[1]){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                           </tr>
                            <tr>
                           <td><center>4</center></th>
                          <td><center>English 2nd Paper</center></td>
                           <td><center> <input type="text" name="english2" class="txt" value="<?=$ele_mark[3]?>" id="textfield" max="100"></center></td>
                            <td><select name="appear_on4" id="appear_on3">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==$ele_pass[1]){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                           </tr>
                            <tr>
                            <td><center>3</center></th>
                          <td><center> Maths </center></td>
                           <td><center> <input type="text" name="maths" class="txt" value="<?=$ele_mark[4]?>" id="textfield" max="100"></center></td>
                            <td><select name="appear_on5" id="appear_on5">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==$ele_pass[2]){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                           </tr>
                            <tr>
                            <td><center>4</center></th>
                          <td><center> Science</center> </td>
                          <td><center> <input type="text" name="science" class="txt" value="<?=$ele_mark[5]?>" id="textfield" max="100"></center></td>
                           <td><select name="appear_on6" id="appear_on6">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==$ele_pass[3]){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                          </tr>
                          
                            <tr>
                            <td><center>5</center></th>
                          <td><center> Social Science </td>
                           <td><center> <input  type="text"  name="social" class="txt" value="<?=$ele_mark[6]?>" id="textfield" max="100"></center></td>
                            <td><select name="appear_on7" id="appear_on7">
                                <option value="">Select</option>
                             <?php 
                             for($i=date("Y")-4;$i<=date("Y");$i++) {?>
                                 
                                  <option value="<?=$i?>" <?php if($i==$ele_pass[4]){?>selected="selected"<?php }?>><?=$i?></option>
                           <?php   }     ?>
                               </select></td>
                            </tr>
                           <tr>
                           <td></th>
                          <td><center> Total </center></td>
                           <td><center> <input  type="text" readonly name="total"  value="<?=$ele_mark[7]?>" id="textfield"></center></td>
                         </tr> 
                        <tr>
                           <td></th>
                          <td><center> Percentage </center></td>
                           <td><center> <input  type="text" id="percent" name="percent"  readonly value="<?=$ele_mark[8]?>"></center></td>
                         </tr> 
                         </table>
                         
                          </div>
                    <!--       <div class="_25">
							<p>
                                <label for="textfield">Select Group: <span class="error">*</span></label>
                                <select name="group_id"  id="group_id">
                                 
                                <option value="Computer Science" <?php if($sel_group=="Computer Science"){ echo "selected";}?>>Computer Science</option>
                                  <option value="Biology" <?php if($sel_group=="Biology"){ echo "selected";}?>>Biology</option>
                                    <option value="Commerce(Computer Science)" <?php if($sel_group=="Commerce(Computer Science)"){ echo "selected";}?>>Commerce(Computer Science)</option>
                                      <option value="Commerce" <?php if($sel_group=="Commerce"){ echo "selected";}?>>Commerce</option>
                                        
                  </select>
                            </p>
						</div> -->
						
						 <div class="clear"></div>
						<h1>Select Group</h1>
						  <div class="_50">
                               <p>
                                <label for="select">1st Preference: <span class="error">*</span> </label>
                                 <select name="pre1"  id="pre1">
                                  <option value="">Select Group</option>
                                <option value="Computer Science" <?php if($ele_prefer[0]=="Computer Science"){echo "selected";}?>>Mathematics, Physics, Chemistry, Computer Science</option>
                                  <option value="Biology" <?php if($ele_prefer[0]=="Biology"){echo "selected";}?>>Mathematics, Physics, Chemistry, Biology</option>
                                    <option value="Commerce(Computer Science)" <?php if($ele_prefer[0]=="Commerce(Computer Science)"){echo "selected";}?>>Commerce, Accountancy, Economics, Computer Science</option>
                                      <option value="Commerce" <?php if($ele_prefer[0]=="Commerce"){echo "selected";}?>>Commerce, Accountancy, Economics, Business Mathematics.</option>                              
                                   </select>
                                </div>
                           <div class="_50"><br>
                               <p>
                                <label for="select">2nd Preference: <span class="error">*</span>  </label>
                                 <select name="pre2"  id="pre2">
                                  <option value="">Select Group</option>
                                  <option value="Computer Science" <?php if($ele_prefer[1]=="Computer Science"){echo "selected";}?>>Mathematics, Physics, Chemistry, Computer Science</option>
                                  <option value="Biology" <?php if($ele_prefer[1]=="Biology"){echo "selected";}?>>Mathematics, Physics, Chemistry, Biology</option>
                                    <option value="Commerce(Computer Science)" <?php if($ele_prefer[1]=="Commerce(Computer Science)"){echo "selected";}?>>Commerce, Accountancy, Economics, Computer Science</option>
                                      <option value="Commerce" <?php if($ele_prefer[1]=="Commerce"){echo "selected";}?>>Commerce, Accountancy, Economics, Business Mathematics.</option>                             
                                   </select>
                                </div>
                          <div class="_50">
                               <p>
                                <label for="select">3rd Preference: <span class="error">*</span>  </label>
                                 <select name="pre3"  id="pre3">
                                  <option value="">Select Group</option>
                                 <option value="Computer Science" <?php if($ele_prefer[2]=="Computer Science"){echo "selected";}?>>Mathematics, Physics, Chemistry, Computer Science</option>
                                  <option value="Biology" <?php if($ele_prefer[2]=="Biology"){echo "selected";}?>>Mathematics, Physics, Chemistry, Biology</option>
                                    <option value="Commerce(Computer Science)" <?php if($ele_prefer[2]=="Commerce(Computer Science)"){echo "selected";}?>>Commerce, Accountancy, Economics, Computer Science</option>
                                      <option value="Commerce" <?php if($ele_prefer[2]=="Commerce"){echo "selected";}?>>Commerce, Accountancy, Economics, Business Mathematics.</option>                              
                                   </select>
                                </div>
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
		/*
		 * Datepicker
		 */
				
		$( "#datepicker1" ).Zebra_DatePicker({
			 format: 'd/m/Y',
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
        if ((document.register.english1.value == null) ||
(document.register.tamil1.value == null) || (document.register.maths.value == null) ||
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
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
 <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
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
        xmlhttp.open("GET", "classlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }


    function standard(n)
    {
  	var std=$("#cid option[value="+n+"]").text()
    $("#eleven_mark input").removeClass("required");
  	$("#eleven_mark select").removeClass("required");
  	$("#eleven_mark").hide();
  	if(std==="XI STD"){
  		$("#eleven_mark input").addClass("required");
  		$("#eleven_mark select").addClass("required");
  		$("#eleven_mark").show();
  
  	}
    }
    	  
</script>    
</body>
</html>
<? ob_flush(); ?>