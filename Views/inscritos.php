<?php
include_once('/var/www/html/SistemaNotas/Views/header.php');
include_once('/var/www/html/SistemaNotas/Controllers/inscritosController.php');
$insController = new inscritosController();
$datos = $insController->readAll_est($_GET['cod_doc'], $_GET['año'], $_GET['periodo'], $_GET['cod_cur']);
?>

<div class="contenido_flex">
    <div class="contenido-izq">
        <div>
            <div class="menu-izq">
                <h1 class="sub-title"><?= $datos[0]['nomb_cur']. '<br>' .$_GET['año'].' - '.$_GET['periodo'] ?></h1>
                <a href="inscritos.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons selected'>Inscritos</a>
                <a href="inscribir.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $datos[0]['nomb_cur'] ?>" class='menu-izq-buttons'>Inscribir</a>
                <a href="notas.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons'>Calificaciones</a>
                <a href="reporte.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $datos[0]['nomb_cur'] ?>" class='menu-izq-buttons'>Estadísticas del curso</a>
            </div>
        </div>
    </div>
    <div class="contenido-central">
        <div class="tbl">
            <table id='miTabla4'>
                <caption class="sub-title">inscritos al curso</caption>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Programa</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($datos) : ?>
                        <?php foreach ($datos as $data) : ?>
                            <tr>
                                <td><?= $data['apell_est'] . " " . $data['nomb_est'] ?></td>
                                <td class="td-cent"><?= $data['nomb_pro'] ?></td>
                                <td  class="td-der">
                                    <a href="inscritos_inter.php?cod_est=<?= $data['cod_est'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_doc=<?= $_GET['cod_doc'] ?>" class="delete button">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 50 59" class="bin">
                                            <path fill="#B5BAC1" d="M0 7.5C0 5.01472 2.01472 3 4.5 3H45.5C47.9853 3 50 5.01472 50 7.5V7.5C50 8.32843 49.3284 9 48.5 9H1.5C0.671571 9 0 8.32843 0 7.5V7.5Z"></path>
                                            <path fill="#B5BAC1" d="M17 3C17 1.34315 18.3431 0 20 0H29.3125C30.9694 0 32.3125 1.34315 32.3125 3V3H17V3Z"></path>
                                            <path fill="#B5BAC1" d="M2.18565 18.0974C2.08466 15.821 3.903 13.9202 6.18172 13.9202H43.8189C46.0976 13.9202 47.916 15.821 47.815 18.0975L46.1699 55.1775C46.0751 57.3155 44.314 59.0002 42.1739 59.0002H7.8268C5.68661 59.0002 3.92559 57.3155 3.83073 55.1775L2.18565 18.0974ZM18.0003 49.5402C16.6196 49.5402 15.5003 48.4209 15.5003 47.0402V24.9602C15.5003 23.5795 16.6196 22.4602 18.0003 22.4602C19.381 22.4602 20.5003 23.5795 20.5003 24.9602V47.0402C20.5003 48.4209 19.381 49.5402 18.0003 49.5402ZM29.5003 47.0402C29.5003 48.4209 30.6196 49.5402 32.0003 49.5402C33.381 49.5402 34.5003 48.4209 34.5003 47.0402V24.9602C34.5003 23.5795 33.381 22.4602 32.0003 22.4602C30.6196 22.4602 29.5003 23.5795 29.5003 24.9602V47.0402Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                                            <path fill="#B5BAC1" d="M2 13H48L47.6742 21.28H2.32031L2 13Z"></path>
                                        </svg>
                                        <span class="tooltip">Eliminar</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3">No hay inscritos</td>
                        </tr>
                    <?php endif ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// echo $data['cod_pro'];
// echo "<br><br><br>";
include_once('/var/www/html/SistemaNotas/Views/footer.php');
?>