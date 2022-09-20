<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/admission.php");
 
 if (isset($_POST['submit']))
{
	$admin_no=mysql_real_escape_string($_POST['admin_no']);
	$fname=mysql_real_escape_string($_POST['fname']);
	$lname=mysql_real_escape_string($_POST['lname']);
	$p_name=mysql_real_escape_string($_POST['p_name']);
	$m_name=mysql_real_escape_string($_POST['m_name']);
	
	$dob=mysql_real_escape_string($_POST['dob']);
	$gender=mysql_real_escape_string($_POST['gender']);
	
	$religion=mysql_real_escape_string($_POST['religion']);
	$email=mysql_real_escape_string($_POST['email']);
	$phone=mysql_real_escape_string($_POST['phone']);
	$phone1=mysql_real_escape_string($_POST['phone1']);
	$phone2=mysql_real_escape_string($_POST['phone2']);
	$phone3=mysql_real_escape_string($_POST['phone3']);
	$address1=mysql_real_escape_string($_POST['address1']);
	$village=mysql_real_escape_string($_POST['village']);
	$country=mysql_real_escape_string($_POST['country']);
	$state=mysql_real_escape_string($_POST['state']);
	$pincode=mysql_real_escape_string($_POST['pincode']);
	
	$bid=mysql_real_escape_string($_POST['b_id']);
	$cid=mysql_real_escape_string($_POST['cid']);
	
	$todaydate=date("d/m/Y H:i:s");
	
	$adminlist1=mysql_query("SELECT * FROM admin_no_count WHERE id='2'"); 
								  $admincount1=mysql_fetch_array($adminlist1);	
								  $adminno1=$admincount1['count'];
								  $adminno2=$adminno1+1;
								 $admin_number1="PRE".str_pad($adminno1, 5, '0', STR_PAD_LEFT);
			//$photo=$admin_number1.".jpg";					 
	
	$newfilename = $admin_number1 . $file_ext;		
		 $sql="INSERT INTO pre_admission (pa_admission_no,firstname,lastname,dob,gender,reg,fathersname,email,address1,city_id,country,state,pin,phone_number,phone1,phone2,phone3,c_id,m_name,b_id,ay_id) VALUES
('$admin_number1','$fname','$lname','$dob','$gender','$religion','$p_name','$email','$address1','$village','$country','$state','$pincode','$phone','$phone1','$phone2','$phone3','$cid','$m_name','$bid','$acyear')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=$id = mysql_insert_id();
    if($result){			
		$sql1=mysql_query("UPDATE admin_no_count SET count='$adminno2' WHERE id='2'");
        header("Location:pre_admission_single.php?msg=succ&lid=$lastid");
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
					$adminlist=mysql_query("SELECT * FROM admin_no_count WHERE id='2'"); 
								  $admincount=mysql_fetch_array($adminlist);								  
								  $adminno=$admincount['count'];								  
								 $admin_number="PRE".str_pad($adminno, 5, '0', STR_PAD_LEFT);
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="pre_admission.php" title="Home">Pre Admission</a></li>
                <li class="no-hover">Pre Admission Student Add</li>
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">			
			<div class="grid_12">
				<h1>Pre Admission Student Add</h1>                
			<a href="pre_admission.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <?php $lid=$_GET['lid'];
			if($lid){?>
            <a href="pre_admission_prt.php?paid=<?php echo $lid;?>" style="margin:0px 0 0 10px; float:right" target="_blank"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png">Print Last Pre Admission</button></a>
            <?php } ?>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php }else if($msg=="eronfile"){?>			
            <div class="alert error"><span class="hide">x</span>Please Upload this type of file only (.png , .jpg , .Gif) AND also file size lessthen 1MB!!!</div>
            <?php } ?>            
				<div class="block-border">
					<div class="block-header">
						<h1>Pre Admission Student Add</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_25">
							<p>
                                <label for="textfield">Pre Admin NO : <span class="error">*</span></label>
                                <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $admin_number;?>" readonly  />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">First Name: <span class="error">*</span></label>
                                <input id="textfield" name="fname" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Last Name:</label>
                                <input id="textfield" name="lname" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father / Guardian Name: <span class="error">*</span></label>
                                <input id="textfield" name="p_name" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Mother's Name : </label>
                                <input id="textfield" name="m_name" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date Of Birth : <span class="error">*</span></label>
                                <input id="datepicker1" name="dob" class="required" type="text" value="" />
                            </p>
						</div>
                       <div class="_25">
							<p>
								<label for="select">Gender : <span class="error">*</span></label>
								<select name="gender" class="required">
									<option value="">Select one</option>
									<option value="M">Male</option>
									<option value="F">Female</option>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Religion : <span class="error">*</span></label>
                                <input id="textfield" name="religion" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="clear"></div>
                        <div class="_50">
							<p><label for="textarea">Address : <span class="error">*</span></label><textarea id="textarea" name="address1" class="required" rows="5" cols="40"></textarea></p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">City: <span class="error">*</span></label>
                                <input id="textfield" name="village" class="required" type="text" value="" />
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">State : <span class="error">*</span></label>
                                <input id="textfield" name="state" class="required" type="text" value="" />
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Country : <span class="error">*</span></label>
                                <input id="textfield" name="country" class="required" type="text" value="" />
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Pin Code : <span class="error">*</span></label>
                                <input id="textfield" name="pincode" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Email :</label>
                                <input id="textfield" name="email" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father / Guardian Phone No: <span class="error">*</span></label>
                                <input id="textfield" name="phone" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Additional Phone No 1 : </label>
                                <input id="textfield" name="phone1" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Additional Phone No 2 :</label>
                                <input id="textfield" name="phone2" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Additional Phone No 3 : </label>
                                <input id="textfield" name="phone3"  type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Select Board: <span class="error">*</span></label>
                                <select name="b_id" id="bid" onchange="showCategoryboard(this.value)">
                                <option value="">Select Board</option>
                                <?php 
							$qry=mysql_query("SELECT * FROM board");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ ?>
                				<option value="<?php echo $row['b_id']; ?>"><?php echo $row['b_name']; ?></option>
                  <?PHP } ?>
                  </select>
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                               <select name="cid" id="cid" class="required">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                        <div id="class">    
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
				
		$( "#datepicker1" ).Zebra_DatePicker({
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
 <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
    function showCategoryboard(str) {
        if (str == "") {
            document.getElementById("cid").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("cid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "classlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }	  
</script>   
</body>
</html>
<? ob_flush(); ?>