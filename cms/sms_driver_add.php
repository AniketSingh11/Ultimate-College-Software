<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$pdate=mysql_real_escape_string($_POST['pdate']);
	 $title=mysql_real_escape_string($_POST['title']);
	 $msg=mysql_real_escape_string($_POST['msg']);
	 $date_split= explode('/', $pdate);
	  $publish_day=$date_split[0];
			 $publish_month=$date_split[1];
			 $publish_year=$date_split[2];
			 
			 				$succ="";
							$error="";
							
		
			 foreach ($_POST['ms_example'] as $selectedOption)
    { 
	 $stid=$selectedOption;	 
	 
	  $stafflist=mysql_query("SELECT fname,lname,phone_no FROM driver WHERE d_id=$stid"); 
								  $row=mysql_fetch_assoc($stafflist);
								 // $phone_no=$row['phone_no'];
								  
								  $phone_no=explode(",",$row['phone_no']);
								  $phone_no=$phone_no[0];
								  
								  $name=$row['fname']." ".$row['lname'];
								  
								  $msg1="Dear ".$name." ".$msg;
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
									if($status == "Status=0"){	*/						
									 	$sql="INSERT INTO mobile_sms_specific (day,month,year,date,title,msg,d_id,ay_id) VALUES
('$publish_day','$publish_month','$publish_year','$pdate','$title','$msg','$stid','$acyear')";
				$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
									$msg2="succ";				
									/*}else if($status == "Status=1"){
										$error .="SMS sent failed to ".$row['staff_id']."-".$row['fname']."".$row['lname']."<br>";
									}*/
								} 
                                curl_close($ch);
								  
	}
	
}

 


	
if(empty ($buffer))
{
    // echo " buffer is empty ";
}else{
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
				<li class="no-hover"><a href="sms_specific_mng1.php" title="NEWS Management">Specific SMS  Management</a></li>
                <li class="no-hover">SMS To Specific Driver</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>SMS To Specific  Driver</h1>                
			<a href="sms_specific_mng.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
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
						<h1>SMS To Specific Driver</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_100">
                    <p>
							<select name="ms_example[ ]" multiple="multiple" id="msc" class="required">
                            <?php
                            $select_record1=mysql_query("SELECT * FROM driver  where status='1'");
							$succ="";
							$error="";
							while($queryfetch1=mysql_fetch_assoc($select_record1))
							{ ?>
                                            <option value="<?php echo $queryfetch1['d_id'];?>"><?php echo $queryfetch1['fname']." ".$queryfetch1['lname'];?></option>
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
   <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
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
    <script>window.attachNEWS('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
 <script src="js/jquery-migrate-1.2.1.js"></script>
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
	</script>
  
</body>
</html>
<? ob_flush(); ?>