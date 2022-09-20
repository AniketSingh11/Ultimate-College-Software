<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	 $salary=$_POST['salary'];
	 $mid1=$_POST['mid1'];
	 $syid=$_POST['syid'];
		
		$qry=mysql_query("UPDATE salary SET amount='$salary',m_id='$mid1', ay_id='$acyear' WHERE sy_id='$syid'");
    if($qry){
        header("Location:salary_edit.php?syid=$syid&mid=$mid1&msg=succ");
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
            <?php 
							$mid=$_GET['mid'];
							$montharray=array("June","July","August","September","October","November","December","January","February","March","April","May"); 
								  ?>
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="salary_mng.php?mid=<?php echo $mid;?>" title="Home">Staff Salary Management</a></li>
                <li class="no-hover">Edit Staff Salary</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit staff Salary <b>( <?php echo $montharray[$mid-1];?> )</b></h1>                
			<a href="salary_mng.php?mid=<?php echo $mid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your staff Salary Successfully Edited!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit staff Salary <b>( <?php echo $montharray[$mid-1];?> )</b></h1><span></span>
					</div>
                    <?php 
							$syid=$_GET['syid'];
							$classlist=mysql_query("SELECT * FROM salary WHERE sy_id=$syid"); 
								  $salary=mysql_fetch_array($classlist);	
								  $st_id=$salary['st_id'];
								  $studentlist=mysql_query("SELECT * FROM staff WHERE st_id=$st_id"); 
								   $staff=mysql_fetch_array($studentlist);
							?>
					<form id="validate-form" class="block-content form" action="" method="post">
                    <div class="_50">
                    <p>
                                    <label for="required">Salary Month:</label>
                                    <?php 
				$montharray=array("June","July","August","September","October","November","December","January","February","March","April","May"); 
				?>	
                                    <select name="mid1" id="mid1" class="required" >
                                    <?php
				$qry2=mysql_query("SELECT * FROM year ORDER BY ay_id DESC LIMIT 1");
				$row2=mysql_fetch_array($qry2);
				
				$monthno=date("m");
				 			$qry1=mysql_query("SELECT * FROM month WHERE ay_id=$acyear");
							$mcount=1;
							$count=1;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$mno=$row1['m_no'];	
					if($mcount==1){
				 if($mid==$row1['m_id']){?>
                 <option value="<?php echo $row1['m_id'];?>" style="background-color:#D6EDF8" selected><?php echo $row1['m_name']?></option>
            <?php } else { ?>				
            <option value="<?php echo $row1['m_id'];?>" style="background-color:#D6EDF8" ><?php echo $row1['m_name']?></option>           
            <?php } }
			if($mno==$monthno && $row2['ay_id']==$acyear){
						$mcount=0;
					} 
				}?>	
                                    </select>										
								</p> <!-- .field-group -->
                    </div>
						<div class="_100">
							<p>
                                <label for="textfield">Staff Name</label>
                                <input id="textfield" name="sname" type="text" value="<?php echo $staff['fname']." ".$staff['mname']." ".$staff['lname']; ?>" readonly />
                            </p>
						</div>
                        <div class="_100">
							<p>
                                <label for="textfield">Salary</label>
                                <input id="textfield" name="salary" class="required" type="text" value="<?php echo $salary['amount']; ?>" />
                            </p>
						</div>
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="syid" value="<?php echo $syid;?>" > 
                            <input type="hidden" class="medium" name="mid" value="<?php echo $mid;?>" > 
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
			location.reload(); 
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
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