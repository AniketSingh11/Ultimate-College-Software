<?php
include("header.php");
session_start();
 $month=date("M");
 $year=$_GET['year'];
$year=date("Y");	  
	  
 $m_value=$_GET['m'];
 //echo $m_value;
 
$months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May"); 
$sacyear=$_SESSION['acyear'];
$syear=$_GET['syear'];
$eyear=$_GET['eyear'];
if($m_value>5){
	$y_value=$syear;
}else if($m_value<=5){
	$y_value=$eyear;
}
if($sacyear){
$ayear=mysql_query("SELECT * FROM year WHERE ay_id='$sacyear'");
$ay=mysql_fetch_array($ayear);
}else{
	$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);
}

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];
$sdate=mysql_real_escape_string($_GET['sdate']);
$edate=mysql_real_escape_string($_GET['edate']);


if(!$syear && !$eyear){
$syear=$ay['s_year'];
$eyear=$ay['e_year'];
}

?>
<style type="text/css">
	.howler {
		margin: 0 .75em 1em 0;
	}
	</style>
  </head>
 <body>
 <div id="wrapper">
	   <?php 
	   include("includes/head_logo.php");	   
	   include("includes/top_nav.php");	   
	   include("sidebar.php");
	   $sid=$_GET['id'];
	   
	  $filter=$_GET['filt'];
	   
	  
	    $cid=$_GET['cid'];	
		 $leaveid=$_GET['lt_id'];
	 //  echo $leaveid;die;
	   
	   if($leaveid){
		   	$leavetype1=mysql_query("SELECT lt_name FROM leavetype WHERE lt_id='$leaveid'");
			$lleave=mysql_fetch_array($leavetype1);
			$leavetyname=$lleave['lt_name'];
	   }
	   ?>	
     <div id="content">	
		 <div id="content-header">
			 <div class="col-md-8">
			 <h1> Monthwise Leave Details ( <?php echo $syear." - ".$eyear;?> )</h1><?php if($filter || ($syear && $eyear)) {?><span style="float:right; margin-right:30px;"><b>Filter by : </b><?php if($leaveid){?> Leave Type = <?php echo $leavetyname." | "; }?> <?php if($filter){?>Employe Type = <?php echo $filter." | "; }?> Year :  <?php echo$y_value."|"; ?><?php if($m_value){ ?> Month = <?php echo $months[$m_value];} else { echo "Month=".date("F"); }?></span><?php } ?>
			 </div>
			
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
 <?php if($_GET["msg"] == 'dsucc') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully deleted 
			</div>
<?php } ?>
 	 <div class="row">
				 <div class="col-md-12">
					 <div class="portlet">
						 <div class="portlet-header">
						 
							 <h3>
								Overall Leave  List  ( <?php echo $syear." - ".$eyear;?> )
							 </h3>
                             
                           <a href="overall_leave_list_down.php?filt=<?php echo $filter."&syear=".$syear."&eyear=".$eyear."&ltid=".$leaveid;?>&m=<?php echo $m_value; ?>" title="Download Report"><button type="button" class="btn btn-success">Download Report</button></a>
				             <a href="leave_list_print.php?filt=<?php echo $filter."&syear=".$syear."&eyear=".$eyear."&ltid=".$leaveid;?>&m=<?php echo $m_value; ?>" title="Print" target="_blank"><button type="button" class="btn btn-success">Print</button></a> 
							
							</div>
                            <div class="btn-group" style="float:right; margin-right:10px;">
							  <button type="button" class="btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Academic Year <span class="caret"></span>
							  </button>
							   <ul class="dropdown-menu" role="menu">
							   
                              <?php 
							  $yearstring=$syear."-".$eyear;
							  $qry=mysql_query("SELECT * FROM year");
							  while($row=mysql_fetch_array($qry))
								{
									
									$syear1=$row['s_year'];
									$eyaer1=$row['e_year'];
									$leaveid=$_GET['lt_id'];
											//echo $leaveid;die;
											
									?>
									<?php
							  $emp_query14="select * from leavetype order by lt_id asc";
											//echo $leaveid;die;
				$leaveid=$_GET['lt_id'];							
											 											 
		$emp_result14=mysql_query($emp_query14);
		
		while($emp_display14=mysql_fetch_array($emp_result14))
		{
			$lt_id=$emp_display14["lt_id"];	
			$others=$emp_display14["other"];	
							   
		}			   
							   
							   ?>

									
                                  <li <?php if($row['y_name']==$yearstring){ echo 'class="active"';}?>><a href="monthwise_leave_list.php?lt_id=<?php echo $leaveid;?>&filt=<?php echo $filter ;?>&syear=<?php echo $syear1."&eyear=".$eyaer1;?>&m=<?php  echo $m_value;?>"><?php echo $row['y_name'];?></a></li>
								<?php } ?>
								  
							  </ul>
							</div>
							 <div class="btn-group" style="float:right; margin-right:10px;">
                              <button type="button" class="btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
							    Month <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu">
							  
                                <?php                                  
                                    foreach($months as $x => $x_value) {
									?>
									<li class="<?php if($x==$m_value){ echo "active"; }?>"><a href="monthwise_leave_list.php?lt_id=<?php echo $leaveid;?>&syear=<?php echo $syear;?>&eyear=<?php echo $eyear;?>&filt=<?php echo $filter ;?>&m=<?php echo $x;?>"><?php echo $x_value; ?></a></li>
                                
                                <?php }?>
							  </ul>
							</div>
                            <div class="btn-group" style="float:right; margin-right:10px;">
							  <button type="button" class="btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Empolye Type <span class="caret"></span>
							  </button>
							  <?php if(!$syear && !$eyear){
$syear=$ay['s_year'];
$eyear=$ay['e_year'];
}
 
?>
<?php



                              $m_value=$_GET['m'];
							  $emp_query13="select * from leavetype order by lt_id asc";
											//echo $leaveid;die;
				$leaveid=$_GET['lt_id'];							
											 											 
		$emp_result13=mysql_query($emp_query13);
		
		while($emp_display13=mysql_fetch_array($emp_result13))
		{
			$lt_id=$emp_display13["lt_id"];	
			$others=$emp_display13["other"];	
							   
							   
							   
							   ?>

	

		
							   <ul class="dropdown-menu" role="menu">
                                <li <?php if($filter==""){echo 'class="active"';}?>><a href="monthwise_leave_list.php?lt_id=<?php echo $leaveid;?>&filt=&syear=<?php echo $syear."&eyear=".$eyear;?><?php echo $row['y_name'];?>&m=<?php  echo $m_value;?>">Over All</a></li>
							    <li <?php if($filter=="staff"){ echo 'class="active"';}?>><a href="monthwise_leave_list.php?lt_id=<?php echo $leaveid;?>&filt=staff&syear=<?php echo $syear."&eyear=".$eyear;?>&m=<?php  echo $m_value;?>"><?php echo $row['y_name'];?>Staff</a></li>
							    <li <?php if($filter=="others"){  echo 'class="active"';} ?>><a href="monthwise_leave_list.php?lt_id=<?php echo $leaveid;?>&filt=others&syear=<?php echo $syear."&eyear=".$eyear;?>&m=<?php  echo $m_value;?>"><?php echo $row['y_name'];?>Others</a></li>
								<li <?php if($filter=="driver"){ echo 'class="active"';}?>><a href="monthwise_leave_list.php?lt_id=<?php echo $leaveid;?>&filt=driver&syear=<?php echo $syear."&eyear=".$eyear;?>&m=<?php  echo $m_value;?>"><?php echo $row['y_name'];?>Driver</a></li>
							<?php } ?>	
								
							  </ul>
									  
							  
							</div>
					
							
							
						<div class="btn-group" style="float:right; margin-right:10px;">
							  <button type="button" class="btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
							    Filter by Leave Type <span class="caret"></span>
							  </button>
							  
							   <ul class="dropdown-menu" role="menu">
							     <li <?php if(!$leaveid){ echo 'class="active"';}?>><a href="overall_leave_list.php?syear=<?php echo $syear;?>&eyear=<?php echo $eyear; if($filter){ echo "&filt=".$filter;}?>&m=<?php  echo $m_value;?>">Over All</a></li>
							   <?php
							  $emp_query12="select * from leavetype order by lt_id asc";
											//echo $leaveid;die;
											
											 											 
		$emp_result12=mysql_query($emp_query12);
		
		while($emp_display12=mysql_fetch_array($emp_result12))
		{
			$lt_id=$emp_display12["lt_id"];	
			$others=$emp_display12["other"];	
							   
							   
							   
							   ?>
                                <li <?php if($leaveid==$lt_id){ echo 'class="active"';}?>><a href="monthwise_leave_list.php?lt_id=<?php echo $lt_id;?>&syear=<?php echo $syear."&eyear=".$eyear;?><?php echo $row['y_name'];?>&filt=<?php echo $filter;?>&m=<?php  echo $m_value;?>"><?php echo $emp_display12['lt_name']?></a></li>
							 
							 
			<?php } ?>					  
		  
					 </ul>	
			 		 
							</div>
							
						 </div>  <!-- /.portlet-header -->
						 
						 <div class="portlet-content">
							 <div class="table-responsive">
                             <table 
								class="table table-striped table-bordered table-hover table-highlight table-checkable" 
								data-provide="datatable" 
								data-display-rows="10"
								data-info="true"
								data-search="true"
								data-length-change="true"
								data-paginate="true"
							>
									<thead>
										<tr>
											<th data-sortable="true">S.No</th>
											 <th data-filterable="true" data-sortable="true">Emp Code </th>
											 <th data-filterable="true" data-sortable="true">Emp Name </th>
											 <th data-filterable="true" data-sortable="true">Emp Type </th>
											
											
											<?php	
											$leaveid=$_GET['lt_id'];
											//echo $leaveid;die;
											$emp_query11="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query11.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query11.="  order by lt_id asc";
											// echo  $emp_query11;die;
											 
		$emp_result11=mysql_query($emp_query11);
		
		while($emp_display11=mysql_fetch_array($emp_result11))
		{
			$lt_id=$emp_display11["lt_id"];	
			$others=$emp_display11["other"];	
		?>    
		
											 
                                             <th data-sortable="true"  data-sortable="true" ><?php echo $emp_display11["lt_name"];?></th>
											
                                             
                                             
											 
											 
											 
											 <?php         
		$emp_count++;		
        }        
        ?>	
										</tr>
									</thead>
									
									<tbody>
								
		<!-- stafff------------------------->							
									
										<?php
										
                              	if($filter=="staff"){
										$emp_query="SELECT * FROM staff WHERE s_type in ('Teaching','Non-Teaching')  order by fname asc";
									
										////echo "SELECT * FROM staff WHERE s_type in ('Teaching','Non-Teaching')  order by fname asc";die;
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		
		while($emp_display=mysql_fetch_array($emp_result))
		{
			
			$emp_id=$emp_display["st_id"];
            $s_type=$emp_display["s_type"];
?>   
          

		
		
										 <tr>
											
											 <td><?php echo $emp_count++ ;?> </td>
                                             <td><?php echo $emp_display["staff_id"]; ?> </td>
                                             <td><?php echo $emp_display["fname"]; ?> </td>

                                             <td><?php if(($s_type=="Teaching") or ($s_type=="Non-Teaching") ) { echo "staff";}?> </td>
										<?php
	
										//	$emp_query1="select * from leavetype order by lt_id asc";
										//	print_r(mysql_fetch_array($emp_result));

                                         $leaveid=$_GET['lt_id'];
											//$leaveid="1";
											$emp_query1="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query1.= "   where lt_id=$leaveid"; 
											 }
	                                         $emp_query1.="  order by lt_id asc";
										
		$emp_result1=mysql_query($emp_query1);
		
		while($emp_display1=mysql_fetch_array($emp_result1))
		{
			$other=$emp_display1["other"];
			$lt_id=$emp_display1["lt_id"];
			$tleave=0;
			$emp_query2="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) ";
			
                                             if($m_value)
											 {
												$emp_query2.= "AND f_month=$m_value"; 
											 }
											
	//echo "select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) AND f_month=$m_value";die;
			
			
			$emp_result2=mysql_query($emp_query2);
			//print_r(mysql_fetch_array($emp_result2));die;
			while($emp_display2=mysql_fetch_array($emp_result2))
				
			{
				
				$tleave +=$emp_display2['l_total'];
				//echo $tleave;die;
			}
			
		?>    

                                  
                                             <td><?php echo $tleave;?> </td>     
                                            
                                           
						 
										 
	<?php 

		$rleave=0;	
		 
		}
		?>
		</tr>
				
		
	<!-- Others------------------------->				
		
		<?php
		}
								}
								
			
								elseif($filter=="others"){
									
										 $pos=$_GET['position'];
										if(!empty($cid) && $cid!="all")
                            {
							$emp_query3="SELECT * FROM others where category_id='$cid' order by fname asc";
                            }else{                                
                                $emp_query3="SELECT * FROM others order by fname asc";
                            }		
		$emp_result3=mysql_query($emp_query3);
		
		while($emp_display3=mysql_fetch_array($emp_result3))
		{
			$emp_id=$emp_display3["o_id"];	
			$ocid=$emp_display3["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
			
		?>  
                              <tr>
											 <td><?php echo $emp_count++ ;?> </td>
                                             <td><?php echo $emp_display3["others_id"]; ?> </td>
                                             <td><?php echo $emp_display3["fname"]; ?> </td>
											 <td><?php if($pos){echo "others";}else{echo "others";}?></td>
								<?php	
											//$emp_query4="select * from leavetype order by lt_id asc";		

                                              $leaveid=$_GET['lt_id'];
											//$leaveid="1";
											$emp_query4="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query4.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query4.="  order by lt_id asc";


											
		$emp_result4=mysql_query($emp_query4);
		
		while($emp_display4=mysql_fetch_array($emp_result4))
		{
			$other=$emp_display4["other"];
			$lt_id=$emp_display4["lt_id"];
			$tleave=0;
			$emp_query5="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) ";
			
                                             if($m_value)
											 {
												$emp_query5.= "AND f_month=$m_value"; 
											 }
			//echo "select * from staff_leave where status='1' AND (o_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result5=mysql_query($emp_query5);
			while($emp_display5=mysql_fetch_array($emp_result5))
			{
				$tleave +=$emp_display5['l_total'];
			}
			
		?>          		


										<td><?php  echo $tleave;?> </td>     
                                            
                                                                               

<?php         
		
		$rleave=0;	
        }
		
		
										
        ?>		
		</tr>
		
		
		<!-- driver------------------------->
		
		
<?php
	}		
								}
								elseif($filter=="driver"){
									
	$emp_query6="SELECT * FROM driver WHERE d_type in ('Driver','Non-Driver') order by fname asc";
								//echo "select * from driver where d_type='Driver' order by fname asc";die;
										
		
		$emp_result6=mysql_query($emp_query6);
		
		while($emp_display6=mysql_fetch_array($emp_result6))
		{
			$emp_id=$emp_display6["d_id"];
		//	print_r($emp_id);die;
            $d_type=$emp_display6["d_type"];			
			
		?>                             
		              <tr>
											 <td><?php echo $emp_count++ ;?> </td>
                                             <td><?php echo $emp_display6["driver_id"]; ?> </td>
                                             <td><?php echo $emp_display6["fname"]; ?> </td>
											 <td><?php if($d_type=="Driver"){echo "Driver";}else{echo "Driver";} ?> </td>
				<?php	
											 //$emp_query7="select * from leavetype order by lt_id asc";

$leaveid=$_GET['lt_id'];
											//$leaveid="1";
											$emp_query7="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query7.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query7.="  order by lt_id asc";
											 
		$emp_result7=mysql_query($emp_query7);
		
		while($emp_display7=mysql_fetch_array($emp_result7))
		{
			$other=$emp_display7["other"];
			$lt_id=$emp_display7["lt_id"];
			$tleave=0;
			 $emp_query8="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) ";
			
                                             if($m_value)
											 {
												$emp_query8.= "AND f_month=$m_value"; 
											 }
			//echo "select * from staff_leave where status='1' AND (d_id=$emp_id AND l_type=$lt_id) AND month=$months AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result8=mysql_query($emp_query8);
			while($emp_display8=mysql_fetch_array($emp_result8))
			{
				$tleave +=$emp_display8['l_total'];
			}
			
		?>


				<td><?php  echo $tleave;?> </td>     
                                             
							
		<?php         
		
			
        }       	
        
       
        ?>						

</tr>				 


                               <!-- Overall------------------------->
											<?php }}
								
							
								elseif($filter==""){
							
							$emp_query="SELECT * FROM staff WHERE s_type in ('Teaching','Non-Teaching')  order by fname asc";
									
										//echo "SELECT * FROM staff WHERE s_type in ('Teaching','Non-Teaching')  order by fname asc";die;
		
		$emp_result=mysql_query($emp_query);
		$emp_count=1;
		
		while($emp_display=mysql_fetch_array($emp_result))
		{
			
			$emp_id=$emp_display["st_id"];
         $s_type=$emp_display["s_type"];		
									
		?>							
									
		 <tr>
											
											 <td><?php echo $emp_count++ ;?> </td>
                                             <td><?php echo $emp_display["staff_id"]; ?> </td>
                                             <td><?php echo $emp_display["fname"]; ?> </td>

                                             <td><?php if(($s_type=="Teaching") or ($s_type=="Non-Teaching") ) { echo "staff";}?> </td>
										<?php	
										//	$emp_query1="select * from leavetype order by lt_id asc";
											
										          $leaveid=$_GET['lt_id'];
											//$leaveid="1";
											$emp_query1="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query1.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query1.="  order by lt_id asc";	
											
											
										//	print_r(mysql_fetch_array($emp_result));										
		$emp_result1=mysql_query($emp_query1);
		
		while($emp_display1=mysql_fetch_array($emp_result1))
		{
			$other=$emp_display1["other"];
			$lt_id=$emp_display1["lt_id"];
			$tleave=0;
			
			$emp_query2="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) ";
			
                                             if($m_value)
											 {
												$emp_query2.= "AND f_month=$m_value"; 
											 }
											  elseif(!$m_value)
											 {
												 
												$emp_query2.= "AND f_month=".date(['Month=m']);  
											 }
			
			
			///echo "select * from staff_leave where status='1' AND (st_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result2=mysql_query($emp_query2);
			while($emp_display2=mysql_fetch_array($emp_result2))
			{
				$tleave +=$emp_display2['l_total'];
			}
			
		?>    


                                             <td><?php   echo $tleave;?> </td>     
                                          
                                             
																				 
										 
	<?php 

			
		 
		}
		?>
		</tr>
				
		
			<!-- overall-Others  ------------------------->
		
		<?php
		}							
		
		 $emp_query3="SELECT * FROM others order by fname asc";
                        	
		$emp_result3=mysql_query($emp_query3);
		
		while($emp_display3=mysql_fetch_array($emp_result3))
		{
			$emp_id=$emp_display3["o_id"];	
			$ocid=$emp_display3["category_id"];
			
				$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
			
		?>  
                              <tr>
											 <td><?php echo $emp_count++ ;?> </td>
                                             <td><?php echo $emp_display3["others_id"]; ?> </td>
                                             <td><?php echo $emp_display3["fname"]; ?> </td>
											 <td><?php if($pos){echo "others";}else{echo "others";}?></td>
								<?php	
											//$emp_query4="select * from leavetype order by lt_id asc";		

                                              $leaveid=$_GET['lt_id'];
											//$leaveid="1";
											$emp_query4="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query4.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query4.="  order by lt_id asc";


											
		$emp_result4=mysql_query($emp_query4);
		
		while($emp_display4=mysql_fetch_array($emp_result4))
		{
			$other=$emp_display4["other"];
			$lt_id=$emp_display4["lt_id"];
			$tleave=0;
			$emp_query5="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) ";
			
                                             if($m_value)
											 {
												$emp_query5.= "AND f_month=$m_value"; 
											 }
											 elseif(!$m_value)
											 {
												 
												$emp_query5.= "AND f_month=".date(['Month=m']);  
											 }
			//echo "select * from staff_leave where status='1' AND (o_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result5=mysql_query($emp_query5);
			while($emp_display5=mysql_fetch_array($emp_result5))
			{
				$tleave +=$emp_display5['l_total'];
			}
			
		?>          		


										<td><?php  echo $tleave;?> </td>     
                                            
                                                                               

<?php         
		
		
        }
		
		
										
        ?>		
		</tr>
		
				<!-- overall-driver  ------------------------->	
		
<?php
	}		
													
									
	$emp_query6="SELECT * FROM driver WHERE d_type in ('Driver','Non-Driver') order by fname asc";
								///echo "select * from driver where d_type='Driver' order by fname asc";die;
										
		
		$emp_result6=mysql_query($emp_query6);
		
		while($emp_display6=mysql_fetch_array($emp_result6))
		{
			$emp_id=$emp_display6["d_id"];
            $d_type=$emp_display6["d_type"];			
			
		?>                             
		              <tr>
											 <td><?php echo $emp_count++ ;?> </td>
                                             <td><?php echo $emp_display6["driver_id"]; ?> </td>
                                             <td><?php echo $emp_display6["fname"]; ?> </td>
											 <td><?php if($d_type=="Driver"){echo "Driver";}else{echo "Driver";} ?> </td>
				<?php	
											 $emp_query7="select * from leavetype order by lt_id asc";

                                         $leaveid=$_GET['lt_id'];
											//$leaveid="1";
											$emp_query7="select * from leavetype";
										
                                             if($leaveid)
											 {
												$emp_query7.= "  where lt_id=$leaveid"; 
											 }
	                                         $emp_query7.="  order by lt_id asc";


											 
		$emp_result7=mysql_query($emp_query7);
		
		while($emp_display7=mysql_fetch_array($emp_result7))
		{
			$other=$emp_display7["other"];
			$lt_id=$emp_display7["lt_id"];
			$tleave=0;
			 $emp_query8="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear) OR (year=$eyear )) ";
			
                                             if($m_value)
											 {
												$emp_query8.= "AND f_month=$m_value"; 
											 }
											   elseif(!$m_value)
											 {
												 
												$emp_query8.= "AND f_month=".date(['Month=m']);  
											 }
			////echo "select * from staff_leave where status='1' AND (d_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result8=mysql_query($emp_query8);
			while($emp_display8=mysql_fetch_array($emp_result8))
			{
				$tleave +=$emp_display8['l_total'];
			}
			
		?>


				<td><?php echo  $tleave;?> </td>     
                                             
                                             
							
		<?php         
				
        }       	
        
       
        ?>						

</tr>				 
		<?php }									
								}
						
								
								
								?>
						
									</tbody>
								</table>
				</div>  <!-- /.table-responsive -->
						 </div>  <!-- /.portlet-content -->
					 </div>  <!-- /.portlet -->
				 </div>  <!-- /.col -->
			 </div>  <!-- /.row -->
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
				
			
<?php
include("footer.php");
include("includes/script.php");?>
</body>
</html>

 <? ob_flush(); ?>