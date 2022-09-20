<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 function findrank($rank, $ssid1){	 
	 foreach($rank as $key=>$data) {
				$datas=$data;
					$nos=1;
					foreach($data as $key1=>$data1) {
						if($key1==$ssid1){
						if($nos=='1'){										
							$ssid=$key1;
							$Total=$data1;
						}else{
							$studentrank=$data1;										
						}
						$nos++;	
						}
					}
				}
				return $studentrank;
 }
 function array_push_assoc($array, $key, $value){
				$array[$key] = $value;
				return $array;
				}
				
 function rank ($arr) {
  $ret = array();
  $s = array();
  $i = 0;
  foreach ($arr as $x => $v) {
    if (!$s[$v]) { $s[$v] = ++$i; }
    $ret[]= array($x => $v, $s[$v]);
  }
  return $ret;
}
?>
<style type="text/css">
 .table tr td{border-bottom:1px #737171 dotted;}
 .table tr td.grade{background-color:#A2E17B;}
 .table tr td.rank{background-color:#EBB07E;}
 .table tr td.mark{background-color:#FCC859;}
 </style>
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
								  $board1=mysql_fetch_assoc($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_assoc($boardlist);
								  
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                 <li class="no-hover"><a href="board_select_exam.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Exam Results Management</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="board_select_exam.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
								  $exam=mysql_fetch_assoc($examlist);
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_assoc($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_assoc($sectionlist);	  
								  
								  if(!$subid){
								$qry7=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear ORDER BY b.sl_id ASC");
								$subjectlist=mysql_fetch_assoc($qry7);
									$subid=$subjectlist['sub_id'];
								}								
							if($subid){
							$subjectlist=mysql_query("SELECT * FROM subject WHERE sub_id=$subid"); 
								  $subject=mysql_fetch_assoc($subjectlist);
								   $slid1=$subject['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid1'"); 
								   $slist1=mysql_fetch_assoc($subjectlist1);
								   $paper=$slist1['paper'];
								  	  }
							 	  //echo $class['c_name']."-".$section['s_name'];
								  
								  /**************************rank ********************************/
								  $a=array();								
					$resultarray=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
							$nofrow=mysql_num_rows($resultarray);
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear");
							$count=1;
			  while($student=mysql_fetch_assoc($qry))
        		{
						$ssid=$student['ss_id'];
						if($nofrow>1){
							$qry1=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear ORDER BY b.sl_id ASC");
							$pass=0;
							$fail=0;
							$gtotal=0;
							$subount=0;
			  while($row1=mysql_fetch_assoc($qry1))
        		{
					$slid=$row1['sl_id'];
					$subid1=$row1['sub_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_assoc($subjectlist1);
								   $paper=$slist['paper'];
								   $subjectype=$slist['s_type'];
								    $studentlist=mysql_query("SELECT * FROM result WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
								   $row=mysql_fetch_assoc($studentlist);
								   
							if($subjectype=='1'){		
								$mark=$row['mark'];
								$mark1=$row['mark1'];								
								$total=$mark+$mark1;								
								$result=$row['result'];
																
								if($result=="FAIL"){
									$fail++;
								}else if($result=="PASS"){
									$pass++;
								}
								$subount++;		
								 if($paper=='1'){
                                 $gtotal +=$total; } else {  $gtotal +=$row['mark']; }
							}else{
								$fa1=$row['fa1'];
									$fa2=$row['fa2'];
									$fa3=$row['fa3'];
									$fa_a_mark=$row['fa_a_mark'];
									$fa_b_mark=$row['fa_b_mark'];
									$fa_mark=$row['fa_mark'];
									$fa_grade=$row['fa_grade'];
									$sa_mark=$row['sa_mark'];
									$sa_grade=$row['sa_grade'];
									$fa_sa_mark=$row['fa_sa_mark'];
									$fa_sa_grade=$row['fa_sa_grade'];								
									$total=$fa_sa_mark;	
									if($fa_sa_grade=="E"){
										$fail++;
									}else{
										$pass++;
									}
									$subount++;	
									$gtotal +=$total;
							}	 
					 	  } 
					 //echo $pass."-".$subount."<br>";
					 if($pass==$subount){
                			 if($gtotal){ 
								if($fail){ 
								 }else{
									 $a = array_merge($a, array("'$ssid'"=>"$gtotal"));
									 //print_r($data);								 
									 } 
							}  
					 }
							$count++;
						}
						}
								arsort($a);
								$rank = rank($a);
								/*echo "<pre>";
								print_r($rank);
								echo "</pre>";
								$ssid1="'505'";
								echo findrank($rank, $ssid1);*/
								  ?>
		<div class="grid_12">
				<h1><?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> - Overall Grade Result </h1>
                <?php if($cid && $subid && $sid){?>
                 <a href="result_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&bid=<?php echo $bid;?>" title="add" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Result Add/delete</button></a>
                 <span><a href="rank_list.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/chart--pencil.png">  Student Ranks</button></a></span>
                 
                <span style="float:right"><a href="result_analysis.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/chart-pie-separate.png">  Result Analysis</button></a></span>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } }?>                   
			</div>
            <?php if($cid && $sid && $eid){?>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> - Overall Grade Result </h1>
                        <a href="result_mng_grade_excel.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Download Excel</button></a>                       
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
							$qry1=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear ORDER BY b.sl_id ASC");
							$count=1;
							  while($row1=mysql_fetch_assoc($qry1))
								{
									$slid=$row1['sl_id'];
									   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
									   $slist=mysql_fetch_assoc($subjectlist1);
									   $subjectype=$slist['s_type'];
									   if($slist['extra_sub']!=1) {
									?>
									<th <?php if($subjectype!='1'){ echo 'colspan="3"';}?>><?php echo $slist['s_name']; ?></th>
								<?php } 
								} ?>
                                    <th>Total</th>
                                    <th>result</th>
                                    <th>Rank</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$resultarray=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
							$nofrow=mysql_num_rows($resultarray);
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear ORDER BY gender DESC,firstname ASC");
							$count=1;
			  while($student=mysql_fetch_assoc($qry))
        		{
						$ssid=$student['ss_id'];
						$ssid1="'".$ssid."'";
						$rank1=findrank($rank, $ssid1);
						if($nofrow>1){
							if($subjectype!='1'){
						?> 
                        		<tr>
									<td></td>
                                    <td></td>
                                    <td></td>
                                     <?php 
							$qry1=mysql_query("SELECT sl_id FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$count=1;
							  while($row1=mysql_fetch_assoc($qry1))
								{	?>
									<td><b>FA</b></td>
                                    <td><b>SA</b></td>
                                    <td><b>Total</b></td>
								<?php  } ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
								</tr>
                                <?php $nofrow=0;} }?>
								<tr class="gradeX1" style="border-top:dotted 1px #000;">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?></center></td>
                                <?php 
							$qry1=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear AND b.extra_sub=0 ORDER BY b.sl_id ASC");
							$pass=0;
							$fail=0;
							$gtotal=0;
							  while($row1=mysql_fetch_assoc($qry1))
								{
									$slid=$row1['sl_id'];
									$subid1=$row1['sub_id'];
					
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_assoc($subjectlist1);
								   $paper=$slist['paper'];
								   $subjectype=$slist['s_type'];
								    $studentlist=mysql_query("SELECT * FROM result WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
								   $row=mysql_fetch_assoc($studentlist);	
								if($subjectype=='1'){					
									$mark=$row['mark'];
									$mark1=$row['mark1'];								
									$total=$mark+$mark1;								
									$result=$row['result'];
																	
									if($result=="FAIL"){
										$fail++;
									}	
								 if($paper=='1'){ ?>
                                 <td width="10%" <?php if($result) { if($result=="FAIL"){ echo 'style="background-color:#f32200; color:#FFF;border-top:dotted 1px #000;"'; }else{ echo 'style="background-color:#06ae1e;color:#FFF;border-top:dotted 1px #000;"'; } }?>><?php if($total){ echo $mark."-".$mark1." = ".$total;}?> </td><?PHP $gtotal +=$total; } else {  ?>
								 <td width="10%" <?php if($result) { if($result=="FAIL"){ echo 'style="background-color:#f32200; color:#FFF;border-top:dotted 1px #000;"'; }else{ echo 'style="background-color:#06ae1e;color:#FFF;border-top:dotted 1px #000;"'; } }?>><center><?php echo $row['mark'];?></center> </td>
								 <?php  $gtotal +=$row['mark']; }
								}else{
									$fa1=$row['fa1'];
									$fa2=$row['fa2'];
									$fa3=$row['fa3'];
									$fa_a_mark=$row['fa_a_mark'];
									$fa_b_mark=$row['fa_b_mark'];
									$fa_mark=$row['fa_mark'];
									$fa_grade=$row['fa_grade'];
									$sa_mark=$row['sa_mark'];
									$sa_grade=$row['sa_grade'];
									$fa_sa_mark=$row['fa_sa_mark'];
									$fa_sa_grade=$row['fa_sa_grade'];								
									$total=$fa_sa_mark;	
									if($fa_sa_grade=="E"){
										$fail++;
									}	
									?>
                                <td width="10%" class="mark"><center><?php echo $fa_grade;?></center> </td>
                                <td width="10%" class="grade"><center><?php echo $sa_grade;?></center> </td>
                                <td width="10%" class="rank"><center><?php echo $fa_sa_grade;?></center> </td>
                                <?php  $gtotal +=$total; } ?>
                <?php  } ?>
                				<td <?php if($gtotal && $fail){ echo 'style="background-color:#deb713;border-top:dotted 1px #000;"';}else if($gtotal){ echo 'style="background-color:#008fc4; color:#FFF;border-top:dotted 1px #000;"';}?>><center><?php if($gtotal){ echo $gtotal;}?> </center></td>
                				<td <?php if($gtotal){ 
								if($fail){ echo 'style="background-color:#f32200; color:#FFF;border-top:dotted 1px #000;"'; }else{ echo 'style="background-color:#06ae1e;color:#FFF;border-top:dotted 1px #000;"'; } } ?>> <center><?php if($gtotal){ 
								if($fail){ echo "FAIL"; }else{ echo "PASS"; } 
								}?></center></td>
                                <td style="background-color:#B35300; color:#FFF;border-top:dotted 1px #000;"><center><b><?=$rank1?></b></center></td>		                
                                </tr> 
                                 <?php 
							$count++;
						 } ?>                               																
							</tbody>
						</table>
					</div>
				</div>
            </div> <?php }  else {?>
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
	 window.location.href = 'result_mng1.php?bid='+cid;	  
	} 
</script>  
<?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>