<?php
class inscritosModel
{
    private $conn;
    function __construct()
    {
        include_once('../config/conexion.php');
        $obj = new ConexionBD();
        $this->conn = $obj->getConnection();
    }
    function readAll_año($cod_doc)
    {
        $statement = $this->conn->prepare("SELECT DISTINCT i.año, i.periodo FROM inscritos i 
        JOIN curso c ON c.cod_cur=i.cod_cur WHERE c.cod_doc=$cod_doc");
        return ($statement->execute())? $statement->fetchAll():false;
    }
    
    // function readAll_cur($cod_doc,$año,$periodo)
    // {
    //     $statement = $this->conn->prepare("SELECT DISTINCT c.nomb_cur FROM curso c 
    //     JOIN inscritos i ON i.cod_cur=c.cod_cur WHERE i.año=$año AND i.periodo=$periodo AND c.cod_doc=$cod_doc");
    //     return ($statement->execute())? $statement->fetchAll():false;
    // }

    function readAll_historico($cod_doc,$cod_cur,$año,$periodo)
    {
        $statement = $this->conn->prepare("select e.apell_est, e.nomb_est, p.nomb_pro,
        round(sum(ca.nota*inf.porcentaje),1) as def from estudiante e 
        join inscritos i on i.cod_est=e.cod_est join curso c on c.cod_cur=i.cod_cur 
        join calificacion ca on ca.cod_est=e.cod_est and ca.cod_cur=c.cod_cur and ca.año=i.año 
        and ca.periodo=i.periodo join info_nota inf on inf.cod_inf=ca.cod_inf join programa p 
        on p.cod_pro=e.cod_pro where c.cod_doc=$cod_doc and c.cod_cur=$cod_cur and i.año=$año 
        and i.periodo=$periodo group by e.apell_est, e.nomb_est, p.nomb_pro
        ");
        return ($statement->execute())? $statement->fetchAll():false;
    }
    function readAll_est($cod_doc,$año,$periodo,$cod_cur)
    {
        $statement = $this->conn->prepare("SELECT e.cod_est, e.apell_est, e.nomb_est, p.nomb_pro, c.nomb_cur FROM inscritos i 
        JOIN curso c ON c.cod_cur=i.cod_cur JOIN estudiante e ON e.cod_est=i.cod_est 
        JOIN docente d ON d.cod_doc=c.cod_doc JOIN programa p ON p.cod_pro=e.cod_pro WHERE c.cod_cur=$cod_cur AND d.cod_doc=$cod_doc 
        AND i.año=$año AND i.periodo=$periodo ORDER BY e.apell_est");
        return ($statement->execute())? $statement->fetchAll():false;
    }
    function readAll_est_no_ins($cod_doc,$año,$periodo,$cod_cur)
    {
        $statement = $this->conn->prepare("SELECT e.apell_est, e.nomb_est, p.nomb_pro, e.cod_est FROM estudiante e 
        JOIN programa p ON p.cod_pro=e.cod_pro WHERE e.cod_est <> ALL (SELECT e.cod_est FROM inscritos i 
        JOIN curso c ON c.cod_cur=i.cod_cur JOIN estudiante e ON e.cod_est=i.cod_est 
        JOIN docente d ON d.cod_doc=c.cod_doc JOIN programa p ON p.cod_pro=e.cod_pro 
        WHERE c.cod_cur=$cod_cur AND d.cod_doc=$cod_doc AND i.año=$año AND i.periodo=$periodo)  ORDER BY e.apell_est");
        return ($statement->execute())? $statement->fetchAll():false;
    }
    function create($año,$periodo,$cod_cur,$cod_est)
    {
        $statement = $this->conn->prepare("INSERT INTO inscritos (año,periodo,cod_cur,cod_est) VALUES($año,$periodo,$cod_cur,$cod_est)");
        // try {
        //     $statement = $this->conn->prepare("INSERT INTO inscritos (año,periodo,cod_cur,cod_est) VALUES(:año,:periodo,:cod_cur,:cod_est)");
        //     $statement->bindParam(":año", $año);
        //     $statement->bindParam(":periodo", $periodo);
        //     $statement->bindParam(":cod_cur", $cod_cur);
        //     $statement->bindParam(":cod_est", $cod_est);
        //     if ($statement->execute()) {
        //         return $cod_est;
        //     } else {
        //         return false;
        //     }
        // } catch (PDOException $e) {
        //     error_log($e->getMessage());
        //     throw $e;
        // }
        return ($statement->execute())? $cod_est: false;
    }
    function delete($cod_cur,$cod_est,$año,$periodo){
        $cant = $this->cant_registros($cod_cur,$año,$periodo);
        if ($cant>1){
            $statement = $this->conn->prepare("DELETE FROM inscritos WHERE cod_cur=$cod_cur AND cod_est=$cod_est AND año=$año AND periodo=$periodo");
            $res = ($statement->execute())? true:false;
        }
        return ($res)? $cant:false;
    }
    function cant_registros($cod_cur,$año,$periodo){
        $statement = $this->conn->prepare("SELECT count(*) FROM inscritos WHERE cod_cur=$cod_cur AND año=$año AND periodo=$periodo");
        return ($statement->execute())? $statement->fetch()['count']:false;
    }
    function find($cod_doc,$año,$periodo,$cod_cur,$nomb_est){
        $statement = $this->conn->prepare("SELECT e.apell_est, e.nomb_est, p.nomb_pro, e.cod_est FROM estudiante e 
        JOIN programa p ON p.cod_pro=e.cod_pro WHERE e.cod_est <> ALL (SELECT e.cod_est FROM inscritos i 
        JOIN curso c ON c.cod_cur=i.cod_cur JOIN estudiante e ON e.cod_est=i.cod_est 
        JOIN docente d ON d.cod_doc=c.cod_doc JOIN programa p ON p.cod_pro=e.cod_pro 
        WHERE c.cod_cur=$cod_cur AND d.cod_doc=$cod_doc AND i.año=$año AND i.periodo=$periodo) 
        AND e.nomb_est ILIKE '$nomb_est%' OR e.apell_est ILIKE '$nomb_est%' ORDER BY e.apell_est");
        return ($statement->execute())? $statement->fetchAll():false;
    }
}