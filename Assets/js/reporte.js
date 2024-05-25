document.addEventListener("DOMContentLoaded", defecto);
let histogramaChart, barrasChart, pastelChart;
function defecto(){
    var infNotas = [
        { value: "d1", text: "Corte 1" },
        { value: "d2", text: "Corte 2" },
        { value: "d3", text: "Corte 3" },
        { value: "d4", text: "Curso" }
    ];
    var menuDesplegable = document.getElementById("detalles");
    infNotas.forEach(function(opcion){
        var options = document.createElement("option");
        if(opcion.value == "d4"){
            options.selected = true;
        }
        options.value = opcion.value;
        options.text = opcion.text;
        menuDesplegable.appendChild(options);
    });
}

function corte(){
    const params = new URLSearchParams(window.location.search);
    const seleccion = document.getElementById('corte').value;
    if(seleccion != 4){
        if(params.has('cod_cur')){
            fetch(`../Controllers/reporte.php?corte=${seleccion}&cod_cur=${params.get('cod_cur')}`)
            .then(response => { 
                if(!response.ok){
                    throw new Error('Error en la red');
                }
                return response.json();
            })
            .then(infNotas => {
                if(infNotas.Error){
                    console.error('error', infNotas.error);
                    return
                }
                
                mostrarInfoNotas(infNotas);
            })
        }
    }else{
        var infNotas = [
            { value: "d1", text: "Corte 1" },
            { value: "d2", text: "Corte 2" },
            { value: "d3", text: "Corte 3" },
            { value: "d4", text: "Curso" }
        ];
        mostrarInfoNotas(infNotas);
    }
}

function mostrarInfoNotas(infNotas){
    
    var menuDesplegable = document.getElementById("detalles");
    menuDesplegable.innerHTML = '<option value="" disabled selected>seleccione la nota</option>';

    infNotas.forEach(function(opcion){
        var options = document.createElement("option");
        options.value = opcion.value;
        options.text = opcion.text;
        menuDesplegable.appendChild(options);
    });
}

function sacarNotas(){
    const seleccion = document.getElementById('detalles').value;

    fetch(`../Controllers/reporte.php?cod_inf=${seleccion}`)
    .then(response => { 
        if(!response.ok){
            throw new Error('Error en la red');
        }
        return response.json();
    })
    .then(notas => {
        if(notas.Error){
        console.error('error', notas.error);
            return
        }
        notas = notas.map(parseFloat)
        actualizarGraficas(notas);
    })
    
}

function actualizarGraficas(notas){
    // Histograma de frecuencias
    if (histogramaChart) histogramaChart.destroy();
    const ctxHistograma = document.getElementById('histograma').getContext('2d');
    histogramaChart = new Chart(ctxHistograma, {
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
    if (barrasChart) barrasChart.destroy();
    const ctxBarras = document.getElementById('graficoBarras').getContext('2d');
    barrasChart = new Chart(ctxBarras, {
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
    if (pastelChart) pastelChart.destroy();
    const ctxPastel = document.getElementById('graficoPastel').getContext('2d');
    pastelChart = new Chart(ctxPastel, {
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
}

// Funciones para calcular estadísticas
function calcularPromedio(notas) {
    hola = notas.reduce((a, b) => a + b, 0) / notas.length;
    console.log(notas);
    console.log(hola);
    return hola;
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

