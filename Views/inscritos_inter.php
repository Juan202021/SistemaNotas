<?php

include_once('/var/www/html/NOTAS/Controllers/inscritosController.php');
$insController = new inscritosController();

$insController->delete($_GET['cod_cur'],$_GET['cod_est'],$_GET['año'],$_GET['periodo'],$_GET['cod_doc']);
