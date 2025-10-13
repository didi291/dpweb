<?php
require_once("../model/CategoriaModel.php");

$objCategoria = new CategoriaModel();

$tipo = $_GET['tipo'];

if ($tipo == "ver_categorias") {
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $categorias = $objCategoria->verCategorias();
    if (count($categorias)) {
        $respuesta = array('status' => true, 'msg' => '', 'data' => $categorias);
    }
    echo json_encode($respuesta);
}

if ($tipo == "registrar") {
    //print_r($_POST);
    $nombre = $_POST['nombre'];
    $detalle = $_POST['detalle'];

    if ($nombre == "" || $nombre == "") {
        $arrResponse = array('status' => false, 'msg' => 'Error, campos vacios');
    } else {
        //validacion si existe persona con el mismo dni
        $existeCategoria = $objCategoria->existeCategoria($nombre);
        if ($existeCategoria > 0) {
            $arrResponse = array('status' => false, 'msg' => 'Error, categoria ya existe');
        } else {
            $respuesta = $objCategoria->registrar($nombre, $detalle);
            if ($respuesta) {
                $arrResponse = array('status' => true, 'msg' => 'Registrado Correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error, falló en registro');
            }
        }
    }
    echo json_encode($arrResponse);
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
        $respuesta['msg'] = 'Error, categoria no existe';
    }
    echo json_encode($respuesta);
}
if ($tipo == "actualizar") {
    //print_r($_POST);
    $id_cat = $_POST['id_categoria'];
    $nombre = $_POST['nombre'];
    $detalle = $_POST['detalle'];
    if ($id_cat == "" || $nombre == "" || $detalle == "") {
        $arrResponse = array('status' => false, 'msg' => 'Error, campos vacios');
    } else {
        $existeID = $objCategoria->ver($id_cat);
        if (!$existeID) {
            //devolver mensaje
            $arrResponse = array('status' => false, 'msg' => 'Error, categoria no existe en BD');
            echo json_encode($arrResponse);
            // cerrar funcion
            exit;
        } else {
            // actualizar
            $actualizar = $objCategoria->actualizar($id_cat, $nombre, $detalle);
            if ($actualizar) {
                $arrResponse = array('status' => true, 'msg'=>"Actualizado correctamente");
            }else {
                $arrResponse = array('status' => false, 'msg'=>$actualizar);
            }
            echo json_encode($arrResponse);
            exit;
        }
    }
}
if ($tipo == "eliminar") {
    //print_r($_POST);
    $id_categoria = $_POST['id_categoria'];
    $respuesta = array('status' => false, 'msg' => '');
    $resultado = $objCategoria->eliminar($id_categoria);
    if ($resultado) {
        $respuesta = array('status' => true, 'msg' => 'Eliminado Correctamente');
    }else {
        $respuesta = array('status' => false, 'msg' => $resultado);
    }
    echo json_encode($respuesta);
}