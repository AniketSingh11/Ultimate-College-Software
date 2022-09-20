 <?php
 include("header.php");

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
			 <h1> Datewise Hostel Report <a  onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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



<?php    
                    
                   $fromdate=$_GET["from_date"];
                   $todate=$_GET["to_date"];
                   
                   $fo=explode("/",$fromdate);
                   $from_date=$fo[2]."-".$fo[1]."-".$fo[0];
                   $to=explode("/",$todate);
                   $to_date=$to[2]."-".$to[1]."-".$to[0];
                  
                     $filter=$_GET["filter"];
                   
                   if($filter=="join_student")
                   {  
                       $emp_query="select * from hms_student_room  where 	status='0' and  join_date <= '$to_date' and join_date >= '$from_date'  order by category asc";
                                   	 
                       	$takeid="admission_number";
                       	$type_format="Join";
                       	$type_value="join_date";
                       	$person="student";
                   }elseif ($filter=="vacate_student")
                   {
                       
                         $emp_query="select * from hms_student_room  where 	status='1' and  vacate_date <= '$to_date' and vacate_date >= '$from_date'  order by category asc";

                         $takeid="admission_number";
                         $type_format="Vacate";
                         $type_value="vacate_date";
                         $person="student";
                   }elseif ($filter=="join_staff"){
                      
                       $takeid="staff_id";
                       $type_format="Join";
                       $type_value="join_date";
                       $person="staff";
                     $emp_query="select * from hms_staff_room  where 	status='0' and  join_date <= '$to_date' and join_date >= '$from_date'  order by category asc";
                            
                       
                   }else{
                       $takeid="staff_id";
                       $type_format="Vacate";
                       $type_value="vacate_date";
                       $person="staff";
                      $emp_query="select * from hms_staff_room  where 	status='1' and  vacate_date <= '$to_date' and join_date >= '$from_date'  order by category asc";
                
                       
                   }
                   
                   
                    
            ?>
				 <div class="portlet-header">
			   <h3>						 
						Datewise Report
					 </h3>			 
				 </div>  <!-- /.portlet-header -->	
<form id="validate-enhanced" action="" class="form parsley-form" method="get" enctype="multipart/form-data" name="first">
				
				                           
                          <div class="portlet-content">  
                            
								   <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Start Date</label>
                                    <div class="input-group date ui-datepicker1" style="width:55%">
									<input class="form-control txt"  type="text"    placeholder="From  date" value="<?=$fromdate?>" name="from_date"  data-minlength="10"   data-maxlength="10"    id="from_date" data-date-format="dd/mm/yyyy" data-date-autoclose="true"  data-required="true"  >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>  
								  
								 
								<div class="form-group">
									<label for="name">To Date</label>
                                    <div class="input-group date ui-datepicker1 " style="width:55%">
									<input class="form-control txt"  type="text"    placeholder="To  date" name="to_date"  value="<?=$todate?>" data-minlength="10"   data-maxlength="10"   id="to_date" data-date-format="dd/mm/yyyy" data-date-autoclose="true"  data-required="true"  >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>  </div> 
								
								
								  <div class="col-sm-6">
								 <div class="form-group">
									<label for="name">Select</label>
                                   <select  name="filter"  data-required="true" class="form-control" style="width:35%">
                                      <option value="">Plese select</option>
                                     <option value="join_student"  <?php if($filter=="join_student"){?>selected="selected" <?php }?>>Joined Student</option>		
                                    <option value="vacate_student"  <?php if($filter=="vacate_student"){?>selected="selected" <?php }?>>Vacate Student</option> 
                                     <option value="join_staff" <?php if($filter=="join_staff"){?>selected="selected" <?php }?>>Joined Staff</option>	
                                        <option value="vacate_staff" <?php if($filter=="vacate_staff"){?>selected="selected" <?php }?>>Vacate Staff</option>						
                            		</select>
								</div>  
								
								<div class="form-group">
								 
								 
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
								 </div> 
								 
								 </div>
								  <div class="portlet-content">  
				 		
<?php if($filter){

    
    
    
    ?>    
                 
							 <div class="table-responsive">
							  <center>   <a href="export_datewisehostel_report.php?from_date=<?=$fromdate?>&to_date=<?=$todate?>&filter=<?=$filter?>">    <button type="button" class="btn btn-warning">   Download Excel</button></a></center>  
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
											 <th data-filterable="true" data-sortable="true">Hostel Name</th>
											 <th data-filterable="true" data-sortable="true">Floor</th>
											 <th data-filterable="true" data-sortable="true">Room Number / cart</th>
											  
											 <th data-filterable="true" data-sortable="true">Person Name</th>
											 
                                             <th data-filterable="true" data-sortable="true"><?=$type_format?>Date</th>	 
                                          										 
											 
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
										 
										//$emp_query="select * from lms_student_borrowbook  where ay_id='$acyear' and book_id='$s_id' order by status asc";
									 	$emp_result=mysql_query($emp_query) or die (mysql_error());
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
										    
										    $res=mysql_query("select * from hms_category where h_id='$emp_display[category]'");
										    $row=mysql_fetch_array($res);
										    $hostel_name=$row["h_name"];

										    $res=mysql_query("select * from hms_room where hr_id='$hr_id'");
										    $row=mysql_fetch_array($res);
										    $room_number=$row["room_number"];
										    $res=mysql_query("select * from hms_room_cart where hrc_id='$hrc_id'");
										    $row=mysql_fetch_array($res);
										    $cart_name=$row["cart_name"];
										    
										    
										    $number=$emp_display["$takeid"];
										    $firstname=$emp_display["firstname"];
								
										    $qdate=$emp_display["$type_value"];
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
										    <td><?php echo $hostel_name; ?> </td>
                                             <td><?php echo $floor_name; ?> </td>
                                            
                                            <td><?php echo $room_number." / ".$cart_name; ?> </td>
                                             <td><?php echo $number." ".$firstname; ?> </td>
                                            
                                             <td><?=date("d/m/y",strtotime($qdate))?></td>
                                          <td> <a title="edit" href="<?=$person?>_roomdetails_edit.php?id=<?php echo $hsr_id; ?>"><img src="img/layout/edit.png"/></a>  </td>
										 </tr>
		<?php 
       
$emp_count++;
         }
									 
						
		$emp_result=mysql_query($emp_query1);
	 
		while($emp_display=mysql_fetch_array($emp_result))
		{
			 
			$sb_id=$emp_display["sfb_id"];
			
			
			$staff_id=$emp_display["staff_id"];
			$filterdate=$emp_display["$filter_field"];
			$st=explode("-",$filterdate);
			
			$filter_date=$st[2]."/".$st[1]."/".$st[0];
			 
			$query=mysql_query("SELECT * FROM staff where st_id='$staff_id'");
			$res=mysql_fetch_array($query);
			 
			$staff_number=$res["staff_id"];
			$fname=$res["fname"];
			$lname=$res["lname"];

			$res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
			$row=mysql_fetch_array($res);
			$book_title=$row["book_title"];
			$book_no=$row["book_no"];
			
			$return_bookstatus=$emp_display["lost_bookstatus"];
			
			
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
										   
                                             <td><?php echo $book_no." ".$book_title; ?> </td>
                                            
                                            <td><?php echo $staff_number."-".$fname; ?> </td>
                                             <td>Staff</td>
                                              <td><?php echo $filter_date;  ?></td>
                                             <?php if($return_bookstatus==1){?>
                                             <td><button type="button" class="btn btn-sm btn-primary">Losted</button></td>		
                                             	<?php }elseif($emp_display["status"]==0){?> 	
                                              <td><button type="button" class="btn btn-sm btn-primary">Pending</button></td>
                                              <?php } else { ?> <td><button type="button" class="btn btn-sm btn-success">Closed</button></td>	<?php }?>
                                               						 
											 <td><a title="view" href="#styledModal_<?php echo $sb_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="edit" href="staff_borrow_bookdetails_edit.php?id=<?php echo $sb_id; ?>"><img src="img/layout/edit.png"/></a> 
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
 
 
$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$sb_id=$emp_display["sb_id"];	

			if($filter=="renew")
			{
			    $query="select * from  lms_student_borrowbook where sb_id='$sb_id'";
			    $res=mysql_query($query);
			    $emp_display=mysql_fetch_array($res);
			
			}
			$board=$emp_display["b_id"];
			 
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
<div id="styledModal<?php echo $sb_id;?>" class="modal modal-styled fade">
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
<?php         
		$emp_count++;		
        }        
        ?>	
  
  
 
 <?php 
 include("footer.php"); 
 include("includes/script.php");?>
 <script type="text/javascript">


 $('#from_date').datepicker({
	   daysOfWeekDisabled: [0,0]
		//var d = new Date();
		//options["startDate"] = new Date(d.setDate(d.getDate() - 1));
	});
	 
 $('#to_date').datepicker({
	   daysOfWeekDisabled: [0,0]
		//var d = new Date();
		//options["startDate"] = new Date(d.setDate(d.getDate() - 1));
	});
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
		  window.location="report_book_details.php?sid="+selbook;
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