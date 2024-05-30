<?php
    require_once '../Models/pacto_aula.php';

    class PactoAulaControlador{
        private $pactoAula;

        public function __construct(){
            $this->pactoAula = new PactoAulaModelo;
        }

        public function getDatosNotas($cod_cur){
            return $this->pactoAula->getInfoNotas($cod_cur);
        }

        public function eliminar($cod_inf){
            echo $cod_inf;
            $this->pactoAula->eliminar($cod_inf);
        }

        public function getInfoNotas($cod_cur){
            $datos = $this->getDatosNotas($cod_cur);
            $info_nota = [];

            for($i = 0; $i < 3; $i++){
                if(!isset($datos[$i])){
                    $tabla = '<tr>'; 
                    $tabla .= '<td class="td-cent">'.($i+1).'</td>';
                    $tabla .= '<td class="td-cent" contenteditable="false" cod_inf="0" onclick="borrarFila(this)">Nueva Actividad</td>';
                    $tabla .= '<td class="td-cent" contenteditable="false" onclick="borrarFila(this)">Nuevo Porcentaje</td>';
                    $tabla .= '<td class="td-cent">0</td>';
                    $tabla .= '<td class="td-der botones">
                                    <a href="#" class="delete button" onclick="editar(event); return false;">
                                        <span class="material-symbols-outlined">
                                            edit
                                        </span>
                                        <span class="tooltip">Editar</span>
                                    </a>
                                    <a href="#" class="delete button" onclick="activarBorrar(); return false;">
                                        <span class="material-symbols-outlined">
                                            delete
                                        </span>
                                        <span class="tooltip">Eliminar</span>
                                    </a>
                                </td>';
                    $tabla .= '</tr>'; 
                }else{
                    $tabla = '<tr>'; 
                    $tabla .= '<td class="td-cent" rowspan="'.count($datos[$i]['detalle']).'"> '.($i+1).'</td>';
                    for($j = 0; $j < count($datos[$i]['detalle']); $j++){
                        $tabla .= '<td class="td-cent" contenteditable="false" cod_info="'.$datos[$i]['cod_inf'][$j].'" onclick="borrarFila(this)">'.$datos[$i]['detalle'][$j].'</td>';
                        $tabla .= '<td class="td-cent" contenteditable="false" onclick="borrarFila(this)">'.($datos[$i]['porcentaje'][$j] * 100).'</td>';
                        if($j == 0){
                            $tabla .= '<td class="td-cent" rowspan="'.count($datos[$i]['detalle']).'">'.$datos[$i]['porcentajeTotal'].'</td>';
                            $tabla .= '<td rowspan="'.count($datos[$i]['detalle']).'" class="td-der botones">
                                            <a href="#" class="delete button" onclick="editar(event); return false;">
                                                <span class="material-symbols-outlined">
                                                    edit
                                                </span>
                                                <span class="tooltip">Editar</span>
                                            </a>
                                            <a href="#" class="delete button" onclick="activarBorrar(); return false;">
                                                <span class="material-symbols-outlined">
                                                    delete
                                                </span>
                                                <span class="tooltip">Eliminar</span>
                                            </a>
                                        </td>';
                        }
                        $tabla .= '</tr>'; 
                        if($j < count($datos[$i]['detalle'])-1){
                            $tabla .= '<tr>'; 
                        }
                        
                    }
                    
                }
                $info_nota[] = $tabla;
            }
            return $info_nota;
        }

        public function manejoSolicitud(){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $crear = [];
                $guardar = [];
                // Obtener el cuerpo de la solicitud
                $json = file_get_contents('php://input');

                // Decodificar el JSON en un array asociativo
                $infoNotas = json_decode($json, true);
                // Verificar si se decodificó correctamente
                if ($infoNotas !== null) {
                    if($infoNotas['labor'] == "guardar"){
                        for($i = 0; $i < count($infoNotas['datos']); $i++){
                            if($infoNotas['datos'][$i]['cod_inf'] == 0){
                                
                                array_push($crear, $infoNotas['datos'][$i]);
                            } else{
                                array_push($guardar, $infoNotas['datos'][$i]);
                            }
                        }

                        if(count($guardar) != 0){
                            // Procesar los datos
                            $this->editarInfoNotas($guardar);
                        }
                        if(count($crear) != 0){
                            echo 'datos a crear';
                            $this->crearInfoNotas($crear, $infoNotas['curso']);
                        }
                    }else{
                        $this->eliminar($infoNotas['datos']);
                    }
                    
                } else {
                    // Error al decodificar JSON
                    echo "Error al decodificar JSON";
                }
            }
        }

        public function editarInfoNotas($infoNotas){
            $this->pactoAula->editarInfoNotas($infoNotas);
        }

        public function crearInfoNotas($infoNotas, $curso){
            $this->pactoAula->crearInfoNotas($infoNotas, $curso);
        }
    }

    $pactoAula = new PactoAulaControlador;
    $pactoAula->manejoSolicitud();
?>