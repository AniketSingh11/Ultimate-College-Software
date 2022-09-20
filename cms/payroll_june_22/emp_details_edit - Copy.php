 <?php
 
 include("header.php");
 ?>
  </head>
 <body>
 <div id="wrapper">
	   <?php 
	   include("includes/head_logo.php");
	   
	   include("includes/top_nav.php");
	   
	   include("sidebar.php");
	   ?>	
  <script>
 function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(90)
                        .height(90);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>

 <link rel="stylesheet" href="css/jquery-ui.css" />
 
   <script type="text/javascript">
$(document).ready(function() {
	
$('.dob').datepicker({
    onSelect: function (value, ui) {
        var today = new Date();
        var format = value.split("/");
        var dob = new Date(format[2], format[1], format[0]);
        var diff = (today - dob);
        var age = Math.floor(diff / 31536000000);
        $('#age').val(age);
    },
    dateFormat: 'dd/mm/yy',
   // maxDate: '+0d',
    yearRange: '1960:2020',
    changeMonth: true,
    changeYear: true
});

}); //end ready

</script>
 
     <div id="content">		
		
		 <div id="content-header">
			 <h1> Employee Bank Details </h1>
		 </div>  <!-- #content-header -->	


		 <div id="content-container">
         
         
<?php 

$s_id=$_GET["id"];

?>

<?php if($_GET["msg"] == 'err_img') { ?>		
<div class="pane">
<div class="msg_system"><img src="img/layout/ico-done.gif" class="icon_mark"/> Please jpeg, jpg, png, bmp, gif format upload</div>	
<img src="img/layout/ico-delete.gif" alt="delete" class="delete" />
</div>
<?php } ?>


<?php if($_GET["msg"] == 'err') { ?>		
<div class="pane">
<div class="msg_system"><img src="img/layout/ico-done.gif" class="icon_mark"/> Query Failed </div>	
<img src="img/layout/ico-delete.gif" alt="delete" class="delete" />
</div>
<?php } ?>

			 <div class="portlet">
             

				 <div class="portlet-header">
			
					 <h3>						 
						Employee Bank Details
					 </h3>
			
				 </div>  <!-- /.portlet-header -->
			
				 <div class="portlet-content">
			
            
<form id="contacts-form" method="post" action="" enctype="multipart/form-data"  />

<?php
$emp_query="select * from staff where st_id='$s_id'";
$emp_result=mysql_query($emp_query);
if($emp_display=mysql_fetch_array($emp_result))
{
  $emp_image=$emp_display["photo"];
 
?>
<p class="title">Personal Details</p>
<div class="field">
<label>Employee Id : </label>
<input type="text" name="staff_id" readonly value="<?php echo $emp_display["staff_id"] ; ?>" />
</div>

<div class="field">
<label>First Name : </label>
<input type="text" name="fname" value="<?php echo $emp_display["fname"] ; ?>"  />

<label>Last Name : </label>
<input type="text"  name="lname" value="<?php echo $emp_display["lname"] ; ?>"  />
</div>

<div class="field">
<label>Father Name : </label>
<input type="text" name="s_pname" value="<?php echo $emp_display["s_pname"] ; ?>" />

<label>Date Of Birth : </label>
<input type="text" name="dob" class="dob" value="<?php echo $emp_display["dob"] ; ?>" />
</div>

<div class="field">
<label>Age : </label>
<input type="text" name="age" id="age" value="<?php echo $emp_display["age"] ; ?>" readonly  />

<label>Gender : </label>
<select name="gender">
<option>Select Items</option>
<option value="M" <?php if($emp_display["gender"]=='M'){ echo 'selected'; } ?>>Male</option>
<option value="F" <?php if($emp_display["gender"]=='F'){ echo 'selected'; } ?>>Female</option>
</select>
</div>

<div class="field">
<label>Religion : </label>
<input type="text" name="reg" value="<?php echo $emp_display["reg"] ; ?>"  />


<label>Blood Group : </label>
<input type="text" name="blood" value="<?php echo $emp_display["blood"] ; ?>"  />
</div>

<div class="field">
<label>Marital Status : </label>
<select name="marriage">
<option>Select Items</option>
<option value="Single" <?php if($emp_display["marriage"]=='Single'){ echo 'selected'; } ?> >Single</option>
<option value="Married" <?php if($emp_display["marriage"]=='Married'){ echo 'selected'; } ?> >Married</option>
<option value="Widow" <?php if($emp_display["marriage"]=='Widow'){ echo 'selected'; } ?> >Widow</option>
</select>

<label>Date Of Joining : </label>
<input type="text" name="doj" class="dob" value="<?php echo $emp_display["doj"] ; ?>" />
</div>

<div class="field">
<label>Staff Type : </label>
<select  name="s_type">
<option >Select Items </option>
<option value="Teaching" <?php if($emp_display["s_type"]=='Teaching'){ echo 'selected'; } ?>>Teaching </option>
<option value="Non-Teaching" <?php if($emp_display["s_type"]=='Non-Teaching'){ echo 'selected'; } ?>>Non-Teaching</option>
</select>

<label>Designation : </label>
<input type="text" name="position" value="<?php echo $emp_display["position"] ; ?>"  />
</div>

<div class="field">
<label>Job Type : </label>
<select name="job_type">
<option >Select Items </option>
<option value="Permanent" <?php if($emp_display["job_type"]=='Permanent'){ echo 'selected'; } ?> >Permanent </option>
<option value="Temporary" <?php if($emp_display["job_type"]=='Temporary'){ echo 'selected'; } ?> >Temporary </option>
</select>

<label>Qualification : </label>
<input type="text" name="qualf" value="<?php echo $emp_display["qualf"] ; ?>"  />
</div>

<div class="field">
<label>Permanent Address : </label>
<textarea  name="address1"><?php echo $emp_display["address1"] ; ?></textarea>

<label>Residential Address : </label>
<textarea  name="address2"><?php echo $emp_display["address2"] ; ?></textarea>
</div>

<div class="field">
<label>State : </label>
<input type="text" name="state" value="<?php echo $emp_display["state"] ; ?>" />

<label>Country : </label>
<input type="text" name="country" value="<?php echo $emp_display["country"] ; ?>"  />
</div>

<div class="field">
<label>Land Line No : </label>
<input type="text" name="lline" value="<?php echo $emp_display["lline"] ; ?>" />

<label>Phone No : </label>
<input type="text" name="phone_no" value="<?php echo $emp_display["phone_no"] ; ?>" />
</div>

<div class="field">
<label>Email Id : </label>
<input type="email" name="email" value="<?php echo $emp_display["email"] ; ?>" />

<label>Transport : </label>
<select name="transport">
<option>Select Items</option>
<option value="Bus" <?php if($emp_display["transport"]=='Bus'){ echo 'selected'; } ?> >Bus</option>
<option value="Hostel" <?php if($emp_display["transport"]=='Hostel'){ echo 'selected'; } ?> >Hostel</option>
<option value="None" <?php if($emp_display["transport"]=='None'){ echo 'selected'; } ?> >None</option>
</select>
</div>

<div class="field"> <p class="title">Bank Details :</p></div>

<div class="field">
<label>Bank Name : </label>
<input type="text" name="b_name" value="<?php echo $emp_display["b_name"] ; ?>" />

<label>Bank Acc No : </label>
<input type="text" name="b_acc_no" value="<?php echo $emp_display["b_acc_no"] ; ?>" />
</div>

<div class="field">
<label>PF No : </label>
<input type="text" name="pf_no"  value="<?php echo $emp_display["pf_no"] ; ?>" />

<label>Nominee: </label>
<select name="nominee" >
<option>Select Items </option>
<option value="Parents" <?php if($emp_display["nominee"]=='Parents'){ echo 'selected'; } ?> >Parents </option>
<option value="Wife" <?php if($emp_display["nominee"]=='Wife'){ echo 'selected'; } ?> >Wife </option>
<option value="Relatives" <?php if($emp_display["nominee"]=='Relatives'){ echo 'selected'; } ?> >Relatives </option>
</select>
</div>

<div class="field">
<label>Name : </label>
<input type="text" name="n_name" value="<?php echo $emp_display["n_name"] ; ?>" />

<label>Phone No : </label>
<input type="text" name="n_phone_no" value="<?php echo $emp_display["n_phone_no"] ; ?>" />
</div>

<div class="field">
<label>Email Id : </label>
<input type="email" name="n_email" value="<?php echo $emp_display["n_email"] ; ?>"  />

<label>Status : </label>
<select name="status">
<option value="0" <?php if($emp_display["status"]==0){ echo 'selected'; } ?>> Disable</option>
<option value="1" <?php if($emp_display["status"]==1){ echo 'selected';}?>> Enable</option>
</select>
</div>

<div class="field">
<label>Photo : </label>
<input type="file" name="photo" onChange="readURL(this);" style=" border:none;"/>
<img id="blah" src="" alt="" class="img_browse" style=" float:left;margin-left:-30px;"/>
<?php if($emp_image){echo '<p class="del_img"><a href="emp_details_delete.php?img_id='.$s_id.'">delete</a></p><img  src="../img/Staff/'.$emp_image.' " width="95" height="120" style=" margin-bottom:30px;margin-right:30px; float:left; border:1px solid #ccc;" /> ';} else {echo'<p  style=" width:150px; text-align:center; background:#f00; color:#fff;  padding:5px; margin-bottom:20px; float:left; "> There are no images </p> ';} ?>
</div>


<?php } ?>

<div class="field">  
<label>&nbsp;</label> 
<input type="submit" class="but" name="submit" value="Submit"/>
<input type="submit" class="but" name="cancel" value="Cancel"/>
</div>

</form> 
	
    <?php
  
function is_valid_type($file) {
$valid_types = array("image/jpg","image/jpeg", "image/png", "image/bmp", "image/gif");
if (in_array($file['type'], $valid_types))
return 1;
return 0;
}
  if(isset($_POST["submit"]))
  {
	$s_staff_id= mysql_real_escape_string($_POST["staff_id"]);
	$s_fname= mysql_real_escape_string($_POST["fname"]);
	$s_lname= mysql_real_escape_string($_POST["lname"]);
	$s_pname= mysql_real_escape_string($_POST["s_pname"]);
	$s_dob= mysql_real_escape_string($_POST["dob"]);
	$s_age= mysql_real_escape_string($_POST["age"]);
	$s_gender= mysql_real_escape_string($_POST["gender"]);
	$s_reg= mysql_real_escape_string($_POST["reg"]);
	$s_blood= mysql_real_escape_string($_POST["blood"]);
	$s_marriage= mysql_real_escape_string($_POST["marriage"]);
	$s_doj= mysql_real_escape_string($_POST["doj"]);
	$s_type= mysql_real_escape_string($_POST["s_type"]);
	$s_position= mysql_real_escape_string($_POST["position"]);
	$s_job_type= mysql_real_escape_string($_POST["job_type"]);
	$s_qualf= mysql_real_escape_string($_POST["qualf"]);
	$s_address1= mysql_real_escape_string($_POST["address1"]);
	$s_address2= mysql_real_escape_string($_POST["address2"]);	
	$s_state= mysql_real_escape_string($_POST["state"]);
	$s_country= mysql_real_escape_string($_POST["country"]);
	$s_lline= mysql_real_escape_string($_POST["lline"]);
	$s_phone_no= mysql_real_escape_string($_POST["phone_no"]);
	$s_email= mysql_real_escape_string($_POST["email"]);
	$s_transport= mysql_real_escape_string($_POST["transport"]);
	
	$s_b_name= mysql_real_escape_string($_POST["b_name"]);
	$s_b_acc_no= mysql_real_escape_string($_POST["b_acc_no"]);
	$s_pf_no= mysql_real_escape_string($_POST["pf_no"]);
	$s_nominee= mysql_real_escape_string($_POST["nominee"]);
	$s_n_name= mysql_real_escape_string($_POST["n_name"]);
	$s_n_phone_no= mysql_real_escape_string($_POST["n_phone_no"]);
	$s_n_email= mysql_real_escape_string($_POST["n_email"]);
	$s_status= mysql_real_escape_string($_POST["status"]);
			  
$TARGET_PATH = "../img/Staff/";
$image = $_FILES['photo'];
$TARGET_PATH .= $image['name'];

$img=$image['error'];

if($img!=4)
{
	
if (!is_valid_type($image)) {
//$_SESSION['error'] = "You must upload a jpeg, gif, or bmp";
header("Location: emp_details_edit.php?msg=err_img");
exit;
}


if (move_uploaded_file($image['tmp_name'], $TARGET_PATH)) {

	$query="update staff set staff_id='$s_staff_id',fname='$s_fname', lname='$s_lname', s_pname='$s_pname', dob='$s_dob', age='$s_age', gender='$s_gender', reg='$s_reg', blood='$s_blood', marriage='$s_marriage', doj='$s_doj', s_type='$s_type', position='$s_position', job_type='$s_job_type', qualf='$s_qualf', address1='$s_address1', address2='$s_address2', state='$s_state', country='$s_country', lline='$s_lline', phone_no='$s_phone_no', email='$s_email', transport='$s_transport', b_name='$s_b_name', b_acc_no='$s_b_acc_no', pf_no='$s_pf_no', nominee='$s_nominee', n_name='$s_n_name', n_phone_no='$s_n_phone_no', n_email='$s_n_email', photo='" . $image['name'] . "', status='$s_status' where st_id='$s_id' ";
	$result=mysql_query($query);
	
	if($result)
	{
		header("location:emp_details_list.php?msg=succ");
		
	}
	else
	{
		header("location:emp_details_list.php?msg=err");		
	
    }
}
}
else
{
$query="update staff set staff_id='$s_staff_id',fname='$s_fname', lname='$s_lname', s_pname='$s_pname', dob='$s_dob', age='$s_age', gender='$s_gender', reg='$s_reg', blood='$s_blood', marriage='$s_marriage', doj='$s_doj', s_type='$s_type', position='$s_position', job_type='$s_job_type', qualf='$s_qualf', address1='$s_address1', address2='$s_address2', state='$s_state', country='$s_country', lline='$s_lline', phone_no='$s_phone_no', email='$s_email', transport='$s_transport', b_name='$s_b_name', b_acc_no='$s_b_acc_no', pf_no='$s_pf_no', nominee='$s_nominee', n_name='$s_n_name', n_phone_no='$s_n_phone_no', n_email='$s_n_email', status='$s_status' where st_id='$s_id' ";
	$result=mysql_query($query);
	
	if($result)
	{
		header("location:emp_details_list.php?msg=succ");
		
	}
	else
	{
		header("location:emp_details_list.php?msg=err");		
	
    }
}
	

  }
    
  
  if(isset($_POST["cancel"]))
  {
	  header("location:emp_details_list.php");
  }
  ?>  	
  
				 </div>  <!-- /.portlet-content -->
			
			 </div>  <!-- /.portlet -->




		 </div>  <!-- /#content-container -->
		

	 </div>  <!-- #content -->
	
	
 </div>  <!-- #wrapper -->
 
 
 <?php
 
 include("footer.php");
 
 ?>
