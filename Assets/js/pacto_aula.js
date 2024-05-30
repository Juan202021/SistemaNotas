var borrar = false;

function espacioOcupado() {
    var rowspanArray = [];
    var tabla = document.getElementById("pacto_aula");
    var filas = tabla.getElementsByTagName('tr');

    for (var i = 0; i < filas.length; i++) {
        var celdas = filas[i].getElementsByTagName('td');
        if(celdas.length == 5){
            var rowspan = parseInt(celdas[0].getAttribute('rowspan')) || 1;
            rowspanArray.push(rowspan);
        }
    }

    return rowspanArray;
}

function confirmarEditar(event){
    abrirModal(editar,"Esta seguro de editar el pacto de aula", event);
}

function confirmarBorrar(boton){
    abrirModal(activarBorrar, "Estas seguro de que quiere eliminar datos", boton);
}

function borrarDefinitivo(celda){
    if(borrar){
        abrirModal(borrarFila, "Esta seguro de que quiere borrar los datos de esta fila", celda);
    }
}

function confirmarGuardar(event){
    abrirModal(guardar, "Estas seguro de que deseas guardar los datos", event);
}

function confirmacionSalir(){
    abrirModal(salir, "Esta seguro que quiere salir sin guardar los cambios");
}

function editar(event){

    var count = 0;
    var button = event.target;
    var fila = button.closest("tr");
    var tabla = document.getElementById("pacto_aula");
    var espacio = espacioOcupado();
    var filas = tabla.getElementsByTagName('tr');
    for(i = 0; i < espacio.length; i++){
        if(count == fila.rowIndex -1){
            
            count = i;
            
            break;
        }
        count += espacio[i];
    }

    for(i = fila.rowIndex; i < fila.rowIndex + espacio[count]; i++){
        var celdas = filas[i].getElementsByTagName('td');
        
        if(celdas.length == 5){
            celdas[1].setAttribute("contenteditable", "true");
            celdas[2].setAttribute("contenteditable", "true");
            celdas[1].style.backgroundColor = 'rgb(170, 170, 170 )';
            celdas[2].style.backgroundColor = 'rgb(170, 170, 170)';
        }else{
            
            celdas[0].setAttribute("contenteditable", "true");
            celdas[1].setAttribute("contenteditable", "true");
            celdas[0].style.backgroundColor = 'rgb(170, 170, 170)';
            celdas[1].style.backgroundColor = 'rgb(170, 170, 170)';
        }
    }

    var botones = fila.querySelector(".botones");
    botones.innerHTML = '<a href="#" class="save button" onclick="confirmarGuardar(event); return true;">' +
                                '<span class="material-symbols-outlined">' +
                                    'check' +
                                '</span>' +
                                '<span class="tooltip">Guradar</span>' +
                            '</a>'+
                            '<a href="#" class="add2 button" onclick="crear(event); return true;">' +
                                '<span class="material-symbols-outlined">' +
                                    'add' +
                                '</span>' +
                                '<span class="tooltip">Añadir Actividad</span>' +
                            '</a>'+ 
                            '<a href="#" class="delete button" onclick="confirmacionSalir(event); return true;">' +
                                '<span class="material-symbols-outlined">' +
                                    'close' +
                                '</span>' +
                                '<span class="tooltip">Cancelar</span>' +
                            '</a>';
}

function salir(){
    var params = new URLSearchParams(window.location.search);
    var keys = params.keys();
    var nuevaURL = "pacto_aula.php?";
    for (var key of keys) {
        // Obtener el valor del parámetro usando la clave
        var value = params.get(key);
        // Agregar la clave y el valor a la nueva URL
        nuevaURL += encodeURIComponent(key) + "=" + encodeURIComponent(value) + "&";
    }

    // Eliminar el último "&" si no hay más parámetros
    nuevaURL = nuevaURL.slice(0, -1);

    // Redirigir a la nueva página con los parámetros de la URL actual
    window.location.href = nuevaURL;
}

function crear(event){
    var count = 0;
    var button = event.target;
    var fila = button.closest("tr");
    var tabla = document.getElementById("pacto_aula");
    var espacio = espacioOcupado();
    for(i = 0; i < espacio.length; i++){
        if(count == fila.rowIndex -1){
            
            count = i;
            
            break;
        }
        count += espacio[i];
    }
    // Obtén la longitud de las celdas de la fila actual
    var numCeldas = fila.cells.length;

    // Incrementa el rowspan de la primera y última celda de la fila actual
    fila.cells[0].rowSpan += 1;
    fila.cells[numCeldas - 1].rowSpan += 1;
    fila.cells[numCeldas - 2].rowSpan += 1;

    var nuevaFila = tabla.insertRow(fila.rowIndex + espacio[count]);
    for (var j = 0; j < 2; j++) {
        var celda = nuevaFila.insertCell(j);
        celda.className = "td-cent";
        celda.setAttribute("contenteditable", "true");
        if(j == 0){
            celda.setAttribute("cod_info", "0");
            celda.innerText = "Nueva Actividad";
        }
        else{
            celda.innerText = "Nuevo Porcentaje";
        }
        celda.style.backgroundColor = 'rgb(170, 170, 170)';
    }
}

function guardar(event){
    var count = 0;
    var button = event.target;
    var inf_nota = []
    var fila = button.closest("tr");
    var tabla = document.getElementById("pacto_aula");
    var espacio = espacioOcupado();
    var filas = tabla.getElementsByTagName('tr');
    for(i = 0; i < espacio.length; i++){
        if(count == fila.rowIndex -1){
            
            count = i;
            
            break;
        }
        count += espacio[i];
    }
    for(i = fila.rowIndex; i < fila.rowIndex + espacio[count]; i++){
        var celdas = filas[i].getElementsByTagName('td');
        var datosNuevos = {};
        if(celdas.length == 5){
            if(!esNumero(celdas[2].innerText) || celdas[2].innerText == "Nueva Porcentaje"){
                celdas[1].style.backgroundColor = '';
                celdas[2].style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
                return;
            }
            else if(celdas[1].innerText == "Nueva Actividad"){
                celdas[2].style.backgroundColor = '';
                celdas[1].style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
                return;
            }
            celdas[1].setAttribute("contenteditable", "false");
            celdas[2].setAttribute("contenteditable", "false");
            datosNuevos['cod_inf'] = celdas[1].getAttribute("cod_info")
            datosNuevos['corte'] = celdas[0].innerText;
            string = celdas[1].innerText;
            datosNuevos['porcentaje'] = celdas[2].innerText;
            celdas[1].style.backgroundColor = '';
            celdas[2].style.backgroundColor = '';
            if (string.endsWith("\n")) {
                // Eliminar el salto de línea al final
                string = string.trim();
                datosNuevos['detalle'] = string;
            }else{
                datosNuevos['detalle'] = string;
            }
        }else{
            if(!esNumero(celdas[1].innerText) || celdas[1].innerText == "Nueva Porcentaje"){
                celdas[0].style.backgroundColor = '';
                celdas[1].style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
                return;
            }
            else if(celdas[0].innerText == "Nueva Actividad"){
                celdas[1].style.backgroundColor = '';
                celdas[0].style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
                return;
            }
            celdas[0].setAttribute("contenteditable", "flase");
            celdas[1].setAttribute("contenteditable", "false");
            datosNuevos['cod_inf'] = celdas[0].getAttribute("cod_info")
            datosNuevos['corte'] = filas[fila.rowIndex].getElementsByTagName('td')[0].innerText;
            string = celdas[0].innerText;
            datosNuevos['porcentaje'] = celdas[1].innerText;
            celdas[0].style.backgroundColor = '';
            celdas[1].style.backgroundColor = '';
            if (string.endsWith("\n")) {
                // Eliminar el salto de línea al final
                string = string.trim();
                datosNuevos['detalle'] = string;
            }else{
                datosNuevos['detalle'] = string;
            }
        }
        inf_nota.push(datosNuevos);
    }
    enviarDatos(inf_nota, "guardar");
    var botones = fila.querySelector(".botones");
    botones.innerHTML = '<a href="#" class="edit button" onclick="confirmarEditar(event); return false;">' +
                            '<span class="material-symbols-outlined">' +
                                'edit' +
                            '</span>' +
                            '<span class="tooltip">Guardar</span>' +
                        '</a>';
                        setTimeout(function() {
                            location.reload();
                        }, 100);

}

function esNumero(valor) {
    return !isNaN(parseFloat(valor)) && isFinite(valor);
}
function activarBorrar(boton){
    borrar = !borrar;
    boton.innerHTML = '<a href="#" class="delete button" onclick="confirmacionSalir(event); return true;">' +
    '<span class="material-symbols-outlined">' +
        'close' +
    '</span>' +
'</a>';
    var tabla = document.getElementById("pacto_aula");
    var filas = tabla.getElementsByTagName('tr');

    for(i = 1; i < filas.length; i++){
        var celdas = filas[i].getElementsByTagName('td');
        if(celdas.length > 2){
            celdas[1].style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
            celdas[2].style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
        }else{
            celdas[0].style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
            celdas[1].style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
        }
    }
    
}
function borrarFila(celda) {
    if(borrar){
        var fila = celda.parentNode;
        var celdas = fila.cells;
        if(celdas.length > 2){
            enviarDatos(celdas[1].getAttribute("cod_info"), "eliminar");
        }
        else{
            enviarDatos(celdas[0].getAttribute("cod_info"), "eliminar");
        }
        setTimeout(function() {
            location.reload();
        }, 100);
    }
}

function enviarDatos(datos, labor) {
    // Crear un objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    var params = new URLSearchParams(window.location.search);

    var info_notas = {
        labor: labor,
        curso: params.get('cod_cur'),
        datos: datos
    };
    console.log(info_notas);
    // Especificar la URL y el método de la solicitud
    var url = "../Controllers/pacto_aula.php";
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

