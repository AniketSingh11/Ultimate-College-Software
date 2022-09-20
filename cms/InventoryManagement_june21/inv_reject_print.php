<?php
include("header_top.php");
 $sdate = $_GET['sdate'];
                    $edate = $_GET['edate'];
                    
                    $start = date('Y-m-d',  strtotime(str_replace('/', '-', $_GET['sdate'])));
                    $end = date('Y-m-d',  strtotime(str_replace('/', '-',$_GET['edate'])));
                    
                   
                  
                    if ($sdate && $edate) {
                        
                       $sum_qry = mysql_query("SELECT sum(overall_total) as total FROM inv_material_parent 
							left join board on (b_id = board_id) left join class on (c_id = class_id) 
							left join section on (s_id = section_id) where inv_material_parent.paid_status=2 and 
                                                        mat_date between '$start' and '$end'
                                                        order by inv_material_parent.mat_parent_id desc");
                        $sum_result = mysql_fetch_assoc($sum_qry);
                        
                        $qry = mysql_query("SELECT *,inv_material_parent.created as issue_date FROM inv_material_parent 
							left join board on (b_id = board_id) left join class on (c_id = class_id) 
							left join section on (s_id = section_id) where inv_material_parent.paid_status=2 and 
                                                        mat_date between '$start' and '$end'
                                                        order by inv_material_parent.mat_parent_id desc");
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
<?php include '../print_header.php'; ?>
<link rel="stylesheet" href="../css/print.css"> 
<style type="text/css">
    *,table#head_table td{font-family: 'Open Sans', sans-serif;font-size:12px !important;color:#000 !important;  }
    .header p{font-size:10px !important;margin:0; }
    header { margin-bottom: 0px;padding: 0px; border: 0;}
    table{ width:100%;}
    .main-table table{ width:100%; border-collapse:collapse; }
    .main-table th{border:1px solid #000 !important;}
    .main-table td{border:1px solid #000 !important;}		 
</style> 
<style type="text/css">

    table#head_table th,table#head_table td, table#item_table th, table#item_table td{
        background: #FFFFFF;
        padding: 2px 10px;
    }
    #details {
        margin-bottom: 0px;
    }
    header {
        //margin-bottom: 3px;
    }
    table#head_table th,table#head_table td{
        border:0px !important;
        text-align: left;
    }
    table#head_table td {
        padding: 0px;
        line-height: 17px;
        
    }
    table#head_table{
        margin: 0px;
    }
    hr{
            display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #ccc;
    margin: 1em 0;
    padding: 0;
    }
</style>    
</head>
<body onload="javascript:printDiv('printablediv')" style="font-family:Verdana !important; font-size:14px !important; font-weight:bold;">
<!--<div  id="print" style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>-->
    <div align="center" id="printablediv">
        <header class="header">
            <!--<img src="../img/letterpad.png" title="latterpad" width="100%" />-->
            <center>  
                    <!--<img src="img/letterpad.png" title="letterpad" width="100%" /> -->
                <span style="font-size: 15px !important;">
SCHOOL/COLLEGE MANAGEMENT SYSTEM</span><br>
                <span>Cinthamani,
                     Puliangudi</span><br>
               
            </center>	
        </header>
        <hr>
       <h3>Rejected List </h3>
        <br>
        <main>
            <!--            <div id="details" class="clearfix">
                            <div style="float: left">
                                <div class="date">No: <?= $billno; ?></div>
                                <div class="to">Name: <?php echo $name; ?></div>
            
                                <div class="address"><?= nl2br($details_to); ?></div>
                            </div>
                            <div id="invoice">
                                <h1><?= $row1["title"]; ?></h1>
                                <div class="date">Date: <?= date("d/m/Y", strtotime($row_parent['mat_date'])); ?></div>
                                <div class="date">Std: <?= $row_class["c_name"]; ?></div>
            
                            </div>
                        </div>-->
            <table border="1" cellspacing="0" cellpadding="0" id="item_table">
                <thead>
                    <tr>
                                  <th>S.No</th>
                                            
                                        <th>Bill No.</th>
                                        <th>Issue Date</th>
                                        <th>Student / Staff</th>
                                        <th>Student Admin No. /<br> Staff Emp No.</th>
                                        <th>Board</th>
                                        <th>Class & Section</th>
                                        <th>Payment Type</th>
                                        <th>Total</th>
                                        
                    </tr>
                </thead>
                <tbody>
                  <?php
                                      $count = 1;
                                    while ($row = mysql_fetch_array($qry)) {
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $count; ?></td>
                                            <td><?php
                                                //$billno = "MI" . str_pad($row['bill_no'], 5, '0', STR_PAD_LEFT);
                                                echo $row['bill_no'];
                                                ?></td>

                                            <td><?php echo date("d-m-Y", strtotime($row['mat_date'])); ?>
                                            </td>
                                            <td><?php echo $st = ($row['stud_staff']) ? "Student" : "Staff"; ?></td>
                                            <td><?php echo $row['adm_emp_no']; ?></td>
                                            <td><?php echo $row['b_name']; ?></td>
                                            <td><?php echo $row['c_name'] . " " . $row['s_name']; ?></td>
                                            
                                            <td><?php 
                                            
                                            //if($row['paid_status']){
                                                $qry_pay = mysql_query("SELECT * FROM inv_material_payment where inv_material_payment.mat_parent_id=".$row['mat_parent_id']);
                                                $row_pay = mysql_fetch_array($qry_pay);
                                                if($row_pay['p_type']=='cash') echo 'Cash';
                                                        else if($row_pay['p_type']=='card') echo 'Card'; 
                                                        else if($row_pay['p_type']=='cheque') echo 'Cheque';
                                            //} ?></td>
                                            
                                            <td><?php echo $row['overall_total']; ?></td>

                                              
                                            </tr>	
                                            <?php
                                            $count++;
					}}
                                        ?>						
                </tbody>
                <tfoot>

<!--                    <tr>
    <td colspan="2"></td>
    <td colspan="2">SUBTOTAL</td>
    <td><?php echo number_format(array_sum($sub_array), 2); ?></td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="2">DISCOUNT</td>
    <td><?php echo number_format($row_parent['discount'], 2); ?></td>
</tr>

<tr>
    <td colspan="2"></td>
    <td colspan="2">GRAND TOTAL</td>
    <td><?php echo number_format($row_parent['overall_total'], 2); ?></td>
</tr>-->

                </tfoot>
            </table>
            
            

            <!--<div id="notices">
              <div>NOTICE:</div>
              <div class="notice">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</div>
              <div class="notice">netus et malesuada fames ac turpis egestas.</div>
            </div>-->
        </main>

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
    table th,td
    {
        border:1px solid #000000;
        border-collapse:collapse;
        border-bottom:1px solid #000 !important;
		text-align:left;
    }
    table tbody tr:last-child td
    {
        border:1px solid #000;
    }
	table#item_table td {
	font-size:11px !important;
	}
</style>
</html>