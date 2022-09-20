<?php 
include("../includes/config.php");

$bidgroup=explode(",",$_REQUEST["bid"]);

 

foreach($bidgroup as $bid)
{
 
//$query=mysql_query("SELECT lms_book.b_id,lms_student_borrowbook.book_id from `lms_book` join `lms_student_borrowbook` on lms_book.b_id=lms_student_borrowbook.book_id where lms_student_borrowbook.status='0' and lms_book.avilable_qty where ay_id='$ay_id' and b_id='$b_id'  and student_id='$student_id'");

?>	 
 <?php							
                            	
$query="select *  from lms_book where avilable_qty!='0' and status='0' and b_id='$bid' and specimen='0' order by book_title asc limit 1";
$res=mysql_query($query) or die(mysql_error());
while($row=mysql_fetch_array($res))
{
    $book_id=$row["b_id"];
   
    $query1="select  * from `lms_book_snumber` where  b_id='$book_id' and   status='0'";
    $res1=mysql_query($query1) or die(mysql_error());
    
      while($row1=mysql_fetch_array($res1))
      { 

        $qry2=mysql_query("select * from lms_student_borrowbook where  book_id='$book_id' and book_number='$row1[ibs_id]' and status='0'");
        $qry3=mysql_query("select * from lms_staff_borrowbook where  book_id='$book_id' and book_number='$row1[ibs_id]' and  status='0'");
        
        if(mysql_num_rows($qry2)==0 && mysql_num_rows($qry3)==0)
        {   
          
     ?><option value="<?=$row1["ibs_id"]?>"><?php echo $row1["ibs_id"];?></option>
 <?php 
    
     }
      }
    
}
    /*
$query="select lms_book.b_id,lms_book.book_title,lms_book.book_no from lms_book join `lms_student_borrowbook`    where lms_student_borrowbook.ay_id='$ay_id' and lms_student_borrowbook.b_id='$b_id'  and lms_student_borrowbook.student_id='$student_id' and lms_student_borrowbook.status='0'";
$res=mysql_query($query) or die(mysql_error());
while($row=mysql_fetch_array($res))
{
 echo $row["book_title"];
}
*/
}
?>
 
