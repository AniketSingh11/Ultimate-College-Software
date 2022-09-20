<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
  $nid=$_GET['nid'];
 if (isset($_POST['submit']))
{
	
	$from=mysql_real_escape_string($_POST['from']);
	$to=mysql_real_escape_string($_POST['to']);
	$date=mysql_real_escape_string($_POST['date']);
	$time=mysql_real_escape_string($_POST['time']);
	$descri=mysql_real_escape_string($_POST['descri']);
	$remark=mysql_real_escape_string($_POST['remark']);
	$mobile=mysql_real_escape_string($_POST['mobile']);
	$received=mysql_real_escape_string($_POST['received']);
		
		$qry=mysql_query("UPDATE courier SET c_from='$from',c_to='$to',descri='$descri',date='$date',time='$time',mobile='$mobile',received='$received',remarks='$remarks' WHERE id='$nid'");
    if($qry){
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
                <li class="no-hover">Edit Courier/Dispatches</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Courier / Dispatches</h1>                
			<a href="coureirs.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php //$msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php } else if($msg=="err"){?>			
            <div class="alert error"><span class="hide">x</span>Some Error On Your Data!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Courier / Dispatches</h1><span></span>
					</div>
                    <?php 
							
							$classlist=mysql_query("SELECT * FROM courier WHERE id=$nid"); 
								  $class=mysql_fetch_array($classlist);
								  $type=$class['type'];
							?>
					<form id="validate-form" class="block-content form" action="" method="post">
                     <?php if($type =='1'){?>
                     	<div class="_25">
							<p>
                                <label for="textfield">Courier From <span class="error">*</span></label>
                                <input id="from" name="from" class="required" type="text" value="<?php echo $class['c_from']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Courier To <span class="error">*</span></label>
                                <input id="to" name="to" class="required" type="text" value="<?php echo $class['c_to']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date <span class="error">*</span></label>
                                <input id="datepicker" name="date" class="required" type="text" value="<?php echo $class['date']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Time <span class="error">*</span></label>
                                <input id="time" name="time" class="required" type="text" value="<?php echo $class['time']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Description</label>
                                <textarea id="descri" name="descri" rows="5" cols="40"><?php echo $class['descri']; ?></textarea>
                            </p>
						</div>
                        <div class="_50">
							<p>
                            <label for="textarea">Remarks: </label>
                            <textarea id="remark" name="remark" rows="5" cols="40"><?php echo $class['remarks']; ?></textarea>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Contact No </label>
                                <input id="mobile" name="mobile" type="text" value="<?php echo $class['mobile']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Received By <span class="error">*</span></label>
                                <input id="received" name="received" class="required" type="text" value="<?php echo $class['received']; ?>" />
                            </p>
						</div>
                     <?php } else if($type == '2'){ ?>
                     <div class="_25">
							<p>
                                <label for="textfield">Courier Dispatch From <span class="error">*</span></label>
                                <input id="from" name="from" class="required" type="text" value="<?php echo $class['c_from']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Courier Dispatch To <span class="error">*</span></label>
                                <input id="to" name="to" class="required" type="text" value="<?php echo $class['c_to']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date <span class="error">*</span></label>
                                <input id="datepicker1" name="date" class="required" type="text" value="<?php echo $class['date']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Time <span class="error">*</span></label>
                                <input id="time1" name="time" class="required" type="text" value="<?php echo $class['time']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Description</label>
                                <textarea id="descri" name="descri" rows="5" cols="40"><?php echo $class['descri']; ?></textarea>
                            </p>
						</div>
                        <div class="_50">
							<p>
                            <label for="textarea">Remarks: </label>
                            <textarea id="remark" name="remark" rows="5" cols="40"><?php echo $class['remarks']; ?></textarea>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Contact No </label>
                                <input id="mobile" name="mobile" type="text" value="<?php echo $class['mobile']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Received/dispatched By <span class="error">*</span></label>
                                <input id="received" name="received" class="required" type="text" value="<?php echo $class['received']; ?>" />
                            </p>
						</div>
                     <?php } ?>
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
	$('#time').ptTimeSelect();
	$('#time1').ptTimeSelect();
	
	$( "#datepicker" ).Zebra_DatePicker({
			format: 'd/m/Y'
		});	
	$( "#datepicker1" ).Zebra_DatePicker({
			format: 'd/m/Y'
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