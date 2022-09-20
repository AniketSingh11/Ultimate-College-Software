<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$fgid1=$_POST['fgid1'];
	$frid=$_POST['frid'];
	$cid=$_POST['cid'];
	$bid=$_POST['bid'];
	$rate=$_POST['rate'];
	
					//$sql=mysql_query("UPDATE mfrate SET fg_id='$fgid1' WHERE fr_id='$frid'") or die("Could not insert data into DB: " . mysql_error());
						//$lastid=mysql_insert_id();						
				$select_record=mysql_query("SELECT * FROM fdiscount");
					$count=1;
					while($student12=mysql_fetch_array($select_record))
					{ 
						$fdisid=$student12['fdis_id'];
                        $fdis="fdisname".$count;
						$fdisvalue=$_POST[$fdis];
						$sql1=mysql_query("UPDATE mfrate_value SET dis_value='$fdisvalue' WHERE fr_id='$frid' AND fdis_id='$fdisid'") or die("Could not insert data into DB: " . mysql_error());
               $count++; 
			   }
		
//$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($sql1){
        header("Location:mfeesrate_edit.php?cid=$cid&rate=$rate&bid=$bid&frid=$frid&msg=succ");
    }
    /*exit;
	
	$fty_name=$_POST['ftyname'];
	$fty_value=$_POST['ftyvalue'];
	$ftyid=$_POST['ftyid'];
		
		$qry=mysql_query("UPDATE ftype SET fty_name='$fty_name',fty_value='$fty_value', ay_id='$acyear' WHERE fty_id='$ftyid'");
    if($qry){
        header("Location:ftype_edit.php?ftyid=$ftyid&msg=succ");
    }*/
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
		$bid=$_GET['bid'];
		$cid=$_GET['cid'];
		$rate=$_GET['rate'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  $classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                 <li class="no-hover"><a href="mboard_select_feesrate.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="mfeesrate.php?cid=<?php echo $cid;?>&bid=<?php echo $bid;?>&rate=<?php echo $rate;?>" title="Fees Rate">Fees Rate</a></li>
                <li class="no-hover">Edit Fees Rate</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Fees Rate - <?php echo $class['c_name'];?> (<?php echo $rate;?> Rate)</h1>                
			<a href="mfeesrate.php?cid=<?php echo $cid;?>&bid=<?php echo $bid;?>&rate=<?php echo $rate;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Fees Rate - <?php echo $class['c_name'];?> (<?php echo $rate;?> Rate)</h1><span></span>
					</div>
                    <?php 
							$frid=$_GET['frid'];
							$classlist=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid");
								  $class=mysql_fetch_array($classlist);	
								  $fg_id=$class['fg_id'];
								  $fgd_id=$class['fgd_id'];
							?>
					<form id="validate-form" class="block-content form" action="" method="post">
						 <div class="_100">
                         <p>
                        <table class="table">
                  	<thead>
                    	<th><center>Group Name</center></th>
                        <?php 							
							$qry1=mysql_query("SELECT * FROM fdiscount");							
			  while($row1=mysql_fetch_array($qry1))
        		{ ?>
                                    <th><?php echo $row1['fdis_name'];?></th>
                            <?php } ?>
                       </thead>
                    </thead>
                    <tbody>
                    	<tr>
                        <td><select name="fgid1" class="required"  >
                                	<?php $qry1=mysql_query("SELECT * FROM mfgroup");													
									  while($row1=mysql_fetch_array($qry1))
										{ if($fg_id==$row1['fg_id']){?>
                                    <option value="<?php echo $fg_id;?>" selected><?php echo $row1['fg_name'];?></option>
                                    <?php }  }
									$qry1=mysql_query("SELECT * FROM mfgroup_detail");													
									  while($row1=mysql_fetch_array($qry1))
										{ if($fgd_id==$row1['fgd_id']){?>
                                    <option value="<?php echo $fgd_id;?>" selected><?php echo $row1['name'];?></option>
                                    <?php }  } ?>
                                </select></td>
                        <?php 
					$select_record=mysql_query("SELECT * FROM fdiscount");
					$count=1;
					while($student12=mysql_fetch_array($select_record))
					{ 
					$fdisid2=$student12['fdis_id'];
				$frvaluelist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND ay_id=$acyear"); 
								  $frvalue=mysql_fetch_array($frvaluelist);	
					?>
                        <td><center><input id="textfield" name="fdisname<?php echo $count;?>" class="required" type="text" value="<?php echo $frvalue['dis_value']; ?>" /></center></td>
                       <?php $count++; } ?>
                        </tr>
                        <input type="hidden" name="cid" value="<?php echo $cid;?>" />
                        <input type="hidden" name="rate" value="<?php echo $rate;?>" />
                        <input type="hidden" name="bid" value="<?php echo $bid;?>" />
                        <input type="hidden" name="frid" value="<?php echo $frid;?>" />                        
                    </tbody>
                  </table></p>
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
  
  <!-- end scripts-->
<script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 			
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