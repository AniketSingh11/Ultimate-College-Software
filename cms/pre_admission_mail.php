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
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover">Pre Admission Send mail</li>                
			</ul>
		</div> <!--! end of #title-bar -->		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
				<h1>Pre Admission Mail List</h1>
                <!--<a href="#" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Import Student Datas</button></a>-->
          <a onclick="history.go(-1);" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
				 
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
			
			<div id="testing"></div>
            <div class="grid_12">
				<div class="block-border" id="tab-panel-2">
					<div class="block-header">
						<h1>Pre Admission Mail list <a  onclick="send_mail()" id="send_mail"  style="margin:3px 0 0 20px;"><button  class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-270-medium.png"> Ready Send mail </button></a>
				 </h1>
                        <span></span>
					</div>
					<div class="block-content tab-container">
							<br>
                            <table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Pre Admin No</th>
                                    <th><center>Student Name</center></th>
                                     <th>Gender</th>
                                    <th>Parent's name</th>
                                   <th>Email</th>
                                  
                                    <th>Phone</th>                                    
                                    <th>Board / Class</th>
                                    <th>Mail Status</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
                            $array_id=array();
                            
							$qry=mysql_query("SELECT * FROM pre_admission WHERE (status = '1') AND ay_id=$acyear ORDER BY pa_id DESC");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$cid=$row['c_id'];
					$bid=$row['b_id'];
					$pa_id=$row['pa_id'];
					
					array_push($array_id,$pa_id);
					
					$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
								  ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['pa_admission_no']; ?></center></td>
                                <td><center><?php echo $row['firstname']." ".$row['lastname']; ?></center></td>
                                  <td><center><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></center></td>
                                <td><center><?php echo $row['fathersname']; ?></center></td>
                                <td><center><?php echo $row['email']; ?></center></td>
                              
                                <td><center><?php echo $row['phone_number']; ?></center></td>
                                <td><center><?php echo $board['b_name']." / ".$class['c_name']; ?></center></td>
                                <td id="mail_status<?=$pa_id?>" width="100px;">
                                <center></center>
                                </td>
								</tr> 
                                                     <!-- Modal Box Content -->
			<div id="info-dialog<?php echo $count;?>" title="<?php echo $row['pa_admission_no']; ?>, This student details" style="display: none;">
            	<p>Admin NO : <strong><?php echo $row['pa_admission_no']; ?></strong></p>
                
                <p>Board / Class : <strong><?php echo $board['b_name']." / ".$class['c_name']; ?></strong></p>
                
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
	
	$('#table-example').dataTable({
		  'iDisplayLength': 100
		});
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
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});	
		$("#tab-panel-2").createTabs();	
	});


	function send_mail()
	{
		 $("#testing").load("quickmail.php");

	}
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
  <?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>