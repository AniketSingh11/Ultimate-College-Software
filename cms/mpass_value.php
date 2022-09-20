<?php 
include("includes/config.php");

if( (isset ($_GET['value']) && $_GET['value']!='') && (isset ($_GET['ssid']) && $_GET['ssid']!='') && (isset ($_GET['lang']) && $_GET['lang']!='') && (isset ($_GET['other']) && $_GET['other']!=''))
{
	$fdisid =$_GET['value'];
$ssid =$_GET['ssid'];
$fr_split= explode(',',$_GET['lang']);
$frid1=$fr_split[0];
$ftype=$fr_split[1];

$value=$_GET['other'];

$data_split= explode(',', $value);
			$bid=$data_split[0];
			$cid=$data_split[1];		
			$sid=$data_split[2];
			$acyear=$data_split[3];
			
			$studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$ssid"); 
								  $student=mysql_fetch_array($studentlist);
								  $mlate_join=$student['mlate_join'];
			

if($ftype=="fees"){
$fratelist=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid1");
									 $frate=mysql_fetch_array($fratelist);
					$ffgid=$frate['fg_id'];	 
$fgrouplist=mysql_query("SELECT * FROM mfgroup WHERE fg_id=$ffgid");
									 $ffgroup=mysql_fetch_array($fgrouplist);
						$ftyid=$ffgroup['fty_id'];	
						
						$fendmonth=$ffgroup['end'];
									
									if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}		 
						
$ftypelist=mysql_query("SELECT * FROM ftype WHERE fty_id=$ftyid"); 
								  $ftype=mysql_fetch_array($ftypelist);
						$ftypevalue=$ftype['fty_value'];
$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid1 AND fdis_id=$fdisid"); 
								  $class=mysql_fetch_array($classlist);
		
					 $frateid=$frid1;
					 $fratefrom='1';
					 $frateto=$ftypevalue;
					 $frateamount=$class['dis_value'];
					 
					if(!empty($frateid)) { 
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND s_id = '" . $sid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
					 
							$qry3=mysql_query($qry3);
							
							
							$fratelist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frateid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid2=$frate1['fg_id'];
								if($ftypevalue==1){
								$f_to1=$mlate_join;	
							}else{
								$f_to1="";	
							}	 
								//$f_to1="";
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid2;"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to1=$fsummay['fto'];
									 if($f_to1==$tomonth){										 										   
										 $fullpaid++;
									  }		
								 }
								// $fullpaid;
								}
					}
					$f_to1;
					if($f_to1){
						$fratefrom=$f_to1+1;
							if($frateto>1){						
									$frateto1=$fratefrom+$frateto;
								}else{
									$frateto1=$fratefrom;
								}
						//$frateto1=$fratefrom+$frateto;
						if($frateto1>$tomonth){
							$frateto1=$tomonth;
						}
						/*if($fratefrom==$frateto1){
							echo '<script language="javascript">';
							echo 'alert("This Category Fees Fully Paid")';
							echo '</script>';
						}*/
						//ftovalue-ffromvalue)/ftyvalue)*feesvalue;
						
						$frateamount1=(($frateto1-($fratefrom-1))/$frateto)*$frateamount;							
					}else {
							$frateto1=$frateto;
							$frateamount1=$frateamount;							
						}
					if($frateamount1){	
						echo '<div class="_25">
                            	<p>
                                    <label for="required">Fees From:</label>';
                                    
				$montharray=array("","June","July","August","September","October","November","December","January","February","March","April","May"); 
			
                                    echo '<select name="ffrom" id="ffrom" class="required" onchange="change_amountfrom()" >';
                                    
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
				if($fratefrom==$cmonth){
                echo '<option value="'.$cmonth.'" selected="selected" >'.$montharray[$cmonth].'</option>';
             } /*else { 
            echo '<option value="'.$cmonth.'" style="background-color:#D6EDF8" >'.$montharray[$cmonth].'</option>';            
             } */
				}
                                    echo '</select>										
								</p> <!-- .field-group -->
                            </div>
                            <div class="_25">
                            	<p>
                                    <label for="required">Fees To:</label>
                                    <select name="fto" id="fto" class="required" onchange="change_amountfrom()" >';
                                	
				for ($cmonth = 1; $cmonth <= 12; $cmonth++) { 
				if($tomonth>=$cmonth){
				if($fratefrom<=$cmonth){
				if($frateto1==$cmonth){
                echo '<option value="'.$cmonth.'" selected="selected">'.$montharray[$cmonth].'</option>';
             } else if(!$frateto && 12==$cmonth) {
                                     echo '<option value="'.$cmonth.'" selected="selected">'.$montharray[$cmonth].'</option>';
                                      }else { 
            echo '<option value="'.$cmonth.'" style="background-color:#D6EDF8" >'.$montharray[$cmonth].'</option>';         
            } 
				} }
			} 
                                   echo  '</select>										
								</p> <!-- .field-group -->                               	
                            </div>
                            <div class="_25">
                            	<p>
                                    <label for="required">Fees:</label>
                                    <input type="text" name="fees" id="fees" class="biginput" id="autocomplete" class="required" value="'.$frateamount1.'"  readonly/>										
								</p> <!-- .field-group -->
                            </div>
                             <input type="hidden" id="ffrom1" value="'.$fratefrom.'" />
                            <input type="hidden" name="ftyvalue" id="ftyvalue" value="'.$frateto.'" />
                            <input type="hidden" id="feesvalue" name="feesvalue" value="'.$frateamount.'" />
							<input type="hidden" id="ftomonth" name="ftomonth" value="'.$tomonth.'" />
							<input type="hidden" id="feestype" name="feestype" value="fees" />
                            <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><input type="submit" name="add-fees" class="button" value="ADD"></li>
							</ul>
						</div>';
					}else{
						echo '<div class="_50">
                            	<p>
								<div class="alert error"><span class="hide">x</span>This Fees group Fully Paid!!!</div>
								</p>
					</div>';   
   }
}
if($ftype=="other"){
				$fratelist=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frid1");
									 $frate=mysql_fetch_array($fratelist);
					$ffgdid=$frate['fgd_id'];	 
$fgrouplist=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$ffgdid");
									 $ffgroup=mysql_fetch_array($fgrouplist);
						
						$ftypevalue=12;
$classlist=mysql_query("SELECT * FROM mfrate_value WHERE fr_id=$frid1 AND fdis_id=$fdisid"); 
								  $class=mysql_fetch_array($classlist);
		
					 $frateid=$frid1;
					 $fratefrom='1';
					 $frateto=$ftypevalue;
					 $frateamount=$class['dis_value'];
					 
					if(!empty($frateid)) { 
					 $qry3="SELECT * FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND s_id = '" . $sid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";
					 
							$qry3=mysql_query($qry3);
							
							
							$fratelist1=mysql_query("SELECT * FROM mfrate WHERE fr_id=$frateid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid2=$frate1['fg_id'];	
					$ffgdid21=$frate1['fgd_id']; 
								$f_to1="";
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT * FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid2 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to1=$fsummay['fto'];
									 if($f_to1==12){										 										   
										 $fullpaid++;
									  }		
								 }
								// $fullpaid;
								}
					}
					$f_to1;
					if($f_to1){
						$fratefrom=$f_to1+1;
						$frateto1=$fratefrom+$frateto;
						if($frateto1>12){
							$frateto1=12;
						}
						/*if($fratefrom==$frateto1){
							echo '<script language="javascript">';
							echo 'alert("This Category Fees Fully Paid")';
							echo '</script>';
						}*/
						//ftovalue-ffromvalue)/ftyvalue)*feesvalue;
						
						$frateamount1=(($frateto1-($fratefrom-1))/$frateto)*$frateamount;							
					}else {
							$frateto1=$frateto;
							$frateamount1=$frateamount;							
						}
					if($frateamount1){	
						echo '<div class="_25">
                            	<p>
                                    <label for="required">Fees:</label>
                                    <input type="text" name="fees" id="fees" class="biginput" id="autocomplete" class="required" value="'.$frateamount1.'"  readonly/>										
								</p> <!-- .field-group -->
                            </div>
                             <input type="hidden" id="ffrom1" value="'.$fratefrom.'" />
                            <input type="hidden" name="ftyvalue" id="ftyvalue" value="'.$frateto.'" />
                            <input type="hidden" id="feesvalue" name="feesvalue" value="'.$frateamount.'" />
							<input type="hidden" id="feestype" name="feestype" value="other" />
                            <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><input type="submit" name="add-fees" class="button" value="ADD"></li>
							</ul>
						</div>';
					}else{
						echo '<div class="_50">
                            	<p>
								<div class="alert error"><span class="hide">x</span>This Fees group Fully Paid!!!</div>
								</p>
					</div>';   
   		}
}
if($ftype=="other1"){
	
	$fgrouplist1=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$frid1 AND otherfees='1'");
									 $ffgroup1=mysql_fetch_array($fgrouplist1);
	$frateamount1=$ffgroup1['fees_amount'];
	$fratefrom=1;
	$frateto=12;
	if($frateamount1){	
						echo '<div class="_25">
                            	<p>
                                    <label for="required">Fees:</label>
                                    <input type="text" name="fees" id="fees" class="biginput" id="autocomplete" class="required" value="'.$frateamount1.'"  readonly/>										
								</p> <!-- .field-group -->
                            </div>
                             <input type="hidden" id="ffrom1" value="'.$fratefrom.'" />
                            <input type="hidden" name="ftyvalue" id="ftyvalue" value="'.$frateto.'" />
                            <input type="hidden" id="feesvalue" name="feesvalue" value="'.$frateamount1.'" />
							<input type="hidden" id="feestype" name="feestype" value="other" />
                            <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><input type="submit" name="add-fees" class="button" value="ADD"></li>
							</ul>
						</div>';
					}else{
						echo '<div class="_50">
                            	<p>
								<div class="alert error"><span class="hide">x</span>This no fees amount added!!!</div>
								</p>
					</div>';   
   		}
}
}
?>