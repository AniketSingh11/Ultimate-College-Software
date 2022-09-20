 <?php
 include("header.php");

  if(isset($_POST["submit"]))
  {
	  
      
      $student_id=addslashes(trim($_POST["student"]));
      $book_id=addslashes(trim($_POST["sel_book"]));
      
      
      
      $from_date=addslashes(trim($_POST["f_date"]));
      $to_date=addslashes(trim($_POST["t_date"]));
      $bid=addslashes(trim($_POST["b_id"]));
      $date=date("Y-m-d");
      
      $err_msg="";
      $res=mysql_query("select * from lms_book where b_id='$book_id'");
      $row=mysql_fetch_array($res);
      $avilable_qty=$row["avilable_qty"];
      
      if($avilable_qty==0){
          
          $err_msg.="Book Is No Availability..  &nbsp;";
      }
      
      $res1=mysql_query("select * from lms_student_borrowbook where student_id='$student_id' and  book_id='$book_id'") or die(mysql_error());
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
	    
	    $sql=mysql_query("INSERT INTO lms_book_renew(sb_id,renew_startdate,renew_enddate) values('$sb_id','$from_date','$to_date')") or die(mysql_error());
	    
	    
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
			 <h1>  Student  Book Status <a  onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
                   
                   $s_id=$_GET["sid"];
                   
                    
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
						Student  Book Status 
					 </h3>			 
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
				
				 <div class="portlet-content">                      
<div class="col-sm-12">
				            	
				             
				            	
				            	
				            	<div class="form-group">
									<label for="name">Student ID &nbsp;&nbsp;&nbsp;&nbsp;</label>
									<select id="student" name="student" onchange="select_employee()" data-required="true" class="form-control" style="width:50%">
                                    	<option value="">Plese select Student </option>
                                        <?php 
										$emp_query="select * from student where b_id='$bid' and ay_id='$acyear' order by firstname asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$ss_id=$emp_display["ss_id"];		?>
                                        <option value="<?php echo $ss_id;?>" <?php if($ss_id==$s_id){ echo "selected"; }?>><?php echo  $emp_display["admission_number"]."-".$emp_display["firstname"]." ".$emp_display["lastname"]; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>       
								
								
							
								
							                         
                                
</div>

 

<?php if($s_id){ ?>  
        <center      <a title="view" href="#info-dialog_<?php echo $s_id;?>" data-toggle="modal">    <button type="button" class="btn btn-warning">   Student profile</button></a></center>
							 <div class="table-responsive">
                             <table 
								class="table table-striped table-bordered table-hover table-highlight table-checkable" 
								data-provide="datatable" 
								data-display-rows="10"
								data-info="true"
								data-search="true"
								data-length-change="true"
								data-paginate="true">
									<thead>
										<tr>
											<th data-sortable="true" width="5%">S.No</th>
											 
											 <th data-filterable="true" data-sortable="true">Student Name</th>
											  <th data-filterable="true" data-sortable="true">Section</th>
											 <th data-filterable="true" data-sortable="true">Book Title</th>
											 <th data-filterable="true" data-sortable="true">Book Number</th>
                                            <!--  <th data-filterable="true" data-sortable="true">From Date</th>	--> 
                                             <th data-filterable="true" data-sortable="true">Renew Date <br>Or Closed Date</th>											 
											 <th data-filterable="true" data-sortable="true">Status</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
										
										
										
									 
											$emp_query="select * from lms_student_borrowbook  where ay_id='$acyear' and student_id='$s_id' and b_id='$bid' order by status asc";
										 
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$board=$emp_display["b_id"];	
			$sb_id=$emp_display["sb_id"];
			$query=mysql_query("SELECT * FROM board where b_id='$board'");
			$res=mysql_fetch_array($query);
			$board_name=$res["b_name"];
			
		    
			$res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
			$row=mysql_fetch_array($res);
			$book_title=$row["book_title"];
			$book_no=$row["book_no"];
			
			$res=mysql_query("select * from student where ss_id='$emp_display[student_id]'");
			$row=mysql_fetch_array($res);
			$admission_number=$row["admission_number"];
			$firstname=$row["firstname"];
			$c_id=$row["c_id"];
			$section_id=$row["s_id"];
			
			
			 
			 
			$query=mysql_query("SELECT * FROM class where c_id='$c_id'");
			$res=mysql_fetch_array($query);
			$class_name=$res["c_name"];
			
			$query=mysql_query("SELECT * FROM section where s_id='$section_id'");
			$res=mysql_fetch_array($query);
			$section_name=$res["s_name"];
			
			
			$res=mysql_query("select * from lms_book_renew where sb_id='$sb_id' order by lbr_id desc");
			$row=mysql_fetch_array($res);
			$enddate=$row["renew_enddate"];
			
			
			$en=explode("-",$enddate);
		 
			$end_date=$en[2]."/".$en[1]."/".$en[0];
			 
			    $status=$emp_display["status"];
			
			if($status==1)
			{
			    $enddate=$emp_display["return_date"];
			    $en=explode("-",$enddate);
			    	
			    $end_date=$en[2]."/".$en[1]."/".$en[0];
			}
			
			
			
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
										 
											  <td><?php echo $admission_number."-".$firstname; ?> </td>
                                              <td><?php echo $section_name."-".$class_name; ?> </td>
                                             <td><?php echo $book_title; ?> </td>
                                             <td><?php echo $book_no; ?> </td>
                                            <!--   <td><?php echo $emp_display["start_date"]; ?> </td>-->
                                             <td><?php echo $end_date; ?> </td>
                                          <?php   if( $emp_display["lost_bookstatus"]==1){?>
                                             <td><button type="button" class="btn btn-sm btn-primary">Losted</button></td>		
                                             	<?php }elseif($emp_display["status"]==0){?> 	
                                              <td><button type="button" class="btn btn-sm btn-primary">Pending</button></td>
                                              <?php } else { ?> <td><button type="button" class="btn btn-sm btn-success">Closed</button></td>	<?php }?>	
                                             
                                             								 
											 <td><a title="view" href="#styledModal<?php echo $emp_count.''.$sb_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="edit" href="borrow_bookdetails_edit.php?id=<?php echo $sb_id; ?>"><img src="img/layout/edit.png"/></a> 
											 <!-- <a title="delete" href="book_details_delete.php?id=<?php echo $sb_id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> --> </td>
										 </tr>
		<?php 
        
		$emp_count++;
		
        }
        
        ?>							
									</tbody>
								</table>
				</div>  <!-- /.table-responsive -->
					<?php }?>	 
                                
  			 </div>  <!-- /.portlet-content -->
             
    
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 
 
 <?php
 
$emp_query="select * from lms_student_borrowbook  where ay_id='$acyear' and student_id='$s_id' and b_id='$bid' order by status asc";
$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$sb_id=$emp_display["sb_id"];	

			$board=$emp_display["b_id"];
			$sb_id=$emp_display["sb_id"];
			$query=mysql_query("SELECT * FROM board where b_id='$board'");
			$res=mysql_fetch_array($query);
			$board_name=$res["b_name"];
				
			
			$res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
			$row=mysql_fetch_array($res);
			$book_title=$row["book_title"];
			$book_no=$row["book_no"];
				
			$res=mysql_query("select * from student where ss_id='$emp_display[student_id]'");
			$row=mysql_fetch_array($res);
			$admission_number=$row["admission_number"];
			$firstname=$row["firstname"];
		 
			$res=mysql_query("select * from lms_book_renew where sb_id='$sb_id' order by lbr_id desc");
			$row=mysql_fetch_array($res);
			$enddate=$row["renew_enddate"];
			
			$en=explode("-",$enddate);
				
			$end_date=$en[2]."/".$en[1]."/".$en[0];
			$status=$emp_display["status"];
			$s_title="Renew";	
			if($status==1)
			{  $s_title="Closed";
			    $enddate=$emp_display["return_date"];
			    $en=explode("-",$enddate);
			    	
			    $end_date=$en[2]."/".$en[1]."/".$en[0];
			}
			
		?>  
<div id="styledModal<?php echo $emp_count.''.$sb_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"> Book Details</h3>
      </div>
      <div class="modal-body">
     
        <table class="table">
					        <!--<thead>
					          <tr>
					            <th width="5%">S.no</th>
					            <th>Tilte</th>
					            <th></th>
					            <th>Details</th>
					          </tr>
					        </thead>-->
					        <tbody>
                            <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Borrow Book Details</b>
                                </h4></td>
					          </tr>
                              
                               <tr>
					            <td>Board</td>
					            <td>:</td>
					            <td><?php echo $board_name ; ?></td>
					          </tr>
					          
					           
					           <tr>
					            <td>Student</td>
					            <td>:</td>
					            <td><?php echo $admission_number."-".$firstname; ?></td>
					          </tr>
                              
                              <tr>
					            <td>Book Titles</td>
					            <td>:</td>
					            <td><?php echo $book_title ; ?></td>
					          </tr>
					          
					           <tr>
					            <td>Book Number</td>
					            <td>:</td>
					            <td><?php echo $book_no ; ?></td>
					          </tr>
					          
					      <!--     <tr>
					            <td>From Date</td>
					            <td>:</td>
					            <td><?php echo $emp_display["start_date"];  ?></td>
					          </tr>
					          -->
                              <tr>
					            <td><?=$s_title?> Date</td>
					            <td>:</td>
					            <td><?php echo $end_date; ?></td>
					          </tr>
                              
					        </tbody>
					      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!--  New Addtional Model -->
<?php $qry=mysql_query("SELECT * FROM student WHERE ss_id='$emp_display[student_id]'  ORDER BY firstname ASC");
       $row=mysql_fetch_array($qry);?>
<div id="info-dialog_<?php echo $s_id;?>" title="<?php echo $row['admission_number']; ?>, This student details" style="display: none;" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"> student Details</h3>
      </div>
      <div class="modal-body">
     
            <center><img src="../img/student/<?php echo $row['photo']; ?>" alt="student photo" width="60" height="60"></center>
				<p>Admin NO : <strong><?php echo $row['admission_number']; ?></strong></p>
                
                 <p>First Name : <strong><?php echo $row['firstname']; ?></strong></p> 
                
                <p>Last Name : <strong><?php echo $row['lastname']; ?></strong>  </p>   
                
                <p>Father / Guardian Name: <strong><?php echo $row['fathersname']; ?></strong>  </p>   
                
                <p>Father / Guardian Occupation : <strong><?php echo $row['fathersocupation']; ?></strong>  </p> 
                
                <p>Father / Guardian Monthly Income : <strong><?php echo $row['p_income']; ?></strong>  </p> 
                
                <p>Mother's Name : <strong><?php echo $row['m_name']; ?></strong>  </p> 
                
                <p>Mother's Occupation : <strong><?php echo $row['m_occup']; ?></strong>  </p> 
                
                <p>Mother's Monthly Income : <strong><?php echo $row['m_income']; ?></strong>  </p>   
                
                <p>Date of admission :  <strong><?php echo $row['doa']; ?></strong>  </p>   
                
                <p>Date Of Birth : <strong><?php echo $row['dob']; ?></strong> </p>   
                
                <p>Gender : <strong><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Nationality : <strong><?php echo $row['nation']; ?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $row['reg']; ?></strong> </p>   
                
                <p>Caste : <strong><?php echo $row['caste']; ?></strong>  </p>   
                
                <p>Subcaste : <strong><?php echo $row['sub_caste']; ?></strong>  </p>   
                
                <p>Blood Group : <strong><?php echo $row['blood']; ?></strong> </p>   
                
                <p>Email : <strong><?php echo $row['email']; ?></strong> </p>  
                
                <p>Phone : <strong><?php echo $row['phone_number']; ?></strong>  </p>   
                
                <p>Residence Address1 : <strong><?php echo $row['address1']; ?></strong>  </p>   
                
                <p>Residence Address2 : <strong><?php echo $row['address2']; ?></strong> </p>   
                
                <p>Town or village Name : <strong><?php echo $row['city_id']; ?></strong> </p>   
                
                <p>Country : <strong><?php echo $row['country']; ?></strong> </p> 
                
                <p>Pin Code : <strong><?php echo $row['pin']; ?></strong> </p>   
                
                <p>Mother Tongue : <strong><?php echo $row['mother_tongue']; ?></strong> </p>   
                
                <p>Height : <strong><?php echo $row['height']; ?></strong> </p>
                
                <p>Weight : <strong><?php echo $row['weight']; ?></strong> </p>
                
                <p>Remarks : <strong><?php echo $row['remarks']; ?></strong> </p>
                
                <p>student type : <strong><?php echo $row['stype']; ?></strong> </p>
                
                <?php 
				$fdis_id=$row['fdis_id'];
				if($fdis_id){ 
				//$rid1=$invoice['r_id'];
								  $qry6=mysql_query("SELECT * FROM fdiscount WHERE fdis_id=$fdis_id"); 
								  $row6=mysql_fetch_array($qry6);
				?>
                <p>Student Category  : <strong><?php echo $row6['fdis_name']; ?></strong> </p>   
                <?php } $rid=$row['r_id'];
				$spid=$row['sp_id'];
				if($rid){ 
				//$rid1=$invoice['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  $row5=mysql_fetch_array($qry5);
				?>
                <p>Bus Route Name : <strong><?php echo $row5['r_name']; ?></strong> </p>   
                <?php } if($spid){
					 $qry6=mysql_query("SELECT * FROM stopping WHERE sp_id=$spid"); 
								  $row6=mysql_fetch_array($qry6);?>				
                <p>Stopping Point : <strong><?php echo $row6['sp_name']; ?></strong> </p> 
                
                <?php } 
						$fesstypearray=array("Normal Fees","Sp.Fees","Onetime Sp.Fees");
						$busfeestype=$row['busfeestype'];
				 	 if($rid){ 
					 ?>				
                <p>Bus Fees Rate Type : <strong><?php echo $fesstypearray[$busfeestype]; ?></strong> </p> 
                <?php } ?>
                <p>Status  : <?php if($row['user_status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </p>
                                </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div>
                </div>
<!--  New Addtional Model Finished -->
<?php         
		$emp_count++;		
        }        
        ?>	
 
 <?php 
 include("footer.php"); 
 include("includes/script.php");?>
 <script type="text/javascript">

 
 function change_function1(){ 
		
	    var bid =document.getElementById('bid').value;
	    var student = parseFloat(document.getElementById('student').value);
	    
		 window.location.href = "singlestudent_borrow_details.php?sid="+student+'&bid='+bid;
		 	  
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
	 var student = parseFloat(document.getElementById('student').value);
     
     var bid=document.getElementById('bid').value;
     
	  if(student>0){
		  window.location="singlestudent_borrow_details.php?sid="+student+'&bid='+bid;
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