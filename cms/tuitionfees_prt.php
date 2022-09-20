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

function number_to_words($number) {
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
        10                  => 'Ten');
	return $string = $dictionary[$number];
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
$ex_id=$_GET['exid'];	
?>
<?php include 'print_header.php';?>
<html
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript">
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
	 .footer{
	  	  font-size:23px;
	  	  width: 100%;
		  height: 30px;
		  position: absolute;
		  bottom: 0;
		  padding-bottom:50px;
	 }	 
	 
	 
</style>
</head>

<body onLoad="printDiv('printablediv')">
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
 <center>
<img src="img/letterpad.png" style="width:100%;">
</center>
<hr>
 <br><br><br>
 <center><h3 class="title">CERTIFICATE FOR PAYMENT OF TUITION FEES</h3></center>
 <br>
 <br><br><br>
 <?php 
					$count=1;
					$qry5=mysql_query("SELECT * FROM exponses WHERE ex_id=$ex_id");
			  $row5=mysql_fetch_array($qry5);
			  
			  $exc_id=$row5['exc_id'];
			  $qry6=mysql_query("SELECT * FROM ex_category WHERE exc_id=$exc_id");
			  $row6=mysql_fetch_array($qry6);
        			?>
 <p class="parag" style="text-align:justify;">In this institution during the Academic Year (<?=$acyear_name?>), has paid her Annual Tuition Fees (Inclusive of Transportation, Stationeries, Accessories and Other School-Requirements)  for the current academic year.  The details are as follows,</p>
 <br><br>
 <table class="table table-striped1" >
					
					<thead>
						<tr>
							<th>S.No</th>
							<th>REG NO</th>
							<th>NAME OF STUDENT</th>
                            <th>FATHER NAME</th>
							<th class="price">STD & SEC</th>
							<th class="total">TUITION FEES</th>
						</tr>
					</thead>
					
					<tbody>
                    <?php    
					
					$id=$_GET["id"];
					$s=array();
					$qry1=mysql_query("SELECT * FROM sibling where ss_id='$id'") or die (mysql_error());
					$row1=mysql_fetch_array($qry1);
					$p_id=$row1["p_id"];
					array_push($s,$id);
					$qry1=mysql_query("SELECT * FROM sibling where p_id='$p_id' and ss_id!='$id'") or die (mysql_error());
					while($row1=mysql_fetch_array($qry1))
					{
					    $ss_id=$row1["ss_id"];
					     
					    array_push($s,$ss_id);
					}
					$ss=implode(",",$s);
					
					 
					function total_amount($b,$c,$fdis,$acyear,$ftype)
					{
					    $cid=$c;
							$bid=$b;
							$rate=$ftype;
					$total1=0;
					$fdisid2=$fdis;
				 	$qry=mysql_query("SELECT * FROM mfrate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND rate='$rate'");
				 		  while($row=mysql_fetch_array($qry))
							{ 
							$frid=$row['fr_id'];
							$fgid2=$row['fg_id'];
							
								if($fgid2){
								$fgrouplist=mysql_query("SELECT * FROM mfgroup WHERE fg_id=$fgid2");
												  $fgroup=mysql_fetch_array($fgrouplist);
												  $fgroupname=$fgroup['fg_name'];	
												  $ftyid=$fgroup['fty_id'];
												  $fto=$fgroup['end'];
												  if($fto==0){
													  $fto=12;
												  }
								  $ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
														$ftypevalue=$ftype['fty_value'];
								}
								
						$frvaluelist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$fdisid2 AND ay_id=$acyear"); 
								  $frvalue=mysql_fetch_array($frvaluelist);
								  if($frvalue){
									  if($ftypevalue==1){
								  $total1 +=$frvalue['dis_value']*$fto;
									  }else{
								  $total1 +=$frvalue['dis_value'];
									  }
								  }
								   }
								   
                       return $total1;  
					     
					}
					
							$qry="SELECT * FROM student WHERE ay_id=$acyear";
							 
								$qry .="  and ss_id IN ($ss)";
							 
							$qry ." ORDER BY c_id,s_id,gender,firstname ASC";
							$qry1=mysql_query($qry);
							$count=0;
							$total=0;
			  while($row=mysql_fetch_array($qry1))
        		{$count=$count+1;
					$cid=$row['c_id'];
							$sid=$row['s_id'];	
							$bid=$row['b_id'];
							$fdis=$row['fdis_id'];
							$stype=$row['stype'];
								
							if($stype=="Old")
							{
							    $ftype="0";
							}else{
							    $ftype="0,1";
							}

							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
							$class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid");
							$section=mysql_fetch_array($sectionlist);
							
							$total+=total_amount($bid,$cid,$fdis,$acyear,$stype);
							?>
						<tr>
							<td><?php echo $count;?></td>			
							<td><center><?php echo $row['admission_number'];?></center></td>
							<td><center><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname'];?></center></td>
                            <td><center><?php echo  $row['fathersname']; ?></center></td>
							<td class="price"><center><?php echo $class['c_name']."-".$section['s_name']; ?></center></td>
							<td class="total"><?php echo "Rs. ".total_amount($bid,$cid,$fdis,$acyear,$stype); ?></td>
						</tr>
                        <?php }?>
						<tr class="total_bar">
							<td class="grand_total" colspan="5"><?php if($count==1){?> Total Tution Fees Paid :<?php }else if($count>1){ ?>Total fees paid for <?php echo number_to_words($count);?> students <?php } ?></td>
							<td class="grand_total"><b><?php echo number_format($total,2);?></b></td>
						</tr>
					</tbody>
				</table>
               <p style="font-size:18px; color:#000000; font-weight:bold;"> <?php $amount=number_format($total,2);
						 echo "(".convert_number_to_words($total); ?> Rupees Only ) </p>
                         <div class="footer">
<strong><font style="margin-left:80px;">School Seal</font><font style="margin-right:80px; float:right;">Principal</font></strong>
</div>
</div>

</body></html>