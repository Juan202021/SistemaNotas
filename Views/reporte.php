<?php
include_once('/var/www/html/SistemaNotas/Views/header.php');
include_once('/var/www/html/SistemaNotas/Controllers/reporte.php');
?>
<header>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../Assets/js/reporte.js"></script>

</header>

<body>
<div class="contenido_flex">
    <div class="contenido-izq">
        <div>
            <div class="menu-izq">
                <h1 class="sub-title2"><?= $_GET['nomb_cur']. '<br>' .$_GET['año'].' - '.$_GET['periodo'] ?></h1>
                <hr>
                <a href="inscritos.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons'>Inscritos</a>
                <a href="inscribir.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $_GET['nomb_cur'] ?>" class='menu-izq-buttons'>Inscribir</a>
                <a href="notas.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>" class='menu-izq-buttons'>Calificaciones</a>
                <a href="reporte.php?cod_doc=<?= $_GET['cod_doc'] ?>&año=<?= $_GET['año'] ?>&periodo=<?= $_GET['periodo'] ?>&cod_cur=<?= $_GET['cod_cur'] ?>&nomb_cur=<?= $_GET['nomb_cur'] ?>" class='menu-izq-buttons selected'>Estadísticas del curso</a>
            </div>
        </div>
    </div>
    <div class="contenido-central">
        <div class="container">
            <h1>Estadísticas de Notas</h1>
            <select id="corte" onchange="corte()" class="ajuste-1" style="min-width: max-content">
                <option value="" disabled>seleccione el corte</option>
                <option value="1">corte 1</option>
                <option value="2">corte 2</option>
                <option value="3">corte 3</option>
                <option value="4" selected>definitivas</option>
            </select>
            <select name="infoNotas" id="detalles" onchange="sacarNotas()" class="ajuste-1" style="min-width: max-content">
                <option value="" disabled selected>seleccione la nota</option>
            </select>
            <div id="graficos">
                <!-- Espacio para gráficos -->
                <canvas id="histograma" width="400" height="200"></canvas>
                <canvas id="graficoBarras" width="400" height="200"></canvas>
                <canvas id="graficoPastel" ></canvas>
            </div>
        </div>
    </div>
</div>


</body>
<?php
include_once('/var/www/html/SistemaNotas/Views/footer.php');
?>
