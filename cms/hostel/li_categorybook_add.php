 <?php
 error_reporting(E_ALL ^ E_NOTICE);
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
	
	 
	$name=mysql_real_escape_string($_POST["name"]);
     $date=date("Y-m-d");

	$adminlist1=mysql_query("SELECT * FROM lms_category  WHERE category_name='$name' and status='0'");
	$check=0;
	while($admincount1=mysql_fetch_array($adminlist1))
	{
	    $check=1;
	    // $admin_number1="ST".str_pad($adminno1, 3, '0', STR_PAD_LEFT);
	   
	    header("location:li_categorybook_add.php?msg=err&name=$name");
	}
	if($check==0)
	{
	    
	    $query="insert into lms_category(category_name,creation_date)values('$name','$date')";
	    $result=mysql_query($query);
	    header("location:li_categorybook_add.php?msg=succ");
	    
	   
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
			 <h1> Add Book Category Details  <a href="lms_categorydetails_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
    
 <?php   if(isset($_GET["msg"]))
	       {
	           
	 $msg=$_GET["msg"]; 
	  if($msg == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong> Category Successfully Inserted 
			</div>	
<?php } ?>
 <?php if($msg == 'err') {
     
     ?>
 <div class="alert  alert-warning">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Category Name All ready  Given!!!
			</div>
			 
<?php } }?>


 
				 <div class="portlet-header">			
					 <h3>						 
						Add Book Category
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Category Details :</p>       
 	
<div class="col-sm-6">
				            	 
                                <div class="form-group">
									<label for="name">Category Name</label>
									<input type="text" id="name" name="name"     value="<?=$_GET["name"]?>" class="form-control" data-required="true">
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