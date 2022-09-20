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
                <li class="no-hover"><a href="board_select_stu.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Student Attendance Management</li>                
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="board_select_att.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
						<h1>Select Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" method="get">
                    	<div class="_50">
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
                        <div class="_50">
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
                            <input type="hidden" class="medium" name="mid" value="<?php echo $monthsw['m_id'];?>">
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
			<?php
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							//$eid=$_GET['eid'];
							$mid=$_GET['mid'];
							
							
				if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							if($mid){
							$subjectlist=mysql_query("SELECT * FROM month WHERE m_id=$mid"); 
								  $month=mysql_fetch_array($subjectlist);	  }
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
		<div class="grid_12">
				<h1><?php echo $class['c_name']."-".$section['s_name'];?> Student Attendence <b><?php if($mid){?>( <?php echo $month['m_name'];?> )<?php } ?></b></h1>
                
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
					if($mcount==1){?>
                 <a href="att_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&mid=<?php echo $row1['m_id']; ?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-error" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> <?php echo $row1['m_name']; ?></button></a>
                <?php }
				if($mno==$monthno && $row2['ay_id']==$acyear){
						$mcount=0;
					} } ?>
                <br>
                <br>
                <?php if($cid && $mid && $sid){?>
                <a href="att_single.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&mid=<?php echo $mid;?>&bid=<?php echo $bid;?>" title="add" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png">Add Attendance</button></a>
                <span style="margin:0px 10px 0 0px; float:right;"><img src="./img/tick.png"> Present &nbsp; | &nbsp;<img src="./img/close.png"> Absent </strong> &nbsp; | &nbsp;<img src="./img/off-m.png"> Morning Absent &nbsp; | &nbsp;<img src="./img/off-e.png"> Afternoon Absent </span>  
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Attendance Detail Successfully Deleted !!!</div>
                 <?php } }?>                   
			</div>
            <?php if($cid && $mid && $sid){
				
				$qry1=mysql_query("SELECT distinct day FROM attendance WHERE c_id=$cid AND s_id=$sid AND m_id=$mid AND ay_id=$acyear ORDER BY day");
				 $num_rows = mysql_num_rows($qry1);
				?>
            <div class="grid_12" style=" <?php if($num_rows >=14 && $num_rows <20){ echo "width:1100px;"; } else if($num_rows >=20){ echo "width:1200px;"; }?>">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name'];?> Student Attendance <b><?php if($mid){?>(<?php echo $month['m_name'];?>)<?php } ?></b></h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <?php 
						$select_record2=mysql_query("SELECT distinct day FROM attendance WHERE c_id=$cid AND s_id=$sid AND m_id=$mid AND ay_id=$acyear ORDER BY day");
					while($monthday=mysql_fetch_array($select_record2))
					{ 
						?>
                        <th><center> <?php echo $monthday['day'];?> </center></th>
                        <?php } ?>
								</tr>
							</thead>
							<tbody>                    			
                            <?php 
							//$qry=mysql_query("SELECT distinct ss_id FROM attendance WHERE c_id=$cid AND s_id=$sid AND m_id=$mid AND ay_id=$acyear");
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear AND user_status=1 ORDER BY firstname ASC");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
						$ssid=$row['ss_id'];
								   /*$studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								   $student=mysql_fetch_array($studentlist);*/	
						?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['admission_number']; ?></center></td>
                                <td><center><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></center></td>
                                <?php 
						$select_record2=mysql_query("SELECT distinct day FROM attendance WHERE c_id=$cid AND s_id=$sid AND m_id=$mid AND ay_id=$acyear ORDER BY day");
					while($monthday=mysql_fetch_array($select_record2))
					{ 
						$day=$monthday['day'];
						$select_re=mysql_query("SELECT * FROM attendance WHERE c_id=$cid AND m_id=$mid AND ss_id=$ssid AND day=$day AND ay_id=$acyear ORDER BY day");
						$attend=mysql_fetch_array($select_re);
					
					
						$select_re=mysql_query("SELECT * FROM attendance WHERE c_id=$cid AND m_id=$mid AND ss_id=$ssid ORDER BY day");
						$frow=mysql_num_rows($select_re);
						//if($frow>0){
					
						$result=$attend['result'];
						$result_half=$attend['result_half'];
						?>
                                <?php if($result=='1'){?>
                                <td style="background:#66DD6C;border:1px solid #000000"><center><img src="./img/tick.png" alt="present" title="Present"></center></td>
								<?php }else if($result=='0'){?>
								<td style="background:#FC6366; border:1px solid #000000"><center><img src="./img/close.png" alt="absent" title="Absent"></center></td>
                                <?php }else if($result=='off'){?>
                                <td style="background:#FF0004;border:1px solid #000000"><center><?php if($result_half=="M"){?><img src="./img/off-m.png" alt="Morning absent" title="Morning Absent"><?php }else if($result_half=="E"){?><img src="./img/off-e.png" alt="Afternoon absent" title="Afternoon Absent"><?php }?></center></td>
								<?php } else {?>
                                <td style="background:#B3B3B3;border:1px solid #000000"><center> - </center></td>
								<?php } 
									 }
						 ?>
                               
                                
								</tr> 
                                 <?php 
							$count++;
							} ?>     
                            <?php if($count!=1){?> 
                            <tr class="gradeX">
                            		<td></td>
                                    <td></td>
                    				<td><center><strong>Action</strong> <img src="img/icons/packs/fugue/16x16/arrow-skip.png"></center></td>
                                    <?php 
						$select_recor=mysql_query("SELECT distinct day FROM attendance WHERE c_id=$cid AND m_id=$mid AND ay_id=$acyear ORDER BY day");
					while($monthday1=mysql_fetch_array($select_recor))
					{  
					$emonth=$$monthday1['month'];
					$eday=$monthday1['day'];
					$eyear=$monthday1['year'];
						?>
                        <td><center><a href="att_edit.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&mid=<?php echo $mid;?>&eday=<?php echo $eday;?>&bid=<?php echo $bid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> 
                        <a href="att_delete.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&mid=<?php echo $mid;?>&eday=<?php echo $eday;?>&bid=<?php echo $bid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></center>
                        </td>
                        <?php } ?>
								</tr> 
                                <?php } ?>                         																
							</tbody>
						</table>
					</div>
				</div>
            </div> <?php } else {?>
            <center><h3 class="succ"> Please Select Month </h3></center> <?php } ?>
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
  
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'att_mng.php?bid='+cid;	  
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
                document.getElementById("sid").innerHTML = xmlhttp.responseText;
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