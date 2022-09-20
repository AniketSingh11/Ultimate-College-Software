<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("includes/functions.php");
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
		header("location:billing.php?bid=$bid");
	}
	else if($_REQUEST['command']=='update'){
		$max=count($_SESSION['fees']);
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
			}
			else{
				$msg='Some category fees not updated!,please select valid Month!!!';
			}
		}
	}
	
	
 if (isset($_POST['add-fees']))
{
	//die();
		$fgroup=$_POST['fgroup'];
		$ftyvalue=$_POST['ftyvalue'];
		$fgrouplist1=mysql_query("SELECT * FROM frate WHERE fr_id=$fgroup");
									 $ffgroup1=mysql_fetch_array($fgrouplist1);
	  $fgrid=$ffgroup1['fg_id'];							 	  
	  $ffrom=$_POST['ffrom'];
	  $fto=$_POST['fto'];
	  $fees=$_POST['fees'];
	  $feesvalue=$_POST['feesvalue'];
	 if($fgroup){
		addtocart($fgrid,$ffrom,$fto,$fees,$fgroup,$ftyvalue,$fees,$feesvalue);
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
	   $day=date("d");
	   $month=date("m");
	   $year=date("Y");
	  //$seid=$_POST['se_id'];
	   $total=$_POST['total'];
	   $category=$_POST['category'];
	   $stype=$_POST['stype'];
	   $bid1=$_POST['bid1'];	  
	   
	   $qry31=mysql_query("SELECT * FROM finvoice_no WHERE id='1'"); 
								  $row31=mysql_fetch_array($qry31);
								  $invoice_no=$row31['count'];
	  
	 
	 $sql="INSERT INTO finvoice (fr_no,fi_name,fi_total,fi_ptype,fi_day,fi_month,fi_year,ss_id,c_id,s_id,category,stype,fi_by,bid,ay_id) VALUES
('$invoice_no','$ss_name','$total','$ptype','$day','$month','$year','$ssid1','$cid1','$sid1','$category','$stype','$user','$bid1','$acyear')";
//die();
$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=$id = mysql_insert_id();
    if($result){
		/*$invoicelist=mysql_query("SELECT * FROM invoice WHERE i_id='$lastid'"); 
								  $invoice=mysql_fetch_array($invoicelist);
								  $i_id=$invoice['i_id'];								  
								  $inovoice=$in_no+1;*/
								  
								  $inovoice=$invoice_no+1;
					$qry1=mysql_query("UPDATE finvoice_no SET count='$inovoice' WHERE id='1'");
								  
		$max=count($_SESSION['fees']);
				for($i=0;$i<$max;$i++){
					 $pid=$_SESSION['fees'][$i]['fgid'];
					 $q=$_SESSION['fees'][$i]['ffrom'];
					 $s=$_SESSION['fees'][$i]['fto'];
					 $r=$_SESSION['fees'][$i]['amount'];
					 $t=$_SESSION['fees'][$i]['ftid'];
					 $pname=get_product_name($pid);
					if($q==0) continue;
					
					 //$price=get_price($pid);
					 //$btotal=number_format((get_price($pid)*$q),2);
					 //echo "<br>";
					
					$sql1="INSERT INTO fsalessumarry (fi_id,fg_id,fty_id,fg_name,ffrom,fto,amount,bid,ay_id) VALUES
('$lastid','$pid','$t','$pname','$q','$s','$r','$bid1','$acyear')";
					$result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
					
					$booklist=mysql_query("SELECT * FROM book WHERE b_id='$pid'"); 
								  $book=mysql_fetch_array($booklist);
								  $type=$book['type'];
							 	  $nid=$book['n_id'];
					
				}
				unset($_SESSION['fees']);
				unset($_SESSION['frate']);
				header("location:finvoice.php?fiid=$lastid&bid=$bid1");
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
				<h1><a href="board_select_fees.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>  Invoice</h1>
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
								  
				$max=count($_SESSION['fees']);
			if(empty($_SESSION['fees'])){
				//echo "test"; 		die();		  
						$sql1=mysql_query("SELECT * FROM frate WHERE c_id=$cid AND b_id=$bid AND ay_id=$acyear ORDER BY fg_id");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$ffgid=$row2['fg_id'];
									$frid=$row2['fr_id'];
									$fgrouplist=mysql_query("SELECT * FROM fgroup WHERE fg_id=$ffgid");
									$ffgroup=mysql_fetch_array($fgrouplist);
									
									$ftyid=$ffgroup['fty_id'];
							
								$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
														$ftypevalue=$ftype['fty_value'];
														
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
								$classlist=mysql_query("SELECT * FROM frate_value WHERE fr_id=$frid AND fdis_id=$fdisid1"); 
																  $class=mysql_fetch_array($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgid;
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT * FROM finvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND s_id = '" . $sid. "' AND ss_id = '" . $ssid. "'";
							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							
							
							$fratelist1=mysql_query("SELECT * FROM frate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid21=$frate1['fg_id'];	 
					
								
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT * FROM fsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21;"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==12){										 										   
										 $fullpaid2++;
									  }		
								 }
								// $fullpaid;
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12;
						$frateto12=$fratefrom2+$frateto2;
						if($frateto12>12){
							$frateto12=12;
							
						}
						/*if($fratefrom==$frateto1){
							echo '<script language="javascript">';
							echo 'alert("This Category Fees Fully Paid")';
							echo '</script>';
						}*/
						//ftovalue-ffromvalue)/ftyvalue)*feesvalue;
						
						$frateamount12=(($frateto12-$fratefrom2)/$frateto2)*$frateamount2;							
					}else {
							$frateto12=$frateto2;
							$frateamount12=$frateamount2;							
						}
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						if($frateamount12>0){
							addtocart($ffgid,$fratefrom2,$frateto12,$frateamount12,$frid,$ftypevalue,$frateamount12,$frateamount2);
						 }
										
									}
				}
								  if(!$student){
			header("location:billing.php?bid=$bid");
		}
							?>
				<div id="invoice" class="widget widget-plain">			
				        <div class="block-border">
					<div class="block-header">
						<h1>Add New Fees</h1><span></span>
					</div>
                    <?php 
					//unset($_SESSION['frate']);
					 $frateid=$_SESSION['frate']['frid'];
					 $fratefrom=$_SESSION['frate']['ffrom'];
					 $frateto=$_SESSION['frate']['fto'];
					 $frateamount=$_SESSION['frate']['amount'];
					 
					if(!empty($frateid)) { 
					 $qry3="SELECT * FROM finvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND s_id = '" . $sid. "' AND ss_id = '" . $ssid. "'";
							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							
							
							$fratelist1=mysql_query("SELECT * FROM frate WHERE fr_id=$frateid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid2=$frate1['fg_id'];	 
								
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT * FROM fsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid2;"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to1=$fsummay['fto'];
									 if($f_to1==12){										 										   
										 $fullpaid++;
									  }		
								 }
								// $fullpaid;
								}
					}
					if($f_to1){
						$fratefrom=$f_to1;
						$frateto1=$fratefrom+$frateto;
						if($frateto1>12){
							$frateto1=12;
						}
						/*if($fratefrom==$frateto1){
							echo '<script language="javascript">';
							echo 'alert("This Category Fees Fully Paid")';
							echo '</script>';
						}*/
						//ftovalue-ffromvalue)/ftyvalue)*feesvalue;
						
						$frateamount1=(($frateto1-$fratefrom)/$frateto)*$frateamount;							
					}else {
							$frateto1=$frateto;
							$frateamount1=$frateamount;							
						}
			
 ?>
				<form id="validate-form" class="block-content form" method="post" action="">
                	<table width="100%">
               			<tr>
                        	<td width="300px">
                            	<p style="margin:5px 10px">
                                    <label for="required">Fees Group Name:</label>
                                     <select name="fgroup" id="fgroup" class="required"  >
                                	<option value="">Select Fees Type</option>
                                    <?php 
									$sql1=mysql_query("SELECT * FROM frate WHERE c_id=$cid AND b_id=$bid AND ay_id=$acyear AND rate='$s_type' ORDER BY fg_id");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$ffgid=$row2['fg_id'];
									$frid=$row2['fr_id'];
									$fgrouplist=mysql_query("SELECT * FROM fgroup WHERE fg_id=$ffgid");
									 $ffgroup=mysql_fetch_array($fgrouplist);
										if($frateid==$frid){?>
                                    <option value="<?php echo $frid;?>" selected="selected"><?php echo $ffgroup['fg_name'];?></option>
                                    <?php } else { ?>
                                     <option value="<?php echo $frid;?>"><?php echo $ffgroup['fg_name'];?></option>
                                     <?php } } ?>
                                    </select>										
								</p> <!-- .field-group -->
                            </td>
                            <td>
                            	<p style="margin:5px 10px">
                                    <label for="required">Fees From:</label>
                                    <?php 
				$montharray=array("June","July","August","September","October","November","December","January","February","March","April","May"); 
				?>	
                                    <select name="ffrom" id="ffrom" class="required" onchange="change_amountfrom()" >
                                    <?php
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
				if($fratefrom==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected" ><?php echo  $montharray[$cmonth-1]?></option>
            <?php } else { ?>
            <option value="<?php echo $cmonth;?>" style="background-color:#D6EDF8" ><?php echo  $montharray[$cmonth-1]?></option>            
            <?php } }?>	
                                    </select>										
								</p> <!-- .field-group -->
                            </td>
                            <td>
                            	<p style="margin:5px 15px">
                                    <label for="required">Fees To:</label>
                                    <select name="fto" id="fto" class="required" onchange="change_amountfrom()" >
                                	<?php
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
				if($frateto1==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected"><?php echo  $montharray[$cmonth-1]?></option>
            <?php } else if(!$frateto && 12==$cmonth) { ?>
                                     <option value="<?php echo $cmonth;?>" selected="selected"><?php echo $montharray[$cmonth-1];?></option>
                                     <?php }else { ?>				
            <option value="<?php echo $cmonth;?>" style="background-color:#D6EDF8" ><?php echo  $montharray[$cmonth-1]?></option>            
            <?php } } ?>	
                                    </select>										
								</p> <!-- .field-group -->                               	
                            </td>
                            <td width="150px">
                            	<p style="margin:5px 15px">
                                    <label for="required">Fees:</label>
                                    <input type="text" name="fees" id="fees" class="biginput" id="autocomplete" class="required" value="<?php echo $frateamount1;?>" />										
								</p> <!-- .field-group -->
                            </td>
                            <td>
                            <input type="hidden" id="fdisid" value="<?php echo $fdisid1;?>" />
                             <input type="hidden" id="ssid" value="<?php echo $ssid;?>" />
                             <input type="hidden" id="ffrom1" value="<?php echo $fratefrom;?>" />
                            <input type="hidden" name="ftyvalue" id="ftyvalue" value="<?php echo $frateto;?>" />
                            <input type="hidden" id="feesvalue" name="feesvalue" value="<?php echo $frateamount;?>" />
                            <button style="margin:15px 0 0 0" type="submit" name="add-fees" class="btn btn-green">Add</button>
                            </td>
                        </tr>
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
<input type="hidden" name="bid" value="<?php echo $bid;?>" />
<input type="hidden" name="command" />
                <?php 
				//$ssid=$_GET['ss_id'];
					$studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student1=mysql_fetch_array($studentlist1);
								  $cid1=$student1['c_id'];
								  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $row=mysql_fetch_array($qry);
								  
								  $sid1=$student1['s_id'];
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_array($qry1);
								  
								  $qry3=mysql_query("SELECT * FROM finvoice_no WHERE id='1'"); 
								  $row3=mysql_fetch_array($qry3);
								  $invoice_no=$row3['count'];
								  
								  $fdisid=$student1['fdis_id'];
								  $qry4=mysql_query("SELECT * FROM fdiscount WHERE fdis_id='$fdisid'"); 
								  $row4=mysql_fetch_array($qry4);
								  $fdisname=$row4['fdis_name'];
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
					<li>Category: <?php echo $fdisname;?> <input type="hidden" class="medium" name="category" value="Aided"/></li>
                    <li>Student Type : <b><?php echo $student1['stype'];?></b> Student <input type="hidden" class="medium" name="stype" value="New"/></li>										
				</ul>
				<ul class="client_details">
					<li>Status: <span class="ticket ticket-info">Open</span></li>
					<li><strong>Invoice Date :</strong> <?php echo date("d/m/Y");?></li>                    
				</ul>				
				<table class="table table-striped" id="table-example">	
                <?php
				$max=count($_SESSION['fees']);
			if(is_array($_SESSION['fees']) && $max>0){ ?>				
					<thead>
						<tr>
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
					$pname=get_product_name($pid); ?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><?php echo $pname;?></td>
							<td><?php //echo $montharray[$q-1];?>
                                    <select name="bffrom<?php echo $pid;?>" id="bffrom<?php echo $pid;?>" class="required" onchange="change_amountfrom<?php echo $pid;?>()" >
                                    <?php
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
				if($q==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected" ><?php echo  $montharray[$cmonth-1]?></option>
            <?php } else { ?>
            <option value="<?php echo $cmonth;?>" style="background-color:#D6EDF8" ><?php echo  $montharray[$cmonth-1]?></option>            
            <?php } }?>	
                                    </select>										
							   </td>
							<td><?php //echo $montharray[$r-1];?>
                                    <select name="bfto<?php echo $pid;?>" id="bfto<?php echo $pid;?>" class="required" onchange="change_amountfrom<?php echo $pid;?>()" >
                                	<?php
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
				if($r==$cmonth){?>
                <option value="<?php echo $cmonth;?>" selected="selected"><?php echo  $montharray[$cmonth-1]?></option>
            <?php } else if(!$r && 12==$cmonth) { ?>
                                     <option value="<?php echo $cmonth;?>" selected="selected"><?php echo $montharray[$cmonth-1];?></option>
                                     <?php }else { ?>				
            <option value="<?php echo $cmonth;?>" style="background-color:#D6EDF8" ><?php echo  $montharray[$cmonth-1]?></option>            
            <?php } } ?>	
                                    </select>										
							</td>
							<td class="total" width="120"><?php $samount=number_format($s,2);?></span>
                                   <input type="text" name="fees<?php echo $pid;?>" id="fees<?php echo $pid;?>" class="biginput" id="autocomplete" class="required" value="<?php echo $s;?>"  readonly/>									
							  </td>
                            <td><a href="javascript:del(<?php echo $pid?>)"><img src="Book_inventory/images/del.png" alt="delete"></a></td>
                             <input type="hidden" id="ffrom_<?php echo $pid;?>" value="<?php echo $q;?>" />
                             <input type="hidden" id="ftyvalue<?php echo $pid;?>" value="<?php echo $u;?>" />
                             <input type="hidden" id="feesvalue<?php echo $pid;?>" value="<?php echo $v;?>" />
                             <input type="hidden" id="tfeesvalue<?php echo $pid;?>" value="<?php echo $w;?>" />
                            </tr>
						<?php $count++;} ?>
						<tr>
							<td class="sub_total" colspan="3"></td>
							<td class="sub_total">Subtotal:</td>
							<td class="sub_total">Rs. <?php echo number_format(get_order_total(),2);?></td>
						</tr>
						<tr class="total_bar">
							<td class="grand_total" colspan="3"></td>
							<td class="grand_total">Total:</td>
							<td class="grand_total">Rs. <?php echo number_format(get_order_total(),2);?><input type="hidden" class="medium" name="total" value="<?php echo get_order_total();?>"/></td>
						</tr>
                        <tr>
							<td colspan="6" align="right">Payment Type:<div class="field-group">		
									<div class="_25">
										<select name="ptype" id="ptype" class="required" >
											<!--<option value="">Please select</option>	-->
                                            <option value="cash">Cash</option>	
                                            <option value="card">Card</option>
                                            <option value="cheque">cheque</option>									
										</select>										
									</div></td>
						</tr>
				<tr>
                <td colspan="6" align="right">
                <input type="button" value="Clear" class="btn  btn-blue" onClick="clear_cart()" style="width:100px">&nbsp;&nbsp;
                <!--<input type="button" value="Update" class="btn  btn-green" onClick="update_cart()" style="width:100px">&nbsp;&nbsp;-->
                <input type="submit" value="Submit" name="place-order" class="btn btn-green" onClick="return confirm('are you sure you wish to Submit this Details');" style="width:100px">&nbsp;&nbsp;
                <input type="button" value="cancel" class="btn btn-red" onClick="cancel_cart()" style="width:100px">
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
			</div>
            </form>
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
  
  
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php if(!$_GET['roll']){ include("auto.php"); }?>
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
	  if(ffromvalue==1){
		  var ftovalue = ftovalue+1;
	  }	  
	   if(((ftovalue-1) < ffromvalue) || (ffromvalue < ffrom1value)) {
      		alert("Please Select valid months");
			location.reload();
			return true;			
					
   		}
	  fees<?php echo $pid;?> = document.getElementById('fees<?php echo $pid;?>');
	  var feesvalue =parseFloat(feesvalue = document.getElementById('feesvalue<?php echo $pid;?>').value);
	  var tfeesvalue =parseFloat(feesvalue = document.getElementById('tfeesvalue<?php echo $pid;?>').value);
	  var ftyvalue = parseFloat(document.getElementById('ftyvalue<?php echo $pid;?>').value);
	  var amount=parseFloat(((ftovalue-ffromvalue)/ftyvalue)*tfeesvalue);
	  //alert(ftovalue+"-"+ffromvalue+"/"+ftyvalue+"*"+tfeesvalue); 
	  fees<?php echo $pid;?>.value = amount.toFixed(2);
	  update_cart();
}
<?php } ?>

</script>

<script type="text/javascript">
$(document).ready(function() {
    function languageChange()
    {
         var lang = $('#fgroup option:selected').val();
        return lang;
    }
    $('#fgroup').change(function(e) { 
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
                    alert(response.message);					
                }
        });
		//location.reload();
		window.location.reload();
        return false;
    });
});
</script>
</body>
</html>
<? ob_flush(); ?>