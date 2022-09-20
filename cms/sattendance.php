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
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard1.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover">Attendance</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <?php
							$mid=$_GET['mid'];
				  
							if($mid){
								$examlist=mysql_query("SELECT * FROM month WHERE m_id=$mid"); 
								  $month=mysql_fetch_array($examlist);
							  }
							 	  //echo $class['c_name']."-".$section['s_name'];
		
								  ?>
            <?php 
			$monthno=date("m");
				 			$qry1=mysql_query("SELECT * FROM month WHERE ay_id=$acyear");
							$count=1;
							$mcount=1;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$mno=$row1['m_no'];
					if($mcount==1){?>
                 <a href="sattendance.php?mid=<?php echo $row1['m_id'];?>" style="margin:0px 0 0 10px;"><button class="btn btn-small btn-error" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> <?php echo $row1['m_name']; ?></button></a>
                <?php } if($mno==$monthno){
						$mcount=0;
					} }?>
                                   <?php if($mid){?>
		<div class="grid_12">
				<h1><?php echo $month['m_name'];?> - Attendance</h1>
                <br>
                <br>
                <?php if($mid){?>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } }?>                   
			</div>
            <?php 
			$present=0;$absent=0;$absentoff=0;$workday=0;
						$select_record2=mysql_query("SELECT * FROM sattendance WHERE m_id=$mid AND ay_id=$acyear AND st_id=$stid ORDER BY day");
					while($monthday=mysql_fetch_array($select_record2))
					{ 
					$result=$monthday['result'];
					if($result=='1'){
						$present++;
					}
					if($result=='0'){
						$absent++;
					}
					if($result=='off'){
						$absentoff++;
					}
					
						$workday++;
					}
					//echo $present."/".$absent."/".$absentoff."/".$workday;
					$op=$absentoff*.5;
					if($present && $workday){
					$persent=round((($present+$op)/$workday)*100,2);}
					?>
           
            <div class="grid_8">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $month['m_name'];?> - Attendance</h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
                                	<th></th>
									<th>Title</th>
                  					<th>Details</th>
								</tr>
							</thead>
							<tbody>
                                <tr>
                                  <td>1</td>
                                  <td>Total Working Days (upto Updated)</td>
                                  <td>: <strong><?php echo $workday;?></strong></td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td>No of Presents</td>
                                  <td>: <strong><?php echo $present;?></strong></td>
                                </tr>
                                <tr>
                                   <td>3</td>
                                  <td>No of Absents</td>
                                  <td>: <strong><?php echo $absent+$absentoff;?></strong></td>
                                </tr>
                                <tr>
                                <td colspan="3"></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td>Percentage</td>
                                  <td>: <strong><?php echo $persent;?>%</strong></td>
                                </tr>                           																
							</tbody>
						</table>
					</div>
				</div>
            </div>
            <div class="grid_4">
				<div class="block-border">
					<div class="block-header">
                    	<h1><?php echo $month['m_name'];?> - Absent Date List</h1>                        
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
                                	<th>Absent Dates</th>									
								</tr>
							</thead>
							<tbody>
                                <?php $select_record3=mysql_query("SELECT * FROM sattendance WHERE m_id=$mid AND ay_id=$acyear AND st_id=$stid AND (result=0 OR result='off') ORDER BY day");
			  $cno=1;
					while($monthday1=mysql_fetch_array($select_record3))
					{ 
					$emonth=$monthday1['month'];
					$eday=$monthday1['day'];
					$eyear=$monthday1['year'];
					$oresult=$monthday1['result'];
					?>
                  <tr>
                      <td>
                          <p><?php echo $cno.".".$eday."/".$emonth."/".$eyear ; if($oresult=='off'){ echo "- <strong>Half Day Absent</strong>";}?> </p>                          
                      </td>
                  </tr>
                  <?php $cno++; } if($cno==1){ echo "<tr><td> This is no absents</td></tr>";} ?>                         																
							</tbody>
						</table>
					</div>
				</div>
            </div>
             <?php } else {?>
            <center><h3 class="succ"> Please Select any one Month </h3></center> <?php } ?>
            <div class="clear height-fix"></div>
		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->
  <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
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