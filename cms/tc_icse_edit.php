<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 if (isset($_POST['submit']))
{
	$ano=$_POST['ano'];
	$tcno=$_POST['tcno'];
	$name=$_POST['name'];
	$f_name=$_POST['f_name'];
	$a_from=$_POST['a_from'];
	$tc_from=$_POST['tc_from'];
	$left=$_POST['left'];
	$leaving=$_POST['leaving'];
	$class=$_POST['class'];
	$year_from=$_POST['year_from'];
	$year_to=$_POST['year_to'];
	$dob_f=$_POST['dob_f'];
	$dob_w=$_POST['dob_w'];
	$religion=$_POST['religion'];
	$community=$_POST['community'];
	$promotion=$_POST['promotion'];
	$c_date=$_POST['c_date'];
	$id=$_POST['id'];
	$bid=$_POST['bid'];
		//die();
		$qry=mysql_query("UPDATE tc_icse SET ano='$ano',tcno='$tcno',name='$name',f_name='$f_name',a_from='$a_from',tc_from='$tc_from',left1='$left',leaving='$leaving',class='$class',year_from='$year_from',year_to='$year_to',dob_f='$dob_f',dob_w='$dob_w',religion='$religion',community='$community',promotion='$promotion',c_date='$c_date',b_id='$bid' WHERE id='$id'");

    if($qry){		
     header("Location:tc_icse_edit.php?bid=$bid&id=$id&msg=succ");	   
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
    	
    	<!-- Begin of titlebar/breadcrumbs -->
        <?php 
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_tcicse.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="tc_icse.php?bid=<?php echo $bid;?>" title="Home">TC - I to X ICSE STANDARD </a></li>
                <li class="no-hover">Edit TC - I to X ICSE STANDARD</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit TC - I to X ICSE STANDARD Certificate</h1>                
			<a href="tc_icse.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Created!!!
            <center><a href="tc_icse_prt.php?id=<?php echo $_GET['id'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Edited Certificate</button></a></center>
            </div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit TC - I to X ICSE STANDARD Certificate</h1><span></span>
					</div>
                     <?php 
							$id=$_GET['id'];
							$classlist=mysql_query("SELECT * FROM tc_icse WHERE id=$id"); 
								  $class=mysql_fetch_array($classlist);	
							?>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_50">
							<p>
                                <label for="textfield">Admission Number </label>
                                <input id="textfield" name="ano" class="required" type="text" value="<?php echo $class['ano']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">T.C Number</label>
                                <input id="textfield" name="tcno"  type="text" value="<?php echo $class['tcno']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Name of the Pupil </label>
                                <input id="textfield" name="name" class="required" type="text" value="<?php echo $class['name']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Name of the Father or Mother of the Pupil </label>
                                <input id="textfield" name="f_name" class="required" type="text" value="<?php echo $class['f_name']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Admitted into this school from</label>
                                <input id="textfield" name="a_from" class="required" type="text" value="<?php echo $class['a_from']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Transfer Certificate From</label>
                                <input id="textfield" name="tc_from"  type="text" value="<?php echo $class['tc_from']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Left On </label>
                                <input id="textfield"  name="left"  type="text" value="<?php echo $class['left1']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">He/she is Leaving the School (purpose) </label>
                                <input id="textfield"  name="leaving"  type="text" value="<?php echo $class['leaving']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">He/she was the studying in the class </label>
                                <input id="textfield"  name="class" class="required" type="text" value="<?php echo $class['class']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">The School year being from (x)</label>
                                <input id="textfield"  name="year_from" class="required" type="text" value="<?php echo $class['year_from']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">To (x) </label>
                                <input id="textfield"  name="year_to" class="required" type="text" value="<?php echo $class['year_to']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">His/ Her date of birth, according to the Admission Register is (in figures)</label>
                                <input id="textfield"  name="dob_f" type="text" value="<?php echo $class['dob_f']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">His/ Her date of birth, according to the Admission Register is (in Words) </label>
                                <input id="textfield"  name="dob_w"  type="text" value="<?php echo $class['dob_w']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">His/ Her Religion is </label>
                                <input id="textfield"  name="religion"  type="text" value="<?php echo $class['religion']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">His/ Her Community is </label>
                                <input id="textfield"  name="community"  type="text" value="<?php echo $class['community']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Promotion has been (+) </label>
                                <input id="textfield"  name="promotion"  type="text" value="<?php echo $class['promotion']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">This Certificate is dated</label>
                                <input id="datepicker1"  name="c_date"  type="text" value="<?php echo $class['c_date']; ?>" />
                            </p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="id" value="<?php echo $id;?>" > 
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
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
		$( "#datepicker1" ).datepicker();	
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