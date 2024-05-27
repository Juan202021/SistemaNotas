<?php
include_once('/var/www/html/SistemaNotas/Views/header.php');
include_once('/var/www/html/SistemaNotas/Controllers/calificacionesController.php');
include_once('/var/www/html/SistemaNotas/Controllers/inscritosController.php');
$notasController = new calificacionesController();
$insController = new inscritosController();


$est = $insController->readAll_est($_GET['cod_doc'], $_GET['año'], $_GET['periodo'], $_GET['cod_cur']);
$notas_corte1 = $notasController->notas_corte($_GET['cod_doc'], $_GET['año'], $_GET['periodo'], $_GET['cod_cur'], 1);
$notas_corte2 = $notasController->notas_corte($_GET['cod_doc'], $_GET['año'], $_GET['periodo'], $_GET['cod_cur'], 2);
$notas_corte3 = $notasController->notas_corte($_GET['cod_doc'], $_GET['año'], $_GET['periodo'], $_GET['cod_cur'], 3);
// $notas = $notasController->readAll_notas($_GET['cod_doc'], $_GET['año'], $_GET['periodo'], $_GET['cod_cur']);

?>

<div class="contenido_flex">
    <div class="contenido-izq">
        <div>
            <div class="menu-izq">
                <h1 class="sub-title2"><?= $est[0]['nomb_cur']. '<br>' .$_GET['año'].' - '.$_GET['periodo'] ?></h1>
                <ul class="menu-desplegable">
                    <li><a href="inscritos.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons'>Inscritos</a></li>
                    <li><a href="inscribir.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $est[0]['nomb_cur'] ?>" class='menu-izq-buttons'>Inscribir</a></li>
                    <li>
                        <a href="notas.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons'>Calificaciones<img src="../Assets/imagenes/bx-chevron-left.svg" alt=""></a>
                        
                        <ul class="style-desplegable">
                            <li><a href="porcentajes.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons selected'>Ingresar Notas</a></li>
                        </ul>
                    </li>
                    
                    <li><a href="#" class='menu-izq-buttons'>Estadísticas del curso</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="contenido-central">
        <div class="tbl">
            <table id='miTabla3'>
                <caption class="sub-title">calificaciones</caption>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Corte 1</th>
                        <th>Corte 2</th>
                        <th>Corte 3</th>
                        <th>Definitiva</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($est) : ?>
                        <?php foreach ($est as $e) : ?>
                            <tr>
                                <td><a href="#" class="button"><?= $e['apell_est'] . " " . $e['nomb_est'] ?></a></td>
                                <!-- corte 1 -->
                                <?php if ($notasController->coincide($e['apell_est'],$e['nomb_est'],$notas_corte1)) : ?>
                                    <td style="text-align:center"><?= $notasController->coincide($e['apell_est'],$e['nomb_est'],$notas_corte1) ?></td>
                                <?php else : ?>
                                    <td></td>
                                <?php endif ?>
                                <!-- corte 2 -->
                                <?php if ($notasController->coincide($e['apell_est'],$e['nomb_est'],$notas_corte2)) : ?>
                                    <td style="text-align:center"><?= $notasController->coincide($e['apell_est'],$e['nomb_est'],$notas_corte2) ?></td>
                                <?php else : ?>
                                    <td></td>
                                <?php endif ?>
                                <!-- corte 3 -->
                                <?php if ($notasController->coincide($e['apell_est'],$e['nomb_est'],$notas_corte3)) : ?>
                                    <td style="text-align:center"><?= $notasController->coincide($e['apell_est'],$e['nomb_est'],$notas_corte3) ?></td>
                                <?php else : ?>
                                    <td></td>
                                <?php endif ?>
                                <!-- definitiva -->
                                <td style="text-align:center"><?= $notasController->definitiva($e['apell_est'],$e['nomb_est'],$notas_corte1,$notas_corte2,$notas_corte3) ?></td>
                                
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">No hay inscritos</td>
                        </tr>
                    <?php endif ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
echo "<br><br><br>";
include_once("/var/www/html/SistemaNotas/Views/footer.php");
?>