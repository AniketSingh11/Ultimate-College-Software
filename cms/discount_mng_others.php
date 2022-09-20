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
    	<?php $bid=$_GET['bid'];
		$cids=$_GET['cid'];
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  
								  if($cids){
									  $classlist=mysql_query("SELECT c_name FROM class WHERE c_id=$cids"); 
								  	  $class=mysql_fetch_array($classlist);
								   }
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="#" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Student Discount Management <?php if($cids){ echo "(".$class['c_name'].")";} ?></li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
				<h1>Student Discount Management <?php if($cids){ echo "(".$class['c_name'].")";} ?></h1>
                <a href="discount_add_others.php?cid=<?php echo $_GET['cid'];?>&bid=<?php echo $bid;?>"  title="add" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png">  Add Discount</button></a>
				<span style="margin-left:20px;"><a href="std_discount_others.php?cid=<?php echo $_GET['cid'];?>&bid=<?php echo $bid;?>" style="width:100px"title="Print" ><button class="btn btn-small btn-green"><img src="img/icons/packs/fugue/16x16/inbox-download.png">Download Report</button></a></span>
                <div class="_25" style="float:right">
                <label for="select">Board :</label>
                                	<?php
                                            $classl = "SELECT * FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="bid" id="bid" class="required" onchange="change_function()">';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($bid ==$row1['b_id']){
                                                echo "<option value='{$row1['b_id']}' selected>{$row1['b_name']}</option>\n";
												} else {
												echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
                 <div class="_25" style="float:right">
                <label for="select">Standard</label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="required" onchange="change_function1()"> <option value="">All</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
											if($cids==$row1['c_id']){
                                                echo "<option value='{$row1['c_id']}' selected>{$row1['c_name']}</option>\n";
												} else {
												echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } 
				 $qry="SELECT * FROM discount_others WHERE bid=$bid AND ay_id=$acyear";
				 if($cids){
					 $qry .=" AND c_id=$cids";
				 }
				 	$qry .=" ORDER BY d_id DESC";
				  $qry1=mysql_query($qry);
							$total=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$tamount=$row1['total'];
					$total +=$tamount;					
				}?>   
                <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Total : <strong>Rs. <?php echo number_format($total,2); ?></strong> </span>                 
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>Student Discount Management <?php if($cids){ echo "(".$class['c_name'].")";} ?></h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Date</th>
                                    <th>admin No</th>
                                    <th>Student Name</th>
                                    <th>Class-Section</th>
                                    <th>Student type</th>
                                    <th>Discount Amount</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry="SELECT * FROM discount_others WHERE bid=$bid AND ay_id=$acyear";
							 if($cids){
								 $qry .=" AND c_id=$cids";
							 }
								$qry .=" ORDER BY d_id DESC";
							  $qry=mysql_query($qry);
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				$did=$row['d_id'];
				$ssid=$row['ss_id'];
				$cid=$row['c_id'];
				$sid=$row['s_id'];
				$classlist1=mysql_query("SELECT c_name FROM class WHERE c_id=$cid"); 
				//echo "SELECT c_name FROM class WHERE c_id=$cid";die;
								  $class1=mysql_fetch_array($classlist1);
							$sectionlist=mysql_query("SELECT s_name FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	
								  $studentlist=mysql_query("SELECT admission_number,firstname,lastname FROM student WHERE ss_id=$ssid"); 
								  $student=mysql_fetch_array($studentlist);	 
								  
								  $dislist=mysql_query("SELECT * FROM discount_others WHERE ss_id=$ssid"); 
								  $disval=mysql_fetch_array($dislist);
								  //echo $disval['status'].'<br>';
								  if($disval['status']==0){
									  $status=0;
								  }else{
									  $status=1;
								  }
									  
								   
				?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['cdate']; ?></center></td>
                                <td><center><?php echo $student['admission_number']; ?></center></td>
                                <td><center><?php echo $student['firstname']." ".$student['lastname']; ?></center></td>
                                <td><center><?php echo $class1['c_name']."/".$section['s_name']; ?></center></td>
                                <td><center><?php echo $row['stype']; ?></center></td>
                                <td><center>Rs. <?php echo number_format($row['total'],2); ?></center></td>
								<td><center><?php if($row['status']=='0'){ ?>
                                <button class="btn btn-small btn-warning" >Process</button><?php }else{?><button class="btn btn-small btn-success" >Completed</button> <?php } ?>
                                </center></td>
                                <td class="view"><center><a href="discount_detail_others.php?did=<?=$did?>&cid=<?=$cids?>&bid=<?=$bid?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								<td width="10%">
                                <?php if($row['status']=='0'){ ?>
                                 <a href="discount_edit_others.php?did=<?=$did?>&cid=<?=$cids?>&bid=<?=$bid?>" title="Edit"><img src="./img/edit.png" alt="edit"></a>
                                 <a href="discount_delete_others.php?did=<?=$did?>&cid=<?=$cids?>&bid=<?=$bid?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <?php }else{ echo "<center>-</center>"; } ?>
                                 </td>
								 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
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
		
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'discount_mng_others.php?bid='+cid;	  
	} 
	function change_function1() { 
     var cid =document.getElementById('cid').value;
	  window.location.href = 'discount_mng_others.php?cid='+cid+'&bid=<?php echo $bid;?>';	  
}
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>