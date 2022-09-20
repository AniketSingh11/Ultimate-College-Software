 <?php
 include("header.php");
$sdid=$_GET["sdid"];
$id=$_GET["id"];
$emp_query="select m_year from staff_deduction where sd_id='$sdid'";
		$emp_result=mysql_query($emp_query);
		$employee=mysql_fetch_array($emp_result);
  if(isset($_POST["submit"]))
  {
	$title= mysql_real_escape_string($_POST["title"]);
	$type= mysql_real_escape_string($_POST["type"]);
	$amount= mysql_real_escape_string($_POST["amount"]);
	$status= mysql_real_escape_string($_POST["status"]);
	$afor= mysql_real_escape_string($_POST["afor"]);
	
	$query=mysql_query("update staff_ded_detail set title='$title',amount='$amount',type='$type',status='$status',a_for='$afor' where id='$id'");
	
	if($query)
	{
		$msg="succ";		
	}
	else
	{
		$msg="err";
    }
  }
  $emp_query1="select * from staff_ded_detail where id='$id'";
		$emp_result1=mysql_query($emp_query1);
		$ddetail=mysql_fetch_array($emp_result1);
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
			 <h1> <?=$employee['m_year']?> Deduction detail Edit <a href="deduction_detail.php?id=<?=$sdid?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($msg == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Edited!!! 
			</div>	
<?php } ?>
 <?php if($msg == 'err') { ?>
 <div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						<?=$employee['m_year']?> Deduction detail  Edit
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
<div class="col-sm-6">
				            	<div class="form-group">
									<label for="name">Title</label>
									<input type="text" id="title" name="title" class="form-control" data-required="true" value="<?=$ddetail['title']?>">
								</div>
                                <div class="form-group">
									<label for="name">Type</label>
									<select name="type" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="C" <?php if($ddetail["type"]=='C'){ echo 'selected'; } ?>>Common</option>
										<option value="M" <?php if($ddetail["type"]=='M'){ echo 'selected'; } ?>>Men</option>
                                        <option value="W" <?php if($ddetail["type"]=='W'){ echo 'selected'; } ?>>Women</option>
									</select>
								</div>
                                <div class="form-group">	
                                    <label for="validateSelect">Status</label>
                                    <select name="status" id="status" class="form-control" data-required="true">
                                        <option value="0" <?php if($ddetail["status"]==0){ echo 'selected'; } ?>> Enable</option>
                                        <option value="1" <?php if($ddetail["status"]==1){ echo 'selected';}?>> Disable</option>
                                    </select>
                                </div> 
                                
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">Amount for Each</label>
									<input type="text" id="amount" name="amount" class="form-control" data-required="true" data-type="number"  value="<?=$ddetail['amount']?>">
								</div>
                                <div class="form-group">
									<label for="name">Applied for</label>
									<select name="afor" class="form-control" data-required="true">
                                        <option value="0" <?php if($ddetail["a_for"]=='0'){ echo 'selected'; } ?>>All Employee</option>
										<option value="1" <?php if($ddetail["a_for"]=='1'){ echo 'selected'; } ?>>Staff</option>
										<option value="2" <?php if($ddetail["a_for"]=='2'){ echo 'selected'; } ?>>Other Staff</option>
                                        <option value="3" <?php if($ddetail["a_for"]=='3'){ echo 'selected'; } ?>>Driver</option>
									</select>
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