<?php
require_once("../model/CategoriaModel.php");

$objCategoria = new CategoriaModel();

$tipo = $_GET['tipo'];

if ($tipo == "registrar") {
    $nombre = $_POST['nombre'];
    $detalle = $_POST['detalle'];

    if ($nombre == "" || $detalle == "") {
        $arrResponse = array('status' => false, 'msg' => 'Error, campos vacios');
    } else {
        $existeCategoria = $objCategoria->existeCategoria($nombre);
        if ($existeCategoria > 0) {
            $arrResponse = array('status' => false, 'msg' => 'Error, esta categoria ya existe');
        } else {

            $respuesta = $objCategoria->registrar($nombre, $detalle);
            if ($respuesta) {
                $arrResponse = array('status' => true, 'msg' => 'Registrado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error, fallo en registro');
            }
        }
    }
    echo json_encode($arrResponse);
}
if ($tipo == "ver_categoria") {
    $categoria = $objCategoria->verCategoria();
    echo json_encode($categoria);
}
if ($tipo == "ver") {
    //print_r($_POST);
    $respuesta = array('status' => false, 'msg' => '');
    $id_categoria = $_POST['id_categoria'];
    $categoria = $objCategoria->ver($id_categoria);
    if ($categoria) {
        $respuesta['status'] = true;
        $respuesta['data'] = $categoria;
    } else {
        $respuesta['msg'] = 'Ups... parece que esta página decidió tomarse vacaciones';
    }
    echo json_encode($respuesta);
}
if ($tipo == "actualizar") {
    // print_r ($_POST);
    $id_categoria = $_POST['id_categoria'];
    $nombre = $_POST['nombre'];
    $detalle = $_POST['detalle'];

    if ($id_categoria == "" || $nombre == "" || $detalle == "") {
        $arrResponse = array('status' => false, 'msg' => 'Error, campos vacios');
    } else {
        $existeID = $objCategoria->ver($id_categoria);
        if (!$existeID) {
            //devolver mensaje de error
            $arrResponse = array('status' => false, 'msg' => 'Error, la categoria no esta en la base de datos');
            echo json_encode($arrResponse);
            //cerrar función
            exit;
        } else {
            //actualizar usuario
            $actualizar = $objCategoria->actualizar($id_categoria, $nombre, $detalle);
            if ($actualizar) {
                $arrResponse = array('status' => true, 'msg' => 'Categoria actualizada correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => $actualizar);
            }
            echo json_encode($arrResponse);
            exit;
        }
    }
}
if ($tipo == "eliminar") {
    $id_categoria = $_POST['id_categoria'];
    if ($id_categoria == "") {
        $arrResponse = array('status' => false, 'msg' => 'Error, ID vacío');
        echo json_encode($arrResponse);
        exit;
    } else {
        // Verificar si el usuario existe
        $existeID = $objCategoria->ver($id_categoria);
        if (!$existeID) {
            $arrResponse = array('status' => false, 'msg' => 'Error, la categoria no existe en la base de datos');
            echo json_encode($arrResponse);
            exit;
        } else {
            // Eliminar categoria
            $eliminar = $objCategoria->eliminar($id_categoria);
            if ($eliminar) {
                $arrResponse = array('status' => true, 'msg' => 'Categoria eliminada correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la categoria');
            }
            echo json_encode($arrResponse);
            exit;
        }
    }
}
