<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$type=mysql_real_escape_string($_POST['l_type']);
	$from=mysql_real_escape_string($_POST['from']);
	$to=mysql_real_escape_string($_POST['to']);
	$date=mysql_real_escape_string($_POST['date']);
	$time=mysql_real_escape_string($_POST['time']);
	$descri=mysql_real_escape_string($_POST['descri']);
	$remark=mysql_real_escape_string($_POST['remark']);
	$mobile=mysql_real_escape_string($_POST['mobile']);
	$received=mysql_real_escape_string($_POST['received']);
		
 $sql="INSERT INTO courier (c_from,c_to,descri,date,time,mobile,received,remarks,ay_id,type) VALUES
('$from','$to','$descri','$date','$time','$mobile','$received','$remark','$acyear','$type')";
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        //header("Location:courier_add.php?msg=succ");
		$msg="succ";
    }else{
		 $msg="err";		
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
				<li class="no-hover"><a href="coureirs.php" title="NEWS Management">Couriers Management</a></li>
                <li class="no-hover">Add New Courier/Dispatches</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New Courier / Dispatches</h1>                
			<a href="coureirs.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php //$msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } else if($msg=="err"){?>			
            <div class="alert error"><span class="hide">x</span>Some Error On Your Data!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add New Courier / Dispatches</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_25">
							<p>
                                <label for="textfield">Select From <span class="error">*</span></label>
                                <select id="l_type" name="l_type" class="required">
                                    	<option value="">Plese select Form</option>
                                        <option value="1">Courier Form</option>
                                        <option value="2">Dispatches Form</option>
                                </select>
                            </p>
						</div>
                        <div id="test">
        						</div>
                       <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
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
    <link rel="stylesheet" type="text/css" href="src/jquery.ptTimeSelect.css" />
<script type="text/javascript" src="src/jquery.ptTimeSelect.js"></script>
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});				
	/*$('#time').ptTimeSelect();
	$('#time1').ptTimeSelect();
	
	$( "#datepicker" ).Zebra_DatePicker({
			format: 'd/m/Y'
		});	
	$( "#datepicker1" ).Zebra_DatePicker({
			format: 'd/m/Y'
		});	*/	
$("#l_type").change(function(){
        var thiss = $(this);
		var value = thiss.val(); 
		//alert(value);
        $.get("courier_calc.php",{value:value},function(data){
			$( "#test" ).html(data);
        });
    });	
	});
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachNEWS('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>