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
                <h1>Agency</h1>
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
                            $nid = $_GET['parentid'];
                            
                            $parentlist = mysql_query("SELECT * FROM inv_purchase_parent 
                            left join inv_purchase on (inv_purchase.pur_parent_id=inv_purchase_parent.pur_parent_id) where inv_purchase_parent.pur_parent_id=$nid");
                            //$parent = mysql_fetch_array($parentlist);
                            ?>

                            <a href="inv_agency.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
                            <span class="icon-list"></span>
                            <h3 class="icon chart"><?php echo $itemlist['item_name']; ?></h3>		
                        </div>

                        <div class="widget-content">

                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Item Name</th>
                                        <th>Brand Name</th>
                                        <th>Qty</th>
                                        <th>UOM</th>
                                        <th>Buy Price</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    $count = 1;
                                    while ($row = mysql_fetch_array($parentlist)) {

                                        $iid = $row['item_id'];
                                        $item = mysql_query("SELECT * FROM inv_items WHERE item_id=$iid");
                                        $itemlist = mysql_fetch_array($item);

                                        $uom_id = $row['uom_id'];
                                        $uom = mysql_query("SELECT * FROM inv_uom WHERE uom_id=$uom_id");
                                        $uomlist = mysql_fetch_array($uom);

                                        $brand_id = $row['brand_id'];
                                        $brand = mysql_query("SELECT * FROM inv_brand WHERE brand_id=$brand_id");
                                        $brandlist = mysql_fetch_array($brand);
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $itemlist['item_name']; ?></td>
                                            <td><?php if($brandlist['brand_name']!='') echo $brandlist['brand_name']; else echo 'N/A'; ?></td>
                                            <td><?php echo $row['qty']; ?></td>
                                            <td><?php echo $uomlist['uom_name']; ?></td>
                                            <td><?php echo $row['buy_price']; ?></td>
                                            <td><?php echo $row['total']; ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($row['purchase_date'])); ?></td>
                                            
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