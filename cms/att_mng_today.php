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
                <li class="no-hover"><a href="#" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Student Absent List</li>                
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
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
						<h1>Select Date and Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" method="get">
                    	<div class="_25">
							<p>
								<label for="select">Select Date : <span class="error">*</span></label>
                                <input id="datepicker" name="date" type="text" value=""  />
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Standard :</label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" onchange="showCategory(this.value)"> <option value="">All</option>';
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
								<label for="select">Section / Group :</label>
                               <select name="sid" id="sid">
											<option value="">All</option>											
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
							$date=$_GET['date'];
							if(!$date){
								$date=date("d/m/Y");
							}
							$idatesplit=explode("/",$date);  
							$day=$idatesplit[0]; 
							$month=$idatesplit[1];
							$year=$idatesplit[2];
							
				if($date){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
		<div class="grid_12">
				<h1><?php echo $date;?> - Student Absent List</h1>
                <?php if($date){?>
                 <a href="att_today_export.php?date=<?php echo $date."&cid=".$cid."&sid=".$sid."&bid=".$bid."&acid=".$acyear;?>" target="_blank"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Report <?php echo "( ".$date." )";?></button></a>
                <span style="margin:0px 10px 0 0px; float:right;"><img src="./img/tick.png"> Present &nbsp; | &nbsp;<img src="./img/close.png"> Absent </strong> &nbsp; | &nbsp;<img src="./img/off-m.png"> Morning Absent &nbsp; | &nbsp;<img src="./img/off-e.png"> Afternoon Absent </span>  
                <?php }?>                   
			</div>
            <?php if($date){
				?>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $date;?> Student Absent List</b></h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <th>Parent's name</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Class-Section</th>
                        			<th><center> Details </center></th>
								</tr>
							</thead>
							<tbody>                    			
                            <?php 
							//$qry=mysql_query("SELECT distinct ss_id FROM attendance WHERE c_id=$cid AND s_id=$sid AND m_id=$mid AND ay_id=$acyear");
							$qry="SELECT result,result_half,ss_id FROM attendance WHERE day=$day AND month=$month AND year=$year AND ay_id=$acyear AND (result='0' OR result='off')";
							if($cid){
								$qry .=" AND c_id=$cid";
							}if($sid){
								$qry .=" AND s_id=$sid";
							}
							$qry=mysql_query($qry);
				$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
						$ssid=$row['ss_id'];
								   $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								   $student=mysql_fetch_array($studentlist);
								   $result=$row['result'];
								   $result_half=$row['result_half'];
								   	$cid=$student['c_id'];
									$sid=$student['s_id'];
									$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);
								   if($result=='0' || $result=='off'){
						?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php if($student['gender']=='M'){ echo 'Male'; }else if($student['gender']=='F'){ echo"Female"; }?></center></td>
                                <td><center><?php echo $student['phone_number']; ?></center></td>
                                <td><center><?php echo $class['c_name']."/".$section['s_name']; ?></center></td>
                                <?php if($result=='0'){?>
								<td style="background:#FC6366; border:1px solid #000000"><center><img src="./img/close.png" alt="absent" title="Absent"></center></td>
                                <?php }else if($result=='off'){?>
                                <td style="background:#FF0004;border:1px solid #000000"><center><?php if($result_half=="M"){?><img src="./img/off-m.png" alt="Morning absent" title="Morning Absent"><?php }else if($result_half=="E"){?><img src="./img/off-e.png" alt="Afternoon absent" title="Afternoon Absent"><?php }?></center></td>
								<?php }?>
								</tr> 
                                 <?php 
							$count++;
								   }
							} ?>     
							</tbody>
						</table>
					</div>
				</div>
            </div> <?php } ?>
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
	$('#table-example').dataTable({
  'iDisplayLength': 50
});
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
  
  <script defer src="js/zebra_datepicker.js"></script>
  
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
	
	$( ".date" ).change(function() {
	  alert( "Handler for .change() called." );
	});	
		
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'att_mng_today.php?bid='+cid+'&date=<?php echo $date;?>';	  
	} 
	function change_function1() { 
	alert("test");
     var cid =document.getElementById('datepicker').value;
	 window.location.href = 'att_mng_today.php?bid=<?php echo $bid;?>&date='+cid;	  
	}
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
                document.getElementById("sid").innerHTML = "<option value=''>All</option>"+xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script> 
<?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>