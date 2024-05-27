<?php
require_once '../Models/reporte.php';

class ReporteControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new ReporteModelo();
    }

    public function getInfoNotas($corte, $cod_cur) {
        return $this->modelo->getInfoNotas($corte, $cod_cur);
    }
    
    public function getNotas($cod_inf){
        return $this->modelo->getNotas($cod_inf);
    }

    public function manejarPeticion() {
        if (isset($_GET['corte']) && $_GET['corte'] != '' && isset($_GET['cod_cur']) && $_GET['cod_cur'] != '') {
            header('Content-Type: application/json');
            echo json_encode($this->getInfoNotas($_GET['corte'], $_GET['cod_cur']));
        } else if(isset($_GET['cod_inf']) && $_GET['cod_inf'] != ''){
            header('Content-Type: application/json');
            echo json_encode($this->getNotas($_GET['cod_inf']));
        }
    }
}

// Crear una instancia del controlador y manejar la petición
$controlador = new ReporteControlador();
$controlador->manejarPeticion();
?>
