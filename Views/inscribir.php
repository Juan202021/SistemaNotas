<?php
include_once('/var/www/html/SistemaNotas/Views/header.php');
include_once('/var/www/html/SistemaNotas/Controllers/inscritosController.php');
$insController = new inscritosController();
$datos = $insController->readAll_est_no_ins($_GET['cod_doc'], $_GET['año'], $_GET['periodo'], $_GET['cod_cur']);
?>
<header>
<script src="../Assets/js/buscador.js"></script>
</head>

<div class="contenido_flex">
    <div class="contenido-izq">
        <div>
            <div class="menu-izq">
                <h1 class="sub-title2"><?= $_GET['nomb_cur'] . '<br>' . $_GET['año'] . ' - ' . $_GET['periodo'] ?></h1>
                <a href="inscritos.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons'>Inscritos</a>
                <a href="inscribir.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $_GET['nomb_cur'] ?>" class='menu-izq-buttons  selected'>Inscribir</a>
                <a href="notas.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons'>Calificaciones</a>
                <a href="pacto_aula.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $_GET['nomb_cur'] ?>" class='menu-izq-buttons'>Pacto de aula</a>
                <a href="reporte.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $_GET['nomb_cur'] ?>" class='menu-izq-buttons'>Estadísticas del curso</a>

            </div>
        </div>
    </div>
    <div class="contenido-central">

        <div class="tbl">
            <center class="sub-title">inscribir al curso</center>
            <div class="container-filter">
                <div class="filtro">
                    <select name="all" id="f1" class="ajuste-1">
                        <option value="All">Todos</option>
                    </select>
                    <input type="text" name="Buscador" placeholder="Buscar" class="ajuste-2" id="buscarInput">
                </div>
            </div>
            <table id='miTabla3'>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Programa</th>
                        <th></th>
                    </tr>
                </thead>
                    <tbody id="resultadoBusqueda">
                        <?php if ($datos) : ?>
                            <?php foreach ($datos as $data) : ?>
                                <tr>
                                    <td><?= $data['apell_est'] . " " . $data['nomb_est'] ?></td>
                                    <td class="td-cent"><?= $data['nomb_pro'] ?></td>
                                    <td class="td-der">
                                        <a href="inscribir_inter.php?cod_est=<?= $data['cod_est'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_doc=<?= $_GET['cod_doc'] ?>&nomb_cur=<?= $_GET['nomb_cur'] ?>" class="add button">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                                    <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                                                </svg>
                                                <span class="tooltip">Agregar</span>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3">No hay estudiantes para inscribir</td>
                            </tr>
                        <?php endif ?>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include_once('/var/www/html/SistemaNotas/Views/footer.php');
?>