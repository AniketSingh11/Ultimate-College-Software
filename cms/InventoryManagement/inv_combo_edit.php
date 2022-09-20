<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit'])) {

    $package_name = $_POST['package_name'];
    $boardid = $_POST['boardid'];
    $classid = $_POST['classname'];
    $com_parentid = $_POST['combo_parentid'];


    $result_parent = mysql_query("UPDATE inv_combo_parent SET package_name='$package_name',board_id='$boardid',class_id='$classid' where com_parent_id = '$com_parentid'");

    $qry = mysql_query("delete from inv_combo where com_parent_id='$com_parentid'");

    if ($result_parent) {

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

            if ($itemname == "" || $itemname == 0 || $qty == 0) {
                
            } else {
                $sql = "INSERT INTO inv_combo (com_parent_id,package_items,brand_id,qty,uom_id,uomname_new) VALUES
			('$com_parentid','$itemname','$brandname','$qty','$uomname','$uomname_new')";

                $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
            }
        }
    }
    if ($result) {

        header("Location:inv_combo_edit.php?com_parentid=$com_parentid&msg=succ");
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
                        <p>Your data successfully edited!!!</p>
                    </div>
                <?php } ?>

                <div class="grid-24">

                    <div class="widget">

                        <div class="widget-header">
                            <a href="inv_combo.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
                            <span class="icon-article"></span>
                            <h3>Edit Combo Package</h3>
                        </div> <!-- .widget-header -->
                        <div class="widget-content">

                            <?php
                            $cparentid = $_GET['com_parentid'];

                            $combolist = mysql_query("SELECT * FROM inv_combo_parent 
								  left join board on (b_id = board_id) left join class on (c_id = class_id) 
								  where inv_combo_parent.com_parent_id=$cparentid");
                            $combo = mysql_fetch_array($combolist);

                            $comb_sql = "SELECT * FROM inv_combo_parent right join inv_combo on (inv_combo.com_parent_id = inv_combo_parent.com_parent_id) inner join inv_items on (item_id = package_items and active=1) 
								  where inv_combo_parent.com_parent_id=$cparentid";
                            $combochildlist = mysql_query($comb_sql);


                            $combo_items_array = array();
                            while ($combochild = mysql_fetch_assoc($combochildlist)) {

                                array_push($combo_items_array, $combochild['item_id']);
                            }
                            ?>

                            <form class="form uniformForm validateForm" method="post" action="" >

                                <div class="grid-8">                            
                                    <div class="widget-content"> 	
                                        <div class="field-group">
                                            <label for="input">Combo Package Name <span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="package_name" id="package_name" size="32" class="validate[required]" value="<?php echo $combo['package_name'] ?>"/>	
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
                                                    $sel = "";
                                                    if ($row1['b_id'] == $combo['board_id']) {
                                                        $sel = "Selected";
                                                        $bid = $combo['board_id'];
                                                    }
                                                    echo "<option value='{$row1['b_id']}' $sel>{$row1['b_name']}</option>\n";

                                                endwhile;
                                                echo '</select>';
                                                ?>

                                            </div>
                                        </div>

                                        <div class="field-group">		
                                            <label>Class<span class="error"> * </span>:</label>			
                                            <div class="field">
                                                <select name="classname" id="classname" class="form-control required select2" >

                                                    <?php
                                                    echo $classl = "SELECT c_id,c_name FROM class class where b_id=$bid AND ay_id=$acyear";

                                                    $result = mysql_query($classl) or die(mysql_error());
                                                    echo '<option value="0" Selected>All</option>';
                                                    while ($row = mysql_fetch_assoc($result)):
                                                        $sele = ($row['c_id'] == $combo['class_id']) ? "Selected" : "";
                                                        echo "<option value='{$row['c_id']}' $sele >{$row['c_name']}</option>\n";
                                                    endwhile;
                                                    ?>

                                                </select>

                                            </div>		
                                        </div> <!-- .field-group -->

                                    </div>
                                </div>
                                <table class="table purchase_item">
                                    <thead>				        
                                        <tr>
                                            <th width="15%">Item Name</th>
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

                                        <?php
                                        $combochild_data_result = mysql_query($comb_sql);
                                        $j = 0;


                                        while ($combochild_data = mysql_fetch_assoc($combochild_data_result)) {
                                            ?>
                                            <tr id="row_item_<?= $j; ?>" >
                                                <td><div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            $itemsql = "SELECT item_id,item_name FROM inv_items where item_status=1 and active=1";
                                                            $result = mysql_query($itemsql) or die(mysql_error());
                                                            echo '<select name="itemname[]" id="itemname' . $j . '" class="select2 required" onChange="getBrand(' . $j . ');"> <option value="">Select Item </option>';
                                                            while ($row = mysql_fetch_assoc($result)):
                                                                $sele = ($row['item_id'] == $combochild_data['item_id']) ? "Selected" : "";
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
                                                              $agencyl = "SELECT *,inv_purchase.brand_id as bran_id FROM inv_purchase left join inv_uom on (inv_uom.uom_id = inv_purchase.uom_id) 
	left join inv_items on (inv_items.item_id = inv_purchase.item_id) left join inv_brand on (inv_brand.brand_id=inv_purchase.brand_id) 
        where inv_purchase.item_id= " . $combochild_data['item_id'] . " group by inv_purchase.brand_id
	order by inv_purchase.created desc";
                                                            
                                                            $result = mysql_query($agencyl) or die(mysql_error());
                                                            
                                                            echo '<select name="brandname[]" id="brandname' . $j . '" class="select2" onChange="getItemPrice(' . $j . ');" >';

                                                            while ($row = mysql_fetch_assoc($result)):
                                                                $sele_b = ($row['bran_id'] == $combochild_data['brand_id']) ? "Selected" : "";
                                                                if ($row['bran_id'] == 0) {
                                                                    echo '<option value="0" '.$sele_b.'> N/A </option>\n';
                                                                } else {
                                                                   echo "<option value='{$row['brand_id']}' $sele_b>{$row['brand_name']}</option>\n";
                                                                }
                                                                
                                                                
                                                            endwhile;

                                                            echo '</select>';
                                                            ?>      																				
                                                        </div>		
                                                    </div> <!-- .field-group -->
                                                </td>
                                                <td>
                                                    <div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="qty[]" id="qty<?= $j; ?>" size="15" class="validate[required]" value="<?= $combochild_data['qty']; ?>" onkeypress="return isDecimal(event,this);" onkeyup="calc_totalamount(<?= $j; ?>);"/>	
                                                            <input type="hidden" name="oldqty[]" id="oldqty<?= $j; ?>"  value="<?= $combochild_data['qty']; ?>" />	
                                                        </div>
                                                    </div> 
                                                </td>

                                                <td> 


                                                    <div class="field-group" id="uom_group<?php echo $j; ?>">
                                                        <?php
                                                       // echo $combochild_data['uomname_new'];
                                                        if ($combochild_data['uomname_new'] != "") {
                                                            $purchase = "SELECT * FROM inv_purchase left join inv_uom on (inv_uom.uom_id = inv_purchase.uom_id) 
	left join inv_purchase_mode on (inv_purchase_mode.pur_id=inv_purchase.pur_id) where inv_purchase.item_id= " . $combochild_data['item_id'] . "
	order by inv_purchase.created desc limit 1";

                                                            $result_purchase = mysql_query($purchase) or die(mysql_error());
                                                            $row_purchase = mysql_fetch_assoc($result_purchase);

//	echo json_encode($row);

                                                            if ($row_purchase['uom_mode'] == 0) {
                                                               // echo 'Fixed';
                                                                echo '<label id="uom' . $j . '" > ' . $row_purchase['uom_name'] . ' </label>
              <input type="hidden" name="uomname[]" id="uom_name' . $j . '" value="' . $row_purchase['uom_id'] . '" />
			  <input type="hidden" name="uomname_new[]" id="uom_name' . $j . '" value="" />
			  ';
                                                            } else {
                                                                //non-fixed
                                                                
                                                                if (strpos($combochild_data['uomname_new'], ',0') !== false) {
                                                                    $sel_uom_new = "Selected";
                                                                    $sel_uo = '';
                                                                } else {
                                                                    $sel_uo = "Selected";
                                                                    $sel_uom_new = '';
                                                                }
                                                                echo '
		<input type="hidden" name="uomname[]" id="uom_name' . $j . '" value="' . $row_purchase['uom_id'] . '" />
		<select name="uomname_new[]" id="uomname_new' . $j . '">
		<option value="' . $row_purchase['uom_id'] . '" ' . $sel_uo . ' >' . $row_purchase['uom_name'] . '</option>
		<option value="' . $row_purchase['uom_id'] . ',0" ' . $sel_uom_new . ' >' . $row_purchase['uomname_sub'] . '</option>
		</select>';
                                                            }
                                                        } else {

                                                            $uomsql = "SELECT uom_id,uom_name FROM inv_uom where uom_id=" . $combochild_data['uom_id'];
                                                            $result_uom = mysql_query($uomsql) or die(mysql_error());
                                                            $row_uom = mysql_fetch_assoc($result_uom);
                                                            ?>
                                                            <label id="uom<?php echo $j; ?>" > <?php echo $row_uom['uom_name']; ?></label>
                                                            <input type="hidden" name="uomname[]" id="uom_name<?= $j; ?>" value="<?php echo $row_uom['uom_id']; ?>"/>
                                                        <?php } ?>
                                                    </div>

                                                </td>

                            <!-- <td>
                            <div class="field-group">
                                                                    
                                                                    <div class="field">
                                                                            <input type="text" name="buy_price[]" id="buy_price<?= $j; ?>" size="15" readonly value="<?= $combochild_data['buy_price']; ?>" onkeypress="return isDecimal(event,this);" />	
                                                                    </div>
                                                            </div></td>
                            <td><div class="field-group">
                                                                    
                                                                    <div class="field">
                                                                            <input type="text" name="selling_price[]" id="selling_price<?= $j; ?>" size="15" readonly value="<?= $combochild_data['sell_price']; ?>" onkeypress="return isDecimal(event,this);" />	
                                                                    </div>
                                                            </div></td>
                            <td><div class="field-group">
                                                                    
                                                                    <div class="field">
                                                                            <input type="text" name="total_amt[]" id="total_amt<?= $j; ?>"  class="single_total" value="<?= $combochild_data['total']; ?>" size="15" readonly />	
                                                                    </div>
                                                            </div></td>-->
                                                <td> 
                                                    <?php
                                                    if ($j != 0) {
                                                        echo '<img onclick="hide_table_tr(' . $j . ')" src="../img/icons/packs/fugue/16x16/minus-button.png">';
                                                    }
                                                    if ($j == 0) {
                                                        echo '<a id="addvalue' . $j . '" onclick="add_table_tr(' . ($j + 1) . ')" style="cursor:pointer"> <img src="../img/icons/packs/fugue/16x16/plus-button.png" title="Add New"/></a></td>';
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
                                            ?> >
                                                <td>
                                                    <div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            $itemsql = "SELECT item_id,item_name FROM inv_items where item_status=1 and active=1";
                                                            $result = mysql_query($itemsql) or die(mysql_error());
                                                            echo '<select name="itemname[]" id="itemname' . $i . '" onChange="getBrand(' . $i . ');" class="select2"> <option value="">Select Item </option>';
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
                                                            echo '<select name="brandname[]" id="brandname' . $i . '" class="select2" onChange="getItemPrice(' . $i . ');"> <option value="0" selected> N/A </option>';
                                                            while ($row = mysql_fetch_assoc($result)):

                                                                echo "<option value='{$row['brand_id']}'>{$row['brand_name']}</option>\n";
                                                            endwhile;
                                                            echo '</select>';
                                                            ?>      																				
                                                        </div>		
                                                    </div> <!-- .field-group -->
                                                </td>
                                                <td>
                                                    <div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="qty[]" id="qty<?= $i; ?>" size="15"   onkeypress="return isNumber(event);" onkeyup="calc_totalamount(<?= $i; ?>);"/>	
                                                        </div>
                                                    </div> 
                                                </td>
                                                <td> 

                                                    <div class="field-group" id="uom_group<?php echo $i; ?>">

                            <!--<label id="uom<?php echo $i; ?>" > </label>
                            <input type="hidden" name="uomname[]" id="uom_name<?= $i; ?>" />-->
                                                    </div>

                                                </td>
                                               <!--<td><div class="field-group">
                                                                                           
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

                                <input type="hidden" value="<?php echo $cparentid; ?>" name="combo_parentid" id="combo_parentid">
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

                $.get("inv_show_uom.php", {id: id, itemid: itemid, brandid: brandid}, function(data) {

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
                            console.log(seltext);
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

            //count class row
            var numOfVisibleRows = $('.dfdf tr:visible').length;
            $("#addvalue0").attr("onclick", "add_table_tr(" + numOfVisibleRows + ")");

        });
    </script>
</body>
</html>
<? ob_flush(); ?>