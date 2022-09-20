<? ob_start(); ?>
    <?php
	include("../includes/config.php");
	?>
	 <div class="grid-8 inputcontainer">		
									<label for="select">Board <span class="error"> * </span>:</label>
                					<div class="field">
                                	<?php
                                            $classl = "SELECT * FROM board";
                                            $result1 = mysql_query($classl) or die(mysql_error());
                                            echo '<select name="boardid" id="bid"  class="validate[required] select2" onChange="getClassDetails();"><option value="">Select Board</option>';
											while ($row1 = mysql_fetch_assoc($result1)):
												
												echo "<option value='{$row1['b_id']}'>{$row1['b_name']}</option>\n";
												
                                            endwhile;
                                            echo '</select>';
                                            ?>
									
                                	</div>		
								</div>
                                <div class="grid-8 inputcontainer">		
									<label>Class<span class="error"> * </span>:</label>			
									<div class="field">
                                    
                                    <select name="classname" id="classname" class="form-control validate[required] select2" onChange="getSectionDetails();">
                                   <option value="">Select Class Name</option>
                                    </select>
                                         																				
									</div>			
								</div> <!-- .field-group -->
                                 <div class="grid-8 inputcontainer">		
									<label>Section<span class="error"> * </span>:</label>			
									<div class="field">
                                    <select name="sectionname" id="sectionname" class="form-control validate[required] select2" >
                                    <option value="">Select Section</option>
                                    </select>    																				
									</div>		
								</div>
<? ob_flush(); ?>
