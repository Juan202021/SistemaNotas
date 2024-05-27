<?php
require_once '../Models/editar_notas.php';

class EditarNotasControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new EditarNotasModel;
    }

    public function tabla($curso, $corte){
        $notas = $this->modelo->getNotas($curso, $corte);
        $info_notas = $this->modelo->getInfoNotas($curso, $corte);

        $tabla = [];
        $encabezado = '<thead>' . '<tr>';
        $encabezado .= '<th>Nombre</th>' ;
        foreach($info_notas as $info){
            $encabezado .= '<th>'. $info['detalle'] . '</th>';
        }
        
        $encabezado .='<th style="border: none"> <a href="#" class="delete button" onclick="guardar(); return true;">' .
        '<span class="material-symbols-outlined">' .
            'check' .
        '</span>' .
        '<span class="tooltip">Guradar</span>' .
        '</a></th>';

        $encabezado .= '</thead>' . '</tr>';

        array_push($tabla, $encabezado);

        $cuerpo = '<tbody>';
        for($i = 0; $i < count($notas); $i++){
            $cuerpo .= '<tr>';
            $cuerpo .= '<td style="text-align:center" contenteditable="false" cod_est="'.$notas[$i]['cod_est'].'">'. $notas[$i]['apell_est'] . ' ' . $notas[$i]['nomb_est'] .'</td>';
            for($j = 0; $j < count($info_notas); $j++){
                $cuerpo .= '<td style="text-align:center" contenteditable="true" cod_info="'.$notas[$j]['cod_inf'].'">'. $notas[$i]['nota'] . '</td>';
                $i++;
            }
            $cuerpo .= '<tr>';
        }
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

?>
