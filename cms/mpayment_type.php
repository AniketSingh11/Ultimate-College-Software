<?php
if( (isset ($_GET['value']) && $_GET['value']!=''))
{
	$value=$_GET['value'];
	
	if($value == "card"){
	echo '<div class="_25"><p>
                                <label for="textfield">Paid No ( with card )</label>
                                <input id="textfield" name="pay_number" class="required" type="text" value="" />
                            </p></div>';
	}else if($value == "cheque"){
		echo '<div class="_25"><p>
                                <label for="textfield">Cheque No </label>
                                <input id="textfield" name="pay_number" class="required" type="text" value="" />
                            </p></div>
							<div class="_25"><p>
                                <label for="textfield">Bank Name </label>
                                <input id="bank_name" name="bank_name" class="required" type="text" value="" />
                            </p></div>
							<div class="_25"><p>
                                <label for="textfield">Date</label>
                                <input id="datepicker1" name="cheque_date" class="required" type="text" value="" />
                            </p></div>
							<script type="text/javascript">
							$( "#datepicker1" ).Zebra_DatePicker({
        format: \'d/m/Y\'
    });	
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