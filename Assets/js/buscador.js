document.addEventListener('DOMContentLoaded', function() {
    // Obtener la URL actual
    var urlParams = new URLSearchParams(window.location.search);

    // Obtener el valor de un parámetro específico
    var cod_est = urlParams.get('cod_est');
    var cod_cur = urlParams.get('cod_cur');
    var año = urlParams.get('año');
    var periodo = urlParams.get('periodo');
    var cod_doc = urlParams.get('cod_doc');
    var nomb_cur = urlParams.get('nomb_cur');
    var input = document.getElementById('buscarInput');
    var resultados = document.getElementById('resultadoBusqueda');
    console.log("sirve");
    input.addEventListener('input', function() {
        var valor = this.value.trim(); // Obtener el valor del input y eliminar espacios en blanco
        var tabla = "estudiante";
        if (valor.length > 0) {
            // Realizar una solicitud AJAX al servidor para buscar productos en tiempo real
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../Controllers/buscador.php?q=' + encodeURIComponent(valor) + "&buscar=" + tabla, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Mostrar los resultados de la búsqueda en el elemento resultadoBusqueda
                    var datos = JSON.parse(xhr.responseText); // Convertir la respuesta JSON en un objeto JavaScript
                    // Limpiar el contenido anterior
                    resultados.innerText = '';
                    resultados.innerHTML = '';
                    // Iterar sobre los resultados y agregarlos al elemento resultadoBusqueda
                    datos.forEach(element => {
                        resultados.innerHTML += element + '<td><a href="inscribir_inter.php?cod_est=' + cod_est + '&cod_cur=' + cod_cur + '&año=' + año + '&periodo=' + periodo + '&cod_doc=' + cod_doc + '&nomb_cur=' + nomb_cur + '" class="add button"><span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path></svg><span class="tooltip">Agregar</span></span></a></td>';

                    });
                }
            };
            xhr.send();
        } else {
            // Limpiar el resultado si el campo de búsqueda está vacío
            location.reload();
        }
    });
});
