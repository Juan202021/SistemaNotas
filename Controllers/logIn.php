<?php

    require_once '../config/conexion.php';
    require_once '../Models/logIn.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $pdo = new ConexionBD();
    $inicioM = new inicioM($pdo->getConnection());
    $guardar = true;

    // Verificar si se envió el formulario de inicio de registro
    if(isset($_POST['accion']) && $_POST['accion'] === 'log') {

        //nombre del usuario del formulario html
        $nombres = $_POST['nombres_usuario'];
        //apellido del usuario del formulario html
        $apellidos = $_POST['apellidos_usuario'];
        //corro del usuario del formulario html
        $correo = $_POST['correo'];
        //tipo de usuario del formulario html
        $tipo_usuario = $_POST['tipo_de_usuario'];
        //nombre de usuario del formulario html
        $nomb_usuario = $_POST['nombre_de_usuario'];
        //contraseña del usuario del formulario html
        $contr_user = $_POST['contrasena'];

        $contr_user = $contr_user . $nomb_usuario;

        //encripto la contraseña para guardarla en la base de datos
        $contr_user = hash('sha512', $contr_user);
                    
        //consulto si ya esta registrado el correo
        if($inicioM -> validarCorreo($correo)){
            $_SESSION['correo_existente'] = "El correo ya fue utilizado";
            $_SESSION['guardado'] = "Usuario no guardado";
            $guardar = false;
        }else{
            // Expresión regular para validar la estructura del correo electrónico
            $regex = '/^[a-zA-Z0-9._%+-]+@unillanos\.edu\.co$/';
            // Verificar si el correo electrónico cumple con la expresión regular
            if (!preg_match($regex, $correo)) {
                $_SESSION['correo_existente'] = "Utiliza el correo institucional";
                $guardar = false;
            }
        }
        //echo '<h2>' . $error_log[1] . '</h2>';
        //miro si el nombre del usuario ya existe
        if($inicioM->validarUsuario($nomb_usuario)){
            $_SESSION['usuario_existente'] = "Nombre de usuario existente";
            $_SESSION['guardado'] = "Usuario no guardado";
            $guardar = false;
        }

        if(!$guardar){
            header("Location: ../Views/logIn.php");
            exit();
        }

        //pero la consulta sql para insertar los datos en la base de datos
        $consulta = $inicioM->setUser($nomb_usuario, $contr_user, $tipo_usuario, $correo);
        $id_user = $inicioM->getUltimoId();

        //valido si es un estuidante o un profesor
        if($tipo_usuario == "estudiante"){
            $carrera = $_POST['carrera'];
            //inserto los datos en la tabla estudiantes
            $consulta = $inicioM->setEstudiante($nombres, $apellidos, $id_user, $carrera);
        }
        else{
            $facultad = $_POST['facultad'];
            //guardo los datos en la tabla de profesor
            $consulta = $inicioM->setProfesor($nombres, $apellidos, $id_user, $facultad);
        }

        if($consulta){
            //si la ejecuta se realizo con exito lo mando a la pagina de incio y le notifico que se guardo el usuario
            $_SESSION['guardado'] = "Usuario guardado exitosamente";
            header("Location: ../Views/logIn.php");
            exit();
        }
        else{
            $_SESSION['guardado'] = "Usuario no guardado";
            header("Location: ../Views/logIn.php");
            exit();
        }
    }
    // Verificar si se envió el formulario de inicio de sesión
    else if(isset($_POST['accion']) && $_POST['accion'] === 'login') {
        
        //traemos el usuario del formulario de html
        $usuario = $_POST['usuario'];
        //traemos la contraseña del formulario de html
        $contrasena = $_POST['contrasena'];

        $contrasena = $contrasena . $usuario;
        
        //encriptamos la contraseña para validar si es igual a la que esta en la base de datos encriptada
        $contrasena = hash('sha512', $contrasena);

        //hago la consulta de la contreseña a la base de datos y pongo como condicion el nombre del usuario
        $consulta = $inicioM->getUser($usuario);
        
        //valido si me devolvio alguna consulta
        if($consulta->rowCount() > 0){
            //saco la fila de la cosulta en una variable
            $consulta = $consulta->fetch(PDO::FETCH_ASSOC);
            //valido si las contraseñas son iguales
            if ($contrasena == $consulta["contr_user"]){
                //guardo el usuario que se logeo para poder utilizarlo mas adelante
                $_SESSION['id'] = $inicioM->getId($consulta["cod_user"], $consulta["tipo_user"]);
                echo '<h2>' . $_SESSION['id'] . '</h2>';
                //los mando a el inicio de la web
                header("Location: ../Views/inicio.php");
                exit();
            }else{
                //si no es igual le digo al usuario que no es la contraseña
                $_SESSION['contrasena_incorrecta'] = "contraseña incorrecta";
                header("Location: ../Views/logIn.php");
            
                exit();
            }
        }
        else{
            //le digo al usuario que el usuario no existe
            $_SESSION['usuario_incorrecto'] = "usuario invalido";
            header("Location: ../Views/logIn.php");
            exit();
        }
    }
    $facultades = $inicioM->getFacultades();
    
?>