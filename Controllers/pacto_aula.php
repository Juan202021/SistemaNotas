<?php
    require_once '../Models/pacto_aula.php';

    class PactoAulaControlador{
        private $pactoAula;

        public function __construct(){
            $this->pactoAula = new PactoAulaModelo;
        }

        public function getDatosNotas($cod_cur){
            $orden = [1, 2, 3];
            $info_nota = $this->pactoAula->getInfoNotas($cod_cur);

            // Ordenar el array $info_nota
            usort($info_nota, function ($a, $b) use ($orden){
                $posA = array_search($a['corte'], $orden);
                $posB = array_search($b['corte'], $orden);
                return $posA - $posB;
            });

            // Retornar el array ordenado
            return $info_nota;
        }

        public function getCantidadNotas($info_nota){
            $tamaño = array_fill(0, 3, 0);
            foreach ($info_nota as $elemento){
                if($elemento['corte'] == 1){
                    $tamaño[0]++;
                }else if($elemento['corte'] == 2){
                    $tamaño[1]++;
                }else if($elemento['corte'] == 3){
                    $tamaño[2]++;
                }
            }
            return $tamaño;
        }  

        public function getPorcentaje($info_nota){
            $porcentaje = array_fill(0, 3, 0);
            foreach ($info_nota as $elemento){
                if($elemento['corte'] == 1){
                    $porcentaje[0] += $elemento['porcentaje'] * 100;
                }else if($elemento['corte'] == 2){
                    $porcentaje[1] += $elemento['porcentaje'] * 100;
                }else if($elemento['corte'] == 3){
                    $porcentaje[2] += $elemento['porcentaje'] * 100;
                }
            }
            return $porcentaje;
        }

        public function eliminar($cod_inf){
            echo $cod_inf;
            $this->pactoAula->eliminar($cod_inf);
        }

        public function getInfoNotas($cod_cur){
            $posicion = 0;
            $datos = $this->getDatosNotas($cod_cur);
            $tamaño = $this->getCantidadNotas($datos);
            $porcentaje = $this->getPorcentaje($datos);
            $info_nota = [];

            for($i = 0; $i < 3; $i++){
                if($tamaño[$i] == 0){
                    $tabla = '<tr>'; 
                    $tabla .= '<td class="td-cent">'.($i+1).'</td>';
                    $tabla .= '<td class="td-cent" contenteditable="false" cod_inf="0" onclick="borrarFila(this)">Nueva Actividad</td>';
                    $tabla .= '<td class="td-cent" contenteditable="false" onclick="borrarFila(this)">Nuevo Porcentaje</td>';
                    $tabla .= '<td class="td-cent">'.$porcentaje[$i].'</td>';
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
                    $tabla .= '<td class="td-cent" rowspan="'.$tamaño[$i].'"> '.($i+1).'</td>';
                    for($j = 0; $j < $tamaño[$i]; $j++){
                        $tabla .= '<td class="td-cent" contenteditable="false" cod_info="'.$datos[$posicion]['cod_inf'].'" onclick="borrarFila(this)">'.$datos[$posicion]['detalle'].'</td>';
                        $tabla .= '<td class="td-cent" contenteditable="false" onclick="borrarFila(this)">'.($datos[$posicion]['porcentaje'] * 100).'</td>';
                        if($j == 0){
                            $tabla .= '<td class="td-cent" rowspan="'.$tamaño[$i].'">'.$porcentaje[$i].'</td>';
                            $tabla .= '<td rowspan="'.$tamaño[$i].'" class="td-der botones">
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
                        // Incrementa la posición en cada iteración del bucle interno
                        $posicion++;
                        if($j < $tamaño[$i]-1){
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