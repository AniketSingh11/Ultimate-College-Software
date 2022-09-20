<?php
function thefunction($number){
  if ($number < 0)
    return 0;
  return $number; 
}

include("includes/config.php"); 
if( (isset ($_GET['value']) && $_GET['value']!='') && (isset ($_GET['bid']) && $_GET['bid']!='') && (isset ($_GET['ayid']) && $_GET['ayid']!='') )
{
	   $value=$_GET['value'];
      $b_id=$_GET['bid'];
	  $acyear=$_GET['ayid'];
   
   echo '<div class="_100">
							<p>
                            <div id="msc1">
                            </div>
                            <select name="ms_example[ ]" multiple="multiple" id="msc">';
                            $query = mysql_query("SELECT * FROM student WHERE (ay_id='$acyear' AND  b_id='$b_id') AND (s_id='0' AND c_id='$value') ORDER BY ss_id ASC"); 
    while ($row = mysql_fetch_assoc($query)) 
    { 
	$cid1=$row['c_id'];
	$classlist=mysql_query("SELECT * FROM class WHERE c_id=$cid1"); 
								  $class=mysql_fetch_array($classlist);

                                  echo '<option value="'.$row['ss_id'].'">'.$row['admission_number']." - ".$row['firstname']." ".$row['lastname']." - ".$class['c_name'].'</option>';
								   }
								   echo '</select>
                                        <div class="btn-group">
                                            <span class="button blue" id="ms_select">Select all</span>
                                            <span class="button blue" id="ms_deselect">Deselect all</span>
                                        </div>
                                        
							</p>
						</div>';
}
?>
<script type='text/javascript' src='js/plugins/jquery/jquery-1.9.1.min.js'></script>
        
    <script type='text/javascript' src='js/plugins/multiselect/jquery.multi-select.min.js'></script>  
<script type="text/javascript">
$().ready(function() {		
		if($("#msc").length > 0){
        $("#msc").multiSelect({
            selectableHeader: "<div class='multipleselect-header'>Selectable item</div>",
            selectedHeader: "<div class='multipleselect-header'>Selected items</div>",
            afterSelect: function(value, text){
                //action
            },
            afterDeselect: function(value, text){
                //action
            }            
        });
        
        $("#ms_select").click(function(){
            $('#msc').multiSelect('select_all');
        });
        $("#ms_deselect").click(function(){
            $('#msc').multiSelect('deselect_all');
        });        
    }    	
	});    
</script> 