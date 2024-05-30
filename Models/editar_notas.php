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
        
        public function getNotas($cod_cur, $corte) {
            $datos = [];
            $consulta = $this->pdo->prepare("SELECT c.nota, e.nomb_est, e.apell_est, i.cod_inf, e.cod_est 
                                            FROM calificacion c 
                                            JOIN info_nota i ON  i.cod_inf = c.cod_inf
                                            JOIN estudiante e ON e.cod_est = c.cod_est
                                            WHERE i.corte = :corte and c.cod_cur = :cod_cur
                                            ORDER BY e.apell_est");
            $consulta->bindParam(':corte', $corte);
            $consulta->bindParam(':cod_cur', $cod_cur);
            $consulta->execute();
            
            if ($consulta->rowCount() > 0) {
                while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $posicion = -1;
                    foreach ($datos as $index => $dato) {
                        if ($resultado['cod_est'] == $dato['cod_est']) {
                            $posicion = $index;
                            break;
                        }
                    }
                    if ($posicion != -1) {
                        $datos[$posicion]['nota'][] = $resultado['nota'];
                        $datos[$posicion]['cod_inf'][] = $resultado['cod_inf'];
                        // Ordenar el array de cod_inf y sincronizar el array de notas
                        array_multisort($datos[$posicion]['cod_inf'], SORT_ASC, $datos[$posicion]['nota']);
                    } else {
                        $nota = [];
                        $info =  [];
                        $nota[] = $resultado['nota'];
                        $info[] = $resultado['cod_inf'];
                        $datos[] = [
                            'nota' => $nota,
                            'nomb_est' => $resultado['nomb_est'],
                            'apell_est' => $resultado['apell_est'],
                            'cod_inf' => $info,
                            'cod_est' => $resultado['cod_est']
                        ];
                    }
                }
            }
            return $datos;
        }
        

        public function getInfoNotas($cod_cur, $corte){
            $info_notas = [];
            $consulta = $this->pdo->prepare("SELECT DISTINCT i.detalle, i.cod_inf FROM calificacion c 
                                            JOIN info_nota i ON  i.cod_inf = c.cod_inf
                                            JOIN estudiante e ON e.cod_est = c.cod_est
                                            WHERE i.corte = :corte and c.cod_cur = :cod_cur
                                            ORDER BY i.cod_inf ASC");
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
        
        for($i = 0; $i < count($notas['datos']); $i++){
            $cod_est = $notas['datos'][$i]['cod_est'];
            for($j = 0; $j < count($notas['datos'][$i]['nota']); $j++){
                $cod_inf = $notas['datos'][$i]['cod_inf'][$j]; 
                $nota = $notas['datos'][$i]['nota'][$j]; 

                $consulta = $this->pdo->prepare("UPDATE calificacion SET nota = :nota 
                                                WHERE cod_est = :cod_est and cod_inf = :cod_inf");
                $consulta->bindParam(':nota' , $nota);
                $consulta->bindParam(':cod_est' , $cod_est);
                $consulta->bindParam(':cod_inf' , $cod_inf);
                $consulta->execute();
            }
        }
    }
}

?>