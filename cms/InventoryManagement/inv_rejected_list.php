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
                <h1>Reports</h1>
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
 <div class="grid_12">
                        <div class="widget widget-table">
                            <div class="widget-header">
                                <h1> Rejected Bill List
</h1><span></span>
                            </div>
                            <form id="validate-form" class="block-content form" action="" method="get">
                                <div class="grid-8">  
                                    <div class="widget-content"> 
                                        <div class="field-group">
                                            <label for="required">Start Date<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input id="datepicker" name="sdate" class="required datepicker" type="text" value="<?php //echo date("d/m/Y");   ?>" readonly />

                                            </div>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="grid-8">  
                                    <div class="widget-content"> 
                                        <div class="field-group">
                                            <label for="required">End Date<span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input id="datepicker1" name="edate" class="required datepicker" type="text" value="<?php //echo date("d/m/Y");   ?>" readonly />

                                            </div>
                                        </div> 
                                    </div> 
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
                                <div class="clear"></div>
                                <div class="block-actions">

                                    <ul class="actions-left">

                                        <li style="list-style:none;"><input type="submit" class="btn btn-success" value="Submit"></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
					<?php
                    $sdate = $_GET['sdate'];
                    $edate = $_GET['edate'];
                    
                    $start = date('Y-m-d',  strtotime(str_replace('/', '-', $_GET['sdate'])));
                    $end = date('Y-m-d',  strtotime(str_replace('/', '-',$_GET['edate'])));
                    
                   
                    if ($sdate && $edate) {
                        
                       $sum_qry = mysql_query("SELECT sum(overall_total) as total FROM inv_material_parent 
							left join board on (b_id = board_id) left join class on (c_id = class_id) 
							left join section on (s_id = section_id) where inv_material_parent.paid_status=2 and 
                                                        mat_date between '$start' and '$end'
                                                        order by inv_material_parent.mat_parent_id desc");
                        $sum_result = mysql_fetch_assoc($sum_qry);
                        
                        $qry = mysql_query("SELECT *,inv_material_parent.created as issue_date FROM inv_material_parent 
							left join board on (b_id = board_id) left join class on (c_id = class_id) 
							left join section on (s_id = section_id) where inv_material_parent.paid_status=2 and 
                                                        mat_date between '$start' and '$end'
                                                        order by inv_material_parent.mat_parent_id desc");
                        ?>
						<br>
						<div class="block-actions">

                            <ul class="actions-left">

                                <li style="list-style:none;">
                                    	<a href="inv_reject_download.php?sdate=<?= $sdate; ?>&edate=<?= $edate; ?>"  class="btn btn-success" >Download Report</a>
									<a href="inv_reject_print.php?sdate=<?= $sdate; ?>&edate=<?= $edate; ?>" target="_blank" class="btn btn-success" >print</a>
									
                                    <div style="float:right;">
                                        <span><img src="../img/icons/packs/fugue/16x16/calendar-next.png"> Start Date : <strong><?= $sdate; ?></strong> | </span> 
                                        <span><img src="../img/icons/packs/fugue/16x16/calendar-next.png"> End Date : <strong><?= $edate; ?></strong> | </span>
                                        <span><img src="../img/icons/packs/fugue/16x16/calculator-scientific.png"> Total : <strong> <?= $sum_result['total'];?> </strong> </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <div class="widget widget-table">

                        <div class="widget-header">
                            <a href="inv_material_issue_new.php" style="margin:3px 0 0 20px;"><button class="btn btn-success ">Add New</button></a>
                            <span class="icon-list"></span>
                            <h3 class="icon chart">Rejected List</h3>		
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
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                 
						/* 	echo "SELECT *,inv_material_parent.created as issue_date FROM inv_material_parent 
							left join board on (b_id = board_id) left join class on (c_id = class_id) 
							left join section on (s_id = section_id) where inv_material_parent.paid_status=2 order by inv_material_parent.mat_parent_id desc";die; */
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
                                            
                                            <td><?php echo $row['overall_total']; ?></td>

                                            <td class="action">
                                                <a href="inv_material_issue_view.php?parentid=<?php echo $row['mat_parent_id']; ?>" title="View">
                                                    <img src="./images/detail.png" alt="view"></a> 
<!--                                                <a href="inv_material_issue_edit.php?parentid=<?php echo $row['mat_parent_id']; ?>" title="Edit">
                                                    <img src="./images/edit.png" alt="edit"></a> -->
                                                <?php //if($row['cat_id']!=0){ ?>
                                                <a href="inv_separate_bill_print.php?parentid=<?php echo $row['mat_parent_id']; ?>" title="Print" target="_blank">
                                                    <img src="./images/print.png" alt="Print"></a> 
                                                <?php //}else{?>
                                                    <!--<a href="inv_material_issue_print.php?parentid=<?php echo $row['mat_parent_id']; ?>" title="Print" target="_blank"><img src="./images/print.png" alt="Print"></a>--> 
                                                <?php //} ?>
                                                <!--<a href="inv_material_issue_delete.php?parentid=<?php echo $row['mat_parent_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./images/del.png" alt="delete"></a>-->
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
 <script type="text/javascript">
        $(document).ready(function() {
            $(".datepicker").datepicker({
                dateFormat: 'dd/mm/yy'
            });
        });
    </script>
</body>
</html>
<? ob_flush(); ?>