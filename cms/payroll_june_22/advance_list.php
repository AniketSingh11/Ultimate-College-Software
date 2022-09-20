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
	   $ltype=$_GET['ltype'];	
 	   $year=$_GET['year'];
	   $tyear=date("Y");
	   $pay=$_GET['pay'];
	     $st_id=$_GET["st_id"];
		
		$o_id=$_GET["o_id"];
		 $d_id=$_GET["d_id"];
											 
	   if($pay=="P"){
		   $payment="Pending";
	   }else if($pay=="R"){
		   $payment="Received";
	   }
	 						  	$ayear1=mysql_query("SELECT * FROM year ORDER BY s_year ASC");
								$ay1=mysql_fetch_array($ayear1);
								$start=$ay1['s_year'];
								
								?>
     <div id="content">		
		
		 <div id="content-header">
		 <?php
		 
		  $emp_query11="SELECT staff_name,status FROM staff_advance";
		
		  if($st_id)
		 {
			 $emp_query11.= "  where   st_id='$st_id'";
		 }
		 
		if($o_id)
		 {
			 $emp_query11.= "  where   o_id='$o_id'";
		 } 
		 if($d_id)
		 {
			 $emp_query11.= "  where   d_id='$d_id'";
		 }
		 
		// echo  $emp_query11;die;
		 $emp_result5=mysql_query($emp_query11);
		 while($emp_display5=mysql_fetch_array($emp_result5))
								{
		
		 
		   $staff_name=$emp_display5['staff_name'];
		   $status=$emp_display5['status'];
		 
		
		$emp_query12="SELECT SUM(a_amount) from staff_advance";
		$emp_result2=mysql_query($emp_query12);
		$emp_display2= mysql_fetch_array($emp_result2);
		//print_r($emp_display2);
		$a_amount=$emp_display2[0];
		//echo $a_amount;die;
	// print_r($emp_display5);die;
		if($status==1)
		
		{
			//echo $status;
			$emp_query9="SELECT SUM( a_amount ) FROM staff_advance where status=1";
			if($st_id)
		{
			$emp_query9.= "  AND st_id=$st_id"; 
			
		}
		elseif($o_id)
		{
			$emp_query9.= "   AND o_id=$o_id"; 
			
		}
		else if($d_id)
		{
			$emp_query9.= "   AND d_id=$d_id"; 
			
		}
		
			$emp_result9=mysql_query($emp_query9);
		    $emp_display9= mysql_fetch_array($emp_result9);
			//print_r($emp_display9);die;
			$recieved=$emp_display9[0];
		}
	if($status==0)
			
		{
			
		
			
			
			$emp_query14="SELECT SUM(a_amount) from staff_advance where status=0";
				if($st_id)
		{
			$emp_query14.= "  AND st_id=$st_id"; 
			
		}
		elseif($o_id)
		{
			$emp_query14.= "  AND o_id=$o_id"; 
			
		}
		elseif($d_id)
		{
			$emp_query14.= "   AND d_id=$d_id"; 
			
		}
			
			$emp_result14=mysql_query($emp_query14);
			
	      $emp_display14= mysql_fetch_array($emp_result14);
			//print_r($emp_display14);die;
			$pending=$emp_display14[0];
		}
		
	
		
		
								}
								
							
		?>
		
			
				
		 <h1> Advance Salary List <?php if($year){ echo "(".$year.")";}?></h1>
		 
		  <div style="float:left; margin-left:25px; padding:10px 0px;">
		
		Advance Salary Detail- Total:<?php if (!$st_id&!$o_id&!$d_id) { echo $a_amount; } else { echo $recieved+$pending;} ?>&nbsp;&nbsp;
		 Recieved:<?php if($recieved=="") { echo "0"; } else { echo $recieved; } ?>&nbsp;&nbsp;
		 Pending:<?php if($pending=="") { echo "0"; } else { echo $pending; }?>
		
		 </div>			
		 
		 <?php if($year||$staff_name){?>
		 
		 
		 
		 
		 <span style="float:right; margin-right:30px;"><b>
		 Filter by : </b>
		<?php if($year){ echo " Year = ".$year;}?><?php if($pay){ echo "| Payment = ".$payment;}?><?php if($st_id){ echo " | emp = ".$staff_name; } ?><?php if($o_id){ echo " | emp = ".$staff_name; } ?><?php if($d_id){ echo " |  emp = ".$staff_name; } ?></span><?php } ?>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
 <?php if($_GET["msg"] == 'dsucc') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully deleted 
			</div>
<?php } ?>	 <div class="row">
			 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								Advance Salary List <?php if($year){ echo "(".$year.")";}?>
							 </h3>
                             <a href="advance_add.php" title="Apply Loan"><button type="button" class="btn btn-warning">Apply Advance Salary</button></a>
							<?php 
							 $st_id=$_GET["st_id"];
		
		$o_id=$_GET["o_id"];
		 $d_id=$_GET["d_id"];
		  $pay=$_GET['pay'];
		  $year=$_GET['year'];
		 
		 ?>
                             <a href="advance_down.php?year=<?php echo $year."&pay=".$pay."&acid=".$acyear;?>" title="Download Report"><button type="button" class="btn btn-success">Download Report</button></a>
							 <a href="advance_list_print.php?year=<?php echo $year."&pay=".$pay."&acid=".$acyear;?>&<?php if($st_id){ echo 'st_id='.$st_id."&type=st"; }?><?php if($o_id){ echo 'o_id='.$o_id."&type=ow"; }?><?php if($d_id){ echo 'd_id='.$d_id."&type=dr"; }?>" title="Print" target="_blank"><button type="button" class="btn btn-success">Print</button></a>
                            <div class="btn-group" style="float:right; margin-right:10px;">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							    Filter by Payment <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
							   
                              <li <?php if(!$pay){ echo 'class="active"';}?>><a href="advance_list.php?<?php echo "?year=".$year;?>&<?php if($st_id){ echo 'st_id='.$st_id."&type=st"; }?><?php if($o_id){ echo 'o_id='.$o_id."&type=ow"; }?><?php if($d_id){ echo 'd_id='.$d_id."&type=dr"; }?>">Over All</a></li>
							   <?php 
							  
							   $st_id=$_GET["st_id"];
											 $o_id=$_GET["o_id"];
											 $d_id=$_GET["d_id"];
											  $year=$_GET['year'];
							  ?>
                              <li <?php if($pay=="R"){ echo 'class="active"';}?>><a href="advance_list.php?year=<?php echo $year."&pay=R";?>&<?php if($st_id){ echo 'st_id='.$st_id."&type=st"; }?><?php if($o_id){ echo 'o_id='.$o_id."&type=ow"; }?><?php if($d_id){ echo 'd_id='.$d_id."&type=dr"; }?><?php echo $row_enq['staff_name']; ?>">Received</a></li>
                              <li <?php if($pay=="P"){ echo 'class="active"';}?>><a href="advance_list.php?year=<?php echo $year."&pay=P";?>&<?php if($st_id){ echo 'st_id='.$st_id."&type=st"; }?><?php if($o_id){ echo 'o_id='.$o_id."&type=ow"; }?><?php if($d_id){ echo 'd_id='.$d_id."&type=dr"; }?><?php echo $row_enq['staff_name']; ?>">Pending</a></li>
							  </ul>
							</div>
                            <div class="btn-group" style="float:right; margin-right:10px;">
							  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
							    Filter by Year <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
							  <?php 
							  
							   $st_id=$_GET["st_id"];
											 $o_id=$_GET["o_id"];
											 $d_id=$_GET["d_id"];
											  $year=$_GET['year'];
											  //echo  $year;die;
							  ?>
                             <li <?php if(!$year){ echo 'class="active"';}?>><a href="advance_list.php<?php echo "?pay=".$pay;?>&<?php if($st_id){ echo 'st_id='.$st_id."&type=st"; }?><?php if($o_id){ echo 'o_id='.$o_id."&type=ow"; }?><?php if($d_id){ echo 'd_id='.$d_id."&type=dr"; }?>">Over All</a></li>
                              <?php for($i=$start;$i<=$tyear;$i++){ ?>
							 <li <?php if($year==$i){ echo 'class="active"';}?>><a href="advance_list.php?year=<?php echo $i."&pay=".$pay;?>&<?php if($st_id){ echo 'st_id='.$st_id."&type=st"; }?><?php if($o_id){ echo 'o_id='.$o_id."&type=ow"; }?><?php if($d_id){ echo 'd_id='.$d_id."&type=dr"; }?><?php echo $row_enq['staff_name']; ?>"><?php echo $i;?></a></li>
								  <?php } ?>
							  </ul>
							</div>
							  <div class="btn-group" style="float:right; margin-right:10px;">
							  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
							    Filter by Employe <span class="caret"></span>
							  </button>
							  
							  <ul class="dropdown-menu" role="menu" style="max-height:300px; overflow:scroll;">
							   <?php 
							  
							   $st_id1=$_GET["st_id"];
											 $o_id1=$_GET["o_id"];
											 $d_id1=$_GET["d_id"];
											 $staff_name=$_GET['staff_name'];
							  ?>
							  <li <?php if(!$st_id==!$st_id1||!$o_id== !$o_id1||!$d_id==!$d_id1)	{ echo "selected";	} ?> ><a href="advance_list.php">OVER ALL</a></li>
							 <?php
					
				    $emp_query=mysql_query("SELECT * FROM staff_advance group BY staff_name ORDER BY staff_name ");
				 
                    while ($row_enq = mysql_fetch_array($emp_query)) {
                     $staff_name=$row_enq['staff_name'];				  
                     $st_id=$row_enq['st_id'];
				     $o_id=$row_enq['o_id'];
					 $d_id=$row_enq['d_id'];
				   
					 $emp_query1=mysql_query("select * from staff WHERE status='1' AND st_id='$st_id'  order by fname asc");
							
								      $emp_display=mysql_fetch_array($emp_query1);
									
					 $emp_query2=mysql_query("select * from others WHERE status='1' AND o_id='$o_id' order by fname asc");			 $emp_display1=mysql_fetch_array($emp_query2);
					
					$emp_query3=mysql_query("select * from driver WHERE status='1' AND d_id='$d_id' order by fname asc");
					
					 $emp_display2=mysql_fetch_array($emp_query3);
				
				
		?>  
							  
                       <li <?php if($st_id==$st_id1||$o_id== $o_id1||$d_id==$d_id1)	{ echo "selected";	} ?> ><a href="advance_list.php?<?php if($st_id){ echo 'st_id='.$st_id."&type=st"; }?><?php if($o_id){ echo 'o_id='.$o_id."&type=ow"; }?><?php if($d_id){ echo 'd_id='.$d_id."&type=dr"; }?>"><?php echo $row_enq['staff_name']; ?></a></li>
				    
                          
				<?php }
				?> 
						
						   
							  </ul>
		
							</div>
							
						 </div>  <!-- /.portlet-header --> 
						 
						 <div class="portlet-content">						
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
											 <th data-filterable="true" data-sortable="true">Emp Code</th>
											 <th data-filterable="true" data-sortable="true">Emp Name </th>
                                             <th data-filterable="true" data-sortable="true">Date </th>	
                                             <th data-filterable="true" data-sortable="true">Amount</th>
                                             <th data-sortable="true">Payment</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm" width="12%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										
										
									
										
										
										
										     $st_id=$_GET["st_id"];
											 $o_id=$_GET["o_id"];
											 $d_id=$_GET["d_id"];
                                             $type=$_GET["type"];
											$year=$_GET['year'];
                                                  if(!$st_id&!$o_id&!$d_id)	{										 
											 $emp_query="select * from staff_advance";
											//echo "select * from staff_advance where staff_id='$staff_id'";die;
											if($year || $pay){
											$emp_query .=" where ";
                                              // echo 	$emp_query;die;										
											}
												  }
												  else
												  {
													  
													 $emp_query="select * from staff_advance";
													 
													 
											if($type=="st")
											 {
												$emp_query.= "  where st_id=$st_id"; 
												
											 }
	                                        
											 
											 elseif($type=="ow")
											 {
												$emp_query.= "  where o_id=$o_id"; 
											 }
	                                        
											 else
												
											 {
												$emp_query.= "  where d_id=$d_id"; 
											 }
	                                         if($year || $pay){
											$emp_query .=" AND";
                                              // echo 	$emp_query;die;										
											}
												  }	  
											 
											 

											
											if($year){
											  $emp_query .=" year=$year";	
											//echo 	$emp_query;die;
												if($pay=="P"){
												$emp_query .=" AND status=0";
                                                 //echo 	$emp_query;die;												
												}
												if($pay=="R"){
												$emp_query .=" AND status=1";										
												}									
											}else{
												if($pay=="P"){
												$emp_query .=" status=0";										
												}
												if($pay=="R"){
												$emp_query .=" status=1";										
												}
											}
												  
											 $emp_query .=" order by a_id desc";	
										//die;	
								$emp_result=mysql_query($emp_query);
								
								$emp_count=1;
								while($emp_display=mysql_fetch_array($emp_result))
								{
									$a_id=$emp_display["a_id"];	
									$emp_id=$emp_display["st_id"];
									$emp_id1=$emp_display["o_id"];	
									$emp_id2=$emp_display["d_id"];
								    $status=$emp_display["status"];	
		
			?> 					   
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><?php echo $emp_display["staff_id"]; ?> </td>
                                             <td><?php echo $emp_display["staff_name"]; ?> </td>
                                             <td><?php echo $emp_display["a_date"]; ?> </td>
                                             <td>Rs. <?php echo $emp_display["a_amount"]; ?> </td> 
                                             <td><?php if($status==1){ ?><button type="button" class="btn btn-success">received</button><?php } else{ ?><button type="button" class="btn btn-danger">Pending</button> <?php } ?></td>	
                                             <td><a title="Loan Details" href="#loanModal<?php echo $emp_count.''.$a_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> 
                                             <a title="Employee Details" href="#styledModal<?php echo $emp_count.''.$a_id;?>" data-toggle="modal"><img src="img/layout/user.png"/></a>
                                             <?php if($status!=1){?><a title="edit" href="advance_edit.php?id=<?php echo $a_id; ?>"><img src="img/layout/edit.png"/></a>
                                              <a title="delete" href="advance_delete.php?id=<?php echo $a_id;?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> <?php }else{?> 
                                              <a title="Print" href="monthly_salary_print.php?id=<?php echo $emp_display["st_ms_id"]; ?>&stid=<?php if($emp_id){ echo $emp_id."&type=st";}else if($emp_id1){ echo $emp_id1."&type=ow";}else if($emp_id2){ echo $emp_id2."&type=dr";}?>" target="_blank"><img src="img/layout/print.png"/></a>
                                              <?php } ?></td>
										 </tr>
		<?php         
		$emp_count++;		
        }   
		
        ?>							
									</tbody>
									
								</table>
								
				</div>  <!-- /.table-responsive -->
						 </div> 
						 <!-- /.portlet-content -->
						 
					 </div>  <!-- /.portlet -->
				 </div>  <!-- /.col -->
			 </div>  <!-- /.row -->
			 
		 </div>  <!-- /#content-container -->
		 
	 </div> 
	 <!-- #content -->
	</div>  <!-- #wrapper -->
 

				<?php
				
				
				$emp_query1="select * from staff_advance";
    //  echo "select * from staff_advance where staff_id='$staff_id'";die;				
											if($year){
											$emp_query1 .=" where year=$year";										
											}
											$emp_query1 .=" order by a_id desc";	
		$emp_result1=mysql_query($emp_query1);
		$emp_count=1;
		while($emp_display1=mysql_fetch_array($emp_result1))
		{
			$a_id=$emp_display1["a_id"];
			$status=$emp_display1["status"];		
			
			$st_id=$emp_display1["st_id"];	
			$o_id=$emp_display1["o_id"];	
			$d_id=$emp_display1["d_id"];	
			/*$emp_query=mysql_query("select * from staff where st_id='$emp_id'");
			$emp_display=mysql_fetch_array($emp_query);	*/
			
			if($st_id){		
			$emp_query11="select * from staff where st_id='$st_id'";
			//echo "select * from staff where st_id='$st_id' AND  staff_id='$staff_id'";die;
			$emp_result11=mysql_query($emp_query11);
			$emp_display=mysql_fetch_array($emp_result11);
			
			$staffname=$emp_display['fname']." ".$emp_display['lname'];
			$staffid=$emp_display['staff_id'];
			$path="../img/Staff/";
			}
			if($o_id){		
			$emp_query11="select * from others where o_id='$o_id'";
			//echo "select * from others where o_id='$o_id' AND  staff_id='$staff_id'";die;
			$emp_result11=mysql_query($emp_query11);
			$emp_display=mysql_fetch_array($emp_result11);	
			
			$staffname=$emp_display['fname']." ".$emp_display['lname'];
			$staffid=$emp_display['others_id'];
			$ocid=$emp_display["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
			$path="../img/others/";
			}
			if($d_id){		
			$emp_query11="select * from driver where d_id='$d_id'";
			$emp_result11=mysql_query($emp_query11);
			$emp_display=mysql_fetch_array($emp_result11);	
			
			$staffname=$emp_display['fname']." ".$emp_display['lname'];
			$staffid=$emp_display['driver_id'];
			$path="../img/driver/";
			}

		?>  
        
        <div id="loanModal<?php echo $emp_count.''.$a_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $staffname; ?> - Loan Details</h3>
      </div>
      <div class="modal-body">
        <table class="table">
					        <tbody>
                            <tbody>
                              <tr>
					            <td>Employee ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display1["staff_id"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Employee Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display1["staff_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Advance Details</b>
                                </h4></td>
					          </tr>
					          <tr>
					            <td>Date </td>
					            <td>:</td>
					            <td><?php echo $emp_display1["a_date"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Amount</td>
					            <td>:</td>
					            <td>Rs. <?php echo $emp_display1["a_amount"] ; ?> /-</td>
					          </tr>
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php if($emp_display1['status']=='0'){ ?>
                                <button class="btn btn-small btn-success" >Pending</button><?php }else{?><button class="btn btn-small btn-primary" >Received</button> <?php } ?></td>
					          </tr>                            
					        </tbody>
					      </table>
					        </tbody>
					      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<div id="styledModal<?php echo $emp_count.''.$a_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $emp_display["fname"]." ".$emp_display["lname"]; ?> Employee Details</h3>
      </div>
      <div class="modal-body">
      
      <center><img class="thumbnail" src="<?php echo $path.$emp_display['photo']; ?>" alt="staff photo" width="200px" height="200px;"></center>
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
                                    <b>Personal Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Title</td>
					            <td>:</td>
					            <td>Details</td>
					          </tr>
                              <tr>
					            <td>Employee ID</td>
					            <td>:</td>
					            <td><?php echo $staffid; ?></td>
					          </tr>
					          <tr>
					            <td>First Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["fname"] ; ?></td>
					          </tr>
					          <tr>
					            <td>Last Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["lname"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Father Name</td>
					            <td>:</td>
					            <td><?php if($d_id){ echo $emp_display["d_pname"]; }else{ echo $emp_display["s_pname"]; }?></td>
					          </tr>
                              <tr>
					            <td>Date Of Birth</td>
					            <td>:</td>
					            <td><?php echo $emp_display["dob"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Religion</td>
					            <td>:</td>
					            <td><?php echo $emp_display["reg"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Gender</td>
					            <td>:</td>
					            <td><?php if($emp_display['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></td>
					          </tr>
                              <tr>
					            <td>Marital Status</td>
					            <td>:</td>
					            <td><?php echo $emp_display["marriage"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Blood Group</td>
					            <td>:</td>
					            <td><?php echo $emp_display["blood"] ; ?></td>
					          </tr>
                              <?php if($st_id){?>
                              <tr>
					            <td>Staff Type</td>
					            <td>:</td>
					            <td><?php echo $emp_display["s_type"] ; ?></td>
					          </tr>
                              <?php }else if($o_id){?>
                              <tr>
					            <td>Category</td>
					            <td>:</td>
					            <td><?php echo $ocategory["category_name"]; ?></td>
					          </tr>
                              <?php }else if($d_id){?>
                              <tr>
					            <td>Driver type</td>
					            <td>:</td>
					            <td><?php echo $ocategory["d_type"]; ?></td>
					          </tr>
                              <?php } ?>
                              <tr>
					            <td>Date Of Joining</td>
					            <td>:</td>
					            <td><?php echo $emp_display["doj"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Job Type</td>
					            <td>:</td>
					            <td><?php echo $emp_display["job_type"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Designation</td>
					            <td>:</td>
					            <td><?php echo $emp_display["position"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Qualification</td>
					            <td>:</td>
					            <td><?php echo $emp_display["qualf"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Permanent Address</td>
					            <td>:</td>
					            <td><?php  if($d_id){ echo $emp_display["address"]; }else{ echo $emp_display["address1"]; } ?></td>
					          </tr>
                              <tr>
					            <td>Residential Address</td>
					            <td>:</td>
					            <td><?php echo $emp_display["address2"] ; ?></td>
					          </tr>
                              <tr>
					            <td>State</td>
					            <td>:</td>
					            <td><?php echo $emp_display["state"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Country</td>
					            <td>:</td>
					            <td><?php echo $emp_display["country"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Email ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Phone No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Land Line No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["lline"] ; ?></td>
					          </tr>
                              <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Bank Details</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Bank Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["b_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Account Number</td>
					            <td>:</td>
					            <td><?php echo $emp_display["b_acc_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>PF No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["pf_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee</td>
					            <td>:</td>
					            <td><?php echo $emp_display["nominee"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_name"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Phone No</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_phone_no"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Nominee Email ID</td>
					            <td>:</td>
					            <td><?php echo $emp_display["n_email"] ; ?></td>
					          </tr>
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php if($emp_display['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?></td>
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
include("footer.php");
include("includes/script.php");?>

</body>
</html>

 <? ob_flush(); ?>