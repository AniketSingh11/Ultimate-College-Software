<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php"); 
 //echo $_SESSION['uname'];
 function FAGrade($value){
	 if($value>=37 && 40>=$value){
		 return "A1";
	 }else if($value>=33 && 36>=$value){
		 return "A2";
	 }else if($value>=29 && 32>=$value){
		 return "B1";
	 }else if($value>=25 && 28>=$value){
		 return "B2";
	 }else if($value>=21 && 24>=$value){
		 return "C1";
	 }else if($value>=17 && 20>=$value){
		 return "C2";
	 }else if($value>=13 && 16>=$value){
		 return "D";
	 }else{
		 return "E";
	 }
 }
 function SAGrade($value){
	 if($value>=55 && 60>=$value){
		 return "A1";
	 }else if($value>=49 && 54>=$value){
		 return "A2";
	 }else if($value>=43 && 48>=$value){
		 return "B1";
	 }else if($value>=37 && 42>=$value){
		 return "B2";
	 }else if($value>=31 && 36>=$value){
		 return "C1";
	 }else if($value>=25 && 30>=$value){
		 return "C2";
	 }else if($value>=19 && 18>=$value){
		 return "D";
	 }else{
		 return "E";
	 }
 }
 function FASAGrade($value){
	 if($value>=91 && 100>=$value){
		 return "A1";
	 }else if($value>=81 && 90>=$value){
		 return "A2";
	 }else if($value>=71 && 80>=$value){
		 return "B1";
	 }else if($value>=61 && 70>=$value){
		 return "B2";
	 }else if($value>=51 && 60>=$value){
		 return "C1";
	 }else if($value>=41 && 50>=$value){
		 return "C2";
	 }else if($value>=31 && 40>=$value){
		 return "D";
	 }else{
		 return "E";
	 }
 }
 
$cid=$_GET['cid'];
$sid=$_GET['sid'];
$eid=$_GET['eid'];
$subid=$_GET['subid'];
$rid=$_GET['rid'];
$bid=$_GET['bid'];
 if (isset($_POST['submit']))
{
	$ssid=$_POST['ssid'];
	$subjectype=$_POST['subjectype'];
	
	if($subjectype=='1'){
		$mark=$_POST['mark'];
	$mark1=$_POST['mark1'];
	$result=$_POST['result'];
	$remark=$_POST['remarks'];
$sql="UPDATE result SET mark='$mark',mark1='$mark1',result='$result',remark='$remark',b_id='$bid' WHERE r_id='$rid'";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
	}else{
		$fa1=$_POST['fa1'];
		$fa2=$_POST['fa2'];
		$fa3=$_POST['fa3'];
		$fa4=$_POST['fa4'];
		$sa=$_POST['sa'];
		$FA_A=$fa1+$fa2;
						$FA_B=$fa3+$fa4;
						$FA_mark=$FA_A+$FA_B;
						$faG=FAGrade($FA_mark);
						$saG=SAGrade($sa);
						$FA_SA_mark=$FA_mark+$sa;
						$FA_SA_grade=FASAGrade($FA_SA_mark);
		$sql="UPDATE result SET fa1='$fa1',fa2='$fa2',fa3='$fa3',fa4='$fa4',fa_a_mark='$FA_A',fa_b_mark='$FA_B',fa_mark='$FA_mark',fa_grade='$faG',sa_mark='$sa',sa_grade='$saG',fa_sa_mark='$FA_SA_mark',fa_sa_grade='$FA_SA_grade' WHERE r_id='$rid'";
		$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
	}
    if($result){
        header("Location:result_edit.php?cid=$cid&sid=$sid&eid=$eid&subid=$subid&rid=$rid&bid=$bid&msg=succ");
    }else{
	   header("Location:result_edit.php?cid=$cid&sid=$sid&eid=$eid&subid=$subid&rid=$rid&bid=$bid&msg=err");	
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
							$examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							$subjectlist=mysql_query("SELECT * FROM subject WHERE sub_id=$subid"); 
								  $subject=mysql_fetch_array($subjectlist);
								  $slid1=$subject['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid1'"); 
								   $slist1=mysql_fetch_array($subjectlist1);
								   $subjectype=$slist1['s_type'];	  
								  ?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_exam.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover"><a href="result_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" title="Result Management">Result managemrnt</a></li>
                <li class="no-hover">Edit Student Result</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Edit <?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result <b>(<?php echo $slist1['s_name'];?>)</b></h1>                
			<a href="result_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Edit <?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result <b>(<?php echo $slist1['s_name'];?>)</b></h1><span></span>
					</div>
                    <form id="validate-form" class="block-content form" action="" method="post">
						 <div class="_100">
                         <p>
                         <label for="textfield">Fill Student Marks: </label>
                    <?php 
							$resultlist=mysql_query("SELECT ss_id,mark,result,remark,mark1,fa1,fa2,fa3,fa4,sa_mark FROM result WHERE r_id=$rid"); 
								  $result=mysql_fetch_array($resultlist);	
								  $ssid1=$result['ss_id'];
								  if($subjectype=='1'){ ?>
								  <table class="table">
                                        <thead>
                                            <th><center>S.No</center></th>
                                            <th><center>Admin No</center></th>
                                            <th><center>Student Name</center></th>
                                            <?php if($class['c_name']=='XI STD' || $class['c_name']=='XII STD' || $class['c_name']=='XI' || $class['c_name']=='XII'){
											$paper=$slist1['paper'];
											if($paper){?>
											<th><center>Paper I </center></th>
											<th><center>Paper II </center></th>
											<?php }else{?>
											<th><center>Mark</center></th>
											<?php }}else{?>
											<th><center>Mark</center></th>
											<?php } ?>
                                            <th><center>Result (pass or fail)</center></th>
                                            <th><center>Remark</center></th>
                                        </thead>
                                        <tbody>
										<?php 
                                         $att=1;						 
                                        $select_record=mysql_query("SELECT ss_id,admission_number,firstname,lastname FROM student where ss_id=$ssid1");
                                        $student12=mysql_fetch_assoc($select_record);
                                            ?>
                                            <tr>
                                            <td><center><?php echo $att;?></center></td>
                                            <td><center><?php echo $student12['admission_number']?></center></td>
                                            <td><center><?php echo $student12['firstname']." ".$student12['lastname']; ?></center></td>
                                            <?php if($class['c_name']=='XI STD' || $class['c_name']=='XII STD' || $class['c_name']=='XI' || $class['c_name']=='XII'){
                        $paper=$slist1['paper'];
						if($paper){?>
                                            <td><center><input type="text" name="mark" max="100" class="required" autocomplete="off" value="<?=$result['mark']?>"/></center></td>
                                            <td><center><input type="text" name="mark1" max="100" class="required" autocomplete="off" value="<?=$result['mark1']?>"/></center></td>
                                            <?php }else{?>
                                            <td><center><input type="text" name="mark" max="200" class="required" autocomplete="off" value="<?=$result['mark']?>"/></center></td>
                                            <?php }}else{?>
                                            <td><center><input type="text" name="mark" max="100" class="required" autocomplete="off" value="<?=$result['mark']?>"/></center></td>
                                             <?php } ?>
                                            <td><center><input style="opacity: 0;" name="result" type="radio" value="PASS" <?php if($result['result']=="PASS" || !$result['result']){ echo "checked"; }?>> Pass</input> 
                                                    <input style="opacity: 0;" name="result" type="radio" value="FAIL" <?php if($result['result']=="FAIL"){ echo "checked"; }?>> Fail</input></center></td>
                                            <td><center><input type="text" name="remark" autocomplete="off" value="<?=$result['remark']?>"/></center></td>
                                            </tr>
                                         <?php $att++; ?>         
                                        </tbody>
                                      </table>
								 <?php } else { ?>
                    
                        <table class="table">
                  	<thead>
                    	<th><center>S.No</center></th>
                    	<th><center>Admin No</center></th>
                        <th><center>Student Name</center></th>
                        <th colspan="2"><center>FA (a)</center></th>
                        <th colspan="2"><center>FA (b)</center></th>
                        <th><center>SA</center></th>
                       </thead>
                    </thead>
                    <tbody>
                    	<?php 
						 $att=1;						 
					$select_record=mysql_query("SELECT ss_id,admission_number,firstname,lastname FROM student where ss_id=$ssid1");
					$student12=mysql_fetch_assoc($select_record);
						?>
                        <tr>
                        <td><center><?php echo $att;?></center></td>
                        <td><center><?php echo $student12['admission_number']?></center></td>
                        <td><center><?php echo $student12['firstname']." ".$student12['lastname']; ?></center></td>
                        <td><center><input type="text" name="fa1" max="10" class="required" autocomplete="off" value="<?=$result['fa1']?>"/></center></td>
                        <td><center><input type="text" name="fa2" max="10" class="required" autocomplete="off" value="<?=$result['fa2']?>"/></center></td>
                        <td><center><input type="text" name="fa3" max="10" class="required" autocomplete="off" value="<?=$result['fa3']?>"/></center></td>
                        <td><center><input type="text" name="fa4" max="10" class="required" autocomplete="off" value="<?=$result['fa4']?>"/></center></td>
                        <td><center><input type="text" name="sa" max="60" class="required" autocomplete="off" value="<?=$result['sa_mark']?>"/></center></td>
                        </tr>
                     <?php $att++; ?>         
                    </tbody>
                  </table>
                    <?php } ?>
                    </p><br><br>	
                  </div>
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                                <input type="hidden" name="rid" value="<?php echo $rid;?>" />
                                <input type="hidden" name="subjectype" value="<?php echo $subjectype;?>" />
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
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).datepicker();
		$( "#datepicker1" ).datepicker();
		$( "#datepicker2" ).datepicker();
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