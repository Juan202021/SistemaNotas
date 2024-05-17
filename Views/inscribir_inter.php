<?php
// include_once('/var/www/html/NOTAS/Views/header.php');
include_once('/var/www/html/SistemaNotas/Controllers/inscritosController.php');
$insController = new inscritosController();

$insController->create($_GET['año'],$_GET['periodo'],$_GET['cod_cur'],$_GET['cod_est'],$_GET['cod_doc'],$_GET['nomb_cur']);