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

    }

?>