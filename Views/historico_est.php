<?php
include_once('/var/www/html/SistemaNotas/Views/header.php');
include_once('/var/www/html/SistemaNotas/Controllers/inscritosController.php');
$insController = new inscritosController();
$datos = $insController->readAll_historico($_GET['cod_doc'],$_GET['cod_cur'],$_GET['año'],$_GET['periodo']);
?>

<div class="contenido_flex">
    <div class="contenido-unico">
        <div class="tbl">
            <table id='miTabla3'>
                <caption class="sub-title">inscritos al curso <?= $_GET['nomb_cur'].'<br>'.$_GET['año'].' - '.$_GET['periodo'] ?></caption>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Programa</th>
                        <th>Definitiva</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($datos) : ?>
                        <?php foreach ($datos as $data) : ?>
                            <tr>
                                <td><?= $data['apell_est'] . " " . $data['nomb_est'] ?></td>
                                <td class="td-cent"><?= $data['nomb_pro'] ?></td>
                                <td class="td-cent"><?= $data['def'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4">No hay registros</td>
                        </tr>
                    <?php endif ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include_once('/var/www/html/SistemaNotas/Views/footer.php');
?>