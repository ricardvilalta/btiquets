<?php

    include_once './common.php';
    include_once './../php/funcions.php';
    sec_session_start('btiquets_session_id'); // Our custom secure way of starting a php session. 
    global $mysqli;
    global $lang;
    
    if(isset($_POST['user_id'],$_POST['p'])) 
    {
        $userid = $_POST['user_id'];
        $password = $_POST['p']; // The hashed password.
        if(editPassword($userid,$password,$mysqli) == true)
        {
            header('Location: /admin/4');
            
//            if(login_id($userid, $password, $mysqli,"btiquets_login_string"))
//            {
//                header('Location: /admin/2');
//                exit;
//            }
//            else
//            {
//                // Login failed
//                header('Location: /login');
//                exit;
//            }
        } 
        else 
        {
            // Login failed
            header('Location: /login');
            exit;
        }
    } 
    else 
    { 
        // The correct POST variables were not sent to this page.
        echo 'Invalid Request';
    }
?>