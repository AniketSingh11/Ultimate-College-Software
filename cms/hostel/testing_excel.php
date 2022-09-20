<?php 

/** PHPExcel_IOFactory */

include("../includes/config.php");

include '../Classes/PHPExcel/IOFactory.php';
 

if($_SERVER['REQUEST_METHOD']=="POST")
{
    $category= mysql_real_escape_string($_POST["category"]);
    $floor=mysql_real_escape_string($_POST["floor"]);
    $j=1;
    if($_FILES["file$j"]["name"]==""||$_FILES["file$j"]["name"]==" "){
         
        ?>
      	<script>
      alert("Uploaded Failed!");
       
     </script>
      	<?php
      
      }else{
         
          $value = explode(".", $_FILES["file$j"]["name"]);
          $extension = strtolower(array_pop($value));   //Line 32
         
      
       
      //	$extension =  end(explode(".",$filename));
      
      	if($extension=="XLSX"||$extension=="xlsx"||$extension=="XLS"||$extension=="xls"){

$date=date("Y-m-d");

 

$fail_list=array();
$fail_reason=array();
 
      		$ban="up_files/".time().".".$extension;
      		move_uploaded_file($_FILES["file$j"]["tmp_name"],$ban);
      		$file=$ban;


//$category=mysql_real_escape_string($_POST["category"]);
//$floor=mysql_real_escape_string($_POST["floor"]);
 
//$file = "up_files/1416816513.xlsx";
 
//Open the file
$objReader = PHPExcel_IOFactory::createReaderForFile($file);
$objReader->setReadDataOnly(true);
$PHPExcelObject = $objReader->load($file);
 
$sheetCount = $PHPExcelObject->getSheetCount();
 
$PHPExcelObject->setActiveSheetIndex(0);
 
$date_regex = '/^(0[1-9]|1[012])[\/\/.](0[1-9]|[12][0-9]|3[01])[\/\/.](19|20)\d\d$/';
 
 
$hiredate = '12/14/2014';
 
if (!preg_match($date_regex, $hiredate)) {
   // echo '<br>Your hire date entry does not match the YYYY-MM-DD required format.<br>';
}else{

    //echo "fsdsd";
}
 
// put this at beginning of your script
$saveTimeZone = date_default_timezone_get();
date_default_timezone_set('UTC'); // PHP's date function uses this value!
 
$highestRow=$PHPExcelObject->getActiveSheet()->getHighestRow();
 
for ($i=2;$i<=$highestRow;$i++) {


    $array_name1=$PHPExcelObject->getActiveSheet()->getCell('B'.$i)->getValue();
    $array_name2=$PHPExcelObject->getActiveSheet()->getCell('C'.$i)->getValue();
    $array_name3=$PHPExcelObject->getActiveSheet()->getCell('D'.$i)->getValue();

    $array_name1=str_replace("'","",$array_name1);
    $array_name2=str_replace("'","",$array_name2);
    $array_name3=str_replace("'","",$array_name3);

    $array_name1=addslashes($array_name1);
    $array_name2=addslashes($array_name2);
    $array_name3=addslashes($array_name3);
   


    $query="select * from hms_room  where category='$category' and room_number='$array_name1' and status='0'";
    $res=mysql_query($query) or die (mysql_error());
    $chk_room=0;
    $err_msg="";
    while($row=mysql_fetch_array($res))
    {
        $err_msg="Room Name already Given &nbsp; ";
        $chk_room=1;
        array_push($fail_list,$array_name1);
        array_push($fail_reason,$err_msg);
    }
    
//echo $array_name1."-".$array_name2."<br>";
  /*  if ($array_name1!="" && $array_name2!="" && $chk_room==0)
    {

        $bedcart=explode(",",$array_name2);
         $num_bed=count($bedcart);
          $query="insert into hms_room(category,floor,room_number,room_name,no_cart,date)
     	      values('$category','$floor','$array_name1','','$num_bed','$date')";
     	      $result=mysql_query($query);
     	       
     	      $last_id=mysql_insert_id();
     	      
     	  for($r=0;$r<$num_bed;$r++)
	    {
	    $c_value=$bedcart[$r];
	    $query="insert into hms_room_cart(category,floor,hr_id,cart_name,date)
	    
	                values('$category','$floor','$last_id','$c_value','$date')";
	    $result=mysql_query($query);
	    }
     	  
    } */
}

}// extension
date_default_timezone_set($saveTimeZone);
?>
       
      	 	<?php
      	
      }//file type
     
     
     
 }

