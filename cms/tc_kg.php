<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>TC</title>
<?php
include("includes/config.php");
error_reporting(E_ALL ^ E_NOTICE);
session_start();
?>
<?php 
$id=$_GET['tcid'];
$tcall=mysql_query("select * from tc_xi_kg where id='$id'");
$tc=mysql_fetch_assoc($tcall);
?>
</head>

<body style="font-family:arial">

<div id="printablediv" style="width:216mm; height:356mm">

<div style="width:216mm; height:335.36mm; min-height:178mm; max-height:178mm;">

	<div style="width:216mm; height:35.1mm; min-height:35.1mm;">
    <div style="text-align: center; width:12%; float:left;"> 
        <img src="img/christschool_logo.png" alt="logo" title="logo" style="width:100%;" />
    </div>
    <div style="text-align: center; width:72%; float:left;">
        <h1 style="padding:0px; padding-bottom:2px; margin:0px; font-family:georgia; letter-spacing: 0.2em;">CHRIST</h1>
        <h5 style="padding:0px; padding-bottom:2px; margin:0px; font-size:21px; font-weight:bold; letter-spacing:0.1em">MATRICULATION HR. SEC. SCHOOL</h5>
        <h5 style="padding:0px; padding-bottom:2px; margin:0px; font-size:15px; font-weight:bold">Christ Nagar, Seneerkuppam, Poonamallae, Chennai - 56 </h5><br>
        <span style="padding:8px 10px 8px; margin:10px 0px 0px 0px; border:1px solid #000; border-radius:10px; font-weight:bold">TRANSFER CERTIFICATE</span>
    </div>
</div>


	<div style="width:216mm; height:12mm; min-height:12mm;">
    <div style="width:216mm; float:left; padding-bottom:10px;">
        <div style="float:left; font-size:14px; width:7%; font-weight:bold;">T.C. No:</div>
        <div style="float:left; font-size:14px; width:23%;"> <?= $tc['tno']?> </div>
        <div style="float:left; font-size:14px; width:7%; font-weight:bold;"></div>  
        <div style="float:left; font-size:14px; width:31%;"> <?= $tc['na_en']?> </div>
        <div style="float:left; font-size:14px; width:13%; font-weight:bold;">Admission No:</div>
        <div style="float:left; font-size:14px; width:19%;"> <?= $tc['ano']?> </div>
    </div>
</div>

    <div style="width:216mm; font-size:15px;">
    
    <div style="width:216mm;">
        <div style="width:216mm; float:left; height:10mm;">
        <div style="width:40%; float:left;">1. &nbsp;  Name of the Pupil</div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['sname']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:10mm;">
        <div style="width:40%; float:left;">2. &nbsp;  Name of the Father</div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['fname']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:16mm;">
        <div style="width:40%; float:left; line-height:21px;">3. &nbsp;  Date of Birth<br> <span style="margin-left:6mm"> (in words)</span></div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['dobfigure']?>, <?= $tc['dobword']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:10mm;">
        <div style="width:40%; float:left;">4. &nbsp; Date of Admission </div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['doandclass']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:14mm;">
        <div style="width:40%; float:left; line-height:21px;">5. &nbsp;  Standard in which the Pupil was Studing at <br> <span style="margin-left:6mm">the time of leaving</span></div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['leaving']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:14mm;">
        <div style="width:40%; float:left; line-height:21px;">6. &nbsp;  Whether Qualified for <br> <span style="margin-left:6mm"> Promotion</span></div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['q_std']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:10mm;">
        <div style="width:40%; float:left;">7. &nbsp;  Date of leaving</div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['last_att']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:10mm;">
        <div style="width:40%; float:left;">8. &nbsp;  Conduct</div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['conduct']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:10mm; margin-top:15mm">
        <div style="width:40%; float:left; margin-left:5mm; font-weight:bold">Signature of the <br> <span> Parent/Guardian</span></div>
        <div style=" width:57%; float:left; font-weight:bold; font-size:13px; font-family:georgia; text-align:right"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:14px; font-family:arial; text-align:left; font-weight:bold">Principal</span></div>
        </div>
    
    </div>
    
    
    </div>
    
    </div>
    
<div style="width:216mm; height:335.36mm; min-height:178mm; max-height:178mm;margin-top:15mm;">

    <div style="width:216mm; height:35.1mm; min-height:35.1mm;">
    <div style="text-align: center; width:12%; float:left;"> 
        <img src="img/christschool_logo.png" alt="logo" title="logo" style="width:100%;" />
    </div>
    <div style="text-align: center; width:72%; float:left;">
        <h1 style="padding:0px; padding-bottom:2px; margin:0px; font-family:georgia; letter-spacing: 0.2em;">CHRIST</h1>
        <h5 style="padding:0px; padding-bottom:2px; margin:0px; font-size:21px; font-weight:bold; letter-spacing:0.1em">MATRICULATION HR. SEC. SCHOOL</h5>
        <h5 style="padding:0px; padding-bottom:2px; margin:0px; font-size:15px; font-weight:bold">Christ Nagar, Seneerkuppam, Poonamallae, Chennai - 56 </h5><br>
        <span style="padding:8px 10px 8px; margin:10px 0px 0px 0px; border:1px solid #000; border-radius:10px; font-weight:bold">TRANSFER CERTIFICATE</span>
    </div>
</div>


    <div style="width:216mm; height:12mm; min-height:12mm;">
    <div style="width:216mm; float:left; padding-bottom:10px;">
        <div style="float:left; font-size:14px; width:7%; font-weight:bold;">T.C. No:</div>
        <div style="float:left; font-size:14px; width:23%;"> <?= $tc['tno']?> </div>
        <div style="float:left; font-size:14px; width:7%; font-weight:bold;">Rc.No:</div>  
        <div style="float:left; font-size:14px; width:31%;"> <?= $tc['na_en']?> </div>
        <div style="float:left; font-size:14px; width:13%; font-weight:bold;">Admission No:</div>
        <div style="float:left; font-size:14px; width:19%;"> <?= $tc['ano']?> </div>
    </div>
</div>

    <div style="width:216mm; font-size:15px;">
    
    <div style="width:216mm;">
        <div style="width:216mm; float:left; height:10mm;">
        <div style="width:40%; float:left;">1. &nbsp;  Name of the Pupil</div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['sname']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:10mm;">
        <div style="width:40%; float:left;">2. &nbsp;  Name of the Father</div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['fname']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:16mm;">
        <div style="width:40%; float:left; line-height:21px;">3. &nbsp;  Date of Birth<br> <span style="margin-left:6mm"> (in words)</span></div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['dobfigure']?>, <?= $tc['dobword']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:10mm;">
        <div style="width:40%; float:left;">4. &nbsp; Date of Admission </div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['doandclass']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:14mm;">
        <div style="width:40%; float:left; line-height:21px;">5. &nbsp;  Standard in which the Pupil was Studing at <br> <span style="margin-left:6mm">the time of leaving</span></div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['leaving']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:14mm;">
        <div style="width:40%; float:left; line-height:21px;">6. &nbsp;  Whether Qualified for <br> <span style="margin-left:6mm"> Promotion</span></div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['q_std']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:10mm;">
        <div style="width:40%; float:left;">7. &nbsp;  Date of leaving</div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['last_att']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:10mm;">
        <div style="width:40%; float:left;">8. &nbsp;  Conduct</div>
        <div style="width:1.5%; float:left"> : </div><div style=" width:58.5%; float:left; border-bottom:1px dashed #424141; font-weight:bold; font-size:13px; font-family:georgia;"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:13px; font-family:arial; text-align:left"><?= $tc['conduct']?></span></div>
        </div>
    
        <div style="width:216mm; float:left; height:10mm; margin-top:15mm">
        <div style="width:40%; float:left; margin-left:5mm; font-weight:bold">Signature of the <br> <span> Parent/Guardian</span></div>
        <div style=" width:57%; float:left; font-weight:bold; font-size:13px; font-family:georgia; text-align:right"> &nbsp;&nbsp;&nbsp; <span style="line-height:26px; font-size:14px; font-family:arial; text-align:left; font-weight:bold">Principal</span></div>
        </div>
    
    </div>
    
    
    </div>
    
    </div>

</div>

</body>
<script type="text/javascript">
    window.print();
</script>
</html>
