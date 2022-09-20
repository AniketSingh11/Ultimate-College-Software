<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php");  
?>
 <link rel="stylesheet" href="Book_inventory/stylesheets/sample_pages/invoice.css" type="text/css" />
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
		/*$bid=$_GET['bid'];
		$boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid"); 
								  $board=mysql_fetch_array($boardlist);*/
		
		?>
    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar">
			<ul id="breadcrumbs">
				<li><a href="dashboard.php" title="Home"><span id="bc-home"></span></a></li>
                <li> Expenses Report</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
            <div class="grid_12">
            <div class="block-border">
					<div class="block-header">
						<h1>Select Start and End Date</h1><span></span>
					</div>
					
					<?php 	$sdate=$_GET['sdate'];
					$edate=$_GET['edate'];
					$excid=$_GET['exc_id'];
					$exsid=$_GET['exsid'];
					?>
					
					<form id="validate-form" class="block-content form" action="" method="get" action="">
						<div class="_25">
							<p>
								<label for="select">Start Date : <span class="error">*</span></label>
                               <input id="datepicker" name="sdate" class="required" type="text" value="" /> 	
							</p>
						</div>
                        <div class="_25">
							<p>
								<label for="select">End Date : <span class="error">*</span></label>
                               <input id="datepicker1" name="edate" class="required" type="text" value="" /> 	
							</p>
						</div>
                         <div class="_25">
							<p>
								<label for="select">Select Expense Category : <span class="error">*</span></label>
                       <select name="exc_id" id="exc_id" onchange="change_function()" class="required">
						  <option value="All">All Category</option>
                             <?php  $qry=mysql_query("SELECT * FROM ex_category");
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{	?> 
							<option value="<?php echo $row['exc_id'];?>"><?php echo $row['ex_category'];?></option>                                                           
               <?php  } ?>
               </select>
               			</p>
						</div>
						 
						 <div class="_25" >
               <p> <label for="select">Expenses SubCategory:</label>
                                	  <select name="exsid" id="exsid" class="required" >
                               <option value="All">All</option>
                                <?php $classl = "SELECT *  FROM ex_insubcategory where count='0'";
                                    $result1 = mysql_query($classl) or die(mysql_error());
                                while ($row1 = mysql_fetch_assoc($result1))
                                {
                                    $subname=$row1["sub_name"];
                                    $c_id=$row1["exs_id"];
                                    $category=$row1["category"];
                            ?>
                              <option style='display:none;' data_value='<?=$category?>' value='<?=$c_id?>'><?=$subname?></option>
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
                                
                                                $qry1=mysql_fetch_array(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$val'"));
                                                $insub_name.=$qry1["sub_name"]."&nbsp;>&nbsp;";
                                
                                                }
                                
                                
                                                ?>
                                     <option style='display:none;' data_value='<?=$row1['category']?>' value='<?=$row1['exs_id']?>' <?php if($exsid==$row1['exs_id']){ echo "selected";}?>><?=$insub_name?><?=$row1['sub_name']?></option>
                                     <?php    }
                                                                
                                         }
                                ?>
                                </select>
								</p>
                       </div> 
                 
                 
					 
                        <div class="clear"></div>
						<div class="block-actions">
							<ul class="actions-left">
								<li><a class="button red" id="reset-validate-form" href="javascript:void(0);">Reset</a></li>
							</ul>
							<ul class="actions-left">
                            	<li><input type="submit" class="button" value="Submit"></li>
							</ul>
						</div>
					</form>
				</div>
            </div>
             <?php 
				
					if(!empty($excid) && $excid!='All') {
					$exclist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid"); 
								  $ecategory=mysql_fetch_array($exclist);
					}
					
					
					if($exsid && $exsid!='All'){
					    $classlist=mysql_query("SELECT * FROM ex_subcategory WHERE exs_id=$exsid");
					    $class1=mysql_fetch_array($classlist);
					}
					$sdate_split1= explode('/', $sdate);		 
		  $sdate_month=$sdate_split1[0];
		  $sdate_day=$sdate_split1[1];
		  $sdate_year=$sdate_split1[2];
		  $startdate= $sdate_year.$sdate_month.$sdate_day;
		 			
					$edate_split1= explode('/', $edate);		 
		  $edate_month=$edate_split1[0];
		  $edate_day=$edate_split1[1];
		  $edate_year=$edate_split1[2];
		  
		  $enddate= $edate_year.$edate_month.$edate_day;
					
					if($sdate && $edate && $excid){ 
					
					$qry1="SELECT * FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "'";
							if(!empty($excid) && $excid!='All') { $qry1 .= " AND exc_id = '" . $excid. "'"; }
							if($exsid && $exsid!='All'){
							    $qry1.=" and  exs_id=$exsid";
							}
							$qry1=mysql_query($qry1);
							$total=0;
			  while($row1=mysql_fetch_array($qry1))
        		{
					$total +=$row1['amount'];
				}?>
                <div class="grid_12"><br>
                <h1> Expenses Report</h1>
                <span style="">Expenses Category : <br><strong><?php if($excid=='All'){ echo "All";}else{ echo $ecategory['ex_category']; }?></strong>
                <?php  if($exsid && $exsid!='All'){?>  <strong>--<?php  echo "(".$class1['sub_cname'].")";?></strong><?php  } ?></span>
               <span style="margin-left:20px;"><a href="exponse_export.php?sdate=<?php echo $sdate;?>&edate=<?php echo $edate;?>&exc_id=<?php echo $excid;?>&exs_id=<?php echo $exsid;?>" style="width:100px"><button class="btn btn-small btn-green"><img src="img/icons/packs/fugue/16x16/inbox-download.png"> Download Report</button></a></span>
                <span style="margin:0px 50px 10px 0px; float:right;"><img src="img/icons/packs/fugue/16x16/calendar-next.png"> Start Date : <strong> <?php echo$sdate; ?></strong> | <img src="img/icons/packs/fugue/16x16/calendar-previous.png"> End Date : <strong><?php echo $edate; ?></strong> | <img src="img/icons/packs/fugue/16x16/calculator-scientific.png"> Total : <strong>Rs. <?php echo number_format($total,2); ?></strong> </span>
                <br><br>
				<div class="block-border">
					<div class="block-header">
                    	<h1> Expenses Report (<?php if($excid=='All'){ echo "All";}else{ echo $ecategory['ex_category']; if($exsid && $exsid!='All'){ echo "-".$class1['sub_cname']; }} ?>)</h1>                       
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
									<th><center>Category</center></th>
                                    <th><center>Sub Category</center></th>
                                    <th><center>Receipt No</center></th>
                                    <th><center>Date</center></th>
                                    <th><center>Title</center></th>
                                    <th><center>Description</center></th>
                                    <th><center>Amount</center></th>                                    
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry="SELECT * FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "'";
							if(!empty($excid) && $excid!='All') { $qry .= " AND exc_id = '" . $excid. "'"; }
							if($exsid && $exsid!='All'){
							    $qry.=" and  exs_id=$exsid";
							}
							$qry=mysql_query($qry);
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
        		    $excid1=$row['exc_id'];
        		    $exsid=$row['exs_id'];
        		    $qry1=mysql_fetch_array(mysql_query("select * from ex_insubcategory where exs_id='$exsid'"));
        		    $subcname=$qry1["sub_name"];
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
        		    	
        		    $qry1=mysql_fetch_array(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$val'"));
        		    $insub_name.=$qry1["sub_name"]."&nbsp;>&nbsp;";
        		    	
        		    }
        		    $expenselist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid1");
        		    $expenses=mysql_fetch_array($expenselist);
        		    ?>
								<tr class="gradeX">
								<td class="sno center"><center><?php echo $count; ?></center></td>
								 <td><center><?php echo $expenses['ex_category']; ?></center></td>
                                 <td><center><?php echo $insub_name.$subcname; ?></center></td>
                                <td><center><?php echo $row['r_no']; ?></center></td>
								<td><center><?php echo $row['date_day']."/".$row['date_month']."/".$row['date_year']; ?></center></td>
                                <td><center><?php echo $row['title']; ?></center></td>
                                <td><center><?php echo $row['des']; ?></center></td>
                                <td><center>Rs. <?php echo number_format($row['amount'],2); ?></center></td>                               
								 <td class="action">
                                 <a href="javascript:void(0);" onclick="$('#info-dialog<?php echo $count;?>').dialog({ modal: true });" title="Details"><img src="./img/detail.png" alt="edit"></a>
                                 <a href="exponse_mng_edit.php?exid=<?php echo $row['ex_id'];?>&excid=<?php echo $excid;?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="exponse_mng_delete.php?exid=<?php echo $row['ex_id']; ?>&excid=<?php echo $excid; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></td>
								</tr> 
                                <div id="info-dialog<?php echo $count;?>" title="<?php echo $class['ex_category']; ?> Expenses Details" style="display: none;">
            	<p>Date : <strong><?php echo $row['date_day']."/".$row['date_month']."/".$row['date_year']; ?></strong></p>
                <p>Title : <strong><?php echo $row['title']; ?></strong></p> 
                <p>Description : <strong><?php echo $row['des']; ?></strong>  </p>   
                <p>Receipt No : <strong><?php echo $row['r_no']; ?></strong>  </p>   
                <p>Amount : <strong>Rs. <?php echo number_format($row['amount'],2); ?></strong>  </p>   
                </div>                				
			</div> <!--! end of #info-dialog -->
                                 <?php 
							$count++;
							} ?>                               																
							</tbody>
						</table>
					</div>
				</div>			
		<div class="clear height-fix"></div>
        </div>
        <?php } ?>
        </div>
        </div> <!--! end of #main-content -->
  </div> <!--! end of #main -->

    
    <?php include("includes/footer.php");
	?>
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
  <script defer src="js/mylibs/jquery-ui-1.8.15.custom.min.js"></script>
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
			location.reload(); 
			$.jGrowl("Form was Reset.", { theme: 'error' });
		});		
		
		/*
		 * Datepicker
		 */
		$( "#datepicker" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
		$( "#datepicker1" ).Zebra_DatePicker({
        format: 'm/d/Y'
    });			
	});


	 function change_function() { 
	     var cid =document.getElementById('exc_id').value;
	     $("#exsid option[data_value]").hide();
	      $("#exsid option[data_value="+cid+"]").show();
		// window.location.href = 'exponse_mng.php?excid='+cid;	  
		}
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