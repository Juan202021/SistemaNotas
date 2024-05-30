<?php
include_once('/var/www/html/SistemaNotas/Views/header.php');
include_once('/var/www/html/SistemaNotas/Controllers/editar_notas.php');
$editarNotas = new EditarNotasControlador();
?>
<header>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="../Assets/js/guardar_notas.js"></script>
</header>
<div class="contenido_flex">
    <div class="contenido-izq">
        <div>
            <div class="menu-izq">

                <h1 class="sub-title"><?= $_GET['nomb_cur']. '<br>' .$_GET['año'].' - '.$_GET['periodo'] ?></h1>
                <a href="inscritos.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons'>Inscritos</a>
                <a href="inscribir.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $_GET['nomb_cur'] ?>" class='menu-izq-buttons'>Inscribir</a>
                <a href="notas.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons selected'>Calificaciones</a>
                <a href="pacto_aula.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $_GET['nomb_cur']?>" class='menu-izq-buttons'>Pacto de aula</a>
                <a href="reporte.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $_GET['nomb_cur']?>" class='menu-izq-buttons'>Estadísticas del curso</a>
            </div>
        </div>
    </div>
    <div class="contenido-central">
        <div>
            <div class="tbl">
            
                <table id='actualizar_nota'>
                    <caption class="sub-title">calificaciones</caption>
                        <?php $tabla = $editarNotas->tabla($_GET['cod_cur'], $_GET['corte']); ?>
                        <?php foreach($tabla as $filas) : ?>
                            <?php echo $filas ?>
                        <?php endforeach ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include_once("/var/www/html/SistemaNotas/Views/footer.php");
?>