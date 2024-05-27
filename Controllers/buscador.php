<?php
    require_once '../Models/buscador.php';
    class BuscadorControlador{
        private $buscadorModelo;

        public function __construct()
        {
            $this->buscadorModelo = new BuscadorModelo;
        }

        public function estudiantes($texto){
            return $this->buscadorModelo->estudiantes($texto);
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