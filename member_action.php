<?php
    require_once('_common/common.php');
    require_once('_common/CSRF.php');
    require_once('_common/conn_open.php');
    require_once('_common/data_functions.php');

    if(!isset($_POST, $_POST['UNCLE-JOE_CSRF_TOKEN']) || !(CSRF::verifyToken('member-form', $_POST['UNCLE-JOE_CSRF_TOKEN']) || CSRF::verifyToken('updatePassword-form', $_POST['UNCLE-JOE_CSRF_TOKEN']))){
        redirect("b5_member.php");
        exit();
    }

    $id = mysql_real_escape_string($_POST['id']);
    $action = mysql_real_escape_string($_POST['action']);

    if($action=="updateAccount"){
        $sql = "SELECT * FROM `member` WHERE `id`='".$id."'";
        $mbRS = mysql_query($sql);
        if(mysql_num_rows($mbRS)==1){
            $mbRow = mysql_fetch_assoc($mbRS);
            foreach($mbRow as $k=>$v){
                if(isset($_POST[$k]) && $_POST[$k]!=$v){
                    $sql = "INSERT INTO `member_update_history` (`member_id`,`update_field`,`old_value`,`new_value`,`updateBy`) VALUES ('".$id."','".$k."','".$v."','".$_POST[$k]."',2)";
                    mysql_query($sql);
                }else if($k=="accept_promotion" && $v=1 && !isset($_POST[$k])){
                    $sql = "INSERT INTO `member_update_history` (`member_id`,`update_field`,`old_value`,`new_value`,`updateBy`) VALUES ('".$id."','".$k."','".$v."',0,2)";
                    mysql_query($sql);
                }
            }
        }

        $query = mysql_query("SELECT * FROM member LIMIT 1");
        $numberfields = mysql_num_fields($query);
        $lastfield = $numberfields-1;
        $sqlupdateStr= "";
        for ($i=0; $i<$numberfields; $i++) {
           $fieldname = mysql_field_name($query, $i);
           if(isset($_POST[$fieldname])){
                $fieldvalue = htmlspecialchars($_POST[$fieldname], ENT_QUOTES);
               if($fieldname =="id"){
                   //skip
               }else if($fieldname=="birthYear" || $fieldname=="birthMonth" || substr($fieldname,0,4)=="date"){
                    if($fieldvalue=="")
                        $sqlupdateStr = $sqlupdateStr."`".$fieldname."` = null,";
                    else
                        $sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."',";
               }else{
                    if($i == $lastfield){
                        $sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."'";
                    }else{
                        $sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '".$fieldvalue."',";
                    }
               }
            }else if($fieldname=="accept_promotion"){
                $sqlupdateStr = $sqlupdateStr."`".$fieldname."` = '0',";
            }
        }
        $sql = "UPDATE `member` SET ".$sqlupdateStr." WHERE `id` = '$id'";
        mysql_query($sql) or die(mysql_error());

        redirect("b5_member.php?msg=1");

    }else if($action=="updatePassword"){
        $oldpwd = passwordEncode($_POST['password_old']);
        $newpwd = passwordEncode($_POST['password_hash']);
        $mbRS = mysql_fetch_array(mysql_query("SELECT password_hash FROM `member` WHERE `id`='".$id."'"));
        $pwd = $mbRS[0];

        if($oldpwd!=$pwd){
            redirect("b5_member.php?msg=3");
            exit();
        }

        $sql = "INSERT INTO `member_update_history` (`member_id`,`update_field`,`old_value`,`new_value`,`updateBy`) VALUES ('".$id."','password_hash','".$pwd."','".$newpwd."',2)";
        mysql_query($sql) or die(mysql_error());

        $sql = "UPDATE `member` SET `password_hash`='$newpwd' WHERE `id` = '$id'";
        mysql_query($sql) or die(mysql_error());

        redirect("b5_member.php?msg=2");
    }
    
?>
<?php require_once('_common/conn_close.php'); ?>