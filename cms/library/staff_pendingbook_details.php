<?php
include("header.php");
?>
<style type="text/css">

	.howler {
		margin: 0 .75em 1em 0;
	}

	</style>
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
			 <h1>Staff Return Pending Book Details </h1><?php if($filter){?><span style="float:right; margin-right:30px;"><b>Filter by : </b> <?php echo $cat_name;?></span><?php } ?>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
		 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your  Record Successfully Updated 
			</div>	
<?php } ?>
		 
 <?php if($_GET["msg"] == 'delete_succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully deleted 
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


                   <div class="row">
				   <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
						 
						<!--  <div class="_25" style="float:right">
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
								 
                 </div> -->
							 <h3>
							Staff  Return Pending   Details List 
							 </h3>
                             
							 
						 </div>  <!-- /.portlet-header -->
						 <div class="portlet-content">
						   <center>     <a href="export_pending_staffbook_report.php?ay_id=<?=$acyear?>&b_id=<?=$bid?>">    <button type="button" class="btn btn-warning">   Download Excel</button></a></center>
 
							 <div class="table-responsive">
                             <table 
								class="table table-striped table-bordered table-hover table-highlight table-checkable" 
								data-provide="datatable" 
								data-display-rows="10"
								data-info="true"
								data-search="true"
								data-length-change="true"
								data-paginate="true"
							>
									<thead>
										<tr>
											<th data-sortable="true">S.No</th>
											 
											 <th data-filterable="true" data-sortable="true">staff Name</th>
											 
											 <th data-filterable="true" data-sortable="true">Book Title</th>
											 <th data-filterable="true" data-sortable="true">Book Number</th>
                                           <th data-filterable="true" data-sortable="true">Start Date</th>	
                                              <th data-filterable="true" data-sortable="true">Book  Status</th>	 									 
											 
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										
										<?php	
										
	$emp_query="select * from lms_staff_borrowbook  where status='0' and ay_id='$acyear'  order by date_time asc";
	$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
		 
			$sfb_id=$emp_display["sfb_id"];
			$book_no=$emp_display["book_number"];
			
		 $res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
			$row=mysql_fetch_array($res);
			$book_title=$row["book_title"];
			
			
			$res=mysql_query("select * from staff where st_id='$emp_display[staff_id]'");
			$row=mysql_fetch_array($res);
			$staff_number=$row["staff_id"];
			$fname=$row["fname"];
			$lname=$row["lname"];
			 
			
			
			
			
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
											 
											 <td><?php echo $staff_number."-".$fname." ".$lname; ?> </td>
                                             
                                             <td><?php echo $book_title; ?> </td>
                                             <td><?php echo $book_no; ?> </td>
                                            <td><?php echo $emp_display["start_date"]; ?> </td> 
                                         <!-- <td><?php echo $end_date; ?></td> -->
                                               <td><button type="button" class="btn btn-sm btn-primary">Pending</button></td>
                                             
                                             								 
											 <td><a title="view" href="#styledModal<?php echo $emp_count.''.$sfb_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="edit" href="staff_borrow_bookdetails_edit.php?id=<?php echo $sfb_id; ?>"><img src="img/layout/edit.png"/></a> 
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
					 </div>  <!-- /.portlet -->
				 </div>  <!-- /.col -->
			 </div>  <!-- /.row -->
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->

				<?php
 
$emp_query="select * from lms_staff_borrowbook where status='0'  and ay_id='$acyear'  order by date_time asc";
$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$sfb_id=$emp_display["sfb_id"];	
			$book_no=$emp_display["book_number"];
		 
			
			$res=mysql_query("select * from lms_book where b_id='$emp_display[book_id]'");
			$row=mysql_fetch_array($res);
			$book_title=$row["book_title"];
			 
			
				
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
					           
                           <!--    <tr>
					            <td>Renew Date</td>
					            <td>:</td>
					            <td><?php echo $end_date; ?></td>
					          </tr>--> 
                              
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
?>
<?php include("includes/script.php");?>
</body>
</html>
<script>
function change_function1(){ 
	
    var bid =document.getElementById('bid').value;
	 window.location.href = 'staff_pendingbook_details.php?bid='+bid;
	 	  
	}
</script>

 <? ob_flush(); ?>