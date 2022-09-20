<?php
include("includes/config.php");
if( (isset ($_GET['value']) && $_GET['value']!=''))
{
	$value=$_GET['value'];
	$epid=$_GET['epid'];
	if($epid){
	$exbilllist=mysql_query("SELECT * FROM exponses_bill WHERE ep_id=$epid"); 
			  $exbill=mysql_fetch_array($exbilllist);
			  $ptype=$exbill['p_type'];
			  if($ptype=="card"){
			  $card=$exbill['pay_number'];
			  }else if($ptype=="cheque"){
				  $chequeno=$exbill['pay_number'];
				  $bank=$exbill['bank'];
				  $account=$exbill['account'];
				  $cdate=$exbill['c_date'];
			  }
			  $baid2=$exbill['ba_id'];
	}
	
	if($value == "card"){
	echo '<div class="_25"><p>
                                <label for="textfield">Paid No ( with card )</label>
                                <input id="textfield" name="pay_number" class="required" type="text" value="'.$card.'" />
                            </p></div>';
	}else if($value == "cheque"){
		echo '<div class="clear"></div><div class="_25"><p>
                                <label for="textfield">Cheque No </label>
                                <input id="textfield" name="pay_number" class="required" type="text" value="'.$chequeno.'" />
                            </p></div>';
							$classl = "SELECT * FROM bank_account";
                                            $result1 = mysql_query($classl) or die(mysql_error());
								echo '<div class="_25"><p>
                                <label for="textfield">Bank Name </label>
								<select name="baid" id="baid" class="required" onchange="bank_type()">';
											echo "<option value=''>Select Account</option>";
											while ($row1 = mysql_fetch_assoc($result1)):
												if($baid2 ==$row1['ba_id']){
                                                echo "<option value='{$row1['ba_id']}' selected>{$row1['name']} - {$row1['account_no']}</option>\n";
												} else {
												echo "<option value='{$row1['ba_id']}'>{$row1['name']} - {$row1['account_no']}</option>\n";
												}
										    endwhile;
                                            echo '</select></p></div>';
							echo '
							<div id="ajax_pay1">
									</div>
							<div class="_25"><p>
                                <label for="textfield">Date</label>
                                <input id="datepicker1" name="cheque_date" class="required" type="text" value="'.$cdate.'" />
                            </p></div>
							<script type="text/javascript">
							$( "#datepicker1" ).Zebra_DatePicker({
        format: \'d/m/Y\'
    });	
	function bank_type() {
			var x = document.getElementById("baid").value;
			$.get("expayment_type.php",{baid:x},function(data){
			$( "#ajax_pay1" ).html(data);
			});	
		}
		bank_type();
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

if((isset ($_GET['baid']) && $_GET['baid']!='')){
	$baid=$_GET['baid'];
	$banklist=mysql_query("SELECT * FROM bank_account WHERE ba_id=$baid"); 
			  $bank=mysql_fetch_array($banklist);
			  $bankname=$bank['name'];
			  $account=$bank['account_no'];
		echo '<div class="_25"><p>
                                <label for="textfield">Bank Name </label>
                                <input id="bank_name" name="bank_name" class="required" type="text" value="'.$bankname.'" readonly/>
                            </p></div>
							<div class="_25"><p>
                                <label for="textfield">Account No</label>
                                <input id="account_no" name="account_no" class="required" type="text" value="'.$account.'" readonly/>
                            </p></div>';
}

if((isset ($_GET['cstatus']) && $_GET['cstatus']!='')){
	if($_GET['cstatus']=='2'){
	echo '
							<div class="_25"><p>
                                <label for="textfield">Debited Date</label>
                                <input id="datepicker2" name="debited_date" class="required" type="text" value="'.$cdate.'" />
                            </p></div>
							<script type="text/javascript">
							$( "#datepicker2" ).Zebra_DatePicker({
							format: \'d/m/Y\'
						});	
					</script>';
	}
}

if((isset ($_GET['feecheck']) && $_GET['feecheck']!='')){
	$date=$_GET['date'];
	if($_GET['feecheck']=='2'){
	echo '
							<div class="_25"><p>
                                <label for="textfield">Debited Date</label>
                                <input id="datepicker2" name="debited_date" class="required" type="text" value="'.$date.'" />
                            </p></div>
							<script type="text/javascript">
							$( "#datepicker2" ).Zebra_DatePicker({
							format: \'d/m/Y\'
						});	
					</script>';
	}
}