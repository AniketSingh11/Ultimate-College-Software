<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("head_top.php"); 
 
$qry=mysql_query("SELECT * FROM student");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$ssid=$row['ss_id'];
					$date=$row['dob'];
					$date_split1= explode('/', $date);
		 
					 $date_month=$date_split1[1];
					 $date_day=$date_split1[0];
					 $date_year=$date_split1[2];
					 
					 $sql="UPDATE student SET day='$date_day',month='$date_month',year='$date_year' WHERE ss_id='$ssid'";
					
					$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
					
					
				}
				
?>