<? ob_start(); ?>
<?php 
ini_set('max_execution_time', 0);
error_reporting(E_ALL ^ E_NOTICE);
include("../includes/config.php"); 
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
 $sid=$_GET['id'];
	   
	  $filter=$_GET['filt'];
	   
	  
	    $cid=$_GET['cid'];	
		 $leaveid=$_GET['ltid'];
	   
	   
	   if($leaveid){
		   	$leavetype1=mysql_query("SELECT lt_name FROM leavetype WHERE lt_id='$leaveid'");
			$lleave=mysql_fetch_array($leavetype1);
			$leavetyname=$lleave['lt_name'];
	   }


$date = date_default_timezone_set('Asia/Kolkata');

$check=$_SESSION['email'];

$query=mysql_query("select email,id from admin_login where email='$check' ");



$email=$data['email'];
$adminid=$data['id'];
$user=$_SESSION['uname'];

$sacyear=$_SESSION['acyear'];

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


if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        header("Location:../timeout.php");
    }
    else {
        $_SESSION['expiretime'] = time() + 6000;
    }
}




					
				?> 


 <?php include 'print_header.php';?> 
<script>
function hide_button(){
     document.getElementById('print').style.visibility='hidden';
	 document.getElementById('print').style.display='none';
     window.print();
    // document.body.onmousemove = doneyet;
}


</script>
</head>
 <body style="background:#FFFFFF;">
 
<div style="float:right;" id="print"> <a onclick="hide_button();" href="" title="Print this certificate">
<img src="../img/printer.png"></a> 
             
                   <div class="_25" style="float:center">
                                   <label for="select">   Filter by Empolye Type </label>
                                	 <select name="filter" id="filter"  onChange="filter()" class="required" >
                               <option <?php if($filter==""){echo 'class="active"';}?> value= "">Over All</option>
							    <?php if(!$syear && !$eyear){
$syear=$ay['s_year'];
$eyear=$ay['e_year'];
}
 
?>
<?php
							  $emp_query13="select * from leavetype order by lt_id asc";
											//echo $leaveid;die;
				$leaveid=$_GET['ltid'];							
											 											 
		$emp_result13=mysql_query($emp_query13);
		
		while($emp_display13=mysql_fetch_array($emp_result13))
		{
			$lt_id=$emp_display13["lt_id"];	
			$others=$emp_display13["other"];	
							?>   
								
							 <?php } ?>
  
					
			<option value="staff" <?php if($filter=="staff"){ echo 'selected'; }?>>Staff</option>
<option value="others" <?php if($filter=="others"){ echo 'selected';}?>>Others</option>
<option value="driver"<?php if($filter=="driver"){ echo 'selected';}?>>Driver</option>		




                                </select>
								</div>
								
								<div class="_25" style="float:center">
                <label for="select">Filter by Academic Year:</label>
				<select name="year" id="year"  onChange="leaveyeartype()" class="required" >
                                	 <?php 
							  $yearstring=$syear."-".$eyear;
							  $qry=mysql_query("SELECT * FROM year");
							  while($row=mysql_fetch_array($qry))
								{
									
									$syear1=$row['s_year'];
									$eyaer1=$row['e_year'];
									$leaveid=$_GET['ltid'];
											//echo $leaveid;die;?>
										
									
									<?php
							  $emp_query14="select * from leavetype order by lt_id asc";
											//echo $leaveid;die;
				$leaveid=$_GET['ltid'];							
											 											 
		$emp_result14=mysql_query($emp_query14);
		
		while($emp_display14=mysql_fetch_array($emp_result14))
		{
			$lt_id=$emp_display14["lt_id"];	
			$others=$emp_display14["other"];	
			?>
		
							   

	<?php	}		?>	   
							   
                     <option value="<?php echo $syear1."&eyear=".$eyaer1;?>"<?php if($row['y_name']==$yearstring){ echo "selected";}?>><?php echo $row['y_name'];?>  </option>
					 
<?php						 } ?>


								  
									
								</select>	
								</div>
                <div class="_25" style="float:center">
                                   <label for="select">   Filter by Month </label>
								    <?php $m=$_GET['m'];?>
                                	 <select name="month" id="month"  onChange="month()" class="required" >
                                <option <?php if($m==""){echo 'class="active"';}?> value= "">Over All</option>
							    
  <?php                                  
                                    foreach($months as $x => $x_value) {
										
									?>
									 
									<option <?php if($x==$m){ echo "selected"; }?> value="<?php echo $x; ?>"><?php echo $x_value; ?></option>
                                
                                <?php }?>

                                </select>
								</div>
				 
				     <div class="_25" style="float:right">
                <label for="select">Filter by Leave Type:</label>
				<select name="leave" id="leave"  onChange="leavetype()" class="required" >
				
				 <option value="">Over All</option>
				
                                	 <?php
									  $leaveid=$_GET['ltid'];
							  $emp_query12="select * from leavetype order by lt_id asc";
							 // echo "select * from leavetype order by lt_id asc";die
											//echo $leaveid;die;
											
											 											 
		$emp_result12=mysql_query($emp_query12);
		
		while($emp_display12=mysql_fetch_array($emp_result12))
		{
			$lt_id=$emp_display12["lt_id"];	
			$others=$emp_display12["other"];?>


			<option value="<?php echo $lt_id;?>"<?php if($leaveid==$lt_id){ echo "selected";}?>><?php  echo $emp_display12['lt_name'];?></option>
							   	
								<?php } ?>
								
								
								
								
								
</select>													
                   </div> 
				 
				 
				 
				 
				 
				 
				 
				 </div>
<div align="center" id="printablediv">  <!-- ImageReady Slices (Bonafide(1).jpg) -->
  
<!doctype html>
<html>
<head>

<style type="text/css" media="all">
  img.adjusted {
    position: absolute;
    z-index: -1;
    width: 100%;
   
  }
  .Invitation {
    position: relative;
    width: 950px;
    margin-top:-362px;
	height:200px;
	margin-left:-960px !important;
   
  }
  .block-content-invoice1{
	  width:950px;
	  margin:30px
		border-radius: 3px;
		/* position: relative; */
		padding: 10px;
		/*border: 2px solid #a9a6a6;*/
		  }
.table td, .table th
{
	padding:5px;
	text-align:center;
}


</style></head> 
 <form action="" id="staff_form" name="staff_form" method="GET">       
<div id="invoice" class="widget widget-plain">	
						<div class="block-content-invoice1">
                      <div style="width:236mm; margin:0px; height:40.1mm; min-height:40.1mm; border-bottom:2px solid #01a8ff; padding-bottom:20px; display:inline-block;" id="Table_01">
                            <div style="text-align:left; width:50.00mm; float:left;">
                                <div><img src="img/logo1.png" width="160px" height="160px"></div>
                            </div>
                            <div style="text-align:center;width:185.75mm; float:left; padding-top:25px;">
                                <h5 style="padding:0px; padding-bottom:3px; margin:0px; letter-spacing:2px; color:red; font-family:Impact, Haettenschweiler, 'Franklin Gothic Bold', 'Arial Black', sans-serif; font-size:46px; ; font-weight:bold;">SCHOOL/COLLEGE MANAGEMENT SYSTEM</h5>

                                <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-weight:bold; font-size:18px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Hetauda, Nepal</h5>
                               <!-- <h5 style="padding:0px; font-weight:normal; padding-bottom:3px; margin:0px; font-size:16px; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif;">Contact : 044-32429897, 26790694, Email : christischool@gmail.com, Web: www.christschool.co.in</h5>-->
                            </div>
                        </div>
<body>
<div id="content-header">
			 <div class="" style="display:inline-block; width:100%">
			 <h3> Overall Leave Details ( <?php echo $syear." - ".$eyear;?> )</h3><?php if($filter || ($syear && $eyear)){?><h3><b>Filter by : </b><?php if($leaveid){?> Leave Type = <?php echo $leavetyname." | "; }?> <?php if($filter){?>Employe Type = <?php echo $filter." | "; }?> Year :  <?php echo $y_value."|"; ?><?php if($m_value!=""){ ?> Month = <?php echo $months[$m_value];}else{
				//echo date("F"); 
				echo "All"; 
			 }?></h3><?php } ?>
			 
			 </div>
			 
		 </div>  <!-- #content-header -->	
   
                      <div class="modal-body"> 
             <table class="table" width="100%" cellpadding="0" cols="0" border="1" style="border-collapse:collapse;">
				
								
							<thead>
										<tr>
											<th data-sortable="true">S.No</th>
											 <th data-filterable="true" data-sortable="true">Emp Code </th>
											 <th data-filterable="true" data-sortable="true">Emp Name </th>
											 <th data-filterable="true" data-sortable="true">Emp Type </th>
											
											
											<?php	
											$leaveid=$_GET['ltid'];
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
		
											 
                                             <th data-sortable="true"  data-sortable="true" colspan="3"><?php echo $emp_display11["lt_name"];?></th>
											
                                             
                                             
											 
											 
											 
											 <?php         
		$emp_count++;		
        }        
        ?>	
										</tr>
									</thead>
									
									<tbody>
									<tr>
									<?php
									$leaveid=$_GET['ltid'];
									if($leaveid)
									{
										?>
										
									<td></td><td></td><td></td><td></td><td>A<td>T</td><td>R</td>
										
									<?php }else{?>
										<td></td><td></td><td></td><td></td><td>A<td>T</td><td>R</td><td>A</td><td>T</td><td>R</td><td>A</td><td>T</td><td>R</td><td>A</td><td>T</td><td>R</td><td>A</td><td>T</td><td>R</td><td>A</td><td>T</td><td>R</td>
									</tr>
								<?php	}
									?>
									
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

$leaveid=$_GET['ltid'];
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
			$emp_query2="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";
			////echo "select * from staff_leave where status='1' AND (st_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			
			
			$emp_result2=mysql_query($emp_query2);
			while($emp_display2=mysql_fetch_array($emp_result2))
			{
				$tleave +=$emp_display2['l_total'];
			}
			$rleave=$emp_display1["l_total"]-$tleave;
		?>    


                                             <td><?php if($other){ echo "-";}else{echo $emp_display1["l_total"];}?> </td>     
                                             <td><?php echo $tleave;?> </td>
                                             <td><?php if($other){ echo "-";}else{echo $rleave;}?> </td> 
																				 
										 
	<?php 

		$rleave=0;	
		 
		}
		?>
		</tr>
				
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

$leaveid=$_GET['ltid'];
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
			$emp_query5="select * from staff_leave where status='1' AND (o_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";
			//echo "select * from staff_leave where status='1' AND (o_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result5=mysql_query($emp_query5);
			while($emp_display5=mysql_fetch_array($emp_result5))
			{
				$tleave +=$emp_display5['l_total'];
			}
			$rleave=$emp_display4["l_total"]-$tleave;
		?>          		


										<td><?php if($other){ echo "-";}else{echo $emp_display4["l_total"];}?> </td>     
                                             <td><?php echo $tleave;?> </td>
                                             <td><?php if($other){ echo "-";}else{echo $rleave;}?> </td>                                   

<?php         
		
		$rleave=0;	
        }
		
		
										
        ?>		
		</tr>
		
		
		
		
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
            $d_type=$emp_display6["d_type"];			
			
		?>                             
		              <tr>
											 <td><?php echo $emp_count++ ;?> </td>
                                             <td><?php echo $emp_display6["driver_id"]; ?> </td>
                                             <td><?php echo $emp_display6["fname"]; ?> </td>
											 <td><?php if($d_type=="Driver"){echo "Driver";}else{echo "Driver";} ?> </td>
				<?php	
											 //$emp_query7="select * from leavetype order by lt_id asc";

$leaveid=$_GET['ltid'];
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
			 $emp_query8="select * from staff_leave where status='1' AND (d_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";
			//echo "select * from staff_leave where status='1' AND (d_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result8=mysql_query($emp_query8);
			while($emp_display8=mysql_fetch_array($emp_result8))
			{
				$tleave +=$emp_display8['l_total'];
			}
			$rleave=$emp_display7["l_total"]-$tleave;
		?>


				<td><?php if($other){ echo "-";}else{echo $emp_display7["l_total"];}?> </td>     
                                             <td><?php echo $tleave;?> </td>
                                             <td><?php if($other){ echo "-";}else{echo $rleave;}?> </td>
							
		<?php         
		
		$rleave=0;		
        }       	
        
       
        ?>						

</tr>				 
								<?php }}
								else{
									
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
											$emp_query1="select * from leavetype order by lt_id asc";
											
										$leaveid=$_GET['ltid'];
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
			$emp_query2="select * from staff_leave where status='1' AND (st_id=$emp_id  AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";
			///echo "select * from staff_leave where status='1' AND (st_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result2=mysql_query($emp_query2);
			while($emp_display2=mysql_fetch_array($emp_result2))
			{
				$tleave +=$emp_display2['l_total'];
			}
			$rleave=$emp_display1["l_total"]-$tleave;
		?>    


                                             <td><?php if($other){ echo "-";}else{echo $emp_display1["l_total"];}?> </td>     
                                             <td><?php echo $tleave;?> </td>
                                             <td><?php if($other){ echo "-";}else{echo $rleave;}?> </td> 
																				 
										 
	<?php 

		$rleave=0;	
		 
		}
		?>
		</tr>
				
		
			
		
		<?php
		}							
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
											$emp_query4="select * from leavetype order by lt_id asc";

$leaveid=$_GET['ltid'];
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
			$emp_query5="select * from staff_leave where status='1' AND (o_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";
			////echo "select * from staff_leave where status='1' AND (o_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result5=mysql_query($emp_query5);
			while($emp_display5=mysql_fetch_array($emp_result5))
			{
				$tleave +=$emp_display5['l_total'];
			}
			$rleave=$emp_display4["l_total"]-$tleave;
		?>          		


										<td><?php if($other){ echo "-";}else{echo $emp_display4["l_total"];}?> </td>     
                                             <td><?php echo $tleave;?> </td>
                                             <td><?php if($other){ echo "-";}else{echo $rleave;}?> </td>                                   

<?php         
		
		$rleave=0;	
        }
		
		
										
        ?>		
		</tr>
		
		
		
		
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

                                         $leaveid=$_GET['ltid'];
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
			 $emp_query8="select * from staff_leave where status='1' AND (d_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";
			////echo "select * from staff_leave where status='1' AND (d_id=$emp_id AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";die;
			$emp_result8=mysql_query($emp_query8);
			while($emp_display8=mysql_fetch_array($emp_result8))
			{
				$tleave +=$emp_display8['l_total'];
			}
			$rleave=$emp_display7["l_total"]-$tleave;
		?>


				<td><?php if($other){ echo "-";}else{echo $emp_display7["l_total"];}?> </td>     
                                             <td><?php echo $tleave;?> </td>
                                             <td><?php if($other){ echo "-";}else{echo $rleave;}?> </td>
							
		<?php         
		
		$rleave=0;		
        }       	
        
       
        ?>						

</tr>				 
		<?php }									
								}
								?>

		
									</tbody>
								</table>
						 
                            </div>
							
							
							
							
							
							
                        </div>
                    </div>
                    <div class="clear height-fix"></div>
                </div>
            </div> <!--! end of #main-content -->
        </div> <!--! end of #main -->


										
				
		  	
      </div>
            </div>
           <!-- <div class="Invitation">
   <img src="img/prt_logo.png" alt="" class="adjusted">
</div>-->
  <p>&nbsp;    </p>
</div>
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
  <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
<script type="text/javascript">
$().ready(function() {
		
		var validateform = $("#validate-form").validate();
		$("#reset-validate-form").click(function() {
			location.reload(); 
			$.jGrowl("Blogpost was not created.", { theme: 'error' });
		});		
	});
	 function filter()
{
var m_value=document.getElementById('month').value; 
var filter=document.getElementById('filter').value;
//alert(filter);
var leave=document.getElementById('leave').value;
//alert(leave);
var data = document.getElementById('year').value;
//alert(data);
var arr = data.split('-');

window.location.href='over_all_leavelist_print.php?syear='+arr[0]+"&filt="+filter+"&ltid="+leave+"&m="+m_value;
//window.location.href='leave_list_print.php?syear='+arr[0]+"&eyear="+arr[1]+"&leave="+leave+"&emptype="+emp_type;
 }
	function leavetype()
{
var m_value=document.getElementById('month').value; 	
var filter=document.getElementById('filter').value;
//alert(filter);
var leave=document.getElementById('leave').value;
//alert(leave);
var data = document.getElementById('year').value;
//alert(data);

var arr = data.split('-');

window.location.href='over_all_leavelist_print.php?syear='+arr[0]+"&filt="+filter+"&ltid="+leave+"&m="+m_value;
 }
 function month()
{
 
var m_value=document.getElementById('month').value; 
//alert(m_value);
var filter=document.getElementById('filter').value;
//alert(filter);
var leave=document.getElementById('leave').value;
//alert(leave);
var data = document.getElementById('year').value;
//alert(data);

var arr = data.split('-');

window.location.href='over_all_leavelist_print.php?syear='+arr[0]+"&filt="+filter+"&ltid="+leave+"&m="+m_value;
 }
	 function leaveyeartype()
{
var m_value=document.getElementById('month').value; 
var filter=document.getElementById('filter').value;
//alert(filter);
var leave=document.getElementById('leave').value;
//alert(leave);
var data = document.getElementById('year').value;
//alert(data);
var arr = data.split('-');
window.location.href='over_all_leavelist_print.php?syear='+arr[0]+"&filt="+filter+"&ltid="+leave+"&m="+m_value;
 }
 

	
  </script>
  </form>
  
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