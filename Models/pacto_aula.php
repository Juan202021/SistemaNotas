<?php
    require_once '../config/conexion.php';

    class PactoAulaModelo{
        private $pdo;

        public function __construct(){
            $conexion = new ConexionBD;
            $this->pdo = $conexion->getConnection();
        }

        public function getInfoNotas($cod_cur){
            $detalle = [];
            $porcentaje = [];
            $consulta = $this->pdo->prepare("SELECT DISTINCT i.* FROM info_nota i
                                        JOIN calificacion c ON c.cod_inf = i.cod_inf WHERE cod_cur = :cod_cur
                                        ORDER BY i.corte");
            $consulta->bindParam(':cod_cur', $cod_cur);         
            $consulta->execute();

            if ($consulta->rowCount() > 0){
                while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)){

                    if(isset($detalle[$resultado['corte']-1])){
                        $detalle[$resultado['corte']-1]['cod_inf'][] = $resultado['cod_inf'];
                        $detalle[$resultado['corte']-1]['detalle'][] = $resultado['detalle'];
                        $detalle[$resultado['corte']-1]['porcentaje'][] = $resultado['porcentaje'];
                        $porcentaje[$resultado['corte']-1] += $resultado['porcentaje'] * 100; 
                    }
                    else{
                        $detalle[$resultado['corte']-1] = [
                            'cod_inf' => [$resultado['cod_inf']],
                            'detalle' => [$resultado['detalle']],
                            'porcentaje' => [$resultado['porcentaje']],
                            'porcentajeTotal' => 0
                        ];
                        $porcentaje[$resultado['corte']-1] = $resultado['porcentaje'] * 100; 
                    }
                }
            }
            foreach($porcentaje as $index => $porCorte){
                $detalle[$index]['porcentajeTotal'] = $porCorte; 
            }
            return $detalle;
        }

        public function getInscritos($cod_cur){
            $estudiante =  [];
            $consulta = $this->pdo->prepare("SELECT año, periodo, cod_est FROM inscritos WHERE cod_cur = :cod_cur");
            $consulta->bindParam(':cod_cur' , $cod_cur);
            $exito = $consulta->execute();
            //echo $exito;
            if ($consulta->rowCount() > 0){
                while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)){
                    $estudiante[] = [
                        'cod_est' => $resultado['cod_est'],
                        'periodo' => $resultado['periodo'],
                        'anio' => $resultado['año']
                    ];
                }
            }

            return $estudiante;
        }

        public function getCodInfo($info_notas){
            $detalle = $info_notas['detalle'];
            $porcentaje = $info_notas['porcentaje'] / 100;
            $corte = $info_notas['corte'];
            $consulta = $this->pdo->prepare("INSERT INTO info_nota (detalle, porcentaje, corte) VALUES (:detalle, :porcentaje, :corte) RETURNING cod_inf");
            $consulta->bindParam(':detalle' , $detalle);
            $consulta->bindParam(':porcentaje' , $porcentaje );
            $consulta->bindParam(':corte' , $corte);
            $consulta->execute();
            return $consulta->fetchColumn();
        }

        public function eliminar($cod_inf){
            $consulta = $this->pdo->prepare("DELETE FROM info_nota WHERE cod_inf = :cod_inf");
            $consulta->bindParam(':cod_inf' , $cod_inf );
            $consulta->execute();
        }

        public function editarInfoNotas($info_notas){
            foreach($info_notas as $datos){
                $detalle = $datos['detalle'];
                $porcentaje = $datos['porcentaje'] / 100;
                $cod_inf = $datos['cod_inf'];
                $consulta = $this->pdo->prepare("UPDATE info_nota SET detalle = :detalle, porcentaje = :porcentaje WHERE cod_inf = :cod_inf");
                $consulta->bindParam(':detalle' , $detalle);
                $consulta->bindParam(':porcentaje' , $porcentaje );
                $consulta->bindParam(':cod_inf' , $cod_inf);
                $exito = $consulta->execute();
                //echo $exito;
            }
        }

        public function crearInfoNotas($info_notas, $cod_cur){
            $fecha = date("Y-m-d");
            echo 'hola';
            foreach($info_notas as $info_nota){
                $estudiante = $this->getInscritos($cod_cur);
                $cod_info = $this->getCodInfo($info_nota);
                foreach($estudiante as $inscrito){
                    $cod_est = $inscrito['cod_est'];
                    $anio = $inscrito['anio'];
                    $periodo = $inscrito['periodo'];
                    $nota = 0;
                    $consulta = $this->pdo->prepare("INSERT INTO calificacion (nota, fecha, cod_inf, cod_cur, cod_est, año, periodo) VALUES
                                                        (:nota, :fecha, :cod_info, :cod_cur, :cod_est, :anio, :periodo)");
                    $consulta->bindParam(':nota' , $nota);
                    $consulta->bindParam(':fecha' , $fecha);
                    $consulta->bindParam(':cod_info' , $cod_info);
                    $consulta->bindParam(':cod_cur' , $cod_cur);
                    $consulta->bindParam(':cod_est' , $cod_est);
                    $consulta->bindParam(':anio' , $anio);
                    $consulta->bindParam(':periodo' , $periodo);
                    $exito = $consulta->execute();
                    //echo $exito;
                }
            }
        }
    }

?>