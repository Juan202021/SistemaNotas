<?php
class calificacionesModel
{
    private $conn;
    function __construct()
    {
        include_once('../config/conexion.php');
        $obj = new ConexionBD();
        $this->conn = $obj->getConnection();
    }
    function readAll_notas($cod_doc, $año, $periodo, $cod_cur)
    {
        $statement = $this->conn->prepare("SELECT e.apell_est, e.nomb_est, inf.porcentaje, ca.nota 
        FROM estudiante e JOIN inscritos i ON i.cod_est=e.cod_est JOIN curso c ON c.cod_cur=i.cod_cur 
        JOIN calificacion ca ON ca.cod_cur=i.cod_cur AND ca.cod_est=i.cod_est AND ca.año=i.año 
        AND ca.periodo=i.periodo JOIN info_nota inf ON inf.cod_inf=ca.cod_inf 
        WHERE i.año=$año AND i.periodo=$periodo AND c.cod_doc=$cod_doc AND c.cod_cur=$cod_cur
        ");
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }
    function notas_corte($cod_doc, $año, $periodo, $cod_cur, $corte)
    {
        $statement = $this->conn->prepare("SELECT e.apell_est, e.nomb_est, 
        ROUND(SUM(ca.nota*inf.porcentaje/0.3)::numeric,1) FROM estudiante e JOIN inscritos i 
        ON i.cod_est=e.cod_est JOIN curso c ON c.cod_cur=i.cod_cur JOIN calificacion ca 
        ON ca.cod_cur=i.cod_cur AND ca.cod_est=i.cod_est AND ca.año=i.año 
        AND ca.periodo=i.periodo JOIN info_nota inf ON inf.cod_inf=ca.cod_inf 
        WHERE i.año=$año AND i.periodo=$periodo AND c.cod_doc=$cod_doc AND c.cod_cur=$cod_cur
        AND inf.corte=$corte GROUP BY e.apell_est,e.nomb_est");
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }
    function coincide($apell_est, $nomb_est, $datos)
    {
        if ($datos){
            foreach ($datos as $data) {
                if ($data['apell_est'] == $apell_est && $data['nomb_est'] == $nomb_est){
                    return $data['round'];
                }
            }
        }
        else {
            return false;
        }
    }
    function definitiva($apell_est, $nomb_est, $datos_corte_1, $datos_corte_2, $datos_corte_3){
        $def = 0;
        $corte1 = $this->coincide($apell_est, $nomb_est, $datos_corte_1);
        $corte2 = $this->coincide($apell_est, $nomb_est, $datos_corte_2);
        $corte3 = $this->coincide($apell_est, $nomb_est, $datos_corte_3);
        $def += ($corte1)? ($corte1*0.3):0;
        $def += ($corte2)? ($corte2*0.3):0;
        $def += ($corte3)? ($corte3*0.4):0;
        return round($def,1);
    }
}
