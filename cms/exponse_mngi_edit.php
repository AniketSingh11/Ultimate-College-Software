<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php");
include("includes/close-bill.php");
$epid = $_GET['epid'];


//echo $_SESSION['uname']; 
if (isset($_POST['place-order'])) {
    $date = $_POST['date'];
    $date_split1 = explode('/', $date);

    $date_month = $date_split1[1];
    $date_day = $date_split1[0];
    $date_year = $date_split1[2];


    $title = $_POST['title'];
    $billno = $_POST['bill_no'];
    $total = $_POST['total'];
    $aid = $_POST['aid'];
    $excid = $_POST['excid'];
    $aname = $_POST['aname'];
    $address = $_POST['address'];

    $ptype = $_POST['ptype'];
    $pay_number = $_POST['pay_number'];

    $ba_id = $_POST['baid'];
    $bank_name = $_POST['bank_name'];
    $account_no = $_POST['account_no'];
    $receiver = $_POST['receiver'];
    $cheque_date = $_POST['cheque_date'];


    $amount = $_POST['amount'];
    $orig_total = $_POST['orig_total'];
    $adv_status = $_POST['use_advance'];
    $add_advance_status = $_POST['add_advance'];

    $adv_amount = $_POST['pay_from_advance'];
    $balance_advance = $_POST['balance_advance'];
    $pay_to_advance = $_POST['pay_to_advance'];

    $exc_advance = ((($adv_amount) - $orig_total) > 0) ? (($adv_amount) - $orig_total) : 0;

    $exc_advance_total = $exc_advance + $pay_to_advance;        //total advance amount in hand


    $exbilllist = mysql_query("SELECT * FROM exponses_bill WHERE ep_id=$epid");
    $exbill = mysql_fetch_array($exbilllist);
    $oldamount = $exbill['amount'];
    $oldptype = $exbill['p_type'];

    $qry = "UPDATE exponses_bill SET date='$date',date_day='$date_day',date_month='$date_month',date_year='$date_year',amount='$total',"
            . "p_type='$ptype',pay_number='$pay_number',ba_id='$ba_id',bank='$bank_name',account='$account_no',c_date='$cheque_date',"
            . "address='$address',receiver='$receiver',advance_status='$adv_status',advance_amt='$adv_amount',excess_advance='$exc_advance',"
            . "add_adv_status='$add_advance_status',add_advance_amt='$pay_to_advance' WHERE ep_id='$epid'";

    $result = mysql_query($qry) or die("Could not edit data into DB: " . mysql_error());
    if ($result) {

        $sql_adv = "UPDATE advance_payment SET a_id='$aid',bal_advance='$adv_amount' WHERE ep_id='$epid'";
        $result_adv = mysql_query($sql_adv) or die("Could not insert data into DB: " . mysql_error());

        //excess advance
        if ($total == 0)
            $ptype = 'cash';

        $adv_date = $date_year . '-' . $date_month . '-' . $date_day;

        $sql_ag = "UPDATE agency_advance SET a_id='$aid',adv_date='$adv_date',adv_amt='$exc_advance_total',adv_purpose='Via Expense Bill Paid',
                status=1,p_type='$ptype',pay_number='$pay_number',ba_id='$ba_id',bank='$bank_name',account='$account_no',
                c_date='$cheque_date' where ep_id='$epid'";

        $result_ag = mysql_query($sql_ag);

        /*         * ********************************Hand cash pay Update **************************************** */
        if ($ptype == 'cash') {
            $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
            $cash = mysql_fetch_array($cashlist);
            $currentcash = $cash['amount'];
            if ($oldptype == $ptype) {
                $updatecash = ($currentcash + $oldamount + $exbill['add_advance_amt']) - ($total + $pay_to_advance);
                $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
            } else {
                $updatecash = $currentcash - ($total + $pay_to_advance);
                $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
            }
        } else if ($ptype == 'cheque') {
            if ($oldptype == 'cash') {
                $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
                $cash = mysql_fetch_array($cashlist);
                $currentcash = $cash['amount'];
                $updatecash = $currentcash + $oldamount + $exbill['add_advance_amt'];
                $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
            }
        }

        $max = count($_SESSION['close']);
        $count = 1;
        $myarray = array();
        for ($i = 0; $i < $max; $i++) {
            $pid = $_SESSION['close'][$i]['exid'];
            $q = $_SESSION['close'][$i]['excid'];
            $r = $_SESSION['close'][$i]['amount'];
            $t = $_SESSION['close'][$i]['payamount'];

            $results = mysql_query("SELECT * FROM exponses WHERE ex_id = '" . $pid . "' AND type=1");
            $exrow = mysql_fetch_assoc($results);

            $exdate = $exrow['date_day'] . "/" . $exrow['date_month'] . "/" . $exrow['date_year'];
            $r_no = $exrow['r_no'];
            $b_no = $exrow['b_no'];
            $title = $exrow['title'];
            $arrayid = "";
            $exbillex = mysql_query("SELECT id FROM exponses_bill_summary WHERE ep_id=$epid AND ex_id=$pid AND exc_id=$q");
            $alexbill = mysql_fetch_array($exbillex);
            $exbillid = $alexbill['id'];
            if ($exbillid) {
                $qry = mysql_query("UPDATE exponses_bill_summary SET amount='$t' WHERE id='$exbillid'");
                $arrayid = $exbillid;
            } else {
                $sql1 = "INSERT INTO exponses_bill_summary (ep_id,ex_id,exc_id,r_no,exdate,b_no,title,amount,ay_id) VALUES
('$epid','$pid','$q','$r_no','$exdate','$b_no','$title','$t','$acyear')";
                $result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
                $arrayid = mysql_insert_id();
            }
            $pending = $r - $t;
            if ($pending) {
                $status = 0;
                $cdate1 = "";
            } else {
                $status = 1;
                $cdate1 = $date;
            }
            $sql1 = mysql_query("UPDATE exponses SET pending='$pending',status='$status',cdate='$cdate1' WHERE ex_id='$pid'");
            array_push($myarray, $arrayid);
        }
        print_r($myarray);
        $delete1 = mysql_query("select id,amount,ex_id from exponses_bill_summary where ep_id='$epid' AND (id NOT IN (" . implode(',', $myarray) . ")) ");
        while ($delete = mysql_fetch_array($delete1)) {
            $exid1 = $delete['ex_id'];
            $results1 = mysql_query("SELECT * FROM exponses WHERE ex_id = '" . $exid1 . "' AND type=1");
            $exrow1 = mysql_fetch_assoc($results1);
            $expending = $exrow1['pending'];
            $exid2 = $delete['id'];
            $damount = $delete['amount'] + $expending;
            $sql1 = mysql_query("UPDATE exponses SET pending='$damount',status='0',cdate='' WHERE ex_id='$exid1'");
            $delete = mysql_query("Delete from exponses_bill_summary where id='$exid2' ");
        }
        unset($_SESSION['close']);
        header("Location:exponse_mngi_edit.php?epid=$epid&msg=succ");
    }
}

$exbilllist = mysql_query("SELECT * FROM exponses_bill WHERE ep_id=$epid");
$exbill = mysql_fetch_array($exbilllist);
$ptype = $exbill["p_type"];
$excid = $exbill["exc_id"];
$mtitle = $exbill["title"];
$aid = $exbill["a_id"];
$bill_address = $exbill["bill_address"];
$receiver = $exbill["receiver"];
$total_amount = $exbill["amount"];
$query = "select * from  exponses_bill_summary where ep_id='$epid'";
$res = mysql_query($query);
$i = 0;
while ($row = mysql_fetch_array($res)) {
    $i = $i + 1;
    $date = stripslashes($row["exdate"]);
    $r_no = stripslashes($row["r_no"]);
    $b_no = stripslashes($row["b_no"]);
    $title = stripslashes($row["title"]);
    $amount = $row["amount"];
    $exid = $row["ex_id"];
    $classlist12 = mysql_query("SELECT * FROM exponses WHERE ex_id=$exid");
    $row6 = mysql_fetch_array($classlist12);
    $pending1 = $row6["pending"];
    $payamount = $amount;
    $amount = $amount + $pending1;
    $excid = $row6["exc_id"];
    addtocart($exid, $excid, $amount, $aid, $payamount, $epid);
}

if ($_REQUEST['command'] == 'delete' && $_REQUEST['pid'] > 0) {
    remove_product($_REQUEST['pid']);
} else if ($_REQUEST['command'] == 'clear') {
    unset($_SESSION['close']);
} else if ($_REQUEST['command'] == 'cancel') {
    unset($_SESSION['close']);
    $bid = $_REQUEST['bid'];
    header("location:exponse_mngi.php");
} else if ($_REQUEST['command'] == 'update') {
    $max = count($_SESSION['close']);
    for ($i = 0; $i < $max; $i++) {
        $pid = $_SESSION['close'][$i]['exid'];
        $u = $_REQUEST['fees' . $pid];
        if ($u > 1) {
            $_SESSION['close'][$i]['payamount'] = $u;
        } else {
            $msg = 'Some proudcts not updated!, amount must be a number above 1';
        }
    }
}
if ($epid) {
    remove_product1($epid);
    //unset($_SESSION['close']);
}
if (isset($_POST['bills'])) {
    unset($_SESSION['close']);

    $ms_example = $_POST['ms_example'];
    $aid = $_POST['aid'];

    foreach ($ms_example as $selectedOption) {
        $exid = $selectedOption;
        $classlist1 = mysql_query("SELECT * FROM exponses WHERE ex_id=$exid");
        $row = mysql_fetch_array($classlist1);
        $tamount = $row["amount"];
        $pending1 = $row["pending"];
        if (!$pending1) {
            $pending1 = $row["amount"];
        }
        $excid = $row["exc_id"];
        addtocart($exid, $excid, $pending1, $aid, $pending1, $epid);
    }
    header("Location:exponse_mngi_new.php?aid=$aid");
    exit;
    //addtocart($cartid,$frid,$fgid2,$fgdid,$fgroup['fg_name'],$pending1,$total1,"terms",$paid);
}
//$aid=$_GET['aid'];
if (!$aid) {
    unset($_SESSION['close']);
}
?>
<link href="css/multiselect/multiselect.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
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
            //$aid=$_GET['aid'];
            if ($aid) {
                $classlist = mysql_query("SELECT * FROM agency WHERE a_id=$aid");
                $class = mysql_fetch_array($classlist);
            }
            $max = count($_SESSION['close']);
            ?>
            <!-- Begin of titlebar/breadcrumbs -->
            <div id="title-bar">
                <ul id="breadcrumbs">
                    <li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                    <li class="no-hover"><a href="exponse_mngi.php" title="month">Bill Paid Details</a></li>
                    <li class="no-hover">Bills to Close</li>
                </ul>
            </div> <!--! end of #title-bar -->

            <div class="shadow-bottom shadow-titlebar"></div>

            <!-- Begin of #main-content -->
            <div id="main-content">
                <div class="container_12">
                    <div class="grid_12">
                        <h1>Bills to Close</h1>                
                        <a href="exponse_mngi.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                        <?php if ($aid && $max > 0) { ?>
                            <div class="_25" style="float:right">
                                <label for="select">Add Bills To close:</label>
                                <select name="exid-add" id="exid-add" class="required" onchange="bill_add()">
                                    <option value="">Please Select</option>
                                    <?php
                                    $query = "SELECT ex_id,r_no,amount,pending FROM exponses WHERE aid = '" . $aid . "' AND type=1 AND status=0";
                                    $result = mysql_query($query);
                                    while ($row = mysql_fetch_assoc($result)) {
                                        $idcheck = $row['ex_id'];
                                        if (!product_exists($idcheck)) {
                                            $pending1 = $row["pending"];
                                            if (!$pending1) {
                                                $pending1 = $row["amount"];
                                            }
                                            echo '<option value ="' . $idcheck . '">' . $row['r_no'] . " - Rs. " . $pending1 . ".00 </option>";
                                        }
                                    }
                                    echo '</select>';
                                    ?>
                                </select>
                            </div>
                        <?php } ?> 
                    </div>
                    <div class="grid_12">
                        <?php
                        $msg = $_GET['msg'];
                        if ($msg == "succ") {
                            ?>			
                            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
                            <?php
                        }
                        if ($max > 0) {
                            $classl = mysql_query("SELECT * FROM agency where a_id=$aid");
                            $excateg = mysql_fetch_assoc($classl);
                            $receiptlist = mysql_query("SELECT * FROM tc_no WHERE id='6'");
                            $receiptcount = mysql_fetch_array($receiptlist);
                            $receiptno = $receiptcount['count'];
                            $receiptno = "EXPAY" . str_pad($receiptno, 3, '0', STR_PAD_LEFT);
                            ?>            
                            <div class="block-border">
                                <div class="block-header">
                                    <h1>Bill Payment Details</h1><span></span>
                                </div>
                                <form name="form1" method="post" action="" id="validate-form1" class="block-content form">
                                    <?php
                                    $a_qry = "SELECT sum(bal_advance) as advance FROM advance_payment where a_id=$aid order by adv_pay_id desc limit 1";

                                    $advancelist = mysql_query($a_qry);
                                    $advance = mysql_fetch_assoc($advancelist);

                                    $a_adv = "SELECT sum(adv_amt) as advance FROM agency_advance where a_id=$aid";

                                    $advlist = mysql_query($a_adv);
                                    $adv_total = mysql_fetch_assoc($advlist);

                                    $total_advance = $adv_total['advance'] - $advance['advance'];
                                    ?>
                                    <input type="hidden" name="pid" />
                                    <input type="hidden" name="command" />
                                    <div id="invoice" class="widget widget-plain" class="widget-content">
                                        <div class="_25">
                                            <p>
                                                <label for="textfield">Bill Date <span class="error">*</span></label>
                                                <input id="datepicker" name="date" class="required" type="text" value="<?php echo $exbill["date"]; ?>" readonly />
                                            </p>
                                        </div>
                                        <div class="_25">
                                            <p>
                                                <label for="textfield">Agency Name<span class="error">*</span></label>
                                                <input id="textfield" name="aname" class="required" type="text" value="<?php echo $excateg["a_name"]; ?>" readonly />
                                                <input id="textfield" name="aid" type="hidden" value="<?php echo $aid; ?>" readonly />
                                            </p>
                                        </div>
                                        <div class="_25">
                                            <p>
                                                <label for="textfield">Bill No <span class="error">*</span></label>
                                                <input id="textfield" name="bill_no" class="required" type="text" value="<?php echo $receiptno; ?>" readonly />
                                            </p>
                                        </div>
                                        <div class="_25">
                                            <p>
                                                <label for="textfield">Title</label>
                                                <input id="textfield" name="title"  type="text" value="<?= $mtitle ?>" />
                                            </p>
                                        </div>
                                        <div class="_50">
                                            <p>
                                                <label for="textfield">Address<span class="error">*</span></label>
                                                <textarea id="address" name="address" class="required" rows="5"><?php echo $excateg["a_address"]; ?></textarea>
                                            </p>
                                        </div>
                                        <div class="_25 adv_class" <?php if($total_advance==0){?> style="display:none;" <?php }?>>
                                            <p style="font-size: 40px;color: green;margin: 30px 0px;"> 
                                                <label for="textfield">Advance Payment</label>
                                                Rs.
                                                <?php
                                                echo $total_advance + $exbill["advance_amt"];
                                                ?>
                                                /-
                                                <input type="hidden" id="adv_amt_id" name="adv_amt_"  value="<?php echo $total_advance + $exbill["advance_amt"]; ?>" readonly />
                                        </div>

                                        <div class="_25 adv_class" >
                                            <p> 
                                                <label for="textfield">
                                                    <?php //if ($total_advance != 0) {  ?><input name="use_advance" id="use_advance" type="checkbox" value="<?php echo $exbill["advance_status"]; ?>" <?php if ($exbill["advance_status"] == 1) echo "checked"; ?> style="width:20%" onchange="showBalanceAdvance();">Inclusive Advance Amount <?php //}  ?><br>
                                                    <input name="add_advance" id="add_advance" type="checkbox" value="<?php echo $exbill["add_adv_status"]; ?>" <?php if ($exbill["add_adv_status"] == 1) echo "checked"; ?> style="width:20%" onchange="addAdvance();">Add Advance Amount
                                                </label>

                                        </div>
                                        <div class="clear"></div>
                                        <h4><center>Closing Bill Details</center></h4>
                                        <table class="table table-striped" id="table-example">	
                                            <?php
                                            $max = count($_SESSION['close']);
                                            if (is_array($_SESSION['close']) && $max > 0) {
                                                ?>				
                                                <thead>
                                                    <tr>
                                                        <th width="10">S.No</th>
                                                        <th><center>Date</center></th>
                                                <th><center>Expence No</center></th>
                                                <th><center>Bill No</center></th>
                                                <th><center>Title</center></th>
                                                <th><center>Total</center></th>
                                                <th class="total">Pay Amount</th>
                                                <th width="10"></th>
                                                </tr>
                                                </thead>						
                                                <tbody>
                                                    <?php
                                                    $max = count($_SESSION['close']);
                                                    $count = 1;
                                                    for ($i = 0; $i < $max; $i++) {
                                                        $pid = $_SESSION['close'][$i]['exid'];
                                                        $q = $_SESSION['close'][$i]['excid'];
                                                        $r = $_SESSION['close'][$i]['amount'];
                                                        $t = $_SESSION['close'][$i]['payamount'];

                                                        $result = mysql_query("SELECT * FROM exponses WHERE ex_id = '" . $pid . "' AND type=1");
                                                        $row = mysql_fetch_assoc($result);
                                                        ?>
                                                        <tr>
                                                            <td><center><?php echo $count; ?></center></td>			
                                                    <td><center><?php echo $row['date_day'] . "/" . $row['date_month'] . "/" . $row['date_year']; ?></center></td>
                                                    <td><center><?php echo $row['r_no']; ?></center></td>
                                                    <td><center><?php echo $row['b_no']; ?></center></td>
                                                    <td><center><?php echo $row['title']; ?></center></td>
                                                    <td><center><?php echo $r; ?></center></td>
                                                    <td class="total" width="120"><?php $samount = number_format($r, 2); ?></span>
                                                        <input type="text" name="fees<?php echo $pid; ?>" id="fees<?php echo $pid; ?>" class="biginput txt" value="<?php echo $t; ?>" autocomplete="off" max="<?php echo $r; ?>" />									
                                                    </td>
                                                    <td><a href="javascript:del(<?php echo $pid ?>)"><img src="Book_inventory/images/del.png" alt="delete"></a></td>
                                                    </tr>
                                                    <?php
                                                    $count++;
                                                }
                                                ?>
                                                <tr>
                                                    <td class="sub_total" colspan="5"></td>
                                                    <td class="sub_total">Subtotal:</td>
                                                    <td class="sub_total">Rs. <?php echo number_format(get_order_total(), 2); ?></td>
                                                </tr>
                                                
                                                    <tr class="tr_adv_class" <?php if ($exbill["advance_status"]) { ?> style="display:none"<?php } ?> >
                                                        <td class="sub_total" colspan="5"></td>
                                                        <td class="sub_total">Already Paid Advance:</td>
                                                        <td class="sub_total">
                                                            <input id="pay_from_advance" name="pay_from_advance" type="text" value="<?php echo $exbill["advance_amt"]; ?>" onkeyup="showBalanceAdvance();" />
                                                        </td>

                                                    </tr>
                                                
                                                <tr class="total_bar">
                                                    <td class="grand_total" colspan="5"></td>
                                                    <td class="grand_total">Total:</td>
                                                    <td class="grand_total"><span id="total_text">Rs. 
                                                            <?php
                                                            $total = get_order_total();
                                                            echo $exbill["amount"];
                                                            ?>
                                                        </span>
                                                        <input type="hidden" class="medium" name="orig_total" id="orig_total" value="<?php echo $total; ?>"/>
                                                        <input type="hidden" id="bal_adv_amt_id" name="balance_advance" value="<?php //echo $balance_advance;    ?>" />
                                                        <input type="hidden" class="medium" name="total" id="gr_total" value="<?php echo $exbill["amount"]; ?>"/>
                                                    </td>
                                                </tr>
                                                <tr class="total_bar tr_adv_class">
                                                    <td class="grand_total" colspan="5"></td>
                                                    <td class="grand_total">Balance Advance Amount:</td>
                                                    <td class="grand_total"><span id="bal_adv_amt_text"><?php //echo number_format($bal_pay, 2);   ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="9" align="right">
                                                        <div class="_25 bal_adv_class" style="display:none;" >
                                                            <p>
                                                                <label for="textfield" > Amount To Advance </label>
                                                                <input id="pay_to_advance" name="pay_to_advance" type="text" value="<?php echo $exbill["add_advance_amt"]; ?>" onkeyup="showAdvanceBalText();" />
                                                            </p>    
                                                        </div>
                                                        <div class="_25 payment_type" >
                                                            <p>
                                                                <label for="textfield">Payment Type:</label>
                                                                <select name="ptype" id="ptype" class="required" onchange="paymet_type()">
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
                                                                <input type="hidden" name="old_ptype" value="<?= $ptype ?>" />
                                                            </p>									
                                                        </div>

                                                        <div class="_25">
                                                            <label for="textfield" style="padding-bottom:5px;"> Receiver:</label><input type="text"  name="receiver" value="<?php echo $exbill['receiver']; ?>"/><br></div>						


                                                        <div class="_25">
                                                            <label for="textfield" style="padding-bottom:5px;">  Bill Generated By:</label><input type="text" name="billgenerate" value="<?php echo $exbill['billgenerate']; ?>" readonly/><br></div>
                                                        <div class="clear"></div>
                                                        <div id="ajax_pay">
                                                        </div>
                                                        <div id="cash_pay">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="9" align="right">
                                                        <span id="billpay">
                                                            <input type="submit" value="Submit" name="place-order" class="btn btn-green" onClick="return confirm('are you sure you wish to Submit this Details');" style="width:100px">&nbsp;&nbsp;
                                                            <input type="button" value="cancel" class="btn btn-red" onClick="cancel_cart()" style="width:100px"></span>
                                                        <span id="billupdate" style="display:none; float:right">
                                                            <input type="button" value="Update" class="btn  btn-green" onClick="update_cart()" style="width:100px">&nbsp;&nbsp;
                                                            <input type="button" value="cancel" class="btn btn-red" onClick="cancel_cart()" style="width:100px">
                                                        </span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                                <?php
                                            } else {
                                                echo '<tr bgColor="#FFFFFF"><td><center><h4>There are no Fees Details in your Invoice !!!</h4></center></td><td width="80px"><input type="button" value="cancel" class="btn  btn-red" onclick="cancel_cart()">';
                                            }
                                            ?>
                                        </table>
                                    </div>
                                    <div class="clear"></div>
                                </form>
                            </div>
                            <?php
                        } else {
                            unset($_SESSION['close']);
                        }
                        ?>
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
    <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>
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
                                                            $("#exsid option[data_value='<?= $excid ?>']").show();
                                                            var validateform = $("#validate-form").validate();
                                                            var validateform = $("#validate-form1").validate();
                                                            $("#reset-validate-form").click(function() {
                                                                validateform.resetForm();
                                                                $.jGrowl("Form was Reset.", {theme: 'error'});
                                                            });
                                                            //$( "#datepicker" ).datepicker();	
                                                            $("#datepicker").Zebra_DatePicker({
                                                                format: 'd/m/Y'
                                                            });
                                                            $(".txt").keyup(function() {
                                                                $('#billupdate').show();
                                                                $('#billpay').hide();
                                                            });

                                                            showBalanceAdvance();
                                                            addAdvance();
                                                            $("#validate-form1").submit(function(e) {
                                                                var cashamt = $('#cashamt').val();
                                                                var advamt = $('#pay_from_advance').val();
                                                                var grtotal = $('#gr_total').val();

                                                                cashamt = (cashamt != '') ? cashamt : "0";
                                                                advamt = (advamt != '') ? advamt : "0";
                                                                grtotal = (grtotal != '') ? grtotal : "0";
                                                                /*console.log('grand total ' + parseFloat(grtotal) + 'cash amount ' + parseFloat(cashamt) + 'Advance ' + parseFloat(advamt));
                                                                 console.log((parseFloat(grtotal) > (parseFloat(cashamt) + parseFloat(advamt))));
                                                                 
                                                                 if ((parseFloat(grtotal) > (parseFloat(cashamt) + parseFloat(advamt)))) {
                                                                 alert('Please Give the Full Payment');
                                                                 return false;
                                                                 } else {
                                                                 return true;
                                                                 }*/
                                                                if ($(".err_msg").length) {
                                                                    alert('Error Alert');
                                                                    return false;
                                                                }
                                                            });

                                                        });

                                                        //show balance advance amt
                                                        function showBalanceAdvance() {

                                                            var check = $('#use_advance').is(':checked');
                                                            var cashamt = $('#pay_from_advance').val();
                                                            var advamt = $('#adv_amt_id').val();

                                                            cashamt = (cashamt != '') ? cashamt : "0";
                                                            advamt = (advamt != '') ? advamt : "0";

                                                            if (check) {

                                                                $('.tr_adv_class').show();
                                                                if ((parseFloat(cashamt) <= parseFloat(advamt)) && (parseFloat(cashamt) <= parseFloat(advamt))) {
                                                                    var balance = parseFloat(advamt) - parseFloat(cashamt);
                                                                    $('#bal_adv_amt_id').val(balance);
                                                                    //$('#bal_adv_amt_text').html(balance);
                                                                    $('.err_msg').remove();
                                                                    total_with_advance();
                                                                }
                                                                else {
                                                                    $('#pay_from_advance').val(0);
                                                                    $('#bal_adv_amt_id').val(advamt);
                                                                    //$('#bal_adv_amt_text').html(advamt);
                                                                    $("<span class='err_msg' style='color:red;'>You can use below or equal of advance amount(" + advamt + ")</span>").insertAfter("#pay_from_advance");
                                                                }
                                                                $('#use_advance').val(1);
                                                            } else {
                                                                $('.tr_adv_class').hide();

                                                                $('#bal_adv_amt_id').val(advamt);
                                                                //$('#bal_adv_amt_text').html(advamt);
                                                                $('#pay_from_advance').val(0);
                                                                $('#use_advance').val(0);
                                                                total_with_advance();
                                                                $('#cashamt').val($('#gr_total').val());


                                                            }
                                                            showAdvanceBalText();
                                                        }
                                                        //end show bal advance amt
                                                        function total_with_advance() {

                                                            var total_amt = $('#orig_total').val();
                                                            var advance_amt = $('#pay_from_advance').val();
                                                            
                                                            console.log(advance_amt);
                                                            
                                                            var bal_pay = parseFloat(advance_amt.replace(",", "")) - parseFloat(total_amt);
                                                            var bal_advance;
                                                            if (bal_pay >= 0) {
                                                                bal_advance = bal_pay;
                                                                bal_pay = 0;
                                                                $('.payment_type').hide();

                                                            } else if (bal_pay < 0) {

                                                                bal_pay = Math.abs(bal_pay);
                                                                bal_advance = 0;
                                                                $('.payment_type').show();
                                                            }
                                                            $('#total_text').html(bal_pay);
                                                            $('#gr_total').val(bal_pay);
                                                            $('#cashamt').val(bal_pay);

                                                        }

                                                        function addAdvance() {
                                                            var check = $('#add_advance').is(':checked');
                                                            var tot = $('#gr_total').val();
                                                            if (check) {
                                                                $('.bal_adv_class').show();

                                                                $('#add_advance').val(1);
                                                            } else {
                                                                $('.bal_adv_class').hide();

                                                                $('#pay_to_advance').val(0);
                                                                $('#add_advance').val(0);
                                                                showAdvanceBalText();
                                                            }

                                                            if (check || tot != 0) {
                                                                $('.payment_type').show();
                                                            } else {
                                                                $('.payment_type').hide();
                                                            }

                                                        }

                                                        function showAdvanceBalText() {
                                                            var lessadv = $('#bal_adv_amt_id').val();
                                                            var payadv = $('#pay_to_advance').val();
                                                            payadv = (payadv != '') ? payadv : "0";

                                                            var bal_adv = parseFloat(lessadv) + parseFloat(payadv);
                                                            $('#bal_adv_amt_text').html(bal_adv);
                                                        }

                                                        function proposal_bill() {
                                                            var x = document.getElementById("n_sid").value;
                                                            $.get("proposal_bill.php", {value: x}, function(data) {
                                                                $("#proposal_bill").html(data);
                                                            });
                                                        }
                                                        function del(pid) {
                                                            if (confirm('Do you really mean to delete this item')) {
                                                                document.form1.pid.value = pid;
                                                                document.form1.command.value = 'delete';
                                                                document.form1.submit();
                                                            }
                                                        }
                                                        function clear_cart() {
                                                            if (confirm('This will empty your Billing, continue?')) {
                                                                document.form1.command.value = 'clear';
                                                                document.form1.submit();
                                                            }
                                                        }
                                                        function update_cart() {
                                                            document.form1.command.value = 'update';
                                                            document.form1.submit();
                                                        }
                                                        function cancel_cart() {
                                                            if (confirm('This will cancel your Bill, continue?')) {
                                                                document.form1.command.value = 'cancel';
                                                                document.form1.submit();
                                                            }
                                                        }
                                                        function paymet_type() {
                                                            var x = document.getElementById("ptype").value;
                                                            if (x != "cash") {
                                                                $('#cash_pay').hide();
                                                            } else {
                                                                $('#cash_pay').show();
                                                            }
                                                            $.get("expayment_type.php", {value: x, epid:<?= $epid ?>}, function(data) {
                                                                $("#ajax_pay").html(data);
                                                            });
                                                        }
                                                        function bill_add() {
                                                            var x = document.getElementById("exid-add").value;
                                                            $.get("expayment_billadd.php", {value: x, epid:<?= $epid ?>}, function(data) {
                                                                window.location.href = window.location.href
                                                            });

                                                        }
                                                        paymet_type()
    </script>
    <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
         chromium.org/developers/how-tos/chrome-frame-getting-started -->
    <!--[if lt IE 7 ]>
      <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
      <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->
    <?php if (!$aid || !$max) { ?>
        <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
    <?php } ?>
    <script src="js/jquery-migrate-1.2.1.js"></script>
    <script type='text/javascript' src='js/plugins/multiselect/jquery.multi-select.min.js'></script>  
    <script type="text/javascript">
                                                        function showCategory(str) {
                                                            if (str == "") {
                                                                document.getElementById("msc1").innerHTML = "";
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
                                                                    document.getElementById("msc1").innerHTML = xmlhttp.responseText;
                                                                    multiselect();
                                                                }
                                                            }
                                                            xmlhttp.open("GET", "exbilllist.php?mmtid=" + str, true);
                                                            xmlhttp.send();
                                                        }
                                                        function multiselect() {
                                                            if ($("#msc").length > 0) {
                                                                //alert($("#msc").length);
                                                                $("#msc").multiSelect({
                                                                    selectableHeader: "<div class='multipleselect-header'>Selectable item</div>",
                                                                    selectedHeader: "<div class='multipleselect-header'>Selected items</div>",
                                                                    afterSelect: function(value, text) {
                                                                        //action
                                                                        //alert("select");
                                                                    },
                                                                    afterDeselect: function(value, text) {
                                                                        //action
                                                                        //alert("delete");
                                                                    }
                                                                });

                                                                $("#ms_select").click(function() {
                                                                    $('#msc').multiSelect('select_all');
                                                                });
                                                                $("#ms_deselect").click(function() {
                                                                    $('#msc').multiSelect('deselect_all');
                                                                });
                                                            }
                                                        }

    </script> 


</body>
</html>
<? ob_flush(); ?>