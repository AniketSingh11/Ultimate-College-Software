<?php 
include("../includes/config.php");

$student_id=$_POST["stid"];
$ay_id=$_POST["ay_id"];
$b_id=$_POST["bid"];



//$query=mysql_query("SELECT lms_book.b_id,lms_student_borrowbook.book_id from `lms_book` join `lms_student_borrowbook` on lms_book.b_id=lms_student_borrowbook.book_id where lms_student_borrowbook.status='0' and lms_book.avilable_qty where ay_id='$ay_id' and b_id='$b_id'  and student_id='$student_id'");

?>	 
 <?php							
                            	
$query="select *  from lms_book where avilable_qty!='0' and status='0' and specimen='0' order by book_title asc";
$res=mysql_query($query) or die(mysql_error());
while($row=mysql_fetch_array($res))
{
    $book_id=$row["b_id"];
   
    $query1="select  * from `lms_student_borrowbook` where book_id='$book_id' and ay_id='$ay_id' and b_id='$b_id'  and student_id='$student_id' and status='0' limit 1";
    $res1=mysql_query($query1) or die(mysql_error());
    $c=0;
     while($row1=mysql_fetch_array($res1))
     {
    $c=1;     
         
     }
    
    
    if($c=="0")
    {
        ?><option value="<?=$book_id?>"><?php echo $row["book_title"];?></option>
                        <?php 
       
    }else{
        
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
?>
 
