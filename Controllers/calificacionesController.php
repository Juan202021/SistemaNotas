<?php
class calificacionesController {
    private $model;
    public function __construct(){
        include_once('/var/www/html/SistemaNotas/Models/calificacionesModel.php');
        $this->model = new calificacionesModel();
    }
    public function readAll_notas($cod_doc,$año,$periodo,$cod_cur){
        try{
            return ($this->model->readAll_notas($cod_doc,$año,$periodo,$cod_cur))? $this->model->readAll_notas($cod_doc,$año,$periodo,$cod_cur):false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function notas_corte($cod_doc,$año,$periodo,$cod_cur,$corte){
        try{
            return ($this->model->notas_corte($cod_doc,$año,$periodo,$cod_cur,$corte))? $this->model->notas_corte($cod_doc,$año,$periodo,$cod_cur,$corte):false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function coincide($apell_est, $nomb_est, $datos){
        try{
            return ($this->model->coincide($apell_est, $nomb_est, $datos))? $this->model->coincide($apell_est, $nomb_est, $datos):false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function definitiva($apell_est, $nomb_est, $datos_corte_1, $datos_corte_2, $datos_corte_3){
        try{
            return ($this->model->definitiva($apell_est, $nomb_est, $datos_corte_1, $datos_corte_2, $datos_corte_3))? $this->model->definitiva($apell_est, $nomb_est, $datos_corte_1, $datos_corte_2, $datos_corte_3):false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}