<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$date=$_POST['date'];
	$date_split1= explode('/', $date);
		 
		 $date_month=$date_split1[1];
		 $date_day=$date_split1[0];
		 $date_year=$date_split1[2];
		 
	$title=$_POST['title'];
	$des=$_POST['des'];
	$r_no=$_POST['r_no'];
	$b_no=$_POST['b_no'];
	$amount=$_POST['amount'];
	$incid=$_POST['incid'];
	$inid=$_POST['inid'];
	
	$oldamount=$_POST['oldamount'];	
	
	$sql=mysql_query("UPDATE income SET r_no='$r_no',b_no='$b_no',date_day='$date_day',date_month='$date_month',date_year='$date_year',title='$title',des='$des',amount='$amount',inc_id='$incid',ay_id='$acyear' WHERE in_id='$inid'") or die("Could not insert data into DB: " . mysql_error());

    if($sql){
		$cashlist=mysql_query("SELECT * FROM cash WHERE id=1"); 
			  $cash=mysql_fetch_array($cashlist);
			  $currentcash=$cash['amount'];
			  $updatecash=($currentcash-$oldamount)+$amount;
			  $cashqry=mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
        $msg="succ";
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
    	<?php 
		$incid=$_GET['incid'];
							 $classlist=mysql_query("SELECT * FROM in_category WHERE inc_id=$incid"); 
								  $class=mysql_fetch_array($classlist);
								  $cashlist=mysql_query("SELECT * FROM cash WHERE id=1"); 
								  $cash=mysql_fetch_array($cashlist);
								  $currentcash=$cash['amount'];
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="income_category.php" title="Academic in_catetory">Income Category list</a></li>
                <li class="no-hover"><a href="income.php?incid=<?php echo $excid; ?>" title="month"><?php  echo $class['in_category'];?> Income Details</a></li>
                <li class="no-hover">Edit <?php  echo $class['in_category'];?> Income Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit <?php  echo $class['in_category'];?> Income Details</h1>                
			<a href="income.php?incid=<?php echo $incid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div style="float:right">
             	Current Hand Cash Total :<button class="btn btn-small btn-success"><?=$currentcash?> Rs/-</button>
             </div>
			</div>
            <div class="grid_12">
            <?php //$msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit <?php  echo $class['in_category'];?> Income Details</h1><span></span>
					</div>
                    <?php 
					$inid=$_GET['inid'];
							 $classlist1=mysql_query("SELECT * FROM income WHERE in_id=$inid"); 
								  $row=mysql_fetch_array($classlist1);
								  ?>
					<form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_25">
							<p>
                                <label for="textfield">Date <span class="error">*</span></label>
                                <input id="datepicker" name="date" class="required" type="text" value="<?php echo $row['date_day']."/".$row['date_month']."/".$row['date_year']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Title <span class="error">*</span></label>
                                <input id="textfield" name="title" class="required" type="text" value="<?php echo $row['title']; ?>" />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Description <span class="error">*</span></label>
                                <textarea id="textfield" name="des" class="required" rows="5"><?php echo $row['des']; ?></textarea>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Receipt No <span class="error">*</span></label>
                                <input id="textfield" name="r_no" class="required" type="text" value="<?php echo $row['r_no']; ?>" readonly />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Bill No/Receipt No From outside</label>
                                <input id="textfield" name="b_no" type="text" value="<?php echo $row['b_no']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Amount <span class="error">*</span></label>
                                <input id="textfield" name="amount" class="required" type="text" value="<?php echo $row['amount']; ?>" />
                                <input name="oldamount" type="hidden" value="<?php echo $row['amount'];?>" />
                            </p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="incid" value="<?php echo $_GET['incid'];?>">
                            <input type="hidden" class="medium" name="inid" value="<?php echo $_GET['inid'];?>">
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
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		$( "#datepicker" ).Zebra_DatePicker({
			format: 'd/m/Y'
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