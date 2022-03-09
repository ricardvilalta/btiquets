<?php

	include_once 'common.php';
    include_once '../php/funcions.php';

    $backup_folder = $_POST['backup_folder'];    

    $tempfolder = '../temp';
    $backup = '../CS/' . $backup_folder . '/';
    $zip_file_1 = $backup.'boxes.zip';

    if(!file_exists( $tempfolder ))
    {
        mkdir($tempfolder);
    }

    // es borra el contingut de temp, però temp no.
    delete_dir($tempfolder,false);

    // ara copiem boxes i cellers al directori temp
    copyDirToDir('../boxes',$tempfolder);

    // es borra el contingut actual de boxes i cellers.
    delete_dir('../boxes',false);

    // es descomprimeixen els arxius
    UnZip($zip_file_1,'../boxes/',true,false);

    // i carrego la bbdd
    $com = 'mysql --user=' . $user . ' --password=' . $pass . ' --host=' . $host . ' ' . $databaseName . ' < ../CS/' . $backup_folder . '/DB.sql';
    exec($com);

    echo json_encode(1);
?>