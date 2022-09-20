<?php
include("header.php");
include_once("amount_in_word.php");
$month=date("M");
$year=date("Y");
$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May"); 

$syear=$_GET['syear'];
$eyear=$_GET['eyear'];

if($m_value>5){
	$y_value=$syear;
}else if($m_value<=5){
	$y_value=$eyear;
}
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
		/*$stid=$_GET['id'];
$query=mysql_query("select * from staff where st_id='$stid'");
$staffs=mysql_fetch_array($query);*/
?>
		 <div id="content-header">
			 <h1> <?php echo $syear." - ".$eyear;?> Common Deduction </h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
         <?php if($_GET["msg"] == 'dsucc') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully deleted 
			</div>
<?php } ?>
 			 <div class="row">
				 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
							 <h3>
								<?php echo $syear." - ".$eyear;?> Common Deduction List 
							 </h3>
                             <a href="common_deduction_add.php" title="Add deduction"><button type="button" class="btn btn-warning">Add New</button></a>           
                             <!--<a href="common_deduction_down.php?<?php //echo "syear=".$syear."&eyear=".$eyear."&acid=".$acyear;?>" title="Download Report"><button type="button" class="btn btn-success">Download Report</button></a>      -->            
                             <div class="btn-group" style="float:right; padding-right:5%">
                              <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							    Year <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
                              <?php 
							  $yearstring=$syear."-".$eyear;
							  $qry=mysql_query("SELECT s_year,e_year,y_name FROM year ORDER BY ay_id DESC");
							  while($row=mysql_fetch_array($qry))
								{
									$syear1=$row['s_year'];
									$eyaer1=$row['e_year'];?>
                                  <li <?php if($row['y_name']==$yearstring){ echo 'class="active"';}?>><a href="common_deduction.php?syear=<?php echo $syear1."&eyear=".$eyaer1;?>"><?php echo $row['y_name'];?></a></li>
                                  <?php } ?>                             		
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
                                         	<th data-sortable="true" width="7%">S.No</th>
											 <th data-sortable="true" width="15%">Month-Year</th>
                                             <th data-sortable="true"><center>Deduction Name</center></th>										 
											 <th data-filterable="false" width="12%">Status</th>
                                             <th data-filterable="false" width="12%">Details</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm" width="12%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
							$emp_query="select m_year,name,sd_id,status from staff_deduction where (year=$syear AND month>'5') OR (year=$eyear AND month<='5') order by sd_id desc";										
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{		
							$sd_id=$emp_display["sd_id"];
							$status=$emp_display["status"];			
							?>                             
										 <tr>
											 <td><?php echo $emp_count;?> </td>
                                             <td><?php echo $emp_display["m_year"]; ?> </td>
                                             <td><center><?php echo $emp_display["name"]; ?> </center></td>
                                             <td><?php if($status==0){ ?><button type="button" class="btn btn-success">Enable</button><?php } else{ ?><button type="button" class="btn btn-danger">disable</button> <?php } ?></td>	
                                             <td><a href="deduction_detail.php?id=<?php echo $sd_id;?>"<button type="button" class="btn btn-secondary">View</button></a></td>
                                             <td><a title="view" href="#styledModal<?php echo $emp_count.''.$sd_id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="edit" href="common_deduction_edit.php?id=<?php echo $sd_id; ?>"><img src="img/layout/edit.png"/></a>
											 <?php if($_SESSION['admin_type']=="0" || in_array("common_deduction.php", $permissions_record_delete) ){ ?>
												<a title="delete" href="common_deduction_delete.php?id=<?php echo $sd_id."&syear=".$syear."&eyear=".$eyear;?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a>
											<?php } ?>
                                              </td>
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
 $emp_query="select m_year,name,sd_id,status from staff_deduction where (year=$syear AND month>'5') OR (year=$eyear AND month<='5') order by sd_id desc";										
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{		
							$sd_id=$emp_display["sd_id"];	
							?>
 <div id="styledModal<?php echo $emp_count.''.$sd_id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $emp_display["m_year"]; ?> - Common Deduction</h3>
      </div>
      <div class="modal-body">
        		<table class="table">
					        <tbody>
                            <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b><?php echo $emp_display["m_year"]; ?> - Common Deduction</b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Month - Year</td>
					            <td>:</td>
					            <td>Details</td>
					          </tr>
                              <tr>
					            <td>Deduction Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["m_year"]; ?></td>
					          </tr>
                              <tr>
					            <td>Status</td>
					            <td>:</td>
					            <td><?php if($emp_display['status']=='0'){ ?>
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
<?php } ?>
<?php
include("footer.php");
include("includes/script.php");?>
</body>
</html>
 <? ob_flush(); ?>