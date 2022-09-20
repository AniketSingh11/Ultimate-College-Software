<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php");
//echo $_SESSION['uname'];
$ss_id = $_GET['ssid'];
$ssid = $ss_id;

$action = $_GET["action"];
if ($action == "export") {
    $csv_content = "School/College Management Solution\n";
    $csv_content = $csv_content . "S.No.,Admission No.,Student Name,Class Name,1st Term Fees,1st Term Paid,1st Term Pending,2nd Term Fees,2nd Term Paid,2nd Term Pending,3rd Term Fees,3rd Term Paid,3rd Term Pending,Other Fees,Other Paid,Other Pending\n";
}
?>
</head>
<body id="top">
    <!-- Begin of #container -->
    <div id="container">
        <!-- Begin of #header -->
        <?php include("includes/header.php"); ?>
        <!--! end of #header -->

        <div class="fix-shadow-bottom-height"></div>

        <!-- Begin of Sidebar -->
        <aside id="sidebar">
            <!-- Search -->
            <?php include("includes/search.php"); ?>
            <!--! end of #search-bar -->

            <!-- Begin of #login-details -->
            <?php include("includes/login-details.php"); ?>
            <!--! end of #login-details -->

            <!-- Begin of Navigation -->
            <?php include("nav.php"); ?>
            <!--! end of #nav -->

        </aside> <!--! end of #sidebar -->

        <!-- Begin of #main -->
        <div id="main" role="main">
            <?php
            $bid = $_GET['bid'];
            if (!$bid) {
                $boardlist1 = mysql_query("SELECT * FROM board");
                $board1 = mysql_fetch_array($boardlist1);
                $bid = $board1['b_id'];
            }
            $boardlist = mysql_query("SELECT * FROM board WHERE b_id=$bid");
            $board = mysql_fetch_array($boardlist);
            $cid = $_GET['cid'];
            $sid = $_GET['sid'];
            $sid = $_GET['sid'];
            $ddlterm = $_GET["ddlterm"];
            $feesub = $_GET["fees_sub"];
            //$order_gender = $_GET["order_gender"];
            if ($cid && $sid) {
                $classlist = mysql_query("SELECT * FROM class WHERE c_id=$cid");
                $class = mysql_fetch_array($classlist);
                $sectionlist = mysql_query("SELECT * FROM section WHERE s_id=$sid");
                $section = mysql_fetch_array($sectionlist);
                //echo $class['c_name']."-".$section['s_name'];
            }
            ?>
            <!-- Begin of titlebar/breadcrumbs -->
            <div id="title-bar">
                <ul id="breadcrumbs">
                    <li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                    <li class="no-hover"><a   title="<?php echo $board['b_name']; ?>"><?php echo $board['b_name']; ?></a></li>
                    <li class="no-hover">Fees Report</li>
                </ul>
            </div> <!--! end of #title-bar -->
            <div class="shadow-bottom shadow-titlebar"></div>	 
            <!-- Begin of #main-content -->
            <div id="main-content">
                <div class="container_12">

                    <a href="board_select_stu.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                    <span style="margin-left:20px;"><a href="mstudent_feesinvoice_download1.php?cid=<?= $cid; ?>&sid=<?= $sid ?>&bid=<?= $bid ?>&order_gender=<?= $order_gender ?>&fees_sub=<?= $feesub ?>&ddlterm=<?= $ddlterm ?>" style ="width:100px"><button class="btn btn-small btn-green"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Report</button></a></span> 
                    <span style="margin-left:20px;"><a href="mstudent_feesinvoice_download1_print.php?cid=<?= $cid; ?>&sid=<?= $sid ?>&bid=<?= $bid ?>&order_gender=<?= $order_gender ?>&fees_sub=<?= $feesub ?>&ddlterm=<?= $ddlterm ?>" style ="width:100px" target="_blank"><button class="btn btn-small btn-green"><img src="img/icons/packs/fugue/16x16/inbox-download.png">Print</button></a></span> 
                    <div class="_25" style="float:right">


                        <label for="select">Board :</label>
                        <?php
                        $classl = "SELECT * FROM board";
                        $result1 = mysql_query($classl) or die(mysql_error());
                        echo '<select name="bid" id="bid" class="required" onchange="change_function()">';
                        while ($row1 = mysql_fetch_assoc($result1)):
                            if ($bid == $row1['b_id']) {
                                echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
                            } else {
                                echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
                            }
                        endwhile;
                        echo '</select>';
                        ?>
                        </select>
                    </div>
                    <div class="grid_12">
                        <div class="block-border">
                            <div class="block-header">
                                <h1>Select Standard and Section/Group</h1><span></span>
                            </div>
                            <form id="validate-form" class="block-content form" action="" method="get" action="mstudent_feesinvoice.php">
                                <div class="_50">
                                    <p>
                                        <label for="select">Standard : <span class="error">*</span></label>
                                        <?php
                                        $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id='" . $acyear . "'";
                                        $result1 = mysql_query($classl) or die(mysql_error());
                                        echo '<select name="cid" id="cid" class="required" onchange="showCategory(this.value)"> <option value="">Select Class</option>';
                                        echo "<option value='all'>All</option>";
                                        while ($row1 = mysql_fetch_assoc($result1)):
                                            echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
                                        endwhile;
                                        echo '</select>';
                                        ?>
                                        </select>
                                    </p>
                                </div>
                                <div class="_50">
                                    <p>
                                        <label for="select">Section / Group : <span class="error">*</span></label>
                                        <select name="sid" id="sid" class="required">
                                            <option value="">Please select</option>

                                        </select>
                                    </p>
                                </div>
                                <div class="_50">
                                    <p>
                                        <label for="select">Fees Type : <span class="error">*</span></label>
                                        <select name="ddlterm" id="ddlterm" class="required">
                                            <option value="all">All</option>	
                                            <option value="1">1st Term Fees Only</option>
                                            <option value="2">2nd Term Fees Only</option>											
                                            <option value="3">3rd Term Fees Only</option>	
                                            <?php
                                            $otherfees_qry = "SELECT * FROM fgroup_detail where fg_id='4' AND otherfees='0'";
                                            $qry = mysql_query($otherfees_qry);
                                            while ($row = mysql_fetch_array($qry)) {
                                                ?>
                                                <option value="4<?= $row['fgd_id']; ?>"><?= $row['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </p>
                                </div>
                                <div class="_50">
                                    <p>
                                        <label for="select">Fees Sub Type : <span class="error">*</span></label>
                                        <select name="fees_sub" id="fees_sub" class="required">
                                            <option value="all">All</option>	
                                            <option value="1">Fees</option>
                                            <option value="2">Paid</option>											
                                            <option value="3">Pending</option>	
                                        </select>
                                    </p>
                                </div>

<!-- <div><p><a href='mstudent_feesinvoice.php?action=export'>Export Student</a> </p>  </div> -->
                                <div class="clear"></div>
                                <div class="block-actions">
                                    <ul class="actions-left">
                                        <li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
                                    </ul>
                                    <ul class="actions-left">
                                        <input type="hidden" class="medium" name="bid" value="<?php echo $bid; ?>" >
                                        <li><input type="submit" class="button" value="Submit"></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div	>
                    <?php
                    $cid = $_GET['cid'];
                    $sid = $_GET['sid'];
                    $sid = $_GET['sid'];
                    $ddlterm = $_GET["ddlterm"];
                    $feesub = $_GET["fees_sub"];
                    if ($cid && $sid) {
                        $classlist = mysql_query("SELECT * FROM class WHERE c_id=$cid");
                        $class = mysql_fetch_array($classlist);
                        $sectionlist = mysql_query("SELECT * FROM section WHERE s_id=$sid");
                        $section = mysql_fetch_array($sectionlist);
                        //echo $class['c_name']."-".$section['s_name'];
                    }
                    ?>
                    <div class="grid_12">
                        <div class="block-border">
                            <div class="block-header">
                                <h1><?php echo $class['c_name'] . "-" . $section['s_name']; ?> Student List</h1>                        
                                <span></span>
                            </div>
                            <div class="block-content">
                                <table id="table-example" class="table">
                                    <thead>
                                        <tr><th rowspan='2'>S.No.</th>
                                            <th rowspan='2'>Admission No.</th>
                                            <th rowspan='2'>Student Name</th>
                                            <th rowspan='2'>Class Name</th>
                                            <th rowspan='2'>Student Type</th>
                                            <th rowspan='2'>Student Phone no</th>
                                            <?php
                                            if ($ddlterm == "1") {
                                                ?>
                                                <th colspan='3'>Ist Term Fees</th>
                                            </tr>
                                            <tr>
                                                <?php
                                                if ($feesub == 1) {

                                                    echo '<th>Fees</th>';
                                                } else if ($feesub == 2) {

                                                    echo '<th colspan="1">Fees</th><th>Paid</th>';
                                                } else if ($feesub == 3) {

                                                    echo '<th colspan="1">Fees</th><th>Pending</th>';
                                                } else {

                                                    echo '<th>Fees</th><th>Paid</th><th>Pending</th>';
                                                }
                                                ?>

                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($ddlterm == "2") {
                                            ?>
                                        <th colspan='3'>2nd Term Fees</th>
                                        </tr>
                                        <tr>
                                            <?php
                                            if ($feesub == 1) {

                                                echo '<th>Fees</th>';
                                            } else if ($feesub == 2) {

                                                echo '<th colspan="1">Fees</th><th>Paid</th>';
                                            } else if ($feesub == 3) {

                                                echo '<th colspan="1">Fees</th><th>Pending</th>';
                                            } else {

                                                echo '<th>Fees</th><th>Paid</th><th>Pending</th>';
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($ddlterm == "3") {
                                        ?>
                                        <th colspan='3'>3rd  Term Fees</th>
                                        </tr>
                                        <tr>
                                            <?php
                                            if ($feesub == 1) {

                                                echo '<th>Fees</th>';
                                            } else if ($feesub == 2) {

                                                echo '<th colspan="1">Fees</th><th>Paid</th>';
                                            } else if ($feesub == 3) {

                                                echo '<th colspan="1">Fees</th><th>Pending</th>';
                                            } else {

                                                echo '<th>Fees</th><th>Paid</th><th>Pending</th>';
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    //other sub
                                    $qry_others = mysql_query($otherfees_qry);
                                    while ($row_other = mysql_fetch_array($qry_others)) {
                                        $fees_otherid = '4' . $row_other['fgd_id'];
                                        if ($fees_otherid == $ddlterm) {
                                            ?>       
                                            <th colspan='3'><?php echo $row_other['name']; ?></th>
                                            </tr>   
                                            <tr>
                                                <?php
                                                if ($feesub == 1) {

                                                    echo '<th>Fees</th>';
                                                } else if ($feesub == 2) {

                                                    echo '<th colspan="1">Fees</th><th>Paid</th>';
                                                } else if ($feesub == 3) {

                                                    echo '<th colspan="1">Fees</th><th>Pending</th>';
                                                } else {

                                                    echo '<th>Fees</th><th>Paid</th><th>Pending</th>';
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <?php
                                    if ($ddlterm == "all") {

                                        //Ist term
                                        if ($feesub == 1) {

                                            $colspan = '';
                                        } else if ($feesub == 2) {

                                            $colspan = 'colspan="2"';
                                        } else if ($feesub == 3) {

                                            $colspan = 'colspan="2"';
                                        } else {

                                            $colspan = 'colspan="3"';
                                        }
                                        ?>



                                        <th <?= $colspan; ?>>Ist Term Fees</th>
                                        <th <?= $colspan; ?>>2nd Term Fees</th>
                                        <th <?= $colspan; ?>>3rd  Term Fees</th>


                                        <?php
                                        $qry_others_th = mysql_query($otherfees_qry);
                                        while ($row_other_th = mysql_fetch_array($qry_others_th)) {
                                            ?>       
                                            <th <?= $colspan; ?>><?php echo $row_other_th['name']; ?></th>
                                        <?php } ?>
                                        <th <?= $colspan; ?>>Total Fees</th>
                                        </tr>

                                        <tr>

                                            <?php
                                            //Ist term
                                            if ($feesub == 1) {

                                                echo '<th>Fees</th>';
                                            } else if ($feesub == 2) {

                                                echo '<th>Fees</th><th>Paid</th>';
                                            } else if ($feesub == 3) {

                                                echo '<th>Fees</th><th>Pending</th>';
                                            } else {

                                                echo '<th>Fees</th><th>Paid</th><th>Pending</th>';
                                            }
                                            ?>

                                            <?php
                                            //IInd term
                                            if ($feesub == 1) {

                                                echo '<th>Fees</th>';
                                            } else if ($feesub == 2) {

                                                echo '<th>Fees</th><th>Paid</th>';
                                            } else if ($feesub == 3) {

                                                echo '<th>Fees</th><th>Pending</th>';
                                            } else {

                                                echo '<th>Fees</th><th>Paid</th><th>Pending</th>';
                                            }
                                            ?>

                                            <?php
                                            //IIIrd term
                                            if ($feesub == 1) {

                                                echo '<th>Fees</th>';
                                            } else if ($feesub == 2) {

                                                echo '<th>Fees</th><th>Paid</th>';
                                            } else if ($feesub == 3) {

                                                echo '<th>Fees</th><th>Pending</th>';
                                            } else {

                                                echo '<th>Fees</th><th>Paid</th><th>Pending</th>';
                                            }
                                            ?>

                                            <?php
                                            //other sub fees
                                            $qry_others_su = mysql_query($otherfees_qry);
                                            while ($row_other_sub = mysql_fetch_array($qry_others_su)) {

                                                if ($feesub == 1) {

                                                    echo '<th>Fees</th>';
                                                } else if ($feesub == 2) {

                                                    echo '<th>Fees</th><th>Paid</th>';
                                                } else if ($feesub == 3) {

                                                    echo '<th>Fees</th><th>Pending</th>';
                                                } else {

                                                    echo '<th>Fees</th><th>Paid</th><th>Pending</th>';
                                                }
                                                ?>

                                                <?php
                                            }
                                            //total fees
                                            if ($feesub == 1) {

                                                echo '<th>Fees</th>';
                                            } else if ($feesub == 2) {

                                                echo '<th>Fees</th><th>Paid</th>';
                                            } else if ($feesub == 3) {

                                                echo '<th>Fees</th><th>Pending</th>';
                                            } else {

                                                echo '<th>Fees</th><th>Paid</th><th>Pending</th>';
                                            }
                                            ?>


                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </thead>
                                    <tbody>
                                        <?php
                                        $cid = $_GET["cid"];
                                        $sid = $_GET["sid"];
                                        $qry = "SELECT s.firstname,s.admission_number,s.ss_id,c.c_name,c.c_id,s.stype,phone_number FROM student AS s 
                                                INNER JOIN class AS c on c.c_id=s.c_id AND c.ay_id=s.ay_id AND s.b_id=c.b_id WHERE s.ay_id='" . $acyear . "' AND user_status='1' ";
                                        if ($cid != "all") {
                                            $qry = $qry . "	AND s.c_id='" . $cid . "'";
                                        }
                                        if ($sid != "all" && $sid != "Old") {
                                            $qry = $qry . "  AND s.s_id='" . $sid . "'";
                                        }
                                        if ($sid == "Old") {
                                            $qry = $qry . "  AND s.s_id!=0";
                                        }
                                        $qry = $qry . " AND s.b_id='" . $bid . "' ORDER BY s.c_id ASC";
                                        // echo $qry;
                                        // die;
                                        $result = mysql_query($qry);
                                        $cnt = 0;
                                        while ($rs = mysql_fetch_assoc($result)) {
                                            $cnt+=1;
                                            //getting the total fees for a student 
                                            $qry1 = "SELECT fg.fg_id,fg.fg_name,fgd.type,fr.ay_id,fr.c_id,sum(rate) as rate FROM fgroup AS fg 
                                                   INNER JOIN fgroup_detail AS fgd  ON fgd.fg_id=fg.fg_id  
                                                   INNER JOIN frate AS fr ON fr.fg_id=fg.fg_id 
                                                    GROUP BY fg.fg_id,fgd.type,fr.c_id,fr.ay_id  having fr.ay_id='" . $acyear . "'
                                                    AND fr.c_id='" . $rs["c_id"] . "'";
                                            //echo $qry1;
                                            $qry1 = "SELECT fg_id,ay_id,c_id,sum(rate) as rate from frate AS fr "
                                                    . "group by  fg_id,ay_id,c_id having fr.ay_id='" . $acyear . "' "
                                                    . "AND fr.c_id='" . $rs["c_id"] . "'";
                                            $result1 = mysql_query($qry1);
                                            $t1_fees = 0;
                                            $t2_fees = 0;
                                            $t3_fees = 0;
                                            $other_fees = 0;
                                            while ($rs1 = mysql_fetch_assoc($result1)) {
                                                if ($rs['stype'] == "New" && $rs1['type'] == "1")
                                                    $fees+=$rs1['rate'];
                                                else
                                                    $fees+=$rs1['rate'];
                                                switch ($rs1['fg_id']) {
                                                    case "1":
                                                        $t1_fees+=$rs1['rate'];
                                                        break;
                                                    case "2":
                                                        $t2_fees+=$rs1['rate'];
                                                        break;
                                                    case "3":
                                                        $t3_fees+=$rs1['rate'];
                                                        break;
                                                    case "4":
                                                    /* if ($rs['stype'] == "New" && $rs1['type'] == "1")
                                                      $other_fees+=$rs1['rate'];
                                                      else
                                                      $other_fees+=$rs1['rate'];
                                                      break;
                                                     */
                                                }
                                            }

                                            //START OTHER FEES CALC
                                            $qry1_all = "SELECT fg_id,fgd_id,ay_id,c_id,rate from frate AS fr WHERE fr.ay_id='" . $acyear . "' AND fr.c_id='" . $rs["c_id"] . "'";
                                            //die;
                                            $result1_all = mysql_query($qry1_all);

                                            $other_fees_reg = 0;
                                            $other_fees_schl = 0;
                                            $other_fees_admn = 0;
                                            $other_fees_cam = 0;
                                            $other_fees_aba = 0;
                                            $other_fees_skat = 0;
                                            $other_fees_karat = 0;
                                            $other_fees_cric = 0;

                                            while ($rs1_all = mysql_fetch_assoc($result1_all)) {
                                                if ($rs1_all['fg_id'] == 4) {

                                                    switch ($rs1_all['fgd_id']) {
                                                        case "2":
                                                            //if ($rs['stype'] == "New") {
                                                            $other_fees_reg+=$rs1_all['rate'];
                                                            //}
                                                            break;
                                                        case "7":
                                                            // if ($rs['stype'] == "New") {
                                                            $other_fees_admn+=$rs1_all['rate'];
                                                            // }
                                                            break;
                                                        case "9":
                                                            $other_fees_schl+=$rs1_all['rate'];
                                                            break;
                                                        case "10":
                                                            //if ($rs['stype'] == "New") {
                                                            $other_fees_cam+=$rs1_all['rate'];
                                                            //}
                                                            break;
                                                        case "11":
                                                            // if ($rs['stype'] == "New") {
                                                            $other_fees_aba+=$rs1_all['rate'];
                                                            // }
                                                            break;
                                                        case "12":
                                                            $other_fees_skat+=$rs1_all['rate'];
                                                            break;
                                                        case "13":
                                                            $other_fees_karat+=$rs1_all['rate'];
                                                            break;
                                                        case "14":
                                                            $other_fees_cric+=$rs1_all['rate'];
                                                            break;
                                                    }
                                                }
                                            }
                                            //END OTHER FEES


                                            /* $qry2="Select fs.fg_id,ss_id,sum(amount) as amount from fsalessumarry AS fs INNER JOIN finvoice AS fi ON fi.fi_id=fs.fi_id INNER JOIN frate AS fr ON fr.fr_id=fs.fr_id  WHERE  ss_id='".$rs["ss_id"]."' GROUP BY ss_id,fg_id"; */
                                            $qry2 = "select fs.fss_id,fs.amount,fs.fg_id,fs.fgd_id from finvoice as fi 
                                                    INNER JOIN fsalessumarry AS fs ON fs.fi_id=fi.fi_id WHERE fi.ss_id='" . $rs["ss_id"] . "'
                                                    AND fi.c_status!='1' AND fi.i_status='0'";
                                            $result2 = mysql_query($qry2);
                                            $t1_amount = 0;
                                            $t2_amount = 0;
                                            $t3_amount = 0;
                                            $other_amount = 0;
                                            $other_amount_reg = 0;
                                            $other_amount_schl = 0;
                                            $other_amount_admn = 0;
                                            $other_amount_cam = 0;
                                            $other_amount_aba = 0;
                                            $other_amount_skat = 0;
                                            $other_amount_karat = 0;
                                            $other_amount_cric = 0;

                                            while ($rs2 = mysql_fetch_assoc($result2)) {

                                                switch ($rs2['fg_id']) {
                                                    case "1":
                                                        $t1_amount+=$rs2['amount'];
                                                        break;
                                                    case "2":
                                                        $t2_amount+=$rs2['amount'];
                                                        break;
                                                    case "3":
                                                        $t3_amount+=$rs2['amount'];
                                                        break;
                                                    case "4":

                                                        /* $feesgroup = mysql_query("SELECT otherfees FROM fgroup_detail WHERE fgd_id='" . $rs2['fg_id'] . "' AND otherfees=0");
                                                          $feesgrouplist = mysql_fetch_array($feesgroup);
                                                          if ($feesgrouplist) {
                                                          $other_amount+=$rs2['amount'];
                                                          }
                                                          break;
                                                         */
//&& ($rs['stype'] == "New")
                                                        if (($rs2['fgd_id'] == "2")) {
                                                            $other_amount_reg+=$rs2['amount'];
                                                        } else if (($rs2['fgd_id'] == "7")) {
                                                            $other_amount_admn+=$rs2['amount'];
                                                        } else if (($rs2['fgd_id'] == "9")) {
                                                            $other_amount_schl+=$rs2['amount'];
                                                        } else if (($rs2['fgd_id'] == "10")) {
                                                            $other_amount_cam+=$rs2['amount'];
                                                        } else if (($rs2['fgd_id'] == "11")) {
                                                            $other_amount_aba+=$rs2['amount'];
                                                        } else if (($rs2['fgd_id'] == "12")) {
                                                            $other_amount_skat+=$rs2['amount'];
                                                        } else if (($rs2['fgd_id'] == "13")) {
                                                            $other_amount_karat+=$rs2['amount'];
                                                        } else if (($rs2['fgd_id'] == "14")) {
                                                            $other_amount_cric+=$rs2['amount'];
                                                        }

                                                        break;
                                                }
                                            }

                                            $t1_pending = $t1_fees - $t1_amount;
                                            $t2_pending = $t2_fees - $t2_amount;
                                            $t3_pending = $t3_fees - $t3_amount;

                                            $reg_pending = $other_fees_reg - $other_amount_reg;
                                            $admn_pending = $other_fees_admn - $other_amount_admn;
                                            $schl_pending = $other_fees_schl - $other_amount_schl;

                                            $cam_pending = $other_fees_cam - $other_amount_cam;
                                            $aba_pending = $other_fees_aba - $other_amount_aba;
                                            $skat_pending = $other_fees_skat - $other_amount_skat;
                                            $karat_pending = $other_fees_karat - $other_amount_karat;
                                            $cric_pending = $other_fees_cric - $other_amount_cric;
                                            // echo ' fees'.$feesub.'-amt'.($t1_pending);

                                            if ($feesub == 'all' || $feesub == 1 || ($feesub == 2 && (($ddlterm == 'all' && (($t1_amount) != 0 || ($t2_amount) != 0 || ($t3_amount) != 0 || $other_amount_reg != 0 || $other_amount_admn != 0 || $other_amount_schl != 0)) || ($ddlterm == 1 && ($t1_amount) != 0) || ($ddlterm == 2 && ($t2_amount) != 0) ||
                                                    ($ddlterm == 3 && ($t3_amount) != 0) || ($ddlterm == 42 && $other_amount_reg != 0) ||
                                                    ($ddlterm == 47 && $other_amount_admn != 0) || ($ddlterm == 49 && $other_amount_schl != 0) )) ||
                                                    ($feesub == 3 && (($ddlterm == 'all' && (($t1_pending) != 0 || ($t2_pending) != 0 || ($t3_pending) != 0 || $reg_pending != 0 || $admn_pending != 0 || $schl_pending != 0)) || ($ddlterm == 1 && ($t1_pending) != 0) || ($ddlterm == 2 && ($t2_pending) != 0) ||
                                                    ($ddlterm == 3 && ($t3_pending) != 0) || ($ddlterm == 42 && $reg_pending != 0) ||
                                                    ($ddlterm == 47 && $admn_pending != 0) || ($ddlterm == 49 && $schl_pending != 0) ||
                                                    ($ddlterm == 410 && $cam_pending != 0) || ($ddlterm == 411 && $aba_pending != 0) ||
                                                    ($ddlterm == 412 && $skat_pending != 0) || ($ddlterm == 413 && $karat_pending != 0) ||
                                                    ($ddlterm == 414 && $cric_pending != 0)
                                                    ))
                                            ) {
                                                ?>
                                                <tr class="gradeX">
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo $rs["admission_number"]; ?></td>
                                                    <td><?php echo $rs["firstname"]; ?></td>
                                                    <td><?php echo $rs["c_name"]; ?></td>
                                                    <td><?php echo $rs["stype"]; ?></td>
                                                    <td><?php echo $rs["phone_number"]; ?></td>

                                                    <?php
                                                    $csv_content = $csv_content . $cnt . "," . $rs["admission_number"] . "," . $rs["firstname"] . "," . $rs["c_name"];
                                                    if ($ddlterm == "all") {
                                                        $csv_content = $csv_content . "," . $t1_fees . "," . $t1_amount . "," . $t1_fees - $t1_amount;

                                                        if ($feesub == 1) {

                                                            echo '<td>' . $t1_fees . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td>' . $t1_fees . '</td><td>' . $t1_amount . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td>' . $t1_fees . '</td><td>' . ($t1_fees - $t1_amount) . '</td>';
                                                        } else {

                                                            echo '<td>' . $t1_fees . '</td><td>' . $t1_amount . '</td><td>' . ($t1_fees - $t1_amount) . '</td>';
                                                        }


                                                        if ($feesub == 1) {

                                                            echo '<td>' . $t2_fees . '</td>';
                                                        } else if ($feesub == 2) {

                                                            echo '<td>' . $t2_fees . '</td><td>' . $t2_amount . '</td>';
                                                        } else if ($feesub == 3) {

                                                            echo '<td>' . $t2_fees . '</td><td>' . ($t2_fees - $t2_amount) . '</td>';
                                                        } else {

                                                            echo '<td>' . $t2_fees . '</td><td>' . $t2_amount . '</td><td>' . ($t2_fees - $t2_amount) . '</td>';
                                                        }

                                                        if ($feesub == 1) {

                                                            echo '<td>' . $t3_fees . '</td>';
                                                        } else if ($feesub == 2) {

                                                            echo '<td>' . $t3_fees . '</td><td>' . $t3_amount . '</td>';
                                                        } else if ($feesub == 3) {

                                                            echo '<td>' . $t3_fees . '</td><td>' . ($t3_fees - $t3_amount) . '</td>';
                                                        } else {

                                                            echo '<td>' . $t3_fees . '</td><td>' . $t3_amount . '</td><td>' . ($t3_fees - $t3_amount) . '</td>';
                                                        }
                                                        ?>

                                                        <?php
                                                        //other sub

                                                        $reg_pending = $other_fees_reg - $other_amount_reg;
                                                        //register
                                                        /* if ($rs['stype'] == "Old") {
                                                          $other_fees_reg = '-';
                                                          $other_amount_reg = '-';
                                                          $reg_pending = '-';
                                                          } */

                                                        if ($feesub == 1) {

                                                            if ($rs['stype'] == "New")
                                                                echo '<td>' . $other_fees_reg . '</td>';
                                                            else
                                                                echo '<td>-</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            if ($rs['stype'] == "New")
                                                                echo '<td>' . $other_fees_reg . '</td><td>' . $other_amount_reg . '</td>';
                                                            else
                                                                echo '<td >-</td><td>-</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            if ($rs['stype'] == "New")
                                                                echo '<td>' . $other_fees_reg . '</td><td>' . $reg_pending . '</td>';
                                                            else
                                                                echo '<td >-</td><td>-</td>';
                                                        } else {

                                                            if ($rs['stype'] == "New")
                                                                echo '<td>' . $other_fees_reg . '</td><td>' . $other_amount_reg . '</td><td>' . $reg_pending . '</td>';
                                                            else
                                                                echo '<td>-</td><td>-</td><td>-</td>';
                                                        }

                                                        //admission
                                                        $adm_pending = $other_fees_admn - $other_amount_admn;
                                                        //register
                                                        /* if ($rs['stype'] == "Old") {
                                                          $other_fees_admn = '-';
                                                          $other_amount_admn = '-';
                                                          $adm_pending = '-';
                                                          } */
                                                        if ($feesub == 1) {

                                                            if ($rs['stype'] == "New")
                                                                echo '<td>' . $other_fees_admn . '</td>';
                                                            else
                                                                echo '<td>-</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            if ($rs['stype'] == "New")
                                                                echo '<td>' . $other_fees_admn . '</td><td>' . $other_amount_admn . '</td>';
                                                            else
                                                                echo '<td >-</td><td>-</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            if ($rs['stype'] == "New")
                                                                echo '<td>' . $other_fees_admn . '</td><td>' . $adm_pending . '</td>';
                                                            else
                                                                echo '<td >-</td><td>-</td>';
                                                        } else {

                                                            if ($rs['stype'] == "New")
                                                                echo '<td>' . $other_fees_admn . '</td><td>' . $other_amount_admn . '</td><td>' . $adm_pending . '</td>';
                                                            else
                                                                echo '<td>-</td><td>-</td><td>-</td>';
                                                        }

                                                        //school
                                                        $schl_pending = $other_fees_schl - $other_amount_schl;

                                                        if ($feesub == 1) {

                                                            echo '<td>' . $other_fees_schl . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td>' . $other_fees_schl . '</td><td>' . $other_amount_schl . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td>' . $other_fees_schl . '</td><td>' . $schl_pending . '</td>';
                                                        } else {

                                                            echo '<td>' . $other_fees_schl . '</td><td>' . $other_amount_schl . '</td><td>' . $schl_pending . '</td>';
                                                        }
                                                        
                                                        
                                                        //cambridge
                                                        $cam_pending = $other_fees_cam - $other_amount_cam;
                                                      
                                                        if ($feesub == 1) {

                                                            echo '<td>' . $other_fees_cam . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td>' . $other_fees_cam . '</td><td>' . $other_amount_cam . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td>' . $other_fees_cam . '</td><td>' . $cam_pending . '</td>';
                                                        } else {

                                                            echo '<td>' . $other_fees_cam . '</td><td>' . $other_amount_cam . '</td><td>' . $cam_pending . '</td>';
                                                        }
                                                        //abacus
                                                        $aba_pending = $other_fees_aba - $other_amount_aba;
                                                        
                                                        if ($feesub == 1) {

                                                            echo '<td>' . $other_fees_aba . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td>' . $other_fees_aba . '</td><td>' . $other_amount_aba . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td>' . $other_fees_aba . '</td><td>' . $aba_pending . '</td>';
                                                        } else {

                                                            echo '<td>' . $other_fees_aba . '</td><td>' . $other_amount_aba . '</td><td>' . $aba_pending . '</td>';
                                                        }
                                                        
                                                        //skating
                                                        $skat_pending = $other_fees_skat - $other_amount_skat;
                                                        if ($feesub == 1) {

                                                            echo '<td>' . $other_fees_skat . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td>' . $other_fees_skat . '</td><td>' . $other_amount_skat . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td>' . $other_fees_skat . '</td><td>' . $skat_pending . '</td>';
                                                        } else {

                                                            echo '<td>' . $other_fees_skat . '</td><td>' . $other_amount_skat . '</td><td>' . $skat_pending . '</td>';
                                                        }
                                                        //karate
                                                        $karat_pending = $other_fees_karat - $other_amount_karat;
                                                        if ($feesub == 1) {

                                                            echo '<td>' . $other_fees_karat . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td>' . $other_fees_karat . '</td><td>' . $other_amount_karat . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td>' . $other_fees_karat . '</td><td>' . $karat_pending . '</td>';
                                                        } else {

                                                            echo '<td>' . $other_fees_karat . '</td><td>' . $other_amount_karat . '</td><td>' . $karat_pending . '</td>';
                                                        }
                                                        //cricket
                                                        $cric_pending = $other_fees_cric - $other_amount_cric;
                                                        if ($feesub == 1) {

                                                            echo '<td>' . $other_fees_cric . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td>' . $other_fees_cric . '</td><td>' . $other_amount_cric . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td>' . $other_fees_cric . '</td><td>' . $cric_pending . '</td>';
                                                        } else {

                                                            echo '<td>' . $other_fees_cric . '</td><td>' . $other_amount_cric . '</td><td>' . $cric_pending . '</td>';
                                                        }
                                                        ?>
                                                        <?php
                                                        $csv_content = $csv_content . "," . $total_fees . "," . $total_amount . "," . $total_pending_amount . "\n";
                                                        $total_fees = $t1_fees + $t2_fees + $t3_fees + $other_fees_reg + $other_fees_admn + $other_fees_schl+$other_fees_cam+$other_fees_aba+$other_fees_skat+$other_fees_karat+$other_fees_cric;
                                                        $csv_content = $csv_content . "," . $total_fees;
                                                        $total_amount = $t1_amount + $t2_amount + $t3_amount + $other_amount_reg + $other_amount_admn + $other_amount_schl+ $other_amount_cam+ $other_amount_aba+ $other_amount_skat+ $other_amount_karat+ $other_amount_cric;
                                                        $csv_content = $csv_content . "," . $total_amount;
                                                        $total_pending_amount = $total_fees - $total_amount;
                                                        $csv_content = $csv_content . "," . $total_pending_amount . "\n";

                                                        if ($feesub == 1) {

                                                            echo '<td>' . $total_fees . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td>' . $total_fees . '</td><td>' . $total_amount . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td>' . $total_fees . '</td><td>' . ($total_fees - $total_amount) . '</td>';
                                                        } else {

                                                            echo '<td>' . $total_fees . '</td><td>' . $total_amount . '</td><td>' . ($total_fees - $total_amount) . '</td>';
                                                        }
                                                    }
                                                    if ($ddlterm == "1") {

                                                        if ($feesub == 1) {

                                                            echo '<td>' . $t1_fees . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td colspan="1">' . $t1_fees . '</td><td>' . $t1_amount . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td colspan="1">' . $t1_fees . '</td><td>' . ($t1_fees - $t1_amount) . '</td>';
                                                        } else {

                                                            echo '<td>' . $t1_fees . '</td><td>' . $t1_amount . '</td><td>' . ($t1_fees - $t1_amount) . '</td>';
                                                        }
                                                        ?>

                                                        <?php
                                                    }
                                                    if ($ddlterm == "2") {

                                                        if ($feesub == 1) {

                                                            echo '<td>' . $t2_fees . '</td>';
                                                        } else if ($feesub == 2) {

                                                            echo '<td colspan="1">' . $t2_fees . '</td><td>' . $t2_amount . '</td>';
                                                        } else if ($feesub == 3) {

                                                            echo '<td colspan="1">' . $t2_fees . '</td><td>' . ($t2_fees - $t2_amount) . '</td>';
                                                        } else {

                                                            echo '<td>' . $t2_fees . '</td><td>' . $t2_amount . '</td><td>' . ($t2_fees - $t2_amount) . '</td>';
                                                        }
                                                        ?>

                                                        <?php
                                                    }
                                                    if ($ddlterm == "3") {

                                                        if ($feesub == 1) {

                                                            echo '<td>' . $t3_fees . '</td>';
                                                        } else if ($feesub == 2) {

                                                            echo '<td colspan="1">' . $t3_fees . '</td><td>' . $t3_amount . '</td>';
                                                        } else if ($feesub == 3) {

                                                            echo '<td colspan="1">' . $t3_fees . '</td><td>' . ($t3_fees - $t3_amount) . '</td>';
                                                        } else {

                                                            echo '<td>' . $t3_fees . '</td><td>' . $t3_amount . '</td><td>' . ($t3_fees - $t3_amount) . '</td>';
                                                        }
                                                        ?>

                                                        <?php
                                                    }

                                                    //other sub
                                                    if ($ddlterm == '42') {

                                                        $reg_pending = $other_fees_reg - $other_amount_reg;
                                                        //register
                                                        /* if ($rs['stype'] == "Old") {
                                                          $other_fees_reg = '-';
                                                          $other_amount_reg = '-';
                                                          $reg_pending = '-';
                                                          } */

                                                        if ($feesub == 1) {

                                                            if ($rs['stype'] == "New")
                                                                echo '<td>' . $other_fees_reg . '</td>';
                                                            else
                                                                echo '<td>-</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            if ($rs['stype'] == "New")
                                                                echo '<td colspan="1">' . $other_fees_reg . '</td><td>' . $other_amount_reg . '</td>';
                                                            else
                                                                echo '<td colspan="1">-<td><td>-</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            if ($rs['stype'] == "New")
                                                                echo '<td colspan="1">' . $other_fees_reg . '</td><td>' . $reg_pending . '</td>';
                                                            else
                                                                echo '<td colspan="1">-<td><td>-</td>';
                                                        } else {

                                                            if ($rs['stype'] == "New")
                                                                echo '<td>' . $other_fees_reg . '</td><td>' . $other_amount_reg . '</td><td>' . $reg_pending . '</td>';
                                                            else
                                                                echo '<td colspan="1">-<td><td>-</td>';
                                                        }
                                                    }
                                                    if ($ddlterm == '47') {
                                                        //admission
                                                        $adm_pending = $other_fees_admn - $other_amount_admn;
                                                        //register
                                                        /* if ($rs['stype'] == "Old") {
                                                          $other_fees_admn = '-';
                                                          $other_amount_admn = '-';
                                                          $adm_pending = '-';
                                                          } */
                                                        if ($feesub == 1) {

                                                            if ($rs['stype'] == "New")
                                                                echo '<td>' . $other_fees_admn . '</td>';
                                                            else
                                                                echo '<td>-</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            if ($rs['stype'] == "New")
                                                                echo '<td colspan="1">' . $other_fees_admn . '</td><td>' . $other_amount_admn . '</td>';
                                                            else
                                                                echo '<td colspan="1">-<td><td>-</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            if ($rs['stype'] == "New")
                                                                echo '<td colspan="1">' . $other_fees_admn . '</td><td>' . $adm_pending . '</td>';
                                                            else
                                                                echo '<td colspan="1">-<td><td>-</td>';
                                                        } else {

                                                            if ($rs['stype'] == "New")
                                                                echo '<td>' . $other_fees_admn . '</td><td>' . $other_amount_admn . '</td><td>' . $adm_pending . '</td>';
                                                            else
                                                                echo '<td colspan="1">-<td><td>-</td>';
                                                        }
                                                    }
                                                    if ($ddlterm == '49') {
                                                        //school
                                                        $schl_pending = $other_fees_schl - $other_amount_schl;

                                                        /* if ($rs['stype'] == "Old") {
                                                          $other_fees_schl = '-';
                                                          $other_amount_schl = '-';
                                                          $schl_pending = '-';
                                                          } */
                                                        if ($feesub == 1) {

                                                            echo '<td>' . $other_fees_schl . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td colspan="1">' . $other_fees_schl . '</td><td>' . $other_amount_schl . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td colspan="1">' . $other_fees_schl . '</td><td>' . $schl_pending . '</td>';
                                                        } else {

                                                            echo '<td>' . $other_fees_schl . '</td><td>' . $other_amount_schl . '</td><td>' . $schl_pending . '</td>';
                                                        }
                                                    }
                                                    
                                                     if ($ddlterm == '410') {
                                                        //cambridge
                                                        $cam_pending = $other_fees_cam - $other_amount_cam;

                                                        /* if ($rs['stype'] == "Old") {
                                                          $other_fees_schl = '-';
                                                          $other_amount_schl = '-';
                                                          $schl_pending = '-';
                                                          } */
                                                        if ($feesub == 1) {

                                                            echo '<td>' . $other_fees_cam . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td colspan="1">' . $other_fees_cam . '</td><td>' . $other_amount_cam . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td colspan="1">' . $other_fees_cam . '</td><td>' . $cam_pending . '</td>';
                                                        } else {

                                                            echo '<td>' . $other_fees_cam . '</td><td>' . $other_amount_cam . '</td><td>' . $cam_pending . '</td>';
                                                        }
                                                    }
                                                     if ($ddlterm == '411') {
                                                        //abacus
                                                        $aba_pending = $other_fees_aba - $other_amount_aba;

                                                        /* if ($rs['stype'] == "Old") {
                                                          $other_fees_schl = '-';
                                                          $other_amount_schl = '-';
                                                          $schl_pending = '-';
                                                          } */
                                                        if ($feesub == 1) {

                                                            echo '<td>' . $other_fees_aba . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td colspan="1">' . $other_fees_aba . '</td><td>' . $other_amount_aba . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td colspan="1">' . $other_fees_aba . '</td><td>' . $aba_pending . '</td>';
                                                        } else {

                                                            echo '<td>' . $other_fees_aba . '</td><td>' . $other_amount_aba . '</td><td>' . $aba_pending . '</td>';
                                                        }
                                                    }
                                                     if ($ddlterm == '412') {
                                                        //skating
                                                        $skat_pending = $other_fees_skat - $other_amount_skat;

                                                        /* if ($rs['stype'] == "Old") {
                                                          $other_fees_schl = '-';
                                                          $other_amount_schl = '-';
                                                          $schl_pending = '-';
                                                          } */
                                                        if ($feesub == 1) {

                                                            echo '<td>' . $other_fees_skat . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td colspan="1">' . $other_fees_skat . '</td><td>' . $other_amount_skat . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td colspan="1">' . $other_fees_skat . '</td><td>' . $skat_pending . '</td>';
                                                        } else {

                                                            echo '<td>' . $other_fees_skat . '</td><td>' . $other_amount_skat . '</td><td>' . $skat_pending . '</td>';
                                                        }
                                                    }
                                                     if ($ddlterm == '413') {
                                                        //karate
                                                        $karat_pending = $other_fees_karat - $other_amount_karat;

                                                        /* if ($rs['stype'] == "Old") {
                                                          $other_fees_schl = '-';
                                                          $other_amount_schl = '-';
                                                          $schl_pending = '-';
                                                          } */
                                                        if ($feesub == 1) {

                                                            echo '<td>' . $other_fees_karat . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td colspan="1">' . $other_fees_karat . '</td><td>' . $other_amount_karat . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td colspan="1">' . $other_fees_karat . '</td><td>' . $karat_pending . '</td>';
                                                        } else {

                                                            echo '<td>' . $other_fees_karat . '</td><td>' . $other_amount_karat . '</td><td>' . $karat_pending . '</td>';
                                                        }
                                                    }
                                                     if ($ddlterm == '414') {
                                                        //cricket
                                                        $cric_pending = $other_fees_cric - $other_amount_cric;

                                                        /* if ($rs['stype'] == "Old") {
                                                          $other_fees_schl = '-';
                                                          $other_amount_schl = '-';
                                                          $schl_pending = '-';
                                                          } */
                                                        if ($feesub == 1) {

                                                            echo '<td>' . $other_fees_cric . '</td>';
                                                        } else if ($feesub == 2) {
                                                            //paid
                                                            echo '<td colspan="1">' . $other_fees_cric . '</td><td>' . $other_amount_cric . '</td>';
                                                        } else if ($feesub == 3) {
                                                            //pending
                                                            echo '<td colspan="1">' . $other_fees_cric . '</td><td>' . $cric_pending . '</td>';
                                                        } else {

                                                            echo '<td>' . $other_fees_cric . '</td><td>' . $other_amount_cric . '</td><td>' . $cric_pending . '</td>';
                                                        }
                                                    }
                                                    ?>

                                                </tr>
                                                <?php
                                            }
                                            $t1_fees = 0;
                                            $t2_fees = 0;
                                            $t3_fees = 0;
                                            $other_fees = 0;
                                            $t1_pending = 0;
                                            $t2_pending = 0;
                                            $t3_pending = 0;

                                            $reg_pending = 0;
                                            $admn_pending = 0;
                                            $schl_pending = 0;
                                            
                                            $cam_pending = 0;
                                            $aba_pending = 0;
                                            $skat_pending = 0;
                                            $karat_pending = 0;
                                            $cric_pending = 0;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="clear height-fix"></div>
                </div>
            </div> <!--! end of #main-content -->
        </div> <!--! end of #main -->


        <?php include("includes/footer.php"); ?>
    </div> <!--! end of #container -->

    <!-- JavaScript at the bottom for fast page loading -->
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
    <script>
        $.noConflict();
        jQuery(document).ready(function($) {
            $('#table-example').dataTable({
                'iDisplayLength': 25
            });
            // Code that uses jQuery's $ can follow here.
        });
        // Code that uses other library's $ can follow here.
    </script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script src="js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


    <!-- scripts concatenated and minified via ant build script-->
    <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
    <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
    <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
    <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
    <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
    <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
    <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
    <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
    <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
    <script defer src="js/common.js"></script> <!-- Generic functions -->
    <script defer src="js/script.js"></script> <!-- Generic scripts -->

    <script type="text/javascript">
        $().ready(function() {

            var validateform = $("#validate-form").validate();
            $("#reset-validate-form").click(function() {
                location.reload();
                //$.jGrowl("Blogpost was not created.", { theme: 'error' });
            });
        });
        function change_function() {
            var cid = document.getElementById('bid').value;
            window.location.href = 'student_mng.php?bid=' + cid;
        }
    </script>
    <!-- end scripts-->

    <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
         chromium.org/developers/how-tos/chrome-frame-getting-started -->
    <!--[if lt IE 7 ]>
      <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
      <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->
    <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
    <script type="text/javascript">
        function showCategory(str) {
            if (str == "") {
                document.getElementById("sid").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else {// code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("sid").innerHTML = "<option value='all'>All</option><option value='Old'>Old</option><option value='0'>New</option>" + xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
            xmlhttp.send();
        }

        function gender_order()
        {
            var order_gender = $("#order_gender").val();
            window.location.href = "student_mng.php?cid=<?= $cid ?>&sid=<?= $sid ?>&bid=<?= $bid ?>&order_gender=" + order_gender;

        }
    </script>  
    <?php include("roll_footer.php"); ?> 
</body>
</html>
<? ob_flush(); ?>