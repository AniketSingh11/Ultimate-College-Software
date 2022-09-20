<?php
include("header.php");
$sdid=$_GET["id"];
$emp_query="select m_year from staff_deduction where sd_id='$sdid'";
		$emp_result=mysql_query($emp_query);
		$employee=mysql_fetch_array($emp_result);
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
			 <h1><?=$employee['m_year']?> Deduction detail <a href="common_deduction.php?syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
 <?php if($_GET["msg"] == 'dsucc') { ?>		
<div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Your Record Successfully Deleted !!!
			</div>
<?php }
?>		 <div class="row">
			 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								<?=$employee['m_year']?> Deduction detail
							 </h3>
                             <a href="deduction_detail_add.php?sdid=<?=$sdid?>" title="Add Detail"><button type="button" class="btn btn-warning">Add Detail</button></a>                           </div>  <!-- /.portlet-header -->
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
											<th data-sortable="true" width="7%">S.No</th>
											 <th data-filterable="true" data-sortable="true"><center>Title</center></th>
											 <th data-filterable="true" data-sortable="true" width="20%">Amount for Each</th>
                                             <th data-filterable="true" data-sortable="true" width="10%">Type</th>
                                              <th data-filterable="true" data-sortable="true" width="12%">Applied For</th>
                                             <th data-filterable="false" data-sortable="false" width="10%">Status</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm" width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
											$emp_query="select id,status,title,amount,type,a_for from staff_ded_detail WHERE sd_id='$sdid' order by id DESC";										
					$emp_result=mysql_query($emp_query);
					$emp_count=1;
					while($emp_display=mysql_fetch_array($emp_result))
					{
						$id=$emp_display["id"];	
						$status=$emp_display["status"];
						$type=$emp_display["type"];	
						$afor=$emp_display["a_for"];
					?>                             
										 <tr>
											 <td><?php echo $emp_count ;?> </td>
                                             <td><center><?php echo $emp_display["title"]; ?></center></td>
                                             <td><center>Rs <?php echo $emp_display["amount"]; ?> /-</center> </td>
                                             <td><?php if($type=='C'){ echo "Common"; }else if($type=='M'){ echo "Men"; }else if($type=='W'){ echo "Women"; }?></td>
                                             <td><?php if($afor=='1'){ echo "Staff"; }else if($afor=='2'){ echo "Other Staff"; }else if($afor=='3'){ echo "Driver"; }else{ echo "All Employee";}?></td>
                                             <td><?php if($status=='0'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                			 </td>  	
                                             <td><a title="edit" href="deduction_detail_edit.php?id=<?php echo $id."&sdid=".$sdid; ?>"><img src="img/layout/edit.png"/></a> <a title="delete" href="deduction_detail_delete.php?id=<?php echo $id."&sdid=".$sdid; ?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a> </td>
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
include("footer.php");
include("includes/script.php");?>
</body>
</html>
 <? ob_flush(); ?>