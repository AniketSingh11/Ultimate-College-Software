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
    	<?php $bid=$_GET['bid'];
    	$ss_id=$_GET['ssid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);	

								  function total_amount($b,$c,$fdis,$acyear,$ftype,$latejoin)
								  {
								      $fr=array();
									  $fr1=array();
								      $tquery=mysql_query("select * from frate where ay_id='$acyear' and   b_id='$b' and  c_id='$c'");
								      while($trow=mysql_fetch_array($tquery)){
								          $fr_id=$trow["fr_id"];
										  $fg_id=$trow["fg_id"];
								          $permissions_check1 = explode(',', $latejoin);	
										  if((!$latejoin) || ($latejoin && in_array($fg_id, $permissions_check1)) || ($latejoin && $fg_id=='4')){
								          array_push($fr,$fr_id);
										  }
										  if(($latejoin && !in_array("1", $permissions_check1))){
											  array_push($fr1,$fr_id);
										  }
								      }
								      $frs=implode(",",$fr);
									  $frs1=implode(",",$fr1);
								      $tot=0;
								      $tquery=mysql_query("select * from frate_value where  fr_id IN ($frs) and fdis_id='$fdis'  and ftype in ($ftype) ");
								      while($trow=mysql_fetch_array($tquery)){
								           
								          $tot +=$trow['dis_value'];
								      }
									  if(!empty($fr1)){
									  $tquery=mysql_query("select * from frate_value where  fr_id IN ($frs1) and fdis_id='$fdis'  and ftype in (1) ");
								      while($trow=mysql_fetch_array($tquery)){								           
								          $tot +=$trow['dis_value'];
								      }
									  }	
								  
								      return $tot;
								      	
								  }
								  
								  function paid_amount($b,$c,$s,$acyear,$ssid)
								  {
								      $fi=array();
								      $tquery2=mysql_query("select * from finvoice  where ss_id='$ssid' and c_id='$c' and s_id='$s' and bid='$b' and  ay_id='$acyear'");
								      while($trow2=mysql_fetch_array($tquery2)){
								          $fi_id=$trow2["fi_id"];
								  
								          array_push($fi,$fi_id);
								      }
								      	
								      $fis=implode(",",$fi);
								  
								  
								      $ptotal=0;
								      $tquery1=mysql_query("select * from fsalessumarry  where  fi_id IN ($fis) and fr_id!='0'  ");
								      $d=0;
								      while($trow1=mysql_fetch_array($tquery1)){
								          $d=$d+1;
								          $ptotal=$trow1['amount']+$ptotal;
								           
								      }
								      //  echo $d."-".$ptotal."<br>";
								      return $ptotal;
								      	
								  }
								  	
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li class="no-hover"><a href="board_select_feesinvoice.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Fees Invoice</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		<?php 
		$qry1=mysql_query("SELECT * FROM finvoice WHERE bid=$bid AND ss_id='$ss_id' AND ay_id=$acyear");
							$total=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$tamount=$row1['fi_total'];
					$total +=$tamount;		

					$student=mysql_fetch_array(mysql_query("SELECT * FROM student where ss_id='$ss_id'"));
					$cid=$student['c_id'];
					$sid=$student['s_id'];
					 
					$fdis=$student['fdis_id'];
					$stype=$student['stype'];
					
					if($stype=="Old")
					{
					    $ftype="0";
					}else{
					    $ftype="0,1";
					}
					$f_total=total_amount($bid,$cid,$fdis,$acyear,$ftype);
					$paid=paid_amount($bid,$cid,$sid,$acyear,$ss_id);
				}
				
				if($total==0)
				{
				    $student=mysql_fetch_array(mysql_query("SELECT * FROM student where ss_id='$ss_id'"));
				    $cid=$student['c_id'];
				    $sid=$student['s_id'];
				    
				    $fdis=$student['fdis_id'];
				    $stype=$student['stype'];
					$latejoin=$student['late_join'];
				    	
				    if($stype=="Old")
				    {
				        $ftype="0";
				    }else{
				        $ftype="0,1";
				    }
				    $f_total=total_amount($bid,$cid,$fdis,$acyear,$ftype,$latejoin);
				    
				}
				
				?>
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
				<h1>Fees Invoice List <?php echo "( ".$student['firstname']." ".$student['lastname']." )";?></h1>
                <a onclick="history.go(-1);" style="margin:3px 0 0 20px;"><button class="btn btn-small btn-primary"><img src="img/icons/packs/fugue/16x16/arrow-curve-180-double.png"> Back </button></a>
                <a href="billing.php?bid=<?php echo $bid;?>"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } 
				?>   
                <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-table.png"> Total Fees : <strong>Rs. <?php echo number_format($f_total,2); ?></strong> </span>         
                <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/medal-red.png"> Total Paid   : <strong>Rs. <?php echo number_format($total,2); ?></strong> </span>          
               
                <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/pill--minus.png"> Total Pending : <strong>Rs. <?php echo number_format($f_total-$paid,2); ?></strong> </span>  
               			</div>
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>Fees Invoice List <?php echo "( ".$student['firstname']." ".$student['lastname']." )";?></h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>FR No</center></th>
                                    <th>Student Name</th>
                                    <th>Date</th>
                                    <th>Class-Section</th>
                                    <th>Student Category</th>
                                    <th>Student type</th>
                                    <th>Inovice By</th>
                                    <th>Amount</th>
                                    <th>Invoice Detail</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
                            
                            
                            
                            
                            
                            
							$qry=mysql_query("SELECT * FROM finvoice WHERE bid=$bid AND ss_id='$ss_id' AND ay_id=$acyear");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				$cid=$row['c_id'];
				$sid=$row['s_id'];
				$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid"); 
								  $class=mysql_fetch_array($classlist);
							$sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid"); 
								  $section=mysql_fetch_array($sectionlist);	  
				?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
								<td><center><?php echo $row['fr_no']; ?></center></td>
                                <td><center><?php echo $row['fi_name']; ?></center></td>
                                <td><center><?php echo $row['fi_day']."/".$row['fi_month']."/".$row['fi_year']; ?></center></td>
                                <td><center><?php echo $class['c_name']."/".$section['s_name']; ?></center></td>
                                <td><center><?php echo $row['category']; ?></center></td>
                                <td><center><?php echo $row['stype']; ?></center></td>
                                <td><center><?php echo $row['fi_by']; ?></center></td>
                                <td width="120">Rs. <?php echo number_format($row['fi_total'],2); ?></td>
								<td class="view"><center><a href="feesinvoice_detail.php?fiid=<?php echo $row['fi_id'];?>&bid=<?php echo $bid;?>"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center></td>
								 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
					</div>
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