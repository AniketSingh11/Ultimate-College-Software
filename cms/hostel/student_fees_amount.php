 <?php
 include("header.php");
 if(isset($_POST["submit"]))
  {
 
	 
      $fid=mysql_real_escape_string($_POST["fid"]);
	$ay_id=mysql_real_escape_string($_POST["ay_id"]);
	
	$date=date("Y-m-d"); 
	
	$err_msg="";
 
	
 
	$res=mysql_query("select * from hms_room_type where status='0'");
	while($row=mysql_fetch_array($res))
	{
	    $room_type=stripslashes($row["room_type"]);
	    $hrt_id=stripslashes($row["hrt_id"]);
	    
	    $amount=mysql_real_escape_string($_POST["amount$hrt_id"]);
	    
	    if($amount==""){
	        $err_msg.="$room_type Field is Empty &nbsp;";
	        
	    }
	}
	 
	if($fid!="" && $ay_id!="" && $err_msg=="")
	{
	  
	    $res=mysql_query("select * from hms_room_type where status='0'");
	    while($row=mysql_fetch_array($res))
	    {
	    $hrt_id=stripslashes($row["hrt_id"]);
	    $amount=mysql_real_escape_string($_POST["amount$hrt_id"]);
	    
	    $qry1=mysql_query("select * from hms_feestype where  hfs_id='$fid' and room_type='$hrt_id'");
	    
	    if(mysql_num_rows($qry1)==0){
	        $query="insert into hms_feestype(hfs_id,room_type,amount,date) values('$fid','$hrt_id','$amount','$date')";
	        $result=mysql_query($query) or die(mysql_error());
	    }else{
	    $query="update hms_feestype set amount='$amount',date='$date' where hfs_id='$fid' and room_type='$hrt_id'";
	    $result=mysql_query($query) or die(mysql_error());
	    }
	    }
	  header("location:hostel_fees_amount_edit.php?msg=succ&id=$fid");
	    
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
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1>View Hostel Fees Details  <a href="hostel_fees_amount.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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


<?php 

$id=$_GET["id"];

$qry=mysql_fetch_array(mysql_query("select * from hms_feestype where hfs_id='$id'"));
$section=$qry["room_type"];


$qry1=mysql_fetch_array(mysql_query("select * from class where c_id='$section'"));
$c_name=$qry1["c_name"];

?>
				 <div class="portlet-header">			
					 <h3>						 
					View	Hostel Fees Details 
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
				 <div class="col-sm-6">
     <p class="title"> Academic Year :2014 - 2015 </p>     
       <p class="title"> Student Name :Siva </p>
       </div>
        <div class="col-sm-6">
     <p class="title"> Academic Year :2014 - 2015 </p>     
       <p class="title"> Standard :LKG - A </p>
       </div>
     <input type="hidden" name="ay_id" value="<?=$acyear?>">   
     <input type="hidden" name="fid" value="<?=$id?>"> 
                        <center><p class="title">Register Room Details</p> </center>  
                    <table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Fees Amount</center></th>
                                  	 
								 
									<th>Non A/C Room Amount</th>
									 <th><?=$room_type?> Cash Deposit</th>
                                   <th>Status</th>
								</tr>
							</thead>
                             <tbody>
                             <tr>
                        <td>1</td>
                        <td>Hostel Fees</td>
       
								 
                     <td>Rs.40000.00</td>
                     <td>Rs.5000.00</td>
                     <td><input type="checkbox">&nbsp;Paid</td>  
                     </tr>
                     
                        </tbody>
                        </table>
 
<div class="col-sm-6">
								<!--   <div class="form-group">	
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
                              </div> -->
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
</body>
</html>

 <? ob_flush(); ?>