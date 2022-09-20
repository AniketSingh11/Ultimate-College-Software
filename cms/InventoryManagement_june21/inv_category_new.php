<? ob_start(); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include("header_top.php");

if (isset($_POST['submit'])) {
    $category = $_POST['category'];
    $cat_prefix = $_POST['cat_prefix'];
    $auto_number = 1;
    $status = 1; //$_POST['status'];


    $sql = "INSERT INTO inv_category (category_name,cat_status,cat_prefix,Cat_billno) VALUES
             ('$category','$status','$cat_prefix','$auto_number')";

    $result = mysql_query($sql) or die("Could not insert data into DB: " . mysql_error());
    if ($result) {
        header("Location:inv_category_new.php?msg=succ");
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
                        <p>Your data successfully created!!!</p>
                    </div>
<?php } if ($msg === "err") {
    ?>
                    <div class="notify notify-error">						
                        <a href="javascript:;" class="close">&times;</a>						
                        <h3>Error Notifty</h3>						
                        <p>Your data has not been created!!!</p>
                    </div>
<?php } ?>

                <div class="grid-24">

                    <div class="widget">

                        <div class="widget-header">
                            <a href="inv_category.php" style="margin:3px 0 0 20px;"><button class="btn btn-primary ">Back</button></a>
                            <span class="icon-article"></span>
                            <h3>Add New Category</h3>
                        </div> <!-- .widget-header -->
                        <div class="widget-content">
                            <form class="form uniformForm validateForm" method="post" action="" >

                                <div class="grid-8">	
                                    <div class="widget-content"> 
                                        <div class="field-group">
                                            <label for="required">Category Name <span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="category" id="catname" size="32" class="validate[required]" />	
                                            </div>
                                        </div> 
                                        <div class="field-group">
                                            <label for="required">Category Bill Prefix <span class="error"> * </span>:</label>
                                            <div class="field">
                                                <input type="text" name="cat_prefix" id="cat_prefix" value="" size="32" class="validate[required]" />	
                                            </div>
                                        </div>
                                        <!-- .field-group
                                        <div class="field-group">		
                                                                                <label>Status<span class="error"> * </span>:</label>			
                                                                                <div class="field">
                                                                                        <select name="status" id="status" class="select2 required">
                                                                                                <option value="">Please select</option>		
                                                    <option value="1">Enable</option>	
                                                    <option value="0">Disable</option>											
                                                                                        </select>										
                                                                                </div>		
                                                                        </div>  -->
                                        <!-- .field-group -->

                                        <div class="actions">						
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




    </div> <!-- #wrapper -->

<?php include("includes/footer.php"); ?>


    <script type="text/javascript" src="javascripts/jquery.easyui.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            if ($("select option:selected").length) {
                //alert("sd")

            }
            $("#datepicker").datepicker();

            // var validator = $('.validateForm').validate({ignore: 'input[type=hidden]'});


        });
    </script>
    <script type="text/javascript">
        function showCategory(st) {
            var s = st.split("-");
            var str = s[0];
            var clas = s[1];



            if (clas.indexOf("XI") >= 0) {

                $("#showclass").show();
            } else {
                $("#showclass").hide();
            }

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

                    $('#section option:eq(1)').attr('selected', 'selected');

                    var c = $('#section').val().split("-");


                    $("#uniform-section span").html(c[1]);

                    //$("#section").val($("#section option:first").val());
                }
            }
            xmlhttp.open("GET", "sectionlist_new.php?mmtid=" + str, true);

            xmlhttp.send();
        }
    </script>  
</body>
</html>
<? ob_flush(); ?>