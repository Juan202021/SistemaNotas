<?php
class inscritosController {
    private $model;
    public function __construct(){
        include_once('/var/www/html/SistemaNotas/Models/inscritosModel.php');
        $this->model = new inscritosModel();
    }
    public function readAll_año($cod_doc){
        try{
            return ($this->model->readAll_año($cod_doc))? $this->model->readAll_año($cod_doc):false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    // public function readAll_cur($cod_doc,$año,$periodo){
    //     try{
    //         return ($this->model->readAll_cur($cod_doc,$año,$periodo))? $this->model->readAll_cur($cod_doc,$año,$periodo):false;
    //     }catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }
    public function readAll_historico($cod_doc,$cod_cur,$año,$periodo){
        try{
            return ($this->model->readAll_historico($cod_doc,$cod_cur,$año,$periodo))? $this->model->readAll_historico($cod_doc,$cod_cur,$año,$periodo):false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function readAll_est($cod_doc,$año,$periodo,$cod_cur){
        try{
            return ($this->model->readAll_est($cod_doc,$año,$periodo,$cod_cur))? $this->model->readAll_est($cod_doc,$año,$periodo,$cod_cur):false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function readAll_est_no_ins($cod_doc,$año,$periodo,$cod_cur){
        try{
            return ($this->model->readAll_est_no_ins($cod_doc,$año,$periodo,$cod_cur))? $this->model->readAll_est_no_ins($cod_doc,$año,$periodo,$cod_cur):false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function create($año,$periodo,$cod_cur,$cod_est,$cod_doc,$nomb_cur){
        $cod = $this->model->create($año,$periodo,$cod_cur,$cod_est);
        return ($cod!=false)? header("Location:inscribir.php?cod_doc=$cod_doc&año=$año&periodo=$periodo&cod_cur=$cod_cur&nomb_cur=$nomb_cur"):header("Location:inscribir.php?cod_doc=$cod_doc&año=$año&periodo=$periodo&cod_cur=$cod_cur&nomb_cur=$nomb_cur");
    }
    public function delete($cod_cur,$cod_est,$año,$periodo,$cod_doc){
        $cod = $this->model->delete($cod_cur,$cod_est,$año,$periodo);
        return header("Location:inscritos.php?cod_doc=$cod_doc&año=$año&periodo=$periodo&cod_cur=$cod_cur");
    }
}