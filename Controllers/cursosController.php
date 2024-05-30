<?php
class cursosController {
    private $model;
    public function __construct(){
        include_once('/var/www/html/SistemaNotas/Models/cursosModel.php');
        $this->model = new cursosModel();
    }
    public function readAll($cod_doc){
        try{
            return ($this->model->readAll($cod_doc))? $this->model->readAll($cod_doc):false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function find($cod_doc, $nomb_cur){
        try{
            return ($this->model->find($cod_doc,$nomb_cur))? $this->model->find($cod_doc,$nomb_cur):false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function getCursos($cod_doc, $periodo, $año){
        return $this->getCursos($cod_doc,$periodo, $año);
    }

    public function manejoSolicitud(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener el cuerpo de la solicitud
            $json = file_get_contents('php://input');
            // Decodificar el JSON en un array asociativo
            $notas = json_decode($json, true);
            echo $notas;
            // Verificar si se decodificó correctamente
            $partes = explode("-", $notas);
            if ($notas !== null) {
                echo $this->getCursos($partes[2], $partes[1], $partes[0]);
            } else {
                // Error al decodificar JSON
                echo "Error al decodificar JSON";
            }
        }
    }
}