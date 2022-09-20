 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
  
	$category= mysql_real_escape_string($_POST["category"]);
	$f_name= mysql_real_escape_string($_POST["f_name"]);
	$id=mysql_real_escape_string($_POST["id"]);
	
	$date=date("Y-m-d"); 
	
	$err_msg="";
 
	$query="select * from hms_floor where floor_name='$f_name' and hf_id!='$id' and status='0' ";
	$res=mysql_query($query) or die(mysql_error());
	$chk=0;
	while($row=mysql_fetch_array($res))
	{
	    $chk=1;
	    
	    $err_msg.="Floor Name Already Given &nbsp;";
	    
	}
	

	
	if($f_name!="" && $category!="" && $chk!="1")
	{
	    
	   
	    
	   $qry=mysql_query("update hms_floor set category='$category',floor_name='$f_name' where hf_id='$id'");
	
        header("location:floor_details_edit.php?id=$id&msg=succ");
	    
	}else{
	
	if($err_msg==""){
	    $err_msg.="Failed!!";}
	
	
	    header("location:floor_details_edit.php?id=$id&msg=err&err_msg=$err_msg");
 
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
			 <h1> Floor Details Edit <a href="floor_details_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
						Floor Details Edit
					 </h3>			
				 </div>  <!-- /.portlet-header -->	
                 <?php
				 $hf_id=$_GET["id"];
$book_query="select * from hms_floor  where hf_id='$hf_id' and status='0'";
$book_result=mysql_query($book_query);
$book_display=mysql_fetch_array($book_result);
?>		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Floor Details :</p>       
     
                            
<div class="col-sm-6">
  <div class="form-group">	
									<label for="validateSelect">Category<font color="red">*</font></label>
									<select name="category" class="form-control" data-required="true">
									<?php if($book_display["category"]==""){?><option value="" selected="selected" >Please Select</option><?php }?> <?php 
									$res=mysql_query("select * from hms_category");
									while($row=mysql_fetch_array($res))
									{
									
									?>
										 
										<option value="<?=stripslashes($row["h_id"]);?>" <?php if($book_display["category"]==$row["h_id"]){?>selected="selected" <?php }?> ><?=stripslashes($row["h_name"]);?></option>
									 <?php }?>
									</select>
								</div>
				            	 
             </div>                  
<div class="col-sm-6">
                                <div class="form-group">
									<label for="name">Floor Name<font color="red">*</font></label>
									<input type="text" id="f_name" value="<?=$book_display["floor_name"]?>" name="f_name" class="form-control" data-required="true">
								</div>
                                <!--<div class="form-group">
									<label for="name">Age</label>
									<input type="text" id="age" name="age" class="form-control" data-required="true">
								</div>-->
                              
								<input type="hidden" name="id" value="<?=$hf_id?>">
								 
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