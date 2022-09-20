 <?php 
 include("header.php");
 $s_id=$_GET["id"];
 if(isset($_POST["submit"]))
{
	 $s_type=mysql_real_escape_string($_POST["type"]);
	 $s_name=mysql_real_escape_string($_POST["name"]);
	 $s_per_cent=mysql_real_escape_string($_POST["per_cent1"]);
	 $s_descrip=mysql_real_escape_string($_POST["descrip"]);
	 $s_status=mysql_real_escape_string($_POST["status"]);
	
	 $emp_query="update staff_allw_ded set type='$s_type', name='$s_name', per_cent='$s_per_cent', descrip='$s_descrip', status='$s_status' where id='$s_id' ";
	$emp_result=mysql_query($emp_query);
	
	if($emp_result)	
	{
		if($s_type=="Allowance"){
		$emp_query5="select * from staff_allw_ded where type='Allowance' AND basic='0'";
										$emp_result5=mysql_query($emp_query5);
										while($emp_display5=mysql_fetch_array($emp_result5))
										{
											$value5+=$emp_display5['per_cent'];
										}
										$basicvalue=100-($value5);										
										$query1=mysql_query("update staff_allw_ded set per_cent='$basicvalue' where basic='1' AND type='Allowance'");
		}
		header("location:allw_ded_edit.php?id=$s_id&msg=succ");
	}		
	else
	{
		header("location:allw_ded_edit.php?id=$s_id&msg=err");
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
			 <h1> Allowance & Deduction Edit  <a href="allw_ded_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">

 <?php if($_GET["msg"] == 'err_img') { ?>
    <div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong>Please upload this type of File Format only jpeg, jpg, png, gif
			</div>
<?php } ?>
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Edited 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php } ?>

			 <div class="portlet">
			
				 <div class="portlet-header">
			
					 <h3> Edit Allowance or Deduction  </h3>
			
				 </div>  <!-- /.portlet-header -->
			
				 <div class="portlet-content">
			<?php
			
$emp_query="select * from staff_allw_ded where id='$s_id'";
$emp_result=mysql_query($emp_query);
$emp_display=mysql_fetch_array($emp_result);
?>
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data"  />
<div class="col-sm-6">
				            	 <div class="form-group">	
									<label for="validateSelect">Type</label>
									<select name="type" id="type" class="form-control" data-required="true" onchange="change_function()">
										<option value="">Please Select</option>
										<option value="Allowance" <?php if($emp_display["type"]=='Allowance'){ echo 'selected'; } ?>> Allowance </option>
										<option value="Deductions" <?php if($emp_display["type"]=='Deductions'){ echo 'selected'; } ?>> Deductions </option>
									</select>
								</div>
                                <div class="form-group">
									<label for="name">Percentage</label>
									<span id="rangeMinAmount1" style="border:0; color:#f6931f; font-weight:bold;"></span>							
                                <div id="rangeMinSlider1" class="slider-tertiary" style="margin-top: 1em;">
                                <input type="hidden" name="per_cent1" id="per_cent1" value=""/>
                                </div>
								</div>
                                <div class="form-group">	
									<label for="validateSelect">Status</label>
									<select name="status" id="status" class="form-control" data-required="true">
										<option value="0" <?php if($emp_display["status"]==0){ echo 'selected'; } ?>> Disable</option>
										<option value="1" <?php if($emp_display["status"]==1){ echo 'selected';}?>> Enable</option>
									</select>
								</div>
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" id="name" name="name" class="form-control" value="<?php echo $emp_display["name"] ; ?>" data-required="true">
								</div>
                                <div class="form-group">
								<label for="textarea-input">Description</label>
								<textarea name="descrip" id="textarea-input" cols="10" rows="3" class="form-control"><?php echo $emp_display["descrip"] ; ?></textarea>
								</div>
</div><div class="clear"></div>
<div class="col-sm-12">
                    <center>
<div class="form-group">
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
                                </div>
</form> 
				 </div>  <!-- /.portlet-content -->
			 </div>  <!-- /.portlet -->
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php
 include("footer.php");
 ?>
 <?php include("includes/script.php");?>
                                        
 <script type="text/javascript">
 function change_function() { 
      var ffromvalue =document.getElementById('type').value;
	  //alert(ffromvalue);
	  if(ffromvalue=="Allowance"){
		   <?php
										$emp_query3="select * from staff_allw_ded where type='Allowance' AND basic='0'";
										$emp_result3=mysql_query($emp_query3);
										while($emp_display3=mysql_fetch_array($emp_result3))
										{
											$value+=$emp_display3['per_cent'];
										}
										if($emp_display["type"]=='Allowance'){
										$rvalue=(100-$value)+$emp_display["per_cent"];
										}else{
											$rvalue=(100-$value);
										}
											
										?>
										$( "#rangeMinSlider1" ).slider({
		range: "min",
		value: <?php echo $emp_display["per_cent"] ; ?>,
		animate: true,
		min: 1,
		max: <?php echo $rvalue;?>,
		slide: function( event, ui ) {
			$( "#rangeMinAmount1" ).text ( ui.value+"%");
			fees = document.getElementById('per_cent1');
			fees.value = ui.value;
		}
	});
	$( "#rangeMinAmount1" ).text ( $( "#rangeMinSlider1" ).slider("value")+"%" );
	fees1 = document.getElementById('per_cent1');
	fees1.value = $( "#rangeMinSlider1" ).slider("value");
	  }
	  if(ffromvalue=="Deductions"){
		  <?php
										$emp_query4="select * from staff_allw_ded where type='Deductions' AND basic='0'";
										$emp_result4=mysql_query($emp_query4);
										while($emp_display4=mysql_fetch_array($emp_result4))
										{
											$value1+=$emp_display4['per_cent'];
										}
										if($emp_display["type"]=='Deductions'){
										$rvalue1=(100-$value1)+$emp_display["per_cent"];
										}else{
											$rvalue1=(100-$value1);
										}
										?>
										$( "#rangeMinSlider1" ).slider({
		range: "min",
		value: <?php echo $emp_display["per_cent"] ; ?>,
		animate: true,
		min: 1,
		max: <?php echo $rvalue1;?>,
		slide: function( event, ui ) {
			$( "#rangeMinAmount1" ).text ( ui.value+"%");
			fees = document.getElementById('per_cent1');
			fees.value = ui.value;
		}
	});
	$( "#rangeMinAmount1" ).text ( $( "#rangeMinSlider1" ).slider("value")+"%" );
	fees1 = document.getElementById('per_cent1');
	fees1.value = $( "#rangeMinSlider1" ).slider("value");
	  }
	   
}
$( "#rangeMinSlider1" ).slider({
		range: "min",
		value: <?php echo $emp_display["per_cent"] ; ?>,
		animate: true,
		min: 1,
		max: <?php if($emp_display["type"]=='Allowance'){ echo $rvalue; }else if($emp_display["type"]=='Deductions'){ echo $rvalue1; }else{ echo "100";} ?>,
		slide: function( event, ui ) {
			$( "#rangeMinAmount1" ).text ( ui.value+"%");
			fees = document.getElementById('per_cent1');
			fees.value = ui.value;
		}
	});
	$( "#rangeMinAmount1" ).text ( $( "#rangeMinSlider1" ).slider("value")+"%" );
	fees1 = document.getElementById('per_cent1');
	fees1.value = $( "#rangeMinSlider1" ).slider("value");
 
 </script>
 </body>
</html>

 <? ob_flush(); ?>
