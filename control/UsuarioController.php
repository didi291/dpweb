<?php
require_once("../model/UsuarioModel.php"); //carga el modelo donde estan las funciones para registrar y validar usuarios

$objPersona = new UsuarioModel(); //crea un objeto del modelo usuariomodel para llamar funcioines (punte entre controlador y la base de datos)

$tipo = $_GET['tipo']; //toma el parametro desde la url para saber que funcion se va a ejecutar

if ($tipo == 'registrar') {
    // print_r ($_POST);
    $nro_identidad = $_POST['nro_identidad'];
    $razon_social = $_POST['razon_social'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $departamento = $_POST['departamento'];
    $provincia = $_POST['provincia'];
    $distrito = $_POST['distrito'];
    $cod_postal = $_POST['cod_postal'];
    $direccion = $_POST['direccion'];
    $rol = $_POST['rol'];
    //ENCRIPTANDO DNI nro_identidad PARA UTILIZARLO COMO CONTRASEÑA
    $password = password_hash($nro_identidad, PASSWORD_DEFAULT);

    if ($nro_identidad == "" || $razon_social == "" || $telefono == "" || $correo == "" || $departamento == "" || $provincia == "" || $distrito == "" || $cod_postal == "" || $direccion == "" || $rol == "") {
        $arrResponse = array('status' => false, 'msg' => 'Error, campos vacios'); //Valida que todos los campos este llenos, si falta lgo envia error
    } else {
        //validacion si existe la misma persona con el mismo dni
        $existePersona = $objPersona->existePersona($nro_identidad);
        if ($existePersona ) {
            $arrResponse = array('status' => false, 'msg' => 'Error, nro de documento ya existe');//verifica si ya hay una persona con nro_identidad usando el modelo, si ya existe envia error
        } else {

            $respuesta = $objPersona->registrar($nro_identidad, $razon_social, $telefono, $correo, $departamento, $provincia, $distrito, $cod_postal, $direccion, $rol, $password);
            if ($respuesta) {
                $arrResponse = array('status' => true, 'msg' => 'Registrado Correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error, fallo en registro');
            }
        }
    }
    echo json_encode($arrResponse);
}
if ($tipo == "iniciar_sesion") {
    $nro_identidad = $_POST['username'];
    $password = $_POST['password'];
    if ($nro_identidad == "" || $password == "") {
        $respuesta = array('status' => false, 'msg' => 'Error, campos vacios');
    } else {
        $existePersona = $objPersona->existePersona($nro_identidad);
        if ($existePersona == 0) {
            $respuesta = array('status' => false, 'msg' => 'Error, el usuario no existe');
        } else {
            $persona = $objPersona->buscarPersonaPorNroIdentidad($nro_identidad);
            if (password_verify($password, $persona->password)) {
                session_start();
                $_SESSION['ventas_id'] = $persona->id;
                $_SESSION['ventas_usuario'] = $persona->razon_social;
                $respuesta = array('status' => true, 'msg' => 'Bienvenido al sistema');
            } else {
                $respuesta = array('status' => false, 'msg' => 'Error, contraseña incorrecta');
            }
        }
    }
    echo json_encode($respuesta);
}
if ($tipo == "ver_usuarios") {
    $usuarios = $objPersona->verUsuarios();
    echo json_encode($usuarios);
}