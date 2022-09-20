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
				<li class="no-hover">Expenses Sub&Inner Category list</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			
                 
                 
        	<div class="grid_12">
				<h1>Expenses Sub&Inner Category list</h1>
				<a href="ecategory_add.php" title="add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New category</button></a>
                <a href="esubcategory_add.php" title="add"><button class="btn btn-small btn-success" ><img src="img/icons/packs/fugue/16x16/table--plus.png"> Add New Subcategory</button></a>
				<?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?>     
                 
                   <div class="_25" style="float:right">
                <label for="select">Category :</label>
                
                                    <select name="exc_id" id="exc_id" class="required" onchange="change_function()">
                                	<?php
                                	    $exc_id=$_GET['exc_id'];
                                	    
                                	    if(!$exc_id)
                                	    {

                                	 $qry1=mysql_fetch_array(mysql_query("select * from ex_category"));

                                	  $exc_id=$qry1["exc_id"];
                                	    }
                                	
                                            $classl = "SELECT * FROM ex_category";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            $e=0;
                                            while ($row1 = mysql_fetch_array($result1))
                                            {
                                            $e=$e+1;
                                            ?>
                                          <option value="<?=$row1['exc_id']?>" <?php if($row1['exc_id']==$exc_id){?> selected <?php }?>><?=$row1['ex_category']?></option>
								     	<?php } ?>
                                          </select>
                                         
								 
                 </div>              
			</div>
			
			 
			
            <div class="grid_12">
				<div class="block-border">
					<div class="block-header">
                    	<h1>Expenses Sub&Inner Category list</h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
								 
                                    <th><center>Expenses Sub & Inner Category</center></th>
                                   
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php 
							$qry=mysql_query("SELECT * FROM ex_insubcategory where category='$exc_id'  order by count asc");
							$cont=1;
			  while($row=mysql_fetch_array($qry))
        		{
                  $category_id=$row["category"];
                  $count=$row["count"];
                  $qry1=mysql_fetch_array(mysql_query("select * from ex_category where exc_id='$category_id'"));
                  $category_name=$qry1["ex_category"];
                 
                  
                  if($count!=0)
                  {
                      
                      $subcat=array();
                      for($j=1;$j<=20;$j++)
                      {
                      $sub_id=$row["sub$j"."_id"];
                      
                          if($sub_id!=0){
                      array_push($subcat,$sub_id);
                      }
                      }
                      
                      $insub_name="";
                      foreach ($subcat as $val){
                      
                      $qry1=mysql_fetch_array(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$val'"));
                      $insub_name.=$qry1["sub_name"]."&nbsp;>&nbsp;";
                      
                      }     
                      
                
                  
                  }
                 // echo 
        		    ?>
								<tr class="gradeX">
									<td class="sno center"><center><?php echo $cont; ?></center></td>
									<!-- <td><center><?php echo $category_name; ?></center></td> -->
								    <td><center><?php echo $insub_name.stripslashes($row['sub_name']); ?></center></td>
								
								
							  <td class="action"><a href="esubcategory_edit.php?exsid=<?php echo $row['exs_id'];?>" title="Edit"><img src="./img/edit.png" alt="edit"></a> <a href="esubcategory_delete.php?exsid=<?php echo $row['exs_id']; ?>" class="delete" title="delete" onClick="return confirm('are you sure you wish to delete this record');"><img src="./img/del.png" alt="delete"></a></td>
								</tr> 
                                 <?php 
							$cont++;
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
			validateform.resetForm();
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
	});

	function change_function() {		 
	     var exc_id =document.getElementById('exc_id').value;
		 window.location.href = 'exponses_subcategory.php?exc_id='+exc_id;	 
		} 
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  <?php  include("roll_footer.php");?> 
</body>
</html>
<? ob_flush(); ?>