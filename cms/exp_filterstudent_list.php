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
                <li class="no-hover"><a title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Filter Students List Report</li>                
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
             <div class="grid_12">
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
                 <h1>Filtered Student Report</h1>
                 <a href="exp_filterstudent_temp.php"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png">Create Template</button></a>
			</div>
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Standard and Section/Group</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="student_filter_export.php" method="POST">
					
					       <div class="_25">
							<p>
								<label for="select">Select Filter : <span class="error">*</span></label>
                               <select  name="filter" onChange="s_filter(this.value)" class="required">
									<option value="All">All</option>	
									<option value="dob">Date of birth</option>	
									<option value="gender">Gender</option>
									 <option value="blood">Blood Group</option>
									<option value="reg">Religion</option>
									<option value="caste">Caste</option>	
									<option value="stype">Student Type</option>	
									<option value="fdis_id">Student Category</option>	
																	
								</select>
							</p>
						   </div>
						   
						    <div class="_25">
							<p>
								<label for="select">Select  : <span class="error">*</span></label>
                               <select  id="filter_value" multiple="multiple"  name="filter_value[]" style="width:100%" class="required">
									 
											<option value="All">All</option>								
								</select>
							</p>
						   </div>
						<div class="_25">
							<p>
								<label for="select">Standard : <span class="error">*</span></label>
                                	<?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$bid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="cid" id="cid" class="required" onchange="showCategory(this.value)"> <option value="All">All</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
                                                echo "<option value='{$row1['c_id']}'>{$row1['c_name']}</option>\n";
                                            endwhile;
                                            echo '</select>';
                                            ?>
							</p>
						 </div>
                        <div class="_25">
							<p>
								<label for="select">Section / Group : <span class="error">*</span></label>
                               <select name="sid" id="sid" class="required">
											<option value="All">All</option>											
								</select>
							</p>
						</div>
						<div class="clear"></div>
                        <div class="_25">
							<p>
								<label for="select">Expense Type: <span class="error">*</span></label>
                               <select name="type" data-required="true" id="type"  class='required' onchange="expense_type()">
                               		<option value="">Please Select</option>
                                    <option value="New">New</option>
                                    <?php $qry=mysql_query("SELECT * FROM report_temp");
					  while($row=mysql_fetch_array($qry))
						{ ?>
                        				<option value="<?=$row['t_id']?>"><?=$row['title']?></option>
                         <?php } ?>
								</select>
							</p>
						</div>
						<div id="ajax_pay">
                        </div>
                        <div class="_50">
							<p>
								<label for="select">Download File Format : <span class="error">*</span></label>
                                <input   name="download_format" class="required"    type="radio" value="CSV" />CSV  
                                 <input    name="download_format"    type="radio" value="EXCEL" />EXCEL 
                                 <!--   <input    name="download_format"    type="radio" value="PDF" />PDF<br>-->
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
	function expense_type() {
			var x = document.getElementById("type").value;
			if(x){
				$.get("exp_filter_ajax.php",{value1:x},function(data){
					$("#ajax_pay").html(data);
					});
			}else{
				$('#ajax_pay').hide();
			}
			/*$.get("mpayment_type.php",{value:x},function(data){
			$( "#ajax_pay" ).html(data);
			});*/	
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
  
   <script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
  	  <link rel="stylesheet" href="payroll/js/plugins/select2/select2.css" type="text/css" />
  	  <script src="payroll/js/plugins/select2/select2.js"></script>  
      <script src="js/jquery-migrate-1.2.1.js"></script>
  
<script type="text/javascript">
    function showCategory(str) {
        if (str == "") {
            document.getElementById("sid").innerHTML = "<option value='All'>All</option>";
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
            	var output="<option value='All'>All</option>"+xmlhttp.responseText;
             
               
                document.getElementById("sid").innerHTML = output;
            }
        }
        xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
        xmlhttp.send();
    }
        
    function change_function() { 
        var cid =document.getElementById('bid').value;
   	 window.location.href = 'exp_filterstudent_list.php?bid='+cid;	  
   	} 

    function s_filter(str)
    {
//alert(str);
 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
}
else {// code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    	var output=xmlhttp.responseText;
     
       
        document.getElementById("filter_value").innerHTML = output;
        $("#filter_value").select2('val', '')
        
    }
}
xmlhttp.open("GET", "ajax_student_filter_list.php?filter=" + str+"&ay_id=<?=$acyear?>&b_id=<?=$bid?>", true);
xmlhttp.send();
    }
$().ready(function() {		
   	 
      	/* $('#down_id').select2 ({
      			allowClear: true,
      			placeholder: "Please Select..."
      		});*/ 

       	$('#filter_value').select2 ({
  			allowClear: true,
  			placeholder: "Please Select..."
  		}).on("change", function(e) {
            // mostly used event, fired to the original element when the value changes
  			var f=$('#filter_value').val();
  			var res=f.slice(0,3);

			 if(res[0]=="All"){
				 $("#filter_value").select2('val', '')
				 $("#filter_value").select2('val', 'All')
			 }else{
			 }
          })
  		 .on("select2-selecting", function(e) {

  	      
        })
      });	
</script>  
</body>
</html>
<? ob_flush(); ?>