document.addEventListener('DOMContentLoaded', function() {
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
                    console.log(xhr.responseText);
                }
            };
            xhr.send();
        } else {
            // Limpiar el resultado si el campo de búsqueda está vacío
            resultados.innerHTML = '';
        }
    });
});
