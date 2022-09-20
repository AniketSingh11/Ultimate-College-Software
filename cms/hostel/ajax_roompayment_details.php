<?php 
include("../includes/config.php");

//$student_id=$_POST["stid"];

$rid=$_REQUEST["rid"];
$hsr_id=$_REQUEST["hsr_id"];

$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];

$syear=$ay['s_year'];
$eyear=$ay['e_year'];

$date=date("Y-m-d");

$emp_display=mysql_fetch_array(mysql_query("select * from hms_student_room where hsr_id='$hsr_id'"));
$room_id=$emp_display["hr_id"];
$cart_id=$emp_display["hrc_id"];
$room_date=$emp_display["room_date"];
$student_number=$emp_display["admission_number"]; 

$res=mysql_query("select * from student where admission_number='$student_number' order by ay_id desc");
$row1=mysql_fetch_array($res);
$class_id=$row1["c_id"];

$res=mysql_query("select * from hms_room where hr_id='$room_id'");
$row=mysql_fetch_array($res);
$room_type=$row["room_type"];

$qry1=mysql_query("select * from hms_hinvoice where hsr_id='$hsr_id' and ay_id='$acyear'");

if(mysql_num_rows($qry1)!=0)
{
 
$res=mysql_query("select * from hms_hinvoice_sumarry where 	hsr_id='$hsr_id' and hr_id='$room_id' and hrc_id='$cart_id' and ay_id='$acyear'");
$row=mysql_fetch_array($res);
$amount=$row["amount"];
$fees_type=$row["fees_type"];
 


          if($amount=="")
			    {
			        $fees_type="Given Amount";
			     $qry1=mysql_query("select * from  hms_studentcash_amount where hsr_id='$hsr_id'");  
			     $row=mysql_fetch_array($qry1);
			     $amount=$row["given_amount"];
			    }

			     
			    
			    
			   if($amount!="")
			    {
			    
			    $from_date=$room_date;
			    if($fees_type=="Changeroom Fees" ||$fees_type=="Given Amount")
			    {
			        $startTimeStamp = strtotime($from_date);
			        $to_date=$eyear."-05-31";
			        $endTimeStamp = strtotime($to_date);
			         
			        $timeDiff = abs($endTimeStamp - $startTimeStamp);
			         
			        $numberDays1 = $timeDiff/86400;  // 86400 seconds in one day
			         
			        // and you might want to convert to integer
			        $numberDays1 = intval($numberDays1);
			        
			        $endTimeStamp1=strtotime($date);
			        $timeDiff1 = abs($endTimeStamp1 - $startTimeStamp);
			        
			        $numberDays = $timeDiff1/86400;  // 86400 seconds in one day
			        
			        // and you might want to convert to integer
			        $numberDays= intval($numberDays);
			        
			    
			        
			     $perday=($amount/$numberDays1);

			    
			     
			    }else{
			        
			        $startTimeStamp = strtotime($from_date);
			        $endTimeStamp = strtotime($date);
			         
			        $timeDiff = abs($endTimeStamp - $startTimeStamp);
			         
			        $numberDays = $timeDiff/86400;  // 86400 seconds in one day
			         
			        // and you might want to convert to integer
			        $numberDays = intval($numberDays);
			        
			    $perday=($amount/365);
			     
			    }
			    
			    
			    
			    $cal_rent_old=round($amount-($perday*$numberDays));

			   // echo $cal_rent_old."Amount";
			   
			     
$res=mysql_query("select * from hms_room where hr_id='$rid'");
$row=mysql_fetch_array($res);
$selroom_type=$row["room_type"];

$res=mysql_query("select * from hms_fees_structure where section='$class_id' and ay_id='$acyear'");
$row=mysql_fetch_array($res);
$hfs_id=$row["hfs_id"];
 
$res=mysql_query("select * from hms_feestype where 	hfs_id='$hfs_id' and room_type='$selroom_type'");
$row=mysql_fetch_array($res);
$amount=$row["amount"];

 

$to_date=$eyear."-05-31";
$startTimeStamp = strtotime($date);
$endTimeStamp = strtotime($to_date);
 
$timeDiff = abs($endTimeStamp - $startTimeStamp);
 
$numberDays = $timeDiff/86400;  // 86400 seconds in one day
 
// and you might want to convert to integer
$numberDays = intval($numberDays);
 
 
$perday=($amount/365);
 
$cal_rent_new=round($perday*$numberDays);
//echo $cal_rent_new."<br>";

if($room_type==$selroom_type)
{
    
    
}else{

    $cal=$cal_rent_old-$cal_rent_new;
    
    $final_amount=abs($cal);
  if($cal < 0)
{
    echo "<label for='name' style='color:red'>Pending Pay amount :</label>&nbsp;Rs.".$final_amount;
    echo "<input type='hidden' name='c_amount' value='$final_amount'>";
    echo "<input type='hidden' name='deposit' value='0'>";
    
}else{
   
    echo "<label for='name' style='color:red'>Given Return amount :</label>&nbsp;Rs.".$final_amount;
    echo "<input type='hidden' name='c_amount' value='$final_amount'>";
    echo "<input type='hidden' name='deposit' value='1'>";
}

}

			    }

}	    
			    