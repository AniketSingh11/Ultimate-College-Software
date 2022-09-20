 <?php
 include("header.php");
  $s_id=$_GET["emp"];
  if(isset($_POST["submit"]))
  {
	  
      
      $student_id=addslashes(trim($_POST["student"]));
      $book_id=addslashes(trim($_POST["sel_book"]));
      
    
      
      
      $fromdate=addslashes(trim($_POST["f_date"]));
      $todate=addslashes(trim($_POST["t_date"]));
      $bid=addslashes(trim($_POST["b_id"]));
      $date=date("Y-m-d");
      
      $fr=explode("/",$fromdate);
      $to=explode("/",$todate);
      
      $from_date=$fr[2]."-".$fr[1]."-".$fr[0];
      $to_date=$to[2]."-".$to[1]."-".$to[0];
      
      $err_msg="";
      $res=mysql_query("select * from lms_book where b_id='$book_id' and status='0'");
      $row=mysql_fetch_array($res);
      $avilable_qty=$row["avilable_qty"];
      
      if($avilable_qty==0){
          
          $err_msg.="Book Is No Availability..  &nbsp;";
      }
      
      $res1=mysql_query("select * from lms_student_borrowbook where student_id='$student_id' and  book_id='$book_id' and status='0'") or die(mysql_error());
      $chk=0;
      while($row1=mysql_fetch_array($res1))
      {
         $chk=1; 
         $err_msg.="Book is Already Given..  &nbsp;";
          
      }
      
      
      if($avilable_qty!="0" && $chk!="1")
      {
        $query="insert into lms_student_borrowbook(student_id,book_id,start_date,end_date,ay_id,b_id,creation_date)
	          values('$student_id','$book_id','$from_date','$to_date','$acyear','$bid','$date')";
	    $result=mysql_query($query);
	    
	    
	    $sb_id=mysql_insert_id();
	    
	    $sql=mysql_query("INSERT INTO lms_book_renew(sb_id,renew_startdate,renew_enddate,renew_status,ay_id) values('$sb_id','$from_date','$to_date','1','$acyear')") or die(mysql_error());
	    
	    
	    $avilableqty=$avilable_qty-1;
	    
	    
	    $qry=mysql_query("update lms_book set avilable_qty='$avilableqty' where b_id='$book_id'");
	
	    
	    header("location: student_book_details.php?msg=succ&bid=$bid");
      }else{
          
          header("location: student_book_details.php?msg=err&err_msg=$err_msg&bid=$bid");
          
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
			 <h1> Apply Book <a href="borrow_bookdetails_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
						Apply Book  
					 </h3>			<?php if($s_id){ ?> <a href="loan_add.php" style="float:right;"><button type="button" class="btn btn-warning" > Select Another Student</button></a><?php } ?>
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
				<?php if(!$s_id){ ?>  
				 <div class="portlet-content">                      
<div class="col-sm-12">
				            	
				            	<div class="form-group">
									<label for="name">Book No/Title </label>
									<select id="sel_book"   placeholder="Please select Book" name="sel_book" data-required="true" class="form-control" style="width:50%">
                                     
                                        <?php 
										$emp_query="select * from lms_book where avilable_qty!='0' and status='0' order by book_title asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$b_id=$emp_display["b_id"];		?>
                                        <option value="<?php echo $b_id;?>"><?php echo  $emp_display["book_no"]."-".$emp_display["book_title"]; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>  
				            	
				            	
				            	<div class="form-group">
									<label for="name">Student ID &nbsp;&nbsp;&nbsp;&nbsp;</label>
									<select id="student" name="student" data-required="true" class="form-control" style="width:50%">
                                    	<option value="">Plese select Student </option>
                                        <?php 
										$emp_query="select * from student where b_id='$bid' and ay_id='$acyear' order by firstname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$ss_id=$emp_display["ss_id"];		?>
                                        <option value="<?php echo $ss_id;?>"><?php echo  $emp_display["admission_number"]."-".$emp_display["firstname"]." ".$emp_display["lastname"]; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>       
								
								
								 
								
								
								<div class="form-group">
									<label for="name">From Date</label>
                                    <div class="input-group date ui-datepicker1 " style="width:35%">
									<input class="form-control txt" type="text" placeholder="Start date" name="f_date" data-minlength="10"   data-maxlength="10" value="<?=date("d/m/Y")?>" id="dpStart" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-required="true" >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>     
								
								
								
								<div class="form-group">
									<label for="name">To Date</label>
                                    <div class="input-group date ui-datepicker1 " style="width:35%">
									<input class="form-control txt" type="text" placeholder="End  date" name="t_date"  data-minlength="10"   data-maxlength="10"  id="dpEnd" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-required="true" >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>                          
                                
</div>

 <div class="col-sm-12">
                    <center>
                             <div class="form-group"><input type="hidden" name="b_id" value="<?php echo  $bid;?>"/>
								<input type="hidden" name="st_id" value="<?php echo  $s_id;?>"/>
                                <input type="hidden" name="role" value="<?php echo $employee11['s_type'];?>"/>
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
                   </center>
                                </div>


  			 </div>  <!-- /.portlet-content -->
             <?php 
				 }			?>
  
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 include("includes/script.php");?>
 <script type="text/javascript">


 function sd()
 {
var v=$("#sel_book").val();
alert(v);
 }
 function change_function1(){ 
		
	    var bid=document.getElementById('bid').value;
		 window.location.href = 'student_book_details.php?bid='+bid;
		 	  
		}

 $('#dpStart').datepicker({
	 
	    daysOfWeekDisabled: [0,0]
	});

  
 $('#dpEnd').datepicker({
  daysOfWeekDisabled: [0,0]
	});
 $('#sel_book').select2 ({
		allowClear: true,
		placeholder: "Select..."
	})  
 $('#student').select2 ({
		allowClear: true,
		placeholder: "Select..."
	})
	
 function select_employee() { 
      var employee = parseFloat(document.getElementById('employee').value);
	  if(employee>0){
		  window.location="student_book_details.php?emp="+employee;
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