<?php
class cursosModel
{
    private $conn;
    function __construct()
    {
        include_once('../config/conexion.php');
        $obj = new ConexionBD();
        $this->conn = $obj->getConnection();
    }
    function readAll($cod_doc)
    {
        $statement = $this->conn->prepare("SELECT DISTINCT c.cod_cur, c.nomb_cur, i.año, i.periodo FROM curso c 
        JOIN inscritos i ON i.cod_cur=c.cod_cur WHERE c.cod_doc=$cod_doc ORDER BY i.año DESC");
        return ($statement->execute())? $statement->fetchAll():false;
    }
    function find($cod_doc,$nomb_cur){
        $statement = $this->conn->prepare("SELECT DISTINCT c.cod_cur, c.nomb_cur, i.año, i.periodo FROM curso c 
        JOIN inscritos i ON i.cod_cur=c.cod_cur WHERE c.cod_doc=$cod_doc AND c.nomb_cur ILIKE '$nomb_cur%' ORDER BY i.año DESC");
        return ($statement->execute())? $statement->fetchAll():false;
    }
}