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
                            <!-- <a href="inv_purchase_new.php" style="margin:3px 0 0 20px;"><button class="btn btn-success ">Add New</button></a>-->
                            <span class="icon-list"></span>
                            <h3 class="icon chart">Agency</h3>		
                        </div>

                        <div class="widget-content">

                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Agency Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry = mysql_query("SELECT * from inv_purchase_parent");
                                    $count = 1;
                                    while ($row = mysql_fetch_array($qry)) {

                                        $aid = $row['agency_id'];
                                        $agency = mysql_query("SELECT * FROM agency WHERE a_id=$aid");
                                        $agencylist = mysql_fetch_array($agency);

                                        $parenid = $row['pur_parent_id'];
                                        $qty_tot = mysql_query("SELECT sum(qty) as qty FROM inv_purchase WHERE pur_parent_id=$parenid");
                                        $qtylist = mysql_fetch_array($qty_tot);
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $agencylist['a_name']; ?></td>
                                            <td><?php echo $qtylist['qty']; ?></td>
                                            <td><?php echo $row['overeall_total']; ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($row['purchase_date'])); ?></td>
                                            <td class="action">
                                                <a href="inv_agency_view.php?parentid=<?php echo $row['pur_parent_id']; ?>" title="View"><img src="./images/detail.png" alt="view"></a>
                                                <a href="inv_agency_edit.php?parentid=<?php echo $row['pur_parent_id']; ?>" title="Edit"><img src="./images/edit.png" alt="edit"></a> 
                                                 
                                                <a href="inv_agency_print.php?parentid=<?php echo $row['pur_parent_id']; ?>" title="Print" target="_blank"><img src="./images/print.png" alt="print"></a> 
                                                <a href="inv_purchase_delete.php?purid=<?php echo $row['pur_parent_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');">
                                                    <img src="./images/del.png" alt="delete"></a>
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