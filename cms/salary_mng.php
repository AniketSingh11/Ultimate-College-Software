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
				<li class="no-hover">Staff Salary Management </li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            
			<?php
							
							//$eid=$_GET['eid'];
							$mid=$_GET['mid'];
							 
				$montharray=array("June","July","August","September","October","November","December","January","February","March","April","May"); 
			?>
		<div class="grid_12">
				<h1>Staff Salary <b><?php if($mid){?>( <?php echo $montharray[$mid-1];?> )<?php } ?> <a href="salary_single.php" title="add" style="margin:0px 0 0 10px;"><button class="btn btn-orange btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png"> Add Salary</button></a></b></h1>
                 <?php 
				 $qry2=mysql_query("SELECT * FROM year ORDER BY ay_id DESC LIMIT 1");
				$row2=mysql_fetch_array($qry2);
				
				$monthno=date("m");
				 			$qry1=mysql_query("SELECT * FROM month WHERE ay_id=$acyear");
							$mcount=1;
							$count=1;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$mno=$row1['m_no'];	
					if($mcount==1){?>
                 <a href="salary_mng.php?mid=<?php echo $row1['m_id']; ?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-error" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> <?php echo $row1['m_name']; ?></button></a>
                <?php }
				if($mno==$monthno && $row2['ay_id']==$acyear){
						$mcount=0;
					} }
					 ?>
                <br>
                <br>
                <?php if($mid){?>
                
                <a href="salary_export.php?mid=<?php echo $mid;?>&ayid=<?php echo $acyear;?>&month=<?php echo $montharray[$mid-1];?>" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Salary Report</button></a>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Salary Detail Successfully Deleted !!!</div>
                 <?php } }?>                   
			</div>
            <?php if($mid){?>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>Staffs Salary <b><?php if($mid){?>(<?php echo $montharray[$mid-1];?>)<?php } ?></b></h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th>Staff ID</th>
                                    <th><center>Staff Name</center></th> 
                                    <th><center>Staff Type</center></th>
                                    <th><center>Date</center></th>                                    
                        			<th><center>Salary</center></th>
                                    <th>Action</th>
                        		</tr>
							</thead>
							<tbody>                    			
                            <?php 
							$qry=mysql_query("SELECT * FROM salary WHERE m_id=$mid AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
						$stid=$row['st_id'];
								   $studentlist=mysql_query("SELECT * FROM staff WHERE st_id=$stid"); 
								   $staff=mysql_fetch_array($studentlist);	
						?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $staff['staff_id']; ?></center></td>
                                <td><center><?php echo $staff['fname']." ".$staff['mname']." ".$staff['lname']; ?></center></td>
                                <td><center><?php echo $staff['s_type']; ?></center></td>
                                <td><center><?php echo $row['date_day']."/".$row['date_month']."/".$row['date_year']; ?></center></td>
                                <td><center>Rs. <?php echo $row['amount'];?></center></td>
                                <td width="60px;">
                                 <a href="salary_edit.php?syid=<?php echo $row['sy_id'];?>&mid=<?php echo $mid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a>
                                 <a href="salary_delete.php?syid=<?php echo $row['sy_id'];?>&mid=<?php echo $mid;?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 </td>
                               </tr> 
                                 <?php 
							$count++;
							} ?>     
                           </tbody>
						</table>
					</div>
				</div>
            </div> <?php } else {?>
            <center><h3 class="succ"> Please Select Month </h3></center> <?php } ?>
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
<?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>