<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 ?>
 <style type="text/css">
 .subclass{
  display: none;
 }
 </style>
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
                <li class="no-hover"><a href="board_select_bfeesinvoice.php" title="<?php echo $board['b_name'];?>"><?php echo $board['b_name'];?></a></li>
				<li class="no-hover">Cashier Report</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			<div class="grid_12">
				<h1>Cashier Report</h1>
                
                <a href="fees_collection.php?bid=<?php echo $bid;?>" title="add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
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
                 </div><br><br>
                 <div class="_25" style="float:left">
                <label for="select">Status :</label>
                <select name="status" onchange="redirect(this.value);" id="status">
                    <option value="All" <?php if($_GET['status']=="All"){echo 'selected';}?>>All</option>
                    <option value="Received" <?php if($_GET['status']=="Received"){echo 'selected';}?>>Received</option>
                    <option value="Rejected" <?php if($_GET['status']=="Rejected"){echo 'selected';}?>>Pending</option>
                </select>
                 </div>
				<?php $msg=$_GET['save'];
				if($msg=="save"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Saved Successfully !!!</div>
        <?php } 
				 				
				?>   
                
			</div>
            <div class="grid_12">
            <?php $msg=$_GET['save'];
      if($msg=="success"){?>     
            <div class="alert success"><span class="hide">x</span>Your Record Saved Successfully!!!</div>
            <?php } ?>
				<div class="block-border">
					<div class="block-header">
                    	<h1>Cashier Report</h1>
                        <span></span>
					</div>

					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                  
                                    <th>Cashier Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total Amount</th>
                                    <th>Amount Given</th>
                                    <th>Status</th>
                                     <th>Details</th>
								</tr>
							</thead>
							<tbody>
                            <?php
              if($_GET['status']) {
    
              if($_GET['status']=="All") { 
							$qry=mysql_query("SELECT * FROM feescollection WHERE ay_id=$acyear  ORDER BY id DESC");
						} else if($_GET['status']=="Received"){
							$qry=mysql_query("SELECT * FROM feescollection WHERE  ay_id=$acyear AND status=0 ORDER BY id DESC");
						} else {
							$qry=mysql_query("SELECT * FROM feescollection WHERE  ay_id=$acyear AND status=1 ORDER BY id DESC");
						}

					} else {
						  $qry=mysql_query("SELECT * FROM feescollection WHERE ay_id=$acyear  ORDER BY id DESC");
					}
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{ 
				
				?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $count; ?></center></td>
                   <td><center><?php echo $row['cashier']; ?></center></td>
								<td><center><?php echo date("d/m/Y",strtotime($row['sdate'])); ?></center></td>
                                <td><center><?php echo date("d/m/Y",strtotime($row['edate'])); ?></center></td>
                              
                                <td><center><?php echo number_format($row['amount_total'],2); ?></center></td>
                                  <td><center><?php echo number_format($row['amount_given'],2); ?></center></td>
                                <td>
                                	<?php if($row['status']==1)
                                	  echo '<a href="#"><button class="btn btn-red btn-small">Pending</button></a>';
                                	  else
                                	  	echo '<a href="#"><button class="btn btn-primary btn-small">Received</button></a>';
                                	?>
                                </td>
                                <td>
                                <center>
                                <input class="btn btn-grey" id="icon<?= $row['id']?>" type="button" style="padding: 2px !important;width: 25px !important;" value="+" onclick="cashierDetail(<?= $row['id']?>);">&nbsp;&nbsp;
                                <a href="fees_collection_details.php?sdate=<?php echo date("d/m/Y",strtotime($row['sdate']));?>&edate=<?php echo date("d/m/Y",strtotime($row['edate']));?>&cashier=<?= $row['cashier']?>&id=<?= $row['id']?>" target="_blank"><button class="btn btn-primary btn-small"><img src="img/icons/packs/fugue/16x16/pictures-stack.png"> View</button></a></center>
                                </td>
								</tr>
                <tr id="details_<?= $row['id']?>" class="subclass">
                <td colspan="8">
                <table style="width:100%;">
                  <tr><th style="width:53px;">S.No</th><th style="width:767px;">Fees</th><th>Amount</th></tr>
                  <?php
                    $n=1;
                    $id=$row['id'];
                    $sub=mysql_query("select * from feescollection_child where id=$id");
                    while($red=mysql_fetch_assoc($sub)){
                      echo '<tr><td>'.$n.'</td>';
                      echo '<td>'.$red['fees'].'</td>';
                      echo '<td style="text-align: right;">'.number_format($red['amount'],2).'</td></tr>';
                      $n++;
                    }
                  ?>
                  <tr><td colspan="2" style="text-align: right;">Total</td><td style="text-align: right;"><?= number_format($row['amount_total'],2)?></td></tr>
                </table>

                </td>
                </tr>
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
	//$('#table-example').dataTable();
  
  //Code that uses jQuery's $ can follow here.
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
	function redirect(val){
    var cid =document.getElementById('bid').value;
    window.location.href = 'cashierreport.php?status='+val;   
  }
	function change_function() { 
     var cid =document.getElementById('bid').value;
	 window.location.href = 'bfeesinvoice.php?bid='+cid;	  
	} 
  function cashierDetail(id){
     $('#details_'+id).toggle('show',function(){
        $(this).is(":visible") ? $('#icon'+id).val("-") : $('#icon'+id).val("+");
     });
   }
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>