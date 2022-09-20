 <?php
 include("header.php");
function is_valid_type($file) {
$valid_types = array("image/jpg","image/jpeg", "image/png", "image/bmp", "image/gif");
if (in_array($file['type'], $valid_types))
return 1;
return 0;
}
 $sid=$_GET['id'];
  if(isset($_POST["submit"]))
  {
	 $sid=$_GET['id'];
	$staff_id= mysql_real_escape_string($_POST["staffid"]);
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
	
	
	$b_name= mysql_real_escape_string($_POST["bankname"]);
	$b_acc_no= mysql_real_escape_string($_POST["accountno"]);
	$pf_no= mysql_real_escape_string($_POST["pfno"]);
	$nominee= mysql_real_escape_string($_POST["nominee"]);
	$n_name= mysql_real_escape_string($_POST["nname"]);
	$n_phone_no= mysql_real_escape_string($_POST["nphone"]);
	$n_email= mysql_real_escape_string($_POST["nemail"]);
	$status= mysql_real_escape_string($_POST["status"]);
	$salarytype= mysql_real_escape_string($_POST["salarytype"]);
	$lastphoto= mysql_real_escape_string($_POST["lastphoto"]);
	$status= mysql_real_escape_string($_POST["status"]);
		$dor= mysql_real_escape_string($_POST["dor"]);
	$relivestatus= mysql_real_escape_string($_POST["relivestatus"]);
	$city=mysql_real_escape_string($_POST['city']);
	$expriences=mysql_real_escape_string($_POST['expriences']);
	$pincode=mysql_real_escape_string($_POST['pincode']);
	$uanno= mysql_real_escape_string($_POST["uanno"]);
			  
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
	
$query="update staff set staff_id='$staff_id',fname='$fname', lname='$lname', s_pname='$pname', dob='$dob',gender='$gender', reg='$reg', blood='$blood', marriage='$marriage', doj='$doj', s_type='$s_type',dor='$dor',relivestatus='$relivestatus', position='$position', expriences='$expriences',job_type='$job_type', qualf='$qualf', address1='$address1', address2='$address2', city='$city',state='$state', pincode='$pincode',country='$country', lline='$lline', phone_no='$phone_no', email='$email',  b_name='$b_name', b_acc_no='$b_acc_no', pf_no='$pf_no', nominee='$nominee', n_name='$n_name', n_phone_no='$phone_no', n_email='$email',photo='" . $image['name'] . "',status='$status',salarytype='$salarytype',uanno='$uanno' where st_id='$sid' ";
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
			
			$query="update staff set staff_id='$staff_id',fname='$fname', lname='$lname', s_pname='$pname', dob='$dob', gender='$gender', reg='$reg', blood='$blood', marriage='$marriage', doj='$doj', s_type='$s_type', position='$position', expriences='$expriences', job_type='$job_type', qualf='$qualf',dor='$dor',relivestatus='$relivestatus', address1='$address1', address2='$address2',  city='$city',state='$state', pincode='$pincode',country='$country', lline='$lline', phone_no='$phone_no', email='$email', b_name='$b_name', b_acc_no='$b_acc_no', pf_no='$pf_no', nominee='$nominee', n_name='$n_name', n_phone_no='$n_phone_no', n_email='$n_email',photo='$photo',status='$status',salarytype='$salarytype',uanno='$uanno' where st_id='$sid' ";
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
									<input type="text" id="staffid" name="staffid" class="form-control" data-required="true"  value="<?php echo $emp_display["staff_id"] ; ?>" readonly>
								</div>
                                <div class="form-group">
									<label for="name">Last Name</label>
									<input type="text" id="lname" name="lname" class="form-control" data-required="true" value="<?php echo $emp_display["lname"] ; ?>">
								</div>
                                <div class="form-group">
									<label for="date-2">Date Of Birth</label>
									<div id="dp-ex-2" class="input-group date ui-datepicker1" style="width:75%">
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
                               <?php $bloodlist=array("A+ve","A-ve","A1+ve","A1-ve","A2+ve","A2-ve","B+ve","B-ve","O+ve","O-ve","AB+ve","AB-ve","A1B+ve","A1B-ve");  ?>
                               
                     <div class="form-group">	
							<p>
                                <label for="name">Blood Group </label>
                                <!--<input id="textfield" name="blood" class="required" type="text" value="" />-->
                                <select  name='blood' id='blood' class="form-control" data-required="true">
                                    <option value="" selected="selected" >Select</option>
                                    <OPTION VALUE="A+ve" <?php if($emp_display["blood"]=='A+ve' || $emp_display["blood"]=='A+Ve') {  echo 'selected'; } ?>> A+ve </OPTION>
                                    <OPTION VALUE="A-ve" <?php if($emp_display["blood"]=='A-ve' || $emp_display["blood"]=='A-Ve') {  echo 'selected'; } ?>>A -ve </OPTION>
                                    <OPTION VALUE="A1+ve" <?php if($emp_display["blood"]=='A1+ve' || $emp_display["blood"]=='A1+Ve') {  echo 'selected'; } ?>>A1 +ve </OPTION>
                                    <OPTION VALUE="A1-ve" <?php if($emp_display["blood"]=='A1-ve' || $emp_display["blood"]=='A1-Ve') {  echo 'selected'; } ?>>A1 -ve </OPTION>
                                    <OPTION VALUE="A2+ve" <?php if($emp_display["blood"]=='A2+ve' || $emp_display["blood"]=='A2+Ve') {  echo 'selected'; } ?>>A2 +ve </OPTION>
                                    <OPTION VALUE="A2-ve" <?php if($emp_display["blood"]=='A2-ve' || $emp_display["blood"]=='A-Ve') {  echo 'selected'; } ?>>A2 -ve </OPTION>
                                    <OPTION VALUE="B+ve" <?php if($emp_display["blood"]=='B+ve' || $emp_display["blood"]=='B+Ve') {  echo 'selected'; } ?>>B +ve </OPTION>
                                    <OPTION VALUE="B-ve" <?php if($emp_display["blood"]=='B-ve' || $emp_display["blood"]=='B-Ve') {  echo 'selected'; } ?>>B -ve </OPTION>
                                    <OPTION VALUE="O+ve" <?php if($emp_display["blood"]=='O+ve' || $emp_display["blood"]=='O+Ve') {  echo 'selected'; } ?>>O +ve </OPTION>
                                    <OPTION VALUE="O-ve" <?php if($emp_display["blood"]=='O-ve' || $emp_display["blood"]=='O-Ve') {  echo 'selected'; } ?>>O -ve </OPTION>
                                    <OPTION VALUE="AB+ve" <?php if($emp_display["blood"]=='AB+ve' || $emp_display["blood"]=='AB+Ve') {  echo 'selected'; } ?>>AB +ve </OPTION>
                                    <OPTION VALUE="AB-ve" <?php if($emp_display["blood"]=='AB-ve' || $emp_display["blood"]=='AB-Ve') {  echo 'selected'; } ?>>AB -ve </OPTION>
                                    <OPTION VALUE="A1B+ve" <?php if($emp_display["blood"]=='A1B+ve' || $emp_display["blood"]=='A1B+Ve') {  echo 'selected'; } ?>>A1B +ve </OPTION>
                                    <OPTION VALUE="A1B-ve" <?php if($emp_display["blood"]=='A1B-ve' || $emp_display["blood"]=='A1B-Ve') {  echo 'selected'; } ?>>A1B -ve </OPTION>
                                </select>
                            </p>
						</div>
                        
                       
                        
                        
                                <div class="form-group">
									<label for="date-2">Date Of Joining</label>
									<div id="dp-ex-3" class="input-group date ui-datepicker1" style="width:75%">
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
                                    
                                     <div class="form-group">
                                <label for="name">Experiences</label>
                                <input type="text" id="expriences" name="expriences"  class="form-control" data-required="true" value="<?php echo $emp_display["expriences"] ; ?>"> 
                           
						</div>
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
                                 <?php $religionlist=array("Buddhist","Christian","Hindu","Jain","Muslim","Parsi","Sikh"); ?>
                                <div class="form-group">	
							<p>
                                <label for="name">Religion </label>
                                <!--<input id="textfield" name="blood" class="required" type="text" value="" />-->
                                <select  name='reg' id='reg' class="form-control" data-required="true">
                                    <option value="" selected="selected" >Select</option>
                                      <option value="Buddhist" <?php if($emp_display["reg"]=='Buddhist' || $emp_display["reg"]=='BUDDHIST') {  echo 'selected'; } ?>>Buddhist</option>
                                      <option value="Christian" <?php if($emp_display["reg"]=='Christian' || $emp_display["reg"]=='CHRISTIAN') {  echo 'selected'; } ?>>Christian</option>
                                      <option value="Hindu" <?php if($emp_display["reg"]=='Hindu' || $emp_display["reg"]=='HINDU') {  echo 'selected'; } ?>>Hindu</option>
                                      <option value="Jain" <?php if($emp_display["reg"]=='Jain' || $emp_display["reg"]=='JAIN') {  echo 'selected'; } ?>>Jain</option>
                                      <option value="Muslim" <?php if($emp_display["reg"]=='Muslim' || $emp_display["reg"]=='MUSLIM') {  echo 'selected'; } ?>>Muslim</option>
                                      <option value="Parsi" <?php if($emp_display["reg"]=='Parsi' || $emp_display["reg"]=='PARIS') {  echo 'selected'; } ?>>Parsi</option>
                                      <option value="Sikh" <?php if($emp_display["reg"]=='Sikh' || $emp_display["reg"]=='SIKH') {  echo 'selected'; } ?>>Sikh</option>
                                 </select>
                           
								 </p>
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
                                <label for="name">Town or village Name</label>
                                <input type="text" id="city" name="city"  class="form-control" data-required="true" value="<?php echo $emp_display["city"]; ?>"> 
                           
						</div>
                                <div class="form-group">
									<label for="name">State </label>
									<input type="text" id="state" name="state" class="form-control" data-required="true" value="<?php echo $emp_display["state"]; ?>">
								</div>
                                
                                  <div class="form-group">
                                <label for="name">Pincode</label>
                                <input type="text" id="pincode" name="pincode"  class="form-control" data-required="true" value="<?php echo $emp_display["pincode"]; ?>"> 
                           
						</div>
                                <div class="form-group">
									<label for="name">Email ID </label>
									<input type="text" id="email" name="email" class="form-control" data-required="true" value="<?php echo $emp_display["email"]; ?>" >
								</div>
                                <div class="form-group">
									<label for="name">Phone No</label>
									<input type="text" id="phone" name="phone" class="form-control" data-required="true" value="<?php echo $emp_display["phone_no"]; ?>">
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
									<label for="name">PAN No</label>
									<input type="text" id="uanno" name="uanno" class="form-control" data-required="true" value="<?php echo $emp_display["uanno"] ; ?>"">
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
                                <div class="form-group">	
									<label for="validateSelect">Salary Type</label>
									<select name="salarytype" class="form-control" data-required="true">
										<option value="0" <?php if($emp_display["salarytype"]==0){ echo 'selected'; } ?>> Bank</option>
										<option value="1" <?php if($emp_display["salarytype"]==1){ echo 'selected';}?>> In Hand</option>
									</select>
								</div>
								
								
								
					 <div class="form-group">
				<label for="validateSelect">Do You Relive? </label>	 
				
					 <select id="comboA" name="relivestatus"  onchange="getComboA(this.value)">
					 
  <option value="1" <?php if($emp_display["relivestatus"]==1){ echo 'selected'; }?>checked>Yes</option>
  <option value="0" <?php if($emp_display["relivestatus"]==0){ echo 'selected';}?>>No</option>
  
</select>

			
					 </div>
						
										
								<div id="dp-ex-4" class="input-group date ui-datepicker1  pick" style="width:75%">
		                                <input id="dor" name="dor" class="form-control" type="text" selected="selected" value="<?php echo $emp_display["dor"] ; ?>">
										
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										
		                            
								</div>
								
								
							<?php
							$s_id=$sid;
							$monthly_pay=0;
	
$loanlist=mysql_query("select l_id,l_pay,month,year,l_m_pay from staff_loan WHERE d_id=$s_id AND status='0'");
$loan=mysql_fetch_array($loanlist);

$l_id=$loan['l_id'];
$l_tpay=$loan['l_pay'];
$lmonthdate=$loan['month'];
$totalpay=0;

$loanpaylist=mysql_query("select amount from staff_loan_pay WHERE d_id=$s_id AND l_id='$l_id'");
while($loanpay1=mysql_fetch_array($loanpaylist))
{
	$totalpay +=$loanpay1['amount'];
}

 $loanbalance=$l_tpay-$totalpay;

/*echo $salary_date = array_search($sdate_month, array_keys($months)); 
echo $loan_apply_date = array_search($lmonthdate, array_keys($months)); */

$salary_date1=$sdate_year."-".$sdate_month;
$loan_apply_date1=$loan['year']."-".$loan['month'];

if($salary_date1 >= $loan_apply_date1){
	if($loanbalance>=$loan['l_m_pay']){
		$monthly_pay=$loan['l_m_pay'];
	}else{
		$monthly_pay=$loanbalance;
	}
$l_id=$loan['l_id'];
$l_pay=$loan['l_pay'];
}
	$test =$value+$s_id;	
	
/* 	$emp_que="select count(satt_id) from sattendance where month=$sdate_month and year=$sdate_year and d_id=$s_id";
$emp_res=mysql_query($emp_que);
$salarylistt=mysql_fetch_array($emp_res);
$gross_total=$fixed*$salarylistt[0]; */
	
									$advancetotal=0;
									$myarray = array();
										$emp1_result=mysql_query("select a_amount,a_id from staff_advance WHERE d_id=$s_id AND status=0");
										while($emp1_display=mysql_fetch_array($emp1_result))
										{
											$advancetotal +=$emp1_display["a_amount"];
											array_push($myarray,$emp1_display["a_id"]);		
										}
										//echo $advancetotal."sdfsdf".$loanbalance;
							
							?>	
								
								<!--<p><font color="red">Your Total Due amount is <?php echo $advancetotal+$loanbalance;?></font></p>-->
								
								
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
<script>
 
 function getComboA(sel) {
	 
	 if(sel=="1")
	 {
		 //$selected = 'selected = "selected"';
		  $('#dp-ex-4').show();
		 
	 }
	 else
	 {
		  $('#dp-ex-4').hide();
		  
	 }
	 //var selected = selectBox.options[selectBox.selectedIndex].sel.value;
    var value = sel.value;  
}
getComboA(<?php echo $emp_display["relivestatus"];?>);
</script>
</body>
</html>

 <? ob_flush(); ?>