<?php
if( (isset ($_GET['value']) && $_GET['value']!='') )
{
	 $value=$_GET['value'];
	 
	 if($value == '1'){
		 echo '<div class="clear"></div>
		 <div class="_25">
							<p>
                                <label for="textfield">Courier From <span class="error">*</span></label>
                                <input id="from" name="from" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Courier To <span class="error">*</span></label>
                                <input id="to" name="to" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date <span class="error">*</span></label>
                                <input id="datepicker" name="date" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Time <span class="error">*</span></label>
                                <input id="time" name="time" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Description</label>
                                <textarea id="descri" name="descri" rows="5" cols="40"></textarea>
                            </p>
						</div>
                        <div class="_50">
							<p>
                            <label for="textarea">Remarks: </label>
                            <textarea id="remark" name="remark" rows="5" cols="40"></textarea>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Contact No </label>
                                <input id="mobile" name="mobile" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Received By <span class="error">*</span></label>
                                <input id="received" name="received" class="required" type="text" value="" />
                            </p>
						</div>';
	 } else if($value == '2'){
		 echo '<div class="clear"></div>
                        <div class="_25">
							<p>
                                <label for="textfield">Courier Dispatch From <span class="error">*</span></label>
                                <input id="from" name="from" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Courier Dispatch To <span class="error">*</span></label>
                                <input id="to" name="to" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date <span class="error">*</span></label>
                                <input id="datepicker1" name="date" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Time <span class="error">*</span></label>
                                <input id="time1" name="time" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Description</label>
                                <textarea id="descri" name="descri" rows="5" cols="40"></textarea>
                            </p>
						</div>
                        <div class="_50">
							<p>
                            <label for="textarea">Remarks: </label>
                            <textarea id="remark" name="remark" rows="5" cols="40"></textarea>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Contact No </label>
                                <input id="mobile" name="mobile" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Received/dispatched By <span class="error">*</span></label>
                                <input id="received" name="received" class="required" type="text" value="" />
                            </p>
						</div>';
	 }
	 
	 echo '<script type="text/javascript">		
	$("#time").ptTimeSelect();
	$("#time1").ptTimeSelect();
	
	$( "#datepicker" ).Zebra_DatePicker({
			format: "d/m/Y"
		});	
	$( "#datepicker1" ).Zebra_DatePicker({
			format: "d/m/Y"
		});		
  </script>';
	
}