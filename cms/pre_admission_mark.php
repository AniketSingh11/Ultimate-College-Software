<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/admission.php");
 $bid=$_GET['bid'];
 $cid=$_GET['cid']; 	
		
 if (isset($_POST['submit']))
{
	$qry=mysql_query("SELECT * FROM pre_admission WHERE ay_id='$acyear' AND b_id='$bid' AND c_id='$cid' AND status='0' ORDER BY firstname ASC");							
					while($student12=mysql_fetch_array($qry))
					{ 
						$paid=$student12['pa_id'];
						 $mname="mark".$paid;
						 $mark = $_POST[$mname];
						 
						 $rname="remark".$paid;
						 $remark = $_POST[$rname];
						 
						 $sname="select".$paid;
						 $status = $_POST[$sname];
						 
						 $sql="UPDATE pre_admission SET status='$status',mark='$mark',remark='$remark' WHERE pa_id='$paid'"; 
						$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());				
					}
		if(!$result)
{
die("Query Failed: ". mysql_error());
}
else
{
 header("Location:pre_admission_mark.php?bid=$bid&cid=$cid&msg=succ");
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
    <?php $msg=$_GET['msg']; 
						$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  $classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
			?>
    <!-- Begin of #main -->
    <div id="main" role="main">
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_pre.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li class="no-hover"><a href="pre_admission_select.php?bid=<?php echo $bid; ?>&cid=<?php echo $cid;?>" title="Pre Admisson Selection">Pre Admission selection</a></li> 
                <li class="no-hover"><?php if($cid){ echo $class['c_name']." - "; }?>Update Student Mark & Selection</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1><?php if($cid){ echo $class['c_name']." - "; }?>Update Student Mark & Selection</h1>                
			<a href="pre_admission_select.php?bid=<?php echo $bid; ?>&cid=<?php echo $cid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php 
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Salary Details Successfully updated!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Update Student Mark & Selection</h1><span></span>
					</div>
					<?php 
					$qry=mysql_query("SELECT * FROM pre_admission WHERE ay_id='$acyear' AND b_id='$bid' AND c_id='$cid' AND status='0' ORDER BY firstname ASC");
					$student12=mysql_fetch_array($qry);
					
					    $std_value=$student12['std_value'];
					    
					?>
					
					<form id="validate-form" class="block-content form" action="" method="post">
                    	<div class="_100">
                         <p>
                         <label for="textfield">Fill Pre admission Status: </label>
                        <table class="table">
                  	<thead>
                    	<th><center>S.No</center></th>
                    	<th><center>Pre Admin No</center></th>
                        <th><center>Student Name</center></th>
                         <?php if($std_value=="XI STD"){?>
                        <th><center>Tamil(1 & 2) paper Mark</center></th>
                         <th><center>English(1 & 2) paper Mark</center></th>
                         <th><center>Maths</center></th>
                          <th><center>physics</center></th>
                           <th><center>Chemistry</center></th>
                            <th><center>Social</center></th>
                            <th><center>Total</center></th>
                            <?php } else{?>
                          <th><center>Mark</center></th>
                          <?php } ?>
                        
                        <th><center>Remark</center></th>
                        <th><center>Selection</center></th>
                       </thead>
                    </thead>
                    <tbody>
                    	<?php 
						 $att=1;
						 $qry=mysql_query("SELECT * FROM pre_admission WHERE ay_id='$acyear' AND b_id='$bid' AND c_id='$cid' AND status='0' ORDER BY firstname ASC");							
					while($student12=mysql_fetch_array($qry))
					{ 
					    $ele_mark=explode(",",$student12['ele_mark']);
					    $std_value=$student12['std_value'];
					//$id=$queryfetch['admission_number'];?>
                        <tr>
                        <td><center><?php echo $att;?></center></td>
                        <td><center><?php echo $student12['pa_admission_no']?></center></td>
                        <td><center><?php echo $student12['firstname']." ".$student12['lastname']; ?></center></td>
                        <?php if($std_value=="XI STD"){?>
                        <td><center><?php echo $ele_mark[0]."-".$ele_mark[1];?></center></td>
                        <td><center><?php echo $ele_mark[2]."-".$ele_mark[3];?></center></td>
                        <td><center><?php echo $ele_mark[4];?></center></td>
                        <td><center><?php echo $ele_mark[5];?></center></td>
                        <td><center><?php echo $ele_mark[6];?></center></td>
                         <td><center><?php echo $ele_mark[7];?></center></td>
                         <td><center><?php echo $ele_mark[8];?></center></td>
                        <?php }else{?>
                        <td><input type="text" id="textfield" name="<?php echo "mark".$student12['pa_id']?>" /></td>
                        <?php }?>
                        
                        <td><input type="text" id="textfield" name="<?php echo "remark".$student12['pa_id']?>" /></td>
                        <td><select name="<?php echo "select".$student12['pa_id']?>">
                        	<option value="0">please select</option>
                            <option value="1">Selected</option>
                            <option value="2">Rejected</option>                            
                        </td>
                        </tr>
                     <?php $att++; } ?>
                    </tbody>
                  </table></p><br><br>	
                  </div>                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">                            
                        	<input type="hidden" name="att" value="<?php echo $att;?>" />   
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
			location.reload(); 
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'm/d/Y'
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