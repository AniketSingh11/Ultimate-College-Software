<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top1.php"); 
 //echo $_SESSION['uname'];
 //echo $acyear;
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
    	<?php include("nav1.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    <?php 
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard1.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="sboard_select_exam.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Select Your Class</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<a href="sboard_select_exam.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Exam</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get">
                    <div class="_100">
							<p>
								<label for="select">Exam : <span class="error">*</span></label>
                                	<?php
                                            $classl1 = "SELECT e_id,e_name FROM exam where ay_id=$acyear";
                                            $result11 = mysql_query($classl1) or die(mysql_error());
                                            echo '<select name="eid" id="eid" class="required"> <option value="">Select Exam</option>';
											while ($row11 = mysql_fetch_assoc($result11)):
                                                echo "<option value='{$row11['e_id']}'>{$row11['e_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            	<li><input type="submit" name="" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
			
		<?php
		 		$eid=$_GET['eid'];
		if($eid){
				$examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
		 ?>	
			<div class="grid_12">
				<h1>Select Your Class - <?php echo $exam['e_name'];?></h1>				
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
						<h1>List of Your Class</h1><span></span>
					</div>
					<div class="block-content">
						<ul class="shortcut-list">
                        <?php 
							$qry=mysql_query("SELECT * FROM subject WHERE st_id=$stid AND b_id=$bid AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$slid=$row['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1); 
					$cid=$row['c_id'];
					$sid=$row['s_id'];
					
					$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
					$class=mysql_fetch_array($classlist);
					$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
					$section=mysql_fetch_array($sectionlist);
				
				?>
							<li>
								<a href="sresult_mng.php?bid=<?php echo $row['b_id']; ?>&cid=<?php echo $cid; ?>&sid=<?php echo $sid; ?>&eid=<?php echo $eid;?>&subid=<?php echo $row['sub_id'];?>">
									<img src="img/icons/packs/crystal/48x48/apps/kllckety.png">
									<?php echo $class['c_name']."-".$section['s_name']." (".$slist['s_name'].")"; ?>
								</a>
							</li>
                       <?php 
							$count++;
							} ?> 													
						</ul>
                        <?php if($count=='1'){?>
                        <h5>There is no classes for you !  Please Contact Administrator for forther information...</h5>
                        <?php } ?>
						<div class="clear"></div>
					</div>
				</div>
			</div>
			<?php } ?>
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
  
  <script type="text/javascript">
	$().ready(function() {
		
		/*
		 * Form Validation
		 */
		$.validator.setDefaults({
			submitHandler: function(e) {
				$.jGrowl("Form was successfully submitted.", { theme: 'success' });
				$(e).parent().parent().fadeOut();
				v.resetForm();
				v2.resetForm();
				v3.resetForm();
			}
		});
		
		var validateform = $("#validate-form").validate();
		
		$("#reset-validate-form").click(function() {
			location.reload(); 
		});
	});
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>