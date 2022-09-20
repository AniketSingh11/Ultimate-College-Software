<?php

include("includes/config.php");
if ((isset($_GET['a_id']) && $_GET['a_id'] != '')) {
    $aid = $_GET['a_id'];
    $a_qry = "SELECT sum(bal_advance) as advance FROM advance_payment where a_id=$aid order by adv_pay_id desc limit 1";

    $advancelist = mysql_query($a_qry);
    $advance = mysql_fetch_assoc($advancelist);
    
    $a_adv = "SELECT sum(adv_amt) as advance FROM agency_advance where a_id=$aid";

    $advlist = mysql_query($a_adv);
    $adv_total = mysql_fetch_assoc($advlist);
    
    $total_advance = $adv_total['advance'] - $advance['advance'];
    
    echo $total_advance;
}