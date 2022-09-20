<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("includes/config.php");

session_start();

$check=$_SESSION['email'];

$query=mysql_query("select email,id from admin_login where email='$check' ");

$data=mysql_fetch_array($query);

$email=$data['email'];
$adminid=$data['id'];
$user=$_SESSION['uname'];

$sacyear=$_SESSION['acyear'];

if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
    $ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);
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

                    $did=$_GET['did'];  
                    //$prt_type=$_GET['bid'];                           
                        $invoicelist1=mysql_query("SELECT * FROM discount WHERE d_id=$did"); 
                                  $invoice=mysql_fetch_array($invoicelist1);
                                    
                                    $ssid=$invoice['ss_id'];
                                    $bid=$invoice['bid'];
                                  $studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
                                  $student1=mysql_fetch_array($studentlist1);
                                  $fdisid1=$student1['fdis_id'];
                                  
                                  $stype=$student1['stype'];
                                  
                                  $cid1=$invoice['c_id'];
                                  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
                                  $row=mysql_fetch_array($qry);
                                  
                                  $sid1=$student1['s_id'];
                                  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
                                  $row1=mysql_fetch_array($qry1);   
                                  
                                  if(($row['c_name']=="XI STD") || ($row['c_name']=="XII STD") || ($row['c_name']=="XI") || ($row['c_name']=="XII")) {
                                     $sid21 = $sid1;
                                  }else {
                                      $sid21 = "0";
                                  }     
                                  
                                  $showno=$_GET['show'];    
                                  if(!$showno){
                                      $showno=1;
                                  } 
                    
?>
<?php include 'print_header.php'; ?>
<!--<link rel="stylesheet" href="css/print.css"> -->
<style type="text/css">
    /*.profile-table td{
             border:1px solid #2D2D2D;
             padding-left:10px;
    }
    .small{font-size:10px;}
    .bgcolor{background-color:#D0D0D0;}
    .column {
    float: left;
        margin: 20px;
        
        padding-bottom: 1000px;
        margin-bottom: -1000px;
    }*/
</style>    
</head>
<script>
function hide_button(){
     document.getElementById('print').style.display='none';
     window.print();
     document.body.onmousemove = doneyet;
}
</script>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style=" font-family:Verdana !important; font-size:14px !important; font-weight:bold;">
<center>
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
<!--<div  id="print" style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>-->
    <div id="printablediv" style="width: 105mm;padding-top: 65px;">
	
	<style type="text/css">
   *{font-family: 'Open Sans', sans-serif;font-size:12px !important;color:#000 !important;  }
   .header p{font-size:10px !important;margin:0; }
   header { margin-bottom: 0px; border-bottom:0;}
   table{ width:100%;}
   .main-table table{ width:100%;}
   .main-table th{border-top:1px solid #000 !important;border-bottom:1px solid #000 !important;}
   .main-table tfoot td{border-top:1px solid #000 !important;border-bottom:1px solid #000 !important;}     
</style> 
 
<style type="text/css">
  img.adjusted {
    position: absolute;
    z-index: -1;
    width: 100%;
   
  }
  .Invitation {
    position: relative;
    width: 766px;
    /*margin-top:-362px;*/
  height:100px;
  margin-left:-960px !important;
   
  }
  .block-content-invoice1{
    width:750px;
    float:left;
    /*margin:30px*/
    border-radius: 3px;
    position: absolute;
    padding: 10px;
    top:-10px;
    }
  .table tbody th, .table tbody td, .table tfoot th, .table tfoot td{
    border:none;
  }
  .table tbody td{ background:none; }
  .total{ float:right; margin-right:50px;}
    .main-table td:nth-child(2){
        border-left: 1px solid #000;
        border-right: 1px solid #000;
    }
    .main-table th:nth-child(2){
        border-left: 1px solid #000;
        border-right: 1px solid #000;
    }
    .main-table td{
        padding-top: 5px;
    }
</style>

        <header class="header">
          <center> 
          <!-- 
          <img src="img/letterpad.png" title="letterpad" width="100%" />
          -->
          <span style="font-size: 15px !important;">

SCHOOL/COLLEGE MANAGEMENT SYSTEM
</span><br>
          <span>Cinthamani,
Puliangudi</span><br>
                     
          </center>   
        </header>
		
        <main>
		<br>
            <div id="" class="clearfix" style="display: inline-block; width: 100%;">
                <div style="float:left; width: 55%;">
                    <div class="to" style="float:left;">TO:&nbsp;</div>
					<div style="display: inline-block;">
                    <div class="name"><?php echo $student1['firstname']." ".$student1['lastname']."(".$student1['admission_number'].")"; ?></div>
                    <div class="address"><?= nl2br($student1["address1"]); ?></div></div>
                </div>
                <div id="" style="float:right;">
                    <div class="">Date of Bill: <?php echo $invoice['day']."/".$invoice['month']."/".$invoice['year']; ?></div>
                </div>
            </div>
			
			<div class="main-table">
			<br>		
			   <table style="text-align:center; border-collapse:collapse;">
   			     <thead>
				   <th style="border-left:0 !important;border-right:0 !important;">S.No</th>
				   <th style="border-left:0 !important;border-right:0 !important;">Discount Applied</th>
				   <th style="border-right:0 !important;">Amount</th>
			     </thead>
			     <tbody>
                 <tr>
                 <td style="border-bottom:0 !important;border-left:0 !important;border-left:0 !important;border-right:0 !important;">1</td>
                 <td style="border-bottom:0 !important;border-left:0 !important;">Total Fees</td>
                 <td style="border-right:0 !important;border-right:0 !important;"><?php
                     $wamt=mysql_query("select sum(rate) as wtot from frate where ay_id='$acyear' AND c_id='$cid1' and s_id='$sid21'");
                            $totamt=mysql_fetch_assoc($wamt)['wtot'];
                    ?>
                    <?php echo number_format($totamt,2);?>
                 </td>
                 </tr>		   
				   <tr>
				    <td style="border-bottom:0 !important;border-left:0 !important;border-left:0 !important;border-right:0 !important;">2</td>
					<td style="border-bottom:0 !important;border-left:0 !important;"><?php
                        if($invoice['remark']!="")
                              $reson=' for '.$invoice['remark'];
                        $percent=($invoice['total']/$totamt)*100;
                        echo 'Fees Concession Rs '.$invoice['total'].'( '.round($percent,2).'% )'.$reson;?></td>					
					<td style="border-right:0 !important;border-right:0 !important;"><?php echo '-'.number_format($invoice['total'],2);?></td>
				   </tr>
			     </tbody>
                 <?php
                    $tr=5;
                 for($i=0;$i<=$tr;$i++) {?>
                 <tr>
                     <td colspan="2" style="">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                     <!--<td style=""></td>-->
                     <td style="border-right:0 !important;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                     <!--<td style="border-right:0 !important;"></td>-->
                    </tr>

                 <?php }    ?>
				 <tfoot>
				    <tr>
				     <td style="border-top:0 !important;border-left:0 !important;"></td>
				     <td style="border-top:0 !important;border-left:0 !important;"><b>Total</b></td>				     
				     <td style="border-right:0 !important;"><?php echo number_format($totamt-$invoice['total'],2);?></td>
				    </tr>
				 </tfoot>
			   </table>
                
            </div>
			
			
            <!--<div class="exponsive">
                <div class="no">S.No</div>
                <div class="desc" style="width: 75%;">Discount Applied</div>
                <div class="rno">Amount</div>
                                         
            </div>
			<div class="exponsive">
				<div class="no">1</div>
				<div class="desc" style="width: 75%;"><?= $invoice['remark'] ?></div>
				<div class="rno"><?php echo number_format($invoice['total'],2);?></div>
				
			</div>
            <div class="exponsive">
                <div class="no" style="background:none;">&nbsp; </div>
                <div class="desc" style="background:none;">&nbsp; </div>
                <div class="rno" style="background:none;">&nbsp; </div>
                <div class="pay" style="background:none;">&nbsp; </div>
                <div class="qty" style="background:none;">&nbsp; </div>
                <div class="unit" style="background:none; width:13.5%;">Sub Total</div>
                <div class="total" style="background:none; color:black;text-align: right;" ><?php echo number_format($invoice['total'],2);?></div>
            </div>-->

           <br>
		   
            <div id=""><center>Thank you!</center></div>
			<br>
            <div id="loginuser" style="text-align:left;">
                <h2> Bill Generated By<br><br> <?php echo $user; ?></h2>
            </div>
			<br>
			<div id="receiver" style="float:left;text-align:left;"> <h3 style="font-size:20px;" ></h3>
				<h2>Receiver Parent / Guardian Signature<br><br> <?php echo $row1['receiver']; ?></h2>
			</div>
			<div id="chairman" style="float:right;text-align:right;"><h1> Correspondent Signature</h1></div>
			<!--<div id="notices">
			  <div>NOTICE:</div>
			  <div class="notice">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</div>
			  <div class="notice">netus et malesuada fames ac turpis egestas.</div>
			</div>-->
            
        </main>

        <!--<footer>
            1/191 A,, Rajiv Gandhi Nagar, Kundrathur Main Rd, Kovur, Chennai-600128. Phone No : 044 6566 6673.
        </footer>-->
    </div>
    </center>
</body>

<!--
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page     var oldPage = document.body.innerHTML;
        //Reset the page's HTML with div's HTML only
        //document.body.innerHTML ="<html><head><title></title></head><body>" + divElements + "</body>";
        //Print Page
        window.print();
        //$('#print').hide();
        //Restore orignal HTML
        document.body.innerHTML = oldPage;
    }
</script>
<style>
    .exponsive
    {
        width:210mm !important;
        height:40px !important; 
    }
    .exponsive .no, .desc, .rno, .pay, .qty , .unit, .total
    {
        padding:10px 0px;
    }
    .exponsive .no{
        color: #FFFFFF;
        width:26.25mm;
        font-size: 0.9em;
        background: #2376B2;
        float: left;
        text-align: center; 
    }

    .exponsive .desc {
        text-align: left;
        float:left;
        background: #EEEEEE;    
        text-align: center; 
        width:26.25mm;
    }
    .exponsive .rno
    {
        width:26.25mm;
    }
    .exponsive .pay
    {
        width:26.25mm;
    }
    .exponsive .qty
    {
        width:35mm;
    }
    .exponsive .unit
    {
        width:35mm;
    }
    .exponsive .total
    {
        width:35mm;
    }
    .exponsive .rno, .exponsive .pay, .exponsive .qty{
        background: #EEEEEE;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;
        float:left;
    }
    .exponsive .unit {
        background: #DDDDDD;
        float:left;
        text-align: center;
    }
    .exponsive .total {
        background: #2376B2;
        color: #FFFFFF;
        float:left;
        text-align: center;
    }
    .total_bar
    {
        height:10mm;
    }
    .total_bar1
    {
        width:135mm; float:left; margin-left:8px; padding:10px 0px; color:#2376B2;
    }
    .total_bar2
    {
        width:35mm; float:left; padding:10px 0px; color:#2376B2;
    }
    .total_bar3
    {
        width:35mm; float:left; padding:10px 0px; color:#2376B2; text-align:right;
    }

</style>-->
</html>