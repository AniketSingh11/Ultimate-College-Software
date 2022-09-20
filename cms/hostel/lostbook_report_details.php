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
			 <h1> Lost Book Report <a  onclick="history.go(-1);"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
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
						 Lost Book Report
					 </h3>			 
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
				
				          <div class="portlet-content">                      
                          
                            	<div class="form-group">
									<label for="name">Lost Book No/Title </label>
									<select id="sel_book"  onchange="select_employee()"  placeholder="Please select Book" name="sel_book" data-required="true" class="form-control" style="width:50%">
                                     <option value="" selected="selected">Please Select Book </option>
                                        <?php 
                                        $emp_query1="select distinct book_id from lms_lostbooks";
                                        $emp_result1=mysql_query($emp_query1);
                                        while($emp_display1=mysql_fetch_array($emp_result1))
                                        { 
                                            $bookid=$emp_display1["book_id"];
										$emp_query="select * from lms_book where  b_id='$bookid'";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$b_id=$emp_display["b_id"];		?>
                                        <option value="<?php echo $b_id;?>" <?php if($s_id==$b_id){?> selected="selected" <?php }?>><?php echo  $emp_display["book_no"]."-".$emp_display["book_title"]; ?></option>
                                  <?php } }?>								
                            		</select>
								</div>  

 

 
                 <center>   <a href="export_lostbook_report.php?ay_id=<?=$acyear?>&book_id=<?=$s_id?>">    <button type="button" class="btn btn-warning">   Download Excel</button></a></center>
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
											 
											 <th data-filterable="true" data-sortable="true">Book Number Title</th>
											 <th data-filterable="true" data-sortable="true">Person Name</th>
											 <th data-filterable="true" data-sortable="true">Person Type</th>
                                            <!--  <th data-filterable="true" data-sortable="true">From Date</th>	--> 
                                          										 
											 <th data-filterable="true" data-sortable="true">Closed Date</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
										if($s_id){

										$emp_query="select * from lms_lostbooks where book_id='$s_id' and `ay_id`='$acyear' order by person_type desc";
										}else{
										    $emp_query="select * from lms_lostbooks  where   `ay_id`='$acyear'  order by person_type desc";
										    
										}
										
										$emp_result=mysql_query($emp_query);
										$emp_count=1;
										while($emp_display=mysql_fetch_array($emp_result))
										{
										    $lb_id=$emp_display["lb_id"];
										    $book_id=$emp_display["book_id"];
										    $person_type=$emp_display["person_type"];
										    $type_id=$emp_display["type_id"];
										    $closed_date=$emp_display["closed_date"];
										    $b_id=$emp_display["b_id"];
										    
										    
										    $res=mysql_query("select * from lms_book where b_id='$book_id'");
										    $row=mysql_fetch_array($res);
										    $book_title=$row["book_title"];
										    $book_no=$row["book_no"];
										    	
										    if($person_type=="student")
										    {
										    $res=mysql_query("select * from student where ss_id='$type_id'");
										    $row=mysql_fetch_array($res);
										    $number=$row["admission_number"];
										    $fname=$row["firstname"];
						                    $c_id=$row["c_id"];
										    $section_id=$row["s_id"];
										    $query=mysql_query("SELECT * FROM class where c_id='$c_id'");
										    $res=mysql_fetch_array($query);
										    $class_name=$res["c_name"];
										    $query=mysql_query("SELECT * FROM section where s_id='$section_id'");
										    $res=mysql_fetch_array($query);
										    $section_name=$res["s_name"];
		                                    }else{
		                                
		                                $query=mysql_query("SELECT * FROM staff where st_id='$type_id'");
		                                $res=mysql_fetch_array($query);
		                                
		                                $number=$res["staff_id"];
		                                $fname=$res["fname"];
		                                $lname=$res["lname"];
		                                
		                            }
		                            
		                            ?>
										 <tr>
											  <td><?php echo $emp_count ;?> </td>
										   
                                              <td><?php echo $book_no." ".$book_title; ?> </td>
                                            
                                              <td><?php echo $number."-".$fname; ?> </td>
                                              <td><?php echo $person_type;?></td>
                                               <td><?php echo $closed_date;?></td>
                                             
                                             								 
									 <td><a title="view" href="#styledModal_<?php echo $emp_count.''.$lb_id;?>" data-toggle="modal"><img src="img/layout/view.png"/>View Details</a>
											 <!-- <a title="delete" href="book_details_delete.php?id=<?php echo $sb_id; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> --> </td>
										 </tr>
		<?php 
       
$emp_count++;
         }
									 
											 
        
        ?>							
									</tbody>
								</table>
				</div>  <!-- /.table-responsive -->
					 
                                
  			 </div>  <!-- /.portlet-content -->
             
    
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php
 
 
 if($s_id){
 
     $emp_query="select * from lms_lostbooks where book_id='$s_id'  and `ay_id`='$acyear' order by person_type desc";
 }else{
     $emp_query="select * from lms_lostbooks  where   `ay_id`='$acyear'  order by person_type desc";
 
 }
 
 
 $emp_result=mysql_query($emp_query);
 $emp_count=1;
 while($emp_display=mysql_fetch_array($emp_result))
 {
     $lb_id=$emp_display["lb_id"];
     $book_id=$emp_display["book_id"];
     $person_type=$emp_display["person_type"];
     $type_id=$emp_display["type_id"];
     $closed_date=$emp_display["closed_date"];
     
     
 
     $res=mysql_query("select * from lms_book where b_id='$book_id'");
     $row=mysql_fetch_array($res);
     $book_title=$row["book_title"];
     $book_no=$row["book_no"];
     	
     
     
     if($person_type=="student")
     {
         $res=mysql_query("select * from student where ss_id='$type_id'");
         $row=mysql_fetch_array($res);
         $number=$row["admission_number"];
         $fname=$row["firstname"];
         $c_id=$row["c_id"];
         $b_id=$row["b_id"];
         $query=mysql_query("SELECT * FROM board where b_id='$b_id'");
         $res=mysql_fetch_array($query);
         $board_name=$res["b_name"];
         $section_id=$row["s_id"];
         $query=mysql_query("SELECT * FROM class where c_id='$c_id'");
         $res=mysql_fetch_array($query);
         $class_name=$res["c_name"];
         $query=mysql_query("SELECT * FROM section where s_id='$section_id'");
         $res=mysql_fetch_array($query);
         $section_name=$res["s_name"];
     }else{
 
         $query=mysql_query("SELECT * FROM staff where st_id='$type_id'");
         $res=mysql_fetch_array($query);
 
         $number=$res["staff_id"];
         $fname=$res["fname"];
         $lname=$res["lname"];
 
     }
		?>  
<div id="styledModal_<?php echo $emp_count.''.$lb_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"> Book Details</h3>
      </div>
      <div class="modal-body">
     
        <table class="table">
		 
					        <tbody>
                            <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Lost Book Details</b>
                                </h4></td>
					          </tr>
                              
                              <?php if($person_type=="student"){ ?>
                               <tr>
					            <td>Board</td>
					            <td>:</td>
					            <td><?php echo $board_name ; ?></td>
					          </tr>
					          
					           
					           <tr>
					            <td>Student</td>
					            <td>:</td>
					            <td><?php echo $number."-".$fname; ?></td>
					          </tr>
					          
					           <tr>
					            <td>Section</td>
					            <td>:</td>
					            <td><?php echo $section_name."-".$class_name; ?></td>
					          </tr>
					          <?php }else{?>
					          
					                <tr>
					            <td>Staff</td>
					            <td>:</td>
					            <td><?php echo $number."-".$fname; ?></td>
					          </tr>
					          
					          
					          <?php }?>
                              
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
					            <td>Closed Date</td>
					            <td>:</td>
					            <td><?php echo $closed_date; ?></td>
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
	    
		 window.location.href = "lostbook_report_details.php?sid="+staff+'&bid='+bid;
		 	  
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
		  window.location="lostbook_report_details.php?sid="+selbook;
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