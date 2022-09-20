 <?php
 include("header.php");
 if(isset($_POST["submit"]))
  {
 
	$s_type=mysql_real_escape_string($_POST["s_type"]);
	
	$ay_id=mysql_real_escape_string($_POST["ay_id"]);
	
	$date=date("Y-m-d"); 
	
	$err_msg="";
 
	$query="select * from hms_fees_structure where  status='0' and section='$s_type' and ay_id='$ay_id'";
	$res=mysql_query($query);
	$chk=0;
	while($row=mysql_fetch_array($res))
	{
	    $chk=1;
	    
	    $err_msg.="Hostel Fees  Already Assign This Section &nbsp;";
	    
	}
 
	$res=mysql_query("select * from hms_room_type where status='0'");
	while($row=mysql_fetch_array($res))
	{
	    $room_type=stripslashes($row["room_type"]);
	    $hrt_id=stripslashes($row["hrt_id"]);
	    
	    $amount=mysql_real_escape_string($_POST["amount$hrt_id"]);
	    
	    if($amount==""){
	        $err_msg.="$room_type Field is Empty &nbsp;";
	        
	    }
	}
	 
	if($s_type!="" && $chk!="1" && $ay_id!="" && $err_msg=="")
	{
	  $query="insert into hms_fees_structure(section,role,ay_id,date)
	   values('$s_type','Hostel Fees','$ay_id','$date')";
	    $result=mysql_query($query) or die(mysql_error());
	    
	    $last_id=mysql_insert_id();
	    
	    $res=mysql_query("select * from hms_room_type where status='0'");
	    while($row=mysql_fetch_array($res))
	    {
	    $hrt_id=stripslashes($row["hrt_id"]);
	    $amount=mysql_real_escape_string($_POST["amount$hrt_id"]);
	    $query="insert into hms_feestype(hfs_id,room_type,amount,date) values('$last_id','$hrt_id','$amount','$date')";
	    $result=mysql_query($query) or die(mysql_error());
	    }
	   
	  header("location:hostel_fees_amount.php?msg=succ");
	    
	}else{
	
	if($err_msg==""){
 $err_msg.="Failed!!";}
//  header("location:book_details_add.php?msg=err&err_msg=$err_msg");
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
			 <h1>Add Hostel Fees Details  <a onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
					Add	Hostel Fees Details 
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title"> Academic Year :2014 - 2015 </p>     
     <input type="hidden" name="ay_id" value="<?=$acyear?>">   
                          <div class="form-group" style="width: 500px;">	
									<label for="validateSelect">Standard<font color="red">*</font></label>
									<select name="s_type"  class="form-control"  data-required="true">
									<option value=''>Select</option>
									<?php 
									$res=mysql_query("select * from class  where ay_id='$acyear' order by c_id asc");
									while($row=mysql_fetch_array($res))
									{
									$c_name=stripslashes($row["c_name"]);
									$c_id=stripslashes($row["c_id"]);

									$qry1=mysql_query("select * from hms_fees_structure where status='0' and  section='$c_id' and ay_id='$acyear'");
									if(mysql_num_rows($qry1)==0){
									
									?>
									<option value="<?=$c_id?>"><?=$c_name?></option>
									
									 <?php } }?>
									
									</select>
                              </div> 
                    <table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Fees Amount</center></th>
                                  	<?php 
									$res=mysql_query("select * from hms_room_type where status='0'");
									while($row=mysql_fetch_array($res))
									{
									$room_type=stripslashes($row["room_type"]);
									$hrt_id=stripslashes($row["hrt_id"]);
									?>
									<th><?=$room_type?> Amount</th>
									 <?php }?>
                                   
								</tr>
							</thead>
                             <tbody>
                        <td>1</td>
                        <td>Hostel Fees</td>
        <?php $res=mysql_query("select * from hms_room_type where status='0'");
									while($row=mysql_fetch_array($res))
									{
									 
									$hrt_id=stripslashes($row["hrt_id"]);?>
								 
              <td><div class="form-group"><input type="text" style="width: 150px;"  name="amount<?=$hrt_id?>" data-digit="true" class="form-control" data-required="true"></div></td>
              <?php }?>
                       
                        </tbody>
                        </table>
 
<div class="col-sm-6">
								<!--   <div class="form-group">	
									<label for="validateSelect">Room Type<font color="red">*</font></label>
									<select name="r_type"  class="form-control"  data-required="true">
									<option value=''>Select</option>
									<?php 
									$res=mysql_query("select * from hms_room_type where status='0'");
									while($row=mysql_fetch_array($res))
									{
									$room_type=stripslashes($row["room_type"]);
									$hrt_id=stripslashes($row["hrt_id"]);
									?>
									<option value="<?=$hrt_id?>"><?=$room_type?></option>
									 <?php }?>
									
									</select>
                              </div> -->
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
										 
											 
                                             <th data-filterable="true">Section</th>		
                                             
                                             	<?php 
									$res=mysql_query("select * from hms_room_type where status='0'");
									while($row=mysql_fetch_array($res))
									{
									$room_type=stripslashes($row["room_type"]);
									$hrt_id=stripslashes($row["hrt_id"]);
									?>
									<th data-filterable="true"><?=$room_type?> Amount</th>
									 <?php }?>									 
											  
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
	 $emp_query="select * from hms_fees_structure  where status='0' and ay_id='$acyear' order by section asc";
	 $emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$section=$emp_display["section"];	
			$hfs_id=$emp_display["hfs_id"];
			
		$qry1=mysql_fetch_array(mysql_query("select * from class where c_id='$section'"));	
		$c_name=$qry1["c_name"];
		
			 ?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                            <td><?php echo $c_name;?> </td>
                                          <?php  $res=mysql_query("select * from hms_room_type where status='0'");
									while($row=mysql_fetch_array($res))
									{
									 
									$hrt_id=stripslashes($row["hrt_id"]);
									$qry1=mysql_fetch_array(mysql_query("select * from hms_feestype where hfs_id='$hfs_id' and room_type='$hrt_id'"));
									$amount=$qry1["amount"];
									
									   
                                          ?>  <td><?php echo $amount;?> </td>
                                          <?php }?> 
                                            
                 <td> <a title="edit" href="hostel_fees_amount_edit.php?id=<?php echo $hfs_id;?>"><img src="img/layout/edit.png"/></a>   <a title="delete" href="hostel_fees_amount_delete.php?id=<?php echo $hfs_id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a>   </td>
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