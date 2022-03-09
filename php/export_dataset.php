<?php  

    include_once 'common.php';
    include_once '../php/funcions.php';
    include_once '../php/btdv_funcions.php'; 

    global $mysqli;    
    
    ExportDataset($mysqli,$_POST["tid"],intval($_POST["xid"]),$_POST["sid"],$_POST["uid"],$_POST["did1"],$_POST["did2"],$_POST["did3"],$_POST["did4"]);
?>