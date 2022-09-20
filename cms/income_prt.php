<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("includes/config.php");

session_start();

$check=$_SESSION['email'];

$acyear=$_SESSION['acyear'];

 
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
<?php include 'print_header.php';?>
<html
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>
function hide_button(){
     window.print();
}
</script>
<link rel="stylesheet" href="css/style.css"> <!-- Generic style (Boilerplate) -->
  <link rel="stylesheet" href="css/tables.css"> <!-- Tables, optional -->
  <!-- end CSS-->
  <style type="text/css">
  body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto;
  background: #FFFFFF; 
  font-family: Arial, sans-serif;
}
.parag{
		 margin:0 auto;
		 width:90%;
		 font-size:25px;
		 line-height:50px;
		 text-align:justify;
	 }

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 30px;
  margin-right:5px;
  border: 1px solid #C1CED9;
  
  font-family: Arial, sans-serif;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 20px 20px;
  color: #000000;
  border: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
  background: #DDDDDD;
}
	.title{
		font-size:25px;
		border-bottom: solid 1px #000000;
      display: inline;
      padding-bottom: 2px;}
	 .parag{
		 margin:0 auto;
		 width:90%;
		 font-size:25px;
		 line-height:60px;
		 text-align:justify;
	 }
	 table .service,
table .desc {
  text-align: left;
}

table td {
	font-size:18px;
  padding: 20px;
  text-align: right;
  border: 1px solid #C1CED9;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.sub {
  border: 1px solid #C1CED9;
}

table td.grand {
  border: 1px solid #5D6975;
}

/*table tr:nth-child(2n-1) td {
  background: #EEEEEE;
}*/

table tr:last-child td {
  background: #DDDDDD;
}
	 .footer1{
		 padding-top:60px;
	  	  width: 100%;
		  height: 30px;
		  position: absolute;
	 }	
</style>
  <!-- Fonts -->
  <link href="//fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
</head>

<body onLoad="hide_button()">

<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
 <center>
<img src="img/letterpad.png" style="width:100%;">
</center>
<hr>

     <?php 
     $in_id=$_GET['inid'];
					$count=1;
					$qry5=mysql_query("SELECT * FROM income WHERE in_id=$in_id");
			  $row5=mysql_fetch_array($qry5);
			  
			  $inc_id=$row5['inc_id'];
			  $qry6=mysql_query("SELECT * FROM in_category WHERE inc_id=$inc_id");
			  $row6=mysql_fetch_array($qry6);
        			?>
<font style="margin-right:80px; float:right;">Receipt No: <?php echo $row5['r_no'];?></font><br>
 <center><h3 class="title">Income Receipt</h3></center>
                    <br>
 <table  class="table table-striped1">	
                	<thead>
						<tr style="border:1px solid #BFBFBF;">
							<th width="10"><center>S.No</center></th>
                            <th colspan="4"><center>Income Category</center></th>
							<th colspan="4"><center>Income Title</center></th>
							<th class="total" width="120"><center>Amount</center></th>                            
						</tr>
					</thead>						
					<tbody style="border:1px solid #BFBFBF;">
                    	<tr>
							<td><center><?php echo $count;?></center></td>	
                            <td colspan="4"><center><?php echo $row6['in_category'];?></center></td>		
							<td colspan="4"><center><?php echo $row5['title'];?></center></td>
							<td class="total"><?php echo number_format($row5['amount'],2);?></td>
                        </tr>
                        <tr class="total_bar" style="border:1px solid #BFBFBF;">
							<td class="grand_total" colspan="8"><center>
 <?php $amount=number_format($row5['amount'],2);
						 echo convert_number_to_words($row5['amount']); ?> Rupees Only
</center></td>
							<td class="grand_total" width="150px">Total:</td>
							<td class="grand_total">Rs. <?php echo number_format($row5['amount'],2);?></td>
						</tr>
             		</tbody>
                  </table>
             
                         <div class="footer1">
                         <?php if($row5['b_no']){?>
<strong><font style=" float:left; margin-left:60px;">Bill No / Receipt No : <?php echo $row5['b_no'];?></font><?php } ?><font>School Seal</font><font style="margin-right:80px; float:right;">Principal</font></strong>
</div>
</div>
</body></html>

 
  