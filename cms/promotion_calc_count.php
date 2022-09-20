<?php
function thefunction($number){
  if ($number < 0)
    return 0;
  return $number; 
}

include("includes/config.php"); 
if((isset ($_GET['value']) && $_GET['value']!='') && (isset ($_GET['bid']) && $_GET['bid']!='') && (isset ($_GET['ayid']) && $_GET['ayid']!='') )
{
	  
      $b_id=$_GET['bid'];
	  $acyear=$_GET['ayid'];
	  $sections=$_GET['section'];
	  
	  $section = join(',',$sections); 
	 
	  $standard=$_GET['value'];
	  echo "<div id='msc1'></div>";
	  $qry=mysql_query("SELECT * FROM `year` where ay_id > '$acyear'  order by ay_id asc");
	  $res=mysql_fetch_array($qry);
	  $new_ayid=$res["ay_id"];
	  
	  $pro=array();
	  $query = mysql_query("SELECT * FROM student WHERE s_id IN ($section) and  (ay_id='$acyear' AND  b_id='$b_id' AND c_id='$standard') AND  user_status='1'  ORDER BY ss_id ASC");
	   while ($row = mysql_fetch_assoc($query)) 
    { 
	$cid1=$row['c_id'];
	$s_id1=$row['s_id'];
	$admission_number=$row['admission_number'];
	
	$user_status=$row['user_status'];
	$check=0;
	if($user_status==0){
	     
	    if($row['reason_leaving']!="" || $row['std_leaving']!="" ||$row['no_date_tran']!=""|| $row['dol']!="")
	    {
	        $check=1;
	
	    }
	     
	}
	
	$query1=mysql_query("select * from student where admission_number='$admission_number' and ay_id='$new_ayid'");
	
	 if(mysql_num_rows($query1)=="0"  && $check==0){
	
	
	$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $class=mysql_fetch_array($classlist);
								  
								  $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$s_id1");
								  $sect=mysql_fetch_array($sectionlist);
								  
								  array_push($pro,$row['ss_id']);
                                  	   }
                                   }
								   
}

 ?>                            <div class="_25">
							     <p>
								<label for="select">Shuffle Number Student :<span class="error">*</span></label>
								<input type="text" name="shuffle" min="1" max="<?=count($pro)?>"   class='required digits'>
								</p>
								</div>
								<textarea name="std" style="display: none;"><?php $numItems = count($pro);
$i = 0; foreach ($pro as $std_id){ echo $std_id; if(++$i === $numItems) {}else{ echo ",";}}; 
 ?></textarea>
 <script type="text/javascript">
$().ready(function() {	

	 $("#msc1").html("Total number of Students <?=count($pro)?>");
});
</script>