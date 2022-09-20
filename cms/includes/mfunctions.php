<?php
	function get_product_name($pid,$x){
		
		if($x=="fees"){
		$result=mysql_query("select fg_name from mfgroup where fg_id=$pid") or die("select fg_name from fgroup where fg_id=$pid"."<br/><br/>".mysql_error());
		$row=mysql_fetch_array($result);
		return $row['fg_name'];
		}else if($x=="other"){
			$result=mysql_query("select name from mfgroup_detail where fgd_id=$pid") or die("select fg_name from fgroup where fg_id=$pid"."<br/><br/>".mysql_error());
		$row=mysql_fetch_array($result);
		return $row['name'];
		}else if($x=="discount"){
		return "Discount";
		}else if($x=="pending"){
		return "Last Year Pending Fees";
		}
	}
	function get_price($pid){
		$pid=intval($pid);
		$max=count($_SESSION['fees']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['fees'][$i]['fgid']){
				$gprice=$_SESSION['fees'][$i]['fgid'];
				break;
			}
		}
		return $gprice;
	}
	function remove_product($pid,$x){
		$pid=intval($pid);
		$x=$x;
		$max=count($_SESSION['fees']);
		for($i=0;$i<$max;$i++){
			if(($pid==$_SESSION['fees'][$i]['fgid']) && ($x==$_SESSION['fees'][$i]['ftype'])){
				unset($_SESSION['fees'][$i]);
				break;
			}
		}
		$_SESSION['fees']=array_values($_SESSION['fees']);
	}
	function get_order_total(){
		$max=count($_SESSION['fees']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['fees'][$i]['fgid'];
			$x=$_SESSION['fees'][$i]['ftype'];
			//echo $sum." - ";
			 $s=$_SESSION['fees'][$i]['amount'];
			 //$price + = $q;
			if($x=="discount"){
			$sum=$sum-$s;
			}else{
				$sum=$sum+$s;
			}
			
			//$sum=number_format($sum, 2);
		}
		//return number_format($sum,2);
		return $sum;
	}
	function addtocart($pid,$q,$r,$s,$t,$u,$v,$w,$x,$y){
		if($pid<1 or $q<1 or $r<1 or $s<1 or $s<1) return;
		
		if(is_array($_SESSION['fees'])){
			if(product_exists($pid,$x)) return;
			$max=count($_SESSION['fees']);
			$_SESSION['fees'][$max]['fgid']=$pid;
			$_SESSION['fees'][$max]['ffrom']=$q;
			$_SESSION['fees'][$max]['fto']=$r;
			$_SESSION['fees'][$max]['amount']=$s;
			$_SESSION['fees'][$max]['ftid']=$t;
			$_SESSION['fees'][$max]['dftyvalue']=$u;
			$_SESSION['fees'][$max]['damount']=$v;
			$_SESSION['fees'][$max]['ftamount']=$w;
			$_SESSION['fees'][$max]['ftype']=$x;
			$_SESSION['fees'][$max]['ftomonth']=$y;
		}
		else{
			$_SESSION['fees']=array();
			$_SESSION['fees'][0]['fgid']=$pid;
			$_SESSION['fees'][0]['ffrom']=$q;
			$_SESSION['fees'][0]['fto']=$r;
			$_SESSION['fees'][0]['amount']=$s;
			$_SESSION['fees'][0]['ftid']=$t;
			$_SESSION['fees'][0]['dftyvalue']=$u;
			$_SESSION['fees'][0]['damount']=$v;
			$_SESSION['fees'][0]['ftamount']=$w;
			$_SESSION['fees'][0]['ftype']=$x;
			$_SESSION['fees'][0]['ftomonth']=$y;
		}
	}
	function product_exists($pid,$x){
		$pid=intval($pid);
		$max=count($_SESSION['fees']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if(($pid==$_SESSION['fees'][$i]['fgid']) && ($x==$_SESSION['fees'][$i]['ftype'])){
				$flag=1;
				break;
			}
		}
		return $flag;
	}

function addgroup($pid){
		if($pid<1) return;
		
		if(is_array($_SESSION['frate'])){
			$_SESSION['frate']['fgid']=$pid;
		}		
	}
?>