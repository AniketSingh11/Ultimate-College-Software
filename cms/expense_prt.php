<?php
error_reporting(E_ALL ^ E_NOTICE);
include("includes/config.php");

session_start();

$check = $_SESSION['email'];

$sacyear = $_SESSION['acyear'];

if ($sacyear) {
    $ayear = mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
    $ay = mysql_fetch_array($ayear);
} else {
    $ayear = mysql_query("SELECT * FROM year WHERE status='1'");
    $ay = mysql_fetch_array($ayear);
}

$acyear = $ay['ay_id'];
$acyear_name = $ay['y_name'];

if (isset($_SESSION['expiretime'])) {
    if ($_SESSION['expiretime'] < time()) {
        header("Location:timeout.php");
    } else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}

if (!isset($check)) {

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

$ex_id = $_GET['exid'];
$aid = $_GET['a_id'];
$count = 1;
$qry5 = mysql_query("SELECT * FROM exponses WHERE ex_id=$ex_id");
$row5 = mysql_fetch_array($qry5);
$day = $row5['date_day'];
$month = $row5['date_month'];
$year = $row5['date_year'];
$date = $day . '/' . $month . '/' . $year;
$exc_id = $row5['exc_id'];
$total_amount = $row5["amount"];
$bill_address = $row5["bill_address"];

$ptype = $row5['p_type'];
$cnum = $row5['pay_number'];
$bank = $row5['bank'];
$c_date = $row5['c_date'];

$qry6 = mysql_query("SELECT * FROM ex_category WHERE exc_id=$exc_id");
$row6 = mysql_fetch_array($qry6);
$agencylist1 = mysql_query("SELECT * FROM agency WHERE a_id=$aid");
//echo "SELECT * FROM agency WHERE a_id=$aid"; 
$agency1 = mysql_fetch_assoc($agencylist1);

$agencyname = $agency1['a_name'];
$address = $agency1['a_address'];
?>

<?php include 'print_header.php'; ?>
<script>
    function hide_button() {
        window.print();
    }
</script>
<link rel="stylesheet" href="css/print.css"> 
<style type="text/css">

</style>
<!-- Fonts -->

</head>

<body onLoad="hide_button()">

    <div id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->

       <header class="clearfix">
          <center>  <img src="img/logo_sms.png" title="latterpad" width="30%" /></center>
        </header>

        <main>
            <div id="details" class="clearfix">
                <div id="client">
                    <div class="to">TO:</div>
                    <h2 class="name"><?php echo $agencyname; ?></h2>
                    <div class="address"><?php echo $address; ?></div>
                </div>
                <div id="invoice">

                    <div class="date">Date of Bill: <?php echo $date; ?></div>
                </div>

            </div>
            <center><h2> Expense Receipt</h2></center><br><br>
            <?php if ($ptype) {
                ?>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th width="10.45mm" class="no" >S.No</th>
                            <th  width="36.45mm" class="rno">Expence No</th>
                            <th  width="25.45mm" class="pay">Pay Type </th>

                            <th  width="80.45mm" class="qty">Bill No</th>
                            <th width="35.45mm" class="category">Expense Category</th>
                            <th  width="80.45mm" class="title">Title</th>
                            <th  width="36.45mm" class="total">Amount</th>
                        </tr>
                    </thead>
                    <?php $count = 1; ?> 
                    <tr>
                        <td width="10.45mm" class="no"><center><?php echo $count++; ?></center></td>
                    <td width="36.45mm" class="date"><center><?php echo $row5['r_no']; ?></center></td>
                    <td width="25.45mm" class="rno"><center><?php echo $row5['p_type']; ?></center></td>


                    <td width="80.45mm" class="qty"><center><?php echo $row5['b_no']; ?></center></td> 
                    <td width="35.45mm" class="category"><center><?php echo $row6['ex_category']; ?></center></td> 
                    <th  width="80.45mm" class="title"><center><?php echo $row5['title']; ?></center></td>  
                    <td width="36.45mm" class="total"><center><?php echo number_format($row5['amount'] + $row5['advance_amt'], 2); ?></center></td>
                    </tr>

                    </tbody>



                    <tfoot>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="2" >SUBTOTAL</td>
                            <td><?php echo number_format($total_amount + $row5["advance_amt"], 2); ?></td>
                        </tr>
                        <?php if ($row5['advance_status'] == 1) { ?>
                            <tr>
                                <td colspan="4"></td>
                                <td colspan="2" >ADVANCE AMOUNT</td>
                                <td><?php echo number_format($row5["advance_amt"], 2); ?></td>
                            </tr>

                        <?php } ?>
        <!--<tr>
        <td colspan="2"></td>
        <td colspan="2">TAX 25%</td>
        <td>1,300.00</td>
        </tr>-->
                        <tr>
                        <tr class="total_bar" style="border:1px solid #BFBFBF;">
                            <td class="grand_total" colspan="3"  style="font-size:1.1em"><center>
                        <?php
                        $amount = number_format($row1['amount'], 2);
                        echo convert_number_to_words($row5['amount']);
                        ?> Rupees Only
                    </center></td>


                    <td colspan="3" style="font-size:1em">GRAND TOTAL</td>
                    <td><?php echo number_format($total_amount, 2); ?></td>
                    </tr>
                    </tfoot>
                </table><br><br>
                <h3><b> <?php if ($ptype == "card") { ?>  Card Number: <?php
                            echo $row5['pay_number'];
                        }
                        ?> 
                        <?php if ($ptype == "cheque") { ?>
                            Cheque Number: <?php echo $row5['pay_number']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Bank Name: <?php echo $row5['bank']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cheque Date: <?php
                            echo $row5['c_date'];
                        }
                        ?>


                    </b></h3><br><br>

                <div id="thanks"><center><b><h3>Thank you!</h3></b></center></div>


                <div id="loginuser" style="text-align:left;"> <h3 style="font-size:20px;" ></h3>
                    <h2> Bill Generated By <br><br><?php echo $row5['billgenerate']; ?></h2>

                </div>

                <div id="chairman" style="text-align:right;"><h1> Chairman Signature</h1>

                    <div id="receiver" style="text-align:left;"> <h3 style="font-size:20px;" ></h3>
                        <h2>  Receiver Signature <br><br> <?php echo $row5['receiver']; ?></h2>

                    </div>

                    <?php
                } else {
                    //proposal
                    ?>   
                    <link rel="stylesheet" href="css/print.css"> 
                    <style type="text/css">

                    </style>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="10.45mm" class="no" ><center>S.No</center></th>

                        <th  width="36.45mm" class="rno"><center>Expense No</center></th>
                        <th  width="30.45mm" class="pay">Name </th>
                        <th  width="80.45mm" class="qty">Bill No</center></th>
                        <th width="46.45mm" class="category">Expense <br>Category</center></th>


                        <th width="35.45mm" class="qty">Quantity</center></th>
                        <th  width="33.45mm" class="amount">Amount</center></th>     
                        <th  width="33.45mm" class="total">Total</center></th>                        
                        </tr>
                        </thead>	
                        <?php
                        $count = 1;
                        $ex_id = $_GET['exid'];
                        $aid = $_GET['a_id'];
                        $query = "select * from  exponses where ex_id='$ex_id' order by ex_id asc";
                        // echo "select * from  exponses where ex_id='$ex_id' order by ep_id asc"; die;
                        $res = mysql_query($query);
                        //echo "select * from  expense_po_amount where ex_id='$ex_id' order by ep_id asc"; die;

                        $row = mysql_fetch_array($res);

                        //  print_r($row);die;
                        //echo "SELECT * FROM exponses WHERE ex_id=$ex_id"; die;


                        $count = 1;
                        $ex_no = $row['r_no'];
                        $b_no = $row['b_no'];
                        $p_type = $row['p_type'];
                        $exc_id = $row['exc_id'];

                        $qry6 = mysql_query("SELECT * FROM ex_category WHERE exc_id=$exc_id");
                        $row6 = mysql_fetch_array($qry6);

                        $id = $row['ex_id'];
                        $qry5 = mysql_query("SELECT * FROM expense_po_amount WHERE ex_id=$ex_id");
                        //echo "SELECT * FROM expense_po_amount WHERE ex_id=$ex_id";die;
                        ?>					
                        <?php
                        while ($row5 = mysql_fetch_array($qry5)) {

                            //print_r($row5);
                            ?>
                            <tr>
                                <td width="10.45mm" class="no"><center><?php echo $count++; ?></center></td>


                            <td width="36.45mm" class="date"><center><?php echo $row['r_no']; ?></center></td>
                            <td width="35.45mm" class="rno"><center><?php echo $row5['name']; ?></center></td>	
                            <td width="80.45mm" class="qty"><center><?php echo $row['b_no']; ?></center></td>	
                            <td width="46.45mm" class="category"><center><?php echo $row6['ex_category']; ?></center></td>	


                            <td width="35.45mm" class="qty"><center><?php echo $row5['qty']; ?></center></td>	
                            <td width="33.45mm" class="amount"><center><?php echo number_format($row5['amount'], 2); ?></center></td>

                            <td width="33.45mm" class="total"><center><?php echo number_format($row5['total'], 2); ?></center></td>

                            </tr>
                        <?php } ?>
                        </tbody>
                        <?php ?>
                        <tfoot>
                        <tfoot>
                            <tr>

                            <tr class="total_bar" style="border:1px solid #BFBFBF;">
                                <td class="grand_total" colspan="7" style="font-size:1.1em; background:#EEEEEE">PERCENTAGE

                                <td style="background:#2376B2; color:white"><?php echo number_format($row['t_parcent'], 2); ?></td>
                            </tr>
                            <tr>

                            <tr class="total_bar" style="border:1px solid #BFBFBF;">
                                <td class="grand_total" colspan="7" style="font-size:1.1em; background:#EEEEEE">TOTAL
                                <td style="background:#2376B2; color:white"><?php echo number_format($row['t_amount'], 2); ?></td>
                            </tr>
                            
                            <tr class="total_bar" style="border:1px solid #BFBFBF;">
                                <td class="grand_total" colspan="7" style="font-size:1.1em; background:#EEEEEE">TDS ( <?php echo $row['tds_per'].'%'; ?> )
                                <td style="background:#2376B2; color:white"><?php echo number_format($row['tds_amt'], 2); ?></td>
                            </tr>
                            
                            <tr class="total_bar" style="border:1px solid #BFBFBF;">
                                <td class="grand_total" colspan="7" style="font-size:1.1em; background:#EEEEEE">SHIPPING
                                <td style="background:#2376B2; color:white"><?php echo number_format($row['shipping'], 2); ?></td>
                            </tr>
                            <tr>

                            <tr class="total_bar" style="border:1px solid #BFBFBF;">
                                <td class="grand_total" colspan="7" style="font-size:1.1em; background:#EEEEEE">DISCOUNT
                                <td style="background:#2376B2; color:white"><?php echo number_format($row['discount'], 2); ?></td>
                            </tr>
                            <tr>

                            <tr>

                                <td colspan="5"></td>
                                <td colspan="2" >SUBTOTAL</td>
                                <td><?php echo number_format($total_amount, 2); ?></td>
                            </tr>
                            <tr>
                            <tr class="total_bar" style="border:1px solid #BFBFBF;">
                                <td class="grand_total" colspan="2"  style="font-size:1.1em"><center>
                            <?php
                            $amount = number_format($row5['amount'], 2);
                            echo convert_number_to_words($row['amount']);
                            ?> Rupees Only
                        </center></td>


                        <td colspan="5" style="font-size:1em">GRAND TOTAL</td>
                        <td class="grand_total"> <?php echo number_format($row['amount'], 2); ?></td>
                        </tr>
                        </tbody>

                    </table>

                    <?php if ($ptype == "card") { ?>  Card Number: <?php
                        echo $row5['pay_number'];
                    }
                    ?> 
                    <?php if ($ptype == "cheque") { ?>
                        Cheque Number: <?php echo $row5['pay_number']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Bank Name: <?php echo $row5['bank']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cheque Date: <?php
                        echo $row5['c_date'];
                    }
                    ?>



                    <h5> <div id="thanks" style="text-align:left;">Thank you!</div></h5><br>

                    <div id="loginuser" style="text-align:left;"> <h4 style="font-size:20px;" ></h4>
                        <h4> Bill Generated By <br><br><?php echo $row['billgenerate']; ?></h4>

                    </div>

                    <div id="chairman" style="text-align:right;"><h4> Correspondent Signature</h4>

                        <div id="receiver" style="text-align:left;"> <h4 style="font-size:20px;" ></h4>
                            <h4>  Receiver Signature <br><br> <?php echo $row['receiver']; ?></h4>

                        </div>
                    <?php } ?>
                </div>
                </body></html>
                </body></html>

