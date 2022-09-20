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
                <h1>Purchase Entry</h1>
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
                <?php } ?>

                <div class="grid-24">

                    <div class="widget widget-table">

                        <div class="widget-header">

                            <?php
                            $i_id = $_GET['itemid'];

                            $item = mysql_query("SELECT * FROM inv_items WHERE item_id=$i_id");
                            $itemlist = mysql_fetch_array($item);
                            ?>

                            <a href="inv_purchase.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
                            <span class="icon-list"></span>
                            <h3 class="icon chart"><?php echo $itemlist['item_name']; ?></h3>		
                        </div>

                        <div class="widget-content">

                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Brand Name</th>
                                        <th>Qty</th>
                                        <th>UOM</th>
                                        <th>Price</th>
                                        <th>Agency</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry = mysql_query("SELECT * FROM inv_purchase where item_id = $i_id");
                                    $count = 1;
                                    while ($row = mysql_fetch_array($qry)) {

                                        $parentid = $row['pur_parent_id'];
                                        $purchase_qry = mysql_query("SELECT * FROM inv_purchase_parent where pur_parent_id = $parentid");
                                        $purchase_list = mysql_fetch_array($purchase_qry);

                                        $aid = $purchase_list['agency_id'];
                                        $agency = mysql_query("SELECT * FROM agency WHERE a_id=$aid");
                                        $agencylist = mysql_fetch_array($agency);



                                        $uom_id = $row['uom_id'];
                                        $uom = mysql_query("SELECT * FROM inv_uom WHERE uom_id=$uom_id");
                                        $uomlist = mysql_fetch_array($uom);

                                        $brand_id = $row['brand_id'];
                                        $brand = mysql_query("SELECT * FROM inv_brand WHERE brand_id=$brand_id");
                                        $brandlist = mysql_fetch_array($brand);
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $count; ?></td>
                                            <td><?php if($brandlist['brand_name']!='') echo $brandlist['brand_name']; else echo 'N/A'; ?></td>
                                            <td><?php echo $row['qty']; ?></td>
                                            <td><?php echo $uomlist['uom_name']; ?></td>
                                            <td><?php echo $row['total']; ?></td>
                                            <td><?php echo $agencylist['a_name']; ?></td>
                                            <td class="action">
                                                <a href="inv_purchase_edit.php?purid=<?php echo $row['pur_id']; ?>" title="Edit"><img src="./images/edit.png" alt="edit"></a>
                                                <a href="inv_purchase_delete.php?purid=<?php echo $row['pur_id']; ?>&from=purchase" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a>
                                            </td>
                                        </tr>	
    <?php
    // } } 
    $count++;
}
?>																						
                                </tbody>
                            </table>
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

</body>
</html>
<? ob_flush(); ?>