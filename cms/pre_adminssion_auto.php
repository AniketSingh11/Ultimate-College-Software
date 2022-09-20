<? ob_start(); ?>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script src="js/jquery-migrate-1.2.1.js"></script>
<script type="text/javascript" src="Book_inventory/js/jquery.autocomplete.min.js"></script>
<script type="text/javascript">
$(function(){
  var currencies = [
    <?php
	$sql="SELECT pa_admission_no,c_id,s_id,firstname,lastname,fathersname,reg,pa_id FROM pre_admission WHERE b_id=$bid AND ay_id=$acyear";
	if($cids){
		$sql.=" AND c_id=$cids";
	}
$sql = mysql_query($sql);
while ($thisrow = mysql_fetch_array($sql)){	
$m_cid=$thisrow['c_id'];
$pa_id=$thisrow['pa_id'];
			$m_sid=$thisrow['s_id'];
			$classlis=mysql_query("SELECT pa_id FROM pre_admission_advance WHERE pa_id=$pa_id"); 
								  $pacount=mysql_num_rows($classlis);
			if(!$pacount){				  
		$classlist2=mysql_query("SELECT c_name FROM class WHERE c_id=$m_cid"); 
								  $class2=mysql_fetch_array($classlist2);
		$sectionlist2=mysql_query("SELECT s_name FROM section WHERE s_id=$m_sid"); 
								  $section2=mysql_fetch_array($sectionlist2);
$sname=$thisrow['firstname']." ".$thisrow['lastname']." (".$class2['c_name']." ".$section2['s_name']." - ".$thisrow['fathersname']." )";
echo "{ value:'$thisrow[pa_admission_no]-$sname', name:'$thisrow[firstname]', reg:'$thisrow[reg]', cid:'$thisrow[c_id]', sid:'$thisrow[s_id]'},";
} }
?>  
  ];
  
  // setup autocomplete function pulling from currencies[] array
  $('#autocomplete').autocomplete({
    lookup: currencies
  });

});
</script>
<? ob_flush(); ?>