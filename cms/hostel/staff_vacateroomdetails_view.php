 <?php
 include("header.php");?>
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
			 <h1>View Vacate staff Room Details  <a onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
					 <h3> View Vacate staff Room Details </h3>			
				 </div>  <!-- /.portlet-header -->	
                 <?php
                 
                  $hsr_id=$_GET["id"];
				 
		 $emp_query="select * from hms_staff_room  where 	hsr_id='$hsr_id' ";
			 $emp_result=mysql_query($emp_query);
			 $emp_count=1;
			 $emp_display=mysql_fetch_array($emp_result);
				 
		$hsr_id=$emp_display["hsr_id"];
			$hr_id=$emp_display["hr_id"];
			$hrc_id=$emp_display["hrc_id"];
			
			$status=$emp_display["status"];
			
			$staff_number=$emp_display["staff_id"];
			$firstname=$emp_display["firstname"];
			$lastname=$emp_display ["lastname"];
            $join_date=$emp_display["join_date"];	
            $vacate_date=$emp_display["vacate_date"];
            
            
			
			
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
   
?>		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
			 
				 <div class="portlet-content">
                      <p class="title">Room  Details :</p>       
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
									 <label for="value"> <?=$staff_number?></label>
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
									<label for="name">staff Name :</label>
									 <label for="value"> <?=$firstname." ".$lastname?> </label>
								</div>
							 
								
						 <input type="hidden"  name="id" value="<?=$hsr_id?>">
								  
								
								<div id="closed_status"   class="form-group">
									<label for="name">Vacate Date :
                                     <?=date("d/m/Y",strtotime($vacate_date))?> </label>
                                 </div>
                                 
                                  </div>
  			
  			
  			<div class="clear"></div>
                    <div class="col-sm-12">
                    <center>
<div class="form-group">
								 
								<a onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a>
								</div>
</center>
                    </div>
  			
  			
  			 </div>  <!-- /.portlet-content -->
  			 
              
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
	 $("#change_room").show();
	// $("#r_reason").val("");
	 $('#sel_book').select2("val", $('option:eq(0)').val());
	 $('#show_cart').hide();
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
		 
	 }else{
		 $('#show_cart').hide();

	 }
	 
  //this.value
})  
$('#sel_cart').select2 ({
	allowClear: true,
	placeholder: "Select..."
})

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