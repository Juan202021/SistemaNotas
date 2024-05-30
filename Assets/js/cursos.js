document.addEventListener("DOMContentLoaded", function() {
    
    var periodo = document.getElementById("f2");

    periodo.addEventListener("change", function(){

        enviarDatos(periodo.value);

    });
});

function enviarDatos(datos) {

    var params = new URLSearchParams(window.location.search);

    datos = params.get('cod_doc')

    fetch(`../Controllers/cursosController.php?periodo=${params.get('año')}&cod_doc=${params.get('cod_doc')}&periodo=${params.get('periodo')}&cod_cur=${params.get('cod_cur')}&corte=${seleccion.substring(1)}`)
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