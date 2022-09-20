 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
  
	$status=mysql_real_escape_string($_POST["status"]);
 
	$cdate=mysql_real_escape_string($_POST["c_date"]);
	$r_status=mysql_real_escape_string($_POST["r_status"]);
	
	$co=explode("/",$cdate);
	$c_date=$co[2]."-".$co[1]."-".$co[0];
	 
	$c_amount=mysql_real_escape_string($_POST["c_amount"]);
	
	$id=mysql_real_escape_string($_POST["id"]);
	
	$date=date("Y-m-d"); 
	
	$res=mysql_query("select * from lms_staff_borrowbook where sfb_id='$id'");
	$row=mysql_fetch_array($res);
	$book_id=$row["book_id"];
    $staff_id=$row["staff_id"];
    

	$res=mysql_query("select * from lms_book where b_id='$book_id'");
	$row=mysql_fetch_array($res);
	$avilable_qty=$row["avilable_qty"]+1;
	
	
	
   if($status!="" && $id!="")
	{
	    
 if($status=="no"){
     $qry=mysql_query("update lms_book set  avilable_qty='$avilable_qty' where b_id='$book_id'") or die(mysql_error());
   $qry=mysql_query("update lms_staff_borrowbook set return_date='$c_date',return_bookstatus='$r_status',status='1' where sfb_id='$id'") or die(mysql_error());
   
   header("location:staff_borrow_bookdetails_list.php?msg=succ");
 }elseif($status=="yes"){
	    
     $qty=$row["qty"]-1;
     $qry=mysql_query("update lms_book set  qty='$qty' where b_id='$book_id'") or die(mysql_error());
     
     $qry=mysql_query("update lms_staff_borrowbook set return_date='$c_date',return_bookstatus='$r_status',status='1',fine_amount='$c_amount',lost_bookstatus='1' where sfb_id='$id'") or die(mysql_error());
	     
	 $sql=mysql_query("INSERT INTO lms_lostbooks (book_id,person_type,type_id,closed_date,creation_date) values('$book_id','staff','$staff_id','$c_date','$date')") or die(mysql_error());

	 header("location:staff_borrow_bookdetails_list.php?msg=succ");
 }else{
      
      
  }

 
 
  }else{
      $err_msg="Failed!!";
      header("location:staff_borrow_bookdetails_edit.php?id=$id&msg=err&err_msg=$err_msg");
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
			 <h1> Borrow Book Details   closed <a onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
				   Staff Borrow Book Details closed
					 </h3>			
				 </div>  <!-- /.portlet-header -->	
                 <?php
                 
                 
                 
                 
                 
				 $s_id=$_GET["id"];
				 $emp_query="select * from lms_staff_borrowbook  where sfb_id='$s_id' ";
				 	
				 
				 $emp_result=mysql_query($emp_query);
				 $emp_count=1;
				  $emp_display=mysql_fetch_array($emp_result);
				 
				     $board=$emp_display["b_id"];
				     $sb_id=$emp_display["sb_id"];
				     $status=$emp_display["status"];
				     
				     $startdate=$emp_display["start_date"];
				 
				     $res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
				     $row=mysql_fetch_array($res);
				     $book_title=$row["book_title"];
				     $book_no=$row["book_no"];
				     	
				     $res=mysql_query("select * from staff where st_id='$emp_display[staff_id]'");
				     $row1=mysql_fetch_array($res);
				     $admission_number=$row1["staff_id"];
				     $firstname=$row1["fname"];
				     
				 
				     $st=explode("-",$startdate);
				     $end_date=$en[2]."/".$en[1]."/".$en[0];
				     $start_date=$st[2]."/".$st[1]."/".$st[0];
				 
				     $date=date("Y-m-d");
  
				    
				     
				   
				     $res=mysql_query("select * from lms_category where c_id='$row[category]' order by c_id desc");
				     $row3=mysql_fetch_array($res);
				     $category_name=$row3["category_name"];
?>		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				<?php if($status=="1"){ echo "<h1 style='color:red';>Book Already Closed</h1>";}else{?>
				 <div class="portlet-content">
                      <p class="title">Borrow  Details :</p>       
                      <div class="col-sm-6">
                                     <div class="form-group">
									<label for="name">Staff :</label>
									<label for="value"> <?=$admission_number."-".$firstname?></label>
								</div>

							 
				            	<div class="form-group">
									<label for="name">Book Titles :</label>
									 <label for="value"> <?=$book_title?></label>
								</div>
                                <div class="form-group">
									<label for="name">Author Name :</label>
									 <label for="value"> <?=$row["author_name"]?></label>
								</div>
                               
                                <div class="form-group">
									<label for="name">Edition :</label>
									 <label for="value"> <?=$row["edition"]?></label>
								</div>
								
								 <div class="form-group">
									<label for="name">From Date :</label>
									 <label for="value"> <?=$start_date?></label>
								</div>
                                
                              
							
								
								 
								<div class="form-group">
									<label for="name">Closed Date</label>
                                    <div class="input-group date ui-datepicker1 " style="width:35%">
									<input class="form-control txt" type="text" placeholder="Closed  date" name="c_date"   data-minlength="10"   data-maxlength="10"    id="cEnd" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-required="true"  >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>  
								
								<div class="form-group">
									<label for="name">Return Book Status:</label>
									 <textarea  data-required="true" id="r_bookstatus" name="r_status"   class="form-control"  type="text"></textarea>
								</div>
								 
								 
				            </div> 
				                             
                                   <div class="col-sm-6">
                                   

                                    <div class="form-group">	
									<label for="validateSelect">Book Category :</label>
									 <?php echo $category_name;?>
								</div>
                                <div class="form-group">
									<label for="name">Publisher :</label>
									 <label for="value"> <?=$row["publisher"]?></label>
								</div>
                                <!--<div class="form-group">
									<label for="name">Age</label>
									<input type="text" id="age" name="age" class="form-control" data-required="true">
								</div>-->
                                <div class="form-group">
									<label for="name">Book Number</label>
									 <?=$row["book_no"]?> 
								</div>
							 
								 <div class="form-group">
									<label for="name">Shelf No:</label>
									 <label for="value"> <?=$row["shelf_no"]?> </label>
								</div>
								
							 
								 
								<input type="hidden"  name="id" value="<?=$s_id?>">
								
								 
									
								<div class="form-group">
									<label for="name">Are you lost Book? :</label>
									<select name="status" id="status" onchange="status_report()" data-required="true"   class="required form-control">
									<option value="no" selected="selected">No</option>
									<option value="yes">Yes</option>
									</select>
									 
								</div>
								
								<div id="closed_status" style="display: none;" class="form-group">
									<label for="name">Penalty  Amount:</label>
									 <input  type="text" data-required="true" data-type="digits" id="c_amount" name="c_amount"  value="0"  class="form-control" >
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
  			 <?php }?>
              
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
<script>

 

 
function status_report()
{

//var c=$('input[name=status]').val();
var v=$("#status").val();
 
$("#closed_status").hide();

 
if(v=="no"){
	 $("#closed_status").hide();
 
}
if(v=="yes"){
$("#closed_status").show();
 
}

 

}
 
$('#dpEnd').datepicker({
   daysOfWeekDisabled: [0,0]
	//var d = new Date();
	//options["startDate"] = new Date(d.setDate(d.getDate() - 1));
});


$('#cEnd').datepicker({

	   daysOfWeekDisabled: [0,0]
		//var d = new Date();
		//options["startDate"] = new Date(d.setDate(d.getDate() - 1));
	});
 </script>

 <? ob_flush(); ?>