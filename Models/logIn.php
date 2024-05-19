<?php
    
    class inicioM{
        private $pdo;
        
        public function __construct($pdo){
            $this -> pdo = $pdo;
        }

        public function getUser($usuario){
            return $this -> pdo -> query("SELECT cod_user, nomb_user, contr_user, tipo_user FROM usuario WHERE nomb_user ='$usuario'");
        }

        public function setUser($nomb_usuario, $contr_user, $tipo_usuario, $correo){
            $consulta = $this->pdo->prepare("INSERT INTO usuario(nomb_user, contr_user, tipo_user, correo) 
                                        VALUES (:nomb_user, :contr_user, :tipo_user, :correo)"); 
            //ejecuto la consulta sql y cambio los valores por lo valores reales
            $consulta->execute(array(':nomb_user' => $nomb_usuario, ':contr_user' => $contr_user, ':tipo_user' => $tipo_usuario, ':correo' => $correo));
            
            if($consulta){
                return true;
            }

            return false;
        }

        public function setEstudiante($nombres, $apellidos, $id_user, $carrera){
             //inserto los datos en la tabla estudiantes
            $consulta = $this->pdo->prepare("INSERT INTO estudiante(nomb_est, apell_est, cod_user, cod_pro)
                                            VALUES (:nomb_est, :apell_est, :cod_user, :cod_pro)");
            //pido la carrera que esta en el formulario html
            $carrera = $_POST['carrera'];
            //ejecuto la consulta
            $consulta->execute(array(':nomb_est' => $nombres, ':apell_est' => $apellidos, ':cod_user' => $id_user, ':cod_pro' => $carrera));
            
            if($consulta){
                return true;
            }

            return false;
        }

        public function setProfesor($nombres, $apellidos, $id_user, $facultad){
            //guardo los datos en la tabla de profesor
            $consulta = $this->pdo->prepare("INSERT INTO docente(nomb_doc, apell_doc, cod_user, cod_fac)
                                        VALUES (:nomb_doc, :apell_doc, :cod_user, :cod_fac)");
            //pido la faculta a la que pertenece que esta en el formulario de html
            $facultad = $_POST['facultad'];
            //ejecuto la consulta
            $consulta->execute(array(':nomb_doc' => $nombres, ':apell_doc' => $apellidos, ':cod_user' => $id_user, ':cod_fac' => $facultad));
            
            if($consulta){
                return true;
            }

            return false;
        }

        public function validarCorreo($correo) {
            $statement = $this->pdo->prepare("SELECT correo FROM usuario WHERE correo = :correo");
            $statement->bindParam(':correo', $correo);
            $statement->execute();
            return $statement->rowCount() > 0;
        }

        public function validarUsuario($usuario) {
            $statement = $this->pdo->prepare("SELECT nomb_user FROM usuario WHERE nomb_user = :usuario");
            $statement->bindParam(':usuario', $usuario);
            $statement->execute();
            return $statement->rowCount() > 0;
        }

        public function getUltimoId(){
            return $this->pdo->lastInsertId();
        }

        public function getCarrera($facultad){
            
            return $this->pdo->query("SELECT cod_pro, nomb_pro FROM programa WHERE cod_fac = $facultad ");
        }

        public function getFacultades() {
            $facultades = array();

            $consulta = $this->pdo->query("SELECT cod_fac, nomb_fac FROM facultad");
            while($fila = $consulta->fetch(PDO::FETCH_ASSOC)){
                $facultades[] = $fila;
            }

            return $facultades;
        }
    }
?>