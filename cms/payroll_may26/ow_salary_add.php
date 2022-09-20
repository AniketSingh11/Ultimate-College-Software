 <?php
 include("header.php");

$oid=$_GET['id'];
  if(isset($_POST["submit"]))
  {
	  
	$salary= mysql_real_escape_string($_POST["salary"]);
	$ex_salary= mysql_real_escape_string($_POST["ex_salary"]);
	$date1=date('d-m-Y H:i:s');
	foreach($_POST['allowance'] as $value)
  {
     $allowance.=$value.",";	 
  }
  foreach($_POST['deduction'] as $value1)
  {
     $deduction.=$value1.",";	 
  }
    $allowance=rtrim($allowance, ",");
    $deduction=rtrim($deduction, ",");
   
	$query="insert into staff_salary(salary,allowance,deduction,date,o_id,status,extra_salary)values('$salary','$allowance','$deduction','$date1','$oid','1','$ex_salary')";
	$result=mysql_query($query);	
	if($result)
	{
		header("location:ow_salary_add.php?id=$oid&msg=succ");		
	}
	else
	{
		header("location:ow_salary_add.php?id=$oid&msg=err");		
	}
	
  }
  $query=mysql_query("select * from others where o_id='$oid'");
$staffs=mysql_fetch_array($query);
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
			 <h1><?php echo $staffs['fname']." ".$staffs['lname'];?> - Salary Details Add <a href="ow_salary_list.php?id=<?php echo $oid;?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
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
						<?php echo $staffs['fname']." ".$staffs['lname'];?> - Salary Details Add
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Profile Details :</p>    
     <div class="col-sm-6">
     	<div class="form-group">
									<label for="name">Salary</label>
									<input type="text" id="salary" name="salary" class="form-control" data-required="true" data-type="number" >
								</div>
	 </div>   
<div class="col-sm-6">
     	<div class="form-group">
									<label for="name">Extra Salary</label>
									<input type="text" id="ex_salary" name="ex_salary" class="form-control"  data-type="number" >
								</div>
	 </div> 	 
     <div class="clear"></div>   
<div class="col-sm-6">
                                <h4>Allowance</h4>
	                        <div class="form-group">
                            <?php
										$emp_query="select * from staff_allw_ded where type='Allowance' order by id asc";
										$emp_result=mysql_query($emp_query);
										$emp_count=1;
										while($emp_display=mysql_fetch_array($emp_result))
										{
										$emp_id=$emp_display["id"];
										$basic=$emp_display["basic"];	?>
				                <div class="checkbox">
									<label>
									    <input type="checkbox" name="allowance[]" class="" checked value="<?php echo $emp_display["id"]; ?>" data-required="true" data-mincheck="2">
									    <?php echo $emp_display["name"]; ?>
                                        <div align="center" class="progress progress-striped active">
			  <div class="progress-bar progress-bar-success btn-success" role="progressbar" aria-valuenow="<?php echo $emp_display["per_cent"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $emp_display["per_cent"]; ?>%;">
			    <span class="sr-only"> <?php echo $emp_display["per_cent"]; ?>% Complete</span>
			  </div> <?php echo $emp_display["per_cent"]; ?> % 
			</div>
									</label>
								</div>
                                <?php } ?>				                
							</div> <!-- /.form-group -->
                                
</div>
<div class="col-sm-6">
                                <h4>Deductions</h4>
	                        <div class="form-group">
				                <?php
										$emp_query="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result=mysql_query($emp_query);
										$emp_count=1;
										while($emp_display=mysql_fetch_array($emp_result))
										{
										$emp_id=$emp_display["id"];	?>
				                <div class="checkbox">
									<label>
									    <input type="checkbox" name="deduction[]" class="" checked value="<?php echo $emp_display["id"]; ?>">
									    <?php echo $emp_display["name"]; ?>
                                        <div align="center" class="progress progress-striped active">
			  <div class="progress-bar progress-bar-primary btn-warning" role="progressbar" aria-valuenow="<?php echo $emp_display["per_cent"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $emp_display["per_cent"]; ?>%;">
			    <span class="sr-only"> <?php echo $emp_display["per_cent"]; ?>% Complete</span>
			  </div> <?php echo $emp_display["per_cent"]; ?> % 
			</div>
									</label>
								</div>
                                <?php } ?>					                
							</div> <!-- /.form-group -->
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
  			 </div>  <!-- /.portlet-content -->
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