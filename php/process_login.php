<?php

    include_once './common.php';
    include_once './../php/funcions.php';
    sec_session_start('btiquets_session_id'); // Our custom secure way of starting a php session. 
    global $mysqli;
    
    if(isset($_POST['email'], $_POST['p'])) 
    { 
        $email = $_POST['email'];
        $password = $_POST['p']; // The hashed password.
        $redirect = $_POST['redirect'];        
        if(login($email, $password, $mysqli,"btiquets_login_string"))
        {
            header('Location: /admin/2' . $redirect);
            exit;
        }
        else
        {
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