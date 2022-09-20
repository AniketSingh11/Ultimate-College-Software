<?php 
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
						$invoicelist1=mysql_query("SELECT * FROM mfinvoice WHERE fi_id=$ffi_id"); 
								  $invoice=mysql_fetch_array($invoicelist1);
									
									$ssid=$invoice['ss_id'];
								  $studentlist1=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student1=mysql_fetch_array($studentlist1);
								  $cid1=$invoice['c_id'];
								  $qry=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $row=mysql_fetch_array($qry);
								  
								  $sid1=$invoice['s_id'];
								  $qry1=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $row1=mysql_fetch_array($qry1);	
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
  <!-- end CSS-->
  
  <!-- Fonts -->
  <link href="//fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div style="float:right;position:absolute;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="img/printer.png"></a><br>
Bill Type: 
<select name="type" id="show">
	<option value="1" <?php if($showno==1){echo "selected";}?>>Full</option>
    <option value="2" <?php if($showno==2){echo "selected";}?>>Shortly</option>
</select></div>
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
	  width:148mm;
	  /*margin:30px
	  border: 2px solid #a9a6a6;
		border-radius: 3px;*/
		border: 2px solid #011623;
		border-radius: 15px;
		position: relative;
		padding: 0 10px;
		  }
.table { width: 100%; border: 0; margin-bottom: 1em; border-collapse: collapse;  }


 .table thead th
 {
 	font-size: 12px;
	font-weight: bold;
	text-align: left;

	color: #333;
	padding: 10px 10px;
	
	border-bottom: 1px solid #E3E3E3;
	
}	

.table td { vertical-align: top; }

.table tbody tr td { background: #FFF; border-bottom: 1px solid #E3E3E3; }

.table tbody td { padding: 10px; }

		
	
/* ---------------------------------- */
/* @Striped Table */
			
.table-striped tr:nth-child(odd) td { background-color: #FAFAFA; }
.table-striped tr:nth-child(even) td { background-color: #FFF; }



/* ---------------------------------- */
/* @Bordered Table */
		
.table-bordered {
	border-top: 1px solid #E3E3E3;
	border-left: 1px solid #E3E3E3;				
}

.table-bordered thead tr { 
	background: #EEE;
	background:-moz-linear-gradient(top, #FFFFFF 0%, #EEEEEE 100%); /* FF3.6+ */
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#FFFFFF), color-stop(100%,#EEEEEE)); /* Chrome,Safari4+ */
	background:-webkit-linear-gradient(top, #FFFFFF 0%,#EEEEEE 100%); /* Chrome10+,Safari5.1+ */
	background:-o-linear-gradient(top, #FFFFFF 0%,#EEEEEE 100%); /* Opera11.10+ */
	background:-ms-linear-gradient(top, #FFFFFF 0%,#EEEEEE 100%); /* IE10+ */
	background:linear-gradient(top, #FFFFFF 0%,#EEEEEE 100%); /* W3C */	
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFFFFF', endColorstr='#EEEEEE');
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFFFF', endColorstr='#EEEEEE')";
}

.table-bordered tbody td
, .table-bordered thead th {
	border-right: 1px solid #E3E3E3;
	border-bottom: 1px solid #E3E3E3;
}




/*plugin styles*/
.visualize {
	border:1px solid #e6e6e6;
	position:relative;
	background:#fafafa;
	margin:0 auto 30px;
}
.visualize canvas { position: absolute; }
.visualize ul,.visualize li { margin:0; padding:0; list-style:none; background:none; }

/*table title, key elements*/
.visualize .visualize-info { padding: 3px 5px; background: #fafafa; border: 1px solid #e6e6e6; position: absolute; top: -20px; right: 10px; opacity: .8; }
.visualize .visualize-title { display: block; color: #333; margin-bottom: 3px;  font-size: 1.1em; }
.visualize ul.visualize-key { list-style: none;  }
.visualize ul.visualize-key li { list-style: none; float: left; margin-right: 10px; padding-left: 10px; position: relative;}
.visualize ul.visualize-key .visualize-key-color { width: 6px; height: 6px; left: 0; position: absolute; top: 50%; margin-top: -3px;  }
.visualize ul.visualize-key .visualize-key-label { color: #000; }
.client_details{
	padding: 5px 25px !important;
}
#invoice .name { font-size: 12px; }
</style>
 						<div id="invoice" class="widget widget-plain">	
						<div class="block-content-invoice1">
                        <img src="img/letterpad.png" title="latterpad" width="100%" />
                        <center><hr style="margin:0; padding:0;"><h4 style="margin:0; padding:0;">FEES RECEIPT</h4><hr style="margin:0; padding:0;"></center>
                        <span style="float:right; margin-right:10px; margin-top:-22px;"><strong>SI.No</strong> : <?php echo 5000+$invoice['fr_no'];?></span>
				<div style="margin:0 auto; float:none;" align="center">
                <ul class="client_details">
               		<li>Stu's Name : <strong class="name"><?php echo $student1['firstname']." ".$student1['lastname'];?></strong></li>
					<li><strong class="name">FR No : <?php echo $invoice['fr_no'];?></strong></li>
                    <li>Class: <?php echo $row['c_name']." - ".$row1['s_name'];?></li>
					<li>Gender: <?php if($student1['gender'] == 'M')
											echo "Male";
										else	
										    echo "Female"; ?></li>
				</ul>
                <ul class="client_details">
					<li>Admin No: <strong><?php echo $student1['admission_number'];?></strong></li>
                    <li>Academic Year : <strong class="name"><?php echo $acyear_name;?></strong></li>
					<li><strong>Invoice Date :</strong> <?php echo $invoice['fi_day']."/".$invoice['fi_month']."/".$invoice['fi_year'];?></li>
                    <li> Student Type : <?php echo $invoice['stype'];?> Student</li>	
				</ul>
				</div>			
				<table class="table table-striped" id="table-example">	
                	<thead>
						<thead>
						<tr>
							<th>S.No</th>
							<th>Fees Group Name</th>
							<th>Fees From</th>
							<th>Fees To</th>
							<th class="total">Total</th>
						</tr>
					</thead>
					</thead>						
					<tbody>
                    <?php 
					if($showno==1){
					$count=1;
					$montharray=array("June","July","August","September","October","November","December","January","February","March","April","May"); 
					$qry5=mysql_query("SELECT * FROM mfsalessumarry WHERE fi_id=$ffi_id");
			  while($row5=mysql_fetch_array($qry5))
        		{
					$ffrom=$row5['ffrom'];
					$fto=$row5['fto'];
					$fgid=$row5['fg_id'];
					$fgdid=$row5['fgd_id'];
					$ftypes=$row5['ftype'];
					if($fgid){?>
						<tr>
							<td><?php echo $count;?></td>			
							<?php if($ftypes=="discount"){?>
                            <td><b><?php echo $row5['fg_name'];?></b></td>
                           	<td><center>-</center></td>
							<td><center>-</center></td>
                            <td class="total"><b>- <?php echo $row5['amount'];?></b></td>
                            <?php } else { ?>
                            <td><?php echo $row5['fg_name'];?></td>
							<td><?php echo $montharray[$ffrom-1];?></td>
							<td><?php echo $montharray[$fto-1];?></td>
                            <td class="total"><?php echo $row5['amount'];?></td>
                            <?php } ?>
                        </tr>
                        <?php } else if($fgdid){ ?>
                        <tr>
							<td><?php echo $count;?></td>			
							<td><?php echo $row5['fg_name'];?></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td class="total"><?php echo number_format($row5['amount'],2);?></td>
                        </tr>
                        <?php } else{ ?>
                        <tr>
							<td><?php echo $count;?></td>			
							<td><b><?php echo $row5['fg_name'];?></b></td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td class="total"><?php echo $row5['amount'];?></td>
                            <!--<td><a href=""><img src="Book_inventory/images/del.png" alt="delete"></a></td>-->
                        </tr>
							
						<?php }$count++;} }else if($showno==2){ ?>
                        <tr>
							<td>1</td>			
							<td>School Fees</td>
							<td><center>-</center></td>
							<td><center>-</center></td>
							<td class="total"><?php echo number_format($invoice['fi_total'],2);?></td>
                        </tr>
                        <?php } ?>
                    <!--<tr>
							<td><center>1</center></td>			
							<td colspan="4"><center>Tution Fees</center></td>
							<td class="total"><center>Rs. <?php //echo number_format($invoice['fi_total'],2);?></center></td>
                        </tr>-->
                    	<tr class="total_bar" style="border-bottom:dotted 1px solid;">
							<td class="grand_total" colspan="3"><center>
Rupees <?php $amount=number_format($invoice['fi_total'],2);
						if(floor($amount)==$amount){
							$amount1=floor($amount);
							 echo convert_number_to_words($invoice['fi_total']);
						}else{
						 echo convert_number_to_words($amount); }?> Only
</center></td>
							<td class="grand_total" width="150px">Total:</td>
							<td class="grand_total">Rs.<?php echo number_format($invoice['fi_total'],2);?></td>
						</tr>
                         <tr class="total_bar" >
                         <td style="border:none;"></td>
                         <td style="border:none;"></td>
                         <td style="border:none;"></td>
                         <td style="border:none;"></td>
                         <td style="border:none;"></td>
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
                  <span style="float:left; padding-left:15px;margin-top:10px;">Category: <strong><?php echo $invoice['category'];?></strong></span>
                  <span style="float:right; padding-right:40px; margin-top:20px; "><strong><?php echo $invoice['fi_by'];?></strong></span>
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
<script>
$().ready(function() {
	$("#show").change(function(){
		var a=this.value;
		if(this.value) {
		window.location.href='mfinvoice_prt.php?fiid=<?=$ffi_id?>&type=<?=$prt_type?>&show='+a;
	}
	});	
});
				 
</script>
</body></html>