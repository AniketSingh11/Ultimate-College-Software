<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top1.php"); 
 //echo $_SESSION['uname'];
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
    	<?php include("nav1.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
     <?php 
		$bid=$_GET['bid'];
		$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$eid=$_GET['eid'];
							$subid=$_GET['subid'];
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
				<li><a href="dashboard1.php" title="Home"><span id="bc-home"></span></a></li>
                 <li class="no-hover"><a href="sboard_select_exam.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                 <li class="no-hover"><a href="sboard_select_classexam.php?bid=<?php echo $bid; ?>&eid=<?php echo $eid;?>" title="Select Class">Class List</a></li>
				<li class="no-hover"><a href="sresult_mng1.php?cid=<?php echo $cid."&sid=".$sid."&eid=".$eid."&bid=".$bid."&subid=".$subid;?>" title="<?php echo $board['b_name'];?>">Overall Result</a></li> 
                <li class="no-hover">Student Rank List</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <?php							
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
				<h1><?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Rank List </h1>
                <?php if($cid && $subid && $sid){?>
                 <a href="sresult_mng1.php?cid=<?php echo $cid."&sid=".$sid."&eid=".$eid."&bid=".$bid."&subid=".$subid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                <?php  }?>                   
			</div>
            <?php if($cid && $sid && $eid){				
				
				
				/*$a=array("Guna"=>"100");
								//array_push($a,"Joe"=>"84","Peter1"=>"84");								
								$data = array_merge($a, array("Joe"=>"84","Peter1"=>"84"));
								//$myarray = array_push_assoc($myarray, "Gune", "100");
								//print_r($data);
								//$data = array_merge($data, array("Joe2"=>"84","Peter2"=>"83"));
								
								$rank = rank($data);

								echo "<pre>";
								print_r($rank);
								echo "</pre>";*/
								
								/*$a=array("7"=>"289");
								$data = array_merge($a, array("3"=>"234","4"=>"194","5"=>"214"));
								rsort($data);
								$rank = rank($data);

								echo "<pre>";
								print_r($rank);
								echo "</pre>";
								
								//var_dump($rank);
								foreach($rank as $key=>$data) {
									$datas=$data;
									$nos=1;
									foreach($data as $key1=>$data1) {
										if($nos=='1'){										
										echo "Key: ".$key1." Data: ".$data1."<br />";
										}else{
										echo "Data: ".$data1."<br />";
										}
										$nos++;										
									}
								}*/
				?>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Rank List </h1>                        
                        <span></span>
					</div>
                    <?php
								$a=array();								
					$resultarray=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
							$nofrow=mysql_num_rows($resultarray);
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear");
							$count=1;
			  while($student=mysql_fetch_array($qry))
        		{
						$ssid=$student['ss_id'];
						if($nofrow>1){
							$qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$pass=0;
							$fail=0;
							$gtotal=0;
							$subount=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$slid=$row1['sl_id'];
					$subid1=$row1['sub_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
								   
								    $studentlist=mysql_query("SELECT * FROM result WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
								   $row=mysql_fetch_array($studentlist);	
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
					 } 
					// echo $pass."-".$subount."<br>";
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
								print_r($a);
								echo "</pre>";*/
						
						?>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                     <?php 
							$qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$count=1;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$slid=$row1['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
					?>
                 	<th><?php echo $slist['s_name']; ?></th>
                <?php } ?>
                                    <th>Total</th>
                                    <th>Rank</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$resultarray=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND ay_id=$acyear"); 
							$nofrow=mysql_num_rows($resultarray);
							$count=1;
				foreach($rank as $key=>$data) {
								$datas=$data;
									$nos=1;
									foreach($data as $key1=>$data1) {
										if($nos=='1'){										
											$ssid=$key1;
											$Total=$data1;
										}else{
											$studentrank=$data1;										
										}
										$nos++;										
									}
						$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear AND ss_id=$ssid");
						$student=mysql_fetch_array($qry);
						if($nofrow>1){
						?> 
								<tr class="gradeX1" style="border-top:dotted 1px #000;">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?></center></td>
                                <?php 
							$qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$pass=0;
							$fail=0;
							$gtotal=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$slid=$row1['sl_id'];
					$subid1=$row1['sub_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);
								   
								    $studentlist=mysql_query("SELECT * FROM result WHERE ss_id=$ssid AND c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid1 AND ay_id=$acyear"); 
								   $row=mysql_fetch_array($studentlist);	
								$mark=$row['mark'];
								$mark1=$row['mark1'];								
								$total=$mark+$mark1;								
								$result=$row['result'];
																
								if($result=="FAIL"){
									$fail++;
								}							
								 if($paper=='1'){ ?>
                                 <td width="10%" style="border-top:dotted 1px #000;"><?php echo $mark."-".$mark1." = ".$total;?> </td><?PHP $gtotal +=$total; } else {  ?>
								 <td width="10%" <?php if($result) { if($result=="FAIL"){ echo 'style="background-color:#f32200; color:#FFF;border-top:dotted 1px #000;"'; }else{ echo 'style="background-color:#06ae1e;color:#FFF;border-top:dotted 1px #000;"'; } }?>><center><?php echo $row['mark'];?></center> </td>
								 <?php  $gtotal +=$row['mark']; }?>
                                 
                <?php  } ?>			
                				<td <?php if($gtotal && $fail){ echo 'style="background-color:#deb713;border-top:dotted 1px #000;"';}else if($gtotal){ echo 'style="background-color:#008fc4; color:#FFF;border-top:dotted 1px #000;"';}?>><center><?php if($gtotal){ echo $gtotal;}?> </center></td>
                				<td style="background-color:#deb713; color:#000;border-top:dotted 1px #000;"><center><?php 
								echo $studentrank;
								?></center></td>	                
                                </tr> 
                                 <?php 
							$count++;
						}} ?>                               																
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
</body>
</html>
<? ob_flush(); ?>