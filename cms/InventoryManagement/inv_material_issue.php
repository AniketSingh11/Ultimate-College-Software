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
                <h1>Material Issue</h1>
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
                            <h3 class="icon chart"> Material Issue</h3>		
                        </div>

                        <div class="widget-content">

                            <table class="table table-bordered table-striped data-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Bill No.</th>
                                        <th>Issue Date</th>
                                        <th>Student / Staff</th>
                                        <th>Student Admin No. / Staff Emp No.</th>
                                        <th>Board</th>
                                        <th>Class & Section</th>
                                        <th>Payment Type</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry = mysql_query("SELECT *,inv_material_parent.created as issue_date FROM inv_material_parent 
							left join board on (b_id = board_id) left join class on (c_id = class_id) 
							left join section on (s_id = section_id) order by inv_material_parent.mat_parent_id desc");
                                    $count = 1;
                                    while ($row = mysql_fetch_array($qry)) {
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $count; ?></td>
                                            <td><?php
                                                //$billno = "MI" . str_pad($row['bill_no'], 5, '0', STR_PAD_LEFT);
                                                echo $row['bill_no'];
                                                ?></td>

                                            <td><?php echo date("d-m-Y", strtotime($row['mat_date'])); ?>
                                            </td>
                                            <td><?php echo $st = ($row['stud_staff']) ? "Student" : "Staff"; ?></td>
                                            <td><?php echo $row['adm_emp_no']; ?></td>
                                            <td><?php echo $row['b_name']; ?></td>
                                            <td><?php echo $row['c_name'] . " " . $row['s_name']; ?></td>
                                            
                                            <td><?php 
                                            
                                            //if($row['paid_status']){
                                                $qry_pay = mysql_query("SELECT * FROM inv_material_payment where inv_material_payment.mat_parent_id=".$row['mat_parent_id']);
                                                $row_pay = mysql_fetch_array($qry_pay);
                                                if($row_pay['p_type']=='cash') echo 'Cash';
                                                        else if($row_pay['p_type']=='card') echo 'Card'; 
                                                        else if($row_pay['p_type']=='cheque') echo 'Cheque';
                                            //} ?></td>
                                            <td><?php if($row['paid_status']==0){
                                                echo '<button class="btn btn-warning">Pending</button>';
                                            }else if($row['paid_status']==1){
                                                echo '<button class="btn btn-success ">Paid</button>';
                                                
                                            }else if($row['paid_status']==2){
                                                echo '<button class="btn btn-error ">Rejected</button>';
                                            } ?></td>
                                            <td><?php echo $row['overall_total']; ?></td>

                                            <td class="action">
                                                <a href="inv_material_issue_view.php?parentid=<?php echo $row['mat_parent_id']; ?>" title="View">
                                                    <img src="./images/detail.png" alt="view"></a> 
                                                
                                                <?php //if($row['cat_id']!=0){ ?>
                                                <a href="inv_separate_bill_print.php?parentid=<?php echo $row['mat_parent_id']; ?>" title="Print" target="_blank">
                                                    <img src="./images/print.png" alt="Print"></a> 
                                                <?php //}else{?>
                                                    <!--<a href="inv_material_issue_print.php?parentid=<?php echo $row['mat_parent_id']; ?>" title="Print" target="_blank"><img src="./images/print.png" alt="Print"></a>--> 
                                                <?php //} ?>
                                                 <?php if($row['paid_status']!=2){ ?>
                                                <a href="inv_material_issue_edit.php?parentid=<?php echo $row['mat_parent_id']; ?>" title="Edit">
                                                    <img src="./images/edit.png" alt="edit"></a> 
                                                <a href="inv_material_issue_delete.php?parentid=<?php echo $row['mat_parent_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');">
                                                    <img src="./images/del.png" alt="delete"></a>
                                                 <?php } ?>
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