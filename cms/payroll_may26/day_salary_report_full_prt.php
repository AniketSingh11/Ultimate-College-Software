<? ob_start(); ?>
<?php 
error_reporting(E_ALL ^ E_NOTICE);
include("../includes/config.php"); 


session_start();

$date = date_default_timezone_set('Asia/Kolkata');

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

$syear=$ay['s_year'];
$eyear=$ay['e_year'];

if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:../timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}
if(!isset($check))
{	
header("Location:../404.php");
}
include("../checking_page/payroll.php");
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

$value=$_GET['value'];
						   $sdate_split1= explode('-', $value);
								  $sdate_month=$sdate_split1[0];
								  $sdate_year=$sdate_split1[1];	
								 // $sdate_day=$sdate_split1[0];	
?>
<script>
function hide_button(){
     document.getElementById('print').style.visibility='hidden';
	 document.getElementById('print').style.display='none';
     window.print();
     document.body.onmousemove = doneyet;
}
</script>
  </head>
 <body style="background:#FFFFFF;">
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="../img/printer.png"></a></div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
  
<style type="text/css" media="all">
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
		/*border: 2px solid #a9a6a6;*/
		  }
.table td, .table th
{
	padding:10px;
	text-align:center;
}
</style>
 						<div id="invoice" class="widget widget-plain">	
						<div class="block-content-invoice1">
                       <div style="width:236mm; margin:0px; height:40.1mm; min-height:40.1mm; border-bottom:2px solid #01a8ff; padding-bottom:20px; display:inline-block;" id="Table_01">
                            <div style="text-align:left; width:50.00mm; float:left;">
                                <div><img src="img/logo1.png" width="160px" height="160px"></div>
                            </div>
                            <div style="text-align:center;width:185.75mm; float:left; padding-top:25px;">
                                <h5 style="padding:0px; padding-bottom:3px; margin:0px; letter-spacing:2px; color:red; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:46px; ; font-weight:bold;">SCHOOL/COLLEGE MANAGEMENT SYSTEM</h5>

                                <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-weight:bold; font-size:18px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Hetauda, Nepal</h5>
                               <!-- <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-size:16px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Contact : 044-32429897, 26790694, Email : christischool@gmail.com, Web: www.christschool.co.in</h5>-->
                            </div>
                        </div>
<div style="text-align:right; padding:10px 10px;">Date : <?php echo date("d/m/Y");?></div>
<h3>Salary Overall Report ( <?=$sdate_month."-".$sdate_year?> )</h3>
                       <div class="modal-body">
        <table class="table" width="100%" cellpadding="0" cols="0" border="1" style="border-collapse:collapse;">
        					<tr>
                            <th>S.No</th>
                            <th>Teacher's Name</th>
                            <th>Designation</th>
                            <th>Salary</th>
                            </tr> 
                            <?php
							
							$emp_query="select n_salary,staff_name,position,accno,n_salary from staff_daily_salary where month=$sdate_month and year=$sdate_year order by st_ms_id desc";										
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							$total=0;
							while($emp_display=mysql_fetch_array($emp_result))
							{
									$total +=round($emp_display["n_salary"]);
								?>                         
                           <tr>
                           <td><?=$emp_count?></td>
                           <td><?=$emp_display["staff_name"]?></td>
                           <td><?=$emp_display["position"]?></td>
                           <td><?=round($emp_display["n_salary"])?></td>
                           </tr>
                           <?php $emp_count++; } ?>
                           <tr>
                           <td colspan="3"><b style="float:right">Total</b></td>
                           <td><b><?=round($total)?></b></td>
                           </tr>
					      </table>
                          <br><br><br><br><br><br><br><br>
<font style="margin-left:400px;">Director</font><br/>
      </div>
            </div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>


</body>
 </html>