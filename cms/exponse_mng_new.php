<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php");
//echo $_SESSION['uname']; 
session_start();

//$check=$_SESSION['email'];

$user = $_SESSION['uname'];
if (isset($_POST['submit'])) {
    $date = $_POST['date'];
    $date_split1 = explode('/', $date);

    $date_month = $date_split1[1];
    $date_day = $date_split1[0];
    $date_year = $date_split1[2];

    $type = $_POST['type'];
    $aid = $_POST['aid'];

    if ($type == "2") {
        //cash payamount
        $title = $_POST['title'];
        $des = $_POST['des'];
        $r_no = $_POST['r_no'];
        $b_no = $_POST['b_no'];
        $amount = $_POST['amount'];
        $excid = $_POST['excid'];
        $exsid = $_POST['exsid'];
        $excid1 = $_POST['excid1'];

        $ptype = $_POST['ptype'];
        $pay_number = $_POST['pay_number'];

        $bank_name = $_POST['bank_name'];
        $account_no = $_POST['account_no'];
        $receiver = $_POST['receiver'];
        $cheque_date = $_POST['cheque_date'];
        
        $adv_status = $_POST['use_advance'];
        $adv_amount = $_POST['pay_from_advance'];
        $balance_advance = $_POST['balance_advance'];

        $receiptlist = mysql_query("SELECT * FROM tc_no WHERE id='3'");
        $receiptcount = mysql_fetch_array($receiptlist);

        $receiptno1 = $receiptcount['count'];
        $receiptno2 = $receiptno1 + 1;

        $receiptno = "EX" . str_pad($receiptno1, 5, '0', STR_PAD_LEFT);

        $sql = "INSERT INTO exponses (r_no,b_no,date_day,date_month,date_year,title,des,amount,exc_id,exs_id,ay_id,type,status,aid,p_type,
            pay_number,bank,account,c_date,receiver,billgenerate,advance_status,advance_amt) VALUES
('$receiptno','$b_no','$date_day','$date_month','$date_year','$title','$des','$amount','$excid','$exsid','$acyear','0','1','$aid','$ptype',
           '$pay_number','$bank_name','$account_no','$cheque_date','$receiver','$user','$adv_status','$adv_amount')";
        $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
        if ($result) {
            
            $parentid = mysql_insert_id();
            if($adv_status==1){
            $sql_adv = "INSERT INTO advance_payment (a_id,ex_id,r_no,bal_advance) VALUES ('$aid','$parentid','$r_no','$adv_amount')";
            $result_adv = mysql_query($sql_adv) or die("Could not insert data into DB: " . mysql_error());
            }
            
            $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
            $cash = mysql_fetch_array($cashlist);
            $currentcash = $cash['amount'];
            $updatecash = $currentcash - $amount;
            $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
            $sql1 = mysql_query("UPDATE tc_no SET count='$receiptno2' WHERE id='3'");
            $msg = "succ";
        }
    } else if ($type == "1") {
        //proposal
        $title = $_POST['title'];
        $b_no = $_POST['b_no'];

        $r_no = $_POST['r_no'];
        $total_amount = addslashes(trim($_POST['overall_totamount']));
        $excid = $_POST['excid'];
        $exsid = $_POST['exsid'];
        $excid1 = $_POST['excid1'];
        $n_sid = $_POST['n_sid'];
        $receiver = $_POST['receiver'];
        $t_type = $_POST['otype'];
        $t_parcent = $_POST['tax'];
        $t_amount = $_POST['ttax'];
        $shipping = $_POST['shipping'];
        $discount = $_POST['discount'];
        
        $tds_per = $_POST['tds_per'];
        $tds_amount = $_POST['tds_amt'];
        
        if (!$t_type) {
            $t_parcent = "";
            $t_amount = "";
        }

        if ($n_sid == "New") {
            $n_sid = 0;
        }
        $receiptlist = mysql_query("SELECT * FROM tc_no WHERE id='3'");
        $receiptcount = mysql_fetch_array($receiptlist);

        $receiptno1 = $receiptcount['count'];
        $receiptno2 = $receiptno1 + 1;

        $receiptno = "EX" . str_pad($receiptno1, 5, '0', STR_PAD_LEFT);
        $sql = "INSERT INTO exponses (r_no,b_no,date_day,date_month,date_year,title,des,amount,exc_id,exs_id,ay_id,type,q_id,t_type,t_parcent,t_amount,tds_per,tds_amt,shipping,discount,aid,receiver,billgenerate) VALUES
('$receiptno','$b_no','$date_day','$date_month','$date_year','$title','$des','$total_amount','$excid','$exsid','$acyear','1','$n_sid','$t_type','$t_parcent','$t_amount','$tds_per','$tds_amount','$shipping','$discount','$aid','$receiver','$user')";
        $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
        $id = mysql_insert_id();
        if ($result) {
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
                    $sql = mysql_query("INSERT INTO expense_po_amount (ex_id,name,poqty,qty,amount,total) values('$id','$name','$poqty','$qty','$amount','$totals')") or die(mysql_error());
                }
            }
            if ($n_sid) {
                $sql1 = mysql_query("UPDATE quotation SET status='1' WHERE q_id='$n_sid'");
            }
            $sql1 = mysql_query("UPDATE tc_no SET count='$receiptno2' WHERE id='3'");
            $msg = "succ";
        }
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

            $receiptlist = mysql_query("SELECT * FROM tc_no WHERE id='3'");
            $receiptcount = mysql_fetch_array($receiptlist);

            $receiptno = $receiptcount['count'];

            $receiptno = "EX" . str_pad($receiptno, 5, '0', STR_PAD_LEFT);
            $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
            $cash = mysql_fetch_array($cashlist);
            $currentcash = $cash['amount'];
            ?>
            <!-- Begin of titlebar/breadcrumbs -->
            <div id="title-bar">
                <ul id="breadcrumbs">
                    <li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                    <li class="no-hover"><a href="exponse_mng.php?excid=<?php echo $excid; ?>" title="month"><?php echo $class['ex_category']; ?> Expenses Details</a></li>
                    <li class="no-hover">Add New Expenses Details</li>
                </ul>
            </div> <!--! end of #title-bar -->

            <div class="shadow-bottom shadow-titlebar"></div>

            <!-- Begin of #main-content -->
            <div id="main-content">
                <div class="container_12">

                    <div class="grid_12">
                        <h1>Add New Expenses Details</h1>                
                        <a href="exponse_mng.php?excid=<?php echo $excid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                        <div style="float:right">
                            Current Hand Cash Total :<button class="btn btn-small btn-success"><?= $currentcash ?> Rs/-</button>
                        </div>
                    </div>
                    <div class="grid_12">
                        <?php //$msg=$_GET['msg'];
                        if ($msg == "succ") {
                            ?>			
                            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
<?php } ?>

                        <div class="block-border">
                            <div class="block-header">
                                <h1>Add New <?php echo $class['ex_category']; ?> Expenses Details</h1><span></span>
                            </div>
                            <form id="validate-form" class="block-content form" action="" method="post">
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Date (DD/MM/YYYY) <span class="error">*</span></label>
                                        <input id="datepicker" name="date" class="required" type="text" value="<?php echo date("d/m/Y"); ?>" readonly onchange="paymets()" />
                                    </p>
                                </div>

                                <div class="_25">
                                    <p>
                                        <label for="textfield">Expenses Category<span class="error">*</span></label>
                                        <?php
                                        $classl = "SELECT * FROM ex_category";
                                        $result1 = mysql_query($classl) or die(mysql_error());
                                        echo '<select name="excid" id="excid" class="required" onchange="suncategory()">';
                                        echo "<option value=''>Select category</option>";
                                        while ($row1 = mysql_fetch_assoc($result1)):
                                            if ($excid == $row1['exc_id']) {
                                                echo "<option value='{$row1['exc_id']}' selected>{$row1['ex_category']}</option>\n";
                                            } else {
                                                echo "<option value='{$row1['exc_id']}'>{$row1['ex_category']}</option>\n";
                                            }
                                        endwhile;
                                        echo '</select>';
                                        ?>
                                    </p>
                                </div>

                                <div class="_50">
                                    <p>
                                    <div id="subcategory">
                                        <label for="textfield">Expenses sub Category<span class="error">*</span></label>
                                        <select name="exsid" id="exsid" class="required" style="width:100%">
                                            <option value='' data_value=''>Select sub category</option>
                                        </select>
                                        <?php /*
                                          $classl = "SELECT * FROM  ex_insubcategory where count='0'";
                                          $result1 = mysql_query($classl) or die(mysql_error());
                                          echo '<select name="exsid" id="exsid" class="required" style="width:100%">';
                                          echo "<option value='' data_value=''>Select sub category</option>";
                                          while ($row1 = mysql_fetch_assoc($result1)):
                                          if($exsid ==$row1['exs_id']){
                                          echo "<option style='display:none;' data_value='$row1[category]' value='{$row1['exs_id']}' selected>{$row1['sub_name']}</option>\n";
                                          } else {
                                          echo "<option style='display:none;' data_value='$row1[category]' value='{$row1['exs_id']}'>{$row1['sub_name']}</option>\n";
                                          }
                                          endwhile;

                                          for($i=1;$i<=20;$i++)
                                          {
                                          $classl = "SELECT * FROM ex_insubcategory where count='$i' ";
                                          $result1 = mysql_query($classl) or die(mysql_error());
                                          while ($row1 = mysql_fetch_assoc($result1))
                                          {
                                          $subcat=array();
                                          for($j=1;$j<=20;$j++)
                                          {
                                          $sub_id=$row1["sub$j"."_id"];

                                          if($sub_id!=0){
                                          array_push($subcat,$sub_id);
                                          }
                                          }
                                          $insub_name="";
                                          foreach ($subcat as $val){
                                          $qry1=mysql_fetch_array(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$val'"));
                                          $insub_name.=$qry1["sub_name"]."&nbsp;>&nbsp;";
                                          }

                                          ?>
                                          <option style='display:none;'  data_value='<?=$row1[category]?>' value='<?=$row1['exs_id']?>-&innersubcategory'><?=$insub_name?><?=$row1['sub_name']?></option>
                                          <?php    }

                                          }
                                          echo '</select>'; */
                                        ?>
                                    </div>
                                    </p>
                                </div>
                                <div class="clear"></div>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Receipt No <span class="error">*</span></label>
                                        <input id="textfield" name="r_no" class="required" type="text" value="<?php echo $receiptno; ?>" readonly />
                                    </p>
                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="select">Expense Type: <span class="error">*</span></label>
                                        <select name="type" data-required="true" id="type"  class='required' onchange="expense_type()">
                                            <option value="">Please Select</option>
                                            <option value="1">Proposal</option>
                                            <option value="2">Cash payamount</option>
                                        </select>
                                    </p>
                                </div>
                                <div class="_75" style="float:left; width:20%;">
                                    <label for="textfield" style="padding-bottom:5px;">Receiver:</label><input type="text" name="receiver"></div>								


                                <div class="_75" style="float:rightt; width:20%;">
                                    <label for="textfield" style="padding-bottom:5px;">Bill Generated By:</label><input type="text" name="Bill Generated By" value="<?php echo $user; ?>"readonly></div>								
                                <div id="proposal" style="display:none">
                                    <div class="_25">
                                        <p>
                                            <label for="select">Po No: </label>
                                            <select name="n_sid" id="n_sid" onchange="proposal_type()" style="width:100%">
                                                <option value="New">New Proposal </option>
                                                <?php
                                                $emp_query = "select q_id,po_no from quotation where ay_id='$acyear' AND status=0";
                                                $emp_result = mysql_query($emp_query);
                                                while ($emp_display = mysql_fetch_array($emp_result)) {
                                                    $q_id = $emp_display["q_id"];
                                                    $qry1 = mysql_fetch_array(mysql_query("SELECT q_id FROM exponses where q_id='$q_id'"));
                                                    //if(!$qry1){
                                                    ?>
                                                    <option value="<?php echo $q_id; ?>"><?php echo $class . $emp_display["po_no"]; ?></option>
    <?php //} 
}
?>		
                                            </select>
                                        </p>
                                    </div>
                                    <div id="ajax_pay">
                                    </div>
                                </div>
                                <div id="expence_form">                        
                                </div>
                                <div class="clear"></div>
                                <div class="block-actions">
                                    <ul class="actions-left">
                                        <li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
                                    </ul>
                                    <ul class="actions-left">
                                        <input type="hidden" class="medium" name="excid1" value="<?php echo $_GET['excid']; ?>">
                                        <li><input type="submit" name="submit" class="button" value="Submit"></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div> 
                    <div class="clear height-fix"></div>
                    <div id="ajax_paylist">

                    </div>
                    <div class="clear height-fix"></div>
                </div>
            </div> <!--! end of #main-content -->
        </div> <!--! end of #main -->
<?php include("includes/footer.php"); ?>
    </div> <!--! end of #container -->
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
    <script>
                                                $.noConflict();
                                                jQuery(document).ready(function($) {
                                                    $('#table-example').dataTable({
                                                        'iDisplayLength': 25
                                                    });
                                                    // Code that uses jQuery's $ can follow here.
                                                });
                                                // Code that uses other library's $ can follow here.
    </script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
    <script src="js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


    <!-- scripts concatenated and minified via ant build script-->
    <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
    <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!--jQuery UI -->
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
                                                    $("#datepicker").datepicker(
                                                            {dateFormat: 'dd/mm/yy'});
                                                    $("#datepicker2").datepicker(
                                                            {dateFormat: 'dd/mm/yy'});

                                                    /*$( "#datepicker2" ).Zebra_DatePicker({
                                                     format: 'd/m/Y'
                                                     });*/
                                                });

                                                /*$( "#excid" ).change(function() {
                                                 var v=$( "#excid" ).val();
                                                 $("#exsid option").hide();
                                                 $("#exsid option[data_value='"+v+"']").show();
                                                 });*/
                                                 //start get agency advance amount
                                                function getAdvanceAmount(agency_id) {

                                                    $.get("get_advance_amount.php", {a_id: agency_id}, function(data) {
                                                        //$("#ajax_pay1").html(data);
                                                        //console.log(data);
                                                        if (data == '')
                                                            data = 0;
                                                        
                                                        if(data!=0){
                                                        $('.adv_class').show();
                                                        $('#adv_amt_id').val(data);
                                                        showBalanceAdvance();
                                                    }
                                                    else{
                                                        $('.adv_class').hide();
                                                        $('#adv_amt_id').val(0);
                                                    }
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
                                                        if(parseFloat(cashamt)<=parseFloat(advamt)){
                                                            var balance = parseFloat(advamt) - parseFloat(cashamt);
                                                            $('#bal_adv_amt_id').val(balance);
                                                            $('.err_msg').remove();
                                                        }
                                                        else{
                                                            $('#pay_from_advance').val(0);
                                                            $( "<span class='err_msg' style='color:red;'>You can use below or equal of advance amount..</span>" ).insertAfter( "#pay_from_advance" );
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

                                                function t_type() {
                                                    var x = document.getElementById("otype").value;
                                                    if (x) {
                                                        $('#ttypeid').show();
                                                        $('#ttypeid1').show();
                                                        var ttax = Number($("#ttax").val());
                                                        tax_total(ttax);
                                                    } else {
                                                        $('#ttypeid').hide();
                                                        $('#ttypeid1').hide();
                                                        tax_total(0);
                                                    }
                                                }

                                                function expense_type() {
                                                    var x = document.getElementById("type").value;
                                                    if (x == "1") {
                                                        $('#proposal').show();
                                                        proposal_type("New")
                                                        $('#expence_form').hide();
                                                    } else if (x == "2") {
                                                        $('#proposal').hide();
                                                        $('#expence_form').show();
                                                        $.get("proposal_type.php", {value1: x}, function(data) {
                                                            $("#expence_form").html(data);
                                                            $("#ajax_pay").html("");
                                                        });
                                                    } else {
                                                        $('#expence_form').hide();
                                                        $('#proposal').hide();
                                                    }
                                                    /*$.get("mpayment_type.php",{value:x},function(data){
                                                     $( "#ajax_pay" ).html(data);
                                                     });*/
                                                }
                                                function proposal_type() {
                                                    var x = document.getElementById("n_sid").value;
                                                    $.get("proposal_type.php", {value: x}, function(data) {
                                                        $("#ajax_pay").html(data);
                                                        $("#expence_form").html("");
                                                    });
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
                                                            vals = parseInt(checkboxes[i].value) + vals;
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
                                                    vals = (parseFloat(vals) + parseFloat(ttax) +parseFloat(tds_amt)+ parseFloat(ship)) - parseFloat(discount);
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

                                                    vals = (parseFloat(vals) + parseFloat(ttax)+parseFloat(tds_amt) + parseFloat(shipping)) - parseFloat(discount);
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
                                                    vals = (parseFloat(vals) + parseFloat(ttax) +parseFloat(tds_amt) + parseFloat(shipping)) - parseFloat(discount);
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
    <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
    <link rel="stylesheet" href="library/js/plugins/select2/select2.css" type="text/css" />
    <script src="js/jquery-migrate-1.2.1.js"></script>
    <script src="library/js/plugins/select2/select2.js"></script>  
    <script type="text/javascript">
                                                $().ready(function() {
                                                    $('#n_sid').select2({
                                                        allowClear: true,
                                                        placeholder: "Please Select..."
                                                    })
                                                    $('#exsid').select2({
                                                        allowClear: true,
                                                        placeholder: "Please Select..."
                                                    })
                                                });

                                                function paymets() {
                                                    var x = document.getElementById("datepicker").value;
                                                    $.get("expence_list.php", {value: x}, function(data) {
                                                        $("#ajax_paylist").html(data);
                                                    });
                                                }
                                                function suncategory() {
                                                    var x = document.getElementById("excid").value;
                                                    $.get("expence_list.php", {excid: x}, function(data) {
                                                        $("#subcategory").html(data);
                                                    });
                                                }
                                                paymets();
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