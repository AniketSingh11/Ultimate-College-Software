 <?php
 include("header.php");  
  $id=$_GET["id"];
  $emp_query="select * from staff_leave where id='$id'";
$emp_result=mysql_query($emp_query);
$employee=mysql_fetch_array($emp_result);
  $oid=$employee["o_id"];
  		$st_id=$employee["st_id"];
  		$o_id=$employee["o_id"];
		$d_id=$employee["d_id"];
  if(isset($_POST["submit"]))
  {
	$oid= mysql_real_escape_string($_POST["o_id"]);
	$a_date= mysql_real_escape_string($_POST["date"]);
	$staff_name= mysql_real_escape_string($_POST["staff_name"]);
	$staff_id= mysql_real_escape_string($_POST["staff_id"]);
	
	$l_type=mysql_real_escape_string($_POST["l_type"]);
	
	$query=mysql_query("select * from leavetype where lt_id='$l_type' ");
	$lv_display=mysql_fetch_array($query);
	$l_type_name=$lv_display["lt_name"];
	
	$h_type= mysql_real_escape_string($_POST["h_type"]);	
	
	$f_date= mysql_real_escape_string($_POST["f_date"]);
	$t_date= mysql_real_escape_string($_POST["t_date"]);
	$l_total= mysql_real_escape_string($_POST["l_total"]);
	$l_dec= mysql_real_escape_string($_POST["l_dec"]);
	$status= mysql_real_escape_string($_POST["status"]);
		
	$sdate_split1= explode('-', $a_date);		 
		  $sdate_day=$sdate_split1[0];
		  $sdate_month=$sdate_split1[1];
		  $sdate_year=$sdate_split1[2];	
		  
	$sdate_split2= explode('-', $f_date);		 
		  $f_day=$sdate_split2[0];
		  $f_month=$sdate_split2[1];
		  $f_year=$sdate_split2[2];	
		  
		$sdate_split3= explode('-', $t_date);		 
		  $t_day=$sdate_split3[0];
		  $t_month=$sdate_split3[1];
		  $t_year=$sdate_split3[2];
		  
		  $from_date=$f_year."-".$f_month."-".$f_day;
	$to_date=$t_year."-".$t_month."-".$t_day;	
	
	$fromdate= mysql_real_escape_string($_POST["fromdate"]);
	 $lastdate= mysql_real_escape_string($_POST["lastdate"]);
	
	$sdate_split3= explode('-', $fromdate);		 
		  $lf_day=$sdate_split3[0];
		  $lf_month=$sdate_split3[1];
		  $lf_year=$sdate_split3[2];	
	$lfrom_date=$lf_year."-".$lf_month."-".$lf_day;
	
	$sdate_split4= explode('-', $lastdate);		 
		  $ll_day=$sdate_split4[0];
		  $ll_month=$sdate_split4[1];
		  $ll_year=$sdate_split4[2];	
	$llast_date=$ll_year."-".$ll_month."-".$ll_day;
	
	if($status=='1'){
		/********************************************Small - Big ******************************************/
		if($lfrom_date>$from_date && $llast_date<=$to_date){
			//echo "smarl-big";
			$datefrom=$from_date;
			
			while ($datefrom <= $to_date) {
				
				if($datefrom<$lfrom_date || $datefrom>$llast_date){
					$sdate_split5= explode('-', $datefrom);		 
					  $check_day=$sdate_split5[2];
					  $check_month=$sdate_split5[1];
					  $check_year=$sdate_split5[0];
					  $select_record1=mysql_query("SELECT satt_id FROM sattendance where (day='$check_day' AND month='$check_month' AND year='$check_year') AND (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) AND ay_id=$acyear");
					  $ccount=mysql_num_rows($select_record1);
					  //echo "$datefrom<br>";
					  if($ccount>0){
						  $select_record2=mysql_fetch_array($select_record1);
						  $satt_id1=$select_record2['satt_id'];
							if($h_type=="EM"){
									$result1="off";
								if($datefrom==$from_date){
									$result_half="M";
								}else if($datefrom==$to_date){
									$result_half="E";
								}
							}else if($h_type=="M" && $datefrom==$from_date){
								$result1="off";
								$result_half="M";
							}else if($h_type=="E" && $datefrom==$to_date){
								$result1="off";
								$result_half="E";
							}else{
								$result1=0;
								$result_half="";
							}
								$lt_id=$l_type;
								$reason=$l_dec;
								$l_apply=$id;
							 $sql=mysql_query("UPDATE sattendance SET result='$result1',lt_id='$lt_id',reason='$reason',result_half='$result_half',l_apply='$l_apply' WHERE satt_id='$satt_id1'");
					  }
				}
			 $datefrom = date ("Y-m-d", strtotime("+1 day", strtotime($datefrom)));
			 }
		}else if($lfrom_date>$from_date && $llast_date>$to_date){
			/********************************************Small - Small ******************************************/
			$datefrom=$from_date;
			echo "small-small";
			while ($datefrom <= $llast_date) {
			//echo "$datefrom<br>";
					if($datefrom<$lfrom_date){
					$sdate_split5= explode('-', $datefrom);		 
					  $check_day=$sdate_split5[2];
					  $check_month=$sdate_split5[1];
					  $check_year=$sdate_split5[0];
					  $select_record1=mysql_query("SELECT satt_id FROM sattendance where (day='$check_day' AND month='$check_month' AND year='$check_year') AND (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) AND ay_id=$acyear");
					  $ccount=mysql_num_rows($select_record1);
					  //echo "$datefrom<br>";
					  if($ccount>0){
						  $select_record2=mysql_fetch_array($select_record1);
						  $satt_id1=$select_record2['satt_id'];
							if(($h_type=="E" || $h_type=="EM") && $datefrom==$from_date){
								$result1="off";
								$result_half="E";
							}else{
								$result1=0;
								$result_half="";
							}
								$lt_id=$l_type;
								$reason=$l_dec;
								$l_apply=$id;
							 	$sql=mysql_query("UPDATE sattendance SET result='$result1',lt_id='$lt_id',reason='$reason',result_half='$result_half',l_apply='$l_apply' WHERE satt_id='$satt_id1'");
					  	}
					}else if($datefrom==$to_date){
					$sdate_split5= explode('-', $datefrom);		 
					  $check_day=$sdate_split5[2];
					  $check_month=$sdate_split5[1];
					  $check_year=$sdate_split5[0];
					  $select_record1=mysql_query("SELECT satt_id FROM sattendance where (day='$check_day' AND month='$check_month' AND year='$check_year') AND (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) AND ay_id=$acyear");
					  $ccount=mysql_num_rows($select_record1);
					  //echo "$datefrom<br>";
					  if($ccount>0){
						  $select_record2=mysql_fetch_array($select_record1);
						  $satt_id1=$select_record2['satt_id'];
							if(($h_type=="M" || $h_type=="EM")){
								$result1="off";
								$result_half="M";
							}else{
								$result1=0;
								$result_half="";
							}
								$lt_id=$l_type;
								$reason=$l_dec;
								$l_apply=$id;
							 $sql=mysql_query("UPDATE sattendance SET result='$result1',lt_id='$lt_id',reason='$reason',result_half='$result_half',l_apply='$l_apply' WHERE satt_id='$satt_id1'");
					  }
					}else if($datefrom>$to_date){
						  $sdate_split5= explode('-', $datefrom);		 
						  $check_day=$sdate_split5[2];
						  $check_month=$sdate_split5[1];
						  $check_year=$sdate_split5[0];
						  $select_record1=mysql_query("SELECT satt_id FROM sattendance where (day='$check_day' AND month='$check_month' AND year='$check_year') AND (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) AND ay_id=$acyear");
						  $ccount=mysql_num_rows($select_record1);
						  //echo "$datefrom<br>";
						  if($ccount>0){
							  $select_record2=mysql_fetch_array($select_record1);
							  $satt_id1=$select_record2['satt_id'];
							  $sql=mysql_query("UPDATE sattendance SET result='1',lt_id='',reason='',result_half='',l_apply='0' WHERE satt_id='$satt_id1'");
						  }
					  }
			$datefrom = date ("Y-m-d", strtotime("+1 day", strtotime($datefrom)));
			 }
		}else if($lfrom_date<=$from_date && $llast_date<$to_date){
			/********************************************Big - Big ******************************************/
			echo "big-big";
			$datefrom=$lfrom_date;
			while ($datefrom <= $to_date) {
				//echo "$datefrom<br>";	
				if($datefrom < $from_date){
					//echo "$datefrom<br>";	
					$sdate_split5= explode('-', $datefrom);		 
						  $check_day=$sdate_split5[2];
						  $check_month=$sdate_split5[1];
						  $check_year=$sdate_split5[0];
						  $select_record1=mysql_query("SELECT satt_id FROM sattendance where (day='$check_day' AND month='$check_month' AND year='$check_year') AND (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) AND ay_id=$acyear");
						  $ccount=mysql_num_rows($select_record1);
						  if($ccount>0){
							  $select_record2=mysql_fetch_array($select_record1);
							  $satt_id1=$select_record2['satt_id'];
							  $sql=mysql_query("UPDATE sattendance SET result='1',lt_id='',reason='',result_half='',l_apply='0' WHERE satt_id='$satt_id1'");
						  }
				}else if($datefrom > $llast_date){
					//echo "$datefrom<br>";	
					$sdate_split5= explode('-', $datefrom);		 
					  $check_day=$sdate_split5[2];
					  $check_month=$sdate_split5[1];
					  $check_year=$sdate_split5[0];
					  $select_record1=mysql_query("SELECT satt_id FROM sattendance where (day='$check_day' AND month='$check_month' AND year='$check_year') AND (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) AND ay_id=$acyear");
					  $ccount=mysql_num_rows($select_record1);
					  //echo "$datefrom<br>";
					  if($ccount>0){
						  $select_record2=mysql_fetch_array($select_record1);
						  $satt_id1=$select_record2['satt_id'];
							if(($h_type=="M" || $h_type=="EM") && $datefrom == $to_date){
								$result1="off";
								$result_half="M";
							}else{
								$result1=0;
								$result_half="";
							}
								$lt_id=$l_type;
								$reason=$l_dec;
								$l_apply=$id;
							 $sql=mysql_query("UPDATE sattendance SET result='$result1',lt_id='$lt_id',reason='$reason',result_half='$result_half',l_apply='$l_apply' WHERE satt_id='$satt_id1'");
					  }
				}else{
					$sdate_split5= explode('-', $datefrom);		 
					  $check_day=$sdate_split5[2];
					  $check_month=$sdate_split5[1];
					  $check_year=$sdate_split5[0];
					  $select_record1=mysql_query("SELECT satt_id FROM sattendance where (day='$check_day' AND month='$check_month' AND year='$check_year') AND (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) AND ay_id=$acyear");
					  $ccount=mysql_num_rows($select_record1);
					  //echo "$datefrom<br>";
					  if($ccount>0){
						  $select_record2=mysql_fetch_array($select_record1);
						  $satt_id1=$select_record2['satt_id'];
							if(($h_type=="E" || $h_type=="EM") && $datefrom==$from_date){
								$result1="off";
								$result_half="E";
							}else{
								$result1=0;
								$result_half="";
							}
								$lt_id=$l_type;
								$reason=$l_dec;
								$l_apply=$id;
							 $sql=mysql_query("UPDATE sattendance SET result='$result1',lt_id='$lt_id',reason='$reason',result_half='$result_half',l_apply='$l_apply' WHERE satt_id='$satt_id1'");
					  }					
				}
				
				$datefrom = date ("Y-m-d", strtotime("+1 day", strtotime($datefrom)));		
			}
		}else if(($lfrom_date<=$from_date && $llast_date>$to_date) || ($lfrom_date<$from_date && $llast_date>=$to_date)){
			/******************************************** Betweens ******************************************/
			echo "between";
			$datefrom=$lfrom_date;
			while ($datefrom <= $llast_date) {
				if($datefrom<$from_date || $datefrom>$to_date){
					//echo "$datefrom<br>";	
					  $sdate_split5= explode('-', $datefrom);		 
					  $check_day=$sdate_split5[2];
					  $check_month=$sdate_split5[1];
					  $check_year=$sdate_split5[0];
					  $select_record1=mysql_query("SELECT satt_id FROM sattendance where (day='$check_day' AND month='$check_month' AND year='$check_year') AND (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) AND ay_id=$acyear");
					  $ccount=mysql_num_rows($select_record1);
					  if($ccount>0){
						  $select_record2=mysql_fetch_array($select_record1);
						  $satt_id1=$select_record2['satt_id'];
						  $sql=mysql_query("UPDATE sattendance SET result='1',lt_id='',reason='',result_half='',l_apply='0' WHERE satt_id='$satt_id1'");
					  }
				}else{
					$sdate_split5= explode('-', $datefrom);		 
					  $check_day=$sdate_split5[2];
					  $check_month=$sdate_split5[1];
					  $check_year=$sdate_split5[0];
					  $select_record1=mysql_query("SELECT satt_id FROM sattendance where (day='$check_day' AND month='$check_month' AND year='$check_year') AND (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) AND ay_id=$acyear");
					  $ccount=mysql_num_rows($select_record1);
					  //echo "$datefrom<br>";
					  if($ccount>0){
						  $select_record2=mysql_fetch_array($select_record1);
						  $satt_id1=$select_record2['satt_id'];
							if($h_type=="EM"){
									$result1="off";
								if($datefrom==$from_date){
									$result_half="E";
								}else if($datefrom==$to_date){
									$result_half="M";
								}
							}else if($h_type=="E" && $datefrom==$from_date){
								$result1="off";
								$result_half="E";
							}else if($h_type=="M" && $datefrom==$to_date){
								$result1="off";
								$result_half="M";
							}else{
								$result1=0;
								$result_half="";
							}
								$lt_id=$l_type;
								$reason=$l_dec;
								$l_apply=$id;
							 $sql=mysql_query("UPDATE sattendance SET result='$result1',lt_id='$lt_id',reason='$reason',result_half='$result_half',l_apply='$l_apply' WHERE satt_id='$satt_id1'");
					  }
				}
			$datefrom = date ("Y-m-d", strtotime("+1 day", strtotime($datefrom)));		
			}
		}else{
			$datefrom=$lfrom_date;
			while ($datefrom <= $llast_date) {
				
					$sdate_split5= explode('-', $datefrom);		 
					  $check_day=$sdate_split5[2];
					  $check_month=$sdate_split5[1];
					  $check_year=$sdate_split5[0];
					  $select_record1=mysql_query("SELECT satt_id FROM sattendance where (day='$check_day' AND month='$check_month' AND year='$check_year') AND (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) AND ay_id=$acyear");
					  $ccount=mysql_num_rows($select_record1);
					  //echo "$datefrom<br>";
					  if($ccount>0){
						  $select_record2=mysql_fetch_array($select_record1);
						  $satt_id1=$select_record2['satt_id'];
							if($h_type=="EM"){
									$result1="off";
								if($datefrom==$from_date){
									$result_half="E";
								}else if($datefrom==$to_date){
									$result_half="M";
								}
							}else if($h_type=="E" && $datefrom==$from_date){
								$result1="off";
								$result_half="E";
							}else if($h_type=="M" && $datefrom==$to_date){
								$result1="off";
								$result_half="M";
							}else{
								$result1=0;
								$result_half="";
							}
								$lt_id=$l_type;
								$reason=$l_dec;
								$l_apply=$id;
							 $sql=mysql_query("UPDATE sattendance SET result='$result1',lt_id='$lt_id',reason='$reason',result_half='$result_half',l_apply='$l_apply' WHERE satt_id='$satt_id1'");
					  }
			$datefrom = date ("Y-m-d", strtotime("+1 day", strtotime($datefrom)));		
			}
		}
    }else{
		/******************************************** All are cancel ******************************************/
		//echo "all are cancel";
		$datefrom=$lfrom_date;
			while ($datefrom <= $llast_date) {
				$sdate_split5= explode('-', $datefrom);		 
					  $check_day=$sdate_split5[2];
					  $check_month=$sdate_split5[1];
					  $check_year=$sdate_split5[0];
					  $select_record1=mysql_query("SELECT satt_id FROM sattendance where (day='$check_day' AND month='$check_month' AND year='$check_year') AND (st_id=$st_id AND o_id=$o_id AND d_id=$d_id) AND ay_id=$acyear");
					  $ccount=mysql_num_rows($select_record1);
					  if($ccount>0){
						  $select_record2=mysql_fetch_array($select_record1);
						  $satt_id1=$select_record2['satt_id'];
						  $sql=mysql_query("UPDATE sattendance SET result='1',lt_id='',reason='',result_half='',l_apply='0' WHERE satt_id='$satt_id1'");
					  }			
			$datefrom = date ("Y-m-d", strtotime("+1 day", strtotime($datefrom)));	
			}
	}
	
	$re_leave= mysql_real_escape_string($_POST["re_leave"]);
	if(($l_total>$re_leave) && $re_leave!="other"){
		header("location:leave_detail_edit1.php?id=$id&msg=ltotal");
		exit;
	}
	$query="update staff_leave set staff_name='$staff_name', l_type='$l_type', l_type_name='$l_type_name', a_date='$a_date', f_date='$f_date', t_date='$t_date', l_total='$l_total', l_des='$l_dec', h_type='$h_type', day='$sdate_day', month='$sdate_month', year='$sdate_year', f_day='$f_day', f_month='$f_month', f_year='$f_year', t_day='$t_day', t_month='$t_month', t_year='$t_year', status='$status', from_date='$from_date', to_date='$to_date' where id='$id' ";
	$result=mysql_query($query);
	if($result)
	{	
		header("location:leave_detail_edit1.php?id=$id&msg=succ");
	}
	else
	{
		header("location:leave_detail_edit1.php?id=$id&msg=err");
    }	
  }
   ?>
  </head>
 <body>
 <div id="wrapper">
	   <?php 
	   include("includes/head_logo.php");
	   
	   include("includes/top_nav.php");
	   
	   include("sidebar.php");
	   
	   
  $l_status=$employee["status"];
 $emp_query1="select * from others where o_id='$oid'";
		$emp_result1=mysql_query($emp_query1);
		$employee11=mysql_fetch_array($emp_result1);
		$ocid=$employee11["category_id"];
		
		$categorys=mysql_query("SELECT * FROM others_category WHERE oc_id='$ocid'");
				$ocategory=mysql_fetch_array($categorys);
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1><?php echo $employee11['fname']." ".$employee11['lname'];?> - Leave Edit <a href="leave_detail1.php?id=<?php echo $oid;?>&syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully edited 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php }
 if($_GET["msg"] == 'aerr') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> This employee already Got Loan!!!
			</div>
<?php }
if($_GET["msg"] == 'ltotal') { ?>
 <div class="alert alert-danger">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Total Leaves greater than Remaining leaves!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						<?php echo $employee11['fname']." ".$employee11['lname'];?> - Leave Edit   
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data" name="first">
				<?php 	
if($oid){
?>
             <div class="portlet-content">
     <!--<p class="title">Employee Details :</p> -->
     <div class="col-sm-6">
								<div class="form-group">
									<label for="name">Employee Name</label>
									<input type="text" id="staff_name" name="staff_name" class="form-control" data-required="true" value="<?php echo $employee11['fname']." ".$employee11['lname'];?>" readonly>
								</div>  
                                <div class="form-group">
									<label for="name">Leave Apply Date</label>
                                    <div class="input-group date ui-datepicker1" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="date" name="date" class="form-control" type="text" data-required="true" value="<?php echo date('d-m-Y');?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">Employee ID</label>
									<input type="text" id="staff_id" name="staff_id" class="form-control" data-required="true" value="<?php echo $employee11['others_id'];?>" readonly>
								</div>								
                                <div class="form-group">
									<label for="name">Leave Type</label><br>
									<select id="l_type" name="l_type" class="form-control" data-required="true">
                                    	<option value="">Plese select Employee</option>
                                        <?php 
										$l_type1=$employee['l_type'];
										
										$emp_result=mysql_query("select * from leavetype where lt_id=$l_type1");
										$emp_display=mysql_fetch_array($emp_result);
										$tother=$emp_display["other"];
										$emp_query12="select * from staff_leave where status='1' AND (o_id=$oid AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";	
											$emp_result12=mysql_query($emp_query21);
											while($emp_display21=mysql_fetch_array($emp_result21))
											{
												$tleave1 +=$emp_display21['l_total'];
											}
											$rleave1=$emp_display["l_total"]-$tleave1;
											if($tother){
												$rleave1="other";
											}
												
											
											
										$emp_query1="select * from leavetype order by lt_id asc";
										$emp_result1=mysql_query($emp_query1);
										while($emp_display1=mysql_fetch_array($emp_result1))
										{
											$lt_id=$emp_display1["lt_id"];	
											$other=$emp_display1["other"];
											$tleave=0;
											$emp_query2="select * from staff_leave where status='1' AND (o_id=$oid  AND l_type=$lt_id) AND ((year=$syear AND month>'5') OR (year=$eyear AND month<='5'))";	
											$emp_result2=mysql_query($emp_query2);
											while($emp_display2=mysql_fetch_array($emp_result2))
											{
												$tleave +=$emp_display2['l_total'];
											}
											$rleave=$emp_display1["l_total"]-$tleave;	
											if(($rleave>0 && $other==0) || $other){	
											if($l_type1==$lt_id){?>
                                        <option value="<?php echo $lt_id;?>" selected><?php echo $emp_display1["lt_name"]; ?></option>
                                        	<?php } else{?>
                                            <option value="<?php echo $lt_id;?>"><?php echo $emp_display1["lt_name"]; ?></option>
                                  <?php } } } ?>								
                            		</select>
                                    <input type="hidden" name="re_leave" value="<?php echo  $rleave1;?>"/>							
                            		</select>
								</div>                                   
                        </div>        
<div class="clear"></div><br>
                    <h4 class="heading1">
                                        <b>Leave Details</b>
                                    </h4>
				<div class="col-sm-6">
								<div class="form-group">
									<label for="name">From Date</label>
                                    <div class="input-group date ui-datepicker1" style="width:75%">
									<input class="form-control txt" type="text" placeholder="Start date" name="f_date" id="dpStart" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-required="true" value="<?php echo $employee['f_date'];?>">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>
                                <div class="form-group">
									<label for="name">Total Leave</label>
									<input type="text" id="net_salary" name="l_total" class="form-control"  data-required="true" data-type="number" autocomplete="off" readonly value="<?php echo $employee['l_total'];?>">
								</div>   
                                <div class="form-group">
                                <?php $h_type=$employee['h_type'];?>
									<label for="name">If Any HalfDay Leave</label>
									<select id="h_type" name="h_type" class="form-control parsley-validated" onChange="leave_total()">
                                    	<option value="" <?php if(!$h_type){ echo 'selected'; } ?>>No Halfday Leave</option>
                                        <option value="E" <?php if($h_type == "E"){ echo 'selected'; } ?>>Evening Leave In From Date</option>
                                        <option value="M" <?php if($h_type == "M"){ echo 'selected'; } ?>>Morning Leave in To Date</option>
                                        <option value="EM" <?php if($h_type == "EM"){ echo 'selected'; } ?>>Evening AND Morning</option>
                            		</select>
								</div> 
                                <div class="form-group">
									<label for="name">status</label><br>
									<select id="status" name="status" class="form-control" data-required="true">
                                    	<option value="0" <?php if($l_status == 0){ echo 'selected'; } ?>  >Pending</option>
<option value="2" <?php if($l_status == 2){ echo 'selected'; } ?>  >Rejected</option>
<option value="1" <?php if($l_status == 1){ echo 'selected'; } ?>  >Approved</option>							
                            		</select>
								</div>
                                 <div id="test">
        						</div>                              
                    </div>
                    <div class="col-sm-6">
								<div class="form-group">
									<label for="name">To Date</label>
                                    <div class="input-group date ui-datepicker1" style="width:75%">
									<input class="form-control txt" type="text" name="t_date" placeholder="End date" id="dpEnd" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-required="true" value="<?php echo $employee['t_date'];?>">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
								</div>
                                <div class="form-group">
									<label for="name">Description</label>
									<textarea id="deduction_total" name="l_dec" rows="5" class="form-control"><?php echo $employee['l_des'];?></textarea>
								</div>
                    </div>
                    <div class="clear"></div>
                    <div class="col-sm-12">
                    <center>
<div class="form-group">
								<input type="hidden" name="o_id" value="<?php echo  $oid;?>"/>
                                <input type="hidden" name="role" value="<?php echo $employee11['s_type'];?>"/>
                                <input type="hidden" name="fromdate" value="<?php echo $employee['f_date'];?>"/>
                                <input type="hidden" name="lastdate" value="<?php echo $employee['t_date'];?>"/>
								<input type="reset" class="btn btn-default">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
</center>
                                </div>

     </div>
     <?php }?>     
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); ?>
 <script type="text/javascript">
$(document).ready(function(){
    $("#l_type").change(function(){
		var thiss = $(this);
		var value = thiss.val(); 
        $.get("leave_calculate.php",{value:value, stid:<?php echo $oid;?>, type:'ow'},function(data){
			$( "#test" ).html(data);
        });
    });
});
</script>

<?php include("includes/script.php");?>
 <script type="text/javascript">
 $('#employee').select2 ({
		allowClear: true,
		placeholder: "Select..."
	})
	
 function select_employee() { 
      var employee = parseFloat(document.getElementById('employee').value);
	  if(employee>0){
		  window.location="leave_add.php?emp="+employee;
	  }	
}
$(document).ready(function(){ 
        $(".txt").each(function() { 
            $(this).change(function(){
                leave_total();
            });
        }); 
    });	
 function leave_total() {	
var a = document.first.f_date.value;
var b = document.first.t_date.value;

var date1 = a;
var date2 = b;

// First we split the values to arrays date1[0] is the year, [1] the month and [2] the day
date1 = date1.split('-');
date2 = date2.split('-');

// Now we convert the array to a Date object, which has several helpful methods
date1 = new Date(date1[2], date1[1], date1[0]);
date2 = new Date(date2[2], date2[1], date2[0]);

// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
date1_unixtime = parseInt(date1.getTime() / 1000);
date2_unixtime = parseInt(date2.getTime() / 1000);

// This is the calculated difference in seconds
var timeDifference = date2_unixtime - date1_unixtime;

// in Hours
var timeDifferenceInHours = timeDifference / 60 / 60;

// and finaly, in days :)
var timeDifferenceInDays = timeDifferenceInHours  / 24;

var timeDifferenceInDays =timeDifferenceInDays+1;
var ln=$("#h_type").val();
if(ln){
	if(ln=='EM'){
	timeDifferenceInDays=(timeDifferenceInDays-1);
	}else{
	timeDifferenceInDays=(timeDifferenceInDays-.5);
	}
}
if(timeDifferenceInDays=='0'){
	timeDifferenceInDays='0 - Days';
}
//alert(timeDifferenceInDays);
document.first.l_total.value = timeDifferenceInDays;
} 
</script>
</body>
</html>

 <? ob_flush(); ?>