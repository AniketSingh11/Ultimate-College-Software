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
 .table tr td.rank{background-color:#0091CF; color:#FFFFFF;}
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
								   $subjectype=$slist1['s_type'];
								  	  }
							 	  //echo $class['c_name']."-".$section['s_name'];
								  
								   /**************************rank ********************************/
								  $a=array();								
					$resultarray=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid AND ay_id=$acyear"); 
							$nofrow=mysql_num_rows($resultarray);
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND b_id=$bid AND ay_id=$acyear");
							$count=1;
			  while($student=mysql_fetch_assoc($qry))
        		{
						$ssid=$student['ss_id'];
						if($nofrow>1){
							$qry1=mysql_query("SELECT * FROM subject WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear AND sub_id=$subid");
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
				<h1><?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result <b><?php if($subid){?>(<?php echo $slist1['s_name'];?>)<?php } ?></b></h1>
                 <?php 
							$qry1=mysql_query("SELECT a.* FROM subject a,subjectlist b WHERE (a.sl_id=b.sl_id) AND a.c_id=$cid AND a.s_id=$sid AND a.ay_id=$acyear ORDER BY b.sl_id ASC");
							$count=1;
			  while($row1=mysql_fetch_assoc($qry1))
        		{
					$slid=$row1['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_assoc($subjectlist1);
							if($slist['extra_sub']!=1) {	   
					?>
                 <a href="result_mng.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $row1['sub_id']; ?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-error" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> <?php echo $slist['s_name']; ?></button></a>
                <?php } } ?>
                <br>
                <br>
                <?php if($cid && $subid && $sid){?>
                <a href="result_impt.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" title="add" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Import Student Datas</button></a>
                <a href="result_new.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" title="add" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png">  Add/Edit Marks</button></a>
                <a href="result_mng1.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> View Overall Result</button></a>
                <a href="result_mng_grade.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-error" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> View Overall Grade</button></a>
                 <a href="result_mng_mark.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> View Overall Mark</button></a>
                <span style="float:right"><a href="result_analysis.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/chart-pie-separate.png">  Result Analysis</button></a></span>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } }?>                   
			</div>
            <?php if($cid && $subid && $sid && $eid){?>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name']." ".$exam['e_name'];?> Result <b><?php if($subid){?>(<?php echo $slist1['s_name'];?>)<?php } ?></b></h1>   <a href="result_mng_excel.php?cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&bid=<?php echo $bid;?>&subid=<?php echo $subid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Download Excel</button></a>                     
                        <span></span>
					</div>
					<div class="block-content">
                    <?php if($subjectype=='1'){?>
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <th>Mark</th>
                                    <th>result</th>
                                    <th>Rank</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody><?php 
							$qry=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_assoc($qry))
        		{
						$ssid=$row['ss_id'];
						
								   $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								   $student=mysql_fetch_assoc($studentlist);	
						if($student){	
								$ssid1="'".$ssid."'";
								$rank1=findrank($rank, $ssid1);	   
						?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php
								$mark=$row['mark'];
								$mark1=$row['mark1'];
								$total=$mark+$mark1;
								 if($paper=='1'){ echo $mark."-".$mark1." = ".$total; } else { echo $row['mark']; }?></center></td>
                                <td><center><?php echo $row['result']; ?></center></td>
                                <td><center><?php echo $rank1; ?></center></td>
                                <td width="80px;">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="result_edit.php?rid=<?php echo $row['r_id'];?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a>
                                 <a href="result_delete.php?rid=<?php echo $row['r_id']; ?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?>'s Result" style="display: none;">
				<p>Exam Name : <strong><?php echo $exam['e_name']; ?></strong></p>
                
                 <p>Mark : <strong><?php
								$mark=$row['mark'];
								$mark1=$row['mark1'];
								$total=$mark+$mark1;
								 if($paper=='1'){ echo $mark."-".$mark1." = ".$total; } else { echo $row['mark']; }?></strong></p> 
                
                <p>Result : <strong><?php echo $row['result']; ?></strong>  </p> 
                <p>Remark : <strong><?php echo $row['remark']; ?></strong>  </p> 
                  
                </div>
                                 <?php 
							$count++;
						} } ?></tbody>
						</table><?php } else{ ?><table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <th colspan="2"><center>FA (a)</center></th>
                                    <th colspan="2"><center>FA (b)</center></th>
                                    <th><center>FA (40)</center></th>
                                    <th><center>SA (60)</center></th>
                                    <th><center>Total (100)</center></th>
                                    <th><center>Grade FA</center></th>
                                    <th><center>Grade SA</center></th>
                                    <th><center>OverAll</center></th>
                                    <th><center>Rank</center></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody><?php 
							$qry=mysql_query("SELECT * FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_assoc($qry))
        		{
						$ssid=$row['ss_id'];
								   $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								   $student=mysql_fetch_assoc($studentlist);	
						if($student){	
								$ssid1="'".$ssid."'";
								$rank1=findrank($rank, $ssid1);	   
						?><tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?=$row['fa1']?></center></td>
                                <td><center><?=$row['fa2']?></center></td>
                                <td><center><?=$row['fa3']?></center></td>
                                <td><center><?=$row['fa4']?></center></td>
                                <td class="mark"><center><?=$row['fa_mark']?></center></td>
                                <td class="mark"><center><?=$row['sa_mark']?></center></td>
                                <td class="mark"><center><?=$row['fa_sa_mark']?></center></td>
                                <td class="grade"><center><?=$row['fa_grade']?></center></td>
                                <td class="grade"><center><?=$row['sa_grade']?></center></td>
                                <td class="grade"><center><?=$row['fa_sa_grade']?></center></td>
                                <td class="rank"><center><?=$rank1?></center></td>
                                <td width="80px;">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="result_edit.php?rid=<?php echo $row['r_id'];?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a>
                                 <a href="result_delete.php?rid=<?php echo $row['r_id']; ?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&eid=<?php echo $eid;?>&subid=<?php echo $subid;?>&bid=<?php echo $bid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $student['firstname']." ".$student['middlename']." ".$student['lastname']; ?>'s Result" style="display: none;">
				<p>Exam Name : <strong><?php echo $exam['e_name']; ?></strong></p>
                
                 <p>Mark : <strong><?php
								$mark=$row['mark'];
								$mark1=$row['mark1'];
								$total=$mark+$mark1;
								 if($paper=='1'){ echo $mark."-".$mark1." = ".$total; } else { echo $row['mark']; }?></strong></p> 
                
                <p>Result : <strong><?php echo $row['result']; ?></strong>  </p> 
                <p>Remark : <strong><?php echo $row['remark']; ?></strong>  </p>   
                </div>
                                 <?php 
							$count++;
						}}?></tbody>
				</table><?php } 
				$qry1="SELECT r_id FROM result WHERE c_id=$cid AND s_id=$sid AND e_id=$eid AND sub_id=$subid AND ay_id=$acyear";
				if($subjectype=='1'){
					$qry1 .=" AND mark";
					$qry2 = $qry1." AND result='PASS'";
					$qry3 = $qry1." AND mark >= 90";
					$qry4 = $qry1." AND mark >= 60 AND mark < 90 ";
					$qry5 = $qry1." AND mark >= 35 AND mark < 60 ";
				}else{
					$qry1 .=" AND fa_sa_mark";
					$qry2 = $qry1." AND fa_sa_grade!='E'";
					$qry3 = $qry1." AND fa_sa_mark >= 90";
					$qry4 = $qry1." AND fa_sa_mark >= 60 AND fa_sa_mark < 90 ";
					$qry5 = $qry1." AND fa_sa_mark >= 35 AND fa_sa_mark < 60 ";
				}
				$qrys1=mysql_query($qry1);
				$total_appeared=mysql_num_rows($qrys1);
				$qrys2=mysql_query($qry2);
				$no_passed=mysql_num_rows($qrys2);
				$no_failed=$total_appeared-$no_passed;
				$percent=($no_passed/$total_appeared)*100;
				$qrys3=mysql_query($qry3);
				$above90=mysql_num_rows($qrys3);
				$qrys4=mysql_query($qry4);
				$above60=mysql_num_rows($qrys4);
				$qrys5=mysql_query($qry5);
				$above35=mysql_num_rows($qrys5);
				?>
                <table id="table-example" class="table" role="grid" aria-describedby="table-example_info">
							<tbody style="width:50%">
                            <tr class="gradeX odd" role="row">
								<td style="text-align:right; width:20%">Total no of students appeared :</td>
                                <td style="width:5%"><?=$total_appeared?></td>
                                <td style="width:30%"></td>
                                <td style="text-align:right;width:10%">Above 90 :</td>
                                <td style="width:5%"><?=$above90?></td>
								</tr>
                                <tr class="gradeX odd" role="row">
								<td style="text-align:right;">No of students passed :</td>
                                <td><?=$no_passed?></td>
                                <td style="width:30%"></td>
                                <td style="text-align:right;">Above 60 :</center></td>
                                <td><?=$above60?></td>
								</tr>
                                <tr class="gradeX odd" role="row">
								<td style="text-align:right;">No of students failed :</td>
                                <td><?=$no_failed?></td>
                                <td style="width:30%"></td>
                                <td style="text-align:right;">Above 35 :</center></td>
                                <td><?=$above35?></td>
								</tr>
                                <tr class="gradeX odd" role="row">
								<td style="text-align:right;">Pass Percentage :</center></td>
                                <td><?php echo round($percent,2)." %";?></center></td>
                                <td style="width:30%"></td>
                                <td></td>
                                <td></td>
								</tr>
                               </tbody>
						</table>
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
	 window.location.href = 'result_mng.php?bid='+cid;	  
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