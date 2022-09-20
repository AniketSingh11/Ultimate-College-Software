<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php");
?>
<link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
<style type="text/css">
    .table tr{
        border:1px #B7B7B7 dotted !important;
    }
</style>
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
            /* $bid=$_GET['bid'];
              $boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid");
              $board=mysql_fetch_assoc($boardlist); */
            ?>
            <!-- Begin of titlebar/breadcrumbs -->
            <div id="title-bar">
                <ul id="breadcrumbs">
                    <li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                    <li>Cashier Report</li>
                </ul>
            </div> <!--! end of #title-bar -->

            <div class="shadow-bottom shadow-titlebar"></div>		
            <!-- Begin of #main-content -->
            <div id="main-content">
                <div class="container_12">
                    <div class="grid_12">
                        <div class="block-border">
                            <div class="block-header">
                                <h1>Select Today</h1><span></span>
                            </div>
                            <form id="validate-form" class="block-content form" action="" method="get" action="">
                                <div class="_25">
                                    <p>
                                        <label for="select">Start Date : <span class="error">*</span></label>
                                        <input id="datepicker" name="sdate" class="required" type="text" value="<?php echo date("d/m/Y"); ?>" /> 	
                                    </p>
                                </div>
                                <div class="_25">
                                    <p>
                                        <label for="select">End Date : <span class="error">*</span></label>
                                        <input id="datepicker1" name="edate" class="required" type="text" value="<?php echo date("d/m/Y"); ?>" />    
                                    </p>
                                </div>
<div class="_50">
                                    <p>
                                        <label for="select">Cashier : <span class="error">*</span></label>
                                        <select name="cashier" class="required">

                                            <option>Select</option>
<?php 
        // dev-sri
        $fi_by=array();
        
        $feeslist = mysql_query("SELECT * FROM finvoice WHERE ay_id=$acyear and c_status!='1' AND i_status='0'");
        while ($fees = mysql_fetch_assoc($feeslist)) {
            $feeby=$fees['fi_by'];
            if(in_array($feeby, $fi_by)){
            }
                else{
                    $fi_by[]=$feeby;
                }
        }
        $booklist1 = mysql_query("SELECT * FROM bfinvoice WHERE ay_id=$acyear AND c_status!='1' AND i_status='0'");
        while ($bus1 = mysql_fetch_assoc($booklist1)) {
          $feeby=$bus1['bfi_by'];
            if(in_array($feeby, $fi_by)){}
                else{
                    $fi_by[]=$feeby;
                }  
        }

        $feeslist1 = mysql_query("SELECT * FROM exponses WHERE ay_id='$acyear'");
                                                    while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                        $feeby=$fees1['billgenerate'];
                                                if(in_array($feeby, $fi_by)){}
                                                else{
                                                    $fi_by[]=$feeby;
                                                    }  
                                                } ?>
                                        <?php foreach($fi_by as $tmp) { 
                                            if($tmp!="") {
                                            ?>
                                              <option value="<?= $tmp?>"><?= $tmp?></option> 
                                              <?php } ?>
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
                                        <li><input type="submit" class="button" value="Submit"></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                    $sdate = $_GET['sdate'];
                    $edate = $_GET['edate'];
                    $cashier=$_GET['cashier'];
                    $sdate_split1 = explode('/', $sdate);
                    $sdate_month = $sdate_split1[1];
                    $sdate_day = $sdate_split1[0];
                    $sdate_year = $sdate_split1[2];
                    $startdate = $sdate_year . $sdate_month . $sdate_day;
                    $startdate1 = $sdate_year . "-" . $sdate_month . "-" . $sdate_day;

                    $edate_split1 = explode('/', $edate);
                    $edate_month = $edate_split1[1];
                    $edate_day = $edate_split1[0];
                    $edate_year = $edate_split1[2];

                    $enddate = $edate_year . $edate_month . $edate_day;
                    $enddate1 = $edate_year . "-" . $edate_month . "-" . $edate_day;

                    if ($sdate && $edate) {
                        ?>
                        <div class="grid_12">
                             <h1>Cashier Income And Expenses </h1>
                             <span style="margin:0px 50px 10px 0px; float:right;"><img src="img/icons/packs/fugue/16x16/calendar-next.png"> End Date : <strong> <?php echo$edate; ?></strong></span> 
                            <span style="margin:0px 50px 10px 0px; float:right;"><img src="img/icons/packs/fugue/16x16/calendar-next.png"> Start Date : <strong> <?php echo$sdate; ?></strong></span>
                            <div id="invoice" class="widget widget-plain">			
                                <br>
                                <div class="widget-content">

    <?php 
        // dev-sri
        $fi_by=array();
        
        $feeslist = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0'");
        while ($fees = mysql_fetch_assoc($feeslist)) {
            $feeby=$fees['fi_by'];
            if(in_array($feeby, $fi_by)){
            }
                else{
                    $fi_by[]=$feeby;
                }
        }
        $booklist1 = mysql_query("SELECT * FROM bfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear AND c_status!='1' AND i_status='0'");
        while ($bus1 = mysql_fetch_assoc($booklist1)) {
          $feeby=$bus1['bfi_by'];
            if(in_array($feeby, $fi_by)){}
                else{
                    $fi_by[]=$feeby;
                }  
        }

        $feeslist1 = mysql_query("SELECT * FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "'");
                                                    while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                        $feeby=$fees1['billgenerate'];
                                                if(in_array($feeby, $fi_by)){}
                                                else{
                                                    $fi_by[]=$feeby;
                                                    }  
                                                }

        
        if($cashier!="Select"){
            unset($fi_by);
            $fi_by=array();
            $fi_by[]=$cashier;
        }
        //echo '<pre>';
        //print_r($fi_by);
        //echo '</pre>';
        if(count($fi_by)!=0) {
        ?>
        <table class="table table-striped" id="table-example">  
                                        <thead>
                                            <tr>
                                                <th width="5%">S.No</th>
                                                <th width="50%"><center>Cashier</center></th>
                                        <th class="total"><center>Income</center></th>
                                        <th class="total"><center>Expenses</center></th>
                                        <th class="total"><center>Total</center></th>
                                        </tr>
                                        </thead>                        
                                        <tbody>
                                        <?php 
                                        $n=1;
                                        foreach($fi_by as $tmp) { ?>
                                        <tr>
                                        <td><?= $n?></td>
                                        <td><?= $tmp?></td>
                                        <td>
                                            <?php
                                            $cash=0;
                                            $card=0;
                                            $cheque=0;
                                            $feeslist = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0'");
                                            while ($fees = mysql_fetch_assoc($feeslist)) {
                                            $by=$fees['fi_by'];
                                            if($by==$tmp) {
                                            $fi_id = $fees['fi_id'];
                                                    $feesummarry = mysql_query("SELECT amount FROM fsalessumarry WHERE fi_id=$fi_id");
                                                    while ($fsummarry = mysql_fetch_assoc($feesummarry)) {
                                                        $amount = $fsummarry['amount'];
                                                        if($fees['fi_ptype']=="cash")
                                                            $cash += $amount;
                                                        if($fees['fi_ptype']=="card")
                                                            $card += $amount;
                                                        if($fees['fi_ptype']=="cheque")
                                                            $cheque += $amount;
                                                    } 
                                                } 
                                            }
                                            $feeslist = mysql_query("SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0'");
                                            while ($fees = mysql_fetch_assoc($feeslist)) {
                                            $by=$fees['fi_by'];
                                            if($by==$tmp) {
                                            $fi_id = $fees['fi_id'];
                                                        $amount = $fees['fi_total'];
                                                        if($fees['fi_ptype']=="cash")
                                                            $cash += $amount;
                                                        if($fees['fi_ptype']=="card")
                                                            $card += $amount;
                                                        if($fees['fi_ptype']=="cheque")
                                                            $cheque += $amount;  
                                                } 
                                            }
                                            $booklist1 = mysql_query("SELECT * FROM bfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear AND c_status!='1' AND i_status='0'");
                                            
                                            while ($bus1 = mysql_fetch_assoc($booklist1)) {
                                                 $by=$bus1['bfi_by'];
                                                if($by==$tmp){
                                                $amount=$bus1['fi_total'];
                                                        if($bus1['fi_ptype']=="cash")
                                                            $cash += $amount;
                                                        if($bus1['fi_ptype']=="card")
                                                            $card += $amount;
                                                        if($bus1['fi_ptype']=="cheque")
                                                            $cheque += $amount;
                                                    }
                                            }
                                           $ans=$cash;
                                            if( ($card!=0) && ($cheque!=0) )
                                                $ans=$cash.'( Card- '.$card.', Cheque- '.$cheque.')'; 
                                            else if($card!=0)
                                                 $ans=$cash.'(Card- '.$card.')'; 
                                             else if($cheque!=0)
                                                $ans=$cash.'(Cheque- '.$cheque.')'; 
                                            if($ans!=0)
                                                    echo $ans;
                                                else 
                                                    echo '-';
                                            $inc=$cash;
                                            ?>
                                        </td>
                                        <td>
                                        <?php
                                        $cash=0;
                                        $card=0;
                                        $cheque=0;
                                          $feeslist1 = mysql_query("SELECT * FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND type=0");
                                                   
                                                    while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                        $feeby=$fees1['billgenerate']; 
                                                        if($feeby==$tmp){
                                                        $amount=$fees1['amount'];
                                                        if($fees1['p_type']=="cash")
                                                            $cash += $amount;
                                                        if($fees1['p_type']=="card")
                                                            $card += $amount;
                                                        if($fees1['p_type']=="cheque")
                                                            $cheque += $amount;
                                                        }
                                                    }
                                               $feeslist2 = mysql_query("SELECT * FROM exponses_bill WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "'");
                                                   
                                                    while ($fees2 = mysql_fetch_assoc($feeslist2)) {
                                                        $feeby=$fees2['billgenerate']; 
                                                        if($feeby==$tmp){
                                                        $amount=$fees2['amount'];
                                                        if($fees2['p_type']=="cash")
                                                            $cash += $amount;
                                                        if($fees2['p_type']=="card")
                                                            $card += $amount;
                                                        if($fees2['p_type']=="cheque")
                                                            $cheque += $amount;
                                                        }
                                                    } 
                                            $ans=$cash;
                                            if( ($card!=0) && ($cheque!=0) )
                                                $ans=$cash.'( Card- '.$card.', Cheque- '.$cheque.')'; 
                                           else if($card!=0)
                                                 $ans=$cash.'(Card- '.$card.')'; 
                                            else if($cheque!=0)
                                                $ans=$cash.'(Cheque- '.$cheque.')'; 
                                                if($ans!=0)
                                                    echo $ans;
                                                else 
                                                    echo '-';
                                            $exp=$cash;       
                                        ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(($inc-$exp)>0)
                                                    echo  $inc-$exp;
                                                else 
                                                    echo '-';
                                            ?>
                                        </td></tr>
                                        <?php 
                                        $n++;
                                        } ?>
                                        </tbody>
                                        </table>
                                        <?php } ?>
                           <form action="cashier_report_prt.php" method="post">
                           <input type="hidden" name="sdate" value="<?= $sdate?>">
                           <input type="hidden" name="edate" value="<?= $edate?>">
                           <input type="hidden" name="cashier" value="<?= $cashier?>">
                         <div class="_25" style="float: right;">
                                    <p>
                                        <label for="select">Amount Given<span class="error">*</span></label>
                                        <input id="" name="amount" class="required" type="text" value="" />    
                                    </p>
                                </div>
                                <br><br><br>
                                <input type="submit" value="Save" name="save" class="btn btn-green" style="width:150px"> 
                          
                            
                         </form>
                            <div class="clear height-fix"></div>
                        </div>
                        </div></div>
        <?php } ?>

                </div>
            </div> <!--! end of #main-content -->
        </div> <!--! end of #main -->
        <?php include("includes/footer.php");
?>              
</div>
</div>


    </div> <!--! end of #container -->


    <!-- JavaScript at the bottom for fast page loading -->

    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script src="js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


    <!-- scripts concatenated and minified via ant build script-->
    <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
    <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>
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
    <script type="text/javascript">
        $().ready(function() {

            var validateform = $("#validate-form").validate();
            $("#reset-validate-form").click(function() {
                validateform.resetForm();
                $.jGrowl("Form was Reset.", {theme: 'error'});
            });
            /*
             * Datepicker
             */
            $("#datepicker").Zebra_DatePicker({
                format: 'd/m/Y'
            });
            $("#datepicker1").Zebra_DatePicker({
                format: 'd/m/Y'
            });
        });
    </script>
    <!-- end scripts-->

    <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
         chromium.org/developers/how-tos/chrome-frame-getting-started -->
    <!--[if lt IE 7 ]>
      <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
      <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->  
</body>
</html>
<? ob_flush(); ?>