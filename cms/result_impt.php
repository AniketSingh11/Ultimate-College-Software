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
 $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
 if (isset($_POST['submit']))
{
	//echo "test";
	//$sname=$_POST['sname'];
	 $cid=$_POST['cid'];
	 $sid=$_POST['sid'];
	 $eid=$_POST['eid'];
	 $subid=$_POST['subid'];
	 $bid=$_POST['bid'];
	 $cname=$_POST['cname'];
	 $todaydate=date("d/m/Y H:i:s");
	 $subjectype=$_POST['subjectype'];
	 
		
		$filename=$_FILES["file"]["tmp_name"];
		if(!in_array($_FILES['file']['type'],$mimes)){
			  header("Location:result_impt.php?sid=$sid&cid=$cid&eid=$eid&subid=$subid&bid=$bid&msg=efile");
			  exit();
			}
		 if($_FILES["file"]["size"] > 0)
		 {

		  	$file = fopen($filename, "r");
			$count=0;
	         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {
				if($count>0 && $emapData[1]){
					//$gender=strtoupper($emapData[3]);
					//echo "test : ".$emapData[21];
	          //It wiil insert a row to our subject table from our csv file`
			  
			  if($subjectype=='1'){
				  /*if($cname=='XI STD' || $cname=='XII STD'){
				   $sql = "INSERT INTO result (mark,mark1,result,remark,c_id,s_id,e_id,sub_id,ss_id,admin_no,b_id,ay_id) values('$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]','$cid','$sid','$eid','$subid','$emapData[1]','$emapData[2]','$bid','$acyear')";
				  }else{
					   $sql = "INSERT INTO result (mark,result,remark,c_id,s_id,e_id,sub_id,ss_id,admin_no,b_id,ay_id) values('$emapData[4]','$emapData[5]','$emapData[6]','$cid','$sid','$eid','$subid','$emapData[1]','$emapData[2]','$bid','$acyear')";
				  }
				 //we are using mysql_query function. it returns a resource on true else False on error
				 $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());*/
			  }else{
				  $admin_no=mysql_escape_string($emapData[1]);
				  
				  $studentlist1=mysql_query("SELECT ss_id,firstname,lastname,admission_number FROM student WHERE admission_number='$admin_no'"); 
					$student1=mysql_fetch_array($studentlist1);
						$stu_id=$student1['ss_id'];
						if($stu_id){
						$stu_name3=$student1['firstname']." ".$student1['lastname'];
				  		$fa1=mysql_escape_string($emapData[3]);
						$fa2=mysql_escape_string($emapData[4]);
						$fa3=mysql_escape_string($emapData[5]);
						$fa4=mysql_escape_string($emapData[6]);
						$sa=mysql_escape_string($emapData[7]);
						 $FA_A=$fa1+$fa2;
						 $FA_B=$fa3+$fa4;
						$FA_mark=$FA_A+$FA_B;
						$faG=FAGrade($FA_mark);
						$saG=SAGrade($sa);
						$FA_SA_mark=$FA_mark+$sa;
						$FA_SA_grade=FASAGrade($FA_SA_mark);
						
							$select_record1=mysql_query("SELECT r_id FROM result where c_id='$cid' AND e_id=$eid AND sub_id=$subid AND ss_id=$stu_id AND ay_id=$acyear");
						$checkcount=mysql_num_rows($select_record1);
						if($checkcount>0){
							$queryfetch1=mysql_fetch_assoc($select_record1);
							$rid=$queryfetch1['r_id'];
							$qry=mysql_query("UPDATE result SET fa1='$fa1',fa2='$fa2',fa3='$fa3',fa4='$fa4',fa_a_mark='$FA_A',fa_b_mark='$FA_B',fa_mark='$FA_mark',fa_grade='$faG',sa_mark='$sa',sa_grade='$saG',fa_sa_mark='$FA_SA_mark',fa_sa_grade='$FA_SA_grade' WHERE r_id='$rid'") or die("Could not insert data into DB: " . mysql_error());
						}else {
							$qry=mysql_query("INSERT INTO `result` (`fa1`,`fa2`,`fa3`,`fa4`,`fa_a_mark`,`fa_b_mark`,`fa_mark`,`fa_grade`,`sa_mark`,`sa_grade`,`fa_sa_mark`,`fa_sa_grade`,`c_id`,`s_id`,`e_id`,`sub_id`,`ss_id`,`admin_no`,`b_id`,`ay_id`) VALUES ('$fa1', '$fa2','$fa3', '$fa4','$FA_A','$FA_B','$FA_mark','$faG','$sa','$saG','$FA_SA_mark','$FA_SA_grade','$cid','$sid','$eid','$subid','$stu_id','$admin_no','$bid','$acyear')") or die("Could not insert data into DB: " . mysql_error());
						}
						}
			  }
				
				if(!$qry)
				{	
						header("Location:result_impt.php?sid=$sid&cid=$cid&eid=$eid&subid=$subid&bid=$bid&msg=eonfile");
						exit;
				}
				header("Location:result_impt.php?sid=$sid&cid=$cid&eid=$eid&subid=$subid&bid=$bid&msg=succ");
				}
				$count++;
	         }
	         fclose($file);	        
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
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    				<?php 
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							$eid=$_GET['eid'];
							$subid=$_GET['subid'];
							
							$examlist=mysql_query("SELECT * FROM exam WHERE e_id=$eid"); 
								  $exam=mysql_fetch_array($examlist);
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $bid=$_GET['bid'];
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
				<li class="no-hover"><a href="result_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" title="Home">result Management</a></li>
                
                <li class="no-hover">Import <?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result <b>(<?php echo $slist1['s_name'];?>)</b></li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Import <?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result <b>(<?php echo $slist1['s_name'];?>)</b></h1>                
			<a href="result_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <?php
			if($subjectype=='1'){
			 if($class['c_name']=='XI' || $class['c_name']=='XII'){?>
             <a href="student_mark1.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>&ayid=<?php echo $acyear;?>" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Sample File, Fill it andthen import</button></a>
             <?php }else{?>
             <a href="student_mark.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>&ayid=<?php echo $acyear;?>" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Sample File, Fill it and then import</button></a>
             <?php }}else{ ?>
             <a href="student_safa.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>&ayid=<?php echo $acyear;?>" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Sample File</button></a>
             <?php } ?>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Records Successfully Imported!!!</div>
            <?php }
			if($msg=="efile"){?>			
            <div class="alert error"><span class="hide">x</span>Please Upload CSV File Only!!!</div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Import <?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result <b>(<?php echo $subject['s_name'];?>)</b></h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_100">
							<p>
								<label for="file">Upload a file</label>
								<input type="file" name="file" id="file" required/>
							</p>
						</div>
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="cid" value="<?php echo $_GET['cid'];?>" >
                            <input type="hidden" class="medium" name="sid" value="<?php echo $_GET['sid'];?>" >
                            <input type="hidden" class="medium" name="eid" value="<?php echo $_GET['eid'];?>" >
                            <input type="hidden" class="medium" name="subid" value="<?php echo $_GET['subid'];?>" >
                            <input type="hidden" class="medium" name="bid" value="<?php echo $_GET['bid'];?>" >
                            <input type="hidden" class="medium" name="cname" value="<?php echo $class['c_name'];?>" >
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
			//$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		/*
		 * Datepicker
		 */		
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