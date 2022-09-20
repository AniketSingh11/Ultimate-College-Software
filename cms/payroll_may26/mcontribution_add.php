 <?php
 
 include("header.php");
 
$syear=$_GET['syear'];
$eyear=$_GET['eyear'];
 $emp_result2=mysql_query("select ay_id from year where s_year='$syear' AND e_year='$eyear'");
		$accc=mysql_fetch_assoc($emp_result2);
		$ayid1=$accc['ay_id'];
 if(isset($_POST["submit"]))
{
	 $ad_id=mysql_real_escape_string($_POST["ad_id"]);
		$emp_result1=mysql_query("select name from staff_allw_ded where id='$ad_id'");
		$staff1=mysql_fetch_assoc($emp_result1);
		$name=$staff1['name'];
	 $s_per_cent=mysql_real_escape_string($_POST["per_cent1"]);
	$emp_query="insert into staff_mcontribution(ad_id,name,per_cent,ay_id)values('$ad_id','$name','$s_per_cent','$ayid1')";
	$emp_result=mysql_query($emp_query);
	if($emp_result)	
	{
		header("location:mcontribution_add.php?syear=$syear&eyear=$eyear&msg=succ");
	}		
	else
	{
		header("location:mcontribution_add.php?syear=$syear&eyear=$eyear&msg=err");
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
			 <h1><?php echo $syear." - ".$eyear;?> Management Contribution New <a href="mcontribution.php?syear=<?php echo $syear.'&eyear='.$eyear;?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->
		 <div id="content-container">
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Inserted 
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
					 <h3><?php echo $syear." - ".$eyear;?> Management Contribution New</h3>			
				 </div>  <!-- /.portlet-header -->
			
				 <div class="portlet-content">
			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data"  />
<div class="col-sm-6">
				            	 <div class="form-group">	
									<label for="validateSelect">Type</label>
									<select name="ad_id" id="ad_id" class="form-control" data-required="true" onchange="change_function()">
										<option value="">Please Select</option>
                                        <?php 
										$emp_result5=mysql_query("select id,name from staff_allw_ded where pe_type!='0' ");
										while($emp_display5=mysql_fetch_assoc($emp_result5))
										{ 
										$id=$emp_display5['id'];
											$checkcount=0;
											$emp_result6=mysql_query("select id from staff_mcontribution where ad_id=$id AND ay_id=$ayid1");
											$checkcount=mysql_num_rows($emp_result6);
										if($checkcount==0){
										?>
										<option value="<?=$emp_display5['id']?>"><?=$emp_display5['name']?></option>
                                        <?php } } ?>
									</select>
								</div>
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">Percentage</label>
									<span id="rangeMinAmount1" style="border:0; color:#f6931f; font-weight:bold;"></span>							
                                <div id="rangeMinSlider1" class="slider-tertiary" style="margin-top: 1em;">
                                <input type="hidden" name="per_cent1" id="per_cent1" value=""/>
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
$( "#rangeMinSlider1" ).slider({
		range: "min",
		value: 1,
		animate: true,
		min: 1,
		max: 50,
		step: 0.25,
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
