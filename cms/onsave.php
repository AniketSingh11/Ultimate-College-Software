 <?php
 include("includes/config.php");
$cosmo = $_POST["p"];
$pposition = $_POST["pposition"];
$cid = $_POST["cid"];
$sid = $_POST["sid"];
$bid = $_POST["bid"];
$ayid = $_POST["ayid"];
$did = $_POST["did1"];
$subject = $_POST["subject"];
/*if ($_POST['name'])
    echo $cosmo;*/
	$positions="p".$pposition;
		$stclass=0;
		$stclass1=0;
		$subject1=mysql_query("SELECT * FROM subject WHERE sub_id=$cosmo"); 
		$subjects=mysql_fetch_array($subject1);
		if($subjects){
			$sfid=$subjects['st_id'];
			
			$staff1=mysql_query("SELECT * FROM staff WHERE st_id=$sfid"); 
		$staffs=mysql_fetch_array($staff1);
		$staffname=$staffs['fname'];
			$stassign=mysql_query("SELECT * FROM subject WHERE st_id='$sfid' AND ay_id=$ayid"); 
			while($strow=mysql_fetch_array($stassign))
        		{
					 $subid1=$strow['sub_id'];
					 $cid1=$strow['c_id'];
					 $sid1=$strow['s_id'];
					 $bid1=$strow['b_id'];
					 $slid=$strow['sl_id'];
					$timelist1=mysql_query("SELECT * FROM timetable WHERE $positions=$subid1 AND c_id=$cid1 AND s_id=$sid1 AND d_id='$did' AND b_id=$bid1 AND ay_id=$ayid");
					$quryno = mysql_num_rows($timelist1);
					$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid1"); 
								  $section=mysql_fetch_array($sectionlist);
					if($quryno>0){
						if($cid1!=$cid && $sid1!=$sid){					
							$stclass +=$quryno;
								  $classname=$class['c_name']."-".$section['s_name'];
						}else{
							$submatch=mysql_query("select * from subjectlist where sl_id=$slid");
							$hsub=mysql_fetch_array($submatch)['s_name'];
							if($hsub==$subject){
								$stclass1++;
								$classname=$class['c_name']."-".$section['s_name'];
							} else {
								$classname=$class['c_name']."-".$section['s_name'];
								$stclass++;
							}
						}
					}
				}
		}
	if ($stclass > 0) {
		$errmsg="This Subject Staff Already have Class in ".$classname."!!!";
echo json_encode(array(
    'status' => 'error',
    'message'=> $errmsg
));
}
else
{	
if(!$staffname){
	$staffname=" ";
}
if($stclass1>0){
echo json_encode(array(
    'status' => 'success1',
    'message'=> 'This Subject Staff Already has Class, take combined class to '.$classname.' !!!'
));
}else{
echo json_encode(array(
    'status' => 'success',
    'message'=> $staffname
));
}
$timelist=mysql_query("SELECT * FROM timetable WHERE c_id=$cid AND s_id=$sid AND d_id=$did AND b_id=$bid AND ay_id=$ayid"); 
								   $timetable=mysql_fetch_array($timelist);	
		   if($timetable){
			   $tt_id=$timetable['tt_id'];			   
			   $sql=mysql_query("UPDATE timetable SET $positions='$cosmo' WHERE tt_id='$tt_id'");
		   }else{
			   $sql=mysql_query("INSERT INTO timetable (d_id,$positions,c_id,s_id,b_id,ay_id) VALUES
('$did','$cosmo','$cid','$sid','$bid','$ayid')");
		   }
		   
}								   
	
	
/*if ($cosmo == 2) {
echo json_encode(array(
    'status' => 'error',
    'message'=> 'error message'
));
}
else
{
echo json_encode(array(
    'status' => 'success',
    'message'=> 'success message'
));
}*/
	
?> 