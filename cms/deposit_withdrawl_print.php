<?php 
include("includes/config.php");
error_reporting(E_ALL ^ E_NOTICE);

session_start();

$check=$_SESSION['email'];

$query=mysql_query("select email from admin_login where email='$check' ");

$data=mysql_fetch_array($query);

$email=$data['email'];
$user=$_SESSION['uname'];

if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}

if(!isset($email))

{
	
header("Location:404.php");

}
						
?>
<?php include 'print_header.php';?>
<script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page     var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
          
        }
    </script>
</head>
<body>
<div style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>

<div id="printablediv"  style="font-size:12.5px; line-height:20px;">
<center>
<img src="img/hallticket.jpg">
</center>
<div id="main-content">        		
			<div class="container_12">
<?php 
$baid=$_GET['baid'];
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
					
				}
				
				
				
				
?>		
 <span style="margin:0px 50px 0 0px;"><img src="img/icons/packs/fugue/16x16/inbox-download.png">Account Cash: <strong>Rs. <button class="btn btn-small btn-success"><?php if($val!="") { echo number_format($val,2); } else { echo "0.00" ; } ?></button></strong> </span>    
 <span style="margin:0px 50px 0 0px;"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Till Date Total : <strong>Rs. <?php echo number_format($final_total,2); ?></strong> </span> 

 <?php if($_GET['startdate']!=""){?>
 
 <span style="margin:0px 50px 0 0px;">Start Date : <strong> <?php echo $_GET['startdate']; ?></strong> </span>
  <span style="margin:0px 50px 0 0px;">End Date : <strong> <?php echo $_GET['enddate']; ?></strong> </span> 
  
 
 <?php } ?>
 
 <?php
if($baid!="")
{
$classl = "SELECT * FROM bank_account where ba_id=$baid";
}
else
{
$classl = "SELECT * FROM bank_account where ba_id='1'";
}
                                            $result1 = mysql_query($classl) or die(mysql_error());
											$value=mysql_fetch_array($result1);
											?>
											
			 <span style="margin:0px 50px 0 0px;">Bank Name: <strong> <?php echo $value['name']; ?></strong> </span>
<?php  ?>
			</div>
			</div>
			<body>
<br>
                       <div class="modal-body"> 
                <table class="table" width="100%" cellpadding="0" cols="0" border="1" style="border-collapse:collapse;"><tr>
                					<th><center>SNo</center></th>
        							<th><center>Date</center></th>
                                    <th><center>Account No</center></th>
                                    <th><center>Bank</center></th>
									<th><center>Cheque No</center></th>
                                    <th><center>Amount</center></th>
                                    <th><center>Deposit by</center></th>
                               		<th><center>Withdrawl by</center></th>
                               		<th><center>Bank balance amount</center></th>
                                    </tr>
                                    <?php $baid=$_GET['baid'];
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
						$qrys=mysql_query("SELECT SUM(amount) FROM bank_deposit WHERE  deposit_date_time < '" . $withdrawl_date_time. "' and ba_id='$baid' ");
						$qryz= mysql_query("SELECT SUM(amount) FROM bank_withdrawl WHERE withdrawl_date_time < '" . $withdrawl_date_time. "' and ba_id='$baid'");
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
						
								</table></body>	
      </div>

</div>
</body>
</html>