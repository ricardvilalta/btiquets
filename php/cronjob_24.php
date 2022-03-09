<?php

    include_once '../php/common.php';
    include_once '../php/btdv_funcions.php';
    global $mysqli;
    global $zone;    

    // ES BORREN LES RESERVES INCOMPLETES MÉS ANTIGUES D'1 SETMANA
    DeleteIncompleteReservations($mysqli,$zone);
    
    // S'EXECUTEN LES SESSIONS
    ExecuteSessions($mysqli,$zone);

    // CÒPIA DE SEGURETAT
    include_once '../php/backup.php';
?>