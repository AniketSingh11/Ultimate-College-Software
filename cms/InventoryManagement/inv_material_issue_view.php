<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

$parentid = $_GET['parentid'];
$exbilllist1 = mysql_query("SELECT * FROM inv_material_parent WHERE mat_parent_id=$parentid");
$exbill1 = mysql_fetch_array($exbilllist1);
$catid = $exbill1['cat_id'];

if (isset($_POST['submit'])) {

    $parentid = $_GET['parentid'];
    //item delete
    $result_material = mysql_query("select * from inv_material
        inner join inv_material_parent on (inv_material_parent.mat_parent_id=inv_material.mat_parent_id) where inv_material_parent.mat_parent_id=$parentid");

    $pur_parent_id = $row_purchase['pur_parent_id'];

    $exbilllist = mysql_query("SELECT * FROM inv_material_payment WHERE mat_parent_id=$parentid");
    $exbill = mysql_fetch_array($exbilllist);
    $matpay_id = $exbill['mat_pay_id'];
    $oldamount = $exbill['payamount'];
    $oldptype = $exbill['p_type'];
    $oldcstatus = $exbill['c_status'];
    $ba_id = $exbill['ba_id'];

    while ($row_mat_del = mysql_fetch_assoc($result_material)) {

        $result_select2 = mysql_query("select * from inv_items where item_id=" . $row_mat_del['item_id']);
        $row_items_select2 = mysql_fetch_assoc($result_select2);
        echo 'Child I delete Loop' . $row_items_select2['item_qty'] . ' + ' . $row_mat_del['qty'] . '<br>';

        //get original qty
        $orig_qty11 = $row_items_select2['item_qty'] + $row_mat_del['qty'];
        $orig_qty1 = ($orig_qty11 < 0) ? "0" : $orig_qty11;
        //update total qty
        echo $sql_item2 = "UPDATE inv_items SET item_qty='$orig_qty1' where item_id=" . $row_mat_del['item_id'];
        echo '<br>';
        $result2 = mysql_query($sql_item2) or die("Could not update data into DB: " . mysql_error());

        //udpate brand qty
        $qry_brand = "select * from inv_brand_items where item_id=" . $row_mat_del['item_id'] . " and brand_id = " . $row_mat_del['brand_id'];
        $result_brand = mysql_query($qry_brand);
        $row_brand = mysql_fetch_assoc($result_brand);

        if (!empty($row_brand)) {
            echo 'brand items';
            $brand_qty = $row_brand['qty'] + $row_mat_del['qty'];
            $brand_qty_i = ($brand_qty < 0) ? "0" : $brand_qty;
            $sql_item_brand = mysql_query("UPDATE inv_brand_items SET qty='$brand_qty_i' where item_id=" . $row_mat_del['item_id'] . " and brand_id = " . $row_mat_del['brand_id']);
        }
    }


    if ($result2 || empty($row_mat_del)) {
        //delete material
        $sql_item2_del = mysql_query("UPDATE inv_material_parent SET paid_status='2' where mat_parent_id=" . $parentid);
        //$qry_del_child = mysql_query("delete from inv_material where mat_parent_id='$parentid'") or die("Could not delete data from DB: " . mysql_error());
        //$qry_del_pa = mysql_query("delete from inv_material_parent where mat_parent_id='$parentid'") or die("Could not delete data from DB: " . mysql_error());

        /*         * ********************************Hand cash pay Update **************************************** */
        if ($oldptype == 'cash') {
            $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
            $cash = mysql_fetch_array($cashlist);
            $currentcash = $cash['amount'];

            $updatecash = $currentcash - ($oldamount);
            $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
        } else if ($oldptype == 'cheque') {

            if ($oldcstatus == '2') {
                $delete1 = "Delete from bank_deposit where mat_pay_id='$matpay_id' AND ba_id='$ba_id'";
                $result2 = mysql_query($delete1);
                $classlist1 = mysql_query("SELECT * FROM bank_account WHERE ba_id=$ba_id");
                $class1 = mysql_fetch_array($classlist1);
                $amount = $oldamount;
                $accountamount = $class1['amount'];
                $accountcash = $accountamount - $amount;
                $cashqry = mysql_query("UPDATE bank_account SET amount='$accountcash' WHERE ba_id=$ba_id");
            }
        }
    }

//combo delete
    $result_matcombo_del = mysql_query("SELECT * from inv_material_combo_parent left join inv_material_combo_child 
	on (inv_material_combo_child.mat_com_id = inv_material_combo_parent.mat_com_id) 
	inner join inv_combo on (inv_combo.com_parent_id=inv_material_combo_parent.com_parent_id and package_items=item_id) where mat_parent_id='$parentid' ") or die("Could not fetch inv_material_combo_parent data into DB: " . mysql_error());
    echo '<br>';
    while ($row_matcomb_del = mysql_fetch_assoc($result_matcombo_del)) {

        $result_items_1 = mysql_query("SELECT * FROM inv_purchase
 WHERE item_id = " . $row_matcomb_del['item_id'] . " order by inv_purchase.created desc limit 1");

        $row_items_1 = mysql_fetch_assoc($result_items_1);

        $result_select1 = mysql_query("select * from inv_items where item_id=" . $row_matcomb_del['item_id']);
        $row_items_select1 = mysql_fetch_assoc($result_select1);

        echo 'Child II delete Loop' . $row_items_select1['item_qty'] . ' + ' . $row_matcomb_del['qty'] . '<br>';

        //get original qty
        $orig_qty2 = $row_items_select1['item_qty'] + $row_matcomb_del['qty'];
        $orig_qty = ($orig_qty2 < 0) ? "0" : $orig_qty2;
        //update total qty
        echo $sql_item1 = "UPDATE inv_items SET item_qty='$orig_qty' where item_id=" . $row_matcomb_del['item_id'];
        echo '<br>';
        $result11 = mysql_query($sql_item1) or die("Could not update data into DB: " . mysql_error());

        //udpate brand qty
        $qry_brand = "select * from inv_brand_items where item_id=" . $row_matcomb_del['item_id'] . " and brand_id = " . $row_matcomb_del['brand_id'];
        $result_brand = mysql_query($qry_brand);
        $row_brand = mysql_fetch_assoc($result_brand);

        if (!empty($row_brand)) {
            echo 'brand items';
            $brand_qty = $row_brand['qty'] + $row_matcomb_del['qty'];
            $brand_qty_c = ($brand_qty < 0) ? "0" : $brand_qty;
            $sql_item_brand = mysql_query("UPDATE inv_brand_items SET qty='$brand_qty_c' where item_id=" . $row_matcomb_del['item_id'] . " and brand_id = " . $row_matcomb_del['brand_id']);
        }
    }

    /* $result_two_delete = mysql_query("DELETE inv_material_combo_parent,inv_material_combo_child FROM inv_material_combo_parent 
      INNER JOIN inv_material_combo_child on (inv_material_combo_child.mat_com_id= inv_material_combo_parent.mat_com_id)
      where inv_material_combo_parent.mat_parent_id = '$parentid'");
     */
    if (!$sql_item2_del) {
        die("Query Failed: " . mysql_error());
    } else {
        header("Location:inv_material_issue.php?msg=dsucc");
    }
}
?>
<link rel="stylesheet" href="stylesheets/sample_pages/invoice.css" type="text/css" />
<style>
    table th, table td {
        padding: 10px;
        font-size: 14px;
    }
    table#items_table, #items_table thead, #items_table tr, #items_table th, #items_table td {
        border: 1px solid;
    }
    #items_table th {
        font-weight: bold;
    }
</style>
<body>

    <div id="wrapper">

        <div id="header">
            <h1><a href="dashboard.php">Inventory Management</a></h1>		

            <a href="javascript:;" id="reveal-nav">
                <span class="reveal-bar"></span>
                <span class="reveal-bar"></span>
                <span class="reveal-bar"></span>
            </a>
        </div> <!-- #header -->

        <div id="search">
            <form>
                <input type="text" name="search" placeholder="Search..." id="searchField" />
            </form>		
        </div> <!-- #search -->

        <div id="sidebar">		

            <?php include 'sidebar.php'; ?>

        </div> <!-- #sidebar -->

        <div id="content">		

            <div id="contentHeader">
                <h1>Material Issue</h1>
            </div> <!-- #contentHeader -->	

            <div class="container">
                <?php
                $msg = $_GET['msg'];
                $parentid_get = $_GET['parentid'];
                $cat = $_GET['catid'];
                if ($msg === "succ") {
                    ?>
                    <div class="notify notify-success">						
                        <a href="javascript:;" class="close">&times;</a>
                        <?php if ($cat != 0) { ?>
                            <a href="inv_separate_bill_print.php?parentid=<?php echo $parentid_get; ?>" target="_blank"  style="float: right;width:60%;"><button class="btn btn-success ">Recent Issued Bill Print</button></a>
                        <?php } else { ?>
                            <a href="inv_material_issue_print.php?parentid=<?php echo $parentid_get; ?>" target="_blank"  style="float: right;width:60%;"><button class="btn btn-success ">Recent Issued Bill Print</button></a>
                        <?php } ?>
                        <h3>Success Notifty</h3>						
                        <p>Your data successfully Updated!!!</p>

                    </div>
                <?php } if ($msg === "err") {
                    ?>
                    <div class="notify notify-error">						
                        <a href="javascript:;" class="close">&times;</a>						
                        <h3>Error Notifty</h3>						
                        <p>Your data has not been Updated!!! Please give atleast one Item..!!!</p>
                    </div>
                <?php } ?>
                <div class="notify notify-success qty_notify" style="display:none">						
                    <a href="javascript:;" class="close">&times;</a>						
                    <h3>Quantity Notifty</h3>						
                    <p>The <span id="ietm_n"></span> available quantity is : <span id="item_q"></span></p>
                </div>
                <div class="grid-24">

                    <div class="widget">

                        <div class="widget-header">
                            <a href="inv_material_issue.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
                            <span class="icon-article"></span>
                            <h3>Material View</h3>
                        </div> <!-- .widget-header -->
                        <div class="widget-content">
                            <?php
                            $parentid = $_GET['parentid'];

                            $qry = mysql_query("SELECT *,inv_material_parent.created as issue_date FROM inv_material_parent 
							left join board on (b_id = board_id) left join class on (c_id = class_id) 
							left join section on (s_id = section_id) where inv_material_parent.mat_parent_id = $parentid");
                            $row_parent = mysql_fetch_array($qry);

                            $billno = "MI" . str_pad($row_parent['bill_no'], 5, '0', STR_PAD_LEFT);
                            $bid = $row_parent['board_id'];
                            // echo if($row_parent['paid_status']);
                            //die;
                            if ($row_parent['paid_status'] != 0) {
                                $qry_pay = mysql_query("SELECT * FROM inv_material_payment where inv_material_payment.mat_parent_id=" . $row_parent['mat_parent_id']);
                                $row_pay = mysql_fetch_array($qry_pay);
                                $ptype = $row_pay["p_type"];
                            }
                            ?>

                            <form class="form uniformForm validateForm" method="post" action="" >

                                <div class="grid-8">	
                                    <div class="widget-content">
                                        <div class="field-group">

                                            <label for="required">Receipt No.<span class="error"> </span>: <?php echo $row_parent['bill_no']; ?></label>


                                        </div> 

                                        <div class="clear"></div>
                                        <div class="field-group">		
                                            <label>Student / Staff<span class="error"> </span>:  <?php
                                                if ($row_parent['stud_staff'] == '1') {
                                                    echo 'Student';
                                                }
                                                ?>	
                                                <?php
                                                if ($row_parent['stud_staff'] == '0') {
                                                    echo 'Staff';
                                                }
                                                ?>
                                            </label>			
                                            <div class="field">
                                                <select name="status" id="status" class="required select2" onChange="getNumber();" style="display:none;">	
                                                    <option value="1" <?php
                                                    if ($row_parent['stud_staff'] == '1') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Student</option>	
                                                    <option value="0" <?php
                                                    if ($row_parent['stud_staff'] == '0') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Staff</option>											
                                                </select>										
                                            </div>		
                                        </div>

                                        <?php
                                        if ($row_parent['stud_staff'] == 1) {
                                            $stud = "style='display:block'";
                                            $staff = "style='display:none'";
                                        } else {
                                            $stud = "style='display:none'";
                                            $staff = "style='display:block'";
                                        }
                                        ?>
                                        <div class="field-group" <?php echo $staff; ?> id="staff_no">
                                            <label for="required">Staff Employee No.<span class="error">  </span>: <span id="empno"></span></label>
                                            <div class="field">
                                                <input type="text" name="empno" id="empno1" size="32" class="validate[required]" value="<?php //echo $row_parent['adm_emp_no'];                       ?>"/>	
                                                <div id="suggesstion-box_staff"></div>
                                                <div id="class_sections_staff">
                                                    <input type='hidden' name='sectionname_s' id='sectionname_s' value='<?php echo $row_parent['section_id']; ?>'>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group" id="stud_no" <?php echo $stud; ?>>
                                            <?php
                                            $adminno_arr = explode(' ', $row_parent['adm_emp_no']);
                                            $query_adm = "SELECT * FROM student WHERE admission_number = '" . $adminno_arr[0] . "' ";
                                            $result_adm = mysql_query($query_adm);
                                            $row_adm = mysql_fetch_assoc($result_adm)
                                            ?>
                                            <label for="required">Student Admin No.<span class="error"> </span>: <span ><?= $adminno_arr[0]; ?></span></label>
                                            <div class="field">
                                                <input type="hidden" name="studno" class="biginput validate[required]" id="studno_suggest1" autocomplete="off" size="32" value="<?php //echo $row_parent['adm_emp_no'];                       ?>" >
                                                <div id="suggesstion-box"></div>
                                                <div id="class_sections_stud">



                                                    <input type='hidden' name='studentid' id='studentid' value='<?php echo $row_parent["studid"]; ?>'>
                                                    <input type='hidden' name='sectionname_s' id='sectionname_s' value='<?php echo $row_parent['section_id']; ?>'>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>	

                                <div class="grid-8">	
                                    <div class="widget-content">

                                        <div class="field-group">	
                                            <label for="required">Receipt Date<span class="error"> </span>: <?php echo date("d/m/Y", strtotime($row_parent['mat_date'])); ?></label>

                                        </div>
                                        <div class="field-group">	
                                            <?php
                                            $classl = "SELECT c_id,c_name FROM class class where b_id=$bid AND ay_id=$acyear and c_id=" . $row_parent['class_id'];
                                            //$row_parent['class_id'];
                                            $result_class = mysql_query($classl) or die(mysql_error());
                                            $row_class = mysql_fetch_assoc($result_class)
                                            ?>
                                            <label>Class<span class="error">  </span>: <?= $row_class['c_name']; ?></label>			
                                            <input type='hidden' value="<?= $row_parent['class_id']; ?>" id='classname'>
                                        </div> <!-- .field-group -->

                                    </div>
                                </div>

                                <div class="grid-8">	
                                    <div class="widget-content">

                                        <!-- .field-group -->
                                        <div class="field-group" >
                                            <?php
                                            $classl = "SELECT * FROM board where b_id=" . $row_parent['board_id'];
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            $row1 = mysql_fetch_assoc($result1);
                                            ?>
                                            <label for="select">Board <span class="error">  </span>: <?= $row1['b_name']; ?></label>

                                        </div>

                                        <div class="field-group">
                                            <?php
                                            $query_s = "SELECT * FROM section WHERE c_id = '" . $row_parent['class_id'] . "' and s_id=" . $row_parent['section_id'];
                                            $result_s = mysql_query($query_s);
                                            $row_s = mysql_fetch_assoc($result_s);
                                            ?>
                                            <label>Section<span class="error"> </span>: <?= $row_s['s_name']; ?></label>			

                                        </div>  

                                    </div>
                                </div>



                                <div class="widget fees_details">
                                    <div class="widget-header">
                                        <h3>Fees Details </h3><span class="expander icon-plus" style="float: right;padding: 0px 10px 0px 3px;margin-top: 5px;"></span>
                                    </div>
                                    <div class="widget-content">
                                        <div id="class_sections" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>

                                <h3>ITEM LIST :</h3>   

                                <?php if ($row_parent['cat_id'] != 0) { ?>
                                    <div class="grid-8">	
                                        <div class="widget-content">
                                            <div class="field-group">		

                                                <div class="field">

                                                    <?php
                                                    $catsql = "SELECT * from inv_category where cat_status=1 and cat_id=" . $row_parent['cat_id'];
                                                    $result_cat = mysql_query($catsql) or die(mysql_error());
                                                    $row_cat = mysql_fetch_assoc($result_cat);
                                                    ?>
                                                    <label style="font-size:20px"><?php echo $row_cat['category_name']; ?> Category</label>
                                                </div>		
                                            </div>
                                        </div>		
                                    </div>
                                <?php } ?>
                                <div class="clear"></div>
                                <div class="grid-24">	
                                    <div class="widget-content">
                                        <table border="0" cellspacing="0" cellpadding="0" width='100%' border='1' id='items_table'>
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
                                    </div>
                                </div>
                                <div class="grid-8">	
                                    <div class="widget-content">
                                        <div class="field-group payment_type">		
                                            <label for="textfield">Payment Type: <?php
                                                if ($ptype == 'cash') {
                                                    echo 'Cash';
                                                }
                                                ?>	
                                                <?php
                                                if ($ptype == 'card') {
                                                    echo 'Card';
                                                }
                                                ?><?php
                                                if ($ptype == 'cheque') {
                                                    echo 'Cheque';
                                                }
                                                ?>
                                            </label>			
                                            <div class="field">
                                                <select name="ptype" id="ptype" class="required select2" onchange="payment_type()" style="display:none;">
                                                    <option value="cash" <?php
                                                    if ($ptype == 'cash') {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>>Cash</option>	
                                                    <option value="card" <?php
                                                    if ($ptype == 'card') {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>>Card</option>
                                                    <option value="cheque" <?php
                                                    if ($ptype == 'cheque') {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>>Cheque</option>								
                                                </select>	
                                                <input type="hidden" name="old_ptype" value="<?= $ptype ?>" />
                                            </div>		
                                        </div>


                                        <?php if ($ptype == 'card') { ?>

                                            <div class="field-group ">
                                                <label for="textfield">Paid No ( with card ) : <?php echo $row_pay["pay_number"]; ?></label>

                                            </div> 

                                        <?php } if ($ptype == 'cheque') { ?>

                                            <div class="field-group ">

                                                <label for="textfield">Cheque No : <span><?php echo $row_pay["pay_number"]; ?></span></label>

                                            </div>
                                            <?php
                                            $baid1 = $row_pay["ba_id"];
                                            $banklist = mysql_query("SELECT * FROM bank_account WHERE ba_id=$baid1");
                                            $bank = mysql_fetch_array($banklist);
                                            $bankname = $bank['name'];
                                            $account = $bank['account_no'];
                                            ?>


<!--                                            <div class="field-group ">

                                                <label for="textfield">Bank Name : <?php echo $bankname . " - " . $account; ?></label>

                                            </div>-->



                                            <div class="field-group ">

                                                <label for="textfield">Bank Name : <?php echo $row_pay["bank"]; ?> </label>


                                            </div>


                                            <div class="field-group ">

                                                <label for="textfield">Account No : <?php echo $row_pay["account"]; ?></label>


                                            </div>

                                            <div class="field-group ">
                                                <label for="textfield">Date : <?= $row_pay['c_date'] ?></label>


                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>		
                        </div>

                        <div class="clear"></div>
                        <input type="hidden" name="parent_id" id="parent_id" value="<?php echo $parentid; ?>" > 

                        <div class="actions">	
                            <?php if ($row_parent['paid_status'] != 2) { ?>
                                <button type="submit" name="submit" class="btn btn-error">Reject Bill</button>
                            <?php } ?>
                        </div> <!-- .actions -->
                        </form>


                    </div> <!-- .widget-content -->

                </div>

            </div> <!-- .grid -->

        </div> <!-- .container -->

    </div> <!-- #content -->

    <?php
    include("includes/topnav.php");
    ?> <!-- #topNav -->




</div> <!-- #wrapper -->

<?php
include("includes/footer.php");

include("auto.php");
?>

<style>
    .table tbody tr td.amount_td{
        border:0px;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {

        $("#datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        });
        if ($("select option:selected").length) {
            //alert("sd")

        }
        var s_id = $("#studentid").val();
        var c_id = $("#classname").val();
        //console.log(s_id + ' '+c_id);

        //start fees details
        //getFeesDetails(s_id, c_id);
        var selval = $("#status option:selected").val();


        if (selval == 1) {
            $('#class_sections').show();
            $('#class_sections').html('<img src="images/loaders/loading.gif" style="margin-left: 33%;width: 25%;">');
        }

        $.ajax({
            type: "POST",
            url: "inv_fees_details.php",
            data: {studentid: s_id, classid: c_id},
            success: function(data) {
                //console.log(data);
                $('#class_sections').html(data);

                //getStdCombo(c_id);

            }
        });
        //end fees details

        //get status stud/emp
        var st = $('#status').val();
        //alert(st);
        if (st) {
            //student
            $("#studno_suggest").html('<?php echo $row_parent['adm_emp_no']; ?>');
        }
        else {
            //staff
            $("#empno").val('<?php echo $row_parent['adm_emp_no']; ?>');
        }
        //end

        var item_tr = 0;
        var combo_tr = 0;

        $(".dfdf tr:visible").each(function() {

            var itemid = this.id;

            //count item class row
            if (itemid.indexOf("row_item_") >= 0) {
                item_tr++;
            }
            //count combo class row
            if (itemid.indexOf("combo_item_") >= 0) {
                combo_tr++;
            }

        });

        $("#addvalue0").attr("onclick", "add_table_tr(" + item_tr + ")");
        $("#addvalue_combo0").attr("onclick", "add_combo_table_tr(" + combo_tr + ")");

        //auto complete
        //for student  
        $("#studno_suggest").keyup(function() {

            var classname = $("#classname option:selected").val();
            var sectionname = $("#sectionname option:selected").val();
            //console.log(classname);
            var keyword = $(this).val();
            $.ajax({
                type: "POST",
                url: "inv_auto_student.php",
                data: {keyword: keyword, classid: classname, sectid: sectionname},
                beforeSend: function() {
                    $("#studno_suggest").css("background-color", "#FFF");
                },
                success: function(data) {
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                    $("#studno_suggest").css("background", "#FFF");
                }
            });
        });


        //for staff  
        $("#empno").keyup(function() {
            $.ajax({
                type: "POST",
                url: "inv_auto_staff.php",
                data: 'keyword=' + $(this).val(),
                beforeSend: function() {
                    $("#empno").css("background-color", "#FFF");
                },
                success: function(data) {
                    $("#suggesstion-box_staff").show();
                    $("#suggesstion-box_staff").html(data);
                    $("#empno").css("background", "#FFF");
                }
            });
        });

        //toggle fees details
        $('.expander').live('click', function() {
            $('#class_sections').slideToggle();
        });

    });
</script>
<script type="text/javascript">

    payment_type();

    function payment_type() {
        var x = document.getElementById("ptype").value;
        if (x != "cash") {
            $('#cash_pay').hide();
        } else {
            $('#cash_pay').show();
        }
        $.get("inv_payment_type.php", {value: x, matid:<?= $row_parent['mat_parent_id'] ?>}, function(data) {
            $("#ajax_pay").html(data);
        });
    }
    function getBrand(id) {

        var itemid = $("#itemname" + id + " option:selected").val();

        $.ajax({
            type: "GET",
            url: "inv_itembrand_list.php",
            //dataType: 'json',
            data: {itemid: itemid},
            success: function(data) {

                $("#brandname" + id).html(data);

                jq('select.select2').select2({
                    allowClear: true,
                    placeholder: "Please Select...",
                    width: 'resolve',
                });

                getItemPrice(id);
            }

        });

    }
    function getItemPrice(id) {

        var itemid = $("#itemname" + id + " option:selected").val();
        var brandid = $("#brandname" + id + " option:selected").val();
        $.ajax({
            method: "GET",
            url: "inv_itembrand_price.php",
            dataType: 'json',
            data: {itemid: itemid, brandid: brandid},
            success: function(data) {

                $('#qty' + id).val(0);
                $('#selling_price' + id).val(data.sell_price);
                $('#uom' + id).html(data.uom_name);
                $('#uom_name' + id).val(data.uom_id);

                showUOM_Sub(id);

                calc_totalamount(id);

                //console.log(data);
                if (data) {

                    $(".qty_notify").show();
                    var final_qty = qtyChecking(itemid, data.brand_qty, id);
                    //$("#item_q").html(data.qty);
                    //console.log(data);
                    checkComboItem_qty();
                } else {
                    $(".qty_notify").show();
                    $("#item_q").html(0);
                }
            }

        });

    }

    function showUOM_Sub(id) {
        var itemid = $("#itemname" + id + " option:selected").val();
        var brandid = $("#brandname" + id + " option:selected").val();
        var uomname = $("#uom_name" + id).val();

        $.get("inv_show_uom.php", {id: id, itemid: itemid, brandid: brandid}, function(data) {

            var str = data;
            //console.log(data);
            $("#uom_group" + id).html(data);

        });

    }

    function getSubSellingPrice(id) {

        var uomid = $("#uomname_new" + id + " option:selected").val();
        var itemid = $("#itemname" + id + " option:selected").val();


        if (uomid.indexOf(',0') != -1) {
            console.log(uomid);

            $.ajax({
                method: "GET",
                url: "inv_sub_selling_price.php",
                data: {itemid: itemid},
                success: function(data) {

                    $('#selling_price' + id).val(data);

                    calc_totalamount(id);

                }

            });

        } else {
            getItemPrice(id);
        }

    }

    function checkQty(id) {

        var curr_itemval = $("#itemname" + id + " option:selected").val();
        var brandid = $("#brandname" + id + " option:selected").val();

        $.ajax({
            method: "GET",
            url: "inv_itembrand_price.php",
            dataType: 'json',
            data: {itemid: curr_itemval, brandid: brandid},
            success: function(data) {

                if (data) {
                    $(".qty_notify").show();
                    var final_qty = qtyChecking(curr_itemval, data.brand_qty, id);
                    calc_totalamount(id);

                    checkComboItem_qty();
                } else {

                    $(".qty_notify").show();
                    $("#item_q").html(0);
                }
            }

        });


    }
    //combo qty and selling price
    function getSell_byQty(id1, id2) {

        var qty = ($('#combo_item_listqty' + id1 + '_' + id2).val() == "") ? 0 : $('#combo_item_listqty' + id1 + '_' + id2).val();
        var sellprice = ($('#combo_item_listsell' + id1 + '_' + id2).val() == "") ? 0 : $('#combo_item_listsell' + id1 + '_' + id2).val();

        var total = parseFloat(qty) * parseFloat(sellprice);

        $('#combo_item_listtotal' + id1 + '_' + id2).val(total);
        $('#combo_item_listtotal_label' + id1 + '_' + id2).html(total);

        if ($("#combo_item_list" + id1 + "_" + id2).is(":checked")) {

            var sum = 0;

            $(".comb_total_sell").each(function() {

                var id_total = $(this).prop('id');

                var comboqtyid_name = this.id;

                comboqtyid_name = comboqtyid_name.replace("combo_item_listtotal", "");

                var comboqtyid_array = comboqtyid_name.split("_");
                var id11 = comboqtyid_array[0];
                var id12 = comboqtyid_array[1];

                if ($("#combo_item_list" + id11 + "_" + id12).is(":checked")) {

                    sum = parseFloat(sum) + parseFloat($('#' + id_total).val());
                    //$('#overall_totamount').val(sum);

                }
            });

            $("#total_combo_amt" + id1).val(sum);
            calc_total();

        }

    }

    function qtyChecking(curr_itemval, stock_qty, id) {

        var qty_loop = 0;
        var oldqty_loop = 0;

        $(".itemname_class").each(function() {

            var itemid = this.id;

            var loop_itemval = $("#" + itemid + " option:selected").val();

            var id_no = itemid.replace("itemname", "");

            if (curr_itemval == loop_itemval) {

                qty_loop = qty_loop + parseFloat($("#qty" + id_no).val());
                oldqty_loop = oldqty_loop + parseFloat($("#oldqty" + id_no).val());

                //console.log(itemid+' '+id_no);
            }

        });

        //console.log("Stock qty "+stock_qty+" old Qty total "+oldqty_loop + " qty total " +qty_loop);

        var tot_qty = (parseFloat(stock_qty) + parseFloat(oldqty_loop)) - parseFloat(qty_loop);

        if (tot_qty < 0) {
            tot_qty = "0";
            $("#qty" + id).val(0);
            $("#qty_error" + id).html("Quantity out of stock");
        }
        else {
            tot_qty = tot_qty;
            $("#qty_error" + id).html("");
        }

        $("#item_q").html(tot_qty);

        return tot_qty;
    }

    function getStudentDetails() {
        var student_val = $("#autocomplete").val();
        var stud_no = student_val.substr(3, 6);

        console.log(student_val);
    }

    function selectStudent(val, allid) {

        //alert(val);

        $("#studno_suggest").val(val);
        $("#suggesstion-box").hide();

        var arr = allid.split('-');

        //console.log(arr);

        $("#class_sections_stud").html("<input type='hidden' name='studentid' id='studentid' value='" + arr[0] + "'><input type='hidden' id='boardid_s' value='" + arr[1] + "'><input type='hidden' id='classname_s' value='" + arr[2] + "'><input type='hidden' id='sectionname_s' name='sectionname_s' value='" + arr[3] + "'>");

        //$("#bid").val("'"+arr[1]+"'");
        $("#bid option[value='" + arr[1] + "']").prop('selected', true);
        //getClassDetails();
        //$("#classname option[value='"+arr[2]+"']").prop('selected', true);
        //getSectionDetails();
        //$("#sectionname option[value='"+arr[3]+"']").prop('selected', true);
        $(".combopackage_items_div").html("");

        getFeesDetails(arr[0], arr[2]);

        jq('select.select2').select2({
            allowClear: true,
            placeholder: "Please Select...",
            width: 'resolve',
        });
    }

    function getFeesDetails(s_id, c_id) {
        var selval = $("#status option:selected").val();


        if (selval == 1) {
            $('#class_sections').show();
            $('#class_sections').html('<img src="images/loaders/loading.gif" style="margin-left: 33%;width: 25%;">');

        }

        $.ajax({
            type: "POST",
            url: "inv_fees_details.php",
            data: {studentid: s_id, classid: c_id},
            success: function(data) {
                //console.log(data);
                $('#class_sections').html(data);

                getStdCombo(c_id);

            }
        });
    }

    function selectStaff(val) {
        $("#empno").val(val);
        $("#suggesstion-box_staff").hide();

    }

    function add_combo_table_tr(n) {

        var input = $("#row_item_" + n);
        input.removeAttr("disabled");
        var m = parseFloat(n) + 1;
        $("#combo_item_" + n).show();
        $("#addvalue_combo0").attr("onclick", "add_combo_table_tr(" + m + ")");
        calc_total();
    }

    function hide_combo_table_tr(n) {

        $("#combo_item_" + n).hide();
        $("#total_combo_amt" + n).val(0);
        $('#combopackage_items' + n).html("");

        var input = $("#combo_item_" + n);
        input.attr("disabled", "disabled");
        calc_total();
    }

    function add_table_tr(n) {

        var input = $("#row_item_" + n);
        input.removeAttr("disabled");
        var m = parseFloat(n) + 1;
        $("#row_item_" + n).show();
        $("#addvalue0").attr("onclick", "add_table_tr(" + m + ")");

        calc_total();

    }

    function hide_table_tr(n) {

        $("#row_item_" + n).hide();
        $("#qty" + n).val(0);
        $("#amount" + n).val(0);
        $("#total" + n).val(0);
        $('#total_amt' + n).val(0);
        var input = $("#row_item_" + n);
        input.attr("disabled", "disabled");

        calc_total();
    }



    function getComboPrice(id) {
        //console.log("getcombo price "+id);
        if ((typeof id != "undefined")) {
            var itemid = $("#combopackage" + id + " option:selected").val();

            /*$.get("inv_combo_item_price.php",{combid:itemid},function(data){
             
             $('#total_combo_amt'+id).val(data);
             //calc_totalamount(id);
             calc_total();
             });*/

            $.ajax({
                type: "POST",
                url: "inv_material_combopackage_items.php",
                data: {comboid: itemid, id: id},
                success: function(data) {
                    //console.log(data);
                    //console.log(data);
                    $('#combopackage_items' + id).html(data);

                    checkComboItem_qty(id);

                    var sum = 0;

                    $(".comb_total_sell").each(function() {

                        var id_total = $(this).prop('id');

                        var comboqtyid_name = this.id;

                        if (comboqtyid_name.indexOf("combo_item_listtotal" + id) >= 0) {

                            comboqtyid_name = comboqtyid_name.replace("combo_item_listtotal", "");

                            var comboqtyid_array = comboqtyid_name.split("_");
                            var id11 = comboqtyid_array[0];
                            var id12 = comboqtyid_array[1];

                            if ($("#combo_item_list" + id11 + "_" + id12).is(":checked")) {

                                sum = parseFloat(sum) + parseFloat($('#' + id_total).val());
                                //$('#overall_totamount').val(sum);

                            }
                        }
                    });

                    $("#total_combo_amt" + id).val(sum);
                    calc_total();
                }
            });
        }
        else {
            $('.combo_total').val(0);
            //calc_totalamount(id);
            calc_combototal();
            calc_total();
        }

    }

    function checkComboItem_qty() {

        var qty_loop = 0;
        var comb_qty = 0;
        $(".comboqty_class").each(function() {

            var comboqtyid_name = this.id;

            //var loop_itemval = $("#"+itemid+" option:selected").val();

            comboqtyid_name = comboqtyid_name.replace("combo_item_listqty", "");

            var comboqtyid_array = comboqtyid_name.split("_");


            if ($("#combo_item_listst" + comboqtyid_array[0] + "_" + comboqtyid_array[1]).val() == 1) {

                //console.log($("#combo_item_listst"+comb_id+"_"+comboqtyid_array[1]).val());

                var curr_itemval = $("#combo_item_listid" + comboqtyid_array[0] + "_" + comboqtyid_array[1]).val();

                checkComboItem_qty_ajax(curr_itemval, comboqtyid_array[0], comboqtyid_array[1]);

            }

        });



    }

    function checkComboItem_qty_ajax(curr_itemval, comb_id, citem_id) {

        $.ajax({
            method: "GET",
            url: "inv_item_price.php",
            dataType: 'json',
            data: {itemid: curr_itemval},
            success: function(data) {

                if (data) {
                    //console.log("stock_qty "+data.item_qty);
                    var final_qty = getEachComboItem_qty(curr_itemval, data.item_qty, comb_id, citem_id);
                    //calc_totalamount(id);
                } else {

                    //$(".qty_notify").show();
                    //$("#item_q").html(0);
                    $("#comboqty_error" + comb_id + "_" + citem_id).html(" ");
                }
            }

        });

    }

    function getEachComboItem_qty(curr_itemval, stock_qty, comb_id, citem_id) {

        var qty_loop = 0;
        var comb_qty = 0;
        $(".itemname_class").each(function() {

            var itemid = this.id;
            var loop_itemval = $("#" + itemid + " option:selected").val();
            var id_no = itemid.replace("itemname", "");

            if (curr_itemval == loop_itemval) {

                comb_qty = $("#combo_item_listqty" + comb_id + "_" + citem_id).val();

                qty_loop = (qty_loop + parseInt($("#qty" + id_no).val())) + parseInt(comb_qty);

                //console.log(itemid+' '+id_no);
            }

        });

        var tot_qty = stock_qty - qty_loop;
        console.log("total qty " + tot_qty);

        if (tot_qty < 0) {
            tot_qty = "0";

            $("#comboqty_error" + comb_id + "_" + citem_id).html("Quantity out of stock");

            $("#combo_item_list" + comb_id + "_" + citem_id).attr('checked', false);
            changeCheckedItem(comb_id, citem_id);
        }
        else {
            tot_qty = tot_qty;
            $("#comboqty_error" + comb_id + "_" + citem_id).html(" ");
        }

        return tot_qty;
    }

    function changeCheckedItem(combid, citemid) {
        //console.log("combo id "+combid+" combo item id "+citemid);
        var itemtotal;
        var tot_comb_total;
        var combo_total;

        if ($("#combo_item_list" + combid + "_" + citemid).is(":checked")) {
            // alert("Checkbox is checked.");
            $("#combo_item_listst" + combid + "_" + citemid).val(1);
            itemtotal = $("#combo_item_listtotal" + combid + "_" + citemid).val();
            combo_total = $("#total_combo_amt" + combid).val();
            tot_comb_total = parseFloat(combo_total) + parseFloat(itemtotal);
            //console.log('combo total if' + combo_total);
        }
        else if ($("#combo_item_list" + combid + "_" + citemid).is(":not(:checked)")) {
            //alert("Checkbox is unchecked.");
            $("#combo_item_listst" + combid + "_" + citemid).val(0);

            itemtotal = $("#combo_item_listtotal" + combid + "_" + citemid).val();
            combo_total = $("#total_combo_amt" + combid).val();
            tot_comb_total = parseFloat(combo_total) - parseFloat(itemtotal);
            //console.log('combo total else' + combo_total);
        }

        $("#total_combo_amt" + combid).val(tot_comb_total);
        calc_total();
    }



    function calc_combototal() {

        var sum = 0;
        var combid;
        //alert('hi');

        $(".comb_total_sell").each(function() {

            var id_total = $(this).prop('id');

            var comboqtyid_name = this.id;

            comboqtyid_name = comboqtyid_name.replace("combo_item_listtotal", "");

            var comboqtyid_array = comboqtyid_name.split("_");
            combid = comboqtyid_array[0];

            sum = parseFloat(sum) + parseFloat($('#' + id_total).val());

            //$('#overall_totamount').val(sum);

        });

        $("#total_combo_amt" + combid).val(sum);
        calc_total();

    }
    function calc_totalamount(id) {

        var qty = ($('#qty' + id).val() == "") ? 0 : $('#qty' + id).val();
        var sellprice = ($('#selling_price' + id).val() == "") ? 0 : $('#selling_price' + id).val();

        var total = parseFloat(qty) * parseFloat(sellprice);

        $('#total_amt' + id).val(total);

        calc_total();

    }

    function calc_total() {

        var sum = 0;
        var disc = ($('#discount').val() == "") ? 0 : $('#discount').val();

        $(".single_total").each(function() {

            var id_total = $(this).prop('id');

            sum = parseFloat(sum) + parseFloat($('#' + id_total).val());

            //$('#overall_totamount').val(sum);

        });

        var tot_total = parseFloat(sum) - parseFloat(disc);
        //tot_total = (tot_total<0) ? 0 : tot_total; 
        $('#overall_totamount').val(tot_total);

    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function isDecimal(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode
        if (
                (charCode != 45) && // “-” CHECK MINUS, AND ONLY ONE.
                (charCode != 46 || $(element).val().indexOf('.') != -1) && // “.” CHECK DOT, AND ONLY ONE.
                (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function getNumber() {

        var selval = $("#status option:selected").val();
        $("#empno").val('');
        $("#studno_suggest").val('');
        if (selval == 1) {
            //student
            $('.fees_details').show();
            $('#stud_no').show();
            $('#staff_no').hide();

            $("#class_sections").html("");
            $("#class_sections_staff").html("");
            // $("#classname option:eq(0)").html("All").val('0');
            getStdCombo(0);
        } else {
            //staff
            $('.fees_details').hide();
            $('#stud_no').hide();
            $('#staff_no').show();
            $("#class_sections").html("");
            $("#class_sections_stud").html("");
            // $("#classname option:eq(0)").html("Select Class Name").val('');
            setSectionName();
            $.ajax({
                method: "GET",
                url: "inv_class_sec_board.php",
                data: {itemid: ""},
                success: function(data) {
                    //$('#class_sections').html(data);

                }
            });
        }
        //$("#class_sections").show();
    }

    function getClassDetails() {

        var selval = $("#bid option:selected").val();
        var staff = $("#status option:selected").val();
        $.get("inv_class_list.php", {bid: selval}, function(data) {
            $("#classname").html('<option value="">Select Class Name</option>');
            $("#classname").append(data);

            //if(staff==0){
            $("#classname option[value='0']").remove();
            //}

        });


        //getSectionDetails();

    }

    function getSectionDetails() {
        var selval = $("#classname option:selected").val();
        $.get("inv_section_list.php", {secid: selval}, function(data) {
            //$("#classname").html('<option value="">Select Section Name</option>');
            $("#sectionname").html(data);
        });

        if ($("#classname_s").val() != selval) {

            $("#studno_suggest").val("");
            $("#class_sections").html("");

        }

        getStdCombo(selval);
    }

    function getStdCombo(classid) {

        $.get("inv_combo_list.php", {classid: classid}, function(data) {

            $("select.comboclass").html(data);
            //$(".combopackage_items_div").html("");			

//                jq('select.comboclass.select2').select2({
//                    allowClear: true,
//                    placeholder: "Please Select...",
//                    width: 'resolve',
//                });
            //jq("select.comboclass.select2").select2("val", "");

            getComboPrice();
        });


    }

    function setSectionName() {

        var selval = $("#sectionname option:selected").val();


        $("#class_sections_staff").html("<input type='hidden' id='sectionname_s' name='sectionname_s' value='" + selval + "'>");

    }


    function showCategory(st) {
        var s = st.split("-");
        var str = s[0];
        var clas = s[1];



        if (clas.indexOf("XI") >= 0) {

            $("#showclass").show();
        } else {
            $("#showclass").hide();
        }

        if (str == "") {
            document.getElementById("section").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("section").innerHTML = xmlhttp.responseText;

                $('#section option:eq(1)').attr('selected', 'selected');

                var c = $('#section').val().split("-");


                $("#uniform-section span").html(c[1]);

                //$("#section").val($("#section option:first").val());
            }
        }
        xmlhttp.open("GET", "sectionlist_new.php?mmtid=" + str, true);

        xmlhttp.send();
    }
</script>  
</body>
</html>
<? ob_flush(); ?>