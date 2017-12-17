<?php
    require_once('_common/common.php');
    require_once('_common/CSRF.php');
    require_once('_common/conn_open.php');
    require_once('_common/data_functions.php');

    if(!isset($_POST, $_POST['UNCLE-JOE_CSRF_TOKEN']) || !CSRF::verifyToken('member_login-form', $_POST['UNCLE-JOE_CSRF_TOKEN'])){
        redirect("b5_login.php");
        exit();
    }

    $module = $_POST['module'];
    $email = mysql_real_escape_string($_POST['email']);
    $psw = passwordEncode(mysql_real_escape_string($_POST['password_hash']));

    $sql = "SELECT * FROM member WHERE `email`='$email' AND `password_hash`='$psw' AND `status`='1'";
    $result = mysql_query($sql);
    if(mysql_num_rows($result)!=1){
        // login fail
        alert("Incorrect Email or Password!");
        redirect("b5_login.php");
        exit();
    }else{
        $row = mysql_fetch_array($result);
        $_SESSION['member']["id"] = $row['id'];
        $_SESSION['member']["name_tc"] = $row['name_tc'];
        $_SESSION['member']['email'] = $row['email'];
        redirect($module.".php");
    }

?>
<?php require_once('_common/conn_close.php'); ?>