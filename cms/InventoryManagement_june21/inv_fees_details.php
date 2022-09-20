<? ob_start(); ?>
    <?php
	//include("../includes/config.php");
	include("header_top.php");
	 $student_id = $_POST['studentid'];
	
	 $class_id = $_POST['classid']; 
	
 	     $sql = "SELECT *,sum(rate) as feesamount FROM frate left join fgroup_detail on (fgroup_detail.fgd_id = frate.fgd_id) 
	  where c_id= ".$class_id." and ay_id=$acyear group by frate.fgd_id";
$sql_res = mysql_query($sql) or die("Could not fetch data into DB: " . mysql_error());
echo '

<table class=" table fees_details" border="1">
<thead>
<tr>
<th> S.No</th>
<th> Group Name </th>
<th> Fees Amount </th>
<th> Status </th>
</tr>
</thead>
<tbody>
';
$i=1;
while ($thisrow = mysql_fetch_array($sql_res)){
		echo "<tr>
		<td> ".$i++."</td>
		<td>".$thisrow['name']." </td>
		<td>".$thisrow['feesamount']."</td>
		<td>
		";
		
		   $sql_summary = "SELECT * , SUM( tamount ) as paidamt FROM finvoice INNER JOIN fsalessumarry ON ( fsalessumarry.fi_id = finvoice.fi_id ) 
WHERE finvoice.bid=$brdid AND finvoice.ay_id=$acyear AND finvoice.ss_id = ".$student_id." AND finvoice.c_id = ".$class_id." AND i_status = 0 and c_status!='1' GROUP BY fsalessumarry.fgd_id ";

		$res_summary = mysql_query($sql_summary) or die("Could not fetch data from DB: " . mysql_error());
		
		$text = "<span class='status_text not'> NOT PAID </span>";
		
		while ($thisrow_sum = mysql_fetch_array($res_summary)){
			
			
			if(($thisrow_sum['fgd_id']!="") && ($thisrow_sum['fgd_id']==$thisrow['fgd_id']))
			{			
				if(($thisrow_sum['paidamt']>=$thisrow['feesamount'])){
					
				 	$text = "<span class='status_text'> PAID </span>";
				}
				else{
					
					 $text = "<span class='status_text not'> NOT PAID </span>";
	
				}		
			}
		}
		
		echo "$text
		</td><tr>
		";
}
echo "</tbody>
</table>
";
?>

 <h3 class="grid-5"> Last Year Pending Fees :</h3>
                        
                   <?php     /********* start last year fees ******************/
				 
				$layear=mysql_query("SELECT ay_id FROM year WHERE e_year=$syear");
				$lay=mysql_fetch_array($layear);  
				 $lacyear=$lay['ay_id'];
				$count=1;
				/****************************************** Pending Amount Start **********************************/
					if($lacyear){
						
									$lst_qry = "SELECT ss_id,c_id,s_id,stype,fdis_id,admission_number,firstname,lastname FROM student 
									WHERE ay_id=$lacyear ";
									
									$lstudentlist=mysql_query($lst_qry); 
									
								  while($lstudent=mysql_fetch_array($lstudentlist)){
									  $totalpending=0;
								  $lssid=$lstudent['ss_id'];
								  $lcid=$lstudent['c_id'];
								  	$lsid=$lstudent['s_id'];
									$ls_type=$lstudent['stype'];
									$lfdisid1=$lstudent['fdis_id'];
									
									$lclasslist1=mysql_query("SELECT c_name FROM class WHERE c_id=$lcid"); 
								    $lclass1=mysql_fetch_array($lclasslist1);
									
									$sectionlist1=mysql_query("SELECT s_name FROM section WHERE s_id=$lsid"); 
								  $section1=mysql_fetch_array($sectionlist1);	
									
									if(($lclass1['c_name']=="XI STD") || ($lclass1['c_name']=="XII STD") || ($lclass1['c_name']=="XI") || ($lclass1['c_name']=="XII")){
									 $lsid21 = $lsid;
								  }else {
									  $lsid21 = "0";
								  }
								  
								 $qry_12 = "SELECT fg_id,fgd_id,fr_id FROM mfrate WHERE c_id=$lcid AND b_id=$bid AND ay_id=$lacyear AND rate='$ls_type' 
				AND s_id=$lsid21 ORDER BY fgd_id";
				$sql1=mysql_query($qry_12);
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									 $ffgid=$row2['fg_id'];
									 $ffgdid=$row2['fgd_id'];
									$frid=$row2['fr_id'];
									
									if($ffgid){ 
									/************************ School Fees start*********************************/									
									
									$fgrouplist=mysql_query("SELECT fty_id,end FROM mfgroup WHERE fg_id=$ffgid");
									$ffgroup=mysql_fetch_array($fgrouplist);
									$ftyid=$ffgroup['fty_id'];
									$fendmonth=$ffgroup['end'];									
									if($fendmonth){
										$tomonth=$fendmonth;
									}else{
										$tomonth=12;
									}
								$ftypelist=mysql_query("SELECT fty_value FROM ftype WHERE fty_id=$ftyid"); 
																  $ftype=mysql_fetch_array($ftypelist);
														$ftypevalue=$ftype['fty_value'];													
														
										//$_SESSION['frate']['ffrom'] = '1';
										//$_SESSION['frate']['fto'] = $ftypevalue;		  						
								$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$lfdisid1"); 
																  $class=mysql_fetch_array($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgid;
					 $fratefrom2='1';
					 if($ftypevalue==1 && $mpdid){
					 	 $frateto2=intval($dismonth);
					 }else{
						 $frateto2=$ftypevalue;
					 }
						 
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
										
					 $qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $lacyear. "' AND c_id = '" . $lcid. "' AND ss_id = '" . $lssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							$fratelist1=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							if($ftypevalue==1){
								$f_to12=$mlate_join;	
							}else{
								$f_to12="";	
							}
								
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT fto FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==$tomonth){										 										   
										 $fullpaid2++;
									  }		
								 }
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;						
								if($frateto2>1){						
									$frateto12=$fratefrom2+$frateto2;
								}else{
									$frateto12=$fratefrom2;
								}
								
						if($frateto12>$tomonth){
							$frateto12=$tomonth;							
						}
						if($ftypevalue==1 && $mpdid){
								 $frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2*$frateto2;
							 }else{
								 $frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;
							 }
							 $rmonth=$tomonth-$frateto12;
													
					}else {
							$frateto12=$frateto2;
							
							if($frateto12>$tomonth){
								$frateto12=$tomonth;							
							}
							
							if($ftypevalue==1 && $mpdid){
								 $frateamount12=$frateamount2*$frateto12;
							 }else{
								 $frateamount12=$frateamount2;
							 }		
							 $rmonth=$tomonth-$frateto12;				
						}
						if($frateto12==$tomonth && ($ftypevalue==1 && $mpdid)){
							$discount=1;
						}
						if($rmonth){
							$frateamount12=$frateamount12*($rmonth+1);
						}
						 $fratefrom2;
						 $frateto12;
						 $frateamount12;
						if($frateamount12>0){
							//addtocart($ffgid,$fratefrom2,$frateto12,$frateamount12,$frid,$ftypevalue,$frateamount12,$frateamount2,"fees",$tomonth);
							$totalpending +=$frateamount12;
						 }
				}
				/************************ School Fees end*********************************/
				
				if($ffgdid){ /************************ Other Fees start*********************************/
														$ftypevalue=12;
									
								$classlist=mysql_query("SELECT dis_value FROM mfrate_value WHERE fr_id=$frid AND fdis_id=$lfdisid1"); 
																  $class=mysql_fetch_array($classlist);
										$class['dis_value'];
										
										$frateid2=$ffgdid;
					 $fratefrom2='1';
					 $frateto2=$ftypevalue;
					 $frateamount2=$class['dis_value'];
					 $fullpaid2=0;
					 $f_to12=0;
										if(!empty($frid)) { 
					 $qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $lacyear. "' AND c_id = '" . $lcid. "' AND ss_id = '" . $lssid. "' AND c_status!='1' AND i_status='0'";
							
							$qry3=mysql_query($qry3);							
							
							$fratelist1=mysql_query("SELECT fg_id,fgd_id FROM mfrate WHERE fr_id=$frid");
									 $frate1=mysql_fetch_array($fratelist1);
					$ffgid21=$frate1['fg_id'];
					$ffgdid21=$frate1['fgd_id'];	 
					
							$f_to12="";	
						  while($row3=mysql_fetch_array($qry3))
							{
								$fullpaid2=0;
								$fiid1=$row3['fi_id'];
								$fsummaylist=mysql_query("SELECT fto FROM mfsalessumarry where fi_id=$fiid1 AND fg_id=$ffgid21 AND fgd_id=$ffgdid21"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 $f_to12=$fsummay['fto'];
									 if($f_to12==12){										 										   
										 $fullpaid2++;
									  }		
								 }
								}
					}
					if($f_to12){
						$fratefrom2=$f_to12+1;
								if($frateto2>1){						
									$frateto12=$fratefrom2+$frateto2;
								}else{
									$frateto12=$fratefrom2;
								}
						if($frateto12>12){
							$frateto12=12;							
						}
						
						$frateamount12=(($frateto12-($fratefrom2-1))/$frateto2)*$frateamount2;							
					}else {
							$frateto12=$frateto2;
							$frateamount12=$frateamount2;							
						}
						 $fratefrom2;
						 $frateto12;
						  $frateamount12;
						if($frateamount12>0){
							$totalpending +=$frateamount12;
						 }
				}
				/************************ Other Fees end*********************************/
			}
				/****************************************** Pending Amount End **********************************/
					
				//echo $totalpending."<br>";
				$rollno=$lstudent['admission_number'];
				$studentlist=mysql_query("SELECT ss_id,c_id FROM student WHERE admission_number LIKE '$rollno' AND ay_id=$acyear"); 

								  $student=mysql_fetch_array($studentlist);
								  $ssid=$student['ss_id'];
								  $cid=$student['c_id'];
				$ptypepay=0;
				$fiid2=0;
				$qry3="SELECT fi_id FROM mfinvoice WHERE bid= '" . $bid. "' AND ay_id='" . $acyear. "' AND c_id = '" . $cid. "' AND ss_id = '" . $ssid. "' AND c_status!='1' AND i_status='0'";							
							//echo $qry1;
							$qry3=mysql_query($qry3);
							 while($row3=mysql_fetch_array($qry3))
							{
							$fiid1=$row3['fi_id'];
							$fsummaylist=mysql_query("SELECT ftype FROM mfsalessumarry where fi_id=$fiid1"); 
								 while($fsummay=mysql_fetch_array($fsummaylist)){
									 if($fsummay['ftype']=="pending"){
									 $ptypepay=1;
									 $fiid2=$fiid1;
									 }
								 }
							}
				
							if($totalpending){
								$fdis_id=$lstudent['fdis_id'];
								$qry6=mysql_query("SELECT fdis_name FROM fdiscount WHERE fdis_id=$fdis_id"); 
								  $row6=mysql_fetch_array($qry6);
							if($admin_no==$lstudent['admission_number']){
						?>
							
								
                                <h4 class="grid-4"><?php echo $totalpending; ?></h4>
                                <h4 class="grid-8"><?php if($totalpending>0 && $ptypepay==0)
								{
									echo '<span class="status_text not"> PENDING </span>';
								}else{
										echo '<span class="status_text"> PAID </span>';
									};?>
                                </h4>
                                <span class="grid-12"></span>
								 <?php 
							$count++;
							}
							} 
							}  
							
							}
							/********* end last year fees ******************/
							?>
 
<style>
.status_text{
	font-weight:bold;
	color:green;	
	}
.status_text.not{
	color:red;
	} 	
</style>
<? ob_flush(); ?>
