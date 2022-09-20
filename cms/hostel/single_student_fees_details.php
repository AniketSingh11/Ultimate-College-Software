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
	   $filter=$_GET['filt'];	
	   $res=mysql_query("select * from hms_category where h_id='$filter'");
	   $row=mysql_fetch_array($res);
	   $cat_name=$row["h_name"];
	    
	   
	   ?>	
     <div id="content">		
		
		 <div id="content-header">
			 <h1>Student Hostel Fees Details </h1><?php if($filter){?><span style="float:right; margin-right:30px;"><b>Filter by : </b> <?php echo $cat_name;?></span><?php } ?>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
 <?php if($_GET["msg"] == 'delete_succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully deleted 
			</div>
<?php } ?>		

 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Room  Successfully Changed 
			</div>
<?php } ?>		
 <?php if($_GET["msg"] == 'err') { ?>	
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> <?php echo $_GET["err_msg"]; ?> 
			</div>
<?php } ?>	
<?php  $adno=$_GET["adno"];?>

<div class="row">
				 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								Student Hostel Fees  Details List 
							 </h3>
                             
							<div class="btn-group" style="float:right;">
							  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Category Type <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                                <li <?php if(!$filter){ echo 'class="active"';}?>><a href="single_student_fees_details.php">Over All</a></li>
                            <?php 
									$res=mysql_query("select * from hms_category where status='0'");
									while($row=mysql_fetch_array($res))
									{
									
									?>
										 
										<li   <?php if($_GET["filt"]==$row["h_id"]){?>class="active" <?php }?> ><a href="single_student_fees_details.php?filt=<?=$row["h_id"]?>"><?=stripslashes($row["h_name"]);?></a></li>
									 <?php } ?>
									 
									
									
						 
							  </ul>
							</div>
						 </div>  <!-- /.portlet-header -->
						 <div class="portlet-content">
						 
						 <div class="form-group">
									<label for="name" style="width: 140px;">Student ID &nbsp;&nbsp;&nbsp;&nbsp; :</label>
									<select id="student" name="student" data-required="true" class="form-control" style="width:50%">
                                    	<option value="">Plese select Student </option>
                                       <?php 
										$emp_query="select * from hms_student_room where status='0' order by admission_number asc";
										$emp_result=mysql_query($emp_query);
										while($emp_display=mysql_fetch_array($emp_result))
										{
											$student_number=$emp_display["admission_number"];

											$res=mysql_query("select * from student where admission_number='$student_number' order by ay_id desc");
											$row1=mysql_fetch_array($res);
										  
											$ss_id=$row1["ss_id"];
											?>
                                        <option value="<?php echo $student_number;?>" <?php if($s_id==$ss_id){ echo "selected"; }?>><?php echo  $row1["admission_number"]."-".$row1["firstname"]." ".$row1["lastname"]; ?></option>
                                  <?php } ?>								
                            		</select>
								</div>    
								
								<?php
								
								if($adno)
								{
								
								?>
						 
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
											<th data-sortable="true">S.No</th>
												
										       <th data-filterable="true" data-sortable="true">Student name </th>	
                                             <th data-filterable="true" data-sortable="true">Class -Section </th>	
                                              <th data-filterable="true" data-sortable="true" data-direction="asc">Hostel name</th>
										       <th data-filterable="true" data-sortable="true">Room Number / Beds&cart </th>
                                              <th data-filterable="true" data-sortable="true">Fees Type</th>	
                                              <th data-filterable="true" data-sortable="true">Total Amount  </th>										 
											 <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										
										if($filter!="" && $adno!=""){
											$emp_query="select * from  hms_student_room  where category='$filter' and admission_number='$adno' and  status='0' order by date_time desc";
										}else{
											$emp_query="select * from hms_student_room  where status='0' and admission_number='$adno' order by date_time desc";
										}
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		while($emp_display=mysql_fetch_array($emp_result))
		{
			$hsr_id=$emp_display["hsr_id"];
			$hr_id=$emp_display["hr_id"];
			$hrc_id=$emp_display["hrc_id"];
			$r_ay_id=$emp_display["r_ay_id"];
			$reg_class=$emp_display["reg_class"];
			
		   
			$join_date=$emp_display["join_date"];	
            
            $student_number=$emp_display["admission_number"];
            $firstname=$emp_display["firstname"];
           
            
            $res=mysql_query("select * from student where admission_number='$student_number' order by ay_id desc");
            $row1=mysql_fetch_array($res);
            $c_id=$row1["c_id"];	
		    $s_id=$row1["s_id"];
		    $student_id=$row1["ss_id"];
		    
		    
		    $query=mysql_query("SELECT * FROM class where c_id='$c_id'");
			$res=mysql_fetch_array($query);
			$class_name=$res["c_name"];
			 
			$query=mysql_query("SELECT * FROM section where s_id='$s_id'");
			$res=mysql_fetch_array($query);
			$section_name=$res["s_name"];
			
			
			$res=mysql_query("select * from hms_category where h_id='$emp_display[category]'");
			$row=mysql_fetch_array($res);
			$cat_name=$row["h_name"];
			
			$res=mysql_query("select * from hms_room where hr_id='$hr_id'");
			$row=mysql_fetch_array($res);
			$room_number=$row["room_number"];
			$room_type=$row["room_type"];
			
			
			$res=mysql_query("select * from hms_room_cart where hrc_id='$hrc_id'");
			$row=mysql_fetch_array($res);
			$cart_name=$row["cart_name"];
			
		if($r_ay_id==$acyear)
			{
			    $feetypes="Register Fees";
			    $res=mysql_query("select * from hms_fees_structure where section='$reg_class' and ay_id='$acyear'");
			    $row=mysql_fetch_array($res);
			    $hfs_id=$row["hfs_id"];
			    
		        $res=mysql_query("select * from hms_feestype where 	hfs_id='$hfs_id' and room_type='$room_type'");
			    $row=mysql_fetch_array($res);
			    $amount=$row["amount"];
			    
			    $query=mysql_query("SELECT * FROM hms_cash_deposit where ay_id='$r_ay_id'");
			    $res=mysql_fetch_array($query);
			    $amount=$res["amount"]+$amount;
			    

			}else{
			    
			    $feetypes="Renew Fees";
			    $res=mysql_query("select * from hms_fees_structure where section='$c_id' and ay_id='$acyear'");
			    $row=mysql_fetch_array($res);
			    $hfs_id=$row["hfs_id"];
			    	
			    $res=mysql_query("select * from hms_feestype where 	hfs_id='$hfs_id' and room_type='$room_type'");
			    $row=mysql_fetch_array($res);
			    $amount=$row["amount"];
			    
			}
			
			
			$qry1=mysql_query("select * from hms_hinvoice where admission_no='$student_number' and ay_id='$acyear' and fees_type in ('Renew Fees','Register Fees') ");
			$res1=mysql_fetch_array($qry1);
			$hin_id=$res1["hin_id"];
			$h_total=$res1["h_total"];
			
		?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
											 <td><?php echo $student_number."-".$firstname; ?></td>
                                            
                                             <td><?php echo $class_name."-".$section_name; ?></td>
											 <td><?php echo $cat_name ;?> </td>
                                             <td><?php echo $room_number." - ".$cart_name; ?></td>
                                           
                                             
                                             <td><?php echo $feetypes;?></td>
                                            
                                <?php if(mysql_num_rows($qry1)==0){ ?> 
                                 <td><?php echo $amount; ?> </td>      								 
					 <td><a href="invoice_fees.php?id=<?=$student_id?>&fees_type=<?=$feetypes?>" class="btn btn-info" type="button" <button>Pay</a> </td>
					 <?php }else{?>
					  <td><?php echo $h_total; ?> </td>
					 <td><a   href="view_invoice.php?id=<?=$hin_id?>&sid=<?=$student_id?>" class="btn btn-success" type="button" <button>Paid</a> </td>
					 <?php }?>
										 </tr>
		<?php 
        
		$emp_count++;
		
		
		
		$qry1=mysql_query("select * from hms_student_changeroom  where  admission_number='$student_number' and ay_id='$acyear' and hsr_id='$hsr_id' and payment_type='0'") or die(mysql_error());
		while($res1=mysql_fetch_array($qry1))
		{
		    
		   
		    $res=mysql_query("select * from hms_category where h_id='$res1[category]'");
		    $row=mysql_fetch_array($res);
		    $cat_name=$row["h_name"];
		
		    $res=mysql_query("select * from hms_room where hr_id='$res1[hr_id]'");
		    $row=mysql_fetch_array($res);
		    $room_number=$row["room_number"];
		    $room_type=$row["room_type"];
		
		
		    $res=mysql_query("select * from hms_room_cart where hrc_id='$res1[hrc_id]'");
		    $row=mysql_fetch_array($res);
		    $cart_name=$row["cart_name"];
		    
		    
		    $qry2=mysql_query("select * from  hms_hinvoice_sumarry  where hsr_id='$hsr_id' and  hr_id='$res1[hr_id]' and hrc_id='$res1[hrc_id]'  and ay_id='$acyear' and fees_type in ('Changeroom Fees') ");
		    $res2=mysql_fetch_array($qry2);
		    $hin_id=$res2["hin_id"];
		    $h_total=$res2["amount"];
		     
		    ?>
					    										 <tr>
					    											 <td><?php echo $emp_count ;?> </td>
					    											  <td><?php echo $student_number."-".$firstname; ?></td>
					                                                
					                                                 <td><?php echo $class_name."-".$section_name; ?></td>
					    											 <td><?php echo $cat_name ;?> </td>
					                                                 <td><?php echo $room_number." - ".$cart_name; ?></td>
					                                               
					                                                
					                                                 <td><?php echo "Changeroom Fees";?></td>
					                                                <?php if(mysql_num_rows($qry2)==0){ ?> 
                                
					                                                 <td><?php echo $res1["amount"]; ?> </td>
					                                             								 
					    					 <td><a href="invoice_fees.php?id=<?=$student_id?>&fees_type=Changeroom Fees" class="btn btn-info" type="button" <button>Pay</a> </td>
					    					 <?php }else{
					    					   ?>
					    					     <td><?php echo $h_total; ?> </td>
					    					      <td><a   href="view_invoice.php?id=<?=$hin_id?>&sid=<?=$student_id?>" class="btn btn-success" type="button" <button>Paid</a> </td>
					    					     
					    					   <?php }?>
					    					 
					    										 </tr>
					    		<?php 
					            
					    		$emp_count++;
					    
					    
					}
		
        }
        
        ?>							
									</tbody>
								</table>
				</div>  <!-- /.table-responsive -->
				<?php }?>
						 </div>  <!-- /.portlet-content -->
					 </div>  <!-- /.portlet -->
				 </div>  <!-- /.col -->
			 </div>  <!-- /.row -->
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->

				
<?php
include("footer.php");
?>
<?php include("includes/script.php");?>
<script type="text/javascript">

$('#student').select2 ({
		allowClear: true,
		placeholder: "Select..."
	}).on('change', function (e) {

	var s=$('#student').val();
	
	if(s!=""){
		window.location.href='single_student_fees_details.php?adno='+s+"&filt=<?=$_GET["filt"]?>";
		
	}
	})
	$('#student').select2('val','<?=$adno?>');
</script>
</body>
</html>

 <? ob_flush(); ?>