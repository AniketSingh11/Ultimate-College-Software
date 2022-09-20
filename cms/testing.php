<?php 

include("includes/config.php");

 



/* $qry=mysql_query("select * from  book where type='B' and ay_id='2'");
 while($row=mysql_fetch_row($qry))
 {

     echo $row[0]."-".$row[1]."-".$row[2]."-".$row[3]."-".$row[4]."-".$row[5]."-".$row[6]."-".$row[7]."-".$row[8]."-".$row[9]."-".$row[10]."-".$row[11]."-".$row[12]."-".$row[13]."-".$row[14]."-".$row[15]."<br>";
     
$sql = "INSERT INTO book (b_name,b_qtysold,b_qtyleft,b_price,m_price,p_date,category,c_id,s_id,a_id,n_id,type,brdid,ay_id,qty)
    values('$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]','$row[9]','$row[10]','$row[11]','$row[12]','$row[13]','$row[14]','$row[15]')";
    $result1 = mysql_query($sql);
}
*/
$qry="SELECT  ss_id,dob,day,month,year FROM `student` WHERE  dob LIKE '%-%'";
 
 
$qry1=mysql_query($qry);

while($row=mysql_fetch_array($qry1))
{
    $dob=$row["dob"];
    $day=$row["day"];
    $month=$row["month"];
    $year=$row["year"];
    
    $date_split1= explode('-', $dob);
    $date_month=$date_split1[1];
    $date_day=$date_split1[0];
    $date_year=$date_split1[2];
    
    $orginal_date=$date_day."/".$date_month."/".$date_year;
    
    $ss_id=$row["ss_id"];
    
    echo $orginal_date."<br>";
    
  //echo   $dob."-".$date_day."-".$date_month."-".$date_year."<br>";
  
     // echo $orginal_date."-".$ss_id."<br>";
   //  echo $date_day."/".$date_month."/".$date_year."<br>";
    $update_sb=mysql_query("update student set dob='$orginal_date',day='$date_day',month='$date_month',year='$date_year'  where ss_id='$ss_id'");
  
}
 //
 
 

/*
for($i=0;$i<count($sibling1);$i++)
{
    $ss_id=$sibling1[$i];
    
      $result=mysql_query("SELECT * FROM student where ss_id='$ss_id'");
      $res1=mysql_fetch_array($result);
      $c_id=$res1['c_id'];
      $s_id=$res1['s_id'];
      $b_id=$res1['b_id'];
      $ay_id=$res1['ay_id'];
      $admin_no=$res1['admission_number'];
      $p_id=$res1['p_id'];
      
      
      
       
      
       $sql = "INSERT INTO sibling (p_id,ss_id,c_id,s_id,b_id,ay_id,admin_no)
      values('$p_id','$ss_id','$c_id','$s_id','$b_id','$ay_id','$admin_no')";
       $result1 = mysql_query($sql);
      
      $update_sb=mysql_query("update parent set sibling='1' where p_id='$p_id'");
}


$sibling2=array('402','287','225','242','240','232','236','243','231','218','398','373','298','318','404','420','419','319','224','354','381','222','237','401','233','423');


for($i=0;$i<count($sibling2);$i++)
{
    
    $ss_id=$sibling2[$i];

    $result=mysql_query("SELECT * FROM student where ss_id='$ss_id'");
    $res1=mysql_fetch_array($result);
    $c_id=$res1['c_id'];
    $s_id=$res1['s_id'];
    $b_id=$res1['b_id'];
    $ay_id=$res1['ay_id'];
    $admin_no=$res1['admission_number'];
    $p_id=$res1['p_id'];



     

    $sql = "INSERT INTO sibling (p_id,ss_id,c_id,s_id,b_id,ay_id,admin_no)
    values('$p_id','$ss_id','$c_id','$s_id','$b_id','$ay_id','$admin_no')";
    $result1 = mysql_query($sql);

    $del_pa=mysql_query("delete from parent  where p_id='$p_id'");
    
}


*/

//echo count($sibling2);
?>