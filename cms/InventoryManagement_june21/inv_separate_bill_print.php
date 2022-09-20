<?php
include("header_top.php");

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

$parentid = $_GET['parentid'];
$qry = mysql_query("SELECT *,inv_material_parent.created as issue_date FROM inv_material_parent 
	left join board on (b_id = board_id) left join class on (c_id = class_id) 
	left join section on (s_id = section_id) where inv_material_parent.mat_parent_id = $parentid");
$row_parent = mysql_fetch_array($qry);

$billno = $row_parent['bill_no']; //"MI" . str_pad($row_parent['bill_no'], 5, '0', STR_PAD_LEFT);

$bid = $row_parent['board_id'];
$cid = $row_parent['class_id'];
$ssid = $row_parent['studid'];
$secid = $row_parent['section_id'];

$agid = $row_parent['agency_id'];
$agency = mysql_query("SELECT * FROM agency WHERE a_id=$agid");
$agencylist = mysql_fetch_array($agency);


$result_class = mysql_query("SELECT c_id,c_name FROM class class where c_id=$cid and b_id=$bid");
$row_class = mysql_fetch_assoc($result_class);

$result_section = mysql_query("SELECT * FROM section WHERE s_id = '$secid'");
$row_section = mysql_fetch_assoc($result_section);

$staff_admin = explode(" - ", $row_parent['adm_emp_no']);
$admin_no = $staff_admin[0];
if ($row_parent['stud_staff']) {
    //student
    $result_student = mysql_query("SELECT * FROM student WHERE ss_id = '$ssid'");
    $row_stud = mysql_fetch_assoc($result_student);
    $details_to = $row_stud['firstname'] . '<br>' . $row_stud['admission_number'] . '<br>' . $row_class["c_name"] . '<br>';
    $name = $row_stud['firstname'];
} else {
    //staff
    //$staff_admin = explode(" - ", $row_parent['adm_emp_no']);
    $result_staff = mysql_query("SELECT * FROM staff WHERE staff_id like '%$staff_admin[0]%'");
    $row_staff = mysql_fetch_assoc($result_staff);
    $details_to = $row_staff['fname'] . '<br>' . $staff_admin[0] . '<br>' . $row_class["c_name"] . '<br>';
    $name = $row_staff['fname'];
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
<body onload="javascript:printDiv('printablediv')" style="width:148mm;font-family:Verdana !important; font-size:14px !important; font-weight:bold;">
<!--<div  id="print" style="float:right;"><a onClick="javascript:printDiv('printablediv')" href="#" title="Print this certificate"><img src="img/printer.png"></a></div>-->
    <div align="center" id="printablediv">
        <header class="header">
            <!--<img src="../img/letterpad.png" title="latterpad" width="100%" />-->
            <center>  
                    <!--<img src="img/letterpad.png" title="letterpad" width="100%" /> -->
                <span style="font-size: 15px !important;">
SCHOOL/COLLEGE MANAGEMENT SYSTEM
</span><br>
                <span>Cinthamani,
Puliangudi</span><br>
               
            </center>	
        </header>
        <hr>
        <div>
            <table style="border:0" id="head_table">
                <tr>
                    <td style="text-align:left;">Bill No:</td><td style="width: 50%;"> <?= $billno; ?></td>

                    <td>Date </td><td><span style="width:100%;"><?= date("d/m/Y", strtotime($row_parent['mat_date'])); ?></span></td>
                </tr>
                <tr>
                    <td>Class</td><td><span style="width:100%;"><?php echo $row_class["c_name"] ?></span></td>
                    <td>Sec</td><td><span style="width:100%;"><?php echo $row_section['s_name'] ?></span></td>
                </tr>
                <tr>
                    <td>Name</td><td><span style="width:100%;"><?php echo $name; ?></span></td>
                    <td>Admin No</td><td><span style="width:100%;"><?php echo $admin_no; ?></span></td>			  

                </tr>
            </table>

        </div>
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
                        <th class="unit1">Items</th>
                        <!--<th class="qty">Brand Name</th>-->
                        <th class="unit1" width="12%">Quantity</th>
                        <!--<th class="qty">UOM</th>-->
                        <th class="total1"  width="12%">Rs.</th>
                        <th class="total1"  width="10%">Ps.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $parentlist = mysql_query("SELECT * FROM inv_material_parent 
                        right join inv_material on (inv_material.mat_parent_id = inv_material_parent.mat_parent_id) 
			left join inv_items on (inv_items.item_id = inv_material.item_id) WHERE inv_material_parent.mat_parent_id=$parentid");

                    $i = 1;
                    $sub_array = array();
                    while ($row = mysql_fetch_array($parentlist)) {




                        $iid = $row['item_id'];
                        $item = mysql_query("SELECT * FROM inv_items WHERE item_id=$iid");
                        $itemlist = mysql_fetch_array($item);

                        $uom_id = $row['uom_id'];
                        $uom = mysql_query("SELECT * FROM inv_uom WHERE uom_id=$uom_id");
                        $uomlist = mysql_fetch_array($uom);

                        $brand_id = $row['brand_id'];
                        $brand = mysql_query("SELECT * FROM inv_brand WHERE brand_id=$brand_id");
                        $brandlist = mysql_fetch_array($brand);
                        ?>
                        <tr>

                <!--<td class="desc"><center><?= date("d-m-Y h:i:sa", strtotime($row['item_date'])); ?></center></td>-->
                            <td class="unit1"><center><b><?php echo $itemlist['item_name']; ?></b></center></td>
            <!--                    <td class="qty"><center><?php
                    if ($brandlist['brand_name'] != '')
                        echo $brandlist['brand_name'];
                    else
                        echo 'N/A';
                    ?></center></td>-->
                    <td class="unit1"><center><?= $row['qty'] ?></center></td> 
                    <td class="total1"><?php
                        $total_with_deci = explode('.', $row['total']);
                        echo $total_with_deci[0]; //number_format($row['total'], 2);  
                        ?></td>
                    <td><?= $total_with_deci[1]; ?></td>
                    </tr>
                    <?php
                    array_push($sub_array, $row['total']);
                    $i = $i + 1;
                }
                ?>

                <?php
                $qry_combomat = "SELECT * FROM inv_material_combo_parent 
                    left join inv_combo_parent on (inv_combo_parent.com_parent_id=inv_material_combo_parent.com_parent_id) WHERE 
							inv_material_combo_parent.mat_parent_id=$parentid";
                $result_combo_material = mysql_query($qry_combomat);



                while ($row_combo_material = mysql_fetch_assoc($result_combo_material)) {

                    /* $result_combo_material_child = mysql_query("SELECT * from inv_material_combo_parent 
                      left join inv_material_combo_child on (inv_material_combo_child.mat_com_id = inv_material_combo_parent.mat_com_id)
                      where inv_material_combo_child.mat_com_id=".$row_combo_material['mat_com_id']); */
                    $combo_namesql = mysql_query("SELECT com_parent_id,package_name FROM inv_combo_parent where com_parent_id=" . $row_combo_material['com_parent_id']);
                    $row_com = mysql_fetch_assoc($combo_namesql);
                    ?>
                <!--                    <tr>
                                        <td colspan="7" style="text-align: left;"><?php echo $row_com['package_name']; ?></td>
                                    </tr>-->
                    <?php
                    $result_combo_material_child = "SELECT *,inv_combo.brand_id as com_brandid FROM inv_combo_parent left join inv_combo on(inv_combo.com_parent_id = inv_combo_parent.com_parent_id) 
			left join inv_items on (item_id = package_items) left join inv_uom on (inv_uom.uom_id = inv_combo.uom_id)
			left join inv_brand on (inv_brand.brand_id=inv_combo.brand_id) where inv_combo_parent.com_parent_id = " . $row_combo_material['com_parent_id'] . "
                             and inv_items.active=1 and inv_items.item_status=1";
                    $row_combo_material_child1 = mysql_query($result_combo_material_child);
                    $j = 1;
                    while ($row_combo_material_child = mysql_fetch_assoc($row_combo_material_child1)) {


                        $result_combo_mat_child = mysql_query("SELECT * from inv_material_combo_parent 
                      left join inv_material_combo_child on (inv_material_combo_child.mat_com_id = inv_material_combo_parent.mat_com_id)
                      where inv_material_combo_child.mat_com_id=" . $row_combo_material['mat_com_id']);
                        //$row_combo_mat_child = mysql_fetch_assoc($result_combo_mat_child);
                        //$purchasechild = "SELECT * FROM inv_purchase where inv_purchase.item_id = " . $row_combo_material_child['package_items'] . " order by created desc";

                        $purchasechild = "SELECT * FROM inv_purchase left join inv_purchase_mode on 
					(inv_purchase_mode.pur_id=inv_purchase.pur_id) 
                                        left join inv_brand on (inv_brand.brand_id=inv_purchase.brand_id) where inv_purchase.item_id = " . $row_combo_material_child['package_items'] . " "
                                . "and inv_purchase.brand_id = " . $row_combo_material_child['com_brandid'] . " order by inv_purchase.created desc";

                        $result_purchase = mysql_query($purchasechild) or die(mysql_error());
                        $row_purchase = mysql_fetch_assoc($result_purchase);

                        while ($row_combo_mat_child = mysql_fetch_assoc($result_combo_mat_child)) {
                            //echo $row_combo_material_child['item_name'] . ' ' . $row_combo_mat_child['item_id'] . ' ' . $row_purchase['item_id'] . '<br>';
                            if ($row_combo_mat_child['item_id'] == $row_purchase['item_id']) {
                                if ($row_purchase['uomname_sub'] != "") {
                                    $uomname_last = $row_purchase['uomname_sub'];

                                    $total_price = $row_purchase['selling_price_sub'] * $row_combo_mat_child['qty']; //$row_combo_material_child['qty'];
                                } else {
                                    $uomname_last = $row_combo_material_child['uom_name'];
                                    $total_price = $row_purchase['sell_price'] * $row_combo_mat_child['qty']; //$row_combo_material_child['qty'];
                                }
                                ?>
                                <tr>
                                    <!--<td class="desc"><center><?= date("d-m-Y h:i:sa", strtotime($row_combo_material_child['created'])); ?></center></td>-->
                                    <td class="unit1"><center><b><?php echo $row_combo_material_child['item_name']; ?></b></center></td>
                <!--                                <td class="qty"><center><?php
                                if ($row_combo_material_child['brand_name'] != '')
                                    echo $row_combo_material_child['brand_name'];
                                else
                                    echo 'N/A';
                                ?></center></td>-->
                                <td class="unit1"><center><?= $row_combo_mat_child['qty']; ?></center></td> 

                                <td class="total1"><?php
                                    $total_with_deci1 = explode('.', number_format($total_price, 2));
                                    echo $total_with_deci1[0]; //number_format($total_price, 2);  
                                    ?></td>
                                <td><?php echo $total_with_deci1[1]; ?></td>
                                </tr>
                                <?php
                                $i++;
                                array_push($sub_array, $total_price);
                            }
                        }
                    }
                }
                ?>
<!--<tr>
<td class="unit1" colspan="2"  style="text-align:right"><b>Subtotal</b></td>
<td class="total1"><?php
                $total_with_deci_sub = explode('.', number_format(array_sum($sub_array), 2));
                echo $total_with_deci_sub[0]; //number_format(array_sum($sub_array), 2);  
                ?></td>
<td><?php echo $total_with_deci_sub[1]; ?></td>
</tr>
<tr>

<td class="unit1" colspan="2" style="text-align:right"><strong>Discount</strong></td>
<td class="total1"><?php
                $total_with_deci_dis = explode('.', $row_parent['discount']);
                echo $total_with_deci_dis[0]; //number_format($row_parent['discount'], 2);  
                ?></td>
<td><?php echo $total_with_deci_dis[1]; ?></td>
</tr>-->
                <tr>

                    <td class="unit1" colspan="2" style="text-align:right"><strong>Total</strong></td>      
                    <td class="total1"><?php
                        $total_with_deci_tot = explode('.', $row_parent['overall_total']);
                        echo $total_with_deci_tot[0]; //number_format($row_parent['overall_total'], 2);  
                        ?></td>
                    <td><?php echo $total_with_deci_tot[1]; ?></td>
                </tr>
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
            <div style="font-size: 16px;float:left;">Rupees : <?php echo convert_number_to_words($row_parent['overall_total']); ?> Rupees Only </div>
            <div style=" float:right">For School/College Management Solution </div><br>
            <div style=" float:right; margin-top:4%;">Cashier </div>

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
    }
    table tbody tr:last-child td
    {
        border:1px solid #000;
    }
</style>
</html>