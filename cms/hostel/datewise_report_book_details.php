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
			 <h1> Datewise Book Report <a  onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
                    
                   $fromdate=$_GET["from_date"];
                   $todate=$_GET["to_date"];
                   
                   $fo=explode("/",$fromdate);
                   $from_date=$fo[2]."-".$fo[1]."-".$fo[0];
                   $to=explode("/",$todate);
                   $to_date=$to[2]."-".$to[1]."-".$to[0];
                  
                     $filter=$_GET["filter"];
                   
                   if($filter=="apply")
                   {
                       $filter_field="start_date";
                       $filter_status="status";
                       
                       $emp_query="select * from lms_student_borrowbook  where ay_id='$acyear' and  start_date <= '$to_date' and start_date >= '$from_date'  order by status asc";
                       $emp_query1="select * from lms_staff_borrowbook  where  ay_id='$acyear' and start_date <= '$to_date' and start_date >= '$from_date'     order by status asc";
                       	 
                       	
                       
                   }elseif ($filter=="renew")
                   {
                       $filter_field="renew_startdate";
                       $filter_status="status";
                       
                        $emp_query="select * from  lms_book_renew  where  ay_id='$acyear' and renew_startdate  <= '$to_date' and renew_startdate >= '$from_date' and renew_status='0' ";
                       
                   }elseif ($filter=="return"){
                       $filter_field="return_date";
                       $filter_status="lost_bookstatus";
                        
                       
                       $emp_query="select * from lms_student_borrowbook  where ay_id='$acyear' and  return_date <= '$to_date' and return_date >= '$from_date' and status='1' and lost_bookstatus='0' ";
                       $emp_query1="select * from lms_staff_borrowbook  where  ay_id='$acyear' and  return_date <= '$to_date' and return_date >= '$from_date' and status='1' and lost_bookstatus='0' ";
                       
                       
                   }else{
                       
                       $filter_field="return_date";
                       $filter_status="lost_bookstatus";
                       
                        
                       $emp_query="select * from lms_student_borrowbook  where ay_id='$acyear' and  return_date <= '$to_date' and return_date >= '$from_date' and status='1' and lost_bookstatus='1' ";
                       $emp_query1="select * from lms_staff_borrowbook  where  ay_id='$acyear' and  return_date <= '$to_date' and return_date >= '$from_date' and status='1' and lost_bookstatus='1' ";
                       
                       
                   }
                   
                   
                    
            ?>
				 <div class="portlet-header">
				<!--   <div class="_25" style="float:right">
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
								 
                 </div>-->
				 			
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
                                     <option value="apply"  <?php if($filter=="apply"){?>selected="selected" <?php }?>>Applied Book</option>		
                                    <option value="renew"  <?php if($filter=="renew"){?>selected="selected" <?php }?>>Renewed Book</option> 
                                     <option value="return" <?php if($filter=="return"){?>selected="selected" <?php }?>>Returned Book</option>	
                                        <option value="lost" <?php if($filter=="lost"){?>selected="selected" <?php }?>>Losted Book</option>						
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
							  <center>   <a href="export_datewisebook_report.php?ay_id=<?=$acyear?>&from_date=<?=$fromdate?>&to_date=<?=$todate?>&filter=<?=$filter?>">    <button type="button" class="btn btn-warning">   Download Excel</button></a></center>  
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
											<th data-sortable="true"    width="5%">S.No</th>
											 
											 <th data-filterable="true" data-sortable="true">Book Number Title</th>
											 <th data-filterable="true" data-sortable="true">Person Name</th>
											 <th data-filterable="true" data-sortable="true">Person Type</th>
											 
                                             <th data-filterable="true" data-sortable="true"><?=ucfirst($filter)?> Date</th>	
                                             
                                          										 
											 <th data-filterable="true" data-sortable="true">Status</th>
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
										    $sb_id=$emp_display["sb_id"];
										    
										    $filterdate=$emp_display["$filter_field"];
										    if($filter=="renew")
										    {
										    $query="select * from  lms_student_borrowbook where sb_id='$sb_id'";
										    $res=mysql_query($query);
										    $emp_display=mysql_fetch_array($res);
										    
										    }
										    
										    $student_id=$emp_display["student_id"];
										  
										  /*   if($return_bookstatus==1){
										    $filter_scolour2="primary";
										    $filter_svalue2="Losted";
										    }
										    */
										     $st=explode("-",$filterdate);
				                        
				                            $filter_date=$st[2]."/".$st[1]."/".$st[0];
										    $res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
										    $row=mysql_fetch_array($res);
										    $book_title=$row["book_title"];
										    $book_no=$row["book_no"];
										    	
										    $res=mysql_query("select * from student where ss_id='$student_id'");
										    $row=mysql_fetch_array($res);
										    $student_number=$row["admission_number"];
										    $firstname=$row["firstname"];
										    
										    
										    
										    
										    
										    $c_id=$row["c_id"];
										    $section_id=$row["s_id"];
										    $status=$emp_display["status"];
										    if($status==0){
										        $status="Pending";   }
										        else{
										            $status="Closed";
										        }
										    	
										    	
										    $query=mysql_query("SELECT * FROM class where c_id='$c_id'");
										    $res=mysql_fetch_array($query);
										    $class_name=$res["c_name"];
										    
										    $query=mysql_query("SELECT * FROM section where s_id='$section_id'");
										    $res=mysql_fetch_array($query);
										    $section_name=$res["s_name"];
										    
										   
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
										   
                                            <td><?php echo $book_no." ".$book_title; ?> </td>
                                            
                                            <td><?php echo $student_number."-".$firstname; ?> </td>
                                            <td>Student</td>
                                            <td><?=$filter_date?></td>
                                            
                                            <?php  if($filter=="renew")
										    { ?><td><button type="button" class="btn btn-sm btn-success">Renewed</button></td>
										        
										     <?php }else{   if( $emp_display["lost_bookstatus"]==1){?>
                                             <td><button type="button" class="btn btn-sm btn-primary">Losted</button></td>		
                                             	<?php }elseif($emp_display["status"]==0){?> 	
                                              <td><button type="button" class="btn btn-sm btn-primary">Pending</button></td>
                                              <?php } else { ?> <td><button type="button" class="btn btn-sm btn-success">Closed</button></td>	<?php } }?>	
                                              			 
											 <td><a title="view" href="#styledModal<?php echo $sb_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="edit" href="borrow_bookdetails_edit.php?id=<?php echo $sb_id; ?>"><img src="img/layout/edit.png"/></a> 
											 <!-- <a title="delete" href="book_details_delete.php?id=<?php echo $sb_id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> --> </td>
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
 
 
$emp_result=mysql_query($emp_query1);
		 
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
			$s_title="Closed";
			$enddate=$emp_display["return_date"];
			if($enddate!=""){
			$en=explode("-",$enddate);
			
			$end_date=$en[2]."/".$en[1]."/".$en[0];
			}
		?>  
<div id="styledModal_<?php echo $sfb_id;?>" class="modal modal-styled fade">
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
					            <td>Closed Date</td>
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