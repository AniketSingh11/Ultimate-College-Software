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

                    <div class="widget widget-table">

                        <div class="widget-header">
                            <a href="inv_purchase_new.php" style="margin:3px 0 0 20px;"><button class="btn btn-success ">Add New</button></a>
                            <span class="icon-list"></span>
                            <h3 class="icon chart">Purchase Entry</h3>		
                        </div>

                        <div class="widget-content">

                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Item Name</th>
                                        <th>Qty Sold</th>
                                        <th>Qty Left</th>
                                        <th>UOM</th>
                                        <th>Price</th>
                                        <th>Agency</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry = mysql_query("SELECT * FROM (SELECT * FROM inv_purchase ORDER BY created DESC ) AS tmp_table GROUP BY item_id");
                                    $count = 1;
                                    while ($row = mysql_fetch_array($qry)) {
                                        $parentid = $row['pur_parent_id'];

                                        $purchase_qry = mysql_query("SELECT * FROM inv_purchase_parent where pur_parent_id = $parentid");
                                        $purchase_list = mysql_fetch_array($purchase_qry);

                                        $aid = $purchase_list['agency_id'];
                                        $agency = mysql_query("SELECT * FROM agency WHERE a_id=$aid");
                                        $agencylist = mysql_fetch_array($agency);

                                        $i_id = $row['item_id'];
                                        $item = mysql_query("SELECT * FROM inv_items WHERE item_id=$i_id");
                                        $itemlist = mysql_fetch_array($item);

                                        $uom_id = $row['uom_id'];
                                        $uom = mysql_query("SELECT * FROM inv_uom WHERE uom_id=$uom_id");
                                        $uomlist = mysql_fetch_array($uom);

                                        $material_qry = mysql_query("select *,sum(qty) as Qty from inv_material where item_id=$i_id");
                                        $material_list = mysql_fetch_array($material_qry);

                                        $mat_combo_qry = mysql_query("SELECT *,sum(qty) as Qty FROM inv_material_combo_child 
					left join inv_material_combo_parent on (inv_material_combo_parent.mat_com_id=inv_material_combo_child.mat_com_id) 
					left join inv_combo on (inv_combo.com_parent_id = inv_material_combo_parent.com_parent_id AND package_items = item_id) WHERE item_id=$i_id");
                                        $mat_combo_list = mysql_fetch_array($mat_combo_qry);

                                        $qty_sold = $material_list['Qty'] + $mat_combo_list['Qty'];
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $itemlist['item_name']; ?></td>
                                            <td><?php echo $qty_sold; ?></td>
                                            <td><?php echo $itemlist['item_qty']; ?></td>
                                            <td><?php echo $uomlist['uom_name']; ?></td>
                                            <td><?php echo $row['total']; ?></td>
                                            <td><?php echo $agencylist['a_name']; ?></td>
                                            <td class="action">
                                           <!--<a href="inv_purchase_edit.php?purid=<?php echo $row['pur_id']; ?>" title="Edit"><img src="./images/edit.png" alt="edit"></a> -->
                                                <a href="inv_purchase_view.php?itemid=<?php echo $row['item_id']; ?>" title="View"><img src="./images/detail.png" alt="view"></a>

                                            </td>
                                            <!-- <a href="inv_purchase_delete.php?purid=<?php //echo $row['pur_id'];  ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a>-->
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