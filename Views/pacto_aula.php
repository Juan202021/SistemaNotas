<?php
include_once('/var/www/html/SistemaNotas/Views/header.php');
include_once('/var/www/html/SistemaNotas/Controllers/pacto_aula.php');
$controlador = new PactoAulaControlador;
?>

<header>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    
    <script src="../Assets/js/pacto_aula.js"></script>
</header>

<body>
<div class="contenido_flex">
    <div class="contenido-izq">
        <div>
            <div class="menu-izq">
                <h1 class="sub-title"><?= $_GET['nomb_cur']. '<br>' .$_GET['año'].' - '.$_GET['periodo'] ?></h1>
                <a href="inscritos.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons'>Inscritos</a>
                <a href="inscribir.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $_GET['nomb_cur'] ?>" class='menu-izq-buttons'>Inscribir</a>
                <a href="notas.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons'>Calificaciones</a>
                <a href="pacto_aula.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $_GET['nomb_cur'] ?>" class='menu-izq-buttons selected'>Pacto de aula</a>
                <a href="reporte.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $_GET['nomb_cur'] ?>" class='menu-izq-buttons'>Estadísticas del curso</a>
            </div>
        </div>
    </div>
    <div class="contenido-central">
        <div class="container">
            <table id='pacto_aula'>
                <caption class="sub-title">Pacto de aula</caption>
                <thead>
                    <tr>
                        <th>Corte</th>
                        <th>Actividad</th>
                        <th>porcentaje</th>
                        <th class="td-der">Porcentaje total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $info_nota = $controlador->getInfoNotas($_GET['cod_doc']); ?>
                    <?php foreach ($info_nota as $elemento) : ?>
                            <?php echo $elemento; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
<?php
include_once('/var/www/html/SistemaNotas/Views/footer.php');
?>