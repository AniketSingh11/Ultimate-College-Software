<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("includes/functions1.php");
 //echo $_SESSION['uname'];
 //echo $acyear;
 
 if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){
		remove_product($_REQUEST['pid']);
	}else if($_REQUEST['command']=='clear'){
		unset($_SESSION['fees']);
	}
	else if($_REQUEST['command']=='cancel'){
		unset($_SESSION['fees']);
		$bid=$_REQUEST['bid'];
		header("location:busfeesbilling.php?bid=$bid");
	}
	else if($_REQUEST['command']=='update'){
		$max=count($_SESSION['fees']);
		$cheque=$_REQUEST['cheque_service'];

		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['fees'][$i]['fgid'];
			 $q1=intval($_REQUEST['bffrom'.$pid]);
			 $r1=intval($_REQUEST['bfto'.$pid]);
			 $s1=$_REQUEST['fees'.$pid];
			//die();
			if(!empty($q1) && !empty($r1) && !empty($s1)){
				$_SESSION['fees'][$i]['ffrom']=$q1;
				$_SESSION['fees'][$i]['fto']=$r1;
				$_SESSION['fees'][$i]['amount']=$s1;
				$_SESSION['fees'][$i]['cheque']=$cheque;
				$_SESSION['fees'][$i]['totamount']=$s1+$cheque;
			}
			else{
				$msg='Some category fees not updated!,please select valid Month!!!';
			}
		}
	}
if (isset($_POST['place-order']))
{
	 
	   $frno=$_POST['frno'];
	   $ptype=$_POST['ptype'];
	   $ssid1=$_POST['ssid1'];
	   $ss_name=$_POST['ss_name'];
	   $cid1=$_POST['cid1'];
	   $sid1=$_POST['sid1'];
	   $rid1=$_POST['rid1'];
	   $spid1=$_POST['spid1'];
	   $busfeestype1=$_POST['busfeestype1'];
	   $idate=$_POST['idate'];
	   $idatesplit=explode("/",$idate);  
	    $day=$idatesplit[0]; 
	    $month=$idatesplit[1];
	    $year=$idatesplit[2];
	   /*$day=date("d");
	   $month=date("m");
	   $year=date("Y");*/
	  //$seid=$_POST['se_id'];
	   $total=$_POST['total'];
	   $category=$_POST['category'];
	   $stype=$_POST['stype'];
	   $bid1=$_POST['bid1'];
	   
	   $pmfrom=$_POST['pmfrom'];
	   $pmto=$_POST['pmto'];
	   $pending=$_POST['pending'];	
	   
	   $pay_number=$_POST['pay_number'];
	   
	   $get_amount=$_POST['get_amount'];
	   $balance=$_POST['balance'];	
	   
	   $bank_name=$_POST['bank_name'];
	   $cheque_date=$_POST['cheque_date'];     
	    $c_fi_id=$_POST['service_invoice_id'];
 		$chequeservice=$_POST['cheque_service'];
 		$total=$total-$chequeservice;
	   $qry31=mysql_query("SELECT * FROM bfinvoice_no WHERE id='1'"); 
								  $row31=mysql_fetch_array($qry31);
								  $invoice_no=$row31['count'];
								  
	  $max=count($_SESSION['fees']);
				for($i=0;$i<$max;$i++){
					  $pid=$_SESSION['fees'][$i]['fgid'];
					  $q=$_SESSION['fees'][$i]['ffrom'];
					  $s=$_SESSION['fees'][$i]['fto'];
					  $r=$_SESSION['fees'][$i]['amount'];
					  $t=$_SESSION['fees'][$i]['ftid'];
					  $y=$_SESSION['fees'][$i]['ftype'];
					if($q==0) continue;
	 if($y=="fees"){

	 $sql="INSERT INTO bfinvoice (fr_no,fi_name,fi_total,fi_ptype,fi_day,fi_month,fi_year,ss_id,c_id,s_id,ffrom,fto,r_id,sp_id,busfeestype,bfi_by,bid,ay_id,pmfrom,pmto,pending,pay_number,get_amount,balance,bank_name,cheque_date,cheque_service) VALUES
('$invoice_no','$ss_name','$total','$ptype','$day','$month','$year','$ssid1','$cid1','$sid1','$q','$s','$rid1','$spid1','$busfeestype1','$user','$bid1','$acyear','$pmfrom','$pmto','$pending','$pay_number','$get_amount','$balance','$bank_name','$cheque_date','$chequeservice')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=$id = mysql_insert_id();
    if($result){
								  $inovoice=$invoice_no+1;
					$qry1=mysql_query("UPDATE bfinvoice_no SET count='$inovoice' WHERE id='1'");
				}
				unset($_SESSION['fees']);
				unset($_SESSION['frate']);
				header("location:bfinvoice.php?bfiid=$lastid&bid=$bid1");
    }else if($y=="pending" && $max==1){
		 $sql="INSERT INTO bfinvoice (fr_no,fi_name,fi_total,fi_ptype,fi_day,fi_month,fi_year,ss_id,c_id,s_id,ffrom,fto,r_id,sp_id,busfeestype,bfi_by,bid,ay_id,pmfrom,pmto,pending,pay_number,get_amount,balance,bank_name,cheque_date,cheque_service) VALUES
('$invoice_no','$ss_name','$total','$ptype','$day','$month','$year','$ssid1','$cid1','$sid1','0','0','$rid1','$spid1','$busfeestype1','$user','$bid1','$acyear','$pmfrom','$pmto','$pending','$pay_number','$get_amount','$balance','$bank_name','$cheque_date','$chequeservice')";
//die();
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=$id = mysql_insert_id();
$update_cheque=mysql_query("update bfinvoice set service_charge_status=1 where bfi_id=$c_fi_id");
    if($result){
								  $inovoice=$invoice_no+1;
					$qry1=mysql_query("UPDATE bfinvoice_no SET count='$inovoice' WHERE id='1'");
				}
				unset($_SESSION['fees']);
				unset($_SESSION['frate']);
				header("location:bfinvoice.php?bfiid=$lastid&bid=$bid1");
	}
				}
				die();
}		
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
                <li class="no-hover"><a href="board_select_busfees.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Bus Fees Paymant</li> 
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
								
            </div>
                 <h1><a href="board_select_busfees.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>  Bus Fees Invoice</h1>
                 
			<div class="grid_12">
				<?php if($_GET['roll']){
					
					$roll=$_GET['roll'];
					$classes=explode("-",$roll);  
					//print_r($classes);
					$rollno=$classes[0];  
					$studentname=$classes[1];  

					//die();
					
					$studentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$acyear"); 
								  $student=mysql_fetch_array($studentlist);
								  $ssid=$student['ss_id'];
								  $ss_gender=$student['	gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  $s_type=$student['stype'];
								  $fdisid1=$student['fdis_id'];
								  $rid=$student['r_id'];
								  $spid=$student['sp_id'];
								  $busfeestype=$student['busfeestype'];
								  $mlate_join=$student['mlate_join'];
								  $blate_join=$student['blate_join'];
								  
				$max=count($_SESSION['fees']);
			if(empty($_SESSION['fees'])){
				//echo "test"; 		die();	
				$layear=mysql_query("SELECT * FROM year WHERE e_year=$syear");
				$lay=mysql_fetch_array($layear);  
				$lacyear=$lay['ay_id'];
				
				/****************************************** Pending Amount Start **********************************/
					$totalpending=0;
					if($lacyear){
						$lstudentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$lacyear"); 
								  $lstudent=mysql_fetch_array($lstudentlist);
								  $lssid=$lstudent['ss_id'];
								  $lcid=$lstudent['c_id'];
								  	$lsid=$lstudent['s_id'];
									$ls_type=$lstudent['stype'];
									$lrid=$lstudent['r_id'];
								  $lspid=$lstudent['sp_id'];
								  $lbusfeestype=$lstudent['busfeestype'];
								  $lmlate_join=$lstudent['mlate_join'];
								  $lblate_join=$lstudent['blate_join'];
									
									$lclasslist1=mysql_query("SELECT * FROM class WHERE c_id=$lcid"); 
								    $lclass1=mysql_fetch_array($lclasslist1);
									
									if(($lclass1['c_name']=="XI STD") || ($lclass1['c_name']=="XII STD") || ($lclass1['c_name']=="XI") || ($lclass1['c_name']=="XII")){
									 $lsid21 = $lsid;
								  }else {
									  $lsid21 = "0";
								  }
								  
								  $sql1=mysql_query("SELECT * FROM trbusfees WHERE sp_id=$lspid AND ay_id=$lacyear");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$bfid=$row2['bf_id'];
									$ftyid=$row2['ftyid'];
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
								
														$ftypevalue=$ftype['fty_value'];
					 $fratefrom2='1';
					 if($lblate_join){
						 $fratefrom2=$lblate_join;
					 }
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
					 $qry3="SELECT * FROM bfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $lacyear. "' AND c_id = '" . $lcid. "' AND ss_id = '" . $lssid. "' AND c_status!='1' AND i_status='0'";
							
							$qry3=mysql_query($qry3);
						while($row3=mysql_fetch_array($qry3))
							{
								$f_to12=$row3['fto'];
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
								 }
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
						//$frateto12=$fratefrom2+$frateto2;
						$frateto12=$fratefrom2;
						if($frateto12>$tomonth){
							$frateto12=$tomonth;
						}
						//$frateamount12=(($frateto12-$fratefrom2)/$frateto2)*$frateamount2;							
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
							$totalpending +=($onemonth*$totalmonth);
							//addtocart($bfid,$fratefrom2,$frateto12,$frateamount12,$ftyid,$ftypevalue,$frateamount12,$frateamount2,$tomonth);
						 }			
									}
									
						/****************************************** Pending Amount End **********************************/
							$ptypepay=0;
				$qry3="SELECT pending FROM bfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							 while($row3=mysql_fetch_array($qry3))
							{
							$pending=$row3['pending'];
									 if($pending){
									 $ptypepay=1;									 
								 }
							}
				if($totalpending>0 && $ptypepay==0){
						addtocart($bfid,$fratefrom2,$frateto12,$totalpending,$ftyid,$ftypevalue,$totalpending,$frateamount2,$tomonth,"pending");		
						}		
									/****************************************** Pending Amount Add End **********************************/
									
								  $sql1=mysql_query("SELECT * FROM trbusfees WHERE sp_id=$spid AND ay_id=$acyear");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$bfid=$row2['bf_id'];
									$ftyid=$row2['ftyid'];
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
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
					 
					 $tablefield=$fesstypearray[$busfeestype];
					 $frateamount2=$row2[$tablefield]; 
					 $fullpaid2=0;
					 //$f_to12=0;
					 		if($ftypevalue==1){
								$f_to12=$blate_join;	
							}else{
								$f_to12="";	
							}
							
							//echo $f_to12;
							
										if(!empty($bfid)) { 
					 $qry3="SELECT fto FROM bfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0' ORDER BY bfi_id DESC LIMIT 0,1";
							
							$qry3=mysql_query($qry3);
						while($row3=mysql_fetch_array($qry3))
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
						//$frateto12=$fratefrom2+$frateto2;
						$frateto12=$fratefrom2;
						if($frateto12>$tomonth){
							$frateto12=$tomonth;
							
						}
						
						//$frateamount12=(($frateto12-$fratefrom2)/$frateto2)*$frateamount2;							
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
							addtocart($bfid,$fratefrom2,$frateto12,$frateamount12,$ftyid,$ftypevalue,$frateamount12,$frateamount2,$tomonth,"fees");
						 }
									}
					}
						$sql1=mysql_query("SELECT * FROM trbusfees WHERE sp_id=$spid AND ay_id=$acyear");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$bfid=$row2['bf_id'];
									$ftyid=$row2['ftyid'];
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
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
					 
					 $tablefield=$fesstypearray[$busfeestype];
					 $frateamount2=$row2[$tablefield]; 
					 $fullpaid2=0;
					 //$f_to12=0;
					 		if($ftypevalue==1){
								$f_to12=$blate_join;	
							}else{
								$f_to12="";	
							}
							
							//echo $f_to12;
							
										if(!empty($bfid)) { 
					 $qry3="SELECT * FROM bfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
							
							$qry3=mysql_query($qry3);
						while($row3=mysql_fetch_array($qry3))
							{
								$f_to12=$row3['fto'];
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
								 }
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
						//$frateto12=$fratefrom2+$frateto2;
						$frateto12=$fratefrom2;
						if($frateto12>$tomonth){
							$frateto12=$tomonth;
							
						}
						
						//$frateamount12=(($frateto12-$fratefrom2)/$frateto2)*$frateamount2;							
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
							addtocart($bfid,$fratefrom2,$frateto12,$frateamount12,$ftyid,$ftypevalue,$frateamount12,$frateamount2,$tomonth);
						 }
										
									}
				}
								  if(!$student){
			header("location:busfeesbilling.php?bid=$bid");
		}
							?>
				<div id="invoice" class="widget widget-plain">			
				<br>
                
                <form name="form1" method="post" action="" id="validate-form" class="block-content-invoice form">
<input type="hidden" name="pid" />
<input type="hidden" name="bid" value="<?php echo $bid;?>" />
<input type="hidden" name="command" />
                <?php 
					$studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student1=mysql_fetch_array($studentlist1);
								  $cid1=$student1['c_id'];
								  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $row=mysql_fetch_array($qry);
								  
								  $sid1=$student1['s_id'];
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_array($qry1);
								  
								  $rid1=$student1['r_id'];
								  
								  $spid1=$student1['sp_id'];
								  $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $trrid=$row6['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$trrid"); 
								  $row5=mysql_fetch_array($qry5);
								  
								  $qry3=mysql_query("SELECT * FROM bfinvoice_no WHERE id='1'"); 
								  $row3=mysql_fetch_array($qry3);
								  $invoice_no=$row3['count'];
								  
								  $fdisid=$student1['fdis_id'];
								  $qry4=mysql_query("SELECT * FROM fdiscount WHERE fdis_id='$fdisid'"); 
								  $row4=mysql_fetch_array($qry4);
								  $fdisname=$row4['fdis_name'];
								  $montharray=array("","June","July","August","September","October","November","December","January","February","March","April","May"); 
								  $fesstypearray1=array("Normal Fees","Sp.Fees","Onetime Sp.Fees","Onetime Fees"); 
								  $busfeestype1=$student1['busfeestype'];
								  ?>
						<?php
				// Cheque Bounce Finder dev-sri
				$bouncefind=mysql_query("SELECT * FROM bfinvoice WHERE ss_id=$ssid AND ay_id=$acyear AND c_status=1 AND service_charge_status IS NULL");
				$B_there=mysql_fetch_array($bouncefind);
				//echo "<pre>";
				//	print_r($B_there);
				//echo "</pre>" 
				?>
						<div class="widget-content">			
				<ul class="client_details">
					<li><strong class="name">FR Number : <?php echo $invoice_no;?></strong><input type="hidden" class="medium" name="frno" value="<?php echo $invoice_no;?>"/></li>
                    <li>Class: <?php echo $row['c_name'];?><input type="hidden" class="medium" name="cid1" value="<?php echo $cid;?>"/></li>
					<li>Gender: <?php if($student1['gender'] == 'M')
											echo "Male";
										else	
										    echo "Female"; ?><input type="hidden" class="medium" name="bid1" value="<?php echo $bid;?>"/></li>
				</ul>
                <ul class="client_details">
					<li>Student Name : <strong class="name"><?php echo $student1['firstname']." ".$student1['middlename']." ".$student1['lastname'];?></strong> <input type="hidden" class="medium" name="ss_name" value="<?php echo $student1['firstname']." ".$student1['middlename']." ".$student1['lastname'];?>"/></li>
					<li>Admission No: <?php echo $student1['admission_number'];?> <input type="hidden" class="medium" name="adminid" value="<?php echo $student1['admission_number'];?>"/></li>
					<li>Section/Group: <?php echo $row1['s_name'];?><input type="hidden" class="medium" name="sid1" value="<?php echo $sid;?>"/></li>					
				</ul>
                <ul class="client_details">
					<li>Academic Year : <strong class="name"><?php echo $acyear_name;?></strong><input type="hidden" class="medium" name="ssid1" value="<?php echo $ssid; ?>"/></li>
					<li>Route Name: <?php echo $row5['r_name'];?> <input type="hidden" class="medium" name="rid1" value="<?php echo $rid1;?>"/></li>
                    <li><strong>Stopping Point 	:</strong> <?php echo $row6['stop_name'];?><input type="hidden" class="medium" name="spid1" value="<?php echo $spid1;?>"/></li> 					
				</ul>
				<ul class="client_details">
					<li>Status			: <span class="ticket ticket-info">Open</span></li>
					<li><strong>Invoice Date 	:</strong> <input id="datepicker" name="idate" type="text" value="<?php echo date("d/m/Y");?>"  style="width:60%"/></li> 
                    <li><strong>BusFees Type 	:</strong> <?php echo $fesstypearray1[$busfeestype1];?><input type="hidden" class="medium" name="busfeestype1" value="<?php echo $busfeestype1;?>"/></li>                   
				</ul>				
				<table class="table table-striped" id="table-example">	
                <?php
				$max=count($_SESSION['fees']);
			if(is_array($_SESSION['fees']) && $max>0){ ?>				
					<thead>
						<tr>
							<th>S.No</th>
							<th>Type of Fees Name</th>
							<th>Fees Month From</th>
							<th>Fees Month To</th>
							<th class="total">Total</th>
                            <th width="10"></th>
						</tr>
					</thead>						
					<tbody>
                    <?php 
                    $max=count($_SESSION['fees']);
				$count=1;
				for($i=0;$i<$max;$i++){
					  $pid=$_SESSION['fees'][$i]['fgid'];
					  $q=$_SESSION['fees'][$i]['ffrom'];
					  $r=$_SESSION['fees'][$i]['fto'];
					  $s=$_SESSION['fees'][$i]['amount'];
					  $u=$_SESSION['fees'][$i]['dftyvalue'];
					  $v=$_SESSION['fees'][$i]['damount'];
					  $w=$_SESSION['fees'][$i]['ftamount'];
					  $x=$_SESSION['fees'][$i]['ftomonth'];
					  $y=$_SESSION['fees'][$i]['ftype'];
					  $totamt=$_SESSION['fees'][$i]['totamount'];
					  $cheque=$_SESSION['fees'][$i]['cheque'];
					  if($y=="fees"){
					 ?>
						<tr>
							<td><?php echo $count;?></td>			
							<td>Bus Fees</td>
							<td><?php //echo $montharray[$q-1];?>
                                    <select name="bffrom<?php echo $pid;?>" id="bffrom<?php echo $pid;?>" class="required" onchange="change_amountfrom<?php echo $pid;?>()" >
                                    <?php
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
				if($q==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected"><?php echo  $montharray[$cmonth]?></option>
            <?php } }?>	
                                    </select>										
							   </td>
							<td><?php //echo $montharray[$r-1];?>
                                    <select name="bfto<?php echo $pid;?>" id="bfto<?php echo $pid;?>" class="txt" onchange="change_amountfrom<?php echo $pid;?>()">
                                	<?php
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) {
				if($x>=$cmonth){	 
				if($q<=$cmonth){
				if($r==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected"><?php echo  $montharray[$cmonth]?></option>
            <?php } else if(!$r && 12==$cmonth) { ?>
                                     <option value="<?php echo $cmonth;?>" selected="selected"><?php echo $montharray[$cmonth];?></option>
                                     <?php }else { ?>				
            <option value="<?php echo $cmonth;?>" style="background-color:#D6EDF8" ><?php echo  $montharray[$cmonth]?></option>            
            <?php } } } } ?>	
                                    </select>										
							</td>
							        <td class="total" width="120"><span><?php $samount=number_format($s,2);?></span>
                                   <input type="text" name="fees<?php echo $pid;?>" id="fees<?php echo $pid;?>" class="biginput required" value="<?php echo $s;?>"  readonly />									
							  </td>
                            <td><a href="javascript:del(<?php echo $pid?>)"><img src="Book_inventory/images/del.png" alt="delete"></a></td>
                             <input type="hidden" id="ffrom_<?php echo $pid;?>" value="<?php echo $q;?>" />
                             <input type="hidden" id="ftyvalue<?php echo $pid;?>" value="<?php echo $u;?>" />
                             <input type="hidden" id="feesvalue<?php echo $pid;?>" value="<?php echo $v;?>" />
                             <input type="hidden" id="tfeesvalue<?php echo $pid;?>" value="<?php echo $w;?>" />
                            </tr>
						<?php }else if($y=="pending"){?> 
						<tr>
							<td><?php echo $count;?></td>			
							<td><b>Last Year Pending Amount</b></td>
							<td><?php //echo $montharray[$q-1];?>
                                    <select name="bffrom<?php echo $pid;?>" id="bffrom<?php echo $pid;?>" class="required" onchange="change_amountfrom<?php echo $pid;?>()" >
                                    <?php
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
				if($q==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected"><?php echo  $montharray[$cmonth]?></option>
            <?php } }?>	
                                    </select>										
							   </td>
							<td><?php //echo $montharray[$r-1];?>
                                    <select name="bfto<?php echo $pid;?>" id="bfto<?php echo $pid;?>" class="txt">
                                	<?php
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) {
				if($x==$cmonth){	 
				if($q<=$cmonth){
				if($r==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected"><?php echo  $montharray[$cmonth]?></option>
            <?php } else if(!$r && 12==$cmonth) { ?>
                                     <option value="<?php echo $cmonth;?>" selected="selected"><?php echo $montharray[$cmonth];?></option>
                                     <?php }else { ?>				
            <option value="<?php echo $cmonth;?>" style="background-color:#D6EDF8" ><?php echo  $montharray[$cmonth]?></option>            
            <?php } } } } ?>	
                                    </select>										
							</td>
							<td class="total" width="120"><span><?php $samount=number_format($s,2);?></span>
                                   <input type="text" name="fees<?php echo $pid;?>" id="fees<?php echo $pid;?>" class="biginput required" value="<?php echo $s;?>"  readonly />									
							</td>
                            <td></td>
                            </tr>
                            <input type="hidden" name="pmfrom" value="<?php echo $q;?>" />
                            <input type="hidden" name="pmto" value="<?php echo $x;?>" />
                            <input type="hidden" name="pending" value="<?php echo $s;?>" />
						
						<?php }$count++;} ?>
						<?php    //Cheque Bounce dev-sri
						if($B_there['c_status']==1){ ?>
							<tr>
							<td colspan="3"></td>
							<td>Cheque Bounce Charges :</td>
							<input type="hidden" name="service_invoice_id" value="<?= $B_there['bfi_id']?>">
							<td><input id="chequecharge" class="biginput txt text" type="text" autocomplete="off" name="cheque_service" value="<?= $cheque?>"></td>
							<td></td>
						</tr>
						<?php } else { 
							
						}  // cheque bounce dev-sri ?>
						<tr>
							<td class="sub_total" colspan="3"></td>
							<td class="sub_total">Subtotal:</td>
							<td class="sub_total">Rs. <?php echo number_format(get_order_total()+$cheque,2);?></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="3"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs. <?php echo number_format(get_order_total()+$cheque,2);?><input type="hidden" class="medium" name="total" value="<?php echo get_order_total()+$cheque;?>" /></td>
						</tr>
                        <tr>
							<td colspan="6" align="right">	
									<div class="_25">
                                    <p>
                                    <label for="textfield">Payment Type:</label>
										<select name="ptype" id="ptype" class="required" onchange="paymet_type()">
											<!--<option value="">Please select</option>-->
                                            <option value="cash">Cash</option>	
                                            <option value="card">Card</option>
                                            <option value="cheque">cheque</option>									
										</select>	
                                    </p>									
									</div>
                                    <div id="ajax_pay">
									</div>
                                    <div id="cash_pay">
                                    <div class="_25">
                                    <p>
                                        <label for="textfield">Get Amount </label>
                                        <input id="textfield" name="get_amount" class="getamount" type="text" value="" />
                                    </p>
                                    </div>
                                    <div class="_25">
                                    <p>
                                        <label for="textfield">Given Balance</label>
                                        <input id="textfield" name="balance" type="text" value="" readonly />
                                    </p>
                                    </div>
                                    </div>
                            </td>
						</tr>
				<tr>
                <td colspan="6" align="right">
                <span id="billpay">
                <input type="button" value="Clear" class="btn  btn-blue" onClick="clear_cart()" style="width:100px" />&nbsp;&nbsp;
                <!--<input type="button" value="Update" class="btn  btn-green" onClick="update_cart()" style="width:100px">&nbsp;&nbsp;-->
                <input type="submit" value="Submit" name="place-order" class="btn btn-green" onClick="return confirm('are you sure you wish to Submit this Details');" style="width:100px" />&nbsp;&nbsp;
                <input type="button" value="cancel" class="btn btn-red" onClick="cancel_cart()" style="width:100px" />
                </span>
                <span id="billupdate" style="display:none; float:right">
                <input type="button" value="Update" class="btn  btn-green" onClick="update_cart()" style="width:100px" />&nbsp;&nbsp;
                <input type="button" value="cancel" class="btn btn-red" onClick="cancel_cart()" style="width:100px" />
                </span>
                </td>
                </tr>
					</tbody>
                    <?php
            }
			else{
				echo '<tr bgColor="#FFFFFF"><td><center><h4>There are no Fees Details in your Invoice !!! OR Fully paid!!!</h4></center></td><td width="80px"><input type="button" value="cancel" class="btn  btn-red" onclick="cancel_cart()">';
			}
		?>
				</table>
				
				<hr>
			            </div>
			
            </form>
                </div>
		<?php } else { 
		unset($_SESSION['fees']);
		unset($_SESSION['frate']);
		?>
        <div class="field-group">
                            <form id="validate-form" class="block-content form" method="get" action="">
                            <div class="_25">
                            <p>
                            <label for="required">Student Roll No:</label>
                            <input type="text" name="roll" class="biginput" id="autocomplete" /> 
                            </p>
                            </div>
                            <div class="_25">
                            <p style="margin-top:25px;">
                            <input name="bid" value="<?php echo $bid;?>" type="hidden" />
                            <button type="submit" name="" class="btn btn-error">Submit</button>
                             </p>
                            </div>
                            </form>											
        </div> <!-- .field-group -->        
        <?php  } ?>
		
		
		
		
		<div id="main-content1">
			<div class="container_12">
			<?php
			$roll=$_GET['roll'];
			if($roll!="")
			{
					$classes=explode("-",$roll);  
					//print_r($classes);
					$rollno=$classes[0];  
					$studentname=$classes[1];  

					//die();
					
					$studentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$acyear"); 
								  $student1=mysql_fetch_array($studentlist);
								 // print_r($student1);die;
								  $sp_id=$student1['sp_id'];
								  $busfees_type=$student1['busfeestype'];
								  $bid=$_GET['bid'];
								  $ssid=$student1['ss_id'];
								  $busfees=mysql_query("SELECT * FROM trbusfees WHERE sp_id=$sp_id and ay_id='$acyear'"); 
								  $busfee=mysql_fetch_array($busfees);
								  //print_r($busfee);die;
								  if($busfees_type=='0')
								  {
								  $Due_amount=$busfee['fees'];
								  }
								  if($busfees_type=='1')
								  {
								  $Due_amount=$busfee['sp_fees'];
								  }
								  if($busfees_type=='2')
								  {
								  $Due_amount=$busfee['sp_fees_onetime'];
								  }
								  if($busfees_type=='3')
								  {
								  $Due_amount=$busfee['onetime'];
								  }
								//echo $Due_amount;die;
								  $qry=mysql_query("SELECT SUM(fi_total) FROM bfinvoice WHERE bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='0' AND ss_id='$ssid' ORDER BY bfi_id DESC");	 
							//echo "SELECT SUM(fi_total) FROM bfinvoice WHERE bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='0' AND ss_id='$ssid' ORDER BY bfi_id DESC";die;
							$value=mysql_fetch_array($qry);
							//print_r($value);die;
							$discount1=mysql_query("SELECT * FROM bfinvoice WHERE ay_id='$acyear' and ss_id='$ssid'");
							//print_r($value);die;
			  $discount=mysql_fetch_array($discount1);
			 // print_r($discount);die;
			   $f_from=$discount['ffrom'];
			   $f_to=$discount['fto'];
			  //while($rows=mysql_fetch_array($discount1)){
				  $x=0;
				  for($i=$f_from; $i<=$f_to ; $i++)
				  {
					  $x++;
					  $i;
				  }
				  //echo $count;die;
				  //$pendings=$discount['fi_total']/$x;
				  $pendings=$value[0]/$count;
				  $mon=12-$count;
				   //$pend=$pendings*$mon;
				 // $total=$pend+$value[0];
				  $total=$Due_amount;
				  $pend_amt=$Due_amount*$f_to;
				  $pend=$total-$value[0]; 
			?>
			
			<div class="grid_12">
				<h1>Monthly Fees Invoice List <?php echo "( ".$student1['admission_number']." - ".$student1['firstname']." ".$student1['lastname']." )";?></h1>
               <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/pill--minus.png"> 
				Total Pending : <strong>Rs. <?php echo number_format($pend,2); ?></strong> </span>  
                <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/medal-red.png"> Total Paid   : <strong>Rs. <?php echo number_format($value[0],2); ?></strong> </span>        
                <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-table.png"> Total Fees : <strong>Rs. <?php echo number_format($total,2); ?></strong> </span>
               			</div>
            <div class="grid_12">
				<div class="block-border" id="toggle2">
					<div class="block-header">
                    	<h1>Monthly Fees Invoice List <?php echo "( ".$student1['firstname']." ".$student1['lastname']." )";?></h1>
                        <span class="closed"></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>FR No</center></th>
                                    <!--<th>admin No</th>
                                    <th>Student Name</th>-->
                                    <th>Date</th>
                                    <th>Class-Section</th>
                                    <th>Route Name</th>
                                    <th>Stopping</th>
                                    <th>Inovice By</th>
                                    <th>Amount</th>
                                    <th>Inovice Detail</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM bfinvoice WHERE bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='0' AND ss_id='$ssid' ORDER BY bfi_id DESC");
							//echo "SELECT * FROM bfinvoice WHERE bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='0' AND ss_id='$ssid' ORDER BY bfi_id DESC";die;
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				$ssid=$row['ss_id'];
				$cid=$row['c_id'];
				$sid=$row['s_id'];
				$classlist=mysql_query("SELECT c_name FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $studentlist=mysql_query("SELECT admission_number FROM student WHERE ss_id=$ssid and user_status='1'"); 
								  $student=mysql_fetch_array($studentlist);
								  
								  $sectionlist=mysql_query("SELECT s_name FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
								  
								  $spid1=$row['sp_id'];
								  $qry6=mysql_query("SELECT r_id,stop_name FROM trstopping WHERE stop_id=$spid1"); 
								  $row6=mysql_fetch_array($qry6);
								  
								  $rid1=$row6['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid1"); 
								  $row5=mysql_fetch_array($qry5);
				?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['fr_no']; ?></center></td>
                                <!--<td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $row['fi_name']; ?></center></td>-->
                                <td><center><?php echo $row['fi_day']."/".$row['fi_month']."/".$row['fi_year']; ?></center></td>
                                <td><center><?php echo $class['c_name']."/".$section['s_name']; ?></center></td>
                                <td><center><?php echo $row5['r_name']; ?></center></td>
                                <td><center><?php echo $row6['stop_name']; ?></center></td>
                                <td><center><?php echo $row['bfi_by']; ?></center></td>
                                <td><center>Rs. <?php echo number_format($row['fi_total'],2); ?></center></td>
								<td class="view"><center><a href="bfeesinvoice_detail.php?bfiid=<?php echo $row['bfi_id'];?>&bid=<?php echo $bid;?>&stu_inv=1" title="Edit"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
            
            
            <?php 
			 $roll=$_GET['roll'];
			 $bis=$_GET['bid'];
					$classes=explode("-",$roll);  
					//print_r($classes);
					$rollno=$classes[0];  
					$studentname=$classes[1];  

					//die();
					
					$studentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$acyear"); 
				    $student=mysql_fetch_array($studentlist);
			  
								  $sp_id=$student['sp_id'];
								  $ssid=$student['ss_id'];
								  $busfees_type=$student['busfeestype'];
								  
								  //$busfees=mysql_query("SELECT * FROM busfees WHERE sp_id=$sp_id and ay_id='$acyear'"); 
								  $busfees=mysql_query("SELECT * FROM trbusfees WHERE sp_id=$sp_id and ay_id='$acyear'"); 
								  $busfee=mysql_fetch_array($busfees);
								  if($busfees_type=='0')
								  {
								  $Due_amount=$busfee['fees'];
								  }
								  if($busfees_type=='1')
								  {
								  $Due_amount=$busfee['sp_fees'];
								  }
								  if($busfees_type=='2')
								  {
								  $Due_amount=$busfee['sp_fees_onetime'];
								  }
								  if($busfees_type=='3')
								  {
								  $Due_amount=$busfee['onetime'];
								  } 
			  ?>
            <div class="grid_12">
				<div class="block-border" id="toggle1">
					<div class="block-header">
                    	<h1><?php echo "".$student['admission_number']." - ".$student['firstname']." ".$student['lastname']." - Fees Details";?></h1>
                        <span class="closed"></span>
					</div>
					<div class="block-content">
						<table id="table-example1" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Student Name</center></th>
                                    <th>Paid Amount</th>
                                    <th>Pending</th>
                                    <th>Total Amount</th>
                                    <!-- <th>Month</th>
                                   <th>Payment</th>-->
								</tr>
							</thead>
							<tbody>
                                 <?php 
								//echo 450*12;die;
						 	$qry=mysql_query("SELECT SUM(fi_total) FROM bfinvoice WHERE bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='0' AND ss_id='$ssid' ORDER BY bfi_id DESC");	 
							//echo "SELECT SUM(fi_total) FROM bfinvoice WHERE bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='0' AND ss_id='$ssid' ORDER BY bfi_id DESC";die;
							$value=mysql_fetch_array($qry);
							//print_r($value);die;
							$discount1=mysql_query("SELECT * FROM bfinvoice WHERE ay_id='$acyear' and ss_id='$ssid'");
							//print_r($value);die;
			  $discount=mysql_fetch_array($discount1);
			 // print_r($discount);die;
			   $f_from=$discount['ffrom'];
			   $f_to=$discount['fto'];
			  //while($rows=mysql_fetch_array($discount1)){
				  $x=0;
				  for($i=$f_from; $i<=$f_to ; $i++)
				  {
					  $x++;
					  $i;
				  }
				  //echo $count;die;
				  //$pendings=$discount['fi_total']/$x;
				  $pendings=$value[0]/$count;
				  $mon=12-$count;
				   //$pend=$pendings*$mon;
				 // $total=$pend+$value[0];
				  $total=$Due_amount;
				  $pend_amt=$Due_amount*$f_to;
				   $pend=$total-$value[0];  
				
				 
			?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo '1'; ?></center></td>
								<td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
								<td>Rs.<?php echo $value[0] ;?></td>
								<td>Rs.<?php echo round($pend);?></td>
								<td>Rs.<?php echo round($total);?></td>
								
								
								
								</tr> 
                               
                            <tr class="gradeX odd" role="row">
									<td class="sno center sorting_1"><center></center></td>
								<td><center><b></b></center></td>
                                    <td><b><?php //echo $totalamount; if($disamount){ echo " ( discount= -".$disamount." )"; }?></b></td>
                                    <td><b><?php //echo round($total);
									?></b></td>
                                    <td><b> </b></td>
                            								<!-- <td class="action"><b><?php if(round($total)==round($discount['fi_total'])){ echo "Fully Paid";}else{echo "Pending";}?></b></td>	-->							
			  </tr>    <?php //} ?>               																
							</tbody>
							<table id="table-example1" class="table block-border1">
							<tr>
							 
							  <?php 
									
									$paid="SELECT * FROM bfinvoice WHERE ss_id='$ssid' ORDER BY bfi_id DESC LIMIT 1";
									//echo $paid;die;
										$paid_student=mysql_query($paid);
										$val=mysql_fetch_assoc($paid_student);
										$too=$val['fto'];
										$frompaid="SELECT * FROM bfinvoice WHERE ss_id='$ssid' ORDER BY bfi_id ASC LIMIT 1";
									//echo $paid;die;
										$from_paid_student=mysql_query($frompaid);
										$from_val=mysql_fetch_assoc($from_paid_student);
										//print_r($val);die;
										$f_newarr=array();
										$f_newarr2=array();
										$fromval=$from_val['ffrom'];
										
										
									for($i=1;$i<=12;$i++){?>
                                    <th><?php echo $montharray[$i];?></th>
									<?php } ?>
							</tr>
							<tr>
							 
							 <?php
						// echo $too;die;
									$z= $total / 12 ;
									for($i=1;$i<=12;$i++) {
if($fromval<='1')
{
	
									if($i<=$too || $value[0]==$total) { echo '<td><a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a></td>'; } else { echo '<td><a original-title="NonePaid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/cross.png"/></a></td>'; } }
									else {
										if($i<$fromval){ echo '<td>-</td>'; } 
										 else if($fromval==$i) { echo '<td><a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a></td>'; }
										else{
											echo '<td><a original-title="NonePaid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/cross.png"/></a></td>';
										}
										
										
									}}?>
							</tr>
							</table>
						</table>
					</div>
				</div>
			</div>
            
<?php } ?>
		</div>
	</div> <!--! end of #main-content1 -->
        <div class="clear height-fix"></div>
        </div>
        </div>
        </div> <!--! end of #main-content -->
  </div> <!--! end of #main -->
    <?php include("includes/footer.php");
	?>
  </div> <!--! end of #container -->
  <!-- JavaScript at the bottom for fast page loading -->
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  
     <style>
.block-border1
{
background: url("img/misc/shine-effect.png") repeat-x scroll 0 0 rgba(33, 40, 44, 0.11);
    border: 1px solid #25333c;
    border-radius: 5px 5px 5px 5px;
    padding: 8px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
	margin-bottom:10px;
}
</style>
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>

  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <!--<script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>  jQuery UI -->
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
  <script defer src="js/zebra_datepicker.js"></script>
  
  
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php if(!$_GET['roll']){ include("auto1.php"); }?>
  <script language="javascript">
	function del(pid){
		if(confirm('Do you really mean to delete this item')){
			document.form1.pid.value=pid;
			document.form1.command.value='delete';
			document.form1.submit();
		}
	}
	function clear_cart(){
		if(confirm('This will empty your Billing, continue?')){
			document.form1.command.value='clear';
			document.form1.submit();
		}
	}
	function update_cart(){
		document.form1.command.value='update';
		document.form1.submit();
	}
	function cancel_cart(){
		if(confirm('This will cancel your Bill, continue?')){
			document.form1.command.value='cancel';
			document.form1.submit();
		}
	}
	function change_amountfrom() { 
      var ffromvalue = parseFloat(document.getElementById('ffrom').value);
	  var ffrom1value = parseFloat(document.getElementById('ffrom1').value);
	  var ftovalue = parseFloat(document.getElementById('fto').value);
	  if(ffromvalue==1){
		  var ftovalue = ftovalue+1;
	  }	
	   if(((ftovalue-1) < ffromvalue) || (ffromvalue < ffrom1value)) {
      		alert("Please Select valid months");
			location.reload();
			return true;			
					
   		}
	  fees = document.getElementById('fees');
	  var feesvalue =parseFloat(feesvalue = document.getElementById('feesvalue').value);
	  var ftyvalue = parseFloat(document.getElementById('ftyvalue').value);
	  var amount=parseFloat(((ftovalue-ffromvalue)/ftyvalue)*feesvalue);
	  fees.value = amount.toFixed(2);
}
	<?php 
	$max=count($_SESSION['fees']);
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['fees'][$i]['fgid']; ?>
	function change_amountfrom<?php echo $pid;?>() {
	  var ffromvalue = parseFloat(document.getElementById('bffrom<?php echo $pid;?>').value);
	  var ffrom1value = parseFloat(document.getElementById('ffrom_<?php echo $pid;?>').value);
	  var ftovalue = parseFloat(document.getElementById('bfto<?php echo $pid;?>').value);
	  /*if(ffromvalue==1){
		  var ftovalue = ftovalue+1;
	  }	  
	   if(((ftovalue-1) < ffromvalue) || (ffromvalue < ffrom1value) || (ffromvalue > ffrom1value)) {
      		alert("Please Select valid months");
			location.reload();
			return true;			
					
   		}*/
	  fees<?php echo $pid;?> = document.getElementById('fees<?php echo $pid;?>');
	  var feesvalue =parseFloat(feesvalue = document.getElementById('feesvalue<?php echo $pid;?>').value);
	  var tfeesvalue =parseFloat(feesvalue = document.getElementById('tfeesvalue<?php echo $pid;?>').value);
	  var ftyvalue = parseFloat(document.getElementById('ftyvalue<?php echo $pid;?>').value);
	  var amount=parseFloat(((ftovalue-(ffromvalue-1))/ftyvalue)*tfeesvalue);
	  //alert(ftovalue+"-"+ffromvalue+"/"+ftyvalue+"*"+tfeesvalue); 
	  fees<?php echo $pid;?>.value = amount.toFixed(2);
	  //update_cart();
}
<?php } ?>
function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'busfeesbilling.php?bid='+cid;	  
	} 
	$(".getamount").each(function() { 
            $(this).keyup(function(){
				var a = document.form1.get_amount.value;
				var total = <?php echo get_order_total()+$cheque;?>;
				var balance = (a-total);
				if(balance<0){
					balance=0;
				}
				document.form1.balance.value = balance;
            });
        });
	function paymet_type() {
			var x = document.getElementById("ptype").value;
			if(x != "cash"){
				$('#cash_pay').hide();
			}else{
				$('#cash_pay').show();
			}
			$.get("mpayment_type.php",{value:x},function(data){
			$( "#ajax_pay" ).html(data);
			});	
		}
</script>
<script type="text/javascript">
$(document).ready(function() {
	$(".txt").change(function() { 
	        $('#billupdate').show();
			$('#billpay').hide();
        });
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
	});
</script>
</body>
</html>
<? ob_flush(); ?>