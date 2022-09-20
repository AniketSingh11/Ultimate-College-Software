<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$ex_subcategory=trim($_POST['ecname']);
    $exsid=$_POST['exsid'];
		$qry=mysql_query("UPDATE ex_insubcategory SET sub_name='$ex_subcategory' WHERE exs_id='$exsid'");
    if($qry){
        header("Location:esubcategory_edit.php?exsid=$exsid&msg=succ");
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
				<li class="no-hover"><a href="exponses_subcategory.php" title="Exponses Category">Exponses Sub Category list</a></li>
                <li class="no-hover">Edit Exponses Sub Category</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Exponses Sub Category</h1>                
			<a href="exponses_subcategory.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Expenses Sub Category</h1><span></span>
					</div>
                    <?php 
							$exsid=$_GET['exsid'];
							$classlist=mysql_query("SELECT * FROM ex_insubcategory WHERE exs_id=$exsid"); 
							$class=mysql_fetch_array($classlist);	

							$category=$class["category"];
							$sub_name=$class["sub_name"];
							$count=$class["count"];
							
							
							$subcat=array();
							for($j=1;$j<=20;$j++)
							{
							$sub_id=$class["sub$j"."_id"];
							
							if($sub_id!=0){
							    array_push($subcat,$sub_id);
							}
							}
							
							
							
							
							$insub_name="";
							    foreach ($subcat as $val){
							
							    $qry1=mysql_fetch_array(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$val'"));
							        $insub_name.=$qry1["sub_name"]."&nbsp;>&nbsp;";
							
							    }
							    if($count!=0)
							    {
							    $qry1=mysql_fetch_array(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$subcat[0]'"));
							    $sub_catname=$qry1["sub_name"];
							    }else{
							       
							        $sub_catname=$sub_name;
							    }
							    
							    
			 				?>
					<form id="validate-form" class="block-content form" action="" method="post">
					
					  <div class="_100">
							<p>
                                <label for="textfield">Expenses  Category :
                              
                               
                                <?php $classl = "SELECT * FROM ex_category where exc_id='$category' ";
                                    $result1 = mysql_query($classl) or die(mysql_error());
                                while ($row1 = mysql_fetch_assoc($result1))
                                {
                                    $ex_category=$row1["ex_category"];
                                    $exc_id=$row1["exc_id"];
                            echo  $ex_category; 
                             
                                }
                                ?>
                                </label>
                            </p>
						</div>
						
						<div class="_100">
							<p>
                               
                                <?php if($count==0)
                                {?> <label for="textfield">Exponses Sub  Category</label>
                                <input id="textfield" name="ecname" class="required" type="text" value="<?php echo $sub_catname; ?>" />
                                <?php }else{?>
                                  <label for="textfield">Exponses Sub  Category :<?php echo $sub_catname; ?></label>
                                <?php }?>
                            </p>
						</div>
						<?php if($count!=0)
						{?>
						<div class="_100">
							<p>
                                <label for="textfield">Exponses Inner Sub  Category :<?=$insub_name.$sub_name?></label>
                               
                            </p>
						</div>
						
						<div class="_100">
							<p>
                                <label for="textfield">Edit Inner Sub  Category</label>
                                <input id="textfield" name="ecname" class="required" type="text" value="<?php echo $sub_name; ?>" />
                            </p>
						</div>
						
						
						
						<?php }?>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="exsid" value="<?php echo $exsid;?>" > 
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
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>