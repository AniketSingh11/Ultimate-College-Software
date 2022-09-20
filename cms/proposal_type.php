<?php

include("includes/config.php");
if ((isset($_GET['value']) && $_GET['value'] != '')) {
    $value = $_GET['value'];

    echo '<div class="clear"></div><div class="_25">
							<p>
                                <label for="textfield">Title <span class="error">*</span></label>
                                <input id="title" name="title" class="required" type="text" value="" />
                            </p>
						</div>
						<div class="_25">
							<p>
                                <label for="textfield">Bill No/Receipt No <span class="error">*</span></label>
                                <input id="b_no" name="b_no" class="required" type="text" value="" />
                            </p>
						</div>
						<div class="_25">
							<p>
							<label for="textfield">Agency <span class="error">*</span></label>';
    $classl = "SELECT * FROM agency WHERE status=0";
    $result1 = mysql_query($classl) or die(mysql_error());
    echo '<select name="aid" id="aid" class="required">';
    echo "<option value=''>please select agency</option>\n";
    while ($row1 = mysql_fetch_assoc($result1)):
        echo "<option value='{$row1['a_id']}'>{$row1['a_name']}</option>\n";
    endwhile;
    echo '</select>
						</p>
						</div>';
    if ($value != "New") {
        echo '<table class="table">
					        <thead>					        
                            <tr>
					          <th>Name /Description</th>
                              <th width="10%">Po Qty</th>
					           <th width="10%">Re Qty</th>
					            <th width="20%">Amount</th>
					           <th width="20%">Total</th>
					           <th width="5%"></th>
					          </tr>                              
					        </thead>					        
					        <tbody class="dfdf">';

        $qry = mysql_query("SELECT * FROM quotation where q_id='$value'") or die(mysql_error());
        $row1 = mysql_fetch_array($qry);
        $query = "select * from  quotation_amount where q_id='$value' order by qa_id asc ";
        $res = mysql_query($query);
        $i = 0;
        while ($row = mysql_fetch_array($res)) {
            $name = stripslashes($row["name"]);
            $qty = $row["qty"];
            $amount = $row["amount"];
            $total = $row["total"];

            echo '<tr id="hide_tr' . $i . '" >
					           					              <td> <input type="text" name="name[]" value="' . $name . '" /></td>
					           					            <td> <input type="text" data-required="true" id="poqty' . $i . '" value="' . $qty . '"   name="poqty[]" data-type="digits" class="required" readonly> </td>
                                                            <td> <input type="text" data-required="true" id="qty' . $i . '" value="' . $qty . '"   name="qty[]" onkeyup="calc(' . $i . ')" data-type="digits" class="required"  autocomplete="off"> </td>
                                                             
					           					            <td>  <input type="text"  data-required="true" data-type="digits"  value="' . $amount . '"   id="amount' . $i . '" onkeyup="calc(' . $i . ')" name="amount[]"  class="required"  autocomplete="off"></td>
					           					             <td>  <input type="text"  id="total' . $i . '"    name="total[]"  value="' . $total . '" readonly></td>
					           					              <td>';
            if ($i != 0) {
                echo'<img onclick="hide_table_tr(' . $i . ')" src="img/icons/packs/fugue/16x16/minus-button.png">';
            }
            if ($i == 0) {
                echo '<a id="addvalue' . $i . '" onclick="add_table_tr(' . mysql_num_rows($res) . ')"> <img src="img/icons/packs/fugue/16x16/plus-button.png" title="Add New"/></a></td>';
            }

            echo '</tr>';
            $i = $i + 1;
        }
        for ($j = $i; $j <= 30; $j++) {
            echo '<tr id="hide_tr' . $j . '"';
            if ($j != 0) {
                echo 'style="display: none;"';
            } echo '>
					            
					              <td>  <input type="text" name="name[]" value="" /></td>
                                  <td> <input type="text" data-required="true" id="poqty' . $j . '" value="0"   name="poqty[]" data-type="digits" class="required"> </td>
					            <td> <input type="text" data-required="true" id="qty' . $j . '"  disabled  name="qty[]" onkeyup="calc(' . $j . ')" data-type="digits" class="required"  autocomplete="off"> </td>
					            <td>  <input type="text"  data-required="true" data-type="digits"   disabled   id="amount' . $j . '" onkeyup="calc(' . $j . ')" name="amount[]"  class="required"  autocomplete="off"></td>
					             <td>  <input type="text"  id="total' . $j . '"    name="total[]" readonly></td>
					              <td>  
					              <img onclick="hide_table_tr(' . $j . ')" src="img/icons/packs/fugue/16x16/minus-button.png"> 
					          </tr>';
        }
        echo '
							<tr>
								<td colspan="3"> </td>
								<td><div id="tax1" style="float:right; font-size:14px; font-weight:bold;"><select id="otype" name="otype" style="width:60%" onchange="t_type()"><option value="">Select VAT/TAX</option><option value="VAT">VAT</option><option value="TAX">TAX</option></select> : <span id="ttypeid" style="display:none"><input type="text" name="tax" value="" onkeyup="tax()" style="border: none; width:20%;font-size:14px; font-weight:bold;" id="tax">%</span></div></td>
								<td><div id="ttypeid1" style="display:none"><input type="text" id="ttax" name="ttax" onkeyup="tax_total(this.value)"></div></td>
							</tr>
                                                        <tr>
								<td colspan="2"> </td>
								<td><div id="tdsper" style="float:right; font-size:14px; font-weight:bold;">TDS : <input type="text" id="tds_per" name="tds_per" style="width:20%"> % </div></td>
								<td><div id="tdsamt"><input type="text" id="tds_amt" name="tds_amt" onkeyup="tax_total()"></div></td>
							</tr>
							<tr>
								<td colspan="2"> </td>
								<td><div id="tax1" style="float:right; font-size:14px; font-weight:bold;">Shipping Charges</div></td>
								<td><div id="shipping1"><input type="text" id="shipping" name="shipping" onkeyup="shipping_total(this.value)"></div></td>
							</tr>
							<tr>
								<td colspan="2"> </td>
								<td><div id="tax1" style="float:right; font-size:14px; font-weight:bold;">Discount</div></td>
								<td><div id="discount1"><input type="text" id="discount" name="discount" onkeyup="discount_total(this.value)"></div></td>
							</tr>
							</tbody>
					      </table>
						  <input type="hidden" name="id" value="' . $qid . '">
						<div id="overall_amount" style="float:right; font-size:14px; font-weight:bold;">Total Amount: <input type="text" name="overall_totamount" value="' . $row1['total_amount'] . '"  readonly style="border: none; width:30%;font-size:14px; font-weight:bold;" id="overall_totamount"></div>';
    } else if ($value == "New") {
        echo '<table class="table">
					        <thead>				        
                            <tr>
					          <th>Name /Description</th>
					           <th width="10%">Qty</th>
					            <th width="20%">Amount</th>
					           <th width="20%">Total</th>
					           <th width="5%"></th>
					          </tr>                              
					        </thead>					        
					        <tbody class="dfdf">';
        for ($i = 0; $i <= 30; $i++) {
            echo '<tr id="hide_tr' . $i . '"';
            if ($i != 0) {
                echo 'style="display: none;"';
            } echo '>
					            
					            <td> <input type="text" name="name[]" value="" /></td>
					            <td> <input type="text" data-required="true" id="qty' . $i . '"';
            if ($i != 0) {
                echo 'disabled';
            } echo ' name="qty[]" onkeyup="calc(' . $i . ')" data-type="digits" class="required"  name="quantity"> </td>
					            <td>  <input type="text"  data-required="true" data-type="digits"';
            if ($i != 0) {
                echo 'disabled';
            } echo ' id="amount' . $i . '" onkeyup="calc(' . $i . ')" name="amount[]"  class="required" ></td>
					             <td width="20%">  <input type="text"  id="total' . $i . '"    name="total[]" readonly></td>
					              <td>';
            if ($i != 0) {
                echo '<img onclick="hide_table_tr(' . $i . ')" src="img/icons/packs/fugue/16x16/minus-button.png">';
            }
            if ($i == 0) {
                echo '<a id="addvalue' . $i . '" onclick="add_table_tr(' . $i . '+1)" style="cursor:pointer"> <img src="img/icons/packs/fugue/16x16/plus-button.png" title="Add New"/></a></td>';
            }
            echo '</tr>';
        }
        echo '<tr>
								<td colspan="2"> </td>
								<td><div id="tax1" style="float:right; font-size:14px; font-weight:bold;"><select id="otype" name="otype" style="width:60%" onchange="t_type()"><option value="">Select VAT/TAX</option><option value="VAT">VAT</option><option value="TAX">TAX</option></select> : <span id="ttypeid" style="display:none"><input type="text" name="tax" value="" style="border: none; width:20%;font-size:14px; font-weight:bold;" id="tax">%</span></div></td>
								<td><div id="ttypeid1" style="display:none"><input type="text" id="ttax" name="ttax" onkeyup="tax_total(this.value)"></div></td>
							</tr>
                                                        <tr>
								<td colspan="2"> </td>
								<td><div id="tdsper" style="float:right; font-size:14px; font-weight:bold;">TDS : <input type="text" id="tds_per" name="tds_per" style="width:20%"> % </div></td>
								<td><div id="tdsamt"><input type="text" id="tds_amt" name="tds_amt" onkeyup="tax_total()"></div></td>
							</tr>
							<tr>
								<td colspan="2"> </td>
								<td><div id="tax1" style="float:right; font-size:14px; font-weight:bold;">Shipping Charges</div></td>
								<td><div id="shipping1"><input type="text" id="shipping" name="shipping" onkeyup="shipping_total(this.value)"></div></td>
							</tr>
							<tr>
								<td colspan="2"> </td>
								<td><div id="tax1" style="float:right; font-size:14px; font-weight:bold;">Discount</div></td>
								<td><div id="discount1"><input type="text" id="discount" name="discount" onkeyup="discount_total(this.value)"></div></td>
							</tr>
							</tbody>
					      </table>						
						<div id="overall_amount" style="float:right; font-size:14px; font-weight:bold;">Total Amount: <input type="text" name="overall_totamount"  readonly style="border: none; width:20%;font-size:14px; font-weight:bold;" id="overall_totamount"> </div>                         
						<div class="clear"></div>';
    }
}
if ((isset($_GET['value1']) && $_GET['value1'] != '')) {
    $value = $_GET['value1'];
    if ($value) {
        echo '<div class="clear"></div><div class="_50">
							<p>
                                <label for="textfield">Title <span class="error">*</span></label>
                                <input id="textfield" name="title" class="required" type="text" value="" />
                            </p>
						</div>
						<div class="_25">
							<p>
							<label for="textfield">Agency</label>';
        $classl = "SELECT * FROM agency WHERE status=0";
        $result1 = mysql_query($classl) or die(mysql_error());
        echo '<select name="aid" id="aid" onchange="getAdvanceAmount(this.value);">';
        echo "<option value=''>please select agency</option>\n";
        while ($row1 = mysql_fetch_assoc($result1)):
            echo "<option value='{$row1['a_id']}'>{$row1['a_name']}</option>\n";
        endwhile;
        echo '</select>
						</p>
						</div>
                                                <div class="_25 adv_class" style="display:none;" >
							<p>
							<label for="textfield" > Advance Amount </label>
                                                        <input id="adv_amt_id" name="adv_amt_" type="text" value="" readonly />
                                                </div> 
                        <div class="_100">
							<p>
                                <label for="textfield">Description <span class="error">*</span></label>
                                <textarea id="textfield" name="des" class="required" rows="5"></textarea>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Bill No/Receipt No From outside</label>
                                <input id="textfield" name="b_no" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Amount <span class="error">*</span></label>
                                <input id="textfield" name="amount" class="required" type="text" value="" />
                            </p>
						</div>
						<div class="clear"></div>
						<div class="_25">
                                    <p>
                                    <label for="textfield">Payment Type:</label>
										<select name="ptype" id="ptype" class="required" onchange="paymet_type()">
                                            <option value="cash">Cash</option>	
                                            <option value="card">Card</option>
                                            <option value="cheque">cheque</option>									
										</select>	
                                    </p>									
									</div>
                       <div class="_25 adv_class" style="display:none;">
                            <p>
                            <label for="textfield"><br></label>
                            </p>
                               <input type="checkbox" name="use_advance" id="use_advance"  value="" style="width:20%;" onchange="showBalanceAdvance();">Use Advance Amount
                            
			</div>
						<div class="clear"></div>
                                            
                        
                         <div class="_25 bal_adv_class" style="display:none;" >
                            <p>
				<label for="textfield" > Amount From Advance </label>
                                <input id="pay_from_advance" name="pay_from_advance" type="text" value="" onkeyup="showBalanceAdvance();" />
                            </p>    
                        </div>

                        <div class="_25 bal_adv_class" style="display:none;" >
                            <p>
				<label for="textfield" > Balance Advance Amount </label>
                                <input id="bal_adv_amt_id" name="balance_advance" type="text" value="" readonly />
                            </p>    
                        </div>     
						
                                    <div class="clear"></div>  
                                    <div id="ajax_pay1">
									</div>
                                    <div id="cash_pay1">
                                    </div>';
    }
}