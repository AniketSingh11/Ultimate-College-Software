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
                <li class="no-hover">Expenses Details</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">        		
			<div class="container_12">		
            <?php 
					$excid=$_GET['excid'];
					$exsid=$_GET['exsid'];
					$aid=$_GET['aid'];
					if($excid){
							 $classlist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid"); 
								  $class=mysql_fetch_assoc($classlist);
					}
					if($aid){
							 $agencylist=mysql_query("SELECT * FROM agency WHERE a_id=$aid"); 
								  $agency=mysql_fetch_assoc($agencylist);
					}
					if($exsid){
					    $classlist1=mysql_query("SELECT * FROM ex_insubcategory WHERE exs_id='$exsid'");
					    $class1=mysql_fetch_assoc($classlist1);
						
						for($j=1;$j<=20;$j++)
                                {
                                $sub_id=$class1["sub".$j."_id"];
                                
                                if($sub_id!=0){
                                   $field=$j;
                                }
                                }
								$fieldno=$field+1;
								$myarray = array();
								array_push($myarray,$exsid);
								$subname="sub".$fieldno."_id";
								$classlist2=mysql_query("SELECT * FROM ex_insubcategory WHERE $subname='$exsid'");
					    		while($class2=mysql_fetch_assoc($classlist2))
                                {
									//$sub_id=$class1["sub".$j."_id"];
									array_push($myarray,$class2['exs_id']);
								}
					}
					//print_r($myarray);
					
								  /*$qry=mysql_query("SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID");
								  while($row=mysql_fetch_assoc($qry))
									{
																				
									}*/
									
								  ?>
			<div class="grid_12">
				<h1><?php if($excid){ echo $class['ex_category'];} else{ echo "All";} ?>  Expenses Details <?php if($aid){ echo "(".$agency['a_name'].")";}?></h1>
                <a href="exponse_mng_new.php?excid=<?php echo $excid;?>" title="add" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New</button></a>
			  <a href="export_exponse.php?excid=<?php echo $excid;?>&exs_id=<?=$exsid?>&aid=<?=$aid?>" title="Download" style="margin-left:10px;"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Download Excel</button></a>
			
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php }
				 			$qry1 ="SELECT status,amount,ex_id FROM exponses WHERE ay_id=$acyear ";
							if($excid || $aid){
								$qry1 .=" AND";
							}
							if($excid && !$aid){
							$qry1 .=" exc_id=$excid";
							}else if(!$excid && $aid){
								$qry1 .=" aid=$aid";
							}else if($excid && $aid){
								$qry1 .=" exc_id=$excid AND aid=$aid";
							}
							if($exsid){
							    //$qry1 .=" and exs_id=$exsid";
								$qry1 .=" AND  exs_id IN (".implode(',',$myarray).")";
							}
							//echo $qry1;			
							$qry1=mysql_query($qry1);
							$total=0;
							$paitotal=0;
			  while($row1=mysql_fetch_assoc($qry1))
        		{
					$status=$row1['status'];
					$tamount=$row1['amount'];
					$exid1=$row1['ex_id'];
					$total +=$tamount;		
					if($status=='1'){
						$paitotal +=$tamount;	
					}else{
						$exbilllist1=mysql_query("SELECT amount FROM exponses_bill_summary WHERE ex_id=$exid1");
						while($exbillsummary=mysql_fetch_assoc($exbilllist1))
						{
							$paitotal +=$exbillsummary['amount'];
						}
					}
				}
				$pending=$total-$paitotal;
				?> 
                <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Pending : <strong>Rs. <?php echo number_format($pending,2); ?></strong> </span> 
				  <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Paid : <strong>Rs. <?php echo number_format($paitotal,2); ?></strong> </span> 
                  <span style="margin:0px 50px 0 0px; float:right;"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Total : <strong>Rs. <?php echo number_format($total,2); ?></strong> </span>
                 <div class="clear"></div>  
				<?php if($excid!=""){?>
				<div class="_25" style="float:right">
                <label for="select">Expenses SubCategory:</label>
                                	  <select name="exsid" id="exsid" class="required" >
                               <option value="">All</option>
                                <?php $classl = "SELECT * FROM ex_insubcategory where count='0'";
                                    $result1 = mysql_query($classl) or die(mysql_error());
                                while ($row1 = mysql_fetch_assoc($result1))
                                {
                                    $subname=$row1["sub_name"];
                                    $c_id=$row1["exs_id"];
                                    $category=$row1["category"];
                            ?>
                              <option style='display:none;' data_value='<?=$category?>' value='<?=$c_id?>'<?php if($exsid==$c_id){ echo "selected"; $selectsubname=$subname;}?> ><?=$subname?></option>
                              <?php 
                                }
                                for($i=1;$i<=20;$i++)
                                {
                                $classl = "SELECT * FROM ex_insubcategory where count='$i' ";
                                $result1 = mysql_query($classl) or die(mysql_error());
                                while ($row1 = mysql_fetch_assoc($result1))
                                {                                 
                                
                                $subcat=array();
                                for($j=1;$j<=20;$j++)
                                {
                                $sub_id=$row1["sub$j"."_id"];
                                
                                if($sub_id!=0){
                                    array_push($subcat,$sub_id);
                                }
                                }
                                    $insub_name="";
                                        foreach ($subcat as $val){                                
                                            $qry1=mysql_fetch_assoc(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$val'"));
                                            $insub_name.=$qry1["sub_name"]."&nbsp;>&nbsp;";
											}
                                            ?>
                                                               <option style='display:none;' data_value='<?=$row1['category']?>'
                                                                value='<?=$row1['exs_id']?>'<?php
																if($exsid==$row1['exs_id']){ echo "selected"; 
															   $selectsubname=$insub_name.$row1['sub_name'];
															   }?>><?=$insub_name?><?=$row1['sub_name']?></option>
                                                             <?php    }
                                
                                                                }
                                ?>
                                </select>
								 
                 </div> <?php }?>
                <div class="_25" style="float:right">
                <label for="select">Expenses Category:</label>
                                	<?php
                                            $classl = "SELECT * FROM ex_category ";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="excid" id="excid" class="required" onchange="change_function()">';
											echo "<option value='' selected>All</option>\n";
											while ($row1 = mysql_fetch_assoc($result1)):
												if($excid ==$row1['exc_id']){
                                                echo "<option value='{$row1['exc_id']}' selected>{$row1['ex_category']}</option>\n";
												} else {
												echo "<option value='{$row1['exc_id']}'>{$row1['ex_category']}</option>\n";
												}
                                            endwhile;
                                            echo '</select>';
                                            ?>
								</select>
                 </div> 
                 <div class="_25" style="float:right">
                <label for="select">Agencies:</label>
                                	<?php
                                            $classl = "SELECT * FROM agency WHERE status=0";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="aid" id="aid" class="required" onchange="change_function1()">';
											echo "<option value=''>All</option>\n";
											while ($row1 = mysql_fetch_assoc($result1)):
											if($row1['a_id']==$aid){
												echo "<option value='{$row1['a_id']}' selected>{$row1['a_name']}</option>\n";
											}else{
												echo "<option value='{$row1['a_id']}'>{$row1['a_name']}</option>\n";
											}
                                            endwhile;
                                            echo '</select>';
                                            ?>
                 </div>       
			</div>
            <div class="grid_12">
            	<div class="block-border">
					<div class="block-header">
                    	<h1><?php if($excid){ echo $class['ex_category'];} else{ echo "All";} ?> Expenses Details <?php  if($exsid){ echo "(".$selectsubname.")"; } ?></h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Category</center></th>
                                    <th><center>Sub Category</center></th>
                                    <th><center>Agency</center></th>
                                    <th><center>Receipt No</center></th>
                                    <th><center>Date</center></th>
                                    <th><center>Title</center></th>
                                    <th><center>type</center></th>
                                    <th><center>Amount</center></th>  
                                     <th><center>Receiver</center></th>  
                                     <th><center>Bill Generated By </center></th>                                          
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry2="SELECT * FROM exponses WHERE ay_id=$acyear ";
							if($excid || $aid){
								$qry2 .=" AND";
							}
							if($excid && !$aid){
							$qry2 .=" exc_id=$excid";
							}else if(!$excid && $aid){
								$qry2 .=" aid=$aid";
							}else if($excid && $aid){
								$qry2 .=" exc_id=$excid AND aid=$aid";
							}
							if($exsid){
							    //$qry2 .=" and  exs_id=$exsid";
								$qry2 .=" AND  exs_id IN (".implode(',',$myarray).")";
							}
							$qry2 .=" ORDER BY ex_id DESC";
							$qry=mysql_query($qry2);
							$count=1;
			  while($row=mysql_fetch_assoc($qry))
        		{
					$aid1=$row['aid'];
					$excid1=$row['exc_id'];
					$exsid1=$row['exs_id'];
					$qry1=mysql_fetch_assoc(mysql_query("select * from ex_insubcategory where exs_id='$exsid1'"));
					$sb_count=$qry1["count"];
					$subcname=$qry1["sub_name"];
					$subcat=array();
					for($j=1;$j<=20;$j++)
					{
					$sub_id=$qry1["sub$j"."_id"];
					
					if($sub_id!=0){
					    array_push($subcat,$sub_id);
					}
					}
					$insub_name="";
					foreach ($subcat as $val){
					
					$qry1=mysql_fetch_assoc(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$val'"));
					$insub_name.=$qry1["sub_name"]."&nbsp;>&nbsp;";
					
					 }
					 $expenselist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid1"); 
								  $expenses=mysql_fetch_assoc($expenselist);
								  
								  $agencylist1=mysql_query("SELECT * FROM agency WHERE a_id=$aid1"); 
								  $agency1=mysql_fetch_assoc($agencylist1);
								  
								  $agencyname=$agency1['a_name'];
								  $status=$row['status'];
								  ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
                                <td><center><?php echo $expenses['ex_category']; ?></center></td>
                                <td><center><?php echo $insub_name.$subcname; ?></center></td>
                                <td><center><?php if($agencyname){ echo $agencyname;}else{ echo "-"; }?></center></td>
                                <td><center><?php echo $row['r_no']; ?></center></td>
								<td><center><?php echo $row['date_day']."/".$row['date_month']."/".$row['date_year']; ?></center></td>
                                <td><center><?php if($row['title']){ echo $row['title']; }else{ echo "-"; }?></center></td>
                                <td><center><?php if($row['type']=='0'){ echo '<button class="btn btn-small btn-success" >Cash Amount</button>'; }else if($row['type']=='1' && $status=='1'){ echo '<button class="btn btn-small btn-warning" >Paid</button>'; }else if($row['type']=='1'){ echo '<button class="btn btn-small btn-error" >Invoiced</button>'; } ?></center></td>
                                <td><center>Rs. <?php echo number_format($row['amount'],2); ?></center></td> 
                                 <td><center><?php echo $row['receiver']; ?></center></td>  
                                 <td><center><?php echo $row['billgenerate'];?></center></td>                                 
								 <td  width="12%">
                                 <a <?php if($row['type']=='0'){ ?>href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" <?php }else{ ?> href="exponse_mng_single.php?exid=<?php echo $row['ex_id'];?>" <?php } ?> title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <?php if($status==0 || ($row['type']=='0' && $status==1)){?>
                                 <a href="exponse_mng_edit.php?exid=<?php echo $row['ex_id'];?>&excid=<?php echo $excid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="exponse_mng_delete.php?exid=<?php echo $row['ex_id']; ?>&excid=<?php echo $excid; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a>
                                 <?php } ?>
                                 <a href="expense_prt.php?exid=<?php echo $row['ex_id'];?>&a_id=<?php echo $agency1['a_id'];?>" title="print" target="_blank"><img src="./img/print.png" alt="print"></a></td>
								</tr> 
                                <?php if($row['type']=='0'){ ?>
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $class['ex_category']; ?> Expenses Details" style="display: none;">
            	<p>Date : <strong><?php echo $row['date_day']."/".$row['date_month']."/".$row['date_year']; ?></strong></p>
                <p>Title : <strong><?php echo $row['title']; ?></strong></p> 
                <p>Description : <strong><?php echo $row['des']; ?></strong>  </p>   
                <p>Receipt No : <strong><?php echo $row['r_no']; ?></strong>  </p>  
                <p>Bill / Receipt No : <strong><?php echo $row['b_no']; ?></strong>  </p>   
                <p>Amount : <strong>Rs. <?php echo number_format($row['amount'],2); ?></strong>  </p>   
                </div>   <?php } ?>
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
	$('#table-example').dataTable({
  'iDisplayLength': 25
});
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
		$("#exsid option[data_value='<?=$excid?>']").show();
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});		
	});
	 function change_function() { 
     var cid =document.getElementById('excid').value;
	 window.location.href = 'exponse_mng.php?excid='+cid+'<?php echo "&aid=".$aid;?>';	  
	}
	function change_function1() { 
     var cid =document.getElementById('aid').value;
	 window.location.href = 'exponse_mng.php?aid='+cid+'<?php echo "&excid=".$excid."&exsid=".$exsid;?>';	  
	}
	 $( "#exsid" ).change(function() {
			var cid=$( "#excid" ).val();
			var sid=$( "#exsid" ).val();
			 window.location.href = 'exponse_mng.php?excid='+cid+"&exsid="+sid+'<?php echo "&aid=".$aid;?>';
			}); 
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