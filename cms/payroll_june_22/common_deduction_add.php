 <?php
 include("header.php");
 $months = array("06"=>"June", "07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December", "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May"); 
  if(isset($_POST["submit"]))
  {
	 
	$name= mysql_real_escape_string($_POST["name"]);
	$date= mysql_real_escape_string($_POST["date"]);
	
	$sdate_split1= explode('-', $date);	
	      $sdate_day=date("d");	 
		  $sdate_month=$sdate_split1[0];
		  $sdate_year=$sdate_split1[1];
	$m_year=$months[$sdate_month]."-".$sdate_year;
	$cdate=$sdate_year."-".$sdate_month."-".$sdate_day;
	
	$query="insert into staff_deduction(cdate,day,month,year,m_year,name)values('$cdate','$sdate_day','$sdate_month','$sdate_year','$m_year','$name')";
	$result=mysql_query($query);	
	if($result)
	{
		header("location:common_deduction_add.php?msg=succ");		
	}
	else
	{
		header("location:common_deduction_add.php?msg=err");
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
	   ?>
     <div id="content">	
		 <div id="content-header">
			 <h1> Common Deduction Add <a href="common_deduction.php?syear=<?php echo $ay['s_year'].'&eyear='.$ay['e_year'];?>"><button type="button" class="btn btn-success"> <i class="fa fa-angle-double-left"></i> Back</button></a></h1>
		 </div>  <!-- #content-header -->	
		 <div id="content-container">
			 <div class="portlet">
 <?php if($_GET["msg"] == 'succ') { ?>	
 <div class="alert alert-success">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>done!</strong> Your Record Successfully Inserted 
			</div>	
<?php } ?>
 <?php if($_GET["msg"] == 'err') { ?>
 <div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<strong>Error!</strong> Some Query Error on this details!!!
			</div>
<?php } ?>
				 <div class="portlet-header">			
					 <h3>						 
						Common Deduction Add
					 </h3>			
				 </div>  <!-- /.portlet-header -->			
<form id="validate-enhanced" action="" class="form parsley-form" method="post" enctype="multipart/form-data">
				 <div class="portlet-content">
<div class="col-sm-6">
				            	<div class="form-group">
									<label for="name">month - year </label>
									<div class="input-group date ui-datepicker2" style="width:75%" data-date-format="dd-mm-yyyy">
		                                <input id="salary_date" name="date" class="form-control" type="text" data-required="true" value="<?php //echo date('d-m-Y');?>">
		                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                            </div>
								</div>
                                
</div>
<div class="col-sm-6">
								<div class="form-group">
									<label for="name">Deduction Name</label>
									<input type="text" id="name" name="name" class="form-control" data-required="true" >
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