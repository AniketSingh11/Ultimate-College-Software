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
	$emp_result2=mysql_query("select ay_id from year where s_year='$syear' AND e_year='$eyear'");
		$accc=mysql_fetch_assoc($emp_result2);
		$ayid1=$accc['ay_id'];
?>
		 <div id="content-header">
			 <h1> <?php echo $syear." - ".$eyear;?> Management Contribution </h1>
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
								<?php echo $syear." - ".$eyear;?> Management Contribution 
							 </h3>
                             <a href="mcontribution_add.php<?php echo "?syear=".$syear."&eyear=".$eyear;?>" title="Add deduction"><button type="button" class="btn btn-warning">Add New</button></a>           
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
                                  <li <?php if($row['y_name']==$yearstring){ echo 'class="active"';}?>><a href="mcontribution.php?syear=<?php echo $syear1."&eyear=".$eyaer1;?>"><?php echo $row['y_name'];?></a></li>
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
											 <th data-sortable="true"><center>Deduction Name</center></th>										 
											 <th data-sortable="true" width="15%">Percentage</th>
                                             <th data-filterable="false" class="hidden-xs hidden-sm" width="12%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php	
							$emp_query="select id,per_cent,ad_id,name from staff_mcontribution where ay_id=$ayid1";										
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{		
								$id=$emp_display["id"];		
							?>                             
										 <tr>
											 <td><?php echo $emp_count;?> </td>
                                             <td><b><center><?php echo $emp_display["name"]; ?> </center></b></td>
                                             <td><?php echo $emp_display["per_cent"]." %"; ?></td>	
                                             <td><a title="view" href="#styledModal<?php echo $emp_count.''.$id;?>" data-toggle="modal"><img src="img/layout/view.png"/></a> <a title="edit" href="mcontribution_edit.php?id=<?php echo $id."&syear=".$syear."&eyear=".$eyear;?>"><img src="img/layout/edit.png"/></a>
                                             <?php if($_SESSION['admin_type']=="0" || in_array("mcontribution.php", $permissions_record_delete) ){ ?>
												<a title="delete" href="mcontribution_delete.php?id=<?php echo $id."&syear=".$syear."&eyear=".$eyear;?>" onClick="return confirm('are you sure you wish to delete this record');"><img src="img/layout/delete.png"/></a>
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
 $emp_query="select id,per_cent,ad_id,name from staff_mcontribution where ay_id=$ayid1";										
							$emp_result=mysql_query($emp_query);
							$emp_count=1;
							while($emp_display=mysql_fetch_array($emp_result))
							{		
							$id=$emp_display["id"];	
							?>
 <div id="styledModal<?php echo $emp_count.''.$id;?>" class="modal modal-styled fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?php echo $syear." - ".$eyear;?> Management Contribution </h3>
      </div>
      <div class="modal-body">
        		<table class="table">
					        <tbody>
                            <tr>
					            <td colspan="3"><h4 class="heading1">
                                    <b><?php echo $syear." - ".$eyear;?> Management Contribution </b>
                                </h4></td>
					          </tr>
                              <tr>
					            <td>Title</td>
					            <td>:</td>
					            <td>Details</td>
					          </tr>
                              <tr>
					            <td>Deduction Name</td>
					            <td>:</td>
					            <td><?php echo $emp_display["name"]; ?></td>
					          </tr>
                              <tr>
					            <td>Percentage</td>
					            <td>:</td>
					            <td><?php echo $emp_display["per_cent"]." %"; ?></td>
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
<?php $emp_count++;} ?>
<?php
include("footer.php");
include("includes/script.php");?>
</body>
</html>
 <? ob_flush(); ?>