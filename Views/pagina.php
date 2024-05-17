<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Notas</title>
    <link rel="stylesheet" href="../Assets/css/styles2.css">
</head>
<body>
    <div class="container">
        <h1>Estadísticas de Notas</h1>
        <div id="estadisticas">
            <!-- Estadísticas Descriptivas -->
            <p>Promedio: <span id="promedio"></span></p>
            <p>Mediana: <span id="mediana"></span></p>
            <p>Moda: <span id="moda"></span></p>
            <p>Desviación Estándar: <span id="desviacion"></span></p>
            <p>Nota Mínima: <span id="minima"></span></p>
            <p>Nota Máxima: <span id="maxima"></span></p>
        </div>
        <div id="graficos">
            <!-- Espacio para gráficos -->
            <canvas id="histograma" width="400" height="200"></canvas>
            <canvas id="graficoBarras" width="400" height="200"></canvas>
            <canvas id="graficoPastel" width="400" height="200"></canvas>
            <canvas id="boxPlot" width="400" height="200"></canvas>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../Assets/js/script.js"></script>
</body>
</html>
