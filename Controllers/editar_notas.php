<?php
require_once '../Models/editar_notas.php';

class EditarNotasControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new EditarNotasModel;
    }

    public function tabla($curso, $corte) {
        $notas = $this->modelo->getNotas($curso, $corte);
        $info_notas = $this->modelo->getInfoNotas($curso, $corte);
        $index  = 0;
    
        $tabla = [];
        $encabezado = '<thead><tr>';
        $encabezado .= '<th>Cod.</th>';
        $encabezado .= '<th>Nombre</th>';
        foreach($info_notas as $info) {
            $encabezado .= '<th cod_inf="' . $info['cod_inf'] . '">' . $info['detalle'] . '</th>';
        }
    
        $encabezado .= '<th style="border: none"> <a href="#" class="delete button" onclick="pregunta(); return true;">' .
                    '<span class="material-symbols-outlined">check</span>' .
                    '<span class="tooltip">Guardar</span>' .
                    '</a></th>';
        $encabezado .= '</tr></thead>';
        array_push($tabla, $encabezado);
    
        $cuerpo = '<tbody>';
    
        foreach ($notas as $nota) {
            $cuerpo .= '<tr>';
            $cuerpo .= '<td cod_est="' . $nota['cod_est'] . '" align="center">' .$nota['cod_est'].'</td>';
            $cuerpo .= '<td cod_est="' . $nota['cod_est'] . '">' . $nota['apell_est'] . ' ' . $nota['nomb_est'] . '</td>';
    
            for ($i = 0; $i < count($nota['nota']); $i++) {
                if ($nota['cod_inf'][$i] == $info_notas[$i]['cod_inf']) {
                    $cuerpo .= '<td class="td-cent" contenteditable="true" cod_inf="' . $nota['cod_inf'][$i] . '">' . $nota['nota'][$i] . '</td>';
                }
            }
    
            $cuerpo .= '</tr>';
        }
        $cuerpo .= '</tbody>';
        array_push($tabla, $cuerpo);
    
        return $tabla;
    }
    

    public function manejoSolicitud(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener el cuerpo de la solicitud
            $json = file_get_contents('php://input');
            // Decodificar el JSON en un array asociativo
            $notas = json_decode($json, true);
            // Verificar si se decodificó correctamente
            if ($notas !== null) {
                $this->setNotas($notas);
            } else {
                // Error al decodificar JSON
                echo "Error al decodificar JSON";
            }
        }
    }
    
    public function setNotas($notas){
        $this->modelo->setNotas($notas);
    }
    
}

$controlador = new EditarNotasControlador;
$controlador -> manejoSolicitud();

?>
