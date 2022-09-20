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

					$ffi_id=$_GET['fiid'];	
					$prt_type=$_GET['type'];							
						$invoicelist1=mysql_query("SELECT * FROM finvoice_others WHERE fi_id=$ffi_id"); 
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
								  
								  $sid1=$invoice['s_id'];
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_array($qry1);	
								  
								  if(($row['c_name']=="XI STD") || ($row['c_name']=="XII STD") || ($row['c_name']=="XI") || ($row['c_name']=="XII")){
									 $sid21 = $sid1;
								  }else {
									  $sid21 = "0";
								  }		
								  
								  $showno=$_GET['show'];	
								  if(!$showno){
									  $showno=1;
								  }	
					
?>
<?php include 'print_header.php';?>
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
<link rel="stylesheet" href="css/style.css"> <!-- Generic style (Boilerplate) -->
  <link rel="stylesheet" href="css/960.fluid.css"> <!-- 960.gs Grid System -->
  <link rel="stylesheet" href="css/lists.css"> <!-- Lists, optional -->
  <link rel="stylesheet" href="css/forms.css"> <!-- Forms, optional -->
  <link rel="stylesheet" href="css/tables.css"> <!-- Tables, optional -->
  <!-- end CSS-->
  
  <!-- Fonts -->
  <link href="//fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style=" font-family:Verdana !important; font-size:14px !important; font-weight:bold;">
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a></div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
  
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
</style>
 						<div id="invoice1" class="widget widget-plain">	
						<div class="block-content-invoice1">
                        <p><span style="position:absolute; left:100px"><?php echo $student1['firstname']." ".$student1['lastname']."(".$student1['admission_number'].")";?></span><span style="position:absolute; left:690px"> <?php echo $invoice['fr_no'];?></span></p><br>
                        <p><span style="position:absolute; left:100px"><?php echo $row['c_name']."-".$row1['s_name'];?></span><span style="position:absolute; left:690px"> <?php echo $invoice['fi_day']."/".$invoice['fi_month']."/".$invoice['fi_year'];?></span></p>
                        
				<table class="table table-striped" id="table-example"cellpadding="0" cellspacing="0" style="clear:none;text-align:left; width:100%; margin-top:40px;">	
                	<tbody>
                    <?php 
					$count=1;
					$myarray = array();
					$montharray=array("June","July","August","September","October","November","December","January","February","March","April","May"); 

				?>
                    	<tr>
							<td colspan="5"><center><?php echo 'Books, Notes & Other Items';
                            if($invoice['discount']!=0)
                            echo '<br>Discount Applied Rs '.$invoice['discount'].' for '.$invoice['discount_remark']?></center></td>
                            
							<td class="total"><?php echo number_format($invoice['fi_total'],2);?></td>
                        </tr>
                        <?php if($invoice['cheque_service']!=0) { ?>
                        <tr>
                            <td colspan="5"><center><?php echo 'Cheque Bounce Charges';?></center></td>
                            <td class="total"><?php echo number_format($invoice['cheque_service'],2);?></td>
                        </tr>
                        <?php } ?>
                    	<tr>
							<td colspan="6"></td>
                        </tr>
                    	<tr class="total_bar">
							<td class="grand_total1" colspan="4" width="220px" style=" font-size:11px !important;"><center>
 <?php $amount=number_format($invoice['fi_total'],2);
						if(floor($amount)==$amount){
							$amount1=floor($amount);
							 echo convert_number_to_words($invoice['fi_total']);
						}else{
						 echo convert_number_to_words($amount); }?> Rupees Only
</center></td>
							<td class="grand_total1" width="120px" style=" text-align:right">Total:</td>
							<td class="grand_total1 total">Rs. <?php echo number_format($invoice['fi_total']+$invoice['cheque_service'],2);?></td>
						</tr>
                         
                        <!--<tr class="total_bar" >
                        <td colspan="6">
                        <hr>
                        </td>
                        </tr>-->
					</tbody>
                    <tfoot><tr>
                    <td colspan="6">
                    <div>
                  <span style="float:left; margin-left:200px;top:180px; position:absolute; font-size:11px !important;"><?php echo $invoice['fi_by'];?></strong></span>
                  </div>
                  </td>
                    </tr>
                    </tfoot>
                  </table>
                  
			</div>
            </div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>

</body></html>