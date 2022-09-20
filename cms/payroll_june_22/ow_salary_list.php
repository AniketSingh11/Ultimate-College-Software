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
		<?php
		$oid=$_GET['id'];
$query=mysql_query("select * from others where o_id='$oid'");
$staffs=mysql_fetch_array($query);
?>
		 <div id="content-header">
			 <h1> <?php echo $staffs['fname']." ".$staffs['lname'];?> - Salary Details <a href="ow_list.php"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	


		 <div id="content-container">

 <?php if($_GET["msg"] == 'succ') { ?>		
<div class="pane">
<div class="msg_system"><img src="img/layout/ico-done.gif" class="icon_mark"/> Your Record Successfully Edited </div>	
<img src="img/layout/ico-delete.gif" alt="delete" class="delete" />
</div>
<?php } ?>

 <?php if($_GET["msg"] == 'delete_succ') { ?>		
<div class="pane">
<div class="msg_system"><img src="img/layout/ico-done.gif" class="icon_mark"/> Your Record Successfully Deleted </div>	
<img src="img/layout/ico-delete.gif" alt="delete" class="delete" />
</div>
<?php } ?>

 <?php if($_GET["msg"] == 'err') { ?>		
<div class="pane">
<div class="msg_system"><img src="img/layout/ico-done.gif" class="icon_mark"/> Query Failed </div>	
<img src="img/layout/ico-delete.gif" alt="delete" class="delete" />
</div>
<?php } 
?>

			 <div class="row">

				 <div class="col-md-12">

					 <div class="portlet">

						 <div class="portlet-header">

							 <h3>
								<?php echo $staffs['fname']." ".$staffs['lname'];?> - Salary Details List 
							 </h3>
                             <a href="ow_salary_add.php?id=<?php echo $oid;?>" title="Add Employee Salary"><button type="button" class="btn btn-warning">Add Employee Salary</button></a>
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
											 <th data-sortable="true">Salary</th>
                                             <th>Allowance </th>											 
											 <th class="hidden-xs hidden-sm">Deduction </th>
											 <th data-sortable="true">Date</th>
                                             <th data-sortable="true">Status</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
											$emp_query="select * from staff_salary where o_id=$oid order by id desc";										
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{
								$emp_id=$emp_display["id"];	
								$allowance = explode( ',', $emp_display["allowance"]);	
								$deduction = explode( ',', $emp_display["deduction"]);	
								/*foreach ($id_nums as $id) {
									echo $id."<br>";
								}*/
		?>                             
										 <tr>
											 <td><?php echo $emp_count;?> </td>
                                             <td><?php echo $emp_display["salary"]; ?> </td>
                                             <td><?php foreach ($allowance as $id) {
												 $allowlist=mysql_query("select * from staff_allw_ded where id='$id'");
												 $allow=mysql_fetch_array($allowlist);
												 ?>
                                                 <button type="button" class="btn btn-info btn-xs"><?php echo $allow['name'];?></button>
										<?php } ?> 
                                             </td>
                                             <td><?php foreach ($deduction as $id) {
												 $allowlist=mysql_query("select * from staff_allw_ded where id='$id'");
												 $allow=mysql_fetch_array($allowlist);
												 ?>
                                                 <button type="button" class="btn btn-primary btn-xs"><?php echo $allow['name'];?></button>
										<?php } ?> </td>
                                             <td><?php echo $emp_display["date"]; ?> </td>
                                             <td><?php if($emp_display['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                			 </td>                    								 
											 <td><a title="view" href="#styledModal<?php echo $emp_count.''.$emp_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a><a title="edit" href="ow_salary_edit.php?id=<?php echo $emp_id; ?>&oid=<?php echo $oid; ?>"><img src="img/layout/edit.png"/></a> <a title="delete" href="ow_salary_delete.php?id=<?php echo $emp_id; ?>&oid=<?php echo $oid; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> </td>
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
					$emp_query="select * from staff_salary where o_id=$oid order by id desc";										
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{
								$emp_id=$emp_display["id"];	
								$allowance = explode( ',', $emp_display["allowance"]);	
								$deduction = explode( ',', $emp_display["deduction"]);		
		?>  
<div id="styledModal<?php echo $emp_count.''.$emp_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $staffs['fname']." ".$staffs['lname'];?> - Salary Details</h3>
      </div>
      <div class="modal-body">
        <table class="table">
					        <tbody>
                            <tr>
					            <td colspan="3"><center><h4 class="heading1"><button type="button" class="btn btn-secondary">Rs/- <b><?php echo $emp_display["salary"] ; ?></b></button></h4></center></td>
					          </tr>
                            <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Allowance</b>
                                </h4></td>
					          </tr>
                                <?php
								$emp_query2="select * from staff_allw_ded where type='Allowance' and basic='0'";
										$emp_result2=mysql_query($emp_query2);
										while($emp_display2=mysql_fetch_array($emp_result2))
										{
										$emp_id2=$emp_display2["id"];	
												foreach ($allowance as $id) {
													if($emp_id2==$id){
														$tallow +=$emp_display2["per_cent"];
													}
												}
										}
										//echo $tallow;
										$basic=100-$tallow;										
										
										
										$emp_query1="select * from staff_allw_ded where type='Allowance' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										$emp_id1=$emp_display1["id"];
										if($emp_display1["basic"]=='1'){
											$percent=$basic;
										}else{
											$percent=$emp_display1["per_cent"];
										}
										foreach ($allowance as $id) {
													if($emp_id1==$id){
														$deduc=1;
														
										?>
                                      <tr>
                                        <td><?php echo $emp_display1["name"];?> </td>
                                        <td>:</td>
                                        <td><div class="progress progress-striped active">
                                          <div class="progress-bar progress-bar-success btn-success" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%;">
                                            <span class="sr-only"> <?php echo $percent; ?>% Complete</span>
                                          </div> <?php echo $percent; ?> % 
                                        </div>
                                        </td>
                                     </tr>
                                    <?php 
														}
													}
                                    $emp_count1++;
                                    }
                                    ?>
                              <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b>Deductions</b>
                                </h4></td>
					          </tr>
                                <?php
										$emp_query1="select * from staff_allw_ded where type='Deductions' order by id asc";
										$emp_result1=mysql_query($emp_query1);
										$emp_count1=1;
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
										$emp_id1=$emp_display1["id"];
										foreach ($deduction as $id) {
													if($emp_id1==$id){
														$deduc=1;
														
										?>
                                      <tr>
                                        <td><?php echo $emp_display1["name"];?> </td>
                                        <td>:</td>
                                        <td><div class="progress progress-striped active">
                                          <div class="progress-bar progress-bar-primary btn-warning" role="progressbar" aria-valuenow="<?php echo $emp_display1["per_cent"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $emp_display1["per_cent"]; ?>%;">
                                            <span class="sr-only"> <?php echo $emp_display1["per_cent"]; ?>% Complete</span>
                                          </div> <?php echo $emp_display1["per_cent"]; ?> % 
                                        </div>
                                        </td>
                                     </tr>
                                    <?php 
														}
													}
                                    $emp_count1++;
                                    }
                                    ?>      
                              <tr>
					            <td>date</td>
					            <td>:</td>
					            <td><?php echo $emp_display["date"] ; ?></td>
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
        
        ?>	
        
<?php
include("footer.php");
?>
<?php include("includes/script.php");?>
</body>
</html>
 <? ob_flush(); ?>