<?php
    class EditarNotasModel
    {
        private $pdo;

        function __construct()
        {
            include_once('../config/conexion.php');
            $obj = new ConexionBD();
            $this->pdo = $obj->getConnection();
        }
        
        public function getNotas($cod_cur, $corte){
            $notas = [];
            $consulta = $this->pdo->prepare("SELECT c.nota, e.nomb_est, e.apell_est, i.cod_inf, e.cod_est FROM calificacion c 
                                            JOIN info_nota i ON  i.cod_inf = c.cod_inf
                                            JOIN estudiante e ON e.cod_est = c.cod_est
                                            WHERE i.corte = :corte and c.cod_cur = :cod_cur
                                            ORDER BY e.nomb_est, e.apell_est");
            $consulta->bindParam(':corte' , $corte);
            $consulta->bindParam(':cod_cur', $cod_cur);
            $consulta->execute();
            if ($consulta->rowCount() > 0){
                while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)){
                    $notas[] = [
                        'nota' => $resultado['nota'],
                        'nomb_est' => $resultado['nomb_est'],
                        'apell_est' => $resultado['apell_est'],
                        'cod_inf' => $resultado['cod_inf'],
                        'cod_est' => $resultado['cod_est']
                    ];
                }
            }
            return $notas;
        }

        public function getInfoNotas($cod_cur, $corte){
            $info_notas = [];
            $consulta = $this->pdo->prepare("SELECT DISTINCT i.detalle, i.cod_inf FROM calificacion c 
                                            JOIN info_nota i ON  i.cod_inf = c.cod_inf
                                            JOIN estudiante e ON e.cod_est = c.cod_est
                                            WHERE i.corte = :corte and c.cod_cur = :cod_cur");
            $consulta->bindParam(':corte' , $corte);
            $consulta->bindParam(':cod_cur' , $cod_cur );
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

        public function setNotas($notas){
            for( $i = 0; $i < count($notas); $i++){
                $cod_inf = $notas[$i]['cod_inf'+1+$i];
                $cod_est = $notas[$i]['notas'+1+$i];
                echo $cod_est;
                echo $cod_inf;
                $consulta = $this->pdo->prepare("UPDATE calificacion SET nota = :nota 
                                            WHERE cod_est = :cod_est and cod_inf = :cod_inf");
                $consulta->bindParam(':cod_est' , $cod_est);
                $consulta->bindParam(':cod_inf' , $cod_inf);
                $consulta->execute();
            }
        }

    }
?>