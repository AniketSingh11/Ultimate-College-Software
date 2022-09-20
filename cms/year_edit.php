<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$syear=$_POST['syear'];
	$eyear=$_POST['eyear'];
	$yname=$_POST['yname'];
	$ayid=$_POST['ayid'];
	$lastyearname=$_POST['lastyearname'];
	
	if($yname !=$lastyearname){
	  $yearlist=mysql_query("SELECT * FROM year WHERE y_name='$yname'"); 
	  $year1=mysql_fetch_array($yearlist);	  
	  if($year1){
		  header("Location:year_edit.php?ayid=$ayid&msg=aerr");
	  }else{
		$qry=mysql_query("UPDATE year SET y_name='$yname',s_year='$syear',e_year='$eyear' WHERE ay_id='$ayid'");
    if($qry){
        header("Location:year_edit.php?ayid=$ayid&msg=succ");
    }
    exit;
	  }
	}else{
		$qry=mysql_query("UPDATE year SET y_name='$yname',s_year='$syear',e_year='$eyear' WHERE ay_id='$ayid'");
    if($qry){
        header("Location:year_edit.php?ayid=$ayid&msg=succ");
    }
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
				<li class="no-hover"><a href="year.php" title="Academic Year">Academic Year list</a></li>
                <li class="no-hover">Edit Acadamic Year</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Acadamic Year</h1>                
			<a href="year.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php }			 
			if($msg=="aerr"){?>			
            <div class="alert error"><span class="hide">x</span>This Academic Year Already Added!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Academic Year</h1><span></span>
					</div>
                    <?php 
							$ayid=$_GET['ayid'];
							$classlist=mysql_query("SELECT * FROM year WHERE ay_id=$ayid"); 
								  $class=mysql_fetch_array($classlist);	
								  $e_syear=$class['s_year'];
							?>
					<form id="validate-form" class="block-content form" action="" method="post">
						<?php 
						$startyearlist=mysql_query("SELECT s_year FROM year order by s_year asc");
						$startyear=mysql_fetch_array($startyearlist);
						$styear=$startyear['s_year']-1;
						$endyearlist=mysql_query("SELECT e_year FROM year order by e_year desc");
						$endyear=mysql_fetch_array($endyearlist);
						$edyear=$endyear['e_year'];
						?>
						<div class="_25">
							<p>
								<label for="select">Start Year</label>
								<select class="required" name="syear" id="syear" onchange="change_year()">
									<option value="">Please Select Year</option>
                                    <?php for($i=$edyear;$i>=$styear;$i--){
										if($e_syear==$i){?>
									<option value="<?php echo $i;?>" selected><?php echo $i;?></option>
                                    <?php } else{ ?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php } }?>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">End Year</label>
								<input name="eyear" id="eyear" type="text" value="<?php echo $class['e_year']; ?>" readonly class="required" />
							</p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Academic Year</label>
                                <input name="yname" id="yname" type="text" value="<?php echo $class['y_name']; ?>" readonly class="required"/>
                            </p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="ayid" value="<?php echo $ayid;?>" > 
                            <input type="hidden" class="medium" name="lastyearname" value="<?php echo $class['y_name'];?>" > 
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
  
  <!-- end scripts-->
<script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
	});
	function change_year() { 	
      var syear = parseInt(document.getElementById('syear').value);
	  if(syear>1){
		  var eyearvalue = syear+1;		  
		  var ynamevalue = syear+"-"+eyearvalue;		  
	  }
	  eyear = document.getElementById('eyear');
	  eyear.value = eyearvalue;
	  yname = document.getElementById('yname');	  
	  yname.value = ynamevalue;
}
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