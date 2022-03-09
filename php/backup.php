<?php

	include_once 'common.php';
    include_once '../php/funcions.php';

    global $zone;

    date_default_timezone_set($zone);
    $date = date('Y-m-d_His');

    if(!file_exists("../CS/"))
    {
        mkdir("../CS/");
    }
    mkdir("../CS/".$date);

    // Primer fa la còpia de la base de dades
    $com = 'mysqldump --user=' . $user . ' --password=' . $pass . ' --host=' . $host . ' ' . $databaseName . ' > ../CS/' . $date . '/DB.sql';
    exec($com);

    // I ara es comprimeix tot
    $folder = '../boxes';
    $backup = '../CS/' . $date;
    $zip_file = $backup.'/boxes.zip';
    Zip($folder,$zip_file);
?>