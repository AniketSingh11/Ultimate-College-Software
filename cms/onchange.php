<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
 include("head_top.php"); 
 //include("onchangevalaue.php");
 ?>
<script type="text/javascript">
function jsfunc(x)
{
<?PHP
$y=print("document.abc.mylist.options[x].text");
echo ("Value is = ".$y);
?>
} 
function change_val() { 
   var sel = document.getElementById('A'),
       ffrom = document.getElementById('ffrom_value');
	   fto = document.getElementById('fto_value');
	   fees = document.getElementById('fees_value');
	   
  // lbl.disabled = (sel.selectedIndex !== 0);
   if(sel.selectedIndex === 0) {
      lbl.value = '<?php echo "test"; ?>';
   } /*else {
      lbl.value = sel.options[sel.selectedIndex].value;
   }*/
}
function change_fees() { 
   var myVar = document.getElementById('selected_value').value,
       lbl = document.getElementById('fees');
		lbl.value = sel.selectedIndex;
		//alert(sel);
   //lbl.disabled = (sel.selectedIndex !== 0);
   //$.post('onchangevalaue.php',myVar);
   
   <?php $ip = "<script>document.write('" + myVar + "')</script>"; ?>
   	   
   if( myVar === '<?php echo $ip; ?>') {
      lbl.value = '<?php echo "test"; ?>';
   } /*else {
      lbl.value = sel.options[sel.selectedIndex].value;
   }*/
}
</script>
<?php 
function fromvalue() {
    $ffrom = '<script>document.getElementById("selected_value").value;</script>';
    return $ffrom; //turn the array into a string
}
?>
</head>
<?php echo $ip;?>
<body>
<select id="A" onchange="change_val()">
    <option value=" ">Select</option>
    <?php 
		$sql1=mysql_query("SELECT distinct fg_id FROM frate WHERE c_id=9 AND b_id=1 AND ay_id=$acyear AND rate='Old' ORDER BY fg_id");
									while($row2=mysql_fetch_assoc($sql1))
									{ 
									$ffgid=$row2['fg_id'];
									$fgrouplist=mysql_query("SELECT * FROM fgroup WHERE fg_id=$ffgid");
									 $ffgroup=mysql_fetch_array($fgrouplist);
										?>
                                    <option value="<?php echo $ffgid;?>"><?php echo $ffgroup['fg_name'];?></option>
                                    <?php } ?>
</select>

<!--<input type="text" id="selected_value" value=""/>-->
<select id="selected_value" onchange="change_fees()">
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="May">May</option>
</select>
<input type="text" id="fees" value=""/>
<p><select size="1" name=mylist id="D1" onchange="jsfunc(this.selectedIndex)">
<option>Value 1</option>    
<option>Value 2</option>    
<option>Value 3</option>    
    </select></p> 
</body>
</html>
