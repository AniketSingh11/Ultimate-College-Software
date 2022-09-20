<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	 
	 $vt_id=$_POST['vid'];
	 $v_id=$_POST['v_id'];
     $start_km=trim($_POST['start_km']);
	 $end_km=trim($_POST['end_km']);
	 $fuel_fill=trim($_POST['fuel_fill']);
	 $fuel_amount=trim($_POST['fuel_amount']);
	 $r_id="";
	 foreach($_POST["r_id"] as $v)
	 {
	     $r_id.=$v.",";
	 }
	 $r_id=rtrim($r_id,",");
	 
	 $date=date("Y-m-d");
	 
	 
	 
	 $v_date=trim($_POST['v_date']);
	 $v_date = str_replace('/', '-', $v_date);
	 $v_date=date('Y-m-d', strtotime($v_date));
	
	 $qry=mysql_query("select * from vehicle_trip where v_id='$v_id' and v_date='$v_date' and vt_id!='$vt_id'");
	 
	 if(mysql_num_rows($qry)=="0")
	 {
		$sql="UPDATE vehicle_trip SET v_date='$v_date',start_km='$start_km',end_km='$end_km',fuel_fill='$fuel_fill',fuel_amount='$fuel_amount',r_id='$r_id' WHERE vt_id='$vt_id'";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:vehicle_tripedit.php?vid=$vt_id&msg=succ");
    }
    exit;
}else{
  header("Location:vehicle_tripedit.php?vid=$vt_id&msg=error");
}
}
 ?>
</head>

<body id="top">

  <!-- Begin of #container -->
  <div id="container">
  	<!-- Begin of #header -->
    <?php include("includes/header.php");?>
    <!--! end of #header -->
    
    <div class="fix-shadow-bottom-height"></div>
	
	<!-- Begin of Sidebar -->
    <aside id="sidebar">
    	
    	<!-- Search -->
    	    	<?php include("includes/search.php"); ?>
 <!--! end of #search-bar -->
		
		<!-- Begin of #login-details -->
		<?php include("includes/login-details.php");?>
         <!--! end of #login-details -->
    	
    	<!-- Begin of Navigation -->
    	<?php include("nav.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    	
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="vehicle_trip.php" title="Home">Vehicle Trip list</a></li>
                <li class="no-hover">Edit Vehicle Trip</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Vehicle Trip Details</h1>                
			<a href="vehicle_trip.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } ?>
             <?php  if($msg=="error"){?>			
            <div class="alert error"><span class="hide">x</span>This Vehicle Already Added for this date.. !!!</div>
            <?php } ?>
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Vehicle Trip Details</h1><span></span>
					</div>
                    <?php 
                    $vt_id=$_GET['vid'];
							$stafflist=mysql_query("SELECT * FROM vehicle_trip WHERE vt_id=$vt_id"); 
								  $row=mysql_fetch_array($stafflist);
								  $vid=$row['v_id'];
								  $rid=explode(",",$row['r_id']);
								  
								   ?>
					<form id="validate-form" class="block-content form" action="" method="post">
					
					 <div class="_50">
							<p>
								<label for="select">Vehicle No : <?php
                                	
                                	$vehiclelist=mysql_query("SELECT * FROM vehicle WHERE v_id=$vid");
                                	$vehicle=mysql_fetch_array($vehiclelist);
                                	echo $vehicle['v_no'];
                                           
                                            ?></label>
                                	
								</select>
							</p>
						</div>
						
							 <div class="_50">
							<p>
								<label for="select">Date: <span class="error">*</span></label>
                                	 
								   <input  id="datepicker" style="width:470px;" name="v_date"  class="required" type="text" value="<?php echo date("d/m/Y",strtotime($row['v_date']));?>" />
							</p>
						</div>
						 
						
                        <div class="_50">
							<p>
								<label for="select">Root master: <span class="error">*</span></label>
                                	<?php
                                            $classl = "SELECT * FROM route";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="r_id[]" style="width:400px;"  multiple="multiple" id="r_id" class="required">';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['r_id']}'>{$row1['r_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
								 
							</p>
						</div>
						
                        <div class="_50">
							<p>
								<label for="select">Today  Start Km: <span class="error">*</span></label>
                                	 
								   <input id="textfield" name="start_km" class="required" type="text" value="<?=$row['start_km']?>" />
							</p>
						</div>
							<div class="clear"></div>
						 <div class="_50">
							<p>
								<label for="select">Today  End Km: <span class="error">*</span></label>
                                	 
								   <input id="textfield" name="end_km" class="required" type="text" value="<?=$row['end_km']?>" />
							</p>
						</div>
						
						<div class="_50">
							<p>
								<label for="select">Fuel Filling Details:</label>
                                	 
								   <input id="textfield" name="fuel_fill"  type="text" value="<?=$row['fuel_fill']?>" />
							</p>
						</div>
						
						<div class="_50">
							<p>
								<label for="select">Amount:</label>
                                	 
								   <input id="textfield" name="fuel_amount"  type="text" value="<?=$row['fuel_amount']?>" />
							</p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
							 <input type="hidden" class="medium" name="v_id" value="<?php echo $vid;?>" >
                            <input type="hidden" class="medium" name="vid" value="<?php echo $_GET['vid'];?>" >
								<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
						
					</form>
				</div>
			</div>
            
            
            <div class="clear height-fix"></div>

		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
    <script defer src="js/zebra_datepicker.js"></script>
    
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		$( "#datepicker" ).Zebra_DatePicker({
	        format: 'd/m/Y'
	    });	
		$('.Zebra_DatePicker').css('top',  '200px');
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
	});
  </script>
  
      <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
      <link rel="stylesheet" href="payroll/js/plugins/select2/select2.css" type="text/css" />
  	  <script src="payroll/js/plugins/select2/select2.js"></script>  
      <script src="js/jquery-migrate-1.2.1.js"></script>
      <script type='text/javascript' src='js/plugins/multiselect/jquery.multi-select.min.js'></script>  
      <script type="text/javascript">
$().ready(function() {	

 $('#r_id').select2 ({
			allowClear: true,
			placeholder: "Please Select..."
		}) 

		
	$("#r_id").select2('val', [<?php for($i=0;$i<count($rid);$i++)
	{ ?> '<?=$rid[$i]?>',  <?php }?>]);
    
 
		
});

</script>
   
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>