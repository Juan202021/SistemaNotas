<?php
include_once('/var/www/html/SistemaNotas/Views/header.php');
include_once('/var/www/html/SistemaNotas/Controllers/inscritosController.php');
include_once('/var/www/html/SistemaNotas/Controllers/cursosController.php');
$insController = new inscritosController();
$curController = new cursosController();
$periodos = $insController->readAll_año($_GET['cod_doc']);
$datos = $curController->readAll($_GET['cod_doc']);
?>

<div class="contenido">
    <div class="contenido-unico">
        <div class="list-container">
            <center class="sub-title">cursos</center>
            <div class="container-filter">
                <div class="filtro">
                    <form action="" method="post" autocomplete="off" id="form-search">
                        <select name="all" id="f1" class="ajuste-1">
                            <option value="All">Todos</option>
                        </select>
                        <input type="text" id="nomb_cur" name="" placeholder="Buscar" class="ajuste-2">
                        <select name="select-año" id="f2" class="ajuste-3">
                            <option value="">Periodo</option>
                            <?php if ($periodos) : ?>
                                <?php foreach ($periodos as $periodo) : ?>
                                    <option value=""><?= $periodo['año'] . '  -  ' . $periodo['periodo'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </form>

                </div>
            </div>
            <ul class="lista" id="content">
                <?php if ($datos) : ?>
                    <?php foreach ($datos as $data) : ?>
                        <li>
                            <a href="inscritos.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $data['año'] ?>&periodo=<?= $data['periodo'] ?>&cod_cur=<?= $data['cod_cur'] ?>" class='button-big'><?= $data['nomb_cur'] . '<br><br>' . $data['año'] . ' - ' . $data['periodo'] ?></a>
                        </li>
                    <?php endforeach ?>
                <?php endif ?>
            </ul>
        </div>
    </div>
</div>

<?php
echo "<br><br>";
echo session_id();
echo "<br><br>";
include_once('/var/www/html/SistemaNotas/Views/footer.php');
?>