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
			 <h1>Overall Hostel Room Availability <a  onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
				  <h3>Overall Hostel Room Availability </h3>			 
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
											  <th data-filterable="true" data-sortable="true">Room Number</th>
											  <th data-filterable="true" data-sortable="true">Beds / Cart availability</th>
									 </tr>
									</thead>
									<tbody>
										<?php	
										
										

										$emp_query="select * from hms_room  where category='$s_id' and 	available_qty!='0' and status='0' order by category desc";
											
										
										$emp_result=mysql_query($emp_query);
										$emp_count=1;
										while($emp_display=mysql_fetch_array($emp_result))
										{
										    
										    $hr_id=$emp_display["hr_id"];
										    
										    $floor=$emp_display["floor"];
										    $category=$emp_display["category"];
										    $available_qty=$emp_display["available_qty"];
										    $room_number=$emp_display["room_number"];
										   
										    $res=mysql_query("select * from hms_floor where hf_id='$floor'");
										    $row=mysql_fetch_array($res);
										    $floor_name=$row["floor_name"];
										   
		                                  ?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
										   
                                             <td><?php echo $floor_name; ?> </td>
                                            
                                            <td><?php echo $room_number?> </td>
                                             <td>(<?=$available_qty?> - Cart Available) </td>
 
										 </tr>
		<?php 
       
$emp_count++;
         } ?>
									 
										 
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
		  window.location="check_room_availability.php?hid="+selbook;
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