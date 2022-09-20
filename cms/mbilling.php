<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("includes/mfunctions.php");
 //echo $_SESSION['uname'];
 //echo $acyear;
 
 $montharray=array("","June","July","August","September","October","November","December","January","February","March","April","May"); 
 
 if($_REQUEST['command']=='multidelete'){    
   foreach ($_POST['multivalue'] as $value) {
	   $vesplit=explode(",",$value);  
	    $vp=$vesplit[0];
		$vx=$vesplit[1];
    remove_product($vp,$vx);    
   }
}

 if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){
		remove_product($_REQUEST['pid'],$_REQUEST['x']);
	}else if($_REQUEST['command']=='clear'){
		unset($_SESSION['fees']);
	}
	else if($_REQUEST['command']=='cancel'){
		unset($_SESSION['fees']);
		$bid=$_REQUEST['bid'];
		header("location:mbilling.php?bid=$bid");
	}
	else if($_REQUEST['command']=='update'){
		$max=count($_SESSION['fees']);
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['fees'][$i]['fgid'];
			$xftype=$_SESSION['fees'][$i]['ftype'];
			if($xftype=="fees"){
			 $q1=intval($_REQUEST['bffrom'.$pid]);
			 $r1=intval($_REQUEST['bfto'.$pid]);
			 $s1=$_REQUEST['fees'.$pid];
			//die();
			if(!empty($q1) && !empty($r1) && !empty($s1)){
				$_SESSION['fees'][$i]['ffrom']=$q1;
				$_SESSION['fees'][$i]['fto']=$r1;
				$_SESSION['fees'][$i]['amount']=$s1;
			}
			else{
				$msg='Some category fees not updated!,please select valid Month!!!';
			}
			}
		}
	}
	
 if (isset($_POST['add-fees']))
{
	//die();
		$fr_split= explode(',',$_POST['fgroup']);
		$fgroup=$fr_split[0];
		$ftype=$fr_split[1];

		$ftyvalue=$_POST['ftyvalue'];
		$fgrouplist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$fgroup");
				$ffgroup1=mysql_fetch_assoc($fgrouplist1);
	  $fgrid=$ffgroup1['fg_id'];
	  $fgdrid=$ffgroup1['fgd_id'];							 	  
	  $ffrom=$_POST['ffrom'];
	  $fto=$_POST['fto'];
	  $fees=$_POST['fees'];
	  $ftomonth=$_POST['ftomonth'];
	  if($ftype=="other"){
		  $ffrom=1;
	  $fto=12;
	  $fgrid=$fgdrid;
	  }
	  if($ftype=="other1"){
		  $ffrom=1;
	  $fto=12;
	  $fgrouplist1=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$fgroup");
									 $ffgroup1=mysql_fetch_assoc($fgrouplist1);
	  $fgrid=$ffgroup1['fgd_id'];
	  $ftype="other";
	  }
	  $feesvalue=$_POST['feesvalue'];
	  //$feestype=$_POST['feestype'];
	 if($fgroup){
		addtocart($fgrid,$ffrom,$fto,$fees,$fgroup,$ftyvalue,$fees,$feesvalue,$ftype,$ftomonth);
	 }
	 unset($_SESSION['frate']);
	 
}
//echo $max=count($_SESSION['fees']);
//if(is_array($_SESSION['fees'])){
//echo $_SESSION['fees'][0]['fgid'];
//}
//echo get_product_name(1);
//unset($_SESSION['fees']);
if (isset($_POST['place-order']))
{
	   $frno=$_POST['frno'];
	   $ptype=$_POST['ptype'];
	   $ssid1=$_POST['ssid1'];
	   $ss_name=$_POST['ss_name'];
	   $cid1=$_POST['cid1'];
	   $sid1=$_POST['sid1'];
	   $idate=$_POST['idate'];
	   $idatesplit=explode("/",$idate);  
	    $day=$idatesplit[0]; 
	    $month=$idatesplit[1];
	    $year=$idatesplit[2];
	  
	  //$seid=$_POST['se_id'];
	   $total=$_POST['total'];
	   $category=$_POST['category'];
	   $stype=$_POST['stype'];
	   $bid1=$_POST['bid1'];	
	   
	   $pay_number=$_POST['pay_number'];
	   
	   $bank_name=$_POST['bank_name'];
	   $cheque_date=$_POST['cheque_date'];
	   
	   $get_amount=$_POST['get_amount'];
	   $balance=$_POST['balance'];
	   	  
	   $poor_pay_amount=$_POST['poor_pay_amount'];
	   $fund_amount=$_POST['funds'];
	   
	   if($poor_pay_amount || $fund_amount){
		   $fund = "1";
	   }  
	   
	   $qry31=mysql_query("SELECT * FROM mfinvoice_no WHERE id='1'"); 
								  $row31=mysql_fetch_assoc($qry31);
								  $invoice_no=$row31['count'];
								  
	  $sql="INSERT INTO mfinvoice (fr_no,fi_name,fi_total,fi_ptype,fi_day,fi_month,fi_year,ss_id,c_id,s_id,category,stype,fi_by,bid,ay_id,pay_number,get_amount,balance,poor_student_pay,fund_amount,funds,fi_by_name,bank_name,cheque_date) VALUES
('$invoice_no','$ss_name','$total','$ptype','$day','$month','$year','$ssid1','$cid1','$sid1','$category','$stype','$user','$bid1','$acyear','$pay_number','$get_amount','$balance','$poor_pay_amount','$fund_amount','$fund','$user','$bank_name','$cheque_date')";
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=$id = mysql_insert_id();
    if($result){
		/*$invoicelist=mysql_query("SELECT * FROM invoice WHERE i_id='$lastid'"); 
								  $invoice=mysql_fetch_assoc($invoicelist);
								  $i_id=$invoice['i_id'];								  
								  $inovoice=$in_no+1;*/
								  
								  $inovoice=$invoice_no+1;
					$qry1=mysql_query("UPDATE mfinvoice_no SET count='$inovoice' WHERE id='1'");
								  
		$max=count($_SESSION['fees']);
				for($i=0;$i<$max;$i++){
					 $pid=$_SESSION['fees'][$i]['fgid'];
					 $q=$_SESSION['fees'][$i]['ffrom'];
					 $s=$_SESSION['fees'][$i]['fto'];
					 $r=$_SESSION['fees'][$i]['amount'];
					 $t=$_SESSION['fees'][$i]['ftid'];
					 $x=$_SESSION['fees'][$i]['ftype'];
					 $pname=get_product_name($pid,$x);
					 if($x=="fees"){
						 $fgid=$pid;
						 $fgdid=0;
					 }else if($x=="other"){
						 $fgid=0;
						 $fgdid=$pid;
					 }else if($x=="discount"){
						 $fgid=0;
						 $fgdid=0;
					 }
					if($q==0) continue;					
					 //$price=get_price($pid);
					 //$btotal=number_format((get_price($pid)*$q),2);
					 //echo "<br>";
					
					$sql1="INSERT INTO mfsalessumarry (fi_id,fg_id,fgd_id,fty_id,fg_name,ffrom,fto,amount,bid,ay_id,ftype) VALUES
('$lastid','$fgid','$fgdid','$t','$pname','$q','$s','$r','$bid1','$acyear','$x')";
					$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
					
					$booklist=mysql_query("SELECT * FROM book WHERE b_id='$pid'"); 
								  $book=mysql_fetch_assoc($booklist);
								  $type=$book['type'];
							 	  $nid=$book['n_id'];
				}
				unset($_SESSION['fees']);
				unset($_SESSION['frate']);
				header("location:mfinvoice.php?fiid=$lastid&bid=$bid1");
    }
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
                <li class="no-hover"><a href="mboard_select_fees.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Fees Paymant</li> 
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
				<h1><a href="mboard_select_fees.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>  Invoice</h1>
                <?php if($_GET['roll']){					
					$roll=$_GET['roll'];
					$classes=explode("-",$roll);  
					//print_r($classes);
					$rollno=$classes[0];  
					$studentname=$classes[1]; 
					//die();
					$studentlist=mysql_query("SELECT * FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$acyear"); 
								  $student=mysql_fetch_assoc($studentlist);
								  $ssid=$student['ss_id'];
								  $ss_gender=$student['gender'];
								  $cid=$student['c_id'];
								  $sid=$student['s_id'];
								  $s_type=$student['stype'];
								  $mlate_join=$student['mlate_join'];
								  $fdisid1=$student['fdis_id'];
								  
								  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class1=mysql_fetch_assoc($classlist1);
								  
								  $mpdid=$student['mpd_id'];
								  $discount=0;
								  if($mpdid){
									  $paytypelist=mysql_query("SELECT value,discount FROM mpaydiscount WHERE mpd_id=$mpdid"); 
								  	  $mpaydiscount=mysql_fetch_assoc($paytypelist);
									  $dismonth=$mpaydiscount['value'];
									  $disamount=$mpaydiscount['discount'];	
								  }
								  
								   if(($class1['c_name']=="XI STD") || ($class1['c_name']=="XII STD") || ($class1['c_name']=="XI") || ($class1['c_name']=="XII")){
									 $sid21 = $sid;
								  }else {
									  $sid21 = "0";
								  }	
								  
				$max=count($_SESSION['fees']);
			if(empty($_SESSION['fees'])){
				//echo "test"; 		die();		
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
									
									$lclasslist1=mysql_query("SELECT * FROM class WHERE c_id=$lcid"); 
								    $lclass1=mysql_fetch_assoc($lclasslist1);
									
									if(($lclass1['c_name']=="XI STD") || ($lclass1['c_name']=="XII STD") || ($lclass1['c_name']=="XI") || ($lclass1['c_name']=="XII")){
									 $lsid21 = $lsid;
								  }else {
									  $lsid21 = "0";
								  }
						
								  
				$sql1=mysql_query("SELECT * FROM mfrate WHERE c_id=$lcid AND b_id=$bid AND ay_id=$lacyear AND rate='$ls_type' AND s_id=$lsid21 ORDER BY fgd_id");
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
									
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_assoc($ftypelist);
														$ftypevalue=$ftype['fty_value'];													
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
								$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$lfdisid1"); 
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
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $lacyear. "' AND c_id = '" . $lcid. "' AND ss_id = '" . $lssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							$fratelist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid");
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
								$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
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
						
						//echo $rmonth;
						
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
				}/************************ School Fees end*********************************/
				
				if($ffgdid){ /************************ Other Fees start*********************************/									
									
									
									$fgrouplist=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$ffgdid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);
									
									/*$ftyid=$ffgroup['fty_id'];
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_assoc($ftypelist);*/
														$ftypevalue=12;
														
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
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
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $lacyear. "' AND c_id = '" . $lcid. "' AND ss_id = '" . $lssid. "' AND c_status!='1' AND i_status='0'";
							
							//echo $qry1;
							$qry3=mysql_query($qry3);							
							
							$fratelist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_assoc($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							$f_to12="";	
						  while($row3=mysql_fetch_assoc($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
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
						/*if($fratefrom==$frateto1){
							echo '<script language="javascript">';
							echo 'alert("This Category Fees Fully Paid")';
							echo '</script>';
						}*/
						//ftovalue-ffromvalue)/ftyvalue)*feesvalue;
						
						$frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;							
					}else {
							$frateto12=$frateto2;
							$frateamount12=$frateamount2;							
						}
						 $fratefrom2;
						 $frateto12;
						  $frateamount12;
						if($frateamount12>0){
							//addtocart($ffgdid,$fratefrom2,$frateto12,$frateamount12,$frid,$ftypevalue,$frateamount12,$frateamount2,"other","");
							$totalpending +=$frateamount12;
						 }
				}/************************ Other Fees end*********************************/
			}
				/****************************************** Pending Amount End **********************************/
					}
				//echo $totalpending;
				//die();
				$ptypepay=0;
				$qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							 while($row3=mysql_fetch_assoc($qry3))
							{
							$fiid1=$row3['fi_id'];
							$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1"); 
								 while($fsummay=mysql_fetch_assoc($fsummaylist)){
									 if($fsummay['ftype']=="pending"){
									 $ptypepay=1;
									 }
								 }
							}
				
				if($totalpending>0 && $ptypepay==0){
					
					
						addtocart("2","2","2",$totalpending,"2","2","2","2","pending","");			
						}
						
						
						$sql1=mysql_query("SELECT * FROM mfrate WHERE c_id=$cid AND b_id=$bid AND ay_id=$acyear AND rate='$s_type' AND s_id=$sid21 ORDER BY fgd_id");
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
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_assoc($ftypelist);
														$ftypevalue=$ftype['fty_value'];													
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
								$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
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
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							$fratelist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid");
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
								$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
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
						/*if($fratefrom==$frateto1){
							echo '<script language="javascript">';
							echo 'alert("This Category Fees Fully Paid")';
							echo '</script>';
						}*/
						//ftovalue-ffromvalue)/ftyvalue)*feesvalue;
						//echo '(('.$frateto12.'-('.$fratefrom2.'-1))/'.$frateto2.')*'.$frateamount2.'*'.$frateto2;
						//die();
						if($ftypevalue==1 && $mpdid){
								 $frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2*$frateto2;
							 }else{
								 $frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;
							 }
													
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
						}
						
						if($frateto12==$tomonth && ($ftypevalue==1 && $mpdid)){
							$discount=1;
						}
						
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						if($frateamount12>0){
							addtocart($ffgid,$fratefrom2,$frateto12,$frateamount12,$frid,$ftypevalue,$frateamount12,$frateamount2,"fees",$tomonth);
						 }
				}/************************ School Fees end*********************************/
				
				if($ffgdid){ /************************ Other Fees start*********************************/									
									
									
									$fgrouplist=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$ffgdid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);
									
									/*$ftyid=$ffgroup['fty_id'];
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_assoc($ftypelist);*/
														$ftypevalue=12;
														
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
								$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
																  $class=mysql_fetch_assoc($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgdid;
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
							
							//echo $qry1;
							$qry3=mysql_query($qry3);							
							
							$fratelist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_assoc($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							$f_to12="";	
						  while($row3=mysql_fetch_assoc($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
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
						/*if($fratefrom==$frateto1){
							echo '<script language="javascript">';
							echo 'alert("This Category Fees Fully Paid")';
							echo '</script>';
						}*/
						//ftovalue-ffromvalue)/ftyvalue)*feesvalue;
						
						$frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;							
					}else {
							$frateto12=$frateto2;
							$frateamount12=$frateamount2;							
						}
						 $fratefrom2;
						 $frateto12;
						  $frateamount12;
						if($frateamount12>0){
							addtocart($ffgdid,$fratefrom2,$frateto12,$frateamount12,$frid,$ftypevalue,$frateamount12,$frateamount2,"other","");
						 }
				}/************************ Other Fees end*********************************/
										
									}
									
									$dscountpay=0;
				$qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							 while($row3=mysql_fetch_assoc($qry3))
							{
							$fiid1=$row3['fi_id'];
							$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1"); 
								 while($fsummay=mysql_fetch_assoc($fsummaylist)){
									 if($fsummay['ftype']=="discount"){
									 $dscountpay=1;
									 }
								 }
							}
							
						if($discount==1 && $dscountpay==0){
						addtocart("2","2","2",$disamount,"2","2","2","2","discount","");			
						}
				}
								  if(!$student){
			header("location:mbilling.php?bid=$bid");
		}
							?>
				         <div class="block-border">
					<div class="block-header">
						<h1>Add New Fees</h1><span></span>
					</div>
                    
				<form id="validate-form" class="block-content form" method="post" action="">
                    <div class="_25">
							<p>
                                    <label for="required">Fees Group Name:</label>
                                     <select name="fgroup" id="fgroup" class="required"  >
                                	<option value="">Select Fees Type</option>
                                    <?php 
									$sql1=mysql_query("SELECT * FROM mfrate WHERE c_id=$cid AND b_id=$bid AND ay_id=$acyear AND rate='$s_type' AND s_id=$sid21 ORDER BY fgd_id");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$ffgid=$row2['fg_id'];
									$ffgdid=$row2['fgd_id'];
									$frid=$row2['fr_id'];
									if($ffgid){
									$fgrouplist=mysql_query("SELECT * FROM mfgroup WHERE fg_id=$ffgid");
									 $ffgroup=mysql_fetch_assoc($fgrouplist);
										?>
                                     <option value="<?php echo $frid.",fees";?>"><?php echo $ffgroup['fg_name'];?></option>
                                     <?php }if($ffgdid){
										 $fgrouplist=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$ffgdid");
									 $ffgroup=mysql_fetch_assoc($fgrouplist);
										?>
                                     <option value="<?php echo $frid.",other";?>"><?php echo $ffgroup['name'];?></option>
                                     <?php } }
									 $sql1=mysql_query("SELECT * FROM mfgroup_detail WHERE otherfees='1' ORDER BY fgd_id");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$mfgdid=$row2['fgd_id'];?>
                                    <option value="<?php echo $mfgdid.",other1";?>"><?php echo $row2['name'];?></option>
                                    <?php } ?>
                                    </select>	
                                    <input type="hidden" id="fdisid" value="<?php echo $fdisid1;?>" />
                             <input type="hidden" id="ssid" value="<?php echo $ssid;?>" />									
								</p>
						</div>
                        <div id="test">
                        </div>                        
                        <div class="clear"></div>                          
                        <?php if($fratefrom==$frateto1 && !empty($frateid)){?>
                        <tr>
                        <td colspan="5" style="color:#FF0004;font-size:13px;">
                        <center>This Category Fees Fully Paid</center>
                        </td>
                        </tr>
                        <?php } ?>
                        </table>
                        </form>
				</div><br>
                <form name="form1" method="post" action="" id="validate-form" class="block-content-invoice form">
<input type="hidden" name="pid" />
<input type="hidden" name="x" />
<input type="hidden" name="bid" value="<?php echo $bid;?>" />
<input type="hidden" name="command" />
                <?php 
				//$ssid=$_GET['ss_id'];
					$studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student1=mysql_fetch_assoc($studentlist1);
								  $cid1=$student1['c_id'];
								  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $row=mysql_fetch_assoc($qry);
								  
								  $sid1=$student1['s_id'];
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_assoc($qry1);
								  
								  $qry3=mysql_query("SELECT * FROM mfinvoice_no WHERE id='1'"); 
								  $row3=mysql_fetch_assoc($qry3);
								  $invoice_no=$row3['count'];
								  
								  $fdisid=$student1['fdis_id'];
								  $qry4=mysql_query("SELECT * FROM fdiscount WHERE fdis_id='$fdisid'"); 
								  $row4=mysql_fetch_assoc($qry4);
								  $fdisname=$row4['fdis_name'];
								  ?>
						
						<div id="invoice" class="widget widget-plain">				
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
					<li>Category: <?php echo $fdisname;?> <input type="hidden" class="medium" name="category" value="<?php echo $fdisname;?>"/></li>
                    <li>Student Type : <b><?php echo $student1['stype'];?></b> Student <input type="hidden" class="medium" name="stype" value="<?php echo $student1['stype'];?>"/></li>										
				</ul>
				<ul class="client_details">
					<li>Status: <span class="ticket ticket-info">Open</span></li>
					<li><strong>Date :</strong> <input id="datepicker" name="idate" type="text" value="<?php echo date("d/m/Y");?>"  style="width:60%"/>
				</ul>				
				<table class="table table-striped" id="table-example">	
                <?php
				$max=count($_SESSION['fees']);
			if(is_array($_SESSION['fees']) && $max>0){ ?>				
					<thead>
						<tr>
                        	<th width="5"><span id="multi_delete" hidden="true"><img src="img/del.png" onClick="multidelete()"  name="multi_delete" alt="delete"></span></th>
							<th>S.No</th>
							<th>Fees Group Name</th>
							<th>Fees From</th>
							<th>Fees To</th>
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
					$x=$_SESSION['fees'][$i]['ftype'];
					$y=$_SESSION['fees'][$i]['ftomonth'];
					$pname=get_product_name($pid,$x);
					if($x=="fees"){ /**********************school Fees start ****************************/
					 ?>
						<tr>
                        	<td id="multi_id"><center><input type="checkbox" name="multivalue[]" onClick="multi_check()" value="<?=$pid.",".$x?>"></center></td>
							<td><?php echo $count;?></td>			
							<td><?php echo $pname;?></td>
							<td><?php //echo $montharray[$q-1];?>
                                    <select name="bffrom<?php echo $pid;?>" id="bffrom<?php echo $pid;?>" class="required" onchange="change_amountfrom<?php echo $pid;?>()" >
                                    <?php
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
				if($q==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected" ><?php echo  $montharray[$cmonth]?></option>
            <?php } }?>	
                                    </select>										
							   </td>
							<td><?php //echo $montharray[$r-1];?>
                                    <select name="bfto<?php echo $pid;?>" id="bfto<?php echo $pid;?>" class="txt" onchange="change_amountfrom<?php echo $pid;?>()" >
                                	<?php
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
				if($y>=$cmonth){
				if($q<=$cmonth){
				if($r==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected"><?php echo  $montharray[$cmonth]?></option>
            <?php } else if(!$r && 12==$cmonth) { ?>
                                     <option value="<?php echo $cmonth;?>" selected="selected"><?php echo $montharray[$cmonth];?></option>
                                     <?php }else { ?>				
            <option value="<?php echo $cmonth;?>" style="background-color:#D6EDF8" ><?php echo  $montharray[$cmonth]?></option>            
            <?php }  } } } ?>	
                                    </select>										
							</td>
							<td class="total" width="120"><?php $samount=number_format($s,2);?></span>
                                   <input type="text" name="fees<?php echo $pid;?>" id="fees<?php echo $pid;?>" class="biginput" id="autocomplete" class="required" value="<?php echo $s;?>"  readonly/>									
							  </td>
                            <td><a href="javascript:del(<?php echo $pid.",'".$x."'";?>)"><img src="img/del.png" alt="delete"></a></td>
                             <input type="hidden" id="ffrom_<?php echo $pid;?>" value="<?php echo $q;?>" />
                             <input type="hidden" id="ftyvalue<?php echo $pid;?>" value="<?php echo $u;?>" />
                             <input type="hidden" id="feesvalue<?php echo $pid;?>" value="<?php echo $v;?>" />
                             <input type="hidden" id="tfeesvalue<?php echo $pid;?>" value="<?php echo $w;?>" />
                             <input type="hidden" id="tfeesvalue<?php echo $pid;?>" value="<?php echo $x;?>" />
                            </tr>
                            <?php } /***************************School Fees End ******************************/
							
							else if($x=="other"){  /***************************Other Fees End ******************************/
							?>
							<tr>
                            <td id="multi_id"><center><input type="checkbox" name="multivalue[]" onClick="multi_check()" value="<?=$pid.",".$x?>"></center></td>
							<td><?php echo $count;?></td>			
							<td><?php echo $pname;?></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td class="total" width="120"><?php $samount=number_format($s,2);?></span>
                                   <input type="text" id="" class="biginput" id="autocomplete" class="required" value="<?php echo $s;?>"  readonly/>									
							  </td>
                            <td><a href="javascript:del(<?php echo $pid.",'".$x."'";?>)"><img src="Book_inventory/images/del.png" alt="delete"></a></td>
                            </tr>
							<?php } else if($x=="discount"){  /***************************Other Fees End ******************************/
							?>
							<tr>
                            <td id="multi_id"><center><input type="checkbox" name="multivalue[]" onClick="multi_check()" value="<?=$pid.",".$x?>"></center></td>
							<td><?php echo $count;?></td>			
							<td><b><?php echo $pname;?></b></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td class="total" width="120"><?php $samount=number_format($s,2);?>
                                   <input type="text" id="" class="biginput" style="font-weight:bold" id="autocomplete" class="required" value="<?php echo "- ".$s;?>"  readonly/>							
							  </td>
                            <td><a href="javascript:del(<?php echo $pid.",'".$x."'";?>)"><img src="Book_inventory/images/del.png" alt="delete"></a></td>
                            </tr>
							<?php } else if($x=="pending"){  /***************************Other Fees End ******************************/
							?>
							<tr>
                            <td id="multi_id"><center><input type="checkbox" name="multivalue[]" onClick="multi_check()" value="<?=$pid.",".$x?>"></center></td>
							<td><?php echo $count;?></td>			
							<td><b><?php echo $pname;?></b></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td class="total" width="120"><?php $samount=number_format($s,2);?>
                                   <input type="text" id="" class="biginput" style="font-weight:bold" id="autocomplete" class="required" value="<?php echo $s;?>"  readonly/>							
							  </td>
                            <td><a href="javascript:del(<?php echo $pid.",'".$x."'";?>)"><img src="Book_inventory/images/del.png" alt="delete"></a></td>
                            </tr>
							<?php }?>
						<?php $count++;} ?>
						<tr>
                        	<td class="sub_total" colspan="4"></td>
							<td class="sub_total">Subtotal:</td>
							<td class="sub_total">Rs. <?php echo number_format(get_order_total(),2);?></td>
                            <td></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="4"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs. <?php echo number_format(get_order_total(),2);?><input type="hidden" class="medium" name="total" value="<?php echo get_order_total();?>"/></td>
                            <td></td>
						</tr>
                        <tr>
							<td colspan="8" align="right">	
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
                                        <input id="textfield" name="get_amount" id="get_amount" class="getamount" type="text" value="" />
                                    </p>
                                    </div>
                                    <div class="_25">
                                    <p>
                                        <label for="textfield">Given Balance</label>
                                        <input id="textfield" name="balance" id="balanace" type="text" value="" readonly/>
                                    </p>
                                    </div>
                                    </div>
                            </td>
						</tr>
                        <?php if($_SESSION['admin_type']=="0"){?>
                        <tr>
							<td colspan="7" align="right">
                        <div class="_25">
							<p>
								<span class="label">Student Discount</span>
								<label><input type="checkbox" name="poor" id="poor" /> If to give Discount</label>
							</p>
						</div>
                        <div id="poor_student" style="display:none">
                        			<div class="_25">
                                    <p>
                                        <label for="textfield">Discount from school</label>
                                        <input id="textfield" name="funds" id="funds" type="text" value="" class="fundcal" autocomplete="off"/>
                                    </p>
                                    </div>
                                    <div class="_25">
                                    <p>
                                        <label for="textfield">Fee Payment</label>
                                        <input id="textfield" name="poor_pay_amount" id="poor_pay_amount"  type="text" value="" readonly  />
                                    </p>
                                    </div>
                                    </div>
                        </td>
                        </tr>
                        <?php } ?>
				<tr>
                <td colspan="8" align="right">
                 <span id="billpay">
                <input type="button" value="Clear" class="btn  btn-blue" onClick="clear_cart()" style="width:100px">&nbsp;&nbsp;
                <input type="submit" value="Submit" name="place-order" class="btn btn-green" onClick="return confirm('are you sure you wish to Submit this Details');" style="width:100px">&nbsp;&nbsp;
                <input type="button" value="cancel" class="btn btn-red" onClick="cancel_cart()" style="width:100px">
                </span>
                <span id="billupdate" style="display:none; float:right">
                <input type="button" value="Update" class="btn  btn-green" onClick="update_cart()" style="width:100px">&nbsp;&nbsp;
                <input type="button" value="cancel" class="btn btn-red" onClick="cancel_cart()" style="width:100px">
                </span>
                </td>
                </tr>
					</tbody>
                    <?php
            }
			else{
				echo '<tr bgColor="#FFFFFF"><td><center><h4>There are no Fees Details in your Invoice !!!</h4></center></td><td width="80px"><input type="button" value="cancel" class="btn  btn-red" onclick="cancel_cart()">';
			}
		?>
				</table>
				
				<hr>
			</div>
            </form>
            <hr>
            <?php 
					/******************************* Display Student Fees Details **************************************************************/
			
			$tot=0;
								$totalamount=0;
								      $tquery=mysql_query("SELECT * FROM mfrate WHERE c_id=$cid AND b_id=$bid AND ay_id=$acyear AND rate='$s_type' AND s_id=$sid21 ORDER BY fgd_id");
								      while($row2=mysql_fetch_assoc($tquery)){
										  
										   
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
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_assoc($ftypelist);
														$ftypevalue=$ftype['fty_value'];													
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
								$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
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
					 $f_to12=0;
					 					if(!empty($frid)) { 
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							$fratelist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid");
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
								$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_assoc($fsummaylist)){
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
						
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						 if($rmonth){
							$frateamount12=$frateamount12*($rmonth+1);
						}
						if($frateamount12>0){
							$tot +=$frateamount12;
						 }
				}/************************ School Fees end*********************************/
				
				if($ffgdid){ /************************ Other Fees start*********************************/									
									
									
									$fgrouplist=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$ffgdid");
									$ffgroup=mysql_fetch_assoc($fgrouplist);
														$ftypevalue=12;
								$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
																  $class=mysql_fetch_assoc($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgdid;
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
							
							//echo $qry1;
							$qry3=mysql_query($qry3);							
							
							$fratelist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_assoc($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							$f_to12="";	
						  while($row3=mysql_fetch_assoc($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
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
							$tot +=$frateamount12;
						 }
						 $totalamount +=$frateamount2;
				}/************************ Other Fees end*********************************/
									}
									
								//echo $tot;
								  function paid_amount($b,$c,$s,$acyear,$ssid)
								  {
								      $fi=array();
								      $tquery2=mysql_query("select fi_id from mfinvoice  where ss_id='$ssid' and c_id='$c' and bid='$b' and  ay_id='$acyear' AND c_status!='1' AND i_status='0'");
								      while($trow2=mysql_fetch_assoc($tquery2)){
								          $fi_id=$trow2["fi_id"];
								  
								          array_push($fi,$fi_id);
								      }
								      	
								      $fis=implode(",",$fi);
								  
								  
								      $ptotal=0;
								      $tquery1=mysql_query("select * from fsalessumarry  where  fi_id IN ($fis) and fr_id!='0'  ");
								      $d=0;
								      while($trow1=mysql_fetch_assoc($tquery1)){
								          $d=$d+1;
								          $ptotal=$trow1['amount']+$ptotal;
								           
								      }
								      //  echo $d."-".$ptotal."<br>";
								      return $ptotal;
								      	
								  }
								  	
		?>
    	<?php 
		$qry1=mysql_query("SELECT * FROM mfinvoice WHERE bid=$bid AND ss_id='$ssid' AND ay_id=$acyear AND c_status!='1' AND i_status='0'");
							$total=0;
			  while($row1=mysql_fetch_assoc($qry1))
        		{
					$tamount=$row1['fi_total'];
					$total +=$tamount;		

					$fdis=$student['fdis_id'];
					$stype=$student['stype'];
					
					if($stype=="Old")
					{
					    $ftype="0";
					}else{
					    $ftype="0,1";
					}
					$paid=paid_amount($bid,$cid,$sid,$acyear,$ss_id);
				}
				?>
		<!-- Begin of #main-content -->
		<div id="main-content1">
			<div class="container_12">
			<div class="grid_12">
				<h1>Monthly Fees Invoice List <?php echo "( ".$student1['admission_number']." - ".$student1['firstname']." ".$student1['lastname']." )";?></h1>
                <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/pill--minus.png"> Total Pending : <strong>Rs. <?php echo number_format($tot,2); ?></strong> </span>  
                <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/medal-red.png"> Total Paid   : <strong>Rs. <?php echo number_format($total,2); ?></strong> </span>        
                <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-table.png"> Total Fees : <strong>Rs. <?php echo number_format($totalamount,2); ?></strong> </span>
               			</div>
            <div class="grid_12">
				<div class="block-border" id="toggle2">
					<div class="block-header">
                    	<h1>Monthly Fees Invoice List <?php echo "( ".$student['firstname']." ".$student['lastname']." )";?></h1>
                        <span class="closed"></span>
					</div>
					<div class="block-content">
						<table id="table-example2" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>FR No</center></th>
                                    <th>Date</th>
                                    <th>Class-Section</th>
                                    <th>Student Category</th>
                                    <th>Student type</th>
                                    <th>Inovice By</th>
                                    <th>Amount</th>
                                    <th>Invoice Detail</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM mfinvoice WHERE bid=$bid AND ss_id='$ssid' AND ay_id=$acyear AND c_status!='1' AND i_status='0' ORDER BY fi_id DESC");
							$count=1;
			  while($row=mysql_fetch_assoc($qry))
        		{ 
				$cid1=$row['c_id'];
				$sid1=$row['s_id'];
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $class=mysql_fetch_assoc($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $section=mysql_fetch_assoc($sectionlist);	  
				?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['fr_no']; ?></center></td>
                                <td><center><?php echo $row['fi_day']."/".$row['fi_month']."/".$row['fi_year']; ?></center></td>
                                <td><center><?php echo $class['c_name']."/".$section['s_name']; ?></center></td>
                                <td><center><?php echo $row['category']; ?></center></td>
                                <td><center><?php echo $row['stype']; ?></center></td>
                                <td><center><?php echo $row['fi_by']; ?></center></td>
                                <td width="120">Rs. <?php echo number_format($row['fi_total'],2); ?></td>
								<td class="view"><center><a href="mfeesinvoice_detail.php?fiid=<?php echo $row['fi_id'];?>&bid=<?php echo $bid;?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
					</div>
				</div>
			</div>
            
            
            <?php 
			$discount1=mysql_query("SELECT * FROM fdiscount WHERE fdis_id=$fdisid1");							
			  $discount=mysql_fetch_assoc($discount1);
			  ?>
            <div class="grid_12">
				<div class="block-border" id="toggle1">
					<div class="block-header">
                    	<h1><?php echo "".$student1['admission_number']." - ".$student['firstname']." ".$student['lastname']." - Fees Details";?></h1>
                        <span class="closed"></span>
					</div>
					<div class="block-content">
						<table id="table-example1" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Group Name</center></th>
                                    <th>Fees</th>
                                    <th>Paid</th>
                                    <th>Pending</th>
                                    <th>Payment</th>
								</tr>
							</thead>
							<tbody>
                                   <?php
							$qry=mysql_query("SELECT * FROM mfrate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid21 AND rate='$s_type'");
							$count=1;
			  while($row=mysql_fetch_assoc($qry))
        		{ 
				$frid=$row['fr_id'];
				$fgid2=$row['fg_id'];
				$fgdid=$row['fgd_id'];
				if($fgid2){
				$fgrouplist=mysql_query("SELECT * FROM mfgroup WHERE fg_id=$fgid2");
								  $fgroup=mysql_fetch_assoc($fgrouplist);
								  $fgroupname=$fgroup['fg_name'];
								  $ftyid=$fgroup['fty_id'];
												  $fto=$fgroup['end'];
												  if($fto==0){
													  $fto=12;
												  }	
						   $ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
										  $ftype=mysql_fetch_assoc($ftypelist);
								$ftypevalue=$ftype['fty_value'];
				}else if($fgdid){
					$fgrouplist=mysql_query("SELECT * FROM mfgroup_detail WHERE fg_id=$fgid2");
								  $fgroup=mysql_fetch_assoc($fgrouplist);
								  $fgroupname=$fgroup['name'];
								  $ftypevalue=12;
				}
				?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $fgroupname; ?></center></td>
                                <?php 							
				//$fdisid2=$row1['fdis_id'];
				$frvaluelist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid1 AND ay_id=$acyear"); 
								  $frvalue=mysql_fetch_assoc($frvaluelist);	
								  if($frvalue){
									  if($ftypevalue==1){
								  $total1 =$frvalue['dis_value']*$fto;
									  }else{
								  $total1 =$frvalue['dis_value'];
									  }
								  }
								  $amount=0;
								  if(!empty($frid)) { 
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
							
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
								$fsummaylist=mysql_query("SELECT amount,fto FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_assoc($fsummaylist)){
									 $amount +=$fsummay['amount'];
									 $f_to12=$fsummay['fto'];
									 if($f_to12==12){										 										   
										 $fullpaid2++;
									  }		
								 }
								// $fullpaid;
								}
					}
					$pending=$total1-$amount;
				?>
                                    <td><?php echo $total1;?></td>
                                    <td><?php echo $amount;?></td>
                                    <td><?php echo $pending;?></td>
								 	<td><?php if(!$pending){ echo '<a original-title="Paid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/tick.png"/></a>';}else{ echo '<a original-title="NonePaid" href="javascript:void(0);" rel="tooltip-top"><img src="img/icons/packs/fugue/24x24/cross.png"/></a>'; } ?></td>
								</tr> 
                                 <?php 
							$count++;
							} ?>  
                            <tr class="gradeX odd" role="row">
									<td class="sno center sorting_1"><center>-</center></td>
								<td><center><b>Total</b></center></td>
                                    <td><b><?php echo $totalamount; if($disamount){ echo " ( discount= -".$disamount." )"; }?></b></td>
                                    <td><b><?php echo $total;?></b></td>
                                    <td><b><?php echo $tot;?></b></td>
                            								 <td class="action"><b><?php if(!$tot){ echo "Fully Paid";}else{echo "Pending";}?></b></td>								
                                 								</tr>                   																
							</tbody>
						</table>
					</div>
				</div>
			</div>
            <div class="clear height-fix"></div>

		</div></div> <!--! end of #main-content -->
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
        <div class="clear height-fix"></div>
        </div>
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
	$('#table-example2').dataTable();	
	$('#table-example1').dataTable();		
// Code that uses jQuery's $ can follow here.
});
// Code that uses other library's $ can follow here.
</script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
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
  <?php if(!$_GET['roll']){ include("mauto.php"); }?>
  <script language="javascript">
	function del(pid,x){
		if(confirm('Do you really mean to delete this item')){
			document.form1.pid.value=pid;
			document.form1.x.value=x;
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
	$(".getamount").each(function() { 
            $(this).keyup(function(){
				var a = document.form1.get_amount.value;
				var total = <?php echo get_order_total();?>;
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
		
		function multi_check()
		{		
				 var checkboxes = $("#multi_id  input[type=checkbox]");					 
					for (var i=0, no=checkboxes.length;i<no;i++) {						 
						  if (checkboxes[i].checked){
							  $("#multi_delete").show();
							  return false;
						  }else{
							  $("#multi_delete").hide();
						  }
						  }
				/*if($('#multi_id').attr('checked')) {
					 $("#multi_delete").show();
				}else{
					$("#multi_delete").hide();
				}
		*/
			 }
		 function multidelete()
		 {
			 if(confirm('Do you really mean to delete this item')){
				 var checkboxes = $("#multi_id  input[type=checkbox]");				 
					for (var i=0, no=checkboxes.length;i<no;i++) {						 
						  if (checkboxes[i].checked){							  
							  var x=checkboxes[i].value;
							 /* $.get("multidelete_payment.php",{value:x},function(data){									
									});	*/							  
						  }else{							  
						  }
						  }				 
					document.form1.command.value='multidelete';
					document.form1.submit();
			 }
		 }
	function change_amountfrom() { 
      var ffromvalue = parseFloat(document.getElementById('ffrom').value);
	  var ffrom1value = parseFloat(document.getElementById('ffrom1').value);
	  var ftovalue = parseFloat(document.getElementById('fto').value);
	  /*if(ffromvalue==1){
		  var ftovalue = ftovalue+1;
	  }	
	   if(((ftovalue-1) < ffromvalue) || (ffromvalue < ffrom1value)) {
      		alert("Please Select valid months");
			location.reload();
			return true;			
					
   		}*/
	  fees = document.getElementById('fees');
	  var feesvalue =parseFloat(feesvalue = document.getElementById('feesvalue').value);
	  var ftyvalue = parseFloat(document.getElementById('ftyvalue').value);
	  var amount=parseFloat(((ftovalue-(ffromvalue-1))/ftyvalue)*feesvalue);
	  //alert(ftovalue);
	  fees.value = amount.toFixed(2);
}
	<?php 
	$max=count($_SESSION['fees']);
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['fees'][$i]['fgid'];
			$feestype=$_SESSION['fees'][$i]['ftype'];
			if($feestype=="fees"){ ?>
	function change_amountfrom<?php echo $pid;?>() {
	  var ffromvalue = parseFloat(document.getElementById('bffrom<?php echo $pid;?>').value);
	  var ffrom1value = parseFloat(document.getElementById('ffrom_<?php echo $pid;?>').value);
	  var ftovalue = parseFloat(document.getElementById('bfto<?php echo $pid;?>').value);
	  /*if(ffromvalue==1){
		  var ftovalue = ftovalue+1;
	  }	  
	   if(((ftovalue-1) < ffromvalue) || (ffromvalue < ffrom1value)) {
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
<?php } } ?>
</script>
<script type="text/javascript">
$(document).ready(function() {
	$('#toggle1 .block-header span,#toggle2 .block-header span').parent().parent().children('.block-content').slideToggle();
    function languageChange()
    {
         var lang = $('#fgroup option:selected').val();
         return lang;
    }
	$("#fgroup").change(function(e){
		var lang = languageChange();
		var fees= $("#fdisid").val();
		var ssid1= $("#ssid").val();
        var value = "<?php echo $bid.",".$cid.",".$sid.",".$acyear;?>";
		//alert(ssid1);
        $.get("mpass_value.php",{value:fees,ssid:ssid1,lang:lang,other:value},function(data){
			$( "#test" ).html(data);
        });
    });
	$( "#datepicker" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
	$(".txt").change(function() { 
	        $('#billupdate').show();
			$('#billpay').hide();
        }); 
		
		$("#poor").change(function(){
			if(this.checked) {
       			$('#poor_student').show();
			}else{
				$('#poor_student').hide();				
			}
    	});	
		$(".fundcal").each(function() { 
            $(this).keyup(function(){
				var a = document.form1.funds.value;
				var total = <?php echo get_order_total();?>;
				var balance = (total-a);
				if(balance<0){
					balance=0;
				}
				document.form1.poor_pay_amount.value = balance;
			 });			
			});		
    /*$('#fgroup').change(function(e) { 
        var lang = languageChange();
		var fees= $("#fdisid").val();
		var ssid1= $("#ssid").val();
        //var dataString = 'lang=' + lang +'fdisid=1';
        $.ajax({
            type: "POST",
            url: "pass_value.php",
            //data: dataString,
			data :{"lang":lang,"fdisid":fees,"ssid":ssid1},
            dataType: 'json',
            cache: false,
            success: function(response) {
                    $( "#test" ).html(data);				
                }
        });
		//location.reload();
		//window.location.reload();
        return false;
    });*/
});
function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'mbilling.php?bid='+cid;	  
	}
</script>
</body>
</html>
<? ob_flush(); ?>