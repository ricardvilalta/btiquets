<?php 
header('Cache-control: public'); // IE 6 FIX (private)
header('Content-Type: text/html; charset=UTF-8');

include_once 'common.php';
include_once 'funcions.php';
include_once 'btdv_funcions.php'; 
require_once '../vendor/autoload.php';

global $mysqli;

$ref=$_GET["codi"];
$info_reserva = GetReservation_by_ref($mysqli,$ref);
$mpdf = GeneratePDF4($info_reserva);
$content = $mpdf->Output();
?>