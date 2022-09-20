<? ob_start(); ?>
<?php
//error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];


 if (isset($_POST['submit']))
{
	 
	 $title=addslashes(trim($_POST['title']));
	 $descript=addslashes(trim($_POST['descript']));
 
 $date=date("Y-m-d");
				
				$sql="INSERT INTO letter_pad (title,description,date) VALUES('$title','$descript','$date')";
				$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
				$last_id=mysql_insert_id();
				if($result){ 
					 
				header("Location:letterpad_add.php?msg=succ&id=$last_id");
			}else {
				//$_SESSION['error'] = "Could not upload file.  Check read/write persmissions on the directory";
				header("Location:letterpad_add.php?msg=eronfile");
				exit;
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
				 
                <li class="no-hover">Letterhead Printing</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add Letterhead Content</h1>                
			<a href="letterpad_list.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!
             <center><a href="letterpad_prt.php?l_id=<?php echo $_GET['id'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print</button></a></center>
            </div>
            <?php } if($msg=="eronfile"){?>			
            <div class="alert error"><span class="hide">x</span>Failed!!</div>
            <?php } ?>
            
          
            
            
				<div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Add Letter Pad Content</h1>
                       
                        <span></span>
					</div>
                    <div class="block-content tab-container" >
						 
							<br>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						 
                        <div class="_100">
							<p>
                                <label for="textfield">Title : <span class="error">*</span></label>
                                <input id="textfield" name="title" class="required" type="text" value="" />
                            </p>
						</div>
                         <div class="_100">
							<p><label for="textarea"> Description: <span class="error">*</span></label><textarea id="textarea" name="descript"   rows="5" cols="40"></textarea></p>
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
					title: "Default Template 1",
					url: "letterpad/default.html",
					description: "Adds Editors Name, Staff ID and others things"
				},
				{
					title: "Default Template 2",
					url: "letterpad/default1.html",
					description: "Adds Editors Name, Staff ID and others things"
                },
                {
                        title: "Experience Certificate",
                        url: "letterpad/experience.html",
                        description: "Adds Editors Name, Staff ID and others things"
                },
				{
                        title: "Bonafide Certificate",
                        url: "letterpad/bonafide.html",
                        description: "Adds Editors Name, Staff ID and others things"
                },
				{
                        title: "Proposal Template",
                        url: "letterpad/proposal.html",
                        description: "Adds Editors Name and others things"
                },
				{
                        title: "Fees Certificate Temp",
                        url: "letterpad/fees-certificate.html",
                        description: "Adds Editors Name and others things"
                }
        ],
   toolbar: "insertfile undo redo | styleselect | bold italic |   fontselect |  fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons" 
   
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
		var validateform1 = $("#validate-form1").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
		$("#reset-validate-form1").click(function() {
			validateform1.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
		$( "#datepicker2" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
		$("#tab-panel-1").createTabs();
	});
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
   <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
 
  
            
</body>
</html>
<? ob_flush(); ?>