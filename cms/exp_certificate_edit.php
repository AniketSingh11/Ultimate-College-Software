<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	 $position=$_POST['position'];
	$duration_from=$_POST['d_from'];
	$duration_to=$_POST['d_to'];
	 
	 $eid=addslashes(trim($_POST['eid']));
	 $purpose=addslashes(trim($_POST['purpose']));
	 
	 $name=$_POST['name'];
	 $gender=$_POST['gender'];
	 
		$qry=mysql_query("UPDATE experience_certificate SET name='$name',gender='$gender',position='$position',duration_from='$duration_from',duration_to='$duration_to',purpose='$purpose'  WHERE e_id='$eid'") or die(mysql_error());
    if($qry){
         header("Location:exp_certificate_edit.php?e_id=$eid&msg=succ");
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
				
                <li class="no-hover">Edit Experience Certificate</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Experience Certificate</h1>                
			<a href="exp_certificate_list.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Experience Certificate</h1><span></span>
					</div>
                    <?php 
							$eid=$_GET['e_id'];
							$classlist=mysql_query("SELECT * FROM experience_certificate WHERE e_id=$eid"); 
								  $class=mysql_fetch_array($classlist);	
								  $ref_no=$class["ref_number"];
								  $id=$class["id"];
								  $name=stripslashes($class["name"]);
								  $type=stripslashes($class["type"]);
								  $position=stripslashes($class["position"]);
								  $duration_from=stripslashes($class["duration_from"]);
								  $duration_to=stripslashes($class["duration_to"]);
								  $gender=stripslashes($class["gender"]);
								  
								  $fathername=stripslashes($class["fathername"]);
								  
							?>
					<form id="validate-form" class="block-content form" action="" method="post">
					 <div class="_25">
							<p>
                                <label for="textfield">Ref NO :  <?php echo $ref_no; ?></label>
                                
                            </p>
						</div>
					
					 <div class="_25">
							<p>
                                <label for="textfield">Id :  <?php echo $id; ?></label>
                                
                            </p>
						</div>
					
						<div class="_25">
							<p>
                                <label for="textfield">Type :  <?php echo $type; ?></label>
                                
                            </p>
						</div>
						
						
						  <div class="_50">
							<p>
                                <label for="textfield">Name : </label>
                                 <input   name="name" id="name" class="required" value="<?php echo $name; ?>" type="text" value="" />
                            </p>
						</div>
							
						
						
                        <div class="_50">
							<p>
                                <label for="textfield">Father Name :  </label>
                              <input   name="fathername" id="fathername" class="required" value="<?php echo $fathername; ?>" type="text" value="" />
                            </p>
						</div>
                        
						 <div class="_50">
							<p>
                                <label for="textfield">Duration From</label>
                                <input id="datepicker" style="width: 450px;" name="d_from" value="<?=$duration_from?>" class="required" type="text" value="" />
                            </p>
						</div>
						 <div class="_50">
							<p>
                                <label for="textfield">Duration To</label>
                                <input id="datepicker1" style="width: 450px;" value="<?=$duration_to?>"  name="d_to" class="required" type="text" value="" />
                            </p>
						</div>
						
						  <div class="_100">
							<p>
                                <label for="textfield">Experience Position Name</label>
                                <input id="position" name="position" value="<?=$position?>" class="required" type="text" value="" />
                            </p>
						</div>
                   
                   <div class="_100">
							<p>
                                <label for="textfield">Purpose</label>
                                <input id="purpose"  name="purpose" class="required" type="text" value="<?php echo $class['purpose']; ?>" />
                            </p>
						</div>
                   	      <div class="clear"></div>
						  <div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="eid" value="<?php echo $eid;?>" > 
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
<script src="js/tinyeditor/tinymce.min.js"></script>

<script   type="text/javascript">
 
tinymce.init({
    selector: "#textarea",
    theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
    font_size_style_values: "12px,13px,14px,16px,18px,20px",
    theme: "modern",
   
    height:200,
    //width:500,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   templates : [
                {
                        title: "Editor Details",
                        url: "editor_details.htm",
                        description: "Adds Editors Name and Staff ID"
                }
        ],
   toolbar: "insertfile undo redo | styleselect | sizeselect | bold italic | fontselect |  fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons" 
   
 }); 
</script>

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
		       
	      	  pair: $('#datepicker1'),
				format: 'd.m.Y'
	    });				

			$( "#datepicker1" ).Zebra_DatePicker({
				direction: 1,
				format: 'd.m.Y'
			 
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