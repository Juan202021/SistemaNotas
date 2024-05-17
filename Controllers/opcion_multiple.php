<?php 
    /*trae la conexion con la base de datos para poder sacar lo valores necesarios */
    require '../modelo/conexion_bd.php';

    //trae el codifo de la facultad elegida
    $facultadSeleccionada = $_GET["facultad"];
    //con le codigo obtenido consultamos en la base de datos para traer las carreras asociadas a la facultad
    
    $consulta = $pdo->query("SELECT cod_pro, nomb_pro FROM programa WHERE cod_fac = " . $facultadSeleccionada);
    //validamos que la consulta me devolvio algo para asi mostrarlo por pantalla
    if ($consulta->rowCount() > 0) {
        //sacamos fila por fila de lo que me devolvio la consulta
        while($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
            //sacamos por pantalla todas las filas de la consulta para que sea elegido
            echo "<option value='" . $fila["cod_pro"] . "'>" . $fila["nomb_pro"] . "</option>";
        }
    } else {
        //si no tenemos filas es porque no tenemos carreras asociadas a la facultad 
        echo "<option value='' disabled>No hay carreras disponibles para esta facultad</option>";
    }

    $pdo = null;
?>