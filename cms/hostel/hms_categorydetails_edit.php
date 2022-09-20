 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
	 $hid=$_POST['id'];

	
	$name=mysql_real_escape_string($_POST["name"]);
	$address=mysql_real_escape_string($_POST["address"]);
	$error_msg="";
	if($name==""){
	    $error_msg.="Hotel Name  Empty!! &nbsp;";
	    
	}
	
	 

	$adminlist1=mysql_query("SELECT * FROM hms_category  WHERE 	h_name='$name' and  h_id!='$hid' and  status='0'");
	$check=0;
	while($admincount1=mysql_fetch_array($adminlist1))
	{
	    $check=1;

	    $error_msg.="Hostel Name  Already Given";
	    header("location:hms_categorydetails_edit.php?id=$hid&msg=err&eror_msg=$error_msg");
	}
	
	
	if($check==0)
	{
	    
	    $query=mysql_query("update hms_category set h_name='$name',h_address='$address' where h_id='$hid'");
	    header("location:hms_categorydetails_edit.php?id=".$hid."&msg=succ");
	  
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
			 <h1>Hostel  Category Details Edit <a href="hms_categorydetails_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
   
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong> Your Record Successfully Updated 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] =='err' ) { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> <?=$_GET["eror_msg"];?>!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
					Hostel	Category Details Edit
					 </h3>			
				 </div>  <!-- /.portlet-header -->	
                 <?php
				 $h_id=$_GET["id"];
				 
$emp_query="select * from hms_category where h_id='$h_id' and status='0'";
$emp_result=mysql_query($emp_query) or die(mysql_error());
$emp_display=mysql_fetch_array($emp_result);
$h_name=stripslashes($emp_display["h_name"]);
$h_address=stripslashes($emp_display["h_address"]);
 
?>		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Hostel Details :</p>       
<div class="col-sm-6">
				            	<div class="form-group">
									<label for="name">Hostel Name</label>
									<input type="text" id="name" name="name" class="form-control" data-required="true"  value="<?=$h_name?>">
								</div>
								</div>
								
								<div class="col-sm-6">
				            	 
                                <div class="form-group">
									<label for="name">Hostel Address</label>
									<textarea name="address" class="form-control" data-required="true"><?=$h_address?></textarea>
								</div>
                               </div>
                               
<div class="clear"></div>
                                 <div class="col-sm-12">
                    <center>
<div class="form-group">
								<input type="hidden" name="id" value="<?php echo $h_id; ?>"/>
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