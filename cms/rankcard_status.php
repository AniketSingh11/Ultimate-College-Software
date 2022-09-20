<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
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
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                 <li class="no-hover"><a href="board_select_rank1.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Progress Card Visit Status</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="board_select_rank1.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div class="_25" style="float:right">
                <label for="select">Board :</label>
                                	<?php
                                            $classl = "SELECT * FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="bid" id="bid" class="required" onchange="change_function()">';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($bid ==$row1['b_id']){
                                                echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
												} else {
												echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Exam , Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get">
                    <div class="_25">
							<p>
								<label for="select">Exam : <span class="error">*</span></label>
                                	<?php
                                            $classl1 = "SELECT e_id,e_name FROM exam where ay_id=$acyear";
                                            $result11 = mysql_query($classl1) or die(mysql_error());
                                            echo '<select name="eid" id="eid" class="required"> <option value="">Select Exam</option>';
											while ($row11 = mysql_fetch_assoc($result11)):
                                                echo "<option value='{$row11['e_id']}'>{$row11['e_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
						<div class="_25">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="required" onchange="showCategory(this.value)"> <option value="">Select Class</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Section / Group : <span class="error">*</span></label>
                               <select name="sid" id="sid" class="required">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                       
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $bid;?>" >
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
			<?php
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$eid=$_GET['eid'];
							$subid=$_GET['subid'];							
				if($cid && $sid && $eid){
							$examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
								  
								  if(!$subid){
								$qry7=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
								$subjectlist=mysql_fetch_array($qry7);
									$subid=$subjectlist['sub_id'];
								}								
							if($subid){
							$subjectlist=mysql_query("SELECT * FROM subject WHERE sub_id=$subid"); 
								  $subject=mysql_fetch_array($subjectlist);
								   $slid1=$subject['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid1'"); 
								   $slist1=mysql_fetch_array($subjectlist1);
								   $paper=$slist1['paper'];
								  	  }
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
		<div class="grid_12">
				<h1><?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Progress Card Status</h1>
                <?php if($cid && $subid && $sid){?>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } }?>                   
			</div>
            <?php if($cid && $sid && $eid){?>
            <div class="grid_12">
				<div class="block-border" id="tab-panel-1">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Progress Card Status</h1> 
                        <ul class="tabs" style="margin-right:60px;">
							<li><a href="#tab-1">Visited</a></li>
							<li><a href="#tab-2">Non-Visit</a></li>
						</ul>
                        <span></span>
					</div>
					<div class="block-content tab-container">
                    <div id="tab-1" class="tab-content">
							<br>
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <th>Father Name</th>
                                    <th>Phone No</th>
                                    <th>remark</th>
                                    <th>status</th>
                                    <th>Progress Card</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$resultarray=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
							$nofrow=mysql_num_rows($resultarray);
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear");
							$count=1;
			  while($student=mysql_fetch_array($qry))
        		{
						$ssid=$student['ss_id'];
						$rankarray=mysql_query("SELECT * FROM rankcard_status WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
						$rankcard=mysql_fetch_array($rankarray);
							$rstatus=mysql_num_rows($rankarray);
						if($nofrow>1 && $rstatus){
						?> 
								<tr class="gradeX1" style="border-top:dotted 1px #000;">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?></center></td>
                                <td <center><?php echo $student['fathersname']; ?></center></td>
                				<td><center><?php echo $student['phone_number']; ?></center></td>
                               <td <center><?php echo $rankcard['remark']; ?></center></td>
                				<td><center><?php if($rankcard['status']==1){ echo "Visited"; } ?></center></td>
                                <td><a href="rank_list_student.php?ssid=<?php echo $ssid;?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" title="View"> <button class="btn btn-small btn-success" > View </button> </a></td>	                
                                </tr> 
                                 <?php 
							$count++;
						}} ?>                               																
							</tbody>
						</table>
                        </div>
                        <div id="tab-2" class="tab-content">
                        <br>
                        <table id="table-example1" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <th>Father Name</th>
                                    <th>Phone No</th>
                                    <th>Progress Card</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$resultarray=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
							$nofrow=mysql_num_rows($resultarray);
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear");
							$count=1;
			  while($student=mysql_fetch_array($qry))
        		{
						$ssid=$student['ss_id'];
						$rankarray=mysql_query("SELECT * FROM rankcard_status WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
							$rstatus=mysql_num_rows($rankarray);
						if($nofrow>1 && !$rstatus){
						?> 
								<tr class="gradeX1" style="border-top:dotted 1px #000;">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?></center></td>
                               <td <center><?php echo $student['fathersname']; ?></center></td>
                				<td><center><?php echo $student['phone_number']; ?></center></td>
                                <td><a href="rank_list_student.php?ssid=<?php echo $ssid;?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" title="View"> <button class="btn btn-small btn-success" > View </button> </a></td>	                
                                </tr> 
                                 <?php 
							$count++;
						}} ?>                               																
							</tbody>
						</table>
                        
                        </div>
					</div>
				</div>
            </div> <?php } else {?>
            <center><h3 class="succ"> Please Select Subject </h3></center> <?php } ?>
            <div class="clear height-fix"></div>
<?php } ?>
		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
  <script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	$('#table-example').dataTable();
	$('#table-example1').dataTable();
// Code that uses jQuery's $ can follow here.
});
// Code that uses other library's $ can follow here.
</script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		$("#tab-panel-1").createTabs();
		
	});
  </script>
  <!-- end scripts-->

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
            document.getElementById("sid").innerHTML = "";
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
                document.getElementById("sid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
	
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'rankcard_status.php?bid='+cid;	  
	} 
</script>  
</body>
</html>
<? ob_flush(); ?>