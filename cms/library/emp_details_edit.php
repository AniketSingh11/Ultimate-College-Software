 <?php
 include("header.php");
function is_valid_type($file) {
$valid_types = array("image/jpg","image/jpeg", "image/png", "image/bmp", "image/gif");
if (in_array($file['type'], $valid_types))
return 1;
return 0;
}
  if(isset($_POST["submit"]))
  {
	 $sid=$_GET['id'];
	$staff_id= mysql_real_escape_string($_POST["staffid"]);
	$fname= mysql_real_escape_string($_POST["fname"]);
	$lname= mysql_real_escape_string($_POST["lname"]);
	$pname= mysql_real_escape_string($_POST["fathername"]);
	$dob= mysql_real_escape_string($_POST["dob"]);
	$age= mysql_real_escape_string($_POST["age"]);
	$gender= mysql_real_escape_string($_POST["gender"]);
	$reg= mysql_real_escape_string($_POST["religion"]);
	$blood= mysql_real_escape_string($_POST["blood"]);
	$marriage= mysql_real_escape_string($_POST["marital"]);
	$doj= mysql_real_escape_string($_POST["doj"]);
	$s_type= mysql_real_escape_string($_POST["staff_type"]);
	$position= mysql_real_escape_string($_POST["designation"]);
	$job_type= mysql_real_escape_string($_POST["job_type"]);
	$qualf= mysql_real_escape_string($_POST["qualification"]);
	$address1= mysql_real_escape_string($_POST["address1"]);
	$address2= mysql_real_escape_string($_POST["address2"]);	
	$state= mysql_real_escape_string($_POST["state"]);
	$country= mysql_real_escape_string($_POST["country"]);
	$lline= mysql_real_escape_string($_POST["lline"]);
	$phone_no= mysql_real_escape_string($_POST["phone"]);
	$email= mysql_real_escape_string($_POST["email"]);
	$transport= mysql_real_escape_string($_POST["transport"]);
	
	$b_name= mysql_real_escape_string($_POST["bankname"]);
	$b_acc_no= mysql_real_escape_string($_POST["accountno"]);
	$pf_no= mysql_real_escape_string($_POST["pfno"]);
	$nominee= mysql_real_escape_string($_POST["nominee"]);
	$n_name= mysql_real_escape_string($_POST["nname"]);
	$n_phone_no= mysql_real_escape_string($_POST["nphone"]);
	$n_email= mysql_real_escape_string($_POST["nemail"]);
	$status= mysql_real_escape_string($_POST["status"]);
	$lastphoto= mysql_real_escape_string($_POST["lastphoto"]);
			  
$TARGET_PATH = "../img/Staff/";
$image = $_FILES['file'];
$TARGET_PATH .= $image['name'];

//echo '<pre>'; print_r($image); echo '</pre>';

$img=$image['error'];


if($img!=4)
{
	
if (!is_valid_type($image)) {
//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
header("Location: emp_details_edit.php?id=$sid&msg=err_img");
exit;
}


if (move_uploaded_file($image['tmp_name'], $TARGET_PATH)) {
	
	if($lastphoto && $lastphoto!="mstaff_small.png" && $lastphoto!="fstaff_small.png"){
	unlink($TARGET_PATH."/".$lastphoto);
	}
	
$query="update staff set staff_id='$staff_id',fname='$fname', lname='$lname', s_pname='$pname', dob='$dob', age='$s_age', gender='$gender', reg='$reg', blood='$blood', marriage='$marriage', doj='$doj', s_type='$s_type', position='$position', job_type='$job_type', qualf='$qualf', address1='$address1', address2='$address2', state='$state', country='$country', lline='$lline', phone_no='$phone_no', email='$email', transport='$transport', b_name='$b_name', b_acc_no='$b_acc_no', pf_no='$pf_no', nominee='$nominee', n_name='$n_name', n_phone_no='$phone_no', n_email='$email',photo='" . $image['name'] . "',status='$status' where st_id='$sid' ";
	$result=mysql_query($query);
	
	if($result)
	{
		header("location:emp_details_edit.php?id=$sid&msg=succ");
		
	}
	else
	{
		header("location:emp_details_edit.php?id=$sid&msg=err");		
	
    }
}
}
else
{
	if(!$lastphoto || $lastphoto=="mstaff_small.png" || $lastphoto=="fstaff_small.png"){
			if($gender=='M'){
				$photo="mstaff_small.png";
			}else{
				$photo="fstaff_small.png";
			}	
	}else{
		$photo=$lastphoto;
	}
			
			$query="update staff set staff_id='$staff_id',fname='$fname', lname='$lname', s_pname='$pname', dob='$dob', age='$age', gender='$gender', reg='$reg', blood='$blood', marriage='$marriage', doj='$doj', s_type='$s_type', position='$position', job_type='$job_type', qualf='$qualf', address1='$address1', address2='$address2', state='$state', country='$country', lline='$lline', phone_no='$phone_no', email='$email', transport='$transport', b_name='$b_name', b_acc_no='$b_acc_no', pf_no='$pf_no', nominee='$nominee', n_name='$n_name', n_phone_no='$n_phone_no', n_email='$n_email',photo='$photo',status='$status' where st_id='$sid' ";
	$result=mysql_query($query);
	
	if($result)
	{
		header("location:emp_details_edit.php?id=$sid&msg=succ");
		
	}
	else
	{
		header("location:emp_details_edit.php?id=$sid&msg=err");		
	
    }
}
  }
   ?>
  </head>
 <body>
 <div id="wrapper">
	   <?php 
	   include("includes/head_logo.php");
	   
	   include("includes/top_nav.php");
	   
	   include("sidebar.php");
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1> Employee Details Edit <a href="emp_details_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
    <?php if($_GET["msg"] == 'err_img') { ?>
    <div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong>Please upload this type of File Format only jpeg, jpg, png, gif
			</div>
<?php } ?>
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Edited 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Employee Details Edit
					 </h3>			
				 </div>  <!-- /.portlet-header -->	
                 <?php
				 $s_id=$_GET["id"];
$emp_query="select * from staff where st_id='$s_id'";
$emp_result=mysql_query($emp_query);
$emp_display=mysql_fetch_array($emp_result);
?>		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Profile Details :</p>       
<div class="col-sm-6">
				            	<div class="form-group">
									<label for="name">Employee ID</label>
									<input type="text" id="staffid" name="staffid" class="form-control" data-required="true"  value="<?php echo $emp_display["staff_id"] ; ?>">
								</div>
                                <div class="form-group">
									<label for="name">Last Name</label>
									<input type="text" id="lname" name="lname" class="form-control" data-required="true" value="<?php echo $emp_display["lname"] ; ?>">
								</div>
                                <div class="form-group">
									<label for="date-2">Date Of Birth</label>
									<div class="input-group date ui-datepicker1" style="width:75%">
		                                <input id="dob" name="dob" class="form-control" type="text" data-required="true" value="<?php echo $emp_display["dob"] ; ?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
                                 <div class="form-group">	
									<label for="validateSelect">Gender</label>
									<select name="gender" class="form-control" data-required="true">
										<option value="M" <?php if($emp_display["gender"]=='M'){ echo 'selected'; } ?>>Male</option>
										<option value="F" <?php if($emp_display["gender"]=='F'){ echo 'selected'; } ?>>Female</option>
									</select>
								</div>
                                <div class="form-group">
									<label for="name">Blood Group</label>
									<input type="text" id="blood" name="blood" class="form-control" value="<?php echo $emp_display["blood"] ; ?>">
								</div>
                                <div class="form-group">
									<label for="date-2">Date Of Joining</label>
									<div class="input-group date ui-datepicker1" style="width:75%">
		                                <input id="doj" name="doj" class="form-control" type="text" data-required="true" value="<?php echo $emp_display["doj"] ; ?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
                                <div class="form-group">
									<label for="name">Designation </label>
									<input type="text" id="designation" name="designation" class="form-control" data-required="true" value="<?php echo $emp_display["position"] ; ?>">
								</div>
                                <div class="form-group">
									<label for="name">Qualification </label>
									<input type="text" id="qualification" name="qualification" class="form-control" data-required="true" value="<?php echo $emp_display["qualf"] ; ?>">
								</div>
                                <div class="form-group">
								<label for="textarea-input">Residential Address</label>
								<textarea name="address2" id="textarea-input" cols="10" rows="3" class="form-control"> <?php echo $emp_display["address1"] ; ?></textarea>
								</div>
                                <div class="form-group">
									<label for="name">Country </label>
									<input type="text" id="country" name="country" class="form-control" data-required="true" value="<?php echo $emp_display["country"] ; ?>" >
								</div>
                                <div class="form-group">
									<label for="name">Land Line No </label>
									<input type="text" id="lline" name="lline" class="form-control" value="<?php echo $emp_display["lline"] ; ?>">
								</div>
                                
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">First Name</label>
									<input type="text" id="fname" name="fname" class="form-control" data-required="true" value="<?php echo $emp_display["fname"] ; ?>" >
								</div>
                                <div class="form-group">
									<label for="name">Father Name</label>
									<input type="text" id="fathername" name="fathername" class="form-control" data-required="true" value="<?php echo $emp_display["s_pname"] ; ?>">
								</div>
                                <!--<div class="form-group">
									<label for="name">Age</label>
									<input type="text" id="age" name="age" class="form-control" data-required="true">
								</div>-->
                                <div class="form-group">
									<label for="name">Religion</label>
									<input type="text" id="religion" name="religion" class="form-control" data-required="true" value="<?php echo $emp_display["reg"] ; ?>" >
								</div>
                                <div class="form-group">
                                 <?php 
							$marital1=array("Single","Married","Widow");
							?>	
									<label for="validateSelect">Marital Status</label>
									<select name="marital" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<?php
							   $maritals=$emp_display['marriage'];
				for ($cmonth = 0; $cmonth <= 2; $cmonth++) { 
				if($maritals==$marital1[$cmonth]){?>
                <option value="<?php echo $marital1[$cmonth];?>" selected="selected" ><?php echo $marital1[$cmonth];?></option>
            <?php }else { ?>
            <option value="<?php echo $marital1[$cmonth];?>" ><?php echo  $marital1[$cmonth]?></option>            
            <?php } }?>             
									</select>
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Staff Type</label>
									<select name="staff_type" class="form-control" data-required="true">
										<option value="Teaching" <?php if($emp_display["s_type"]=='Teaching'){ echo 'selected'; } ?>>Teaching </option>
										<option value="Non-Teaching" <?php if($emp_display["s_type"]=='Non-Teaching'){ echo 'selected'; } ?>>Non-Teaching</option>
									</select>
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Job Type</label>
									<select name="job_type" class="form-control" data-required="true">
										<option value="Permanent" <?php if($emp_display["job_type"]=='Permanent'){ echo 'selected'; } ?> >Permanent </option>
										<option value="Temporary" <?php if($emp_display["job_type"]=='Temporary'){ echo 'selected'; } ?> >Temporary </option>
									</select>
								</div>
                                <div class="form-group">
								<label for="textarea-input">Permanent Address</label>
								<textarea name="address1" id="textarea-input" cols="10" rows="3" class="form-control" data-required="true"><?php echo $emp_display["address1"]; ?></textarea>
								</div>
                                <div class="form-group">
									<label for="name">State </label>
									<input type="text" id="state" name="state" class="form-control" data-required="true" value="<?php echo $emp_display["state"]; ?>">
								</div>
                                <div class="form-group">
									<label for="name">Email ID </label>
									<input type="email" id="email" name="email" class="form-control" data-required="true" value="<?php echo $emp_display["email"]; ?>" >
								</div>
                                <div class="form-group">
									<label for="name">Phone No</label>
									<input type="text" id="phone" name="phone" class="form-control" data-required="true" value="<?php echo $emp_display["phone_no"]; ?>">
								</div>
                                <div class="form-group">	
                                <?php 
							$fesstypearray=array("Regural Bus","Sp.Bus","Onetime Sp.Bus");
							?>
									<label for="validateSelect">Transport</label>
									<select name="transport" class="form-control">
										<option value="">Select Transport</option>
										<?php
							   $busfeestype=$emp_display['busfeestype'];
				for ($cmonth = 0; $cmonth <= 2; $cmonth++) { 
				if($busfeestype==$fesstypearray[$cmonth]){?>
                <option value="<?php echo $fesstypearray[$cmonth];?>" selected="selected" ><?php echo $fesstypearray[$cmonth];?></option>
            <?php }else { ?>
            <option value="<?php echo $fesstypearray[$cmonth];?>" ><?php echo  $fesstypearray[$cmonth]?></option>            
            <?php } }?>		
									</select>
								</div>
</div>
  			 </div>  <!-- /.portlet-content -->
             <div class="portlet-content">
     <p class="title">Bank Details :</p> 
     <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Bank Name</label>
									<input type="text" id="bankname" name="bankname" class="form-control" data-required="true" value="<?php echo $emp_display["b_name"] ; ?>">
								</div>
                                <div class="form-group">
									<label for="name">PF No</label>
									<input type="text" id="pfno" name="pfno" class="form-control" data-required="true"  value="<?php echo $emp_display["pf_no"] ; ?>">
								</div>
                                <div class="form-group">
									<label for="name">Nominee Name</label>
									<input type="text" id="nname" name="nname" class="form-control" data-required="true" value="<?php echo $emp_display["n_name"] ; ?>">
								</div>
                                <div class="form-group">
									<label for="name">Nominee Email ID</label>
									<input type="text" id="nemail" name="nemail" class="form-control"  value="<?php echo $emp_display["n_email"] ; ?>">
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Status</label>
									<select name="status" class="form-control" data-required="true">
										<option value="0" <?php if($emp_display["status"]==0){ echo 'selected'; } ?>> Disable</option>
										<option value="1" <?php if($emp_display["status"]==1){ echo 'selected';}?>> Enable</option>
									</select>
								</div>
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">Account Number</label>
									<input type="text" id="accountno" name="accountno" class="form-control" data-required="true" value="<?php echo $emp_display["b_acc_no"] ; ?>">
								</div>
                                 <div class="form-group">	
                                 <?php 
							$nominee1=array("Parents","Wife","Relatives");
							?>
									<label for="validateSelect">Nominee</label>
									<select name="nominee" class="form-control" data-required="true">
										<?php
							   $busfeestype=$emp_display['nominee'];
				for ($cmonth = 0; $cmonth <= 2; $cmonth++) { 
				if($busfeestype==$nominee1[$cmonth]){?>
                <option value="<?php echo $nominee1[$cmonth];?>" selected="selected"><?php echo $nominee1[$cmonth]?></option>
            <?php }else { ?>
            <option value="<?php echo $nominee1[$cmonth];?>" ><?php echo  $nominee1[$cmonth]?></option>            
            <?php } }?>		
									</select>
								</div>
                                <div class="form-group">
									<label for="name">Nominee Phone No</label>
									<input type="text" id="nphone" name="nphone" class="form-control" data-required="true" value="<?php echo $emp_display["n_phone_no"] ; ?>">
								</div>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
							  <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                              <?php if($emp_display['photo']){ ?>
                              <img  src="../img/Staff/<?php echo $emp_display['photo']; ?>" width="95" height="120" style=" margin-bottom:30px;margin-right:30px; float:left; border:1px solid #ccc;" />
                              <?php } ?>
                              </div>
							  <div>
							    <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="file" /></span>
							    <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                                <?php if($emp_display['photo'] && $emp_display['photo']!="mstaff_small.png" && $emp_display['photo']!="fstaff_small.png"){
									 ?>
                                <a href="emp_details_delete.php?img_id=<?php echo $s_id;?>" title="delete" class="btn btn-default">Delete</a>
                                <?php } ?>
							  </div>
							</div>
                                
</div>
<div class="clear"></div>
                    <div class="col-sm-12">
                    <center>
<div class="form-group">
								<input type="hidden" name="lastphoto" value="<?php echo $emp_display['photo']; ?>"/>
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
                                </div>

     </div>
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 ?>
 <?php include("includes/script.php");?>

</body>
</html>

 <? ob_flush(); ?>