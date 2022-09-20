<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 include("checking_page/staff.php"); 
 
 if($_SERVER['REQUEST_METHOD']=="POST")
 {
     
     $j=1;
     if($_FILES["file$j"]["name"]==""||$_FILES["file$j"]["name"]==" "){
     
         ?>
      	<script>
      alert("Uploaded Failed!");
       
     </script>
      	<?php
      
      }else{
         
          $value = explode(".", $_FILES["file$j"]["name"]);
          $extension = strtolower(array_pop($value));   //Line 32
         
      
       
      //	$extension =  end(explode(".",$filename));
      
      	if($extension=="XLSX"||$extension=="xlsx"||$extension=="XLS"||$extension=="xls"){
     set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
     
     /** PHPExcel_IOFactory */
     include 'PHPExcel/IOFactory.php';
     
      
      $date=date("Y-m-d");
      
     
      
      $fail_list=array();
      $fail_reason=array();
      
     
      
      
      		$ban="up_files/".time().".".$extension;
      		move_uploaded_file($_FILES["file$j"]["tmp_name"],$ban);
      		$file=$ban;
      
     
     //$file = "up_files/1416816513.xlsx";
     
     //Open the file
     $objReader = PHPExcel_IOFactory::createReaderForFile($file);
     $objReader->setReadDataOnly(true);
     $PHPExcelObject = $objReader->load($file);
     
     $sheetCount = $PHPExcelObject->getSheetCount();
     
     $PHPExcelObject->setActiveSheetIndex(0);
     
     $date_regex = '/^(0[1-9]|1[012])[\/\/.](0[1-9]|[12][0-9]|3[01])[\/\/.](19|20)\d\d$/';
     
     
     $hiredate = '12/14/2014';
     
     if (!preg_match($date_regex, $hiredate)) {
     	echo '<br>Your hire date entry does not match the YYYY-MM-DD required format.<br>';
     }else{
     	
     	//echo "fsdsd";
     }
     
     // put this at beginning of your script
     $saveTimeZone = date_default_timezone_get();
     date_default_timezone_set('UTC'); // PHP's date function uses this value!
     
     $highestRow=$PHPExcelObject->getActiveSheet()->getHighestRow(); 
     
     for ($i=2;$i<=$highestRow;$i++) {
     	
     	
     	$array_name1=$PHPExcelObject->getActiveSheet()->getCell('B'.$i)->getValue();
     	$array_name2=$PHPExcelObject->getActiveSheet()->getCell('C'.$i)->getValue();
     	$array_name3=$PHPExcelObject->getActiveSheet()->getCell('D'.$i)->getValue();
     	$array_name4=$PHPExcelObject->getActiveSheet()->getCell('E'.$i)->getValue();
     	$array_name5=$PHPExcelObject->getActiveSheet()->getCell('F'.$i)->getValue();
     	$array_name6=$PHPExcelObject->getActiveSheet()->getCell('G'.$i)->getValue();
     	$array_name7=$PHPExcelObject->getActiveSheet()->getCell('H'.$i)->getValue();
     	$array_name8=$PHPExcelObject->getActiveSheet()->getCell('I'.$i)->getValue();
     	$array_name9=$PHPExcelObject->getActiveSheet()->getCell('J'.$i)->getValue();
     	$array_name10=$PHPExcelObject->getActiveSheet()->getCell('K'.$i)->getValue();
     	$array_name11=$PHPExcelObject->getActiveSheet()->getCell('L'.$i)->getValue();
     	$array_name12=$PHPExcelObject->getActiveSheet()->getCell('M'.$i)->getValue();
     	$array_name13=$PHPExcelObject->getActiveSheet()->getCell('N'.$i)->getValue();
     	
     	
     	$array_name1=str_replace("'","",$array_name1);
     	$array_name2=str_replace("'","",$array_name2);
     	$array_name3=str_replace("'","",$array_name3);
     	$array_name4=str_replace("'","",$array_name4);
     	$array_name5=str_replace("'","",$array_name5);
     	$array_name6=str_replace("'","",$array_name6);
     	$array_name7=str_replace("'","",$array_name7);
     	$array_name8=str_replace("'","",$array_name8);
     	$array_name9=str_replace("'","",$array_name9);
     	$array_name10=str_replace("'","",$array_name10);
     	$array_name11=str_replace("'","",$array_name11);
     	$array_name12=str_replace("'","",$array_name12);
     	$array_name13=str_replace("'","",$array_name13);
     	
     	
     	
     	$array_name1=addslashes($array_name1);
     	$array_name2=addslashes($array_name2);
     	$array_name3=addslashes($array_name3);
     	$array_name4=addslashes($array_name4);
     	$array_name5=addslashes($array_name5);
     	$array_name6=addslashes($array_name6);
     	$array_name7=addslashes($array_name7);
     	$array_name8=addslashes($array_name8);
     	$array_name9=addslashes($array_name9);
     	$array_name10=addslashes($array_name10);
     	$array_name11=addslashes($array_name11);
     	$array_name12=addslashes($array_name12);
     	$array_name13=addslashes($array_name13);
      
     	
     	if (!filter_var($array_name7, FILTER_VALIDATE_EMAIL) === false &&  $array_name1!="" && $array_name2!=""&& $array_name3!="" && $array_name4!=""&& $array_name5!=""&& $array_name6!=""&& $array_name8!="")
     	 {
     	     
     	     
     	     $array_name6 = PHPExcel_Shared_Date::ExcelToPHP($array_name6); // 1007596800 (Unix time)
     	    
     	     
     	     $array_name6 = date('d/m/Y', $array_name6); // 06.12.2001 (formatted date)
     	   
     	     $date_split1= explode('/', $array_name6);
     	     if ( ! isset($date_split1[1]) ) {
     	         $date_split1[1] = null;
     	         
     	     }
     	     if ( ! isset($date_split1[2]) ) {
     	         $date_split1[2] = null;
     	     
     	     }
     	     $date_month=$date_split1[1];
     	     $date_day=$date_split1[0];
     	     $date_year=$date_split1[2];
     	    
     	     $array_name13 = PHPExcel_Shared_Date::ExcelToPHP($array_name13); // 1007596800 (Unix time)
     	     
     	     	
     	     $array_name13 = date('d/m/Y', $array_name13); // 06.12.2001 (formatted date)
     	 
     	  $query="select * from staff where n_email ='$array_name7'";
     	  $res=mysql_query($query);
     	  $chk_email=0;
     	  $err_msg="";
     	  while($row=mysql_fetch_array($res))
     	  {
     	      $err_msg.="Email address already Given &nbsp; ";
     	      $chk_email=1;
     	      
     	  }
     	  
     	
     	 
     
     	  $query="select * from staff where staff_id ='$array_name1'";
     	  $res=mysql_query($query);
     	 
     	  $chk_staffid=0;
     	  while($row=mysql_fetch_array($res))
     	  {
     	      $err_msg.="Staff Id already Given";
     	      $chk_staffid=1;
     	       
     	  }
     	  if($chk_email==0 && $chk_staffid==0){     	      
     	      $s_type="Teaching";     	      
     	      $sql="INSERT INTO staff (staff_id,fname,lname,s_type,s_pname,dob,day,month,year,gender,email,password,phone_no,address1,city,country,status,qualf,doj) VALUES
     	      ('$array_name1','$array_name2','$array_name3','$s_type','$array_name4','$array_name6','$date_day','$date_month','$date_year','$array_name5','$array_name7','$array_name1','$array_name8','$array_name9','$array_name10','$array_name11','1','$array_name12','$array_name13')";
     	      $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
     	      
     	  }else{
     	      array_push($fail_list,$array_name1);
     	      array_push($fail_reason,$err_msg);     	      
     	  }
     	}
     }
      
      
     
      	}// extension
      	date_default_timezone_set($saveTimeZone);
      	 ?> 
       
      	 	<?php
      	
      }//file type
     
     
     
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
				<li class="no-hover"><a href="staff.php" title="Home">Staff Management</a></li>
                <li class="no-hover">Import Staff Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
		 
		 
		 
		 
		 
			<div class="grid_12">
				<h1>Import Staff Management</h1>
             <a href="staff.php" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
				<?php if($_SERVER['REQUEST_METHOD']=="POST")
				{
				 ?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Imported !!!</div>
                 <?php  }?>     
                  <a href="Download sample staff data.xlsx" target="_blank" style="margin:0px 10px 0 0px; float:right;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Sample File</button></a>
                       
                       <?php if($_SERVER['REQUEST_METHOD']=="POST" &&  count($fail_list)>0 ){?>
                         <table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Staff ID</center></th>
                                   
                                    <th>Failed Reason</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
                            $f=1;
							 foreach ($fail_list as $value) {
							  
        		 ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $f; ?></center></td>
								<td><center><?php echo $value; ?></center></td>
                                <td><center><font color="red"><?php echo $fail_reason[$f-1];  ?></font></center></td>
                                
								</tr> 
                                         <?php $f++; }?>                    																
							</tbody>
						</table>
                         <?php }?>
                          <div class="block-border">
					<div class="block-header">
						<h1>Import Staff Datas</h1><span></span>
					</div>
					 
					
					<form id="validate-form" class="block-content form" action="" method="post" enctype="multipart/form-data">
						<div class="_100">
							<p>
								<label for="file">Upload a file</label>
								<input type="file" name="file1" id="file1" clas="=required"/>
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
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		/*
		 * DataTables
		 */
		
		$("#tab-panel-1").createTabs();
		
	});
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
<? ob_flush(); ?>