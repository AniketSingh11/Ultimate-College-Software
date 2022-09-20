<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //echo $_SESSION['uname'];
 //echo $acyear;
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
				<li class="no-hover">Contact Details List</li>
			</ul>
		</div> <!--! end of #title-bar -->
		
		<div class="shadow-bottom shadow-titlebar"></div>
		
		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">
			
			<div class="grid_12">
				<h1>Contact Details List</h1>
				<a href="contact_add.php" title="add" style="margin:0px 0 0 10px;"><button class="btn btn-success btn-small "><img src="img/icons/packs/fugue/16x16/user--plus.png">  Add Contact Details</button></a>
                <?php $msg=$_GET['msg'];
				if($msg=="dsucc"){?>
                <div class="alert success"><span class="hide">x</span>Your Record Successfully Deleted !!!</div>
                 <?php } ?> 
			</div>
			
			<div class="grid_6">
				<div class="block-border">
					<div class="block-header">
						<h1>Contact List</h1><span></span>
					</div>
					<div class="block-content">
						<div id="slider">
							<div class="slider-content">
								<ul>
									<li id="a"><a name="a" class="title">A</a>
										<ul>
                                        <?php
                                        $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='A'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
											<?php }  } ?>
										</ul>
									</li>
									<li id="b"><a name="b" class="title">B</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='B'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="c"><a name="c" class="title">c</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='C'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="d"><a name="d" class="title">d</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='D'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="e"><a name="e" class="title">E</a>
										<ul>
											<?php
                                            $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='E'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="f"><a name="f" class="title">f</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='F'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="g"><a name="g" class="title">g</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='G'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="h"><a name="h" class="title">h</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='H'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="i"><a name="i" class="title">i</a>
										<ul>
											<?php
                                            $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='I'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="j"><a name="j" class="title">j</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='J'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="k"><a name="k" class="title">k</a>
										<ul>
											<?php
                                            $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='K'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="l"><a name="l" class="title">l</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='L'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="m"><a name="m" class="title">m</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='M'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="n"><a name="n" class="title">n</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='N'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="o"><a name="o" class="title">o</a>
										<ul>
											<?php
                                            $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='O'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="p"><a name="p" class="title">p</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='P'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="q"><a name="q" class="title">q</a>
										<ul>
											<?php
                                            $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='Q'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="r"><a name="r" class="title">r</a>
										<ul>
											<?php
                                            $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='R'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="s"><a name="s" class="title">s</a>
										<ul>
											<?php
                                            $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='S'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="t"><a name="t" class="title">t</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='T'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="u"><a name="u" class="title">u</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='U'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="v"><a name="v" class="title">v</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='V'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="w"><a name="w" class="title">w</a>
										<ul>
											<?php
                                            $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='W'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="x"><a name="x" class="title">x</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='X'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="y"><a name="y" class="title">y</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='Y'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>
									<li id="z"><a name="z" class="title">z</a>
										<ul>
											<?php
                                             $qry=mysql_query("SELECT * FROM contact WHERE status='1'");
										  while($row=mysql_fetch_array($qry))
											{ 
											$ccname=$row['cname'];
											$ccname1=substr($ccname,0,1);
											$ccname1=strtoupper($ccname1);
											if($ccname1=='Z'){											
											?>
											<li><a href="contact_details.php?ctid=<?php echo $row['ct_id'];?>"><?php echo $ccname;?></a></li>
                                            <?php }  } ?>
										</ul>
									</li>                                   
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
            
            <div class="grid_6">
				<div class="block-border">
					<div class="block-header">
						<h1>Contact Person Details</h1><span></span>
					</div>
					<div class="block-content">
                    <?php $ctid=$_GET['ctid'];
					if($ctid){
					$qry1=mysql_query("SELECT * FROM contact WHERE ct_id='$ctid'");
										  $row1=mysql_fetch_array($qry1);					
					?>
					
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th width="49%">Title</th>
									<th width="3px"></th>
									<th width="50%">Details</th>
								</tr>
							</thead>
							<tbody>
								<tr class="gradeX">
									<td>Company Name / Person Name</td>
									<td>:</td>
									<td><strong><?php echo $row1['cname'];?></strong></td>
								</tr>
								<tr class="gradeC">
									<td>Contact Person</td>
									<td>:</td>
									<td><strong><?php echo $row1['cpname'];?></strong></td>
								</tr>
								<tr class="gradeA">
									<td>Gender</td>
									<td>:</td>
									<td><?php if($row1['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></td>
								</tr>
								<tr class="gradeA">
									<td>Email</td>
									<td>:</td>
									<td><?php echo $row1['email'];?></td>
								</tr>
								<tr class="gradeA">
									<td>Address</td>
									<td>:</td>
									<td><?php echo $row1['address'];?></td>
								</tr>
								<tr class="gradeA">
									<td>Mobile</td>
									<td>:</td>
									<td><?php echo $row1['mobile'];?></td>
								</tr>
                                <?php if($row1['phone']){?>
                                <tr class="gradeA">
									<td>Phone</td>
									<td>:</td>
									<td><?php echo $row1['phone'];?></td>
								</tr>
                                <?php } if($row1['desc1']){?>
                                <tr class="gradeA">
									<td>Description</td>
									<td>:</td>
									<td><?php echo $row1['desc1'];?></td>
								</tr>
                                <?php } ?>
							</tbody>
						</table>     
                        <br>
                        <a href="contact_edit.php?ctid=<?php echo $ctid;?>" style="margin:0px 0 0 10px;"><button class="btn btn-warning btn-small "><img src="img/icons/packs/fugue/16x16/user--pencil.png">  Edit Contact Details</button></a>
                        <a href="contact_delete.php?ctid=<?php echo $ctid;?>" onClick="return confirm('are you sure you wish to delete this record');" style="margin:0px 0 0 10px;"><button class="btn btn-error btn-small "><img src="img/icons/packs/fugue/16x16/user--minus.png"> Delete Contact Details</button></a>
                        <br><br>  
                        <?php } else { 
						$qry1=mysql_query("SELECT * FROM contact WHERE ct_id='1'");
										  $row1=mysql_fetch_array($qry1);					
					?>
					
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th width="49%">Title</th>
									<th width="3px"></th>
									<th width="50%">Details</th>
								</tr>
							</thead>
							<tbody>
								<tr class="gradeX">
									<td>School Name</td>
									<td>:</td>
									<td><strong><?php echo $row1['cname'];?></strong></td>
								</tr>
								<tr class="gradeC">
									<td>Contact Person</td>
									<td>:</td>
									<td><strong><?php echo $row1['cpname'];?></strong></td>
								</tr>
								<tr class="gradeA">
									<td>Gender</td>
									<td>:</td>
									<td><?php if($row1['gender']=='M'){ echo 'Male'; }else{ echo"Female"; }?></td>
								</tr>
								<tr class="gradeA">
									<td>Email</td>
									<td>:</td>
									<td><?php echo $row1['email'];?></td>
								</tr>
								<tr class="gradeA">
									<td>Address</td>
									<td>:</td>
									<td><?php echo $row1['address'];?></td>
								</tr>
								<tr class="gradeA">
									<td>Mobile</td>
									<td>:</td>
									<td><?php echo $row1['mobile'];?></td>
								</tr>
                                <?php if($row1['phone']){?>
                                <tr class="gradeA">
									<td>Phone</td>
									<td>:</td>
									<td><?php echo $row1['phone'];?></td>
								</tr>
                                <?php } if($row1['desc1']){?>
                                <tr class="gradeA">
									<td>Description</td>
									<td>:</td>
									<td><?php echo $row1['desc1'];?></td>
								</tr>
                                <?php } ?>
							</tbody>
						</table>     
                        <br>
                        <a href="contact_edit.php?ctid=1" title="Edit" style="margin:0px 0 0 10px;"><button class="btn btn-warning btn-small "><img src="img/icons/packs/fugue/16x16/user--pencil.png">  Edit Our Details</button></a>
                        <br><br>  
                        <?php } ?>                
					</div>
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
  
  <script type="text/javascript">
	$().ready(function() {
		
		/*
		 * Form Validation
		 */
		$.validator.setDefaults({
			submitHandler: function(e) {
				$.jGrowl("Form was successfully submitted.", { theme: 'success' });
				$(e).parent().parent().fadeOut();
				v.resetForm();
				v2.resetForm();
				v3.resetForm();
			}
		});
		var v = $("#create-user-form").validate();
		jQuery("#reset").click(function() { v.resetForm(); $.jGrowl("User was not created!", { theme: 'error' }); });
		
		var v2 = $("#write-message-form").validate();
		jQuery("#reset2").click(function() { v2.resetForm(); $.jGrowl("Message was not sent.", { theme: 'error' }); });
		
		var v3 = $("#create-folder-form").validate();
		jQuery("#reset3").click(function() { v3.resetForm(); $.jGrowl("Folder was not created!", { theme: 'error' }); });
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			validateform.resetForm();
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});
		
		$('#slider').sliderNav();
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