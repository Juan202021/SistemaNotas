<?php 
    /*trae la conexion con la base de datos para poder sacar lo valores necesarios */
    require_once '../Controllers/logIn.php';
    require_once '../config/conexion.php';

    $pdo = new ConexionBD();
    $inicioM = new inicioM($pdo->getConnection());

    //trae el codifo de la facultad elegida
    $facultadSeleccionada = $_GET["facultad"];
    //con le codigo obtenido consultamos en la base de datos para traer las carreras asociadas a la facultad

    $consulta = $inicioM->getCarrera($facultadSeleccionada);
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