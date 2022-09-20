<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");
 include("checking_page/admission.php");
 
 if (isset($_POST['submit']))
{
	$bid=mysql_real_escape_string($_POST['bid']);
	$cid=mysql_real_escape_string($_POST['cid']);
	$sid=mysql_real_escape_string($_POST['sid']);
	foreach ($_POST['ms_example'] as $selectedOption)
    { 
	 $paid=$selectedOption;	 
	 $studentlist=mysql_query("SELECT * FROM pre_admission WHERE pa_id=$paid"); 
								  $row=mysql_fetch_array($studentlist);
								  
	$fname=mysql_real_escape_string($row['firstname']);
	$lname=mysql_real_escape_string($row['lastname']);
	$p_name=mysql_real_escape_string($row['fathersname']);
	$p_occup=mysql_real_escape_string($row['fathersocupation']);
	$p_income=mysql_real_escape_string($row['p_income']);
	$m_name=mysql_real_escape_string($row['m_name']);
	$m_occup=mysql_real_escape_string($row['m_occup']);
	$m_income=mysql_real_escape_string($row['m_income']);
	
	$dob=mysql_real_escape_string($row['dob']);
	$gender=mysql_real_escape_string($row['gender']);
	
	$belong=mysql_real_escape_string($row['belong']);
	$religion=mysql_real_escape_string($row['religion']);
	$caste=mysql_real_escape_string($row['caste']);
	$subcaste=mysql_real_escape_string($row['subcaste']);
	$blood=mysql_real_escape_string($row['blood']);
	$email=mysql_real_escape_string($row['email']);
	$phone=mysql_real_escape_string($row['phone_number']);
	$address1=mysql_real_escape_string($row['address1']);
	$address2=mysql_real_escape_string($row['address2']);
	$village=mysql_real_escape_string($row['village']);
	$country=mysql_real_escape_string($row['country']);
	$pincode=mysql_real_escape_string($row['pincode']);
	$m_tongue=mysql_real_escape_string($row['m_tongue']);
	$height=mysql_real_escape_string($row['height']);
	$weight=mysql_real_escape_string($row['weight']);
	
	$remarks=mysql_real_escape_string($row['remarks']);
	$stype="New";
	$fdis_id=mysql_real_escape_string($row['fdis_id']);	
	$todaydate=date("d/m/Y H:i:s");
	
	$adminlist1=mysql_query("SELECT * FROM admin_no_count WHERE id='1'"); 
								  $admincount1=mysql_fetch_array($adminlist1);	
								  $adminno1=$admincount1['count'];
								  $adminno2=$adminno1+1;
								 $admin_number1="SMS".str_pad($adminno1, 5, '0', STR_PAD_LEFT);
								 
								 $photo=$admin_number1.".JPG";
		 $sql="INSERT INTO student (admission_number,firstname,lastname,dob,gender,blood,nation,reg,caste,sub_caste,fathersname,email,password,address1,address2,city_id,country,pin,phone_number,user_status,joined_date,c_id,s_id,fathersocupation,p_income,m_name,m_occup,m_income,doa,mother_tongue,height,weight,remarks,b_id,stype,fdis_id,ay_id,photo) VALUES
('$admin_number1','$fname','$lname','$dob','$gender','$blood','$belong','$religion','$caste','$subcaste','$p_name','$email','$admin_number1','$address1','$address2','$village','$country','$pincode','$phone','1','$todaydate','$cid','$sid','$p_occup','$p_income','$m_name','$m_occup','$m_income','$todaydate','$m_tongue','$height','$weight','$remarks','$bid','$stype','$fdis_id','$acyear','$photo')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

$lastid = mysql_insert_id();

$sql1="INSERT INTO parent (p_name,password,phone_number,user_status,joined_date,c_id,s_id,ocupation,ay_id,ss_id,email,admin_no,b_id) VALUES
('$p_name','$phone','$phone','1','$todaydate','$cid','$sid','$p_occup','$acyear','$lastid','$email','$admin_number1','$bid')";

$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
    if($result && $result1){				
		$sql1=mysql_query("UPDATE admin_no_count SET count='$adminno2' WHERE id='1'");
		$sql1=mysql_query("UPDATE pre_admission SET c_id='$cid',s_id='$sid',b_id='$bid',admin_id='$admin_number1',allocat='1' WHERE pa_id='$paid'");
    }
	}
	 header("Location:pre_admission_allocat.php?msg=succ");
	 exit;	
}
 ?>
 <link href="css/multiselect/multiselect.css" rel="stylesheet" type="text/css" />
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
                <li class="no-hover"><a href="pre_admission_allocation.php" title="Pre Admission Allocation">Pre Admission Allocation</a></li>
				<li class="no-hover">Student Class Allocat</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="pre_admission_allocation.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php }?>
            <div class="block-border">
					<div class="block-header">
						<h1>Select Student and Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="POST">
						<div class="_100">
							<p>
                            <div id="msc1">
                            </div>
                            <select name="ms_example[ ]" multiple="multiple" id="msc">
                            <?php 
							$query = mysql_query("SELECT * FROM pre_admission WHERE status='1' AND allocat='0' AND ay_id='$acyear' ORDER BY pa_id ASC"); 
    while ($row = mysql_fetch_assoc($query)) 
    { ?>
                                            <option value="<?php echo $row['pa_id'];?>"><?php echo $row['pa_admission_no']." - ".$row['firstname']." ".$row['lastname']." - ".$row['looking'];?></option>
                                            <?php } ?>                                                                       
                                        </select>
                                        <div class="btn-group">
                                            <span class="button blue" id="ms_select">Select all</span>
                                            <span class="button blue" id="ms_deselect">Deselect all</span>
                                        </div>
                                        
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Board : <span class="error">*</span></label>
                                </select>
                                	<?php
                                            $classl = "SELECT b_id,b_name FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="bid" id="bid" class="required" onchange="showCategoryboard(this.value)"> <option value="">Select Board</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
							</p>
						</div>
                       <div class="_25">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                               <select name="cid" id="cid" class="required" onchange="showCategory(this.value)">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Section / Group : <span class="error">*</span></label>
                               <select name="sid" id="sid" class="required">
											<option value="">Please select</option>											
								</select>
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
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
	});
  </script>
  	<script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
        
    <script type='text/javascript' src='js/plugins/multiselect/jquery.multi-select.min.js'></script>  
<script type="text/javascript">
$().ready(function() {		
		if($("#msc").length > 0){
        $("#msc").multiSelect({
            selectableHeader: "<div class='multipleselect-header'>Selectable item</div>",
            selectedHeader: "<div class='multipleselect-header'>Selected items</div>",
            afterSelect: function(value, text){
                //action
            },
            afterDeselect: function(value, text){
                //action
            }            
        });
        
        $("#ms_select").click(function(){
            $('#msc').multiSelect('select_all');
        });
        $("#ms_deselect").click(function(){
            $('#msc').multiSelect('deselect_all');
        });        
    }    	
	});
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
    function showCategory(str) {
        if (str == "") {
            document.getElementById("sid").innerHTML = "";
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
                document.getElementById("sid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }
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