<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php");
//echo $_SESSION['uname'];

if (isset($_POST['submit'])) {

    $aname = $_POST['a_id'];
    $adv_amt = $_POST['adv_amt'];
    $adv_purpose = $_POST['adv_purpose'];

    $adate = str_replace('/', '-', $_POST['adv_date']);

    $adv_date = date("Y-m-d", strtotime($adate));


    $ptype = $_POST['ptype'];
    $pay_number = $_POST['pay_number'];

    $ba_id = $_POST['baid'];
    $bank_name = $_POST['bank_name'];
    $account_no = $_POST['account_no'];
    
    $receiver = $_POST['receiver'];
    $billgenerate = $_POST['billgenerate'];

    if (!isset($_POST['cheque_date']))
        $_POST['cheque_date'] = '00/00/0000';

    $cdate = str_replace('/', '-', $_POST['cheque_date']);
    $cheque_date = date("Y-m-d", strtotime($cdate));

    $receiptlist = mysql_query("SELECT * FROM tc_no WHERE id='8'");
    $receiptcount = mysql_fetch_array($receiptlist);

    $receiptno1 = $receiptcount['count'];
    $receiptno2 = $receiptno1 + 1;

    $receiptno = "AD" . str_pad($receiptno1, 5, '0', STR_PAD_LEFT);

    $sql = "INSERT INTO agency_advance (a_id,rec_no,adv_date,adv_amt,adv_purpose,status,p_type,pay_number,ba_id,bank,account,c_date,receiver,billgenerate) VALUES
('$aname','$receiptno','$adv_date','$adv_amt','$adv_purpose','1','$ptype','$pay_number','$ba_id','$bank_name','$account_no','$cheque_date','$receiver','$billgenerate')";

    $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if ($result) {

        /*         * ********************************Hand cash pay Update **************************************** */
        if ($ptype == 'cash') {
            $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
            $cash = mysql_fetch_array($cashlist);
            $currentcash = $cash['amount'];
            $updatecash = $currentcash - $adv_amt; //$total;
            $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
        }
        $sql1 = mysql_query("UPDATE tc_no SET count='$receiptno2' WHERE id='8'");
        header("Location:agency_advance.php?msg=succ");
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
                    <li class="no-hover"><a href="agency_advance.php" title="Home">Agency Advance</a></li>
                    <li class="no-hover">Add Advance Payment</li>
                </ul>
            </div> <!--! end of #title-bar -->

            <div class="shadow-bottom shadow-titlebar"></div>

            <!-- Begin of #main-content -->
            <div id="main-content">
                <div class="container_12">

                    <div class="grid_12">
                        <h1>Add Advance Payment</h1>                
                        <a href="agency_advance.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
                                <h1>Add Advance Payment</h1><span></span>
                            </div>
                            <form id="validate-form" class="block-content form" action="" method="post">
                                <?php
                                $receiptlist = mysql_query("SELECT * FROM tc_no WHERE id='8'");
                                $receiptcount = mysql_fetch_array($receiptlist);
                                $receiptno = $receiptcount['count'];
                                $receiptno = "AD" . str_pad($receiptno, 5, '0', STR_PAD_LEFT);
                                ?>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Receipt No.</label>
                                        <input id="rec_no" name="rec_no" class="required" type="text" value="<?php echo $receiptno; ?>" readonly/>
                                    </p>
                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Receipt Date <span class="error">*</span></label>
                                        <input id="datepicker" name="adv_date" class="required" type="text" value="<?php echo date("d/m/Y"); ?>" readonly />
                                    </p>
                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Agency</label>
                                        <select name="a_id" id="aid" class="required select2">
                                            <?php
                                            $classl = "SELECT * FROM agency WHERE status=0";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo "<option value=''>please select agency</option>\n";
                                            while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['a_id']}'>{$row1['a_name']}</option>\n";
                                            endwhile;
                                            ?>
                                        </select>
                                    </p>

                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Advance Amount</label>
                                        <input id="adv_amt" name="adv_amt" class="required" type="text" value="" />
                                    </p>
                                </div>

                                <div class="_25">
                                    <p>
                                        <label for="textfield">Purpose</label>
                                        <input id="adv_purpose" name="adv_purpose" class="required" type="text" value="" />
                                    </p>
                                </div>

                                <div class="_25">
                                    <p>
                                        <label for="textfield">Payment Type:</label>
                                        <select name="ptype" id="ptype" class="required" onchange="paymet_type()">
                                            <option value="cash">Cash</option>	
                                            <option value="card">Card</option>
                                            <option value="cheque">cheque</option>									
                                        </select>	
                                    </p>									
                                </div> 
                                <div class="_75" style="float:left; width:20%;">
                                    <label for="textfield" style="padding-bottom:5px;">Receiver:</label>
                                    <input type="text" name="receiver">
                                </div>								


                                <div class="_75" style="float:rightt; width:20%;">
                                    <label for="textfield" style="padding-bottom:5px;">Bill Generated By:</label>
                                    <input type="text" name="billgenerate" value="<?php echo $user; ?>"readonly>
                                </div>
                                
                                <div class="clear"></div>
                                <div id="ajax_pay">
                                </div>
                                <div id="cash_pay">
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

                                            function paymet_type() {
                                                var x = document.getElementById("ptype").value;
                                                if (x != "cash") {
                                                    $('#cash_pay').hide();
                                                } else {
                                                    $('#cash_pay').show();
                                                }
                                                $.get("expayment_type.php", {value: x}, function(data) {
                                                    $("#ajax_pay").html(data);
                                                });
                                            }

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