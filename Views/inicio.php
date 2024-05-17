<?php
include_once('/var/www/html/NOTAS/Views/header.php');
include_once('/var/www/html/NOTAS/Controllers/cursosController.php');
$curController = new cursosController();
$datos = $curController->readAll($_GET['cod_doc']);
?>

<div class="contenido">
    <div class="contenido-unico">
        <div class="espaciado">
            <center>
                <h1 id="title">SISTEMA DE GESTIÓN DE NOTAS</h1>
            </center>
        </div>
        <div class="contenido-texto">
            <p>Bienvenido al sistema de gestión de notas de la Universidad de los Llanos</p>
        </div>
    </div>
    <br><br>
    <div class="contenido-unico">
        <div class="list-container">
            <center class="sub-title">todos los cursos</center>
            <ul class="lista">
                <?php if ($datos) : ?>
                    <?php foreach ($datos as $data) : ?>
                        <li>
                            <a href="historico_est.php?cod_doc=<?= $_GET['cod_doc'] ?>&cod_cur=<?= $data['cod_cur'] ?>&año=<?= $data['año'] ?>&periodo=<?= $data['periodo'] ?>&nomb_cur=<?= $data['nomb_cur'] ?>" class='button-big'><?= $data['nomb_cur'].'<br><br>'.$data['año'].' - '.$data['periodo'] ?></a>
                        </li>
                    <?php endforeach ?>
                <?php endif ?>
            </ul>
        </div>
    </div>
</div>
<?php
include_once('/var/www/html/NOTAS/Views/footer.php');
?>