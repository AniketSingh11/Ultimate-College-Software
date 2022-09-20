<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

/*if (isset($_POST['submit']))
{
	$aname=$_POST['aname'];
	$address=$_POST['address'];
	$person=$_POST['person'];
	$mobile=$_POST['mobile'];
		
		$sql="INSERT INTO agency (a_id,a_name,a_address,a_person,a_mobile) VALUES
('','$aname','$address','$person','$mobile')";

$result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if($result){
        header("Location:agency_new.php?msg=succ");
    }
    exit;
}*/

?>
<body>

<div id="wrapper">
	
	<div id="header">
		<h1><a href="dashboard.php">Book Inventory</a></h1>		
		
		<a href="javascript:;" id="reveal-nav">
			<span class="reveal-bar"></span>
			<span class="reveal-bar"></span>
			<span class="reveal-bar"></span>
		</a>
	</div> <!-- #header -->
	
	<div id="search">
		<form>
			<input type="text" name="search" placeholder="Search..." id="searchField" />
		</form>		
	</div> <!-- #search -->
	
	<div id="sidebar">		
		
		 <?php include("sidebar.php"); ?>
				
	</div> <!-- #sidebar -->
	
	<div id="content">		
		
		<div id="contentHeader">
			<h1>Report for Agency Book Management</h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
        <?php 
		$msg=$_GET['msg'];
		if($msg === "succ"){
		?>
        <div class="notify notify-success">						
						<a href="javascript:;" class="close">&times;</a>						
						<h3>Success Notifty</h3>						
						<p>Your data successfully created!!!</p>
					</div>
			<?php } ?>
			
			<div class="grid-24">
				
				<div class="widget">
						
						<div class="widget-header">
                         
							<span class="icon-article"></span>
							<h3>Report for Agency Book Management</h3>
						</div> <!-- .widget-header -->
						  
						<div class="widget-content">
							
							<form class="form uniformForm validateForm" method="get" action="report_bookagency.php" >
								  <div class="grid-8">
								<div class="field-group">
									<label for="required">Agency Name:</label>
									<div class="field">
                                     <?php
                                            $agencyl = "SELECT a_id,a_name FROM agency where a_name!=''";
                                            $result = mysql_query($agencyl) or die(mysql_error());
                                            ?>
                                            <select name="agency" id="agency" class="validate[required]">
                                             <option value="">Select Main menu </option>
                                             <option value="All" <?php if("All"==$_GET["agency"]){ echo "selected"; }?>>All Agency </option>
                                             <?php 
											while ($row = mysql_fetch_assoc($result)){
											    ?>
                                               <option value='<?=$row['a_id']?>' <?php if($row['a_id']==$_GET["agency"]){ echo "selected"; }?>><?=$row['a_name']?></option>
                                                <?php } ?>
                                             </select> 
                                             																				
									</div>
								</div> 
								</div>
									<div class="field-group">		
									<label>Class<span class="error"> * </span>:</label>			
									<div class="field">
                                    <?php
                                            $classl = "SELECT c_id,c_name FROM class WHERE b_id=$brdid AND ay_id=$acyear";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            ?>
                                             <select name="class" id="class" class="validate[required]" >
                                              <option value="">Select Main menu</option> 
                                              <option value="All" <?php if("All"==$_GET["class"]){ echo "selected"; }?>>All Class</option>
                                              <?php 
											while ($row1 = mysql_fetch_assoc($result1))
											{
											    ?>
											  <option value='<?=$row1[c_id]?>' <?php if($row1[c_id]==$_GET["class"]){ echo "selected"; }?>><?=$row1['c_name']?></option>
											  <?php }?>
                                             </select>                                            
									</div>		
								</div>
								<div class="actions">						
									<button type="submit" Value="submit" class="btn btn-error">Submit</button>
								</div> <!-- .actions -->								
							</form>							
						</div> <!-- .widget-content -->						
					</div>
				
			</div> <!-- .grid -->
            <?php if(isset($_GET["agency"]))
                        { ?>	
            <div class="grid-24">
				<div class="widget widget-table">
						<div class="widget-header">
                        <a href='export_bookagency.php?agency=<?=$_GET["agency"]?>&class=<?=$_GET["class"]?>&b_id=<?=$brdid?>&ay_id=<?=$acyear?>'><button   Value="Download Excel" class="btn btn-success">Download Excel</button></a>
							<span class="icon-list"></span>
							<h3 class="icon chart">Report for Agency Book Management</h3>		
						</div>
						<div class="widget-content">
							<table class="table table-bordered table-striped data-table">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Things Name</th>
								<th>Qty Sold</th>
                                <th>Qty Left</th>
                                <th>Market Price</th>
                                <th>Price</th>
                                <th>Purchase Date</th>
                                <th>Class - Group</th>
                                <th>Category</th>
								<th>Agency</th>							 
							</tr>
						</thead>
						<tbody>
                        <?php 
                        $qry="";
                        if(isset($_GET["agency"]))
                        {
                        $agency_val=$_GET["agency"];
                        $class=$_GET["class"];                        
                        if($agency_val=="All"){
                            $qry.="SELECT * FROM book Where  brdid=$brdid AND ay_id=$acyear ";
                        }else{
                            $qry.="SELECT * FROM book Where a_id=$agency_val AND brdid=$brdid AND ay_id=$acyear ";
                        }
                        if($class=="All"){
                            $qry.=" AND c_id!=''";
                        }else{
                            $qry.=" AND c_id='$class'";
                        }
                        }else{
                            $qry.="SELECT * FROM book Where  brdid=$brdid AND ay_id=$acyear ";
                        }
                        
            //   	$qry=mysql_query("SELECT * FROM book Where type='B' AND brdid=$brdid AND ay_id=$acyear");
							$count=1;
							$qry=mysql_query($qry);
			  while($row=mysql_fetch_array($qry))
        		{  
        		    $cid=$row['c_id']; 
					$sid=$row['s_id']; 
					$aid=$row['a_id']; 
					$class=mysql_query("SELECT * FROM class WHERE c_id=$cid");
			  		$classlist=mysql_fetch_array($class);
			  		$class_name=$classlist['c_name'];
			  		
			  		if($class_name=="XI STD" || $class_name=="XI" || $class_name=="XII STD" || $class_name=="XII")
			  		{
			  		    $section=mysql_query("SELECT * FROM section WHERE s_id=$sid");
			  		    $sectionlist=mysql_fetch_array($section);
			  		    $section_name=" - ".$sectionlist['s_name'];
			  		}else{
			  		    
			  		    $section_name="";
			  		}
			  		
					$sold=$row['b_qtysold'];
					$left=$row['b_qtyleft'];
					$mprice=$row['m_price'];
					$nid=$row['n_id']; 
					if($nid>0){
						$note=mysql_query("SELECT * FROM notebook_purchese WHERE n_id=$nid");
			  			$notebook=mysql_fetch_array($note);
						$sold=$notebook['n_qtysold'];
						$left=$notebook['n_qtyleft'];
						$mprice=$notebook['m_price'];						
					}
					$agency=mysql_query("SELECT * FROM agency WHERE a_id=$aid");
			  		$agencylist=mysql_fetch_array($agency);
				?>
							<tr class="gradeA">
								<td><?php echo $count; ?></td>
								<td><?php echo $row['b_name']; ?></td>
                                <td><?php echo $sold;?></td>
                                <td><?php echo $left;?></td>
                                <td><?php echo $mprice; ?></td>
                                <td><?php echo $row['b_price']; ?></td>
                                <td><?php echo $row['p_date']; ?></td>
                                <td><?php echo $class_name.$section_name; ?></td>
                                <td><?php if($row['category']=='C')
										echo "Common";
									  elseif($row['category']=='M')
									    echo "Male";
									  else
									    echo "Female";	?></td>
                               <td><?php echo $agencylist['a_name']; ?></td>
                                 							</tr>	
                            <?php // } } 
							$count++;
							} ?>																						
						</tbody>
					</table>
						</div> <!-- .widget-content -->
					
				</div>
				
			</div>
            <?php }?>
			
		</div> <!-- .container -->
		
	</div> <!-- #content -->
	
	<?php 
	include("includes/topnav.php");
	?> <!-- #topNav -->
	
	 <!-- .quickNav -->
	
	
</div> <!-- #wrapper -->

<?php include("includes/footer.php"); ?>

</body>
</html><? ob_flush(); ?>