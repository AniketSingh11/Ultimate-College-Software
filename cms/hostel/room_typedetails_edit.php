 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
  
	 
	$t_name= mysql_real_escape_string($_POST["t_name"]);
	$id=mysql_real_escape_string($_POST["id"]);
	
	$date=date("Y-m-d"); 
	
	$err_msg="";
 
	$query="select * from hms_room_type where room_type='$t_name' and hrt_id!='$id' and status='0' ";
	$res=mysql_query($query) or die(mysql_error());
	$chk=0;
	while($row=mysql_fetch_array($res))
	{
	    $chk=1;
	    
	    $err_msg.="Room Type Name Already Given &nbsp;";
	    
	}
	

	
	if($t_name!="" && $chk!="1")
	{
	    
	   
	    
	   $qry=mysql_query("update hms_room_type set room_type='$t_name' where hrt_id='$id'");
	
        header("location:room_typedetails_edit.php?id=$id&msg=succ");
	    
	}else{
	
	if($err_msg==""){
	    $err_msg.="Failed!!";}
	
	
	    header("location:room_typedetails_edit.php?id=$id&msg=err&err_msg=$err_msg");
 
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
			 <h1> Room Type Details Edit <a href="room_typedetails_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
    
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Updated 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong>  <?php echo $_GET["err_msg"];?>!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Room Type Details Edit
					 </h3>			
				 </div>  <!-- /.portlet-header -->	
                 <?php
				 $hrt_id=$_GET["id"];
$book_query="select * from hms_room_type where hrt_id='$hrt_id' and status='0'";
$book_result=mysql_query($book_query);
$book_display=mysql_fetch_array($book_result);

$room_type=stripslashes($book_display["room_type"]);
?>		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Room Type Details :</p>       
     
                  
<div class="col-sm-6">
                                <div class="form-group">
									<label for="name">Room Type Name<font color="red">*</font></label>
									<input type="text" id="t_name" value="<?=$room_type?>" name="t_name" class="form-control" data-required="true">
								</div>
                                <!--<div class="form-group">
									<label for="name">Age</label>
									<input type="text" id="age" name="age" class="form-control" data-required="true">
								</div>-->
                              
<input type="hidden" name="id" value="<?=$hrt_id?>">			 
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
 <script>
 
    //iterate through each textboxes and add keyup
    //handler to trigger sum event
 
 
 </script>
 <?php 
 include("footer.php"); 
 ?>
 <?php include("includes/script.php");?>

</body>
</html>

 <? ob_flush(); ?>