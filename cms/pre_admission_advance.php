<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/admission.php");
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
    
    <?php 
			$bid=$_GET['bid'];
			$cid=$_GET['cid']; 			
			if($cid){
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
			}
			if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
			 $bid=$board1['b_id'];
			}
			if($bid){
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
			}
			?>
    <!-- Begin of #main -->
    <div id="main" role="main">
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_pre.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li class="no-hover"><?php if($cid){ echo $class['c_name']." - "; }?>Pre Admission Advance Payment</li>                
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
				<h1><?php if($cid){ echo $class['c_name']." - "; }?>Pre Admission Advance Payment</h1>
                <a href="pre_admission_advance_pay.php" title="add"  style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png">Student Advance Payment</button></a>
                <div class="_25" style="float:right">
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
								</select>
                 </div>
                <div class="_25" style="float:right">
                	<label for="select">Standard</label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="required" onchange="change_function()"> 
											<option value="all">All</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
												if($cid ==$row1['c_id']){
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
                 <?php } ?>                   
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>Pre Admission Advance Payment</h1>
                        <span></span>
					</div>
					<div class="block-content">
                            <table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Class</th>
                                    <th>Pre Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <th>Parent's name</th>
                                    <th>Phone</th> 
                                    <th>Amount</th>                                      
                                    <th>Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry="SELECT * FROM pre_admission_advance WHERE ay_id='$acyear'";							
							if($bid){
								$qry .=" AND b_id='$bid'";
							}
							if($cid){
								$qry .=" AND c_id='$cid'";
							}							
							$qry .=" ORDER BY name ASC";
							$qryselect=mysql_query($qry);
							$count=1;
			  while($row=mysql_fetch_array($qryselect))
        		{
					$cid1=$row['c_id'];
					$classlist1=mysql_query("SELECT c_name FROM class WHERE c_id=$cid1"); 
								  $class1=mysql_fetch_array($classlist1);
				?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
                                <td><center><?php echo $class1['c_name']; ?></center></td>
								<td><center><?php echo $row['pre_admin']; ?></center></td>
                                <td><center><?php echo $row['name']; ?></center></td>
                                <td><center><?php echo $row['fname']; ?></center></td>
                                <td><center><?php echo $row['phone']; ?></center></td>
                                <td><center><?php echo $row['amount']; ?></center></td>
                                <td><center><?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Closed </button><?php } else if($row['status']=='2'){?><button class="btn btn-small btn-error" >Returned </button> <?php } else { ?><button class="btn btn-small btn-warning" >Processing </button><?php } ?>
								 <td width="100px;">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="pre_admission_advance_edit.php?id=<?php echo $row['id'];?>&bid=<?php echo $bid; if($cid){ echo "&cid=".$cid;}?>" title="Edit"><img src="./img/edit.png" alt="edit"></a>
                                 <a href="pre_admission_advance_delete.php?id=<?php echo $row['id'];?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="pre_admission_advance_prt.php?id=<?php echo $row['id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr> 
                                                     <!-- Modal Box Content -->
			<div id="info-dialog<?php echo $count;?>" title="<?php echo $row['pa_admission_no']; ?>, This student details" style="display: none;">
            	<p>Admin NO : <strong><?php echo $row['pa_admission_no']; ?></strong></p>
                
                <p>Board / Class : <strong><?php echo $board['b_name']; if($cid){ echo " / ".$class['c_name']; } ?></strong></p>
                
                <p>First Name  : <strong><?php echo $row['firstname']; ?></strong></p> 
                
                <p>Last Name  : <strong><?php echo $row['lastname']; ?></strong>  </p>   
                
                <p>Father / Guardian Name: <strong><?php echo $row['fathersname']; ?></strong>  </p>  
                
                <p>Mother's Name : <strong><?php echo $row['m_name']; ?></strong>  </p>    
                
                <p>Date Of Birth : <strong><?php echo $row['dob']; ?></strong> </p>   
                
                <p>Gender : <strong><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>     
                
                <p>Religion : <strong><?php echo $row['reg']; ?></strong> </p>  
                
                <p>Email : <strong><?php echo $row['email']; ?></strong> </p>  
                
                <p>Phone : <strong><?php echo $row['phone_number']; ?></strong>  </p>
                
                <p>Additional Phone1 : <strong><?php echo $row['phone1']; ?></strong>  </p>
                
                <p>Additional Phone2 : <strong><?php echo $row['phone2']; ?></strong>  </p>
                
                <p>Additional Phone3 : <strong><?php echo $row['phone3']; ?></strong>  </p>   
                
                <p>Residence Address1 : <strong><?php echo $row['address1']; ?></strong>  </p>
                
                <p>Town or village Name : <strong><?php echo $row['city_id']; ?></strong> </p>   
                
                <p>State : <strong><?php echo $row['state']; ?></strong> </p> 
                
                <p>Country : <strong><?php echo $row['country']; ?></strong> </p> 
                
                <p>Pin Code : <strong><?php echo $row['pin']; ?></strong> </p> 
                
                <p>Status : <?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Selected </button><?php } else if($row['status']=='2'){?><button class="btn btn-small btn-error" >Rejected </button> <?php } else { ?><button class="btn btn-small btn-warning" >Processing </button><?php } ?></p> 
                </div>
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
	$('#table-example1').dataTable();
	$('#table-example2').dataTable();
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
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});	
		$("#tab-panel-2").createTabs();	
	});	

function mark_status(value,n)
{

var s=$("#status"+n).val();
if(value=="1"){ $("#output_status"+n).html("<button class='btn btn-small btn-success'>Selected </button>"); }
else if(value=="2"){
	$("#output_status"+n).html("<button class='btn btn-small btn-error'>Rejected </button>");
}else{

	$("#output_status"+n).html("<button class='btn btn-small btn-warning'>Pending </button>");
}

}
 </script>
  <!-- end scripts-->
   <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
function change_function() { 
     var cid =document.getElementById('cid').value;
	 if(cid != 'all'){
	  window.location.href = 'pre_admission_select.php?cid='+cid+'&bid=<?php echo $bid;?>';	  
	 } else {
	 window.location.href = 'pre_admission_select.php?bid=<?php echo $bid;?>';	  
	 }
	} 
	function change_function1() { 
     var bid =document.getElementById('bid').value;
	 window.location.href = 'pre_admission_select.php?bid='+bid;	  
	}
	</script>
	<?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>