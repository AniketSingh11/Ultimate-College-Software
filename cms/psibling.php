<?php
include("includes/config.php"); 
if( (isset ($_GET['value']) && $_GET['value']!='') /*&& (isset ($_GET['stid']) && $_GET['stid']!='') */)
{
	 $value=$_GET['value'];
	 
	 $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$value"); 
		  $row=mysql_fetch_array($studentlist); 
	 
	 $parentlist=mysql_query("SELECT * FROM parent WHERE ss_id=$value"); 
		  $parent=mysql_fetch_array($parentlist); 
	 
	 echo '<div class="_25">
							<p>
                                <label for="textfield">First Name: <span class="error">*</span></label>
                                <input id="textfield" name="fname" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Last Name:</label>
                                <input id="textfield" name="lname" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father / Guardian Name: <span class="error">*</span></label>
                                <input id="textfield" name="p_name" class="required" type="text" value="'.$row['fathersname'].'" />
								<input id="textfield" name="p_id" type="hidden" value="'.$parent['p_id'].'" />
								<input id="textfield" name="ss_id1" type="hidden" value="'.$row['ss_id'].'" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Mother\'s Name : </label>
                                <input id="textfield" name="m_name" type="text" value="'.$row['m_name'].'" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date Of Birth : <span class="error">*</span></label>
                                <input id="datepicker1" name="dob" class="required" type="text" value="" />
                            </p>
						</div>
                       <div class="_25">
							<p>
								<label for="select">Gender : <span class="error">*</span></label>
								<select name="gender" class="required">
									<option value="">Select one</option>
									<option value="M">Male</option>
									<option value="F">Female</option>
								</select>
							</p>
						</div>
                        <div class="clear"></div>
                        <div class="_50">
							<p><label for="textarea">Address : <span class="error">*</span></label><textarea id="textarea" name="address1" class="required" rows="5" cols="40">'.$row['address1'].'</textarea></p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">City: <span class="error">*</span></label>
                                <input id="textfield" name="village" class="required" type="text" value="'.$row['city_id'].'" />
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">State : <span class="error">*</span></label>
                                <input id="textfield" name="state" class="required" type="text" value="" />
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Country : <span class="error">*</span></label>
                                <input id="textfield" name="country" class="required" type="text" value="'.$row['country'].'" />
							</p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Pin Code : <span class="error">*</span></label>
                                <input id="textfield" name="pincode" class="required" type="text" value="'.$row['pin'].'" />
                            </p>
						</div>
						<div class="_25">
							<p>
                                <label for="textfield">Religion : <span class="error">*</span></label>';
								$religionlist=array("Buddhist","Christian","Hindu","Jain","Muslim","Parsi","Sikh"); 
                        echo '<select  name="religion" id="religion" class="required">
                                    <option value="" selected="selected" >Select</option>';
									$religionvalue=$row['reg'];
									for ($cmonth = 0; $cmonth <= 6; $cmonth++) {
										if($religionvalue==$religionlist[$cmonth]){
                                    echo '<OPTION VALUE="'.$religionlist[$cmonth].'" selected>'.$religionlist[$cmonth].'</OPTION>';
										}else{
									echo '<OPTION VALUE="'.$religionlist[$cmonth].'">'.$religionlist[$cmonth].'</OPTION>';		
										}
									}
                                    echo '</select>
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Email :</label>
                                <input id="textfield" name="email" type="text" value="'.$row['email'].'" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father / Guardian Phone No: <span class="error">*</span></label>
                                <input id="textfield" name="phone" class="required" type="text" value="'.$row['phone_number'].'" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Additional Phone No 1 : </label>
                                <input id="textfield" name="phone1" type="text" value="">
                            </p>
						</div>
						<div class="clear"></div>
                        <div class="_25">
							<p>
                                <label for="textfield">Additional Phone No 2 :</label>
                                <input id="textfield" name="phone2" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Additional Phone No 3 : </label>
                                <input id="textfield" name="phone3"  type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Select Board: <span class="error">*</span></label>
                                <select name="b_id" id="bid" onchange="showCategoryboard1(this.value)">
                                <option value="">Select Board</option>';
                                
							$qry=mysql_query("SELECT * FROM board");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
                				echo '<option value="'.$row['b_id'].'">'.$row['b_name'].'</option>';
                  }
                  echo '</select>
                            </p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                               <select name="cid1" id="cid1" onchange="standard1(this.value)" class="required">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>';
    
}
?>
