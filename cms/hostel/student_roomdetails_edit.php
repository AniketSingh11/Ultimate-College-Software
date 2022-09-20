 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
  
	$status=mysql_real_escape_string($_POST["status"]);
 
	$cdate=mysql_real_escape_string($_POST["c_date"]);
	$r_reason=mysql_real_escape_string($_POST["r_reason"]);
	
	$co=explode("/",$cdate);
	$c_date=$co[2]."-".$co[1]."-".$co[0];
	
    $sel_cart=mysql_real_escape_string($_POST["sel_cart"]);
	$sel_book=mysql_real_escape_string($_POST["sel_book"]);
	
	$id=mysql_real_escape_string($_POST["id"]);
	
	$c_amount=$_POST["c_amount"];
	$deposit=$_POST["deposit"];
	
	$date=date("Y-m-d"); 
	
	
	//echo $status."-".$sel_book."-".$sel_cart."-".$id."-".$cdate;
	

	$res=mysql_query("select * from hms_student_room where hsr_id='$id'");
	$row=mysql_fetch_array($res);
	$hr_id=$row["hr_id"];
    $hrc_id=$row["hrc_id"];
    $admission_number=$row["admission_number"];
    
    $res1=mysql_query("select * from hms_room where hr_id='$hr_id'");
    $row1=mysql_fetch_array($res1);
    $available_qty=$row1["available_qty"]+1;
    
    $err_msg="";
    
   
   if($status!="" && $id!="")
	{
	    
	
	//{
	    $qry1=mysql_query("select * from hms_student_changeroom where hsr_id='$id' and ay_id='$acyear' and payment_status='0'");
	    
	    $check_status=mysql_num_rows($qry1);
	    
	    if($check_status!=0)
	    {
	        $err_msg.="Pay Amount for Already Changed Pervious Room First, After  then Change New Room.. ";
	    }
	    
	    
 if($status=="no" && $sel_cart!="0" && $sel_book!="" && $check_status==0){
    $res1=mysql_query("select * from hms_room where hr_id='$sel_book'");
     $row1=mysql_fetch_array($res1);
     $category=$row1["category"];
     $floor=$row1["floor"];
     $new_available_qty=$row1["available_qty"];
   
   if($new_available_qty==0){
     
         $err_msg.="Room Is No Availability..  &nbsp;";
         header("location:student_roomdetails_edit.php?id=$id&msg=err&err_msg=$err_msg");
     }else{
         
     $new_available_qty=$new_available_qty-1;
     
     
     $qry=mysql_query("update hms_room set  available_qty='$available_qty' where hr_id='$hr_id'") or die(mysql_error());
      
     $qry=mysql_query("update hms_room_cart set room_status='0'  where 	hrc_id='$hrc_id'") or die(mysql_error());
         
     
     
     $qry=mysql_query("update hms_room set available_qty='$new_available_qty' where hr_id='$sel_book'");
      
     $qry=mysql_query("update hms_room_cart set room_status='1' where hrc_id='$sel_cart'");
     
     $qry=mysql_query("update hms_student_room set category='$category',floor='$floor',hr_id='$sel_book',hrc_id='$sel_cart',room_date='$date' where hsr_id='$id'") or die(mysql_error());

     if($c_amount!=""){
          
         
          $query="insert into hms_student_changeroom(hsr_id,category,floor,hr_id,hrc_id,admission_number,ay_id,join_date,amount,payment_status,payment_type,date)
                  values('$id','$category','$floor','$sel_book','$sel_cart','$admission_number','$acyear','$date','$c_amount','$deposit','$deposit','$date')";
          $result=mysql_query($query) or die(mysql_error());
          
          if($deposit==1){
              
              $qry=mysql_query("update hms_studentcash_amount set given_amount='$c_amount' where hsr_id='$id'");
           }else{
               $qry=mysql_query("update hms_studentcash_amount set given_amount='0' where hsr_id='$id'");
           }
          
     }
     
     
     $qry1=mysql_fetch_array(mysql_query("select * from hms_category where h_id='$category'"));
     $category_name=$qry1["h_name"];
     
     $qry1=mysql_fetch_array(mysql_query("select * from hms_floor where hf_id='$floor'"));
     $floor_name=$qry1["floor_name"];
     
     $qry1=mysql_fetch_array(mysql_query("select * from hms_room where hr_id='$sel_book'"));
     $room_name=$qry1["room_name"];
     $room_number=$qry1["room_number"];
     $room_type=$qry1["room_type"];
     
     
     $qry1=mysql_fetch_array(mysql_query("select * from hms_room_type where hrt_id='$room_type'"));
     
     $hms_room_type=$qry1["room_type"];
     
     $start_date=date("Y-m-d");
     
     $end_date=date("Y-m-d");
     
     $qry2=mysql_query("select * from hms_studentflow_room where reg_id='$id' order by hsfr_id desc");
     
     if(mysql_num_rows($qry2)!=0)
     {
        $res2=mysql_fetch_array($qry2);
         
         $hsfr_id=$res2["hsfr_id"];
         
         $qry=mysql_query("update hms_studentflow_room set end_date='$end_date' where hsfr_id='$hsfr_id'");
         
     }
     
    
     
     
     $query="insert into hms_studentflow_room(reg_id,role,hostel,floor,room_number,room_name,room_type,start_date,end_date,date)
     values('$id','RoomChange','$category_name','$floor_name','$room_number','$room_name','$hms_room_type','$start_date','','$date')";
     $result=mysql_query($query) or die(mysql_error());
     
     
     
    header("location:student_room_details.php?msg=succ");
     
     
     }
    // $qry=mysql_query("update hms_student_room set category='1',floor='$c_date', where hsr_id='$id'") or die(mysql_error());
     
   //  $qry=mysql_query("update hms_room set  available_qty='$available_qty' where hr_id='$hr_id'") or die(mysql_error());
  //   $qry=mysql_query("update hms_student_room set category='$category',floor='$floor',hr_id='$sel_book',hrc_id='$sel_cart'   where hsr_id='$id'") or die(mysql_error());
    
 
 }elseif($status=="yes"){
     $res=mysql_query("select * from hms_room where hr_id='$hr_id'");
     $row=mysql_fetch_array($res);
     
    
     
     $qry=mysql_query("update hms_student_room set status='1',vacate_date='$c_date',v_ay_id='$acyear' where hsr_id='$id'") or die(mysql_error());
     
     $qry=mysql_query("update hms_room set  available_qty='$available_qty' where hr_id='$hr_id'") or die(mysql_error());
     
     $qry=mysql_query("update hms_room_cart set  room_status='0'  where hrc_id='$hrc_id'") or die(mysql_error());
	     
     
     $qry=mysql_query("update hms_studentcash_amount  set vacate_date='$c_date',payment_status='1',v_ay_id='$acyear'  where hsr_id='$id'") or die(mysql_error());
     
     $end_date=date("Y-m-d");
      
     $qry2=mysql_query("select * from hms_studentflow_room where reg_id='$id' order by hsfr_id desc");
      
     if(mysql_num_rows($qry2)!=0)
     {
         $res2=mysql_fetch_array($qry2);
         $hsfr_id=$res2["hsfr_id"];
          
         $qry=mysql_query("update hms_studentflow_room set end_date='$c_date' where hsfr_id='$hsfr_id'");
          
     }
      
	
	 header("location:student_room_details.php?msg=succ");
 }else{
     $err_msg.="Failed!!";
     header("location:student_roomdetails_edit.php?id=$id&msg=err&err_msg=$err_msg");
  }

 
 
  }else{
      $err_msg.="Failed!!";
      header("location:student_roomdetails_edit.php?id=$id&msg=err&err_msg=$err_msg");
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
			 <h1>Edit Student Room Details  <a onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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

				 <h3> Edit Student Room Details </h3> </div>  <!-- /.portlet-header -->	
                 <?php
                 
                  $hsr_id=$_GET["id"];
				 
		 $emp_query="select * from hms_student_room  where 	hsr_id='$hsr_id' ";
			 $emp_result=mysql_query($emp_query);
			 $emp_count=1;
			 $emp_display=mysql_fetch_array($emp_result);
				 
		$hsr_id=$emp_display["hsr_id"];
			$hr_id=$emp_display["hr_id"];
			$hrc_id=$emp_display["hrc_id"];
			
			$status=$emp_display["status"];
			
			$student_number=$emp_display["admission_number"];
			$firstname=$emp_display["firstname"];
			$lastname=$emp_display ["lastname"];
            $join_date=$emp_display["join_date"];	
            
            $res=mysql_query("select * from student where admission_number='$student_number' order by ay_id desc");
            $row1=mysql_fetch_array($res);
             
			$c_id=$row1["c_id"];	
			$b_id=$row1["b_id"];	
			$s_id=$row1["s_id"];
			
			$query=mysql_query("SELECT * FROM class where c_id='$c_id'");
			$res=mysql_fetch_array($query);
			$class_name=$res["c_name"];
			 
			$query=mysql_query("SELECT * FROM section where s_id='$s_id'");
			$res=mysql_fetch_array($query);
			$section_name=$res["s_name"];
			
			
			$res=mysql_query("select * from hms_category where h_id='$emp_display[category]'");
			$row=mysql_fetch_array($res);
			$cat_name=$row["h_name"];
			
			
			$res=mysql_query("select * from hms_room where hr_id='$hr_id'");
			$row=mysql_fetch_array($res);
			$room_number=$row["room_number"];
			$floor=$row["floor"];
			
			$res=mysql_query("select * from hms_floor where hf_id='$floor'");
			$row=mysql_fetch_array($res);
			$floor_name=$row["floor_name"];
			
			
			
			$res=mysql_query("select * from hms_room_cart where hrc_id='$hrc_id'");
			$row=mysql_fetch_array($res);
			$cart_name=$row["cart_name"];
	       
			$date=date("Y-m-d");
			 
			$query1=mysql_query("select * from hms_studentflow_room where end_date!='' and reg_id='$hsr_id' order by hsfr_id asc");
?>		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				<?php if($status=="1"){ echo "<h1 style='color:red';>Student Details Closed</h1>";}else{?>
				 <div class="portlet-content">
                      <p class="title">Room  Details :</p>       
                      <?php if(mysql_num_rows($query1)!=0){?>
                      <p><a style="color:red;" href="#styledModal" data-toggle="modal">Already Changed <?php echo mysql_num_rows($query1); ?> Room</a></p>
                      <?php }?>
                      <div class="col-sm-6">
                                 <div class="form-group">
									<label for="name">Hostel Name :</label>
									<label for="value"> <?=$cat_name?></label>
								</div>

							   <div class="form-group">
									<label for="name">Room Number :</label>
									 <label for="value"> <?=$room_number?></label>
								</div>
								
                                <div class="form-group">
									<label for="name">Joining date :</label>
									 <label for="value"> <?=date("d/m/Y",strtotime($join_date))?></label>
								</div>
                               
                                <div class="form-group">
									<label for="name">Admission Number :</label>
									 <label for="value"> <?=$student_number?></label>
								</div>
								<div id="change_room">
								<div class="form-group">
									<label for="name">Select Room :</label>
									<select id="sel_book"   placeholder="Please select Book" name="sel_book" data-required="true" class="form-control" >
                                     <option value="">Select Room</option>	
                                        <?php 
										$emp_query="select * from hms_room where  available_qty!='0' and status='0' order by category asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
										    $category=$emp_display["category"];
										    $res=mysql_fetch_array(mysql_query("select * from hms_category where h_id=$category"));
										    $hostel_name=stripslashes($res["h_name"]);
										    
										    
											$floor=$emp_display["floor"];
											
											
											$res=mysql_fetch_array(mysql_query("select * from hms_floor where hf_id=$floor"));
											$floor_name=stripslashes($res["floor_name"]);
											
											$room_number=stripslashes($emp_display["room_number"]);
											$room_type=stripslashes($emp_display["room_type"]);
											$hr_id=stripslashes($emp_display["hr_id"]);
											
											$qry1=mysql_fetch_array(mysql_query("select * from hms_room_type where hrt_id='$room_type'"));
											$room_type=$qry1["room_type"];
											
											?>
                                        <option value="<?php echo $hr_id;?>"><?php echo $hostel_name." / ".$floor_name." / ".$room_number." ".$room_type; ?></option>
                                  <?php } ?>							
                            		</select>
								</div>  
								<div class="form-group" id="show_cart"  style="display:none;">
									<label for="name" style="width: 140px;">Select Beds/cart :</label>
									<select id="sel_cart"   placeholder="Please select Cart" name="sel_cart" data-required="true" class="form-control">
                                      <option value="0">Select Beds/cart</option>
                                       							
                            		</select>
								</div>  
							 	
							   <div class="form-group" id="cal_amnt" style="display:none;">
									<label for="name" >Balance Amount:</label>&nbsp; Rs.500
								</div>  
								
								 
								 
								<!--  <div class="form-group">
									<label for="name">Reason For Change Room:</label>
									 <textarea  data-required="true" id="r_reason" name="r_reason"   class="form-control"  type="text"></textarea>
								    </div>-->
								
								  </div> 
								 
				            </div> 
				                             
                                   <div class="col-sm-6">
                                   

                                    <div class="form-group">	
									<label for="validateSelect">Floor Name :</label>
									 <label for="value">  <?php echo $floor_name;?></label>
								</div>
                                <div class="form-group">
									<label for="name">Beds&cart :</label>
									 <label for="value"> <?=$cart_name?></label>
								</div>
                                <!--<div class="form-group">
									<label for="name">Age</label>
									<input type="text" id="age" name="age" class="form-control" data-required="true">
								</div>-->
                                <div class="form-group">
									<label for="name">Student Name :</label>
									 <label for="value"> <?=$firstname." ".$lastname?> </label>
								</div>
							 
								 <div class="form-group">
									<label for="name">Class -Section:</label>
									 <label for="value"> <?=$class_name."-".$section_name?> </label>
								</div>
								
						 <input type="hidden"  name="id" value="<?=$hsr_id?>">
								 <div class="form-group">
									<label for="name"> Select :</label>
									<select name="status" id="status" onchange="status_report()" data-required="true"   class="required form-control">
									<option value="no" selected="selected">Change Room</option>
									<option value="yes">Hostel Vacate</option>
									</select>
									 
								</div>
								
								<div id="closed_status" style="display: none;" class="form-group">
									<label for="name">Closed Date</label>
                                    <div class="input-group date ui-datepicker1 " style="width:35%">
									<input class="form-control txt" type="text" placeholder="Closed  date" name="c_date" value="<?=date("d/m/Y")?>"   data-minlength="10"   data-maxlength="10"    id="cEnd" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-required="true"  >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>		
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
  			 <?php } ?>
              
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 
 	<div id="styledModal" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title">Changing Room Details</h3>
      </div>
      <div class="modal-body">
     
        <table class="table"> 
					        <thead>
					          <tr>
					            <th width="5%">S.no</th>
					            <th>Hostel</th>
					            <th>Floor</th>
					            <th>Room</th>
					            <th>(From - To ) Date</th>
					          </tr>
					        </thead>
					        <tbody>
                             
                              <?php 
                              
                              $query1="select * from hms_studentflow_room where end_date!='' and reg_id='$hsr_id' order by 	hsfr_id asc";
                              $res1=mysql_query($query1);
                              $sr=0;
                              while($row1=mysql_fetch_array($res1))
                              {
                              $sr=$sr+1;
                              
                              ?>
                              <tr>
					            <td><?=$sr?></td>
					            <td><?php echo $row1["hostel"]; ?></td>
					            <td><?php echo $row1["floor"]; ?></td>
					            <td><?php echo $row1["room_number"]." ".$row1["room_type"]; ?></td>
					            <td><?php echo date("d/m/Y",strtotime($row1["start_date"]))." -To- ".date("d/m/Y",strtotime($row1["end_date"])); ?></td>
					          </tr>
					          <?php  }?>
					         
                              
					        </tbody>
					      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
 
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
	 $("#change_room").show();
	// $("#r_reason").val("");
	 $('#sel_book').select2("val", $('option:eq(0)').val());
	 $('#show_cart').hide();
	 $('#cal_amnt').hide(); 
}
if(v=="yes"){
$("#closed_status").show();
$("#change_room").hide();
//$("#r_reason").val("a");
$('#sel_book').select2("val", $('option:eq(1)').val());
//$('#sel_cart').select2("data", {  text: "Select" });
}

}

$('#sel_book').select2 ({
	allowClear: true,
	placeholder: "Select..."
	
}).on('change', function (e) {

	 var v=$('#sel_book').val();
	 
	 if(v!="")
	 {
		 $("#s2id_sel_cart .select2-chosen").text("Select");

		 var request =$.ajax({
		 	  
			    url: "ajax_roompayment_details.php",
			   // context: document.body
		 type: "POST",
		 data: {rid:v,hsr_id:<?=$hsr_id?>},
		 dataType: "html"
			  });
		 request.done(
		   		  
				    function(dataFromTheBackEnd) {

				        //$("#step3").css("display", "block");
					      $("#cal_amnt").html(dataFromTheBackEnd);
					      
					    }
						  
					  );
		 
		 var request =$.ajax({
		 	  
			    url: "ajax_room_details.php",
			   // context: document.body
		 type: "POST",
		 data: {rid:v},
		 dataType: "html"
			  });
		 request.done(
		   		  
				    function(dataFromTheBackEnd) {
					   // alert(dataFromTheBackEnd);
			 		 /* $('#configform')[0].reset(); form reset */
				 		 
				      // The data from the back end is passed to the callback as a parameter /
					     // $("#step1").css("display", "none");
					      //$("#step3").css("display", "block");
				      $("#sel_cart").html(dataFromTheBackEnd);
				      $('#sel_cart').select2("val", $('option:eq(1)').val());
				    }
					  
				  );
		 $('#show_cart').show();
		 $('#cal_amnt').show();  
	 }else{
		 $('#show_cart').hide();
		 $('#cal_amnt').hide(); 
	 }
	 
  //this.value
})  
$('#sel_cart').select2 ({
	allowClear: true,
	placeholder: "Select..."
})

$('#dpEnd').datepicker({
 //  daysOfWeekDisabled: [0,0]
	//var d = new Date();
	//options["startDate"] = new Date(d.setDate(d.getDate() - 1));
});


$('#cEnd').datepicker({

	   //daysOfWeekDisabled: [0,0]
		//var d = new Date();
		//options["startDate"] = new Date(d.setDate(d.getDate() - 1));
	
	});
 </script>

 <? ob_flush(); ?>