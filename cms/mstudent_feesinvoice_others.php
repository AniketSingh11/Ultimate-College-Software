<?php ob_start(); ?>
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
<?php
                    $cid = $_GET['cid'];
                    $sid = $_GET['sid'];
                    $bid = $_GET['bid'];
                    $ddlterm = $_GET["ddlterm"];
                    $feesub = $_GET["fees_sub"];
                    $status=$_GET['status'];
                    if ($cid && $sid) {
                        $classlist = mysql_query("SELECT * FROM class WHERE c_id=$cid");
                        $class = mysql_fetch_array($classlist);
                        $sectionlist = mysql_query("SELECT * FROM section WHERE s_id=$sid");
                        $section = mysql_fetch_array($sectionlist);
                        //echo $class['c_name']."-".$section['s_name'];
                    }

                                        if(!empty($ddlterm)){ 
                                        $qry = "SELECT s.firstname,s.admission_number,s.ss_id,c.c_name,c.c_id,s.stype,s.s_id,phone_number FROM student AS s 
                                                INNER JOIN class AS c on c.c_id=s.c_id AND c.ay_id=s.ay_id AND s.b_id=c.b_id WHERE s.ay_id='" . $acyear . "' ";
                                        if ($cid != "all") {
                                            $qry = $qry . " AND s.c_id='" . $cid . "'";
                                        }
                                        if ($sid != "all" && $sid != "Old") {
                                            $qry = $qry . "  AND s.s_id='" . $sid . "'";
                                        }
                                        if ($sid == "Old") {
                                            $qry = $qry . "  AND s.s_id!=0";
                                        }
                                        $qry = $qry . " AND s.b_id='" . $bid . "' ORDER BY s.c_id ASC";
                                        
                                        $result = mysql_query($qry);
                                        //echo $qry;
                                        $oin="SELECT * FROM finvoice_others as fin";
                                        $oin1=$oin;
                                        
                                        $result1 = mysql_query($oin);
                                        //echo $oin;
                                        $detail=array();
                                        $gdetail=array();
                                        while ($allin = mysql_fetch_assoc($result1)) {
                                            $detail[]=$allin;
                                        }
                                        $grt=mysql_query($oin1);
                                        while ($all = mysql_fetch_assoc($result)) {
                                            $gdetail[]=$all;
                                        }
                                        
                                       
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
					<span style="margin-left:20px;"><a href="mstudent_feesinvoice_download_others.php?cid=<?=$cid;?>&sid=<?=$sid?>&bid=<?=$bid?>&order_gender=<?=$order_gender?>&fees_sub=<?=$feesub?>&ddlterm=<?=$ddlterm?>&status=<?=$status?>" style ="width:100px"><button class="btn btn-small btn-green"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Report</button></a></span> 
					 <span style="margin-left:20px;"><a href="mstudent_feesinvoice_download_print_others.php?cid=<?=$cid;?>&sid=<?=$sid?>&bid=<?=$bid?>&order_gender=<?=$order_gender?>&fees_sub=<?=$feesub?>&ddlterm=<?=$ddlterm?>&status=<?= $status?>" style ="width:100px" target="_blank"><button class="btn btn-small btn-green"><img src="img/icons/packs/fugue/16x16/inbox-download.png">Print</button></a></span> 
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
                                        echo '<select name="cid" id="cid" class="required" onChange="showCategory(this.value)"> <option value="">Select Class</option>';
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
                                            <option value="Books, Notes & Other Items" selected=true>Books, Notes & Other Items</option>	
                                            
                                        </select>
                                    </p>
                                </div>
                                <div class="_50">
                                    <p>
                                        <label for="select">Status : <span class="error">*</span></label>
                                        <select name="status" id="ddlterm" class="required">
                                            <option>Select</option>  
                                            <option value="Fully">Fully Paid</option>
                                            <option value="Pending">Pending</option>
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
                    </div>
                    
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
                                            <th colspan="3">Books, Notes, Other Items</th>
                                            </tr>
                                            <tr>
                                                <th>Fees</th>
                                                <th>Paid</th>
                                                <th>Pending</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $n=1;
                                    foreach ($gdetail as $tmp) { ?>
                                     <?php
                                            $cidd=$tmp['c_id'];
                                            $sid=$tmp['s_id'];

                                            $getsec=mysql_query("select * from section where s_id=$sid AND c_id=$cid");
                                            $gname=mysql_fetch_assoc($getsec)['g_name'];
                                           //echo "select * from others_bill_all where std=$cidd AND gname=$gname";
                                            $clss = mysql_query("select * from others_bill_all where std=$cidd AND gname='$gname' AND ay_id=$acyear");
                                            $ans=mysql_fetch_array($clss)['amount'];
                                            $paid=0;
                                            foreach ($detail as $sub) {
                                                if($tmp['ss_id']==$sub['ss_id']){
                                                    $paid+=$sub['fi_total']+$sub['discount'];
                                                }
                                            }
                                            $ssidd=$tmp['ss_id'];
                                            $sql=mysql_query("select * from discount_others where ay_id='$acyear' AND ss_id='$ssidd' AND status=0");
                                            $disalloc=mysql_fetch_assoc($sql);
                                            if($disalloc['total'])
                                                $paid=$paid+$disalloc['total'];
                                            
                                            $pen=$ans-$paid;
                                            if($ans) {
                                            if($status=="Fully" && $pen==0){ 
                                        ?>
                                        <tr>
                                        <td><?php echo $n;?></td>
                                        <td><?php echo $tmp['admission_number'];?></td>
                                        <td><?php echo $tmp['firstname']?></td>
                                        <td><?php echo $tmp['c_name']?></td>
                                        <td><?php echo $tmp['stype']?></td>
                                        <td><?php echo $tmp['phone_number']?></td>

                                        <td>
                                            <?php echo $ans;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $ssidd=$tmp['ss_id'];
                                            $sql=mysql_query("select * from discount_others where ay_id='$acyear' AND ss_id='$ssidd' AND status=0");
                                            $disalloc=mysql_fetch_assoc($sql);
                                            $disapp=0;
                                            foreach ($detail as $sub) {
                                                if($tmp['ss_id']==$sub['ss_id']){
                                                    $disapp+=$sub['discount'];
                                                }
                                            }
                                            if($disalloc['total']){
                                                $distot=$disalloc['total']+$disapp;
                                                echo $paid.' ( * : '.$distot.')';
                                            }
                                            else{
                                                //$disaloc=$disalloc['total'];
                                                if($disapp!=0)
                                                    echo $paid.' ( * : '.$disapp.')';
                                                else
                                                    echo $paid;
                                            }
                                            ?>
                                        </td>
                                        <td><?php
                                          
                                          if($pen==0)
                                            echo "<center>-</center>";
                                          else
                                          echo $ans-$paid;
                                           ?> 
                                        </td>
                                        </tr>
                                    <?php $n++; } if($status=="Pending" && $pen!=0) { ?>
                                        <tr>
                                        <td><?php echo $n;?></td>
                                        <td><?php echo $tmp['admission_number'];?></td>
                                        <td><?php echo $tmp['firstname']?></td>
                                        <td><?php echo $tmp['c_name']?></td>
                                        <td><?php echo $tmp['stype']?></td>
                                        <td><?php echo $tmp['phone_number']?></td>

                                        <td>
                                            <?php echo $ans;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $ssidd=$tmp['ss_id'];
                                            $sql=mysql_query("select * from discount_others where ay_id='$acyear' AND ss_id='$ssidd' AND status=0");
                                            $disalloc=mysql_fetch_assoc($sql);
                                            $disapp=0;
                                            foreach ($detail as $sub) {
                                                if($tmp['ss_id']==$sub['ss_id']){
                                                    $disapp+=$sub['discount'];
                                                }
                                            }
                                            if($disalloc['total']){
                                                $distot=$disalloc['total']+$disapp;
                                                echo $paid.' ( * : '.$distot.')';
                                            }
                                            else{
                                                //$disaloc=$disalloc['total'];
                                                if($disapp!=0)
                                                    echo $paid.' ( * : '.$disapp.')';
                                                else
                                                    echo $paid;
                                            }
                                            ?>
                                        </td>
                                        <td><?php
                                          
                                          if($pen==0)
                                            echo "<center>-</center>";
                                          else
                                          echo $ans-$paid;
                                           ?> 
                                        </td>
                                        </tr>
                                    <?php } if($status=="Select") { ?>
                                        <tr>
                                        <td><?php echo $n;?></td>
                                        <td><?php echo $tmp['admission_number'];?></td>
                                        <td><?php echo $tmp['firstname']?></td>
                                        <td><?php echo $tmp['c_name']?></td>
                                        <td><?php echo $tmp['stype']?></td>
                                        <td><?php echo $tmp['phone_number']?></td>

                                        <td>
                                            <?php echo $ans;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $ssidd=$tmp['ss_id'];
                                            $sql=mysql_query("select * from discount_others where ay_id='$acyear' AND ss_id='$ssidd' AND status=0");
                                            $disalloc=mysql_fetch_assoc($sql);
                                            $disapp=0;
                                            foreach ($detail as $sub) {
                                                if($tmp['ss_id']==$sub['ss_id']){
                                                    $disapp+=$sub['discount'];
                                                }
                                            }
                                            if($disalloc['total']){
                                                $distot=$disalloc['total']+$disapp;
                                                echo $paid.' ( * : '.$distot.')';
                                            }
                                            else{
                                                //$disaloc=$disalloc['total'];
                                                if($disapp!=0)
                                                    echo $paid.' ( * : '.$disapp.')';
                                                else
                                                    echo $paid;
                                            }
                                            ?>
                                        </td>
                                        <td><?php
                                          
                                          if($pen==0)
                                            echo "<center>-</center>";
                                          else
                                          echo $ans-$paid;
                                           ?> 
                                        </td>
                                        </tr>
                                    <?php }
                                    $n++;
                                    }
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
            //alert(str);
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
<?php ob_flush(); ?>