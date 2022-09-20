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
                    <li> Income & Expense Ledger in Particular Date </li>
                </ul>
    <!--<a href="balance_finance_sheet.php" class="btn btn-green" style="float:right; color:#FFFFFF" target="_blank"> <?/*=$acyear_name*/?> finance Year Full Ledger</a>-->
            </div> <!--! end of #title-bar -->

            <div class="shadow-bottom shadow-titlebar"></div>		
            <!-- Begin of #main-content -->
            <div id="main-content">
                <div class="container_12">
                    <div class="grid_12">
                        <div class="block-border">
                            <div class="block-header">
                                <h1>Select Date</h1><span></span>
                            </div>
                            <form id="validate-form" class="block-content form" action="" method="get" action="">
                                <div class="_50">
                                    <p>
                                        <label for="select">Date : <span class="error">*</span></label>
                                        <input id="datepicker" name="sdate" class="required" type="text" value="" /> 	
                                    </p>
                                </div>
                                <div class="_50">
                                    <p>
                                            <!--<label for="select">End Date : <span class="error"></span></label>
           <input id="datepicker1" name="edate" class="" type="text" value="" /> 	-->
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
                    $edate = $_GET['sdate'];

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
                            <h1>Income & Expense Ledger in Particular Date </h1>
                            <span style="margin:0px 50px 10px 0px; float:right;"><!--<img src="img/icons/packs/fugue/16x16/calendar-next.png">Date : <strong> <?php /* echo $sdate; */ ?></strong> |-->  <img src="img/icons/packs/fugue/16x16/calendar-previous.png"> Date : <strong><?php echo $sdate; ?></strong></span> 
                            <div id="invoice" class="widget widget-plain">			
                                <br>
                                <div class="widget-content">
                                    <table class="table table-striped" id="table-example">	
                                        <thead>
                                            <tr>
                                                <th width="5%">S.No</th>
                                                <th width="50%"><center>Particular</center></th>
                                        <th class="total"><center>Expenses</center></th>
                                        <th class="total"><center>Income</center></th>
                                        <th class="total"><center>Assets</center></th>
                                        </tr>
                                        </thead>						
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            $total = 0;
                                            $indisplay = 1;
                                            /*                                             * *******************************Other Fees******************************* */
                                            $qry5 = mysql_query("SELECT fgd_id,name,fg_id FROM fgroup_detail");
                                            while ($row5 = mysql_fetch_assoc($qry5)) {
                                                if($row5['fg_id']==4) {
                                                $fgd_id = $row5['fgd_id'];
                                                $fg_amount = 0;
                                                $feeslist = mysql_query("SELECT fi_id FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0'");
                                                while ($fees = mysql_fetch_assoc($feeslist)) {
                                                    $fi_id = $fees['fi_id'];
                                                    $feesummarry = mysql_query("SELECT amount FROM fsalessumarry WHERE fi_id=$fi_id AND fgd_id=$fgd_id");
                                                    while ($fsummarry = mysql_fetch_assoc($feesummarry)) {
                                                        $amount = $fsummarry['amount'];
                                                        $fg_amount += $amount;
                                                    }
                                                }

                                                if ($fg_amount != 0) {
                                                    $total += $fg_amount;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>			
                                                        <td><center><?php echo $row5['name']; ?></center></td>
                                                <td class="total"><center>-</center></td>
                                                <td class="total">Rs. <?php echo number_format($fg_amount, 2); ?></td>
                                                <td class="total"><center>-</center></td>
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        }
                                        }
                                        $fg_amount_cl = 0;
                                                $fg_amount_cm = 0;
                                                $fg_amount_ch = 0;
                                                $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CL%'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($fsummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['amount'];
                                                        $fg_amount_cl += $amount;
                                                        }
                                                    }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_cl != 0) {
                                            $total += $fg_amount_cl;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td><center>KG Term Fees (<?= $frmmto?>)</center></td>
                                                <td class="total"><center>-</center></td>
                                            <td class="total">Rs. <?php echo number_format($fg_amount_cl, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                        $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CM%'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($fsummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['amount'];
                                                        $fg_amount_cm += $amount;
                                                        }
                                                    }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_cm != 0) {
                                            $total += $fg_amount_cm;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td><center>HS Term Fees (<?= $frmmto?>)</center></td>
                                                <td class="total"><center>-</center></td>
                                            <td class="total">Rs. <?php echo number_format($fg_amount_cm, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                                $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CH%'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($fsummarry1['fg_id']==4){}
                                                        else{
                                                        $amount = $fsummarry1['amount'];
                                                        $fg_amount_ch += $amount;
                                                        }
                                                    }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_ch != 0) {
                                            $total += $fg_amount_ch;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td><center>HSS Term Fees (<?= $frmmto?>)</center></td>
                                                <td class="total"><center>-</center></td>
                                            <td class="total">Rs. <?php echo number_format($fg_amount_ch, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                             
                                        
                                        $other=mysql_query("SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' and c_status!='1' AND i_status='0'");

                                        $book=0;
                                        $from='';
                                        $to='';
                                        $fromto='';
                                        $n=1;
                                        while($all=mysql_fetch_assoc($other)){
                                           if($n==1){
                                             $from=$all['fr_no'];
                                         }
                                             $to=$all['fr_no'];
                                         $n++;
                                            $book+=$all['fi_total'];
                                           
                                        }
                                        if($from==$to)
                                            $fromto=$from;
                                        else
                                            $fromto=$from.'-'.$to;
                                        if($book!=0) {
                                        ?>
                                        <tr>
                                                    <td><?php echo $count; $count++;?></td>          
                                                    <td><center>Books, Notes & Other Items Fees (<?= $fromto?>)</center></td>
                                                <td class="total"><center>-</center></td>
                                                <td class="total">Rs. <?php echo number_format($book, 2); ?></td>
                                                <td class="total"><center>-</center></td>
                                                </tr>
                                        <?php } ?> 
                                        <?php 
                                        $other=mysql_query("SELECT * FROM tc_xi WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "'");

                                        $tc=0;
                                        
                                        while($all=mysql_fetch_assoc($other)){
                                           
                                            $tc+=$all['tc_amount'];
                                           
                                        }
                                        
                                        $other=mysql_query("SELECT * FROM tc_xi_kg WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "'");

                                        
                                        
                                        while($all=mysql_fetch_assoc($other)){
                                           
                                            $tc+=$all['tc_amount'];
                                           
                                        }
                                        $total+=$tc;
                                        if($tc!=0) {
                                        ?>
                                        <tr>
                                                    <td><?php echo $count; $count++;?></td>          
                                                    <td><center>TC Issued Charges</center></td>
                                                <td class="total"><center>-</center></td>
                                                <td class="total">Rs. <?php echo number_format($tc, 2); ?></td>
                                                <td class="total"><center>-</center></td>
                                                </tr>
                                        <?php } ?> 
                                                    
                                        <?php

                                        /* * **********************************************lastyesr Pending Fees ***************************************** */
                                        $fg_amount = 0;
                                        $feeslist = mysql_query("SELECT fi_id FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0'");
                                        while ($fees = mysql_fetch_assoc($feeslist)) {
                                            $fi_id = $fees['fi_id'];
                                            $feesummarry = mysql_query("SELECT amount FROM fsalessumarry WHERE fi_id=$fi_id AND ftype='pending'");
                                            while ($fsummarry = mysql_fetch_assoc($feesummarry)) {
                                                $amount = $fsummarry['amount'];
                                                $fg_amount += $amount;
                                            }
                                        }

                                        if ($fg_amount != 0) {
                                            $total += $fg_amount;
                                            ?>

                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td><b><center>Last Year Pending Fees</center></b></td>
                                                <td class="total"><center>-</center></td>
                                            <td class="total">Rs. <?php echo number_format($fg_amount, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        $etotal = 0;
                                        $qry1 = mysql_query("SELECT fund_amount FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear AND funds='1' and c_status!='1' AND i_status='0'");
                                        $sdf_total = 0;
                                        while ($row1 = mysql_fetch_assoc($qry1)) {
                                            $sdf_tamount = $row1['fund_amount'];
                                            $sdf_total +=$sdf_tamount;
                                        }
                                        if ($sdf_total) {
                                            $etotal += $sdf_total;
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td><b><center>Student Discount Funds</center></b></td>
                                                <td class="total">Rs. <?php echo number_format($sdf_total, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        ?>
                                                        <!--<tr>
                                <td colspan="4" class="sub_total"><center><b>Other Fees</b></center></td>
                            </tr>-->
                                        <?php
                                        $book_amount = 0;
                                        $booklist = mysql_query("SELECT i_total FROM invoice WHERE (i_year*10000) + (i_month*100) + i_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and i_status='0'");
                                        while ($book1 = mysql_fetch_assoc($booklist)) {
                                            $bamont = $book1['i_total'];
                                            $book_amount += $bamont;
                                        }
                                        if ($book_amount != 0) {
                                            $total +=$book_amount;
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td><b><center>Book Fees</center></b></td>
                                                <td class="total"><center>-</center></td>
                                            <td class="total">Rs. <?php echo number_format($book_amount, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                        $bamountthisyear = 0;
                                        $bus_lastyear = 0;
                                        $booklist1 = mysql_query("SELECT * FROM bfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear AND c_status!='1' AND i_status='0'");
                                        $n=0;
                                        $cls='';
                                        $cle='';
                                        while ($bus1 = mysql_fetch_assoc($booklist1)) {
                                            if($n==0){
                                                $cls=$bus1['fr_no'];
                                                $n++;
                                            }
                                            $bamont1 = $bus1['fi_total'];
                                            $pending1 = $bus1['pending'];
                                            $bus_amount = $bamont1 - $pending1;
                                            $bamountthisyear += $bus_amount;
                                            $bus_lastyear += $pending1;
                                            $cle=$bus1['fr_no'];
                                        }
                                        $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                        if ($bamountthisyear != 0) {
                                            $total +=$bamountthisyear;
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td><center>Bus Fees (<?= $frmmto?>)</center></td>
                                                <td class="total"><center>-</center></td>
                                            <td class="total">Rs. <?php echo number_format($bamountthisyear, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        if ($bus_lastyear != 0) {
                                            $total +=$bus_lastyear;
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td><b><center>Last Year Pending Bus Fees</center></b></td>
                                                <td class="total"><center>-</center></td>
                                            <td class="total">Rs. <?php echo number_format($bus_lastyear, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        /*                                         * ************************************* Loan Payment Income *********************************************** */
                                        $loanpay_amount = 0;
                                        $booklist = mysql_query("SELECT amount FROM staff_loan_pay WHERE (year*10000) + (month*100) + day between '" . $startdate . "' AND '" . $enddate . "'");
                                        while ($book1 = mysql_fetch_assoc($booklist)) {
                                            $lamont = $book1['amount'];
                                            $loanpay_amount += $lamont;
                                        }
                                        if ($loanpay_amount != 0) {
                                            $total +=$loanpay_amount;
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td><b><center>Loan Payment</center></b></td>
                                                <td class="total"><center>-</center></td>
                                            <td class="total">Rs. <?php echo number_format($loanpay_amount, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        ?>
                                        <?php
                                        $indisplay = 1;
                                        $classl = mysql_query("SELECT inc_id,in_category FROM in_category");
                                        while ($row1 = mysql_fetch_assoc($classl)) {
                                            $incid = $row1['inc_id'];
                                            $in_amount = 0;
                                            $booklist1 = mysql_query("SELECT amount FROM income WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND inc_id=$incid");
                                            while ($bus1 = mysql_fetch_assoc($booklist1)) {
                                                $bamont1 = $bus1['amount'];
                                                $in_amount += $bamont1;

                                                $total +=$in_amount;
                                            }
                                            if ($in_amount != 0) {
                                                if ($indisplay == '1') {
                                                    ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><b>Income Categories:</b></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <?php
                                                    $indisplay = 0;
                                                }
                                                ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>			
                                                    <td><center><?= $row1['in_category'] ?></center></td>
                                                <td class="total"><center>-</center></td>
                                                <td class="total">Rs. <?php echo number_format($in_amount, 2); ?></td>
                                                <td class="total"><center>-</center></td>
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        }
                                        ?>
                                         
                                              

                                        <!-- ****************Expenses *************************--> 
                                        <?php
                                        $qry6 = mysql_query("SELECT exc_id,ex_category,e_category FROM ex_category");
                                        $excount = 1;
                                        $indisplay = 1;
                                        while ($row6 = mysql_fetch_assoc($qry6)) {
                                            $e_category = $row6['e_category'];
                                            $exc_id = $row6['exc_id'];
                                            $exsqry = mysql_query("SELECT * FROM ex_insubcategory where category='$exc_id'  order by count asc");
                                            $cont = 1;
                                            while ($exrow = mysql_fetch_assoc($exsqry)) {
                                                $category_id = $exrow["category"];
                                                $exsid = $exrow["exs_id"];
                                                $count1 = $exrow["count"];
                                                $subexname = $exrow["sub_name"];
                                                if ($count1 == 0) {
                                                    for ($j = 1; $j <= 20; $j++) {
                                                        $sub_id = $exrow["sub" . $j . "_id"];

                                                        if ($sub_id != 0) {
                                                            $field = $j;
                                                        }
                                                    }
                                                    $fieldno = $field + 1;
                                                    $myarray = array();
                                                    array_push($myarray, $exsid);
                                                    $subname = "sub" . $fieldno . "_id";
                                                    $classlist2 = mysql_query("SELECT exs_id FROM ex_insubcategory WHERE $subname='$exsid'");
                                                    while ($class2 = mysql_fetch_assoc($classlist2)) {
                                                        //$sub_id=$class1["sub".$j."_id"];
                                                        array_push($myarray, $class2['exs_id']);
                                                    }

                                                    $exc_amount = 0;
                                                    $feeslist1 = mysql_query("SELECT status,amount,pending FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND exc_id=$exc_id  AND  exs_id IN (" . implode(',', $myarray) . ") AND type=0");
                                                    while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                        $type = $fees1['type'];
                                                        $status = $fees1['status'];
                                                        $amount1 = $fees1['amount'];
                                                        if ($status == '1') {
                                                            $exc_amount += $amount1;
                                                        }
                                                    }
                                                    //parcial qoutation payment
                                                    $feeslist1 = mysql_query("SELECT ex_id,amount FROM exponses_bill_summary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND exc_id=$exc_id");
                                                    while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                        $amount1 = $fees1['amount'];
                                                        $exid = $fees1['ex_id'];
                                                        $check1 = mysql_query("SELECT ex_id FROM exponses WHERE ex_id=$exid AND exc_id=$exc_id  AND  exs_id IN (" . implode(',', $myarray) . ")");
                                                        $checkcount = mysql_num_rows($check1);
                                                        if ($checkcount > 0) {
                                                            $exc_amount += $amount1;
                                                        }
                                                    }
                                                    if ($exc_amount != 0) {
                                                        if ($indisplay == '1') {
                                                            ?>
                                                            <tr>
                                                                <td></td>
                                                                <td><b>Expence Categories :</b></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <?php
                                                            $indisplay = 0;
                                                        }
                                                        if ($cont == '1') {
                                                            ?>
                                                            <tr>
                                                                <td></td>
                                                                <td style="padding-left:25px;"><?php echo $excount . ". " . $row6['ex_category'] ?> :</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <?php
                                                            $cont = 0;
                                                            $excount++;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $count; ?></td>			
                                                            <td><center><?php echo $subexname; ?></center></td>
                                                        <?php if ($e_category == '1') { ?>
                                                            <td class="total"><center>-</center></td>
                                                            <td class="total"><center>-</center></td>
                                                            <td class="total">Rs. <?php echo number_format($exc_amount, 2); ?></td>
                                                            <?php
                                                            $assettotal += $exc_amount;
                                                        } else {
                                                            ?>
                                                            <td class="total">Rs. <?php echo number_format($exc_amount, 2); ?></td>
                                                            <td class="total"><center>-</center></td>
                                                            <td class="total"><center>-</center></td>
                                                            <?php
                                                            $etotal += $exc_amount;
                                                        }
                                                        ?>
                                                        </tr>
                                                        <?php
                                                        $count++;
                                                    }
                                                }
                                            }
                                        }
                                        /*                                         * ********************************daily Allowance ******************************** */
                                        $d_amount = 0;
                                        $booklist1 = mysql_query("SELECT total_amount FROM exp_allowance WHERE (cdate >= '$startdate1' AND cdate <= '$enddate1')");
                                        while ($bus1 = mysql_fetch_assoc($booklist1)) {
                                            $bamont1 = $bus1['total_amount'];
                                            $d_amount += $bamont1;
                                        }
                                        if ($d_amount != 0) {
                                            $etotal +=$d_amount;
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td><b><center>Daily Allowance</center></b></td>
                                                <td class="total">Rs. <?php echo number_format($d_amount, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        /*                                         * ********************************Principal Salary ******************************** */
                                        $sqry = mysql_query("SELECT st_id FROM staff Where prince='1'");
                                        $srow = mysql_fetch_assoc($sqry);
                                        $pstid1 = $srow['st_id'];
                                        $exc_amount1 = 0;

                                        $feeslist2 = mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND st_id=$pstid1 ");
                                        while ($fees2 = mysql_fetch_assoc($feeslist2)) {
                                            $amount2 = $fees2['n_salary'];
                                            $exc_amount1 += $amount2;
                                        }
                                        $etotal +=$exc_amount1;
                                        if ($exc_amount1 != 0) {
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td><b><center>Principal Salary</center></b></td>
                                                <td class="total">Rs. <?php echo number_format($exc_amount1, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                        /*                                         * ********************************Teaching Staff Salary ******************************** */
                                        $exc_amount1 = 0;
                                        $feeslist2 = mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND st_id AND st_id!=$pstid1");
                                        while ($fees2 = mysql_fetch_assoc($feeslist2)) {
                                            $amount2 = $fees2['n_salary'];
                                            $exc_amount1 += $amount2;
                                        }
                                        $etotal +=$exc_amount1;
                                        if ($exc_amount1 != 0) {
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td><b><center>Teaching Staff Salary</center></b></td>
                                                <td class="total">Rs. <?php echo number_format($exc_amount1, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                        /*                                         * ********************************Non-Teaching Staff Salary ******************************** */
                                        $exc_amount1 = 0;
                                        $feeslist2 = mysql_query("SELECT n_salary FROM staff_month_salary WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND (o_id OR d_id)");
                                        while ($fees2 = mysql_fetch_assoc($feeslist2)) {
                                            $amount2 = $fees2['n_salary'];
                                            $exc_amount1 += $amount2;
                                        }
                                        $etotal +=$exc_amount1;
                                        if ($exc_amount1 != 0) {
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td><b><center>Non-Teaching Staff Salary</center></b></td>
                                                <td class="total">Rs. <?php echo number_format($exc_amount1, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        /*                                         * ******************************** Staff Salary Advance  ******************************** */
                                        $exc_amount1 = 0;
                                        $feeslist2 = mysql_query("SELECT a_amount FROM staff_advance WHERE (year*10000) + (month*100) + day between '" . $startdate . "' AND '" . $enddate . "' AND status=0");
                                        while ($fees2 = mysql_fetch_assoc($feeslist2)) {
                                            $amount2 = $fees2['a_amount'];
                                            $exc_amount1 += $amount2;
                                        }
                                        $etotal +=$exc_amount1;
                                        if ($exc_amount1 != 0) {
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td><b><center>Staff Salary Advance </center></b></td>
                                                <td class="total">Rs. <?php echo number_format($exc_amount1, 2); ?></td>
                                            <td class="total"><center>-</center></td>
                                            <td class="total"><center>-</center></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        /*                                         * ******************************** EPF - ESI Contribution ******************************** */
                                        $alldedlist2 = mysql_query("SELECT id,name FROM staff_allw_ded WHERE pe_type!=0");
                                        while ($allded2 = mysql_fetch_assoc($alldedlist2)) {
                                            $adid = $allded2['id'];
                                            $adname = $allded2['name'];
                                            $exc_amount1 = 0;
                                            $feeslist2 = mysql_query("SELECT b.pevalue,b.amount FROM staff_month_salary a, staff_month_salary_summary b WHERE (a.year*10000) + (a.month*100) + a.day between '" . $startdate . "' AND '" . $enddate . "' AND a.st_ms_id = b.st_ms_id AND b.ad_id=$adid AND b.pevalue");
                                            while ($fees2 = mysql_fetch_assoc($feeslist2)) {
                                                $staffpreamount = $fees2['amount'];
                                                $preamount = $fees2['pevalue'];
                                                if ($staffpreamount) {
                                                    $exc_amount1 += $staffpreamount + $preamount;
                                                }
                                            }
                                            $etotal +=$exc_amount1;
                                            if ($exc_amount1 != 0) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>			
                                                    <td><b><center><?php echo $adname . " Contribution"; ?></center></b></td>
                                                    <td class="total">Rs. <?php echo number_format($exc_amount1, 2); ?></td>
                                                <td class="total"><center>-</center></td>
                                                <td class="total"><center>-</center></td>
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        } ?>
                                     
                                                <?php 
                                        /*************************advance expense*****************************/
                                        $qry_adv = "SELECT sum(adv_amt) as advance FROM agency_advance WHERE DATE(adv_date) between '" . $startdate1 . "' AND '" . $enddate1 . "'";
                                        $advance_qry = mysql_query($qry_adv);
                                        $advance_result = mysql_fetch_assoc($advance_qry);


                                        
                                        if($advance_result['advance']!=0){
                                            $etotal = $etotal + $advance_result['advance'];
                                        ?>        

                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td> ADVANCE PAYMENT </td>
                                            <td class="total"><?php echo "Rs. " . number_format($advance_result['advance'], 2); ?></td>
                                        <td><center>-</center></td>
                                        <td><center>-</center></td>
                                        </tr> 
                                        <?php 
                                        
                                        $count++;
                                        } 
                                        
                                        /************************* Inventory Purchase Expense *****************************/
                                        $qry_pur = "SELECT sum(overeall_total) as purchase_amt FROM inv_purchase_parent WHERE DATE(purchase_date) between '" . $startdate1 . "' AND '" . $enddate1 . "'";
                                        $pur_qry = mysql_query($qry_pur);
                                        $pur_result = mysql_fetch_assoc($pur_qry);


                                        
                                        if($pur_result['purchase_amt']!=0){
                                        $etotal = $etotal + $pur_result['purchase_amt'];

                                        $all = "SELECT  * FROM inv_purchase_parent WHERE DATE(purchase_date) between '" . $startdate1 . "' AND '" . $enddate1 . "'";
                                        $from='';
                                        $to='';
                                        $n=1;
                                        $fromto='';
                                        $deff = mysql_query($all);
                                        while($row=mysql_fetch_assoc($deff)){
                                                if($n==1)
                                                    $from=$row['purchase_no'];
                                                $to=$row['purchase_no'];
                                                $n++;
                                        }
                                        
                                         if($from==$to)
                                            $fromto="PB" . str_pad($from, 5, '0', STR_PAD_LEFT);
                                        else
                                            $fromto="PB" . str_pad($from, 5, '0', STR_PAD_LEFT).'-'."PB" . str_pad($to, 5, '0', STR_PAD_LEFT);
                                        ?>
                                        
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td> INVENTORY PURCHASE (<?= $fromto?>)</td>
                                            <td class="total"><?php echo "Rs. " . number_format($pur_result['purchase_amt'], 2); ?></td>
                                        <td><center>-</center></td>
                                        <td><center>-</center></td>
                                        </tr>
                                        
                                        <?php 
                                        $count++;
                                        }
                                        /************************* Inventory Material Issue Income *****************************/
                                         $qry_mat = "SELECT sum(overall_total) as material_amt FROM inv_material_parent WHERE DATE(mat_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND stud_staff=1";
                                        $mat_qry = mysql_query($qry_mat);
                                        $mat_result = mysql_fetch_assoc($mat_qry);


                                       
                                        if($mat_result['material_amt']!=0){
                                             $total = $total + $mat_result['material_amt'];

                                        $qry_mat1 = "SELECT * FROM inv_material_parent WHERE DATE(mat_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND stud_staff=1";
                                        $from='';
                                        $to='';
                                        $n=1;
                                        $fromto='';
                                        $mat_qry1 = mysql_query($qry_mat1);
                                        while($row=mysql_fetch_assoc($mat_qry1)){
                                                if($n==1)
                                                    $from=$row['bill_no'];
                                                    $to=$row['bill_no'];
                                                $n++;
                                        }
                                        if($from==$to)
                                            $fromto=$from;
                                        else
                                            $fromto=$from.'-'.$to;
                                        ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td> INVENTORY MATERIAL ISSUE (<?= $fromto?>)</td>
                                            <td><center>-</center></td>
                                        <td class="total"><?php echo "Rs. " . number_format($mat_result['material_amt'], 2); ?></td>
                                        <td><center>-</center></td>
                                        </tr>
                                        
                                        <?php 
                                        $count++;
                                        }?>
                                        <tr>
                                            <td class="sub_total" colspan="2"> Total </td>
                                            <td class="sub_total"><?php echo "Rs. " . number_format($etotal, 2); ?></td>
                                        <td class="sub_total"><?php $total=$total+$book; echo "Rs. " . number_format($total, 2); ?></td>
                                        <td class="sub_total"><?php echo "Rs. " . number_format($assettotal, 2); ?></td>
                                        </tr>   
                                        <tr class="total_bar">
                                            <td class="sub_total" colspan="3"><?php
                                                $expencetotal = $etotal + $assettotal;
                                                $finaltotal = $total - $expencetotal;
                                                echo "Income : <b>Rs. " . number_format($total, 2) . "</b> | Expenses : <b>Rs. " . number_format($expencetotal, 2) . "</b> ( " . number_format($total, 0) . " - ( " . number_format($etotal, 0) . " + " . number_format($assettotal, 0) . " ))";
                                                ?></td>
                                            <td class="grand_total sub_total">Profit Total:</td>
                                            <td class="grand_total sub_total">Rs. <?php echo number_format($finaltotal, 2); ?></td>
                                        </tr>                        
                                        </tbody>
                                    </table>
                                  
                                    <h2>Fees Concession</h2>
                                    <table class="table table-striped" id="table-example">
                                        <thead>
                                            <tr>
                                                <th width="5%">S.No</th>
                                                <th width="70%"><center>Student</center></th>
                                                 <th width="10%"><center>Standard</center></th>
                                        <th class="total" width="10%"><center>Amount</center></th>
                                        </tr>
                                        </thead>						
                                        <tbody>
                                         <?php
                                            $count = 1;
                                           
                                        $fg_amount_cl = 0;
                                                $fg_amount_cm = 0;
                                                $fg_amount_ch = 0;
                                                $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CL%'");
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];

                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   $chk=0;
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($fsummarry1['fg_id']==4){}
                                                        else{
                                                            $chk+=$fsummarry1['discount'];
                                                        $amount = $fsummarry1['discount'];
                                                        $fg_amount_cl += $amount;
                                                        }
                                                    }
                                                    if($chk){

                                                            echo '<tr><td></td>';
                                                            echo '<td style="text-align:right;">';
                                                            $cccid=$fees1['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                            echo  $fees1['fi_name'].' - '.$fees1['fr_no'].'</td><td><center>'.mysql_fetch_assoc($allc)['c_name'];
                                                            echo  '</center></td>';
                                                            echo '<td class="total">'.number_format($chk,2);
                                                            echo '</center></td>';
                                                            echo '</tr>';
                                                        }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_cl != 0) {
                                            $total += $fg_amount_cl;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            ?>

                                            </tr>

                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td colspan="2"><center>KG Term Fees Concession (<?= $frmmto?>)</center></td>
                                                
                                            <td class="total">Rs. <?php echo number_format($fg_amount_cl, 2); ?></td>
                                            
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                        $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CM%'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   $chk=0;
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($fsummarry1['fg_id']==4){}
                                                        else{
                                                        $chk+=$fsummarry1['discount'];
                                                        $amount = $fsummarry1['discount'];
                                                        $fg_amount_cm += $amount;
                                                        }
                                                    }
                                                    $cle=$fees1['fr_no'];
                                                     if($chk){
                                                            echo '<tr><td></td>';
                                                            echo '<td style="text-align:right;">';
                                                            $cccid=$fees1['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                            echo  $fees1['fi_name'].' - '.$fees1['fr_no'].'</td><td><center>'.mysql_fetch_assoc($allc)['c_name'];
                                                            echo  '</center></td>';
                                                            echo '<td class="total">'.number_format($chk,2);
                                                            echo '</center></td>';
                                                            echo '</tr>';
                                                        }
                                                }

                                         if ($fg_amount_cm != 0) {
                                            $total += $fg_amount_cm;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td colspan="2"><center>HS Term Fees Concession (<?= $frmmto?>)</center></td>
                                              
                                            <td class="total">Rs. <?php echo number_format($fg_amount_cm, 2); ?></td>
                                          
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                                $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CH%'");
                                               
                                                $n=0;
                                                while ($fees1 = mysql_fetch_assoc($feeslist1)) {
                                                    if($n==0){
                                                        $cls=$fees1['fr_no'];
                                                        $n++;
                                                    }
                                                    $fi_id1 = $fees1['fi_id'];
                                                    $feesummarry1 = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id1");
                                                   $chk=0;
                                                   while ($fsummarry1 = mysql_fetch_assoc($feesummarry1)) {
                                                        if($fsummarry1['fg_id']==4){}
                                                        else{
                                                            $chk+= $fsummarry1['discount'];
                                                            $amount = $fsummarry1['discount'];
                                                            $fg_amount_ch += $amount;
                                                        }
                                                    }
                                                    if($chk){
                                                            echo '<tr><td></td>';
                                                            echo '<td style="text-align:right;">';
                                                            $cccid=$fees1['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                           echo  $fees1['fi_name'].' - '.$fees1['fr_no'].'</td><td><center>'.mysql_fetch_assoc($allc)['c_name'];
                                                            echo  '</center></td>';
                                                            echo '<td class="total">'.number_format($chk,2);
                                                            echo '</center></td>';
                                                            echo '</tr>';
                                                        }
                                                    $cle=$fees1['fr_no'];
                                                }

                                         if ($fg_amount_ch != 0) {
                                            $total += $fg_amount_ch;
                                            $frmmto='';
                                            if($cls==$cle)
                                                 $frmmto=$cls;
                                            else
                                               $frmmto="$cls - $cle";
                                            ?>
                                            
                                            <tr>
                                                <td><?php echo $count; ?></td>          
                                                <td colspan="2"><center>HSS Term Fees (<?= $frmmto?>)</center></td>
                                                
                                            <td class="total">Rs. <?php echo number_format($fg_amount_ch, 2); ?></td>
                                            
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                             
                                        
                                        $other=mysql_query("SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' and c_status!='1' AND i_status='0'");

                                        $book=0;
                                        $from='';
                                        $to='';
                                        $fromto='';
                                        $n=1;
                                        while($all=mysql_fetch_assoc($other)){
                                           if($n==1){
                                             $from=$all['fr_no'];
                                         }
                                             $to=$all['fr_no'];
                                         $n++;
                                            $book+=$all['discount'];
                                            if($all['discount']){
                                                            echo '<tr><td></td>';
                                                            echo '<td style="text-align:right;">';
                                                            $cccid=$all['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                            echo  $all['fi_name'].' - '.$all['fr_no'].'</td><td><center>'.mysql_fetch_assoc($allc)['c_name'];
                                                            echo  '</center></td>';
                                                            echo '<td class="total">'.number_format($all['discount'],2);
                                                            echo '</center></td>';
                                                            echo '</tr>';
                                                        }
                                           
                                        }
                                        if($from==$to)
                                            $fromto=$from;
                                        else
                                            $fromto=$from.'-'.$to;
                                        if($book!=0) {
                                        ?>
                                        <tr>
                                                    <td><?php echo $count; $count++;?></td>          
                                                    <td colspan="2"><center>Books, Notes & Other Items Fees Concession(<?= $fromto?>)</center></td>
                                                
                                                <td class="total">Rs. <?php echo number_format($book, 2); ?></td>
                                               
                                                </tr>
                                        <?php } ?> 
                                        <?php 
                                        $qry5 = mysql_query("SELECT fgd_id,name,fg_id FROM fgroup_detail");
                                            while ($row5 = mysql_fetch_assoc($qry5)) {
                                                if($row5['fg_id']==4) {
                                                $fgd_id = $row5['fgd_id'];
                                                $fg_amount = 0;
                                                $feeslist = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0'");
                                                while ($fees = mysql_fetch_assoc($feeslist)) {
                                                    $fi_id = $fees['fi_id'];
                                                    $feesummarry = mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id AND fgd_id=$fgd_id");
                                                    $chk=0;
                                                    while ($fsummarry = mysql_fetch_assoc($feesummarry)) {
                                                        $amount = $fsummarry['discount'];
                                                        $chk+=$fsummarry['discount'];
                                                        $fg_amount += $amount;
                                                    }
                                                    if($chk){
                                                            echo '<tr><td></td>';
                                                            echo '<td style="text-align:right;">';
                                                            $cccid=$fees['c_id'];
                                                            $allc=mysql_query("select * from class where c_id=$cccid AND ay_id=$acyear");
                                                            echo  $fees['fi_name'].' - '.$fees['fr_no'].'</td><td><center>'.mysql_fetch_assoc($allc)['c_name'];
                                                            echo  '</center></td>';
                                                            echo '<td class="total">'.number_format($chk,2);
                                                            echo '</center></td>';
                                                            echo '</tr>';
                                                        }
                                                }
                                                if ($fg_amount != 0) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>          
                                                        <td colspan="2"><center><?php echo $row5['name'].' Fees Concession'; ?></center></td>
                                                
                                                <td class="total">Rs. <?php echo number_format($fg_amount, 2); ?></td>
                                               
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        }
                                        }
                                        ?>
                                        </tbody>
                                        </table>
                                    <hr>
                                    <h2>Liabilities :</h2>
                                    <table class="table table-striped" id="table-example">
                                        <thead>
                                            <tr>
                                                <th width="5%">S.No</th>
                                                <th width="50%"><center>Particular</center></th>
                                        <th class="total"><center>Pending</center></th>
                                        </tr>
                                        </thead>						
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            $etotal1 = 0;
                                            $qry6 = mysql_query("SELECT exc_id,ex_category FROM ex_category");
                                            $excount = 1;
                                            $indisplay = 1;
                                            while ($row6 = mysql_fetch_array($qry6)) {
                                                $exc_id = $row6['exc_id'];
                                                $exsqry = mysql_query("SELECT * FROM ex_insubcategory where category='$exc_id' order by count asc");
                                                $cont = 1;
                                                while ($exrow = mysql_fetch_array($exsqry)) {
                                                    $category_id = $exrow["category"];
                                                    $exsid = $exrow["exs_id"];
                                                    $count1 = $exrow["count"];
                                                    $subexname = $exrow["sub_name"];
                                                    if ($count1 == 0) {
                                                        for ($j = 1; $j <= 20; $j++) {
                                                            $sub_id = $exrow["sub" . $j . "_id"];

                                                            if ($sub_id != 0) {
                                                                $field = $j;
                                                            }
                                                        }
                                                        $fieldno = $field + 1;
                                                        $myarray = array();
                                                        array_push($myarray, $exsid);
                                                        $subname = "sub" . $fieldno . "_id";
                                                        $classlist2 = mysql_query("SELECT exs_id FROM ex_insubcategory WHERE $subname='$exsid'");
                                                        while ($class2 = mysql_fetch_array($classlist2)) {
                                                            //$sub_id=$class1["sub".$j."_id"];
                                                            array_push($myarray, $class2['exs_id']);
                                                        }

                                                        $exc_amount = 0;
                                                        //$feeslist1=mysql_query("SELECT ex_id,amount FROM exponses WHERE ((date_year*10000) + (date_month*100) + date_day) <= '" . $enddate. "' AND exc_id=$exc_id AND  exs_id IN (".implode(',',$myarray).") AND type='1'"); 
                                                        $feeslist1 = mysql_query("SELECT ex_id,amount FROM exponses WHERE ((date_year*10000) + (date_month*100) + date_day) between '" . $startdate . "' AND '" . $enddate . "' AND exc_id=$exc_id AND  exs_id IN (" . implode(',', $myarray) . ") AND type='1'");
                                                        while ($fees1 = mysql_fetch_array($feeslist1)) {
                                                            $exid = $fees1['ex_id'];
                                                            $amount1 = $fees1['amount'];
                                                            $amountpaid = 0;
                                                            $pending = 0;
                                                            $bill_summery = mysql_query("SELECT amount FROM exponses_bill_summary WHERE ((date_year*10000) + (date_month*100) + date_day) <= '" . $enddate . "' AND ex_id=$exid AND exc_id=$exc_id");
                                                            while ($summery = mysql_fetch_assoc($bill_summery)) {
                                                                $amountpaid +=$summery['amount'];
                                                            }
                                                            //echo $amount1."-".$amountpaid."<br>";
                                                            $pending = $amount1 - $amountpaid;
                                                            $exc_amount += $pending;
                                                        }
                                                        if ($exc_amount != 0) {
                                                            if ($cont == '1') {
                                                                ?>
                                                                <tr>
                                                                    <td></td>
                                                                    <td style="padding-left:25px;"><b><?php echo $excount . ". " . $row6['ex_category'] ?> :</b></td>
                                                                    <td></td>
                                                                </tr>
                                                                <?php
                                                                $cont = 0;
                                                                $excount++;
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $count; ?></td>			
                                                                <td><center><?php echo $subexname; ?></center></td>
                                                        <td class="total"><center>Rs. <?php echo number_format($exc_amount, 2); ?></center></td>
                                                        </tr>
                                                        <?php
                                                        $count++;
                                                    }
                                                    $etotal1 += $exc_amount;
                                                }
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td class="sub_total" colspan="2"> Total </td>
                                            <td class="sub_total"><center><?php echo "Rs. " . number_format($etotal1, 2); ?></center></td>
                                        </tr>
                                        <tr class="total_bar">
                                            <td class="sub_total" colspan="2"><?php
                                                $finaltotal1 = $finaltotal - $etotal1;
                                                echo "Profit Total : <b>Rs. " . number_format($finaltotal, 2) . "</b> | Liabilities  : <b>Rs. " . number_format($etotal1, 2) . "</b> ( " . number_format($finaltotal, 0) . " - " . number_format($etotal1, 0) . " )";
                                                ?></td>
                                            <td class="grand_total sub_total"><span style="float:left">Profit Total:</span>Rs. <?php echo number_format($finaltotal1, 2); ?></td>
                                        </tr> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <form method="POST" action="balancesheet_prt.php?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>" target="_blank" id="denomination">
                           <div style="width:72%; float: right;">

                            <div style="float: left;">
                            <table class="table" style="">
                            <tr>
                               <th style=""> Bank Notes </th><th> Nos </th><th> Amount </th></tr>
                                <tr><td>Rs 5</td><td><input type="number" name="n5" onkeyup="tot(this.value,5,'n5');" autocomplete="off" type="number"></td><td style="width:35%"><span id="n5" class="denom note"></span></td></tr>
                                <tr><td>Rs 10</td><td><input type="number" name="n10" onkeyup="tot(this.value,10,'n10');" autocomplete="off" type="number"></td><td style="width:35%"><span id="n10" class="denom note"></span></td></tr>
                                <tr><td>Rs 20</td><td><input type="number" name="n20" onkeyup="tot(this.value,20,'n20');" autocomplete="off" type="number"></td><td style="width:35%"><span id="n20" class="denom note"></span></td></tr>
                                <td>Rs 50</td><td><input type="number" name="n50" onkeyup="tot(this.value,50,'n50');" autocomplete="off" type="number"></td><td style="width:35%"><span id="n50" class="denom note"></span></td></tr>
                                <td>Rs 100</td><td><input type="number" name="n100" onkeyup="tot(this.value,100,'n100');" autocomplete="off" type="number"></td><td style="width:35%"><span id="n100" class="denom note"></span></td></tr>
                                <td>Rs 500</td><td><input type="number" name="n500" onkeyup="tot(this.value,500,'n500');" autocomplete="off" type="number"></td><td style="width:35%"><span id="n500" class="denom note"></span></td></tr>
                                <td>Rs 1000</td><td><input type="number" name="n1000" onkeyup="tot(this.value,1000,'n1000');" autocomplete="off" type="number"></td><td style="width:35%"><span id="n1000" class="denom note"></span></td></tr>
                                <tr><th colspan="2">Sub Total</th><th><span id="subtot2"></span></th></tr>
                              
                           
                            </table>
                            </div>
                                                       <div style="float: right;">
                            <table class="table" style="">
                            <tr>
                                <th style=""> Coins </th><th> Nos </th><th> Amount </th></tr>
                                <tr><td>Rs 1</td> <td><input type="number" name="c1" onkeyup="tot(this.value,1,'c1');" autocomplete="off" ></td><td style="width:35%"><span id="c1" class="denom coin"></span></td></tr>
                                <tr><td>Rs 2</td><td><input type="number" name="c2" onkeyup="tot(this.value,2,'c2');" autocomplete="off" type="number"></td><td style="width:35%"><span id="c2" class="denom coin"></span></td></tr>
                                <tr><td>Rs 5</td> <td><input type="number" name="c5" onkeyup="tot(this.value,5,'c5');" autocomplete="off" type="number"></td><td style="width:35%"><span id="c5" class="denom coin"></span></td></tr>
                                <tr><td>Rs 10</td><td><input type="number" name="c10" onkeyup="tot(this.value,10,'c10');" autocomplete="off" type="number"</td><td style="width:35%"><span id="c10" class="denom coin"></span></td></tr>

                                <tr><th colspan="2">Sub Total</th><th><span id="subtot1"></span></th></tr>
                            </table>
                            <br><br><br>
                            <center><b>Total: </b><span id="wtot">0.00</span></center>
                            </div>
                            
                        </div>
                            <input type="hidden" id="wtothidden" name="wtot">
                            <input type="hidden" id="ctothidden" name="ctot">
                            <input type="hidden" id="ntothidden" name="ntot">
                            </form>
                            <br>
                            <a target="_blank"><input type="submit" value="Print Income & Expense Ledger" name="Print" class="btn btn-green" style="width:250px" onclick="formsend();"> </a>
                            <br><br>
                            <a href="balancesheet_excel.php?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&ayid=<?= $acyear ?>" target="_blank"><input type="submit" value="Download Income & Expense Ledger" name="Download" class="btn btn-green" style="width:280px"> </a>

                            <div class="clear height-fix"></div>

                        </div>

                    <?php } ?>

                </div>


            </div> <!--! end of #main-content -->
        </div> <!--! end of #main -->


        <?php include("includes/footer.php");
        ?>
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
        function formsend(){
            $( "#denomination" ).submit();
        }
        function currencyFormat (num) {     
    return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    }
        function tot(val,rs,id){
           
            $("#"+id).html(val*rs);
            var tot=0;
            $( ".denom" ).each(function( index ) {
                tot=Number(tot)+Number($(this).html());
            });
            $('#wtot').html(currencyFormat(tot));
            $('#wtothidden').val(currencyFormat(tot));
            var tot=0;
            $( ".coin" ).each(function( index ) {
                tot=Number(tot)+Number($(this).html());
            });
            $('#subtot1').html(currencyFormat(tot));
             $('#ctothidden').val(currencyFormat(tot));
            var tot=0;
            $( ".note" ).each(function( index ) {
                tot=Number(tot)+Number($(this).html());
            });
            $('#subtot2').html(currencyFormat(tot));
             $('#ntothidden').val(currencyFormat(tot));
        }
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