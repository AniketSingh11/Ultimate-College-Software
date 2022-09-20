<?php 
include("../includes/config.php");

//$student_id=$_POST["stid"];
 

$cid=$_POST["cid"];
$rid=$_POST["rid"];


//$query=mysql_query("SELECT lms_book.b_id,lms_student_borrowbook.book_id from `lms_book` join `lms_student_borrowbook` on lms_book.b_id=lms_student_borrowbook.book_id where lms_student_borrowbook.status='0' and lms_book.avilable_qty where ay_id='$ay_id' and b_id='$b_id'  and student_id='$student_id'");

?>	  
 <?php			
 if(!$cid){
     $emp_query="select * from hms_room_cart where hr_id='$rid' and  room_status='0' and status='0' order by cart_name asc";
     
 }else{
     
$emp_query="select * from hms_room_cart where category='$cid' and hr_id='$rid' and  room_status='0' and status='0' order by cart_name asc";

 }
 

										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											 
											$hrc_id=stripslashes($emp_display["hrc_id"]);
											$cart_name=stripslashes($emp_display["cart_name"]);
											
											
											?>
                                        <option value="<?php echo $hrc_id;?>"><?php echo $cart_name; ?></option>
                                  <?php } ?>								
    
 
 
 
