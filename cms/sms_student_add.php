<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$bid=mysql_real_escape_string($_POST['bid']);
	$cid=mysql_real_escape_string($_POST['cid']);
	$sid=mysql_real_escape_string($_POST['sid']);
	 $pdate=mysql_real_escape_string($_POST['pdate']);
	 $title=mysql_real_escape_string($_POST['title']);
	 $msg=mysql_real_escape_string($_POST['msg']);
	 $date_split= explode('/', $pdate);
	  $publish_day=$date_split[0];
			 $publish_month=$date_split[1];
			 $publish_year=$date_split[2];
			 
			 
			 				$succ="";
							$error="";
							//$msg1=str_replace(' ','%20',$msg); 
			 foreach ($_POST['ms_example'] as $selectedOption)
    { 
	 $ssid=$selectedOption;	 
	 $studentlist=mysql_query("SELECT firstname,lastname,phone_number FROM student WHERE ss_id=$ssid"); 
								  $row=mysql_fetch_array($studentlist);
								  $phone_no=$row['phone_number'];
								  $name=$row['firstname']." ".$row['lastname'];
								  
								  $cid=$row['c_id'];
								  $sid=$row['s_id'];
								  
								  $sectionlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
								  $section=mysql_fetch_array($sectionlist);
								  $class_name=$section["c_name"];
								  
								  $sectionlist=mysql_query("SELECT * FROM section WHERE s_id='$sid'");
								  $section=mysql_fetch_array($sectionlist);
								  $section_name=$section["s_name"];
								  
								  $msg1="Dear ".$name." ".$class_name."-".$section_name." ".$msg;
								  $msg1=str_replace(' ','%20',$msg1);
								 $qry_str = "?username=spmodernschool&password=CIVIL123&mobilenumber=$phone_no&message=$msg1&senderid=MODERN&type=3";
$ch = curl_init();
// Set query data here with the URL
curl_setopt($ch, CURLOPT_URL, 'http://bulksmsgateway.in/unicodesmsapi.php' . $qry_str);
	
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '3');
$buffer = trim(curl_exec($ch));
								  
                                if(empty ($buffer))
                                {
									// echo " buffer is empty "; 
									}else{ 
								//$buffer; 
								$stat= explode(',', $buffer);
	  							/*$status=$stat[0];
									if($status == "Status=0"){*/							
									 	$sql="INSERT INTO mobile_sms_specific (day,month,year,date,title,msg,ss_id,b_id,c_id,s_id,ay_id) VALUES
('$publish_day','$publish_month','$publish_year','$pdate','$title','$msg','$ssid','$bid','$cid','$sid','$acyear')";
				$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
									$msg2="succ";				
									/*}else if($status == "Status=1"){
										$error .="SMS sent failed to ".$row['staff_id']."-".$row['fname']."".$row['lname']."<br>";
									}*/
								} 
                                curl_close($ch);
	}
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
                <li class="no-hover"><a href="sms_specific_mng.php" title="Specific SMS Management">Specific SMS Management</a></li>
				<li class="no-hover">SMS to Specific Student</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="sms_specific_mng.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div class="grid_12">
            <?php //$msg=$_GET['msg'];
			if($msg2=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your SMS Successfully sent!!!</div>
            <?php }
			if($error){?>			
            <div class="alert error"><span class="hide">x</span><?php echo $error;?></div>
            <?php } ?>
            <div class="block-border">
					<div class="block-header">
						<h1>Select Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_25">
							<p>
								<label for="select">Select Board : <span class="error">*</span></label>
								<select name="bid" class="required" onchange="showCategory2(this.value)">
									<option value="">Select Board</option>
                                    <?php 
							$qry=mysql_query("SELECT * FROM board");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ ?>
									<option value="<?php echo $row['b_id']; ?>"><?php echo $row['b_name']; ?></option>									
                            <?php } ?>
								</select>
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
                               <select name="sid" id="sid" class="required" onchange="showCategory1(this.value)">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                        <div class="_100">
							<p>
                            <div id="msc1">
                            </div>          
							</p>
						</div>
                       <div class="_25">
							<p>
                                <label for="textfield">Date : <span class="error">*</span></label>
                                <input id="pdate" name="pdate" class="required"  type="text" value="<?php echo date("d/m/Y");?>" readonly/>
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Title : <span class="error">*</span></label>
                                <input id="textfield" name="title" class="required" type="text" value="" />
                            </p>
						</div>
                         <div class="_100">
							<p><label for="textarea">Msg Details: <span class="error">*</span></label><textarea id="textarea" name="msg" class="required" rows="5" cols="40"></textarea></p>
						</div>
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            	<li><input type="submit" class="button" name="submit" value="Submit"></li>
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
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
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
        <script src="js/jquery-migrate-1.2.1.js"></script>
    <script type='text/javascript' src='js/plugins/multiselect/jquery.multi-select.min.js'></script>  
<script type="text/javascript">
function showCategory2(str) {
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
        xmlhttp.open("GET", "standardlist.php?mmtid=" + str, true);
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
                var sid=$("#sid").val();
                showCategory1(sid);
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }
	function showCategory1(str) {
        if (str == "") {
            document.getElementById("msc1").innerHTML = "";
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
                document.getElementById("msc1").innerHTML = xmlhttp.responseText;
				multiselect();
            }
        }
        xmlhttp.open("GET", "studentlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
	function multiselect(){
		if($("#msc").length > 0){
			//alert($("#msc").length);
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