<? ob_start(); ?>
    <?php
	//include("../includes/config.php");
	
	include("header_top.php");
	
        //$brdid = $_SESSION['brdid'];
	$keyword = $_POST['keyword'];
	
	$classid = $_POST['classid'];
	$sectid = $_POST['sectid'];
	
	if($classid!=""){
		
		if($classid!="" && $sectid!=0){
		 $sql = "SELECT *,student.c_id AS classid, student.s_id AS secid, student.b_id AS boardid FROM student 
		left join board on (board.b_id=student.b_id) left join class on (class.c_id = student.c_id) 
		left join section on (section.s_id=student.s_id) WHERE user_status='1' AND student.c_id=$classid AND student.s_id=$sectid AND student.b_id =$brdid 
		AND student.ay_id=$acyear AND (admission_number like '%".$keyword."%' OR firstname like '%".$keyword."%')";
	
		$sql_res = mysql_query($sql) or die("Could not fetch data into DB: " . mysql_error());
		}else{
		
		 $sql = "SELECT *,student.c_id AS classid, student.s_id AS secid, student.b_id AS boardid FROM student 
		left join board on (board.b_id=student.b_id) left join class on (class.c_id = student.c_id) 
		left join section on (section.s_id=student.s_id) WHERE user_status='1' AND student.c_id=$classid AND student.b_id =$brdid 
		AND student.ay_id=$acyear AND (admission_number like '%".$keyword."%' OR firstname like '%".$keyword."%')";
	
		$sql_res = mysql_query($sql) or die("Could not fetch data into DB: " . mysql_error());
		}
	}else {
	
 	 	 $sql = "SELECT *,student.c_id AS classid, student.s_id AS secid, student.b_id AS boardid FROM student 
		left join board on (board.b_id=student.b_id) left join class on (class.c_id = student.c_id) 
		left join section on (section.s_id=student.s_id) WHERE user_status='1' AND student.b_id =$brdid 
		AND student.ay_id=$acyear AND (admission_number like '%".$keyword."%' OR firstname like '%".$keyword."%') ";
	
		$sql_res = mysql_query($sql) or die("Could not fetch data into DB: " . mysql_error());
		
	}
echo '<ul id="student-list">';
while ($thisrow = mysql_fetch_array($sql_res)){
		
//echo "$thisrow[admission_number]-$thisrow[firstname]";
$studdetail = $thisrow['admission_number']." - ".$thisrow['firstname']." - "
.$thisrow['c_name']." - ".$thisrow['s_name'];

$stud_all_id = $thisrow['ss_id']."-".$thisrow['boardid']."-".$thisrow['classid']."-".$thisrow['secid'];
echo "
<li onClick=\"selectStudent('".$studdetail."','".$stud_all_id."');\">".$studdetail."</li>


";
}
echo "</ul>";
?>  
<style>
#student-list {
    float: left;
    list-style: none;
    margin: 0;
    padding: 0;
    width: 18%;
    position: absolute;
    z-index: 1;
}
#student-list li{
    padding: 10px;
    background: #FAFAFA;
    border-bottom: #F0F0F0 1px solid;
    list-style-type: none;
	margin-bottom: 0;
}
</style> 
<? ob_flush(); ?>
