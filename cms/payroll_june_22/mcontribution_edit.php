 <?php
 
 include("header.php");
 
$syear=$_GET['syear'];
$eyear=$_GET['eyear'];
 $emp_result2=mysql_query("select ay_id from year where s_year='$syear' AND e_year='$eyear'");
		$accc=mysql_fetch_assoc($emp_result2);
		$ayid1=$accc['ay_id'];
		
$id=$_GET['id'];
		
 if(isset($_POST["submit"]))
{
	 $s_per_cent=mysql_real_escape_string($_POST["per_cent1"]);
	 $query="update staff_mcontribution set per_cent='$s_per_cent' where id='$id' ";
	$emp_result=mysql_query($query);
	if($emp_result)	
	{
		header("location:mcontribution_edit.php?id=$id&syear=$syear&eyear=$eyear&msg=succ");
	}		
	else
	{
		header("location:mcontribution_edit.php?id=$id&syear=$syear&eyear=$eyear&msg=err");
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
	   
	$emp_result=mysql_query("select * from staff_mcontribution where id='$id'");
	$contrib=mysql_fetch_array($emp_result);
	$percent=$contrib['per_cent'];
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1><?php echo $syear." - ".$eyear;?> Management Contribution Edit <a href="mcontribution.php?syear=<?php echo $syear.'&eyear='.$eyear;?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
										<option value="<?=$contrib['ad_id']?>"><?=$contrib['name']?></option>
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
		value: <?=$percent?>,
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
