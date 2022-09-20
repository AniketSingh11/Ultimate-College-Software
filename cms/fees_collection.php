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
                    <li> Fees Collection </li>
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
if($_POST){
   // echo '<pre>'; print_r($_POST); echo '</pre>';
   $sdate=$_POST['sdate'];
   $edate=$_POST['edate'];
   $total=$_POST['amount_total'];
   $given=$_POST['amount_given'];
   $cashier=$_POST['cashier'];
   $status=1;
    if($total==$given){
        $status=0;
    }
    $d=date('d');
    $m=date('m');
    $y=date('Y');
   $sql="INSERT INTO feescollection (sdate,edate,amount_total,amount_given,fee_by,cashier,ay_id,status,date_day,date_month,date_year) VALUES ('$sdate','$edate','$total','$given','$user','$cashier','$acyear','$status','$d','$m','$y')";
   $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
   $lastid=mysql_insert_id();
   $i=0;
   $income=$_POST['income'];
   $amount=$_POST['amount'];
   foreach ($income as $tmp) {
       $inc=$tmp;
       $amt=$amount[$i];
       $sql="INSERT INTO feescollection_child (id,fees,amount) VALUES ('$lastid','$tmp','$amt')";
       $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
       $i++;
   }
     header("Location:cashierreport.php?msg=succ");
} 
?>

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
                            <h1>Fees Collection</h1>
                             <span style="margin:0px 50px 10px 0px; float:right;"><!--<img src="img/icons/packs/fugue/16x16/calendar-next.png">Date : <strong> <?php /* echo $sdate; */ ?></strong> |-->  <img src="img/icons/packs/fugue/16x16/calendar-previous.png"> End Date : <strong><?php echo $edate; ?></strong></span> 
                            <span style="margin:0px 50px 10px 0px; float:right;"><!--<img src="img/icons/packs/fugue/16x16/calendar-next.png">Date : <strong> <?php /* echo $sdate; */ ?></strong> |-->  <img src="img/icons/packs/fugue/16x16/calendar-previous.png"> Start Date : <strong><?php echo $sdate; ?></strong></span> 

                            <div id="invoice" class="widget widget-plain">			
                                <br>
                                <div class="widget-content">
                                <form action="" method="post" action="">
                                    <table class="table table-striped" id="table-example">	
                                        <thead>
                                            <tr>
                                                <th width="5%">S.No</th>
                                                <th width="50%"><center>Particular</center></th>
                                       <th class="total"><center>Income</center></th>
                                        </tr>
                                        </thead>						
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            $total = 0;
                                            $indisplay = 1;
                                            /** *******************************Other Fees******************************* */
                                            $qry5 = mysql_query("SELECT fgd_id,name,fg_id FROM fgroup_detail");
                                            while ($row5 = mysql_fetch_assoc($qry5)) {
                                                if($row5['fg_id']==4) {
                                                $fgd_id = $row5['fgd_id'];
                                                $fg_amount = 0;
                                                $feeslist = mysql_query("SELECT fi_id FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND fi_by='$cashier'");
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
                                                        <td>
                                                        <input type="hidden" name="income[]" value="<?= $row5['name']?>">
                                                        <center><?php echo $row5['name']; ?></center></td>
                                                <td class="total">
                                                <input type="hidden" name="amount[]" value="<?= $fg_amount?>">
                                                Rs. <?php echo number_format($fg_amount, 2); ?></td>
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        }
                                        }
                                        $fg_amount_cl = 0;
                                                $fg_amount_cm = 0;
                                                $fg_amount_ch = 0;
                                                $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CL%' AND fi_by='$cashier'");
                                               
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
                                                <td>
                                                <input type="hidden" name="income[]" value="KG Term Fees (<?= $frmmto?>)">
                                                <center>KG Term Fees (<?= $frmmto?>)</center></td>
                                            <td class="total">
                                             <input type="hidden" name="amount[]" value="<?= $fg_amount_cl?>">
                                            Rs. <?php echo number_format($fg_amount_cl, 2); ?></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                        $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CM%' AND fi_by='$cashier'");
                                               
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
                                                <td>
                                                      <input type="hidden" name="income[]" value="HS Term Fees (<?= $frmmto?>)">
                                                <center>HS Term Fees (<?= $frmmto?>)</center></td>
                                               
                                            <td class="total">
                                                     <input type="hidden" name="amount[]" value="<?= $fg_amount_cm?>">
                                            Rs. <?php echo number_format($fg_amount_cm, 2); ?></td>
                                            
                                            </tr>
                                            <?php
                                            $count++;
                                        }

                                                $feeslist1 = mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND cat LIKE 'CH%' AND fi_by='$cashier'");
                                               
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
                                                <td>
                                                     <input type="hidden" name="income[]" value="HSS Term Fees (<?= $frmmto?>)">
                                                <center>HSS Term Fees (<?= $frmmto?>)</center></td>
                                               
                                            <td class="total">
                                                 <input type="hidden" name="amount[]" value="<?= $fg_amount_ch?>">
                                            Rs. <?php echo number_format($fg_amount_ch, 2); ?></td>
                                           
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                             
                                        
                                        $other=mysql_query("SELECT * FROM finvoice_others WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' and c_status!='1' AND i_status='0' AND fi_by='$cashier'");

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
                                                    <td>
                                                         <input type="hidden" name="income[]" value="Books, Notes & Other Items Fees (<?= $fromto?>)">
                                                    <center>Books, Notes & Other Items Fees (<?= $fromto?>)</center></td>
                                              
                                                <td class="total">
                                                  <input type="hidden" name="amount[]" value="<?= $book?>">   
                                                Rs. <?php echo number_format($book, 2); ?></td>
                                            
                                                </tr>
                                        <?php } ?> 
                                        <?php 
                                        $other=mysql_query("SELECT * FROM tc_xi WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' AND tc_by='$cashier'");

                                        $tc=0;
                                        
                                        while($all=mysql_fetch_assoc($other)){
                                           
                                            $tc+=$all['tc_amount'];
                                           
                                        }
                                        
                                        $other=mysql_query("SELECT * FROM tc_xi_kg WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id='" . $acyear. "' AND tc_kg_by='$cashier'");

                                        
                                        
                                        while($all=mysql_fetch_assoc($other)){
                                           
                                            $tc+=$all['tc_amount'];
                                           
                                        }
                                        $total+=$tc;
                                        if($tc!=0) {
                                        ?>
                                        <tr>
                                                    <td><?php echo $count; $count++;?></td>          
                                                    <td>
                                                         <input type="hidden" name="income[]" value="TC Issued Charges">
                                                    <center>TC Issued Charges</center></td>
                                               
                                                <td class="total">
                                                    <input type="hidden" name="amount[]" value="<?= $tc?>">   
                                                Rs. <?php echo number_format($tc, 2); ?></td>
                                               
                                                </tr>
                                        <?php } ?> 
                                                    
                                        <?php

                                        /* * **********************************************lastyesr Pending Fees ***************************************** */
                                        $fg_amount = 0;
                                        $feeslist = mysql_query("SELECT fi_id FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear and c_status!='1' AND i_status='0' AND fi_by='$cashier'");
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
                                                <td>
                                                      <input type="hidden" name="income[]" value="Last Year Pending Fees">
                                                <b><center>Last Year Pending Fees</center></b></td>
                                             
                                            <td class="total">
                                                 <input type="hidden" name="amount[]" value="<?= $fg_amount?>">  
                                            Rs. <?php echo number_format($fg_amount, 2); ?></td>
                                           
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        $etotal = 0;
                                       ?>
                                        <?php
                                        $bamountthisyear = 0;
                                        $bus_lastyear = 0;
                                        $booklist1 = mysql_query("SELECT * FROM bfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate . "' AND '" . $enddate . "' AND ay_id=$acyear AND c_status!='1' AND i_status='0' AND bfi_by='$cashier'");
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
                                                <td>
                                                      <input type="hidden" name="income[]" value="Bus Fees (<?= $frmmto?>)">
                                                <center>Bus Fees (<?= $frmmto?>)</center></td>
                                               
                                            <td class="total">
                                                 <input type="hidden" name="amount[]" value="<?= $bamountthisyear?>">
                                            Rs. <?php echo number_format($bamountthisyear, 2); ?></td>
  
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        if ($bus_lastyear != 0) {
                                            $total +=$bus_lastyear;
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td>
                                                     <input type="hidden" name="income[]" value="Last Year Pending Bus Fees">
                                                <b><center>Last Year Pending Bus Fees</center></b></td>
                                            
                                            <td class="total">
                                                 <input type="hidden" name="amount[]" value="<?= $bus_lastyear?>">
                                            Rs. <?php echo number_format($bus_lastyear, 2); ?></td>
                                          
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        /*                                         * ************************************* Loan Payment Income *********************************************** */
                                        $loanpay_amount = 0;
                                        $booklist = mysql_query("SELECT amount FROM staff_loan_pay WHERE (year*10000) + (month*100) + day between '" . $startdate . "' AND '" . $enddate . "' AND login_user_name='$cashier'");
                                        while ($book1 = mysql_fetch_assoc($booklist)) {
                                            $lamont = $book1['amount'];
                                            $loanpay_amount += $lamont;
                                        }
                                        if ($loanpay_amount != 0) {
                                            $total +=$loanpay_amount;
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>			
                                                <td>
                                                      <input type="hidden" name="income[]" value="Loan Payment">
                                                <b><center>Loan Payment</center></b></td>
                                              
                                            <td class="total">
                                                  <input type="hidden" name="amount[]" value="<?= $loanpay_amount?>">
                                            Rs. <?php echo number_format($loanpay_amount, 2); ?></td>
                                          
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
                                            $booklist1 = mysql_query("SELECT amount FROM income WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate . "' AND '" . $enddate . "' AND inc_id=$incid AND inc_by='$cashier'");
                                            while ($bus1 = mysql_fetch_assoc($booklist1)) {
                                                $bamont1 = $bus1['amount'];
                                                $in_amount += $bamont1;

                                                $total +=$in_amount;
                                            }
                                            if ($in_amount != 0) {
                                                if ($indisplay == '1') {
                                                    ?>
                                                    
                                                    <?php
                                                    $indisplay = 0;
                                                }
                                                ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>			
                                                    <td>
                                                          <input type="hidden" name="income[]" value="<?= $row1['in_category'] ?>">
                                                    <center><?= $row1['in_category'] ?></center></td>
                                              
                                                <td class="total">
                                                     <input type="hidden" name="amount[]" value="<?= $in_amount ?>">
                                                Rs. <?php echo number_format($in_amount, 2); ?></td>
                                          
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        }
                                        ?>
                                         
                                              
                                        <?php 
                                        /************************* Inventory Material Issue Income *****************************/
                                         $qry_mat = "SELECT sum(overall_total) as material_amt FROM inv_material_parent WHERE DATE(mat_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND stud_staff=1 AND billgenerate='$cashier'";
                                        $mat_qry = mysql_query($qry_mat);
                                        $mat_result = mysql_fetch_assoc($mat_qry);


                                       
                                        if($mat_result['material_amt']!=0){
                                             $total = $total + $mat_result['material_amt'];

                                        $qry_mat1 = "SELECT * FROM inv_material_parent WHERE DATE(mat_date) between '" . $startdate1 . "' AND '" . $enddate1 . "' AND stud_staff=1 AND billgenerate!='$user'";
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
                                            <td> 
                                                 <input type="hidden" name="income[]" value="INVENTORY MATERIAL ISSUE (<?= $fromto?>)">
                                            INVENTORY MATERIAL ISSUE (<?= $fromto?>)</td>
                                           
                                        <td class="total">
                                             <input type="hidden" name="amount[]" value="<?= $mat_result['material_amt']?>">
                                        <?php echo "Rs. " . number_format($mat_result['material_amt'], 2); ?></td>
 
                                        </tr>
                                        
                                        <?php 
                                        $count++;
                                        }?>
                                        <tr>
                                            <td class="sub_total" colspan="2"> Total </td>
                                           
                                        <td class="sub_total"><?php $total=$total+$book; echo "Rs. " . number_format($total, 2); ?></td>
                                            <input type="hidden" name="amount_total" value="<?= $total?>"> 
                                             <input type="hidden" name="sdate" value="<?= $startdate1?>"> 
                                             <input type="hidden" name="edate" value="<?= $enddate1?>"> 
                                             <input type="hidden" name="cashier" value="<?= $cashier?>"> 
                                        </tr>  
                                         <tr>
                                            <td class="sub_total" colspan="2"> Amount Given </td>
                                           
                                        <td class="sub_total"><input type="text" value="" class="required text" name="amount_given" max="<?= $total?>"></td>
                                    
                                        </tr>  
                                                      
                                        </tbody>
                                    </table>
                                   
                            <br>
                            <!--
                            <a target="_blank"><input type="button" value="Print Income & Expense Ledger" name="Print" class="btn btn-green" style="width:250px" onclick="formsend();"> </a> 
                            -->
                            <input type="submit" value="Save" name="save" class="btn btn-red" style="width:60px;float: right;">
                            </form>
                            <br><br>
                            <!--
                            <a href="balancesheet_excel.php?sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>&ayid=<?= $acyear ?>" target="_blank"><input type="submit" value="Download Income & Expense Ledger" name="Download" class="btn btn-green" style="width:280px"> </a> -->

                            <div class="clear height-fix"></div>
</div>
</div>
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

<? ob_flush(); ?>