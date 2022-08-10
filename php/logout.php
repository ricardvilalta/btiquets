<?php
    include_once './../php/funcions.php';

    error_log("LOGOUT");
    sec_session_start('btiquets_session_id');
    // Unset all session values
    $_SESSION = array();
    // get session parameters 
    $params = session_get_cookie_params();
    // Delete the actual cookie.
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    // Destroy session
    session_destroy();
    header('Location: /admin/2');
    exit;
?>