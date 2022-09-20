<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php");
//echo $_SESSION['uname'];

if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $date_split1 = explode('/', $date);

    $date_month = $date_split1[1];
    $date_day = $date_split1[0];
    $date_year = $date_split1[2];
    $excid = $_POST['excid'];
    $exid = $_POST['exid'];
    $type = $_POST['type'];
    $b_no = $_POST['b_no'];
    $aid = $_POST['aid'];

    if ($type == "0") {
        //cash payamount
        $title = $_POST['title'];
        $des = $_POST['des'];
        $r_no = $_POST['r_no'];
        $amount = $_POST['amount'];

        $ptype = $_POST['ptype'];
        $pay_number = $_POST['pay_number'];

        $bank_name = $_POST['bank_name'];
        $account_no = $_POST['account_no'];

        $cheque_date = $_POST['cheque_date'];
        $receiver = $_POST['receiver'];
        $oldamount = $_POST['oldamount'];

        $adv_status = $_POST['use_advance'];
        $adv_amount = $_POST['pay_from_advance'];
        $balance_advance = $_POST['balance_advance'];

        $sql = mysql_query("UPDATE exponses SET r_no='$r_no',b_no='$b_no',date_day='$date_day',date_month='$date_month',date_year='$date_year',"
                . "title='$title',des='$des',amount='$amount',ay_id='$acyear',aid='$aid',p_type='$ptype',pay_number='$pay_number',bank='$bank_name',"
                . "account='$account_no',c_date='$cheque_date',receiver='$receiver',advance_status='$adv_status',advance_amt='$adv_amount' WHERE ex_id='$exid'") or die("Could not insert data into DB: " . mysql_error());

        if ($sql) {

            $sql_adv = "UPDATE advance_payment SET a_id='$aid',bal_advance='$adv_amount' WHERE ex_id='$exid'";
            $result_adv = mysql_query($sql_adv);

            $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
            $cash = mysql_fetch_array($cashlist);
            $currentcash = $cash['amount'];
            $updatecash = ($currentcash + $oldamount) - $amount;
            $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
            header("Location:exponse_mng_edit.php?excid=$excid&exid=$exid&msg=succ");
        }
        exit;
    } else if ($type == "1") {
        //proposal
        $title = $_POST['title'];
        $t_type = $_POST['otype'];
        $t_parcent = $_POST['tax'];
        $t_amount = $_POST['ttax'];
        $receiver = $_POST['receiver'];
        $shipping = $_POST['shipping'];
        $discount = $_POST['discount'];
        
        $tds_per = $_POST['tds_per'];
        $tds_amount = $_POST['tds_amt'];
        
        if (!$t_type) {
            $t_parcent = "";
            $t_amount = "";
        }
        $total_amount = addslashes(trim($_POST['overall_totamount']));

        $sql = mysql_query("UPDATE exponses SET date_day='$date_day',date_month='$date_month',date_year='$date_year',title='$title',b_no='$b_no',amount='$total_amount',ay_id='$acyear',t_type='$t_type',t_parcent='$t_parcent',t_amount='$t_amount',tds_per='$tds_per',tds_amt='$tds_amount',shipping='$shipping',discount='$discount',aid='$aid',receiver='$receiver' WHERE ex_id='$exid'") or die("Could not insert data into DB: " . mysql_error());
        if ($sql) {
            $qry = mysql_query("delete from expense_po_amount where ex_id='$exid'");
            for ($i = 0; $i <= 30; $i++) {

                $names = $_POST["name"];
                $poqtys = $_POST["poqty"];
                $qtys = $_POST["qty"];
                $amounts = $_POST["amount"];
                $total = $_POST["total"];

                $totals = $total[$i];
                $name = $names[$i];
                $poqty = $poqtys[$i];
                $qty = $qtys[$i];
                $amount = $amounts[$i];

                if ($totals == "" || $totals == 0) {
                    
                } else {
                    $sql = mysql_query("INSERT INTO expense_po_amount (ex_id,name,poqty,qty,amount,total) values('$exid','$name','$poqty','$qty','$amount','$totals')") or die(mysql_error());
                }
            }
            header("Location:exponse_mng_edit.php?excid=$excid&exid=$exid&msg=succ");
        }
        exit;
    }
}
?>
</head>

<body id="top">

    <!-- Begin of #container -->
    <div id="container">
        <!-- Begin of #header -->
        <?php include("includes/header.php"); ?>
        <!--! end of #header -->

        <div class="fix-shadow-bottom-height"></div>

        <!-- Begin of Sidebar -->
        <aside id="sidebar">
            <!-- Search -->
            <?php include("includes/search.php"); ?>
            <!--! end of #search-bar -->

            <!-- Begin of #login-details -->
            <?php include("includes/login-details.php"); ?>
            <!--! end of #login-details -->

            <!-- Begin of Navigation -->
            <?php include("nav.php"); ?>
            <!--! end of #nav -->

        </aside> <!--! end of #sidebar -->

        <!-- Begin of #main -->
        <div id="main" role="main">
            <?php
            $excid = $_GET['excid'];
            if ($excid) {
                $classlist = mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid");
                $class = mysql_fetch_array($classlist);
            }
            $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
            $cash = mysql_fetch_array($cashlist);
            $currentcash = $cash['amount'];
            ?>
            <!-- Begin of titlebar/breadcrumbs -->
            <div id="title-bar">
                <ul id="breadcrumbs">
                    <li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                    <li class="no-hover"><a href="exponse_mng.php?excid=<?php echo $excid; ?>" title="month"><?php echo $class['ex_category']; ?> Expenses Details</a></li>
                    <li class="no-hover">Edit <?php echo $class['ex_category']; ?> Expenses Details</li>
                </ul>
            </div> <!--! end of #title-bar -->

            <div class="shadow-bottom shadow-titlebar"></div>

            <!-- Begin of #main-content -->
            <div id="main-content">
                <div class="container_12">

                    <div class="grid_12">
                        <h1>Edit <?php echo $class['ex_category']; ?> Expenses Details</h1>                
                        <a href="exponse_mng.php?excid=<?php echo $excid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                        <div style="float:right">
                            Current Hand Cash Total :<button class="btn btn-small btn-success"><?= $currentcash ?> Rs/-</button>
                        </div>
                    </div>
                    <div class="grid_12">
                        <?php
                        $msg = $_GET['msg'];
                        if ($msg == "succ") {
                            ?>			
                            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
                        <?php } ?>

                        <div class="block-border">
                            <div class="block-header">
                                <h1>Edit <?php echo $class['ex_category']; ?> Expenses Details</h1><span></span>
                            </div>
                            <?php
                            $exid = $_GET['exid'];
                            $classlist1 = mysql_query("SELECT * FROM exponses WHERE ex_id=$exid");
                            $row = mysql_fetch_array($classlist1);
                            $exsid = $row["exs_id"];
                            $excid = $row["exc_id"];
                            $tamount = $row["amount"];
                            $t_type = $row['t_type'];
                            $t_parcent = $row['t_parcent'];
                            $t_amount = $row['t_amount'];
                            $shipping = $row['shipping'];
                            $discount = $row['discount'];
                            $receiver = $row['receiver'];
                            $type = $row["type"];
                            
                            $tds_per = $row['tds_per'];
                            $tds_amt = $row['tds_amt'];

                            $class = mysql_fetch_array(mysql_query("SELECT * FROM ex_insubcategory WHERE exs_id=$exsid"));
                            $sub_name = $class["sub_name"];
                            $count = $class["count"];


                            $subcat = array();
                            for ($j = 1; $j <= 20; $j++) {
                                $sub_id = $class["sub$j" . "_id"];

                                if ($sub_id != 0) {
                                    array_push($subcat, $sub_id);
                                }
                            }

                            $insub_name = "";
                            foreach ($subcat as $val) {

                                $qry1 = mysql_fetch_array(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$val'"));
                                $insub_name.=$qry1["sub_name"] . "&nbsp;>&nbsp;";
                            }
                            $classl = mysql_query("SELECT * FROM ex_category where exc_id=$excid");
                            $row1 = mysql_fetch_assoc($classl);
                            ?>
                            <form id="validate-form" class="block-content form" action="" method="post">
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Date <span class="error">*</span></label>
                                        <input id="datepicker" name="date" class="required" type="text" value="<?php echo $row['date_day'] . "/" . $row['date_month'] . "/" . $row['date_year']; ?>" readonly />
                                    </p>
                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Expenses Category </label>
                                        <input id="textfield" name="excid" class="required" type="text" value="<?php echo $row1["ex_category"]; ?>" readonly />
                                    </p>
                                </div>
                                <div class="_50">
                                    <p>
                                        <label for="textfield">Sub & inner Category </label>
                                        <input id="textfield" name="exsid" class="required" type="text" value="<?= $insub_name . $sub_name ?>" readonly />
                                    </p>
                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Receipt No <span class="error">*</span></label>
                                        <input id="textfield" name="r_no" class="required" type="text" value="<?php echo $row['r_no']; ?>" readonly />
                                    </p>
                                </div>
                                <?php if ($type == 0) { ?>
                                    <div class="clear"></div>
                                    <div class="_50">
                                        <p>
                                            <label for="textfield">Title <span class="error">*</span></label>
                                            <input id="textfield" name="title" class="required" type="text" value="<?php echo $row['title']; ?>" />
                                        </p>
                                    </div>
                                    <div class="_25">
                                        <p>
                                            <label for="textfield">Agency</label>
                                            <?php
                                            $aid = $row['aid'];
                                            $classl = "SELECT * FROM agency WHERE status=0";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="aid" id="aid" onchange="getAdvanceAmount(this.value);">';
                                            echo "<option value=''>please select agency</option>\n";
                                            while ($row1 = mysql_fetch_assoc($result1)):
                                                if ($row1['a_id'] == $aid) {
                                                    echo "<option value='{$row1['a_id']}' selected>{$row1['a_name']}</option>\n";
                                                } else {
                                                    echo "<option value='{$row1['a_id']}'>{$row1['a_name']}</option>\n";
                                                }
                                            endwhile;
                                            echo '</select>';
                                            ?>	
                                        </p>
                                    </div>

                                    <div class="_25 adv_class" >
                                        <?php
                                        $a_qry = "SELECT sum(bal_advance) as advance FROM advance_payment where a_id=$aid order by adv_pay_id desc limit 1";

                                        $advancelist = mysql_query($a_qry);
                                        $advance = mysql_fetch_assoc($advancelist);

                                        $a_adv = "SELECT sum(adv_amt) as advance FROM agency_advance where a_id=$aid";

                                        $advlist = mysql_query($a_adv);
                                        $adv_total = mysql_fetch_assoc($advlist);

                                        $total_advance = $adv_total['advance'] - $advance['advance'];

                                        $total_advance_amt = $total_advance + $row['advance_amt'];
                                        ?>
                                        <p>
                                            <label for="textfield" > Advance Amount </label>
                                            <input id="adv_amt_id" name="adv_amt_" type="text" value="<?php echo $total_advance_amt; ?>" readonly />
                                    </div>

                                    <div class="_100">
                                        <p>
                                            <label for="textfield">Description <span class="error">*</span></label>
                                            <textarea id="textfield" name="des" class="required" rows="5"><?php echo $row['des']; ?></textarea>
                                        </p>
                                    </div>
                                    <div class="_25">
                                        <p>
                                            <label for="textfield">Bill No/Receipt No From outside</label>
                                            <input id="textfield" name="b_no" type="text" value="<?php echo $row['b_no']; ?>" />
                                        </p>
                                    </div>
                                    <div class="_50">
                                        <p>
                                            <label for="textfield">Amount <span class="error">*</span></label>
                                            <input id="textfield" name="amount" class="required" type="text" value="<?php echo $row['amount']; ?>" />
                                            <input name="oldamount" type="hidden" value="<?php echo $row['amount']; ?>" />
                                        </p>
                                    </div>
                                    <div class="_25 adv_class" <?php if ($total_advance_amt == 0) { ?>style="display:none;" <?php } ?> >
                                        <p>
                                            <label for="textfield"><br></label>
                                        </p>

                                        <input name="use_advance" id="use_advance" type="checkbox" value="<?php echo $row['advance_status']; ?>" <?php if ($row['advance_status'] == 1) echo 'checked'; ?> style="width:20%" onchange="showBalanceAdvance();">Use Advance Amount

                                    </div>
                                    <div class="clear"></div>
                                    <div class="_25 bal_adv_class" style="display:none;" >
                                        <p>
                                            <label for="textfield" > Amount From Advance </label>
                                            <input id="pay_from_advance" name="pay_from_advance" type="text" value="<?php echo $row['advance_amt']; ?>" onkeyup="showBalanceAdvance();" />
                                        </p>    
                                    </div>

                                    <div class="_25 bal_adv_class" style="display:none;" >
                                        <p>
                                            <label for="textfield" > Balance Advance Amount </label>
                                            <input id="bal_adv_amt_id" name="balance_advance" type="text" value="" readonly />
                                        </p>    
                                    </div>
                                    <div class="_25">
                                        <p>
                                            <label for="textfield">Payment Type:</label>
                                            <select name="ptype" id="ptype" class="required" onchange="paymet_type1()">
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
                                                ?>>cheque</option>								
                                            </select>	
                                        </p>									
                                    </div>
                                    <div class="clear"></div>
                                    <div class="_75" style="float:left; width:25%;">
                                        <p>
                                            <label for="textfield" style="padding-bottom:5px;"> Receiver:</label>
                                            <input type="text"  name="receiver" value="<?php echo $row['receiver']; ?>"/>
                                        </p>
                                    </div>						


                                    <div class="_75" style="float:left; width:25%;">
                                        <p>
                                            <label for="textfield" style="padding-bottom:5px;">  Bill Generated By:</label>
                                            <input type="text" name="billgenerate" value="<?php echo $row['billgenerate']; ?>" readonly/>
                                        </p></div>

                                    <div id="ajax_pay1">
                                    </div>
                                    <div id="cash_pay1">
                                    </div>
                                    <?php
                                } else if ($type == 1) {
                                    $qid = $row["q_id"];
                                    $emp_result = mysql_query("select po_no from quotation where q_id='$qid'");
                                    $emp_display = mysql_fetch_array($emp_result);
                                    ?>
                                    <div class="_25">
                                        <p>
                                            <label for="select">Po No: </label>
                                            <input id="textfield" name="pono" class="required" type="text" value="<?php
                                            if ($qid) {
                                                echo $emp_display['po_no'];
                                            } else {
                                                echo "New Proposal ";
                                            }
                                            ?>" readonly/>
                                        </p>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="_25">
                                        <p>
                                            <label for="textfield">Title <span class="error">*</span></label>
                                            <input id="title" name="title" class="required" type="text" value="<?php echo $row['title']; ?>" />
                                        </p>
                                    </div>
                                    <div class="_25">
                                        <p>
                                            <label for="textfield">Bill No/Receipt No <span class="error">*</span></label>
                                            <input id="b_no" name="b_no" class="required" type="text" value="<?php echo $row['b_no']; ?>" />
                                        </p>
                                    </div>
                                    <div class="_25">
                                        <p>
                                            <label for="textfield">Agency <span class="error">*</span></label>
                                            <?php
                                            $aid = $row['aid'];
                                            $classl = "SELECT * FROM agency WHERE status=0";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="aid" id="aid" class="required">';
                                            echo "<option value=''>please select agency</option>\n";
                                            while ($row1 = mysql_fetch_assoc($result1)):
                                                if ($row1['a_id'] == $aid) {
                                                    echo "<option value='{$row1['a_id']}' selected>{$row1['a_name']}</option>\n";
                                                } else {
                                                    echo "<option value='{$row1['a_id']}'>{$row1['a_name']}</option>\n";
                                                }
                                            endwhile;
                                            echo '</select>';
                                            ?>	
                                        </p>
                                    </div>	
                                    <table class="table">
                                        <thead>					        
                                            <tr>
                                                <th>Name /Description</th>
                                                <?php if ($qid) { ?>
                                                    <th width="10%">Po Qty</th>
                                                <?php } ?>
                                                <th width="10%">Qty</th>
                                                <th width="20%">Amount</th>
                                                <th width="20%">Total</th>
                                                <th width="5%"></th>
                                            </tr>                              
                                        </thead>					        
                                        <tbody class="dfdf">
                                            <?php
                                            $query = "select * from  expense_po_amount where ex_id='$exid' order by ep_id asc";
                                            $res = mysql_query($query);
                                            $i = 0;
                                            while ($row = mysql_fetch_array($res)) {
                                                $name = stripslashes($row["name"]);
                                                $poqty = $row["poqty"];
                                                $qty = $row["qty"];
                                                $amount = $row["amount"];
                                                $total = $row["total"];
                                                ?>
                                                <tr id="hide_tr<?= $i ?>" >
                                                    <td> <input type="text" name="name[]" value="<?= $name ?>" /></td>
                                                    <?php if ($qid) { ?>
                                                        <td> <input type="text" data-required="true" id="poqty<?= $i ?>" value="<?= $poqty ?>"   name="poqty[]" data-type="digits" class="required"> </td>
                                                    <?php } ?>
                                                    <td> <input type="text" data-required="true" id="qty<?= $i ?>" value="<?= $qty ?>"   name="qty[]" onkeyup="calc(<?= $i ?>)" data-type="digits" class="required"> </td>
                                                    <td>  <input type="text"  data-required="true" data-type="digits"  value="<?= $amount ?>"   id="amount<?= $i ?>" onkeyup="calc(<?= $i ?>)" name="amount[]"  class="required"></td>
                                                    <td>  <input type="text"  id="total<?= $i ?>"    name="total[]"  value="<?= $total ?>" readonly></td>
                                                    <td> <?php if ($i != 0) { ?>
                                                            <img onclick="hide_table_tr(<?= $i ?>)" src="img/icons/packs/fugue/16x16/minus-button.png"> 
                                                        <?php } ?>
                                                        <?php if ($i == 0) { ?>
                                                            <a id="addvalue<?= $i ?>" onclick="add_table_tr(<?php echo mysql_num_rows($res); ?>)"> <img src="img/icons/packs/fugue/16x16/plus-button.png" title="Add New"/></a></td><?php } ?>

                                                </tr>
                                                <?php
                                                $i = $i + 1;
                                            }
                                            for ($j = $i; $j <= 30; $j++) {
                                                ?>
                                                <tr id="hide_tr<?= $j ?>" <?php if ($j != 0) { ?>style="display: none;"<?php } ?>>
                                                    <td>  <input type="text" name="name[]" value="" /></td>
                                                    <td> <input type="text" data-required="true" id="poqty<?= $j; ?>" value="0"   name="poqty[]" data-type="digits" class="required"> </td>
                                                    <td> <input type="text" data-required="true" id="qty<?= $j ?>"  disabled  name="qty[]" onkeyup="calc(<?= $j ?>)" data-type="digits" class="required"> </td>
                                                    <td>  <input type="text"  data-required="true" data-type="digits"   disabled   id="amount<?= $j ?>" onkeyup="calc(<?= $j ?>)" name="amount[]"  class="required"></td>
                                                    <td>  <input type="text"  id="total<?= $j ?>"    name="total[]" readonly></td>
                                                    <td>  
                                                        <img onclick="hide_table_tr(<?= $j ?>)" src="img/icons/packs/fugue/16x16/minus-button.png"> 
                                                </tr>
                                            <?php }
                                            ?>
                                            <tr>
                                                <td colspan="<?php
                                                if ($qid) {
                                                    echo "3";
                                                } else {
                                                    echo "2";
                                                }
                                                ?>"> </td>
                                                <td><div id="tax1" style="float:right; font-size:14px; font-weight:bold;">
                                                        <select id="otype" name="otype" style="width:60%" onchange="t_type()">
                                                            <option value="">Select VAT/TAX</option>
                                                            <option value="VAT" <?php
                                                            if ($t_type == "VAT") {
                                                                echo "selected";
                                                            }
                                                            ?>>VAT</option>
                                                            <option value="TAX" <?php
                                                            if ($t_type == "TAX") {
                                                                echo "selected";
                                                            }
                                                            ?>>TAX</option>
                                                        </select> : <span id="ttypeid" <?php
                                                        if (!$t_type) {
                                                            echo 'style="display:none"';
                                                        }
                                                        ?>><input type="text" name="tax" value="<?= $t_parcent ?>" style="border: none; width:20%;font-size:14px; font-weight:bold;" id="tax">%</span></div></td>
                                                <td><div id="ttypeid1" <?php
                                                    if (!$t_type) {
                                                        echo 'style="display:none"';
                                                    }
                                                    ?>><input type="text" id="ttax" name="ttax" onkeyup="tax_total(this.value)" value="<?= $t_amount; ?>"></div></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"> </td>
                                                <td><div id="tdsper" style="float:right; font-size:14px; font-weight:bold;">TDS : <input type="text" id="tds_per" name="tds_per" value="<?= $tds_per; ?>" style="width:20%"> % </div></td>
                                                <td><div id="tdsamt"><input type="text" id="tds_amt" name="tds_amt" onkeyup="tax_total()" value="<?= $tds_amt; ?>"></div></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"> </td>
                                                <td><div id="tax1" style="float:right; font-size:14px; font-weight:bold;">Shipping Charges</div></td>
                                                <td><div id="shipping1"><input type="text" id="shipping" name="shipping" value="<?php echo $shipping; ?>" onkeyup="shipping_total(this.value)"></div></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"> </td>
                                                <td><div id="tax1" style="float:right; font-size:14px; font-weight:bold;">Discount</div></td>
                                                <td><div id="discount1"><input type="text" id="discount" name="discount" value="<?php echo $discount; ?>" onkeyup="discount_total(this.value)"></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="id" value="<?= $qid ?>">
                                    <div id="overall_amount" style="float:right; font-size:14px; font-weight:bold;">Total Amount: <input type="text" name="overall_totamount" value="<?php echo $tamount; ?>"  readonly style="border: none; width:20%;font-size:14px; font-weight:bold;" id="overall_totamount"> </div>
                                <?php } ?>
                                <div class="clear"></div>
                                <div class="block-actions">
                                    <ul class="actions-left">
                                        <li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
                                    </ul>
                                    <ul class="actions-left">
                                        <input type="hidden" class="medium" name="excid" value="<?php echo $_GET['excid']; ?>">
                                        <input type="hidden" class="medium" name="type" value="<?php echo $type; ?>">
                                        <input type="hidden" class="medium" name="exid" value="<?php echo $_GET['exid']; ?>">
                                        <li><input type="submit" name="submit" class="button" value="Submit"></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="clear height-fix"></div>

                </div></div> <!--! end of #main-content -->
        </div> <!--! end of #main -->


        <?php include("includes/footer.php"); ?>
    </div> <!--! end of #container -->

    <!-- JavaScript at the bottom for fast page loading -->

    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script src="js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


    <!-- scripts concatenated and minified via ant build script-->
    <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
    <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
    <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
    <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
    <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
    <script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
    <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
    <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
    <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
    <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
    <script defer src="js/common.js"></script> <!-- Generic functions -->
    <script defer src="js/script.js"></script> <!-- Generic scripts -->
    <script defer src="js/zebra_datepicker.js"></script>
    <!-- end scripts-->
    <script type="text/javascript">
                                                $().ready(function() {

                                                    var validateform = $("#validate-form").validate();
                                                    $("#reset-validate-form").click(function() {
                                                        validateform.resetForm();
                                                        $.jGrowl("Form was Reset.", {theme: 'error'});
                                                    });
                                                    $("#datepicker").Zebra_DatePicker({
                                                        format: 'd/m/Y'
                                                    });

                                                    showBalanceAdvance();
                                                });

                                                //start get agency advance amount
                                                function getAdvanceAmount(agency_id) {

                                                    $.get("get_advance_amount.php", {a_id: agency_id}, function(data) {
                                                        //$("#ajax_pay1").html(data);
                                                        //console.log(data);
                                                        if (data == '')
                                                            data = 0;

                                                        if (data != 0) {
                                                            $('.adv_class').show();
                                                            $('#adv_amt_id').val(data);

                                                        }
                                                        else {
                                                            $('.adv_class').hide();
                                                            $('#adv_amt_id').val(0);
                                                            $('#use_advance').removeAttr('checked');
                                                            $('#use_advance').val(0);
                                                            $(".adv_class span").removeClass("checked");
                                                        }
                                                        showBalanceAdvance();
                                                    });
                                                }
                                                //end agency advance amount

                                                //show balance advance amt
                                                function showBalanceAdvance() {

                                                    var check = $('#use_advance').is(':checked');
                                                    var cashamt = $('#pay_from_advance').val();
                                                    var advamt = $('#adv_amt_id').val();

                                                    cashamt = (cashamt != '') ? cashamt : "0";
                                                    advamt = (advamt != '') ? advamt : "0";

                                                    if (check) {
                                                        $('.bal_adv_class').show();
                                                        if (parseFloat(cashamt) <= parseFloat(advamt)) {
                                                            var balance = parseFloat(advamt) - parseFloat(cashamt);
                                                            $('#bal_adv_amt_id').val(balance);
                                                            $('.err_msg').remove();
                                                        }
                                                        else {
                                                            $('#pay_from_advance').val(0);
                                                            $("<span class='err_msg' style='color:red;'>You can use below or equal of advance amount..</span>").insertAfter("#pay_from_advance");
                                                        }

                                                        $('#use_advance').val(1);
                                                    } else {
                                                        $('.bal_adv_class').hide();
                                                        $('#bal_adv_amt_id').val(advamt);
                                                        $('#pay_from_advance').val(0);
                                                        $('#use_advance').val(0);
                                                    }
                                                }
                                                //end show bal advance amt

                                                function paymet_type1() {
                                                    var x = document.getElementById("ptype").value;
                                                    if (x != "cash") {
                                                        $('#cash_pay1').hide();
                                                    } else {
                                                        $('#cash_pay1').show();
                                                    }
                                                    $.get("expayment_type.php", {value: x, epid:<?= $exid ?>}, function(data) {
                                                        $("#ajax_pay1").html(data);
                                                    });
                                                }

                                                function t_type() {
                                                    var x = document.getElementById("otype").value;
                                                    if (x) {
                                                        $('#ttypeid').show();
                                                        $('#ttypeid1').show();
                                                        var ttax = parseFloat($("#ttax").val());
                                                        tax_total(ttax);
                                                    } else {
                                                        $('#ttypeid').hide();
                                                        $('#ttypeid1').hide();
                                                        tax_total(0);
                                                    }
                                                }

                                                function hide_table_tr(n)
                                                {
                                                    $("#hide_tr" + n).hide();
                                                    $("#qty" + n).val(0);
                                                    $("#amount" + n).val(0);
                                                    $("#total" + n).val(0);
                                                    var input = $("#hide_tr" + n + ' input[type="text"]');
                                                    input.attr("disabled", "disabled");

                                                    var vals = 0;
                                                    var checkboxes = $('input[name="total[]"]');
                                                    for (var i = 0, no = checkboxes.length; i < no; i++) {
                                                        if (checkboxes[i].value == "") {
                                                        } else {
                                                            vals = parseFloat(checkboxes[i].value) + vals;
                                                        }
                                                    }
                                                    $("#overall_totamount").val(vals);
                                                }
                                                function calc(n)
                                                {
                                                    var qty = parseFloat($("#qty" + n).val());
                                                    var amt = parseFloat($("#amount" + n).val());
                                                    var tot = parseFloat(qty * amt);

                                                    if (isNaN(tot)) {
                                                        tot = 0;
                                                    }

                                                    $("#total" + n).val(tot);
                                                    var vals = 0;
                                                    var checkboxes = $('input[name="total[]"]');
                                                    for (var i = 0, no = checkboxes.length; i < no; i++) {
                                                        if (checkboxes[i].value == "") {
                                                        } else {
                                                            vals = parseFloat(checkboxes[i].value) + vals;
                                                        }
                                                    }
                                                    /*var tax=Number($("#tax").val());
                                                     alert(tax);*/
                                                    var ttax = document.getElementById("ttax").value;
                                                    var x = document.getElementById("otype").value;
                                                    var ship = parseFloat(document.getElementById("shipping").value);
                                                    if (isNaN(ship)) {
                                                        ship = 0;
                                                    }
                                                    var discount = parseFloat(document.getElementById("discount").value);
                                                    if (isNaN(discount)) {
                                                        discount = 0;
                                                    }
                                                    if (ttax.length != 0 && x.length != 0)
                                                    {
                                                        vals = parseFloat(vals) + parseFloat(ttax);
                                                    }
                                                    vals = (parseFloat(vals) + parseFloat(ship)) - parseFloat(discount);
                                                    $("#overall_totamount").val(vals);
                                                }

                                                function tax_total(n)
                                                {
                                                    var x = document.getElementById("otype").value;
                                                    var ship = parseFloat(document.getElementById("shipping").value);
                                                    if (isNaN(ship)) {
                                                        ship = 0;
                                                    }
                                                    var discount = parseFloat(document.getElementById("discount").value);
                                                    if (isNaN(discount)) {
                                                        discount = 0;
                                                    }
                                                   var ttax = parseFloat($('#ttax').val());
                                                    if (isNaN(ttax)) {
                                                        ttax = 0;
                                                    }
                                                    
                                                    var tds_amt = parseFloat($('#tds_amt').val());
                                                    if (isNaN(tds_amt)) {
                                                        tds_amt = 0;
                                                    }
                                                    var vals = 0;
                                                    var checkboxes = $('input[name="total[]"]');
                                                    for (var i = 0, no = checkboxes.length; i < no; i++) {
                                                        if (checkboxes[i].value == "") {
                                                        } else {
                                                            vals = parseFloat(checkboxes[i].value) + vals;
                                                        }
                                                    }
                                                    vals = (parseFloat(vals) + parseFloat(ttax)+parseFloat(tds_amt) + parseFloat(ship)) - parseFloat(discount);
                                                    $("#overall_totamount").val(vals);
                                                }
                                                function shipping_total(n)
                                                {
                                                    var ttax = parseFloat(document.getElementById("ttax").value);
                                                    if (isNaN(ttax)) {
                                                        ttax = 0;
                                                    }
                                                    var discount = parseFloat(document.getElementById("discount").value);
                                                    if (isNaN(discount)) {
                                                        discount = 0;
                                                    }

                                                    var shipping = parseFloat(n);
                                                    if (isNaN(shipping)) {
                                                        shipping = 0;
                                                    }
                                                    
                                                    var tds_amt = parseFloat($('#tds_amt').val());
                                                    if (isNaN(tds_amt)) {
                                                        tds_amt = 0;
                                                    }
                                                    
                                                    var vals = 0;
                                                    var checkboxes = $('input[name="total[]"]');
                                                    for (var i = 0, no = checkboxes.length; i < no; i++) {
                                                        if (checkboxes[i].value == "") {
                                                        } else {
                                                            vals = parseFloat(checkboxes[i].value) + vals;
                                                        }
                                                    }

                                                    vals = (parseFloat(vals) + parseFloat(ttax) + parseFloat(tds_amt)+ parseFloat(shipping)) - parseFloat(discount);
                                                    $("#overall_totamount").val(vals);
                                                }
                                                function discount_total(n)
                                                {
                                                    var ttax = parseFloat(document.getElementById("ttax").value);
                                                    if (isNaN(ttax)) {
                                                        ttax = 0;
                                                    }
                                                    var shipping = parseFloat(document.getElementById("shipping").value);
                                                    if (isNaN(shipping)) {
                                                        shipping = 0;
                                                    }
                                                    var discount = parseFloat(n);
                                                    if (isNaN(discount)) {
                                                        discount = 0;
                                                    }
                                                     var tds_amt = parseFloat($('#tds_amt').val());
                                                    if (isNaN(tds_amt)) {
                                                        tds_amt = 0;
                                                    }
                                                    var vals = 0;
                                                    var checkboxes = $('input[name="total[]"]');
                                                    for (var i = 0, no = checkboxes.length; i < no; i++) {
                                                        if (checkboxes[i].value == "") {
                                                        } else {
                                                            vals = parseFloat(checkboxes[i].value) + vals;
                                                        }
                                                    }
                                                    vals = (parseFloat(vals) + parseFloat(ttax) + parseFloat(tds_amt)+parseFloat(shipping)) - parseFloat(discount);
                                                    $("#overall_totamount").val(vals);
                                                }

                                                function add_table_tr(n)
                                                {

                                                    var input = $("#hide_tr" + n + ' input[type="text"]');

                                                    input.removeAttr("disabled");

                                                    var m = parseFloat(n) + 1;

                                                    $("#hide_tr" + n).show();

                                                    $("#addvalue0").attr("onclick", "add_table_tr(" + m + ")");

                                                }
    </script>

    <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
         chromium.org/developers/how-tos/chrome-frame-getting-started -->
    <!--[if lt IE 7 ]>
      <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
      <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->

</body>
</html>
<? ob_flush(); ?>