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
                <h1>Bill Payment</h1>
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
                            <a href="inv_material_issue_new.php" style="margin:3px 0 0 20px;"><button class="btn btn-success ">Add New</button></a>
                            <span class="icon-list"></span>
                            <h3 class="icon chart"> Material Issue Cheque</h3>		
                        </div>

                        <div class="widget-content">

                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Bill No.</th>
                                        <th>Bill Date</th>
                                        <th>Payment Type</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry = mysql_query("SELECT * FROM inv_material_payment "
                                            . "left join inv_material_parent on (inv_material_parent.mat_parent_id=inv_material_payment.mat_parent_id) where p_type='cheque'"
                                            . "order by inv_material_payment.mat_pay_id desc");
                                    $count = 1;
                                    while ($row = mysql_fetch_array($qry)) {
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $count; ?></td>
                                            <td><?php
                                                $billno = "MI" . str_pad($row['bill_no'], 5, '0', STR_PAD_LEFT);
                                                echo $billno;
                                                ?></td>

                                            <td><?php echo date("d-m-Y", strtotime($row['mat_pay_date'])); ?>
                                            </td>
                                            
                                            <td><?php if($row['p_type']=='cash') echo 'Cash';
                                                        else if($row['p_type']=='card') echo 'Card'; 
                                                        else echo 'Cheque'; ?></td>
                                            <td><?php echo $row['payamount']; ?></td>

                                            <td class="action">
                                                <a href="inv_material_issue_view.php?parentid=<?php echo $row['mat_parent_id']; ?>" title="View">
                                                    <img src="./images/detail.png" alt="view"></a> 
                                                <a href="inv_material_issue_cheque_edit.php?parentid=<?php echo $row['mat_parent_id']; ?>" title="Edit">
                                                    <img src="./images/edit.png" alt="edit"></a> 
                                                <a href="inv_material_issue_print.php?parentid=<?php echo $row['mat_parent_id']; ?>" title="Print" target="_blank">
                                                    <img src="./images/print.png" alt="Print"></a> 
                                                <a href="inv_material_issue_delete.php?parentid=<?php echo $row['mat_parent_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a>
                                            </td>
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