
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
	$driver_id= mysql_real_escape_string($_POST["driverid"]);
	$fname= mysql_real_escape_string($_POST["fname"]);
	$lname= mysql_real_escape_string($_POST["lname"]);
	$pname= mysql_real_escape_string($_POST["fathername"]);
	$dob= mysql_real_escape_string($_POST["dob"]);
	$date_split1= explode('/', $dob);		 
		 $date_month=$date_split1[1];
		 $date_day=$date_split1[0];
		 $date_year=$date_split1[2];
	
	$age= mysql_real_escape_string($_POST["age"]);
	$gender= mysql_real_escape_string($_POST["gender"]);
	$reg= mysql_real_escape_string($_POST["reg"]);
	$blood= mysql_real_escape_string($_POST["blood"]);
	$marriage= mysql_real_escape_string($_POST["marital"]);
	$doj= mysql_real_escape_string($_POST["doj"]);
	$d_type= mysql_real_escape_string($_POST["driver_type"]);
	$position= mysql_real_escape_string($_POST["designation"]);
	$job_type= mysql_real_escape_string($_POST["job_type"]);
	$qualf= mysql_real_escape_string($_POST["qualification"]);
	$address1= mysql_real_escape_string($_POST["address"]);
	$address2= mysql_real_escape_string($_POST["address2"]);	
	$state= mysql_real_escape_string($_POST["state"]);
	$country= mysql_real_escape_string($_POST["country"]);
	$lline= mysql_real_escape_string($_POST["lline"]);
	$phone_no= mysql_real_escape_string($_POST["phone"]);
	$email= mysql_real_escape_string($_POST["email"]);
	$transport= mysql_real_escape_string($_POST["transport"]);
	$uanno= mysql_real_escape_string($_POST["uanno"]);
	
	$b_name= mysql_real_escape_string($_POST["bankname"]);
	$b_acc_no= mysql_real_escape_string($_POST["accountno"]);
	$pf_no= mysql_real_escape_string($_POST["pfno"]);
	$nominee= mysql_real_escape_string($_POST["nominee"]);
	$n_name= mysql_real_escape_string($_POST["nname"]);
	$n_phone_no= mysql_real_escape_string($_POST["nphone"]);
	$salarytype= mysql_real_escape_string($_POST["salarytype"]);
	$n_email= mysql_real_escape_string($_POST["nemail"]);
	$city=mysql_real_escape_string($_POST['city']);
	$expriences=mysql_real_escape_string($_POST['expriences']);
	$pincode=mysql_real_escape_string($_POST['pincode']);
	$s_type=mysql_real_escape_string($_POST['s_type']);
		
	$chk_val=mysql_real_escape_string($_POST['chk_val']);
	if($chk_val=="0")
	{
		$allowance_status="0";
		$allowance_amount="";
	}
	else
	{
		$allowance_status="1";
		$allowance_amount=$_POST['allowance_amt'];
	}
	
			  
$TARGET_PATH = "../img/driver/";
$image = $_FILES['file'];
$TARGET_PATH .= $image['name'];

echo '<pre>'; print_r($image); echo '</pre>';
//die();
$img=$image['error'];

$adminlist1=mysql_query("SELECT * FROM driver_no_count WHERE id='1'"); 
								  $admincount1=mysql_fetch_array($adminlist1);	
								  $adminno1=$admincount1['count'];
								  $adminno2=$adminno1+1;
								 $admin_number1="SPMSD".str_pad($adminno1, 3, '0', STR_PAD_LEFT);
if($img!=4)
{
	
if (!is_valid_type($image)) {
//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
header("Location: driver_add.php?msg=err_img");
exit;
}
if (move_uploaded_file($image['tmp_name'], $TARGET_PATH)) {
 //$query="insert into driver(driver_id,fname,lname,d_pname,dob,age,gender,reg,blood,marriage,doj,d_type,position,job_type,qualf,address,address2,state,country,lline,phone_no,email,b_name,b_acc_no,pf_no,nominee,n_name,n_phone_no,n_email,photo,status,salarytype)values('$admin_number1','$fname','$lname','$pname','$dob','$age','$gender','$reg','$blood','$marriage','$doj','$d_type','$position','$job_type','$qualf','$address1','$address2','$state','$country','$lline','$phone_no','$email','$b_name','$b_acc_no','$pf_no','$nominee','$n_name','$n_phone_no','$n_email','" . $image['name'] . "','1','$salarytype')";
 
  $query="insert into driver(driver_id,fname,lname,d_pname,dob,day,month,year,gender,reg,blood,marriage,doj,d_type,position,expriences,job_type,qualf,address,address2,city,state,pincode,country,lline,phone_no,email,b_name,b_acc_no,pf_no,nominee,n_name,n_phone_no,n_email,photo,status,salarytype,s_type,allowance_status,allowance_amount,uanno)values('$admin_number1','$fname','$lname','$pname','$dob','$date_day','$date_month','$date_year','$gender','$reg','$blood','$marriage','$doj','$d_type','$position','$expriences','$job_type','$qualf','$address1','$address2','$city','$state','$pincode','$country','$lline','$phone_no','$email','$b_name','$b_acc_no','$pf_no','$nominee','$n_name','$n_phone_no','$n_email','" . $image['name'] . "','1','$salarytype','$s_type','$allowance_status','$allowance_amount','$uanno')";

//echo "insert into driver(driver_id,fname,lname,d_pname,dob,day,month,year,gender,reg,blood,marriage,doj,d_type,position,expriences,job_type,qualf,address,city,state,pincode,country,lline,phone_no,email,b_name,b_acc_no,pf_no,nominee,n_name,n_phone_no,n_email,photo,status,salarytype)values('$admin_number1','$fname','$lname','$pname','$dob','$date_day','$date_month','$date_year','$gender','$reg','$blood','$marriage','$doj','$d_type','$position','$expriences','$job_type','$qualf','$address','$city','$state','$pincode','$country','$lline','$phone_no','$email','$b_name','$b_acc_no','$pf_no','$nominee','$n_name','$n_phone_no','$n_email','" . $image['name'] . "','1','$salarytype')"; die;
// die();
	$result=mysql_query($query) or die("Could not insert data into DB: " . mysql_error());	
	if($result)
	{
		$sql1=mysql_query("UPDATE driver_no_count SET count='$adminno2' WHERE id='1'");
		header("location:driver_add.php?msg=succ");		
	}
	else
	{
		header("location:driver_add.php?msg=err");
    }
}
}
else
{
	if($gender=='M'){
				$photo="driver_male.png";
			}else{
				$photo="driver_female.png";
			}	
  $query="insert into driver(driver_id,fname,lname,d_pname,dob,day,month,year,gender,reg,blood,marriage,doj,d_type,position,expriences,job_type,qualf,address,address2,city,state,pincode,country,lline,phone_no,email,b_name,b_acc_no,pf_no,nominee,n_name,n_phone_no,n_email,photo,status,salarytype,s_type,allowance_status,allowance_amount,uanno)values('$admin_number1','$fname','$lname','$pname','$dob','$date_day','$date_month','$date_year','$gender','$reg','$blood','$marriage','$doj','$d_type','$position','$expriences','$job_type','$qualf','$address1','$address2','$city','$state','$pincode','$country','$lline','$phone_no','$email','$b_name','$b_acc_no','$pf_no','$nominee','$n_name','$n_phone_no','$n_email','" . $image['name'] . "','1','$salarytype','$s_type','$allowance_status','$allowance_amount','$uanno')";
 //die();
	$result=mysql_query($query) or die("Could not insert data into DB: " . mysql_error());
	
	if($result)
	{
		$sql1=mysql_query("UPDATE driver_no_count SET count='$adminno2' WHERE id='1'");
		header("location:driver_add.php?msg=succ");
		
	}
	else
	{
		header("location:driver_add.php?msg=err");		
	
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
			 <h1> Driver Details Add <a href="driver_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
				<strong>done!</strong> Your Record Successfully Inserted 
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
						Driver Details Add
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Profile Details :</p>       
<?php
$adminlist=mysql_query("SELECT * FROM driver_no_count WHERE id='1'"); 
								  $admincount=mysql_fetch_array($adminlist);	  
								  
								  $adminno=$admincount['count'];
								  
								 $admin_number="SPMSD".str_pad($adminno, 3, '0', STR_PAD_LEFT);

?>		
<div class="col-sm-6">
				            	<div class="form-group">
									<label for="name">Driver ID</label>
									<input type="text" id="driverid" name="driverid" class="form-control" data-required="true"  value="<?php echo $admin_number;?>">
								</div>
                                <div class="form-group">
									<label for="name">Last Name</label>
									<input type="text" id="lname" name="lname" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="date-2">Date Of Birth</label>
									<div id="dp-ex-2" class="input-group date ui-datepicker1" style="width:75%">
		                                <input id="dob" name="dob" class="form-control" type="text" data-required="true">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
                                 <div class="form-group">	
									<label for="validateSelect">Gender</label>
									<select name="gender" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="M">Male</option>
										<option value="F">Female</option>
									</select>
								</div>
                                
                                 <div class="form-group">	
							<p>
                                <label for="name">Blood Group </label>
                                <!--<input id="textfield" name="blood" class="required" type="text" value="" />-->
                                <select  name='blood' id='blood' class="form-control" data-required="true">
                                    <option value="" selected="selected" >Select</option>
                                    <OPTION VALUE="A+ve">A +ve </OPTION>
                                    <OPTION VALUE="A-ve">A -ve </OPTION>
                                    <OPTION VALUE="A1+ve">A1 +ve </OPTION>
                                    <OPTION VALUE="A1-ve">A1 -ve </OPTION>
                                    <OPTION VALUE="A2+ve">A2 +ve </OPTION>
                                    <OPTION VALUE="A2-ve">A2 -ve </OPTION>
                                    <OPTION VALUE="B+ve">B +ve </OPTION>
                                    <OPTION VALUE="B-ve">B -ve </OPTION>
                                    <OPTION VALUE="O+ve">O +ve </OPTION>
                                    <OPTION VALUE="O-ve">O -ve </OPTION>
                                    <OPTION VALUE="AB+ve">AB +ve </OPTION>
                                    <OPTION VALUE="AB-ve">AB -ve </OPTION>
                                    <OPTION VALUE="A1B+ve">A1B +ve </OPTION>
                                    <OPTION VALUE="A1B-ve">A1B -ve </OPTION>
                                </select>
                            </p>
						</div>
                               
                                <div class="form-group">
									<label for="date-2">Date Of Joining</label>
									<div id="dp-ex-3" class="input-group date ui-datepicker1" style="width:75%">
		                                <input id="doj" name="doj" class="form-control" type="text" data-required="true">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
                                <div class="form-group">
									<label for="name">Designation </label>
									<input type="text" id="designation" name="designation" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Qualification </label>
									<input type="text" id="qualification" name="qualification" class="form-control" data-required="true">
								</div>
                                 <div class="form-group">
                                <label for="select">Experiences</label>
                                <input type="text" id="expriences" name="expriences"  class="form-control" data-required="true"> 
                           
						</div>
                               <div class="form-group">
								<label for="textarea-input">Residential Address</label>
								<textarea name="address2" id="textarea-input" cols="10" rows="3" class="form-control"></textarea>
								</div>
                                
                                <div class="form-group">
									<label for="name">Country </label>
									<input type="text" id="country" name="country" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Land Line No </label>
									<input type="text" id="lline" name="lline" class="form-control">
								</div>
								
								
									<div class="checkbox">
								<label>Do you want daily allowance :</label>
								<input type="checkbox" name="allowance_chk" id="allowance_chk" class="form-control" >
								<input type="hidden" name="chk_val" id="chk_val" value="0" />									
								</div>
						
						<div class="form-group"  style="display:none;" id="allowance_amt_div">
								<label for="name">Enter daily allowance amount :</label>
								<input type="text" name="allowance_amt" id="allowance_amt" value=""/>
						</div>	
                                
                                
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">First Name</label>
									<input type="text" id="fname" name="fname" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Father Name</label>
									<input type="text" id="fathername" name="fathername" class="form-control" data-required="true">
								</div>
                                <!--<div class="form-group">
									<label for="name">Age</label>
									<input type="text" id="age" name="age" class="form-control" data-required="true">
								</div>-->
                                <div class="form-group">
							<p>
                                <label for="name">Religion </label>
                                <!--<input id="textfield" name="blood" class="required" type="text" value="" />-->
                                <select  name='reg' id='reg' class="form-control" data-required="true">
                                    <option value="" selected="selected" >Select</option>
                                     
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
                                <div class="form-group">	
									<label for="validateSelect">Marital Status</label>
									<select name="marital" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Single">Single</option>
										<option value="Married">Married</option>
                                        <option value="Widow">Widow</option>
									</select>
								</div>
                                <div class="form-group">	
									<label for="validateSelect">driver Type</label>
									<select name="driver_type" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Driver">Driver</option>
										<option value="Non-Driver">Non-Driver</option>
									</select>
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Job Type</label>
									<select name="job_type" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Permanent">Permanent</option>
										<option value="Temporary">Temporary</option>
									</select>
								</div>
								<div class="form-group">	
									<label for="validateSelect">Salary Type</label>
									<select name="s_type" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="0">Month Salary</option>
										<option value="1">Day Salary</option>
									</select>
								</div>
                                <div class="form-group">
								<label for="textarea-input">Permanent Address</label>
								<textarea name="address" id="textarea-input" cols="10" rows="3" class="form-control" data-required="true"></textarea>
								</div>
                                 <div class="form-group">
                                <label for="select">Town or village Name</label>
                                <input type="text" id="city" name="city"  class="form-control" data-required="true"> 
                           
						</div>
                                <div class="form-group">
									<label for="name">State </label>
									<input type="text" id="state" name="state" class="form-control" data-required="true">
								</div>
                                 <div class="form-group">
                                <label for="select">Pincode</label>
                                <input type="text" id="pincode" name="pincode"  class="form-control" data-required="true"> 
                           
						</div>
                                <div class="form-group">
									<label for="name">Email ID </label>
									<input type="email" id="email" name="email" class="form-control">
								</div>
                                <div class="form-group">
									<label for="name">Phone No</label>
									<input type="text" id="phone" name="phone" class="form-control" data-required="true">
								</div>
                                <!--<div class="form-group">	
									<label for="validateSelect">Transport</label>
									<select name="transport" class="form-control">
										<option value="">Select Transport</option>
										<option value="0">Regular Bus</option>
                                            <option value="1">Sp.Bus</option>
                                            <option value="2">Onetime Sp.Bus</option>	
									</select>
								</div>-->
</div>
  			 </div>  <!-- /.portlet-content -->
             <div class="portlet-content">
     <p class="title">Bank Details :</p> 
     <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Bank Name</label>
									<input type="text" id="bankname" name="bankname" class="form-control" >
								</div>
                                <div class="form-group">
									<label for="name">PF No</label>
									<input type="text" id="pfno" name="pfno" class="form-control" >
								</div>
								 <div class="form-group">
									<label for="name">PAN No</label>
									<input type="text" id="uanno" name="uanno" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Nominee Name</label>
									<input type="text" id="nname" name="nname" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Nominee Email ID</label>
									<input type="text" id="nemail" name="nemail" class="form-control">
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Salary Type</label>
									<select name="salarytype" class="form-control" data-required="true">
										<option value="0"> Bank</option>
										<option value="1"> In Hand</option>
									</select>
								</div>
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">Account Number</label>
									<input type="text" id="accountno" name="accountno" class="form-control" >
								</div>
                                 <div class="form-group">	
									<label for="validateSelect">Nominee</label>
									<select name="nominee" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Parents">Parents</option>
										<option value="Wife">Wife</option>
                                        <option value="Relatives">Relatives</option>
									</select>
								</div>
                                <div class="form-group">
									<label for="name">Nominee Phone No</label>
									<input type="text" id="nphone" name="nphone" class="form-control">
								</div>
                                <div class="fileupload fileupload-new" data-provides="fileupload">
							  <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
							  <div>
							    <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="file" /></span>
							    <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
							  </div>
							</div>
                                
</div>
<div class="clear"></div>
                    <div class="col-sm-12">
                    <center>
<div class="form-group">
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
 
 <script> 
  $().ready(function() {
	 $(".iCheck-helper").click(function(){
    if($("#allowance_chk").is(':checked')){ 
	$("#allowance_amt_div").show();
	  $("#chk_val").val('1');
	}
	else{
		 $("#allowance_amt_div").hide();
		  $("#chk_val").val('0');
	}
});
 });
 </script>
</body>
</html>

 <? ob_flush(); ?>