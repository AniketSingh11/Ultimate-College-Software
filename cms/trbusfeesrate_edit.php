<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 
 if (isset($_POST['submit']))
{
	$busfees=$_POST['busfees'];
	$spfees=$_POST['spfees'];
	$onetimespfees=$_POST['onetimespfees'];
	$onetime=$_POST['onetime'];
	$rid=$_POST['rid'];
	$spid=$_POST['spid'];
	$bfid=$_POST['bfid'];
	$ftyid=$_POST['ftyid'];
	$lftyid=$_POST['lftyid'];
	$status=$_POST['status'];
		
		$sql=mysql_query("UPDATE trbusfees SET fees='$busfees',sp_fees='$spfees',sp_fees_onetime='$onetimespfees',one_time='$onetime',r_id='$rid',status='$status' WHERE bf_id='$bfid'");		
	if($sql){
			if($ftyid!=$lftyid){
			$qry=mysql_query("SELECT * FROM trstopping");
			  while($row=mysql_fetch_array($qry))
        		{
					$spid=$row['sp_id']; 
					$sql=mysql_query("UPDATE trbusfees SET ftyid='$ftyid' WHERE sp_id='$spid'");					
				}
			}
        header("Location:trbusfeesrate_edit.php?bfid=$bfid&msg=succ");
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
	
	<!-- Begin of midebar -->
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
    	
    </aside> <!--! end of #midebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    	
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover"><a href="trbus_feesrate.php" title="Stopping Name List">Bus Fees Rate</a></li>
                <li class="no-hover">Edit Bus Fees Rate</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit Bus Fees Rate</h1>                
			<a href="trbus_feesrate.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit Bus Fees Rate</h1><span></span>
					</div>
                    <?php 
							$bfid=$_GET['bfid'];
							$busfeeslist1=mysql_query("SELECT * FROM trbusfees WHERE bf_id=$bfid"); 
								$busfees1=mysql_fetch_array($busfeeslist1);
								$spid=$busfees1['sp_id'];
							?>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_100">
                         <p>
                        <table id="table-example" class="table">
							<thead>
								<tr>
									<th><center>From</center></th>
                                    <th><center>Stopping Name</center></th>
                                    <th class="action"><center>Fees</center></th>
                                    <th class="action"><center>Sp.Fees</center></th>
                                    <th class="action"><center>Onetime Sp.Fees</center></th>
                                    <th class="action"><center>Onetime Fees</center></th>
                                </tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid");
						$row=mysql_fetch_array($qry);
        				$spid=$row['stop_id'];
						$rid=$row['r_id'];
						$busfeeslist=mysql_query("SELECT * FROM trbusfees WHERE bf_id=$bfid AND r_id=$rid AND sp_id=$spid"); 
								$busfees=mysql_fetch_array($busfeeslist);
								$ftyid=$busfees['ftyid'];
					?>
								<tr class="gradeX">
								<td><center>From School</center></td>
                                <td><center><?php echo $row['stop_name']; ?></center></td>
                                <td><center><input id="textfield" name="busfees" type="text" value="<?php if($busfees['fees']){ echo $busfees['fees']; } ?>" /></center></td>
                                <td><center><input id="textfield" name="spfees"  type="text" value="<?php if($busfees['sp_fees']){ echo $busfees['sp_fees']; } ?>" /></center></td>
                                <td><center><input id="textfield" name="onetimespfees"  type="text" value="<?php if($busfees['sp_fees_onetime']){ echo $busfees['sp_fees_onetime']; }?>" /></center></td>
                                <td><center><input id="textfield" name="onetime" type="text" value="<?php if($busfees['one_time']){ echo $busfees['one_time']; } ?>" /></center></td>
                                <input type="hidden" name="spid" value="<?php echo $spid;?>"/>
                                <input type="hidden" name="bfid" value="<?php echo $bfid;?>"/>
                                <input type="hidden" name="rid" value="<?php echo $rid;?>"/>
							</tbody>
						</table></p>
                  </div>
                  		<div class="_25">
						  <p>
                                <label for="textfield">Fees Type</label>
                                <select name="ftyid" class="required"  >
                                	<!--<option value="">Select no of months</option>-->
                                	<?php $qry1=mysql_query("SELECT * FROM ftype");
													$count=1;
									  while($row1=mysql_fetch_array($qry1))
										{ if($ftyid==$row1['fty_id']){ ?>
                                    <option value="<?php echo $ftyid;?>" selected><?php echo $row1['fty_name'];?></option>
                                    <?php }else { ?>
                                    <option value="<?php echo $row1['fty_id'];?>"><?php echo $row1['fty_name'];?></option>
                                    <?php } }?>
                                </select>
                            </p>
						</div> 
                        <div class="_25">
							<p>
								<label for="select">Active Status :</label>
									<select name="status">
												<option value="1" <?php if($busfees1['status']=='1'){ echo 'selected'; }?>>Enabled</option>
												<option value="0" <?php if($busfees1['status']=='0'){ echo 'selected'; }?>>Disabled</option>
									</select>								
							</p>
						</div>
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" name="lftyid" value="<?php echo $ftyid;?>" />
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