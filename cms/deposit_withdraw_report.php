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
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>				
                <li class="no-hover">Bank Deposit & withdrawl Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">        		
			<div class="container_12">		
            <?php 
					$baid=$_GET['baid'];
					if($baid){
							 $classlist=mysql_query("SELECT * FROM bank_account WHERE ba_id=$baid"); 
								  $class=mysql_fetch_array($classlist);
					}
								  ?>
			<div class="grid_12">
				<h1><?php //if($baid){ echo $class['name']."-".$class['account_no'];} else{ echo "All Account";} ?>  Bank Deposit & withdrawl Details</h1>
                <!--<a href="bdeposit_mng_new.php?baid=<?php echo $baid;?>" title="add" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>-->
				<?php 
				$sdate=$_GET['startdate'];
				$edate=$_GET['enddate'];
				
				
				
				$baid=$_GET['baid'];
					$cur_mon=date('n');
					$x=sprintf('%02d',$cur_mon);
					$cur_yr=date('Y');
					
					$startdate1=$_GET['startdate'];
					$startdate1_val=explode('/',$startdate1);
					
					$startdate1_val1=$startdate1_val[0];
					$startdate1_val2=$startdate1_val[1];
					$startdate1_val3=$startdate1_val[2];
					$startdate_exp=$startdate1_val3.$startdate1_val2.$startdate1_val1;
					$enddate1=$_GET['enddate'];
					$enddate1_val=explode('/',$enddate1);
					 
					$enddate1_val1=$enddate1_val[0];
					$enddate1_val2=$enddate1_val[1];
					$enddate1_val3=$enddate1_val[2];
					$enddate1_exp=$enddate1_val3.$enddate1_val2.$enddate1_val1;
					
					if($startdate!="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE  (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  ORDER BY withdrawl_date_time ASC";
					}
					if($baid!="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE ba_id='$baid' and date_month='$cur_mon' and date_year='$cur_yr' union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit where ba_id='$baid' and date_month='$cur_mon' and date_year='$cur_yr' ORDER BY withdrawl_date_time ASC";
					}
					if($startdate1!="" && $baid!="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE ba_id='$baid' and (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit WHERE ba_id='$baid' and (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  ORDER BY withdrawl_date_time ASC";
					}
					//$qry1 ="select * from bank_withdrawl union all select -1 * from bank_deposit order by date";
					if($startdate1=="" && $baid=="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl where date_month='$cur_mon' and date_year='$cur_yr' and ba_id='1' union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit where date_month='$cur_mon' and date_year='$cur_yr' and ba_id='1' ORDER BY withdrawl_date_time ASC";
					}
					if($startdate1=="" && $baid!="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl where ba_id='$baid' and date_month='$cur_mon' and date_year='$cur_yr' union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit where ba_id='$baid' and date_month='$cur_mon' and date_year='$cur_yr' ORDER BY withdrawl_date_time ASC";
					}
					if($startdate1!="" && $baid=="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  ORDER BY withdrawl_date_time ASC";
					}
					
							
							
							$qry=mysql_query($qry1);
					
							$count=1;
							$i=1;
						//print_r(mysql_fetch_array($qry));die;
			    while($row=mysql_fetch_array($qry))
        		{
					//echo "sdfsdfs";die;
					// $bc_id=$row['bc_id'];
					 $date=$row['date'];
					 $withdrawl_date_time=$row['withdrawl_date_time'];
					 $val=explode('/',$date);
					 //print_r($val);
					$val1=$val[0];
					$val2=$val[1];
					$val3=$val[2];
					$startdate=$val3.'-'.$val2.'-'.$val1;
						//echo "SELECT SUM(amount) FROM bank_withdrawl WHERE withdrawl_date_time < '" . $withdrawl_date_time. "'";die;
						//echo "SELECT * FROM bank_withdrawl WHERE (date_year*10000) + (date_month*100) + date_day < '" . $startdate. "'";
						
					
					//echo "SELECT SUM(amount) FROM bank_withdrawl WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'";die;
						/* if($startdate1!=""){
						$qrys=mysql_query("SELECT SUM(amount) FROM bank_deposit WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'");
						$qryz= mysql_query("SELECT SUM(amount) FROM bank_withdrawl WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'");
						}
						else{ */
							if($baid==""){
						$qrys=mysql_query("SELECT SUM(amount) FROM bank_deposit WHERE  deposit_date_time < '" . $withdrawl_date_time. "' and  ba_id='1'");
						$qryz= mysql_query("SELECT SUM(amount) FROM bank_withdrawl WHERE withdrawl_date_time < '" . $withdrawl_date_time. "' and  ba_id='1'");
							}
							else
							{
								$qrys=mysql_query("SELECT SUM(amount) FROM bank_deposit WHERE  deposit_date_time < '" . $withdrawl_date_time. "' and ba_id='$baid' ");
						$qryz= mysql_query("SELECT SUM(amount) FROM bank_withdrawl WHERE withdrawl_date_time < '" . $withdrawl_date_time. "' and ba_id='$baid'");
							}
						//}
						$value1=mysql_fetch_array($qrys);
					$value2=mysql_fetch_array($qryz);
					//print_r($value1);
					//print_r($value2);
					/* if($value1[0] > $value2[0]){
						
					$tot=$value1[0]-$value2[0];
					}
					else
					{
						$tot=$value2[0]-$value1[0];
					} */
					$tot=$value1[0]-$value2[0];
					//echo $tot;die;
					if($row['withdrawl_by']=="")
					{
						 $val=$tot+$row['amount'];
					}
					
					else
					{
						 $val=$tot-$row['amount'];
					}
					
				}
				
				
				
				
				
				
				//if($sdate==""){
				?>
				 <!--<a href="export_deposit_withdrawl_report.php" title="Download" style="margin-left:10px;">-->
				 <a href="export_deposit_withdrawl_report.php?startdate=<?php if($sdate!="") { echo $sdate; }?>&enddate=<?php if($edate!="") { echo $edate; } ?>&baid=<?php if($_GET['baid']!=""){ echo $_GET['baid'];}?>&acc_value=<?php echo $val;?>" title="Download" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Download Excel</button></a>
				 
				 <a href="deposit_withdrawl_print.php?startdate=<?php if($sdate!="") { echo $sdate; }?>&enddate=<?php if($edate!="") { echo $edate; } ?>&baid=<?php if($_GET['baid']!=""){ echo $_GET['baid'];}?>" title="add" style="margin:0px 0 0 10px;" target="_blank"><button class="btn btn-orange btn-small ">Print</button></a>
				
				
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php }
				 
				 			$qry1 ="SELECT * FROM bank_deposit";
							if($baid){
							$qry1 .=" WHERE ba_id=$baid";
							}	
							else{
							$qry1 .=" WHERE ba_id='1'";
							}							
								
							$qry1=mysql_query($qry1);
							$total=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$tamount=$row1['amount'];
					$total +=$tamount;					
				}
				
				$qry2 ="SELECT * FROM bank_withdrawl";
							if($baid){
							$qry2 .=" WHERE ba_id=$baid";
							}
else{
	$qry2 .=" WHERE ba_id='1'";
}							
							$qry2 .=" ORDER BY bc_id DESC";			
							$qry=mysql_query($qry2);
							$withdrawlamount_total=0;
			  while($row=mysql_fetch_array($qry))
        		{
					$withdrawlamount=$row['amount'];
					$withdrawlamount_total +=$withdrawlamount;					
				}
				
				/* if($total>$withdrawlamount_total)
				{
				 $final_total=$total-$withdrawlamount_total;
				}
				else
				{
				 $final_total=$withdrawlamount_total-$total;
				} */
				$final_total=$total-$withdrawlamount_total;
				 //$final_total.' '.$total.' '.$withdrawlamount_total;
				if($_GET['startdate']!="")
				{
					$sdate=$_GET['startdate'];
					$exp_date=explode('/',$sdate);
					$ex_dat=$exp_date[0];
					$ex_mon=$exp_date[1];
					$ex_yr=$exp_date[2];
					$ss_date=$ex_yr.$ex_mon.$ex_dat;
					$edate=$_GET['enddate'];
					$en_date=explode('/',$edate);
					$en_dat=$en_date[0];
					$en_mon=$en_date[1];
					$en_yr=$en_date[2];
					$enn_dates=$en_yr.$en_mon.$en_dat;
				
				$cur_mon=date('n');
				$x=sprintf('%02d',$cur_mon);
				$cur_yr=date('Y');
				
				//$qry1 ="SELECT * FROM bank_deposit Where date";
				$dep_qry ="select * from bank_deposit WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $ss_date. "' AND '" . $enn_dates. "'";
				
							if($baid){
							$dep_qry .=" AND ba_id=$baid";
							}	
							else{
							$dep_qry .=" AND ba_id='1'";
							}							
							//echo $dep_qry;
							$dep_qry1=mysql_query($dep_qry);
							$total=0;
			  while($dep_row1=mysql_fetch_array($dep_qry1))
        		{
					$tamount=$dep_row1['amount'];
					$total1 +=$tamount;					
				}
				
				//$qry2 ="SELECT * FROM bank_withdrawl";
				$withdr_qry2 ="select * from bank_withdrawl WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $ss_date. "' AND '" . $enn_dates. "'";
							if($baid){
							$withdr_qry2 .=" AND ba_id=$baid";
							}
							else{
							$withdr_qry2 .=" AND ba_id='1'";
							}
						
							$withdr_qry2 .=" ORDER BY bc_id DESC";	
							//echo $withdr_qry2;die;
							$withdr_qry=mysql_query($withdr_qry2);
							$withdrawlamount_total=0;
			  while($withdr_row=mysql_fetch_array($withdr_qry))
        		{
					$withdrawlamount1=$withdr_row['amount'];
					$withdrawlamount_total1 +=$withdrawlamount1;					
				}
				
				$final_total1=$total1-$withdrawlamount_total1;
				}
				
				?> 
                <!--<div class="_25" style="float:right">
                <label for="select">Account Detail :</label>
                                	<?php
                                            $classl = "SELECT * FROM bank_account";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="baid" id="baid" class="required" onchange="change_function()">';
											echo "<option value='' selected>All</option>\n";
											while ($row1 = mysql_fetch_assoc($result1)):
												if($baid ==$row1['ba_id']){
                                                echo "<option value='{$row1['ba_id']}' selected>{$row1['name']} - {$row1['account_no']}</option>\n";
												} else {
												echo "<option value='{$row1['ba_id']}'>{$row1['name']} - {$row1['account_no']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div> -->
				 
				 
				<span style="margin:0px 50px 0 50px;"><img src="img/icons/packs/fugue/16x16/inbox-download.png">Till Date Total: <strong>Rs. <?php echo number_format($final_total,2); ?></strong> </span>
                
				
                 <span style="margin:0px 50px 0 0px;"><img src="img/icons/packs/fugue/16x16/inbox-download.png">Account Cash: <strong>Rs. <button class="btn btn-small btn-success"><?php if($val!="") { echo number_format($val,2); } else { echo "0.00" ; } ?></button></strong> </span>  

      				 
			</div>
			 <div class="_25" style="margin-top:5px;">
                <label for="select">Account Detail :</label>
                                	<?php
                                            $classl = "SELECT * FROM bank_account";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="baid" id="baid" class="required" onchange="change_function()">';
											//echo "<option value='' selected>All</option>\n";
											while ($row1 = mysql_fetch_assoc($result1)):
												if($baid ==$row1['ba_id']){
                                                echo "<option value='{$row1['ba_id']}' selected>{$row1['name']} - {$row1['account_no']}</option>\n";
												} else {
												echo "<option value='{$row1['ba_id']}'>{$row1['name']} - {$row1['account_no']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
				 <div class="grid_8" style="margin-top:15px;">
				 <span style="margin:0px 50px 10px 0px; float:right;"><img src="img/icons/packs/fugue/16x16/calendar-next.png"> Start Date :  <input id="datepicker1" name="datepicker1" type="text" value="<?php echo $_GET['startdate'];?>" /> End Date : <input id="datepicker2" name="datepicker2" type="text" value="<?php echo $_GET['enddate'];?>" /> <button name="submit" id="submit"  onclick="date_wise_records();" class="btn btn-small btn-success" style="
    margin-left: 18px;">Search</button></span> 
				 </div>
            <div class="grid_12">
            	<div class="block-border">
					<div class="block-header">
                    	<h1><?php  //if($baid){ echo $class['name']."-".$class['account_no'];} else{ echo "All Account";} ?> Bank Deposit & withdrawl Details</h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Date</center></th>
                                    <th><center>account No</center></th>
                                    <th><center>Bank</center></th>
                                    <th><center>Cheque No</center></th>
                                    <th><center>Amount</center></th>
                                    <th><center>Deposited By</center></th>
                                    <th><center>Withdrawl By</center></th>
                                    <th><center>Bank Balance Amount</center></th>                                    
                                    <!--<th>Action</th>-->
								</tr>
							</thead>
							<tbody>
                    <?php 
					$baid=$_GET['baid'];
					$cur_mon=date('n');
					$x=sprintf('%02d',$cur_mon);
					$cur_yr=date('Y');
					
					$startdate1=$_GET['startdate'];
					$startdate1_val=explode('/',$startdate1);
					
					$startdate1_val1=$startdate1_val[0];
					$startdate1_val2=$startdate1_val[1];
					$startdate1_val3=$startdate1_val[2];
					$startdate_exp=$startdate1_val3.$startdate1_val2.$startdate1_val1;
					$enddate1=$_GET['enddate'];
					$enddate1_val=explode('/',$enddate1);
					 
					$enddate1_val1=$enddate1_val[0];
					$enddate1_val2=$enddate1_val[1];
					$enddate1_val3=$enddate1_val[2];
					$enddate1_exp=$enddate1_val3.$enddate1_val2.$enddate1_val1;
					
					if($startdate!="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE  (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  ORDER BY withdrawl_date_time ASC";
					}
					if($baid!="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE ba_id='$baid' and date_month='$cur_mon' and date_year='$cur_yr' union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit where ba_id='$baid' and date_month='$cur_mon' and date_year='$cur_yr' ORDER BY withdrawl_date_time ASC";
					}
					if($startdate1!="" && $baid!="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE ba_id='$baid' and (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit WHERE ba_id='$baid' and (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  ORDER BY withdrawl_date_time ASC";
					}
					//$qry1 ="select * from bank_withdrawl union all select -1 * from bank_deposit order by date";
					if($startdate1=="" && $baid=="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl where date_month='$cur_mon' and date_year='$cur_yr' and ba_id='1' union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit where date_month='$cur_mon' and date_year='$cur_yr' and ba_id='1' ORDER BY withdrawl_date_time ASC";
					}
					if($startdate1=="" && $baid!="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl where ba_id='$baid' and date_month='$cur_mon' and date_year='$cur_yr' union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit where ba_id='$baid' and date_month='$cur_mon' and date_year='$cur_yr' ORDER BY withdrawl_date_time ASC";
					}
					if($startdate1!="" && $baid=="")
					{
					$qry1 ="select date,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,Null,date_day,date_month,date_year,withdrawl_date_time from bank_withdrawl WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  union all select date,account_no,b_name,Null,amount,ba_id,ay_id,type,Null,deposit_by,date_day,date_month,date_year,deposit_date_time from bank_deposit WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'  ORDER BY withdrawl_date_time ASC";
					}
					
							
							
							$qry=mysql_query($qry1);
					
							$count=1;
							$i=1;
						//print_r(mysql_fetch_array($qry));die;
			    while($row=mysql_fetch_array($qry))
        		{
					//echo "sdfsdfs";die;
					// $bc_id=$row['bc_id'];
					 $date=$row['date'];
					 $withdrawl_date_time=$row['withdrawl_date_time'];
					 $val=explode('/',$date);
					 //print_r($val);
					$val1=$val[0];
					$val2=$val[1];
					$val3=$val[2];
					$startdate=$val3.'-'.$val2.'-'.$val1;
						//echo "SELECT SUM(amount) FROM bank_withdrawl WHERE withdrawl_date_time < '" . $withdrawl_date_time. "'";die;
						//echo "SELECT * FROM bank_withdrawl WHERE (date_year*10000) + (date_month*100) + date_day < '" . $startdate. "'";
						
					
					//echo "SELECT SUM(amount) FROM bank_withdrawl WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'";die;
						/* if($startdate1!=""){
						$qrys=mysql_query("SELECT SUM(amount) FROM bank_deposit WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'");
						$qryz= mysql_query("SELECT SUM(amount) FROM bank_withdrawl WHERE (date_year*10000) + (date_month*100) +  date_day between'" . $startdate_exp. "' AND '" . $enddate1_exp. "'");
						}
						else{ */
							if($baid==""){
						$qrys=mysql_query("SELECT SUM(amount) FROM bank_deposit WHERE  deposit_date_time < '" . $withdrawl_date_time. "' ");
						$qryz= mysql_query("SELECT SUM(amount) FROM bank_withdrawl WHERE withdrawl_date_time < '" . $withdrawl_date_time. "'");
							}
							else
							{
								$qrys=mysql_query("SELECT SUM(amount) FROM bank_deposit WHERE  deposit_date_time < '" . $withdrawl_date_time. "' and ba_id='$baid' ");
						$qryz= mysql_query("SELECT SUM(amount) FROM bank_withdrawl WHERE withdrawl_date_time < '" . $withdrawl_date_time. "' and ba_id='$baid'");
							}
						//}
						$value1=mysql_fetch_array($qrys);
					$value2=mysql_fetch_array($qryz);
					//print_r($value1);
					//print_r($value2);
					/* if($value1[0] > $value2[0]){
						
					$tot=$value1[0]-$value2[0];
					}
					else
					{
						$tot=$value2[0]-$value1[0];
					} */
					$tot=$value1[0]-$value2[0];
					//echo $tot;die;
					if($row['withdrawl_by']=="")
					{
						 $val=$tot+$row['amount'];
					}
					
					else
					{
						 $val=$tot-$row['amount'];
					}
					
					
					$baid1=$row['ba_id'];
					
					
								  ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $i; ?></center></td>
                                <td><center><?php echo $row['date']; ?></center></td>
                                <td><center><?php echo $row['account_no']; ?></center></td>
                                <td><center><?php echo $row['b_name']; ?></center></td>
                                <td><center><?php if($row['cheque_no']!=""){ echo $row['cheque_no'];} ?></center></td>
								 <td><center><?php echo $row['amount']; ?></center></td>
                                <td><center><?php if($row['NULL']!="") { echo $row['NULL'];}?></center></td>
                                <td><center><?php if($row['withdrawl_by']!=""){ echo $row['withdrawl_by'];} ?></center></td>
                                <td><center>Rs. <?php echo number_format($val); ?></center></td></tr>
							<?php 
							$i++;
							}
							
							?>     
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
  <script defer src="js/zebra_datepicker.js"></script>
  
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
			$( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
	$( "#datepicker2" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });	
	});
	 function change_function() { 
	 var startdate=document.getElementById('datepicker1').value;
	 var enddate=document.getElementById('datepicker2').value;
     var cid =document.getElementById('baid').value;
	 window.location.href = 'deposit_withdraw_report.php?startdate='+startdate+'&enddate='+enddate+'&baid='+cid;	  
	} 
	
	
	function date_wise_records()
	{
		var startdate=document.getElementById('datepicker1').value;
	    var enddate=document.getElementById('datepicker2').value;
	    var baid=document.getElementById('baid').value;
		
		window.location.href='deposit_withdraw_report.php?startdate='+startdate+"&enddate="+enddate+"&baid="+baid;
	}
	
		
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>