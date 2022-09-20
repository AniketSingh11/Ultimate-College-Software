<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit'])) {

    $package_name = $_POST['package_name'];
    $boardid = $_POST['boardid'];
    $classid = $_POST['classname'];

    $result_parent = mysql_query("INSERT INTO inv_combo_parent (package_name,board_id,class_id) VALUES
		('$package_name','$boardid','$classid')");

    $parentid = mysql_insert_id();

    for ($i = 0; $i <= 30; $i++) {

        $itemnames = $_POST['itemname'];
        $brandnames = $_POST['brandname'];
        $qtys = $_POST['qty'];
        $uomnames = $_POST['uomname'];
        $uomname_news = $_POST['uomname_new'];

        $itemname = $itemnames[$i];
        $brandname = $brandnames[$i];
        $qty = $qtys[$i];
        $uomname = $uomnames[$i];
        $uomname_new = $uomname_news[$i];

    if ($itemname == "" || $itemname == 0 || $qty==0) {
            
        } else {

            $sql = "INSERT INTO inv_combo (com_parent_id,package_items,brand_id,qty,uom_id,uomname_new) VALUES
		('$parentid','$itemname','$brandname','$qty','$uomname','$uomname_new')";

            $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
        }
    }

    if ($result_parent) {

        header("Location:inv_combo_new.php?msg=succ");
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
                <h1>Combo Package</h1>
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
                            <a href="inv_combo.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
                            <span class="icon-article"></span>
                            <h3>Add New Combo Package</h3>
                        </div> <!-- .widget-header -->
                        <div class="widget-content">
                            <form class="form uniformForm validateForm" method="post" action="" >

                                <div class="grid-8"> 
                                    <div class="widget-content"> 	
                                        <div class="field-group">
                                            <label for="input">Combo Package Name <span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="package_name" id="package_name" size="32" class="validate[required]"/>	
                                            </div>
                                        </div>

                                        <div  class="field-group">
                                            <label for="select">Board <span class="error"> * </span>:</label>
                                            <div class="field">
                                                <?php
                                                $classl = "SELECT * FROM board";
                                                $result1 = mysql_query($classl) or die(mysql_error());
                                                echo '<select name="boardid" id="bid"  class="required select2" onChange="getClassDetails();"><option value="">Select Board</option>';
                                                while ($row1 = mysql_fetch_assoc($result1)):

                                                    echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";

                                                endwhile;
                                                echo '</select>';
                                                ?>

                                            </div>
                                        </div>

                                        <div class="field-group">		
                                            <label>Class<span class="error"> * </span>:</label>			
                                            <div class="field">
                                                <select name="classname" id="classname" class="form-control required select2" >
                                                    <option value="0">All</option>
                                                </select>

                                            </div>		
                                        </div> <!-- .field-group -->

                                    </div>  
                                </div>
                                <table class="table purchase_item">
                                    <thead>				        
                                        <tr>
                                            <th width="45%">Item Name</th>
                                            <th width="10%">Brand Name</th>
                                            <th width="10%">Qty</th>
                                            <th width="20%">UOM</th>
                                            <!--<th width="20%">Buying Price</th>
                        <th width="20%">Selling Price</th>
                        <th width="20%">Total</th>-->
                                            <th width="5%"></th>
                                        </tr>                              
                                    </thead>					        
                                    <tbody class="dfdf">


                                        <?php for ($i = 0; $i <= 30; $i++) { ?>

                                            <tr id="row_item_<?= $i; ?>" <?php if ($i != 0) {
                                                echo 'style="display: none;"';
                                            } ?> >
                                                <td><div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            $itemsql = "SELECT item_id,item_name FROM inv_items where item_status=1 and active=1";
                                                            $result = mysql_query($itemsql) or die(mysql_error());
                                                            echo '<select name="itemname[]" id="itemname' . $i . '" class="itemname_class select2 required" onChange="getBrand(' . $i . ');" > <option value="">Select Item </option>';
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
                                                            while ($row = mysql_fetch_assoc($result)):
                                                               // echo "<option value='{$row['brand_id']}'>{$row['brand_name']}</option>\n";
                                                            endwhile;
                                                            echo '</select>';
                                                            ?>      																				
                                                        </div>		
                                                    </div> <!-- .field-group -->
                                                </td>
                                                <td>
                                                    <div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="qty[]" id="qty<?= $i; ?>" size="15" class="qty_class validate[required]" onkeypress="return isDecimal(event,this);" 
                                                                   onkeyup="calc_totalamount(<?= $i; ?>);"/>	
                                                        </div>
                                                    </div> 
                                                </td>
                                                <td> 

                                                    <div class="field-group" id="uom_group<?php echo $i; ?>">

    <!--<label id="uom<?php echo $i; ?>" > </label>
    <input type="hidden" name="uomname[]" id="uom_name<?= $i; ?>" />-->
                                                    </div> 

                                                </td>
                                           <!-- <td><div class="field-group">
                                                                                        
                                                                                        <div class="field">
                                                                                                <input type="text" name="buy_price[]" id="buy_price<?= $i; ?>" size="15" readonly onkeyup="calc_totalamount(<?= $i; ?>);" onkeypress="return isDecimal(event,this);" />	
                                                                                        </div>
                                                                                </div> </td>
                                            <td><div class="field-group">
                                                                                        
                                                                                        <div class="field">
                                                                                                <input type="text" name="selling_price[]" id="selling_price<?= $i; ?>" size="15" readonly onkeypress="return isDecimal(event,this);" />	
                                                                                        </div>
                                                                                </div></td>
                                            <td><div class="field-group">
                                                                                        
                                                                                        <div class="field">
                                                                                                <input type="text" name="total_amt[]" id="total_amt<?= $i; ?>"  class="single_total" size="15" readonly value="0"/>	
                                                                                        </div>
                                                                                </div></td>-->
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

                                    </tbody>
                                </table>


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
            function getBrand(id){
                
                var itemid = $("#itemname" + id + " option:selected").val();

                $.ajax({
                    type: "GET",
                    url: "inv_itembrand_list.php",
                    //dataType: 'json',
                    data: {itemid: itemid},
                    success: function(data) {

                        $("#brandname" + id).html(data);
                        
                       jq('select.select2').select2 ({
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
                    data: {itemid: itemid,brandid:brandid},
                    success: function(data) {

                        $('#qty' + id).val(0);
                        $('#uom' + id).html(data.uom_name);
                        $('#uom_name' + id).val(data.uom_id);


                        showUOM_Sub(id);
                    }

                });

            }

            function showUOM_Sub(id) {
                var itemid = $("#itemname" + id + " option:selected").val();
                var brandid = $("#brandname" + id + " option:selected").val();
                var uomname = $("#uom_name" + id).val();

                $.get("inv_show_uom.php", {id: id, itemid: itemid,brandid:brandid}, function(data) {

                    var str = data;
                    //console.log(data);
                    $("#uom_group" + id).html(data);

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
            function multiselect() {
                if ($("#multiselect").length > 0) {
                    //console.log('clicked');

                    $("#multiselect option:selected").each(function() {
                        var $this = $(this);
                        if ($this.length) {
                            var selval = $this.val();
                            var seltext = $this.text();

                            $("#multiselect_to").append("<option value='" + selval + "'>" + seltext + "</option>");

                            $("#hide_div").append('<input type="hidden" name="selected_items[]" class="sel_items_' + selval + '" value="' + selval + '">');

                            $("#multiselect option[value='" + selval + "']").remove();
                        }
                    });

                }
            }

            function multi_deselect() {
                if ($("#multiselect_to").length > 0) {
                    //console.log('clicked');

                    $("#multiselect_to option:selected").each(function() {
                        var $this = $(this);
                        if ($this.length) {
                            var selval = $this.val();
                            var seltext = $this.text();

                            $("#multiselect").append("<option value='" + selval + "'>" + seltext + "</option>");


                            $("#hide_div .sel_items_" + selval).remove();
                            $("#multiselect_to option[value='" + selval + "']").remove();
                        }
                    });

                }
            }

            function getClassDetails() {

                var selval = $("#bid option:selected").val();

                $.get("inv_class_list.php", {bid: selval}, function(data) {
                    $("#classname").html(data);
                });
            }

        </script>


        <?php
        include("includes/topnav.php");
        ?> <!-- #topNav -->




    </div> <!-- #wrapper -->



<?php include("includes/footer.php"); ?>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#datepicker").datepicker();


            $("#multiselect").click(function() {
                multiselect();
            });

            $("#multiselect_to").click(function() {
                multi_deselect();
            });
            // getClassDetails();
        });
    </script>
</body>
</html>
<? ob_flush(); ?>