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
    <?php 
		$bid=$_GET['bid'];
		if(!$bid){
			$boardlist1=mysql_query("SELECT * FROM board"); 
								  $board1=mysql_fetch_array($boardlist1);
		 $bid=$board1['b_id'];
		}
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_resultexp.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Students Mark Report</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <a href="board_select_resultexp.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
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
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Exam,Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="student_result_export.php" method="POST">
						<div class="_50">
							<p>
								<label for="select">Exam : <span class="error">*</span></label>
                                	<?php
                                            $classl1 = "SELECT e_id,e_name FROM exam where ay_id=$acyear";
                                            $result11 = mysql_query($classl1) or die(mysql_error());
                                            echo '<select name="eid" id="eid" class="required"> <option value="">Select Exam</option>';
											while ($row11 = mysql_fetch_assoc($result11)):
                                                echo "<option value='{$row11['e_id']}'>{$row11['e_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="required" onchange="showCategory(this.value)"> <option value="">Select Class</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
							</p>
						</div>
                        <div class="_50">
							<p>
								<label for="select">Section / Group : <span class="error">*</span></label>
                               <select name="sid" id="sid" class="required">
											<option value="">Please select</option>											
								</select>
							</p>
						</div>
                       
                       
                       <div class="_50">
							<p>
								<label for="select">Download File Format : <span class="error">*</span></label>
                                <input   name="download_format" class="required"    type="radio" value="CSV" />CSV  
                                 <input    name="download_format"    type="radio" value="EXCEL" />EXCEL<br>
							</p>
						</div>
                        
                        
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            <input type="hidden" class="medium" name="bid" value="<?php echo $bid;?>" >
                            <input type="hidden" class="medium" name="ayid" value="<?php echo $acyear;?>" >
                            	<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
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
			location.reload(); 
			//$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		/*
		 * DataTables
		 */
		$('#table-example').dataTable();
	});
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'exp_student_result.php?bid='+cid;	  
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