function guardar() {
    var notas = [];
    var tabla = document.getElementById('actualizar_nota');
    var filas = tabla.getElementsByTagName('tr');
    for (var i = 0; i < filas.length; i++) { // Start from i = 0 to include header row if exists
        var notasNuevas = {};
        var nota = [];
        var cod_inf = [];
        var celdas = filas[i].getElementsByTagName('td');
        
        if (celdas.length > 0) { // Check if there are cells in the row
            notasNuevas['cod_est'] = celdas[0].getAttribute("cod_est");
            
            for (var j = 1; j < celdas.length; j++) {
                cod_inf.push(celdas[j].getAttribute("cod_inf"));
                nota.push(celdas[j].innerText);
                console.log(j);
                console.log(cod_inf);
            }
            notasNuevas['cod_inf'] = cod_inf;
            notasNuevas['nota'] = nota;
            notas.push(notasNuevas);
            
        }
        
    }
    enviarDatos(notas);
}
function esNumero(valor) {
    return !isNaN(parseFloat(valor)) && isFinite(valor);
}

function enviarDatos(datos) {
    // Crear un objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    var params = new URLSearchParams(window.location.search);

    var info_notas = {
        curso: params.get('cod_cur'),
        datos: datos
    };
    console.log(info_notas);
    // Especificar la URL y el método de la solicitud
    var url = "../Controllers/editar_notas.php";
    xhr.open("POST", url, true);

    // Configurar el tipo de contenido a enviar
    xhr.setRequestHeader("Content-Type", "application/json");

    // Función que se ejecutará cuando la solicitud se complete
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // La solicitud se completó con éxito
            console.log(xhr.responseText);
            //window.location.replace("notas.php?" + );
        }
    };

    // Convertir el array de datos a formato JSON
    var datosJSON = JSON.stringify(info_notas);

    // Enviar la solicitud con los datos JSON
    xhr.send(datosJSON);
}