<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

$parentid = $_GET['parentid'];
$exbilllist1 = mysql_query("SELECT * FROM inv_material_parent WHERE mat_parent_id=$parentid");
$exbill1 = mysql_fetch_array($exbilllist1);
$catid = $exbill1['cat_id'];
if (isset($_POST['submit'])) {

    $over_total = $_POST['overall_totamount'];
    $disamt = $_POST['discount_amt'];
    $ptype = $_POST['ptype'];
    $pay_number = $_POST['pay_number'];

    $ba_id = $_POST['baid'];
    $bank_name = $_POST['bank_name'];
    $account_no = $_POST['account_no'];
    if (!isset($_POST['cheque_date']))
        $_POST['cheque_date'] = '00/00/0000';

    $cdate = str_replace('/', '-', $_POST['cheque_date']);
    $cheque_date = date("Y-m-d", strtotime($cdate));

    if (($over_total > 0) || ($disamt>0 && $over_total=0)) {

        $parentid = $_POST['parent_id'];

        $auto_bill = $_POST['bill_autono'];
        $billno = $_POST['billno'];
        $stud_staff = $_POST['status'];

        if ($_POST['empno'] != "") {
            $adm_emp_no = $_POST['empno'];
        } else {
            $adm_emp_no = $_POST['studno'];
        }

        $boardid = $_POST['boardid'];
        $classid = $_POST['classname'];
        $secid = $_POST['sectionname_s'];
        $disamt = $_POST['discount_amt'];

        if (isset($_POST['studentid'])) {
            $studentid = $_POST['studentid'];
        } else {
            $studentid = 0;
        }

        $adate = str_replace('/', '-', $_POST['mat_date']);
        $receipt_date = date("Y-m-d", strtotime($adate));

        $exbilllist = mysql_query("SELECT * FROM inv_material_payment WHERE mat_parent_id=$parentid");
        $exbill = mysql_fetch_array($exbilllist);

        $oldamount = $exbill['payamount'];
        $oldptype = $exbill['p_type'];

        $p_qry = "UPDATE inv_material_parent SET mat_date='$receipt_date',paid_status='1',bill_no='$auto_bill',stud_staff='$stud_staff',adm_emp_no='$adm_emp_no',studid='$studentid',
	board_id='$boardid',class_id='$classid',section_id='$secid',discount='$disamt',overall_total='$over_total' where mat_parent_id='$parentid'";


        $result_parent = mysql_query($p_qry);

        if ($result_parent) {

            $sql_pay = "UPDATE inv_material_payment SET mat_pay_date='$receipt_date',payamount='$over_total',p_type='$ptype',"
                    . "pay_number='$pay_number',ba_id='$ba_id',bank='$bank_name',account='$account_no',c_date='$cheque_date' where mat_parent_id='$parentid'";

            $result_pay = mysql_query($sql_pay) or die("Could not update data into DB: " . mysql_error());
            if ($result_pay) {

                /*                 * ********************************Hand cash pay Update **************************************** */
                if ($ptype == 'cash') {
                    $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
                    $cash = mysql_fetch_array($cashlist);
                    $currentcash = $cash['amount'];
                    if ($oldptype == $ptype) {
                        $updatecash = ($currentcash - $oldamount ) + ($over_total);
                        $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
                    } else {
                        $updatecash = $currentcash + ($over_total);
                        $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
                    }
                } else if ($ptype == 'cheque') {
                    if ($oldptype == 'cash') {
                        $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
                        $cash = mysql_fetch_array($cashlist);
                        $currentcash = $cash['amount'];
                        $updatecash = $currentcash - $oldamount;
                        $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
                    }
                }
            }


            $result_mat_del = mysql_query("SELECT * from inv_material where mat_parent_id='$parentid' ") or die("Could not fetch inv_material data into DB: " . mysql_error());

            while ($row_mat_del = mysql_fetch_assoc($result_mat_del)) {

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
                    $brand_qty = ($brand_qty < 0) ? "0" : $brand_qty;
                    $sql_item_brand = mysql_query("UPDATE inv_brand_items SET qty='$brand_qty' where item_id=" . $row_mat_del['item_id'] . " and brand_id = " . $row_mat_del['brand_id']);
                }
            }
            if ($result2) {
                //delete material
                $qry_del_child = mysql_query("delete from inv_material where mat_parent_id='$parentid'") or die("Could not delete data from DB: " . mysql_error());
            }

            for ($i = 0; $i <= 30; $i++) {

                $itemnames = $_POST['itemname'];
                $brandnames = $_POST['brandname'];
                $qtys = $_POST['qty'];
                $uomnames = $_POST['uomname'];
                $oldqtys = $_POST['oldqty'];
                $sellprices = $_POST['selling_price'];
                $totalamts = $_POST['total_amt'];
                $uomname_news = $_POST['uomname_new'];

                $itemname = $itemnames[$i];
                $brandname = $brandnames[$i];
                $qty = $qtys[$i];
                $oldqty = $oldqtys[$i];
                $uomname = $uomnames[$i];
                //$buyprice = $buyprices[$i];
                $sellprice = $sellprices[$i];
                $totalamt = $totalamts[$i];
                $uomname_new = $uomname_news[$i];

                if ($totalamt == "" || $totalamt == 0) {
                    
                } else {
                    $sql = "INSERT INTO inv_material (mat_parent_id,item_id,brand_id,sell_price,qty,uom_id,total,uomname_new) VALUES
			('$parentid','$itemname','$brandname','$sellprice','$qty','$uomname','$totalamt','$uomname_new')";

                    $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());

                    if ($result) {

                        $result_select = mysql_query("select * from inv_items where item_id=$itemname");
                        $row_items_select = mysql_fetch_assoc($result_select);
                        //get original qty
                        //$orig_qty = $row_items_select['item_qty'] + $oldqty;
                        echo 'child I insert Loop' . $row_items_select['item_qty'] . ' - ' . $qty;
                        //set total qty
                        $tot_qty1 = $row_items_select['item_qty'] - $qty;
                        $tot_qty = ($tot_qty1 < 0) ? "0" : $tot_qty1;
                        //update total qty
                        if ($itemname != "" || $itemname != 0) {
                            echo $sql_item = "UPDATE inv_items SET item_qty='$tot_qty' where item_id=$itemname";
                            echo '<br>';
                            $result1 = mysql_query($sql_item) or die("Could not update data into DB: " . mysql_error());

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
            }


            //delete child tables and update qty in inv_items
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

            $result_two_delete = mysql_query("DELETE inv_material_combo_parent,inv_material_combo_child FROM inv_material_combo_parent 
	INNER JOIN inv_material_combo_child on (inv_material_combo_child.mat_com_id= inv_material_combo_parent.mat_com_id) 
	where inv_material_combo_parent.mat_parent_id = '$parentid'");


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

                                    echo 'Child II insert Loop' . $row_items_select['item_qty'] . ' - ' . $combo_item_listqty . '<br>';

                                    //set total qty
                                    $tot_qty5 = $row_items_select['item_qty'] - $combo_item_listqty;
                                    $tot_qty = ($tot_qty5 < 0) ? "0" : $tot_qty5;
                                    //update total qty
                                    echo $sql_item = "UPDATE inv_items SET item_qty='$tot_qty' where item_id=" . $combopackages_listid;
                                    echo '<br>';
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
            //exit;
        }

        if ($result_parent) {

            header("Location:inv_material_issue_edit.php?parentid=$parentid&catid=$catid&msg=succ");
        }
        //exit;
    } else {
        header("Location:inv_material_issue_edit.php?parentid=$parentid&msg=err");
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
                            <h3>Edit Material</h3>
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
                            if ($row_parent['paid_status']) {
                                $qry_pay = mysql_query("SELECT * FROM inv_material_payment where inv_material_payment.mat_parent_id=" . $row_parent['mat_parent_id']);
                                $row_pay = mysql_fetch_array($qry_pay);
                                $ptype = $row_pay["p_type"];
                            }
                            ?>

                            <form class="form uniformForm validateForm" method="post" action="" >

                                <div class="grid-8">	
                                    <div class="widget-content">
                                        <div class="field-group">

                                            <label for="required">Receipt No.<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="billno" id="billno" size="32" class="validate[required]" readonly value="<?php echo $row_parent['bill_no']; ?>" style="width:100%"/>	
                                                <input type="hidden" value="<?php echo $row_parent['bill_no']; ?>" name="bill_autono">

                                            </div>

                                        </div> 

                                        <div class="clear"></div>
                                        <div class="field-group">		
                                            <label>Student / Staff<span class="error"> * </span>:</label>			
                                            <div class="field">
                                                <select name="status" id="status" class="required select2" onChange="getNumber();">	
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
                                            <label for="required">Staff Employee No.<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="empno" id="empno" size="32" class="validate[required]" value="<?php //echo $row_parent['adm_emp_no'];          ?>"/>	
                                                <div id="suggesstion-box_staff"></div>
                                                <div id="class_sections_staff">
                                                    <input type='hidden' name='sectionname_s' id='sectionname_s' value='<?php echo $row_parent['section_id']; ?>'>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-group" id="stud_no" <?php echo $stud; ?>>
                                            <label for="required">Student Admin No.<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="studno" class="biginput validate[required]" id="studno_suggest" autocomplete="off" size="32" value="<?php //echo $row_parent['adm_emp_no'];          ?>" >
                                                <div id="suggesstion-box"></div>
                                                <div id="class_sections_stud">

                                                    <?php
                                                    $adminno_arr = explode(' ', $row_parent['adm_emp_no']);
                                                    $query_adm = "SELECT * FROM student WHERE admission_number = '" . $adminno_arr[0] . "' ";
                                                    $result_adm = mysql_query($query_adm);
                                                    $row_adm = mysql_fetch_assoc($result_adm)
                                                    ?>

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
                                            <label for="required">Receipt Date<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input id="datepicker" name="mat_date" class="required" type="text" value=" <?php echo date("d/m/Y", strtotime($row_parent['mat_date'])); ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="field-group">		
                                            <label>Class<span class="error"> * </span>:</label>			
                                            <div class="field">

                                                <select name="classname" id="classname" class="form-control required select2" onChange="getSectionDetails();">

                                                    <?php
                                                    $classl = "SELECT c_id,c_name FROM class class where b_id=$bid AND ay_id=$acyear";
                                                    //$row_parent['class_id'];
                                                    $result_class = mysql_query($classl) or die(mysql_error());

// if($row_parent['stud_staff']!='0'){
// echo '<option value="0" Selected>All</option>';
// }else{
                                                    echo '<option value="">Select Class Name</option>';
//	}
                                                    while ($row_class = mysql_fetch_assoc($result_class)):
                                                        $selec = ($row_class['c_id'] == $row_parent['class_id']) ? "Selected" : "";
                                                        echo "<option value='{$row_class['c_id']}' $selec >{$row_class['c_name']}</option>\n";
                                                    endwhile;
                                                    ?>
                                                </select>

                                            </div>				
                                        </div> <!-- .field-group -->
                                       
                                    </div>
                                </div>

                                <div class="grid-8">	
                                    <div class="widget-content">
                                        
                                         <!-- .field-group -->
                                        <div class="field-group" >		
                                            <label for="select">Board <span class="error"> * </span>:</label>
                                            <div class="field">
                                                <?php
                                                $classl = "SELECT * FROM board";
                                                $result1 = mysql_query($classl) or die(mysql_error());
                                                echo '<select name="boardid" id="bid"  class="required select2" onChange="getClassDetails();"><option value="">Select Board</option>';
                                                while ($row1 = mysql_fetch_assoc($result1)):
                                                    $sel = "";
                                                    if ($row1['b_id'] == $row_parent['board_id']) {
                                                        $sel = "Selected";
                                                    }

                                                    echo "<option value='{$row1['b_id']}' $sel>{$row1['b_name']}</option>\n";

                                                endwhile;
                                                echo '</select>';
                                                ?>

                                            </div>		
                                        </div>
                                         
                                          <div class="field-group">		
                                            <label>Section<span class="error"> * </span>:</label>			
                                            <div class="field">
                                                <select name="sectionname" id="sectionname" class="form-control required select2" onChange="setSectionName();">

                                                    <?php
                                                    $query_s = "SELECT * FROM section WHERE c_id = '" . $row_parent['class_id'] . "' ";
                                                    $result_s = mysql_query($query_s);
                                                    echo '<option value="0">All</option>';
                                                    while ($row_s = mysql_fetch_assoc($result_s)) {
                                                        $seles = ($row_s['s_id'] == $row_parent['section_id']) ? "Selected" : "";
                                                        echo"<option  value =" . $row_s['s_id'] . " $seles> " . $row_s['s_name'] . "</option>";
                                                    }
                                                    ?>
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

                                <?php if ($row_parent['cat_id'] != 0) { ?>
                                    <div class="grid-8">	
                                        <div class="widget-content">
                                            <div class="field-group">		

                                                <div class="field">

                                                    <?php
                                                    $catsql = "SELECT * from inv_category where cat_status=1 and cat_id=" . $row_parent['cat_id'];
                                                    $result_cat = mysql_query($catsql) or die(mysql_error());
                                                    $row_cat = mysql_fetch_assoc($result_cat);
//                                                    echo '<select name="category" id="categoryname" class="category_class select2" onChange="getCategory_Items();"> <option value="">Select Category </option>';
//                                                    while ($row_cat = mysql_fetch_assoc($result_cat)):
//                                                        echo "<option value='{$row_cat['cat_id']}'>{$row_cat['category_name']}</option>\n";
//                                                    endwhile;
//                                                    echo '</select>';
                                                    ?>
                                                    <label style="font-size:20px"><?php echo $row_cat['category_name']; ?> Category</label>
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
                                        <?php
                                        $materialchild_list = mysql_query("SELECT * FROM inv_material_parent right join inv_material on (inv_material.mat_parent_id = inv_material_parent.mat_parent_id) 
						left join inv_items on (inv_items.item_id = inv_material.item_id) WHERE inv_material_parent.mat_parent_id=$parentid");
                                        $j = 0;
                                        while ($mat_child = mysql_fetch_array($materialchild_list)) {
                                            ?>
                                            <tr id="row_item_<?= $j; ?>" >
                                                <td><div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            if ($row_parent['cat_id'] != 0) {
                                                                $itemsql = "SELECT inv_items.item_id,item_name FROM inv_items inner join inv_purchase on (inv_purchase.item_id =inv_items.item_id)
                                                                    where item_status=1 and active=1 and cat_id=" . $row_parent['cat_id'] . " group by inv_items.item_id";
                                                            } else {
                                                                $itemsql = "SELECT inv_items.item_id,item_name FROM inv_items inner join inv_purchase on (inv_purchase.item_id =inv_items.item_id)
                                                                    where item_status=1 and active=1 group by inv_items.item_id";
                                                            }
                                                            $result = mysql_query($itemsql) or die(mysql_error());
                                                            echo '<select name="itemname[]" id="itemname' . $j . '" onChange="getBrand(' . $j . ');" class="itemname_class select2"> <option value="">Select Item </option>';
                                                            while ($row = mysql_fetch_assoc($result)):
                                                                $sele = ($row['item_id'] == $mat_child['item_id']) ? "Selected" : "";
                                                                echo "<option value='{$row['item_id']}' $sele>{$row['item_name']}</option>\n";
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
                                                            echo '<select name="brandname[]" id="brandname' . $j . '" class="select2" onChange="getItemPrice(' . $j . ');" > <option value="0" selected> N/A </option>';
                                                            while ($row = mysql_fetch_assoc($result)):
                                                                $sele_b = ($row['brand_id'] == $mat_child['brand_id']) ? "Selected" : "";
                                                                echo "<option value='{$row['brand_id']}' $sele_b>{$row['brand_name']}</option>\n";
                                                            endwhile;
                                                            echo '</select>';
                                                            ?>      																				
                                                        </div>		
                                                    </div> <!-- .field-group -->
                                                </td>

                                                <td>
                                                    <div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="qty[]" id="qty<?= $j; ?>" size="15" class="qty_class text_field" value="<?= $mat_child['qty']; ?>" 
                                                                   onkeypress="return isDecimal(event, this);" onkeyup="checkQty(<?= $j; ?>);"/>	
                                                            <input type="hidden" name="oldqty[]" id="oldqty<?= $j; ?>"  value="<?= $mat_child['qty']; ?>" />
                                                            <span class="error" id="qty_error<?= $j; ?>">  </span>	
                                                        </div>
                                                    </div> 
                                                </td>
                                                <td>

                                                    <div class="field-group" id="uom_group<?php echo $j; ?>">
                                                        <?php
                                                        //if( strpos($mat_child['uomname_new'], ',0') !== false ){
                                                        if ($mat_child['uomname_new'] != "") {
                                                            $purchase = "SELECT * FROM inv_purchase left join inv_uom on (inv_uom.uom_id = inv_purchase.uom_id) 
	left join inv_purchase_mode on (inv_purchase_mode.pur_id=inv_purchase.pur_id) where inv_purchase.item_id= " . $mat_child['item_id'] . "
	order by inv_purchase.created desc limit 1";

                                                            $result_purchase = mysql_query($purchase) or die(mysql_error());
                                                            $row_purchase = mysql_fetch_assoc($result_purchase);

//	echo json_encode($row);

                                                            if ($row_purchase['uom_mode'] == 0) {
                                                                //echo 'Fixed';
                                                                echo '<label id="uom' . $j . '" > ' . $row_purchase['uom_name'] . ' </label>
              <input type="hidden" name="uomname[]" id="uom_name' . $j . '" value="' . $row_purchase['uom_id'] . '" />
			  <input type="hidden" name="uomname_new[]" id="uom_name' . $j . '" value="" />
			  ';
                                                            } else {
                                                                if (strpos($mat_child['uomname_new'], ',0') !== false) {
                                                                    $sel_uom_new = "Selected";
                                                                    $sel_uo = '';
                                                                } else {
                                                                    $sel_uo = "Selected";
                                                                    $sel_uom_new = '';
                                                                }

                                                                echo '
		<input type="hidden" name="uomname[]" id="uom_name' . $j . '" value="' . $row_purchase['uom_id'] . '" />
		<select name="uomname_new[]" id="uomname_new' . $j . '" class="uommode_change" onchange="getSubSellingPrice(' . $j . ')">
		<option value="' . $row_purchase['uom_id'] . '" $sel_uo>' . $row_purchase['uom_name'] . '</option>
		<option value="' . $row_purchase['uom_id'] . ',0" $sel_uom_new>' . $row_purchase['uomname_sub'] . '</option>
		</select>';
                                                            }
                                                        } else {

                                                            $uomsql = "SELECT uom_id,uom_name FROM inv_uom where uom_id=" . $mat_child['uom_id'];
                                                            $result_uom = mysql_query($uomsql) or die(mysql_error());
                                                            $row_uom = mysql_fetch_assoc($result_uom);
                                                            ?>
                                                            <label id="uom<?php echo $j; ?>" > <?php echo $row_uom['uom_name']; ?></label>
                                                            <input type="hidden" name="uomname[]" id="uom_name<?= $j; ?>" value="<?php echo $row_uom['uom_id']; ?>"/>
                                                        <?php } ?>
                                                    </div>

                                                </td>
                                                <td><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="selling_price[]" id="selling_price<?= $j; ?>" class="text_field" size="15" readonly value="<?= $mat_child['sell_price']; ?>" onkeypress="return isDecimal(event, this);" />	
                                                        </div>
                                                    </div></td>
                                                <td><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="total_amt[]" id="total_amt<?= $j; ?>"  class="single_total text_field" value="<?= $mat_child['total']; ?>" size="15" readonly />	
                                                        </div>
                                                    </div></td>
                                                <td> 
                                                    <?php
                                                    if ($j != 0) {
                                                        echo '<img onclick="hide_table_tr(' . $j . ')" src="../img/icons/packs/fugue/16x16/minus-button.png">';
                                                    }
                                                    if ($j == 0) {
                                                        echo '<a id="addvalue' . $j . '" onclick="add_table_tr(' . $j . '+1)" style="cursor:pointer"> <img src="../img/icons/packs/fugue/16x16/plus-button.png" title="Add New"/></a></td>';
                                                    }
                                                    ?>

                                                </td>
                                            </tr>

                                            <?php
                                            $j++;
                                        }
                                        for ($i = $j; $i <= 30; $i++) {
                                            ?>

                                            <tr id="row_item_<?= $i; ?>" <?php
                                        if ($i != 0) {
                                            echo 'style="display: none;"';
                                        }
                                            ?>>
                                                <td><div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            $itemsql = "SELECT inv_items.item_id,item_name FROM inv_items inner join inv_purchase on (inv_purchase.item_id =inv_items.item_id)
                                                                    where item_status=1 and active=1 group by inv_items.item_id";
                                                            $result = mysql_query($itemsql) or die(mysql_error());
                                                            echo '<select name="itemname[]" id="itemname' . $i . '" onChange="getBrand(' . $i . ');" class="itemname_class select2"> <option value="0">Select Item </option>';
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
                                                            <input type="text" name="qty[]" id="qty<?= $i; ?>" class="qty_class" size="15" value="0"  
                                                                   onkeypress="return isNumber(event);" onkeyup="checkQty(<?= $i; ?>);"/>	
                                                            <input type="hidden" name="oldqty[]" id="oldqty<?= $i; ?>"  value="0" />
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
                                                            <input type="text" name="selling_price[]" id="selling_price<?= $i; ?>" size="15"  readonly />	
                                                        </div>
                                                    </div></td>
                                                <td><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="total_amt[]" id="total_amt<?= $i; ?>"  class="single_total" size="15" readonly value="0"/>	
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


                                        <!-- Start edit Combo package -->
                                        <tr>
                                            <td colspan="7" ><center><div style="float:left; font-size:14px; font-weight:bold;">Combo Package :</div></center></td>
                                    </tr>
                                    <?php
                                    $k = 0;
                                    $qry_combomat = "SELECT * FROM inv_material_combo_parent WHERE 
							inv_material_combo_parent.mat_parent_id=$parentid";
                                    $result_combo_material = mysql_query($qry_combomat);

                                    while ($row_combo_material = mysql_fetch_assoc($result_combo_material)) {
                                        ?>
                                        <tr id="combo_item_<?= $k; ?>">
                                            <td colspan="5">

                                                <div class="field-group">		

                                                    <div class="field">

                                                        <select name="combopackage[]" id="combopackage<?php echo $k ?>" class="comboclass select2" 
                                                                onChange="getComboPrice(<?php echo $k ?>);">
                                                                    <?php
                                                                    $itemsql = "SELECT com_parent_id,package_name FROM inv_combo_parent where class_id=" . $row_parent['class_id'] . " OR class_id='0' ";

                                                                    $result = mysql_query($itemsql) or die(mysql_error());
                                                                    $com_p_id = 0;
                                                                    echo '<option value="0">Select Combo </option>';
                                                                    while ($row = mysql_fetch_assoc($result)):
                                                                        if ($row['com_parent_id'] == $row_combo_material['com_parent_id']) {
                                                                            $sele_com = "Selected";
                                                                            $com_p_id = $row_combo_material['com_parent_id'];
                                                                        } else {
                                                                            $sele_com = "";
                                                                            //$com_p_id = 0;	
                                                                        }
                                                                        echo "<option value='{$row['com_parent_id']}' $sele_com>{$row['package_name']}</option>\n";
                                                                    endwhile;
                                                                    ?> 
                                                        </select>     																				
                                                    </div>		
                                                </div>

                                                <div id="combopackage_items<?php echo $k ?>" class="combopackage_items_div">
                                                    <?php
                                                    $comboparent = "SELECT *,inv_combo.brand_id as com_brandid FROM inv_combo_parent left join inv_combo on(inv_combo.com_parent_id = inv_combo_parent.com_parent_id) 
			left join inv_items on (item_id = package_items) left join inv_uom on (inv_uom.uom_id = inv_combo.uom_id)
			left join inv_brand on (inv_brand.brand_id=inv_combo.brand_id) where inv_combo_parent.com_parent_id = " . $com_p_id . " and inv_items.active=1 and inv_items.item_status=1";

                                                    $result_combo = mysql_query($comboparent) or die(mysql_error());

                                                    $item_price = array();
                                                    $ik = 0;

                                                    while ($row_combo = mysql_fetch_assoc($result_combo)) {


                                                        //echo $purchasechild = "SELECT * FROM inv_purchase where inv_purchase.item_id = " . $row_combo['package_items'] . " and uom_id=" . $row_combo['uom_id'] . " order by created desc";

                                                        $purchasechild = "SELECT * FROM inv_purchase left join inv_purchase_mode on 
					(inv_purchase_mode.pur_id=inv_purchase.pur_id) 
                                        left join inv_brand on (inv_brand.brand_id=inv_purchase.brand_id) where inv_purchase.item_id = " . $row_combo['package_items'] . " "
                                                                . "and inv_purchase.brand_id = " . $row_combo['com_brandid'] . " order by inv_purchase.created desc";

                                                        $result_purchase = mysql_query($purchasechild) or die(mysql_error());

                                                        $row_purchase = mysql_fetch_assoc($result_purchase);

                                                        if ($row_purchase['uomname_sub'] != "") {
                                                            $uomname_last = $row_purchase['uomname_sub'];
                                                            $sellprice = $row_purchase['selling_price_sub'];
                                                            $total_price = $row_purchase['selling_price_sub'] * $row_combo['qty'];
                                                        } else {
                                                            $uomname_last = $row_combo['uom_name'];
                                                            $sellprice = $row_purchase['sell_price'];
                                                            $total_price = $row_purchase['sell_price'] * $row_combo['qty'];
                                                        }



                                                        echo '<div class="field-group div_check grid-8">		
								<div class="field">';
                                                        $result_combo_material_child = mysql_query("SELECT * from inv_material_combo_parent 
	left join inv_material_combo_child on (inv_material_combo_child.mat_com_id = inv_material_combo_parent.mat_com_id)
        where mat_parent_id=$parentid 
	AND item_id =" . $row_combo['package_items']);

                                                        $row_combo_material_child = mysql_fetch_assoc($result_combo_material_child);

                                                        if ($row_combo['package_items'] == $row_combo_material_child['item_id']) {

                                                            $checked = "checked";
                                                            $st = 1;
                                                            $comboqty = $row_combo_material_child['qty'];
                                                            $total_price = $row_combo_material_child['qty'] * $row_combo_material_child['sell_price'];
                                                            array_push($item_price, $total_price);
                                                        } else {
                                                            $checked = "";
                                                            $st = 0;
                                                            $comboqty = $row_combo['qty'];
                                                        }

                                                        echo '<input name="combo_item_list[]" type="checkbox" ' . $checked . ' id="combo_item_list' . $k . '_' . $ik . '" onchange="changeCheckedItem(' . $k . ',' . $ik . ');">
								' . $row_combo['item_name'] . '
								<input name="combo_item_listst[]" type="hidden" value="' . $st . '" id="combo_item_listst' . $k . '_' . $ik . '">
								<input name="combo_item_listid[]" type="hidden" value="' . $row_combo['package_items'] . '" id="combo_item_listid' . $k . '_' . $ik . '">';



                                                        echo '</div></div> 
					<div class="field-group div_check grid-4">		
								<label>' . $row_combo['brand_name'] . '</label>
								<input name="combo_item_listbrand[]" type="hidden" value="' . $row_combo['brand_id'] . '" id="combo_item_listbrand' . $k . '_' . $ik . '">
					</div>
					<div class="field-group div_check grid-4">		
								<label></label>
								<input name="combo_item_listqty[]" type="text" value="' . $comboqty . '" 
								id="combo_item_listqty' . $k . '_' . $ik . '" class="comboqty_class" style="width:100%;" onkeyup="getSell_byQty(' . $k . ',' . $ik . ');">
								<span class="error" id="comboqty_error' . $k . '_' . $ik . '">  </span>
                                                                    <input name="combo_item_listsell[]" type="hidden" class="comb_sell" value="' . $sellprice . '" id="combo_item_listsell' . $k . '_' . $ik . '">
					</div>
					
					<div class="field-group div_check grid-4">		
								<label style="text-align:center;">' . $uomname_last . '</label>
								<input name="combo_item_listuom[]" type="hidden" value="' . $row_combo['uom_id'] . '" id="combo_item_listuom' . $k . '_' . $ik . '">
					</div>
					<div class="field-group div_check grid-4">		
								<label id="combo_item_listtotal_label' . $k . '_' . $ik . '" >' . $total_price . '</label>
								<input name="combo_item_listtotal[]" type="hidden" value="' . $total_price . '" class="comb_total_sell" id="combo_item_listtotal' . $k . '_' . $ik . '">
					</div>
					<div class="clear"></div>
					';
                                                        $ik++;
                                                    }
                                                    ?>
                                                </div>

                                            </td>

                                            <td >
                                                <div class="field">
                                                    <input type="text" name="total_combo_amt[]" id="total_combo_amt<?= $k; ?>" 
                                                           value="<?php echo array_sum($item_price); //$row_combo_material['total_amt']  ?>" class="single_total combo_total" size="15" readonly />	
                                                </div>
                                            </td>
                                            <td> 
                                                <?php
                                                if ($k != 0) {
                                                    echo '<img onclick="hide_combo_table_tr(' . $k . ')" src="../img/icons/packs/fugue/16x16/minus-button.png">';
                                                }
                                                if ($k == 0) {
                                                    echo '<a id="addvalue_combo' . $k . '" onclick="add_combo_table_tr(' . $k . '+1)" style="cursor:pointer"> <img src="../img/icons/packs/fugue/16x16/plus-button.png" title="Add New"/></a></td>';
                                                }
                                                ?>


                                            </td>
                                        </tr>

                                        <!-- End edit Combo package --> 

                                        <?php
                                        $k++;
                                    }
                                    for ($c = $k; $c <= 30; $c++) {
                                        ?>
                                        <!-- Start Combo package -->
                                        <tr id="combo_item_<?= $c; ?>" <?php
                                    if ($c != 0) {
                                        echo 'style="display: none;"';
                                    }
                                        ?>>
                                            <td  colspan="5">
                                                <div class="field-group">		

                                                    <div class="field">


                                                        <select name="combopackage[]" id="combopackage<?php echo $c ?>" class="comboclass select2" onChange="getComboPrice(<?php echo $c ?>);">
                                                            <?php
                                                            $itemsql = "SELECT com_parent_id,package_name FROM inv_combo_parent where class_id=" . $row_parent['class_id'] . " OR class_id='0' ";
                                                            $result = mysql_query($itemsql) or die(mysql_error());
                                                            echo '<option value="0">Select Combo </option>';
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
                                                    <input type="text" name="total_combo_amt[]" id="total_combo_amt<?= $c; ?>"  class="single_total combo_total text_field" size="15" readonly value="0"/>	
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


                                    <tr>
                                        <td colspan="5" class="amount_td"><div style="float:right; font-size:14px; font-weight:bold;">Discount Amount:</div></td>
                                        <td class="amount_td">
                                            <div class="field">
                                                <input type="text" name="discount_amt" size="15" class="text_field" id="discount" value="<?php echo $row_parent['discount']; ?>" onkeypress="return isDecimal(event, this);" onkeyup="calc_total();"> 

                                            </div>
                                        </td>
                                        <td class="amount_td"></td>
                                    </tr>

                                    <tr>
                                        <td colspan="5" class="amount_td"><div id="overall_amount" style="float:right; font-size:14px; font-weight:bold;">Total Amount: </div></td>
                                        <td class="amount_td">
                                            <div class="field">
                                                <input type="text" name="overall_totamount" class="text_field" readonly size="15" value="<?php echo $row_parent['overall_total']; ?>"  id="overall_totamount">

                                            </div>

                                        </td>
                                        <td class="amount_td"></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="grid-8">	
                                    <div class="widget-content">
                                        <div class="field-group payment_type">		
                                            <label for="textfield">Payment Type:</label>			
                                            <div class="field">
                                                <select name="ptype" id="ptype" class="required select2" onchange="payment_type()">
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
                                    </div>		
                                </div>

                                <div class="clear"></div>
                                <div id="ajax_pay">
                                </div>
                                <div id="cash_pay">
                                </div>
                                <div class="clear"></div>
                                <input type="hidden" name="parent_id" id="parent_id" value="<?php echo $parentid; ?>" > 

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
            var c_id = $("#classname option:selected").val();
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
                $("#studno_suggest").val('<?php echo $row_parent['adm_emp_no']; ?>');
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