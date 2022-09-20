 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {

   $cart_value=mysql_real_escape_string($_POST["cart_value"]);
 
	$hrid=mysql_real_escape_string($_POST["id"]);

      $date=date("Y-m-d"); 
	
     
    $err_msg="";
 
	$query="select * from hms_room_cart  where  cart_name='$cart_value' and hr_id='$hrid'  and status='0' ";
	$res=mysql_query($query) or die(mysql_error());
	$chk=0;
	while($row=mysql_fetch_array($res))
	{
	    $chk=1;
	    
	    $err_msg.="Beds/Cart Number Already Given &nbsp;";
	    
	}
	
	$res=mysql_query("select * from hms_room where hr_id='$hrid'");
	$row=mysql_fetch_array($res);
    $no_cart=$row["no_cart"];
	$category=$row["category"];
	$floor=$row["floor"];
	$available_qty=$row["available_qty"];
	$no_cart=$no_cart+1;
	$available_qty=$available_qty+1;
	if( $cart_value!=""  && $chk!="1" && $err_msg=="")
	{
	    
	    $query="insert into hms_room_cart(category,floor,hr_id,cart_name,date)
	                  values('$category','$floor','$hrid','$cart_value','$date')";
	    $result=mysql_query($query);
	    
	   $qry=mysql_query("update hms_room set no_cart='$no_cart',available_qty='$available_qty' where hr_id='$hrid'");
	    $result=mysql_query($query);
	    
	 
	    
	    header("location:cart_details_add.php?id=$hrid&msg=succ");
	    
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
	   $id=$_GET['id'];
	   $res=mysql_query("select * from hms_room where hr_id='$id'");
	   $row=mysql_fetch_array($res);
	   $room_name=$row["room_number"];
	   $rno=$row["room_number"];
	   $rname=$row["room_name"];
	   $category=$row["category"];
	   $floor=$row["floor"];
	   
	   $cart=array('','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	 
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1>Add <?=$room_name?>   Beds/cart Details  <a onclick="history.go(-1)"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
  
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong> Your Record Successfully Inserted 
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
					Add	<?=$room_name?>  Beds/cart Details 
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title"><?=$room_name?>  Beds/cart Details :</p>       
 
<div class="col-sm-6">

                            <div class="form-group">	
									<label for="validateSelect">Hostel Name :</label>
									
									 <?php 
									$res=mysql_query("select * from hms_category where h_id=$category");
									$row=mysql_fetch_array($res);
									?>
									<b><?=stripslashes($row["h_name"]);?></b>
									 
									 
								</div>
				            	<div class="form-group">
									<label for="name">Room Number:</label>
									<b><?=$rno?></b>
								</div>
                              
                         <div class="form-group">
									<label for="name">Beds/cart Name/Number<font color="red">*</font></label>
									<input type="text" id="cart_value" name="cart_value" class="form-control" data-required="true">
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
									<label for="validateSelect">Hostel Floor Name:</label>
									<?php 
									$res=mysql_query("select * from hms_floor where hf_id='$floor'");
									$row=mysql_fetch_array($res);
                                          ?>
										 
										<b><?=stripslashes($row["floor_name"]);?></b>
                                    </div>
                                <div class="form-group">
									<label for="name">Room Name:</label>
									<b><?=$rname?></b>
								</div>
								
						  <input type="hidden" name="id" value="<?=$id?>">
                               
								
								 
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
 <script>
function sel_floor(n)
{
	$("#floor option[data_value]").hide();
 $("#floor option[data_value="+n+"]").show();
 $("#floor").prop('selectedIndex',0);
}

function sel_cart(n)
{
	$(".show_cart").hide();
	for (i = 1; i <= n; i++) { 

		
		$("#show_cart"+i).show();
		
	}
}

 </script>
 
</body>
</html>

 <? ob_flush(); ?>