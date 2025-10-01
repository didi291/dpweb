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
        if ($existePersona) {
            $arrResponse = array('status' => false, 'msg' => 'Error, nro de documento ya existe'); //verifica si ya hay una persona con nro_identidad usando el modelo, si ya existe envia error
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

if ($tipo == "ver") {
    //print_r($_POST);
    $respuesta = array('status' => false, 'msg' => '');
    $id_persona = $_POST['id_persona'];
    $usuario = $objPersona->ver($id_persona);
    if ($usuario) {
        $respuesta['status'] = true;
        $respuesta['data'] = $usuario;
    } else {
        $respuesta['msg'] = 'Ups... parece que esta página decidió tomarse vacaciones';
    }
    echo json_encode($respuesta);
}
if ($tipo == "actualizar") {
    // print_r ($_POST);
    $id_persona = $_POST['id_persona'];
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
    if ($id_persona == "" || $nro_identidad == "" || $razon_social == "" || $telefono == "" || $correo == "" || $departamento == "" || $provincia == "" || $distrito == "" || $cod_postal == "" || $direccion == "" || $rol == "") {
        $arrResponse = array('status' => false, 'msg' => 'Error, campos vacios');
    } else {
        $existeID = $objPersona->ver($id_persona);
        if (!$existeID) {
            //devolver mensaje de error
            $arrResponse = array('status' => false, 'msg' => 'Error, el usuario no esta en la base de datos');
            echo json_encode($arrResponse);
            //cerrar función
            exit;
        } else {
            //actualizar usuario
            $actualizar = $objPersona->actualizar($id_persona, $nro_identidad, $razon_social, $telefono, $correo, $departamento, $provincia, $distrito, $cod_postal, $direccion, $rol);
            if ($actualizar) {
                $arrResponse = array('status' => true, 'msg' => 'Usuario actualizado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => $actualizar);
            }
            echo json_encode($arrResponse);
            exit;
        }
    }
}
if ($tipo == "eliminar") {
    $id_persona = $_POST['id_persona'];
    if ($id_persona == "") {
        $arrResponse = array('status' => false, 'msg' => 'Error, ID vacío');
        echo json_encode($arrResponse);
        exit;
    } else {
        // Verificar si el usuario existe
        $existeID = $objPersona->ver($id_persona);
        if (!$existeID) {
            $arrResponse = array('status' => false, 'msg' => 'Error, el usuario no existe en la base de datos');
            echo json_encode($arrResponse);
            exit;
        } else {
            // Eliminar usuario
            $eliminar = $objPersona->eliminar($id_persona);
            if ($eliminar) {
                $arrResponse = array('status' => true, 'msg' => 'Usuario eliminado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario');
            }
            echo json_encode($arrResponse);
            exit;
        }
    }
}
/*
if ($tipo == "ver_proveedor") {
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $proveedor = $objPersona->verProveedor();
    $arrProveedor = array();
    if (count($proveedor) > 0) {
        $arrProveedor = $proveedor;
        $respuesta = array('status' => true, 'msg' => '', 'data' => $arrProveedor);
    }
    echo json_encode($respuesta);
}*/

$tipo = $_GET['tipo'] ?? '';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$objUsuario = new UsuarioModel();

if ($tipo == "ver_proveedores") {
    $proveedores = $objUsuario->verProveedores();
    $respuesta = ['status' => false, 'data' => []];
    if (count($proveedores) > 0) $respuesta = ['status' => true, 'data' => $proveedores];
    header('Content-Type: application/json');
    echo json_encode($respuesta);
    exit;
}
