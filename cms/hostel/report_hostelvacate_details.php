 <?php include("header.php");?>
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
			 <h1>Overall Hostel Vacate Report <a  onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
                    
                   $s_id=$_GET["hid"];
                   
                    
            ?>
				 <div class="portlet-header">
				 
				 			
					 <h3>						 
						Overall Hostel Vacate Report
					 </h3>			 
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
				
				          <div class="portlet-content">                      
                          
                            	<div class="form-group">
									<label for="name">Select Hostel </label>
									<select id="sel_book"  onchange="select_employee()"  placeholder="Please select Book" name="sel_book" data-required="true" class="form-control" style="width:50%">
                                      <option value="">Select</option>
                                        <?php 
										$emp_query="select * from hms_category where   status='0' order by h_name asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$h_id=$emp_display["h_id"];		?>
                                        <option value="<?php echo $h_id;?>" <?php if($s_id==$h_id){?>selected="selected" <?php }?>><?php echo  $emp_display["h_name"]; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>  

 

<?php if($s_id){ ?>  
                 <center>   <a href="export_vacatehostel_report.php?type=category&id=<?=$s_id?>">    <button type="button" class="btn btn-warning">   Download Excel</button></a></center>
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
											 
											 <th data-filterable="true" data-sortable="true">Floor</th>
											 <th data-filterable="true" data-sortable="true">Room Number / cart</th>
											  
											 <th data-filterable="true" data-sortable="true">Person Name</th>
											 <th data-filterable="true" data-sortable="true">Person Type</th>
                                             <th data-filterable="true" data-sortable="true">Vacate Date</th>	 
                                          										 
											 
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
										

										$emp_query="select * from hms_student_room  where category='$s_id' and status='1' order by floor desc";
											
										
										$emp_result=mysql_query($emp_query);
										$emp_count=1;
										while($emp_display=mysql_fetch_array($emp_result))
										{
										    
										    $hsr_id=$emp_display["hsr_id"];
										    
										    $floor=$emp_display["floor"];
										    $category=$emp_display["category"];
										    $hr_id=$emp_display["hr_id"];
										    $hrc_id=$emp_display["hrc_id"];
										    $res=mysql_query("select * from hms_floor where hf_id='$floor'");
										    $row=mysql_fetch_array($res);
										    $floor_name=$row["floor_name"];
										    

										    $res=mysql_query("select * from hms_room where hr_id='$hr_id'");
										    $row=mysql_fetch_array($res);
										    $room_number=$row["room_number"];
										    $res=mysql_query("select * from hms_room_cart where hrc_id='$hrc_id'");
										    $row=mysql_fetch_array($res);
										    $cart_name=$row["cart_name"];
										    
										    
										    $student_number=$emp_display["admission_number"];
										    $firstname=$emp_display["firstname"];
								
										    $vacate_date=$emp_display["vacate_date"];
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
										   
                                             <td><?php echo $floor_name; ?> </td>
                                            
                                            <td><?php echo $room_number." / ".$cart_name; ?> </td>
                                             <td><?php echo $student_number." ".$firstname; ?> </td>
                                             <td>Student</td>
                                              <td><?=date("d/m/y",strtotime($vacate_date))?></td>
                                          <td> <a title="edit" href="student_roomdetails_edit.php?id=<?php echo $hsr_id; ?>"><img src="img/layout/edit.png"/></a>  </td>
										 </tr>
		<?php 
       
$emp_count++;
         }
									 
											$emp_query="select * from hms_staff_room  where category='$s_id' and status='1' order by floor desc";
										 
		
		$emp_result=mysql_query($emp_query);
	 
		while($emp_display=mysql_fetch_array($emp_result))
		{
			 
			$hsr_id=$emp_display["hsr_id"];
										    
										    $floor=$emp_display["floor"];
										    $category=$emp_display["category"];
										    $hr_id=$emp_display["hr_id"];
										    $hrc_id=$emp_display["hrc_id"];
										   
										    $res=mysql_query("select * from hms_floor where hf_id='$floor'");
										    $row=mysql_fetch_array($res);
										    $floor_name=$row["floor_name"];
										    

										    $res=mysql_query("select * from hms_room where hr_id='$hr_id'");
										    $row=mysql_fetch_array($res);
										    $room_number=$row["room_number"];
										    
										    $res=mysql_query("select * from hms_room_cart where hrc_id='$hrc_id'");
										    $row=mysql_fetch_array($res);
										    $cart_name=$row["cart_name"];
										    
										    $staff_id=$emp_display["staff_id"];
										    $firstname=$emp_display["firstname"];
			
										    $vacate_date=$emp_display["vacate_date"];
			
			
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
										   
                                             <td><?php echo $floor_name; ?> </td>
                                            
                                            <td><?php echo $room_number." / ".$cart_name;; ?> </td>
                                             <td><?php echo $student_number." ".$firstname; ?> </td>
                                             <td>Staff</td>
                                               <td><?=date("d/m/y",strtotime($vacate_date))?></td>
                                              <td> <a title="edit" href="staff_roomdetails_edit.php?id=<?php echo $hsr_id; ?>"><img src="img/layout/edit.png"/></a> </td>
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
 
$emp_query="select * from lms_student_borrowbook where     book_id='$s_id'  and ay_id='$acyear'  order by category asc";
$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$sb_id=$emp_display["sb_id"];	

			$board=$emp_display["b_id"];
			$sb_id=$emp_display["sb_id"];
			
			$status=$emp_display["status"];
			if($status==0){
			    $status="Pending"; }
			    else{
			        $status="Closed";}
			
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
		?>  
<div id="styledModal_<?php echo $emp_count.''.$sb_id;?>" class="modal modal-styled fade">
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
					            <td>Section</td>
					            <td>:</td>
					            <td><?php echo $section_name."-".$class_name; ?></td>
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
					            <td>Status</td>
					            <td>:</td>
					            <td><?php echo $status; ?></td>
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
<?php         
		$emp_count++;		
        }        
        ?>	
  
 <?php
 
$emp_query="select * from lms_staff_borrowbook where  book_id='$s_id'  and ay_id='$acyear'  order by status asc";
$emp_result=mysql_query($emp_query);
		 
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$sfb_id=$emp_display["sfb_id"];	

			$status=$emp_display["status"];
			if($status==0){
			    $status="Pending"; }
			    else{
			        $status="Closed";}
			
			$res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
			$row=mysql_fetch_array($res);
			$book_title=$row["book_title"];
			$book_no=$row["book_no"];
				
			$res=mysql_query("select * from staff where st_id='$emp_display[staff_id]'");
			$row=mysql_fetch_array($res);
			$staff_number=$row["staff_id"];
			$fname=$row["fname"];
			$lname=$row["lname"];
			 
			 
		?>  
<div id="styledModal<?php echo $emp_count.''.$sfb_id;?>" class="modal modal-styled fade">
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
                                    <b>Staff Borrow Book Details</b>
                                </h4></td>
					          </tr>
                              
                              
					          
					           
					           <tr>
					            <td>staff</td>
					            <td>:</td>
					            <td><?php echo $staff_number."-".$fname." ".$lname; ?></td>
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
					          
					         <tr>
					            <td>From Date</td>
					            <td>:</td>
					            <td><?php echo $emp_display["start_date"];  ?></td>
					          </tr>
					           
                            <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php echo $status; ?></td>
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
	    var staff = parseFloat(document.getElementById('sel_book').value);
	    
		 window.location.href = "report_book_details.php?sid="+staff+'&bid='+bid;
		 	  
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
 $('#staff').select2 ({
		allowClear: true,
		placeholder: "Select..."
	})
	
 function select_employee() { 
	 var selbook = parseFloat(document.getElementById('sel_book').value);
     
 if(selbook>0){
		  window.location="report_hostelvacate_details.php?hid="+selbook;
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