<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php");
//echo $_SESSION['uname'];
$adv_id = $_GET['aid'];
if (isset($_POST['submit'])) {


    $ba_id = $_POST['baid'];
    $bank_name = $_POST['bank_name'];
    $account_no = $_POST['account_no'];

    $payment_no = $_POST['pay_number'];
    $c_status = $_POST['c_status'];

    $date = $_POST['debited_date'];
    $date_split1 = explode('/', $date);

    $date_month = $date_split1[1];
    $date_day = $date_split1[0];
    $date_year = $date_split1[2];

    $cheque_date = $_POST['cheque_date'];

    $exbilllist = mysql_query("SELECT * FROM agency_advance WHERE adv_id=$adv_id");
    $exbill = mysql_fetch_array($exbilllist);
    $oldamount = $exbill['adv_amt'];
    $oldcstatus = $exbill['c_status'];

    $qry = "UPDATE agency_advance SET c_status='$c_status' WHERE adv_id='$adv_id'";
    $result = mysql_query($qry) or die("Could not edit data into DB: " . mysql_error());
    if ($result) {
        if ($c_status == '2') {
            if ($c_status != $oldcstatus) {
                $classlist1 = mysql_query("SELECT * FROM bank_account WHERE ba_id=$ba_id");
                $class1 = mysql_fetch_array($classlist1);
                $acc_no = $class1['account_no'];
                $b_name = $class1['b_name'];
                $baid1 = $class1['ba_id'];
                $amount = $oldamount;
                $sql1 = "INSERT INTO bank_withdrawl (date,date_day,date_month,date_year,account_no,b_name,withdrawl_by,amount,ba_id,ay_id,type,cheque_no,adv_id) VALUES
('$date','$date_day','$date_month','$date_year','$acc_no','$b_name','cheque pay','$amount','$baid1','$acyear','1','$payment_no','$adv_id')";
                $result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
                $accountamount = $class1['amount'];
                $accountcash = $accountamount - $amount;
                $cashqry = mysql_query("UPDATE bank_account SET amount='$accountcash' WHERE ba_id=$baid1");
            }
        } else {
            if ($oldcstatus == '2') {
                $delete1 = "Delete from bank_withdrawl where adv_id = $adv_id and ba_id='$ba_id'";
                $result2 = mysql_query($delete1);
                $classlist1 = mysql_query("SELECT * FROM bank_account WHERE ba_id=$ba_id");
                $class1 = mysql_fetch_array($classlist1);
                $amount = $oldamount;
                $accountamount = $class1['amount'];
                $accountcash = $accountamount + $amount;
                $cashqry = mysql_query("UPDATE bank_account SET amount='$accountcash' WHERE ba_id=$ba_id");
            }
        }
        $msg = "succ";
        header("Location:agency_advance_cheque.php?msg=succ");
    }

    exit;
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

            <!-- Begin of titlebar/breadcrumbs -->
            <div id="title-bar">
                <ul id="breadcrumbs">
                    <li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                    <li class="no-hover"><a href="agency.php" title="Home">Agency list</a></li>
                    <li class="no-hover">Cheque Advance Payment</li>
                </ul>
            </div> <!--! end of #title-bar -->

            <div class="shadow-bottom shadow-titlebar"></div>

            <!-- Begin of #main-content -->
            <div id="main-content">
                <div class="container_12">

                    <div class="grid_12">
                        <h1>Cheque Advance Payment</h1>                
                        <a href="agency_advance_cheque.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
                                <h1>Cheque Advance Payment</h1><span></span>
                            </div>
                            <form id="validate-form" class="block-content form" action="" method="post">
                                <?php
                                $advid = $_GET['aid'];
                                $qey_adv = "SELECT * from agency_advance where p_type='cheque' and adv_id = $advid";
                                $qry = mysql_query($qey_adv);
                                $row = mysql_fetch_array($qry);
                                ?>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Receipt No.</label>
                                        <input id="rec_no" name="rec_no" class="required" type="text" value="<?php echo $row['rec_no']; ?>" readonly/>
                                    </p>
                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Receipt Date <span class="error">*</span></label>
                                        <input id="datepicker" name="adv_date" class="required" type="text" value="<?php echo date("d/m/Y", strtotime($row['adv_date'])); ?>" readonly />
                                    </p>
                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Agency</label>


                                        <?php
                                        $classl = "SELECT * FROM agency WHERE status=0 and a_id=" . $row['a_id'];
                                        $result1 = mysql_query($classl) or die(mysql_error());
                                        $row1 = mysql_fetch_assoc($result1);
//                                            echo "<option value=''>please select agency</option>\n";
//                                            while ($row1 = mysql_fetch_assoc($result1)):
//                                                $sele = ($row['a_id']==$row1['a_id']) ? 'selected' : "" ;
//                                                echo "<option value='{$row1['a_id']}' $sele>{$row1['a_name']}</option>\n";
//                                            endwhile;
                                        ?>

                                        <input name="a_id" id="aid" class="required" type="text" value="<?php echo $row1['a_name']; ?>" readonly/>
                                    </p>

                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Advance Amount</label>
                                        <input id="adv_amt" name="adv_amt" class="required" type="text" value="<?php echo $row['adv_amt']; ?>" readonly/>
                                    </p>
                                </div>

                                <div class="_25">
                                    <p>
                                        <label for="textfield">Purpose</label>
                                        <input id="adv_purpose" name="adv_purpose" class="required" type="text" value="<?php echo $row['adv_purpose']; ?>" readonly />
                                    </p>
                                </div>

                                <div class="_25">
                                    <p>
                                        <label for="textfield">Payment Type:</label>
                                        <select name="ptype" id="ptype" class="required" onchange="paymet_type()">

                                            <option value="cheque" selected>cheque</option>									
                                        </select>	
                                    </p>									
                                </div> 

                                <div id="ajax_1"><div class="clear"></div><div class="_25"><p>
                                            <label for="textfield">Cheque No </label>
                                            <input id="textfield" name="pay_number" class="required" type="text" value="<?php echo $row['pay_number']; ?>">
                                        </p></div>
                                    <?php
                                    $baid1 = $row["ba_id"];
                                    $banklist = mysql_query("SELECT * FROM bank_account WHERE ba_id=$baid1");
                                    $bank = mysql_fetch_array($banklist);
                                    $bankname = $bank['name'];
                                    $account = $bank['account_no'];
                                    ?>
                                    <div class="_25"><p>
                                            <label for="textfield">Bank Name </label>
                                            <select name="baid" id="baid" class="required" onchange="bank_type()">
                                                <option value="<?php echo $baid1; ?>"><?php echo $bankname . " - " . $account; ?></option>
                                            </select></p></div>
                                    <div id="ajax_pay1"><div class="_25"><p>
                                                <label for="textfield">Bank Name </label>
                                                <input id="bank_name" name="bank_name" class="required" type="text" value="<?php echo $row["bank"]; ?>" readonly>
                                            </p></div>
                                        <div class="_25"><p>
                                                <label for="textfield">Account No</label>
                                                <input id="account_no" name="account_no" class="required" type="text" value="<?php echo $row["account"]; ?>" readonly>
                                            </p></div></div>
                                    <div class="_25"><p>
                                            <label for="textfield">Date</label>
                                            <input id="datepicker1" name="cheque_date" class="required" type="text" value="<?= date("d/m/Y", strtotime($row['c_date'])); ?>" readonly/>
                                        </p></div>
                                    <?php $c_status = $row['c_status']; ?>
                                    <div class="_25" id="pstatus"><p>
                                            <label for="textfield">Status </label>
                                            <select name="c_status" id="c_status"  class="required" onchange="process_type()">
                                                <option value="0" <?php
                                                if ($c_status == '0') {
                                                    echo "selected";
                                                }
                                                ?>>Process</option>
                                                <option value="1" <?php
                                                if ($c_status == '1') {
                                                    echo "selected";
                                                }
                                                ?>>Bounce</option>
                                                <option value="2" <?php
                                                if ($c_status == '2') {
                                                    echo "selected";
                                                }
                                                ?>>Debited</option>							
                                            </select>
                                        </p></div>
                                    <div id="debitdate">
                                    </div>
                                </div>
                                <div id="cash_pay1">
                                </div>

                                <div class="clear"></div>
                                <div class="block-actions">
                                    <ul class="actions-left">
                                        <li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
                                    </ul>
                                    <ul class="actions-left">
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

//                                                $('.select2').select2({
//                                                    allowClear: true,
//                                                    placeholder: "Please Select...",
//                                                    width: 'resolve'
//                                                });

                                                    $("#datepicker").Zebra_DatePicker({
                                                        format: 'd/m/Y'
                                                    });
                                                });

                                                /*   function paymet_type() {
                                                 var x = document.getElementById("ptype").value;
                                                 if (x != "cash") {
                                                 $('#cash_pay').hide();
                                                 } else {
                                                 $('#cash_pay').show();
                                                 }
                                                 $.get("expayment_type.php", {value: x}, function(data) {
                                                 $("#ajax_pay").html(data);
                                                 });
                                                 }*/
                                                function paymet_type() {
                                                    var x = document.getElementById("ptype").value;

                                                    if (x != "cash") {
                                                        $('#cash_pay1').hide();
                                                    } else {
                                                        $('#cash_pay1').show();
                                                    }
                                                    $.get("expayment_type1.php", {value: x}, function(data) {
                                                        $("#ajax_pay1").html(data);
                                                    });
                                                }
                                                function process_type() {
                                                    var x = document.getElementById("c_status").value;
                                                    $.get("expayment_type.php", {cstatus: x}, function(data) {
                                                        $("#debitdate").html(data);
                                                    });
                                                }
                                                process_type();
    </script>
<!--    <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
    <link rel="stylesheet" href="library/js/plugins/select2/select2.css" type="text/css" />
    <script src="js/jquery-migrate-1.2.1.js"></script>
    <script src="library/js/plugins/select2/select2.js"></script> -->


    <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
         chromium.org/developers/how-tos/chrome-frame-getting-started -->
    <!--[if lt IE 7 ]>
      <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
      <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->

</body>
</html>
<? ob_flush(); ?>