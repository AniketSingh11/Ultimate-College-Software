<?php 
include("includes/config.php");
$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];
 


require('pdf_student.php');

$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();
 
$pdf->fact_dev( "Student  Report" );
$pdf->temporaire( "Student Report" );
$sdate=$_GET['sdate'];
$edate=$_GET['edate'];
 
$pdf->addReglement("Gender - Male");
$pdf->addEcheance("LKG");
$pdf->addNumTVA("A");
//$pdf->addReference("Devis ... du ....");
/*for($i=0;$i<=count($rs);$i++){
    $title= mysql_field_name($query,$i). ',';
    $cols["$title"]=25;
}*/
$cols=array("S.No"    => 8);

     for($i=0;$i<=count($rs);$i++){
        $title= mysql_field_name($query,$i). ',';
        $cols["$title"]=25;
    }
       
$pdf->addCols($cols);

             
//$pdf->addLineFormat($cols1);
//$pdf->addLineFormat($cols1);

$y = 49;
 	
$sdate_split1= explode('/', $sdate);
$sdate_month=$sdate_split1[0];
$sdate_day=$sdate_split1[1];
$sdate_year=$sdate_split1[2];
$startdate=$sdate_year.$sdate_month.$sdate_day;

$edate_split1= explode('/', $edate);
$edate_month=$edate_split1[0];
$edate_day=$edate_split1[1];
$edate_year=$edate_split1[2];

$enddate= $edate_year.$edate_month.$edate_day;


for($i=40;$i<=15;$i++){
$line = array( "S.No"    => "$count",
    "Particular"  => "FeesSFSFWE456JTRFJ68",
    "Expenses"     => "",
    "Income"      => number_format("900",2),
    "Total" => number_format("900",2));

$size = $pdf->addLine( $y, $line );
$y   += $size + 2;
}
 
 
						        $r1  = 10;
						       $r2  = "172";
						         $y1  = "39";
						        $y2  =  $y-$y1;
						       $pdf->Rect( $r1, $y1, $r2, $y2, "D");
						       $colX = $r1;
						       $tab=$cols;
						       while ( list( $lib, $pos ) = each ($tab) )
						       {
						          // $pdf->SetXY( $colX, $y1+2 );
						          // $this->Cell( $pos, 1, $lib, 0, 0, "C");
						           $colX += $pos;
						            $pdf->Line( $colX, $y1, $colX, $y1+$y2);
						       }
						     
						        
						      
						       /* $r1  = 10;
						        $r2  = "190";
						        $y1  = $y;
						        $y2  = "8";
						        $pdf->Rect( $r1, $y1, $r2, $y2, "D");*/
//$size = $pdf->addLine( $y, $line );
//$y   += $size + 2;

//$pdf->addCadreTVAs();
     
 

  

//$pdf->Output(); 
 $pdf->Output("studentexport.pdf", 'I');
$origFile="studentexport.pdf";
 

 

