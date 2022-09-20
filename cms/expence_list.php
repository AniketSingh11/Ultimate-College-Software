<?php
include("includes/config.php");
if( (isset ($_GET['value']) && $_GET['value']!=''))
{
	$value=$_GET['value'];
	$date_split1= explode('/', $value);
		 
		 $date_day=$date_split1[0];
		 $date_month=$date_split1[1];
		 $date_year=$date_split1[2];
		 
		 echo '<div class="grid_12">
            	<div class="block-border">
					<div class="block-header">
                    	<h1>'.$value.' - Expenses Details </h1>
                        <span></span>
					</div>
					<div class="block-content">
						<table id="table-example" class="table">
							<thead>
								<tr>
									<th>S.No</th>
                                    <th><center>Category</center></th>
                                    <th><center>Sub Category</center></th>
                                    <th><center>Agency</center></th>
                                    <th><center>Receipt No</center></th>
                                    <th><center>Date</center></th>
                                    <th><center>Title</center></th>
                                    <th><center>type</center></th>
                                    <th><center>Amount</center></th> 
								</tr>
							</thead>
							<tbody>';
                            
							$qry2="SELECT * FROM exponses WHERE date_day=$date_day AND date_month=$date_month AND date_year=$date_year ORDER BY ex_id DESC";
							$qry=mysql_query($qry2);
							$count=1;
			  while($row=mysql_fetch_array($qry))
        		{
					$aid1=$row['aid'];
					$excid1=$row['exc_id'];
					$exsid1=$row['exs_id'];
					$qry1=mysql_fetch_array(mysql_query("select * from ex_insubcategory where exs_id='$exsid1'"));
					$sb_count=$qry1["count"];
					$subcname=$qry1["sub_name"];
					$subcat=array();
					for($j=1;$j<=20;$j++)
					{
					$sub_id=$qry1["sub$j"."_id"];
					
					if($sub_id!=0){
					    array_push($subcat,$sub_id);
					}
					}
					$insub_name="";
					foreach ($subcat as $val){
					
					$qry1=mysql_fetch_array(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$val'"));
					$insub_name.=$qry1["sub_name"]."&nbsp;>&nbsp;";
					
					 }
					 $expenselist=mysql_query("SELECT * FROM ex_category WHERE exc_id=$excid1"); 
								  $expenses=mysql_fetch_array($expenselist);
								  
								  $agencylist1=mysql_query("SELECT * FROM agency WHERE a_id=$aid1"); 
								  $agency1=mysql_fetch_array($agencylist1);
								  
								  $agencyname=$agency1['a_name'];
								  $status=$row['status'];
								  
								echo '<tr class="gradeX">
                                    <td class="sno center"><center>'.$count,'</center></td>
                                    <td><center>'.$expenses['ex_category'],'</center></td>
                                    <td><center>'.$insub_name.$subcname.'</center></td>
                                    <td><center>';
									if($agencyname){ echo $agencyname;}else{ echo "-"; }
									echo '</center></td>
                                    <td><center>'.$row['r_no'].'</center></td>
                                    <td><center>'.$row['date_day']."/".$row['date_month']."/".$row['date_year'].'</center></td>
                                    <td><center>';
									if($row['title']){ 
									echo $row['title']; 
									}else{ echo "-"; 
									}
									echo '</center></td>
                                    <td><center>';
									if($row['type']=='0'){ echo '<button class="btn btn-small btn-success" >Cash Amount</button>'; 
									}else if($row['type']=='1' && $status=='1'){ echo '<button class="btn btn-small btn-warning" >Paid</button>'; 
									}else if($row['type']=='1'){ echo '<button class="btn btn-small btn-error" >Invoiced</button>'; } 
									echo '</center></td>
                                    <td><center>Rs. '.number_format($row['amount'],2).'</center></td>                               
								</tr>';
							$count++;
							}
							echo '</tbody>
						</table>
					</div>
				</div>
                
			</div>
			<script type="text/javascript" language="javascript" src="js/jquery-1.9.1.min.js"></script>
			<script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
	$(\'#table-example\').dataTable({
  \'iDisplayLength\': 25
});
});
</script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>';
	
}
if( (isset ($_GET['excid']) && $_GET['excid']!=''))
{
	$exc_id=$_GET['excid'];
	echo '<label for="textfield">Expenses sub Category<span class="error">*</span></label>
                            <select name="exsid" id="exsid" class="required" style="width:100%">
                            	<option value="">Select sub category</option>';
								
								$qry=mysql_query("SELECT * FROM ex_insubcategory where category='$exc_id'  order by count asc");
							$cont=1;
			  while($row=mysql_fetch_array($qry))
        		{
                  $category_id=$row["category"];
                  $count=$row["count"];
                  $qry1=mysql_fetch_array(mysql_query("select * from ex_category where exc_id='$category_id'"));
                  $category_name=$qry1["ex_category"];
                 
                  
                  if($count!=0)
                  {
                      
                      $subcat=array();
                      for($j=1;$j<=20;$j++)
                      {
                      $sub_id=$row["sub$j"."_id"];
                      
                          if($sub_id!=0){
                      array_push($subcat,$sub_id);
                      }
                      }
                      
                      $insub_name="";
                      foreach ($subcat as $val){
                      
                      $qry1=mysql_fetch_array(mysql_query("SELECT * FROM ex_insubcategory where exs_id='$val'"));
                      $insub_name.=$qry1["sub_name"]."&nbsp;>&nbsp;";
                      
                      }     
                      
                
                  
                  }
								
								echo '<option value="'.$row['exs_id'].'">'.$insub_name.stripslashes($row['sub_name']).'</option>';
				}
                            echo '</select>
							<script type="text/javascript">
		$().ready(function() {
			$(\'#exsid\').select2 ({
					allowClear: true,
					placeholder: "Please Select..."
				})   
			});
			</script>';
}
?>
