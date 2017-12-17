<?php
    require_once('_common/common.php');
    require_once('_common/CSRF.php');
    require_once('_common/conn_open.php');
    require_once('_common/data_functions.php');

    if(!isset($_POST, $_POST['UNCLE-JOE_CSRF_TOKEN']) || !CSRF::verifyToken('reg-form', $_POST['UNCLE-JOE_CSRF_TOKEN'])){
        redirect("b5_reg.php");
        exit();
    }

    //Check Email...
    $check = mysql_num_rows(mysql_query("SELECT email FROM member where email='".$_POST['email']."'"));
    if($check > 0){
        redirect("b5_reg.php");
        exit();
    }

    $query = mysql_query("SELECT * FROM member");
    $numberfields = mysql_num_fields($query);
    $lastfield = $numberfields-1;
    $sqlfieldname = "";
    $sqlfieldvalue = "";
    for ($i=0; $i<$numberfields ; $i++ ) {
       $fieldname = mysql_field_name($query, $i);
       consoleLog($fieldname.",".$_POST[$fieldname]);
       if(isset($_POST[$fieldname])){
            $fieldvalue = htmlspecialchars($_POST[$fieldname], ENT_QUOTES);
            if($i == $lastfield){
               $sqlfieldname = $sqlfieldname."`".$fieldname."`";
               $sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."'";
            }elseif($fieldname == "id"){
                //do noting
            }elseif($fieldname=="area" || $fieldname=="birthYear" || $fieldname=="birthMonth" || substr($fieldname,0,4)=="date"){
                if($fieldvalue==""){
                    $sqlfieldname = $sqlfieldname."`".$fieldname."`,";
                    $sqlfieldvalue= $sqlfieldvalue."null,";
                }else{
                    $sqlfieldname = $sqlfieldname."`".$fieldname."`,";
                    $sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."',";
                }
            }elseif(substr($fieldname,0,8) == "password"){
                $fieldvalue = passwordEncode($fieldvalue);
                $sqlfieldname = $sqlfieldname."`".$fieldname."`,";
                $sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."',";
            }else{
                $sqlfieldname = $sqlfieldname."`".$fieldname."`,";
                $sqlfieldvalue= $sqlfieldvalue."'".$fieldvalue."',";
            }
        }
    }
    $sql = "INSERT INTO member (".$sqlfieldname.",`date_join`) VALUES (".$sqlfieldvalue.",'$today')";
    mysql_query($sql) or die(mysql_error());
    $id = mysql_insert_id();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>UNCLE JOE</title>

<link href="css/ui_base.css" type="text/css" rel="stylesheet">
<link href="css/ui_supermarket.css" type="text/css" rel="stylesheet">

<!-- import jQuery -->
        <script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
        <!-- import Nivo Slider -->
        <script type="text/javascript" src="js/Nivo_Slider/jquery.nivo.slider.js"></script>
        <link rel="stylesheet" href="js/Nivo_Slider/themes/default/default.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="js/Nivo_Slider/nivo-slider.css" type="text/css" media="screen" />
        <style>
            .sticky {
                top: -10px;
                position: fixed !important;
                width: 100%;
                z-index: 9999;
            }
        </style>
        
</head>

<body>
<? include "b5_header.php" ?>
<div id="content" class="ui_inside">
  	<div>
        <p id="path">主頁 &gt; 註册帳戶 &gt; 註册完成</p>
        <div id="continer">
        	<h1 class="ui_nav2_subtitle">帳戶 - 註册完成</h1>
            <p>&nbsp;</p>
            <p align="center">註册完成。</p>
            <p>&nbsp;</p>
        </div>
    </div>
</div>
<? include "b5_footer.php" ?>
</body>
</html>
<?php require_once('_common/conn_close.php'); ?>