 <?php
 include("header.php");
 
  if(isset($_POST["submit"]))
  {
  
	$status=mysql_real_escape_string($_POST["status"]);
	$renewdate=mysql_real_escape_string($_POST["t_date"]);
	$status=mysql_real_escape_string($_POST["status"]);
	$cdate=mysql_real_escape_string($_POST["c_date"]);
	$r_status=mysql_real_escape_string($_POST["r_status"]);
	
	$t_amount=mysql_real_escape_string($_POST["t_amount"]);
	$c_amount=mysql_real_escape_string($_POST["c_amount"]);
    $lost_book=mysql_real_escape_string($_POST["lost_book"]);
	$id=mysql_real_escape_string($_POST["id"]);
	
	$date=date("Y-m-d"); 
	
	$to=explode("/",$renewdate);
	$renew_date=$to[2]."-".$to[1]."-".$to[0];
	
	$co=explode("/",$cdate);
	$c_date=$co[2]."-".$co[1]."-".$co[0];
	
	
	if($status!="" && $id!="")
	{
	    
	    $qty=round($qty);
	    
	   
	 if($status=="renew"){
	            
	            
	            
	            
	            
	$sql=mysql_query("INSERT INTO lms_book_renew (sb_id,renew_startdate,renew_enddate,ay_id) values('$id','$date','$renew_date','$acyear')") or die(mysql_error());
	
	$countquery=mysql_query("select count(*) as tp from lms_book_renew where sb_id='$id'");
	$rescount=mysql_fetch_array($countquery);
	$renew_count=$rescount["tp"]-1;
	
	$qry=mysql_query("update lms_student_borrowbook set renew_count='$renew_count',fine_amount='$t_amount' where sb_id='$id'");
	header("location:borrow_bookdetails_edit.php?id=$id&msg=succ");
	        }elseif ($status=="closed")
	        {
	          
	          	$res=mysql_query("select * from lms_student_borrowbook where sb_id='$id'");
	            $row=mysql_fetch_array($res);
	            $book_id=$row["book_id"];
	            $student_id=$row["student_id"];
	            $ay_id=$row["ay_id"];
	            $b_id=$row["b_id"];
	            $book_no=$row["book_number"];
	             
	            $res=mysql_query("select * from lms_book where b_id='$book_id'");
	            $row=mysql_fetch_array($res);
	            $avilable_qty=$row["avilable_qty"]+1;
	           
	            if($lost_book=="yes")
	            {
	                $qry=mysql_query("update lms_student_borrowbook set return_date='$c_date',return_bookstatus='$r_status',status='1',fine_amount='$c_amount',lost_bookstatus='1' where sb_id='$id'");
	                 
	                $qty=$row["qty"]-1;
	                $qry=mysql_query("update lms_book set  qty='$qty' where b_id='$book_id'");
                    $sql=mysql_query("INSERT INTO lms_lostbooks (book_id,person_type,type_id,closed_date,creation_date,ay_id,b_id,book_number) values('$book_id','student','$student_id','$c_date','$date','$ay_id','$b_id','$book_no')") or die(mysql_error());
                    $qry=mysql_query("update lms_book_snumber set  	status='1' where ibs_id='$book_no'");
	            }else{
	                
	                $qry=mysql_query("update lms_book set  avilable_qty='$avilable_qty' where b_id='$book_id'");
	                $qry=mysql_query("update lms_student_borrowbook set return_date='$c_date',return_bookstatus='$r_status',status='1',fine_amount='$c_amount' where sb_id='$id'");
	                 
	            }
	           
	            
	           
	            header("location:borrow_bookdetails_list.php?msg=succ");
	        }else{
	            $err_msg.="Failed!!";
	            header("location:borrow_bookdetails_edit.php?id=$id&msg=err&err_msg=$err_msg");
	        }
	}else{
	
	if($err_msg==""){
	    $err_msg.="Failed!!";}
	
	
	    header("location:borrow_bookdetails_edit.php?id=$id&msg=err&err_msg=$err_msg");
 
  }

 
 
  }
   ?>
  </head>
 <body>
 <div id="wrapper">
	   <?php 
	   include("includes/head_logo.php");
	   
	   include("includes/top_nav.php");
	   
	   include("sidebar.php");
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1> Borrow Book Details Renew (or) closed <a onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
    
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Updated 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong>  <?php echo $_GET["err_msg"];?>!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Borrow Book Details Renew (or) closed
					 </h3>			
				 </div>  <!-- /.portlet-header -->	
                 <?php
                 
                   $s_id=$_GET["id"];
				 $emp_query="select * from lms_student_borrowbook  where sb_id='$s_id' ";
				 	
				 
				 $emp_result=mysql_query($emp_query);
				 $emp_count=1;
				  $emp_display=mysql_fetch_array($emp_result);
				 
				     $board=$emp_display["b_id"];
				     $sb_id=$emp_display["sb_id"];
				     $status=$emp_display["status"];
				     $book_no=$emp_display["book_number"];
				     $query=mysql_query("SELECT * FROM board where b_id='$board'");
				     $res=mysql_fetch_array($query);
				     $board_name=$res["b_name"];
				     	
				 
				     $res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
				     $row=mysql_fetch_array($res);
				     $book_title=$row["book_title"];
				     
				     	
				     $res=mysql_query("select * from student where ss_id='$emp_display[student_id]'");
				     $row1=mysql_fetch_array($res);
				     $admission_number=$row1["admission_number"];
				     $firstname=$row1["firstname"];
				     $c_id=$row1["c_id"];
				     $section_id=$row1["s_id"];
				     	
				     	
				     
				     
				     $query=mysql_query("SELECT * FROM class where c_id='$c_id'");
				     $res=mysql_fetch_array($query);
				     $class_name=$res["c_name"];
				     	
				     $query=mysql_query("SELECT * FROM section where s_id='$section_id'");
				     $res=mysql_fetch_array($query);
				     $section_name=$res["s_name"];
				     
				     $res=mysql_query("select * from lms_book_renew where sb_id='$sb_id' order by lbr_id desc");
				     $row2=mysql_fetch_array($res);
				     $enddate=$row2["renew_enddate"];
				     $startdate=$row2["renew_startdate"];
				     
				     
				     $en=explode("-",$enddate);
				     $st=explode("-",$startdate);
				     $end_date=$en[2]."/".$en[1]."/".$en[0];
				     $start_date=$st[2]."/".$st[1]."/".$st[0];
				     
				 
				     $date=date("Y-m-d");
 
				     $now =  time();// or your date as well
				     $your_date = strtotime("$enddate");
				     $datediff = $now - $your_date;
				     $countdays=floor($datediff/(60*60*24));
				     
				    
				     
				     if($countdays >=4 && $date > $enddate){
				        
				         $countdays=$countdays-3;
				          $t_amount=$emp_display["fine_amount"]+($countdays*$f_amount);
				     }else{
				         $t_amount=$emp_display["fine_amount"];
                         } 
				     
				     $res=mysql_query("select * from lms_category where c_id='$row[category]' order by c_id desc");
				     $row3=mysql_fetch_array($res);
				     $category_name=$row3["category_name"];
?>		
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				<?php if($status=="1"){ echo "<h1 style='color:red';>Book Already Closed</h1>";}else{?>
				
				 <div class="portlet-content">
     <p class="title">Borrow  Details :</p>       
                     <div class="col-sm-6">
                                     <div class="form-group">
									<label for="name">Student :</label>
									<label for="value"> <?=$admission_number."-".$firstname?></label>
								</div>

								<div class="form-group">
									<label for="name">Section :</label>
									<label for="value"> <?=$section_name?> - <?=$class_name?></label>
								</div>
				            	<div class="form-group">
									<label for="name">Book Titles :</label>
									 <label for="value"> <?=$book_title?></label>
								</div>
                                <div class="form-group">
									<label for="name">Author Name :</label>
									 <label for="value"> <?=$row["author_name"]?></label>
								</div>
                               
                                <div class="form-group">
									<label for="name">Edition :</label>
									 <label for="value"> <?=$row["edition"]?></label>
								</div>
								
								 <div class="form-group">
									<label for="name">From Date :</label>
									 <label for="value"> <?=$start_date?></label>
								</div>
                                
                              
								
								<div class="form-group">
									<label for="name"  >Status :</label>
									<select name="status" id="status" onchange="status_report()" data-required="true"   class="required form-control">
									<option value="renew" selected="selected">Renew</option>
									<option value="closed">Closed</option>
									</select>
									 
								</div>
								
								<em id="closed_status"  style="display: none;">
								<div class="form-group">
									<label for="name">Closed Date</label>
                                    <div class="input-group date ui-datepicker1 " style="width:35%">
									<input class="form-control txt" type="text" placeholder="Closed  date" name="c_date" value="<?=date("d/m/Y")?>"  data-minlength="10"   data-maxlength="10"    id="cEnd" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-required="true"  >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>  
								<div class="form-group">
									<label for="name">Total Fine Amount:</label>
									 <input  type="text" data-required="true" data-type="digits" id="c_amount" name="c_amount" value="<?=$t_amount?>"  class="form-control" >
								</div>
								<div class="col-sm-12">
									<label  for="name">Are you lost Book?:</label>
									 <input  type="radio" data-required="true"    name="lost_book" value="no"  checked  class="form-control" >No
									 <input  type="radio" data-required="true"    name="lost_book"  value="yes"    class="form-control" >Yes
								</div>
								<div class="form-group">
									<label for="name">Return Book Status:</label>
									 <textarea  data-required="true" id="r_bookstatus" name="r_status"   class="form-control"  type="text">c</textarea>
								</div>
								</em>
								 
				            </div>                  
                       <div class="col-sm-6">
                                    <div class="form-group">
									<label for="name">Board:&nbsp;</label>
									 <label for="value"><?=$board_name?></label>
								    </div>


                                    <div class="form-group">	
									<label for="validateSelect">Book Category :</label>
									 <?php echo $category_name;?>
								</div>
                                <div class="form-group">
									<label for="name">Publisher :</label>
									 <label for="value"> <?=$row["publisher"]?></label>
								</div>
                                <!--<div class="form-group">
									<label for="name">Age</label>
									<input type="text" id="age" name="age" class="form-control" data-required="true">
								</div>-->
                                <div class="form-group">
									<label for="name">Book Number :</label>
									 <?=$book_no?> 
								</div>
							 
								  <div class="form-group">
									<label for="name">Shelf No:</label>
									 <label for="value"> <?=$row["shelf_no"]?> </label>
								</div>
								
								
								<div class="form-group">
									<label for="name" >To Date :</label>
									 <label for="value"> <font Color="red"><?=$end_date?></font></label>
								</div>
								<input type="hidden"  name="t_amount" value="<?=$t_amount?>">
								<input type="hidden"  name="id" value="<?=$s_id?>">
								
								<div class="form-group" id="renew_status">
									<label for="name">Renew Date</label>
                                    <div class="input-group date ui-datepicker1 " style="width:35%">
									<input class="form-control txt"  type="text"    placeholder="Renew  date" name="t_date"  data-minlength="10"   data-maxlength="10"   id="dpEnd" data-date-format="dd/mm/yyyy" data-date-autoclose="true"  data-required="true"  >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    
								</div>  
								
							 
								
                        </div>
  			
  			
  			<div class="clear"></div>
                    <div class="col-sm-12">
                    <center>
<div class="form-group">
								 
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
                    </div>
  			
  			
  			 </div>  <!-- /.portlet-content -->
  			 <?php }?>
              
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 ?>
 <?php include("includes/script.php");?>

</body>
</html>
<script>

 

 
function status_report()
{

	 
//var c=$('input[name=status]').val();
var v=$("#status").val();

$("#renew_status").hide();
$("#closed_status").hide();

$("#"+v+"_status").show();

$("#cEnd").val("");
$("#r_bookstatus").val("");
$("#dpEnd").val("");
if(v=="renew"){
	 $("#cEnd").val("<?=date("d/m/Y")?>");

	 $("#r_bookstatus").val("c");
}
if(v=="closed"){
	 $("#dpEnd").val("<?=date("d/m/Y")?>");

	 
}

 

}
 
$('#dpEnd').datepicker({
   daysOfWeekDisabled: [0,0]
	//var d = new Date();
	//options["startDate"] = new Date(d.setDate(d.getDate() - 1));
});


$('#cEnd').datepicker({

	   daysOfWeekDisabled: [0,0]
		//var d = new Date();
		//options["startDate"] = new Date(d.setDate(d.getDate() - 1));
	});
 </script>

 <? ob_flush(); ?>