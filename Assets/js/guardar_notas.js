function guardar(){
    var notas = [];
    var tabla = document.getElementById('actualizar_nota');
    var filas = tabla.getElementsByTagName('tr');
    for(var i = 1; i < filas.length; i++){
        var notasNuevas = {};
        var celdas = filas[i].getElementsByTagName('td');
        for(var j = 1; j < celdas.length; j++){
            notasNuevas['cod_est'] = celdas[0].getAttribute("cod_est");
            for(var h = 1; h < celdas.length; h++){
                console.log(celdas[h].innerText);
                notasNuevas['cod_inf'+h] = celdas[h].getAttribute("cod_inf");
                notasNuevas['nota'+h] = celdas[h].innerText;
                if(!esNumero(celdas[h].innerText)){
                    return;
                }
                
            }
        }
        notas.push(notasNuevas);
    }
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
        }
    };

    // Convertir el array de datos a formato JSON
    var datosJSON = JSON.stringify(info_notas);

    // Enviar la solicitud con los datos JSON
    xhr.send(datosJSON);
}