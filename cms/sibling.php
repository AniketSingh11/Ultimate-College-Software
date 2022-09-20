<?php
include("includes/config.php"); 
if( (isset ($_GET['value']) && $_GET['value']!='') /*&& (isset ($_GET['stid']) && $_GET['stid']!='') */)
{
	 $value=$_GET['value'];
	 
	 $studentlist=mysql_query("SELECT * FROM student WHERE ss_id=$value"); 
		  $row=mysql_fetch_array($studentlist); 
	 
	 $parentlist=mysql_query("SELECT * FROM parent WHERE ss_id=$value"); 
		  $parent=mysql_fetch_array($parentlist); 
		  	 
		  
	 echo  '<div class="_25">
							<p>
                                <label for="textfield">First Name: <span class="error">*</span></label>
                                <input id="textfield" name="fname" class="required" type="text" value="" />
								<input id="textfield" name="sibling" type="hidden" value="1" />
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
								<input id="textfield" name="c_id1" type="hidden" value="'.$row['c_id'].'" />
								<input id="textfield" name="s_id1" type="hidden" value="'.$row['s_id'].'" />
								<input id="textfield" name="admin_no1" type="hidden" value="'.$row['admission_number'].'" />
								<input id="textfield" name="b_id1" type="hidden" value="'.$row['b_id'].'" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield"> Father / Guardian Occupation: <span class="error">*</span></label>
                                <input id="textfield" name="p_occup" class="required" type="text" value="'.$row['fathersocupation'].'" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Father / Guardian Income:</label>
                                <input id="textfield" name="p_income" type="text" value="'.$row['p_income'].'" />
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
                                <label for="textfield">Mother\'s Occupation : </label>
                                <input id="textfield" name="m_occup" type="text" value="'.$row['m_occup'].'" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield"> Mother\'s Monthly Income: </label>
                                <input id="textfield" name="m_income" type="text" value="'.$row['m_income'].'" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Date of admission : </label>
                                <input id="datepicker" name="doa" type="text" value="" />
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
                        <div class="_25">
							<p>
                                <label for="textfield">Nationality:</label>
                                <input id="textfield" name="belong" type="text" value="'.$row['nation'].'" />
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
						</div>';
						$castelist=array("GENERAL","SC","ST","OBC","CHRISTIAN","MUSLIM","OTHERS"); 
                        echo '<div class="_25">
							<p>
                                <label for="textfield">Community : <span class="error">*</span></label>
								<select  name="caste" id="caste" class="required">
                                    <option value="" selected="selected" >Select</option>';
									$castevalue=$row['caste'];
									for ($cmonth = 0; $cmonth <= 6; $cmonth++) {
										if($castevalue==$castelist[$cmonth]){
                                    echo '<OPTION VALUE="'.$castelist[$cmonth].'" selected>'.$castelist[$cmonth].'</OPTION>';
										}else{
									echo '<OPTION VALUE="'.$castelist[$cmonth].'">'.$castelist[$cmonth].'</OPTION>';		
										}
									}
                                    echo '</select>
                            </p>
						</div>
						<div class="clear"></div>
                        <div class="_25">
							<p>
                                <label for="textfield">Subcaste :</label>
                                <input id="textfield" name="subcaste" type="text" value="'.$row['sub_caste'].'" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Blood Group : <span class="error">*</span></label>
                                <select  name="blood" id="blood" class="required">
                                    <option value="" selected="selected" >Select</option>
                                    <OPTION VALUE="A +ve">A +ve </OPTION>
                                    <OPTION VALUE="A -ve">A -ve </OPTION>
                                    <OPTION VALUE="A1 +ve">A1 +ve </OPTION>
                                    <OPTION VALUE="A1 -ve">A1 -ve </OPTION>
                                    <OPTION VALUE="A2 +ve">A2 +ve </OPTION>
                                    <OPTION VALUE="A2 -ve">A2 -ve </OPTION>
                                    <OPTION VALUE="B +ve">B +ve </OPTION>
                                    <OPTION VALUE="B -ve">B -ve </OPTION>
                                    <OPTION VALUE="O +ve">O +ve </OPTION>
                                    <OPTION VALUE="O -ve">O -ve </OPTION>
                                    <OPTION VALUE="AB +ve">AB +ve </OPTION>
                                    <OPTION VALUE="AB -ve">AB -ve </OPTION>
                                    <OPTION VALUE="A1B +ve">A1B +ve </OPTION>
                                    <OPTION VALUE="A1B -ve">A1B -ve </OPTION>
                                </select>
                            </p>
						</div>
						<div class="_25">
							<p>
								<label for="select">City or village Name : <span class="error">*</span></label>
                                <input id="textfield" name="village" class="required" type="text" value="'.$row['city_id'].'" />
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Country : <span class="error">*</span></label>
                                <input id="textfield" name="country" class="required" type="text" value="'.$row['country'].'" />
							</p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Residence Address1 : <span class="error">*</span></label><textarea id="textarea" name="address1" class="required" rows="5" cols="40">'.$row['address1'].'</textarea></p>
						</div>
                        <div class="_50">
							<p><label for="textarea">Residence Address2 :</label><textarea id="textarea" name="address2" rows="5" cols="40">'.$row['address2'].'</textarea></p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Pin Code : <span class="error">*</span></label>
                                <input id="textfield" name="pincode" class="required" type="text" value="'.$row['pin'].'" />
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
                                <label for="textfield">Phone : <span class="error">*</span></label>
                                <input id="textfield" name="phone" class="required" type="text" value="'.$row['phone_number'].'" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Mother Tongue : <span class="error">*</span></label>
                                <input id="textfield" name="m_tongue" class="required" type="text" value="'.$row['mother_tongue'].'" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Height : </label>
                                <input id="textfield" name="height" type="text" value="" />
                            </p>
						</div>
                        <div class="_25">
							<p>
                                <label for="textfield">Weight : </label>
                                <input id="textfield" name="weight" type="text" value="" />
                            </p>
						</div>
                             <div class="_25">
							<p>
                                <label for="textfield">Are You Stay in Hostel : </label>
                                 <select name="hostel" class="required">
									<option value="No">No</option>
									<option value="Yes">Yes</option>
								</select>
                            </p>
						 </div>       
                                    
                        <div class="_100">
							<p><label for="textarea">Remarks :</label>
                            <textarea id="textarea" name="remarks" rows="5" cols="40"></textarea></p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Student Category :</label>
									<select name="category" class="required">';
                                 	$sql1=mysql_query("SELECT * FROM fdiscount");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
											echo '<option value="'.$row2['fdis_id'].'">'.$row2['fdis_name'].'</option>';
                                 }
									echo '</select>								
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Student Type : <span class="error">*</span></label>
								<select name="stype" class="required">
									<option value="Old">Old Student</option>
									<option value="New">New Student</option>
								</select>
							</p>
						</div>
						<div class="_25">
							<p>
								<label for="select">Mode of Transport : </label>
                                	<select name="mode" id="mode" class="required" onchange="showCategory1(this.value)">
                                        <option value="">select</option>	
                                        <option value="School Van">School Van</option>
                                        <option value="Private Van">Private Van</option>
                                        <option value="Car">Car</option>
                                        <option value="Auto">Auto</option>
                                        <option value="Two Wheeler">Two Wheeler</option>												
									</select>
							</p>
						</div>
						<div id="eleven_mark1" style="display: none;">
                        <div class="_25">
							<p>
								<label for="select">Stopping Point :</label>
                               <select name="spid" id="spid1">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">Fees Rate Type:</label>
                               <select name="busfeestype" id="busfeestype">
											<option value="0">Normal Fees</option>
                                            <option value="1">Sp.Fees</option>
                                            <option value="2">Onetime Sp.Fees</option>
											<option value="3">Onetime fees</option>												
								</select>
							</p>
						</div>
						</div>
                       
						 <div id="move_div">
							 
						</div>
						<div class="_25">
							<p>
								<label for="select">Fees Payment Type :</label>
									<select name="mpd_id">
                                    <option value="">Please Select</option>';
                                    
									$sql1=mysql_query("SELECT * FROM mpaydiscount");
									while($row2=mysql_fetch_assoc($sql1))
									{
												echo '<option value="'.$row2['mpd_id'].'">'.$row2['name'].'</option>';
                                }
											echo '</select>								
							</p>
						</div>'
					   ;
    
}
?>
