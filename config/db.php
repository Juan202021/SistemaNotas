<?php

include_once('conexion.php');

$obj = new ConexionBD();
$conn = $obj->getConnection();

function crearFacultad(){
    global $conn;
    $statement = $conn->prepare("
    CREATE TABLE facultad (
        cod_fac serial not null,
        nomb_fac varchar(60),
        constraint pk_fac primary key(cod_fac)
    )");
    return ($statement->execute())? "Bien": "Pailas";
}
function crearPrograma(){
    global $conn;
    $statement = $conn->prepare("
    CREATE TABLE programa (
        cod_pro serial not null,
        nomb_pro varchar(60),
        cod_fac int,
        constraint fk_cod_fac foreign key (cod_fac)
        references facultad(cod_fac) MATCH FULL ON DELETE RESTRICT ON UPDATE CASCADE,
        constraint pk_pro primary key(cod_pro)
    )");
    return ($statement->execute())? "Bien": "Pailas";
}
function crearUsuario(){
    global $conn;
    $statement = $conn->prepare("
    CREATE TABLE usuario (
        cod_user serial not null,
        nomb_user varchar(40),
        contr_user text,
        tipo_user varchar(20),
        correo varchar(60),
        constraint pk_user primary key(cod_user)
    )");
    return ($statement->execute())? "Bien": "Pailas";
}
function crearDocente(){
    global $conn;
    $statement = $conn->prepare("
    CREATE TABLE docente (
        cod_doc serial not null,
        nomb_doc varchar(40),
        apell_doc varchar(40),
        cod_user int,
        cod_fac int,
        constraint fk_cod_user_doc foreign key (cod_user)
        references usuario(cod_user) MATCH FULL ON DELETE RESTRICT ON UPDATE CASCADE,
        constraint fk_cod_fac_doc foreign key (cod_fac)
        references facultad(cod_fac) MATCH FULL ON DELETE RESTRICT ON UPDATE CASCADE,
        constraint pk_doc primary key(cod_doc)
    )");
    return ($statement->execute())? "Bien": "Pailas";
}
function crearEstudiante(){
    global $conn;
    $statement = $conn->prepare("
    CREATE TABLE estudiante (
        cod_est serial not null,
        nomb_est varchar(40),
        apell_est varchar(40),
        cod_user int,
        cod_pro int,
        constraint fk_cod_user_est foreign key (cod_user)
        references usuario(cod_user) MATCH FULL ON DELETE RESTRICT ON UPDATE CASCADE,
        constraint fk_cod_pro_est foreign key (cod_pro)
        references programa(cod_pro) MATCH FULL ON DELETE RESTRICT ON UPDATE CASCADE,
        constraint pk_est primary key(cod_est)
    )");
    return ($statement->execute())? "Bien": "Pailas";
}
function crearCurso(){
    global $conn;
    $statement = $conn->prepare("
    CREATE TABLE curso (
        cod_cur serial not null,
        nomb_cur varchar(30),
        creditos int,
        cod_doc int,
        cod_pro int,
        constraint fk_cod_doc_cur foreign key(cod_doc)
        references docente(cod_doc) MATCH FULL ON DELETE RESTRICT ON UPDATE CASCADE,
        constraint fk_cod_pro foreign key (cod_pro)
        references programa(cod_pro) MATCH FULL ON DELETE RESTRICT ON UPDATE CASCADE,
        constraint pk_cur primary key(cod_cur)
    )");
    return ($statement->execute())? "Bien": "Pailas";
}

function crearInscritos(){
    global $conn;
    $statement = $conn->prepare("
    CREATE TABLE inscritos (
        año int,
        periodo numeric(1),
        cod_cur int,
        cod_est int,
        constraint fk_cod_cur_ins foreign key(cod_cur)
        references curso(cod_cur) MATCH FULL ON DELETE RESTRICT ON UPDATE CASCADE,
        constraint fk_cod_est_ins foreign key (cod_est)
        references estudiante(cod_est) MATCH FULL ON DELETE RESTRICT ON UPDATE CASCADE,
        constraint pk_ins primary key(cod_cur,cod_est,año,periodo)
    )");
    return ($statement->execute())? "Bien": "Pailas";
}

function crearInfoNota(){
    global $conn;
    $statement = $conn->prepare("
    CREATE TABLE info_nota (
        cod_inf serial not null,
        detalle varchar(40),
        porcentaje numeric(3,2),
        corte numeric(1),
        constraint pk_inf primary key(cod_inf)
    )");
    return ($statement->execute())? "Bien": "Pailas";
}
function crearCalificacion(){
    global $conn;
    $statement = $conn->prepare("
    CREATE TABLE calificacion (
        cod_cal serial not null,
        nota numeric(2,1),
        fecha date,
        cod_inf int,
        cod_cur int,
        cod_est int,
        año int,
        periodo numeric(1),
        constraint fk_ins_cal foreign key(cod_cur,cod_est,año,periodo)
        references inscritos(cod_cur,cod_est,año,periodo) MATCH FULL ON DELETE CASCADE ON UPDATE CASCADE,
        constraint fk_cod_inf_cal foreign key(cod_inf)
        references info_nota(cod_inf) MATCH FULL ON DELETE CASCADE ON UPDATE CASCADE,
        constraint pk_cal primary key(cod_cal)
    )");
    return ($statement->execute())? "Bien": "Pailas";
}


function insertFacultad(){
    global $conn;
    $statement = $conn->prepare("INSERT INTO facultad (nomb_fac) VALUES ('FCBI'),('FCHE'),('FCE')");
    return ($statement->execute())? "Bien": "Pailas";
}
function insertPrograma(){
    global $conn;
    $statement = $conn->prepare("INSERT INTO programa (nomb_pro,cod_fac) VALUES ('Ing Sistemas',1),('Ing ambiental',2),('Matemáticas',1)");
    return ($statement->execute())? "Bien": "Pailas";
}
function insertUsuario(){
    global $conn;
    $statement = $conn->prepare("
    INSERT INTO usuario (nomb_user,contr_user,tipo_user,correo)
    VALUES ('juanes','1234','Estudiante','jearistizabal@unillanos.edu.co'),
    ('jesusR','1234','Docente','jreyes@unillanos.edu.co'),
    ('Felix','1234','Docente','dsf@unillanos.edu.co'),
    ('hannaA','1234','Estudiante','adfdg@unillanos.edu.co')");
    return ($statement->execute())? "Bien": "Pailas";
}
function insertDocentes(){
    global $conn;
    $statement = $conn->prepare("
    INSERT INTO docente (nomb_doc,apell_doc,cod_user,cod_fac)
    VALUES ('Jesus','Reyes',2,1),('Felix','Castro',3,3)");
    return ($statement->execute())? "Bien": "Pailas";
}
function insertEstudiantes(){
    global $conn;
    $statement = $conn->prepare("
    INSERT INTO estudiante (nomb_est,apell_est,cod_user,cod_pro,fecha_ingreso)
    VALUES ('Juan','Aristizabal',1,1,'2022-09-09'),('Hanna','Castro',4,2,'2021-01-01')");
    return ($statement->execute())? "Bien": "Pailas";
}
function insertCurso(){
    global $conn;
    $statement = $conn->prepare("
    INSERT INTO curso (nomb_cur,creditos,cod_doc,cod_pro)
    VALUES ('Bases de datos',4,1,1),('Catedra',2,2,1)");
    return ($statement->execute())? "Bien": "Pailas";
}

function insertInscritos(){
    global $conn;
    $statement = $conn->prepare("
    INSERT INTO inscritos (cod_cur,cod_est,año,periodo)
    VALUES (1,1,2024,1),(2,2,2022,1)");
    return ($statement->execute())? "Bien": "Pailas";
}
function insertInfoNota(){
    global $conn;
    $statement = $conn->prepare("
    INSERT INTO info_nota (detalle,porcentaje,corte)
    VALUES ('Parcial',0.25,1),('Parcial',0.25,2),('Lab',0.05,1),('Lab',0.05,2)");
    return ($statement->execute())? "Bien": "Pailas";
}
function insertCalificaciones(){
    global $conn;
    $statement = $conn->prepare("
    INSERT INTO calificacion (nota,fecha,cod_cur,cod_est,año,periodo,cod_inf)
    VALUES (4.1,'2024-03-03',1,1,2024,1,1),(4.8,'2024-04-03',1,1,2024,1,3),(4.5,'2024-03-03',2,2,2022,1,1),(4.8,'2024-04-03',2,2,2022,1,3)");
    return ($statement->execute())? "Bien": "Pailas";
}

// echo crearFacultad();
// echo crearPrograma();
// echo crearUsuario();
// echo crearDocente();
// echo crearEstudiante();
// echo crearCurso();
// echo crearInscritos();
// echo crearInfoNota();
// echo crearCalificacion();


echo insertFacultad();
echo insertPrograma();
echo insertUsuario();
echo insertDocentes();
echo insertEstudiantes();
echo insertCurso();
echo insertInscritos();
echo insertInfoNota();
echo insertCalificaciones();
