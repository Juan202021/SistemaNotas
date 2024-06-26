<?php
    session_id(1);
    session_start(); 
    $cod_doc = session_id();
    //$cod_doc = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOTAS UNIVERSIDAD</title>
    <link rel="stylesheet" href="../Assets/css/styles.css">
    <script src="../Assets/js/modal.js"></script>
</head>

<body>
    <header id="header">
        <div class="fondo_blanco">
            <div id="logo">
                <img src="../Assets/imagenes/logo_unillanos.png" alt="Logo Unillanos" style="opacity: 1; visibility: visible;">
            </div>
            <!-- Menú de navegación -->
            <div id="container_menu">
                <div id="menu">
                    <a href="inicio.php?cod_doc=<?= $cod_doc ?>">Inicio</a>
                    <a href="cursos.php?cod_doc=<?= $cod_doc ?>">Cursos</a>
                </div>
            </div>
        </div>
    </header>

    <div id="myModal" class="modal">
        <div class="modal-content"> 
            <div class="arriba_alerta">
                <span class="close">&times;</span>
            </div>
            <p id = "confirmacion" class="centro"></p>
            <div class="abajo_alerta">
                <button id="confirmBtn" class="button_modal">Confirmar</button>
                <button id="cancelBtn" class="button_modal">Cancelar</button>
            </div>
        </div>
    </div>
</body>