<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname']; 
 $baid=$_GET['baid'];
 $bcid=$_GET['bcid'];
 if (isset($_POST['submit']))
{
	
	$date=$_POST['date'];
	$date_split1= explode('/', $date);
		 
		 $date_month=$date_split1[1];
		 $date_day=$date_split1[0];
		 $date_year=$date_split1[2];
		 
	$baid1=$baid;
	
	
	$classlist1=mysql_query("SELECT * FROM bank_account WHERE ba_id=$baid1"); 
								  $class1=mysql_fetch_array($classlist1);
	$acc_no=$class1['account_no'];
	$b_name=$class1['b_name'];
	$withdrawl_by=$_POST['withdrawl_by'];
	$chequeno=$_POST['cheque_no'];
	$amount=$_POST['amount'];
	
	$oldamount=$_POST['oldamount'];
		
		$sql="UPDATE bank_withdrawl SET date='$date',date_day='$date_day',date_month='$date_month',date_year='$date_year',account_no='$acc_no',b_name='$b_name',withdrawl_by='$withdrawl_by',amount='$amount',ay_id='$acyear',cheque_no='$chequeno' WHERE bc_id='$bcid'";
	
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
		$cashlist=mysql_query("SELECT * FROM cash WHERE id=1"); 
			  $cash=mysql_fetch_array($cashlist);
			  $currentcash=$cash['amount'];
			  $updatecash=($currentcash-$oldamount)+$amount;
			  $cashqry=mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
			  
		$classlist=mysql_query("SELECT * FROM bank_account WHERE ba_id=$baid1"); 
								  $class=mysql_fetch_array($classlist);
		$accountamount=$class['amount'];
		$accountcash=($accountamount+$oldamount)-$amount;
			  $cashqry=mysql_query("UPDATE bank_account SET amount='$accountcash' WHERE ba_id=$baid1");
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
							
							if($baid){
							 $classlist=mysql_query("SELECT * FROM bank_account WHERE ba_id=$baid"); 
								  $class=mysql_fetch_array($classlist);
								  $accountamount=$class['amount'];}
								  $classlist1=mysql_query("SELECT * FROM bank_deposit WHERE bc_id=$bcid"); 
								  $class1=mysql_fetch_array($classlist1);
								  $cashlist=mysql_query("SELECT * FROM cash WHERE id=1"); 
								  $cash=mysql_fetch_array($cashlist);
								  $currentcash=$cash['amount'];
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="bank_account.php" title="Academic ex_catetory">Bank Account list</a></li>
				<li class="no-hover"><a href="withdrawl_mng.php?baid=<?php echo $baid; ?>" title="month">Bank withdrawl</a></li>
                <li class="no-hover">Edit <?php  echo $class['name']."-".$class['account_no'];?> Bank withdrawl</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit <?php  echo $class['name']."-".$class['account_no'];?> Bank withdrawl</h1>                
			<a href="withdrawl_mng.php?baid=<?php echo $baid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div class="_50" style="float:right">
             	Current Cash Total :<button class="btn btn-small btn-success"><?=$currentcash?> Rs/-</button>
                &nbsp; | &nbsp;
             	Account Total :<button class="btn btn-small btn-success"><?=$accountamount?> Rs/-</button>
             </div>
			</div>
            <div class="grid_12">
            <?php 
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully edited!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Bank withdrawl Details</h1><span></span>
					</div>
                    <?php 
					$bwithdrawl1=mysql_query("SELECT * FROM bank_withdrawl WHERE bc_id=$bcid"); 
								  $bwithdrawl=mysql_fetch_array($bwithdrawl1);
								  $baid2=$bwithdrawl['ba_id'];
								  ?>
					<form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_25">
							<p>
                                <label for="textfield">Date (MM/DD/YYYY) <span class="error">*</span></label>
                                <input id="datepicker" name="date" class="required" type="text" value="<?php echo $bwithdrawl['date'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">account No <span class="error">*</span></label>
                                <input id="a_no" name="acc_no" class="required" type="text" value="<?php echo $class['account_no'];?>" readonly />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Bank Name <span class="error">*</span></label>
                                <input id="b_name" name="b_name" class="required" type="text" value="<?php echo $class['name'];?>"  readonly/>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">withdrawled By <span class="error">*</span></label>
                                <input id="withdrawl_by" name="withdrawl_by" class="required" type="text" value="<?php echo $bwithdrawl['withdrawl_by'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Self Cheque No <span class="error">*</span></label>
                                <input id="cheque_no" name="cheque_no" class="required" type="text" value="<?php echo $bwithdrawl['cheque_no'];?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Amount <span class="error">*</span></label>
                                <input id="amount" name="amount" class="required" type="text" value="<?php echo $bwithdrawl['amount'];?>" />
                                <input name="oldamount" type="hidden" value="<?php echo $bwithdrawl['amount'];?>" />
                            </p>
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