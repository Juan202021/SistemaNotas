document.addEventListener("DOMContentLoaded", function() {
    
    var periodo = document.getElementById("f2");

    periodo.addEventListener("change", function(){

        enviarDatos(periodo.value);

    });
});

function enviarDatos(datos) {
    // Crear un objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    var params = new URLSearchParams(window.location.search);
    datos += "-" + params.get('cod_doc');

    // Especificar la URL y el método de la solicitud
    var url = "../Controllers/cursosController.php";
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
    var datosJSON = JSON.stringify(datos);

    // Enviar la solicitud con los datos JSON
    xhr.send(datosJSON);
}