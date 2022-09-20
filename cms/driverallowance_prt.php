<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("includes/config.php");

session_start();

$check=$_SESSION['email'];

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

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>School Management Solution</title>
<html
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
function hide_button(){
     document.getElementById('print').style.visibility='hidden';
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

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
    width: 950px;
    margin-top:-362px;
	height:200px;
	margin-left:-960px !important;
   
  }
  .block-content-invoice1{
	  width:950px;
	  margin:30px
		border-radius: 3px;
		position: relative;
		padding: 10px;
		border: 2px solid #a9a6a6;
		  }
</style>
 						<div id="invoice" class="widget widget-plain">	
						<div class="block-content-invoice1">
                        <div>
    <fieldset style="margin-top:10px;width:98%">
    <IMG SRC="img/hallticket.jpg" ALT="" height="70px">
    </fieldset>
    </div>
     <?php 
     $d_id=$_GET['did'];
					$count=1;
					$qry1=mysql_query("SELECT * FROM d_allowance where  d_id='$d_id'");
							$count=1;
			  $row1=mysql_fetch_array($qry1);
        		 
                     $driver_id=$row1["driver_id"];
                     $fromdate=$row1["from_date"];
                     $date_split1=explode('-', $fromdate);
                     $from_date=$date_split1[2]."/".$date_split1[1]."/".$date_split1[0];
                     $todate=$row1["to_date"];
                     $date_split1=explode('-', $todate);
                     
                     $to_date=$date_split1[2]."/".$date_split1[1]."/".$date_split1[0];
        		    $row=mysql_fetch_array(mysql_query("SELECT * FROM 	driver where driver_id='$driver_id' "));
			  
        		   $driver_name=$row['fname']." ".$row['lname'];
        			?>
    <center><h2>Driver Allowance Receipt</h2></center><span style="float:right; margin-right:10px; margin-top:-30px;"><strong>Receipt.No</strong> : <?php echo $row1['receipt_no'];?></span>
   
                        
				<table class="table table-striped" id="table-example">	
                	<thead>
						<tr style="border:1px solid #BFBFBF;">
							<th width="10"><center>S.No</center></th>
                            <th colspan="4"><center>Driver Id</center></th>
                            <th colspan="4"><center>Driver Name</center></th>
                            <th colspan="4"><center>Start Date</center></th>
                            <th colspan="4"><center>End Date</center></th>
							<th colspan="4"><center>Total Days</center></th>
							<th class="total" width="120"><center>Total Allowance Amount</center></th>                            
						</tr>
					</thead>						
					<tbody style="border:1px solid #BFBFBF;">
                    	<tr>
							<td><center><?php echo $count;?></center></td>	
                            <td colspan="4"><center><?php echo $driver_id;?></center></td>		
							<td colspan="4"><center><?php echo $driver_name;?></center></td>
							<td colspan="4"><center><?php echo $from_date;?></center></td>
							<td colspan="4"><center><?php echo $to_date;?></center></td>
							<td colspan="4"><center><?php echo $row1["working_days"];?></center></td>
							<td class="total"><?php echo number_format($row1['total_amount'],2);?></td>
                        </tr>
                        <tr class="total_bar" style="border:1px solid #BFBFBF;">
                        <td></td><td></td><td></td><td></td><td></td>
							<td class="grand_total" colspan="8"><center>
 <?php $amount=number_format($row1['total_amount'],2);
						 echo convert_number_to_words($row1['total_amount']); ?> Rupees Only
</center></td>
							<td class="grand_total" width="150px">Total:</td>
							<td   class="grand_total">Rs. <?php echo number_format($row1['total_amount'],2);?></td>
						</tr>
                         
                        <!--<tr class="total_bar" >
                        <td colspan="6">
                        <hr>
                        </td>
                        </tr>-->
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

 


