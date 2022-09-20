<?php
 

include("includes/config.php"); 
 
	 
	  $sections=array("1","2","3","4","5");
	  
	  $section = join(',',$sections); 
	 
	  $standard=$_GET['value'];
	  
	  $pro=array();
	  $query = mysql_query("SELECT * FROM student WHERE ss_id IN ($section)  ORDER BY ss_id ASC");
 
                               while ($row = mysql_fetch_assoc($query)) 
    { 
	$cid1=$row['c_id'];
	$s_id1=$row['s_id'];
	$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $class=mysql_fetch_array($classlist);
								  
								  $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$s_id1");
								  $sect=mysql_fetch_array($sectionlist);
								  
								  array_push($pro,$row['ss_id']);
                                  echo '<option value="'.$row['ss_id'].'">'.$row['admission_number']." - ".$row['firstname']." ".$row['lastname']." - ".$class['c_name']." - ".$sect['s_name'].'</option>';
								   }
 


 
?>
 