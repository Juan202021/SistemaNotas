<?php
    session_id(1);
    session_start(); 
    $cod_doc = session_id();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOTAS UNIVERSIDAD</title>
    <link rel="stylesheet" href="../Assets/css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#nomb_cur").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $.ajax({
                    url: "loader.php",
                    type: "POST",
                    data: {query: value},
                    success: function(response) {
                        $("#content").html(response);
                    }
                });
            });
        });
    </script>
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
                    <a href="#">Estadísticas</a>
                </div>
            </div>
        </div>
    </header>
    