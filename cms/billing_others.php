<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("includes/functions.php");
 function thefunction($number){
  if ($number < 0)
    return 0;
  return $number; 
}

			/*function termfees($b,$c,$s,$acyear,$type,$ssid)
			{
				 $qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id!=4 AND otherfees='0'");	
				$totalfees=0;
				$count=1;
									  while($row2=mysql_fetch_array($qry2))
										{											
											$fgdid=$row2['fgd_id'];
											$select_record=mysql_query("SELECT fg_id FROM fgroup LIMIT 0,3");
							while($student12=mysql_fetch_array($select_record))
							{ 
								$ffg_id=$student12['fg_id'];
								$fratelist=mysql_query("SELECT fr_id,rate FROM frate WHERE ay_id=$acyear AND b_id=$b AND c_id=$c AND s_id=$s AND fg_id=$ffg_id AND fgd_id=$fgdid");
								$frate=mysql_fetch_array($fratelist);
								//$totalfees +=$frate[$rate2];
								$cartid=$fgdid.$ffg_id;
								if(product_exists_visible($cartid)==1){
								$feescountid=product_count($cartid);
										$payamount=$_SESSION['tfees'][$feescountid]['payment'];
										$totalfees +=$payamount;
								}
								$count++;
							}												
							}
			  return $totalfees;
			}*/


if($_REQUEST['command']=='multidelete'){    
   foreach ($_POST['multivalue'] as $value) {
	   $vesplit=explode(",",$value);  
	    $vp=$vesplit[0];
		$vx=$vesplit[1];
    remove_product($vp,$vx);    
   }
}


 if($_REQUEST['command']=='delete' && $_REQUEST['pid']>0){
	 	remove_product($_REQUEST['pid'],$_REQUEST['dtype']);
	}else if($_REQUEST['command']=='clear'){
		unset($_SESSION['tfees']);
	}
	else if($_REQUEST['command']=='cancel'){
		unset($_SESSION['tfees']);
		$bid=$_REQUEST['bid'];
		header("location:billing_others.php?bid=$bid");
	}
	else if($_REQUEST['command']=='update'){
		$max=count($_SESSION['tfees']);
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['tfees'][$i]['cartid'];
			$u=intval($_REQUEST['fees'.$pid]);
			if($u>1){
				$_SESSION['tfees'][$i]['amount']=$u;
			}
			else{
				$msg='Some proudcts not updated!, amount must be a number above 1';
			}
		}
	}else if($_REQUEST['command']=='add' && $_REQUEST['pid']>0){
		//echo $_REQUEST['pid'].",".$_REQUEST['dtype'];
		//die();
		add_product($_REQUEST['pid'],$_REQUEST['dtype']);
	}
	
 /*if (isset($_POST['add-fees']))
{
	  $fees_type=$_POST['fees_type'];
	  $cartid=$_POST['cartid'];
      $frid=$_POST['frid'];							 	  
	  $fgid=$_POST['fgid'];
	  $fgdid=$_POST['fgdid'];
	  $name=$_POST['name'];
	  $amount=$_POST['amount'];
	  $tamount=$_POST['tamount'];
	  $type=$_POST['type'];
	  $paid=$_POST['paid'];
		 if($fees_type){
			addtocart($cartid,$frid,$fgid,$fgdid,$name,$amount,$tamount,$type,$paid);
		 }
}*/
//echo $max=count($_SESSION['tfees']);
//if(is_array($_SESSION['tfees'])){
//echo $_SESSION['tfees'][0]['fgid'];
//}
//echo get_product_name(1);
//unset($_SESSION['tfees']);

if (isset($_POST['place-order']))
{ 
	   $frno=$_POST['frno'];
	   
	   
	   if($_POST['discount']=='')
	   $discount=0;
	   else
	   $discount=$_POST['discount'];


	   $ptype=$_POST['ptype'];
	   $ssid1=$_POST['ssid1'];
	   $ay_id='';
	   $ay=mysql_query("SELECT * FROM student WHERE ss_id=$ssid1"); 
	   $ay_id=mysql_fetch_array($ay)['ay_id'];
	   $ss_name=$_POST['ss_name'];
	   $cid1=$_POST['cid1'];
	   $sid1=$_POST['sid1'];
	   
	   $scateg=$_POST['scateg'];
	   $sfood=$_POST['sfood'];
	   
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
	   $pay_number=$_POST['pay_number'];
	   
	   $bank_name=$_POST['bank_name'];
	   $cheque_date=$_POST['cheque_date'];
	   
	   $get_amount=$_POST['get_amount'];
	   $balance=$_POST['balance'];
	   $cdate=$_POST['receive_cdate'];
	   $cbank=$_POST['receive_cbank'];
	   //$poor_pay_amount=$_POST['poor_pay_amount'];
	   //$fund_amount=$_POST['funds'];
	   $c_fi_id=$_POST['service_invoice_id'];
	   if($poor_pay_amount && $fund_amount){
		   $fund = "1";
	   }
	   	 $qryclass=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
		  $category=mysql_fetch_array($qryclass)['category'];   
	   $qry31=mysql_query("SELECT * FROM finvoice_no_others WHERE category='book'and ay_id=$ay_id"); 
	   $row31=mysql_fetch_array($qry31);
	   $invoice_no1=$row31['count'];
	  	
	   

	   $invoice_no='BF'.str_pad($invoice_no1, 3, '0', STR_PAD_LEFT);
	  
	 $termfees=$_POST['termfees'];
	 $chequeservice=$_POST['cheque_service'];
		$discount_remark=$_POST['discount_remark'];	

		$total=$total-$chequeservice;
	 $sql="INSERT INTO finvoice_others (fr_no,fi_name,fi_total,fi_ptype,fi_day,fi_month,fi_year,ss_id,c_id,s_id,stype,fi_by,bid,ay_id,pay_number,get_amount,balance,poor_student_pay,fund_amount,funds,bank_name,cheque_date,discount,receive_cdate,receive_cbank,cheque_service,discount_remark) VALUES
('$invoice_no','$ss_name','$total','$ptype','$day','$month','$year','$ssid1','$cid1','$sid1','$stype','$user','$bid1','$acyear','$pay_number','$get_amount','$balance','$poor_pay_amount','$fund_amount','$fund','$bank_name','$cheque_date',$discount,'$cdate','$cbank','$chequeservice','$discount_remark')";
$discountUpdate=mysql_query("UPDATE discount_others SET status=1 WHERE ss_id=$ssid1");
//$dis_update = mysql_query($discountUpdate) or die("Could not insert data into DB: " . mysql_error());
//die();
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid= $id = mysql_insert_id();
$update_cheque=mysql_query("update finvoice_others set service_charge_status=1 where fi_id=$c_fi_id");

    if($result){
		
		/**********************************cash pay Update *****************************************/
		if($ptype=='cash'){
			$cashlist=mysql_query("SELECT * FROM cash WHERE id=1"); 
			  $cash=mysql_fetch_array($cashlist);
			  $currentcash=$cash['amount'];
			  $updatecash=$currentcash+$total;
			  $cashqry=mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
		}
	
			 $inovoice=$invoice_no1+1;
					$qry1=mysql_query("UPDATE finvoice_no_others SET count='$inovoice' WHERE ay_id=$ay_id and category='Book'");
					
	 /************************************************Other Fees *************************************************/
	 				if($stype=="New"){
									 $qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0' ORDER BY type DESC");	
									 }else{
										 $qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0' AND type='0' ORDER BY type DESC");	
									 }
							//$qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0'");													
									  while($row2=mysql_fetch_array($qry2))
										{
											$fdiscount=0;
											$fgdid=$row2['fgd_id'];
											$name=$row2['name'];
											$type=$row2['type'];
											$ftype="";
											if($type){
												$ftype=" (New Student)";
											}
											$ffg_id=4;
											$cartid=$fgdid."4";
											$i=product_count($cartid);
											$fdiscount=$_SESSION['tfees'][$i]['discount'];
											if(product_exists_visible($cartid)==1 || $fdiscount){
												$rate=$_SESSION['tfees'][$i]['rate'];
												$pending=$_SESSION['tfees'][$i]['pending'];
												//$payment=$_SESSION['tfees'][$i]['payment'];
												$dvid=$_SESSION['tfees'][$i]['dv_id'];
												$frid=$_SESSION['tfees'][$i]['fr_id'];
												$paid=$_SESSION['tfees'][$i]['paid'];
												$postName = "fees".$cartid;
												$amount = $_POST[$postName];
												if($amount){
												$payment=0;
												 if($paid){
													 $pamount=($rate-$paid)-($amount+$fdiscount);
												 }else{
												  $pamount=$rate-($amount+$fdiscount);
												 }
												 //echo $pamount;
												 //die();
												 $pamount=thefunction($pamount);
												 if($pamount>0){
													 $payment='1';
												 }
												 if($pending){
											
								if($dvid){
									$qry1=mysql_query("UPDATE discount_others SET status='1' WHERE ss_id=$ss_id");
									}
												 }
											 }
											}
										}						
		 /************************************** Terms Fees *********************************************************/		 
			if($sfood){
							$qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id!=4 AND otherfees='0'");	
						}else{
							$qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id!=4 AND otherfees='0' AND food='0'");		
						}
						
					//$qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id!=4 AND otherfees='0'");	
									  while($row2=mysql_fetch_array($qry2))
										{
										
											$fgdid=$row2['fgd_id'];
											$name=$row2['name'];
											$postName = "termfees".$fgdid;
												$termfees = $_POST[$postName];
					     		$select_record=mysql_query("SELECT * FROM fgroup LIMIT 0,3");
								$total=0;
								while($student12=mysql_fetch_array($select_record))
								{ 
								$fdiscount=0;
								$ffg_id=$student12['fg_id'];
								
									if($termfees>1){
											$cartid=$fgdid.$ffg_id;
											$i=product_count($cartid);
											$fdiscount=$_SESSION['tfees'][$i]['discount'];
										  if(product_exists_visible($cartid)==1 || $fdiscount){
												$rate=$_SESSION['tfees'][$i]['rate'];
												$pending=$_SESSION['tfees'][$i]['pending'];
												//$payment=$_SESSION['tfees'][$i]['payment'];
												$dvid=$_SESSION['tfees'][$i]['dv_id'];
												$frid=$_SESSION['tfees'][$i]['fr_id'];
												$paid=$_SESSION['tfees'][$i]['paid'];
												$payamount1=$pending;
												if($fdiscount){
													$pending=$pending-$fdiscount;
													}
													
												if($termfees>=$pending){
													$amount=$pending;
													$termfees=$termfees-$amount;
												}else{
													$amount=$termfees;
													$termfees=$termfees-$amount;
												}
												
												$payment=0;
												 if($paid){
													 $pamount=($rate-$paid)-($amount+$fdiscount);
												 }else{
												  $pamount=$rate-($amount+$fdiscount);
												 }
												 //echo $pamount;
												 //die();
												 $pamount=thefunction($pamount);
												 if($pamount>0){
													 $payment='1';
												 }
												 if($pending || $fdiscount){
												
					
									if($dvid){
									$qry1=mysql_query("UPDATE discount_value_others SET payment='1' WHERE dv_id='$dvid'");
									}
					
												 }
											}
										  }
										}
					}
     	/********************************************************Other Extra fees ************************************************/
			$max=count($_SESSION['tfees']);
							 for($i=0;$i<$max;$i++){
								 $w=$_SESSION['tfees'][$i]['type'];
								 $x=$_SESSION['tfees'][$i]['visible'];
								 if($w=="otherfees" && $x=="1"){
					$pid=$_SESSION['tfees'][$i]['cartid'];
					$q=$_SESSION['tfees'][$i]['fgd_id'];
					$r=$_SESSION['tfees'][$i]['fg_id'];
					$s=$_SESSION['tfees'][$i]['fr_id'];
					$u=$_SESSION['tfees'][$i]['rate'];
					$v=$_SESSION['tfees'][$i]['paid'];
					$w=$_SESSION['tfees'][$i]['pending'];
					$t=$_SESSION['tfees'][$i]['payment'];
					
					$fgrqry=mysql_query("SELECT name FROM fgroup_detail WHERE fgd_id=$q"); 
								  $fgrouplist=mysql_fetch_array($fgrqry);
								  $name=$fgrouplist['name'];
								  
								  if($w){
									
												 }
								 } }
	 			unset($_SESSION['tfees']);
				unset($_SESSION['frate']);
				header("location:finvoice_others.php?fiid=$lastid&bid=$bid1");	 
	}
}		
?>
<style type="text/css">
a.tooltip {outline:none; float:right; }
a.tooltip strong {line-height:30px;}
a.tooltip:hover {text-decoration:none;} 
a.tooltip span {
    z-index:10;display:none; padding:14px 10px 14px;
    margin-top:13px; margin-left:-160px;
    width:320px; 
}
@-moz-document url-prefix() { 
  a.tooltip span {
     margin-top:30px; margin-left:-190px;
  }
}
a.tooltip:hover span{
    display:inline; position:absolute; 
    border:2px solid #0D5889;  color:#363535;
    background:#FFFFFF;
}
a.tooltip:hover table{ width:100%; }
a.tooltip:hover table td{background-color:transparent;}
.callout {z-index:20;position:absolute;border:0;top:-14px;left:120px;}
    
/*CSS3 extras*/
a.tooltip span
{
    border-radius:2px;        
    box-shadow: 0px 0px 8px 4px #666;
    /*opacity: 0.8;*/
}
</style>
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
		$cids=$_GET['cid'];
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
                <li class="no-hover"><a href="board_select_fees.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
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
                 <div class="_25" style="float:right">
                <label for="select">Standard</label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="required" onchange="change_function2()"> <option value="">All</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
											if($cids==$row1['c_id']){
                                                echo "<option value='{$row1['c_id']}' selected>{$row1['c_name']}</option>\n";
												} else {
												echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
                 
				<h1><a href="<?php if($_GET['roll']){ echo "billing_others.php?bid=".$bid;}else{ echo 'board_select_fees.php';}?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>  Invoice</h1>
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
					  $ss_gender=$student['gender'];
					  $cid=$student['c_id'];
					  $sid=$student['s_id'];
					  $s_type=$student['stype'];
					  $latejoin=$student['late_join'];
					  
					  $scateg=$student['scateg'];
								  $sfood=$student['sfood'];
								  
								  if($scateg=='1'){
									  $rate2="rate1";
								  }else{
									  $rate2="rate";
								  }
					  
					  $fdisid1=$student['fdis_id'];
					  
					  $classlist1=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
					  $class1=mysql_fetch_array($classlist1);
					  
					  if(($class1['c_name']=="XI STD") || ($class1['c_name']=="XII STD")){
						 $sid21 = $sid;
					  }else {
						  $sid21 = "0";
					  }								  
								  
				$max=count($_SESSION['tfees']);
				if(empty($_SESSION['tfees'])){		
				 
				 /*
				 if($s_type=="New"){
				 $qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id!=4 AND otherfees='0' ORDER BY type DESC");	
				 }else{
				  $qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0' AND type='0' ORDER BY type DESC");
				 }*/
				 
							if($sfood){
										$qry2=mysql_query("SELECT * FROM fgroup_detail where fg_id!=4 AND otherfees='0'");	
									}else{
										$qry2=mysql_query("SELECT * FROM fgroup_detail where fg_id!=4 AND otherfees='0' AND food='0'");		
									}
				 //$qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id!=4 AND otherfees='0'");	
									  while($row2=mysql_fetch_array($qry2))
										{
											$fgdid=$row2['fgd_id'];
											$type=$row2['type'];
											$ftype="";
											if($type){
												$ftype=" (New Student)";
											}
											
							$discountlist1=mysql_query("SELECT dv_id,amount,payment FROM discount_value_others WHERE ss_id=$ssid AND type='terms' AND payment='0' AND fg_id='1' AND fgd_id=$fgdid AND ay_id=$acyear");
							$discount1=mysql_fetch_array($discountlist1);	
							$eamount=$discount1['amount'];
							$dvid=$discount1['dv_id'];
											
							$select_record=mysql_query("SELECT * FROM fgroup LIMIT 0,3");
					while($student12=mysql_fetch_array($select_record))
					{ 
					$ffg_id=$student12['fg_id'];
					$total=0;
											
											
											//echo $row2['name'].$ftype;
											//echo "<br>";
				 
						$fratelist=mysql_query("SELECT fr_id,rate,rate1 FROM frate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid21 AND fg_id=$ffg_id AND fgd_id=$fgdid");
						$frate=mysql_fetch_array($fratelist);
						$frid=$frate['fr_id'];
						$frate1=$frate[$rate2];
						if($ffg_id=='1'){
							$term1+=$frate[$rate2];
						}else if($ffg_id=='2'){
							$term2+=$frate[$rate2];
						}else if($ffg_id=='3'){
							$term3+=$frate[$rate2];
						}
						
						$total+=$frate[$rate2];
						$totalfees+=$frate[$rate2];
						
						$total1=$frate[$rate2];
                         //if($frate[$rate2]){ echo $frate[$rate2]; } else{ echo " - "; }
						 //echo "<br>";
                              $count++; 
							  
							  $pending=0;	
								$ptype=1;
								$paid=0;
				$qry5=mysql_query("SELECT * FROM finvoice_others WHERE ss_id=$ssid AND c_id=$cid AND bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='0'");
				  while($row5=mysql_fetch_array($qry5))
					{
							
					  }
					  if($paid){
						  $pending =$frate1-$paid;
					  }else{
						  $pending =$frate1;						  
					  }
					  if($pending>$frate1){
						  $pending =$frate1;						  
					  }else if($pending==0){
						  $ptype=0;
					  }
					  
					  
								  //echo $pending."<br>";
								  
								  if($pending && $ptype=="1"){
									  $pending1=$pending;
									  //$paid=$total1-$pending;
								  }else if(!$pending && $ptype=="0"){
									  $pending1=0;
								  }else{
									  $pending1=$total1;
								  }
								  $cartid=$fgdid.$ffg_id;
								 $fdiscount=0; 
								  $payamount1=$pending1;
								  if($eamount){
										if($pending1>$eamount){
											$payamount1=$pending1-$eamount;
											$fdiscount=$eamount;
											$eamount=0;					
										}else{
											$eamount=$eamount-$pending1;
											$fdiscount=$pending1;
											$payamount1=0;
										}
									}
						if($total1 && $payamount1){
								  		$visible=1;
								  }else{
									  	$visible=2;
								  }
							//echo $cartid."-".$fgdid."-".$ffg_id."-".$frid."-".$total1."-".$paid."-".$pending1."-".$payamount1."-".$visible."-terms-".$fdiscount."-".$dvid."<br>";
								  addtocart($cartid,$fgdid,$ffg_id,$frid,$total1,$paid,$pending1,$payamount1,"terms",$visible,$fdiscount,$dvid);
								  
								  if($eamount==0){
									  $dvid=0;
								  }
							  }
							}
										if($s_type=="New"){
									 $qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0' ORDER BY type DESC");	
									 }else{
										 $qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0' AND type='0' ORDER BY type DESC");	
									 }
				 
				 
				 					//$qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0'");	
																	
									  while($row2=mysql_fetch_array($qry2))
										{
											$total2=0;	
											$fgdid=$row2['fgd_id'];
											$type=$row2['type'];
											$ftype="";
											if($type){
												$ftype=" (New Student)";
											}
											//echo $row2['name'].$ftype;
											//echo "<br>";
											$fratelist=mysql_query("SELECT fr_id,rate,rate1 FROM frate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid21 AND fg_id=4 AND fgd_id=$fgdid");
						$frate=mysql_fetch_array($fratelist);
						$total2+=$frate[$rate2];
						$total+=$frate[$rate2];
						$totalfees+=$frate[$rate2];
						$frid=$frate['fr_id'];
						$frate1=$frate[$rate2];
						//if($frate[$rate2]){ echo $frate[$rate2]; } else{ echo " - "; }
						 //echo "<br>";
						$count++;
						
						$eamount=0;
						$discountlist1=mysql_query("SELECT dv_id,amount,payment FROM discount_value_others WHERE ss_id=$ssid AND fg_id=4 AND fgd_id=$fgdid  AND type='other' AND payment='0'");
							$discount1=mysql_fetch_array($discountlist1);	
							$eamount=$discount1['amount'];
							$dvid=$discount1['dv_id'];
						
							    $pending=0;	
								$ptype=1;
								$paid=0;
				$qry5=mysql_query("SELECT * FROM finvoice_others WHERE ss_id=$ssid AND c_id=$cid AND bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='0'");
				  while($row5=mysql_fetch_array($qry5))
					{
							
					  }
					  
					  if($paid){
						  $pending =$frate1-$paid;
					  }else{
						  $pending =$frate1;						  
					  }
					  if($pending>$frate1){
						  $pending =$frate1;						  
					  }else if($pending==0){
						  $ptype=0;
					  }
								  //echo $pending."<br>";
								  
								  if($pending && $ptype=="1"){
									  $pending1=$pending;
									  //$paid=$total1-$pending;
								  }else if(!$pending && $ptype=="0"){
									  $pending1=0;
								  }else{
									  $pending1=$total2;
								  }
								  $cartid=$fgdid."4";
								  $fdiscount=0;
								  $payamount1=$pending1;
								  if($eamount){
										if($pending1>$eamount){
											$payamount1=$pending1-$eamount;
											$fdiscount=$eamount;
											$eamount=0;								
										}else{
											$eamount=$eamount-$pending1;
											$fdiscount=$pending1;
											$payamount1=0;
										}
									}
								  //echo $cartid."-".$fgdid."-4-".$frid."-".$total2."-".$paid."-".$pending1."-".$payamount1."-other-".$fdiscount."-".$dvid."<br>";
								  
								  if($total2 && $payamount1){
								  		$visible=1;
								  }else{
									  	$visible=2;
								  }
								  addtocart($cartid,$fgdid,"4",$frid,$total2,$paid,$pending1,$payamount1,"other",$visible,$fdiscount,$dvid);
						} 
						
						
						
						$qry6=mysql_query("SELECT * FROM fgroup_detail where fg_id='4' AND otherfees='1'");
						  while($row6=mysql_fetch_array($qry6))
							{	
								$fgdid=$row6['fgd_id'];
								$cartid=$fgdid."4";			
								$pending1=$row6['fees_amount'];
								//echo $cartid."-".$fgdid."-4-".$frid."-".$pending1."-".$pending1."-".$pending1."-".$pending1."-otherfees<br>";
								addtocart($cartid,$fgdid,"4",$frid,$pending1,0,$pending1,$pending1,"otherfees","2");
							}
				 
				//echo $max=count($_SESSION['tfees']);
				//die();
				
				}
								  if(!$student){
			header("location:billing_others.php?bid=$bid");
		}
		
		
		
							?>
				<div>   
                           
                <form name="form1" method="post" action="" id="validate-form1" class="block-content-invoice form">
<input type="hidden" name="pid" />
<input type="hidden" name="dtype" id="dtype" />
<input type="hidden" name="bid" value="<?php echo $bid;?>" />
<input type="hidden" name="command" />
                <?php 
				//$ssid=$_GET['ss_id'];
					$studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student1=mysql_fetch_array($studentlist1);
								  $cid1=$student1['c_id'];
								  
								  $rid=$student1['r_id'];
								  $ay_id=$student1['ay_id'];
								  $class=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $cat=mysql_fetch_array($class)['category'];
								  $scateg=$student1['scateg'];
								  $sfood=$student1['sfood'];
								  
								  if($scateg=='1'){
									  $rate="rate1";
								  }else{
									  $rate="rate";
								  }
								  
								  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $row=mysql_fetch_array($qry);
								  
								  $sid1=$student1['s_id'];
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_array($qry1);
								  
								  $qry3=mysql_query("SELECT count FROM finvoice_no_others WHERE ay_id=$ay_id and category='book'"); 
								  $row3=mysql_fetch_array($qry3);
								  if($cat=="CL")
								  	$cat="BFL";
								  if($cat=="CM")
								  	$cat="BFM";
								  if($cat=="CH")
								  	$cat="BFH";
								  $invoice_no='BF'.str_pad($row3['count'], 3, '0', STR_PAD_LEFT);
								  
								  /*$fdisid=$student1['fdis_id'];
								  $qry4=mysql_query("SELECT * FROM fdiscount WHERE fdis_id='$fdisid'"); 
								  $row4=mysql_fetch_array($qry4);
								  $fdisname=$row4['fdis_name'];*/
								  
								  
								  /*$max=count($_SESSION['tfees']);
							 for($i=0;$i<$max;$i++){
									$z=$_SESSION['tfees'][$i]['type'];
									$x=$_SESSION['tfees'][$i]['visible'];
									$pid=$_SESSION['tfees'][$i]['cartid'];
									$q=$_SESSION['tfees'][$i]['fgd_id'];
									$r=$_SESSION['tfees'][$i]['fg_id'];
									$s=$_SESSION['tfees'][$i]['fr_id'];
									$u=$_SESSION['tfees'][$i]['rate'];
									$v=$_SESSION['tfees'][$i]['paid'];
									$w=$_SESSION['tfees'][$i]['pending'];
									$t=$_SESSION['tfees'][$i]['payment'];
									echo $pid."-".$q."-".$r."-".$s."-".$u."-".$v."-".$w."-".$t."-".$z."-".$x."<br>";
								 }*/
								  ?>
						
						<div id="invoice" class="widget widget-plain" class="widget-content">	
				<ul class="client_details">
				<?php
				// Cheque Bounce Finder dev-sri
				$bouncefind=mysql_query("SELECT * FROM finvoice_others WHERE ss_id=$ssid AND ay_id=$acyear AND c_status=1 AND service_charge_status IS NULL");
				$B_there=mysql_fetch_array($bouncefind);
				//echo "<pre>";
				//	print_r($B_there);
				//echo "</pre>" 
				?>
					<li><strong class="name">FR Number : <?php echo $invoice_no;?></strong><input type="hidden" class="medium" name="frno" value="<?php echo $invoice_no;?>"/></li>
                    <li>Class - Section: <?php echo $row['c_name']." - ".$row1['s_name'];?><input type="hidden" class="medium" name="cid1" value="<?php echo $cid;?>"/>
                    <input type="hidden" class="medium" name="sid1" value="<?php echo $row1['s_id'];?>"/></li>
					<li>Gender: <?php if($student1['gender'] == 'M')
											echo "Male";
										else	
										    echo "Female"; ?><input type="hidden" class="medium" name="bid1" value="<?php echo $bid;?>"/></li>
				</ul>
                <ul class="client_details">
					<li>Student Name : <strong class="name"><?php echo $student1['firstname']." ".$student1['middlename']." ".$student1['lastname'];?></strong> <input type="hidden" class="medium" name="ss_name" value="<?php echo $student1['firstname']." ".$student1['middlename']." ".$student1['lastname'];?>"/></li>
					<li>Admission No: <?php echo $student1['admission_number'];?> <input type="hidden" class="medium" name="adminid" value="<?php echo $student1['admission_number'];?>"/></li>
					 <li>Student Type : <b><?php echo $student1['stype'];?></b> Student <input type="hidden" class="medium" name="stype" value="<?php echo $student1['stype'];?>"/></li>
				</ul>
				<?php 		
$st=mysql_query("select * from discount_others where ss_id=$ssid AND status=0");
$remark=mysql_fetch_array($st)['remark'];
?>
<input type="hidden" name="discount_remark" value="<?= $remark?>">
                <ul class="client_details">
					<li>Academic Year : <strong class="name"><?php echo $acyear_name;?></strong><input type="hidden" class="medium" name="ssid1" value="<?php echo $ssid; ?>"/></li>
					<li>Parent's Name: <?php echo $student1['fathersname'];?> <input type="hidden" class="medium" name="category" value="<?php echo $fdisname;?>"/></li>
                    
				</ul>
				<ul class="client_details">
					<li>Status: <span class="ticket ticket-info">Open</span></li>
					<li><strong>Invoice Date :</strong> <input id="datepicker" name="idate" type="text" value="<?php echo date("d/m/Y");?>"  style="width:60%"/></li>                    
				</ul>
                <div class="_25" style="float:right">
                <select name="cartid" id="cartid" onchange="addd()">
                			<option value="">Add fees</option>
                                	<?php
									/*$totalpayamount=get_term_total();
									if($totalpayamount){
										if(product_exists_visible2()!="1"){	
										echo "<option value='11-1'>Terms Fees - {$totalpayamount}</option>\n"; 									 	
										 }
									}*/
									if($s_type=="New"){
									 $qry6=mysql_query("SELECT name,fgd_id,fees_amount FROM fgroup_detail where fg_id=4 AND otherfees='0' ORDER BY type DESC");	
									 }else{
										 $qry6=mysql_query("SELECT name,fgd_id,fees_amount FROM fgroup_detail where fg_id=4 AND otherfees='0' AND type='0' ORDER BY type DESC");	
									 }
									 //$qry6=mysql_query("SELECT name,fgd_id,fees_amount FROM fgroup_detail where fg_id='4' AND otherfees='0'");
											  while($row6=mysql_fetch_array($qry6))
												{
													$fgdid=$row6['fgd_id'];
													$name=$row6['name'];
													$cartid=$fgdid."4";	
													if(product_exists_visible($cartid)!=1){
														if(product_exists($cartid)==1){
															$feescountid=product_count($cartid);
															$payamount=$_SESSION['tfees'][$feescountid]['payment'];
															if($payamount){
															echo "<option value='{$cartid}-2'>{$name} - {$payamount}</option>\n";
															}
														}
													}
												}
												
									if($sfood){
										$qry6=mysql_query("SELECT name,fgd_id,fees_amount FROM fgroup_detail where fg_id!=4 AND otherfees='0'");	
									}else{
										$qry6=mysql_query("SELECT name,fgd_id,fees_amount FROM fgroup_detail where fg_id!=4 AND otherfees='0' AND food='0'");		
									}
									//$qry6=mysql_query("SELECT name,fgd_id,fees_amount FROM fgroup_detail where fg_id='4' AND otherfees='0'");
											  while($row6=mysql_fetch_array($qry6))
												{
													$fgdid=$row6['fgd_id'];
													$name=$row6['name'];
													$cartid=$fgdid."1";
													if(product_exists_visible2($cartid)!=1){
														if(product_exists($cartid)==1){
															//$feescountid=product_count($cartid);
															$payamount=product_total($cartid);
															if($payamount){
															echo "<option value='{$cartid}-1'>{$name} - {$payamount}</option>\n";
															}
														}
													}
												}
												
												
												
												
											$qry6=mysql_query("SELECT name,fgd_id,fees_amount FROM fgroup_detail where fg_id='4' AND otherfees='1'");
											  while($row6=mysql_fetch_array($qry6))
												{
													$fgdid=$row6['fgd_id'];
													$name=$row6['name'];
													$cartid=$fgdid."4";			
													$pending1=$row6['fees_amount'];
													if(product_exists_visible($cartid)!=1){
                                             	echo "<option value='{$cartid}-2'>{$name} - {$pending1}</option>\n";
													}
												}
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
                 <?php if($rid){?>
                 <a href="busfeesbilling_others.php?roll=<?=$roll?>&bid=<?=$bid?>&fee=1" title="Vehicle Fees Payment" class="btn btn-small btn-success" style="color:#FFFFFF" target="_blank"><img src="img/icons/packs/fugue/16x16/table--plus.png"> Vehicle Fees Payment</a><?php } ?>
                <table id="table-example1" class="table">
                <?php 
				$total=0;
							 $count=1;
							 if($s_type=="New"){
									 $qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0' ORDER BY type DESC");	
									 }else{
										 $qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0' AND type='0' ORDER BY type DESC");				 }
										 
									 $neworcommonfees="sdsf";
									 if($neworcommonfees){ ?>
                			<thead>
								<tr>
                                	<th width="5"><span id="multi_delete" hidden="true"><img src="img/del.png" onClick="multidelete()"  name="multi_delete" alt="delete"></span></th>
									<th>S.No</th>
                                    <th colspan="3"><center>Group Name</center></th>
                                    <?php 							
									$qry1=mysql_query("SELECT * FROM fgroup");
									$noofrow=mysql_num_rows($qry1);							
								   ?>
                                    <th colspan="1">Fees Amount</th>
                            	    <th>Total</th>
                                    <th>Discount</th>
                                    <th class="total">Pay Amount</th>
                                    <th width="10"></th>
								</tr>
							</thead>
                            <tbody>
                			<?php
							//$qry2=mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0'");													
									  $n=0;
									  while($n<1)
										{
											$n++;
											$fgdid=$row2['fgd_id'];
											$type=$row2['type'];
											$ftype="";
											if($type){
												$ftype=" (New Student)";
											}
											$cartid=$fgdid."4";
											?>
                             <tr style="border:1px #B7B7B7 dotted;background-color:#FF0004;">
                             	<td id="multi_id"><center><input type="checkbox" name="multivalue[]" onClick="multi_check()" value="<?=$cartid.",2"?>"></center></td>
                             	<td><?=$count?>

                             	</td>
                                <td colspan="3"><?php echo 'Books, Notes & Other Items';
								?></td>
                                <?php
								$payamount=0;
								//echo $row1['g_name'];
								//echo $cid1;
								$gname=$row1['g_name'];
								//$grp=mysql_query("select * from section where  c_id=$cid1 and s_id=")
						$fratelist=mysql_query("SELECT amount FROM others_bill_all WHERE std=$cid1 and gname='$gname' and ay_id=$acyear");
						$frate=mysql_fetch_array($fratelist);
						//echo "<pre>";
						//print_r($frate);
						//echo "</pre>";

						//$feesrate=$frate['amount'];
						$total+=$frate['amount'];
						$totalfees+=$frate['amount'];
						
						$eamount=0;
						$discountlist1=mysql_query("SELECT amount,payment FROM discount_value_others WHERE ss_id=$ssid AND fg_id=4 AND fgd_id=$fgdid  AND type='other' AND payment='0'");
							$discount1=mysql_fetch_array($discountlist1);	
							$eamount=$discount1['amount'];
							
						if(product_exists($cartid)==1){
										$feescountid=product_count($cartid);
										$payamount=$_SESSION['tfees'][$feescountid]['payment'];
										$fdiscount=$_SESSION['tfees'][$feescountid]['discount'];
						}
						/*if($eamount){
							if($payamount>$eamount){
								$payamount=$payamount-$eamount;
								$eamount=0;
							}else{
								$eamount=$eamount-$payamount;
								$payamount=0;
							}
						}
						echo $eamount;*/
						 ?>
                                <td <?php 
                                if($fdiscount){?> style="background-color:#efbf00" <?php } ?>><?php if($frate['amount']){ echo $frate['amount']; } else{ echo " Paid "; } ?>
                                <?php 
                                $allin=mysql_query("select * from finvoice_others where ss_id=".$student1['ss_id']." and c_status!=1 and i_status!=1");
                                $alin=array();
                                $dis=0;
                                $totfee=0;
                                while($ans=mysql_fetch_assoc($allin))
                                {
                                	$alin[]=$ans;
                                	$totfee+=$ans['fi_total'];
                                	$dis+=$ans['discount'];
                                }

                                if(count($alin)>0){?>
                                    <a href="#" class="tooltip">
    <img src="img/icons/packs/fugue/16x16/clipboard-list.png">
    <span>
        <img class="callout" src="img/callout_black.gif" />
        <center><strong>Total Paid fees : <?=$totfee?></strong></center>
        <?php if($dis>0){
        	$percent=($dis/$frate['amount'])*100;
        ?>
        <div class="alert warning">Rs.<?php echo $dis.' ('.round($percent,2).'% )'?>/- Discount applied</div>
        <?php } ?>
        <table>
		      <thead>
		        <tr>
		          <th>Date</th>
                  <th>fees</th>
		          <th>paid</th>
		          <th>discount</th>
                  <th>pending</th>
		        </tr>
		      </thead>
		      <tbody>
              <?php 
			  $paying=$feesrate;
			  $paid=0;
			  $tcount=1;
			  $qry5=mysql_query("SELECT fi_id,fi_day,fi_month,fi_year FROM finvoice_others WHERE ss_id=$ssid AND c_id=$cid AND bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='0'");
				  $tmptot=0;
				  foreach($alin as $tmp)
					{  
					$tmptot+=$tmp['fi_total'];
					   ?>
		        <tr>
		          <td><?php echo $tmp['fi_day'].'/'.$tmp['fi_month'].'/'.$tmp['fi_year'];?></td>
                  <td><?= $frate['amount']?></td>
		          <td><?= $tmp['fi_total']?></td>
		          <td><?php if($tmp['discount']){ echo $tmp['discount'];}else{ echo "-";}?></td>
                  <td><?php 
                  $tpending=$frate['amount']-$dis-$tmptot;
                  if($tpending){ echo $tpending;}else{ echo "Fully Paid";}?></td>
		        </tr>
                <?php $paying -=($row6['amount']+$row6['discount']); 
				$tcount++;  } 
				if(count($alin)==0){?>
                <tr>
                	<td colspan="5">This is No Invoice Details</td>
                </tr>
                <?php } ?>
		      </tbody>
		    </table>
    </span>
</a><?php } ?>
</td>
                                <td><?php 
       							$frate['amount']=$frate['amount']-$totfee-$dis;
                                if($frate['amount']){ echo $frate['amount']; } else{ echo " Paid "; }?></td>
                                <?php
                                $eamount=0;
                                $ss_id=$student1['ss_id'];
                                $discount=mysql_query("SELECT * FROM discount_others WHERE ss_id=$ss_id and status=0");
                                $status=mysql_fetch_array($discount);
                                $eamount=$status['total'];
                                $percent=($eamount/$frate['amount'])*100;
                                ?>
                                <td style="vertical-align: middle;<?php if($eamount){ echo "background-color:#efbf00;"; } ?>"><center><?php if($eamount){ echo $eamount.' ('.round($percent,2).'% )'; }else{ echo "-"; }?></center>
                                </td>
                                <td>
                                	<?php 
                                	$inall=mysql_query("SELECT * FROM finvoice_others WHERE ss_id=$ss_id");
                                	$amt=0;
                                	while($ans=mysql_fetch_assoc($inall)){
                                		$amt+=$ans['fi_total'];
                                	}
                                	if($frate['amount']!=0){
                                	?>
                                	<input type="text" name="fees<?php echo $cartid;?>" id="fees<?php echo $cartid;?>" class="biginput txt" id="autocomplete" class="required" value="<?php echo $frate['amount']-$eamount;?>" autocomplete="off" max="<?php echo $frate['amount']-$eamount;?>" />
                                	<?php }	else {
                                			echo 'Paid Fully';
                                		}
                                		?>
                                </td>
                                <td>
                                	<?php if(product_exists_visible($cartid)==1){
										if($payamount){?>
                                	<a href="javascript:del(<?php echo $cartid?>,2)"><img src="Book_inventory/images/del.png" alt="delete"></a>
                                    <?php } } ?>
                                </td>
                             </tr>
                             
                             <?php $count++;} }?>
                             
                         <?php    //Cheque Bounce dev-sri
						if($B_there['c_status']==1){ ?>
							<tr>
							<td colspan="7"></td>
							<td>Cheque Bounce Charges :</td>
							<input type="hidden" name="service_invoice_id" value="<?= $B_there['fi_id']?>">
							<td><input id="chequecharge" class="biginput txt text" type="text" autocomplete="off" name="cheque_service"></td>
							<td></td>
						</tr>
						<?php } else { 
							
						}  // cheque bounce dev-sri ?>
						<tr class="total_bar">
							<td class="grand_total" colspan="7"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs. <span id="fgtotal"><?php echo number_format($frate['amount']-$eamount,2);?></span><input type="hidden" class="medium" name="total" id="finaltotal" value="<?php echo $frate['amount']-$eamount;?>"/></td>
						</tr>
                        <tr>
                                                <tr>
                                                <?php if($frate['amount']!=0){ ?>
							<td colspan="10" align="right">	
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
                                   
									<div id="forcheque" style="display: none;">
									<div class="_25">
                                    <p>
                                        <label for="textfield">Cheque Date </label>
                                        <input  name="receive_cdate" id="cdate"  type="text" value="" />
                                    </p>
                                    </div>
									<div class="_25">
                                    <p>
                                        <label for="textfield">Bank Name </label>
                                        <input  name="receive_cbank" id="cbank" type="text" value="" />
                                    </p>
                                    </div>
                                    
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
                                    <input type="hidden" value="<?= $eamount?>" name="discount">
                            </td>
                            
						</tr>
										<tr>
										
                <td colspan="10" align="right">
                <span id="billpay">
                <input type="button" value="Clear" class="btn  btn-blue" onClick="clear_cart()" style="width:100px">&nbsp;&nbsp;
                <input type="submit" value="Submit" name="place-order" class="btn btn-green" onClick="return confirm('are you sure you wish to Submit this Details');" style="width:100px">&nbsp;&nbsp;
                <input type="button" value="cancel" class="btn btn-red" onClick="cancel_cart()" style="width:100px"></span>
                <span id="billupdate" style="display:none; float:right">
                <input type="button" value="Update" class="btn  btn-green" onClick="update_cart()" style="width:100px">&nbsp;&nbsp;
                </span>
                </td>
                </tr>
                <?php } else { ?>
                <tr>
                <td colspan="10" align="right">

                <span id="billpay" style="float:right">
                <input type="button" value="cancel / Close" class="btn btn-red" onClick="cancel_cart()" style="width:130px"></span>
                </td>
                </tr>
                <?php } ?>
                             </tbody>
                             <!--</table>

							<!-- old student -->
							
						</table>
				<table class="table table-striped" id="table-example">	
                <?php
				$max=count($_SESSION['tfees']);
		?>
				</table>
				
				<hr>
			</div>
			</div>
            </form>
		<?php } else { 
		unset($_SESSION['tfees']);
		unset($_SESSION['frate']);
		?>
        <div class="field-group">
                            <form id="validate-form" class="block-content form" method="get" action="">
                            <div class="_75">
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
        <?php  } 
		?>
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
  <?php if(!$_GET['roll']){ include("auto.php"); }?>
  <script language="javascript">
	function del(pid,type){
		if(confirm('Do you really mean to delete this item')){
			document.form1.pid.value=pid;
			document.form1.dtype.value=type;
			document.form1.command.value='delete';
			document.form1.submit();
		}
	}
	function addd(){
		var x = document.getElementById("cartid").value;
		var res = x.split("-");
		//alert(res[0]);
			document.form1.pid.value=res[0];
			document.form1.dtype.value=res[1];
			document.form1.command.value='add';
			document.form1.submit();
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
		function paymet_type() {
			var x = document.getElementById("ptype").value;
			if(x != "cash"){
				$('#cash_pay').hide();
			}else{
				$('#cash_pay').show();
			}
			$.get("payment_type.php",{value:x},function(data){
			$( "#ajax_pay" ).html(data);
			});
			if(x == "cheque"){
				$('#forcheque').html('<div class="_25"><p><label for="textfield">Bank Name </label><input id="cbank" class="text" type="text" value="" name="receive_cbank"></p></div><div class="_25"><p><label for="textfield">Cheque Date </label><span class="Zebra_DatePicker_Icon_Wrapper" style="display: inline-block; position: relative; float: none; top: auto; right: auto; bottom: auto; left: auto;"><input type="text" value="" id="cdate" name="receive_cdate" style="display: inline-block; position: relative; top: auto; right: auto; bottom: auto; left: auto;width:206px;" class="text"></span></p></div>');
				$("#forcheque").show();
				$("#cdate" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
				$("#forcheque").show();
			} else {
				$("#forcheque").hide();
			}	
		}
</script>

<script type="text/javascript">
$(document).ready(function() {
	var validateform = $("#validate-form1").validate();
	$("#fees_type").change(function(){
		//alert("test");
        var thiss = $(this);
        var value = thiss.val(); 
        $.get("feestype_calculate.php",{value:value},function(data){
			$( "#test" ).html(data);
        });
    });
	function currencyFormat (num) {		
    return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	}
	$(".txt").each(function() { 
            $(this).keyup(function(){
				var textBoxVal=0;
				var allInputs = document.getElementsByClassName("txt");
				//alert(allInputs.length);
				for (var i = 0; i < allInputs.length; i++)
				   if (allInputs[i].type === "text") {
					   var fvalue=allInputs[i].value;
					   textBoxVal = Number(fvalue)+textBoxVal;
				   } 
				   
				   textBoxVal1=currencyFormat(textBoxVal);
				   $("#fgtotal").html(textBoxVal1);
				   $("#fstotal").html(textBoxVal1);
				   $("#finaltotal").val(textBoxVal);
				//alert(textBoxVal);
               //$('#billupdate').show();
			   //$('#billpay').hide();
            });
        }); 
	 $(".getamount").each(function() { 
            $(this).keyup(function(){
				var a = document.form1.get_amount.value;
				var total = $('#finaltotal').val();
				var balance = (a-total);
				if(balance<0){
					balance=0;
				}
				document.form1.balance.value = balance;
            });
        });
		$("#poor").change(function(){
			if(this.checked) {
       			$('#poor_student').show();
			}else{
				$('#poor_student').hide();				
			}
    	});	
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
		$("#cdate" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
		$(".fundcal").each(function() { 
            $(this).keyup(function(){
				var a = document.form1.poor_pay_amount.value;
				var total = <?php echo get_order_total();?>;
				var balance = (total-a);
				if(balance<0){
					balance=0;
				}
				document.form1.funds.value = balance;
			 });			
			});		
	
    function languageChange()
    {
         var lang = $('#fgroup option:selected').val();
        return lang;
    }  
});
function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'billing_others.php?bid='+cid;	  
	}
	function change_function2() { 
     var cid =document.getElementById('cid').value;
	 window.location.href = 'billing_others.php?bid=<?php echo $bid;?>&cid='+cid;	  
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
</script>
</body>
</html>
<? ob_flush(); ?>