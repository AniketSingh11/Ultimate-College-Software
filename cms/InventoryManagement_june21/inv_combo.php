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

                        <div class="widget-header">
                            <a href="inv_combo_new.php" style="margin:3px 0 0 20px;"><button class="btn btn-success ">Add New</button></a>
                            <span class="icon-list"></span>
                            <h3 class="icon chart"> Combo Package</h3>		
                        </div>

                        <div class="widget-content">

                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Combo Package Name</th>
                                        <th>Board</th>
                                        <th>Class Name</th>
                                        <th>Item Count</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry = mysql_query("SELECT *,inv_combo_parent.com_parent_id as parent_id FROM inv_combo_parent 
							left join board on (b_id = board_id) left join class on (c_id = class_id) 
							left join inv_combo on (inv_combo.com_parent_id = inv_combo_parent.com_parent_id) group by inv_combo_parent.com_parent_id");
                                    $count = 1;
                                    while ($row = mysql_fetch_array($qry)) {


                                        if (!empty($row['parent_id'])) {
                                            ?>
                                            <tr class="gradeA">
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $row['package_name']; ?></td>
                                                <td><?php
                                    echo $row['b_name'];
                                            ?>
                                                </td>
                                                <td><?php
                                            if ($row['class_id'] == 0) {
                                                echo 'All';
                                            } else {

                                                echo $row['c_name'];
                                            }
                                            ?>
                                                </td>
                                                <td><?php
                                            $qry2 = mysql_query("SELECT count(com_parent_id) as itemcount FROM inv_combo where inv_combo.com_parent_id =" . $row['parent_id']);
                                            $row_count = mysql_fetch_array($qry2);
                                            echo $row_count['itemcount'];
                                            ?>
                                                </td>

                                                <td class="action">
                                                    <a href="inv_combo_view.php?com_parentid=<?php echo $row['parent_id']; ?>" title="View">
                                                        <img src="./images/detail.png" alt="view"></a> 
                                                    <a href="inv_combo_edit.php?com_parentid=<?php echo $row['parent_id']; ?>" title="Edit">
                                                        <img src="./images/edit.png" alt="edit"></a> 
                                                    <a href="inv_combo_delete.php?com_parentid=<?php echo $row['parent_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a></td>
                                            </tr>	
        <?php
    }
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