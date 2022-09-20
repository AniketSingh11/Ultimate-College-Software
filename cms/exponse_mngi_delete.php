<? ob_start(); ?>
<?php
include("includes/config.php");

$epid = $_GET['epid'];

$exp_advance_qry = mysql_query("select * from exponses_bill where ep_id='$epid'");
$exp_adv_result = mysql_fetch_array($exp_advance_qry);

$ptype = $exp_adv_result['p_type'];
$oldcstatus = $exp_adv_result['c_status'];
$ba_id =$exp_adv_result['ba_id'];

if ($ptype == 'cash') {
    $cashlist = mysql_query("SELECT * FROM cash WHERE id=1");
    $cash = mysql_fetch_array($cashlist);
    $currentcash = $cash['amount'];
    
        $updatecash = $currentcash +$exp_adv_result['add_advance_amt'];
        $cashqry = mysql_query("UPDATE cash SET amount='$updatecash' WHERE id='1'");
    
} else if ($ptype == 'cheque') {
    if ($oldcstatus == '2') {
        $delete_q = "Delete from bank_withdrawl where ep_id='$epid' AND ba_id='$ba_id'";
        $result2 = mysql_query($delete_q);
        $classlist1 = mysql_query("SELECT * FROM bank_account WHERE ba_id=$ba_id");
        $class1 = mysql_fetch_array($classlist1);
        $amount =  $exbill['add_advance_amt'];
        $accountamount = $class1['amount'];
        $accountcash = $accountamount + $amount;
        $cashqry = mysql_query("UPDATE bank_account SET amount='$accountcash' WHERE ba_id=$ba_id");
    }
}


$delete11 = mysql_query("Delete from exponses_bill where ep_id='$epid' ");

$delete12 = mysql_query("Delete from advance_payment where ep_id='$epid' ");
$delete13 = mysql_query("Delete from agency_advance where ep_id='$epid' ");

$delete1 = mysql_query("select id,amount,ex_id from exponses_bill_summary where ep_id='$epid'");

while ($delete = mysql_fetch_array($delete1)) {
    $exid1 = $delete['ex_id'];
    $results1 = mysql_query("SELECT ex_id,pending,amount FROM exponses WHERE ex_id = '" . $exid1 . "' AND type=1");
    $exrow1 = mysql_fetch_assoc($results1);
    $expending = $exrow1['pending'];
    $examount = $exrow1['amount'];
    $exid2 = $delete['id'];
    if ($expending) {
        $damount = $delete['amount'] + $expending;
    } else if (!$expending && ($examount > $expending)) {
        $damount = $delete['amount'] + $expending;
    }
    // echo "<br>";
    $sql1 = mysql_query("UPDATE exponses SET pending='$damount',status='0',cdate='' WHERE ex_id='$exid1'");
    $delete = mysql_query("Delete from exponses_bill_summary where id='$exid2' ");
}
header("Location:exponse_mngi.php?msg=dsucc");

/* * *************reject********************************** */
/* $epid = $_GET['epid'];
  $delete1=mysql_query("UPDATE exponses_bill SET reject='1' where ep_id='$epid' ");

  $delete1=mysql_query("select id,amount,ex_id from exponses_bill_summary where ep_id='$epid'");
  while($delete=mysql_fetch_array($delete1))
  {
  $exid1=$delete['ex_id'];
  $results1 = mysql_query("SELECT id,pending FROM exponses WHERE ex_id = '".$exid1."' AND type=1");
  $exrow1 = mysql_fetch_assoc($results1);
  $expending=$exrow1['pending'];
  $exid2=$delete['id'];
  $damount=$delete['amount']+$expending;
  // echo "<br>";
  $sql1=mysql_query("UPDATE exponses SET pending='$damount',status='0',cdate='' WHERE ex_id='$exid1'");
  //$delete=mysql_query("Delete from exponses_bill_summary where id='$exid2' ");
  } */
?>
<? ob_flush(); ?>