<? ob_start(); ?>
<?php
session_start();
$user=$_SESSION['uname'];

error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

$settingslist = mysql_query("SELECT * FROM inv_settings WHERE set_id=1");
$settings = mysql_fetch_array($settingslist);

if (isset($_POST['submit'])) {

    $over_total = $_POST['overall_totamount'];
    $disamt = $_POST['discount_amt'];
    $ptype = $_POST['ptype'];
    $pay_number = $_POST['pay_number'];

    $ba_id = $_POST['baid'];
    $bank_name = $_POST['bank_name'];
    $account_no = $_POST['account_no'];
    $billno = $_POST['bill_autono'];
    if (!isset($_POST['cheque_date']))
        $_POST['cheque_date'] = '00/00/0000';

    $cdate = str_replace('/', '-', $_POST['cheque_date']);
    $cheque_date = date("Y-m-d", strtotime($cdate));

    if (($over_total > 0) || ($disamt>0 && $over_total==0)) {


        $stud_staff = $_POST['status'];
        $catid = $_POST['category'];



        if ($settings['bill_mode'] == 1) {
            //echo 'hihihi_before comboi';
            $bill_result = mysql_query("select * from inv_category where cat_id=$catid") or die(mysql_error());
            $bill_row = mysql_fetch_assoc($bill_result);
            $auto_bill = $bill_row['Cat_billno'];
            $billno = $bill_row['cat_prefix'] . str_pad($auto_bill, 5, '0', STR_PAD_LEFT);
        } else {
            //echo 'hihihi_before comboi';
            $bill_result = mysql_query("select * from tc_no where id=7") or die(mysql_error());
            $bill_row = mysql_fetch_assoc($bill_result);
            $auto_bill = $bill_row['count'];
            $billno = "MI" . str_pad($bill_row['count'], 5, '0', STR_PAD_LEFT);
            $catid = 0;
        }

        if ($_POST['empno'] != "") {
            $adm_emp_no = $_POST['empno'];
        } else {
            $adm_emp_no = $_POST['studno'];
        }

        $boardid = $_POST['boardid'];
        $classid = $_POST['classname'];
        $secid = $_POST['sectionname_s'];
        $disamt = $_POST['discount_amt'];
        $over_total = $_POST['overall_totamount'];

        if (isset($_POST['studentid'])) {
            $studentid = $_POST['studentid'];
        } else {
            $studentid = 0;
        }

        $adate = str_replace('/', '-', $_POST['mat_date']);
        $receipt_date = date("Y-m-d", strtotime($adate));

        $result_parent = mysql_query("INSERT INTO inv_material_parent (mat_date,bill_no,stud_staff,adm_emp_no,studid,board_id,class_id,section_id,discount,overall_total,paid_status,cat_id,ay_id,billgenerate) VALUES
		('$receipt_date','$billno','$stud_staff','$adm_emp_no','$studentid','$boardid','$classid','$secid','$disamt','$over_total','1','$catid','$acyear','$user')");

        $parentid = mysql_insert_id();
		//echo "INSERT INTO inv_material_parent (mat_date,bill_no,stud_staff,adm_emp_no,studid,board_id,class_id,section_id,discount,overall_total,paid_status,cat_id) VALUES
		//('$receipt_date','$billno','$stud_staff','$adm_emp_no','$studentid','$boardid','$classid','$secid','$disamt','$over_total','1','$catid')"; die;

        if ($result_parent) {

            $sql_pay = "INSERT INTO inv_material_payment (mat_parent_id,mat_pay_date,payamount,p_type,pay_number,ba_id,bank,account,c_date) VALUES
('$parentid','$receipt_date','$over_total','$ptype','$pay_number','$ba_id','$bank_name','$account_no','$cheque_date')";

            $result_pay = mysql_query($sql_pay) or die("Could not insert data into DB: " . mysql_error());
            if ($result_pay) {

                /*                 * ********************************Hand cash pay Update **************************************** */
                if ($ptype == 'cash') {
                    $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
                    $cash = mysql_fetch_array($cashlist);
                    $currentcash = $cash['amount'];
                    $updatecash = $currentcash + $over_total;
                    $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
                }
            }
            //update bill no
            $bill_inc_no = $auto_bill + 1;
            if ($settings['bill_mode'] == 1) {

                $result_bill = mysql_query("UPDATE inv_category SET Cat_billno='$bill_inc_no' where cat_id=$catid") or die("Could not insert data into DB: " . mysql_error());
            } else {

                $result_bill = mysql_query("UPDATE tc_no SET count='$bill_inc_no' where id=7") or die("Could not insert data into DB: " . mysql_error());
            }

            for ($i = 0; $i <= 30; $i++) {

                $itemnames = $_POST['itemname'];
                $brandnames = $_POST['brandname'];
                $qtys = $_POST['qty'];
                $uomnames = $_POST['uomname'];
                $sellprices = $_POST['selling_price'];
                $totalamts = $_POST['total_amt'];
                $uomname_news = $_POST['uomname_new'];

                $itemname = $itemnames[$i];
                $brandname = $brandnames[$i];
                $qty = $qtys[$i];
                $uomname = $uomnames[$i];
                //$buyprice = $buyprices[$i];
                $sellprice = $sellprices[$i];
                $totalamt = $totalamts[$i];
                $uomname_new = $uomname_news[$i];

                if ($totalamt == "" || $totalamt == 0) {
                    
                } else {
                    $sql = "INSERT INTO inv_material (mat_parent_id,item_id,brand_id,sell_price,qty,uom_id,total,uomname_new) VALUES
		('$parentid','$itemname','$brandname','$sellprice','$qty','$uomname','$totalamt','$uomname_new')";

                    $result = mysql_query($sql) or die("Could not insert inv_material data into DB: " . mysql_error());

                    if ($result) {
                        $result_select = mysql_query("select * from inv_items where item_id=$itemname");
                        $row_items_select = mysql_fetch_assoc($result_select);
                        //set total qty
                        $tot_qty5 = $row_items_select['item_qty'] - $qty;
                        $tot_qty = ($tot_qty5 < 0) ? "0" : $tot_qty5;
                        //update total qty
                        $sql_item = "UPDATE inv_items SET item_qty='$tot_qty' where item_id=$itemname";
                        $result1 = mysql_query($sql_item) or die("Could not insert inv_items data into DB: " . mysql_error());

                        //start update brand qty
                        $qry_brand1 = mysql_query("select * from inv_brand_items where item_id=$itemname and brand_id = $brandname");
                        $row_brand1 = mysql_fetch_assoc($qry_brand1);

                        if (!empty($row_brand1)) {

                            $brand_qty = $row_brand1['qty'] - $qty;
                            $sql_item_brand1 = mysql_query("UPDATE inv_brand_items SET qty='$brand_qty' where item_id=$itemname and brand_id = $brandname");
                        }

                        //end brand qty
                    }
                }
            }


            //combo items insert
            for ($j = 0; $j <= 30; $j++) {

                $combopackages = $_POST['combopackage'];
                $total_comboamts = $_POST['total_combo_amt'];

                $com_parent_id = $combopackages[$j];
                $total_comboamt = $total_comboamts[$j];

                if ($total_comboamt == "" || $total_comboamt == 0) {
                    
                } else {

                    $sql_combo_parent = "INSERT INTO inv_material_combo_parent (mat_parent_id,com_parent_id,total_amt) VALUES
			('$parentid','$com_parent_id','$total_comboamt')";

                    $result_combo_parent = mysql_query($sql_combo_parent) or die("Could not insert inv_material_combo_parent data into DB: " . mysql_error());
                    $mat_com_parentid = mysql_insert_id();



                    if ($result_combo_parent) {

                        //start material_combo child

                        $combopackages_liststs = $_POST['combo_item_listst'];
                        $combopackages_listids = $_POST['combo_item_listid'];

                        $combo_item_listbrands = $_POST['combo_item_listbrand'];
                        $combo_item_listqtys = $_POST['combo_item_listqty'];
                        $combo_item_listuoms = $_POST['combo_item_listuom'];

                        $combo_item_listtotals = $_POST['combo_item_listtotal'];

                        //	echo "Count number ".count($combopackages_liststs);	

                        for ($k = 0; $k < count($combopackages_liststs); $k++) {

                            $combopackages_listst = $combopackages_liststs[$k];
                            $combopackages_listid = $combopackages_listids[$k];
                            $combo_item_listbrand = $combo_item_listbrands[$k];
                            $combo_item_listqty = $combo_item_listqtys[$k];
                            $combo_item_listuom = $combo_item_listuoms[$k];
                            $combo_item_listtotal = $combo_item_listtotals[$k];

                            if ($combopackages_listst == 1 && ($combo_item_listtotal != 0 && $combo_item_listtotal != "")) {

                                $qry1 = "SELECT * FROM inv_purchase
	 WHERE item_id = " . $combopackages_listid . " order by inv_purchase.created desc limit 1";

                                $result_items = mysql_query($qry1);

                                $row_items = mysql_fetch_array($result_items);
                                //echo print_r($row_items);

                                $result_combochild = mysql_query("INSERT INTO inv_material_combo_child (mat_com_id,item_id,brand_id,sell_price,qty) VALUES
						('$mat_com_parentid','" . $combopackages_listid . "','" . $combo_item_listbrand . "','" . $row_items['sell_price'] . "','" . $combo_item_listqty . "')") or die("Could not insert inv_material_combo_child data into DB: " . mysql_error());

                                if ($result_combochild) {
                                    $result_select = mysql_query("select * from inv_items where item_id=" . $combopackages_listid);
                                    $row_items_select = mysql_fetch_assoc($result_select);
                                    //set total qty
                                    $tot_qty6 = $row_items_select['item_qty'] - $combo_item_listqty;
                                    $tot_qty_1 = ($tot_qty6 < 0) ? "0" : $tot_qty6;
                                    //update total qty
                                    $sql_item = "UPDATE inv_items SET item_qty='$tot_qty_1' where item_id=" . $combopackages_listid;
                                    $result1 = mysql_query($sql_item) or die("Could not update combo items data into DB: " . mysql_error());

                                    //start update brand qty
                                    $qry_brand12 = mysql_query("select * from inv_brand_items where item_id=$combopackages_listid and brand_id = $combo_item_listbrand");
                                    $row_brand12 = mysql_fetch_assoc($qry_brand12);

                                    if (!empty($row_brand12)) {

                                        $brand_qty1 = $row_brand12['qty'] - $combo_item_listqty;
                                        $sql_item_brand12 = mysql_query("UPDATE inv_brand_items SET qty='$brand_qty1' where item_id=$combopackages_listid and brand_id = $combo_item_listbrand");
                                    }

                                    //end brand qty
                                }
                            }
                        }
                        //end material_combo child
                    }
                }
            }//end combo packgae
        }

        if ($result_parent) {

            header("Location:inv_material_issue_new.php?parentid=$parentid&catid=$catid&msg=succ");
        }
        exit;
    } else {
        header("Location:inv_material_issue_new.php?msg=err");
    }
    exit;
}
?>
<link rel="stylesheet" href="stylesheets/sample_pages/invoice.css" type="text/css" />

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
                        <p>Your data successfully created!!!</p>

                    </div>
                <?php } if ($msg === "err") {
                    ?>
                    <div class="notify notify-error">						
                        <a href="javascript:;" class="close">&times;</a>						
                        <h3>Error Notifty</h3>						
                        <p>Your data has not been created!!! Please give atleast one Item..!!!</p>
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
                            <h3>Add New Material</h3>
                        </div> <!-- .widget-header -->
                        <div class="widget-content">
                            <?php
                            $bill_result = mysql_query("select * from tc_no where id=7") or die(mysql_error());
                            $bill_row = mysql_fetch_assoc($bill_result);
                            $biil_auto = $bill_row['count'];
                            $billno = "INV" . str_pad($bill_row['count'], 3, '0', STR_PAD_LEFT);
                            ?>

                            <form class="form uniformForm validateForm" method="post" action="" >

                                <div class="grid-8">	
                                    <div class="widget-content">
                                        <div class="field-group">
                                            <label for="required">Receipt No.<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="billno" id="billno" size="32" class="validate[required]" readonly value="<?php echo $billno; ?>" style="width: 100%;"/>	
                                                <input type="hidden" value="<?php echo $biil_auto; ?>" name="bill_autono">

                                            </div>

                                        </div> 
                                        <div class="clear"></div>
                                        <div class="field-group">		
                                            <label>Student / Staff<span class="error"> * </span>:</label>			
                                            <div class="field">
                                                <select name="status" id="status" class="required select2" onChange="getNumber();">	
                                                    <option value="1">Student</option>	
                                                    <option value="0">Staff</option>											
                                                </select>										
                                            </div>		
                                        </div>

                                        <div class="field-group" style="display:none" id="staff_no">
                                            <label for="required">Staff Employee No.<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="empno" id="empno" size="32" class="validate[required]" />	
                                                <div id="suggesstion-box_staff"></div>
                                                <div id="class_sections_staff">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group" id="stud_no">
                                            <label for="required">Student Admin No.<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="studno" class="biginput validate[required]" id="studno_suggest" autocomplete="off" size="32" />

                                                <div id="suggesstion-box"></div>
                                            </div>
                                            <div id="class_sections_stud"></div>
                                        </div>

                                    </div>
                                </div>	

                                <div class="grid-8">	
                                    <div class="widget-content">
                                        <div class="field-group">	
                                            <label for="required">Receipt Date<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input id="datepicker" name="mat_date" class="required" type="text" value="<?php echo date("d/m/Y"); ?>" readonly />
                                            </div>
                                        </div>
                                        <!-- .field-group -->
                                        <div class="field-group">		
                                            <label>Class<span class="error"> * </span>:</label>			
                                            <div class="field">

                                                <select name="classname" id="classname" class="form-control required select2" onChange="getSectionDetails();">
                                                    <option value="">Select Class Name</option>
                                                </select>

                                            </div>			
                                        </div> <!-- .field-group -->    


                                    </div>
                                </div>

                                <div class="grid-8">	
                                    <div class="widget-content">
                                        <div class="field-group">		
                                            <label for="select">Board <span class="error"> * </span>:</label>
                                            <div class="field">
                                                <?php
                                                $classl = "SELECT * FROM board";
                                                $result1 = mysql_query($classl) or die(mysql_error());
                                                echo '<select name="boardid" id="bid"  class="required select2" onChange="getClassDetails();">';
//                                                <option value="">Select Board</option>
                                                while ($row1 = mysql_fetch_assoc($result1)):

                                                    echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";

                                                endwhile;
                                                echo '</select>';
                                                ?>

                                            </div>		
                                        </div>

                                        <div class="field-group">		
                                            <label>Section<span class="error"> * </span>:</label>			
                                            <div class="field">
                                                <select name="sectionname" id="sectionname" class="form-control required select2" onChange="setSectionName();" >
                                                    <option value="0">All</option>
                                                </select>    																				
                                            </div>		
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
                                <?php if ($settings['bill_mode'] == 1) { ?>
                                    <div class="grid-8">	
                                        <div class="widget-content">
                                            <div class="field-group">		

                                                <div class="field">
                                                    <?php
                                                    $catsql = "SELECT * from inv_category where cat_status=1";
                                                    $result_cat = mysql_query($catsql) or die(mysql_error());
                                                    echo '<select name="category" id="categoryname" class="category_class select2 required" onChange="getCategory_Items();"> <option value="">Select Category </option>';
                                                    while ($row_cat = mysql_fetch_assoc($result_cat)):
                                                        echo "<option value='{$row_cat['cat_id']}'>{$row_cat['category_name']}</option>\n";
                                                    endwhile;
                                                    echo '</select>';
                                                    ?>      																				
                                                </div>		
                                            </div>
                                        </div>		
                                    </div>
                                <?php } ?>
                                <table class="table purchase_item">
                                    <thead>				        
                                        <tr>
                                            <th width="25%">Item Name</th>
                                            <th width="10%">Brand Name</th>
                                            <th width="10%">Qty</th>
                                            <th width="10%">UOM</th>
                                            <th width="20%">Selling Price</th>
                                            <th width="20%">Total</th>
                                            <th width="5%"></th>
                                        </tr>                              
                                    </thead>					        
                                    <tbody class="dfdf">

                                        <?php for ($i = 0; $i <= 30; $i++) { ?>

                                            <tr id="row_item_<?= $i; ?>" <?php
                                            if ($i != 0) {
                                                echo 'style="display: none;"';
                                            }
                                            ?> >
                                                <td>
                                                    <div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            $itemsql = "SELECT inv_items.item_id,item_name FROM inv_items inner join inv_purchase on (inv_purchase.item_id =inv_items.item_id)
                                                                    where item_status=1 and active=1 group by inv_items.item_id";
                                                            $result = mysql_query($itemsql) or die(mysql_error());
                                                            echo '<select name="itemname[]" id="itemname' . $i . '" class="itemname_class select2" onChange="getBrand(' . $i . ');"> <option value="0">Select Item </option>';
                                                            while ($row = mysql_fetch_assoc($result)):
                                                                echo "<option value='{$row['item_id']}'>{$row['item_name']}</option>\n";
                                                            endwhile;
                                                            echo '</select>';
                                                            ?>      																				
                                                        </div>		
                                                    </div> <!-- .field-group -->
                                                </td>
                                                <td style="width:10% !important;">
                                                    <div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            $itemsql = "SELECT brand_id,brand_name FROM inv_brand";
                                                            $result = mysql_query($itemsql) or die(mysql_error());
                                                            echo '<select name="brandname[]" id="brandname' . $i . '" class="select2" onChange="getItemPrice(' . $i . ');"> <option value="0"> N/A </option>';
//                                                            while ($row = mysql_fetch_assoc($result)):
//                                                                echo "<option value='{$row['brand_id']}'>{$row['brand_name']}</option>\n";
//                                                            endwhile;
                                                            echo '</select>';
                                                            ?>      																				
                                                        </div>		
                                                    </div> <!-- .field-group -->
                                                </td>
                                                <td>
                                                    <div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="qty[]" id="qty<?= $i; ?>" class="qty_class text_field" size="15" value="0"  
                                                                   onkeypress="return isDecimal(event, this);" onkeyup="checkQty(<?= $i; ?>);"/>
                                                            <span class="error" id="qty_error<?= $i; ?>">  </span>	
                                                        </div>
                                                    </div> 
                                                </td>
                                                <td>
                                                    <div class="field-group" id="uom_group<?php echo $i; ?>">

                                                                                                                <!--<label id="uom<?php echo $i; ?>" > </label>
                                                                                                                <input type="hidden" name="uomname[]" id="uom_name<?= $i; ?>" />-->
                                                    </div> 
                                                </td>
                                                <td><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="selling_price[]" id="selling_price<?= $i; ?>" size="15" class="text_field"  readonly />	
                                                        </div>
                                                    </div></td>
                                                <td><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="total_amt[]" id="total_amt<?= $i; ?>"  class="single_total text_field" size="15" readonly value="0"/>	
                                                        </div>
                                                    </div>
                                                </td>
                                                <td> 
                                                    <?php
                                                    if ($i != 0) {
                                                        echo '<img onclick="hide_table_tr(' . $i . ')" src="../img/icons/packs/fugue/16x16/minus-button.png">';
                                                    }
                                                    if ($i == 0) {
                                                        echo '<a id="addvalue' . $i . '" onclick="add_table_tr(' . $i . '+1)" style="cursor:pointer"> <img src="../img/icons/packs/fugue/16x16/plus-button.png" title="Add New"/></a></td>';
                                                    }
                                                }
                                                ?>

                                            </td>
                                        </tr>
                                        <!-- Start Combo package -->

                                        <tr>
                                            <td colspan="7" ><center><div style="float:left; font-size:14px; font-weight:bold;">Combo Package :</div></center></td>
                                    </tr>
                                    <?php for ($c = 0; $c <= 30; $c++) { ?>
                                        <tr id="combo_item_<?= $c; ?>" <?php
                                        if ($c != 0) {
                                            echo 'style="display: none;"';
                                        }
                                        ?>>
                                            <td colspan="5">
                                                <div class="field-group">		

                                                    <div class="field">
                                                        <select name="combopackage[]" id="combopackage<?php echo $c ?>" class="comboclass select2" onChange="getComboPrice(<?php echo $c ?>);">
                                                            <?php
                                                            $itemsql = "SELECT com_parent_id,package_name FROM inv_combo_parent where class_id=0";
                                                            $result = mysql_query($itemsql) or die(mysql_error());
                                                            echo ' 
											<option value="0">Select Combo </option>';
                                                            while ($row = mysql_fetch_assoc($result)):
                                                                echo "<option value='{$row['com_parent_id']}'>{$row['package_name']}</option>\n";
                                                            endwhile;
                                                            ?> 
                                                        </select>     																				
                                                    </div>		
                                                </div>

                                                <div id="combopackage_items<?php echo $c ?>" class="combopackage_items_div">



                                                </div>

                                            </td>

                                            <td >
                                                <div class="field">
                                                    <input type="text" name="total_combo_amt[]" id="total_combo_amt<?= $c; ?>"  class="text_field single_total combo_total" size="15" readonly value="0"/>	
                                                </div>
                                            </td>
                                            <td> 
                                                <?php
                                                if ($c != 0) {
                                                    echo '<img onclick="hide_combo_table_tr(' . $c . ')" src="../img/icons/packs/fugue/16x16/minus-button.png">';
                                                }
                                                if ($c == 0) {
                                                    echo '<a id="addvalue_combo' . $c . '" onclick="add_combo_table_tr(' . $c . '+1)" style="cursor:pointer"> <img src="../img/icons/packs/fugue/16x16/plus-button.png" title="Add New"/></a></td>';
                                                }
                                                ?>


                                            </td>
                                        </tr>
                                    <?php }
                                    ?>
                                    <!-- End Combo package -->  

                                    <!-- Start Discount and Total amount -->
                                    <tr>
                                        <td colspan="5" class="amount_td"><div style="float:right; font-size:14px; font-weight:bold;">Discount Amount:</div></td>
                                        <td class="amount_td">
                                            <div class="field">
                                                <input type="text" name="discount_amt" size="15"  id="discount" class="text_field" onkeypress="return isDecimal(event, this);" onkeyup="calc_total();"> 

                                            </div>
                                        </td>
                                        <td class="amount_td"></td>
                                    </tr>

                                    <tr>
                                        <td colspan="5" class="amount_td"><div id="overall_amount" style="float:right; font-size:14px; font-weight:bold;">Total Amount: </div></td>
                                        <td class="amount_td">
                                            <div class="field">
                                                <input type="text" name="overall_totamount" class="text_field" readonly size="15"  id="overall_totamount">

                                            </div>

                                        </td>
                                        <td class="amount_td"></td>
                                    </tr>
                                    <!-- End Discount and Total amount -->        
                                    </tbody>
                                </table>


                                <div class="grid-8">	
                                    <div class="widget-content">
                                        <div class="field-group">		
                                            <label for="textfield">Payment Type:</label>			
                                            <div class="field">
                                                <select name="ptype" id="ptype" class="required select2" onchange="payment_type()">
                                                    <option value="cash">Cash</option>	
                                                    <option value="card">Card</option>
                                                    <option value="cheque">Cheque</option>									
                                                </select>							
                                            </div>		
                                        </div>
                                    </div>		
                                </div>

                                <div class="clear"></div>
                                <div id="ajax_pay">
                                </div>
                                <div id="cash_pay">
                                </div>
                                <div class="clear"></div>
                                <div class="actions">						
                                    <button type="submit" name="submit" class="btn btn-error">Submit</button>
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





    <?php include("includes/footer.php");
    ?>

    <style>
        .table tbody tr td.amount_td{
            border:0px;
        }
    </style>


    <script type="text/javascript">
        $(document).ready(function() {
            $("#datepicker,.datepicker").datepicker({
                dateFormat: 'dd/mm/yy'
            });
            if ($("select option:selected").length) {
                //alert("sd")

            }
            getClassDetails();
            //auto complete
            //for student  
            $("#studno_suggest").keyup(function() {

                var classname = $("#classname option:selected").val();
                var sectionname = $("#sectionname option:selected").val();
                // console.log(classname);
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

            //class dropdown
            /*var selval_st = $("#status option:selected").val();
             if(selval_st==1){
             //student
             
             $("#classname option:eq(0)").html("All").val('0');
             
             }else{
             //staff
             $("#classname option:eq(0)").html("Select Class Name").val('');
             }
             */

            jq("select.select2").select2("val", "");

        });
    </script>

    <script type="text/javascript">

        function payment_type() {
            var x = document.getElementById("ptype").value;
            if (x != "cash") {
                $('#cash_pay').hide();
            } else {
                $('#cash_pay').show();
            }
            $.get("inv_payment_type.php", {value: x}, function(data) {
                $("#ajax_pay").html(data);
            });
        }
        function getCategory_Items() {

            var catid = $("#categoryname option:selected").val();

            $.get("inv_category_bill.php", {catid: catid}, function(data) {
                for (i = 0; i <= 30; i++) {
                    $("#itemname" + i).html(data);
                }
            });

            $.get("inv_category_bill_no.php", {catid: catid}, function(data) {

                $("#billno").val(data);

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

                    console.log(data);
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
            $(".itemname_class").each(function() {

                var itemid = this.id;

                var loop_itemval = $("#" + itemid + " option:selected").val();

                var id_no = itemid.replace("itemname", "");

                if (curr_itemval == loop_itemval) {
                    qty_loop = qty_loop + parseFloat($("#qty" + id_no).val());
                    //console.log(itemid+' '+id_no);
                }

            });

            //console.log("Qty total "+qty_loop);

            var tot_qty = stock_qty - qty_loop;

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

            // console.log(student_val);
        }

        function selectStudent(val, allid) {
            $("#studno_suggest").val(val);
            $("#suggesstion-box").hide();

            var arr = allid.split('-');

            //console.log(arr);

            $("#class_sections_stud").html("<input type='hidden' name='studentid' id='studentid' value='" + arr[0] + "'><input type='hidden' id='boardid_s' value='" + arr[1] + "'><input type='hidden' id='classname_s' value='" + arr[2] + "'><input type='hidden' id='sectionname_s' name='sectionname_s' value='" + arr[3] + "'>");

            //$("#bid").val("'"+arr[1]+"'");
            $("#bid option[value='" + arr[1] + "']").prop('selected', true);
            //getClassDetails();

            //$("#sectionname option[value='"+arr[3]+"']").prop('selected', true);

            getFeesDetails(arr[0], arr[2]);

            jq('select.select2').select2({
                allowClear: true,
                placeholder: "Please Select...",
                width: 'resolve',
            });

        }

        function getFeesDetails(s_id, c_id) {

            $('#class_sections').show();

            $('#class_sections').html('<img src="images/loaders/loading.gif" style="margin-left: 33%;width: 25%;">');

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

            jq('select.select2').select2({
                allowClear: true,
                placeholder: "Please Select...",
                width: 'resolve',
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
            $("#total_amt" + n).val(0);

            var input = $("#row_item_" + n);
            input.attr("disabled", "disabled");

            calc_total();

        }


        function getComboPrice(id) {
            //console.log((typeof id != "undefined"));

            if ((typeof id !== "undefined")) {

                var itemid = $("#combopackage" + id + " option:selected").val();



                /*	$.get("inv_combo_item_price.php",{combid:itemid},function(data){
                 //console.log("dat "+data);
                 $('#total_combo_amt'+id).val(data);
                 //calc_totalamount(id);
                 calc_total();
                 });	
                 */
                $.ajax({
                    type: "POST",
                    url: "inv_material_combopackage_items.php",
                    data: {comboid: itemid, id: id},
                    success: function(data) {
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

            $(".itemname_class").each(function() {

                var itemid = this.id;
                var loop_itemval = $("#" + itemid + " option:selected").val();
                var id_no = itemid.replace("itemname", "");

                if (curr_itemval == loop_itemval) {

                    var comb_qty = $("#combo_item_listqty" + comb_id + "_" + citem_id).val();

                    qty_loop = (qty_loop + parseFloat($("#qty" + id_no).val())) + parseFloat(comb_qty);

                    //console.log(itemid+' '+id_no);
                }

            });
            // console.log("stock_qty qty " + stock_qty + " qty loop " + qty_loop);
            var tot_qty = stock_qty - qty_loop;

            //console.log("total qty each combo with items "+tot_qty);

            if (tot_qty < 0) {

                tot_qty = "0";
                //alert('if combo total'+tot_qty);
                $("#comboqty_error" + comb_id + "_" + citem_id).html("Quantity out of stock");

                $("#combo_item_list" + comb_id + "_" + citem_id).attr('checked', false);
                changeCheckedItem(comb_id, citem_id);
            }
            else {

                tot_qty = tot_qty;
                //alert('else combo total'+tot_qty);
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

                $("#combo_item_listst" + combid + "_" + citemid).val(1);
                itemtotal = $("#combo_item_listtotal" + combid + "_" + citemid).val();
                combo_total = $("#total_combo_amt" + combid).val();
                tot_comb_total = parseFloat(combo_total) + parseFloat(itemtotal);
                //calc_combototal();
            }
            else if ($("#combo_item_list" + combid + "_" + citemid).is(":not(:checked)")) {
                //alert("Checkbox is unchecked.");
                $("#combo_item_listst" + combid + "_" + citemid).val(0);

                itemtotal = $("#combo_item_listtotal" + combid + "_" + citemid).val();
                combo_total = $("#total_combo_amt" + combid).val();
                tot_comb_total = parseFloat(combo_total) - parseFloat(itemtotal);

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
            if (selval == 1) {
                //student
                $('.fees_details').show();
                $("#empno").val('');
                $('#stud_no').show();
                $('#staff_no').hide();

                $("#class_sections").html("");

                //  $("#classname option:eq(0)").html("All").val('0');
                $("#class_sections_staff").html("");
                getStdCombo(0);
            } else {
                //staff
                $('.fees_details').hide();
                $("#studno_suggest").val('');
                $('#stud_no').hide();
                $('#staff_no').show();

                $("#class_sections").html("");

                $("#class_sections_stud").html("");
                //$("#classname option:eq(0)").html("Select Class Name").val('');
                $("#classname option[value='0']").remove();

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
            //jq("select.select2#classname").select2("val", "");
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

            //var classid= $("#classname option:selected").val();
            getStdCombo(selval);
        }

        function getStdCombo(classid) {


            $.get("inv_combo_list.php", {classid: classid}, function(data) {
                console.log(data);
                $("select.comboclass").html(data);
                $(".combopackage_items_div").html("");

                jq('select.comboclass.select2').select2({
                    allowClear: true,
                    placeholder: "Please Select...",
                    width: 'resolve',
                });
                jq("select.comboclass.select2").select2("val", "");

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