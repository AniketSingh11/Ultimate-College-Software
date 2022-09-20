<?php
 // Query that retrieves events
 $sql="SELECT * FROM evenement";
 if($etype && $etype!='all'){
	 $sql .=" WHERE et_id=$etype";
 }
 $sql .=" ORDER BY id";
 //$requete = mysql_query("SELECT * FROM evenement ORDER BY id");
 $requete = mysql_query($sql);
$data='events:[';
 $count=1;
 while($row=mysql_fetch_array($requete))
        		{
					$etid=$row['et_id'];
					$eventtypes=mysql_query("SELECT * FROM event_type WHERE et_id=$etid"); 
					$row4=mysql_fetch_array($eventtypes);
							$background=$row4['et_color'];
							$border=$row4['et_border'];
							$status=$row4['status'];
					$id=$row['id'];
					$title=$row['title'];
					$start=$row['start'];
					$end=$row['end'];
					if($status==1){
						if($count>1){
						$data.=',';
					}
				 $data .='{"id": "'.$id.'","title": "'.$title.'","start": "'.$start.'","end": "'.$end.'","backgroundColor": "'.$background.'", "borderColor": "'.$border.'" }';
				 $count++;
					}
				}
	$data .='],';
 echo $data;
 
?>
