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
			 <h1> Staff Book Status <a  onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
						Staff Book Status 
					 </h3>			 
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
				
				 <div class="portlet-content">                      
<div class="col-sm-12">
 	<div class="form-group">
									<label for="name">staff ID &nbsp;&nbsp;&nbsp;&nbsp;</label>
									<select id="staff" name="staff" onchange="select_employee()" data-required="true" class="form-control" style="width:50%">
                                    	<option value="">Plese select staff </option>
                                        <?php 
										$emp_query="select * from staff";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$ss_id=$emp_display["st_id"];		?>
                                        <option value="<?php echo $ss_id;?>" <?php if($ss_id==$s_id){ echo "selected"; }?>><?php echo  $emp_display["staff_id"]."-".$emp_display["fname"]." ".$emp_display["lname"]; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>       
			    
</div>

 

<?php if($s_id){ ?>  
                 <center   <a title="view" href="#info-dialog1<?php echo $s_id;?>" data-toggle="modal">    <button type="button" class="btn btn-warning">   Staff profile</button></a></center>
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
											 
											 <th data-filterable="true" data-sortable="true">Staff Name</th>
											  
											 <th data-filterable="true" data-sortable="true">Book Title</th>
											 <th data-filterable="true" data-sortable="true">Book Number</th>
                                            <!--  <th data-filterable="true" data-sortable="true">From Date</th>	--> 
                                          										 
											 <th data-filterable="true" data-sortable="true">Status</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
										
										
										
									 
											$emp_query="select * from lms_staff_borrowbook  where  staff_id='$s_id'  and ay_id='$acyear'  order by status asc";
										 
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			 
			$sb_id=$emp_display["sfb_id"];
		 
			
			$query=mysql_query("SELECT * FROM staff where st_id='$s_id'");
			$res=mysql_fetch_array($query);
			 
			$staff_number=$res["staff_id"];
			$fname=$res["fname"];
			$lname=$res["lname"];

			$res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
			$row=mysql_fetch_array($res);
			$book_title=$row["book_title"];
			$book_no=$row["book_no"];
			
		 
			
			
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
										 
											  <td><?php echo $staff_number."-".$fname; ?> </td>
                                              
                                             <td><?php echo $book_title; ?> </td>
                                             <td><?php echo $book_no; ?> </td>
                                           
                                              <?php   if( $emp_display["lost_bookstatus"]==1){?>
                                             <td><button type="button" class="btn btn-sm btn-primary">Losted</button></td>		
                                             	<?php }elseif($emp_display["status"]==0){?> 	
                                              <td><button type="button" class="btn btn-sm btn-primary">Pending</button></td>
                                              <?php } else { ?> <td><button type="button" class="btn btn-sm btn-success">Closed</button></td>	<?php }?>	
                                             
                                             								 
											 <td><a title="view" href="#styledModal<?php echo $emp_count.''.$sb_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="edit" href="staff_borrow_bookdetails_edit.php?id=<?php echo $sb_id; ?>"><img src="img/layout/edit.png"/></a> 
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
 
$emp_query="select * from lms_staff_borrowbook  where  staff_id='$s_id' and ay_id='$acyear'  order by status asc";
$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$sb_id=$emp_display["sfb_id"];	

			$startdate=$emp_display["start_date"];
			$st=explode("-",$startdate);
		 
			$start_date=$st[2]."/".$st[1]."/".$st[0];
			
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
					            <td>Start Date</td>
					            <td>:</td>
					            <td><?php echo $start_date  ?></td>
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


 <div id="info-dialog1<?php echo $s_id;?>" title="<?php echo $row['staff_id']; ?>, This Staff details" style="display: none;"class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"> Staff Profile Details</h3>
      </div>
      <div class="modal-body">
                                <center><img src="../img/staff/<?php echo $row['photo']; ?>" alt="staff photo" width="60" height="60"></center>
				<p>Staff ID : <strong><?php echo $row['staff_id']; ?></strong></p>
                
                 <p>First Name : <strong><?php echo $row['fname']; ?></strong></p> 
                
                <p>Middle Name : <strong><?php echo $row['mname']; ?></strong>  </p>   
                
                <p>Last Name : <strong><?php echo $row['lname']; ?></strong>  </p>   
                
                <p>Staff Type : <strong><?php echo $row['s_type']; ?></strong>  </p>   
                
                <p>Father's Name : <strong><?php echo $row['s_pname']; ?></strong>  </p>   
                
                <p>Date Of Birth :  <strong><?php echo $row['dob']; ?> </strong></p>   
                
                <p>Gender: <strong><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $row['reg']; ?></strong>  </p>   
                
                <p>Blood Group  :  <strong><?php echo $row['blood']; ?></strong>  </p>   
                
                <p>Position : <strong><?php echo $row['position']; ?></strong> </p>   
                
                <p>Expriences : <strong></strong> <?php echo $row['expriences']; ?></p>   
                
                <p>Email : <strong><?php echo $row['email']; ?></strong> </p>   
                
                <p>Phone No : <strong><?php echo $row['phone_no']; ?></strong>  </p>   
                
                <p>Residence Address1 : <strong><?php echo $row['address1']; ?></strong> </p>   
                
                <p>Residence Address2 : <strong><?php echo $row['address2']; ?></strong>  </p>   
                
                <p>Town or village Name  : <strong><?php echo $row['city']; ?></strong>  </p>   
                
                <p>Country : <strong><?php echo $row['country']; ?></strong> </p>   
                
                <p>Pin Code : <strong><?php echo $row['pincode']; ?></strong> </p>  
                
                 <?php $rid=$row['r_id'];
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
                
                <?php } ?>
                
                <center> <?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
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
	    var staff = parseFloat(document.getElementById('staff').value);
	    
		 window.location.href = "singlestaff_borrow_details.php?sid="+staff+'&bid='+bid;
		 	  
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
	 var staff = parseFloat(document.getElementById('staff').value);
     
    
     
	  if(staff>0){
		  window.location="singlestaff_borrow_details.php?sid="+staff;
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