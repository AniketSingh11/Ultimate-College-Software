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
                <li class="no-hover">Class TimeTable Management</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <?php
							
							 	  //echo $class['c_name']."-".$section['s_name'];
								  ?>
			<div class="grid_12">
				<h1>TimeTable</h1>
                <a href="stimetable_prt.php" target="_blank" style="margin:0px 0 0 10px;"><button class="btn btn-success btn-small "><img src="img/icons/packs/fugue/16x16/printer.png"> Print Timetable</button></a>
           </div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>TimeTable </h1>                        
                        <span></span>
					</div>
					<div class="block-content">
                    <?php 
					$timelist1=mysql_query("SELECT * FROM timetable WHERE ay_id=$acyear"); 
								   $timetable1=mysql_fetch_array($timelist1);	
								   if($timetable1){ ?>
						<table id="table-example" class="table1" align="center">
							<thead>
								<tr>
                                	<th>Day</th>
									<th>I</th>
									<th>II</th>
									<th></th>
									<th>III</th>
                                    <th>IV</th>
                                    <th></th>
                                    <th>V</th>
                                    <th>VI</th>
                                    <th></th>
                                    <th>VII</th>
                                    <th>VIII</th>
                                    <th></th>
								</tr>
							</thead>
							<tbody>
								<tr class="gradeX">
									<td></td>
                                    <td></td>
									<td></td>
                                    <td class="vertical" rowspan="6"><strong>Break</strong></td>
									<td></td>
									<td></td>
                                    <td class="vertical" rowspan="6"><strong>Lunch</strong></td>
                                    <td></td>
									<td></td>
                                    <td class="vertical" rowspan="6"><strong>Break</strong></td>
                                    <td></td>
									<td></td>
                                    <td class="vertical" rowspan="6" style="z-index:1;"><strong>DairySign</strong></td>
								</tr>
                                <?php 
							$qry=mysql_query("SELECT * FROM day WHERE ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					 $did=$row['d_id'];
					//die();
								   $timelist=mysql_query("SELECT * FROM timetable WHERE d_id=$did AND ay_id=$acyear"); 
								   $timetable=mysql_fetch_array($timelist);	
								   if($timetable){
									   $tt_id=$timetable['tt_id'];
								   $p1=$timetable['p1'];
								   $p2=$timetable['p2'];
								   $p3=$timetable['p3'];
								   $p4=$timetable['p4'];
								   $p5=$timetable['p5'];
								   $p6=$timetable['p6'];
								   $p7=$timetable['p7'];
								   $p8=$timetable['p8'];
								   $peroid = array($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8);
								   //echo $peroid[3];
								  
								  
					?>
                                <tr class="gradeC">
                                	<td class="hover"><strong><?php echo $row['d_name'];?></strong></td>
                                    <?php  for($i=0;$i<8;$i++){
									  $subid=$peroid[$i];
									  $timeli=mysql_query("SELECT * FROM subject WHERE sub_id='$subid'"); 
									   $row2=mysql_fetch_array($timeli);
									   $slid=$row2['sl_id'];
								   $subjectlist1=mysql_query("SELECT * FROM subjectlist WHERE sl_id='$slid'"); 
								   $slist=mysql_fetch_array($subjectlist1);	
									  //die();
									  if($row2['st_id']==$stid){ 
									  	$cid=$row2['c_id'];
										$sid=$row2['s_id'];
										$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
									  ?>
                                      <td class="hover"><?php echo $class['c_name']."-".$section['s_name']."<br>(".$slist['s_name'].")";?></td>
                                      <?php } else{ ?>
								    <td class="hover">&nbsp;</td>
                                    <?php } } ?>                                                                   
								</tr>
                                <?php } } ?>                               						
							</tbody>
						</table>
                        
            <div class="grid_6">
				<div class="block-border">
					<div class="block-header">
						<h1>Timing</h1><span></span>
					</div>
					<div class="block-content">
						<ul class="overview-list">
							<li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">Break</span> - 10 minutes</a></li>
							<li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">Lunch</span> - 50 minutes</a></li>
							<li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">Dairy Sign</span> 10 minutes</a></li>
							<li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period I</span> - 9.30 AM - 10.10 AM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period II</span> - 10.10 AM - 10.50 AM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period III</span> - 11.00 AM - 11.40AM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period IV</span> - 11.40 AM - 12.20 PM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period V</span> - 1.00 PM - 1.40 PM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period VI</span> - 1.40 PM - 2.20 PM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period VII</span> - 2.30 PM - 3.10 PM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period VIII</span> - 3.10 PM - 3.50 PM</a></li>
						</ul>
					</div>
				</div>
			</div>
            
            <div class="grid_6">
				<div class="block-border">
					<div class="block-header">
						<h1>Timing for Friday</h1><span></span>
					</div>
					<div class="block-content">
						<ul class="overview-list">
							<li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">Break</span> - 10 minutes</a></li>
							<li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">Lunch</span> - 50 minutes</a></li>
							<li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">Dairy Sign</span> 20 minutes</a></li>
							<li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period I</span> - 9.30 AM - 10.10 AM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period II</span> - 10.10 AM - 10.50 AM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period III</span> - 11.00 AM - 11.40AM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period IV</span> - 11.40 AM - 12.20 PM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period V</span> - 1.00 PM - 1.30 PM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period VI</span> - 1.30 PM - 2.00 PM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period VII</span> - 2.10 PM - 2.40 PM</a></li>
                            <li><a href="javascript:void(0);"><span style="width:80px; font-size:16px;">period VIII</span> - 2.40 PM - 3.10 PM</a></li>
						</ul>
					</div>
				</div>
			</div>
                        <?php } else { echo "<center><h5>This is no Class TimeTable Found</h5></center>"; } ?>
					</div>
				</div>
            </div>
            <div class="clear height-fix"></div>
		</div></div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");?>
  </div> <!--! end of #container -->

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="js/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="js/mylibs/jquery.notifications.js"></script> <!-- Notifications  -->
  <script defer src="js/mylibs/jquery.uniform.min.js"></script> <!-- Uniform (Look & Feel from forms) -->
  <script defer src="js/mylibs/jquery.validate.min.js"></script> <!-- Validation from forms -->
  <script defer src="js/mylibs/jquery.dataTables.min.js"></script> <!-- Tables -->
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
		/*
		 * DataTables
		 */
		$('#table-example1').dataTable({
			"bJQueryUI"     : true,
        "bPaginate"     : false,
        "bLengthChange" : false,
        "bFilter"           : false,
        "bSort"         : false,
        "bInfo"         : false,
        "bAutoWidth"        : false,
        "fnDrawCallback"    : function() { $("#table-example1").show();
		$('thead td').addClass('ui-state-default'); }
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