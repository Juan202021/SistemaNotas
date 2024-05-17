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
        JOIN inscritos i ON i.cod_cur=c.cod_cur WHERE c.cod_doc=$cod_doc");
        return ($statement->execute())? $statement->fetchAll():false;
    }
}