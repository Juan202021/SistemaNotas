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

                <h1 class="sub-title"><?= $est[0]['nomb_cur']. '<br>' .$_GET['año'].' - '.$_GET['periodo'] ?></h1>
                <a href="inscritos.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons'>Inscritos</a>
                <a href="inscribir.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $est[0]['nomb_cur'] ?>" class='menu-izq-buttons'>Inscribir</a>
                <a href="notas.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons selected'>Calificaciones</a>
                <a href="pacto_aula.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $est[0]['nomb_cur']?>" class='menu-izq-buttons'>Pacto de aula</a>
                <a href="reporte.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $est[0]['nomb_cur']?>" class='menu-izq-buttons'>Estadísticas del curso</a>

            </div>
        </div>
    </div>
    <div class="contenido-central">
        <div>
            <div class="tbl">
                <table id='miTabla3'>
                    <caption class="sub-title">calificaciones</caption>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>
                                <a class="corte" href="editar_notas.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur']?>&corte=1&nomb_cur=<?= $est[0]['nomb_cur'] ?>">
                                    Corte 1 
                                </a>
                            </th>
                            <th>
                                <a class="corte" href="editar_notas.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur']?>&corte=2&nomb_cur=<?= $est[0]['nomb_cur'] ?>">
                                    Corte 2
                                </a>
                            </th>
                            <th>
                                <a class="corte" href="editar_notas.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur']?>&corte=3&nomb_cur=<?= $est[0]['nomb_cur'] ?>">
                                    Corte 3
                                </a>
                            </th>
                            <th>Definitiva</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($est) : ?>
                            <?php foreach ($est as $e) : ?>
                                <tr>
                                    <td><a href="#" class="button"><?= $e['apell_est'] . " " . $e['nomb_est'] ?></a></td>
                                    <!-- corte 1 -->
                                    <?php if ($notasController->coincide($e['apell_est'], $e['nomb_est'], $notas_corte1)) : ?>
                                        <td style="text-align:center"><?= $notasController->coincide($e['apell_est'], $e['nomb_est'], $notas_corte1) ?></td>
                                    <?php else : ?>
                                        <td></td>
                                    <?php endif ?>
                                    <!-- corte 2 -->
                                    <?php if ($notasController->coincide($e['apell_est'], $e['nomb_est'], $notas_corte2)) : ?>
                                        <td style="text-align:center"><?= $notasController->coincide($e['apell_est'], $e['nomb_est'], $notas_corte2) ?></td>
                                    <?php else : ?>
                                        <td></td>
                                    <?php endif ?>
                                    <!-- corte 3 -->
                                    <?php if ($notasController->coincide($e['apell_est'], $e['nomb_est'], $notas_corte3)) : ?>
                                        <td style="text-align:center"><?= $notasController->coincide($e['apell_est'], $e['nomb_est'], $notas_corte3) ?></td>
                                    <?php else : ?>
                                        <td></td>
                                    <?php endif ?>
                                    <!-- definitiva -->
                                    <td style="text-align:center"><?= $notasController->definitiva($e['apell_est'], $e['nomb_est'], $notas_corte1, $notas_corte2, $notas_corte3) ?></td>

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
</div>

<?php
echo "<br><br><br>";
include_once("/var/www/html/SistemaNotas/Views/footer.php");
?>