<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php");
//echo $_SESSION['uname'];
$bid = $_GET['bid'];
if (!$bid) {
    $boardlist1 = mysql_query("SELECT b_id FROM board");
    $board1 = mysql_fetch_array($boardlist1);
    $bid = $board1['b_id'];
}
$cids = $_GET['cid'];
if (isset($_POST['submit'])) {
    $frno = $_POST['frno'];
    $ssid1 = $_POST['ssid1'];
    $stype = $_POST['stype'];
    $ss_name = $_POST['ss_name'];
    $admin_no = $_POST['admin_no'];
    $cid1 = $_POST['cid1'];
    $sid1 = $_POST['sid1'];

    $idate = $_POST['idate'];
    $idatesplit = explode("/", $idate);
    $day = $idatesplit[0];
    $month = $idatesplit[1];
    $year = $idatesplit[2];


    $total = $_POST['total'];
    $total_pending=$_POST['total_pending'];
    $stype = $_POST['stype'];
    $bid1 = $_POST['bid1'];

    $scateg = $_POST['scateg'];
    $sfood = $_POST['sfood'];

    $termfees1 = $_POST['termfees1'];
    $remark = $_POST['remark'];
    $status=0;
    if($total==$total_pending)
    	$status=1;
    if ($total) {
        $sql = "INSERT INTO discount (day,month,year,cdate,total,ss_id,c_id,s_id,stype,cby,bid,ay_id,s_name,admin_no,remark,status) VALUES
('$day','$month','$year','$idate','$total','$ssid1','$cid1','$sid1','$stype','$user','$bid1','$acyear','$ss_name','$admin_no','$remark','$status')";

        $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
        $lastid = $id = mysql_insert_id();
        if ($result) {
            if ($sfood) {
                $qry2 = mysql_query("SELECT * FROM fgroup_detail where fg_id!=4 AND otherfees='0'");
            } else {
                $qry2 = mysql_query("SELECT * FROM fgroup_detail where fg_id!=4 AND otherfees='0' AND food='0'");
            }
            //$qry2=mysql_query("SELECT * FROM fgroup_detail where fg_id!=4 AND otherfees='0'");	
            $nofrow = mysql_num_rows($qry2);
            while ($row2 = mysql_fetch_array($qry2)) {
                $fgdid = $row2['fgd_id'];
                $type = "terms";
                $name = $row2['name'];
                $cartid = $fgdid . "1";
                $postName = "fees" . $cartid;
                $amount = $_POST[$postName];
                if ($amount) {
                    $sql1 = "INSERT INTO discount_value (d_id,ss_id,fg_id,fgd_id,name,amount,type,payment,bid,ay_id) VALUES
('$lastid','$ssid1','1','$fgdid','$name','$amount','$type','0','$bid1','$acyear')";
                    $result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
                }
            }
            if ($stype == "New") {
                $qry2 = mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0'");
            } else {
                $qry2 = mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0' AND type='0'");
            }
            while ($row2 = mysql_fetch_array($qry2)) {
                $fgdid = $row2['fgd_id'];
                $type = "other";
                $name = $row2['name'];
                $cartid = $fgdid . "4";
                $postName = "fees" . $cartid;
                $amount = $_POST[$postName];
                if ($amount) {
                    $sql1 = "INSERT INTO discount_value (d_id,ss_id,fg_id,fgd_id,name,amount,type,payment,bid,ay_id) VALUES
('$lastid','$ssid1','4','$fgdid','$name','$amount','$type','0','$bid1','$acyear')";
                    $result1 = mysql_query($sql1) or die("Could not insert data into DB: " . mysql_error());
                }
            }
            header("location:discount_add.php?cid=$cids&bid=$bid&msg=succ");
        }
    } else {
        header("location:discount_add.php?cid=$cids&bid=$bid&id=$ssid1&msg=ferr");
    }
}
?>
<link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
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
$id = $_GET['id'];
$boardlist = mysql_query("SELECT * FROM board WHERE b_id=$bid");
$board = mysql_fetch_array($boardlist);
if ($cids) {
    $classlist = mysql_query("SELECT c_name FROM class WHERE c_id=$cids");
    $class = mysql_fetch_array($classlist);
}
?>
            <!-- Begin of titlebar/breadcrumbs -->
            <div id="title-bar">
                <ul id="breadcrumbs">
                    <li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                    <li class="no-hover"><a href="#" title="<?php echo $board['b_name']; ?>"><?php echo $board['b_name']; ?></a></li>
                    <li class="no-hover"><a href="discount_mng.php?cid=<?php echo $cid; ?>&bid=<?php echo $bid; ?>" title="<?php echo $board['b_name']; ?>">Student Discount Management </a></li>
                    <li class="no-hover">Add Discount <?php if ($cids) {
                echo "(" . $class['c_name'] . ")";
            } ?></li>
                </ul>
            </div> <!--! end of #title-bar -->

            <div class="shadow-bottom shadow-titlebar"></div>

            <!-- Begin of #main-content -->
            <div id="main-content">
                <div class="container_12">

                    <div class="grid_12">
                        <h1>Add Discount <?php if ($cids) {
                echo "(" . $class['c_name'] . ")";
            } ?></h1>                
                        <a href="discount_mng.php?cid=<?php echo $cid; ?>&bid=<?php echo $bid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                        <div class="_25" style="float:right">
                            <label for="select">Standard</label>
<?php
$classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
$result1 = mysql_query($classl) or die(mysql_error());
echo '<select name="cid" id="cid" class="required" onchange="change_function1()"> <option value="">All</option>';
while ($row1 = mysql_fetch_assoc($result1)):
    if ($cids == $row1['c_id']) {
        echo "<option value='{$row1['c_id']}' selected>{$row1['c_name']}</option>\n";
    } else {
        echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
    }
endwhile;
echo '</select>';
?>
                            </select>
                        </div>
                    </div>
                    <div class="grid_12">
<?php $msg = $_GET['msg'];
if ($msg == "succ") {
    ?>			
                            <div class="alert success"><span class="hide">x</span>Your Discount Successfully applied!!!</div>
                        <?php }
                        if ($msg == "ferr") {
                            ?>			
                            <div class="alert error"><span class="hide">x</span>Please enter discount Values!!!</div>
                        <?php } ?>
                        <?php if (!$id) { ?>
                            <div class="block-border">

                                <div class="block-header">
                                    <h1>Select Student</h1><span></span>
                                </div>
                                <form id="validate-form" class="block-content form" action="" method="POST">


                                    <div class="_100">
                                        <p>
                                            <label for="select">Student Name: <span class="error">*</span></label>
                                            <select name="n_sid" id="n_sid"  data-required="true"  class='required'  onchange="change_function2(this.value)"  style="width:90%">
                                                <option value="">Plese select Student </option>
                                                <?php
                                                $emp_query = "select ss_id,c_id,s_id,admission_number,firstname,lastname from student where b_id='$bid' and ay_id='$acyear'";
                                                if ($cids) {
                                                    $emp_query.=" AND c_id=$cids";
                                                }
                                                $emp_query.=" AND user_status=1 order by firstname asc";
                                                $emp_result = mysql_query($emp_query);
                                                while ($emp_display = mysql_fetch_array($emp_result)) {
                                                    $ss_id = $emp_display["ss_id"];
                                                    $c_id = $emp_display["c_id"];
                                                    $s_id = $emp_display["s_id"];

                                                    $qry1 = mysql_fetch_array(mysql_query("select c_name from class where c_id='$c_id'"));
                                                    $class_name = $qry1["c_name"];
                                                    $qry1 = mysql_fetch_array(mysql_query("select s_name from section where s_id='$s_id'"));
                                                    $section_name = $qry1["s_name"];

                                                    $class = $class_name . " - " . $section_name . " ";
                                                    $dislist = mysql_num_rows(mysql_query("SELECT dv_id FROM discount_value WHERE ss_id=$ss_id AND payment=0"));
                                                    if ($dislist > 0) {
                                                        $status = 0;
                                                    } else {
                                                        $status = 1;
                                                    }
                                                    if ($status == 1) {
                                                        ?>
                                                        <option value="<?php echo $ss_id; ?>" <?php if ($ss_id == $id) {
                                                echo "selected";
                                            } ?>><?php echo $emp_display["admission_number"] . "-" . $emp_display["firstname"] . " " . $emp_display["lastname"] . "(" . $class . ")"; ?></option>
        <?php }
    } ?>								

                                            </select>
                                        </p>
                                    </div> 

                                    <input type="hidden" name="bid"   class='required'  value="<?= $bid ?>">
                                    <div id="test"></div>  



                                    <div class="clear"></div>

                                </form>
                            </div>
                        <?php
                        }
                        if ($id) {

                            $studentlist = mysql_query("SELECT * FROM student WHERE ss_id='$id' AND ay_id=$acyear");
                            $student = mysql_fetch_array($studentlist);
                            $ssid = $student['ss_id'];
                            $ss_gender = $student['gender'];
                            $cid = $student['c_id'];
                            $sid = $student['s_id'];
                            $s_type = $student['stype'];
                            $latejoin = $student['late_join'];
                            $scateg = $student['scateg'];
                            $sfood = $student['sfood'];

                            if ($scateg == '1') {
                                $rate = "rate1";
                            } else {
                                $rate = "rate";
                            }

                            $fdisid1 = $student['fdis_id'];

                            $classlist1 = mysql_query("SELECT * FROM class WHERE c_id=$cid");
                            $class1 = mysql_fetch_array($classlist1);

                            if (($class1['c_name'] == "XI STD") || ($class1['c_name'] == "XII STD")|| ($class1['c_name'] == "XI") || ($class1['c_name'] == "XII")) {
                                $sid21 = $sid;
                            } else {
                                $sid21 = "0";
                            }
                            $qry1 = mysql_query("SELECT * FROM section WHERE s_id=$sid");
                            $row1 = mysql_fetch_array($qry1);
                            ?>
                            <form id="validate-form" class="block-content-invoice form" action="" method="post">
                                <div id="invoice" class="widget widget-plain" class="widget-content">	
                                    <ul class="client_details">
                                        <li><strong class="name">Admission No : <?php echo $student['admission_number']; ?></strong><input type="hidden" class="medium" name="admin_no" value="<?php echo $student['admission_number']; ?>"/></li>
                                        <li>Class-Section: <?php echo $class1['c_name'] . " - " . $row1['s_name']; ?><input type="hidden" class="medium" name="cid1" value="<?php echo $cid; ?>"/></li>
                                        <li>Gender: <?php
                                        if ($student['gender'] == 'M')
                                            echo "Male";
                                        else
                                            echo "Female";
                                        ?><input type="hidden" class="medium" name="bid1" value="<?php echo $bid; ?>"/></li>
                                    </ul>
                                    <ul class="client_details">
                                        <li>Student Name : <strong class="name"><?php echo $student['firstname'] . " " . $student['lastname']; ?></strong> <input type="hidden" class="medium" name="ss_name" value="<?php echo $student['firstname'] . " " . $student['lastname']; ?>"/></li>
                                        <li>Parent's Name: <?php echo $student['fathersname']; ?> </li>
                                        <li>Student Type : <b><?php echo $student['stype']; ?></b> Student <input type="hidden" class="medium" name="stype" value="<?php echo $student['stype']; ?>"/></li>
                                    </ul>
                                    <ul class="client_details">
                                        <li>Academic Year : <strong class="name"><?php echo $acyear_name; ?></strong><input type="hidden" class="medium" name="ssid1" value="<?php echo $ssid; ?>"/></li>
                                        <li>Student Type : <b><?php echo $student['stype']; ?></b> Student <input type="hidden" class="medium" name="stype" value="<?php echo $student['stype']; ?>"/></li>
                                        <li><strong>Date :</strong> <input id="datepicker" name="idate" type="text" value="<?php echo date("d/m/Y"); ?>"  style="width:60%"/></li>              										
                                    </ul>
                                    <ul class="client_details"></ul>
                                     <ul class="client_details"></ul>
                                      <ul class="client_details"></ul>
                                      <ul class="client_details"></ul>
                                      <ul class="client_details"></ul>
                                      <ul class="client_details"></ul>
                                    <ul class="client_details">
                                       <!-- <li><input class="btn btn-orange" type="button" style="width:120px" value="Full Discount"></li> -->
                                        
                                    </ul>
    <?php
    $classlist = mysql_query("SELECT * FROM frate WHERE fr_id=$frid");
    $class = mysql_fetch_array($classlist);
    $fg_id1 = $class['fg_id'];
    ?>
                                    <table id="table-example" class="table">
                                        <thead>
                                            <tr>
                                                <th width="5%">S.No</th>
                                                <th><center>Group Name</center></th>
                                        <th>Total</th>
                                        <th>Pending</th>
                                        <th>Discount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $allpending=0;
                                            $totalpending = 0;
                                            $totalfees = 0;
                                            $count = 1;
                                            $term1 = 0;
                                            $term2 = 0;
                                            $term3 = 0;
                                            if ($sfood) {
                                                $qry2 = mysql_query("SELECT * FROM fgroup_detail where fg_id!=4 AND otherfees='0'");
                                            } else {
                                                $qry2 = mysql_query("SELECT * FROM fgroup_detail where fg_id!=4 AND otherfees='0' AND food='0'");
                                            }
                                            $nofrow = mysql_num_rows($qry2);
                                            while ($row2 = mysql_fetch_array($qry2)) {
                                                $fgdid = $row2['fgd_id'];
                                                $type = $row2['type'];
                                                $ftype = "";
                                                if ($type) {
                                                    $ftype = " (New Student)";
                                                }
                                                $cartid = $fgdid . "1";
                                                ?>
                                                <tr style="border:1px #B7B7B7 dotted;">
                                                    <td><?= $count ?></td>
                                                    <td><?php echo $row2['name'] . $ftype; ?></td>
                                                    <?php
                                                    $select_record = mysql_query("SELECT * FROM fgroup LIMIT 0,3");
                                                    $total = 0;
                                                    $totalpending = 0;
                                                    while ($student12 = mysql_fetch_array($select_record)) {
                                                        $ffg_id = $student12['fg_id'];
                                                        $fratelist = mysql_query("SELECT fr_id,rate,rate1 FROM frate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid21 AND fg_id=$ffg_id AND fgd_id=$fgdid");
                                                        $frate = mysql_fetch_array($fratelist);

                                                        $frate1 = $frate[$rate];
                                                        if ($ffg_id == '1') {
                                                            $term1+=$frate[$rate];
                                                        } else if ($ffg_id == '2') {
                                                            $term2+=$frate[$rate];
                                                        } else if ($ffg_id == '3') {
                                                            $term3+=$frate[$rate];
                                                        }

                                                        $pending = 0;
                                                        $ptype = 1;
                                                        $paid = 0;
                                                        $qry5 = mysql_query("SELECT * FROM finvoice WHERE ss_id=$ssid AND c_id=$cid AND bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='0'");
                                                        while ($row5 = mysql_fetch_array($qry5)) {
                                                            $ffi_id = $row5['fi_id'];
                                                            $qry6 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id AND fgd_id=$fgdid AND fg_id=$ffg_id AND type='terms'");
                                                            $row6 = mysql_fetch_array($qry6);
                                                            $paid +=$row6['amount'];
                                                            $paid +=$row6['discount'];
                                                        }
                                                        if ($paid) {
                                                            $pending = $frate1 - $paid;
                                                        } else {
                                                            $pending = $frate1;
                                                        }
                                                        if ($pending > $frate1) {
                                                            $pending = $frate1;
                                                        } else if ($pending == 0) {
                                                            $ptype = 0;
                                                        }

                                                        // echo $pending."<br>";
                                                        $totalpending +=$pending;
                                                        $allpending+=$pending;
                                                        $total+=$frate[$rate];
                                                        $totalfees+=$frate[$rate];
                                                    }
                                                    ?>
                                                    <td><?php if ($total) {
                                                        echo $total;
                                                    } else {
                                                        echo " - ";
                                                    } ?></td>
                                                        <?php //if($count==1){
                                                        //$totalpending=termfees($bid,$cid,$sid21,$acyear,$s_type,$ssid);
                                                        ?>
                                                    <td rowspan="<?php //echo $nofrow;?>" style="vertical-align: middle;">
                                                <?= $totalpending ?>

                                                    </td>
                                                    <td rowspan="<?php //echo $nofrow;?>" style="vertical-align: middle;">
                                                <?php if ($totalpending) { ?>
                                                            <input type="text" name="fees<?= $cartid ?>" id="fees<?= $cartid ?>" class="biginput txt" id="autocomplete" class="required" value="" autocomplete="off" max="<?= $totalpending ?>" /><?php } else {
                                        echo "Fully Paid";
                                    } ?>
                                                    </td>
                                                <?php //} ?>
                                                </tr>
                                                <?php $count++;
                                            } ?>
                                            <?php
                                            $total = 0;
                                            if ($s_type == "New") {
                                                $qry2 = mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0'");
                                            } else {
                                                $qry2 = mysql_query("SELECT fgd_id,type,name FROM fgroup_detail where fg_id=4 AND otherfees='0' AND type='0'");
                                            }
                                            //$qry2=mysql_query("SELECT * FROM fgroup_detail where fg_id=4 AND otherfees='0' AND type='0'");													
                                            while ($row2 = mysql_fetch_array($qry2)) {
                                                $fgdid = $row2['fgd_id'];
                                                $type = $row2['type'];
                                                $ftype = "";
                                                if ($type) {
                                                    $ftype = " (New Student)";
                                                }
                                                $cartid = $fgdid . "4";
                                                ?>
                                                <tr style="border:1px #B7B7B7 dotted;">
                                                    <td><?= $count ?></td>
                                                    <td><?php echo $row2['name'] . $ftype; ?></td>
                                                    <?php
                                                    $fratelist = mysql_query("SELECT fr_id,rate,rate1 FROM frate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid21 AND fg_id=4 AND fgd_id=$fgdid");
                                                    $frate = mysql_fetch_array($fratelist);
                                                    $frate1 = $frate[$rate];
                                                    $total+=$frate[$rate];
                                                    $totalfees+=$frate[$rate];
                                                    $pending = 0;
                                                    $ptype = 1;
                                                    $paid = 0;
                                                    $qry5 = mysql_query("SELECT * FROM finvoice WHERE ss_id=$ssid AND c_id=$cid AND bid=$bid AND ay_id=$acyear AND c_status!='1' AND i_status='0'");
                                                    while ($row5 = mysql_fetch_array($qry5)) {
                                                        $ffi_id = $row5['fi_id'];
                                                        $qry6 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$ffi_id AND fgd_id=$fgdid AND fg_id=4 AND type='other'");
                                                        $row6 = mysql_fetch_array($qry6);
                                                        $paid +=$row6['amount'];
                                                        $paid +=$row6['discount'];
                                                    }
                                                    if ($paid) {
                                                        $pending = $frate1 - $paid;
                                                    } else {
                                                        $pending = $frate1;
                                                    }
                                                    if ($pending > $frate1) {
                                                        $pending = $frate1;
                                                    } else if ($pending == 0) {
                                                        $ptype = 0;
                                                    }


                                                    //echo $pending."<br>";

                                                    if ($pending && $ptype == "1") {
                                                        $pending1 = $pending;
                                                        //$paid=$total1-$pending;
                                                    } else if (!$pending && $ptype == "0") {
                                                        $pending1 = 0;
                                                    } else {
                                                        $pending1 = $total1;
                                                    }

                                                    //echo $pending1;
                                                    ?>
                                                    <td><?php if ($frate[$rate]) {
                                                        echo $frate[$rate];
                                                    } else {
                                                        echo " - ";
                                                    } ?></td>
                                                    <td><?= $pending1 ?></td>
                                                    <td><?php if ($pending1) { ?><input type="text" name="fees<?php echo $cartid; ?>" id="fees<?php echo $cartid; ?>" class="biginput txt" id="autocomplete" class="required" value="" autocomplete="off" max="<?= $pending1 ?>"/> <?php } else {
                                                        echo "Fully Paid";
                                                    } ?></td>
                                                </tr>
        <?php $count++;
    } ?>
                                            <tr>
                                                <td class="grand_total" colspan="4">Remark:</td>

                                                <td class="grand_total"><input type="text" class="medium" name="remark" id="remark" value=""/></td>
                                            </tr>
                                            <tr>
                                            <tr class="total_bar">
                                                <td class="grand_total" colspan="3"></td>
                                                <td class="grand_total">Total:</td>
                                                <td class="grand_total">Rs. <span id="fgtotal"></span><input type="hidden" class="medium" name="total" id="finaltotal" value=""/>
                                                <input type="hidden"  name="total_pending" value="<?= $allpending?>"/></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" align="right">
                                                    <span id="billpay" style="float:right">
                                                        <a href="discount_add.php?bid=<?= $bid ?>&cid=<?= $cids ?>" ><input type="button" value="cancel/Close" class="btn btn-red" style="width:120px"></a>&nbsp;&nbsp;
                                                        <input type="submit" value="Submit" name="submit" class="btn btn-green" onClick="return confirm('are you sure you wish to Submit this Details');" style="width:100px"></span>
                                                </td>
                                            </tr>
                                            <!-- *************************** Old Student Total End ************************** -->
                                        </tbody>
                                    </table>
                            </form>
                        </div>
<?php } ?>
                </div>


                <div class="clear height-fix"></div>

            </div></div> <!--! end of #main-content -->
    </div> <!--! end of #main -->


<?php include("includes/footer.php"); ?>
</div> <!--! end of #container -->

<!-- JavaScript at the bottom for fast page loading -->

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
<script src="js/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


<!-- scripts concatenated and minified via ant build script-->
<script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
<script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
<script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
<script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
<script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
<script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
<script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
<script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
<script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
<script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
<script defer src="js/common.js"></script> <!-- Generic functions -->
<script defer src="js/script.js"></script> <!-- Generic scripts -->
<script defer src="js/zebra_datepicker.js"></script>
<!-- end scripts-->
<script type="text/javascript">
                                                        $().ready(function () {

                                                            var validateform = $("#validate-form").validate();
                                                            $("#reset-validate-form").click(function () {
                                                                location.reload();
                                                            });
                                                            $("#datepicker").Zebra_DatePicker({
                                                                format: 'd/m/Y'
                                                            });
                                                            function currencyFormat(num) {
                                                                return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
                                                            }
                                                            $(".txt").each(function () {
                                                                $(this).keyup(function () {
                                                                    var textBoxVal = 0;
                                                                    var allInputs = document.getElementsByClassName("txt");
                                                                    //alert(allInputs.length);
                                                                    for (var i = 0; i < allInputs.length; i++)
                                                                        if (allInputs[i].type === "text") {
                                                                            var fvalue = allInputs[i].value;
                                                                            textBoxVal = Number(fvalue) + textBoxVal;
                                                                        }

                                                                    textBoxVal1 = currencyFormat(textBoxVal);
                                                                    $("#fgtotal").html(textBoxVal1);
                                                                    $("#finaltotal").val(textBoxVal);
                                                                    //alert(textBoxVal);
                                                                    //$('#billupdate').show();
                                                                    //$('#billpay').hide();
                                                                });
                                                            });
                                                        });

                                                        function change_function1() {
                                                            var cid = document.getElementById('cid').value;
                                                            window.location.href = 'discount_add.php?cid=' + cid + '&bid=<?php echo $bid; ?>';
                                                        }
                                                        function change_function2(n) {
                                                            window.location.href = 'discount_add.php?bid=<?php echo $bid; ?>&cid=<?php echo $cids; ?>&id=' + n;

                                                        }
</script>

<?php if (!$id) { ?>
    <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
    <script src="js/jquery-migrate-1.2.1.js"></script>
    <link rel="stylesheet" href="library/js/plugins/select2/select2.css" type="text/css" />
    <script src="library/js/plugins/select2/select2.js"></script> 
    <script type="text/javascript">
                                                            $().ready(function () {

                                                                $('#n_sid').select2({
                                                                    allowClear: true,
                                                                    placeholder: "Please Select..."
                                                                })
                                                                $('#o_sid').select2({
                                                                    allowClear: true,
                                                                    placeholder: "Please Select..."
                                                                })
                                                            });
    </script>
    <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
         chromium.org/developers/how-tos/chrome-frame-getting-started -->
    <!--[if lt IE 7 ]>
      <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
      <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->
<?php } ?>
</body>
</html>
<? ob_flush(); ?>