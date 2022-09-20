<?php
include("includes/config.php");
if( (isset($_GET['value1']) && $_GET['value1']!=''))
{
	$value=$_GET['value1'];
	
	if($value!="New"){
		
		$sectionlist=mysql_query("SELECT * FROM report_temp WHERE t_id=$value"); 
								  $report=mysql_fetch_array($sectionlist);	
						$field=array();
							$reportlist=explode(",",$report["list"]);
							    
							        foreach($reportlist as $val)
							        {
							            array_push($field,$val);
							        }
									
									$fesstypearray=array(
									"admission_number AS AdmissionNo"=>"AdmissionNo",
									"firstname"=>"Firstname",
									"lastname"=>"lastname",
									"fathersname"=>"fathersname",
									"p_income AS Income"=>"Income",
									"m_name AS MotherName"=>"MotherName",
									"m_occup AS MotherOccuption"=>"MotherOccuption",
									"doa AS DateOfadmission"=>"DateOfadmission",
									"dob AS DateOfBirth"=>"DateOfBirth",
									"gender AS Gender"=>"Gender",
									"nation"=>"nation",
									"reg AS Religion"=>"Religion",
									"caste AS Caste"=>"Caste",
									"sub_caste AS SubCaste"=>"SubCaste",
									"blood"=>"blood",
									"email"=>"email",
									"phone_number AS PhoneNumber"=>"PhoneNumber",
									"address1"=>"address1",
									"address2"=>"address2",
									"city_id AS City"=>"City",
									"country"=>"country",
									"pin AS Pincode"=>"Pincode",
									"mother_tongue AS MotherTonge"=>"MotherTonge",
									"height"=>"height",
									"weight"=>"weight",
									"remarks"=>"remarks",
									"stype AS StudentType"=>"StudentType",
									"fdis_id AS StudentCategory"=>"StudentCategory",
									"sp_id AS StoppingPoint"=>"StoppingPoint",
									"c_id AS Class"=>"Class",
									"s_id AS Section"=>"Section",
									); 
									
							echo '<div class="_75">
							<p>
					         <label for="select">Select Download Field: <span class="error">*</span></label>
							<select name="down_id[]" id="down_id" multiple="multiple" class="form-control required" style="width:100%" >';
							foreach ($fesstypearray as $k => $v) {
								if(in_array($k, $field)){
								echo '<option value="'.$k.'" selected="selected" >'.$v.'</option>';
							}else {
								echo '<option value="'.$k.'" >'.$v.'</option>';            
							 } }
							echo '</select>
					        </p>
						   </div>';
	}else{
		echo '<div class="_75">
							<p>
					         <label for="select">Select Download Field: <span class="error">*</span></label>
							<select name="down_id[]" id="down_id" multiple="multiple" class="form-control required" style="width:100%" >
							<option value="">Select</option>
							<option value="admission_number AS AdmissionNo">AdmissionNo</option>
							<option value="firstname">Firstname</option>
							<option value="lastname">Lastname</option>
							<option value="fathersname">Fathersname</option>
							<option value="fathersocupation">Fathers Ocupation</option>
							<option value="p_income AS Income">Income</option>
							<option value="m_name AS MotherName">MotherName</option>
							<option value="m_occup AS MotherOccuption">MotherOccuption</option>
							<option value="m_income AS MotherIncome">MotherIncome</option>
							<option value="doa AS DateOfadmission">Date Of admission</option>
							<option value="dob AS DateOfBirth">Date Of Birth</option>
							<option value="gender AS Gender">Gender</option>
							<option value="nation">Nation</option>
							<option value="reg AS Religion">Religion</option>
							<option value="caste AS Caste">Caste</option>
							<option value="sub_caste AS SubCaste">Sub Caste</option>
							<option value="blood">Blood</option>
							<option value="email">Email</option>
							<option value="phone_number AS PhoneNumber">Phone Number</option>
							<option value="address1">Address 1</option>
							<option value="address2">Address 2</option>
							<option value="city_id AS City">City</option>
							<option value="country">Country</option>
							<option value="pin AS Pincode">Pincode</option>
							<option value="mother_tongue AS MotherTonge">Mother Tonge</option>
							<option value="height">Height</option>
							<option value="weight">Weight</option>
							<option value="remarks">Remarks</option>
							<option value="stype AS StudentType">Student Type</option>
							<option value="fdis_id AS StudentCategory">Student Category</option>
							<option value="sp_id AS StoppingPoint">StoppingPoint</option>
							<option value="c_id AS Class">Class</option>
							<option value="s_id AS Section">Section</option>
							</select>
					        </p>
						   </div>';
		
	}
	echo '<script type="text/javascript">
$().ready(function() {		
   	 
      	 $(\'#down_id\').select2 ({
      			allowClear: true,
      			placeholder: "Please Select..."
      		}); 
      });	
</script>';
	
	/*if($value=="1"){
		
		echo '<div class="_25">
				<p>
				 <label for="select">Select Template: <span class="error">*</span></label>
				<select name="tid" id="tid" class="form-control required">
				<option value="">Select</option>';		
				$qry=mysql_query("SELECT * FROM report_temp");
					  while($row=mysql_fetch_array($qry))
						{
						echo '<option value="'.$row['t_id'].'">'.$row['title'].'</option>';
						}
						echo '</select></p></div>';
		
	}else if($value=="2"){
		 echo '<div class="_50">
							<p>
					         <label for="select">Select Download Field: <span class="error">*</span></label>
							<select name="down_id[]" id="down_id" multiple="multiple" class="form-control required" style="width:100%" >
							<option value="">Select</option>
							<option value="admission_number AS AdmissionNo">AdmissionNo</option>
							<option value="firstname">Firstname</option>
							<option value="lastname">Lastname</option>
							<option value="fathersname">Fathersname</option>
							<option value="fathersocupation">Fathers Ocupation</option>
							<option value="p_income AS Income">Income</option>
							<option value="m_name AS MotherName">MotherName</option>
							<option value="m_occup AS MotherOccuption">MotherOccuption</option>
							<option value="m_income AS MotherIncome">MotherIncome</option>
							<option value="doa AS DateOfadmission">Date Of admission</option>
							<option value="dob AS DateOfBirth">Date Of Birth</option>
							<option value="gender AS Gender">Gender</option>
							<option value="nation">Nation</option>
							<option value="reg AS Religion">Religion</option>
							<option value="caste AS Caste">Caste</option>
							<option value="sub_caste AS SubCaste">Sub Caste</option>
							<option value="blood">Blood</option>
							<option value="email">Email</option>
							<option value="phone_number AS PhoneNumber">Phone Number</option>
							<option value="address1">Address 1</option>
							<option value="address2">Address 2</option>
							<option value="city_id AS City">City</option>
							<option value="country">Country</option>
							<option value="pin AS Pincode">Pincode</option>
							<option value="mother_tongue AS MotherTonge">Mother Tonge</option>
							<option value="height">Height</option>
							<option value="weight">Weight</option>
							<option value="remarks">Remarks</option>
							<option value="stype AS StudentType">Student Type</option>
							<option value="fdis_id AS StudentCategory">Student Category</option>
							</select>
					        </p>
						   </div>';
						   echo '<script type="text/javascript">
$().ready(function() {		
   	 
      	 $(\'#down_id\').select2 ({
      			allowClear: true,
      			placeholder: "Please Select..."
      		}); 
      });	
</script>';
		}*/
}
?>
