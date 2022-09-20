 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
  
	$room_number=mysql_real_escape_string($_POST["room_number"]);
	$room_name=mysql_real_escape_string($_POST["room_name"]);
	$r_type=mysql_real_escape_string($_POST["r_type"]);
	
	$num_bed=mysql_real_escape_string($_POST["num_bed"]);
	$id=mysql_real_escape_string($_POST["id"]);
	
	//echo $room_number."-".$room_name."-".$num_bed."-".$id;
	
	$date=date("Y-m-d"); 
	
	$qry1=mysql_query("select * from hms_room  where hr_id='$id'");
	$res1=mysql_fetch_array($qry1);
    
	$category=$res1["category"];
 
	
  $err_msg="";
 
	$query="select * from hms_room  where  category='$category' and  room_number='$room_number'  and status='0' and hr_id!='$id' ";
	$res=mysql_query($query) or die(mysql_error());
	$chk=0;
	while($row=mysql_fetch_array($res))
	{
	    $chk=1;
	    
	    $err_msg.="Room Number Already Given &nbsp;";
	    
	}

	

	if( $room_number!="" && $chk!="1" && $err_msg=="")
	{
	    
	   $qry=mysql_query("update hms_room set room_number='$room_number',room_name='$room_name',room_type='$r_type' where hr_id='$id'");
	    $result=mysql_query($query);
       header("location:room_details_edit.php?id=$id&msg=succ");
	    
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
	   $hr_id=$_GET["id"];
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1> Room Details Edit <a href="room_details_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
    
 <?php  ?>	

 
 <?php if($_SERVER["REQUEST_METHOD"]=="POST") { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> <?php echo $err_msg;?>!!
			</div>
<?php }else{ 
    if($_GET["msg"] == 'succ') {
    ?>

 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong> Your Record Successfully Updated 
			</div>	

<?php } }?>
				 <div class="portlet-header">			
					 <h3>						 
						Room Details Edit <a href="cart_details_list.php?id=<?=$hr_id?>"><button type="button" class="btn btn-success">Edit Beds/cart List</button></a>
					 </h3>	
					 		
				 </div>  <!-- /.portlet-header -->	
                 <?php
				
$book_query="select * from hms_room  where hr_id='$hr_id' and status='0'";
$book_result=mysql_query($book_query);
$room_display=mysql_fetch_array($book_result);
$cart_count=$room_display["no_cart"];
$room_type=$room_display["room_type"];
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
									<label for="validateSelect">Room Type<font color="red">*</font></label>
									<select name="r_type"  class="form-control"  data-required="true">
									<option value=''>Select</option>
									<?php 
									$res=mysql_query("select * from hms_room_type where status='0'");
									while($row=mysql_fetch_array($res))
									{
									$r_type=stripslashes($row["room_type"]);
									$hrt_id=stripslashes($row["hrt_id"]);
									?>
									<option value="<?=$hrt_id?>" <?php if($room_type==$hrt_id){ echo "selected"; }?>><?=$r_type?></option>
									 <?php }?>
									
									</select>
                              </div>
                           
									 <input type="hidden" name="id" value="<?=$hr_id?>">
							
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