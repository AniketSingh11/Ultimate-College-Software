<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");
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
                <h1>Agency Product List</h1>
            </div> <!-- #contentHeader -->	

            <div class="container">
                <?php
                $msg = $_GET['msg'];
                if ($msg === "dsucc") {
                    ?>
                    <div class="notify notify-success">						
                        <a href="javascript:;" class="close">&times;</a>						
                        <h3>Success Notifty</h3>						
                        <p>Your data successfully Deleted!!!</p>
                    </div>
                <?php
                }

                if ($msg === "succ") {
                    ?>
                    <div class="notify notify-success">						
                        <a href="javascript:;" class="close">&times;</a>						
                        <h3>Success Notifty</h3>						
                        <p>Your data successfully Updated!!!</p>
                    </div>
<?php } ?>


                <div class="grid-24">
                    <div class="grid_12">
                        <div class="widget widget-table">
                            <div class="widget-header">
                                <h1>Select Agency / Item </h1><span></span>
                            </div>
                            <form id="validate-form" class="block-content form" action="" method="get">
                                <div class="_25">
                                    <p style="padding: 25px 10px 0px 10px; width:45%; float:left;">Select Agency : <span class="error">*</span></label>
                                        <?php
                                        $ageny_id = $_GET['agency'];
                                        $agencyl = "SELECT a_id,a_name FROM agency";
                                        $result = mysql_query($agencyl) or die(mysql_error());
                                        echo '<select name="agency" id="agency" class="required select2"> <option value="">Select Agency </option>';
                                        while ($row = mysql_fetch_assoc($result)):
                                            $sel = ($ageny_id == $row['a_id']) ? "Selected" : "";
                                            echo "<option value='{$row['a_id']}' $sel>{$row['a_name']}</option>\n";
                                        endwhile;
                                        echo '</select>';
                                        ?>
                                    </p>

                                    <p style="padding: 25px 10px 0px 10px; width:45%; float:left;">Select Item : <span class="error">*</span></label>
                                        <?php
                                        $item_id = $_GET['item_name'];
                                        $agencyl = "SELECT * FROM inv_items";
                                        $result = mysql_query($agencyl) or die(mysql_error());
                                        $sel_all = ($item_id == 'all') ? "Selected" : "";
                                        echo '<select name="item_name" id="item_name" class="required select2"> <option value="">Select Item </option>';
                                        ?>
                                    <option value="all" <?php echo $sel_all; ?>>All</option>;
                                    <?php
                                    while ($row = mysql_fetch_assoc($result)):
                                        $sel = ($item_id == $row['item_id']) ? "Selected" : "";
                                        echo "<option value='{$row['item_id']}' $sel>{$row['item_name']}</option>\n";
                                    endwhile;
                                    echo '</select>';
                                    ?>
                                    </p>
                                </div>

                                <style>
                                    .widget-header h1 {
                                        margin: 0;
                                        padding: 0;
                                        font-size: 16px;
                                        padding-left: 10px;
                                        line-height: 37px;
                                    }
                                    .select2-container.select2 {
                                        width:none;
                                    }
                                </style>		
                                <div class="block-actions">

                                    <ul class="actions-left">

                                        <li style="list-style:none;"><input type="submit" class="btn btn-success" value="Submit"></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                    <!-- <table class="table table-bordered table-striped data-table">
                                                    <tr>
                                                    <td>
                                                    <div class="select2-container required select2" id="s2id_agency" aria-required="true" style="width: 278px;">
                                                    <select>
<option value="volvo">Volvo</option>
<option value="saab">Saab</option>
<option value="opel">Opel</option>
<option value="audi">Audi</option>
</select>
</div>
                                                    </td>
                                                    <td>
                                                    <button>Submit</button>
                                                    </td>
                                                    </tr>
                                                    </table> -->
                    <?php
                    if ($_GET['agency'] != "") {
                        $itemid = $_GET['item_name'];
                        $qry = mysql_query("SELECT * FROM  inv_items where item_id='$itemid'");
                        $get_item = mysql_fetch_array($qry);
//print_r($get_item);die;
                        ?>
                        <div class="widget widget-table">

                            <div class="widget-header">
                                <!-- <a href="inv_purchase_new.php" style="margin:3px 0 0 20px;"><button class="btn btn-success ">Add New</button></a>-->
                                <span class="icon-list"></span>
                                <h3 class="icon chart">Agency Product List</h3><h3><?php if ($itemid != "all") {
                            echo '-  ' . $get_item['item_name'];
                        }
                        ?></h3>	

                            </div>

                            <div class="widget-content">

                                <table class="table table-bordered table-striped data-table">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <?php
                                            $item_id = $_GET['item_name'];
                                            if ($item_id == 'all') {
                                                ?>
                                                <th>Item Name</th>
    <?php } ?>
                                            <th>Buy Price</th>
                                            <th>Sell Price</th>
                                            <th>Qty</th>
                                            <th>Date</th>
                                            <!--<th>Agency</th>
                                                                             <th>Action</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        $agency_id = $_GET['agency'];
                                        $item_id = $_GET['item_name'];
                                        if ($item_id != "all") {
                                            // echo "SELECT * FROM inv_purchase_parent inner join inv_purchase on inv_purchase_parent.pur_parent_id=inv_purchase.pur_parent_id where inv_purchase_parent.agency_id='$agency_id' and inv_purchase.item_id='$item_id'";die;
                                            $purchase_qry = mysql_query("SELECT * FROM inv_purchase_parent inner join inv_purchase
 on inv_purchase_parent.pur_parent_id=inv_purchase.pur_parent_id where inv_purchase_parent.agency_id='$agency_id' and inv_purchase.item_id='$item_id'");
                                        } else {
                                            $purchase_qry = mysql_query("SELECT * FROM inv_purchase_parent inner join inv_purchase
 on inv_purchase_parent.pur_parent_id=inv_purchase.pur_parent_id where inv_purchase_parent.agency_id='$agency_id'");
                                        }


                                        while ($row = mysql_fetch_array($purchase_qry)) {
                                            $itemid = $row['item_id'];
                                            $qry = mysql_query("SELECT * FROM  inv_items where item_id='$itemid'");
                                            $get_item = mysql_fetch_array($qry);
                                            ?>
                                            <tr class="gradeA">
                                                <td><?php echo $count; ?></td>
                                            <?php
                                            $item_id = $_GET['item_name'];
                                            if ($item_id == 'all') {
                                                ?>
                                                    <td><?php echo $get_item['item_name']; ?></td>
                                                <?php } ?>
                                                <td><?php echo $row['buy_price']; ?></td>
                                                <td><?php echo $row['sell_price']; ?></td>
                                                <td><?php echo $row['qty']; ?></td>
                                                <td><?php echo $row['purchase_date']; ?></td>
                                                 <!-- <td class="action">
                                               <a href="inv_purchase_edit.php?purid=<?php echo $row['pur_id']; ?>" title="Edit"><img src="./images/edit.png" alt="edit"></a> 
                                                 <a href="inv_purchase_view.php?itemid=<?php echo $row['item_id']; ?>" title="View"><img src="./images/detail.png" alt="view"></a>
                                                  
                                                 </td>-->
                                                 <!-- <a href="inv_purchase_delete.php?purid=<?php //echo $row['pur_id'];  ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a>-->
                                            </tr>	
        <?php
        // } 
        $count++;
        //}
    }
    ?>																						
                                    </tbody>
                                </table>
                            </div> <!-- .widget-content -->
                        </div>
<?php } ?>
                </div> <!-- .grid -->			
            </div> <!-- .container -->		
        </div> <!-- #content -->

<?php
include("includes/topnav.php");
?> <!-- #topNav -->

        <!-- .quickNav -->


    </div> <!-- #wrapper -->

<?php include("includes/footer.php"); ?>

</body>
</html>
<? ob_flush(); ?>