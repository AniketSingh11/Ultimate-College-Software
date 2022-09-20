<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top1.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$l_staff_id=mysql_real_escape_string($_POST["staff_id"]);
	$l_fname=$data['fname'];
	$l_l_type=mysql_real_escape_string($_POST["l_type"]);
	$l_l_a_date=date("m-d-Y");
	//echo $l_fname;
	
		 
		 
		 
	$l_l_from=mysql_real_escape_string($_POST["l_from"]);
	$l_l_to=mysql_real_escape_string($_POST["l_to"]);
	$l_descrip=mysql_real_escape_string($_POST["des"]);
	
	$date_split1= explode('-', $l_l_from);
		 
		 $ldate_month=$date_split1[0];
		 $ldate_day=$date_split1[1];
		 $ldate_year=$date_split1[2];
		 
	$date1 = new DateTime($l_l_from);
	$date2 = new DateTime($l_l_to);

	 $days = $date2->diff($date1)->format("%a");
		$days=$days+1;
	
	if ($date2<$date1) {
	header("location:sleave_apply.php?msg=errdate");
	}else if($date2==$date1){
		$days=1;
		}
	  $l_query="insert into staff_leave(d_id,d_staff_id,d_fname,l_type,l_a_date,l_from,l_to,l_total,l_des,status,f_month,f_year)values('$stid','$staff_id','$l_fname','$l_l_type','$l_l_a_date','$l_l_from','$l_l_to','$days','$l_descrip','1','$ldate_month','$ldate_year')";
	
	$l_result=mysql_query($l_query);	
	if($l_result)	
	{
		header("location:sleave_apply.php?msg=succ");
	}		
	else
	{
		header("location:sleave_apply.php?msg=err");
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
    	<?php include("nav1.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard1.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="sleave.php" title="Result Management">Leave List</a></li>
                <li class="no-hover">Apply Leave</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Apply Leave</h1> 
                <a href="sleave.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>               
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php }else if($msg=="errdate"){ ?>
            <div class="alert error"><span class="hide">x</span>Error on your To-Date and End-Date!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Apply Leave</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_100">
							<p>
								<label for="select">Leave Types : <span class="error">*</span></label>
                                	<?php
                                            $classl = mysql_query("SELECT * FROM leavetype");
                                            echo '<select name="l_type" id="ltype" class="required"> <option value="">Select Leave Type</option>';
											while($student12 = mysql_fetch_array($classl)) { ?>
                                                <option value='<?php echo $student12['lt_name']?>'><?php echo $student12['lt_name']." ".$student12['middlename']." ".$student12['lastname']; ?></option>
                                            <?php }
                                            echo '</select>';
                                            ?>
							
							</p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">To Date:<span class="error">*</span></label>
                                <input id="startdate" class="required" name="l_from" class="startdate" type="text"/>
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">End Date:<span class="error">*</span></label>
                                <input id="enddate" class="required" name="l_to" class="enddate" type="text"/>
                            </p>
						</div>
                        <div class="_100">
							<p><label for="textarea">Description :</label>
                            <textarea name="des"  rows="5"> </textarea>
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
		/*
		 * Datepicker
		 */
		$( "#startdate" ).Zebra_DatePicker({
        format: 'd-m-Y'
    });			
		$( "#enddate" ).Zebra_DatePicker({
        format: 'd-m-Y'
    });		
	
	$('#enddate').change(function() {
		var start = parseFloat(document.getElementById('startdate').value);
	  var end = parseFloat(document.getElementById('enddate').value);

if (start<end) {
var days   = (end - start)/1000/60/60/24;
$('#days').val(days);
}
else {
alert ("You cant come back before you have been!");
$('#startdate').val("");
$('#enddate').val("");
$('#days').val("");
}
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