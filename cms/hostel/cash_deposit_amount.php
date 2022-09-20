 <?php
 include("header.php");
 if(isset($_POST["submit"]))
  {

    $amount=mysql_real_escape_string($_POST["amount"]);
	
	$date=date("Y-m-d"); 
	
	$err_msg="";
 
	$query="select * from hms_cash_deposit where   ay_id='$acyear'";
	$res=mysql_query($query);
	$chk=0;
	while($row=mysql_fetch_array($res))
	{
	    $chk=1;
	   
	    
	}
 
	if($chk==0)
	{

	    $query="insert into hms_cash_deposit(amount,ay_id,date)
	    values('$amount','$acyear','$date')";
	    $result=mysql_query($query) or die(mysql_error());
	    
	}else{
	    
	    $query=mysql_query("update hms_cash_deposit set amount='$amount' where ay_id='$acyear'") or die(mysql_error());
	    
	}
	
  header("location:cash_deposit_amount.php?msg=succ");
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
			 <h1>Cash Deposit Details  <a onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
  
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong> Your Record Successfully Added 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'delete_succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong> Your Record Successfully Deleted 
			</div>	
<?php } ?>

 <?php if($_SERVER["REQUEST_METHOD"]=="POST") { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> <?php echo $err_msg;?>!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
					Cash Deposit Details 
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title"> Academic Year :2014 - 2015 </p>     
    
    
                         <?php 
                         $qry1=mysql_fetch_array(mysql_query("select * from hms_cash_deposit where ay_id='$acyear'"));
                         $amount=$qry1["amount"];
                         ?>
                    
 
<div class="col-sm-6">

                                     <div class="form-group">	
									<label for="validateSelect">Amount Rs.<font color="red">*</font></label>
                                <input type="text" id="amount" data-required="true" value="<?=$amount?>"  name="amount" class="form-control">
                                           </div>
								 
</div>

  			 </div>  <!-- /.portlet-content -->
             <div class="portlet-content">
     
     
 
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


<div class="portlet-content">
 <div class="table-responsive">
                             <table 
								class="table table-striped table-bordered table-hover table-highlight table-checkable" 
								data-provide="datatable" 
								data-display-rows="10"
								data-info="true"
								data-search="true"
								data-length-change="true"
								data-paginate="true">
									<thead>
										<tr>
											<th data-sortable="true">S.No</th>
										    <th data-filterable="true">Academic Year</th>		
                                            <th data-filterable="true">Amount</th>  							 
																				</tr>
									</thead>
									<tbody>
										<?php	
										
	 $emp_query="select * from hms_cash_deposit  order by ay_id asc";
	 $emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$amount=$emp_display["amount"];	
			 $ay_id=$emp_display["ay_id"];
			 
			 $qry1=mysql_fetch_array(mysql_query("select * from year where ay_id='$ay_id'"));
			 $y_name=$qry1["y_name"];
			 
		
			 ?>                             
										 <tr>
											  <td><?php echo $emp_count ;?> </td>
											  <td><?php echo $y_name;?> </td>
                                              <td><?php echo $amount;?> </td>
                                        </tr>
		<?php 
        
		$emp_count++; } ?>							
									</tbody>
								</table>
				</div>  <!-- /.table-responsive -->
</div>

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