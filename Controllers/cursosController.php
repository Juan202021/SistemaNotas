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
}