<?php 
include("includes/config.php");

session_start();

$check=$_SESSION['email'];
 
//$user=$_SESSION['uname'];

$sacyear=$_SESSION['acyear'];

if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_assoc($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_assoc($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];



if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}

if(!isset($check))

{
	
header("Location:404.php");
}


function convert_number_to_words($number) {
   
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
		/*10000               => 'Ten Thousand',
        100000              => 'One lakh',
		1000000             => 'Ten Lakhs',*/
		1000000             => 'million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );
   
    if (!is_numeric($number)) {
        return false;
    }
   
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
   
    $string = $fraction = null;
   
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
   
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
   
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
   
    return $string;
}

						
					
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SP MODERN  School</title>
<html
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
function hide_button(){
     document.getElementById('print').style.display='none';
     window.print();
     document.body.onmousemove = doneyet;
}
/*function download_doc(ano){
	
	var url = 'http://localhost/Erp_School/'+'admin/download_cert?id='+ano+'&type=bonafide';
	window.open(url,'_blank');
}
function doneyet()
{
  document.getElementById('butt').style.visibility='visible';
}*/
</script>
  <link rel="stylesheet" href="css/tables.css"> <!-- Tables, optional -->
  <!-- end CSS-->
  
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="margin-top:2%;">
<div style="float:right;" id="print"> 
<a onclick="hide_button();"  title="Print this certificate">
<img src="img/printer.png" style="margin-top:-30%; margin-bottom:-20%;"></a></div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
  
<style type="text/css">
  img.adjusted {
    position: absolute;
    z-index: -1;
    width: 100%;
   
  }
  .Invitation {
    position: relative;
    width: 950px;
    margin-top:-360px;
	height:400px;
	margin-left:-960px !important;
  }
  .financetable
  {
	border-collapse:collapse;
	text-align:center;  
  }

/*table{
        border:none;
    }
    tr{
		display:block;
	}
    td, th{
        width: 100px;
    }
	tbody tr.head {
		page-break-before: always;
		page-break-inside: avoid;
	}
	@media screen {
		tbody .head{
			display: none;
		}
	}
  .financetable th, td 
  {
	  padding:5px;
  }*/
</style>
 <style type="text/css">
.table tr{
border:1px #B7B7B7 dotted !important;
}
.table tbody td{
	padding:2px 7px;
}
</style>
<?php
$sdate=$_GET['sdate'];
					$edate=$_GET['edate'];
					
					$sdate_split1= explode('/', $sdate);		 
		  $sdate_month=$sdate_split1[1];
		  $sdate_day=$sdate_split1[0];
		  $sdate_year=$sdate_split1[2];
		  $startdate= $sdate_year.$sdate_month.$sdate_day;
		  $startdate1= $sdate_year."-".$sdate_month."-".$sdate_day;
		 			
					$edate_split1= explode('/', $edate);		 
		  $edate_month=$edate_split1[1];
		  $edate_day=$edate_split1[0];
		  $edate_year=$edate_split1[2];
		  
		  $enddate= $edate_year.$edate_month.$edate_day;
		  $enddate1= $edate_year."-".$edate_month."-".$edate_day;
		  ?>
          <div style="width:235.75mm; margin:0px; height:40.1mm; min-height:40.1mm; border-bottom:2px solid #01a8ff; padding-bottom:20px; display:inline-block;" id="Table_01">
<div style="text-align:left; width:50.00mm; float:left;">
<div><img src="img/christschool_logo.png" width="180px" height="180px"></div>
</div>
<div style="text-align:center;width:185.75mm; float:left; padding-top:10px;">
<h5 style="padding:0px; padding-bottom:3px; margin:0px; letter-spacing:2px; color:red; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:45px; ; font-weight:bold;">CHIRST METRIC HIGHER SECONDARY SCHOOL</h5>
<h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-weight:bold; color:#01a8ff; font-size:18px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">School Affillated by CBSE Board - Affillation NoL 1930580</h5>
<h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-weight:bold; font-size:18px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">1/191 A,, Rajiv Gandhi Nagar, Kundrathur Main Rd, Kovur, Chennai-600128</h5>
<h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-size:16px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Contact : 044 6566 6673, Email : info.md@gmail.com, Web: www.srikrishinternationalschool.com</h5>
</div>
</div>
<div style="max-height:500px;">
<h2 style="line-height:46px; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:30px;">Income & Expense Ledger</h2>		
<span style="margin:0px 50px 10px 0px; float:right;"><img src="img/icons/packs/fugue/16x16/calendar-next.png"> Start Date : <strong> <?php echo$sdate; ?></strong> | <img src="img/icons/packs/fugue/16x16/calendar-previous.png"> End Date : <strong><?php echo $edate; ?></strong> </span>
				<table  class="table financetable" width="100%" border="1" cellpadding="0" cellspacing="0" id="Table_01">
                	<thead>
						<tr>
							<th width="5%">S.No</th>
							<th width="50%"><center>Particular</center></th>
							<th class="total"><center>Expenses</center></th>
							<th class="total"><center>Income</center></th>
                            <th class="total"><center>Assets</center></th>
						</tr>
					</thead>						
					<tbody>
                    <?php 
					$count=1;
					$total=0;
					$indisplay=1;
					$assettotal=0;
			 			/*********************************Other Fees********************************/						
						$qry5=mysql_query("SELECT fgd_id,name FROM fgroup_detail");
						while($row5=mysql_fetch_assoc($qry5))
						{
						    $fgd_id=$row5['fgd_id'];
						    $fg_amount=0;
						    $feeslist2=mysql_query("SELECT SUM(b.amount) as amount FROM finvoice a, fsalessumarry b WHERE (a.fi_year*10000) + (a.fi_month*100) + a.fi_day between '" . $startdate. "' AND '" . $enddate. "' AND a.c_status!='1' AND a.i_status='0' AND a.fi_id=b.fi_id AND b.fgd_id=$fgd_id"); 
							$fees=mysql_fetch_assoc($feeslist2);
						    	$amount=$fees['amount'];
								$fg_amount += $amount;
						    	
						    if($fg_amount!=0){
								$total += $fg_amount;
						        ?>
												<tr>
													<td><?php echo $count;?></td>			
													<td><center><?php echo $row5['name'];?></center></td>
													<td class="total"><center>-</center></td>
													<td class="total"><center>Rs. <?php echo number_format($fg_amount,2);?></center></td>
                                                    <td class="total"><center>-</center></td>
						                        </tr>
						                        <?php $count++; } 
						                        
												 } 
												
						 /************************************************lastyesr Pending Fees ******************************************/
						 $fg_amount=0;
						    $feeslist=mysql_query("SELECT fi_id FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' and c_status!='1' AND i_status='0'");
						    while($fees=mysql_fetch_assoc($feeslist))
						    {
						        $fi_id=$fees['fi_id'];
						        $feesummarry=mysql_query("SELECT amount FROM fsalessumarry WHERE fi_id=$fi_id AND ftype='pending'");
						        while($fsummarry=mysql_fetch_assoc($feesummarry)){
						            $amount=$fsummarry['amount'];
						            $fg_amount += $amount;
						            	
						        }
						    }
						    	
						    if($fg_amount!=0){
								$total += $fg_amount;
						        ?>
												<tr>
													<td><?php echo $count;?></td>			
													<td><b><center>Last Year Pending Fees</center></b></td>
													<td class="total"><center>-</center></td>
													<td class="total"><center>Rs. <?php echo number_format($fg_amount,2);?></center></td>
                                                    <td class="total"><center>-</center></td>
						                        </tr>
						                        <?php $count++; } 
												$etotal=0;
$qry1=mysql_query("SELECT fund_amount FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND funds='1' and c_status!='1' AND i_status='0'");
$sdf_total=0;
while($row1=mysql_fetch_assoc($qry1))
{
    $sdf_tamount=$row1['fund_amount'];
    $sdf_total +=$sdf_tamount;
}
				if($sdf_total){
					$etotal += $sdf_total;?>
                        <tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Student Discount Funds</center></b></td>
							<td class="total"><center>Rs. <?php echo number_format($sdf_total,2);?></center></td>
							<td class="total"><center>-</center></td>
                            <td class="total"><center>-</center></td>
                        </tr>
<?php $count++;  }?>
							<!--<tr>
                            	<td colspan="4" class="sub_total"><center><b>Other Fees</b></center></td>
                            </tr>-->
						<?php $book_amount=0;
					$booklist=mysql_query("SELECT i_total FROM invoice WHERE (i_year*10000) + (i_month*100) + i_day between '" . $startdate. "' AND '" . $enddate. "' and i_status='0'"); 
								  while($book1=mysql_fetch_assoc($booklist))
								  {
									   $bamont=$book1['i_total'];
									   $book_amount += $bamont;
								  }
					if($book_amount!=0){
						$total +=$book_amount;
					?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Book Fees</center></b></td>
							<td class="total"><center>-</center></td>
							<td class="total"><center>Rs. <?php echo number_format($book_amount,2);?></center></td>
                            <td class="total"><center>-</center></td>
                        </tr>
                        <?php $count++; }  						
						
						$bamountthisyear=0;
						$bus_lastyear=0;
					$booklist1=mysql_query("SELECT fi_total,pending FROM bfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND c_status!='1' AND i_status='0'"); 
								  while($bus1=mysql_fetch_assoc($booklist1))
								  {
									   $bamont1=$bus1['fi_total'];
									   $pending1=$bus1['pending'];
									   $bus_amount=$bamont1-$pending1;
									   $bamountthisyear += $bus_amount;
									   $bus_lastyear += $pending1;
								  }
					if($bamountthisyear!=0){
						$total +=$bamountthisyear;
					?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Bus Fees</center></b></td>
							<td class="total"><center>-</center></td>
							<td class="total"><center>Rs. <?php echo number_format($bamountthisyear,2);?></center></td>
                            <td class="total"><center>-</center></td>
                        </tr>
                        <?php $count++; }
						if($bus_lastyear!=0){
						$total +=$bus_lastyear;
					?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Last Year Pending Bus Fees</center></b></td>
							<td class="total"><center>-</center></td>
							<td class="total"><center>Rs. <?php echo number_format($bus_lastyear,2);?></center></td>
                            <td class="total"><center>-</center></td>
                        </tr>
                        <?php $count++; }   
						/*************************************** Loan Payment Income ************************************************/ 
						$loanpay_amount=0;
					$booklist=mysql_query("SELECT amount FROM staff_loan_pay WHERE (year*10000) + (month*100) + day between '" . $startdate. "' AND '" . $enddate. "'"); 
								  while($book1=mysql_fetch_assoc($booklist))
								  {
									   $lamont=$book1['amount'];
									   $loanpay_amount += $lamont;
								  }
					if($loanpay_amount!=0){
						$total +=$loanpay_amount;
					?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Loan Payment</center></b></td>
							<td class="total"><center>-</center></td>
							<td class="total"><center>Rs. <?php echo number_format($loanpay_amount,2);?></center></td>
                            <td class="total"><center>-</center></td>
                        </tr>
                        <?php $count++; }
?>
                        <?php 
						$indisplay=1;
						$classl = mysql_query("SELECT inc_id,in_category FROM in_category");
						while ($row1 = mysql_fetch_assoc($classl)){
							$incid=$row1['inc_id'];
						$in_amount=0;
                        $booklist1=mysql_query("SELECT amount FROM income WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND inc_id=$incid");
                        while($bus1=mysql_fetch_assoc($booklist1))
                        {
                            $bamont1=$bus1['amount'];
                            $in_amount += $bamont1;
                       
                        $total +=$in_amount;
                        }
                        if($in_amount!=0){
								if($indisplay=='1'){
                            ?>
                            <tr>
                        <td></td>
                        <td><b>Income Categories:</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tr>
                        <?php $indisplay=0;} ?>
                            <tr>
                                <td><?php echo $count;?></td>			
                                <td><center><?=$row1['in_category']?></center></td>
                                <td class="total"><center>-</center></td>
                                <td class="total"><center>Rs. <?php echo number_format($in_amount,2);?></center></td>
                                <td class="total"><center>-</center></td>
                            </tr>
                            <?php $count++;  }  }
						?>
<?php  
						$qry6=mysql_query("SELECT exc_id,ex_category,e_category FROM ex_category");
						$excount=1;
						$indisplay=1;
						while($row6=mysql_fetch_assoc($qry6))
        		{
					$e_category=$row6['e_category'];
					$exc_id=$row6['exc_id'];
					$exsqry=mysql_query("SELECT * FROM ex_insubcategory where category='$exc_id'  order by count asc");
							$cont=1;
			  while($exrow=mysql_fetch_assoc($exsqry))
        		{
                  $category_id=$exrow["category"];
				  $exsid=$exrow["exs_id"];
                  $count1=$exrow["count"];
				  $subexname=$exrow["sub_name"];
				  if($count1==0){
				 			 for($j=1;$j<=20;$j++)
                                {
                                $sub_id=$exrow["sub".$j."_id"];
                                
                                if($sub_id!=0){
                                   $field=$j;
                                }
                                }
								$fieldno=$field+1;
								$myarray = array();
								array_push($myarray,$exsid);
								$subname="sub".$fieldno."_id";
								$classlist2=mysql_query("SELECT exs_id FROM ex_insubcategory WHERE $subname='$exsid'");
					    		while($class2=mysql_fetch_assoc($classlist2))
                                {
									//$sub_id=$class1["sub".$j."_id"];
									array_push($myarray,$class2['exs_id']);
								}
					
					$exc_amount=0;
					$feeslist1=mysql_query("SELECT status,amount,pending,advance_amt FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND exc_id=$exc_id  AND  exs_id IN (".implode(',',$myarray).") AND type=0"); 
								  while($fees1=mysql_fetch_assoc($feeslist1))
								  {
									  $type=$fees1['type'];
									  $status=$fees1['status'];
									  $amount1=($fees1['amount']+$fees1['advance_amt']);
									  if($status=='1'){
									  $exc_amount += $amount1;
									  }
								  }
								  //parcial qoutation payment
						$feeslist1=mysql_query("SELECT ex_id,amount FROM exponses_bill_summary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND exc_id=$exc_id"); 
								  while($fees1=mysql_fetch_assoc($feeslist1))
								  {
									  $amount1=$fees1['amount'];
									  $exid=$fees1['ex_id'];
									  $check1=mysql_query("SELECT ex_id FROM exponses WHERE ex_id=$exid AND exc_id=$exc_id  AND  exs_id IN (".implode(',',$myarray).")");
									  $checkcount=mysql_num_rows($check1);
									  if($checkcount>0){
									  $exc_amount += $amount1;
									  }
								  }		
					if($exc_amount!=0){
						if($indisplay=='1'){
                            ?>
                        <tr>
                            <td></td>
                            <td><b>Expence Categories :</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php $indisplay=0;} 
						if($cont=='1'){
                            ?>
                            <tr>
                        <td></td>
                        <td style="padding-left:25px;"><?php echo $excount.". ".$row6['ex_category']?> :</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tr>
                        <?php $cont=0; $excount++;} ?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><center><?php echo $subexname;?></center></td>
							<?php if($e_category=='1'){?>
                                <td class="total"><center>-</center></td>
                                <td class="total"><center>-</center></td>
                                <td class="total"><center>Rs. <?php echo number_format($exc_amount,2);?></center></td>
                            <?php $assettotal += $exc_amount; }else{ ?>
                                <td class="total"><center>Rs. <?php echo number_format($exc_amount,2);?></center></td>
                                <td class="total"><center>-</center></td>
                                <td class="total"><center>-</center></td>
                            <?php $etotal += $exc_amount; } ?>
                        </tr>
                        <?php $count++;  } } } 
						} 
						/**********************************daily Allowance *********************************/
			$d_amount=0;
					$booklist1=mysql_query("SELECT total_amount FROM exp_allowance WHERE (cdate >= '$startdate1' AND cdate <= '$enddate1')"); 
								  while($bus1=mysql_fetch_assoc($booklist1))
								  {
									   $bamont1=$bus1['total_amount'];
									   $d_amount += $bamont1;
								  }
					if($d_amount!=0){
						$etotal +=$d_amount;
					?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Daily Allowance</center></b></td>
							<td class="total"><center>Rs. <?php echo number_format($d_amount,2);?></center></td>
							<td class="total"><center>-</center></td>
                            <td class="total"><center>-</center></td>
                        </tr>
                        <?php $count++; }  
						
					/**********************************Principal Salary *********************************/			
							$sqry=mysql_query("SELECT st_id FROM staff Where prince='1'");
							$srow=mysql_fetch_assoc($sqry);
							$pstid1=$srow['st_id'];
			  			$exc_amount1=0;
						
					$feeslist2=mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND st_id=$pstid1 "); 
								  while($fees2=mysql_fetch_assoc($feeslist2))
								  { 
									  $amount2=$fees2['n_salary'];
									  $exc_amount1 += $amount2;
								  }
							$etotal +=$exc_amount1;
					if($exc_amount1!=0){
					?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Principal Salary</center></b></td>
							<td class="total"><center>Rs. <?php echo number_format($exc_amount1,2);?></center></td>
							<td class="total"><center>-</center></td>
                            <td class="total"><center>-</center></td>
                        </tr>
                     <?php $count++;} 
					 
					 /**********************************Teaching Staff Salary *********************************/		
						$exc_amount1=0;
					$feeslist2=mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND st_id AND st_id!=$pstid1"); 
								  while($fees2=mysql_fetch_assoc($feeslist2))
								  { 
									  $amount2=$fees2['n_salary'];
									  $exc_amount1 += $amount2;
								  }
							$etotal +=$exc_amount1;
					if($exc_amount1!=0){
					?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Teaching Staff Salary</center></b></td>
							<td class="total"><center>Rs. <?php echo number_format($exc_amount1,2);?></center></td>
							<td class="total"><center>-</center></td>
                            <td class="total"><center>-</center></td>
                        </tr>
                     <?php $count++;} 
					 
					 /**********************************Non-Teaching Staff Salary *********************************/		
						$exc_amount1=0;
					$feeslist2=mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND (o_id OR d_id)"); 
								  while($fees2=mysql_fetch_assoc($feeslist2))
								  { 
									  $amount2=$fees2['n_salary'];
									  $exc_amount1 += $amount2;
								  }
							$etotal +=$exc_amount1;
					if($exc_amount1!=0){
					?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Non-Teaching Staff Salary</center></b></td>
							<td class="total"><center>Rs. <?php echo number_format($exc_amount1,2);?></center></td>
							<td class="total"><center>-</center></td>
                            <td class="total"><center>-</center></td>
                        </tr>
                     <?php $count++;}
					 /********************************** Staff Salary Advance  *********************************/		
						$exc_amount1=0;
					$feeslist2=mysql_query("SELECT a_amount FROM staff_advance WHERE (year*10000) + (month*100) + day between '" . $startdate. "' AND '" . $enddate. "' AND status=0"); 
								  while($fees2=mysql_fetch_assoc($feeslist2))
								  { 
									  $amount2=$fees2['a_amount'];
									  $exc_amount1 += $amount2;
								  }
							$etotal +=$exc_amount1;
							if($exc_amount1!=0){
							?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center>Staff Salary Advance </center></b></td>
							<td class="total"><center>Rs. <?php echo number_format($exc_amount1,2);?></center></td>
							<td class="total"><center>-</center></td>
                            <td class="total"><center>-</center></td>
                        </tr>
                     <?php $count++;}
					 /********************************** EPF - ESI Contribution *********************************/	
					 $alldedlist2=mysql_query("SELECT id,name FROM staff_allw_ded WHERE pe_type!=0"); 
								  while($allded2=mysql_fetch_assoc($alldedlist2))
								  { 	
								  $adid=$allded2['id'];
								  $adname=$allded2['name'];
						$exc_amount1=0;
					$feeslist2=mysql_query("SELECT b.pevalue,b.amount FROM staff_month_salary a, staff_month_salary_summary b WHERE (a.year*10000) + (a.month*100) + a.day between '" . $startdate. "' AND '" . $enddate. "' AND a.st_ms_id = b.st_ms_id AND b.ad_id=$adid AND b.pevalue"); 
								  while($fees2=mysql_fetch_assoc($feeslist2))
								  { 
								  	  $staffpreamount=$fees2['amount'];
									  $preamount=$fees2['pevalue'];
									  if($staffpreamount){
									  $exc_amount1 += $staffpreamount+$preamount;
									  }
								  }
							$etotal +=$exc_amount1;
							if($exc_amount1!=0){
							?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><b><center><?php echo  $adname." Contribution";?></center></b></td>
							<td class="total"><center>Rs. <?php echo number_format($exc_amount1,2);?></center></td>
							<td class="total"><center>-</center></td>
                            <td class="total"><center>-</center></td>
                        </tr>
                     <?php $count++;} }
					 ?>
					 <?php
                                        $var="SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' and c_status!='1' AND i_status='0'";
                                        $other=mysql_query("SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' and c_status!='1' AND i_status='0'");

                                        $book=0;
                                        while($all=mysql_fetch_assoc($other)){
                                            //print_r($all);
                                            $book+=$all['fi_total'];
                                        }
                                        ?>
                                        <tr>
                                                    <td><?php echo $count; $count++;?></td>          
                                                    <td><center>Books, Notes, Other Items</center></td>
                                                <td class="total"><center>-</center></td>
                                                <td class="total"><center>Rs. <?php echo number_format($book, 2); ?></center></td>
                                                <td class="total"><center>-</center></td>
                                                </tr>
                        <tr>
							<td class="sub_total" colspan="2"> Total </td>
							<td class="sub_total"><center><?php echo "Rs. ".number_format($etotal,2);?></center></td>
                            <td class="sub_total"><center><?php $total=$total+$book; echo "Rs. ".number_format($total,2);?></center></td>
                            <td class="sub_total"><center><?php echo "Rs. ".number_format($assettotal,2);?></center></td>
						</tr>
						<tr class="total_bar">
							<td class="sub_total" colspan="3"><?php 
							$expencetotal =$etotal+$assettotal;
							$finaltotal =$total-$expencetotal; 
							echo "Income : <b>Rs. ".number_format($total,2)."</b> | Expenses : <b>Rs. ".number_format($expencetotal,2)."</b> ( ".number_format($total,0)." - ( ".number_format($etotal,0)." + ".number_format($assettotal,0)." ))";?></td>
							<td class="grand_total sub_total">Profit Total:</td>
							<td class="grand_total sub_total">Rs. <?php echo number_format($finaltotal,2);?></td>
						</tr>                        
					</tbody>
                  </table>
                  <h3 align="left">Liabilities :</h3>
                <table class="table table-striped" id="table-example">	
                	<thead>
						<tr>
							<th width="5%">S.No</th>
							<th width="50%"><center>Particular</center></th>
							<th class="total"><center>Pending</center></th>
						</tr>
					</thead>						
					<tbody>
                    <?php  
					$count=1;
					$etotal1=0;
						$qry6=mysql_query("SELECT exc_id,ex_category FROM ex_category");
						$excount=1;
						$indisplay=1;
						while($row6=mysql_fetch_array($qry6))
        			{
					$exc_id=$row6['exc_id'];
					$exsqry=mysql_query("SELECT * FROM ex_insubcategory where category='$exc_id' order by count asc");
							$cont=1;
				  while($exrow=mysql_fetch_array($exsqry))
					{
					  $category_id=$exrow["category"];
					  $exsid=$exrow["exs_id"];
					  $count1=$exrow["count"];
					  $subexname=$exrow["sub_name"];
					  if($count1==0){
				 			 for($j=1;$j<=20;$j++)
                                {
                                $sub_id=$exrow["sub".$j."_id"];
                                
                                if($sub_id!=0){
                                   $field=$j;
                                }
                                }
								$fieldno=$field+1;
								$myarray = array();
								array_push($myarray,$exsid);
								$subname="sub".$fieldno."_id";
								$classlist2=mysql_query("SELECT exs_id FROM ex_insubcategory WHERE $subname='$exsid'");
					    		while($class2=mysql_fetch_array($classlist2))
                                {
									//$sub_id=$class1["sub".$j."_id"];
									array_push($myarray,$class2['exs_id']);
								}
					
					$exc_amount=0;
					//$feeslist1=mysql_query("SELECT ex_id,amount FROM exponses WHERE ((date_year*10000) + (date_month*100) + date_day) <= '" . $enddate. "' AND exc_id=$exc_id AND  exs_id IN (".implode(',',$myarray).") AND type='1'"); 
					$feeslist1=mysql_query("SELECT ex_id,amount,advance_amt FROM exponses WHERE ((date_year*10000) + (date_month*100) + date_day) between '" . $startdate. "' AND '" . $enddate. "' AND exc_id=$exc_id AND  exs_id IN (".implode(',',$myarray).") AND type='1'"); 
								  while($fees1=mysql_fetch_array($feeslist1))
								  {
									  $exid=$fees1['ex_id'];
									  $amount1=($fees1['amount']+$fees1['advance_amt']);
									  $amountpaid=0;
									  $pending=0;
									  $bill_summery=mysql_query("SELECT amount FROM exponses_bill_summary WHERE ((date_year*10000) + (date_month*100) + date_day) <= '" . $enddate. "' AND ex_id=$exid AND exc_id=$exc_id"); 
								  while($summery=mysql_fetch_assoc($bill_summery))
								  {
									  $amountpaid +=$summery['amount'];
								  } 
								  //echo $amount1."-".$amountpaid."<br>";
										  $pending=$amount1-$amountpaid;
										  $exc_amount += $pending;
								  }
					if($exc_amount!=0){
						if($cont=='1'){
                            ?>
                            <tr>
                        <td></td>
                        <td style="padding-left:25px;"><b><?php echo $excount.". ".$row6['ex_category']?> :</b></td>
                        <td></td>
                        </tr>
                        <?php $cont=0; $excount++;} ?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><center><?php echo $subexname;?></center></td>
							<td class="total"><center>Rs. <?php echo number_format($exc_amount,2);?></center></td>
                        </tr>
                        <?php $count++;  }
						$etotal1 += $exc_amount; } } 
						} ?>
                        <tr>
							<td class="sub_total" colspan="2"> Total </td>
							<td class="sub_total"><center><?php echo "Rs. ".number_format($etotal1,2);?></center></td>
						</tr>
						<tr class="total_bar">
							<td class="sub_total" colspan="2"><?php $finaltotal1 =$finaltotal-$etotal1; echo "Profit Total : <b>Rs. ".number_format($finaltotal,2)."</b> | Liabilities  : <b>Rs. ".number_format($etotal1,2)."</b> ( ".number_format($finaltotal,0)." - ".number_format($etotal1,0)." )";?></td>
							<td class="grand_total sub_total"><span style="float:left">Profit Total:</span>Rs. <?php echo number_format($finaltotal1,2);?></td>
						</tr> 
                    </tbody>
                   </table>
                  
			</div>
</div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>

</body></html>