 <?php
 include("header.php");

$oid=$_GET['id'];
  if(isset($_POST["submit"]))
  {
	  
	$salary= mysql_real_escape_string($_POST["salary"]);
	$date1=date('d-m-Y H:i:s');

    $allowance=rtrim($allowance, ",");
    $deduction=rtrim($deduction, ",");
   
	$query="insert into staff_salary(salary,date,o_id,status)values('$salary','$date1','$oid','1')";
	$result=mysql_query($query);	
	if($result)
	{
		header("location:ow_day_salary_add.php?id=$oid&msg=succ");		
	}
	else
	{
		header("location:ow_day_salary_add.php?id=$oid&msg=err");		
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
			 <h1><?php echo $staffs['fname']." ".$staffs['lname'];?> - Salary Details Add <a href="ow_day_salary_list.php?id=<?php echo $oid;?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
									<label for="name">One Day Salary</label>
									<input type="text" id="salary" name="salary" class="form-control" data-required="true" data-type="number" >
								</div>
	 </div>                      
     <div class="clear"></div>   

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