 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
  

	$cart_value=mysql_real_escape_string($_POST["cart_value"]);
 
	$hrcid=mysql_real_escape_string($_POST["cid"]);
	$hrid=mysql_real_escape_string($_POST["id"]);
	//echo $room_number."-".$room_name."-".$num_bed."-".$id;
	
	$date=date("Y-m-d"); 
	
	 
	
  $err_msg="";
 
	$query="select * from hms_room_cart  where  cart_name='$cart_value' and hr_id='$hrid'  and status='0' and hrc_id!='$hrcid' ";
	$res=mysql_query($query) or die(mysql_error());
	$chk=0;
	while($row=mysql_fetch_array($res))
	{
	    $chk=1;
	    
	    $err_msg.="Beds/Cart Number Already Given &nbsp;";
	    
	}
 
 
	if( $cart_value!=""  && $hrcid!="" && $chk!="1" && $err_msg=="")
	{
	    
	   $qry=mysql_query("update hms_room_cart set cart_name='$cart_value' where hrc_id='$hrcid'");
	    $result=mysql_query($query);
	    
	 
	    
	    header("location:cart_details_edit.php?id=$hrid&cid=$hrcid&msg=succ");
	    
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
	   $hrc_id=$_GET["cid"];
	   $id=$_GET['id'];
	   $res=mysql_query("select * from hms_room where hr_id='$id'");
	   $row=mysql_fetch_array($res);
	   $room_name=$row["room_number"];
	    
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1> <?=$room_name?> - Beds/Cart Details Edit <a href="cart_details_list.php?id=<?=$id?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
    
 
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
						<?=$room_name?> - Beds/Cart Details Edit <a href="cart_details_add.php?id=<?=$id?>"><button type="button" class="btn btn-success">Add Beds/cart </button></a>
					 </h3>	
					 		
				 </div>  <!-- /.portlet-header -->	
                 <?php
				
$book_query="select * from hms_room  where hr_id='$id' and status='0'";
$book_result=mysql_query($book_query);
$room_display=mysql_fetch_array($book_result);
$cart_count=$room_display["no_cart"];

 
$qry2=mysql_query("select * from hms_room_cart where hrc_id='$hrc_id' ");
while($row2=mysql_fetch_array($qry2)){

    $cart_name=$row2["cart_name"];
    
   }

  
    
   
?>		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title"><?=$room_name?> - Beds/Cart Details :</p>       
 
          <div class="col-sm-6">
                                <div class="form-group">
									<label for="name">Beds/Cart <font color="red">*</font></label>
									<input type="text" id="cart_value" name="cart_value"   class="form-control" data-required="true"  value="<?=$cart_name?>" >
								</div>
                 <input type="hidden" name="cid" value="<?=$hrc_id?>">
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
 <script>
 
    //iterate through each textboxes and add keyup
    //handler to trigger sum event
 
 
 </script>
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


 </script>
</body>
</html>

 <? ob_flush(); ?>