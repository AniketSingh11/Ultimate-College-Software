 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
	 $cid=$_POST['id'];

	
	$name=mysql_real_escape_string($_POST["name"]);
 
	$error_msg="";
	if($name==""){
	    $error_msg.="Category Name  Empty!! &nbsp;";
	    
	}
	
	 

	$adminlist1=mysql_query("SELECT * FROM lms_category  WHERE category_name='$name' and  c_id!='$cid' and  status='0'");
	$check=0;
	while($admincount1=mysql_fetch_array($adminlist1))
	{
	    $check=1;

	    $error_msg.="Category Name  Already Given";
	    header("location:lms_categorydetails_edit.php?id=$cid&msg=err&eror_msg=$error_msg");
	}
	
	
	if($check==0)
	{
	    
	    $query=mysql_query("update lms_category set category_name='$name' where c_id='$cid'");
	    header("location:lms_categorydetails_edit.php?id=".$cid."&msg=succ");
	  
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
			 <h1> Category Details Edit <a href="lms_categorydetails_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
 <div class="alert alert-warning">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> <?=$_GET["eror_msg"];?>!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Category Details Edit
					 </h3>			
				 </div>  <!-- /.portlet-header -->	
                 <?php
				 $s_id=$_GET["id"];
$emp_query="select * from lms_category where c_id='$s_id' and status='0'";
$emp_result=mysql_query($emp_query);
$emp_display=mysql_fetch_array($emp_result);
?>		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Category Details :</p>       
<div class="col-sm-6">
				            	<div class="form-group">
									<label for="name">Category Name</label>
									<input type="text" id="name" name="name" class="form-control" data-required="true"  value="<?php echo $emp_display["category_name"] ; ?>">
								</div>
                               
<div class="clear"></div>
                                 <div class="col-sm-12">
                    <center>
<div class="form-group">
								<input type="hidden" name="id" value="<?php echo $emp_display['c_id']; ?>"/>
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
                                </div>
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