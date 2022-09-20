<?php
	function get_product_name($pid){
		$result=mysql_query("select fg_name from fgroup where fg_id=$pid") or die("select fg_name from fgroup where fg_id=$pid"."<br/><br/>".mysql_error());
		$row=mysql_fetch_array($result);
		return $row['fg_name'];
	}
	function get_price($pid){
		$pid=intval($pid);
		$max=count($_SESSION['tfees']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['tfees'][$i]['cartid']){
				$gprice=$_SESSION['tfees'][$i]['payment'];
				break;
			}
		}
		return $gprice;
	}
	function remove_product($pid,$type){
		$pid=intval($pid);
		$type=intval($type);
		$delid=substr($pid, 0, 1);
		if($type==1){
				$max=count($_SESSION['tfees']);
				for($i=0;$i<$max;$i++){
					if($delid==$_SESSION['tfees'][$i]['fgd_id']){
						//unset($_SESSION['tfees'][$i]);
						$_SESSION['tfees'][$i]['visible']="2";
					}
				}			
		}else{
		$max=count($_SESSION['tfees']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['tfees'][$i]['cartid']){
				//unset($_SESSION['tfees'][$i]);
				$_SESSION['tfees'][$i]['visible']="2";
				break;
			}
		}
		}
		$_SESSION['tfees']=array_values($_SESSION['tfees']);
	}
	function add_product($pid,$type){
		$pid=intval($pid);
		$type=intval($type);
		if($type==1){
				$delid=substr($pid, 0, 1);
				$max=count($_SESSION['tfees']);
				for($i=0;$i<$max;$i++){
					if($delid==$_SESSION['tfees'][$i]['fgd_id']){
						//unset($_SESSION['tfees'][$i]);
						$_SESSION['tfees'][$i]['visible']="1";
					}
				}			
		}else{
		$max=count($_SESSION['tfees']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['tfees'][$i]['cartid']){
				//unset($_SESSION['tfees'][$i]);
				$_SESSION['tfees'][$i]['visible']="1";
				break;
			}
		}
		}
		$_SESSION['tfees']=array_values($_SESSION['tfees']);
	}
	function get_order_total(){
		$max=count($_SESSION['tfees']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['tfees'][$i]['cartid'];
			//echo $sum." - ";
			 $s=$_SESSION['tfees'][$i]['payment'];
			 $visible=$_SESSION['tfees'][$i]['visible'];
				if($visible==1){
			 //$price + = $q;
			$sum=$sum+$s;
				}
			//$sum=number_format($sum, 2);
		}
		//return number_format($sum,2);
		return $sum;
	}
	function get_order_total_all(){
		$max=count($_SESSION['tfees']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['tfees'][$i]['cartid'];
			//echo $sum." - ";
			 $s=$_SESSION['tfees'][$i]['payment'];
			 $type=$_SESSION['tfees'][$i]['type'];
				if($type!="otherfees"){
			 //$price + = $q;
			$sum=$sum+$s;
				}
			//$sum=number_format($sum, 2);
		}
		//return number_format($sum,2);
		return $sum;
	}
	function get_term_total(){
		$max=count($_SESSION['tfees']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			if("terms"==$_SESSION['tfees'][$i]['type']){
			//echo $sum." - ";
			 $s=$_SESSION['tfees'][$i]['payment'];
			$sum=$sum+$s;
			}
		}
		return $sum;
	}
	function addtocart($pid,$p,$q,$r,$s,$t,$u,$v,$w,$x,$y,$z){
		if($pid<1 or $s<1) return;
		
		if(is_array($_SESSION['tfees'])){
			if(product_exists($pid)) return;
			$max=count($_SESSION['tfees']);
			$_SESSION['tfees'][$max]['cartid']=$pid;
			$_SESSION['tfees'][$max]['fgd_id']=$p;
			$_SESSION['tfees'][$max]['fg_id']=$q;
			$_SESSION['tfees'][$max]['fr_id']=$r;
			$_SESSION['tfees'][$max]['rate']=$s;
			$_SESSION['tfees'][$max]['paid']=$t;
			$_SESSION['tfees'][$max]['pending']=$u;
			$_SESSION['tfees'][$max]['payment']=$v;
			$_SESSION['tfees'][$max]['type']=$w;
			$_SESSION['tfees'][$max]['visible']=$x;
			$_SESSION['tfees'][$max]['discount']=$y;
			$_SESSION['tfees'][$max]['dv_id']=$z;
		}
		else{
			$_SESSION['tfees']=array();
			$_SESSION['tfees'][0]['cartid']=$pid;
			$_SESSION['tfees'][0]['fgd_id']=$p;
			$_SESSION['tfees'][0]['fg_id']=$q;
			$_SESSION['tfees'][0]['fr_id']=$r;
			$_SESSION['tfees'][0]['rate']=$s;
			$_SESSION['tfees'][0]['paid']=$t;
			$_SESSION['tfees'][0]['pending']=$u;
			$_SESSION['tfees'][0]['payment']=$v;
			$_SESSION['tfees'][0]['type']=$w;
			$_SESSION['tfees'][0]['visible']=$x;
			$_SESSION['tfees'][0]['discount']=$y;
			$_SESSION['tfees'][0]['dv_id']=$z;
		}
	}
	function product_exists($pid){
		$pid=intval($pid);
		$max=count($_SESSION['tfees']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['tfees'][$i]['cartid']){
				$flag=1;
				break;
			}
		}
		return $flag;
	}
	
	function product_exists_visible($pid){
		$pid=intval($pid);
		$max=count($_SESSION['tfees']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['tfees'][$i]['cartid']){
				$visible=$_SESSION['tfees'][$i]['visible'];
				if($visible==1){
				$flag=1;
				break;
				}
			}
		}
		return $flag;
	}
	function product_exists_visible2($pid){
		$pid=intval($pid);
		$delid=substr($pid, 0, 1);
		$max=count($_SESSION['tfees']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($delid==$_SESSION['tfees'][$i]['fgd_id']){
				$visible=$_SESSION['tfees'][$i]['visible'];
				if($visible==1){
				$flag=1;
				break;
				}
			}
		}
		return $flag;
	}
	function product_total($pid){
		$pid=intval($pid);
		$delid=substr($pid, 0, 1);
		$max=count($_SESSION['tfees']);
		$total=0;
		for($i=0;$i<$max;$i++){
			if($delid==$_SESSION['tfees'][$i]['fgd_id']){
				$payment=$_SESSION['tfees'][$i]['payment'];
				if($payment){
				$total+=$payment;
				}
			}
		}
		return $total;
	}
	function product_exists_visible1(){
		$max=count($_SESSION['tfees']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if("terms"==$_SESSION['tfees'][$i]['type']){
				$payment=$_SESSION['tfees'][$i]['payment'];
				if($payment){
				$flag=1;
				break;
				}
			}
		}
		return $flag;
	}

function product_count($pid){
		$pid=intval($pid);
		$max=count($_SESSION['tfees']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['tfees'][$i]['cartid']){
				$flag=$i;
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