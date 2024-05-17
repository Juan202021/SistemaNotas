<?php
include_once('/var/www/html/NOTAS/Views/header.php');
include_once('/var/www/html/NOTAS/Controllers/calificacionesController.php');
$notasController = new calificacionesController();
$datos = $notasController->readAll_notas($_GET['cod_doc'], $_GET['año'],$_GET['periodo'], $_GET['nomb_cur']);
$porcentajes = $notasController->porcentajes($_GET['cod_doc'], $_GET['año'],$_GET['periodo'], $_GET['nomb_cur']);
// print_r($_GET);
// print_r($datos);
?>

<div class="contenido">
    <div class="contenido-izq">
        <div>
            <div class="menu-izq">
                <a href="notas.php?año=<?= $_GET['año'] ?>&nomb_cur=<?= $_GET['nomb_cur'] ?>" class='menu-izq-buttons'>Calificaciones</a>
                <a href="#" class='menu-izq-buttons'>Estadísticas del curso</a>
            </div>
        </div>
    </div>
    <div class="contenido-central">
        <div class="tbl">
            <table id='miTabla3'>
                <caption>CALIFICACIONES</caption>
                <thead>
                    <tr>
                        <th rowspan="2">Nombre</th>
                        <th colspan="2">Nota</th>
                    </tr>
                    <tr>
                        <?php if ($porcentajes) : ?>
                            <?php foreach ($porcentajes as $porcentaje) : ?>
                                <th><?= $porcentaje['porcentaje'] ?></th>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($datos) : ?>
                        <?php foreach ($datos as $data) : ?>
                            <tr>
                                <td><?= $data['apell_est'] . " " . $data['nomb_est'] ?></td>

                                <td><?= $data['nota'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td>No hay inscritos</td>
                        </tr>
                    <?php endif ?>

                </tbody>
            </table>
        </div>
    </div>
    <div class="contenido-der">der</div>
</div>

<?php
include_once("/var/www/html/NOTAS/Views/footer.php");
?>