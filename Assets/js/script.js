document.addEventListener("DOMContentLoaded", function() {
    // Datos de ejemplo (pueden ser obtenidos dinámicamente de la base de datos)
    let notas = [5, 2, 1, 3.5, 2, 1.5, 4.5, 5, 2.3, 1.2];

    // Funciones para calcular estadísticas
    function calcularPromedio(notas) {
        return notas.reduce((a, b) => a + b, 0) / notas.length;
    }

    function calcularMediana(notas) {
        notas.sort((a, b) => a - b);
        let mitad = Math.floor(notas.length / 2);
        return notas.length % 2 !== 0 ? notas[mitad] : (notas[mitad - 1] + notas[mitad]) / 2;
    }

    function calcularModa(notas) {
        let frecuencia = {};
        let maxFreq = 0;
        let moda = [];
        notas.forEach(nota => {
            if (!frecuencia[nota]) frecuencia[nota] = 0;
            frecuencia[nota]++;
            if (frecuencia[nota] > maxFreq) {
                maxFreq = frecuencia[nota];
                moda = [nota];
            } else if (frecuencia[nota] === maxFreq) {
                moda.push(nota);
            }
        });
        return moda;
    }

    function calcularDesviacionEstandar(notas) {
        let promedio = calcularPromedio(notas);
        let sumCuadrados = notas.map(nota => Math.pow(nota - promedio, 2)).reduce((a, b) => a + b, 0);
        return Math.sqrt(sumCuadrados / notas.length);
    }

    // Mostrar estadísticas
    document.getElementById('promedio').textContent = calcularPromedio(notas).toFixed(2);
    document.getElementById('mediana').textContent = calcularMediana(notas).toFixed(2);
    document.getElementById('moda').textContent = calcularModa(notas).join(', ');
    document.getElementById('desviacion').textContent = calcularDesviacionEstandar(notas).toFixed(2);
    document.getElementById('minima').textContent = Math.min(...notas);
    document.getElementById('maxima').textContent = Math.max(...notas);

    // Gráficos con Chart.js
    const ctxHistograma = document.getElementById('histograma').getContext('2d');
    const ctxBarras = document.getElementById('graficoBarras').getContext('2d');
    const ctxPastel = document.getElementById('graficoPastel').getContext('2d');
    const ctxBoxPlot = document.getElementById('boxPlot').getContext('2d');

    // Histograma de frecuencias
    new Chart(ctxHistograma, {
        type: 'bar',
        data: {
            labels: Array.from(new Set(notas)),
            datasets: [{
                label: 'Frecuencia',
                data: Array.from(new Set(notas)).map(nota => notas.filter(n => n === nota).length),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Barras
    new Chart(ctxBarras, {
        type: 'bar',
        data: {
            labels: ['Promedio', 'Mediana', 'Moda', 'Min', 'Max'],
            datasets: [{
                label: 'Estadísticas',
                data: [
                    calcularPromedio(notas),
                    calcularMediana(notas),
                    calcularModa(notas)[0],
                    Math.min(...notas),
                    Math.max(...notas)
                ],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Pastel
    new Chart(ctxPastel, {
        type: 'pie',
        data: {
            labels: ['Aprobados', 'Reprobados'],
            datasets: [{
                label: 'Aprobados vs Reprobados',
                data: [
                    notas.filter(nota => nota >= 3).length,
                    notas.filter(nota => nota < 3).length
                ],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // Box Plot - Diagrama de caja y bigotes
    // Para Chart.js se necesita una librería adicional para hacer un boxplot (por ejemplo chartjs-chart-box-and-violin-plot)
    // Asegúrate de incluir la librería antes de usar este gráfico
});
