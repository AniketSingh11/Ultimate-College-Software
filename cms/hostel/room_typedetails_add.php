 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
 
	$t_name= mysql_real_escape_string($_POST["t_name"]);
	
	
	$date=date("Y-m-d"); 
	
	$err_msg="";
 
	$query="select * from hms_room_type where room_type='$t_name' and status='0'";
	$res=mysql_query($query) or die(mysql_error());
	$chk=0;
	while($row=mysql_fetch_array($res))
	{
	    $chk=1;
	    
	    $err_msg.="room type Name Already Given &nbsp;";
	    
	}
 
	
	
	if($t_name!="" && $chk!="1")
	{
	    
	    $qty=round($qty);
	    
	    $query="insert into hms_room_type(room_type)
	    values('$t_name')";
	    $result=mysql_query($query);
	    
	    header("location:room_typedetails_add.php?msg=succ");
	    
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
			 <h1>Add Room type Details  <a href="room_typedetails_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
					Add	Room type Details 
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Room type Details :</p>       
 
 
<div class="col-sm-6">
								   <div class="form-group">
									<label for="name">Room Type Name<font color="red">*</font></label>
									<input type="text" id="t_name" name="t_name" class="form-control"  value="<?=$_POST["t_name"]?>" data-required="true">
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