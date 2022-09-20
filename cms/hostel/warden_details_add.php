 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {

  
	$category=mysql_real_escape_string($_POST["category"]);
	$f_name=mysql_real_escape_string($_POST["f_name"]);
	$p_name=mysql_real_escape_string($_POST["p_name"]);
	$q_name=mysql_real_escape_string($_POST["q_name"]);
	
	
	
	$date=date("Y-m-d"); 
	
	$err_msg="";
 
	 
	
	
	if($f_name!="" && $category!="" && $p_name!="" &&  $q_name!='')
	{
	    
	   
	    
	    $query="insert into hms_worker(category,name,position,qualification,date)
	    values('$category','$f_name','$p_name','$q_name','$date')";
	    $result=mysql_query($query);
	    
	    header("location:warden_details_add.php?msg=succ");
	    
	}else{
	
	if($err_msg==""){
 $err_msg.="Failed!!";}
   header("location:warden_details_add.php?msg=err&err_msg=$err_msg");
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
			 <h1>Add warden Details  <a href="warden_details_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
  
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong> Your Record Successfully Added 
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
					Add	warden Details 
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">warden Details :</p>       
 
<div class="col-sm-6"> <div class="form-group">	
									<label for="validateSelect">Hostel Category<font color="red">*</font></label>
									<select name="category" class="form-control" data-required="true">
									<option value="" <?php if($_POST["category"]==""){?>selected="selected" <?php }?>>Please Select</option> <?php 
									$res=mysql_query("select * from hms_category where 	status='0'");
									while($row=mysql_fetch_array($res))
									{
									
									?>
										 
										<option value="<?=stripslashes($row["h_id"]);?>" <?php if($_POST["category"]==$row["h_id"]){?>selected="selected" <?php }?> ><?=stripslashes($row["h_name"]);?></option>
									 <?php }?>
									</select>
								</div>
				            	 
                             
                               
                                  <div class="form-group">
									<label for="name">Position<font color="red">*</font></label>
									<input type="text" id="p_name" name="p_name" class="form-control"  value="<?=$_POST["p_name"]?>" data-required="true">
								  </div>
                               
								
								
                                <!--  <div class="form-group">
									<label for="name">Qualification </label>
									<input type="text" id="qualification" name="qualification" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
								<label for="textarea-input">Residential Address</label>
								<textarea name="address2" id="textarea-input" cols="10" rows="3" class="form-control"></textarea>
								</div>
                                <div class="form-group">
									<label for="name">Country </label>
									<input type="text" id="country" name="country" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Land Line No </label>
									<input type="text" id="lline" name="lline" class="form-control">
								</div>-->
                                
</div>
                                <div class="col-sm-6">
								   <div class="form-group">
									<label for="name">warden Name<font color="red">*</font></label>
									<input type="text" id="f_name" name="f_name" class="form-control"  value="<?=$_POST["f_name"]?>" data-required="true">
								  </div>
                           
                            
                                 <div class="form-group">
									<label for="name">Qualification<font color="red">*</font></label>
									<input type="text" id="q_name" name="q_name" class="form-control"  value="<?=$_POST["q_name"]?>" data-required="true">
								  </div>
								  
								  
                            
								<!--  
                                <div class="form-group">	
									<label for="validateSelect">Marital Status</label>
									<select name="marital" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Single">Single</option>
										<option value="Married">Married</option>
                                        <option value="Widow">Widow</option>
									</select>
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Staff Type</label>
									<select name="staff_type" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Teaching">Teaching</option>
										<option value="Non-Teaching">Non-Teaching</option>
									</select>
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Job Type</label>
									<select name="job_type" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Permanent">Permanent</option>
										<option value="Temporary">Temporary</option>
									</select>
								</div>
                                <div class="form-group">
								<label for="textarea-input">Permanent Address</label>
								<textarea name="address1" id="textarea-input" cols="10" rows="3" class="form-control" data-required="true"></textarea>
								</div>
                                <div class="form-group">
									<label for="name">State </label>
									<input type="text" id="state" name="state" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Email ID </label>
									<input type="email" id="email" name="email" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Phone No</label>
									<input type="text" id="phone" name="phone" class="form-control" data-required="true">
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Transport</label>
									<select name="transport" class="form-control">
										<option value="">Select Transport</option>
										<option value="0">Regular Bus</option>
                                            <option value="1">Sp.Bus</option>
                                            <option value="2">Onetime Sp.Bus</option>	
									</select>
								</div>-->
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