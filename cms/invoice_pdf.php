<?php 
include("includes/config.php");

$qry=mysql_fetch_array(mysql_query("select * from school_name"));
$school_name=$qry["sc_name"];


$acyear=$_SESSION['acyear'];
/*
$ayear=mysql_query("SELECT * FROM year WHERE status='1'");
$ay=mysql_fetch_array($ayear);

$acyear=$ay['ay_id'];
$acyear_name=$ay['y_name'];
 */
error_reporting(0);

require('invoice.php');



$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();
 
$pdf->fact_dev( "$school_name Finance Report" );
$pdf->temporaire( "Balance Report" );
$sdate=$_GET['sdate'];
$edate=$_GET['edate'];
 
$pdf->addReglement("$sdate");
$pdf->addEcheance("$edate");
$pdf->addNumTVA(time());
//$pdf->addReference("Devis ... du ....");
$cols=array( "S.No"    => 12,
             "Particular"  => 78,
             "Expenses"     => 26,
             "Income"      => 26,
             "Total" => 30 );
       
$pdf->addCols( $cols);
$cols1=array( "S.No"    => "L",
             "Particular"  => "L",
             "Expenses"     => "C",
             "Income"      => "R",
             "Total" => "R");
             
$pdf->addLineFormat( $cols1);
$pdf->addLineFormat($cols1);

$y = 49;
 	
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




$count=1;
$qry5=mysql_query("SELECT * FROM fgroup");
$total=0;
while($row5=mysql_fetch_array($qry5))
{
    $fg_id=$row5['fg_id'];
    $fg_amount=0;
    $feeslist=mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear and c_status!='1'");
    while($fees=mysql_fetch_array($feeslist))
    {
        $fi_id=$fees['fi_id'];
        $feesummarry=mysql_query("SELECT * FROM fsalessumarry WHERE fi_id=$fi_id AND fg_id=$fg_id");
        while($fsummarry=mysql_fetch_array($feesummarry)){
            $amount=$fsummarry['amount'];
            $fg_amount += $amount;
           
        }
    }
    
    if($fg_amount!=0){
 
$line = array( "S.No"    => "$count",
               "Particular"  => "$row5[fg_name].Fees",
               "Expenses"     => "",
               "Income"      => number_format($fg_amount,2),
               "Total" => number_format($fg_amount,2));
            
$size = $pdf->addLine( $y, $line );
$y   += $size + 2;
 
    $count++; } 
						$total += $fg_amount; }
						
						
						$qry5=mysql_query("SELECT * FROM mfgroup");
						 
						while($row5=mysql_fetch_array($qry5))
						{
						    $fg_id=$row5['fg_id'];
						    $fg_amount=0;
						    $feeslist=mysql_query("SELECT * FROM mfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear and c_status!='1'");
						    while($fees=mysql_fetch_array($feeslist))
						    {
						        $fi_id=$fees['fi_id'];
						        $feesummarry=mysql_query("SELECT * FROM mfsalessumarry WHERE fi_id=$fi_id AND fg_id=$fg_id");
						        while($fsummarry=mysql_fetch_array($feesummarry)){
						            $amount=$fsummarry['amount'];
						            $fg_amount += $amount;
						             
						        }
						    }
						
						    if($fg_amount!=0){
						
						        $line = array( "S.No"    => "$count",
						            "Particular"  => "$row5[fg_name].Fees",
						            "Expenses"     => "",
						            "Income"      => number_format($fg_amount,2),
						            "Total" => number_format($fg_amount,2));
						
						        $size = $pdf->addLine( $y, $line );
						        $y   += $size + 2;
						
						        $count++; }
						        $total += $fg_amount; }
						
						
						$book_amount=0;
						$booklist=mysql_query("SELECT * FROM invoice WHERE (i_year*10000) + (i_month*100) + i_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear and i_status='0'");
						while($book1=mysql_fetch_array($booklist))
						{
						    $bamont=$book1['i_total'];
						    $book_amount += $bamont;
						}
						$total +=$book_amount;
						if($book_amount!=0){
						    $line = array( "S.No"    => "$count",
						        "Particular"  => "Book Fees",
						        "Expenses"     => "",
						        "Income"      => number_format($book_amount,2),
						        "Total" => number_format($book_amount,2));
						    
						    $size = $pdf->addLine( $y, $line );
						    $y   += $size + 2;
						    $count++;
						}

						$bus_amount=0;
						$booklist1=mysql_query("SELECT * FROM bfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear");
						while($bus1=mysql_fetch_array($booklist1))
						{
						    $bamont1=$bus1['fi_total'];
						    $bus_amount += $bamont1;
						}
						$total +=$bus_amount;
						if($bus_amount!=0){
						
						    
						    $line = array( "S.No"    => "$count",
						        "Particular"  => "Bus Fees",
						        "Expenses"     => "",
						        "Income"      => number_format($bus_amount,2),
						        "Total" => number_format($bus_amount,2));
						    
						    $size = $pdf->addLine( $y, $line );
						    $y   += $size + 2;
						    $count++;
						    }
						    
						    $in_amount=0;
						    $booklist1=mysql_query("SELECT * FROM income WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear");
						    while($bus1=mysql_fetch_array($booklist1))
						    {
						        $bamont1=$bus1['amount'];
						        $in_amount += $bamont1;
						         
						        $total +=$in_amount;
						    }
						    if($in_amount!=0){
						        $line = array( "S.No"    => "$count",
						            "Particular"  => "Other Incomes",
						            "Expenses"     => "",
						            "Income"      => number_format($in_amount,2),
						            "Total" => number_format($in_amount,2));
						        $size = $pdf->addLine( $y, $line );
						        $y   += $size + 2;
						        $count++;
						    }
						    
						    $etotal=0;
						    $qry1=mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear AND funds='1'");
						    $sdf_total=0;
						    while($row1=mysql_fetch_array($qry1))
						    {
						        $sdf_tamount=$row1['fund_amount'];
						        $sdf_total +=$sdf_tamount;
						    }
						    $etotal += $sdf_total;
						    if($etotal){
						        
						        $line = array( "S.No"    => "$count",
						            "Particular"  => "Student Discount Funds",
						            "Expenses"     => number_format($sdf_total,2),
						            "Income"      => "",
						            "Total" => number_format($sdf_total,2));
						        
						        $size = $pdf->addLine( $y, $line );
						        $y   += $size + 2;
						        
						        
						        $count++;
						    }
						    
						    
						    $etotal=0;
						    $qry1=mysql_query("SELECT * FROM mfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear AND funds='1'");
						    $sdf_total=0;
						    while($row1=mysql_fetch_array($qry1))
						    {
						        $sdf_tamount=$row1['fund_amount'];
						        $sdf_total +=$sdf_tamount;
						    }
						    $etotal += $sdf_total;
						    if($etotal){
						    
						        $line = array( "S.No"    => "$count",
						            "Particular"  => "Student Discount Funds",
						            "Expenses"     => number_format($sdf_total,2),
						            "Income"      => "",
						            "Total" => number_format($sdf_total,2));
						    
						        $size = $pdf->addLine( $y, $line );
						        $y   += $size + 2;
						    
						    
						        $count++;
						    }
						    
						    

						   
						    $qry6=mysql_query("SELECT * FROM ex_category");
						    while($row6=mysql_fetch_array($qry6))
						    {
						        $exc_id=$row6['exc_id'];
						        $exc_amount=0;
						        $feeslist1=mysql_query("SELECT * FROM exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND exc_id=$exc_id AND ay_id=$acyear");
						        while($fees1=mysql_fetch_array($feeslist1))
						        {
						            $amount1=$fees1['amount'];
						            $exc_amount += $amount1;
						        }
						        if($exc_amount!=0){
						            
						            $line = array( "S.No"    => "$count",
						                "Particular"  => "$row6[ex_category]",
						                "Expenses"     =>  number_format($exc_amount,2),
						                "Income"      => "",
						                "Total" => number_format($exc_amount,2));
						            
						            $size = $pdf->addLine( $y, $line );
						            $y   += $size + 2;
						        
						        $count++;  }
						        $etotal += $exc_amount;
						        }
						        
						        $exc_amount1=0;
						        $feeslist2=mysql_query("SELECT *  FROM staff_month_salary WHERE (year*10000) + (month*100) + day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear");
						        while($fees2=mysql_fetch_array($feeslist2))
						        {
						            $amount2=$fees2['n_salary'];
						            $exc_amount1 += $amount2;
						        }
						        $etotal +=$exc_amount1;
						        if($exc_amount1!=0){
						            
						            
						            $line = array( "S.No"    => "$count",
						                "Particular"  => "Staffs Salary",
						                "Expenses"     =>  number_format($exc_amount1,2),
						                "Income"      => "",
						                "Total" => number_format($exc_amount1,2));
						            
						            $size = $pdf->addLine( $y, $line );
						            $y   += $size + 2;
						            $count++;
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

$pdf->addCadreTVAs();
     
$tot_prods = array(array("px_unit" => 600, "qte" => 1, "tva" => 1 ));
$tab_tva = array( "1"       => 19.6,
                  "2"       => 5.5);
$params  = array( "RemiseGlobale" => 1,
                      "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
                      "remise"         => 0,       // {montant de la remise}
                      "remise_percent" => 10,      // {pourcentage de remise sur ce montant de TVA}
                  "FraisPort"     => 1,
                      "portTTC"        => 10,      // montant des frais de ports TTC
                                                   // par defaut la TVA = 19.6 %
                      "portHT"         => 0,       // montant des frais de ports HT
                      "portTVA"        => 19.6,    // valeur de la TVA a appliquer sur le montant HT
                  "AccompteExige" => 1,
                      "accompte"         => 0,     // montant de l'acompte (TTC)
                      "accompte_percent" => 15,    // pourcentage d'acompte (TTC)
                  "Remarque" => "" );

//$pdf->addTVAs( "dfdf", "dfdf", "dfdf");
$y    = $y +2;
$finaltotal =$total-$etotal;
$line = array(  
    "Particular"  => "Income : Rs. ".number_format($total,2)." | Expenses :Rs. ".number_format($etotal,2)." ( ".number_format($total,0)." - ".number_format($etotal,0)." )",
    "Expenses"     => "Rs. ".number_format($etotal,2),
    "Income"      => "Rs. ".number_format($total,2),
    "Total" =>  "Rs. ".number_format($finaltotal,2));

$size = $pdf->addLine( $y, $line );
$y   += $size + 2;

$pdf->addCadreEurosFrancs(number_format($total,2),number_format($etotal,2),number_format($finaltotal,2),$y);

$y=($y+$y1)-15;

$tavle_y=$y;

 


$qry1=mysql_query("SELECT * FROM finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear and c_status!='1'");
$incount=1;
while($row1=mysql_fetch_array($qry1))
{
    
    if($incount=="1")
    {

        $cols2=array( "S.No"    => 12,
            "Fees Invoice Number"  => 78,
            "Date"     => 26,
            "Amount"      => 26 );
        
        $pdf->addCols1( $cols2,$y);
        
        
        $y=$y+10;
}
    
$line = array("S.No"    => "$incount",
    "Invoice Number"  => "$row1[fr_no]",
    "Date"     =>  $row1[fi_day]."/".$row1[fi_month]."/".$row1[fi_year],
    "Amount"      => "Rs. $row1[fi_total]");

$size = $pdf->addLine( $y, $line );
$y   += $size + 2;

if($y==269 || $y > 269){

    $r1  = 10;
    $r2  = "142";
    $y1  = $tavle_y;
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
    $y=19;

    $tavle_y=$y;
}


$incount++;
}




$qry1=mysql_query("SELECT * FROM mfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear and c_status!='1'");
$incount=1;
while($row1=mysql_fetch_array($qry1))
{
    
    if($incount=="1")
    {
        $cols2=array( "S.No"    => 12,
            "Monthly Fees Invoice Number"  => 78,
            "Date"     => 26,
            "Amount"      => 26 );
        
        $pdf->addCols1( $cols2,$y);
        
        
        $y=$y+10;
    }
        
    $line = array( "S.No"    => "$incount",
        "Monthly Fees Invoice Number"  => "$row1[fr_no]",
        "Date"     =>  $row1[fi_day]."/".$row1[fi_month]."/".$row1[fi_year],
        "Amount"      => "Rs. $row1[fi_total]");

    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;
    
    
    if($y==269 || $y > 269){
    
        $r1  = 10;
        $r2  = "142";
        $y1  = $tavle_y;
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
        $y=19;
    
        $tavle_y=$y;
    }
    
    
    $incount++;
}



$qry1=mysql_query("SELECT * FROM invoice WHERE (i_year*10000) + (i_month*100) + i_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear and i_status='0'");
$incount=1;
while($row1=mysql_fetch_array($qry1))
{
    if($incount=="1")
    {
        
        $cols2=array( "S.No"    => 12,
            "Book Fees Invoice Number"  => 78,
            "Date"     => 26,
            "Amount"      => 26 );
        
        $pdf->addCols1( $cols2,$y);
        
        
        $y=$y+10;
    }
    
    $line = array( "S.No"    => "$incount",
        "Book Fees Invoice Number"  => "$row1[i_no]",
        "Date"     =>  $row1[i_day]."/".$row1[i_month]."/".$row1[i_year],
        "Amount"      => "Rs. $row1[i_total]");

    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;


    if($y==269 || $y > 269){

        $r1  = 10;
        $r2  = "142";
        $y1  = $tavle_y;
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
        $y=19;

        $tavle_y=$y;
    }


    $incount++;
}



$qry1=mysql_query("SELECT * FROM bfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear");
$incount=1;
while($row1=mysql_fetch_array($qry1))
{
    
    if($incount=="1")
    {
        $cols2=array( "S.No"    => 12,
            "Bus Fees Invoice Number"  => 78,
            "Date"     => 26,
            "Amount"      => 26 );
        
        $pdf->addCols1( $cols2,$y);
        
        
        $y=$y+10;
        
    }
    $line = array( "S.No"    => "$incount",
        "Bus Fees Invoice Number"  => "$row1[fr_no]",
        "Date"     =>  $row1[fi_day]."/".$row1[fi_month]."/".$row1[fi_year],
        "Amount"      => "Rs. $row1[fi_total]");

    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;


    if($y==269 || $y > 269){

        $r1  = 10;
        $r2  = "142";
        $y1  = $tavle_y;
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
        $y=19;

        $tavle_y=$y;
    }


    $incount++;
}



$qry1=mysql_query("SELECT * FROM income WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear");
$incount=1;
while($row1=mysql_fetch_array($qry1))
{
    
    if($incount=="1")
    {
        $cols2=array( "S.No"    => 12,
            "Income Invoice Number"  => 78,
            "Date"     => 26,
            "Amount"      => 26 );
        
        $pdf->addCols1( $cols2,$y);
        
        
        $y=$y+10;
    }
    
    $line = array( "S.No"    => "$incount",
        "Income Invoice Number"  => "$row1[r_no]",
        "Date"     =>  $row1[date_day]."/".$row1[date_month]."/".$row1[date_year],
        "Amount"      => "Rs. $row1[amount]");

    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;


    if($y==269 || $y > 269){

        $r1  = 10;
        $r2  = "142";
        $y1  = $tavle_y;
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
        $y=19;

        $tavle_y=$y;
    }


    $incount++;
}




$qry1=mysql_query("SELECT * FROM  finvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear AND funds='1'");
$incount=1;
while($row1=mysql_fetch_array($qry1))
{
    if($incount=="1")
    {
        
        $cols2=array( "S.No"    => 12,
            "Student Discount Funds Invoice Number"  => 78,
            "Date"     => 26,
            "Amount"      => 26 );
        
        $pdf->addCols1( $cols2,$y);
        
        
        $y=$y+10;
    }
    
    $line = array( "S.No"    => "$incount",
        "Student Discount Funds Invoice Number"  => "$row1[fr_no]",
        "Date"     =>  $row1[fi_day]."/".$row1[fi_month]."/".$row1[fi_year],
        "Amount"      => "Rs. $row1[fund_amount]");

    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;


    if($y==269 || $y > 269){

        $r1  = 10;
        $r2  = "142";
        $y1  = $tavle_y;
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
        $y=19;

        $tavle_y=$y;
    }


    $incount++;
}




$qry1=mysql_query("SELECT * FROM  mfinvoice WHERE (fi_year*10000) + (fi_month*100) + fi_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear AND funds='1'");
$incount=1;
while($row1=mysql_fetch_array($qry1))
{
    if($incount=="1")
    {
    
        $cols2=array( "S.No"    => 12,
            "Monthly Discount Funds Invoice Number"  => 78,
            "Date"     => 26,
            "Amount"      => 26 );
        
        $pdf->addCols1( $cols2,$y);
        
        $y=$y+10;
        
    }
    
    $line = array( "S.No"    => "$incount",
        "Monthly Student Discount Funds Invoice Number"  => "$row1[fr_no]",
        "Date"     =>  $row1[fi_day]."/".$row1[fi_month]."/".$row1[fi_year],
        "Amount"      => "Rs. $row1[fund_amount]");

    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;


    if($y==269 || $y > 269){

        $r1  = 10;
        $r2  = "142";
        $y1  = $tavle_y;
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
        $y=19;

        $tavle_y=$y;
    }


    $incount++;
}





$qry1=mysql_query("SELECT * FROM  exponses WHERE (date_year*10000) + (date_month*100) + date_day between '" . $startdate. "' AND '" . $enddate. "' AND ay_id=$acyear ");
$incount=1;
while($row1=mysql_fetch_array($qry1))
{
    if($incount=="1")
    {
    
        $cols2=array( "S.No"    => 12,
            "Exponses Invoice Number"  => 78,
            "Date"     => 26,
            "Amount"      => 26 );
        
        $pdf->addCols1( $cols2,$y);
        
        $y=$y+10;
        
    }
    
    $line = array( "S.No"    => "$incount",
        "Exponses Invoice Number"  => "$row1[r_no]",
        "Date"     =>  $row1[date_day]."/".$row1[date_month]."/".$row1[date_year],
        "Amount"      => "Rs. $row1[fund_amount]");

    $size = $pdf->addLine( $y, $line );
    $y   += $size + 2;


    if($y==269 || $y > 269){

        $r1  = 10;
        $r2  = "142";
        $y1  = $tavle_y;
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
        $y=19;

        $tavle_y=$y;
    }


    $incount++;
}


 
$r1  = 10;
$r2  = "142";
$y1  = $tavle_y;
$y2  =  $y-$y1;
$pdf->Rect( $r1, $y1, $r2, $y2, "D");
$colX = $r1;
$tab=$cols2;
while ( list($lib, $pos) = each ($tab) )
{
    // $pdf->SetXY( $colX, $y1+2 );
    // $this->Cell( $pos, 1, $lib, 0, 0, "C");
    $colX += $pos;
    $pdf->Line( $colX, $y1, $colX, $y1+$y2);
}
//$pdf->Output(); 

 $pdf->Output("jpegcam/htdocs/balancesheet.pdf", 'F');
$origFile="jpegcam/htdocs/balancesheet.pdf";

function pdfEncrypt ($origFile, $password, $destFile){
    require_once('fpdi/FPDI_Protection.php');
    $pdf =& new FPDI_Protection();
    $pdf->FPDF('P', 'in');
    //Calculate the number of pages from the original document.
    $pagecount = $pdf->setSourceFile($origFile);
    //Copy all pages from the old unprotected pdf in the new one.
    for ($loop = 1; $loop <= $pagecount; $loop++) {
        $tplidx = $pdf->importPage($loop);
        $pdf->addPage();
        $pdf->useTemplate($tplidx);
    }

    //Protect the new pdf file, and allow no printing, copy, etc. and
    //leave only reading allowed.
    $pdf->SetProtection(array(), $password);
    $pdf->Output($destFile, 'D');
    return $destFile;
}


//Password for the PDF file (I suggest using the email adress of the purchaser).
$password = "1234";
//Name of the original file (unprotected).
//$origFile = "1427435248.pdf";
//Name of the destination file (password protected and printing rights removed).
$destFile ="sample_protected.pdf";
//Encrypt the book and create the protected file.
 pdfEncrypt($origFile, $password, $destFile);
if (unlink("jpegcam/htdocs/balancesheet.pdf"))
{} 

