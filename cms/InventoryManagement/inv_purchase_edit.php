<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit'])) {
    $auto_bill = $_POST['bill_autono'];
    $billno = $_POST['purchase_no'];

    $agencyname = $_POST['agency'];
    $overall_tot = $_POST['overall_totamount'];
    $pur_parent_id = $_POST['pur_parent_id'];
    $pur_id = $_POST['pur_id'];

    $adate = str_replace('/', '-', $_POST['purchase_date']);
    $receipt_date = date("Y-m-d", strtotime($adate));

    $result_parent = mysql_query("UPDATE inv_purchase_parent SET purchase_date='$receipt_date',purchase_no='$auto_bill',agency_id='$agencyname',overeall_total='$overall_tot' where pur_parent_id=$pur_parent_id") or die("Could not insert data into DB: " . mysql_error());
    ;

    //$qry=mysql_query("delete from inv_purchase where pur_parent_id='$pur_parent_id'"); 
    if ($result_parent) {

        $result_mat_del = mysql_query("SELECT * from inv_purchase where pur_parent_id='$pur_parent_id' AND pur_id=$pur_id ") or die("Could not fetch inv_material data into DB: " . mysql_error());

        while ($row_mat_del = mysql_fetch_assoc($result_mat_del)) {

            $result_select2 = mysql_query("select * from inv_items where item_id=" . $row_mat_del['item_id']);
            $row_items_select2 = mysql_fetch_assoc($result_select2);

            echo 'Child I delete Loop' . $row_items_select2['item_qty'] . ' + ' . $row_mat_del['qty'] . '<br>';

            //get original qty
            $orig_qty11 = $row_items_select2['item_qty'] - $row_mat_del['qty'];
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
                $brand_qty = $row_brand['qty'] - $row_mat_del['qty'];
                $brand_qty = ($brand_qty < 0) ? "0" : $brand_qty;
                $sql_item_brand = mysql_query("UPDATE inv_brand_items SET qty='$brand_qty' where item_id=" . $row_mat_del['item_id'] . " and brand_id = " . $row_mat_del['brand_id']);
            }
        }

        if ($result2) {
            //delete material
            $qry_del_child = mysql_query("delete from inv_purchase where pur_id=$pur_id ") or die("Could not delete data from DB: " . mysql_error());
            $qry_del_child_uom = mysql_query("delete from inv_purchase_mode where pur_id=$pur_id ") or die("Could not delete data from DB: " . mysql_error());
        }

        for ($i = 0; $i <= 30; $i++) {


            $itemnames = $_POST['itemname'];
            $brandnames = $_POST['brandname'];
            $qtys = $_POST['qty'];
            $oldqtys = $_POST['oldqty'];
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
            $oldqty = $oldqtys[$i];
            $uomname = $uomnames[$i];
            $buyprice = $buyprices[$i];
            $sellprice = $sellprices[$i];
            $totalamt = $totalamts[$i];

            $uomname_sub = $uomname_subs[$i];
            $selling_price_sub = $selling_price_subs[$i];
            $uomname_modest = $uomname_modests[$i];


            if ($totalamt == "" || $totalamt == 0) {
                
            } else {

                $sql = "INSERT INTO inv_purchase (pur_parent_id,item_id,brand_id,uom_id,buy_price,sell_price,qty,total) 
		VALUES('$pur_parent_id','$itemname','$brandname','$uomname','$buyprice','$sellprice','$qty','$totalamt')";

                //$sql = "UPDATE inv_purchase SET pur_parent_id='$pur_parent_id',item_id='$itemname',uom_id='$uomname',buy_price='$buyprice',
                //sell_price='$sellprice',qty='$qty',total='$totalamt' where pur_id=$pur_id";

                $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
                $pur_id1 = mysql_insert_id();
                if ($result) {

                    if ($uomname_sub != "" && $selling_price_sub != "") {

                        $sql_uom = "INSERT INTO inv_purchase_mode (pur_id,uomname_sub,selling_price_sub) VALUES
				('$pur_id1','$uomname_sub','$selling_price_sub')";

                        $result_uom = mysql_query($sql_uom) or die("Could not insert data into DB: " . mysql_error());
                    }
                }
            }

            $result_select = mysql_query("select * from inv_items where item_id=$itemname");
            $row_items_select = mysql_fetch_assoc($result_select);
            //get original qty
            //$orig_qty = $row_items_select['item_qty'] - $oldqty;
            //set total qty
            $tot_qty1 = $row_items_select['item_qty'] + $qty;
            $tot_qty = ($tot_qty1 < 0) ? "0" : $tot_qty1;
            //update total qty
            if ($itemname != "" || $itemname != 0) {
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

    if ($result_parent) {

        header("Location:inv_purchase.php?msg=succ");
    }
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
                        <p>Your data successfully edited!!!</p>
                    </div>
                <?php } ?>

                <div class="grid-24">

                    <div class="widget">

                        <div class="widget-header">
                            <a href="inv_purchase.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
                            <span class="icon-article"></span>
                            <h3>Edit Purchase Entry</h3>
                        </div> <!-- .widget-header -->

                        <div class="widget-content">
                            <?php
                            $nid = $_GET['purid'];

                            $purchaselist = mysql_query("SELECT * FROM inv_purchase WHERE pur_id=$nid");
                            $purchase = mysql_fetch_array($purchaselist);
                            $parentid = $purchase['pur_parent_id'];

                            $parentlist = mysql_query("SELECT * FROM inv_purchase_parent WHERE pur_parent_id=$parentid");
                            $parent = mysql_fetch_array($parentlist);

                            $aid = $parent['agency_id'];

                            $iid = $purchase['item_id'];
                            $uomid = $purchase['uom_id'];

                            $billno = "PB" . str_pad($parent['purchase_no'], 5, '0', STR_PAD_LEFT);
                            ?>
                            <form class="form uniformForm validateForm" method="post" action="" >

                                <div class="grid-8">  
                                    <div class="widget-content"> 
                                        <div class="field-group">
                                            <label for="required">Receipt No.<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="purchase_no" id="billno" size="32" class="validate[required]" readonly value="<?php echo $billno; ?>"/>	
                                                <input type="hidden" value="<?php echo $parent['purchase_no']; ?>" name="bill_autono">

                                            </div>
                                        </div> 
                                    </div>  
                                </div>
                                <div class="grid-8">  
                                    <div class="widget-content"> 
                                        <div class="field-group">
                                            <label for="required">Receipt Date<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input id="datepicker" name="purchase_date" class="required" type="text" value="<?php echo date("d/m/Y", strtotime($parent['purchase_date'])); ?>" readonly />
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
                                                    $sel = ($aid == $row['a_id']) ? "Selected" : "";
                                                    echo "<option value='{$row['a_id']}' $sel>{$row['a_name']}</option>\n";
                                                endwhile;
                                                echo '</select>';
                                                ?>      																				
                                            </div>		
                                        </div> 
                                        <!-- .field-group -->
                                    </div>
                                </div> 
                                <table class="table purchase_item">
                                    <thead>				        
                                        <tr>
                                            <th width="20%">Item Name</th>
                                            <th width="10%">Brand Name</th>
                                            <th width="10%">Qty</th>
                                            <th width="10%">UOM</th>
                                            <th width="10%">Buying Price</th>
                                            <th width="10%">Selling Price</th>
                                            <th width="15%">Total</th>
                                            <th width="5%"></th>
                                        </tr>                              
                                    </thead>					        
                                    <tbody class="dfdf">


                                        <?php
                                        $purchasechild_list = mysql_query("SELECT * FROM inv_purchase 
						  left join inv_purchase_mode on (inv_purchase_mode.pur_id=inv_purchase.pur_id) WHERE inv_purchase.pur_id=$nid");
                                        $i = 0;
                                        while ($row_child = mysql_fetch_array($purchasechild_list)) {
                                            ?> 
                                            <tr id="row_item_<?= $i; ?>" >
                                                <td style="width:20% !important;"><div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            $itemsql = "SELECT item_id,item_name FROM inv_items where item_status=1 and active=1";
                                                            $result = mysql_query($itemsql) or die(mysql_error());
                                                            echo '<select name="itemname[]" id="itemname' . $i . '" class="select2 required"> <option value="">Select Item </option>';
                                                            while ($row = mysql_fetch_assoc($result)):
                                                                $sele = ($row['item_id'] == $row_child['item_id']) ? "Selected" : "";
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
                                                            echo '<select name="brandname[]" id="brandname' . $i . '" class="select2" > <option value="0" selected> N/A </option>';
                                                            while ($row = mysql_fetch_assoc($result)):
                                                                $sele_b = ($row['brand_id'] == $row_child['brand_id']) ? "Selected" : "";
                                                                echo "<option value='{$row['brand_id']}' $sele_b>{$row['brand_name']}</option>\n";
                                                            endwhile;
                                                            echo '</select>';
                                                            ?>      																				
                                                        </div>		
                                                    </div> <!-- .field-group -->
                                                </td>

                                                <td style="width:10% !important;">
                                                    <div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="qty[]" id="qty<?= $i; ?>" size="15" class="validate[required] text_field" value="<?= $row_child['qty']; ?>" onkeypress="return isDecimal(event, this);" onkeyup="calc_totalamount(<?= $i; ?>);"/>	
                                                            <input type="hidden" name="oldqty[]" id="oldqty<?= $i; ?>" class="text_field" value="<?= $row_child['qty']; ?>" />	
                                                        </div>
                                                    </div> 
                                                </td>
                                                <td style="width:10% !important;"> <div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            $agencyl = "SELECT uom_id,uom_name FROM inv_uom where uom_status=1";
                                                            $result = mysql_query($agencyl) or die(mysql_error());
                                                            echo '<select name="uomname[]" id="uomname' . $i . '" class="select2 required" onChange="showUOM_Sub(' . $i . ');"> <option value="">Select UOM </option>';
                                                            while ($row = mysql_fetch_assoc($result)):
                                                                $sel = ($row['uom_id'] == $row_child['uom_id']) ? "Selected" : "";
                                                                echo "<option value='{$row['uom_id']}' $sel>{$row['uom_name']}</option>\n";
                                                            endwhile;
                                                            echo '</select>';

                                                            $result_u = mysql_query("SELECT uom_id,uom_name,uom_mode FROM inv_uom where uom_id=" . $row_child['uom_id']) or die(mysql_error());
                                                            $row_u = mysql_fetch_assoc($result_u);

                                                            if ($row_u['uom_mode'] == 0) {
                                                                $display = 'style="display:none"';
                                                            } else {
                                                                $display = 'style="display:block"';
                                                            }
                                                            ?>      																				
                                                        </div>	

                                                        <div class="field uom_mode_sub<?= $i; ?>" <?= $display; ?>>
                                                            <input type="text" name="uomname_sub[]" id="uomname_sub<?= $i; ?>" class="text_field" size="15" value="<?php echo $row_child['uomname_sub']; ?>" />
                                                            <input type="hidden" name="uomname_modest[]" id="uomname_modest<?= $i; ?>" class="text_field" size="15" />																					
                                                        </div>

                                                    </div> </td>
                                                <td style="width:10% !important;"><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="buy_price[]" id="buy_price<?= $i; ?>" size="15" class="validate[required] text_field" value="<?= $row_child['buy_price']; ?>" onkeyup="calc_totalamount(<?= $i; ?>);" onkeypress="return isDecimal(event, this);" />	
                                                        </div>
                                                    </div> </td>
                                                <td style="width:10% !important;"><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="selling_price[]" id="selling_price<?= $i; ?>" class="validate[required] text_field" size="15" value="<?= $row_child['sell_price']; ?>" onkeypress="return isDecimal(event, this);" />	
                                                        </div>

                                                        <div class="field uom_mode_sub<?= $i; ?>" <?= $display; ?>>
                                                            <input type="text" name="selling_price_sub[]" id="selling_price_sub<?= $i; ?>" class="text_field" size="15" value="<?php echo $row_child['selling_price_sub']; ?>"/>																				
                                                        </div>

                                                    </div></td>
                                                <td style="width:15% !important"><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="total_amt[]" id="total_amt<?= $i; ?>"  class="single_total text_field" value="<?= $row_child['total']; ?>" size="15" readonly />	
                                                        </div>
                                                    </div></td>
                                                <td style="width:5% !important;"> 
                                                    <?php
                                                    if ($i != 0) {
                                                        //   echo '<img onclick="hide_table_tr('.$i.')" src="../img/icons/packs/fugue/16x16/minus-button.png">'; 
                                                    }
                                                    if ($i == 0) {
                                                        //   echo '<a id="addvalue'.$i.'" onclick="add_table_tr('.$i.'+1)" style="cursor:pointer"> <img src="../img/icons/packs/fugue/16x16/plus-button.png" title="Add New"/></a></td>'; 
                                                    }
                                                    ?>

                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        for ($j = $i; $j <= 30; $j++) {
                                            ?>

                                            <tr id="row_item_<?= $j; ?>" <?php
                                            if ($j != 0) {
                                                echo 'style="display: none;"';
                                            }
                                            ?> >
                                                <td><div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            $itemsql = "SELECT item_id,item_name FROM inv_items where item_status=1 and active=1";
                                                            $result = mysql_query($itemsql) or die(mysql_error());
                                                            echo '<select name="itemname[]" id="itemname' . $j . '" class="select2 required"> <option value="">Select Item </option>';
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
                                                            echo '<select name="brandname[]" id="brandname' . $j . '" class="select2" > <option value="0"> N/A </option>';
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
                                                            <input type="text" name="qty[]" id="qty<?= $j; ?>" size="15" class="validate[required] text_field"  onkeypress="return isNumber(event);" onkeyup="calc_totalamount(<?= $j; ?>);"/>	
                                                            <input type="hidden" name="oldqty[]" id="oldqty<?= $j; ?>"  value="0" />	

                                                        </div>
                                                    </div> 
                                                </td>
                                                <td> <div class="field-group">		

                                                        <div class="field">
                                                            <?php
                                                            $agencyl = "SELECT uom_id,uom_name FROM inv_uom where uom_status=1";
                                                            $result = mysql_query($agencyl) or die(mysql_error());
                                                            echo '<select name="uomname[]" id="uomname' . $j . '" class="select2 reuired"> <option value="">Select UOM </option>';
                                                            while ($row = mysql_fetch_assoc($result)):
                                                                echo "<option value='{$row['uom_id']}'>{$row['uom_name']}</option>\n";
                                                            endwhile;
                                                            echo '</select>';
                                                            ?>      																				
                                                        </div>	

                                                        <div class="field uom_mode_sub<?= $j; ?>" style="display:none">
                                                            <input type="text" name="uomname_sub[]" id="uomname_sub<?= $j; ?>" size="15" class="text_field" />
                                                            <input type="hidden" name="uomname_modest[]" id="uomname_modest<?= $j; ?>" size="15" class="text_field" />																					
                                                        </div>

                                                    </div> </td>
                                                <td><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="buy_price[]" id="buy_price<?= $j; ?>" class="validate[required] text_field" size="15"  onkeyup="calc_totalamount(<?= $j; ?>);" onkeypress="return isDecimal(event, this);" />	
                                                        </div>
                                                    </div> </td>
                                                <td><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="selling_price[]" id="selling_price<?= $j; ?>"  class="validate[required] text_field" size="15"  onkeypress="return isDecimal(event, this);" />	
                                                        </div>

                                                        <div class="field uom_mode_sub<?= $j; ?>" style="display:none">
                                                            <input type="text" name="selling_price_sub[]" id="selling_price_sub<?= $j; ?>" size="15" />																				
                                                        </div>

                                                    </div></td>
                                                <td><div class="field-group">

                                                        <div class="field">
                                                            <input type="text" name="total_amt[]" id="total_amt<?= $j; ?>"  class="single_total text_field" size="15" readonly value="0"/>	
                                                        </div>
                                                    </div></td>
                                                <td> 
                                                    <?php
                                                    if ($j != 0) {
                                                        // echo '<img onclick="hide_table_tr('.$j.')" src="../img/icons/packs/fugue/16x16/minus-button.png">'; 
                                                    }
                                                    if ($j == 0) {
                                                        // echo '<a id="addvalue'.$j.'" onclick="add_table_tr('.$j.'+1)" style="cursor:pointer"> <img src="../img/icons/packs/fugue/16x16/plus-button.png" title="Add New"/></a></td>'; 
                                                    }
                                                }
                                                ?>

                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <div id="overall_amount" style="float:right; font-size:14px; font-weight:bold;">Total Amount: <input type="text" name="overall_totamount"  readonly style="border: none; font-size:14px; font-weight:bold;" id="overall_totamount" value="<?php echo $parent['overeall_total']; ?>"> </div>                         
                                <div class="clear"></div>
                                <input type="hidden" name="pur_parent_id" id="pur_parent_id"  value="<?php echo $parentid; ?>" />
                                <input type="hidden" name="pur_id" id="pur_id"  value="<?php echo $nid; ?>" />
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

        <!-- .quickNav -->


    </div> <!-- #wrapper -->

    <?php include("includes/footer.php"); ?>
    <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
    <script type="text/javascript">

                                                                function showUOM_Sub(id) {
                                                                    var uomname = $("#uomname" + id + " option:selected").val();
                                                                    $.get("inv_check_uommode.php", {uomid: uomname}, function(data) {
                                                                        //console.log(data);
                                                                        var str = data;
                                                                        if ($.trim(data) == 'Non Fixed') {
                                                                            $(".uom_mode_sub" + id).show();
                                                                            $("#uomname_modest" + id).val(1);
                                                                        } else {
                                                                            $(".uom_mode_sub" + id).hide();
                                                                            $("#uomname_sub" + id).val("");
                                                                            $("#selling_price_sub" + id).val(0);
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
                                                                    calc_total();
                                                                }
                                                                function hide_table_tr(n) {


                                                                    $("#row_item_" + n).hide();
                                                                    $("#qty" + n).val(0);
                                                                    $("#total_amt" + n).val(0);
                                                                    var input = $("#row_item_" + n);
                                                                    input.attr("disabled", "disabled");
                                                                    calc_total();
                                                                }



                                                                $(document).ready(function() {

                                                                    $("#datepicker").datepicker({
                                                                        dateFormat: 'dd/mm/yy'
                                                                    });
                                                                });

                                                                function showCategory(str) {
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
                                                                        }
                                                                    }
                                                                    xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
                                                                    xmlhttp.send();
                                                                }
    </script>  
</body>
</html>
<? ob_flush(); ?>