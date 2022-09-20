<?php
	function get_product_name($pid){
		$result=mysql_query("select r_name from route where r_id=$pid") or die("select r_name from route where r_id=$pid"."<br/><br/>".mysql_error());
		$row=mysql_fetch_array($result);
		return $row['r_name'];
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
	function remove_product($pid){
		$pid=intval($pid);
		$max=count($_SESSION['fees']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['fees'][$i]['fgid']){
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
			//echo $sum." - ";
			 $s=$_SESSION['fees'][$i]['amount'];
			 //$price + = $q;
			$sum=$sum+$s;
			//$sum=number_format($sum, 2);
		}
		//return number_format($sum,2);
		return $sum;
	}
	function addtocart($pid,$q,$r,$s,$t,$u,$v,$w,$x,$y){
		if($pid<1 or $q<1 or $r<1 or $s<1 or $s<1) return;
		
		if(is_array($_SESSION['fees'])){
			if(product_exists($pid)) return;
			$max=count($_SESSION['fees']);
			$_SESSION['fees'][$max]['fgid']=$pid;
			$_SESSION['fees'][$max]['ffrom']=$q;
			$_SESSION['fees'][$max]['fto']=$r;
			$_SESSION['fees'][$max]['amount']=$s;
			$_SESSION['fees'][$max]['ftid']=$t;
			$_SESSION['fees'][$max]['dftyvalue']=$u;
			$_SESSION['fees'][$max]['damount']=$v;
			$_SESSION['fees'][$max]['ftamount']=$w;
			$_SESSION['fees'][$max]['ftomonth']=$x;
			$_SESSION['fees'][$max]['ftype']=$y;
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
			$_SESSION['fees'][0]['ftomonth']=$x;
			$_SESSION['fees'][0]['ftype']=$y;
		}
	}
	function product_exists($pid){
		$pid=intval($pid);
		$max=count($_SESSION['fees']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['fees'][$i]['fgid']){
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