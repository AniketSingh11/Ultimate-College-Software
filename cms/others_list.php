<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");
 include("checking_page/staff.php");
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
				<li class="no-hover">Others  Management</li>
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>
		<!-- Begin of #main-content -->
		<div id="main-content">
        	<div class="container_12">
			 <div class="grid_12">
				<h1>Others Management</h1>
                <div class="_25" style="float:right">
                <label for="select">Category :</label>
                                	<?php                                	
                                	if(isset($_GET['cid']))
                                	{
                                	    $cid=$_GET['cid'];
                                	}
                                            ?>
                                           <select name="cid" id="cid" class="required" onchange="change_function1()">
                                            <option value="all">All</option>
                                        <?php 
                                            $classl = "SELECT * FROM others_category";
                                            $result1 = mysql_query($classl) or die(mysql_error());
											while ($row1 = mysql_fetch_assoc($result1)){
											?>
												
                                               <option value='<?=$row1['oc_id']?>'<?php if($cid==$row1['oc_id']){?> selected<?php }?>><?=$row1['category_name']?></option>
                                               <?php }?>
											</select>
                              </div>
                <a href="others_add.php" title="add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
               <a href="export_others_data.php" title="add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png">Download Excel</button></a>
                  <?php if(isset($_GET['msg']))
				{
				if($_GET['msg']="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php }} ?>                   
			</div>
            <div class="grid_12">
            <div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Others Management</h1>
					</div>
					<div class="block-content tab-container">
							<br>
							<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Other ID</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Position</th>                                    
                                    <th>Phone No</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
                            if(isset($_GET['cid']) && $cid!="all")
                            {
							$qry=mysql_query("SELECT * FROM others where category_id='$cid'  order by category_id asc");
                            }else{                                
                                $qry=mysql_query("SELECT * FROM others   order by category_id asc");
                            }
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{   
        		    $res=mysql_query("select * from others_category where oc_id='$row[category_id]'");
        		    $cat=mysql_fetch_array($res);
        		   $c_name=$cat["category_name"];
        		    ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><?php echo $row['others_id']; ?></td>
								<td> <?php echo $c_name ?></td>
                                <td><?php echo $row['fname']."  ".$row['lname'];  ?></td>
                                <td><center><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></center></td>
                                <td><?php echo $row['position']; ?></td>                                
                                <td><?php echo $row['phone_no']; ?></td>
                                <td><center><img src="./img/others/<?php echo $row['photo']; ?>" alt="Others photo" width="40" height="40"></center></td>
                                <td><center><?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
                                <td width="100px">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="others_edit.php?o_id=<?php echo $row['o_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="others_delete.php?o_id=<?php echo $row['o_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="others_prt.php?o_id=<?php echo $row['o_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $row['others_id']; ?>, This others details" style="display: none;">
                                <center><img src="./img/others/<?php echo $row['photo']; ?>" alt="staff photo" width="60" height="60"></center>
				<p>Other ID : <strong><?php echo $row['others_id']; ?></strong></p>
                <p>Category : <strong><?php echo $c_name; ?></strong>  </p>    
                <p>First Name : <strong><?php echo $row['fname']; ?></strong></p> 
                <p>Last Name : <strong><?php echo $row['lname']; ?></strong>  </p>
                
                <p>Father's Name : <strong><?php echo $row['s_pname']; ?></strong>  </p>   
                
                <p>Date Of Birth :  <strong><?php echo $row['dob']; ?> </strong></p>   
                
                <p>Gender: <strong><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $row['reg']; ?></strong>  </p>   
                
                <p>Blood Group  :  <strong><?php echo $row['blood']; ?></strong>  </p>   
                
                <p>Position : <strong><?php echo $row['position']; ?></strong> </p>   
                
                <p>Expriences : <strong></strong> <?php echo $row['expriences']; ?></p>   
                
                <p>Email : <strong><?php echo $row['email']; ?></strong> </p>   
                
                <p>Phone No : <strong><?php echo $row['phone_no']; ?></strong>  </p>   
                
                <p>Residence Address1 : <strong><?php echo $row['address1']; ?></strong> </p> 
                
                <p>Town or village Name  : <strong><?php echo $row['city']; ?></strong>  </p>   
                
                <p>Country : <strong><?php echo $row['country']; ?></strong> </p>   
                
                <p>Pin Code : <strong><?php echo $row['pincode']; ?></strong> </p>
               
                <center> <?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
                </div>
                				
			</div> <!--! end of #info-dialog -->
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
                        <br>
					 
						 				
					</div>
					<!--<div class="block-content dark-bg">
						<p>You see an other example on the <a href="charts.html">Charts-Page</a>.</p>
					</div>-->
				</div>
				<!--<div class="block-border">
					<div class="block-header">
                    	<h1>Staffs Management</h1>
                        <span></span>
					</div>
                    <div class="block-content">
						
					</div>
				</div>-->
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
  function change_function1(){ 		
	    var bid=document.getElementById('cid').value;
		 window.location.href = 'others_list.php?cid='+bid;		 	  
		}  
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