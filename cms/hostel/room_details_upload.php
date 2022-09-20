 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {

  include '../Classes/PHPExcel/IOFactory.php';
 
 
    $category= mysql_real_escape_string($_POST["category"]);
    $floor=mysql_real_escape_string($_POST["floor"]);
  //  $r_type=mysql_real_escape_string($_POST["r_type"]);
    
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
        $err_msg.="Room Name already Given &nbsp; ";
        $chk_room=1;
      
    }
    
    
    
    $query="select * from hms_room_type  where room_type='$array_name3'  and status='0'";
    $res=mysql_query($query) or die (mysql_error());
    $chk_roomtype=1;
    
    while($row=mysql_fetch_array($res))
    {
        
        $chk_roomtype=0;
       
    }
    if($chk_roomtype==1){
        $err_msg.="Room Type No available &nbsp; ";
    }
    
    
    
    if($err_msg!=""){
        
        array_push($fail_list,$array_name1);
        array_push($fail_reason,$err_msg);
    }
    
    
//echo $array_name1."-".$array_name2."<br>";
    if ($array_name1!="" && $array_name2!="" && $chk_room==0 && $chk_roomtype==0)
    {

        $bedcart=explode(",",$array_name2);
         $num_bed=count($bedcart);
          $query="insert into hms_room(category,floor,room_number,room_name,room_type,no_cart,available_qty,date)
     	      values('$category','$floor','$array_name1','','$array_name3','$num_bed','$num_bed','$date')";
     	      $result=mysql_query($query);
     	       
     	      $last_id=mysql_insert_id();
     	      
     	  for($r=0;$r<$num_bed;$r++)
	    {
	    $c_value=$bedcart[$r];
	    $query="insert into hms_room_cart(category,floor,hr_id,cart_name,date)
	    
	                values('$category','$floor','$last_id','$c_value','$date')";
	    $result=mysql_query($query);
	    }
     	  
    } 
}

}// extension
date_default_timezone_set($saveTimeZone);
?>
       
      	 	<?php
      	
      }//file type
     

  }
   ?>
  </head>
 <body>
 <div id="wrapper">
	   <?php 
	   include("includes/head_logo.php");
	   
	   include("includes/top_nav.php");
	   
	   include("sidebar.php");
	   
	   $cart=array('','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	 
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1>Add  Room Details in Excel  <a href="room_details_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
  
 
 <?php if($_SERVER["REQUEST_METHOD"]=="POST") { ?>
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong> Your Record Successfully Inserted 
			</div>	
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
					Add Room  Details in Excel
					 </h3>	
					 <a href="sample_file/upload_hostelroom_details.xlsx" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="../img/icons/packs/fugue/16x16/inbox-download.png"> Download Sample File</button></a>
					 
					</div>  <!-- /.portlet-header -->	
					 <?php  if($_SERVER['REQUEST_METHOD']=="POST" &&  count($fail_list)<0 ){?>
            	 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Done!</strong> Your Record Successfully Inserted 
			</div>
					 	<?php }?>	
                   
                                         
                       <?php  if($_SERVER['REQUEST_METHOD']=="POST" &&  count($fail_list)>0 ){?>
                        <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Failed!!
			</div>
                         <table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Room Number</center></th>
                                   
                                    <th>Failed Reason</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
                            $f=1;
							 foreach ($fail_list as $value) {
							  
        		 ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $f; ?></center></td>
								<td><center><?php echo $value; ?></center></td>
                                <td><center><font color="red"><?php echo $fail_reason[$f-1];  ?></font></center></td>
                                
								</tr> 
                                         <?php  $f++; }?>                    																
							</tbody>
						</table>
                         <?php }?>
                         
                           
				 		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
     <p class="title">Room Details in Excel :</p>       
 
<div class="col-sm-6">

                            <div class="form-group">	
									<label for="validateSelect">Hostel Name<font color="red">*</font></label>
									<select name="category" class="form-control" onchange="sel_floor(this.value)" data-required="true">
									<option value="" <?php if($_POST["category"]==""){?>selected="selected" <?php }?>>Please Select</option> <?php 
									$res=mysql_query("select * from hms_category where status='0'");
									while($row=mysql_fetch_array($res))
									{
									
									?>
										 
										<option value="<?=stripslashes($row["h_id"]);?>" <?php if($_POST["category"]==$row["h_id"]){?>selected="selected" <?php }?> ><?=stripslashes($row["h_name"]);?></option>
									 <?php }?>
									</select>
								</div>
				            	<div class="form-group">
									<label for="validateSelect">Attach Excel File<font color="red">*(.xls .xlsx)</font></label>
									<input type="file" id="file1" name="file1"    class="form-control" data-required="true">
								</div>
                              
                                
</div>
<div class="col-sm-6">
								 <div class="form-group">	
									<label for="validateSelect">Hostel Floor Name<font color="red">*</font></label>
									<select id="floor" name="floor" class="form-control" data-required="true">
									<option value="" <?php if($_POST["floor"]==""){?>selected="selected" <?php }?>>Please Select Floor</option> <?php 
									$res=mysql_query("select * from hms_floor where status='0'");
									while($row=mysql_fetch_array($res))
									{
									
									?>
										 
										<option  data_value='<?=stripslashes($row["category"]);?>' style='display: none;' value="<?=stripslashes($row["hf_id"]);?>" <?php if($_POST["floor"]==$row["hf_id"]){?>selected="selected" <?php }?> ><?=stripslashes($row["floor_name"]);?></option>
									 <?php } ?>
									</select>
								</div>
								
							<!-- 	<div class="form-group">	
									<label for="validateSelect">Room Type<font color="red">*</font></label>
									<select name="r_type"  class="form-control"  data-required="true">
									<option value=''>Select</option>
									<option value='NON A/C Room'>NON A/C Room</option>
									<option value='A/C Room'>A/C Room</option>
									
									</select>
                              </div> -->
                                
</div>
  			 </div>  <!-- /.portlet-content -->
             <div class="portlet-content">
     
     
 
<div class="clear"></div>
                    <div class="col-sm-12">
                    <center>
<div class="form-group">
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
                                </div>

     </div>
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php
 
 include("footer.php");
 
 ?>
 <?php include("includes/script.php");?>
 <script>
function sel_floor(n)
{
	$("#floor option[data_value]").hide();
 $("#floor option[data_value="+n+"]").show();
 $("#floor").prop('selectedIndex',0);
}

function sel_cart(n)
{
	$(".show_cart").hide();
	for (i = 1; i <= n; i++) { 

		
		$("#show_cart"+i).show();
		
	}
}

 </script>
 
</body>
</html>

 <? ob_flush(); ?>