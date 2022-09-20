<?php
	function get_price($pid){
		$pid=intval($pid);
		$max=count($_SESSION['close']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['close'][$i]['fgid']){
				$gprice=$_SESSION['close'][$i]['fgid'];
				break;
			}
		}
		return $gprice;
	}
	function remove_product($pid){
		$pid=intval($pid);
		$max=count($_SESSION['close']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['close'][$i]['exid']){
				unset($_SESSION['close'][$i]);
				break;
			}
		}
		$_SESSION['close']=array_values($_SESSION['close']);
	}
	function remove_product1($epid){
		$epid=intval($epid);
		$max=count($_SESSION['close']);
		for($i=0;$i<$max;$i++){
			if($epid!=$_SESSION['close'][$i]['epid']){
				unset($_SESSION['close'][$i]);
				//break;
			}
		}
		$_SESSION['close']=array_values($_SESSION['close']);
	}
	function get_order_total(){
		$max=count($_SESSION['close']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['close'][$i]['fgid'];
			//echo $sum." - ";
			 $s=$_SESSION['close'][$i]['payamount'];
			 //$price + = $q;
			$sum=$sum+$s;
			//$sum=number_format($sum, 2);
		}
		//return number_format($sum,2);
		return $sum;
	}
	function addtocart($pid,$q,$r,$s,$t,$u){
		if($pid<1) return;
		
		if(is_array($_SESSION['close'])){
			if(product_exists($pid)) return;
			$max=count($_SESSION['close']);
			$_SESSION['close'][$max]['exid']=$pid;
			$_SESSION['close'][$max]['excid']=$q;
			$_SESSION['close'][$max]['amount']=$r;
			$_SESSION['close'][$max]['payamount']=$t;
			$_SESSION['close'][$max]['aid']=$s;
			$_SESSION['close'][$max]['epid']=$u;
		}
		else{
			$_SESSION['close']=array();
			$_SESSION['close'][0]['exid']=$pid;
			$_SESSION['close'][0]['excid']=$q;
			$_SESSION['close'][0]['amount']=$r;
			$_SESSION['close'][0]['payamount']=$t;
			$_SESSION['close'][0]['aid']=$s;
			$_SESSION['close'][0]['epid']=$u;
		}
	}
	function product_exists($pid){
		$pid=intval($pid);
		$max=count($_SESSION['close']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['close'][$i]['exid']){
				$flag=1;
				break;
			}
		}
		return $flag;
	}
?>