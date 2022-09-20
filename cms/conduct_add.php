<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 if (isset($_POST['submit']))
{
	$admin_no=$_POST['admin_no'];
	$name=$_POST['name'];
	$standard=$_POST['standard'];
	$year=$_POST['year'];
	$character1=$_POST['character1'];
	$dob=$_POST['dob'];
	
	$purpose=$_POST['purpose'];
	$c_date=$_POST['date'];
	
	$qry1=mysql_query("select * from conduct where ay_id='$acyear' and admin_no='$admin_no' ");
	
	if(mysql_num_rows($qry1)!=0){
	    $res1=mysql_fetch_array($qry1);
	
	    $ref_number=$res1["ref_number"];
	}else{
	
	
	    $adminlist=mysql_query("SELECT * FROM certificate_count WHERE cc_id='3'");
	    $admincount=mysql_fetch_array($adminlist);
	
	    $refno=$admincount['count'];
	    $refno2=$refno+1;
	    $ref_number=str_pad($refno, 3, '0', STR_PAD_LEFT);
	
	    $sql1=mysql_query("UPDATE certificate_count SET count='$refno2' WHERE cc_id='3'");
	}
		
		$sql="INSERT INTO conduct (admin_no,name,standard,year,character1,dob,ay_id,purpose,ref_number,c_date) VALUES
('$admin_no','$name','$standard','$year','$character1','$dob','$acyear','$purpose','$ref_number','$c_date')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=mysql_insert_id();

    if($result){		
     header("Location:conduct_add.php?lid=$lastid&msg=succ");	   
    }
    exit;
}

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
				<li class="no-hover"><a href="conduct.php" title="Home">conduct Certificate</a></li>
                <li class="no-hover">Add New conduct Certificate</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New conduct Certificate</h1>                
			<a href="conduct.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Created!!!
            <center><a href="conduct_prt.php?contid=<?php echo $_GET['lid'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print the Last Added Certificate</button></a></center>
            </div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add New conduct Certificate</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						<div class="_50" id="suggest">
							<p>
                                <label for="textfield">Admin No</label>
                                <input id="admin_no" name="admin_no"   onkeyup="suggest(this.value);" autocomplete="off" class="required" type="text" value="" />
                                 <div id="suggestions" class="suggestionsBox" style="display: none;">
 
<div id="suggestionsList" class="suggestionList"></div>
</div> 
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Student Name</label>
                                <input   name="name" id="std_name" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="clear"></div>
                        <div class="_50">
							<p>
                                <label for="textfield">Standard</label>
                                <input   name="standard" id="standard" class="required" type="text" value="" />
                            </p>
						</div>
                        
                        <div class="_50">
							<p>
                                <label for="textfield">Academic Year</label>
                                <input id="year" name="year" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Character</label>
                                <input id="textfield" name="character1" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Date of Birth</label>
                                <input id="dob"  name="dob" class="required" type="text" value="" />
                            </p>
						</div>
						
						 <div class="_50">
							<p>
                                <label for="textfield">purpose<font color="red">*</font></label>
                                <input id="purpose"  name="purpose" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Date</label>
                                <input id="datepicker1"  name="date" class="required" type="text" value="<?php echo Date("d/m/Y"); ?>" />
                            </p>
						</div>
						
						<div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
								<li><input type="submit" name="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
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
  <script defer src="js/zebra_datepicker.js"></script>
  <!-- end scripts-->
   <script type="text/javascript">
	$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});	
		$( "#dob" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });		
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'd/m/Y'
    });				
	});
	function suggest(inputString){		 
		//var field=document.search.select.value;		 
        if(inputString.length == 0) {
            $('#suggestions').fadeOut();
        } else {
        $('#admin_no').addClass('load');
            $.post("autostudent.php", {queryString: ""+inputString+""}, function(data){
                if(data.length >0) {
                    $('#suggestions').fadeIn();
                    $('#suggestionsList').html(data);
                    $('#admin_no').removeClass('load');
                }
            });
        }
    } 
    function fill(thisValue,s,p,std,y,d) {      
        $('#admin_no').val(thisValue);
        $('#std_name').val(s);
        $('#p_name').val(p);
        $('#standard').val(std);
        $('#year').val(y);
        $('#dob').val(d);
        setTimeout("$('#suggestions').fadeOut();", 600);
    }
  </script>
  
  <style>

#result {
	height:20px;
	font-size:16px;
	font-family:Arial, Helvetica, sans-serif;
	color:#333;
	padding:5px;
	margin-bottom:10px;
	background-color:#FFFF99;
}
#admin_no{
	padding:3px;
	border:1px #CCC solid;
	font-size:17px;
}
.suggestionsBox {
	position: absolute;
	left: 30px;
	top:15px;
	margin: 26px 0px 0px 0px;
	width: 200px;
	padding:0px;
	background-color: #000;
	border-top: 3px solid #000;
	color: #fff;
}
.suggestionList {
	margin: 0px;
	padding: 0px;
}
.suggestionList ul li {
	list-style:none;
	margin: 0px;
	padding: 6px;
	border-bottom:1px dotted #666;
	cursor: pointer;
}
.suggestionList ul li:hover {
	background-color: #FC3;
	color:#000;
}
ul {
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#FFF;
	padding:0;
	margin:0;
}

.load{
background-image:url(loader.gif);
background-position:right;
background-repeat:no-repeat;
}

#suggest {
	position:relative;
}
 </style>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>