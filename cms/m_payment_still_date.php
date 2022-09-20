<? ob_start(); ?>
<?php
ini_set('max_execution_time', 300);
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 
 $montharray=array("","June","July","August","September","October","November","December","January","February","March","April","May");  
 
?> 
 <link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
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
                <li class="no-hover"><a  title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li> Month Fee Paid Report</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="board_select_paid.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
            <?php $msg=$_GET['msg'];
			if($msg=="err"){?>			
            <div class="alert error"><span class="hide">x</span>Please Select Valid Months!!!</div>
            <?php } 
			$to=$_GET['to'];
					$cid=$_GET['cid'];
					$sid=$_GET['sid'];
					$filt=$_GET['filt'];
					if(!$filt){
						$filt="all";
					}
					?>
            <div class="block-border">
					<div class="block-header">
						<h1>Select Paid type , Board and Class , Section/group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="get" action="">
                        <div class="_25">
							<p>
								<label for="select">Select Month : <span class="error">*</span></label>
                                <select name="to" id="to" class="txt">
                                	<?php
									for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
									?>
									<option value="<?php echo $cmonth;?>" <?php if($to==$cmonth){ echo 'selected="selected"'; }?>><?php echo  $montharray[$cmonth]?></option>
                                    <?php } ?>
                               </select>
                       </p>
						</div>
						<div class="_25">
							<p>
								<label for="select">Standard : </label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid"  onchange="showCategory(this.value)"> <option value="">Select Class</option>';
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
								<label for="select">Section / Group : </label>
                               <select name="sid" id="sid">
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
			 		
					if($to){ 
					if(!empty($cid)) {$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_assoc($classlist); }
							if(!empty($sid)) { $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_assoc($sectionlist);	   }								  
					$ftypelist1=mysql_query("SELECT * FROM ftype WHERE fty_value=1"); 
																  $ftype1=mysql_fetch_assoc($ftypelist1);
														$ftyid1=$ftype1['fty_id'];	
									$ftypelist11=mysql_query("SELECT * FROM mfgroup WHERE fty_id=$ftyid1"); 
																  $ftype11=mysql_fetch_assoc($ftypelist11);
														$fgid1=$ftype11['fg_id'];	
					/*$qry1="SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "'";
							if(!empty($bid) && $bid!='All') { $qry1 .= " AND bid = '" . $bid. "'"; }
							$qry1=mysql_query($qry1);
							$total=0;
			  while($row1=mysql_fetch_assoc($qry1))
        		{
			 		$total +=$row1['fi_total'];
				}*/
				?>
                <div class="grid_12"><br>
                <span id="stype"><a href="m_payment_stilldate_export.php?<?php echo "to=".$to."&cid=".$cid."&sid=".$sid."&bid=".$bid."&acid=".$acyear."&filt=".$filt;?>" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Report <?php echo "(".$montharray[$to].")";?></button></a></span>
                <div class="_25" style="float:right; width:10%">
                <label for="select">Filter by :</label>
                                	<select name="filt" id="filt" onchange="change_function1()">
                                    <option value="all" <?php if($filt=="all"){echo "selected";}?>>All</option>
                                    <option value="np" <?php if($filt=="np"){echo "selected";}?>>None-paid</option>
                                    <option value="p" <?php if($filt=="p"){echo "selected";}?>>Paid</option>
								</select>
                 </div>
                <h1>Month Fee Pending Report <?php echo "(".$montharray[$to].")";?> - <?php  if(!empty($cid)) { echo $class['c_name']; if(!empty($sid)) { echo "-".$section['s_name'];}}else{ echo "All";}?>
                </h1>
                
                <div class="block-border">
					<div class="block-header">
                    	<h1> Month Fee Pending Report <?php echo "(".$montharray[$to].")";?> - <?php echo $class['c_name']; if(!empty($sid)) { echo "-".$section['s_name'];}?></h1>                       
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
                                    <th>Class-Section</th>
                                    <th width="4%">Student type</th>
                                    <th>Phone No</th>
                                    <th>Tution Fees</th>
                                    <th>School Fees</th>
                                    <th>Bus Fees</th>
                                    <th>Last Year <br>Pending</th>
                                    <th>Total</th>
									<th>fee Paid Detail</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$studentlist="SELECT ss_id,gender,c_id,s_id,stype,mlate_join,fdis_id,sp_id,r_id,busfeestype,mlate_join,blate_join,mpd_id,admission_number,firstname,lastname,fathersname,stype,phone_number FROM student WHERE b_id='" . $bid. "' AND ay_id='" . $acyear. "'";
							if(!empty($cid)) { $studentlist .= " AND c_id = '" . $cid. "'"; }
							if(!empty($sid)) { $studentlist .= " AND s_id = '" . $sid. "'"; }
							$studentlist .= " ORDER BY gender DESC, firstname ASC";
							//$studentlist .= " AND ss_id='428' OR ss_id='427'";
							//$studentlist .= " LIMIT 0,1";
							$studentlist=mysql_query($studentlist);
							$count=1;
							$grandtotal=0;
						  while($student=mysql_fetch_assoc($studentlist))
							{	
								  $ssid=$student['ss_id'];								  
								  $ss_id=$ssid;
								//$student=mysql_fetch_assoc(mysql_query("SELECT * FROM student where ss_id='$ss_id'"));
								  $ss_gender=$student['gender'];
								  $rollno=$student['admission_number'];
								  $cid1=$student['c_id'];
								  $sid1=$student['s_id'];
								  $s_type=$student['stype'];
								  $mlate_join=$student['mlate_join'];
								  $fdisid1=$student['fdis_id'];
								  $spid=$student['sp_id'];
								  $busstudent=$student['r_id'];
								  $busfeestype=$student['busfeestype'];
								  $mlate_join=$student['mlate_join'];
								  $blate_join=$student['blate_join'];
								  
								  $classlist1=mysql_query("SELECT c_name FROM class WHERE c_id=$cid1"); 
								  $class1=mysql_fetch_assoc($classlist1);
								  
								  $sectionlist1=mysql_query("SELECT s_name FROM section WHERE s_id=$sid1"); 
								  $section1=mysql_fetch_assoc($sectionlist1);	
								  
								  
								  /*$qry4=mysql_query("SELECT * FROM fdiscount WHERE fdis_id='$fdisid1'"); 
								  $discount1=mysql_fetch_assoc($qry4);*/
								  
								  $mpdid=$student['mpd_id'];
								  $discount=0;
								  if($mpdid){
									  $paytypelist=mysql_query("SELECT value,discount FROM mpaydiscount WHERE mpd_id=$mpdid"); 
								  	  $mpaydiscount=mysql_fetch_assoc($paytypelist);
									  $dismonth=$mpaydiscount['value'];
									  $disamount=$mpaydiscount['discount'];	
								  }
								   if(($class1['c_name']=="XI STD") || ($class1['c_name']=="XII STD") || ($class1['c_name']=="XI") || ($class1['c_name']=="XII")){
									 $sid21 = $sid1;
								  }else {
									  $sid21 = "0";
								  }						
								  /*******************************Lastyear Pending *************************************/
								  $layear=mysql_query("SELECT * FROM year WHERE e_year=$syear");
				$lay=mysql_fetch_assoc($layear);  
				$lacyear=$lay['ay_id'];
				
				/****************************************** Pending Amount Start **********************************/
					$totalpending=0;
					if($lacyear){
									$lstudentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$lacyear"); 
								  $lstudent=mysql_fetch_assoc($lstudentlist);
								  $lssid=$lstudent['ss_id'];
								  $lcid=$lstudent['c_id'];
								  	$lsid=$lstudent['s_id'];
									$ls_type=$lstudent['stype'];
									$lfdisid1=$lstudent['fdis_id'];
									$mpdid=$lstudent['mpd_id'];
									$lrid=$lstudent['r_id'];
								  $lspid=$lstudent['sp_id'];
								  $lbusfeestype=$lstudent['busfeestype'];
								  $lmlate_join=$lstudent['mlate_join'];
								  $lblate_join=$lstudent['blate_join'];
									
									$lclasslist1=mysql_query("SELECT c_name FROM class WHERE c_id=$lcid"); 
								    $lclass1=mysql_fetch_assoc($lclasslist1);
									
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
									//die();
									$frid=$row2['fr_id'];
									
									if($ffgid){ /************************ School Fees start*********************************/									
									
									$fgrouplist=mysql_query("SELECT * FROM mfgroup WHERE fg_id=$ffgid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);
									
									$ftyid=$ffgroup['fty_id'];
									
									$fendmonth=$ffgroup['end'];
									
									if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
									
							
								$ftypelist=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid"); 
									$ftype=mysql_fetch_assoc($ftypelist);
									$ftypevalue=$ftype['fty_value'];	  						
								$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$lfdisid1"); 
																  $class=mysql_fetch_assoc($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgid;
					 $fratefrom2='1';
					 //$frateto2=$ftypevalue;
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
									 $frate1=mysql_fetch_assoc($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							if($ftypevalue==1){
								$f_to12=$mlate_join;	
							}else{
								$f_to12="";	
							}
								
						  while($row3=mysql_fetch_assoc($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT fto,amount FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_assoc($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
									  }		
								 }
								// $fullpaid;
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
							 //echo "((".$frateto12."-(".$fratefrom2."-1))/".$frateto2.")*".$frateamount2."<br>";
								 $frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2*$frateto2;
							 }else{
								 //echo "((".$frateto12."-(".$fratefrom2."-1))/".$frateto2.")*".$frateamount2."<br>";
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
							$totalpending +=$frateamount12;
						 }
				}/************************ School Fees end*********************************/
				
				if($ffgdid){ /************************ Other Fees start*********************************/									
									
									
									$fgrouplist=mysql_query("SELECT dis_value FROM mfgroup_detail WHERE fgd_id=$ffgdid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);
									
														$ftypevalue=12;
								$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$lfdisid1"); 
																  $class=mysql_fetch_assoc($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgdid;
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $lacyear. "' AND c_id = '" . $lcid. "' AND ss_id = '" . $lssid. "' AND c_status!='1' AND i_status='0'";
							
							//echo $qry1;
							$qry3=mysql_query($qry3);							
							
							$fratelist1=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_assoc($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							$f_to12="";	
						  while($row3=mysql_fetch_assoc($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT fto FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_assoc($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==12){										 										   
										 $fullpaid2++;
									  }		
								 }
								// $fullpaid;
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
								if($frateto2>1){						
									$frateto12=$fratefrom2+$frateto2;
								}else{
									$frateto12=$fratefrom2;
								}
						//$frateto12=$fratefrom2+$frateto2;
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
				}/************************ Other Fees end*********************************/
			}
				/****************************************** Pending Amount End **********************************/
					}
				//echo $totalpending;
				//die();
				$ptypepay=0;
				$qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							 while($row3=mysql_fetch_assoc($qry3))
							{
							$fiid1=$row3['fi_id'];
							$fsummaylist=mysql_query("SELECT ftype FROM mfsalessumarry where fi_id=$fiid1 AND fty_id='2'"); 
								 while($fsummay=mysql_fetch_assoc($fsummaylist)){
									 if($fsummay['ftype']=="pending"){
									 $ptypepay=1;
									 }
								 }
							}
							if($ptypepay==1){
								$totalpending=0;
								//echo $totalpending."<br>";	
							}
						
								  /*******************************Lastyeasr Pending End**********************************/	
								  
								  /*******************************Lastyear Bus Pending Fees Strat ********************************/
								 $btotalpending=0;
								  $sql1=mysql_query("SELECT bf_id,ftyid,end,fees,sp_fees,sp_fees_onetime,one_time FROM trbusfees WHERE sp_id=$lspid AND ay_id=$lacyear");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$bfid=$row2['bf_id'];
									$ftyid=$row2['ftyid'];
							
								$ftypelist=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_assoc($ftypelist);
														$ftypevalue=$ftype['fty_value'];
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 				
									$fendmonth=$row2['end'];
					 				if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
					 $fesstypearray=array("fees","sp_fees","sp_fees_onetime","one_time"); 
					 
					 $tablefield=$fesstypearray[$lbusfeestype];
					 $frateamount2=$row2[$tablefield]; 
					 $fullpaid2=0;
					 //$f_to12=0;
					 		if($ftypevalue==1){
								$f_to12=$lblate_join;	
							}else{
								$f_to12="";	
							}
							
							//echo $f_to12;
							
										if(!empty($bfid)) { 
					 $qry3="SELECT fto FROM bfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $lacyear. "' AND c_id = '" . $lcid. "' AND ss_id = '" . $lssid. "' AND c_status!='1' AND i_status='0'";
							
							$qry3=mysql_query($qry3);
						while($row3=mysql_fetch_assoc($qry3))
							{
								if($row3['fto']>$f_to12){
								$f_to12=$row3['fto'];
								}
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
								 }
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
						$frateto12=$fratefrom2;
						if($frateto12>$tomonth){
							$frateto12=$tomonth;
						}
						//echo '(('.$frateto12.'-('.$fratefrom2.'-1))/'.$frateto2.')*'.$frateamount2;
						$frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;
					}else {
							$frateto12=$frateto2;
							$frateamount12=$frateamount2;							
						}
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						 $frateamount2;
						if($frateamount12>0){
							$onemonth=$frateamount12/$ftypevalue;
							$totalmonth=$tomonth-$fratefrom2+1;
							$btotalpending +=($onemonth*$totalmonth);
						 }			
									}
						/****************************************** Pending Amount End **********************************/
							$bptypepay=0;
				$qry3="SELECT pending FROM bfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							 while($row3=mysql_fetch_assoc($qry3))
							{
							$pending=$row3['pending'];
									 if($pending){
									 $bptypepay=1;									 
								 }
							}
				if($btotalpending>0 && $bptypepay==0){
						$totalpending +=$btotalpending;		
						}
						/*************************************************lastyear Bus Pending Fees End *************************************/
								  /*****************************************Yearly Fees Start****************************/
								  $tot=0;
								$totalamount=0;
								$totaolpaid=0;
								      $tquery=mysql_query("SELECT fg_id,fgd_id,fr_id FROM mfrate WHERE c_id=$cid1 AND b_id=$bid AND ay_id=$acyear AND rate='$s_type' AND s_id=$sid21 AND fg_id!=$fgid1 ORDER BY fgd_id");
								      while($row2=mysql_fetch_assoc($tquery)){									  
										   
									 $ffgid=$row2['fg_id'];
									 $ffgdid=$row2['fgd_id'];
									//die();
									$frid=$row2['fr_id'];									
									if($ffgid){ /************************ School Fees start*********************************/									
									
									$fgrouplist=mysql_query("SELECT fty_id,end FROM mfgroup WHERE fg_id=$ffgid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);
									
									$ftyid=$ffgroup['fty_id'];
									
									$fendmonth=$ffgroup['end'];
									
									if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}							
								$ftypelist=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_assoc($ftypelist);
														$ftypevalue=$ftype['fty_value'];												
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
								$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
																  $class=mysql_fetch_assoc($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgid;
					 $fratefrom2='1';
					 //$frateto2=$ftypevalue;
					 if($ftypevalue==1 && $mpdid){
					 	 $frateto2=intval($dismonth);
					 }else{
						 $frateto2=$ftypevalue;
					 }
						 
					 $frateamount2=$class['dis_value'];
					 if($ftypevalue==1){
					 $totalamount +=$frateamount2*$tomonth;
					 }else{
					 $totalamount +=$frateamount2;
					 }
					 $fullpaid2=0;
					 $yf_to12=0;
					 					if(!empty($frid)) { 
					 $qry31="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ss_id. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry31=mysql_query($qry31);
							$fratelist11=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate11=mysql_fetch_assoc($fratelist11);
					$ffgid21=$frate11['fg_id'];
					$ffgdid21=$frate11['fgd_id'];	 
					
							if($ftypevalue==1){
								$yf_to12=$mlate_join;	
							}else{
								$yf_to12="";	
							}
								$paidamount=0;
						  while($row31=mysql_fetch_assoc($qry31))
							{
								$fullpaid2=0;
								$fiid1=$row31['fi_id'];
								$fsummaylist1=mysql_query("SELECT fto,amount FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay1=mysql_fetch_assoc($fsummaylist1)){
									 $yf_to12=$fsummay1['fto'];
									 $paidamount +=$fsummay1['amount'];
									 if($yf_to12==$tomonth){										 										   
										 $fullpaid2++;
									  }		
								 }
								}
					}
					//echo $yf_to12;
					if($yf_to12){
						$fratefrom2=$yf_to12+1;
						
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
								 //echo "((".$frateto12."-(".$fratefrom2."-1))/".$frateto2.")*".$frateamount2."<br>";
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
						
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						 if($rmonth){
							$frateamount12=$frateamount12*($rmonth+1);
						}
						//if($frateamount12>0){
							 $tot +=$frateamount12;
							 $totaolpaid +=$paidamount;
							//echo $paidamount;
							//echo "<br>";
						 //}
				}/************************ School Fees end*********************************/
				
				if($ffgdid){ /************************ Other Fees start*********************************/									
									
									
									/*$fgrouplist=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$ffgdid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);*/
														$ftypevalue=12;
								$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
																  $class=mysql_fetch_assoc($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgdid;
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $yf_to12=0;
										if(!empty($frid)) { 
					 $qry31="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
							
							//echo $qry1;
							$qry31=mysql_query($qry31);							
							
							$fratelist11=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate11=mysql_fetch_assoc($fratelist11);
					$ffgid21=$frate11['fg_id'];
					$ffgdid21=$frate11['fgd_id'];	 
					
							$f_to12="";	
							$paidamount=0;
						  while($row31=mysql_fetch_assoc($qry31))
							{
								$fullpaid2=0;
								$fiid1=$row31['fi_id'];
								$fsummaylist1=mysql_query("SELECT fto,amount FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay1=mysql_fetch_assoc($fsummaylist1)){
									 $f_to12=$fsummay1['fto'];
									 $paidamount +=$fsummay1['amount'];
									 if($f_to12==12){										 										   
										 $fullpaid2++;
									  }		
								 }
								// $fullpaid;
								}
					}
					if($yf_to12){
						$fratefrom2=$yf_to12+1;
								if($frateto2>1){						
									$frateto12=$fratefrom2+$frateto2;
								}else{
									$frateto12=$fratefrom2;
								}
						//$frateto12=$fratefrom2+$frateto2;
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
							$tot +=$frateamount12;
						 }
						 //echo $paidamount."<br>";
						 $totaolpaid +=$paidamount;
						 $totalamount +=$frateamount2;
				}/************************ Other Fees end*********************************/
									}
									/************************ Year Fees end*********************************/
									//echo $totalamount."-".$totaolpaid."<br>";
							$totalyearly=($totalamount-$totaolpaid);	
								  $tot=0;
								$totalamount=0;
								      $tquery=mysql_query("SELECT fg_id,fgd_id,fr_id FROM mfrate WHERE c_id=$cid1 AND b_id=$bid AND ay_id=$acyear AND rate='$s_type' AND s_id=$sid21 AND fg_id=$fgid1 ORDER BY fgd_id");
								      while($row2=mysql_fetch_assoc($tquery)){
										  
									 $ffgid=$row2['fg_id'];
									 $ffgdid=$row2['fgd_id'];
									//die();
									$frid=$row2['fr_id'];
																		
									if($ffgid){ /************************ School Fees start*********************************/									
									
									$fgrouplist=mysql_query("SELECT fty_id,end FROM mfgroup WHERE fg_id=$ffgid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);
									
									$ftyid=$ffgroup['fty_id'];
									
									$fendmonth=$ffgroup['end'];
									
									if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
							$ftypelist=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid"); 
						    $ftype=mysql_fetch_assoc($ftypelist);
							$ftypevalue=$ftype['fty_value'];													
							
			//$_SESSION['frate']['ffrom'] = '1';
			//$_SESSION['frate']['fto'] = $ftypevalue;		  						
					$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
													  $class=mysql_fetch_assoc($classlist);
																	
							$frateid2=$ffgid;
					 $fratefrom2='1';
					 //$frateto2=$ftypevalue;
					 if($ftypevalue==1 && $mpdid){
					 	 $frateto2=intval($dismonth);
					 }else{
						 $frateto2=$ftypevalue;
					 }
						 
					 $frateamount2=$class['dis_value'];
					 if($ftypevalue==1){
					 $totalamount +=$frateamount2*$tomonth;
					 }else{
					 $totalamount +=$frateamount2;
					 }
					 $fullpaid2=0;
					 $f_to12=0;
					 if($ftypevalue=='1'){
						 $feesamount=$class['dis_value'];
					 }
					 
										if(!empty($frid) && $ftypevalue=='1') { 
					 $qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ssid. "' AND c_status!='1'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							$fratelist1=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_assoc($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							if($ftypevalue==1){
								$f_to12=$mlate_join;	
							}else{
								$f_to12="";	
							}
								
						  while($row3=mysql_fetch_assoc($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT fto FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_assoc($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
									  }		
								 }
								}
										}
								//echo $f_to12;
								$bfrateamount2=0;
								$btomonth=0;
								if($spid && $busstudent){
								/****************************************BUS FEES START***********************************/
								$sql11=mysql_query("SELECT bf_id,ftyid,end,fees,sp_fees,sp_fees_onetime,one_time FROM trbusfees WHERE sp_id=$spid AND ay_id=$acyear");
									while($row21=mysql_fetch_assoc($sql11))
									{ 
									$bfid=$row21['bf_id'];
									$ftyid1=$row21['ftyid'];
							
								$ftypelist1=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid1"); 
																  $ftype1=mysql_fetch_assoc($ftypelist1);
														$bftypevalue=$ftype1['fty_value'];
					 $fratefrom2='1';
					 $frateto2=$bftypevalue;
					 				
									$fendmonth=$row21['end'];
					 				if($fendmonth){
										$btomonth=$fendmonth;
									}else{
										$btomonth=12;
									}
					 $fesstypearray1=array("fees","sp_fees","sp_fees_onetime","one_time"); 
					 
					 $tablefield=$fesstypearray1[$busfeestype];
					 $bfrateamount2=$row21[$tablefield]; 
					 $fullpaid2=0;
					 //$f_to12=0;
					 		if($bftypevalue==1){
								$bf_to12=$blate_join;	
							}else{
								$bf_to12="";	
							}
							
							//echo $bf_to12."-".$ss_id."<br>";
							
										if(!empty($bfid)) { 
					 $qry31="SELECT fto FROM bfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid1. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
							
							$qry31=mysql_query($qry31);
						while($row31=mysql_fetch_assoc($qry31))
							{
								if($row31['fto']>$bf_to12){
								$bf_to12=$row31['fto'];
								}
									 if($bf_to12==$btomonth){										 										   
										 $fullpaid2++;
								 }
								}
					}
					if($bf_to12){
						$fratefrom2=$bf_to12+1;
						//$frateto12=$fratefrom2+$frateto2;
						$frateto12=$fratefrom2;
						if($frateto12>$btomonth){
							$frateto12=$btomonth;
							
						}
						
						//echo $btomonth;
						//$frateamount12=(($frateto12-$fratefrom2)/$frateto2)*$bfrateamount2;							
						//echo '(('.$frateto12.'-('.$fratefrom2.'-1))/'.$frateto2.')*'.$bfrateamount2;
						$frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$bfrateamount2;
						
					}else {
							$frateto12=$frateto2;
							$frateamount12=$bfrateamount2;							
						}
						
									}
									
						/****************************************BUS FEES END***********************************/	
								}
								$totalpending =round($totalpending,2);
								$totalmonth=0; $btotal=0; $total=0;
								for($i=$from;$i<=$to;$i++){
									/*********monthly****************/
                                     if($f_to12>=$i){
										 //echo "paid";
										 }else{ 
												if($i<=$tomonth){
												$totalmonth+=round($feesamount,2);}}
									/*********Transport****************/
									if($spid && $busstudent){
										 if($fratefrom2<=$i){
											 if($i<=$btomonth){
													$btotal+=round($bfrateamount2,2);}
											 }	
										} 
									}
									//echo $student['firstname']."-".$btomonth."-".$fratefrom2."-".$bfrateamount2."-".$btotal."<br>";
									$totalyearly=round($totalyearly,2);
									$total=$totalmonth+$btotal+$totalyearly+$totalpending;
								if($filt=='np' && $total){
									$grandtotal +=$total;
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
                                <td><center><?php echo $student['phone_number']; ?></center></td>
                                <td><?php if($totalmonth){ echo $totalmonth; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }?></td>
                                 <td><?php if($totalyearly){ echo $totalyearly; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }?></td>    
                                <td><?php if($spid && $busstudent){ if($btotal){ echo $btotal; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }}else{ echo "-"; }?></td>  
                                <td><?php if($totalpending){ echo "<b>".$totalpending."<br>"; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }?></td>
                                <td><?php if($total){ echo "<b>".$total."<br>"; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }?></td> 
                                <td class="view"><center><a href="mstudent_feesinvoice.php?ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>" target="_blank"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php  $count++;
									}else if($filt=='p' && !$total){
										$grandtotal +=$total;
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
                                <td><center><?php echo $student['phone_number']; ?></center></td>
                                <td><?php if($totalmonth){ echo $totalmonth; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }?></td>
                                 <td><?php if($totalyearly){ echo $totalyearly; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }?></td>    
                                <td><?php if($spid && $busstudent){ if($btotal){ echo $btotal; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }}else{ echo "-"; }?></td> 
                                <td><?php if($totalpending){ echo "<b>".$totalpending."<br>"; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }?></td> 
                                <td><?php if($total){ echo "<b>".$total."<br>"; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }?></td>  
                                <td class="view"><center><a href="mstudent_feesinvoice.php?ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>" target="_blank"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php  $count++;
									}else if($filt=="all"){
										$grandtotal +=$total;
					?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $student['fathersname']; ?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section1['s_name']; ?></center></td>
                                <td><center><?php echo $student['stype']; ?></center></td>
                                <td><center><?php echo $student['phone_number']; ?></center></td>
                                <td><?php if($totalmonth){ echo $totalmonth; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }?></td>
                                 <td><?php if($totalyearly){ echo $totalyearly; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }?></td>    
                                <td><?php if($spid && $busstudent){ if($btotal){ echo $btotal; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }}else{ echo "-"; }?></td> 
                                <td><?php if($totalpending){ echo "<b>".$totalpending."<br>"; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }?></td> 
                                <td><?php if($total){ echo "<b>".$total."<br>"; }else{ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>'; }?></td>  
                                <td class="view"><center><a href="mstudent_feesinvoice.php?ssid=<?php echo $ssid;?>&bid=<?php echo $bid;?>" target="_blank"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								</tr>                                 
                                 <?php  $count++;
									}
										}
								 }
					
				}/************************ School Fees end*********************************/
									 //} ?>                            																
							</tbody>
						</table>
					</div>
				</div>	
                <div id="tot" style="float: right; width: 200px;" ><b>Total Amount : <?php echo "Rs.".number_format($grandtotal,2); ?></b></div>		
		<div class="clear height-fix"></div>
        </div>
        <?php } ?>
        </div>
        </div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");
	?>
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
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>
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
		$( "#tot" ).insertAfter( "#stype" );
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).datepicker();
		$( "#datepicker1" ).datepicker();
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'm_payment_still_date.php?bid='+cid;	  
	} 
	function change_function1() { 
     var cid =document.getElementById('filt').value;
	 window.location.href = 'm_payment_still_date.php?filt='+cid+'<?php echo "&from=$from&to=$to&cid=$cid&sid=$sid&bid=$bid"?>';	  
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
</body>
</html>
<? ob_flush(); ?>