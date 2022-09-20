<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 if (isset($_POST['submit']))
{
	
    $member=explode(",",$_POST['member']);
     $id=$member[0];
     $type=$member[4];
    $fathername=$member[3];
    
    
	$name=$_POST['name'];
	$gender=$_POST['gender'];
	$position=$_POST['position'];
	$duration_from=$_POST['d_from'];
	$duration_to=$_POST['d_to'];
	
	$purpose=$_POST['purpose'];
	
	$qry1=mysql_query("select * from experience_certificate where ay_id='$acyear' and id='$id' ");
	if(mysql_num_rows($qry1)!=0){
	    $res1=mysql_fetch_array($qry1);
	
	    $ref_number=$res1["ref_number"];
	}else{
	
	
	    $adminlist=mysql_query("SELECT * FROM certificate_count WHERE cc_id='8'");
	    $admincount=mysql_fetch_array($adminlist);
	
	    $refno=$admincount['count'];
	    $refno2=$refno+1;
	    $ref_number="Exp".str_pad($refno, 3, '0', STR_PAD_LEFT);
	
	    $sql1=mysql_query("UPDATE certificate_count SET count='$refno2' WHERE cc_id='8'");
	}
	
	$date=date("Y-m-d");

$sql="INSERT INTO experience_certificate (id,name,type,position,duration_from,duration_to,gender,ay_id,date,fathername,purpose,ref_number) VALUES
('$id','$name','$type','$position','$duration_from','$duration_to','$gender','$acyear','$date','$fathername','$purpose','$ref_number')";

 $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
$lastid=mysql_insert_id();

    if($result){		
     header("Location:exp_certificate_add.php?e_id=$lastid&msg=succ");	   
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
				<li class="no-hover"><a href="exp_certificate_list.php" title="Home">Experience Certificate list</a></li>
                <li class="no-hover">Add New Experience Certificate</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Add New Experience Certificate</h1>                
			<a href="exp_certificate_list.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['msg'];
			if($msg=="succ"){?>			
            <div class="alert success"><span class="hide">x</span>Your Certificate Successfully Created!!!
            <center><a href="exp_certificate_prt.php?e_id=<?php echo $_GET['e_id'];?>" target="_blank"><button class="btn btn-small btn-warning" ><img src="img/icons/packs/fugue/16x16/block--arrow.png"> Click Here To Print Certificate</button></a></center>
            </div>
            <?php } ?>
            
				<div class="block-border">
					<div class="block-header">
						<h1>Add New Experience Certificate</h1><span></span>
					</div>
					<form id="validate-form" class="block-content form" action="" method="post">
						 <div class="_50">
                                    <p>
                                        <label for="textfield">Select Member </label>
                                        <select name="member" onchange="fill()"  class="required form-control select2-input" id="member" style="width:100%">
										<option value="">Please Select</option> 
                                        <?php
											$sql = mysql_query("SELECT others_id as id,fname,lname, s_pname as father,gender,'others' as source FROM `others` union SELECT driver_id,fname,lname,d_pname as father,gender,'driver' as source FROM `driver` union SELECT staff_id,fname,lname,s_pname as father,gender,'staff' as source FROM `staff` ");
											while ($thisrow = mysql_fetch_array($sql)){	

											    $stype=$thisrow['source'];
											    if($stype=="others"){
											        $qry2=mysql_fetch_array(mysql_query("select * from others where others_id='$thisrow[id]'"));
											    
											        $qry1=mysql_fetch_array(mysql_query("select * from others_category where oc_id='$qry2[category_id]'"));
											        $stype=$qry1["category_name"];
											        	
											    }
                                               
											$sname=$thisrow['fname'].".".$thisrow['lname'];
											$father=$thisrow['father'];
											$gender=$thisrow['gender'];
											$id=$thisrow['id'];
											?>
									  <option value="<?php echo $id.",".$sname.",".$gender.",".$father.",".$stype;?>"><?php echo $thisrow['id']."-".$sname." - ".$stype;?></option>  
                                        <?php } ?>
									</select>
                                    </p>
                                    </div>
                        <div class="_50">
							<p>
                                <label for="textfield">Name</label>
                                <input   name="name" id="name" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Gender</label>
                                <input   name="gender" id="gender" class="required" type="text" value="" />
                            </p>
						</div>
                        <div class="_50">
							<p>
                                <label for="textfield">Father Name</label>
                                <input id="fname" name="fname" class="required" type="text" value="" />
                            </p>
						</div>
                      
                        <div class="_50">
							<p>
                                <label for="textfield">Duration From</label>
                                <input id="datepicker" style="width: 450px;" name="d_from" class="required" type="text" value="" />
                            </p>
						</div>
						 <div class="_50">
							<p>
                                <label for="textfield">Duration To</label>
                                <input id="datepicker1" style="width: 450px;"  name="d_to" class="required" type="text" value="" />
                            </p>
						</div>
						
						  <div class="_100">
							<p>
                                <label for="textfield">Experience Position Name</label>
                                <input id="position" name="position" class="required" type="text" value="" />
                            </p>
						</div>
						
						
						 <div class="_100">
							<p>
                                <label for="textfield">purpose<font color="red">*</font></label>
                                <input id="purpose"  name="purpose" class="required" type="text" value="" />
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
  <!-- <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script> jQuery UI -->
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
		$( "#datepicker" ).Zebra_DatePicker({
       
      	  pair: $('#datepicker1'),
			format: 'd.m.Y'
    });				

		$( "#datepicker1" ).Zebra_DatePicker({
			direction: 1,
			format: 'd.m.Y'
		 
		});		

		$(".Zebra_DatePicker").css('top', "303px");
		$(".Zebra_DatePicker .dp_monthpicker").css('width', "203px");
		$(".Zebra_DatePicker .dp_yearpicker").css('width', "203px");
	});
	
 
    function fill() {
    	var array = $('#member').val().split(",");
    	 var n=array[1];
    	 var g=array[2];
    	 var f=array[3];
        $('#name').val(n);
        $('#gender').val(g);
        $('#fname').val(f);      
        
     
    }
  </script>
 <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
 <script src="js/jquery-migrate-1.2.1.js"></script>
  <script src="payroll/js/plugins/select2/select2.js"></script>
  <link rel="stylesheet" href="payroll/js/plugins/select2/select2.css" type="text/css" />
  <script>

$(function () {

	$('.select2-input').select2({
					placeholder: "Select..."
				});
			// Just for the demo
		 

});

</script> 

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>