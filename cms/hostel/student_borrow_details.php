 <?php
 include("header.php");
  $s_id=$_GET["sid"];
  if(isset($_POST["submit"]))
  {
	  
      
      
      $status=mysql_real_escape_string($_POST["status"]);
      $renewdate=mysql_real_escape_string($_POST["t_date"]);
      $cdate=mysql_real_escape_string($_POST["c_date"]);
      $r_status=mysql_real_escape_string($_POST["r_status"]);
      
      $t_amount=mysql_real_escape_string($_POST["t_amount"]);
      $c_amount=mysql_real_escape_string($_POST["c_amount"]);
      $lost_book=mysql_real_escape_string($_POST["lost_book"]);
      
      $id=mysql_real_escape_string($_POST["id"]);
      $url=mysql_real_escape_string($_POST["url"]);
      $st_id=mysql_real_escape_string($_POST["st_id"]);
      
      $renew=explode("/",$renewdate);
      
      $renew_date=$renew[2]."-".$renew[1]."-".$renew[0];
      $co=explode("/",$cdate);
      $c_date=$co[2]."-".$co[1]."-".$co[0];
      
      $date=date("Y-m-d");
      
  if($status!="" && $id!="")
	{
	    
	    $qty=round($qty);
	    
	   
	    
	   
	        if($status=="renew"){
	        
	$sql=mysql_query("INSERT INTO lms_book_renew (sb_id,renew_startdate,renew_enddate,ay_id) values('$id','$date','$renew_date','$acyear')") or die(mysql_error());
	
	$countquery=mysql_query("select count(*) as tp from lms_book_renew where sb_id='$id'");
	$rescount=mysql_fetch_array($countquery);
	$renew_count=$rescount["tp"]-1;
	
	$qry=mysql_query("update lms_student_borrowbook set renew_count='$renew_count',fine_amount='$t_amount' where sb_id='$id'");
	header("location:$url&msg=succ");
	        }elseif ($status=="closed")
	        {
	            $res=mysql_query("select * from lms_student_borrowbook where sb_id='$id'");
	            $row=mysql_fetch_array($res);
	            $book_id=$row["book_id"];
	            $student_id=$row["student_id"];
	            $ay_id=$row["ay_id"];
	            $b_id=$row["b_id"];
	            
	            $res=mysql_query("select * from lms_book where b_id='$book_id'");
	            $row=mysql_fetch_array($res);
	            $avilable_qty=$row["avilable_qty"]+1;
	            
	            
	             if($lost_book=="yes")
	            {
	                $qry=mysql_query("update lms_student_borrowbook set return_date='$c_date',return_bookstatus='$r_status',status='1',fine_amount='$c_amount',lost_bookstatus='1' where sb_id='$id'");
	                
	                $qty=$row["qty"]-1;
	                $qry=mysql_query("update lms_book set  qty='$qty' where b_id='$book_id'");
	                $sql=mysql_query("INSERT INTO lms_lostbooks (book_id,person_type,type_id,closed_date,creation_date,ay_id,b_id) values('$book_id','student','$student_id','$c_date','$date','$ay_id','$b_id')") or die(mysql_error());
	            
	            }else{
	                $qry=mysql_query("update lms_student_borrowbook set return_date='$c_date',return_bookstatus='$r_status',status='1',fine_amount='$c_amount' where sb_id='$id'");
	                
	                $qry=mysql_query("update lms_book set  avilable_qty='$avilable_qty' where b_id='$book_id'");
	            }
	            
	           
	            header("location:$url&msg=succ");
	        }else{
	            $err_msg.="Failed!!";
	            header("location:$url&msg=err&err_msg=$err_msg");
	        }
	}else{
	
	if($err_msg==""){
	    $err_msg.="Failed!!";}
	
	
	    header("location:$url&msg=err&err_msg=$err_msg");
 
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
			 <h1> Multi Renew/Closed Book <a href="borrow_bookdetails_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Inserted 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong>  <?php echo $_GET["err_msg"] ?>!!!
			</div>
<?php }
 if($_GET["msg"] == 'aerr') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> This employee already Got Loan!!!
			</div>
<?php } ?>



<?php   if(isset($_GET['bid']))
                   {
                       
                       $bid=$_GET['bid'];
                   }else{
                       
                       $board_query=mysql_query("SELECT * FROM board  order by b_id asc");
                       $bo=mysql_fetch_array($board_query);
                       
                       $bid=$bo['b_id'];
                        
                       
                   }
            ?>
				 <div class="portlet-header">
				 <div class="_25" style="float:right">
                <label for="select">Board :</label>
                                	<?php
                                            $classl = "SELECT * FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="bid" id="bid" class="required" onchange="change_function1()">';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($bid ==$row1['b_id']){
                                                echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
												} else {
												echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								 
                 </div>
				 			
					 <h3>						 
						Multi Renew/Closed Book 
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
		 
				 <div class="portlet-content">                      
<div class="col-sm-12">
				            
				            	
				            	<div class="form-group">
									<label for="name">Student ID &nbsp;&nbsp;&nbsp;&nbsp;</label>
									<select id="student" onchange="select_employee()"  name="student" data-required="true" class="form-control" style="width:50%">
                                    	<option value="">Plese select Student </option>
                                        <?php 
										$emp_query="select * from student where b_id='$bid' and ay_id='$acyear' order by firstname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$ss_id=$emp_display["ss_id"];		?>
                                        <option value="<?php echo $ss_id;?>" <?php if($s_id==$ss_id){ echo "selected"; }?>><?php echo  $emp_display["admission_number"]."-".$emp_display["firstname"]." ".$emp_display["lastname"]; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>       
								
								
								 
								
							                 
                                
</div>

 


  			 </div>  <!-- /.portlet-content -->
               
</form>
		 </div>  <!-- /#content-container -->
		 
		 <div class="panel-group accordion" id="accordion">
		<?php  if($s_id){		 		
$emp_query11="select * from lms_student_borrowbook  where status='0' and student_id='$s_id' and b_id='$bid' and ay_id='$acyear'";
$emp_result11=mysql_query($emp_query11);
$counts=0;
while($emp_display=mysql_fetch_array($emp_result11))
{
    $counts=$counts+1;
    $res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
    $row=mysql_fetch_array($res);
    $book_title=$row["book_title"];
    $book_no=$row["book_no"];
    
    $sb_id=$emp_display["sb_id"];
    
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
     
    $href="#$sb_id";
?>
             
      
     
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent=".accordion" href="<?=$href?>">
										<?php echo $book_no." - ".$book_title;?>
										</a>
									</h4>
								</div>
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
		
								<div style="height: 0px;" id="<?=substr($href,1,200)?>" class="panel-collapse collapse">
									<div class="panel-body">
										<div class="portlet-content">
     <!--<p class="title">Employee Details :</p> -->
     <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Book Number / Title:</label>
									<label for="value"><font color="red"><?php echo $book_no." - ".$book_title;?> </font></label>
								</div>  
								
                                                                                           
                                
   </div>
                            <div class="col-sm-6">
								<div class="form-group">
									<label for="name">From Date -To Date :</label>
									 <label for="value"><font color="red"><?php echo $start_date." - ".$end_date;?></font></label>
								</div>								
                                                                  
                        </div>        
                        <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Section :</label>
									 <label for="value"><font color="red"><?php echo $section_name." - ".$class_name;?></font></label>
								</div>								
                                                                  
                        </div>   
<div class="clear"></div><br>
				              <div class="col-sm-6">
								<div class="form-group">
									<label for="name"  >Status :</label>
									<select name="status" id="status<?=$sb_id?>" onchange="status_report('<?=$sb_id?>')" data-required="true"   class="required form-control">
									<option value="renew" selected="selected">Renew</option>
									<option value="closed">Closed</option>
									</select></div>
									
                                <em id="closed_status<?=$sb_id?>"  style="display: none;">
								<div class="form-group">
									<label for="name">Closed Date</label>
                                    <div class="input-group date ui-datepicker1 " style="width:35%">
									<input class="form-control txt" type="text" placeholder="Closed  date" name="c_date" value="<?=date("d/m/Y")?>"  data-minlength="10"   data-maxlength="10"  id="cEnd<?=$sb_id?>" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-required="true"  >
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
									 <textarea  data-required="true" id="r_bookstatus<?=$sb_id?>" name="r_status"   class="form-control"  type="text">c</textarea>
								</div>
								</em>
                              
                    </div>
                    <div class="col-sm-6">
								<div class="form-group" id="renew_status<?=$sb_id?>">
									<label for="name">Renew Date</label>
                                    <div class="input-group date ui-datepicker1 " style="width:35%">
									<input class="form-control txt"  type="text"   placeholder="Renew  date" name="t_date"    data-minlength="10"   data-maxlength="10"  id="dpEnd<?=$sb_id?>" data-date-format="dd/mm/yyyy" data-date-autoclose="true"  data-required="true"  >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    
								</div>  
                                
                    </div>
                    <div class="clear"></div>
                    <div class="col-sm-12">
                    <center>
                                  <div class="form-group">       
                               <input type="hidden"  name="t_amount" value="<?=$t_amount?>">
                                <input type="hidden" name="id" value="<?php echo  $sb_id;?>"/>
								<input type="hidden" name="st_id" value="<?php echo  $s_id;?>"/>
                                <input type="hidden" name="url" value="<?php echo basename($_SERVER['REQUEST_URI'],"/");?>"/>
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
                    </center>
                                </div>

     </div>				</div>
								</div>
								</form>
							</div> <!-- /.panel-default -->
<?php }if($counts==0){ echo "<h1 style='color:red';>No Books Available </h1>";}
		}?>
							 

				 		 

						</div>
		 
		  
		 
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 include("includes/script.php");
 if($s_id){
     $emp_query11="select * from lms_student_borrowbook  where status='0' and student_id='$s_id' and b_id='$bid' and ay_id='$acyear'";
     $emp_result11=mysql_query($emp_query11);
     $counts=0;
     while($emp_display=mysql_fetch_array($emp_result11))
     {
         $counts=$counts+1;
         $sb_id=$emp_display["sb_id"];
 ?>
  
 <script type="text/javascript">

 $("#cEnd<?=$sb_id?>").datepicker({

	   daysOfWeekDisabled: [0,0]
		//var d = new Date();
		//options["startDate"] = new Date(d.setDate(d.getDate() - 1));
	});

 $("#dpEnd<?=$sb_id?>").datepicker({

	   daysOfWeekDisabled: [0,0]
		//var d = new Date();
		//options["startDate"] = new Date(d.setDate(d.getDate() - 1));
	});
	</script>
 <?php }}?>
 
  
  <script type="text/javascript">
   
  $('#sel_book').select2 ({
  	allowClear: true,
  	placeholder: "Select..."
  });
  $('#student').select2 ({
  	allowClear: true,
  	placeholder: "Select..."
  });
 
 
	 
 function status_report(n)
 {

 //var c=$('input[name=status]').val();
 var v=$("#status"+n).val();

 $("#renew_status"+n).hide();
 $("#closed_status"+n).hide();

 $("#"+v+"_status"+n).show();

 $("#cEnd"+n).val("");
 $("#r_bookstatus"+n).val("");
 $("#dpEnd"+n).val("");
 if(v=="renew"){
 	 $("#cEnd"+n).val("<?=date("d/m/Y")?>");

 	 $("#r_bookstatus"+n).val("c");
 }
 if(v=="closed"){
 	 $("#dpEnd"+n).val("<?=date("d/m/Y")?>");

 	 
 }

  

 }

 
 function change_function1(){ 
		
	    var bid =document.getElementById('bid').value;
		 window.location.href = 'student_borrow_details.php?bid='+bid;
		 	  
		}



	
 function select_employee() { 
	  
      var student = parseFloat(document.getElementById('student').value);
      
      var bid =document.getElementById('bid').value;
      
	  if(student>0){
		  window.location="student_borrow_details.php?sid="+student+'&bid='+bid;
	  }	
}
    $(document).ready(function(){ 
        //iterate through each textboxes and add keyup
        //handler to trigger sum event
        $(".txt").each(function() { 
            $(this).keyup(function(){
                loan();
            });
        }); 
    });
	
 function loan() {	 
var a = document.first.l_t_amount.value;
var b = document.first.l_interest.value;
var c = document.first.l_terms.value;

//var n = c * 12;
var n = c;
var r = b/(12*100);
var p = (a * r *Math.pow((1+r),n))/(Math.pow((1+r),n)-1);
var prin = Math.round(p);
var total = Math.round(p*c);
var total_inrest = Math.round(total-a);
document.first.l_m_pay.value = prin;
document.first.l_t_inrest.value = total_inrest;
document.first.l_t_pay.value = total;
/*var mon = Math.round(((n * prin) - a)*100)/100;
document.first.r2.value = mon;
alert(mon);
var tot = Math.round((mon/n)*100)/100;
document.first.r3.value = tot;
for(var i=0;i<n;i++)
{
var z = a * r * 1;
var q = Math.round(z*100)/100;
var t = p - z;
var w = Math.round(t*100)/100;
var e = a-t;
var l = Math.round(e*100)/100;
a=e;
}*/
} 

</script> 
   
</body>
</html>

 <? ob_flush(); ?>