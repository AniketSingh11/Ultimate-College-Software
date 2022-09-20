<?php
include("header_top.php");
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
    header("Location:../404.php");
}

$nid = $_GET['parentid'];
$result_parent = mysql_query("select * from  inv_purchase_parent where pur_parent_id=$nid");
$row_parent = mysql_fetch_array($result_parent);


$agid = $row_parent['agency_id'];
$agency = mysql_query("SELECT * FROM agency WHERE a_id=$agid");
$agencylist = mysql_fetch_array($agency);

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
                    <div class="address"><?= nl2br($agencylist["a_address"]); ?></div>
                </div>
                <div id="invoice">
                    <h1><?= $row1["title"]; ?></h1>
                    <div class="date">Date of Bill: <?= date("d/m/Y", strtotime($row_parent['purchase_date'])); ?></div>
                    <div class="date">Purchase No: <?= $billno = "PB" . str_pad($row_parent["purchase_no"], 5, '0', STR_PAD_LEFT); ?></div>
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
                        <th class="unit">Buy Price</th>
                        <th class="total">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $parentlist = mysql_query("SELECT *,inv_purchase.created as item_date FROM inv_purchase_parent 
                            left join inv_purchase on (inv_purchase.pur_parent_id=inv_purchase_parent.pur_parent_id) 
                            where inv_purchase_parent.pur_parent_id=$nid");

                    $i = 0;
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
                            <td class="qty"><center><?php if ($brandlist['brand_name'] != '') echo $brandlist['brand_name'];
                    else echo 'N/A'; ?></center></td>
                            <td class="unit"><center><?= $row['qty'] ?></center></td> 
                            <td class="qty"><center><?= $uomlist['uom_name'] ?></center></td> 
                    <td class="unit"><center><?= $row['buy_price'] ?></center></td>           
                    <td class="total"><?php echo number_format($row['total'], 2); ?></td>
                    </tr>
<?php } ?>
                </tbody>
                <tfoot>
                    
                    
                    <tr>
                        <td colspan="4"></td>
                        <td colspan="2">GRAND TOTAL</td>
                        <td><?php echo number_format($row_parent['overeall_total'], 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="4"></td>
                        
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
</html>