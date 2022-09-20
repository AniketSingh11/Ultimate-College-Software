<?php
include("header_top.php");
//session_start();
//$check = $_SESSION['email'];
//$query = mysql_query("select email from admin_login where email='$check' ");
//$data = mysql_fetch_array($query);
//$email = $data['email'];
//$user = $_SESSION['uname'];
//if (isset($_SESSION['expiretime'])) {
//    if ($_SESSION['expiretime'] < time()) {
//        header("Location:timeout.php");
//    } else {
//        $_SESSION['expiretime'] = time() + 6000;
//    }
//}
//if (!isset($email)) {
//    header("Location:../404.php");
//}

$parentid = $_GET['parentid'];
$qry = mysql_query("SELECT *,inv_material_parent.created as issue_date FROM inv_material_parent 
	left join board on (b_id = board_id) left join class on (c_id = class_id) 
	left join section on (s_id = section_id) where inv_material_parent.mat_parent_id = $parentid");
$row_parent = mysql_fetch_array($qry);

$billno = $row_parent['bill_no']; //"MI" . str_pad($row_parent['bill_no'], 5, '0', STR_PAD_LEFT);

$bid = $row_parent['board_id'];
$cid = $row_parent['class_id'];
$ssid = $row_parent['studid'];

$agid = $row_parent['agency_id'];
$agency = mysql_query("SELECT * FROM agency WHERE a_id=$agid");
$agencylist = mysql_fetch_array($agency);


$result_class = mysql_query("SELECT c_id,c_name FROM class class where c_id=$cid and b_id=$bid");
$row_class = mysql_fetch_assoc($result_class);

$result_section = mysql_query("SELECT * FROM section WHERE c_id = '$cid'");
$row_section = mysql_fetch_assoc($result_section);



if ($row_parent['stud_staff']) {
    //student
    $result_student = mysql_query("SELECT * FROM student WHERE ss_id = '$ssid'");
    $row_stud = mysql_fetch_assoc($result_student);
    $details_to = $row_stud['firstname'] . '<br>' . $row_stud['admission_number'] . '<br>' . $row_class["c_name"] . '<br>';
} else {
    //staff
    $staff_admin = explode(" - ", $row_parent['adm_emp_no']);
    $result_staff = mysql_query("SELECT * FROM staff WHERE staff_id like '%$staff_admin[0]%'");
    $row_staff = mysql_fetch_assoc($result_staff);
    $details_to = $row_staff['fname'] . '<br>' . $staff_admin[0] . '<br>' . $row_class["c_name"] . '<br>';
}
?>
<?php include '../print_header.php'; ?>
<link rel="stylesheet" href="../css/print.css"> 
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
            <img src="../img/letterpad.png" title="latterpad" width="100%" />
        </header>
        <main>
            <div id="details" class="clearfix">
                <div id="client">
                    <div class="to">TO:</div>
                    <h2 class="name"><?php echo $agencylist['a_name']; ?></h2>
                    <div class="address"><?= nl2br($details_to); ?></div>
                </div>
                <div id="invoice">
                    <!--<h1><?= $row1["title"]; ?></h1>-->
                    <div class="date">Date of Bill: <?= date("d/m/Y", strtotime($row_parent['mat_date'])); ?></div>
                    <div class="date">Receipt No: <?= $billno; ?></div>
                </div>
            </div>
            <table border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th class="no">S.No</th>
                        <!--<th class="qty">Date</th>-->
                        <th class="unit">Item Name</th>
                        <th class="qty">Brand Name</th>
                        <th class="unit">Qty</th>
                        <th class="qty">UOM</th>
                        <th class="unit">Selling Price</th>
                        <th class="total">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $parentlist = mysql_query("SELECT * FROM inv_material_parent 
                        right join inv_material on (inv_material.mat_parent_id = inv_material_parent.mat_parent_id) 
			left join inv_items on (inv_items.item_id = inv_material.item_id) WHERE inv_material_parent.mat_parent_id=$parentid");

                    $i = 0;
                    $sub_array = array();
                    while ($row = mysql_fetch_array($parentlist)) {


                        $i = $i + 1;

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
                            <td class="no"><center><?= $i ?></center></td>
                            <!--<td class="desc"><center><?= date("d-m-Y h:i:sa", strtotime($row['item_date'])); ?></center></td>-->
                    <td class="unit"><center><?php echo $itemlist['item_name']; ?></center></td>
                    <td class="qty"><center><?php
                        if ($brandlist['brand_name'] != '')
                            echo $brandlist['brand_name'];
                        else
                            echo 'N/A';
                        ?></center></td>
                    <td class="unit"><center><?= $row['qty'] ?></center></td> 
                    <td class="qty"><center><?= $uomlist['uom_name'] ?></center></td> 
                    <td class="unit"><center><?= $row['sell_price'] ?></center></td>           
                    <td class="total"><?php echo number_format($row['total'], 2); ?></td>
                    </tr>
                    <?php
                    array_push($sub_array, $row['total']);
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
                    <tr>
                        <td colspan="7" style="text-align: left;"><?php echo $row_com['package_name']; ?></td>
                    </tr>
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
                                    $total_price = $row_purchase['selling_price_sub'] * $row_combo_material_child['qty'];
                                } else {
                                    $uomname_last = $row_combo_material_child['uom_name'];
                                    $total_price = $row_purchase['sell_price'] * $row_combo_material_child['qty'];
                                }
                                ?>
                                <tr>
                                    <td class="no"><center><?= $j ?></center></td>
                                    <!--<td class="desc"><center><?= date("d-m-Y h:i:sa", strtotime($row_combo_material_child['created'])); ?></center></td>-->
                                <td class="unit"><center><?php echo $row_combo_material_child['item_name']; ?></center></td>
                                <td class="qty"><center><?php
                                    if ($row_combo_material_child['brand_name'] != '')
                                        echo $row_combo_material_child['brand_name'];
                                    else
                                        echo 'N/A';
                                    ?></center></td>
                                <td class="unit"><center><?= $row_combo_material_child['qty'] ?></center></td> 
                                <td class="qty"><center><?= $uomname_last ?></center></td> 
                                <td class="unit"><center><?php
                                    if ($row_purchase['uomname_sub'] != "")
                                        echo $row_purchase['selling_price_sub'];
                                    else
                                        echo $row_purchase['sell_price'];
                                    ?></center></td>           
                                <td class="total"><?php echo number_format($total_price, 2); ?></td>
                                </tr>
                                <?php
                                $j++;
                                array_push($sub_array, $total_price);
                            }
                        }
                    }
                }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td colspan="2">SUBTOTAL</td>
                        <td><?php echo number_format(array_sum($sub_array), 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td colspan="2">DISCOUNT</td>
                        <td><?php echo number_format($row_parent['discount'], 2); ?></td>
                    </tr>

                    <tr>
                        <td colspan="4"></td>
                        <td colspan="2">GRAND TOTAL</td>
                        <td><?php echo number_format($row_parent['overall_total'], 2); ?></td>
                    </tr>

                </tfoot>
            </table>
            <div id="thanks">Thank you!</div>
            <!--<div id="notices">
              <div>NOTICE:</div>
              <div class="notice">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</div>
              <div class="notice">netus et malesuada fames ac turpis egestas.</div>
            </div>-->
        </main>
<!--        <footer>
            1/191 A,, Rajiv Gandhi Nagar, Kundrathur Main Rd, Kovur, Chennai-600128. Phone No : 044 6566 6673.
        </footer>-->
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
</html>