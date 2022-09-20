<?php
include("head_top.php");   
if( (isset ($_GET['value']) && $_GET['value']!='') && (isset ($_GET['cid']) && $_GET['cid']!='') && (isset ($_GET['bid']) && $_GET['bid']!=''))
{
	$value=$_GET['value'];
	
					$classes=explode("-",$value);  
					//print_r($classes);
					 $value=$classes[0];  
					 $type=$classes[1];  
					
	$cid=$_GET['cid'];
	$bid=$_GET['bid'];
	$sid=$_GET['sid'];
	$rate=$_GET['rate'];
	
	
	if($type=="other"){
		
		$classlist=mysql_query("SELECT * FROM mfgroup_detail WHERE fgd_id=$value"); 
								  $class=mysql_fetch_array($classlist);	
								  $name=$class['name'];
								  
		
		//echo "other Fees";
		$qry=mysql_query("SELECT * FROM mfrate WHERE fg_id='0' AND fgd_id=$value AND ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid AND rate='$rate'");							
	$row=mysql_fetch_array($qry);	
	if($row){
		echo '<div class="alert error"><span class="hide">x</span>This fees rate already generated !!!</div><input type="hidden" name="fgdid" value="'.$value.'" />';
		
	}else{
	echo '<table class="table">
                  	<thead>
                    	<th><center>Group Name</center></th>';
                        	$qry1=mysql_query("SELECT * FROM fdiscount");							
			  while($row1=mysql_fetch_array($qry1))
        		{ 
                     echo '<th>'.$row1['fdis_name'].'</th>';
                  }
                   echo '</thead>
                    </thead>
                    <tbody>';
                    	echo '<tr>
                        <td>'.$name.'</td>';                       
					$select_record=mysql_query("SELECT * FROM fdiscount");
					$count=1;
					while($student12=mysql_fetch_array($select_record))
					{ 
					$fdis_id=$student12['fdis_id'];					
                        echo '<td><center><input id="fdisname'.$count.'" name="fdisname'.$count.'" data-type="number" type="text" value="" class="required" /></center></td>';
                       $count++;                        
						}   
						echo '</tr>';                                       
                    echo '</tbody>
                  </table><input type="hidden" name="fgdid" value="'.$value.'" />';
	}
	
	
	}else{
		
		$classlist=mysql_query("SELECT * FROM mfgroup WHERE fg_id=$value"); 
								  $class=mysql_fetch_array($classlist);	
								  $name=$class['fg_name'];
		//echo "SELECT * FROM mfrate WHERE fg_id=$value AND ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid AND rate='$rate'";
	
	$qry=mysql_query("SELECT * FROM mfrate WHERE fg_id=$value AND ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid AND rate='$rate'");							
	$row=mysql_fetch_array($qry);	
	if($row){
		echo '<div class="alert error"><span class="hide">x</span>This fees rate already generated !!!</div><input type="hidden" name="fgid" value="'.$value.'" />';
	}else{
	echo '<table class="table">
                  	<thead>
                    	<th><center>Group Name</center></th>';
                        	$qry1=mysql_query("SELECT * FROM fdiscount");							
			  while($row1=mysql_fetch_array($qry1))
        		{ 
                     echo '<th>'.$row1['fdis_name'].'</th>';
                  }
                   echo '</thead>
                    </thead>
                    <tbody>';
                    	echo '<tr>
                        <td>'.$name.'</td>';                       
					$select_record=mysql_query("SELECT * FROM fdiscount");
					$count=1;
					while($student12=mysql_fetch_array($select_record))
					{ 
					$fdis_id=$student12['fdis_id'];					
                        echo '<td><center><input id="fdisname'.$count.'" name="fdisname'.$count.'" data-type="number" type="text" value="" class="required" /></center></td>';
                       $count++;                        
						}   
						echo '</tr>';                                       
                    echo '</tbody>
                  </table><input type="hidden" name="fgid" value="'.$value.'" />';
	}
	}
}