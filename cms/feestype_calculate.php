<?php

function thefunction($number){
  if ($number < 0)
    return 0;
  return $number; 
}

include("includes/config.php"); 
if( (isset ($_GET['value']) && $_GET['value']!=''))
{
	 $value=$_GET['value'];
	 
	 $data_split= explode(',', $value);
			$cartid=$data_split[0];
			$frid=$data_split[1];		
			$fgid=$data_split[2];
			$fgdid=$data_split[3];
			$name=$data_split[4];
			$amount=$data_split[5];
			$tamount=$data_split[6];
			$type=$data_split[7];
			$paid=$data_split[8];
   
   
   if($amount>0){
   echo '<div class="_25">
                            	<p>
                                    <label for="required">Fees:</label>
                                    <input type="text" name="tamount" id="tamount" class="biginput" id="autocomplete" class="required" value="'.$tamount.'" readonly />           							
								</p> <!-- .field-group -->
                            </div>
                            <div class="_25">
                            	<p>
                                    <label for="required">Pay Amount:</label>
                                    <input type="text" name="amount" id="amount" class="biginput" id="autocomplete" class="required" value="'.$amount.'"'; 
									if($type=="other"){ echo "readonly";} 
									echo '/>           							
								</p> <!-- .field-group -->
                            </div>
                          <div class="_25">
                            	<p>
                                <input type="hidden" id="cartid" name="cartid" value="'.$cartid.'" />
                             <input type="hidden" id="frid" name="frid" value="'.$frid.'" />
							 <input type="hidden" id="fgid" name="fgid" value="'.$fgid.'" />
                             <input type="hidden" id="fgdid" name="fgdid" value="'.$fgdid.'" />
                            <input type="hidden" name="name" id="name" value="'.$name.'" />
                            <input type="hidden" id="type" name="type" value="'.$type.'" /> 
							<input type="hidden" id="paid" name="paid" value="'.$paid.'" /> 
                                    <button style="margin:15px 0 0 0" type="submit" name="add-fees" class="btn btn-green">Add</button>
								</p> <!-- .field-group -->
                            </div>'; 
   } else{
				echo '<div class="_50">
                            	<p>
								<div class="alert error"><span class="hide">x</span>This Fees group Fully Paid!!!</div>
								</p>
					</div>';   
   }
   
	
}