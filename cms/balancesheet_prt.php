<?php
include("includes/config.php");

session_start();

$check = $_SESSION['email'];

$user=$_SESSION['uname'];

$sacyear = $_SESSION['acyear'];

if ($sacyear) {
    $ayear = mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
    $ay = mysql_fetch_assoc($ayear);
} else {
    $ayear = mysql_query("SELECT * FROM year WHERE status='1'");
    $ay = mysql_fetch_assoc($ayear);
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

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>School/College Management Solution</title>
    <html
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script>
            function hide_button() {
                document.getElementById('print').style.display = 'none';
                window.print();
                document.body.onmousemove = doneyet;
            }
            function hider() {
           //alert($('#empty-remover:checkbox:checked').length);
        if($('#empty-remover:checkbox:checked').length>0) {
           $( ".remove" ).each(function() {
            $(this).parent().hide();       
        });
         $( ".kmt" ).each(function() {
            $(this).hide();       
        });
       } else {
        $( ".remove" ).each(function() {
            $(this).parent().show();       
        });
        $( ".kmt" ).each(function() {
            $(this).show();       
        }); 
       }
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
                <img src="img/printer.png" style="margin-bottom:-20%;"></a><br><br>
                <input type="checkbox" value=1 onchange="hider();" id="empty-remover">Remove No Transaction
                </div>
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
                    border: 1px solid #000;
                }
                td,th{
                    border: 1px solid #000;
                }
                .total{
                    text-align: right !important;
                }
                .sub_total{
                    text-align: right !important;
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
            $sdate = $_GET['sdate'];
            $edate = $_GET['edate'];

            $sdate_split1 = explode('/', $sdate);
            $sdate_month = $sdate_split1[1];
            $sdate_day = $sdate_split1[0];
            $sdate_year = $sdate_split1[2];
            $startdate = $sdate_year . $sdate_month . $sdate_day;
            $startdate1 = $sdate_year . "-" . $sdate_month . "-" . $sdate_day;

            $edate_split1 = explode('/', $edate);
            $edate_month = $edate_split1[1];
            $edate_day = $edate_split1[0];
            $edate_year = $edate_split1[2];

            $enddate = $edate_year . $edate_month . $edate_day;
            $enddate1 = $edate_year . "-" . $edate_month . "-" . $edate_day;
            ?>
            <!--
            <div style="width:236mm; margin:0px; height:40.1mm; min-height:40.1mm; border-bottom:2px solid #01a8ff; padding-bottom:20px; display:inline-block;" id="Table_01">
                <div style="text-align:left; width:50.00mm; float:left;">
                    <div><img src="img/christschool_logo.png" width="160px" height="160px"></div>
                </div>
                <div style="text-align:center;width:185.75mm; float:left; padding-top:25px;">
                    <h5 style="padding:0px; padding-bottom:3px; margin:0px; letter-spacing:2px; color:red; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:45px; ; font-weight:bold;">CHRIST MATRIC HR. SEC. SCHOOL</h5>
                    
                    <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-weight:bold; font-size:18px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Christ Nagar, Senneerkuppam Poonamallee, Chennai - 56</h5>
                    <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-size:16px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Contact : 044-32429897, 26790694, Email : christischool@gmail.com, Web: www.christschool.co.in</h5>
                </div>
            </div>
           -->
            <div style="max-height:500px;">
                <h2 style="line-height:46px; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:30px;">Income & Expense Ledger</h2>		
                <?php if($sdate==$edate){} else { ?>
                <span style="margin:0px 50px 10px 0px; float:right;"><img src="img/icons/packs/fugue/16x16/calendar-next.png"> Start Date : <strong> <?php echo $sdate; ?></strong> | <img src="img/icons/packs/fugue/16x16/calendar-previous.png"> End Date : <strong><?php echo $edate; ?></strong> </span>
                <?php } ?>
                <?php 
                            $summary=array();
                            $begin = new DateTime($startdate1);
                            $end = new DateTime($enddate1);
                            $end->modify('+1 day');
                            $interval = DateInterval::createFromDateString('1 day');
                            $period = new DatePeriod($begin, $interval, $end);
                            ?>
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
                                <?php 
                            foreach ( $period as $dt ) {
                                //echo $dt->format( "Y-m-d" ).'<br>';
                                $startdate = $dt->format( "Ymd" );
                                $startdate1 = $dt->format( "Y-m-d" );
                                $enddate = $dt->format( "Ymd" );
                                $enddate1 = $dt->format( "Y-m-d" );
                                $sameday=$dt->format( "d/m/Y" );
                            ?>
                           
                            
               <tbody>
                    <tr>
                                        <th colspan='5'><span style="margin:0px 50px 10px 0px; float:right;font-size:19px;"><img src="img/icons/packs/fugue/16x16/calendar-next.png"> Date : <strong> <?php echo $sameday; ?></strong></span></th>
                                        </tr>
                        						
                    
                                    <?php
                                            $count = 1;
                                            $total = 0;
                                            $indisplay = 1;

                                            /********************** Manager Fees Collection **********************************/
                                                 $feeslist1 = mysql_query("SELECT * FROM feescollection WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and fee_by='$user'");
                                               
                                                $n=1;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    echo '<tr>';
                                                    echo '<td></td>';
                                                    echo '<td colspan="4">'.$fees1['cashier'].'</td>';
                                                    echo '</tr>';
                                                    $id1 = $fees1['id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM feescollection_child WHERE id=$id1");
                                                   $count=1;
                                                   while ($f1 = mysql_fetch_assoc($feesummarry1)) { 
                                            $amt=$f1['amount'];
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td><center><?= $f1['fees']?></center></td>
                                                <td class="total"><center>-</center></td>
                                            <td class="total">Rs. <?php echo number_format($amt, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $total += $amt;
                                            $count++;
                                           }
                                           $n++;
                                        }
                                            /********************** Manager Fees Collection End ******************************/
                                            
                                            /*********************************Other Fees******************************* */
                                            $qry5 = mysql_query("SELECT fgd_id,name,fg_id FROM fgroup_detail");
                                            while ($row5 = mysql_fetch_assoc($qry5)) {
                                                if($row5['fg_id']==4) {
                                                $fgd_id = $row5['fgd_id'];
                                                $fg_amount = 0;
                                                $feeslist = mysql_query("SELECT fi_id FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND fi_by='$user'");
                                                while ($fees = mysql_fetch_assoc($feeslist)) {
                                                    $fi_id = $fees['fi_id'];
                                                    $feesummarry = mysql_query("SELECT amount FROM fsalessumarry WHERE fi_id=$fi_id AND fgd_id=$fgd_id");
                                                    while ($fsummarry = mysql_fetch_assoc($feesummarry)) {
                                                        $amount = $fsummarry['amount'];
                                                        $fg_amount += $amount;
                                                    }
                                                }

                                                if ($fg_amount != 0) {
                                                    $total += $fg_amount;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>          
                                                        <td><center><?php echo $row5['name']; ?></center></td>
                                                <td class="total"><center>-</center></td>
                                                <td class="total">Rs. <?php echo number_format($fg_amount, 2); ?></td>
                                                <td class="total"><center>-</center></td>
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        }
                                        }
                                                $fg_amount_cl = 0;
                                                $fg_amount_cm = 0;
                                                $fg_amount_ch = 0;
                                                $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CL%' AND fi_by='$user'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($feesummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['amount'];
                                                        $fg_amount_cl += $amount;
                                                        }
                                                    }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_cl != 0) {
                                            $total += $fg_amount_cl;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td><center>KG Term Fees (<?= $frmmto?>)</center></td>
                                                <td class="total"><center>-</center></td>
                                            <td class="total">Rs. <?php echo number_format($fg_amount_cl, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                        $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CM%' AND fi_by='$user'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($feesummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['amount'];
                                                        $fg_amount_cm += $amount;
                                                        }
                                                    }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_cm != 0) {
                                            $total += $fg_amount_cm;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td><center>HS Term Fees (<?= $frmmto?>)</center></td>
                                                <td class="total"><center>-</center></td>
                                            <td class="total">Rs. <?php echo number_format($fg_amount_cm, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                                $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CH%' AND fi_by='$user'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($feesummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['amount'];
                                                        $fg_amount_ch += $amount;
                                                        }
                                                    }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_ch != 0) {
                                            $total += $fg_amount_ch;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td><center>HSS Term Fees (<?= $frmmto?>)</center></td>
                                                <td class="total"><center>-</center></td>
                                            <td class="total">Rs. <?php echo number_format($fg_amount_ch, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        } ?>
                                        <!-- ****************Books, Notes & Other Items *************************--> 
                                        <?php
                                        $other=mysql_query("SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' and c_status!='1' AND i_status='0' AND fi_by='$user'");

                                        $book=0;
                                        $from='';
                                        $to='';
                                        $fromto='';
                                        $n=1;
                                        while($all=mysql_fetch_assoc($other)){
                                           if($n==1){
                                             $from=$all['fr_no'];
                                         }
                                             $to=$all['fr_no'];
                                         $n++;
                                            $book+=$all['fi_total'];
                                           
                                        }
                                        if($from==$to)
                                            $fromto=$from;
                                        else
                                            $fromto=$from.'-'.$to;
                                        if($book!=0) {
                                        ?>
                                        <tr>
                                                    <td><?php echo $count; $count++;?></td>          
                                                    <td><center>Books, Notes & Other Items Fees (<?= $fromto?>)</center></td>
                                                <td class="total"><center>-</center></td>
                                                <td class="total">Rs. <?php echo number_format($book, 2); ?></td>
                                                <td class="total"><center>-</center></td>
                                                </tr>
                                        <?php } ?>  
                                         <?php 
                                        $other=mysql_query("SELECT * FROM tc_xi WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' AND tc_by='$user'");

                                        $tc=0;
                                        
                                        while($all=mysql_fetch_assoc($other)){
                                           
                                            $tc+=$all['tc_amount'];
                                           
                                        }
                                        
                                        $other=mysql_query("SELECT * FROM tc_xi_kg WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' AND tc_kg_by='$user'");

                                        
                                        
                                        while($all=mysql_fetch_assoc($other)){
                                           
                                            $tc+=$all['tc_amount'];
                                           
                                        }
                                        $total+=$tc;
                                        if($tc!=0) {
                                        ?>
                                        <tr>
                                                    <td><?php echo $count; $count++;?></td>          
                                                    <td><center>TC Issued Charges</center></td>
                                                <td class="total"><center>-</center></td>
                                                <td class="total">Rs. <?php echo number_format($tc, 2); ?></td>
                                                <td class="total"><center>-</center></td>
                                                </tr>
                                        <?php } ?>   
                                              

<?php 

                    /*                     * **********************************************lastyesr Pending Fees ***************************************** */
                    $fg_amount = 0;
                    $feeslist = mysql_query("SELECT fi_id FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' and c_status!='1' AND i_status='0' AND fi_by='$user'");
                    while ($fees = mysql_fetch_assoc($feeslist)) {
                        $fi_id = $fees['fi_id'];
                        $feesummarry = mysql_query("SELECT amount FROM fsalessumarry WHERE fi_id=$fi_id AND ftype='pending'");
                        while ($fsummarry = mysql_fetch_assoc($feesummarry)) {
                            $amount = $fsummarry['amount'];
                            $fg_amount += $amount;
                        }
                    }

                    if ($fg_amount != 0) {
                        $total += $fg_amount;
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>			
                            <td><b><center>Last Year Pending Fees</center></b></td>
                            <td class="total"><center>-</center></td>
                        <td class="total">Rs. <?php echo number_format($fg_amount, 2); ?></td>
                        <td class="total"><center>-</center></td>
                        </tr>
                        <?php
                        $count++;
                    }
                    $etotal = 0;
                    $qry1 = mysql_query("SELECT fund_amount FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND funds='1' and c_status!='1' AND i_status='0' AND fi_by='$user'");
                    $sdf_total = 0;
                    while ($row1 = mysql_fetch_assoc($qry1)) {
                        $sdf_tamount = $row1['fund_amount'];
                        $sdf_total +=$sdf_tamount;
                    }
                    if ($sdf_total) {
                        $etotal += $sdf_total;
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>			
                            <td><b><center>Student Discount Funds</center></b></td>
                            <td class="total">Rs. <?php echo number_format($sdf_total, 2); ?></td>
                        <td class="total"><center>-</center></td>
                        <td class="total"><center>-</center></td>
                        </tr>
                        <?php
                        $count++;
                    }
                    ?>
                            <!--<tr>
    <td colspan="4" class="sub_total"><center><b>Other Fees</b></center></td>
</tr>-->
                    <?php
                    $book_amount = 0;
                    $booklist = mysql_query("SELECT i_total FROM invoice WHERE (i_year*10000) + (i_month*100) + i_day between '" . $startdate . "' AND '" . $enddate . "' and i_status='0'");
                    while ($book1 = mysql_fetch_assoc($booklist)) {
                        $bamont = $book1['i_total'];
                        $book_amount += $bamont;
                    }
                    if ($book_amount != 0) {
                        $total +=$book_amount;
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>			
                            <td><b><center>Book Fees</center></b></td>
                            <td class="total"><center>-</center></td>
                        <td class="total">Rs. <?php echo number_format($book_amount, 2); ?></td>
                        <td class="total"><center>-</center></td>
                        </tr>
                        <?php
                        $count++;
                    }
$f=1;
                    $bamountthisyear = 0;
                    $bus_lastyear = 0;
                    $booklist1 = mysql_query("SELECT fi_total,pending,fr_no FROM bfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND c_status!='1' AND i_status='0' AND bfi_by='$user'");
                     $n=0;
                                        $cls='';
                                        $cle='';
                    while ($bus1 = mysql_fetch_assoc($booklist1)) {
                        if($f==1){
                                                    $start_binv = $bus1['fr_no'];
                                                    }
                                                    $end_binv = $bus1['fr_no'];
                                                    $f++;
                        $bamont1 = $bus1['fi_total'];
                        $pending1 = $bus1['pending'];
                        $bus_amount = $bamont1 - $pending1;
                        $bamountthisyear += $bus_amount;
                        $bus_lastyear += $pending1;
                        $cle=$bus1['fr_no'];
                    }
                     $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                    if ($bamountthisyear != 0) {
                        $total +=$bamountthisyear;
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>			
                            <td><center>Bus Fees (<?= $start_binv.'-'.$end_binv; ?>)</center></td>
                            <td class="total"><center>-</center></td>
                        <td class="total">Rs. <?php echo number_format($bamountthisyear, 2); ?></td>
                        <td class="total"><center>-</center></td>
                        </tr>
                        <?php
                        $count++;
                    }
                    if ($bus_lastyear != 0) {
                        $total +=$bus_lastyear;
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>			
                            <td><b><center>Last Year Pending Bus Fees</center></b></td>
                            <td class="total"><center>-</center></td>
                        <td class="total">Rs. <?php echo number_format($bus_lastyear, 2); ?></td>
                        <td class="total"><center>-</center></td>
                        </tr>
                        <?php
                        $count++;
                    }
                    /*                     * ************************************* Loan Payment Income *********************************************** */
                    $loanpay_amount = 0;
                    $booklist = mysql_query("SELECT amount FROM staff_loan_pay WHERE (year*10000) + (month*100) + day between '" . $startdate . "' AND '" . $enddate . "' AND login_user_name='$user'");
                    while ($book1 = mysql_fetch_assoc($booklist)) {
                        $lamont = $book1['amount'];
                        $loanpay_amount += $lamont;
                    }
                    if ($loanpay_amount != 0) {
                        $total +=$loanpay_amount;
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>			
                            <td><b><center>Loan Payment</center></b></td>
                            <td class="total"><center>-</center></td>
                        <td class="total">Rs. <?php echo number_format($loanpay_amount, 2); ?></td>
                        <td class="total"><center>-</center></td>
                        </tr>
                        <?php
                        $count++;
                    }
                    ?>
                    <?php
                    $indisplay = 1;
                    $classl = mysql_query("SELECT inc_id,in_category FROM in_category");
                    while ($row1 = mysql_fetch_assoc($classl)) {
                        $incid = $row1['inc_id'];
                        $in_amount = 0;
                        $booklist1 = mysql_query("SELECT amount FROM income WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND inc_id=$incid AND inc_by='$user'");
                        while ($bus1 = mysql_fetch_assoc($booklist1)) {
                            $bamont1 = $bus1['amount'];
                            $in_amount += $bamont1;

                            $total +=$in_amount;
                        }
                        if ($in_amount != 0) {
                            if ($indisplay == '1') {
                                ?>
                                <tr>
                                    <td></td>
                                    <td><b>Income Categories:</b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                                $indisplay = 0;
                            }
                            ?>
                            <tr>
                                <td><?php echo $count; ?></td>			
                                <td><center><?= $row1['in_category'] ?></center></td>
                            <td class="total"><center>-</center></td>
                            <td class="total">Rs. <?php echo number_format($in_amount, 2); ?></td>
                            <td class="total"><center>-</center></td>
                            </tr>
                            <?php
                            $count++;
                        }
                    }
                    ?>
                          
                    <?php
                    $qry6 = mysql_query("SELECT exc_id,ex_category,e_category FROM ex_category");
                    $excount = 1;
                    $indisplay = 1;
                    while ($row6 = mysql_fetch_assoc($qry6)) {
                        $e_category = $row6['e_category'];
                        $exc_id = $row6['exc_id'];
                        $exsqry = mysql_query("SELECT * FROM ex_insubcategory where category='$exc_id'  order by count asc");
                        $cont = 1;
                        while ($exrow = mysql_fetch_assoc($exsqry)) {
                            $category_id = $exrow["category"];
                            $exsid = $exrow["exs_id"];
                            $count1 = $exrow["count"];
                            $subexname = $exrow["sub_name"];
                            if ($count1 == 0) {
                                for ($j = 1; $j <= 20; $j++) {
                                    $sub_id = $exrow["sub" . $j . "_id"];

                                    if ($sub_id != 0) {
                                        $field = $j;
                                    }
                                }
                                $fieldno = $field + 1;
                                $myarray = array();
                                array_push($myarray, $exsid);
                                $subname = "sub" . $fieldno . "_id";
                                $classlist2 = mysql_query("SELECT exs_id FROM ex_insubcategory WHERE $subname='$exsid'");
                                while ($class2 = mysql_fetch_assoc($classlist2)) {
                                    //$sub_id=$class1["sub".$j."_id"];
                                    array_push($myarray, $class2['exs_id']);
                                }

                                $exc_amount = 0;
                                $feeslist1 = mysql_query("SELECT status,amount,pending FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND exc_id=$exc_id  AND  exs_id IN (" . implode(',', $myarray) . ") AND type=0 AND billgenerate='$user'");
                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                    $type = $fees1['type'];
                                    $status = $fees1['status'];
                                    $amount1 = $fees1['amount'];
                                    if ($status == '1') {
                                        $exc_amount += $amount1;
                                    }
                                }

                                //parcial qoutation payment
                                $feeslist1 = mysql_query("SELECT ex_id,amount FROM exponses_bill_summary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND exc_id=$exc_id");
                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                    $amount1 = $fees1['amount'];
                                    $exid = $fees1['ex_id'];
                                    $check1 = mysql_query("SELECT ex_id FROM exponses WHERE ex_id=$exid AND exc_id=$exc_id  AND  exs_id IN (" . implode(',', $myarray) . ") AND billgenerate='$user'");
                                    $checkcount = mysql_num_rows($check1);
                                    if ($checkcount > 0) {
                                        $exc_amount += $amount1;
                                    }
                                }

                                if ($exc_amount != 0) {
                                    if ($indisplay == '1') {
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td><b>Expence Categories :</b></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <?php
                                        $indisplay = 0;
                                    }
                                    if ($cont == '1') {
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td style="padding-left:25px;"><?php echo $excount . ". " . $row6['ex_category'] ?> :</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <?php
                                        $cont = 0;
                                        $excount++;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>			
                                        <td><center><?php echo $subexname; ?></center></td>
                                    <?php if ($e_category == '1') { ?>
                                        <td class="total"><center>-</center></td>
                                        <td class="total"><center>-</center></td>
                                        <td class="total">Rs. <?php echo number_format($exc_amount, 2); ?></td>
                                        <?php
                                        $assettotal += $exc_amount;
                                    } else {
                                        ?>
                                        <td class="total">Rs. <?php echo number_format($exc_amount, 2); ?></td>
                                        <td class="total"><center>-</center></td>
                                        <td class="total"><center>-</center></td>
                                        <?php
                                        $etotal += $exc_amount;
                                    }
                                    ?>
                                    </tr>
                                    <?php
                                    $count++;
                                }
                            }
                        }
                    }
                    /*                     * ********************************daily Allowance ******************************** */
                    $d_amount = 0;
                    $booklist1 = mysql_query("SELECT total_amount FROM exp_allowance WHERE (cdate >= '$startdate1' AND cdate <= '$enddate1') AND bill_by='$user'");
                    while ($bus1 = mysql_fetch_assoc($booklist1)) {
                        $bamont1 = $bus1['total_amount'];
                        $d_amount += $bamont1;
                    }
                    if ($d_amount != 0) {
                        $etotal +=$d_amount;
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>			
                            <td><b><center>Daily Allowance</center></b></td>
                            <td class="total">Rs. <?php echo number_format($d_amount, 2); ?></td>
                        <td class="total"><center>-</center></td>
                        <td class="total"><center>-</center></td>
                        </tr>
                        <?php
                        $count++;
                    }

                    /*                     * ********************************Principal Salary ******************************** */
                    $sqry = mysql_query("SELECT st_id FROM staff Where prince='1'");
                    $srow = mysql_fetch_assoc($sqry);
                    $pstid1 = $srow['st_id'];
                    $exc_amount1 = 0;

                    $feeslist2 = mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND st_id=$pstid1 AND login_user_name='$user'");
                    while ($fees2 = mysql_fetch_assoc($feeslist2)) {
                        $amount2 = $fees2['n_salary'];
                        $exc_amount1 += $amount2;
                    }
                    $etotal +=$exc_amount1;
                    if ($exc_amount1 != 0) {
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>			
                            <td><b><center>Principal Salary</center></b></td>
                            <td class="total">Rs. <?php echo number_format($exc_amount1, 2); ?></td>
                        <td class="total"><center>-</center></td>
                        <td class="total"><center>-</center></td>
                        </tr>
                        <?php
                        $count++;
                    }

                    /*                     * ********************************Teaching Staff Salary ******************************** */
                    $exc_amount1 = 0;
                    $feeslist2 = mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND st_id AND st_id!=$pstid1 AND login_user_name='$user'");
                    while ($fees2 = mysql_fetch_assoc($feeslist2)) {
                        $amount2 = $fees2['n_salary'];
                        $exc_amount1 += $amount2;
                    }
                    $etotal +=$exc_amount1;
                    if ($exc_amount1 != 0) {
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>			
                            <td><b><center>Teaching Staff Salary</center></b></td>
                            <td class="total">Rs. <?php echo number_format($exc_amount1, 2); ?></td>
                        <td class="total"><center>-</center></td>
                        <td class="total"><center>-</center></td>
                        </tr>
                        <?php
                        $count++;
                    }

                    /*                     * ********************************Non-Teaching Staff Salary ******************************** */
                    $exc_amount1 = 0;
                    $feeslist2 = mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND (o_id OR d_id) AND login_user_name='$user'");
                    while ($fees2 = mysql_fetch_assoc($feeslist2)) {
                        $amount2 = $fees2['n_salary'];
                        $exc_amount1 += $amount2;
                    }
                    $etotal +=$exc_amount1;
                    if ($exc_amount1 != 0) {
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>			
                            <td><b><center>Non-Teaching Staff Salary</center></b></td>
                            <td class="total">Rs. <?php echo number_format($exc_amount1, 2); ?></td>
                        <td class="total"><center>-</center></td>
                        <td class="total"><center>-</center></td>
                        </tr>
                        <?php
                        $count++;
                    }
                    /*                     * ******************************** Staff Salary Advance  ******************************** */
                    $exc_amount1 = 0;
                    $feeslist2 = mysql_query("SELECT a_amount FROM staff_advance WHERE (year*10000) + (month*100) + day between '" . $startdate . "' AND '" . $enddate . "' AND status=0 AND login_user_name='$user'");
                    while ($fees2 = mysql_fetch_assoc($feeslist2)) {
                        $amount2 = $fees2['a_amount'];
                        $exc_amount1 += $amount2;
                    }
                    $etotal +=$exc_amount1;
                    if ($exc_amount1 != 0) {
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>			
                            <td><b><center>Staff Salary Advance </center></b></td>
                            <td class="total">Rs. <?php echo number_format($exc_amount1, 2); ?></td>
                        <td class="total"><center>-</center></td>
                        <td class="total"><center>-</center></td>
                        </tr>
                        <?php
                        $count++;
                    }
                    /*                     * ******************************** EPF - ESI Contribution ******************************** */
                    $alldedlist2 = mysql_query("SELECT id,name FROM staff_allw_ded WHERE pe_type!=0");
                    while ($allded2 = mysql_fetch_assoc($alldedlist2)) {
                        $adid = $allded2['id'];
                        $adname = $allded2['name'];
                        $exc_amount1 = 0;
                        $feeslist2 = mysql_query("SELECT b.pevalue,b.amount FROM staff_month_salary a, staff_month_salary_summary b WHERE (a.year*10000) + (a.month*100) + a.day between '" . $startdate . "' AND '" . $enddate . "' AND a.st_ms_id = b.st_ms_id AND b.ad_id=$adid AND b.pevalue AND login_user_name='$user'");
                        while ($fees2 = mysql_fetch_assoc($feeslist2)) {
                            $staffpreamount = $fees2['amount'];
                            $preamount = $fees2['pevalue'];
                            if ($staffpreamount) {
                                $exc_amount1 += $staffpreamount + $preamount;
                            }
                        }
                        $etotal +=$exc_amount1;
                        if ($exc_amount1 != 0) {
                            ?>
                            <tr>
                                <td><?php echo $count; ?></td>			
                                <td><b><center><?php echo $adname . " Contribution"; ?></center></b></td>
                                <td class="total">Rs. <?php echo number_format($exc_amount1, 2); ?></td>
                            <td class="total"><center>-</center></td>
                            <td class="total"><center>-</center></td>
                            </tr>
                            <?php
                            $count++;
                        }
                    } ?>
               
<?php

                    /*                     * ***********************advance expense**************************** */
                    $qry_adv = "SELECT sum(adv_amt) as advance FROM agency_advance WHERE DATE(adv_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND billgenerate='$user'";
                    $advance_qry = mysql_query($qry_adv);
                    $advance_result = mysql_fetch_assoc($advance_qry);


                    
                    if ($advance_result['advance'] != 0) {
                        $etotal = $etotal + $advance_result['advance'];
                        ?>        

                        <tr>
                            <td><?php echo $count; ?></td>
                            <td> ADVANCE PAYMENT </td>
                            <td class="total"><?php echo "Rs. " . number_format($advance_result['advance'], 2); ?></td>
                        <td><center>-</center></td>
                        <td><center>-</center></td>
                        </tr> 
                        <?php
                        $count++;
                    }

                    /*                     * *********************** Inventory Purchase Expense **************************** */
                    $qry_pur = "SELECT sum(overeall_total) as purchase_amt FROM inv_purchase_parent WHERE DATE(purchase_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND billgenerate='$user'";
                    $pur_qry = mysql_query($qry_pur);
                    $pur_result = mysql_fetch_assoc($pur_qry);



                    if ($pur_result['purchase_amt'] != 0) {
                        $etotal = $etotal + $pur_result['purchase_amt'];
                       $all = "SELECT  * FROM inv_purchase_parent WHERE DATE(purchase_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND billgenerate='$user'";
                                        $from='';
                                        $to='';
                                        $n=1;
                                        $fromto='';
                                        $deff = mysql_query($all);
                                        while($row=mysql_fetch_assoc($deff)){
                                                if($n==1)
                                                    $from=$row['purchase_no'];
                                                $to=$row['purchase_no'];
                                                $n++;
                                        }
                                        
                                         if($from==$to)
                                            $fromto="PB" . str_pad($from, 5, '0', STR_PAD_LEFT);
                                        else
                                            $fromto="PB" . str_pad($from, 5, '0', STR_PAD_LEFT).'-'."PB" . str_pad($to, 5, '0', STR_PAD_LEFT);
                                        ?>

                        <tr>
                            <td><?php echo $count; ?></td>
                            <td> INVENTORY PURCHASE (<?= $fromto?>)</td>
                            <td class="total"><?php echo "Rs. " . number_format($pur_result['purchase_amt'], 2); ?></td>
                        <td><center>-</center></td>
                        <td><center>-</center></td>
                        </tr>

                        <?php
                        $count++;
                    }
                    /*                     * *********************** Inventory Material Issue Income **************************** */
                    $qry_mat = "SELECT sum(overall_total) as material_amt FROM inv_material_parent WHERE DATE(mat_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND stud_staff=1 AND billgenerate='$user'";
                    $mat_qry = mysql_query($qry_mat);
                    $mat_result = mysql_fetch_assoc($mat_qry);



                    if ($mat_result['material_amt'] != 0) {
                        $total = $total + $mat_result['material_amt'];
                        $qry_mat1 = "SELECT * FROM inv_material_parent WHERE DATE(mat_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND stud_staff=1 AND billgenerate='$user'";
                                        $from='';
                                        $to='';
                                        $n=1;
                                        $fromto='';
                                        $mat_qry1 = mysql_query($qry_mat1);
                                        while($row=mysql_fetch_assoc($mat_qry1)){
                                                if($n==1)
                                                    $from=$row['bill_no'];
                                                    $to=$row['bill_no'];
                                                $n++;
                                        }
                                        if($from==$to)
                                            $fromto=$from;
                                        else
                                            $fromto=$from.'-'.$to;
                                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td> INVENTORY MATERIAL ISSUE (<?= $fromto?>)</td>
                            <td><center>-</center></td>
                        <td class="total"><?php echo "Rs. " . number_format($mat_result['material_amt'], 2); ?></td>
                        <td><center>-</center></td>
                        </tr>

                        <?php
                        $count++;
                    }
                    ?>
                    <?php if($etotal==0 && $total==0 && $assettotal==0) { ?>
                                         <tr class="remove"></tr>
                                         <?php }    ?>
                    <tr>
                        <td class="sub_total" colspan="2"> Total </td>
                        <td class="sub_total"><?php echo "Rs. " . number_format($etotal, 2); ?></td>
                    <td class="sub_total"><?php $total=$total+$book; echo "Rs. " . number_format($total, 2); ?></td>
                    <td class="sub_total"><?php echo "Rs. " . number_format($assettotal, 2); ?></td>
                    </tr>
                    <tr class="total_bar">
                        <td class="sub_total" colspan="3"><?php
                            $expencetotal = $etotal + $assettotal;
                            $finaltotal = $total - $expencetotal;
                            echo "Income : <b>Rs. " . number_format($total, 2) . "</b> | Expenses : <b>Rs. " . number_format($expencetotal, 2) . "</b> ( " . number_format($total, 0) . " - ( " . number_format($etotal, 0) . " + " . number_format($assettotal, 0) . " ))";
                            ?></td>
                        <td class="grand_total sub_total">Profit Total:</td>
                        <td class="grand_total sub_total">Rs. <?php echo number_format($finaltotal, 2); ?></td>
                    </tr>                        
                    </tbody>
               
                <?php 
                $summary[$sameday]=$etotal.'*|*'.$total.'*|*'.$assettotal;
                $etotal=0;
                $total=0;
                $assettotal=0;
                } ?>
                 </table>
                 <h2>Fees Concession</h2>
                                    <table class="table financetable" id="table-example">
                                        <thead>
                                            <tr>
                                                <th width="5%">S.No</th>
                                                <th width="70%"><center>Particular</center></th>
                                                <th width="10%"><center>Standard</center></th>
                                        <th class="total" widh="12%"><center>Amount</center></th>
                                        </tr>
                                        </thead>                        
                                        <tbody>
                                         <?php
                                            $count = 1;
                                           
                                        $fg_amount_cl = 0;
                                                $fg_amount_cm = 0;
                                                $fg_amount_ch = 0;
                                                $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CL%' AND fi_by='$user'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   $chk=0;
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($fsummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['discount'];
                                                        $chk+=$amount;
                                                        $fg_amount_cl += $amount;
                                                        }
                                                    }
                                                    if($chk){
                                                            echo '<tr><td></td>';
                                                            echo '<td style="text-align:right;">';
                                                            $cccid=$fees1['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                            echo  $fees1['fi_name'].' - '.$fees1['fr_no'].'</td><td><center>'.mysql_fetch_assoc($allc)['c_name'];
                                                            echo  '</center></td>';
                                                            echo '<td class="total">'.number_format($chk,2);
                                                            echo '</td>';
                                                            echo '</tr>';
                                                        }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_cl != 0) {
                                            $total += $fg_amount_cl;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td colspan="2"><center>KG Term Fees Concession (<?= $frmmto?>)</center></td>
                                                
                                            <td class="total">Rs. <?php echo number_format($fg_amount_cl, 2); ?></td>
                                            
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                        $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CM%' AND fi_by='$user'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   $chk=0;
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($fsummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['discount'];
                                                        $chk+=$amount;
                                                        $fg_amount_cm += $amount;
                                                        }
                                                    }
                                                    if($chk){
                                                            echo '<tr><td></td>';
                                                            echo '<td style="text-align:right;">';
                                                            $cccid=$fees1['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                            echo  $fees1['fi_name'].' - '.$fees1['fr_no'].'</td><td><center>'.mysql_fetch_assoc($allc)['c_name'];
                                                            echo  '</center></td>';
                                                            echo '<td class="total">'.number_format($chk,2);
                                                            echo '</td>';
                                                            echo '</tr>';
                                                        }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_cm != 0) {
                                            $total += $fg_amount_cm;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td colspan="2"><center>HS Term Fees Concession (<?= $frmmto?>)</center></td>
                                              
                                            <td class="total">Rs. <?php echo number_format($fg_amount_cm, 2); ?></td>
                                          
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                                $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CH%' AND fi_by='$user'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   $chk=0;
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($fsummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['discount'];
                                                        $chk+=$amount;
                                                        $fg_amount_ch += $amount;
                                                        }
                                                    }
                                                    if($chk){
                                                            echo '<tr><td></td>';
                                                            echo '<td style="text-align:right;">';
                                                            $cccid=$fees1['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                            echo  $fees1['fi_name'].' - '.$fees1['fr_no'].'</td><td><center>'.mysql_fetch_assoc($allc)['c_name'];
                                                            echo  '</center></td>';
                                                            echo '<td class="total">'.number_format($chk,2);
                                                            echo '</td>';
                                                            echo '</tr>';
                                                        }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_ch != 0) {
                                            $total += $fg_amount_ch;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td colspan="2"><center>HSS Term Fees (<?= $frmmto?>)</center></td>
                                                
                                            <td class="total">Rs. <?php echo number_format($fg_amount_ch, 2); ?></td>
                                            
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                             
                                        
                                        $other=mysql_query("SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' and c_status!='1' AND i_status='0' AND fi_by='$user'");

                                        $book=0;
                                        $from='';
                                        $to='';
                                        $fromto='';
                                        $n=1;
                                        while($all=mysql_fetch_assoc($other)){
                                           if($n==1){
                                             $from=$all['fr_no'];
                                         }
                                             $to=$all['fr_no'];
                                         $n++;
                                            $book+=$all['discount'];
                                           if($all['discount']){
                                                            echo '<tr><td></td>';
                                                            echo '<td style="text-align:right;">';
                                                            $cccid=$all['c_id'];
                                                             $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                            echo  $all['fi_name'].' - '.$all['fr_no'].'</td><td><center>'.mysql_fetch_assoc($allc)['c_name'];
                                                            echo  '</center></td>';
                                                            echo '<td class="total">'.number_format($all['discount'],2);
                                                            echo '</td>';
                                                            echo '</tr>';
                                                        }
                                        }
                                        if($from==$to)
                                            $fromto=$from;
                                        else
                                            $fromto=$from.'-'.$to;
                                        if($book!=0) {
                                        ?>

                                        <tr>
                                                    <td><?php echo $count; $count++;?></td>          
                                                    <td colspan="2"><center>Books, Notes & Other Items Fees Concession(<?= $fromto?>)</center></td>
                                                
                                                <td class="total">Rs. <?php echo number_format($book, 2); ?></td>
                                               
                                                </tr>
                                        <?php } ?> 
                                        <?php 
                                        $qry5 = mysql_query("SELECT fgd_id,name,fg_id FROM fgroup_detail");
                                            while ($row5 = mysql_fetch_assoc($qry5)) {
                                                if($row5['fg_id']==4) {
                                                $fgd_id = $row5['fgd_id'];
                                                $fg_amount = 0;
                                                $feeslist = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND fi_by='$user'");
                                                while ($fees = mysql_fetch_assoc($feeslist)) {
                                                    $fi_id = $fees['fi_id'];
                                                    $feesummarry = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id AND fgd_id=$fgd_id");
                                                    $chk=0;
                                                    while ($fsummarry = mysql_fetch_assoc($feesummarry)) {
                                                        $amount = $fsummarry['discount'];
                                                        $chk+=$amount;
                                                        $fg_amount += $amount;
                                                    }
                                                    if($chk){
                                                            echo '<tr><td></td>';
                                                            echo '<td style="text-align:right;">';
                                                            $cccid=$fees['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                             echo  $fees['fi_name'].' - '.$fees['fr_no'].'</td><td><center>'.mysql_fetch_assoc($allc)['c_name'];
                                                            echo  '</center></td>';
                                                            echo '<td class="total">'.number_format($chk,2);
                                                            echo '</td>';
                                                            echo '</tr>';
                                                        }
                                                }
                                                if ($fg_amount != 0) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>          
                                                        <td colspan="2"><center><?php echo $row5['name'].' Fees Concession'; ?></center></td>
                                                
                                                <td class="total">Rs. <?php echo number_format($fg_amount, 2); ?></td>
                                               
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        }
                                        }
                                        ?>
                                        </tbody>
                                        </table>

                  <?php if($_POST) { } else { ?>
                <h2>Income & Expenses Summary :</h2>
                                    <table class="table financetable" id="table-example">  
                                        <thead>
                                            <tr>
                                                <th width="5%">S.No</th>
                                                <th><center>Date</center></th>
                                                <th>Expenses</th>
                                                <th>Incomes</th>
                                                <th>Assets</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        //print_r($summary);
                                        $n=1;
                                        $wtot=0;
                                        $wincome=0;
                                        $wexpenses=0;
                                        $wassets=0;
                                        foreach ($summary as $key => $value) {
                                            //print_r($value);
                                             $alltot=explode('*|*',$value);
                                              if($alltot[0]=='0' && $alltot[1]=='0' && $alltot[2]=='0') 
                                                    echo '<tr class="kmt">';
                                                else
                                                    echo '<tr>';
                                                echo '<td>'.$n.'</td>';
                                                echo '<td>'.$key.'</td>';
                                                echo '<td>'.number_format($alltot[0],2).'</td>';
                                                echo '<td>'.number_format($alltot[1],2).'</td>';
                                                echo '<td>'.number_format($alltot[2],2).'</td>';
                                                echo '</tr>';
                                                $n++;
                                                $wincome+=$alltot[1];
                                                $wexpenses+=$alltot[0];
                                                $wassets+=$alltot[2];
                                        }
                                        $wtot=$wincome-($wexpenses+$wassets);
                                        ?>
                                                               
                                        <tbody>
                                        </tbody>
                                        </table>
                                        <?php } ?>
                <h3 align="left">Liabilities :</h3>
                <table class="table financetable" id="table-example">	
                    <thead>
                        <tr>
                            <th width="5%">S.No</th>
                            <th width="50%"><center>Particular</center></th>
                    <th class="total"><center>Pending</center></th>
                    </tr>
                    </thead>						
                    <tbody>
                        <?php
                        $count = 1;
                        $etotal1 = 0;
                        $qry6 = mysql_query("SELECT exc_id,ex_category FROM ex_category");
                        $excount = 1;
                        $indisplay = 1;
                        while ($row6 = mysql_fetch_array($qry6)) {
                            $exc_id = $row6['exc_id'];
                            $exsqry = mysql_query("SELECT * FROM ex_insubcategory where category='$exc_id' order by count asc");
                            $cont = 1;
                            while ($exrow = mysql_fetch_array($exsqry)) {
                                $category_id = $exrow["category"];
                                $exsid = $exrow["exs_id"];
                                $count1 = $exrow["count"];
                                $subexname = $exrow["sub_name"];
                                if ($count1 == 0) {
                                    for ($j = 1; $j <= 20; $j++) {
                                        $sub_id = $exrow["sub" . $j . "_id"];

                                        if ($sub_id != 0) {
                                            $field = $j;
                                        }
                                    }
                                    $fieldno = $field + 1;
                                    $myarray = array();
                                    array_push($myarray, $exsid);
                                    $subname = "sub" . $fieldno . "_id";
                                    $classlist2 = mysql_query("SELECT exs_id FROM ex_insubcategory WHERE $subname='$exsid'");
                                    while ($class2 = mysql_fetch_array($classlist2)) {
                                        //$sub_id=$class1["sub".$j."_id"];
                                        array_push($myarray, $class2['exs_id']);
                                    }

                                    $exc_amount = 0;
                                    //$feeslist1=mysql_query("SELECT ex_id,amount FROM exponses WHERE ((date_year*10000) + (date_month*100) + date_day) <= '" . $enddate. "' AND exc_id=$exc_id AND  exs_id IN (".implode(',',$myarray).") AND type='1'"); 
                                    $feeslist1 = mysql_query("SELECT ex_id,amount FROM exponses WHERE ((date_year*10000) + (date_month*100) + date_day) between '" . $startdate . "' AND '" . $enddate . "' AND exc_id=$exc_id AND  exs_id IN (" . implode(',', $myarray) . ") AND type='1' AND billgenerate='$user'");
                                    while ($fees1 = mysql_fetch_array($feeslist1)) {
                                        $exid = $fees1['ex_id'];
                                        $amount1 = $fees1['amount'];
                                        $amountpaid = 0;
                                        $pending = 0;
                                        $bill_summery = mysql_query("SELECT amount FROM exponses_bill_summary WHERE ((date_year*10000) + (date_month*100) + date_day) <= '" . $enddate . "' AND ex_id=$exid AND exc_id=$exc_id");
                                        while ($summery = mysql_fetch_assoc($bill_summery)) {
                                            $amountpaid +=$summery['amount'];
                                        }
                                        //echo $amount1."-".$amountpaid."<br>";
                                        $pending = $amount1 - $amountpaid;
                                        $exc_amount += $pending;
                                    }
                                    if ($exc_amount != 0) {
                                        if ($cont == '1') {
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td style="padding-left:25px;"><b><?php echo $excount . ". " . $row6['ex_category'] ?> :</b></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            $cont = 0;
                                            $excount++;
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>			
                                            <td><center><?php echo $subexname; ?></center></td>
                                    <td class="total"><center>Rs. <?php echo number_format($exc_amount, 2); ?></center></td>
                                    </tr>
                                    <?php
                                    $count++;
                                }
                                $etotal1 += $exc_amount;
                            }
                        }
                    }
                    ?>
                    <tr>
                        <td class="sub_total" colspan="2"> Total </td>
                        <td class="sub_total"><center><?php echo "Rs. " . number_format($etotal1, 2); ?></center></td>
                    </tr>
                    <tr class="total_bar">
                        <td class="sub_total" colspan="2"><?php
                            $finaltotal1 = $wtot - $etotal1;
                            echo "Profit Total : <b>Rs. " . number_format($wtot, 2) . "</b> | Liabilities  : <b>Rs. " . number_format($etotal1, 2) . "</b> ( " . number_format($wtot, 0) . " - " . number_format($etotal1, 0) . " )";
                            ?></td>
                        <td class="grand_total sub_total"><span style="float:left">Profit Total:</span>Rs. <?php echo number_format($finaltotal1, 2); ?></td>
                    </tr> 
                    </tbody>
                </table>
                <?php if($_POST) { ?>
                <br>
                  <div style="width:60%; float: right;">
  <div style="float: left;">
                   <table class="financetable" style="">
                            <tr>
                               <th style=""> Bank Notes </th><th> Nos </th><th> Amount </th></tr>
                                <tr><td>Rs 5</td><td><?= $_POST['n5']?></td><td style="width:35%"><span id="n5" class="denom"><?= $_POST['n5']*5?></span></td></tr>
                                <tr><td>Rs 10</td><td><?= $_POST['n10']?></td><td style="width:35%"><span id="n10" class="denom"><?= $_POST['n10']*10?></span></td></tr>
                                <tr><td>Rs 20</td><td><?= $_POST['n20']?></td><td style="width:35%"><span id="n20" class="denom"><?= $_POST['n20']*20?></span></td></tr>
                                <td>Rs 50</td><td><?= $_POST['n50']?></td><td style="width:35%"><span id="n50" class="denom"></span><?= $_POST['n50']*50?></td></tr>
                                <td>Rs 100</td><td><?= $_POST['n100']?></td><td style="width:35%"><span id="n100" class="denom"><?= $_POST['n100']*100?></span></td></tr>
                                <td>Rs 500</td><td><?= $_POST['n500']?></td><td style="width:35%"><span id="n500" class="denom"><?= $_POST['n500']*500?></span></td></tr>
                                <td>Rs 1000</td><td><?= $_POST['n1000']?></td><td style="width:35%"><span id="n1000" class="denom"><?= $_POST['n1000']*1000?></span></td></tr>
                                <tr><th colspan="2">Sub Total</th><th><span id="wtot"><?= $_POST['ntot']?></span></th></tr>
                                
                            </table>
                            </div>
                <div style="float: left;padding-left:30px;">
                 <table class="financetable" style="">
                            <tr>
                                <th style=""> Coins </th><th> Nos </th><th> Amount </th></tr>
                                <tr><td>Rs 1</td> <td><?= $_POST['c1']?></td><td style="width:35%"><span id="c1" class="denom"><?= $_POST['c1']*1?></span></td></tr>
                                <tr><td>Rs 2</td><td><?= $_POST['c2']?></td><td style="width:35%"><span id="c2" class="denom"><?= $_POST['c2']*2?></span></td></tr>
                                <tr><td>Rs 5</td> <td><?= $_POST['c5']?></td><td style="width:35%"><span id="c5" class="denom"><?= $_POST['c5']*5?></span></td></tr>
                                <tr><td>Rs 10</td><td><?= $_POST['c10']?></td><td style="width:35%"><span id="c10" class="denom"><?= $_POST['c10']*10?></span></td></tr>
                                <tr><th colspan="2">Sub Total</th><th><span id="wtot"><?= $_POST['ctot']?></span></th></tr>
                            </table>
                            <br><br><br>
                            <center><b>Total: </b><span id="wtot"><b><?= $_POST['wtot']?></b></span></center>
                           </div>
                             </div>
 
                            <?php } ?>
            </div>
        </div>
        <!-- <div class="Invitation">
<img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
        <p>&nbsp;    </p>
    </div>

</body></html>