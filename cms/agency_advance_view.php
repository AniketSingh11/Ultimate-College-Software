<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php");
//echo $_SESSION['uname'];

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
                    <li class="no-hover"><a href="agency.php" title="Home">Agency list</a></li>
                    <li class="no-hover"> Advance Payment</li>
                </ul>
            </div> <!--! end of #title-bar -->

            <div class="shadow-bottom shadow-titlebar"></div>

            <!-- Begin of #main-content -->
            <div id="main-content">
                <div class="container_12">

                    <div class="grid_12">
                        <h1>Advance Payment</h1>                
                        <a href="agency.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
                                <h1>Advance Payment</h1><span></span>
                            </div>
                            <div class="block-content">
                                <table id="table-example" class="table">
                                    <thead>
                                        <tr>
                                            <th><center>S.No</center></th>
                                            <th><center>Agency Name</center></th>
                                            <th><center>Advance Amount</center></th>
                                            <th><center>Date</center></th>
                                            <th><center>Action</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $aid = $_GET['aid'];
                                        //echo $aid;
                                        $a_qry = "SELECT * FROM agency_advance left join agency on (agency_advance.a_id=agency.a_id) 
                                                where agency.a_id=$aid ";
                                        //die;
                                        $qry = mysql_query($a_qry);
                                        $count = 1;
                                        while ($row = mysql_fetch_array($qry)) {
                                            ?>
                                            <tr class="gradeX">
                                                <td class="sno center"><center><?php echo $count; ?></center></td>
                                        <td><center><?php echo $row['a_name']; ?></center></td>
                                        <td><center><?php echo $row['adv_amt']; ?></center></td>
                                        <td><center><?php echo date("d-m-Y", strtotime($row['adv_date'])); ?></center></td>
                                        
                                        <td class="action">
                                            <!--<a href="agency_edit.php?aid=<?php echo $row['adv_id']; ?>" title="Edit"><img src="./img/edit.png" alt="edit"></a>--> 
                                            <a href="agency_advance_prt.php?aid=<?php echo $row['adv_id']; ?>" title="Print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                            <!--<a href="agency_delete.php?aid=<?php echo $row['adv_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>-->
                                        </td>
                                        </tr> 
                                        <?php
                                        $count++;
                                    }
                                    ?>                               																
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="clear height-fix"></div>
                </div></div> <!--! end of #main-content -->
        </div> <!--! end of #main -->
        <?php include("includes/footer.php"); ?>
    </div> <!--! end of #container -->

    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
    <script>
                                            $.noConflict();
                                            jQuery(document).ready(function($) {
                                                $('#table-example').dataTable();
                                                // Code that uses jQuery's $ can follow here.
                                            });
                                            // Code that uses other library's $ can follow here.
    </script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>

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

                                                //           $('#table-example').dataTable();

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