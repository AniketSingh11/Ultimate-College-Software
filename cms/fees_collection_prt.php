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
                    $cashier=$_GET['cashier'];
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
                        $id=$_GET['id'];
                        $sql=mysql_query("select * from feescollection where id='$id' and ay_id='$acyear'");
                        $givenamount=mysql_fetch_assoc($sql)['amount_given'];
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
                <h2 style="line-height:46px; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:30px;">Fees Collection </h2>     
                <?php if($sdate==$edate){} else { ?>
                <span style="margin:0px 50px 10px 0px; float:right;"><img src="img/icons/packs/fugue/16x16/calendar-next.png"> Start Date : <strong> <?php echo $sdate; ?></strong> | <img src="img/icons/packs/fugue/16x16/calendar-previous.png"> End Date : <strong><?php echo $edate; ?></strong> </span>
                <?php } ?>
               
                             <table  class="table financetable" width="100%" border="1" cellpadding="0" cellspacing="0" id="Table_01">  
                                        <thead>
                                            <tr>
                                                <th width="5%">S.No</th>
                                                <th width="50%"><center>Particular</center></th>
                                       <th class="total"><center>Income</center></th>
                                        </tr>
                                        </thead>                        
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            $total = 0;
                                            $indisplay = 1;
                                            /** *******************************Other Fees******************************* */
                                            $qry5 = mysql_query("SELECT fgd_id,name,fg_id FROM fgroup_detail");
                                            while ($row5 = mysql_fetch_assoc($qry5)) {
                                                if($row5['fg_id']==4) {
                                                $fgd_id = $row5['fgd_id'];
                                                $fg_amount = 0;
                                                $feeslist = mysql_query("SELECT fi_id FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND fi_by='$cashier'");
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
                                                        <td>
                                                        <input type="hidden" name="income[]" value="<?= $row5['name']?>">
                                                        <center><?php echo $row5['name']; ?></center></td>
                                                <td class="total">
                                                <input type="hidden" name="amount[]" value="<?= $fg_amount?>">
                                                Rs. <?php echo number_format($fg_amount, 2); ?></td>
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        }
                                        }
                                        $fg_amount_cl = 0;
                                                $fg_amount_cm = 0;
                                                $fg_amount_ch = 0;
                                                $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CL%' AND fi_by='$cashier'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($fsummarry1['fg_id']==4){}
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
                                                <td>
                                                <input type="hidden" name="income[]" value="KG Term Fees (<?= $frmmto?>)">
                                                <center>KG Term Fees (<?= $frmmto?>)</center></td>
                                            <td class="total">
                                             <input type="hidden" name="amount[]" value="<?= $fg_amount_cl?>">
                                            Rs. <?php echo number_format($fg_amount_cl, 2); ?></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                        $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CM%' AND fi_by='$cashier'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($fsummarry1['fg_id']==4){}
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
                                                <td>
                                                      <input type="hidden" name="income[]" value="HS Term Fees (<?= $frmmto?>)">
                                                <center>HS Term Fees (<?= $frmmto?>)</center></td>
                                               
                                            <td class="total">
                                                     <input type="hidden" name="amount[]" value="<?= $fg_amount_cm?>">
                                            Rs. <?php echo number_format($fg_amount_cm, 2); ?></td>
                                            
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                                $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CH%' AND fi_by='$cashier'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($fsummarry1['fg_id']==4){}
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
                                                <td>
                                                     <input type="hidden" name="income[]" value="HSS Term Fees (<?= $frmmto?>)">
                                                <center>HSS Term Fees (<?= $frmmto?>)</center></td>
                                               
                                            <td class="total">
                                                 <input type="hidden" name="amount[]" value="<?= $fg_amount_ch?>">
                                            Rs. <?php echo number_format($fg_amount_ch, 2); ?></td>
                                           
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                             
                                        
                                        $other=mysql_query("SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' and c_status!='1' AND i_status='0' AND fi_by='$cashier'");

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
                                                    <td>
                                                         <input type="hidden" name="income[]" value="Books, Notes & Other Items Fees (<?= $fromto?>)">
                                                    <center>Books, Notes & Other Items Fees (<?= $fromto?>)</center></td>
                                              
                                                <td class="total">
                                                  <input type="hidden" name="amount[]" value="<?= $book?>">   
                                                Rs. <?php echo number_format($book, 2); ?></td>
                                            
                                                </tr>
                                        <?php } ?> 
                                        <?php 
                                        $other=mysql_query("SELECT * FROM tc_xi WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' AND tc_by='$cashier'");

                                        $tc=0;
                                        
                                        while($all=mysql_fetch_assoc($other)){
                                           
                                            $tc+=$all['tc_amount'];
                                           
                                        }
                                        
                                        $other=mysql_query("SELECT * FROM tc_xi_kg WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' AND tc_kg_by='$cashier'");

                                        
                                        
                                        while($all=mysql_fetch_assoc($other)){
                                           
                                            $tc+=$all['tc_amount'];
                                           
                                        }
                                        $total+=$tc;
                                        if($tc!=0) {
                                        ?>
                                        <tr>
                                                    <td><?php echo $count; $count++;?></td>          
                                                    <td>
                                                         <input type="hidden" name="income[]" value="TC Issued Charges">
                                                    <center>TC Issued Charges</center></td>
                                               
                                                <td class="total">
                                                    <input type="hidden" name="amount[]" value="<?= $tc?>">   
                                                Rs. <?php echo number_format($tc, 2); ?></td>
                                               
                                                </tr>
                                        <?php } ?> 
                                                    
                                        <?php

                                        /* * **********************************************lastyesr Pending Fees ***************************************** */
                                        $fg_amount = 0;
                                        $feeslist = mysql_query("SELECT fi_id FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND fi_by='$cashier'");
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
                                                <td>
                                                      <input type="hidden" name="income[]" value="Last Year Pending Fees">
                                                <b><center>Last Year Pending Fees</center></b></td>
                                             
                                            <td class="total">
                                                 <input type="hidden" name="amount[]" value="<?= $fg_amount?>">  
                                            Rs. <?php echo number_format($fg_amount, 2); ?></td>
                                           
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        $etotal = 0;
                                       ?>
                                        <?php
                                        $bamountthisyear = 0;
                                        $bus_lastyear = 0;
                                        $booklist1 = mysql_query("SELECT * FROM bfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear AND c_status!='1' AND i_status='0' AND bfi_by='$cashier'");
                                        $n=0;
                                        $cls='';
                                        $cle='';
                                        while ($bus1 = mysql_fetch_assoc($booklist1)) {
                                            if($n==0){
                                                $cls=$bus1['fr_no'];
                                                $n++;
                                            }
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
                                                <td>
                                                      <input type="hidden" name="income[]" value="Bus Fees (<?= $frmmto?>)">
                                                <center>Bus Fees (<?= $frmmto?>)</center></td>
                                               
                                            <td class="total">
                                                 <input type="hidden" name="amount[]" value="<?= $bamountthisyear?>">
                                            Rs. <?php echo number_format($bamountthisyear, 2); ?></td>
  
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        if ($bus_lastyear != 0) {
                                            $total +=$bus_lastyear;
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td>
                                                     <input type="hidden" name="income[]" value="Last Year Pending Bus Fees">
                                                <b><center>Last Year Pending Bus Fees</center></b></td>
                                            
                                            <td class="total">
                                                 <input type="hidden" name="amount[]" value="<?= $bus_lastyear?>">
                                            Rs. <?php echo number_format($bus_lastyear, 2); ?></td>
                                          
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        /*                                         * ************************************* Loan Payment Income *********************************************** */
                                        $loanpay_amount = 0;
                                        $booklist = mysql_query("SELECT amount FROM staff_loan_pay WHERE (year*10000) + (month*100) + day between '" . $startdate . "' AND '" . $enddate . "' AND login_user_name='$cashier'");
                                        while ($book1 = mysql_fetch_assoc($booklist)) {
                                            $lamont = $book1['amount'];
                                            $loanpay_amount += $lamont;
                                        }
                                        if ($loanpay_amount != 0) {
                                            $total +=$loanpay_amount;
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td>
                                                      <input type="hidden" name="income[]" value="Loan Payment">
                                                <b><center>Loan Payment</center></b></td>
                                              
                                            <td class="total">
                                                  <input type="hidden" name="amount[]" value="<?= $loanpay_amount?>">
                                            Rs. <?php echo number_format($loanpay_amount, 2); ?></td>
                                          
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
                                            $booklist1 = mysql_query("SELECT amount FROM income WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND inc_id=$incid AND inc_by='$cashier'");
                                            while ($bus1 = mysql_fetch_assoc($booklist1)) {
                                                $bamont1 = $bus1['amount'];
                                                $in_amount += $bamont1;

                                                $total +=$in_amount;
                                            }
                                            if ($in_amount != 0) {
                                                if ($indisplay == '1') {
                                                    ?>
                                                    
                                                    <?php
                                                    $indisplay = 0;
                                                }
                                                ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>          
                                                    <td>
                                                          <input type="hidden" name="income[]" value="<?= $row1['in_category'] ?>">
                                                    <center><?= $row1['in_category'] ?></center></td>
                                              
                                                <td class="total">
                                                     <input type="hidden" name="amount[]" value="<?= $in_amount ?>">
                                                Rs. <?php echo number_format($in_amount, 2); ?></td>
                                          
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        }
                                        ?>
                                         
                                              
                                        <?php 
                                        /************************* Inventory Material Issue Income *****************************/
                                         $qry_mat = "SELECT sum(overall_total) as material_amt FROM inv_material_parent WHERE DATE(mat_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND stud_staff=1 AND billgenerate='$cashier'";
                                        $mat_qry = mysql_query($qry_mat);
                                        $mat_result = mysql_fetch_assoc($mat_qry);


                                       
                                        if($mat_result['material_amt']!=0){
                                             $total = $total + $mat_result['material_amt'];

                                        $qry_mat1 = "SELECT * FROM inv_material_parent WHERE DATE(mat_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND stud_staff=1 AND billgenerate!='$user'";
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
                                            <td> 
                                                 <input type="hidden" name="income[]" value="INVENTORY MATERIAL ISSUE (<?= $fromto?>)">
                                            INVENTORY MATERIAL ISSUE (<?= $fromto?>)</td>
                                           
                                        <td class="total">
                                             <input type="hidden" name="amount[]" value="<?= $mat_result['material_amt']?>">
                                        <?php echo "Rs. " . number_format($mat_result['material_amt'], 2); ?></td>
 
                                        </tr>
                                        
                                        <?php 
                                        $count++;
                                        }?>
                                        <tr>
                                            <td class="sub_total" colspan="2"> Total </td>
                                           
                                        <td class="sub_total"><?php $total=$total+$book; echo "Rs. " . number_format($total, 2); ?></td>
                                            <input type="hidden" name="amount_total" value="<?= $total?>"> 
                                             <input type="hidden" name="sdate" value="<?= $startdate1?>"> 
                                             <input type="hidden" name="edate" value="<?= $enddate1?>"> 
                                             <input type="hidden" name="cashier" value="<?= $cashier?>"> 
                                        </tr>  
                                         <tr>
                                            <td class="sub_total" colspan="2"> Amount Given </td>
                                           
                                        <td class="sub_total">
                                        <!-- <input type="text" value="" class="required text" name="amount_given" max="<?= $total?>"> -->
                                        <?php echo 'Rs. '.number_format($givenamount,2); ?>
                                        </td>
                                    
                                        </tr>  
                                                      
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