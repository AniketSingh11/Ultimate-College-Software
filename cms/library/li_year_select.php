 <?php
 error_reporting(E_ALL ^ E_NOTICE);
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
	
	 
	$year=$_POST['year'];
		//die();
		$classl = mysql_query("SELECT * FROM year");
                                           while ($yearlist = mysql_fetch_assoc($classl)){
											   $yea1r=$yearlist['ay_id'];
											   $qry=mysql_query("UPDATE year SET status='0' WHERE ay_id='$yea1r'");
										   }
		$qry=mysql_query("UPDATE year SET status='1' WHERE ay_id='$year'");
    if($qry){
        header("Location:li_year_select.php?msg=succ");
    }
    exit;
 
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
			 <h1> Select Academy Year </h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
    
 <?php   if(isset($_GET["msg"]))
	       {
	           
	 $msg=$_GET["msg"]; 
	  if($msg == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong>  Successfully Changed 
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
						Select Academy Year
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Radio Buttons</p>       
 	
<div class="col-sm-6">
				            	 
                                <div class="form-group">
									<?php 
								 $classl = mysql_query("SELECT * FROM year");
                                           while ($row1 = mysql_fetch_assoc($classl)){
											   
                                               ?>
								<label><input type="radio" name="year" value="<?php echo $row1['ay_id']; ?>" <?php if($row1["status"]=="1"){?>checked<?php }?> /><?php echo $row1['y_name']; ?></label> 
								<br>
                                <?php } ?>
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