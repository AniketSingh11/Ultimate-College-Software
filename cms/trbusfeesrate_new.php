<? ob_start(); ?>
<?php //phpinfo(); ?>
<?php

error_reporting(E_ALL ^ E_NOTICE);

include("head_top.php");
//echo $_SESSION['uname'];
$montharray = array("", "June", "July", "August", "September", "October", "November", "December", "January", "February", "March", "April", "May");

if (isset($_POST['submit'])) {

    $ftyid = $_POST['ftyid'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    $qry = mysql_query("SELECT * FROM trstopping");
    
    $count = 1;
    while ($row = mysql_fetch_array($qry)) {
        $fdis = "busfees" . $count;
        $fdisvalue = $_POST[$fdis];
        $sp = "spfees" . $count;
        $spvalue = $_POST[$sp];
        $otsp = "onetimespfees" . $count;
        $otspvalue = $_POST[$otsp];
        $otfee = "onetime" . $count;
        $otfeesvalue = $_POST[$otfee];
        $spid = "spid" . $count;
        $spids = $_POST[$spid];
        $rid = $row['r_id'];
        //echo "<br>";
        $bus_qry = "SELECT * FROM trbusfees WHERE sp_id=$spids AND ay_id=$acyear";
        //die;
        $busfeeslist = mysql_query($bus_qry);
        $busfees = mysql_fetch_array($busfeeslist);
        $bfid = $busfees['bf_id'];
        if ($bfid) {
            $sql = "UPDATE trbusfees SET fees='$fdisvalue',sp_fees='$spvalue',sp_fees_onetime='$otspvalue',one_time='$otfeesvalue',r_id='$rid',ftyid='$ftyid',start='$start',end='$end' WHERE bf_id='$bfid'";
            $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
        } else {
            echo $sql = "INSERT INTO trbusfees (fees,sp_fees,sp_fees_onetime,one_time,sp_id,r_id,ftyid,status,ay_id,start,end) VALUES ('$fdisvalue','$spvalue','$otspvalue','$otfeesvalue','$spids','$rid','$ftyid','1','$acyear','$start','$end')";
            $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
        }
        $count++;
    }

    if ($result) {
        header("Location:trbusfeesrate_new.php?msg=succ");
    }
    exit;
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
            <!-- Begin of titlebar/breadcrumbs -->
            <div id="title-bar">
                <ul id="breadcrumbs">
                    <li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                    <li class="no-hover"><a href="trbus_feesrate.php" title="Bus Fees Rate">Bus Fees Rate</a></li>
                    <li class="no-hover">Add New Bus Fees Rate </li>
                </ul>
            </div> <!--! end of #title-bar -->

            <div class="shadow-bottom shadow-titlebar"></div>

            <!-- Begin of #main-content -->
            <div id="main-content">
                <div class="container_12">			
                    <div class="grid_12">
                        <h1>Add New Bus Fees Rate </h1>                
                        <a href="trbus_feesrate.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                    </div>
                    <div class="grid_12">
                        <?php
                        $msg = $_GET['msg'];
                        if ($msg == "succ") {
                            ?>			
                            <div class="alert success"><span class="hide">x</span>Your Record Successfully Created!!!</div>
                        <?php } ?>

                        <div class="block-border">
                            <div class="block-header">
                                <h1>Add New Stopping Place</h1><span></span>
                            </div>
                            <form id="validate-form" class="block-content form" action="" method="post">
                                <div class="_100">
                                    <p>
                                    <table id="table-example" class="table">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th><center>From</center></th>
                                        <th><center>Stopping Name</center></th>
                                        <th class="action"><center>Normal Fees</center></th>
                                        <th class="action"><center>Sp.Fees</center></th>
                                        <th class="action"><center>Onetime Sp.Fees</center></th>
                                        <th class="action"><center>Onetime Fees</center></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $qry_s = mysql_query("SELECT * FROM trstopping");
                                            $count = 1;
                                            while ($row_s = mysql_fetch_array($qry_s)) {
                                                $spid = $row_s['stop_id'];
                                                $busfeeslist = mysql_query("SELECT * FROM trbusfees WHERE sp_id=$spid AND ay_id=$acyear");
                                                $busfees = mysql_fetch_array($busfeeslist);
                                                $ftyid = $busfees['ftyid'];
                                                $end = $busfees['end'];
                                                ?>
                                                <tr class="gradeX">
                                                    <td class="sno center"><center><?php echo $count; ?></center></td>
                                            <td><center>From School</center></td>
                                            <td><center><?php echo $row_s['stop_name']; ?></center></td>
                                            <td><center>
                                                <input id="textfield<?php echo $count; ?>" name="busfees<?php echo $count; ?>" class="" type="text" value="<?php
                                                if ($busfees['fees']) {
                                                    echo $busfees['fees'];
                                                }
                                                ?>" />
                                            </center>
                                            </td>
                                            <td>
                                            <center>
                                                <input id="textfield<?php echo $count; ?>" name="spfees<?php echo $count; ?>" class="" type="text" value="<?php
                                                if ($busfees['sp_fees']) {
                                                    echo $busfees['sp_fees'];
                                                }
                                                ?>" />
                                            </center>
                                            </td>
                                            <td><center>
                                                <input id="textfield<?php echo $count; ?>" name="onetimespfees<?php echo $count; ?>" class="" type="text" value="<?php
                                                if ($busfees['sp_fees_onetime']) {
                                                    echo $busfees['sp_fees_onetime'];
                                                }
                                                ?>" />
                                            </center>
                                            </td>
                                            <td><center>
                                                <input id="textfield<?php echo $count; ?>" name="onetime<?php echo $count; ?>" class="" type="text" value="<?php
                                                if ($busfees['one_time']) {
                                                    echo $busfees['one_time'];
                                                }
                                                ?>" />
                                            </center>
                                            </td>
                                            <input type="hidden" name="spid<?php echo $count; ?>" value="<?php echo $spid; ?>" />
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        ?>                              																
                                        <input type="hidden" name="rid" value="<?php echo $rid; ?>" />
                                        </tbody>
                                    </table></p>
                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Fees Type <span class="error">*</span></label>
                                        <select name="ftyid" class="required">
                                            <option value="">Select Fees Type</option>
                                            <?php
                                            $qry1 = mysql_query("SELECT * FROM ftype");
                                            $count = 1;
                                            while ($row1 = mysql_fetch_array($qry1)) {
                                                if ($ftyid == $row1['fty_id']) {
                                                    ?>
                                                    <option value="<?php echo $ftyid; ?>" selected><?php echo $row1['fty_name']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $row1['fty_id']; ?>"><?php echo $row1['fty_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </p>
                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">Start Month <span class="error">*</span></label>
                                        <select name="start" id="start" class="required">
                                            <option value="1" ><?php echo $montharray[1] ?></option>
                                        </select>
                                    </p>
                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="textfield">End Month <span class="error">*</span></label>
                                        <select name="end" id="end" class="required">
                                            <?php
                                            for ($cmonth = 1; $cmonth <= 12; $cmonth++) {
                                                ?>
                                                <option value="<?php echo $cmonth; ?>" <?php
                                                if ($cmonth == $end) {
                                                    echo 'selected="selected"';
                                                } else if (($cmonth == 12) && (($end == 12) || !$end)) {
                                                    echo 'selected="selected"';
                                                }
                                                ?> ><?php echo $montharray[$cmonth] ?></option>
                                                    <?php } ?>	
                                        </select>
                                    </p>
                                </div> 

                                <div class="clear"></div>
                                <div class="block-actions">
                                    <ul class="actions-left">
                                        <li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
                                    </ul>
                                    <ul class="actions-left">
                                        <li><input type="submit" name="submit" class="button" value="Submit"></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
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

    <!-- end scripts-->
    <script type="text/javascript">
        $().ready(function() {

            var validateform = $("#validate-form").validate();
            $("#reset-validate-form").click(function() {
                validateform.resetForm();
                $.jGrowl("Form was Reset.", {theme: 'error'});
            });
        });
    </script>

    <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
         chromium.org/developers/how-tos/chrome-frame-getting-started -->
    <!--[if lt IE 7 ]>
      <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
      <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->

</body>
</html>
<? ob_flush(); ?>