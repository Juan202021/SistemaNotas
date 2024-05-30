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

    function getCursos($periodo, $año, $cod_doc){
        $consulta = $this->conn->prepare("SELECT DISTINCT c.cod_cur, c.nomb_cur, i.año, i.periodo FROM curso c 
                                        JOIN inscritos i ON i.cod_cur=c.cod_cur 
                                        WHERE c.cod_doc = :cod_doc AND i.año = :año  AND i.periodo = :periodo 
                                        ORDER BY i.año DESC");
            $consulta->bindParam(':cod_doc', $cod_doc);
            $consulta->bindParam(':año', $año);
            $consulta->bindParam(':periodo', $periodo);
            $consulta->execute();

            if ($consulta->rowCount() > 0){
                while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)){
                    $info_notas[] = [
                        'detalle' => $resultado['detalle'],
                        'cod_inf' => $resultado['cod_inf']
                    ];
                }
            }
            return $info_notas;
    }

}