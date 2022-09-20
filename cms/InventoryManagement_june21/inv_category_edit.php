<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit'])) {
    $category = $_POST['category'];
    $status = $_POST['status'];
    $catid = $_POST['catid'];
    $cat_prefix = $_POST['cat_prefix'];

    $qry = mysql_query("UPDATE inv_category SET category_name='$category',cat_status='$status',cat_prefix='$cat_prefix' WHERE cat_id='$catid'");
    if ($qry) {
        header("Location:inv_category_edit.php?catid=$catid&msg=succ");
    }
    exit;
}
?>
<body>

    <div id="wrapper">

        <div id="header">
            <h1><a href="dashboard.php">Inventory Management</a></h1>		

            <a href="javascript:;" id="reveal-nav">
                <span class="reveal-bar"></span>
                <span class="reveal-bar"></span>
                <span class="reveal-bar"></span>
            </a>
        </div> <!-- #header -->

        <div id="search">
            <form>
                <input type="text" name="search" placeholder="Search..." id="searchField" />
            </form>		
        </div> <!-- #search -->

        <div id="sidebar">		

            <?php include 'sidebar.php'; ?>

        </div> <!-- #sidebar -->

        <div id="content">		

            <div id="contentHeader">
                <h1>Product Category</h1>
            </div> <!-- #contentHeader -->	

            <div class="container">
                <?php
                $msg = $_GET['msg'];
                if ($msg === "succ") {
                    ?>
                    <div class="notify notify-success">						
                        <a href="javascript:;" class="close">&times;</a>						
                        <h3>Success Notifty</h3>						
                        <p>Your data successfully edited!!!</p>
                    </div>
                <?php }if ($msg === "err") {
                    ?>
                    <div class="notify notify-error">						
                        <a href="javascript:;" class="close">&times;</a>						
                        <h3>Error Notifty</h3>						
                        <p>Your data has not been edited!!!</p>
                    </div>
                <?php } ?>

                <div class="grid-24">

                    <div class="widget">

                        <div class="widget-header">
                            <a href="inv_category.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
                            <span class="icon-article"></span>
                            <h3>Edit Category</h3>
                        </div> <!-- .widget-header -->
                        <div class="widget-content">
                            <?php
                            $catid = $_GET['catid'];
                            $categorylist = mysql_query("SELECT * FROM inv_category WHERE cat_id=$catid");
                            $category = mysql_fetch_array($categorylist);
                            ?>
                            <form class="form uniformForm validateForm" method="post" action="" >

                                <div class="grid-8">	
                                    <div class="widget-content"> 
                                        <div class="field-group">
                                            <label for="required">Category Name <span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="category" id="catname" value="<?php echo $category['category_name']; ?>" size="32" class="validate[required]" />	
                                            </div>
                                        </div> 
                                        <div class="field-group">		
                                            <label>Status<span class="error"> * </span>:</label>			
                                            <div class="field">
                                                <select name="status" id="status" class="required select2">
                                                    <option value="">Please select</option>	
                                                    <option value="1" <?php
                                                    if ($category['cat_status'] == '1') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Enable</option>
                                                    <option value="0" <?php
                                                    if ($category['cat_status'] == '0') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Disable</option>									
                                                </select>										
                                            </div>	
                                        </div>
                                        <div class="field-group">
                                            <label for="required">Category Bill Prefix <span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="cat_prefix" id="cat_prefix" value="<?php echo $category['cat_prefix']; ?>" size="32" class="validate[required]" />	
                                            </div>
                                        </div>
                                        
                                        <div class="actions">		
                                            <input type="hidden" class="medium" name="catid" value="<?php echo $catid; ?>" > 				
                                            <button type="submit" name="submit" class="btn btn-error">Submit</button>
                                        </div> <!-- .actions -->
                                    </div>
                                </div>
                            </form>
                        </div> <!-- .widget-content -->						
                    </div>				
                </div> <!-- .grid -->			
            </div> <!-- .container -->

        </div> <!-- #content -->

<?php
include("includes/topnav.php");
?> <!-- #topNav -->

        <!-- .quickNav -->


    </div> <!-- #wrapper -->

<?php include("includes/footer.php"); ?>
    <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#datepicker").datepicker();
        });
        function showCategory(str) {
            if (str == "") {
                document.getElementById("section").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else {// code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("section").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "sectionlist.php?mmtid=" + str, true);
            xmlhttp.send();
        }
    </script>  
</body>
</html>
<? ob_flush(); ?>