<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/staff.php");
 
 if (isset($_POST['submit']))
{
		$c_name=addslashes(trim($_POST['c_name']));
		$c_code=addslashes(trim($_POST['c_code']));
		$oc_id=addslashes(trim($_POST['oc_id']));
		
	$qry=mysql_query("select * from others_category  where   oc_id!='$oc_id' and (category_name='$c_name' or c_code='$c_code') ") or die(mysql_error());
	
	
	if(mysql_num_rows($qry)=="0")
	{
		$sql=mysql_query("UPDATE others_category  SET category_name='$c_name',c_code='$c_code'  WHERE oc_id='$oc_id'");
		header("Location:otherscategory_edit.php?oc_id=$oc_id&msg=succ");
	 }else{
	     
	     header("Location:otherscategory_edit.php?oc_id=$oc_id&msg=err");
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
    	
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="others_list.php" title="Home">Others Management</a></li>
                <li class="no-hover">Edit Others Category Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit  Others Category Details</h1>                
			<a href="others_categorylist.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Updated!!!</div>
            <?php }  if($msg=="err"){?>			
            <div class="alert error"><span class="hide">x</span>Category Name (or) Category Code Already Given !!!</div>
            <?php }  ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit  Others Category Details</h1><span></span>
					</div>
                    <?php 
					$oc_id=$_GET['oc_id'];
							$categorylist=mysql_query("SELECT * FROM others_category WHERE oc_id=$oc_id"); 
								  $res=mysql_fetch_array($categorylist);
								  ?>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_25">
							<p>
                                <label for="textfield">Category Name: <span class="error">*</span></label>
                                <input id="c_name" name="c_name" minlength="2" class="required" type="text" value="<?php  echo stripslashes($res['category_name']);?>" />
                            </p>
						</div>
						
						<div class="_25">
							<p>
                                <label for="textfield">Category Code : <span class="error">*</span></label>
                                <input id="c_code" name="c_code" minlength="2" class="required" type="text" value="<?php  echo stripslashes($res['c_code']);?>"    />
                            </p>
						</div>
                         
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="oc_id" value="<?php echo $oc_id;?>" >
                           
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
    function showCategory(str) {
        if (str == "") {
            document.getElementById("spid").innerHTML = "";
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
                document.getElementById("spid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "stoppinglist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script>  
</body>
</html>
<? ob_flush(); ?>