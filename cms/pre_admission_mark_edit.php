<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/admission.php");
  $paid=$_GET['paid'];
  $bid=$_GET['bid'];
		$cid=$_GET['cid']; 

 if (isset($_POST['submit']))
{
	$bid1=mysql_real_escape_string($_POST['b_id']);
	$cid1=mysql_real_escape_string($_POST['cid']);
	$mark=mysql_real_escape_string($_POST['mark']);
	$remark=mysql_real_escape_string($_POST['remark']);
	$status=mysql_real_escape_string($_POST['status']);		 
    $sql="UPDATE pre_admission SET c_id='$cid1',b_id='$bid1',status='$status',mark='$mark',remark='$remark' WHERE pa_id='$paid'";
 
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:pre_admission_mark_edit.php?paid=$paid&bid=$bid&cid=$cid&msg=succ");
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
    				<?php 	
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
					$studentlist=mysql_query("SELECT * FROM pre_admission WHERE pa_id=$paid"); 
								  $row=mysql_fetch_array($studentlist);
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
               <li class="no-hover"><a href="board_select_pre.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li class="no-hover"><a href="pre_admission_select.php?bid=<?php echo $bid; if($cid){ echo "&cid=".$cid;}?>" title="Pre Admisson Selection">Pre Admission selection</a></li> 
                <li class="no-hover">Pre Admission Mark Edit ( <?php echo $row['pa_admission_no'];?> )</li>
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">			
			<div class="grid_12">
				<h1>Pre Admission Mark Edit ( <?php echo $row['pa_admission_no'];?> )</h1>                
			<a href="pre_admission_select.php?bid=<?php echo $bid; if($cid){ echo "&cid=".$cid;}?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <?php 
			if($row['status']=='1'){?>
            <a href="admission_single.php?bid=<?php echo $bid;?>" style="margin:0px 0 0 10px; float:right"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png">To Main Admission</button></a>
            <?php } ?>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Edited!!!</div>
            <?php }else if($msg=="eronfile"){?>			
            <div class="alert error"><span class="hide">x</span>Please Upload this type of file only (.png , .jpg , .Gif) AND also file size lessthen 1MB!!!</div>
            <?php } ?>            
				<div class="block-border">
					<div class="block-header">
						<h1>Pre Admission Mark Edit ( <?php echo $row['pa_admission_no'];?> )</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_25">
							<p>
                                <label for="textfield">Pre Admin NO : <span class="error">*</span></label>
                                <input id="textfield" name="admin_no" class="required" type="text" value="<?php echo $row['pa_admission_no'];?>" readonly  />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">First Name: <span class="error">*</span></label>
                                <input id="textfield" name="fname" class="required" type="text" value="<?php echo $row['firstname'];?>" readonly />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Last Name:</label>
                                <input id="textfield" name="lname" type="text" value="<?php echo $row['lastname'];?>" readonly />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Select Board: <span class="error">*</span></label>
                                <select name="b_id" id="bid" onchange="showCategoryboard(this.value)" >
                                <option value="">Select Board</option>
                                <?php 
							$qry1=mysql_query("SELECT * FROM board");
							$bid1=$row['b_id'];
							$cid1=$row['c_id'];
							
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $class=mysql_fetch_array($classlist);
								  
			  while($row1=mysql_fetch_array($qry1))
        		{ 
				if($bid1==$row1['b_id']){?>
                				<option value="<?php echo $row1['b_id']; ?>" selected><?php echo $row1['b_name']; ?></option>
                  <?PHP }else { ?>
                  		<option value="<?php echo $row1['b_id']; ?>"><?php echo $row1['b_name']; ?></option>
                  <?PHP }  }?>
                  
                  </select>
                            </p>
						</div>
                        <div class="clear"></div>
                        <div class="_25">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                               <select name="cid" id="cid" class="required">
											<option value="<?php echo $row['c_id']; ?>"><?php echo $class['c_name'];?></option>											
								</select>
							</p>
						</div>
						<?php 
						$ele_mark=explode(",",$row['ele_mark']);
						$sel_group=$row['ele_group'];
						$ele_prefer=explode(",",$row['ele_prefer']);
						$std_value=$row['std_value'];
						
						if($std_value!="XI STD"){?>
                        <div class="_25">
							<p>
                                <label for="textfield">Mark : <span class="error">*</span></label>
                                <input id="textfield" name="mark" class="required" type="text" value="<?php echo $row['mark'];?>" />
                            </p>
						</div>
						<?php }?>
                        <div class="_25">
							<p><label for="textarea">Remark : </label><textarea id="textarea" name="remark"  rows="3" cols="40"><?php echo $row['remark'];?></textarea></p>
						</div>
                       <div class="_25">
							<p>
								<label for="select">Selection :</label>
								<select name="status"><?php $gen=$row['status'];?>
                                	<option value="0">select status</option>
									<option value="1" <?php if($row['status']=='1'){ echo 'selected'; }?>>Selected</option>
									<option value="2" <?php if($row['status']=='2'){ echo 'selected'; }?>>Rejected</option>
								</select>
							</p>
						</div>
						<?php if($std_value=="XI STD"){?>
						
						 <div class="_100" >
                         <table class="table"  >
                         <tr>
                         <th width="10%" ><center>S.No</center></th>
                      <th> <center>Subject</center></th>
                      <th><center>Mark</center></th>
                      </tr>
                         <tr>
                         <td><center>1</center></th>
                         <td><center>Tamil 1sd Paper</center></th>
                        <td><center> <?=$ele_mark[0]?></center></td>
                        </tr>
                         <tr>
                         <td><center>2</center></th>
                          <td><center>Tamil 2nd Paper</center></td>
                           <td><center> <?=$ele_mark[1]?></center></td>
                           </tr>
                           <tr>
                           <td><center>3</center></th>
                          <td><center>English 1st Paper</center></td>
                           <td><center> <?=$ele_mark[2]?></center></td>
                           </tr>
                           
                            <tr>
                            <td><center>4</center></th>
                          <td><center>English 2nd Paper</center></td>
                           <td><center> <?=$ele_mark[3]?></center></td>
                            </tr>
                            <tr>
                            <td><center>5</center></th>
                          <td> <center>Maths</center> </td>
                           <td><center> <?=$ele_mark[4]?></center></td>
                           </tr>
                            <tr>
                            <td><center>6</center></th>
                          <td><center> Physics </center></td>
                          <td><center> <?=$ele_mark[5]?></center></td>
                          </tr>
                           <tr>
                           <td><center>7</center></th>
                          <td><center> Chemistry </center></td>
                           <td><center> <?=$ele_mark[6]?></center></td>
                             </tr>
                            <tr>
                            <td><center>8</center></th>
                          <td> <center>Social Science </center></td>
                           <td><center> <?=$ele_mark[7]?></center></td>
                            </tr>
                           <tr>
                           <td></th>
                          <td><center> Total</center> </td>
                           <td><center> <?=$ele_mark[8]?></center></td>
                         </tr> 
                       
                         </table>
                         
                          </div><br>
                          <div class="clear"></div>
                          <div class="_25">
							<p>
                                <label for="textfield">Select Group: <span class="error"></span></label>
                                <?php echo $sel_group;?>
                                 
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">1st Preference: <span class="error"></span></label>
                                <?php echo $ele_prefer[0];?>
                                 
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">2nd Preference: <span class="error"></span></label>
                                <?php echo $ele_prefer[1];?>
                                 
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">3rd Preference: <span class="error"></span></label>
                                <?php echo $ele_prefer[2];?>
                                 
                            </p>
						</div> 
						
						<?php }?>
						
						
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
  <script defer src="js/zebra_datepicker.js"></script>
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		/*
		 * Datepicker
		 */
				
		$( "#datepicker1" ).Zebra_DatePicker({
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
 <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
    function showCategoryboard(str) {
        if (str == "") {
            document.getElementById("cid").innerHTML = "";
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
                document.getElementById("cid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "classlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }	  
</script>    
</body>
</html>
<? ob_flush(); ?>