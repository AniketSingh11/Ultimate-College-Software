 <?php
 error_reporting(E_ALL ^ E_NOTICE);
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
	
	 $amount=addslashes($_POST["fine"]);
	 if($amount!="")
	 {
      $fine_query=mysql_query("SELECT * FROM lms_student_fineamount  where academic_year='$acyear'");
      $f=0;
      while($fi=mysql_fetch_array($fine_query))
      {
          $f=1;
          $qry=mysql_query("UPDATE lms_student_fineamount  SET fineamount='$amount'  WHERE academic_year='$acyear'");
          header("Location:li_fine_amount.php?msg=succ");
      }
      
      if($f==0)
      {
          $sql=mysql_query("INSERT INTO lms_student_fineamount (academic_year,fineamount) values('$acyear','$amount')") or die(mysql_error());
          
          header("Location:li_fine_amount.php?msg=succ");
      }
	 }else{
	     
	     header("Location:li_fine_amount.php?msg=err");
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
			 <h1> Fine  Amount </h1>
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
 <div class="alert  alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong>  <?php echo $_GET["err_msg"];?> !!!
			</div>
			 
<?php } }?>


 
				 <div class="portlet-header">			
					 <h3>						 
						Fine Amount
					 </h3>	
					 
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
          <?php 
          
          $fine_query=mysql_query("SELECT * FROM lms_student_fineamount  where academic_year='$acyear'");
          $fi=mysql_fetch_array($fine_query);
           
          $fine=$fi['fineamount'];
          ?>
 	 
                                   <div class="col-sm-6">
 
								   <div class="form-group">
                                      <label for="name">Fine Amount (Rs) :</label>
									 <input type="text" name="fine" data-type="digits"  data-required="true" value="<?=$fine?>" class="form-control" >
								  </div>
                               
                                 </div>

<div class="clear"></div>
                            <div class="col-sm-12">
                                 <center>
                                 <div class="form-group">
								 <input type="reset"   class="btn btn-default">
								 <button type="submit" class="btn btn-primary" name="submit">Submit</button>
								 </div>
                                </center>
                             </div>
  			
            
</form>





 


 </div>  <!-- /.portlet-content -->









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