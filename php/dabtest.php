<?php 
header('Cache-control: public'); // IE 6 FIX (private)
header('Content-Type: text/html; charset=UTF-8');

$host = "31.24.154.106";
$user = "Gerard";
$pass = "Ges@cces2020";
$databaseName = "angel__gesdoc";  
$mysqli = new mysqli($host, $user, $pass, $databaseName);

$data = array();
//$sql="SELECT Centre,NIFOperari FROM blanca";
$sql="SELECT NomCentre FROM centres";
$result=$mysqli->query($sql);
while ( $row = $result->fetch_row() )
{
    $data[] = array('centre'=>$row[0],'operari'=>$row[1]);
    echo $row[0];
}

?>