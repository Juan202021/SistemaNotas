<?php require_once '../Controllers/logIn.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Assets/css/logIn.css">
</head>
<body>
    
    <main>
        <!--Contenedor principal-->
        <div class="contenedor_principal">
            
            <!--Caja de atras-->
            <div class="caja_trasera">
                
                <!--Caja de inicio de sesion-->
                <div class="caja_trasera_login">
                    <h3>¿Ya tienes cuenta?</h3>
                    <p>inicia sesión para continuar</p>
                    <button class="bt_tracero" id="bt_login">Iniciar sesión</button>
                </div>

                <!--Caja registro-->
                <div class="caja_trasera_log">
                    <h3>¿Aun no tienes cuenta?</h3>
                    <p>Registrate para que puedas iniciar sesión</p>
                    <button class="bt_tracero" id="bt_log">Registrarse</button>
                </div>
            </div>

            <!--Caja principal-->
            <div class="caja_login-log">
                
                <!--formulario de inicio de sesion-->
                <form id="iniciar" action="../Controllers/logIn.php" method="POST" class="form_login">
                    <h2>Iniciar sesión</h2>
                    <?php if(isset($_SESSION['guardado'])) { ?>
                        <p class="error centrar"> <?=$_SESSION['guardado']?> </p>
                    <?php 
                        unset($_SESSION['guardado']);
                    } 
                    ?>
                    <!--Usuario-->
                    <input id="usuario" type="text" name="usuario" placeholder="Usuario">
                    <?php if(isset($_SESSION['usuario_incorrecto'])) { ?>
                        <p class="error"> <?=$_SESSION['usuario_incorrecto']?> </p>
                    <?php 
                        unset($_SESSION['usuario_incorrecto']);
                    } 
                    ?>
                    <!--Contraseña-->
                    <input id="contrasena" type="password" name="contrasena" placeholder="Contraseña">
                    <?php if(isset($_SESSION['contrasena_incorrecta'])) { ?>
                        <p class="error"> <?=$_SESSION['contrasena_incorrecta']?> </p>
                    <?php 
                        unset($_SESSION['contrasena_incorrecta']);
                    } 
                    ?>
                    <input type="hidden" name="accion" value="login">
                    <!--Envio de formulario-->
                    <button id="bt_login">Iniciar sesión</button>
                </form>

                <!--formulario de registro-->
                <form id="registro" action="../Controllers/logIn.php" method="POST" class="form_log">
                    <h2>Registrarse</h2>
                    <!--Nombre De Usuario-->
                    <input type="text"  name="nombres_usuario" placeholder="Nombres" required>
                    <!--Apellido del Usuario-->
                    <input type="text" name="apellidos_usuario" placeholder="Apellidos" required>
                    <!--Correo electronico-->
                    <input type="text" name="correo" placeholder="Correo Electronico" required>
                    <?php if(isset($_SESSION['correo_existente'])) { ?>
                        <p class="error"> <?=$_SESSION['correo_existente']?> </p>
                    <?php 
                        unset($_SESSION['correo_existente']);
                    } 
                    ?>
                    <!--tipos de usuario-->
                    <div class="radio">
                        <div>
                            <!--Docente-->
                            <input type="radio" class="opciones" id="docente" name="tipo_de_usuario" value="docente" required> 
                            <label for="docente">Docente</label>
                        </div>
                        <div>
                            <!--Estudiante-->
                            <input type="radio" class="opciones" id="estudiante" name="tipo_de_usuario" value="estudiante"> 
                            <label for="estudiante">Estudiante</label>
                        </div>
                    </div>
                    <!--Facultad-->
                    <select id="facultad" name="facultad" class="seleccion" required>
                        <option value="" disabled selected>Seleccione una facultad</option>
                        <?php foreach ($facultades as $facultad): ?>
                                <option value="<?= $facultad['cod_fac'] ?>"><?= $facultad['nomb_fac'] ?></option>
                        <?php endforeach; ?>
                        

                    
                    </select>
                    <!--seleccionar la carrera que por defecto esta desactivada y no se puede mirar a no ser que sea estudiante-->
                    <select id="carrera" name="carrera" style="display: none;">
                        <option value='' disabled selected>seleccione su carrera</option>
                    </select>
                    <!--Usuario-->
                    <input type="text" name="nombre_de_usuario" placeholder="Usuario" required>
                    <?php if(isset($_SESSION['usuario_existente'])) { ?>
                        <p class="error"> <?=$_SESSION['usuario_existente']?> </p>
                    <?php 
                        unset($_SESSION['usuario_existente']);
                    } 
                    ?>
                    <!--contraseña-->
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                    <input type="hidden" name="accion" value="log">
                    <!--Envio del formulario-->
                    <button id="bt_log">Registrarse</button>
                </form>
                
            </div>
        </div>
    </main>

    <script src="../Assets/js/logIn.js"></script>
    
</body>
</html>