<?php 
include("includes/config.php");
 
$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];
error_reporting(0);

require('businvoice.php');

$rid=$_GET['rid'];
$acyear=$_GET['ayid'];

$classlist=mysql_query("SELECT * FROM route WHERE r_id=$rid");
$route=mysql_fetch_array($classlist);
$vid=$route['v_id'];
$did=$route['d_id'];
$sdid=$route['sd_id'];
$vehiclelist=mysql_query("SELECT * FROM vehicle WHERE v_id=$vid");
$vehicle=mysql_fetch_array($vehiclelist);
$driverlist=mysql_query("SELECT * FROM driver WHERE d_id=$did");
$driver=mysql_fetch_array($driverlist);
$driverlist1=mysql_query("SELECT * FROM driver WHERE d_id=$sdid");
$driver1=mysql_fetch_array($driverlist1);

$pdf = new PDF_Invoice('P', 'mm', 'A4');
$pdf->AddPage();
 
$pdf->fact_dev("$school_name Bus Stage Report");
$pdf->temporaire( "Bus Stage");

$pdf->addReglement("$route[r_name]");
$pdf->addEcheance("$vehicle[v_no]");
$d=$pdf->addNumTVA("$driver[fname] $driver[lname]");

 

 


 	
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


$title=array();

$spquery  = "SELECT * FROM trstopping WHERE r_id=$rid ORDER BY ListingID ASC";
				$spresult = mysql_query($spquery);
				$count=1;
				while($sprow = mysql_fetch_array($spresult, MYSQL_ASSOC))
				{

				    
$qry=mysql_query("SELECT * FROM student WHERE  ay_id='$acyear' and sp_id='$sprow[stop_id]'");

while($row=mysql_fetch_array($qry))
{
  
    
    $column = 'A';

    $cid=$row['c_id'];
    $sid=$row['s_id'];
    $classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid");
    $class=mysql_fetch_array($classlist);
    $sectionlist=mysql_query("SELECT * FROM section WHERE s_id=$sid");
    $section=mysql_fetch_array($sectionlist);
    $bid=$row['b_id'];
    $boardlist=mysql_query("SELECT * FROM board WHERE b_id=$bid");
    $board=mysql_fetch_array($boardlist);
    $spid1=$row['sp_id'];
    $qry6=mysql_query("SELECT * FROM trstopping WHERE stop_id=$spid1");
    $row6=mysql_fetch_array($qry6);

    $fesstypearray1=array("Regural Bus","Sp.Bus","Onetime Sp.Bus","Onetime Bus");
    $busfeestype1=$row['busfeestype'];
    
    if($y==239 || $y > 239){
    
        $r1  = 10;
        $r2  = "186";
        $y1  = $ta-3;
        $y2  =  $y-$y1;
        $pdf->Rect( $r1, $y1, $r2, $y2, "D");
        $colX = $r1;
        $tab=$cols2;
        while ( list( $lib, $pos ) = each ($tab) )
        {
            // $pdf->SetXY( $colX, $y1+2 );
            // $this->Cell( $pos, 1, $lib, 0, 0, "C");
            $colX += $pos;
            $pdf->Line( $colX, $y1, $colX, $y1+$y2);
        }
    
        $pdf->AddPage();
        $y=30;
    
        $ta=$y;
    }
    
    

   if (in_array("$row6[stop_name]", $title))
   {
   }else{
       $r1  = 10;
       $r2  = "186";
       $y1  = $ta-3;
       $y2  =  $y-$y1;
       $pdf->Rect( $r1, $y1, $r2, $y2, "D");
       $colX = $r1;
       $tab=$cols2;
       while ( list( $lib, $pos ) = each ($tab) )
       {
           // $pdf->SetXY( $colX, $y1+2 );
           // $this->Cell( $pos, 1, $lib, 0, 0, "C");
           $colX += $pos;
           $pdf->Line( $colX, $y1, $colX, $y1+$y2);
       }
       
       
        array_push($title,$row6[stop_name]);
        
        if($count==1)
        {
            $dd=$d;
        }else{
            $dd=$y;
        }
        
        $t=$pdf->addEcheance1("$row6[stop_name]",$dd);
       // echo $t."t<br>";
        //$pdf->addReference("Devis ... du ....");
        $cols=array("S.No"    => 12,
            "Student ID"  => 26,
            "Student Name"     => 60,
            "Class - Section"      => 36,
            "Phone" => 30
        );
         
        $ta=$pdf->addCols($cols,$t);
       
        $ta=$t+6;
        /*$cols1=array( "S.No"    => "L",
         "Student ID"  => "L",
         "Student Name"     => "C",
         "Class - Section"      => "R",
        
        
         "Phone" => "R"
        
        );
         
        //$pdf->addLineFormat( $cols1);
        //$pdf->addLineFormat($cols1);
        */
      $y = $ta;

   
        
    }
    


 
    $y=$y+8;
 
 
$line = array("S.No"  => "$count",
              "Student ID"  => $row['admission_number'],
               "Student Name"  => $row['firstname']." ".$row['lastname'],
               "Class - Section"   => $class['c_name']." / ".$section['s_name'],
              
               "Phone" => $row['phone_number']);

$size = $pdf->addLine($y, $line);
$y   += $size + 2;
 
 //$pdf->Line("10",$y,"196",$y );
 



 
$count++;
 


    } 
						 
				}	 
						     
						        
						      
						       /* $r1  = 10;
						        $r2  = "190";
						        $y1  = $y;
						        $y2  = "8";
						        $pdf->Rect( $r1, $y1, $r2, $y2, "D");*/
//$size = $pdf->addLine( $y, $line );
//$y   += $size + 2;
 
 
 
 

 
$r1  = 10;
$r2  = "186";
$y1  = $ta-3;
$y2  =  $y-$y1;
$pdf->Rect( $r1, $y1, $r2, $y2, "D");
$colX = $r1;
$tab=$cols2;
while (list($lib, $pos) = each ($tab))
{
    // $pdf->SetXY( $colX, $y1+2 );
    // $this->Cell( $pos, 1, $lib, 0, 0, "C");
    $colX += $pos;
    $pdf->Line( $colX, $y1, $colX, $y1+$y2);
}
//$pdf->Output(); 

 $pdf->Output("bus($route[r_name]).pdf", 'D');
 

 

