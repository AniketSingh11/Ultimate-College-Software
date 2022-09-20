<?php
	function get_product_name($pid){
		$result=mysql_query("select b_name from book where b_id=$pid") or die("select b_name from book where b_id=$pid"."<br/><br/>".mysql_error());
		$row=mysql_fetch_array($result);
		return $row['b_name'];
	}
	function get_price($pid){
		$result=mysql_query("select b_price from book where b_id=$pid") or die("select b_price from book where b_id=$pid"."<br/><br/>".mysql_error());
		$row=mysql_fetch_array($result);
		return $row['b_price'];
	}
	function remove_product($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['bookid']){
				unset($_SESSION['cart'][$i]);
				break;
			}
		}
		$_SESSION['cart']=array_values($_SESSION['cart']);
	}
	function get_order_total(){
		$max=count($_SESSION['cart']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['bookid'];
			//echo $sum." - ";
			 $q=$_SESSION['cart'][$i]['qty'];
			 $price=get_price($pid);
			$sum=$sum+($price * $q);
			//$sum=number_format($sum, 2);
		}
		//return number_format($sum,2);
		return $sum;
	}
	function addtocart($pid,$q){
		if($pid<1 or $q<1) return;
		
		if(is_array($_SESSION['cart'])){
			if(product_exists($pid)) return;
			$max=count($_SESSION['cart']);
			$_SESSION['cart'][$max]['bookid']=$pid;
			$_SESSION['cart'][$max]['qty']=$q;
		}
		else{
			$_SESSION['cart']=array();
			$_SESSION['cart'][0]['bookid']=$pid;
			$_SESSION['cart'][0]['qty']=$q;
		}
	}
	function product_exists($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['bookid']){
				$flag=1;
				break;
			}
		}
		return $flag;
	}

?>