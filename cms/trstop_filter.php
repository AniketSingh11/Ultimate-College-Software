<?php
include("head_top.php");   
if( (isset ($_GET['value']) && $_GET['value']!='') && (isset ($_GET['rid']) && $_GET['rid']!=''))
{
	 $value=$_GET['value'];
	 $rid=$_GET['rid'];
	
	if($value=='2')
	$qrys="SELECT * FROM trstopping WHERE r_id!=$rid";
	else if($value=='1')
	$qrys="SELECT * FROM trstopping WHERE r_id=0";
	
	$qry=mysql_query($qrys);
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ $rid1=$row['r_id'];
				
                    	echo '<li class="sortable-item flipInY animated" id="'.$row['stop_id'].'"';
						if($rid1){
							echo 'style="background-color:#FC6467;"';
							} echo '><img src="img/icons/packs/fugue/24x24/marker.png">'.$row['stop_name'].'</li>';
				}
}