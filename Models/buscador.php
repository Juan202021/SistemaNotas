<?php
    require_once '../config/conexion.php';

    class BuscadorModelo{
        private $pdo;

        public function __construct()
        {
            $pdo = new ConexionBD;
            $this->pdo = $pdo->getConnection();
        }


        public function estudiantes($texto){
            $estudiantes = [];
            $consulta = $this->pdo->prepare("SELECT DISTINCT e.nomb_est, e.apell_est, p.nomb_pro FROM estudiante e 
                                            JOIN programa p ON p.cod_pro = e.cod_pro 
                                            LEFT JOIN inscritos i ON e.cod_est = i.cod_est
                                            WHERE i.cod_cur IS NULL AND CONCAT(e.nomb_est, ' ', e.apell_est) ILIKE :texto1 OR p.nomb_pro ILIKE :texto2");
            $consulta->bindValue(':texto1' , "%$texto%");
            $consulta->bindValue(':texto2' , "%$texto%");
            $consulta->execute();
            if ($consulta->rowCount() > 0){
                while ($resultado = $consulta->fetch(PDO::FETCH_ASSOC)){
                    $estudiantes[] = [
                        'nomb_est' => $resultado['nomb_est'],
                        'apell_est' => $resultado['apell_est'],
                        'nomb_pro' => $resultado['nomb_pro']
                    ];
                }
            }
            return $estudiantes;
        }

    }
?>