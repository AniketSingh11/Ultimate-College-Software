<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top1.php"); 
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
    	<?php include("nav1.php");?>
         <!--! end of #nav -->
    	
    </aside> <!--! end of #sidebar -->
    
    <!-- Begin of #main -->
    <div id="main" role="main">
    <?php 
		$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard1.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="sboard_select_stu.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
                <li class="no-hover"><a href="sboard_select_class.php?bid=<?php echo $bid; ?>" title="Select Class">Class List</a></li>
				<li class="no-hover">Students Detail</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="sboard_select_class.php?bid=<?php echo $bid; ?>" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
            <div class="grid_12">
            </div>
			<?php
							$cid=$_GET['cid'];
							$sid=$_GET['sid'];
							
				if($cid && $sid){
							$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
			<div class="grid_12">
				<h1><?php echo $class['c_name']."-".$section['s_name'];?> Student List</h1>                                  
			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $class['c_name']."-".$section['s_name'];?> Student List</h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Admin No</th>
                                    <th><center>Student Name</center></th>
                                    <th>Parent's name</th>
                                    <th>Date of Admin</th>
                                    <th>DOB</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM student WHERE c_id=$cid AND s_id=$sid AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['admission_number']; ?></center></td>
                                <td><center><?php echo $row['firstname']." ".$row['middlename']." ".$row['lastname']; ?></center></td>
                                <td><center><?php echo $row['fathersname']; ?></center></td>
                                <td><center><?php echo $row['doa']; ?></center></td>
                                <td><center><?php echo $row['dob']; ?></center></td>
                                <td><center><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></center></td>
                                <td><center><?php echo $row['phone_number']; ?></center></td>
                                <td><center><?php echo $row['email']; ?></center></td>
                                <td><center><?php if($row['user_status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center></td>
								 <td width="50px;">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="sstudent_prt.php?ssid=<?php echo $row['ss_id'];?>&cid=<?php echo $cid;?>&sid=<?php echo $sid;?>&bid=<?php echo $bid;?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr> 
                                                     <!-- Modal Box Content -->
			<div id="info-dialog<?php echo $count;?>" title="<?php echo $row['admission_number']; ?>, This student details" style="display: none;">
				<center><img src="./img/student/<?php echo $row['photo']; ?>" alt="student photo" width="60" height="60"></center>
				<p>Admin NO : <strong><?php echo $row['admission_number']; ?></strong></p>
                
                 <p>First Name : <strong><?php echo $row['firstname']; ?></strong></p> 
                
                <p>Last Name : <strong><?php echo $row['lastname']; ?></strong>  </p>   
                
                <p>Father / Guardian Name: <strong><?php echo $row['fathersname']; ?></strong>  </p>   
                
                <p>Father / Guardian Occupation : <strong><?php echo $row['fathersocupation']; ?></strong>  </p> 
                
                <p>Father / Guardian Monthly Income : <strong><?php echo $row['p_income']; ?></strong>  </p> 
                
                <p>Mother's Name : <strong><?php echo $row['m_name']; ?></strong>  </p> 
                
                <p>Mother's Occupation : <strong><?php echo $row['m_occup']; ?></strong>  </p> 
                
                <p>Mother's Monthly Income : <strong><?php echo $row['m_income']; ?></strong>  </p>   
                
                <p>Date of admission :  <strong><?php echo $row['doa']; ?></strong>  </p>   
                
                <p>Date Of Birth : <strong><?php echo $row['dob']; ?></strong> </p>   
                
                <p>Gender : <strong><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Nationality : <strong><?php echo $row['nation']; ?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $row['reg']; ?></strong> </p>   
                
                <p>Caste : <strong><?php echo $row['caste']; ?></strong>  </p>   
                
                <p>Subcaste : <strong><?php echo $row['sub_caste']; ?></strong>  </p>   
                
                <p>Blood Group : <strong><?php echo $row['blood']; ?></strong> </p>   
                
                <p>Email : <strong><?php echo $row['email']; ?></strong> </p>  
                
                <p>Phone : <strong><?php echo $row['phone_number']; ?></strong>  </p>   
                
                <p>Residence Address1 : <strong><?php echo $row['address1']; ?></strong>  </p>   
                
                <p>Residence Address2 : <strong><?php echo $row['address2']; ?></strong> </p>   
                
                <p>Town or village Name : <strong><?php echo $row['city_id']; ?></strong> </p>   
                
                <p>Country : <strong><?php echo $row['country']; ?></strong> </p> 
                
                <p>Pin Code : <strong><?php echo $row['pin']; ?></strong> </p>   
                
                <p>Mother Tongue : <strong><?php echo $row['mother_tongue']; ?></strong> </p>   
                
                <p>Height : <strong><?php echo $row['height']; ?></strong> </p>
                
                <p>Weight : <strong><?php echo $row['weight']; ?></strong> </p>
                
                <p>Remarks : <strong><?php echo $row['remarks']; ?></strong> </p>
                
                <p>student type : <strong><?php echo $row['stype']; ?></strong> </p>
                
                <?php 
				$fdis_id=$row['fdis_id'];
				if($fdis_id){ 
				//$rid1=$invoice['r_id'];
								  $qry6=mysql_query("SELECT * FROM fdiscount WHERE fdis_id=$fdis_id"); 
								  $row6=mysql_fetch_array($qry6);
				?>
                <p>Student Category  : <strong><?php echo $row6['fdis_name']; ?></strong> </p>   
                <?php } $rid=$row['r_id'];
				$spid=$row['sp_id'];
				if($rid){ 
				//$rid1=$invoice['r_id'];
								  $qry5=mysql_query("SELECT * FROM route WHERE r_id=$rid"); 
								  $row5=mysql_fetch_array($qry5);
				?>
                <p>Bus Route Name : <strong><?php echo $row5['r_name']; ?></strong> </p>   
                <?php } if($spid){
					 $qry6=mysql_query("SELECT * FROM stopping WHERE sp_id=$spid"); 

								  $row6=mysql_fetch_array($qry6);?>				
                <p>Stopping Point : <strong><?php echo $row6['sp_name']; ?></strong> </p> 
                
                <?php } ?>
                <p>Status  : <?php if($row['user_status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </p>
                </div>
                				
			</div> <!--! end of #info-dialog -->
            
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
					</div>
				</div>
            </div>
            <div class="clear height-fix"></div>
<?php } ?>
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
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		
	});
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
    function showCategory(str) {
        if (str == "") {
            document.getElementById("sid").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("sid").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }    
</script>  
</body>
</html>
<? ob_flush(); ?>