<?php
class cursosController {
    private $model;
    public function __construct(){
        include_once('/var/www/html/NOTAS/Models/cursosModel.php');
        $this->model = new cursosModel();
    }
    public function readAll($cod_doc){
        try{
            return ($this->model->readAll($cod_doc))? $this->model->readAll($cod_doc):false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}