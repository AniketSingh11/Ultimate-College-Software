 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {

   $category= mysql_real_escape_string($_POST["category"]);
	$floor=mysql_real_escape_string($_POST["floor"]);
	$room_number=mysql_real_escape_string($_POST["room_number"]);
	$room_name=mysql_real_escape_string($_POST["room_name"]);
	$num_bed=mysql_real_escape_string($_POST["num_bed"]);
	
	$r_type=mysql_real_escape_string($_POST["r_type"]);
	
	
    $date=date("Y-m-d"); 
	
    $cart_value=array();
    
    
    
   /* for($r=1;$r<=$num_bed;$r++)
    {
    $c_value=mysql_real_escape_string($_POST["cart_value$r"]);
    array_push($cart_value,$c_value);
    }
    $cvalue=join(",",$c_value);
  */
   
	$err_msg="";
 
	$query="select * from hms_room  where category='$category'  and room_number='$room_number'  and status='0'";
	$res=mysql_query($query) or die(mysql_error());
	$chk=0;
	while($row=mysql_fetch_array($res))
	{
	    $chk=1;
	    
	    $err_msg.="Room Number Already Given &nbsp;";
	    
	}

	 
	
	
	 
	
	if($category!="" && $floor!="" && $room_number!=""  && $num_bed!="" && $chk!="1" && $chk1!="1" )
	{
	    
	  $query="insert into hms_room(category,floor,room_number,room_name,room_type,no_cart,available_qty,date)
	    values('$category','$floor','$room_number','$room_name','$r_type','$num_bed','$num_bed','$date')";
	    $result=mysql_query($query);
	    
	    $last_id=mysql_insert_id();
	    for($r=1;$r<=$num_bed;$r++)
	    {
	    $c_value=mysql_real_escape_string($_POST["cart_value$r"]);
	    $query="insert into hms_room_cart(category,floor,hr_id,cart_name,date)
	    
	                values('$category','$floor','$last_id','$c_value','$date')";
	    $result=mysql_query($query);
	    }
	    
	     header("location:room_details_add.php?msg=succ");
	    
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
	   
	   $cart=array('','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	 
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1>Add  Room Details  <a href="room_details_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
					 <h3>Add Room Details  </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Room Details :</p>       
 
<div class="col-sm-6">

                            <div class="form-group">	
									<label for="validateSelect">Hostel Name<font color="red">*</font></label>
									<select name="category" class="form-control" onchange="sel_floor(this.value)" data-required="true">
									<option value="" <?php if($_POST["category"]==""){?>selected="selected" <?php }?>>Please Select</option> <?php 
									$res=mysql_query("select * from hms_category where status='0'");
									while($row=mysql_fetch_array($res))
									{
									
									?>
										 
										<option value="<?=stripslashes($row["h_id"]);?>" <?php if($_POST["category"]==$row["h_id"]){?>selected="selected" <?php }?> ><?=stripslashes($row["h_name"]);?></option>
									 <?php }?>
									</select>
								</div>
								
								
				            	<div class="form-group">
									<label for="name">Room Number<font color="red">*</font></label>
									<input type="text" id="room_number" name="room_number"   class="form-control" data-required="true"  value="<?=$_POST["room_number"]?>" >
								</div>
								
								  <div class="form-group">	
									<label for="validateSelect">Room Type<font color="red">*</font></label>
									<select name="r_type"  class="form-control"  data-required="true">
									<option value=''>Select</option>
									<?php 
									$res=mysql_query("select * from hms_room_type where status='0'");
									while($row=mysql_fetch_array($res))
									{
									$room_type=stripslashes($row["room_type"]);
									$hrt_id=stripslashes($row["hrt_id"]);
									?>
									<option value="<?=$hrt_id?>"><?=$room_type?></option>
									 <?php }?>
									
									</select>
                              </div>
                              
                              
                             
                            <?php for($i=1;$i<=20;$i++)
									{
									    if($i%2==1){
									 ?>
									  <div class="form-group show_cart" id="show_cart<?=$i?>" style="display: none;">
									<label for="name">Beds/cart <?=$i?><font color="red">*</font></label>
									<input type="text" id="cart_value<?=$i?>" value="<?=$cart["$i"]?>" name="cart_value<?=$i?>" class="form-control" data-required="true">
								     </div>
									 <?php } }?>
								
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
									<label for="validateSelect">Hostel Floor Name<font color="red">*</font></label>
									<select id="floor" name="floor" class="form-control" data-required="true">
									<option value="" <?php if($_POST["floor"]==""){?>selected="selected" <?php }?>>Please Select Floor</option> <?php 
									$res=mysql_query("select * from hms_floor where status='0'");
									while($row=mysql_fetch_array($res))
									{
									
									?>
										 
										<option  data_value='<?=stripslashes($row["category"]);?>' style='display: none;' value="<?=stripslashes($row["hf_id"]);?>" <?php if($_POST["floor"]==$row["hf_id"]){?>selected="selected" <?php }?> ><?=stripslashes($row["floor_name"]);?></option>
									 <?php } ?>
									</select>
								</div>
                                <div class="form-group">
									<label for="name">Room Name</label>
									<input type="text" id="room_name" value="<?=$_POST["room_name"]?>" name="room_name" class="form-control" >
								</div>
								
								    <div class="form-group">	
									<label for="validateSelect">No.of Beds/cart<font color="red">*</font></label>
									<select name="num_bed"  class="form-control" onchange=sel_cart(this.value)  data-required="true">
									<option value="" <?php if($_POST["num_bed"]==""){?>selected="selected" <?php }?>>Please Select</option> <?php 
									 for($i=1;$i<=20;$i++)
									{
									 ?>
									 <option value="<?=$i?>"><?=$i?></option>
									 <?php }?>
									</select>
								</div>
								
							<?php for($i=1;$i<=20;$i++)
									{
									    if($i%2==0){
									 ?>
									  <div class="form-group show_cart" id="show_cart<?=$i?>" style="display: none;">
									<label for="name">Beds/cart <?=$i?><font color="red">*</font></label>
									<input type="text" id="cart_value<?=$i?>" value="<?=$cart["$i"]?>" name="cart_value<?=$i?>" class="form-control" data-required="true">
								     </div>
									 <?php } }?>
                       
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