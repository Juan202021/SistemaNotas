<?php
include_once('/var/www/html/SistemaNotas/Views/header.php');
include_once('/var/www/html/SistemaNotas/Controllers/cursosController.php');

$curController = new cursosController();

$data = $curController->find(session_id(),$_POST['query']);

$id = session_id();

if (count($data) > 0) {
    foreach ($data as $d) {
        echo "<li><a href='inscritos.php?cod_doc={$id}&año={$d['año']}&periodo={$d['periodo']}&cod_cur={$d['cod_cur']}' class='button-big'>{$d['nomb_cur']} <br><br> {$d['año']} - {$d['periodo']}</a></li>";
        
    }
} else {
    echo "<li>No se encontraron resultados.</li>";
}