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
    	<?php $bid=$_GET['bid'];
		if(!$bid){
			$boardlist1=mysql_query("SELECT b_id,b_name FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT b_name FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="#" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Last Year Fees Pending</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
				<div class="_25" style="float:right">
                <label for="select">Board :</label>
                                	<?php
                                            $classl = "SELECT b_id,b_name FROM board";
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
                <h1>Last Year Fees Pending</h1>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>     
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>Fees Invoice</h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>admin No</th>
                                    <th>Student Name</th>
                                    <th>Class-Section</th>
                                    <th>Student Category</th>
                                    <th>Student type</th>
                                    <th>Pending</th>
                                    <th>Status</th>
                                    <th>Detail</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
				$layear=mysql_query("SELECT ay_id FROM year WHERE e_year=$syear");
				$lay=mysql_fetch_array($layear);  
				$lacyear=$lay['ay_id'];
				$count=1;
				/****************************************** Pending Amount Start **********************************/
					if($lacyear){
									$lstudentlist=mysql_query("SELECT ss_id,c_id,s_id,stype,fdis_id,admission_number,firstname,lastname FROM student WHERE ay_id=$lacyear"); 
								  while($lstudent=mysql_fetch_array($lstudentlist)){
									  $totalpending=0;
								  $lssid=$lstudent['ss_id'];
								  $lcid=$lstudent['c_id'];
								  	$lsid=$lstudent['s_id'];
									$ls_type=$lstudent['stype'];
									$lfdisid1=$lstudent['fdis_id'];
									
									$lclasslist1=mysql_query("SELECT c_name FROM class WHERE c_id=$lcid"); 
								    $lclass1=mysql_fetch_array($lclasslist1);
									
									$sectionlist1=mysql_query("SELECT s_name FROM section WHERE s_id=$lsid"); 
								  $section1=mysql_fetch_array($sectionlist1);	
									
									if(($lclass1['c_name']=="XI STD") || ($lclass1['c_name']=="XII STD") || ($lclass1['c_name']=="XI") || ($lclass1['c_name']=="XII")){
									 $lsid21 = $lsid;
								  }else {
									  $lsid21 = "0";
								  }
								  
				$sql1=mysql_query("SELECT fg_id,fgd_id,fr_id FROM mfrate WHERE c_id=$lcid AND b_id=$bid AND ay_id=$lacyear AND rate='$ls_type' AND s_id=$lsid21 ORDER BY fgd_id");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									 $ffgid=$row2['fg_id'];
									 $ffgdid=$row2['fgd_id'];
									$frid=$row2['fr_id'];
									
									if($ffgid){ 
									/************************ School Fees start*********************************/									
									
									$fgrouplist=mysql_query("SELECT fty_id,end FROM mfgroup WHERE fg_id=$ffgid");
									$ffgroup=mysql_fetch_array($fgrouplist);
									$ftyid=$ffgroup['fty_id'];
									$fendmonth=$ffgroup['end'];									
									if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
								$ftypelist=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
														$ftypevalue=$ftype['fty_value'];													
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
								$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$lfdisid1"); 
																  $class=mysql_fetch_array($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgid;
					 $fratefrom2='1';
					 if($ftypevalue==1 && $mpdid){
					 	 $frateto2=intval($dismonth);
					 }else{
						 $frateto2=$ftypevalue;
					 }
						 
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $lacyear. "' AND c_id = '" . $lcid. "' AND ss_id = '" . $lssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							$fratelist1=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							if($ftypevalue==1){
								$f_to12=$mlate_join;	
							}else{
								$f_to12="";	
							}
								
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT fto FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
									  }		
								 }
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;						
								if($frateto2>1){						
									$frateto12=$fratefrom2+$frateto2;
								}else{
									$frateto12=$fratefrom2;
								}
								
						if($frateto12>$tomonth){
							$frateto12=$tomonth;							
						}
						if($ftypevalue==1 && $mpdid){
								 $frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2*$frateto2;
							 }else{
								 $frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;
							 }
							 $rmonth=$tomonth-$frateto12;
													
					}else {
							$frateto12=$frateto2;
							
							if($frateto12>$tomonth){
								$frateto12=$tomonth;							
							}
							
							if($ftypevalue==1 && $mpdid){
								 $frateamount12=$frateamount2*$frateto12;
							 }else{
								 $frateamount12=$frateamount2;
							 }		
							 $rmonth=$tomonth-$frateto12;				
						}
						if($frateto12==$tomonth && ($ftypevalue==1 && $mpdid)){
							$discount=1;
						}
						if($rmonth){
							$frateamount12=$frateamount12*($rmonth+1);
						}
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						if($frateamount12>0){
							//addtocart($ffgid,$fratefrom2,$frateto12,$frateamount12,$frid,$ftypevalue,$frateamount12,$frateamount2,"fees",$tomonth);
							$totalpending +=$frateamount12;
						 }
				}
				/************************ School Fees end*********************************/
				
				if($ffgdid){ /************************ Other Fees start*********************************/
														$ftypevalue=12;
									
								$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$lfdisid1"); 
																  $class=mysql_fetch_array($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgdid;
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $lacyear. "' AND c_id = '" . $lcid. "' AND ss_id = '" . $lssid. "' AND c_status!='1' AND i_status='0'";
							
							$qry3=mysql_query($qry3);							
							
							$fratelist1=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							$f_to12="";	
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT fto FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==12){										 										   
										 $fullpaid2++;
									  }		
								 }
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
								if($frateto2>1){						
									$frateto12=$fratefrom2+$frateto2;
								}else{
									$frateto12=$fratefrom2;
								}
						if($frateto12>12){
							$frateto12=12;							
						}
						
						$frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;							
					}else {
							$frateto12=$frateto2;
							$frateamount12=$frateamount2;							
						}
						 $fratefrom2;
						 $frateto12;
						  $frateamount12;
						if($frateamount12>0){
							$totalpending +=$frateamount12;
						 }
				}
				/************************ Other Fees end*********************************/
			}
				/****************************************** Pending Amount End **********************************/
					
				//echo $totalpending."<br>";
				$rollno=$lstudent['admission_number'];
				$studentlist=mysql_query("SELECT ss_id,c_id FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$acyear"); 
								  $student=mysql_fetch_array($studentlist);
								  $ssid=$student['ss_id'];
								  $cid=$student['c_id'];
				$ptypepay=0;
				$fiid2=0;
				$qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							 while($row3=mysql_fetch_array($qry3))
							{
							$fiid1=$row3['fi_id'];
							$fsummaylist=mysql_query("SELECT ftype FROM mfsalessumarry where fi_id=$fiid1"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 if($fsummay['ftype']=="pending"){
									 $ptypepay=1;
									 $fiid2=$fiid1;
									 }
								 }
							}
				
							if($totalpending){
								$fdis_id=$lstudent['fdis_id'];
								$qry6=mysql_query("SELECT fdis_name FROM fdiscount WHERE fdis_id=$fdis_id"); 
								  $row6=mysql_fetch_array($qry6);
						?>
							
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $lstudent['admission_number']; ?></center></td>
                                <td><center><?php echo $lstudent['firstname']." ".$lstudent['lastname']; ?></center></td>
                                <td><center><?php echo $lclass1['c_name']."/".$section1['s_name']; ?></center></td>
                                <td><center><?php echo $row6['fdis_name']; ?></center></td>
                                <td><center><?php echo $lstudent['stype']; ?></center></td>
                                <td><center><?php echo $totalpending; ?></center></td>
                                <td><center><?php if($totalpending>0 && $ptypepay==0){
									echo '<button class="btn btn-small btn-error" >Pending</button>';}else{
										echo '<button class="btn btn-small btn-success" >Paid</button>';
									};?></center></td>
								<td class="view"><center><?php if($fiid2){ ?> <a href="mfeesinvoice_detail.php?fiid=<?php echo $fiid2;?>&bid=<?php echo $bid;?>" target="_blank"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a><?php }else{ echo "-";} ?></center></td>
								 <?php 
							$count++;
							}
							} 
							}?>                               																
							</tbody>
						</table>
					</div>
				</div>
			</div>
            <div class="clear height-fix"></div>

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
  'iDisplayLength': 25
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
			validateform.resetForm();
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'mfeespending.php?bid='+cid;	  
	}
  </script>
  <!-- end scripts-->
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->  
</body>
</html>
<? ob_flush(); ?>