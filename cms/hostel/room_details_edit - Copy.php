 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
  
	$room_number=mysql_real_escape_string($_POST["room_number"]);
	$room_name=mysql_real_escape_string($_POST["room_name"]);
	$num_bed=mysql_real_escape_string($_POST["num_bed"]);
	$id=mysql_real_escape_string($_POST["id"]);
	
	//echo $room_number."-".$room_name."-".$num_bed."-".$id;
	
	$date=date("Y-m-d"); 
	
	$cart_value=array();
	
 for($r=1;$r<=$num_bed;$r++)
	 {
	 $c_value=mysql_real_escape_string($_POST["cart_value$r"]);
	 array_push($cart_value,$c_value);
	 }
	 $cvalue=join(",",$cart_value);
	 $cart_val=array_unique($cart_value);
	 
 
	
  $err_msg="";
 
	$query="select * from hms_room  where  room_number='$room_number'  and status='0' and hr_id!='$id' ";
	$res=mysql_query($query) or die(mysql_error());
	$chk=0;
	while($row=mysql_fetch_array($res))
	{
	    $chk=1;
	    
	    $err_msg.="Room Number Already Given &nbsp;";
	    
	}
//echo $num_bed."-".$cart_val;
if($num_bed!=count($cart_val)){
    
    $err_msg.="Bed/Cart Number Already Given &nbsp;";
}

	

	 
	$qry1=mysql_fetch_array(mysql_query("select * from hms_room where hr_id='$id'"));
	
	$category=$qry1["category"];
	$floor=$qry1["floor"];
	 
	
	
	
	
	if( $room_number!=""  && $num_bed!="" && $chk!="1" && $err_msg=="")
	{
	    
	   $qry=mysql_query("update hms_room set room_number='$room_number',room_name='$room_name',no_cart='$num_bed' where hr_id='$id'");
	    $result=mysql_query($query);
	    
	    
	    $query="select * from hms_room_cart  where  hr_id='$id'";
	    $res=mysql_query($query) or die(mysql_error());
	   $h=1;
	    while($row=mysql_fetch_array($res))
	    {
	     $hrc_id=$row["hrc_id"];   
	     
	    
	     $c_value=mysql_real_escape_string($_POST["cart_value$h"]);
	     $qry=mysql_query("update hms_room_cart set cart_name='$c_value' where hrc_id='$hrc_id'");
	     $result=mysql_query($query);
	     $h=$h+1;
	    }
	    
	  
	    for($r=$h;$r<=$num_bed;$r++)
	    {
	    $c_value=mysql_real_escape_string($_POST["cart_value$r"]);
	  
	    $query="insert into hms_room_cart(category,floor,hr_id,cart_name,date)
	    
	                values('$category','$floor','$id','$c_value','$date')";
	    $result=mysql_query($query);
	   
	    
	    }
	    
	     header("location:room_details_edit.php?msg=succ");
	    
	}else{
	
	if($err_msg==""){
	    $err_msg.="Failed!!";}
  //  header("location:book_details_add.php?msg=err&err_msg=$err_msg");
 
  }
	
	
	    //header("location:room_details_edit.php?id=$id&msg=err&err_msg=$err_msg");
	    

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
			 <h1> Room Details Edit <a href="book_details_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
    
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong> Your Record Successfully Updated 
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
						Room Details Edit
					 </h3>			
				 </div>  <!-- /.portlet-header -->	
                 <?php
				 $hr_id=$_GET["id"];
$book_query="select * from hms_room  where hr_id='$hr_id' and status='0'";
$book_result=mysql_query($book_query);
$room_display=mysql_fetch_array($book_result);
$cart_count=$room_display["no_cart"];

$cart1=array('');
$qry2=mysql_query("select * from hms_room_cart where hr_id='$hr_id'  and status='0' ");
while($row2=mysql_fetch_array($qry2)){

    $cart_name=$row2["cart_name"];
    
    array_push($cart1,$cart_name);
    
    }
    $cart2=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    
    $result=array_merge($cart1,$cart2);
    
    $result_unique=array_unique($result);
     
    $cart=array();
    foreach ($result_unique as $val){
        array_push($cart,$val);
        
    }
  
    
   
?>		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Room Details :</p>       
 
<div class="col-sm-6">

                            <div class="form-group">	
									<label for="validateSelect">Hostel Name :</label>
						<?php 
						$qry1=mysql_fetch_array(mysql_query("select * from hms_category where h_id='$room_display[category]'"));
						       
						?>	  <?=stripslashes($qry1["h_name"]);?> 
									  
									 
								</div>
				            	<div class="form-group">
									<label for="name">Room Number<font color="red">*</font></label>
									<input type="text" id="room_number" name="room_number"   class="form-control" data-required="true"  value="<?=$room_display["room_number"]?>" >
								</div>
                              
                                 <div class="form-group">	
									<label for="validateSelect">No.of Beds/cart<font color="red">*</font></label>
									<select name="num_bed"  class="form-control" onchange=sel_cart(this.value)  data-required="true">
									<?php if($room_display["no_cart"]==""){?><option value="" selected="selected" >Please Select</option><?php }?> <?php 
									 for($i=$cart_count;$i<=20;$i++)
									{
									 ?>
									 <option value="<?=$i?>" <?php if($room_display["no_cart"]==$i){ echo "selected"; }?>><?=$i?></option>
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
									 <?php } } ?>
									 <input type="hidden" name="id" value="<?=$hr_id?>">
								
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
									<label for="validateSelect">Hostel Floor Name :</label>
							 	<?php	$res=mysql_query("select * from hms_floor where hf_id=$room_display[floor]");
									 $row=mysql_fetch_array($res);
								 ?><?=stripslashes($row["floor_name"]);?>
                                </div>
                                <div class="form-group">
									<label for="name">Room Name</label>
									<input type="text" id="room_name" value="<?=$room_display["room_name"]?>" name="room_name" class="form-control" >
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
                                <!--<div class="form-group">
									<label for="name">Age</label>
									<input type="text" id="age" name="age" class="form-control" data-required="true">
								</div>-->
                              
								
								
								<!--  
                                <div class="form-group">	
									<label for="validateSelect">Marital Status</label>
									<select name="marital" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Single">Single</option>
										<option value="Married">Married</option>
                                        <option value="Widow">Widow</option>
									</select>
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Staff Type</label>
									<select name="staff_type" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Teaching">Teaching</option>
										<option value="Non-Teaching">Non-Teaching</option>
									</select>
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Job Type</label>
									<select name="job_type" class="form-control" data-required="true">
										<option value="">Please Select</option>
										<option value="Permanent">Permanent</option>
										<option value="Temporary">Temporary</option>
									</select>
								</div>
                                <div class="form-group">
								<label for="textarea-input">Permanent Address</label>
								<textarea name="address1" id="textarea-input" cols="10" rows="3" class="form-control" data-required="true"></textarea>
								</div>
                                <div class="form-group">
									<label for="name">State </label>
									<input type="text" id="state" name="state" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Email ID </label>
									<input type="email" id="email" name="email" class="form-control" data-required="true">
								</div>
                                <div class="form-group">
									<label for="name">Phone No</label>
									<input type="text" id="phone" name="phone" class="form-control" data-required="true">
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Transport</label>
									<select name="transport" class="form-control">
										<option value="">Select Transport</option>
										<option value="0">Regular Bus</option>
                                            <option value="1">Sp.Bus</option>
                                            <option value="2">Onetime Sp.Bus</option>	
									</select>
								</div>-->
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
 <script>
 
    //iterate through each textboxes and add keyup
    //handler to trigger sum event
 
 
 </script>
 <?php 
 include("footer.php"); 
 ?>
 <?php include("includes/script.php");?>
 <script>
 $(document).ready(function(){ 
     //iterate through each textboxes and add keyup
     //handler to trigger sum event
 
	 for (i = 1; i <= <?=$room_display["no_cart"]?>; i++) { 
		 
			
			$("#show_cart"+i).show();
			
		}
 });
	

 
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

		//$("#cart_value"+i).show();
		$("#show_cart"+i).show();
		if(i><?=$room_display["no_cart"]?>){
		 $("#cart_value"+i).val("");
		}
		
	}
	for (i = n; i <=20; i++) { 
if(i><?=$room_display["no_cart"]?> && i!=n){
		 $("#cart_value"+i).val(i);
}
		 
		
	}
}

 </script>
</body>
</html>

 <? ob_flush(); ?>