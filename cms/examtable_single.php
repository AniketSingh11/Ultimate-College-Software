<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$date=$_POST['date'];
	$day=$_POST['day'];
	$s_name=$_POST['s_name'];
	$time=$_POST['time'];
	$sid=$_POST['sid'];
	$cid=$_POST['cid'];
	$eid=$_POST['eid'];
	$bid=$_POST['bid'];
	
	
		$sql="INSERT INTO examtimetable (date,day,subject,time,c_id,s_id,e_id,b_id,ay_id) VALUES
('$date','$day','$s_name','$time','$cid','$sid','$eid','$bid','$acyear')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:examtable_single.php?cid=$cid&sid=$sid&eid=$eid&bid=$bid&msg=succ");
    }
    exit;
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
    				<?php 
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$eid=$_GET['eid'];
							
							$examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $bid=$_GET['bid'];
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_examtable.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="examtable_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&bid=<?php echo $bid;?>" title="Exam Time Table Management">Exam Time Table Management</a></li>
                <li class="no-hover">Add Exam Time Table </li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New <?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Exam Time Table </b></h1>                
			<a href="examtable_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your timetable Successfully Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add New <?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Exam Time Table</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_100">
							<p>
                                <label for="textfield">Date: <span class="error">*</span></label>
                                <input id="datepicker" name="date" class="required" type="text" value="" />
                            </p>
						</div>      
                        <div class="_50">
							<p>
								<label for="select">Day:</label>
                                <select name="day">
                                	            <option value='Monday'>Monday</option> 
                                                <option value='Tuesday'>Tuesday</option> 
                                                <option value='Wednesday'>Wednesday</option> 
                                                <option value='Thursday'>Thursday</option> 
                                                <option value='Friday'>Friday</option> 
                                                <option value='Saturday'>Saturday</option>                                           
								</select>
							</p>
						</div>                  
                        <div class="_100">
							<p>
                                <label for="textfield">Subject Name :<span class="error">*</span></label>
                                <input id="textfield" name="s_name" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_100">
							<p><label for="textarea">Timing : <span class="error">*</span></label>
                            <input id="textfield" name="time" class="required" type="text" value="" />
						</div>
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
                            <input type="hidden" class="medium" name="eid" value="<?php echo $_GET['eid'];?>" >
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >                            <li>							<input type="submit" name="submit" class="button" value="Submit"></li>
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
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });				
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