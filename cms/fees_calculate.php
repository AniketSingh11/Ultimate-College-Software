<?php
include("head_top.php");   
if( (isset ($_GET['value']) && $_GET['value']!='') && (isset ($_GET['cid']) && $_GET['cid']!='') && (isset ($_GET['bid']) && $_GET['bid']!=''))
{
	$value=$_GET['value'];
	$cid=$_GET['cid'];
	$bid=$_GET['bid'];
	$sid=$_GET['sid'];
	
	/*$qry=mysql_query("SELECT * FROM frate WHERE fg_id=$value AND ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid");							
	$row=mysql_fetch_array($qry);	
	if($row){
		echo '<div class="alert error"><span class="hide">x</span>This fees rate already generated !!!</div>';
	}else{*/
		
		if($value=='1'){
	echo '<table class="table">
                  	<thead>
                    	<th><center>Group Name</center></th>';
                        	$qry1=mysql_query("SELECT fg_name FROM fgroup LIMIT 0,3");							
			  while($row1=mysql_fetch_array($qry1))
        		{ 
                     echo '<th><center>'.$row1['fg_name'].'</center></th>';
                }
                   echo '</thead>';
                   echo '<tbody>';
						$qry2=mysql_query("SELECT * FROM fgroup_detail where fg_id!=4 AND otherfees='0'");													
									  while($row2=mysql_fetch_array($qry2))
										{
											$fgdid=$row2['fgd_id'];
											$type=$row2['type'];
											$ftype="";
											if($type){
												$ftype=" (New Student)";
											}
                    	echo '<tr>
                        <td>'.$row2['name'].$ftype.'</td>';                       
					$select_record=mysql_query("SELECT * FROM fgroup LIMIT 0,3");
					$count=1;
					while($student12=mysql_fetch_array($select_record))
					{ 
						$ffg_id=$student12['fg_id'];	
						$fratelist=mysql_query("SELECT rate,rate1 FROM frate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid AND fg_id=$ffg_id AND fgd_id=$fgdid");
						$frate=mysql_fetch_array($fratelist);				
                        echo '<td><center><input id="textfield'.$fgdid."-".$ffg_id.'" name="fdisname'.$fgdid."-".$ffg_id.'" data-type="number" type="text" value="'.$frate['rate'].'" /></center></td>';
                       $count++; }
                        echo '</tr>';
						}                                          
                    echo '</tbody>
                  </table>';
		}else if($value=='2'){
			
			echo '<table class="table">
                  	<thead>
                    	<th><center>Group Name</center></th>
                        <th><center>Amount</center></th>';
                   echo '</thead>
                    <tbody>';
						$qry2=mysql_query("SELECT * FROM fgroup_detail where fg_id=4 AND otherfees='0'");													
									  while($row2=mysql_fetch_array($qry2))
										{
											$fgdid=$row2['fgd_id'];
											$type=$row2['type'];
											$ftype="";
											if($type){
												$ftype=" (New Student)";
											}
											$fratelist=mysql_query("SELECT rate,rate1 FROM frate WHERE ay_id=$acyear AND b_id=$bid AND c_id=$cid AND s_id=$sid AND fg_id=4 AND fgd_id=$fgdid");
						$frate=mysql_fetch_array($fratelist);
                    	echo '<tr>
                        <td>'.$row2['name'].$ftype.'</td>';                       
						echo '<td><center><input id="textfield'.$fgdid.'" name="fdisname'.$fgdid.'" data-type="number" type="text" value="'.$frate['rate'].'" /></center></td>';
                       $count++;
                        echo '</tr>';
						}                                          
                    echo '</tbody>
                  </table>';
		}
	}
//}