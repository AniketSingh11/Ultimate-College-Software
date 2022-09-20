<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");
?>
<body>

    <div id="wrapper">

        <div id="header">
            <h1><a href="dashboard.php">Inventory Management</a></h1>		

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
                        <?php
                        $parentid = $_GET['com_parentid'];
                        $qry_p = mysql_query("SELECT * from inv_combo_parent where com_parent_id = " . $parentid);

                        $row_parent = mysql_fetch_array($qry_p);
                        ?>
                        <div class="widget-header">
                            <a href="inv_combo.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
                            <span class="icon-list"></span>
                            <h3 class="icon chart"> <?php echo $row_parent['package_name']; ?></h3>		
                        </div>

                        <div class="widget-content">

                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Item Name</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry = mysql_query("SELECT * from inv_combo left join inv_items on (inv_combo.package_items = inv_items.item_id) where com_parent_id = " . $parentid);
                                    $count = 1;
                                    while ($row = mysql_fetch_array($qry)) {
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $row['item_name']; ?></td>
                                        </tr>	
                                        <?php
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