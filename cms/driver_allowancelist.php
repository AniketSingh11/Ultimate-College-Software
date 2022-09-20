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
				<li class="no-hover">Drivers Allowance Management</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Drivers Allowance Management</h1>
              
                 <a href="driver_allowance_add.php"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png">Add Allowance</button></a>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>                   
			</div>
            <div class="grid_12">
            <div class="block-border" id="tab-panel-1">
					<div class="block-header">
						<h1>Drivers Allowance Management</h1>
						<span></span>
						<form action="" method="get">
						<div class="_25"><input id="datepicker" name="s_date" placeholder="Start Date" value="<?=$_GET["s_date"];?>"  style="width: 200px;"  class="required" type="text"  /></div>
                         <div class="_25"><input id="datepicker1" name="e_date" placeholder="End Date" value="<?=$_GET["e_date"];?>" style="width: 200px;"  class="required" type="text"  />
                          
                         </div> 
                         </form> 
                      
					</div>
					
					<?php  $sdate=$_GET['s_date'];
                            $date_split1=explode('/', $sdate);
                            $s_date=$date_split1[2]."-".$date_split1[1]."-".$date_split1[0];
                            $edate=$_GET['e_date'];
                            $date_split1=explode('/', $edate);
                            $e_date=$date_split1[2]."-".$date_split1[1]."-".$date_split1[0];
                            ?>
					<div class="block-content tab-container">
						  
							<br>
							<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Receipt No</center></th>
                                     <th><center>Driver ID</center></th>
                                      <th><center>Driver Name</center></th>
                                       <th><center>Driver Type</center></th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total Days</th>
                                    <th>Total Amount</th>
                                     <th></th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
                           
                            
                            
                          
							$qry1=mysql_query("SELECT * FROM d_allowance where (from_date >= '$s_date' and from_date <= '$e_date') or (to_date >= '$s_date' and to_date <= '$e_date')    ");
							$count=1;
			  while($row1=mysql_fetch_array($qry1))
        		{
                     $driver_id=$row1["driver_id"];
                     
        		    $row=mysql_fetch_array(mysql_query("SELECT * FROM 	driver where driver_id='$driver_id' "));
        		    $fromdate=$row1["from_date"];
        		    $date_split1=explode('-', $fromdate);
        		    	
        		    $from_date=$date_split1[2]."/".$date_split1[1]."/".$date_split1[0];
        		    $todate=$row1["to_date"];
        		    $date_split1=explode('-', $todate);
        		    
        		    $to_date=$date_split1[2]."/".$date_split1[1]."/".$date_split1[0];
        		    
        		    ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row1['receipt_no']; ?></center></td>
								<td><center><?php echo $row['driver_id']; ?></center></td>
                                <td><center><?php echo $row['fname']." ".$row['lname'];  ?></center></td>
                                <td><center><?php echo $row['d_type'];?></center></td>
                                <td><center><?php echo $from_date; ?></center></td>
                                <td><center><?php echo $to_date; ?></center></td>
                                 <td><center><?php echo $row1['working_days']; ?></center></td>
                               <td><center><?php echo $row1['total_amount']; ?></center></td>
                                <td><center><img src="./img/driver/<?php echo $row['photo']; ?>" alt="driver photo" width="40" height="40"></center></td>
                                
                                <td width="100px">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="driver_allowance_edit.php?did=<?php echo $row1['d_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="driver_allowance_delete.php?did=<?php echo $row1['d_id']; ?>&s_date=<?=$_GET["s_date"]?>&e_date=<?=$_GET["e_date"]?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <a href="driverallowance_prt.php?did=<?php echo $row1['d_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a>
                                 </td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $row['driver_id']; ?>, This Driver details" style="display: none;">
                                <center><img src="./img/driver/<?php echo $row['photo']; ?>" alt="Driver photo" width="60" height="60"></center>
				<p>Driver ID : <strong><?php echo $row['driver_id']; ?></strong></p>
                
                 <p>First Name : <strong><?php echo $row['fname']; ?></strong></p> 
                
                <p>Last Name : <strong><?php echo $row['lname']; ?></strong>  </p>   
                
                <p>Driver Type : <strong><?php echo $row['d_type']; ?></strong>  </p>   
                
                <p>Father's Name : <strong><?php echo $row['d_pname']; ?></strong>  </p>   
                
                <p>Date Of Birth :  <strong><?php echo $row['dob']; ?> </strong></p>   
                
                <p>Gender: <strong><?php if($row['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></strong>  </p>   
                
                <p>Religion : <strong><?php echo $row['reg']; ?></strong>  </p>   
                
                <p>Blood Group  :  <strong><?php echo $row['blood']; ?></strong>  </p>   
                
                <p>Position : <strong><?php echo $row['position']; ?></strong> </p>   
                
                <p>Expriences : <strong> <?php echo $row['expriences']; ?></strong></p>   
                
                <p>Email : <strong><?php echo $row['email']; ?></strong> </p>   
                
                <p>Phone No : <strong><?php echo $row['phone_no']; ?></strong>  </p>   
                
                <p>Residence Address : <strong><?php echo $row['address']; ?></strong> </p>   
                
                <p>City  : <strong><?php echo $row['city']; ?></strong>  </p>   
                
                <p>Country : <strong><?php echo $row['country']; ?></strong> </p>   
                
                <p>Pin Code : <strong><?php echo $row['pincode']; ?></strong> </p>  
                
                <center> <?php if($row['status']=='1'){ ?>
                                <button class="btn btn-small btn-success" >Active</button><?php }else{?><button class="btn btn-small btn-gray" >Inactive</button> <?php } ?>
                                </center>
                </div>
                				
			</div> <!--! end of #info-dialog -->
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
                        <br>
					 
					 					
					</div>
					<!--<div class="block-content dark-bg">
						<p>You see an other example on the <a href="charts.html">Charts-Page</a>.</p>
					</div>-->
				</div>
				<!--<div class="block-border">
					<div class="block-header">
                    	<h1>Staffs Management</h1>
                        <span></span>
					</div>
                    <div class="block-content">
						
					</div>
				</div>-->
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
    <script defer src="js/zebra_datepicker.js"></script>
    
    
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
		

  $( "#datepicker").Zebra_DatePicker({
			 
			  pair: $('#datepicker1'),
			format: 'd/m/Y',
			onSelect: function(dateText) {
				var d=$("#datepicker").val(); 
				var d1=$("#datepicker1").val();

				if(d!="Start Date" && d1!="End Date"){    window.location.href="driver_allowancelist.php?s_date="+d+"&e_date="+d1;}
				 
				  }
		});	
	
		$( "#datepicker1" ).Zebra_DatePicker({
			direction: 1,
			format: 'd/m/Y',
			onSelect: function(dateText) {
				var d=$("#datepicker").val(); 
				var d1=$("#datepicker1").val();

				if(d!="Start Date" && d1!="End Date"){  
				window.location.href="driver_allowancelist.php?s_date="+d+"&e_date="+d1; }
				
				  }
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
  
</body>
</html>
<? ob_flush(); ?>