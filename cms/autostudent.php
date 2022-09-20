<?php 
include ("includes/config.php");

$sacyear=$_SESSION['acyear'];

if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

$queryString=addslashes(trim($_POST['queryString']));
 
 ?>  <ul> <?php
$query="select * from student where (admission_number LIKE '$queryString%' or  firstname LIKE '$queryString%') AND ay_id=$acyear LIMIT 10";
$res=mysql_query($query);
while($row=mysql_fetch_array($res))
{
    
    $sec=mysql_fetch_array(mysql_query("select * from section where s_id='$row[s_id]'"));
    $section_name=$sec["s_name"];
    
    $sec=mysql_fetch_array(mysql_query("select * from class where c_id='$row[c_id]'"));
    $class_name=$sec["c_name"];
    $stand_name=$class_name."-".$section_name;
    
    $admission_number=stripslashes($row["admission_number"]);
    $student_name=stripslashes($row["firstname"])." ".stripslashes($row["lastname"]);
    $parent_name=stripslashes($row["fathersname"])." / ".stripslashes($row["m_name"]);
    $dob=stripslashes($row["dob"]);
    $caste=stripslashes($row["caste"]);
	$gender=stripslashes($row["gender"]);
	$city=stripslashes($row["city_id"]);
    $year_duration=$acyear_name;
    
    
    $present=0;$absent=0;$absentoff=0;$workday=0;
    $select_record2=mysql_query("SELECT * FROM attendance WHERE c_id='$row[c_id]' AND s_id='$row[s_id]' AND ay_id=$acyear AND ss_id='$row[ss_id]' ORDER BY day");
    while($monthday=mysql_fetch_array($select_record2))
    {
        $result=$monthday['result'];
        if($result=='1'){
            $present++;
        }
        if($result=='0'){
            $absent++;
        }
        if($result=='off'){
            $absentoff++;
        }
        	
        $workday++;
    }
    	
    $op=$absentoff*.5;
    if($workday){
        $persent=round((($present+$op)/$workday)*100,2);
    }
    
    
    ?>
  
      <li onClick='fill("<?=$admission_number?>","<?=$student_name?>","<?=$parent_name?>","<?=$stand_name?>","<?=$year_duration?>","<?=$dob?>","<?=$caste?>","<?=$gender?>","<?=$city?>","<?=$persent?>","<?=$workday?>")'><?php echo $admission_number." ".$student_name; ?></li> 
  	<?php
	         		}
				 

?></ul>