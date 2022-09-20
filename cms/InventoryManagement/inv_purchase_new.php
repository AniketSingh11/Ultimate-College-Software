<? ob_start(); ?>
<?php
session_start();
$user=$_SESSION['uname'];

error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit'])) {

    $auto_bill = $_POST['bill_autono'];
    $billno = $_POST['purchase_no'];
    
    $agencyname = $_POST['agency'];
    $overall_tot = $_POST['overall_totamount'];
    
    $adate = str_replace('/', '-', $_POST['purchase_date']);
    $receipt_date = date("Y-m-d",  strtotime($adate));
    
    $result_parent = mysql_query("INSERT INTO inv_purchase_parent (purchase_date,purchase_no,agency_id,overeall_total,ay_id,billgenerate) VALUES
		('$receipt_date','$auto_bill','$agencyname','$overall_tot','$acyear','$user')");
    if ($result_parent) {
        $parentid = mysql_insert_id();

        //update bill no
        $bill_inc_no = $auto_bill + 1;
        $result_bill = mysql_query("UPDATE tc_no SET count='$bill_inc_no' where id=9") or die("Could not insert data into DB: " . mysql_error());


        for ($i = 0; $i <= 30; $i++) {


            $itemnames = $_POST['itemname'];
            $brandnames = $_POST['brandname'];
            $qtys = $_POST['qty'];
            $uomnames = $_POST['uomname'];
            $buyprices = $_POST['buy_price'];
            $sellprices = $_POST['selling_price'];
            $totalamts = $_POST['total_amt'];

            $uomname_modests = $_POST['uomname_modest'];

            $uomname_subs = $_POST['uomname_sub'];
            $selling_price_subs = $_POST['selling_price_sub'];



            $itemname = $itemnames[$i];
            $brandname = $brandnames[$i];
            $qty = $qtys[$i];
            $uomname = $uomnames[$i];
            $buyprice = $buyprices[$i];
            $sellprice = $sellprices[$i];
            $totalamt = $totalamts[$i];

            $uomname_sub = $uomname_subs[$i];
            $selling_price_sub = $selling_price_subs[$i];
            $uomname_modest = $uomname_modests[$i];

            if ($totalamt == "" || $totalamt == 0) {
                
            } else {
                $sql = "INSERT INTO inv_purchase (pur_parent_id,item_id,brand_id,uom_id,buy_price,sell_price,qty,total) VALUES
		('$parentid','$itemname','$brandname','$uomname','$buyprice','$sellprice','$qty','$totalamt')";

                $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
                $pur_id = mysql_insert_id();

                if ($result) {

                    if ($uomname_sub != "" && $selling_price_sub != "") {

                        $sql_uom = "INSERT INTO inv_purchase_mode (pur_id,uomname_sub,selling_price_sub) VALUES
				('$pur_id','$uomname_sub','$selling_price_sub')";

                        $result_uom = mysql_query($sql_uom) or die("Could not insert data into DB: " . mysql_error());
                    }

                    $result_select = mysql_query("select * from inv_items where item_id=$itemname");
                    $row_items_select = mysql_fetch_assoc($result_select);
                    //set total qty
                    $tot_qty = $row_items_select['item_qty'] + $qty;
                    //update total qty
                    $sql_item = "UPDATE inv_items SET item_qty='$tot_qty' where item_id=$itemname";
                    $result1 = mysql_query($sql_item) or die("Could not insert data into DB: " . mysql_error());

                    //start update brand qty
                    $qry_brand1 = mysql_query("select * from inv_brand_items where item_id=$itemname and brand_id = $brandname");
                    $row_brand1 = mysql_fetch_assoc($qry_brand1);

                    if (!empty($row_brand1)) {

                        $brand_qty = $row_brand1['qty'] + $qty;
                        $sql_item_brand1 = mysql_query("UPDATE inv_brand_items SET qty='$brand_qty' where item_id=$itemname and brand_id = $brandname");
                    } else {

                        $sql_item_brand1 = mysql_query("INSERT INTO inv_brand_items (item_id,brand_id,qty) VALUES
				('$itemname','$brandname','$qty')");
                    }

                    //end brand qty
                }
            }
        }
    }
    if ($result_parent) {

        header("Location:inv_purchase_new.php?msg=succ");
    }
    exit;
}
?>
<body>

    <div id="wrapper">

        <div id="header">
            <h1><a href="dashboard.php">Book Inventory</a></h1>		

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
                <h1>Purchase Entry</h1>
            </div> <!-- #contentHeader -->	

            <div class="container">
                <?php
                $msg = $_GET['msg'];
                if ($msg === "succ") {
                    ?>
                    <div class="notify notify-success">						
                        <a href="javascript:;" class="close">&times;</a>						
                        <h3>Success Notifty</h3>						
                        <p>Your data successfully created!!!</p>
                    </div>
                <?php } ?>

                <div class="grid-24">

                    <div class="widget">

                        <div class="widget-header">
                            <a href="inv_purchase.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
                            <span class="icon-article"></span>
                            <h3>Add New Purchase Entry</h3>
                        </div> <!-- .widget-header -->
                        <div class="widget-content">
                            <form class="form uniformForm validateForm" method="post" action="" >
                                <?php
                                $bill_result = mysql_query("select * from tc_no where id=9") or die(mysql_error());
                                $bill_row = mysql_fetch_assoc($bill_result);
                                $biil_auto = $bill_row['count'];
                                $billno = "PB" . str_pad($bill_row['count'], 5, '0', STR_PAD_LEFT);
                                ?>
                                <div class="grid-8">  
                                    <div class="widget-content"> 
                                        <div class="field-group">
                                            <label for="required">Receipt No.<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="purchase_no" id="billno" size="32" class="validate[required]" readonly value="<?php echo $billno; ?>"/>	
                                                <input type="hidden" value="<?php echo $biil_auto; ?>" name="bill_autono">

                                            </div>
                                        </div> 
                                    </div>  
                                </div> 
                                <div class="grid-8">  
                                    <div class="widget-content"> 
                                        <div class="field-group">
                                            <label for="required">Receipt Date<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input id="datepicker" name="purchase_date" class="required" type="text" value="<?php echo date("d/m/Y"); ?>" readonly />
                                            </div>
                                        </div> 
                                    </div>  
                                </div> 
                                
                                <div class="grid-8">  
                                    <div class="widget-content"> 
                                        <div class="field-group">		
                                            <label>Agency<span class="error"> * </span>:</label>			
                                            <div class="field">
                                                <?php
                                                $agencyl = "SELECT a_id,a_name FROM agency";
                                                $result = mysql_query($agencyl) or die(mysql_error());
                                                echo '<select name="agency" id="agency" class="required select2"> <option value="">Select Agency </option>';
                                                while ($row = mysql_fetch_assoc($result)):
                                                    echo "<option value='{$row['a_id']}'>{$row['a_name']}</option>\n";
                                                endwhile;
                                                echo '</select>';
                                                ?>      																				
                                            </div>		
                                        </div> <!-- .field-group -->
                                    </div>  
                                </div>



                                <table class="table purchase_item">
                                    <thead>				        
                                        <tr>
                                            <th width="15%">Item Name</th>
                                            <th width="10%">Brand</th>
                                            <th width="10%">Qty</th>
                                            <th width="10%">UOM</th>
                                            <th width="10%">Buying Price</th>
                                            <th width="10%">Selling Price</th>
                                            <th width="10%">Total</th>
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
                                                <td style="width:15% !important;">
                                                    <div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            $itemsql = "SELECT item_id,item_name FROM inv_items where item_status=1 and active=1";
                                                            $result = mysql_query($itemsql) or die(mysql_error());
                                                            echo '<select name="itemname[]" id="itemname' . $i . '" class="select2 required" > <option value="">Select Item </option>';
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
                                                            echo '<select name="brandname[]" id="brandname' . $i . '" class="select2" > <option value="0"> N/A </option>';
                                                            while ($row = mysql_fetch_assoc($result)):
                                                                echo "<option value='{$row['brand_id']}'>{$row['brand_name']}</option>\n";
                                                            endwhile;
                                                            echo '</select>';
                                                            ?>      																				
                                                        </div>		
                                                    </div> <!-- .field-group -->
                                                </td>
                                                <td style="width:10% !important;">
                                                    <div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="qty[]" id="qty<?= $i; ?>" size="15" class="validate[required] text_field"  onkeypress="return isDecimal(event, this);" onkeyup="calc_totalamount(<?= $i; ?>);"/>	
                                                        </div>
                                                    </div> 
                                                </td>
                                                <td style="width:10% !important"> <div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            $agencyl = "SELECT uom_id,uom_name,uom_mode FROM inv_uom where uom_status=1";
                                                            $result = mysql_query($agencyl) or die(mysql_error());

                                                            echo '<select name="uomname[]" id="uomname' . $i . '" class="select2 required" onChange="showUOM_Sub(' . $i . ');"> <option value="" >Select UOM </option>';
                                                            while ($row = mysql_fetch_assoc($result)):
                                                                echo "<option value='{$row['uom_id']}'>{$row['uom_name']}</option>\n";
                                                            endwhile;
                                                            echo '</select>';
                                                            ?>      																				
                                                        </div>	

                                                        <div class="field uom_mode_sub<?= $i; ?>" style="display:none">
                                                            <input type="text" name="uomname_sub[]" id="uomname_sub<?= $i; ?>" size="15" />
                                                            <input type="hidden" name="uomname_modest[]" id="uomname_modest<?= $i; ?>" size="15" />																					
                                                        </div>	
                                                    </div>

                                                </td>
                                                <td style="width:10% !important;"><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="buy_price[]" id="buy_price<?= $i; ?>" size="15" class="validate[required] text_field" onkeyup="calc_totalamount(<?= $i; ?>);" onkeypress="return isDecimal(event, this);" />	
                                                        </div>
                                                    </div> </td>
                                                <td style="width:10% !important"><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="selling_price[]" id="selling_price<?= $i; ?>" size="15" class="validate[required] text_field" onkeypress="return isDecimal(event, this);" />	
                                                        </div>

                                                        <div class="field uom_mode_sub<?= $i; ?>" style="display:none">
                                                            <input type="text" name="selling_price_sub[]" id="selling_price_sub<?= $i; ?>" size="15" />																				
                                                        </div>	

                                                    </div>
                                                </td>
                                                <td style="width:10% !important"><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="total_amt[]" id="total_amt<?= $i; ?>"  class="single_total" size="15" readonly value="0"/>	
                                                        </div>
                                                    </div></td>
                                                <td style="width:5% !important;"> 
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

                                    </tbody>
                                </table>

                                <div id="overall_amount" style="float:right; font-size:14px; font-weight:bold;">Total Amount: <input type="text" name="overall_totamount"  readonly style="border: none; width:20%;font-size:14px; font-weight:bold;" id="overall_totamount"> </div>                         
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
        <style>
            .dfdf img {
                max-width: 100px;
            }
        </style>


        <script>

            function showUOM_Sub(id) {

                var uomname = $("#uomname" + id + " option:selected").val();

                $.get("inv_check_uommode.php", {uomid: uomname}, function(data) {
                    console.log(data);
                    var str = data;
                    if ($.trim(data) == 'Non Fixed') {
                        $(".uom_mode_sub" + id).show();
                        $("#uomname_modest" + id).val(1);

                    } else {
                        $(".uom_mode_sub" + id).hide();
                        $("#uomname_modest" + id).val(0);
                    }
                });

            }

            function calc_totalamount(id) {

                var qty = ($('#qty' + id).val() == "") ? 0 : $('#qty' + id).val();
                var buyprice = ($('#buy_price' + id).val() == "") ? 0 : $('#buy_price' + id).val();


                var total = parseFloat(qty) * parseFloat(buyprice);

                $('#total_amt' + id).val(total);

                calc_total();

            }

            function calc_total() {

                var sum = 0;
                $(".single_total").each(function() {

                    var id_total = $(this).prop('id');

                    sum = parseFloat(sum) + parseFloat($('#' + id_total).val());

                    $('#overall_totamount').val(sum);

                });


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

            function add_table_tr(n) {

                var input = $("#row_item_" + n);
                input.removeAttr("disabled");
                var m = parseFloat(n) + 1;
                $("#row_item_" + n).show();
                $("#addvalue0").attr("onclick", "add_table_tr(" + m + ")");

            }
            function hide_table_tr(n) {


                $("#row_item_" + n).hide();
                $("#qty" + n).val(0);
                $("#amount" + n).val(0);
                $("#total" + n).val(0);
                var input = $("#row_item_" + n);
                input.attr("disabled", "disabled");

            }

        </script>


        <?php
        include("includes/topnav.php");
        ?> <!-- #topNav -->




    </div> <!-- #wrapper -->



    <?php include("includes/footer.php"); ?>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#datepicker").datepicker({
                dateFormat: 'dd/mm/yy'
            });


        });
    </script>
</body>
</html>
<? ob_flush(); ?>