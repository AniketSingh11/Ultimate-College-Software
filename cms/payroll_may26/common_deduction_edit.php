 <?php
 include("header.php");
 $id=$_GET["id"];
 
 $months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May"); 
 
  if(isset($_POST["submit"]))
  {
	$name= mysql_real_escape_string($_POST["name"]);
	$date= mysql_real_escape_string($_POST["date"]);
	$status= mysql_real_escape_string($_POST["status"]);
	
	$sdate_split1= explode('-', $date);	
	      $sdate_day=date("d");	 
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];
	$m_year=$months[$sdate_month]."-".$sdate_year;
	$cdate=$sdate_year."-".$sdate_month."-".$sdate_day;
	
	$query=mysql_query("update staff_deduction set cdate='$cdate',day='$sdate_day',month='$sdate_month',year='$sdate_year',m_year='$m_year',name='$name',status='$status' where sd_id='$id'");
	
	if($query)
	{
		$msg="succ";		
	}
	else
	{
		$msg="err";
    }
  }
  $emp_query="select * from staff_deduction where sd_id='$id'";
		$emp_result=mysql_query($emp_query);
		$employee=mysql_fetch_array($emp_result);
   ?>
  </head>
 <body>
 <div id="wrapper">
	   <?php 
	   include("includes/head_logo.php");	   
	   include("includes/top_nav.php");	   
	   include("sidebar.php");
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1> Common Deduction Edit <a href="common_deduction.php?syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($msg== 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Edited 
			</div>	
<?php } ?>
 <?php if($msg == 'err') { ?>
 <div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Common Deduction Edit
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
	<div class="col-sm-6">
                    <div class="form-group">
                        <label for="name">month - year </label>
                        <div class="input-group date ui-datepicker2" style="width:75%" data-date-format="dd-mm-yyyy">
                            <input id="salary_date" name="date" class="form-control" type="text" data-required="true" value="<?=str_pad($employee['month'], 2, '0', STR_PAD_LEFT)."-".$employee['year'];?>">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                    <div class="form-group">	
                        <label for="validateSelect">Status</label>
                        <select name="status" id="status" class="form-control" data-required="true">
                            <option value="0" <?php if($employee["status"]==0){ echo 'selected'; } ?>> Enable</option>
                            <option value="1" <?php if($employee["status"]==1){ echo 'selected';}?>> Disable</option>
                        </select>
					</div>  
    </div>
    <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name">Deduction Name</label>
                        <input type="text" id="name" name="name" class="form-control" data-required="true" value="<?=$employee['name'];?>" >
                    </div>                     
    </div>
    <div class="clear"></div>
                    <div class="col-sm-12">
                    <center>
<div class="form-group">
                    <input type="reset" class="btn btn-default">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
</center>
                                </div>
  			 </div>
</form>
		 </div>  <!-- /#content-container -->
	 </div>  <!-- #content -->
 </div>  <!-- #wrapper -->
 <?php 
 include("footer.php"); 
 include("includes/script.php");?>
</body>
</html>

 <? ob_flush(); ?>