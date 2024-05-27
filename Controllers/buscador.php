<?php
    require_once '../Models/buscador.php';
    class BuscadorControlador{
        private $buscadorModelo;

        public function __construct()
        {
            $this->buscadorModelo = new BuscadorModelo;
        }

        public function estudiantes($texto){
            $estudiantes = $this->buscadorModelo->estudiantes($texto);
            $respuesta = [];
            foreach($estudiantes as $estudiante){
                $respuesta[] = '<tr>'.
                                '<td>'. htmlspecialchars($estudiante['apell_est']) . ' ' . htmlspecialchars($estudiante['nomb_est']) . '</td>'.
                                '<td class="td-cent">'. htmlspecialchars($estudiante['nomb_pro']) . '</td>';
            }
            return $respuesta;
        }

        public function controlarSolicitud(){
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) {

                if(isset($_GET['q'])){
                    $texto = urldecode($_GET['q']);
                }
                if(isset($_GET['buscar'])){
                    $tabla = $_GET['buscar'];
                }
                if($tabla == "estudiante"){
                    header('Content-Type: application/json');
                    echo json_encode($this->estudiantes($texto));
                }
            }else{
                echo "pilas";
            }
        }
    }

    $buscador = new BuscadorControlador;

    $buscador->controlarSolicitud();

?>