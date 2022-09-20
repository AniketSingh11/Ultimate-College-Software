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
     <div id="content">		
		 <div id="content-header">
			 <h1> Employee Allowance & Deduction Details </h1>
		 </div>  <!-- #content-header -->	
	 <div id="content-container">
<?php 
$s_id=$_GET["id"];
?>
<?php if($_GET["msg"] == 'err') { ?>		
<div class="pane">
<div class="msg_system"><img src="img/layout/ico-done.gif" class="icon_mark"/> Query Failed </div>	
<img src="img/layout/ico-delete.gif" alt="delete" class="delete" />
</div>
<?php } ?>


			 <div class="portlet">
			
				 <div class="portlet-header">
			
					 <h3>						 
						Employee Allowance & Deduction
					 </h3>
			
				 </div>  <!-- /.portlet-header -->
			
				 <div class="portlet-content">
			
<form id="contacts-form" method="post" action="" enctype="multipart/form-data"  />

<?php
$emp_query="select * from staff_allw_ded where id='$s_id'";
$emp_result=mysql_query($emp_query);
if($emp_display=mysql_fetch_array($emp_result))
{
?>

<div class="field">
<label>Type : </label>
<select name="type">
<option value="Allowance" <?php if($emp_display["type"]=='Allowance'){ echo 'selected'; } ?>> Allowance </option>
<option value="Deductions" <?php if($emp_display["type"]=='Deductions'){ echo 'selected'; } ?>> Deductions </option>
</select>
</div>

<div class="field">
<label>Name : </label>
<input type="text" name="name" value="<?php echo $emp_display["name"] ; ?>" />
</div>

<div class="field">
<label>Percentage : </label>
<input type="text" name="per_cent" value="<?php echo $emp_display["per_cent"] ; ?>"  />
</div>

<div class="field">
<label>Description : </label>
<textarea name="descrip" ><?php echo $emp_display["descrip"] ; ?></textarea>
</div>

<div class="field">
<label>Status : </label>
<select name="status">
<option value="0" <?php if($emp_display["status"]==0){ echo 'selected'; } ?>> Disable</option>
<option value="1" <?php if($emp_display["status"]==1){ echo 'selected';}?>> Enable</option>
</select>
</div>

<?php } ?>

<div class="field">  
<label>&nbsp;</label> 
<input type="submit" class="but" name="submit" value="Submit"/>
<input type="submit" class="but" name="cancel" value="Cancel"/>
</div>

</form> 

<?php

if(isset($_POST["submit"]))
{
	$s_type=mysql_real_escape_string($_POST["type"]);
	$s_name=mysql_real_escape_string($_POST["name"]);
	$s_per_cent=mysql_real_escape_string($_POST["per_cent"]);
	$s_descrip=mysql_real_escape_string($_POST["descrip"]);
	$s_status=mysql_real_escape_string($_POST["status"]);
	
	$emp_query="update staff_allw_ded set type='$s_type', name='$s_name', per_cent='$s_per_cent', descrip='$s_descrip', status='$s_status' where id='$s_id' ";
	$emp_result=mysql_query($emp_query);
	
	if($emp_result)
	
	{
		header("location:emp_allw_ded_list.php?msg=succ");
	}
		
	else
	{
		header("location:emp_allw_ded_edit.php?msg=err");
	}
	
}



if(isset($_POST["cancel"]))
  {
	  header("location:emp_allw_ded_list.php");
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
