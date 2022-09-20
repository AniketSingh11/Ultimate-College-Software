<?php
$monthno = date("m");
$qry12 = mysql_query("SELECT * FROM month WHERE m_no=$monthno AND ay_id=$acyear");
$monthsw = mysql_fetch_array($qry12);
if ($_SESSION['admin_type'] == "1") {
    $query1 = "select * from  subadmin_accesspage where subadmin_id='$_SESSION[u_id]' and log_type='admin'";
    $res1 = mysql_query($query1);
    $permissions_check = array();
    $permissions_submenu = array();
    while ($row1 = mysql_fetch_array($res1)) {
        if ($row1["sub_menuname"] != "") {
            $submenu = explode(",", $row1["sub_menuname"]);

            foreach ($submenu as $val) {
                array_push($permissions_submenu, $val);
            }
        }
        array_push($permissions_check, $row1["menu_name"]);
    }
}

if ($_SESSION['log_type'] == "staff") {
    $query1 = "select * from  subadmin_accesspage where log_type='$_SESSION[log_type]' and subadmin_id='$_SESSION[stid]'";
    $res1 = mysql_query($query1);
    $permissions_check = array();
    $permissions_submenu = array();
    while ($row1 = mysql_fetch_array($res1)) {
        if ($row1["sub_menuname"] != "") {
            $submenu = explode(",", $row1["sub_menuname"]);

            foreach ($submenu as $val) {
                array_push($permissions_submenu, $val);
            }
        }
        array_push($permissions_check, $row1["menu_name"]);
    }
}



if ($_SESSION['log_type'] == "others") {
    $query1 = "select * from  subadmin_accesspage where log_type='$_SESSION[log_type]' and subadmin_id='$_SESSION[stid]'";
    $res1 = mysql_query($query1);
    $permissions_check = array();
    $permissions_submenu = array();
    while ($row1 = mysql_fetch_array($res1)) {
        if ($row1["sub_menuname"] != "") {
            $submenu = explode(",", $row1["sub_menuname"]);

            foreach ($submenu as $val) {
                array_push($permissions_submenu, $val);
            }
        }
        array_push($permissions_check, $row1["menu_name"]);
    }
}
?>
<nav id="nav">
    <ul class="menu collapsible shadow-bottom">

        <li><a href="dashboard.php"><img src="img/icons/packs/fugue/16x16/dashboard.png">Dashboard</a></li> 
<?php if ($_SESSION['admin_type'] == "0") { ?>
            <li><a href="subadmin_add.php"><img src="img/icons/packs/fugue/16x16/user-silhouette-question.png"> User Permission</a></li>
<?php } if ($_SESSION['admin_type'] == "0" || in_array("Main admissions", $permissions_check)) { ?>
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/umbrella--exclamation.png">Main Admissions <span class="badge gray">5</span></a>
                <ul class="sub">
                    <li><a href="pre_admission.php"><img src="img/icons/packs/fugue/16x16/inbox-image.png">Pre Admission</a></li>
                    <li><a href="pre_admission_select.php"><img src="img/icons/packs/fugue/16x16/inbox-image.png">Pre Admission Selection</a></li>
                    <li><a href="pre_admission_advance.php"><img src="img/icons/packs/fugue/16x16/inbox-image.png">Pre Admission Advance</a></li>
                    <li><a href="admission.php"><img src="img/icons/packs/fugue/16x16/inbox-image.png">Admission</a></li>
                    <li><a href="admission_imp.php"><img src="img/icons/packs/fugue/16x16/inbox-image.png">New Student import</a></li>
                    <li><a href="pre_admission_allocation.php"><img src="img/icons/packs/fugue/16x16/cake--plus.png">Student Allocation</a></li>
                </ul>
            </li>
<?php }
if ($_SESSION['admin_type'] == "0" || in_array("Fees Management", $permissions_check)) {
    ?>
            <!--<li>
                            <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/blog-posterous.png">Fees Management<span class="badge red">7</span></a>
                            <ul class="sub">
                                    <li><a href="billing.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">Fees Payment</a></li>
                    <li><a href="feesinvoice.php"><img src="img/icons/packs/fugue/16x16/calculator--plus.png">Fees Payment Invoice</a></li>
                    <li><a href="cheque_feesinvoice.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">Cheque payment List</a></li>
                    <li><a href="fundinvoice.php"><img src="img/icons/packs/fugue/16x16/hand-share.png">Student Discount Funds</a></li>
                    <li><a href="fdiscount.php"><img src="img/icons/packs/fugue/16x16/burn--plus.png">Discount Category</a></li>
                    <li><a href="fgroup.php"><img src="img/icons/packs/fugue/16x16/category.png">Fees Group</a></li>
                    <li><a href="feesrate.php"><img src="img/icons/packs/fugue/16x16/chart--arrow.png">Fees Rate</a></li>
                    <li><a href="differedinvoice.php"><img src="img/icons/packs/fugue/16x16/abacus.png">Differed Income List</a></li>    								
                 </ul>
                    </li>-->
        <?php }
        if ($_SESSION['admin_type'] == "0" || in_array("Fees Management", $permissions_check)) {
            ?>
            <li>
                <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/blog-posterous.png">Fees Management<span class="badge red">10</span></a>
                <ul class="sub">
                    <li><a href="billing.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">Fees Payment</a></li>
                    <li><a href="feesinvoice.php"><img src="img/icons/packs/fugue/16x16/calculator--plus.png">Fees Payment Invoice</a></li>
                    <li><a href="feesinvoice_reject.php"><img src="img/icons/packs/fugue/16x16/calculator--plus.png">Rejected Fees Invoice</a></li>
                    <li><a href="cheque_feesinvoice.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">Cheque payment List</a></li>
    <?php if ($_SESSION['admin_type'] == "0") { ?>
                        <li><a href="discount_mng.php"><img src="img/icons/packs/fugue/16x16/burn--plus.png">Discount Apply</a></li>
    <?php } ?>
                    <li><a href="ftype.php"><img src="img/icons/packs/fugue/16x16/calendar-blue.png">Fees Type</a></li>
                    <li><a href="fgroup.php"><img src="img/icons/packs/fugue/16x16/category.png">Fees Group</a></li>
                    <li><a href="feesrate.php"><img src="img/icons/packs/fugue/16x16/chart--arrow.png">Fees Rate</a></li>  								
                </ul>
            </li>
            <li>
                    <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/blog-posterous.png">Book Fees Management<span class="badge red">6</span></a>
                    <ul class="sub">
                        <li><a href="billing_others.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">Fees Payment</a></li>
                        <li><a href="feeinvoice_others.php"><img src="img/icons/packs/fugue/16x16/calculator--plus.png">Fees Payment Invoice</a></li>
                        <li><a href="feesinvoice_reject_others.php"><img src="img/icons/packs/fugue/16x16/calculator--plus.png">Rejected Fees Invoice</a></li>
                        <li><a href="cheque_feesinvoice_others.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">Cheque payment List</a></li>
                        <?php if($_SESSION['admin_type']=="0"){?>
                        <li><a href="discount_mng_others.php"><img src="img/icons/packs/fugue/16x16/burn--plus.png">Discount Apply</a></li>
                        <?php } ?>  
                        <li><a href="others.php"><img src="img/icons/packs/fugue/16x16/chart--arrow.png">Fee Settings</a></li>                          
                     </ul>
                </li>
<?php }
                if($_SESSION['admin_type']=="0" || in_array("Fees Reports", $permissions_check)){?>
                                    <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/open-share-document.png">Fees Reports<span class="badge gray">4</span></a>
                                    
                                    <ul class="sub">
                                     <li><a href="mstudent_feesinvoice1.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Student Fees Report</a></li>
                         <li><a href="mstudent_feesinvoice_report.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Fees Invoice Report</a></li>
                         <li><a href="reject_feesinvoice_report.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Reject Fees Invoice Report</a></li>
                          <li><a href="cheque_feesinvoice_report.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Cheque Fees Invoice Report</a></li>
                         
                                  
                                  </ul>
                                    
                                  </li>
                                  <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/open-share-document.png">Book Fees Reports<span class="badge gray">4</span></a>
                                    
                                    <ul class="sub">
                                     <li><a href="mstudent_feesinvoice_others.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Student Book Fees Report</a></li>
                         <li><a href="mstudent_feesinvoice_report_others.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Book Fees Invoice Report</a></li>
                         <li><a href="reject_feesinvoice_report_others.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Reject Book Fees Invoice Report</a></li>
                          <li><a href="cheque_feesinvoice_report_others.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Cheque Book Fees Invoice Report</a></li>
                         
                                  
                                  </ul>
                                    
                                  </li>
                                
                <?php }

if ($_SESSION['admin_type'] == "0" || in_array("Finance", $permissions_check)) {
    ?>
            <li>
                <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/system-monitor-network.png">Finance<span class="badge red">10</span></a>
                <ul class="sub">
                    <li><a href="handcash.php"><img src="img/icons/packs/fugue/16x16/inbox--plus.png">Current HandCash</a></li>
                    <li><a href="income_category.php"><img src="img/icons/packs/fugue/16x16/inbox--plus.png">Income Category</a></li>
                    <li><a href="income_mng.php"><img src="img/icons/packs/fugue/16x16/inbox-document-text.png">Income Management</a></li>
                    <li><a href="agency.php"><img src="img/icons/packs/fugue/16x16/wallet--plus.png">Agency</a></li>
                    <li><a href="agency_advance.php"><img src="img/icons/packs/fugue/16x16/wallet--plus.png">Agency Advance</a></li>
                    <li><a href="agency_advance_cheque.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">Agency Cheque List</a></li>
                    <li><a href="quotation_list.php"><img src="img/icons/packs/fugue/16x16/address-book-open.png">Proposal Management</a></li>
                    <li><a href="exponses_category.php"><img src="img/icons/packs/fugue/16x16/wallet--plus.png">Expenses Category</a></li>
                    <li><a href="exponse_mng.php"><img src="img/icons/packs/fugue/16x16/ticket--pencil.png">Over Expenses Manage</a></li>
                    <li><a href="exponse_mngi.php"><img src="img/icons/packs/fugue/16x16/ticket--pencil.png">Expenses Bill Paid</a></li>
                    <li><a href="exponse_mngi_cheque.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">Expenses Cheque Paid List</a></li>
                    <li><a href="finance_Agency_reports_prt.php" target="_blank"><img src="img/icons/packs/fugue/16x16/ticket--pencil.png">Agencywise Expenses</a></li>
                    <li><a href="finance_category_reports_prt.php" target="_blank"><img src="img/icons/packs/fugue/16x16/ticket--pencil.png">Categorywise Expenses</a></li>
                    <li><a href="finance_reports_prt.php" target="_blank"><img src="img/icons/packs/fugue/16x16/ticket--pencil.png">SubCategorywise Expenses</a></li>
                    <li><a href="bank_account.php"><img src="img/icons/packs/fugue/16x16/wallet--plus.png">Bank Account List</a></li>
                    <li><a href="bdeposit_mng.php"><img src="img/icons/packs/fugue/16x16/ticket--pencil.png">Bank Deposit Manage</a></li>
                    <li><a href="bwithdrawl_mng.php"><img src="img/icons/packs/fugue/16x16/ticket--pencil.png">Bank Withdrawl Manage</a></li>
					<li><a href="deposit_withdraw_report.php"><img src="img/icons/packs/fugue/16x16/ticket--pencil.png">Bank Deposit & Withdrawl Manage</a></li>
                    <li><a href="expense_allowancelist.php"><img src="img/icons/packs/fugue/16x16/user-thief-baldie.png">Daily Allowance List</a></li>
                    <?php if($user=="manager") { ?>
                    <li><a href="cashierreport.php"><img src="img/icons/packs/fugue/16x16/user-thief-baldie.png">Cashier Report</a></li>
                    <?php } ?>
    <?php if ($_SESSION['admin_type'] == "0") { ?>
                        <li><a href="balance_sheet1.php"><img src="img/icons/packs/fugue/16x16/balance--arrow.png">Income & Expense Ledger</a></li>
    <?php } ?>
                    <li><a href="balance_sheet.php"><img src="img/icons/packs/fugue/16x16/balance--arrow.png">Today Income & Expense </a></li>
                </ul>
            </li>
<?php }
if ($_SESSION['admin_type'] == "0" || in_array("Student Management", $permissions_check)) {
    ?>                 
            <li>
                <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/users.png">Student's<span class="badge orange">4</span></a>
                <ul class="sub">
                    <li><a href="student_mng.php"><img src="img/icons/packs/fugue/16x16/users.png">Student Management</a></li>
                    <li><a href="att_mng.php"><img src="img/icons/packs/fugue/16x16/table--minus.png">Student's Attendance Management</a></li>
                    <li><a href="att_mng_today.php"><img src="img/icons/packs/fugue/16x16/table--minus.png">Today Absent List</a></li>
                    <li><a href="student_overall.php"><img src="img/icons/packs/fugue/16x16/cutter--arrow.png">Overall Student's List</a></li>
                    <li><a href="student_inactive.php"><img src="img/icons/packs/fugue/16x16/table--minus.png">Inactive Student List</a></li>
                    <li><a href="student_newlist.php"><img src="img/icons/packs/fugue/16x16/table--minus.png">New Student List</a></li>
                    <li><a href="roll_of_student.php"><img src="img/icons/packs/fugue/16x16/user.png">Roll of Student</a></li>
                    <li><a href="castewise_list.php"><img src="img/icons/packs/fugue/16x16/clipboard-task.png">Castewise Student list</a></li>
                    <li><a href="today_att_student.php"><img src="img/icons/packs/fugue/16x16/clipboard-task.png">Today Student Present</a></li>
                </ul>
            </li>
<?php }
if ($_SESSION['admin_type'] == "0" || in_array("Staff Management", $permissions_check)) {
    ?>  
            <li>
                <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/user-detective.png">Staff Management<span class="badge orange">3</span></a>
                <ul class="sub">
                    <li><a href="staff.php"><img src="img/icons/packs/fugue/16x16/user--arrow.png">Staff Management</a></li>
                    <li><a href="classwise_staff.php"><img src="img/icons/packs/fugue/16x16/clipboard-task.png">Classwise Staff List</a></li>
                    <li><a href="satt_mng.php"><img src="img/icons/packs/fugue/16x16/table-select-cells.png">Staff Attendance Management</a></li>
                    <li><a target="_blank" href="staff_application_2015_2015_06_01_15_33_53_345.pdf"><img src="img/icons/packs/fugue/16x16/cutter--arrow.png">Staff Application Form</a></li>

                </ul>
            </li>
        <?php }
        if ($_SESSION['admin_type'] == "0" || in_array("Others Management", $permissions_check)) {
            ?>
            <li>
                <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/user-detective.png">Other Staff<span class="badge orange">2</span></a>
                <ul class="sub">
                    <li><a href="others_categorylist.php"><img src="img/icons/packs/fugue/16x16/user--arrow.png">Other Staff Category</a></li>
                    <li><a href="others_list.php"><img src="img/icons/packs/fugue/16x16/clipboard-task.png">Other Staff List</a></li>
                    <li><a href="owatt_mng.php"><img src="img/icons/packs/fugue/16x16/table-select-cells.png">Other Staff Attendance</a></li>

                </ul>
            </li>
        <?php }
        if ($_SESSION['admin_type'] == "0" || in_array("Class Timetable Manage", $permissions_check)) {
            ?>     
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/table.png">Class TimeTable Manage<span class="badge orange">4</span></a>
                <ul class="sub">
                    <li><a href="day.php"><img src="img/icons/packs/fugue/16x16/calendar-day.png">Day management</a></li>
                    <li><a href="peroid.php"><img src="img/icons/packs/fugue/16x16/sport-cricket.png">Extra Period management</a></li>
                    <li><a href="timetable_mng.php"><img src="img/icons/packs/fugue/16x16/table-share.png">Time Table</a></li>
                    <li><a href="staff_free_periods.php"><img src="img/icons/packs/fugue/16x16/table-share.png">Staff Free Hours</a></li>
                </ul>
            </li><?php }
        if ($_SESSION['admin_type'] == "0" || in_array("Parent Management", $permissions_check)) {
            ?>
            <li>
                <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/parents.png">Parent's<span class="badge red">2</span></a>
                <ul class="sub">
                    <li><a href="parent_mng.php"><img src="img/icons/packs/fugue/16x16/photo-album--arrow.png">parants Management</a></li>
                    <li><a href="sibling_mng.php"><img src="img/icons/packs/fugue/16x16/users.png">Sibling Management</a></li>
                </ul>
            </li>
        <?php }
        if ($_SESSION['admin_type'] == "0" || in_array("Exam Management", $permissions_check)) {
            ?>
            <li>
                <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/trophy-bronze.png">Exam Management<span class="badge orange">10</span></a>
                <ul class="sub"> 
                    <li><a href="classtest_mng.php"><img src="img/icons/packs/fugue/16x16/pencil-ruler.png">Class Test Assign</a></li>
                    <li><a href="homework_mng.php"><img src="img/icons/packs/fugue/16x16/home--pencil.png">Home Work Assign</a></li>                        <li><a href="exam.php"><img src="img/icons/packs/fugue/16x16/pencil-color.png">Exam List</a></li>
                    <li><a href="examtimetable_mng.php"><img src="img/icons/packs/fugue/16x16/clock.png">Exams time table</a></li>
                    <li><a href="result_mng.php"><img src="img/icons/packs/fugue/16x16/trophy-bronze.png">Add Exam Results</a></li>
                    <li><a href="result_mng1.php"><img src="img/icons/packs/fugue/16x16/sofa--pencil.png">Overall Exam Results</a></li>
                    <li><a href="result_mng_grade.php"><img src="img/icons/packs/fugue/16x16/sofa--pencil.png">Overall Grade Results</a></li>
                    <li><a href="rank_card.php"><img src="img/icons/packs/fugue/16x16/rainbow.png">Progress Card</a></li>
                    <li><a href="rankcard_status.php"><img src="img/icons/packs/fugue/16x16/eye--plus.png">Progress Visit Status</a></li>
                    <li><a href="result_analysis_section.php"><img src="img/icons/packs/fugue/16x16/chart-up-color.png">Exam Results Analysis</a></li>
                    <li><a href="result_analysis_student.php"><img src="img/icons/packs/fugue/16x16/dashboard--plus.png">Studentwise Results Analysis</a></li>
                </ul>
            </li>
<?php }if ($_SESSION['admin_type'] == "0" || in_array("Permission Management", $permissions_check)) { ?>
            <li><a href="permission.php"><img src="img/icons/packs/fugue/16x16/rocket-fly.png">Permission Management</a></li>
<?php }
if ($_SESSION['admin_type'] == "0" || in_array("Certificates", $permissions_check)) {
    ?>
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/certificate.png">Certificates<span class="badge gray">9</span></a>
                <ul class="sub">
                    <li><a href="bonafide.php"><img src="img/icons/packs/fugue/16x16/address-book-open.png">Bonafide Certificate</a></li>
                    <li><a href="community.php"><img src="img/icons/packs/fugue/16x16/color-adjustment-red.png">Community Certificate</a></li>
                    <li><a href="conduct.php"><img src="img/icons/packs/fugue/16x16/direction.png">Conduct Certificate</a></li>
                    <li><a href="c_attend.php"><img src="img/icons/packs/fugue/16x16/alarm-clock-select-remain.png">Attendance Certificate</a></li>
                    <li><a href="board_select_marksheet.php"><img src="img/icons/packs/fugue/16x16/medal-bronze-red.png">Marklist Certificate</a></li>                       
                    <li><a href="board_select_tc11.php"><img src="img/icons/packs/fugue/16x16/monitor-wallpaper.png">Transfer Certificate</a></li>
                    <li><a href="board_select_tc11_kg.php"><img src="img/icons/packs/fugue/16x16/monitor-wallpaper.png">KG Transfer Certificate</a></li>
                    <li><a href="board_select_hallticket.php"><img src="img/icons/packs/fugue/16x16/ticket--arrow.png">Hall Ticket</a></li>
                    <li><a href="certificates_tuitionfees.php"><img src="img/icons/packs/fugue/16x16/money-coin.png">Tuition Fees Certificate</a></li>
                    <li><a href="exp_certificate_list.php"><img src="img/icons/packs/fugue/16x16/user-silhouette-question.png">Experience  Certificate</a></li>
                </ul>
            </li>
<?php }
if ($_SESSION['admin_type'] == "0" || in_array("ID Card", $permissions_check)) {
    ?>
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/card-address.png">ID Card Generator<span class="badge red">4</span></a>
                <ul class="sub">
                    <li><a href="board_select_idcard3.php"><img src="img/icons/packs/fugue/16x16/cards-bind-address.png">Overall ID Cards</a></li>
                    <li><a href="idcard.php"><img src="img/icons/packs/fugue/16x16/cards-address.png">Classwise ID Cards</a></li>
                    <li><a href="idcard_selected.php"><img src="img/icons/packs/fugue/16x16/grid-snap-dot.png">selected Student ID Cards</a></li>
                    <li><a href="idcard_single.php"><img src="img/icons/packs/fugue/16x16/cards-bind-address.png">Single Student ID Card</a></li>

                    <li><a target="_blank" href="staff_idcard_all_prt.php"><img src="img/icons/packs/fugue/16x16/cards-bind-address.png">Staff Overall ID Cards</a></li>
                    <li><a  href="staff_idcard_single.php"><img src="img/icons/packs/fugue/16x16/cards-bind-address.png">Single Staff ID Cards</a></li>        
                    <li><a target="_blank" href="driver_idcard_all_prt.php"><img src="img/icons/packs/fugue/16x16/cards-bind-address.png">Driver Overall ID Cards</a></li>
                    <li><a  href="driver_idcard_single.php"><img src="img/icons/packs/fugue/16x16/cards-bind-address.png">Single Driver ID Cards</a></li>        
                </ul>
            </li>
<?php }
if ($_SESSION['admin_type'] == "0" || in_array("Mobile SMS", $permissions_check)) {
    ?>
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/speaker.png">Mobile SMS Manage<span class="badge red">2</span></a>
                <ul class="sub">
                    <li><a href="sms_mng.php"><img src="img/icons/packs/fugue/16x16/clipboard-task.png">OverAll SMS Management</a></li>
                    <li><a href="sms_specific_mng.php"><img src="img/icons/packs/fugue/16x16/burn--pencil.png">Specific SMS Management</a></li>
                </ul>
            </li>
<?php }
if ($_SESSION['admin_type'] == "0" || in_array("Circular and Events", $permissions_check)) {
    ?>
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/speaker.png">Circular and Events<span class="badge red">3</span></a>
                <ul class="sub">
                    <li><a href="circular.php"><img src="img/icons/packs/fugue/16x16/clipboard-task.png">Circular Management</a></li>
                    <li><a href="event.php"><img src="img/icons/packs/fugue/16x16/burn--pencil.png">Events Management</a></li>
                    <li><a href="news.php"><img src="img/icons/packs/fugue/16x16/newspaper.png">NEWS Management</a></li>
                </ul>
            </li>
<?php }
if ($_SESSION['admin_type'] == "0"  || in_array("Basic Settings", $permissions_check)) {
    ?>
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/remote-control.png">Basic Settings<span class="badge gray">4</span></a>
                <ul class="sub">
                    <li><a href="board.php"><img src="img/icons/packs/fugue/16x16/block.png">Board Settings</a></li>
                    <li><a href="school_edit.php"><img src="img/icons/packs/fugue/16x16/block.png">School Name</a></li>
                    <li><a href="principal.php"><img src="img/icons/packs/fugue/16x16/switch.png">School Principal</a></li>
                    <li><a href="contact_details.php"><img src="img/icons/packs/fugue/16x16/disk--pencil.png">Email and Contacts</a></li>
    <!--<li><a href=""><img src="img/icons/packs/fugue/16x16/acorn.png">Logo settings</a></li>-->
                    <li><a href="year.php"><img src="img/icons/packs/fugue/16x16/calendar-list.png">Academic Year and Month List</a></li>
                </ul>
            </li>
            <?php }
if ($_SESSION['admin_type'] == "0"  || in_array("Letter Head", $permissions_check)) {
    ?>
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/paper-bag--plus.png">Letterhead<span class="badge gray">2</span></a>
                <ul class="sub">
                    <li><a href="letterpad_add.php"><img src="img/icons/packs/fugue/16x16/palette--plus.png">Add Content</a></li>
                    <li><a href="letterpad_list.php"><img src="img/icons/packs/fugue/16x16/paper-bag-recycle.png">Content List</a></li>	
                </ul>
            </li>
<?php }

if ($_SESSION['admin_type'] == "0" || in_array("Standard and Section", $permissions_check)) {
    ?> 
            <li><a href="standard.php"><img src="img/icons/packs/fugue/16x16/solar-panel.png">Standard and Section Management</a></li>
        <?php }
        if ($_SESSION['admin_type'] == "0" || in_array("Subject Management", $permissions_check)) {
            ?>    
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/system-monitor.png">Subject Management<span class="badge orange">4</span></a>
                <ul class="sub">
                    <?php if ($_SESSION['admin_type'] == "0" || (in_array("Subject Management", $permissions_check) && $roll != "Principal")) { ?>
                        <li><a href="subject_mng.php"><img src="img/icons/packs/fugue/16x16/address-book-open.png">Classwise Subject</a></li>
                        <li><a href="subject_mng1.php"><img src="img/icons/packs/fugue/16x16/beaker--plus.png">Staff Assign</a></li>
                    <?php } ?>
                    <li><a href="stafflist.php"><img src="img/icons/packs/fugue/16x16/bamboos.png">Staffwise Assign</a></li>
                    <li><a href="board_select_cstaff.php"><img src="img/icons/packs/fugue/16x16/blog--arrow.png">Classwise Staff</a></li>
                </ul>
            </li><?php }
            if ($_SESSION['admin_type'] == "0" || in_array("Student Promotion", $permissions_check)) {
                    ?>

            <li>               
                <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/users.png">Student's Promotion<span class="badge orange">3</span></a>
                <ul class="sub">
                    <li><a href="promotion_student.php"><img src="img/icons/packs/fugue/16x16/users.png">Student Selected</a></li>
                    <li><a href="promotion_shuffle_student.php"><img src="img/icons/packs/fugue/16x16/users.png">Student Shuffle</a></li> 
                    <li><a href="student_sec_change.php"><img src="img/icons/packs/fugue/16x16/users.png">Student Section Change</a></li>
                </ul>
            </li>
<?php } if ($_SESSION['admin_type'] == "0" || in_array("Syllabus Management", $permissions_check))  { ?>
            <li><a href=""><img src="img/icons/packs/fugue/16x16/clipboard-paste-image.png">Syllabus Management <span class="badge blue">3</span></a>
                <ul class="sub">
                    <li><a href="syllabus.php"><img src="img/icons/packs/fugue/16x16/block.png">Add Syllabus To Class</a></li>
                    <li><a href="syllabus_class.php"><img src="img/icons/packs/fugue/16x16/switch.png">Assign Syllabus to Staff</a></li>
                    <li><a href="#"><img src="img/icons/packs/fugue/16x16/disk--pencil.png">Syllabus Covered</a></li>
                </ul>
            </li>
        <?php }
        if ($_SESSION['admin_type'] == "0" || in_array("Vehicle management", $permissions_check)) {
            ?>
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/traffic-light--arrow.png">Vehicle management<span class="badge gray">10</span></a>
                <ul class="sub">
    <?php if ($_SESSION['admin_type'] == "0" || (in_array("Vehicle management", $permissions_check) && $roll != "Principal")) { ?>
                        <li><a href="busfeesbilling.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">BusFees Payment</a></li><?php } ?>
                    <li><a href="bfeesinvoice.php"><img src="img/icons/packs/fugue/16x16/calculator--plus.png">BusFees Payment Invoice</a></li>
                    <li><a href="bchequeinvoice.php"><img src="img/icons/packs/fugue/16x16/blueprints.png">Cheque payment List</a></li>
                    <li><a href="trstopping.php"><img src="img/icons/packs/fugue/16x16/map.png">Stopping Points</a></li>
                    <li><a href="vehicle.php"><img src="img/icons/packs/fugue/16x16/block.png">Vehicle Master</a></li>
                    <li><a href="driver.php"><img src="img/icons/packs/fugue/16x16/user-thief-baldie.png">Driver details</a></li>
                    <li><a href="datt_mng.php"><img src="img/icons/packs/fugue/16x16/table-select-cells.png">Driver Attendance</a></li>
                    <li><a href="route.php"><img src="img/icons/packs/fugue/16x16/map.png">Route Master</a></li>
                    <li><a href="stopping_mng.php"><img src="img/icons/packs/fugue/16x16/marker--arrow.png">Route stopping Assign</a></li>
                    <li><a href="trbus_feesrate.php"><img src="img/icons/packs/fugue/16x16/target--plus.png">Overall Fees Rate</a></li>
                    <li><a href="bus_feesrate.php"><img src="img/icons/packs/fugue/16x16/target--plus.png">Routewise Fees Rate</a></li>
                    <li><a href="vehicle_capacity.php"><img src="img/icons/packs/fugue/16x16/disk--pencil.png">Bus Capacity Details</a></li>
                    <li><a href="bus_timing.php"><img src="img/icons/packs/fugue/16x16/clock-history-frame.png">Bus Timing</a></li>
                    <li><a href="boarding_point.php"><img src="img/icons/packs/fugue/16x16/point--arrow.png">Staff / Student & boarding points</a></li>
                    <li><a href="bus_att_mng.php"><img src="img/icons/packs/fugue/16x16/clock-history-frame.png">vehicle Student Attendance</a></li>
                    <li><a href="busfees_overall_prt.php"><img src="img/icons/packs/fugue/16x16/truck--arrow.png">Overall Feesrate</a></li>
                </ul>
            </li>
        <?php }

        if ($_SESSION['admin_type'] == "0" || in_array("Vehicle Trip management", $permissions_check)) {
            ?>
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/traffic-light--arrow.png">VehicleTrip management<span class="badge gray">1</span></a>
                <ul class="sub">

                    <li><a href="vehicle_trip.php"><img src="img/icons/packs/fugue/16x16/calculator--plus.png">Vehicle Trip Details</a></li>


    <!--<li><a href="#"><img src="img/icons/packs/fugue/16x16/truck--arrow.png">Day to day bus log</a></li>-->

                </ul>
            </li>
<?php }
if ($_SESSION['admin_type'] == "0" || in_array("Vehile Management", $permissions_check)) {
    ?>
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/traffic-light--exclamation.png">Vehicle Manage Reports<span class="badge gray">9</span></a>
                <ul class="sub">
                    <li><a href="bincome_report.php"><img src="img/icons/packs/fugue/16x16/server-property.png">Bus Fees Income Report</a></li>
                    <li><a href="bincome_frno_report.php"><img src="img/icons/packs/fugue/16x16/receipt-stamp.png">FR.No Based Income Report</a></li>	
                    <li><a href="bpayment_income_report.php"><img src="img/icons/packs/fugue/16x16/plug--exclamation.png">Fees Paid Report</a></li>	
                    <li><a href="buswiseincome_report.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Buswise Fees Income</a></li>	
                    <li><a href="stopwiseincome_report.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Stopwise Fees Income</a></li>	
                    <li><a href="boarding_point.php"><img src="img/icons/packs/fugue/16x16/user-share.png">Buswise Student/Staff  Report</a></li>
                    <li><a href="vehicle_capacity.php"><img src="img/icons/packs/fugue/16x16/sofa--arrow.png">Bus Capcity Detail Report</a></li>
                    <li><a href="boarding_point_att.php"><img src="img/icons/packs/fugue/16x16/sofa--arrow.png">Today Boarding Point List</a></li>
                    <li><a href="boarding_point_att_count.php"><img src="img/icons/packs/fugue/16x16/sofa--arrow.png">Today Boarding Point Count</a></li> 
                    <li><a href="boarding_point_count.php"><img src="img/icons/packs/fugue/16x16/sofa--arrow.png">Boarding Point Total Count</a></li>    				   				
                </ul>
            </li>
<?php }

if ($_SESSION['admin_type'] == "0" || in_array("Import Data", $permissions_check)) {
    ?>
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/drill.png">Import Data<span class="badge gray">5</span></a>
                <ul class="sub">
                                <!--  <li><a href="board_select_stuimp.php"><img src="img/icons/packs/fugue/16x16/users.png">Import Students</a></li>-->
                    <!--<li><a href="">Import Students Photo</a></li>-->
                    <li><a href="board_select_exam.php"><img src="img/icons/packs/fugue/16x16/trophy-bronze.png">Import Student Mark</a></li>
                    <li><a href="board_select_att.php"><img src="img/icons/packs/fugue/16x16/table--minus.png">Import Student Attendance</a></li>
                    <li><a href="staff_importdata.php"><img src="img/icons/packs/fugue/16x16/user-green-female.png">Import Staff</a></li>
                    <li><a href="satt_mng.php"><img src="img/icons/packs/fugue/16x16/xfn-sweetheart-met.png">Import Staff Attendance</a></li>
                    <li><a href="salary_mng.php"><img src="img/icons/packs/fugue/16x16/lifebuoy.png">Import Staff Salary</a></li>
                </ul>
            </li>
        <?php }        if ($_SESSION['admin_type'] == "0" || in_array("Book Inventory", $permissions_check)) {
            ?>
            <li><a href="board_select_book.php"><img src="img/icons/packs/fugue/16x16/books-stack.png">Inventory</a></li>
        <?php }
        if ($_SESSION['admin_type'] == "0" || in_array("Payroll Management", $permissions_check)) {
            ?>
            <li><a href="payroll/dashboard.php" target="_blank"><img src="img/icons/packs/fugue/16x16/paper-plane--plus.png">Payroll Management System</a></li>
        <?php }
        if ($_SESSION['admin_type'] == "0" || in_array("library Management", $permissions_check)) {
            ?>
            <li><a href="library/dashboard.php" target="_blank" ><img src="img/icons/packs/fugue/16x16/books-brown.png">Library Management System</a></li>
<?php }
if ($_SESSION['admin_type'] == "0" || in_array("Hostel Management", $permissions_check)) {
    ?>
            <li><a href="hostel/dashboard.php"><img src="img/icons/packs/fugue/16x16/home-share.png">Hostel Management System</a></li>
        <?php }
        if ($_SESSION['admin_type'] == "0" || in_array("Front Office", $permissions_check)) {
            ?>
            <li><a href=""><img src="img/icons/packs/fugue/16x16/user-thief.png">Front Office Module<span class="badge gray">3</span></a>
                <ul class="sub">
                    <li><a href="visitor.php"><img src="img/icons/packs/fugue/16x16/block.png">visitors Monitoring </a></li>
                    <li><a href="coureirs.php"><img src="img/icons/packs/fugue/16x16/switch.png">couriers/dispatches</a></li>
                    <li><a href="contact_details.php"><img src="img/icons/packs/fugue/16x16/disk--pencil.png">telephone directory</a></li>
                </ul>
            </li>
<?php }
if ($_SESSION['admin_type'] == "0" || in_array("Feedbacks", $permissions_check)) {
    ?>
            <li>
                <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/feed.png">Feedbacks<span class="badge red">4</span></a>
                <ul class="sub">
                    <li><a href="feedback_mng.php"><img src="img/icons/packs/fugue/16x16/node-delete-child.png">parant-Staff Feedbacks</a></li>
                    <li><a href="feedback_mng1.php"><img src="img/icons/packs/fugue/16x16/foaf.png">Staff-Student Feedbacks</a></li>
                    <li><a href="staff_mng_feed.php"><img src="img/icons/packs/fugue/16x16/mail-share.png">Feed Backs From Staff</a></li>
                    <li><a href="student_mng_feed.php"><img src="img/icons/packs/fugue/16x16/geotag-balloon.png">Feed Backs From Parents</a></li>

                </ul>
            </li>
<?php }
if ($_SESSION['admin_type'] == "0") {
    ?>
            <li><a href="todaybirthday.php"><img src="img/icons/packs/fugue/16x16/present--plus.png">Today Birthday</a></li>
<?php }

if ($_SESSION['admin_type'] == "0" || in_array("Finance Report", $permissions_check)) {
    ?>
            <!--<li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/open-share-document.png">Finance Reports<span class="badge gray">6</span></a>
                    <ul class="sub">
                                    <li><a href="income_report.php"><img src="img/icons/packs/fugue/16x16/server-property.png">Fees Income Report</a></li>
                    <li><a href="income_frno_report.php"><img src="img/icons/packs/fugue/16x16/receipt-stamp.png">FR.No Based Income Report</a></li>	
                    <li><a href="payment_income_report.php"><img src="img/icons/packs/fugue/16x16/ui-toolbar--plus.png">Fees Paid Report</a></li>
                    <li><a href="payment_percentageincome_report.php"><img src="img/icons/packs/fugue/16x16/ui-toolbar--plus.png">Fees Paid percentage Report</a></li>	
                    <li><a href="classwise_income_report.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Classwise Fees Income Report</a></li>	
                    <li><a href="studentwise_income_report.php"><img src="img/icons/packs/fugue/16x16/ui-scroll-pane-image.png">Studentwise Fees Income Report</a></li>	
                    <li><a href="differed_income_report.php"><img src="img/icons/packs/fugue/16x16/compass--arrow.png">Differed Income Report</a></li>	
                    <li><a href="exponse_report.php"><img src="img/icons/packs/fugue/16x16/umbrella--arrow.png">Expenses Report</a></li>	
                    <li><a href="incomedatewise_report.php"><img src="img/icons/packs/fugue/16x16/umbrella--arrow.png">Income Report</a></li>    				
                            </ul>
            </li>-->
<?php }

if ($_SESSION['admin_type'] == "0" || in_array("Fees Reports", $permissions_check)) {
    ?>
            
<?php }
if ($_SESSION['admin_type'] == "0" || in_array("Report datas", $permissions_check)) {
    ?>
            <li><a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/report.png">Reports / Export Datas<span class="badge gray">7</span></a>
                <ul class="sub">
                    <li><a href="exp_student_list.php"><img src="img/icons/packs/fugue/16x16/users.png">Students List</a></li>
                    <li><a href="exp_filterstudent_list.php"><img src="img/icons/packs/fugue/16x16/users.png">Filter Students List</a></li>
                    <li><a href="board_select_staff.php"><img src="img/icons/packs/fugue/16x16/user-detective.png">Staff List</a></li>
                    <li><a href="board_select_driver.php"><img src="img/icons/packs/fugue/16x16/user-detective.png">Driver List</a></li>
                    <li><a href="exp_parent_list.php"><img src="img/icons/packs/fugue/16x16/parents.png">Parents List</a></li>
                    <li><a href="exp_student_result.php"><img src="img/icons/packs/fugue/16x16/trophy-bronze.png">Students Mark</a></li>
                    <li><a href="exp_student_att.php"><img src="img/icons/packs/fugue/16x16/table--minus.png">students Attendance</a></li>
                    <li><a href="exp_staff_att.php"><img src="img/icons/packs/fugue/16x16/microformats.png">Staff Attendance</a></li>
                   <!--  <li><a href="salary_mng.php?mid=<?php //echo $monthsw['m_id']; ?>"><img src="img/icons/packs/fugue/16x16/lifebuoy--arrow.png">staff salary</a></li>
                   <li><a href="">staff time table</a></li>-->
                </ul>
            </li>
<?php }

if ($_SESSION['admin_type'] == "0" || in_array("School Calendar", $permissions_check)) {
    ?>

            <li><a href="fullcalendar.php"><img src="img/icons/packs/fugue/16x16/calendar-list.png">School Calendar</a></li> <?php } ?>
<?php if ($_SESSION['admin_type'] == "0" || in_array("Contact Details", $permissions_check)) { ?>
            <li><a href="contact_details.php"><img src="img/icons/packs/fugue/16x16/address-book--arrow.png">Contact Details</a></li> 
<?php } ?>
        <li><a href="logout.php"><img src="img/icons/packs/fugue/16x16/door-open-in.png">logout</a></li>
        <!--<li>
                <a href="javascript:void(0);"><img src="img/icons/packs/fugue/16x16/user-white.png">Example Submenu<span class="badge red">42</span></a>
                <ul class="sub">
                        <li><a href="javascript:void(0);">Lorem ipsum #1</a></li>
                        <li><a href="javascript:void(0);">Lorem ipsum #2</a></li>
                        <li><a href="javascript:void(0);">Lorem ipsum #3</a></li>
                </ul>
        </li>	-->    		
    </ul>
</nav>