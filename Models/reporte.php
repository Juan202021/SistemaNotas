<?php
    require_once '../config/conexion.php';

    class ReporteModelo{
        private $pdo;

        public function __construct(){
            $conexion = new ConexionBD;
            $this->pdo = $conexion->getConnection();
        }

        public function getInfoNotas($corte, $cod_cur){
            $detalle = [];
            $consulta = $this->pdo->prepare("SELECT DISTINCT i.cod_inf, i.detalle FROM info_nota i
                        JOIN calificacion c ON c.cod_inf = i.cod_inf WHERE cod_cur = :cod_cur AND  corte = :corte");
            $consulta->bindParam(':cod_cur', $cod_cur);
            $consulta->bindParam(':corte', $corte);            
            $consulta->execute();
            if ($consulta->rowCount() > 0){
                while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)){
                    $detalle[] = [
                        'value' => $resultado['cod_inf'],
                        'text' => $resultado['detalle']
                    ];
                }
            }
            return $detalle;
        }

        public function getNotas($cod_inf){
            $detalle = [];
            $consulta = $this->pdo->prepare("SELECT nota FROM calificacion
                        WHERE cod_inf = :cod_inf
                        ORDER BY nota DESC");
            $consulta->bindParam(':cod_inf', $cod_inf);           
            $consulta->execute();
            if ($consulta->rowCount() > 0){
                while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)){
                    $detalle[] = $resultado['nota'];
                }
            }
            return $detalle;
        }

        public function getDefNotas($anio, $periodo, $cod_doc, $cod_cur, $corte) {
            $notas = [];
            // Preparar la consulta SQL con parámetros
            if($corte == 4){
                
                $consulta = $this->pdo->prepare(
                    "SELECT 
                        definitiva_curso
                    FROM 
                        vdefinitiva_curso 
                    WHERE 
                        cod_cur = :cod_cur"
                );
                // Ejecutar la consulta con los valores proporcionados
                $consulta->execute([
                    ':cod_cur' => $cod_cur,
                ]);
                // Verificar si hay resultados y obtenerlos
                if ($consulta->rowCount() > 0) {
                    $notas = $consulta->fetchAll(PDO::FETCH_COLUMN, 0);
                }
            
                return $notas;
                
            }else if($corte != 3){
                $consulta = $this->pdo->prepare(
                    "SELECT 
                        ROUND(SUM(ca.nota * inf.porcentaje / 0.3)::numeric, 1) AS definitiva 
                    FROM 
                        estudiante e 
                    JOIN 
                        inscritos i ON i.cod_est = e.cod_est 
                    JOIN 
                        curso c ON c.cod_cur = i.cod_cur 
                    JOIN 
                        calificacion ca ON ca.cod_cur = i.cod_cur AND ca.cod_est = i.cod_est AND ca.año = i.año AND ca.periodo = i.periodo 
                    JOIN 
                        info_nota inf ON inf.cod_inf = ca.cod_inf 
                    WHERE 
                        i.año = :anio 
                        AND i.periodo = :periodo 
                        AND c.cod_doc = :cod_doc 
                        AND c.cod_cur = :cod_cur 
                        AND inf.corte = :corte 
                    GROUP BY 
                        e.apell_est, e.nomb_est"
                );
            }else if($corte == 3){
                $consulta = $this->pdo->prepare(
                    "SELECT 
                        ROUND(SUM(ca.nota * inf.porcentaje / 0.4)::numeric, 1) AS definitiva 
                    FROM 
                        estudiante e 
                    JOIN 
                        inscritos i ON i.cod_est = e.cod_est 
                    JOIN 
                        curso c ON c.cod_cur = i.cod_cur 
                    JOIN 
                        calificacion ca ON ca.cod_cur = i.cod_cur AND ca.cod_est = i.cod_est AND ca.año = i.año AND ca.periodo = i.periodo 
                    JOIN 
                        info_nota inf ON inf.cod_inf = ca.cod_inf 
                    WHERE 
                        i.año = :anio 
                        AND i.periodo = :periodo 
                        AND c.cod_doc = :cod_doc 
                        AND c.cod_cur = :cod_cur 
                        AND inf.corte = :corte 
                    GROUP BY 
                        e.apell_est, e.nomb_est"
                );
            }
        
            // Ejecutar la consulta con los valores proporcionados
            $consulta->execute([
                ':anio' => $anio,
                ':periodo' => $periodo,
                ':cod_doc' => $cod_doc,
                ':cod_cur' => $cod_cur,
                ':corte' => $corte,
            ]);
        
            // Verificar si hay resultados y obtenerlos
            if ($consulta->rowCount() > 0) {
                $notas = $consulta->fetchAll(PDO::FETCH_COLUMN, 0);
            }
        
            return $notas;
        }
        

    }

?>