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
	$bid=$_POST['bid'];
		//die();
		$sql="INSERT INTO tc_icse (ano,tcno,name,f_name,a_from,tc_from,left1,leaving,class,year_from,year_to,dob_f,dob_w,religion,community,promotion,c_date,ay_id,b_id) VALUES
('$ano','$tcno','$name','$f_name','$a_from','$tc_from','$left','$leaving','$class','$year_from','$year_to','$dob_f','$dob_w','$religion','$community','$promotion','$c_date','$acyear','$bid')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=mysql_insert_id();

    if($result){		
     header("Location:tc_icse_add.php?bid=$bid&lid=$lastid&msg=succ");	   
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
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>    	
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_tcicse.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="tc_icse.php?bid=<?php echo $bid;?>" title="Home">TC - I to X ICSE STANDARD </a></li>
                <li class="no-hover">Add New TC - I to X ICSE STANDARD</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New TC - I to X ICSE STANDARD Certificate</h1>                
			<a href="tc_icse.php?bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			<?php $msg=$_GET['msg'];
			if($msg=="succ"){
				unset($_SESSION['tc']);?>			
            <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Created!!!
            <center><a href="tc_icse_prt.php?id=<?php echo $_GET['lid'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Added Certificate</button></a></center>
            </div>
            <?php }
			 if($_GET['roll']){ ?>
            <a href="tc_icse_add.php?bid=<?php echo $bid;?>"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Create Another One</button></a> <?php } ?>
			</div>
            <?php if(!$_GET['roll']){ ?>
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Academic Year , Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get">
                    <div class="_50">
							<p>
								<label for="select" class="requered">Academic Year : <span class="error">*</span></label>
                                	<?php
											$sayid=$_SESSION['tc']['ayid'];
											if(!$sayid){ unset($_SESSION['tc']);}
                                            $classl1 = "SELECT * FROM year ORDER BY ay_id DESC LIMIT 2";
                                            $result11 = mysql_query($classl1) or die(mysql_error());
                                            echo '<select name="ayid" id="ayid" class="required"> 
											<option value="">Select Academic Year</option>';
											while ($row11 = mysql_fetch_assoc($result11)):
												if($sayid == $row11['ay_id']){
                                                echo "<option value='{$row11['ay_id']}' selected>{$row11['y_name']}</option>\n";
												}else {
													echo "<option value='{$row11['ay_id']}'>{$row11['y_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
							</p>
						</div>
						<div class="_50">
                            <p>
                            <label for="required">Student Roll No:</label>
                            <input type="text" name="roll" class="biginput" class="requered" id="autocomplete" /> 
                            </p>
                            </div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
            <?php } if($_GET['roll']){ 
			
					$roll=$_GET['roll'];
					$classes=explode("-",$roll);  
					//print_r($classes);
					$rollno=$classes[0];  
					$studentname=$classes[1];  
					$ayid=$_GET['ayid'];

					//die();
					
					$studentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$ayid"); 
								  $student=mysql_fetch_array($studentlist);
								  if(!$student){
									  	unset($_SESSION['tc']);
										header("location:samacheer_x_single.php?bid=$bid");
									}
								  $ssid=$student['ss_id'];
								  $ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  $s_type=$student['stype'];
								  $fdisid1=$student['fdis_id'];
								  $rid=$student['r_id'];
								  $spid=$student['sp_id'];
								  if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
								  $yearlist=mysql_query("SELECT * FROM year WHERE ay_id=$ayid"); 
								  $ayears=mysql_fetch_array($yearlist);	
								  }
			?>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Created!!!
            <center><a href="tc_icse_prt.php?id=<?php echo $_GET['lid'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Added Certificate</button></a></center>
            </div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add New TC - I to X ICSE STANDARD Certificate</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_50">
							<p>
                                <label for="textfield">Admission Number </label>
                                <input id="textfield" name="ano" class="required" type="text" value="<?php echo $student['admission_number']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">T.C Number</label>
                                <input id="textfield" name="tcno"  type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Name of the Pupil </label>
                                <input id="textfield" name="name" class="required" type="text" value="<?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Name of the Father or Mother of the Pupil </label>
                                <input id="textfield" name="f_name" class="required" type="text" value="<?php echo $student['fathersname']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Admitted into this school from</label>
                                <input id="textfield" name="a_from" class="required" type="text" value="<?php echo $student['doa']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Transfer Certificate From</label>
                                <input id="textfield" name="tc_from" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Left On </label>
                                <input id="textfield"  name="left"  type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">He/she is Leaving the School (purpose) </label>
                                <input id="textfield"  name="leaving"  type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">He/she was the studying in the class </label>
                                <input id="textfield"  name="class" class="required" type="text" value="<?php echo $class['c_name'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">The School year being from (x)</label>
                                <input id="textfield"  name="year_from" class="required" type="text" value="<?php echo $ayears['y_name'];?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">To (x) </label>
                                <input id="textfield"  name="year_to" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">His/ Her date of birth, according to the Admission Register is (in figures)</label>
                                <input id="textfield"  name="dob_f" type="text" value="<?php echo $student['dob']; ?>" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">His/ Her date of birth, according to the Admission Register is (in Words) </label>
                                <input id="textfield"  name="dob_w"  type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">His/ Her Religion is </label>
                                <input id="textfield"  name="religion"  type="text" value="<?php echo $student['reg']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">His/ Her Community is </label>
                                <input id="textfield"  name="community"  type="text" value="<?php echo $student['caste']; ?>" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Promotion has been (+) </label>
                                <input id="textfield"  name="promotion"  type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">This Certificate is dated</label>
                                <input id="datepicker1"  name="c_date"  type="text" value="<?php echo date("m/d/Y");?>" />
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
   <?php if($_GET['roll']){ ?><script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI --> <?php } ?>
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
  <?php if(!$_GET['roll']){ include("auto2.php"); ?>
  <link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
<?php }?>
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		<?php if($_GET['roll']){ ?> /*
		 * Datepicker
		 */
		$( "#datepicker1" ).datepicker();
		$( "#datepicker2" ).datepicker();
		<?php } ?>
	});
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <script type="text/javascript">
$(document).ready(function() {
    function languageChange()
    {
         var lang = $('#ayid option:selected').val();
        return lang;
    }
    $('#ayid').change(function(e) { 
	    var lang = languageChange();
		//alert(lang);
		//var dataString = 'lang=' + lang +'fdisid=1';
        $.ajax({
            type: "POST",
            url: "pass_value3.php",
            //data: dataString,
			data :{"lang":lang},
            dataType: 'json',
            cache: false,
            success: function(response) {
                    alert(response.message);					
                }
        });
		
		//location.reload();
		window.location.reload();
        return false;
    });
});
</script>
</body>
</html>
<? ob_flush(); ?>