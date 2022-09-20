 <?php
 include("header.php");
 $lt_id=$_GET["id"];
  if(isset($_POST["submit"]))
  {
	$name= mysql_real_escape_string($_POST["name"]);
	$min_amount= mysql_real_escape_string($_POST["min_amount"]);
	$max_amount= mysql_real_escape_string($_POST["max_amount"]);
	$dec= mysql_real_escape_string($_POST["dec"]);	
	$status= mysql_real_escape_string($_POST["status"]);
	
	$query="update staff_loan_type set name='$name', min_amount='$min_amount', max_amount='$max_amount', l_dec='$dec', status='$status' where lt_id='$lt_id' ";
	$result=mysql_query($query);	
	if($result)
	{
		header("location:loan_type_edit.php?id=$lt_id&msg=succ");		
	}
	else
	{
		header("location:loan_type_edit.php?id=$lt_id&msg=err");
	
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
			 <h1> Loan Type Add <a href="loan_type.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Loan Type Add
					 </h3>			
				 </div>  <!-- /.portlet-header -->	
                 <?php				
$emp_query="select * from staff_loan_type where lt_id='$lt_id'";
$emp_result=mysql_query($emp_query);
$loantype=mysql_fetch_array($emp_result);
?>			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
<div class="col-sm-6">
				            	<div class="form-group">
									<label for="name">Loan Name</label>
									<input type="text" id="name" name="name" class="form-control" data-required="true"  value="<?php echo $loantype['name'];?>" >
								</div>
                                <div class="form-group">
									<label for="name">Max Amount</label>
									<input type="text" id="max_amount" name="max_amount" class="form-control" data-required="true" data-type="number" value="<?php echo $loantype['max_amount'];?>">
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Status</label>
									<select name="status" id="status" class="form-control" data-required="true">
										<option value="0" <?php if($loantype["status"]==0){ echo 'selected'; } ?>> Disable</option>
										<option value="1" <?php if($loantype["status"]==1){ echo 'selected';}?>> Enable</option>
									</select>
								</div>
                                
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">min Amount</label>
									<input type="text" id="min_amount" name="min_amount" class="form-control" data-required="true" data-type="number" value="<?php echo $loantype['min_amount'];?>">
								</div>
                                <div class="form-group">
									<label for="name">Description</label>
									<textarea id="dec" name="dec" class="form-control" rows="5"><?php echo $loantype['l_dec'];?></textarea>
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
 include("includes/script.php");?>
</body>
</html>

 <? ob_flush(); ?>