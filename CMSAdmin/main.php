<?php 
    require_once('../_common/conn_open.php');
    require_once('include/checklogin.php'); 
    require_once('include/function.php'); 
    require_once('include/_header.php'); 
?>
<div class="main clearfix">
    <div class="col_cat">
        <div class="cat_menus">
            <?php require_once('include/_menu.php'); ?>
        </div>
    </div>
    <div class="col_content clearfix">
        <div class="col_main">
            <div class="content">

                <h3 class="msg">Welcome to UNCLE JOE Admin Panel </h3>

                <p>&nbsp;</p>
            </div>
        </div>
    </div>
</div>
<?php require_once('include/_footer.php'); ?>
<?php require_once('../_common/conn_close.php'); ?>