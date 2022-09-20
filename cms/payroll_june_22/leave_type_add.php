 <?php
 include("header.php");
  if(isset($_POST["submit"]))
  {
	$name= mysql_real_escape_string($_POST["name"]);
	$l_total= mysql_real_escape_string($_POST["l_total"]);
	
	$query="insert into leavetype(lt_name,l_total,status)values('$name','$l_total','1')";
	$result=mysql_query($query);	
	if($result)
	{
		header("location:leave_type_add.php?msg=succ");		
	}
	else
	{
		header("location:leave_type_add.php?msg=err");
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
			 <h1> Leave Type Add <a href="leave_type.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
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
				 <div class="portlet-header">			
					 <h3>						 
						Leave Type Add
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
<div class="col-sm-6">
				            	<div class="form-group">
									<label for="name">Leave Name</label>
									<input type="text" id="name" name="name" class="form-control" data-required="true">
								</div>
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">Yearly Total Leave : </label>
									<span id="rangeMinAmount1" style="border:0; color:#f6931f; font-weight:bold;"></span>							
                                <div id="rangeMinSlider1" class="slider-tertiary" style="margin-top: 1em;">
                                <input type="hidden" name="l_total" id="per_cent1" value=""/>
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
  			 </div>            
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php
 include("footer.php");
 include("includes/script.php");?>
 <script type="text/javascript">
 $( "#rangeMinSlider1" ).slider({
		range: "min",
		value: 0,
		animate: true,
		min: 0,
		max: 25,
		slide: function( event, ui ) {
			$( "#rangeMinAmount1" ).text ( ui.value+" Days");
			fees = document.getElementById('per_cent1');
			fees.value = ui.value;
		}
	});
	$( "#rangeMinAmount1" ).text ( $( "#rangeMinSlider1" ).slider("value")+" Days" );
	fees1 = document.getElementById('per_cent1');
	fees1.value = $( "#rangeMinSlider1" ).slider("value");
 </script>
 
</body>
</html>

 <? ob_flush(); ?>