<?php
include("includes/config.php");
session_start();
$check = $_SESSION['email'];
$query = mysql_query("select email from admin_login where email='$check' ");
$data = mysql_fetch_array($query);
$email = $data['email'];
$user = $_SESSION['uname'];
if (isset($_SESSION['expiretime'])) {
    if ($_SESSION['expiretime'] < time()) {
        header("Location:timeout.php");
    } else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}
if (!isset($email)) {
    header("Location:404.php");
}

function convert_number_to_words($number) {

    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = array(
        0 => 'Zero',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Fourty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety',
        100 => 'Hundred',
        1000 => 'Thousand',
        /* 10000               => 'Ten Thousand',
          100000              => 'One lakh',
          1000000             => 'Ten Lakhs', */
        1000000 => 'million',
        1000000000 => 'Billion',
        1000000000000 => 'Trillion',
        1000000000000000 => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
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
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
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

$epid = $_GET['id'];
$qry = mysql_query("SELECT * FROM exponses_bill where ep_id='$epid'") or die(mysql_error());
$row1 = mysql_fetch_array($qry);
$excid = $row1["exc_id"];
$bill_address = $row1["bill_address"];
$total_amount = $row1["amount"];
$ptype = $row1["p_type"];
$cnum = $row1['pay_number'];
$bank = $row1['bank'];
$c_date = $row1['c_date'];
$expenselist = mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid");
$expenses = mysql_fetch_array($expenselist);
?>
<?php include 'print_header.php'; ?>
<link rel="stylesheet" href="css/print.css"> 
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
<body onload="javascript:printDiv('printablediv')">
<!--<div  id="print" style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>-->
    <div id="printablediv">
        <header class="clearfix">
          <center>  <img src="img/logo_sms.png" title="latterpad" width="30%" /></center>
        </header>
        <main>
            <div id="details" class="clearfix">
                <div id="client">
                    <div class="to">TO:</div>
                    <h2 class="name"><?php echo $row1['a_name']; ?></h2>
                    <div class="address"><?= nl2br($row1["address"]); ?></div>
                </div>
                <div id="invoice">
                    <h1><?= $row1["title"]; ?></h1>
                    <div class="date">Date of Bill: <?= $row1["date"]; ?></div>
                </div>
            </div>
            <br>
            <div class="exponsive">
                <div class="no">S.No</div>
                <div class="desc">Date</div>
                <div class="rno">Expence No</div>
                <div class="pay">Pay Type</div>
                <div class="qty">Bill No</div>
                <div class="unit">Title</div>
                <div class="total">Amount</div>                           
            </div>

            <?php
            $query = "select * from  exponses_bill_summary where ep_id='$epid'";
            $res = mysql_query($query);
            $i = 0;
            while ($row = mysql_fetch_array($res)) {
                $i = $i + 1;
                $date = stripslashes($row["exdate"]);
                $r_no = stripslashes($row["r_no"]);
                $b_no = stripslashes($row["b_no"]);
                $title = stripslashes($row["title"]);
                $amount = $row["amount"];
                ?>

                <div class="exponsive">
                    <div class="no"><?= $i ?></div>
                    <div class="desc"><?= $date ?></div>
                    <div class="rno"><?php echo $r_no; ?></div>
                    <div class="pay"><?php echo $ptype; ?></div>
                    <div class="qty"><?= $b_no ?></div>
                    <div class="unit"><?= $title ?></div>
                    <div class="total"><?php echo number_format($amount, 2); ?></div>
                </div>
            <?php } ?>

            <div class="exponsive">
                <div class="no" style="background:none;">&nbsp; </div>
                <div class="desc" style="background:none;">&nbsp; </div>
                <div class="rno" style="background:none;">&nbsp; </div>
                <div class="pay" style="background:none;">&nbsp; </div>
                <div class="qty" style="background:none;">&nbsp; </div>
                <div class="unit" style="background:none;">Sub Total</div>
                <div class="total" style="background:none; color:black;" ><?php echo number_format($total_amount + $row1["advance_amt"], 2); ?></div>
            </div>

            <?php if ($row1["advance_status"] == 1) { ?>
                <div class="exponsive">
                    <div class="no" style="background:none;">&nbsp; </div>
                    <div class="desc" style="background:none;">&nbsp; </div>
                    <div class="rno" style="background:none;">&nbsp; </div>
                    <div class="pay" style="background:none;">&nbsp; </div>
                    <div class="qty" style="background:none;">&nbsp; </div>
                    <div class="unit" style="background:none;">Paid Advance Amount</div>
                    <div class="total" style="background:none; color:black;" ><?php echo number_format($row1["advance_amt"], 2); ?></div>
                </div>

            <?php } ?>
            <?php if ($row1["add_adv_status"] == 1) { ?>
                <div class="exponsive">
                    <div class="no" style="background:none;">&nbsp; </div>
                    <div class="desc" style="background:none;">&nbsp; </div>
                    <div class="rno" style="background:none;">&nbsp; </div>
                    <div class="pay" style="background:none;">&nbsp; </div>
                    <div class="qty" style="background:none;">&nbsp; </div>
                    <div class="unit" style="background:none;">Add Advance Amount</div>
                    <div class="total" style="background:none; color:black;" ><?php echo number_format($row1["add_advance_amt"], 2); ?></div>
                </div>

            <?php } ?>


            <div class="total_bar" style="border:1px solid #BFBFBF; ">
                <div class="total_bar1"> <?php echo convert_number_to_words($row1['amount']+$row1["add_advance_amt"]); ?> Rupees Only </div>
                <div class="total_bar2"><center>GRAND TOTAL</center></div>
                <div class="total_bar3"><?php echo number_format($total_amount+$row1["add_advance_amt"], 2); ?></div>
            </div>

            <br><br>

            <h3><b> <?php if ($ptype == "card") { ?>  Card Number:  <?php echo $cnum;
            }
            ?> 
<?php if ($ptype == "cheque") { ?>
                        Cheque Number: <?php echo $cnum; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Bank Name: <?php echo $bank; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cheque Date:<?php echo $c_date;
                }
?>
                </b></h3><br><br>




            <div id="thanks"><center>Thank you!</center></div>

            <div id="loginuser" style="text-align:left;"> <h3 style="font-size:20px;" ></h3>
                <h2> Bill Generated By<br><br> <?php echo $row1['billgenerate']; ?></h2>

            </div>

            <div id="chairman" style="text-align:right;"><h1> Chairman Signature</h1>

                <div id="receiver" style="text-align:left;"> <h3 style="font-size:20px;" ></h3>
                    <h2>  Receiver Signature<br><br> <?php echo $row1['receiver']; ?></h2>

                </div>
                <!--<div id="notices">
                  <div>NOTICE:</div>
                  <div class="notice">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</div>
                  <div class="notice">netus et malesuada fames ac turpis egestas.</div>
                </div>-->
            </div>
        </main>

        <footer>
            1/191 A,, Rajiv Gandhi Nagar, Kundrathur Main Rd, Kovur, Chennai-600128. Phone No : 044 6566 6673.
        </footer>
    </div>
</body>
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

</style>
</html>