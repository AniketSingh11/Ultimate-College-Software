<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 ?>
</head>

<body id="top">

  <!-- Begin of #container -->
  <div id="container">
  	<!-- Begin of #header -->
    <?php include("includes/header.php");?>
    <!--! end of #header -->
    
    <div class="fix-shadow-bottom-height"></div>
	
	<!-- Begin of Sidebar -->
    <aside id="sidebar">
    	
    	<!-- Search -->
    	    	<?php include("includes/search.php"); ?>
 <!--! end of #search-bar -->
		
		<!-- Begin of #login-details -->
		<?php include("includes/login-details.php");?>
         <!--! end of #login-details -->
    	
    	<!-- Begin of Navigation -->
    	<?php include("nav.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    	
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
				<li class="no-hover">Circular Management</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Circular Management</h1>
                <a href="circular_add.php" title="add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Circular Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
            <div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Circular Management</h1>
						<ul class="tabs" style="margin-right:60px;">
							<li><a href="#tab-1">All Circular</a></li>
							<li><a href="#tab-2">Staff Circular</a></li>
                            <li><a href="#tab-3">Student Circular</a></li>
							<li><a href="#tab-4">Parent Circular</a></li>
                            <li><a href="#tab-5">Specific Standard Circular</a></li>
						</ul>
                        <span></span>
					</div>
					<div class="block-content tab-container">
						<div id="tab-1" class="tab-content">
							<br>
							<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
									 <th>Ref No</th>
                                    <th>Published Date</th>
                                    <th><center>Title</center></th>
                                    <th><center>Description</center></th>
                                    <th>Type</th>
                                    <th>Board</th>
                                    <th width="80px;">Circular File</th>
                                    <th>Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM circular WHERE ay_id=$acyear ORDER BY cl_id DESC");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
								$bid=$row['b_id'];
								  $boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  $cid=$row['c_id'];
								  if(!$cid){?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								 <td><center><?php echo $row['ref_number']; ?></center></td>
								<td><center><?php echo $row['cl_day']."-".$row['cl_month']."-".$row['cl_year']; ?></center></td>
                                <td><center><?php echo $row['title']; ?></center></td>
                                <td><center><?php echo substr(strip_tags($row['descript']),0,20);  ?></center></td>
                                <td><center><?php echo $row['type']; ?></center></td>
                                <td><center><?php if($board['b_name']){ echo $board['b_name'];} else { echo "All";} ?></center></td>
                                <td><?php if($row['file']){?><center><a href="circular/<?php echo $row['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a></center><?php } ?></td>
                                <td><center><?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
                                <td width="100px">
                                <a href="javascript:void(0);" onclick="$('#info-dialog1<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="circular_edit.php?clid=<?php echo $row['cl_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="circular_delete.php?clid=<?php echo $row['cl_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete">
                                 </a><a href="circular_prt.php?clid=<?php echo $row['cl_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog1<?php echo $count;?>" title="Circular Details" style="display: none;">
                                
				<p>Published date : <strong><?php echo $row['cl_day']."-".$row['cl_month']."-".$row['cl_year']; ?></strong></p>
                
                 <p>Title : <strong><?php echo $row['title']; ?></strong></p> 
                
                <p>Description : <strong><?php echo substr(strip_tags($row['descript']),0,20); ?></strong>  </p>   
                
                <p>Circular Type: <strong><?php echo $row['type']; ?></strong>  </p>
                
                <p>Board: <strong><?php if($board['b_name']){ echo $board['b_name'];} else { echo "All";} ?></strong>  </p>
                
                <p>Circular file: <?php if($row['file']){?><a href="circular/<?php echo $row['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a><?php } ?></p>   
                
                <center> <?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
                </div>
                                 <?php 
							$count++; }
							} ?>                               																
							</tbody>
						</table>
                        <br>
						</div>
						<div id="tab-2" class="tab-content">
                        <br>
							<table id="table-example1" class="table">
							<thead>
								<tr>
									<th>S.No</th>
									 <th>Ref No</th>
                                    <th>Published Date</th>
                                    <th><center>Title</center></th>
                                    <th><center>Description</center></th>
                                    <th>Type</th>
                                    <th>Board</th>
                                    <th>Circular File</th>
                                    <th>Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry1=mysql_query("SELECT * FROM circular WHERE type='Staff' AND ay_id=$acyear ORDER BY cl_id DESC");
							$count11=1;
			  while($row1=mysql_fetch_array($qry1))
        		{ 
				
						$bid1=$row1['b_id'];
								  $boardlist1=mysql_query("SELECT * FROM board WHERE b_id=$bid1"); 
								  $board1=mysql_fetch_array($boardlist1);?>
								<tr class="gradeX">
                                <td class="sno center"><center><?php echo $count11; ?></center></td>
                                 <td><center><?php echo $row1['ref_number']; ?></center></td>
								<td><center><?php echo $row1['cl_day']."-".$row1['cl_month']."-".$row1['cl_year']; ?></center></td>
                                <td><center><?php echo $row1['title']; ?></center></td>
                                <td><center><?php echo substr(strip_tags($row1['descript']),0,20); ?></center></td>
                                <td><center><?php echo $row1['type']; ?></center></td>
                                <td><center><?php if($board1['b_name']){ echo $board1['b_name'];} else { echo "All";} ?></center></td>
                                <td><?php if($row['file']){?><center><a href="circular/<?php echo $row1['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a></center><?php } ?></td>
                                <td><center><?php if($row1['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
                                <td width="100px">
                                <a href="javascript:void(0);" onclick="$('#info-dialog11<?php echo $count11;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="circular_edit.php?clid=<?php echo $row1['cl_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="circular_delete.php?clid=<?php echo $row1['cl_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="circular_prt.php?clid=<?php echo $row1['cl_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a></td>
								</tr> 
                                <div id="info-dialog11<?php echo $count11;?>" title="Circular Details" style="display: none;">
                                
				<p>Published date : <strong><?php echo $row1['cl_day']."-".$row1['cl_month']."-".$row1['cl_year']; ?></strong></p>
                
                 <p>Title : <strong><?php echo $row1['title']; ?></strong></p> 
                
                <p>Description : <strong><?php echo substr(strip_tags($row1['descript']),0,20);?></strong>  </p>   
                
                <p>Circular Type: <strong><?php echo $row1['type']; ?></strong>  </p>
                
                <p>Board: <strong><?php if($board1['b_name']){ echo $board1['b_name'];} else { echo "All";} ?></strong>  </p>
                
                <p>Circular file: <?php if($row1['file']){?><a href="circular/<?php echo $row1['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a><?php } ?></p>   
                
                <center> <?php if($row1['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
                </div>
                                 <?php 
							$count11++;
							} ?>                               																
							</tbody>
						</table>
                        <br>
						</div>	
                        <div id="tab-3" class="tab-content">
                        <br>
							<table id="table-example2" class="table">
							<thead>
								<tr>
									<th>S.No</th>
									 <th>Ref No</th>
                                    <th>Published Date</th>
                                    <th><center>Title</center></th>
                                    <th><center>Description</center></th>
                                    <th>Type</th>
                                    <th>Board</th>
                                    <th>Circular File</th>
                                    <th>Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry2=mysql_query("SELECT * FROM circular WHERE type='Student' AND ay_id=$acyear ORDER BY cl_id DESC");
							$count12=1;
			  while($row2=mysql_fetch_array($qry2))
        		{ 
				
						$bid2=$row2['b_id'];
								  $boardlist2=mysql_query("SELECT * FROM board WHERE b_id=$bid2"); 
								  $board2=mysql_fetch_array($boardlist2);
								  $cid=$row2['c_id'];
								  if(!$cid){?>
								<tr class="gradeX">
                                <td class="sno center"><center><?php echo $count12; ?></center></td>
                                 <td><center><?php echo $row2['ref_number']; ?></center></td>
								<td><center><?php echo $row2['cl_day']."-".$row2['cl_month']."-".$row2['cl_year']; ?></center></td>
                                <td><center><?php echo $row2['title']; ?></center></td>
                                <td><center><?php  echo substr(strip_tags($row2['descript']),0,20);  ?></center></td>
                                <td><center><?php echo $row2['type']; ?></center></td>
                                <td><center><?php if($board2['b_name']){ echo $board2['b_name'];} else { echo "All";} ?></center></td>
                                <td><?php if($row['file']){?><center><a href="circular/<?php echo $row2['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a></center><?php } ?></td>
                                <td><center><?php if($row2['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
                                <td width="100px">
                                <a href="javascript:void(0);" onclick="$('#info-dialog12<?php echo $count12;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="circular_edit.php?clid=<?php echo $row2['cl_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="circular_delete.php?clid=<?php echo $row2['cl_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="circular_prt.php?clid=<?php echo $row2['cl_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a></td>
								</tr> 
                                <div id="info-dialog12<?php echo $count12;?>" title="Circular Details" style="display: none;">
                                
				<p>Published date : <strong><?php echo $row2['cl_day']."-".$row2['cl_month']."-".$row2['cl_year']; ?></strong></p>
                
                 <p>Title : <strong><?php echo $row2['title']; ?></strong></p> 
                
                <p>Description : <strong><?php echo substr(strip_tags($row2['descript']),0,20); ?></strong>  </p>   
                
                <p>Circular Type: <strong><?php echo $row2['type']; ?></strong>  </p>
                
                <p>Board: <strong><?php if($board2['b_name']){ echo $board2['b_name'];} else { echo "All";} ?></strong>  </p>
                
                <p>Circular file: <?php if($row2['file']){?><a href="circular/<?php echo $row2['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a><?php } ?></p>   
                
                <center> <?php if($row2['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
                </div>
                                 <?php 
							$count12++; }
							} ?>                               																
							</tbody>
						</table>
                        <br>
						</div>
                        <div id="tab-4" class="tab-content">
                        <br>
							<table id="table-example3" class="table">
							<thead>
								<tr>
									<th>S.No</th>
									 <th>Ref No</th>
                                    <th>Published Date</th>
                                    <th><center>Title</center></th>
                                    <th><center>Description</center></th>
                                    <th>Type</th>
                                    <th>Board</th>
                                    <th>Circular File</th>
                                    <th>Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry3=mysql_query("SELECT * FROM circular WHERE type='Parent' AND ay_id=$acyear ORDER BY cl_id DESC");
							$count13=1;
			  while($row3=mysql_fetch_array($qry3))
        		{ 
							$bid3=$row3['b_id'];
								  $boardlist3=mysql_query("SELECT * FROM board WHERE b_id=$bid3"); 
								  $board3=mysql_fetch_array($boardlist3);?>
								<tr class="gradeX">
                                <td class="sno center"><center><?php echo $count13; ?></center></td>
                                 <td><center><?php echo $row3['ref_number']; ?></center></td>
								<td><center><?php echo $row3['cl_day']."-".$row3['cl_month']."-".$row3['cl_year']; ?></center></td>
                                <td><center><?php echo $row3['title']; ?></center></td>
                                <td><center><?php echo substr(strip_tags($row3['descript']),0,20); ?></center></td>
                                <td><center><?php echo $row3['type']; ?></center></td>
                                <td><center><?php if($board3['b_name']){ echo $board3['b_name'];} else { echo "All";} ?></center></td>
                                <td><?php if($row3['file']){?>
                                <center><a href="circular/<?php echo $row3['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a></center> <?php } ?></td>
                                <td><center><?php if($row3['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
                                <td width="100px">
                                <a href="javascript:void(0);" onclick="$('#info-dialog13<?php echo $count13;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="circular_edit.php?clid=<?php echo $row3['cl_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="circular_delete.php?clid=<?php echo $row3['cl_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="circular_prt.php?clid=<?php echo $row3['cl_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a></td>
								</tr> 
                                <div id="info-dialog13<?php echo $count13;?>" title="Circular Details" style="display: none;">
                                
				<p>Published date : <strong><?php echo $row3['cl_day']."-".$row3['cl_month']."-".$row3['cl_year']; ?></strong></p>
                
                 <p>Title : <strong><?php echo $row3['title']; ?></strong></p> 
                
                <p>Description : <strong><?php echo substr(strip_tags($row3['descript']),0,20); ?></strong>  </p>   
                
                <p>Circular Type: <strong><?php echo $row3['type']; ?></strong>  </p>
                
                <p>Board: <strong><?php if($board3['b_name']){ echo $board3['b_name'];} else { echo "All";} ?></strong>  </p>
                
                <p>Circular file: <?php if($row3['file']){?><a href="circular/<?php echo $row3['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a><?php } ?></p>   
                
                <center> <?php if($row3['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
                </div>
                                 <?php 
							$count13++;
							} ?>                               																
							</tbody>
						</table>
                        <br>
						</div>	
                        <div id="tab-5" class="tab-content">
							<br>
							<table id="table-example4" class="table">
							<thead>
								<tr>
									<th>S.No</th>
									 <th>Ref No</th>
                                    <th>Published Date</th>
                                    <th><center>Title</center></th>
                                    <th><center>Description</center></th>
                                    <th>Board</th>
                                     <th>Class/Section</th>
                                    <th width="80px;">Circular File</th>
                                    <th>Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM circular WHERE type='Student' AND ay_id=$acyear ORDER BY cl_id DESC");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
								$bid=$row['b_id'];
								  $boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  $cid=$row['c_id'];								  
								  $sid=$row['s_id'];
							
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
								  $cname=$class['c_name'];
							if($sid!="0" && $sid!="All"){
								$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
								  $cname.=" / ".$section['s_name']; }
								  if($cid){?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								 <td><center><?php echo $row['ref_number']; ?></center></td>
								<td><center><?php echo $row['cl_day']."-".$row['cl_month']."-".$row['cl_year']; ?></center></td>
                                <td><center><?php echo $row['title']; ?></center></td>
                                <td><center><?php echo substr(strip_tags($row['descript']),0,20); ?></center></td>
                                <td><center><?php if($board['b_name']){ echo $board['b_name'];} else { echo "All";} ?></center></td>
                                <td><center><?php echo $cname; ?></center></td>
                                <td><?php if($row['file']){?><center><a href="circular/<?php echo $row['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a></center><?php } ?></td>
                                <td><center><?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
                                <td width="100px">
                                <a href="javascript:void(0);" onclick="$('#info-dialog1<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="circular1_edit.php?clid=<?php echo $row['cl_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="circular_delete.php?clid=<?php echo $row['cl_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="circular_prt.php?clid=<?php echo $row['cl_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a></td>
								</tr> 
                                <div id="info-dialog1<?php echo $count;?>" title="Circular Details" style="display: none;">
                                
				<p>Published date : <strong><?php echo $row['cl_day']."-".$row['cl_month']."-".$row['cl_year']; ?></strong></p>
                
                 <p>Title : <strong><?php echo $row['title']; ?></strong></p> 
                
                <p>Description : <strong><?php substr(strip_tags($row['descript']),0,20); ?></strong>  </p>   
                
                <p>Circular Type: <strong><?php echo $row['type']; ?></strong>  </p>
                
                <p>Board: <strong><?php if($board['b_name']){ echo $board['b_name'];} else { echo "All";} ?></strong>  </p>
                
                <p>Circular file: <?php if($row['file']){?><a href="circular/<?php echo $row['file'];?>" target="_blank"><button class="btn btn-small btn-warning" >Download/View</button></a><?php } ?></p>   
                
                <center> <?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
                </div>
                                 <?php 
							$count++; }
							} ?>                               																
							</tbody>
						</table>
                        <br>
						</div>				
					</div>
				</div>
				
			</div>
            <div class="clear height-fix"></div>

		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
  <script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
  <script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	$('#table-example').dataTable();
		$('#table-example1').dataTable();
		$('#table-example2').dataTable();
		$('#table-example3').dataTable();
		$('#table-example4').dataTable();
// Code that uses jQuery's $ can follow here.
});
// Code that uses other library's $ can follow here.
</script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="js/mylibs/excanvas.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.visualize.js"></script> <!-- Charts -->
  <script defer src="js/mylibs/jquery.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="js/common.js"></script> <!-- Generic functions -->
  <script defer src="js/script.js"></script> <!-- Generic scripts -->
  
  <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		/*
		 * DataTables
		 */
		$("#tab-panel-1").createTabs();
		
	});
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>