 <?php
 include("header.php");
$sdid=$_GET["sdid"];
$emp_query="select m_year from staff_deduction where sd_id='$sdid'";
		$emp_result=mysql_query($emp_query);
		$employee=mysql_fetch_array($emp_result);
  if(isset($_POST["submit"]))
  {
	$title= mysql_real_escape_string($_POST["title"]);
	$type= mysql_real_escape_string($_POST["type"]);
	$amount= mysql_real_escape_string($_POST["amount"]);
	$afor= mysql_real_escape_string($_POST["afor"]);
	
	$query="insert into staff_ded_detail(title,amount,type,sd_id,a_for)values('$title','$amount','$type','$sdid','$afor')";
	$result=mysql_query($query);	
	if($result)
	{
		header("location:deduction_detail_add.php?sdid=$sdid&msg=succ");		
	}
	else
	{
		header("location:deduction_detail_add.php?sdid=$sdid&msg=err");
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
			 <h1> <?=$employee['m_year']?> Deduction detail Add <a href="deduction_detail.php?id=<?=$sdid?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
						<?=$employee['m_year']?> Deduction detail  Add
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
<div class="col-sm-6">
				            	<div class="form-group">
									<label for="name">Title</label>
									<input type="text" id="title" name="title" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Type</label>
									<select name="type" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="C">Common</option>
										<option value="M">Men</option>
                                        <option value="W">Women</option>
									</select>
								</div>
                                
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">Amount for Each</label>
									<input type="text" id="amount" name="amount" class="form-control" data-required="true" data-type="number" >
								</div> 
                                <div class="form-group">
									<label for="name">Applied for</label>
									<select name="afor" class="form-control">
										<option value="0">All</option>
										<option value="1">Staff</option>
										<option value="2">Other Staff</option>
                                        <option value="3">Driver</option>
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