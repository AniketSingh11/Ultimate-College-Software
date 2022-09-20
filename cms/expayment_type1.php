<?php
include("includes/config.php");
if( (isset ($_GET['value']) && $_GET['value']!=''))
{
	$value=$_GET['value'];
	$epid=$_GET['exid'];
	if($epid){
	$exbilllist=mysql_query("SELECT * FROM exponses WHERE ex_id=$epid"); 
			  $exbill=mysql_fetch_assoc($exbilllist);
			  $ptype=$exbill['p_type'];
			  if($ptype=="card"){
			  $card=$exbill['pay_number'];
			  }else if($ptype=="cheque"){
				  $chequeno=$exbill['pay_number'];
				  $bank=$exbill['bank'];
				  $account=$exbill['account'];
				  $cdate=$exbill['c_date'];
			  }
	}
	
	if($value == "card"){
	echo '<div class="_25"><p>
                                <label for="textfield">Paid No ( with card )</label>
                                <input id="textfield" name="pay_number" class="required" type="text" value="'.$card.'" />
                            </p></div>';
	}else if($value == "cheque"){
		echo '<div class="_25"><p>
                                <label for="textfield">Cheque No </label>
                                <input id="textfield" name="pay_number" class="required" type="text" value="'.$chequeno.'" />
                            </p></div>
							<div class="_25"><p>
                                <label for="textfield">Bank Name </label>
                                <input id="bank_name" name="bank_name" class="required" type="text" value="'.$bank.'" />
                            </p></div>
							<div class="_25"><p>
                                <label for="textfield">Date</label>
                                <input id="datepicker1" style="z-index:999" name="cheque_date" class="required" type="text" value="'.$cdate.'" />
                            </p></div><div class="clear"></div>
							<div class="_25"><p>
                                <label for="textfield">Account No</label>
                                <input id="account_no" name="account_no" class="required" type="text" value="'.$account.'" />
                            </p></div>
							<script type="text/javascript">
							$( "#datepicker1" ).datepicker(
		{ dateFormat: \'dd/mm/yy\' });
	</script>';
	}
	/*else{
		echo '<div class="_25">
                                    <p>
                                        <label for="textfield">Get Amount </label>
                                        <input id="textfield" name="get_amount" id="get_amount" class="getamount" type="text" value="" />
                                    </p>
                                    </div>
                                    <div class="_25">
                                    <p>
                                        <label for="textfield">Balance Given</label>
                                        <input id="textfield" name="balance" id="balanace" type="text" value="" readonly/>
                                    </p>
                                    </div>';
	}*/
}