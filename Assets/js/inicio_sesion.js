//eventos para realizar el movimiento de login a log y de acomododar las cajas en las pantallas
document.getElementById("bt_log").addEventListener("click", log);
document.getElementById("bt_login").addEventListener("click", login);
window.addEventListener("resize", anchoPagina);

//variables
var caja_login_log = document.querySelector(".caja_login-log");
var form_login = document.querySelector(".form_login");
var form_log = document.querySelector(".form_log");
var caja_trasera_login = document.querySelector(".caja_trasera_login");
var caja_trasera_log = document.querySelector(".caja_trasera_log");

//logica para mover de manera correcta las cajas en cualquier tamano de pantalla
function anchoPagina(){
    if(window.innerWidth > 896){
        caja_trasera_login.style.display = "block";
        caja_trasera_log.style.display = "block";
        caja_login_log.style.top = "-20.7rem";
    }
    else{
        caja_trasera_login.style.display = "block";
        caja_login_log.style.opacity = "1";
        caja_trasera_log.style.display = "block";
        caja_trasera_log.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        form_login.style.display = "block";
        form_log.style.display = "none";
        caja_login_log.style.left = "0px";
        caja_login_log.style.top = "0";
    }
}

anchoPagina();

function log(){
    if(window.innerWidth > 896){
        form_log.style.display = "block";
        caja_login_log.style.left = "41rem";
        form_login.style.display = "none";
        caja_trasera_log.style.opacity = "0";
        caja_trasera_login.style.opacity = "1";
        caja_login_log.style.top = "-20.7rem";
    }
    else{
        form_log.style.display = "block";
        caja_login_log.style.left = "0rem";
        form_login.style.display = "none";
        caja_trasera_log.style.display = "none";
        caja_trasera_login.style.display = "block";
        caja_trasera_login.opacity = "1";
        caja_login_log.style.top = "30rem";
    }
}

function login(){
    if(window.innerWidth > 896){
        form_log.style.display = "none";
        caja_login_log.style.left = "1rem";
        form_login.style.display = "block";
        caja_trasera_log.style.opacity = "1";
        caja_trasera_login.style.opacity = "0";
        caja_login_log.style.top = "-20.5rem";
    }
    else{
        form_log.style.display = "none";
        caja_login_log.style.left = "0rem";
        form_login.style.display = "block";
        caja_login_log.style.top = "0rem";
        caja_trasera_log.style.display = "block";
        caja_trasera_login.style.display = "none";
    }
}


var opcionCarrera = document.getElementById("carrera");

document.getElementById("facultad").addEventListener("change", listadoCarreras);

function listadoCarreras(){
    var facultadSeleccionada = document.getElementById("facultad").value;

    opcionCarrera.innerHTML = "  <option value='' disabled selected>seleccione su carrera</option>";

    var solicitudCarreras = new XMLHttpRequest();

    solicitudCarreras.onreadystatechange = function(){
        if (solicitudCarreras.readyState == 4 && solicitudCarreras.status == 200) {
            opcionCarrera.innerHTML += solicitudCarreras.responseText;
        }
    };

    solicitudCarreras.open("GET", "php/controlador/opcion_multiple.php?facultad=" + facultadSeleccionada, true);
    solicitudCarreras.send();
}

document.getElementById("estudiante").addEventListener("change", mostrar_carreras);
document.getElementById("docente").addEventListener("change", desactivar_carreras);

var carreras = document.getElementById("carrera");

function mostrar_carreras(){
    opcionCarrera.style.display = "block";
    carreras.required =  true;
}

function desactivar_carreras(){
    opcionCarrera.style.display = "none";
    carreras.required =  false;
}

function limpiarFormulario() {
    document.getElementById("iniciar").reset();
    document.getElementById("iniciar").reset();
}

window.onload = limpiarFormulario()


 // Limpia el formulario cuando la página se vuelva a cargar
window.addEventListener("pageshow", function(event) {
    document.getElementById("iniciar").reset();
    document.getElementById("iniciar").reset();

});