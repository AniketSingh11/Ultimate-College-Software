<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 $tid=$_GET['tid'];
 if (isset($_POST['submit']))
{
	$title=$_POST['title'];
	$down_field="";
foreach ($_POST['down_id'] as $val)
{
    $down_field.=$val.",";
}
$down_field=substr_replace($down_field, "", -1);
		
		$sql="UPDATE report_temp SET title='$title',list='$down_field' WHERE t_id='$tid'";
		
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:exp_filterstudent_temp_edit.php?tid=$tid&msg=succ");
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
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="exp_filterstudent_list.php" title="Filter Students List Report">Filtered Student Report</a></li>
                <li class="no-hover"><a href="exp_filterstudent_temp.php" title="Report Fields Template">Report Fields Template</a></li>
                <li class="no-hover">Edit Template</li>
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">			
			<div class="grid_12">
				<h1>Edit Template</h1>                
			<a href="exp_filterstudent_temp.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Template Successfully edited!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Template</h1><span></span>
					</div>
                     <?php 
							$sectionlist=mysql_query("SELECT * FROM report_temp WHERE t_id=$tid"); 
								  $report=mysql_fetch_array($sectionlist);	
							?>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_50">
							<p>
                                <label for="textfield">Title <span class="error">*</span></label>
                                <input id="textfield" name="title" class="required" type="text" value="<?php echo $report['title'];?>" />
                            </p>
						</div>
                        <?php 
							$field=array();
							$reportlist=explode(",",$report["list"]);
							    
							        foreach($reportlist as $val)
							        {
							            array_push($field,$val);
							        }
									
									$fesstypearray=array(
									"admission_number AS AdmissionNo"=>"AdmissionNo",
									"firstname"=>"Firstname",
									"lastname"=>"lastname",
									"fathersname"=>"fathersname",
									"p_income AS Income"=>"Income",
									"m_name AS MotherName"=>"MotherName",
									"m_occup AS MotherOccuption"=>"MotherOccuption",
									"doa AS DateOfadmission"=>"DateOfadmission",
									"dob AS DateOfBirth"=>"DateOfBirth",
									"gender AS Gender"=>"Gender",
									"nation"=>"nation",
									"reg AS Religion"=>"Religion",
									"caste AS Caste"=>"Caste",
									"sub_caste AS SubCaste"=>"SubCaste",
									"blood"=>"blood",
									"email"=>"email",
									"phone_number AS PhoneNumber"=>"PhoneNumber",
									"address1"=>"address1",
									"address2"=>"address2",
									"city_id AS City"=>"City",
									"country"=>"country",
									"pin AS Pincode"=>"Pincode",
									"mother_tongue AS MotherTonge"=>"MotherTonge",
									"height"=>"height",
									"weight"=>"weight",
									"remarks"=>"remarks",
									"stype AS StudentType"=>"StudentType",
									"fdis_id AS StudentCategory"=>"StudentCategory",
									"sp_id AS StoppingPoint"=>"StoppingPoint",
									"c_id AS Class"=>"Class",
									"s_id AS Section"=>"Section",
									); 
				?>	
                        <div class="_100">
							<p>
					         <label for="select">Select Download Field: <span class="error">*</span></label>
							 <select name="down_id[]" id="down_id" multiple="multiple" class="form-control required" style="width:100%" >
                                 <?php
							   foreach ($fesstypearray as $k => $v) {
								if(in_array($k, $field)){?>
								<option value="<?php echo $k;?>" selected="selected" ><?php echo $v;?></option>
							<?php }else { ?>
								<option value="<?php echo $k;?>" ><?php echo $v;?></option>            
							<?php } }?>		
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
	});
  </script>
    <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
    <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
  	<link rel="stylesheet" href="payroll/js/plugins/select2/select2.css" type="text/css" />
  	  <script src="payroll/js/plugins/select2/select2.js"></script>  
      <script src="js/jquery-migrate-1.2.1.js"></script>
      <script type="text/javascript">
	  $().ready(function() {		
   	 
      	 $('#down_id').select2 ({
      			allowClear: true,
      			placeholder: "Please Select..."
      		}); 

       	$('#filter_value').select2 ({
  			allowClear: true,
  			placeholder: "Please Select..."
  		}).on("change", function(e) {
            // mostly used event, fired to the original element when the value changes
  			var f=$('#filter_value').val();
  			var res=f.slice(0,3);

			 if(res[0]=="All"){
				 $("#filter_value").select2('val', '')
				 $("#filter_value").select2('val', 'All')
			 }else{

			 }

  			//	$("#filter_value option[value='All']").remove();
  	  		
  			//$("select").select2('val', 'All')
          })
  		 .on("select2-selecting", function(e) {

  	      
        })
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