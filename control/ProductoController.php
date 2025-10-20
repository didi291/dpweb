<?php
require_once("../model/ProductoModel.php");
require_once("../model/CategoriaModel.php");

$objProducto = new ProductoModel();
$objCategoria = new CategoriaModel();

$tipo = $_GET['tipo'];

if ($tipo == "ver_productos") {
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $productos = $objProducto->verProductos();
    $arrProduct = array();
    if (count($productos)) {
        foreach ($productos as $producto) {
            $categoria = $objCategoria->ver($producto->id_categoria);
            $producto->categoria = $categoria->nombre;
            array_push($arrProduct, $producto);
        }
        $respuesta = array('status' => true, 'msg' => '', 'data' => $arrProduct);
    }
    echo json_encode($respuesta);
}
if ($tipo === "registrar") {
    $codigo            = $_POST['codigo'] ?? '';
    $nombre            = $_POST['nombre'] ?? '';
    $detalle           = $_POST['detalle'] ?? '';
    $precio            = $_POST['precio'] ?? '';
    $stock             = $_POST['stock'] ?? '';
    $id_categoria      = $_POST['id_categoria'] ?? '';
    $fecha_vencimiento = $_POST['fecha_vencimiento'] ?? '';
    $id_proveedor = $_POST['id_proveedor'] ?? '';

    if ($codigo === "" || $nombre === "" || $detalle === "" || $precio === "" || $stock === "" || $id_categoria === "" || $fecha_vencimiento === "" || $id_proveedor === "") {
        echo json_encode(['status' => false, 'msg' => 'Error, campos vacíos']);
        exit;
    }
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => false, 'msg' => 'Error, imagen no recibida']);
        exit;
    }
    if ($objProducto->existeCodigo($codigo) > 0) {
        echo json_encode(['status' => false, 'msg' => 'Error, el código ya existe']);
        exit;
    }
    $file = $_FILES['imagen'];
    $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $extPermitidas = ['jpg', 'jpeg', 'png'];

    if (!in_array($ext, $extPermitidas)) {
        echo json_encode(['status' => false, 'msg' => 'Formato de imagen no permitido']);
        exit;
    }
    if ($file['size'] > 5 * 1024 * 1024) { // 5MB
        echo json_encode(['status' => false, 'msg' => 'La imagen supera 2MB']);
        exit;
    }
    $carpetaUploads = "../uploads/productos/";
    if (!is_dir($carpetaUploads)) {
        @mkdir($carpetaUploads, 0775, true);
    }

    $nombreUnico = uniqid('prod_') . '.' . $ext;
    $rutaFisica  = $carpetaUploads . $nombreUnico;
    $rutaRelativa = "uploads/productos/" . $nombreUnico;

    if (!move_uploaded_file($file['tmp_name'], $rutaFisica)) {
        echo json_encode(['status' => false, 'msg' => 'No se pudo guardar la imagen']);
        exit;
    }
    $id = $objProducto->registrar($codigo, $nombre, $detalle, $precio, $stock, $id_categoria, $fecha_vencimiento, $rutaRelativa, $id_proveedor);
    if ($id > 0) {
        echo json_encode(['status' => true, 'msg' => 'Registrado correctamente', 'id' => $id, 'img' => $rutaRelativa]);
    } else {
        @unlink($rutaFisica); // revertir archivo si falló BD, tambien para eliminar el archivo
        echo json_encode(['status' => false, 'msg' => 'Error, falló en registro']);
    }
    exit;
}
if ($tipo == "ver") {
    //print_r($_POST);
    $respuesta = array('status' => false, 'msg' => '');
    $id_producto = $_POST['id_producto'];
    $producto = $objProducto->ver($id_producto);
    if ($producto) {
        $respuesta['status'] = true;
        $respuesta['data'] = $producto;
    } else {
        $respuesta['msg'] = 'Error, producto no existe';
    }
    echo json_encode($respuesta);
}
if ($tipo === "actualizar") {

    $id_producto       = $_POST['id_producto'] ?? '';
    $codigo            = $_POST['codigo'] ?? '';
    $nombre            = $_POST['nombre'] ?? '';
    $detalle           = $_POST['detalle'] ?? '';
    $precio            = $_POST['precio'] ?? '';
    $stock             = $_POST['stock'] ?? '';
    $id_categoria      = $_POST['id_categoria'] ?? '';
    $fecha_vencimiento = $_POST['fecha_vencimiento'] ?? '';
    $imagen           = $_POST['imagen'] ?? '';
    $id_proveedor = $_POST['id_proveedor'] ?? '';

    if ($codigo === "" || $nombre === "" || $detalle === "" || $precio === "" || $stock === "" || $id_categoria === "" || $fecha_vencimiento === "" || $imagen === "" || $id_proveedor === "") {
        echo json_encode(['status' => false, 'msg' => 'Error, campos vacíos']);
        exit;
    } else {
        $producto = $objProducto->ver($id_producto);
        if (!$producto) {
            $arrResponse = array('status' => false, 'msg' => 'Error, producto no encontrado');
            echo json_encode($arrResponse);
            exit;
        } else {
            if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
                //echo "no se envio la imagen";
                $imagen  = $producto->imagen;
            } else {
                //echo "si se envio la imagen";
                //primero subir imagen en la carpeta uploads, luego obtener la ruta del archivo y la misma guardarla en la BD, en casa de que se envie guardar como la variable imagen
            
                $file = $_FILES['imagen'];
                $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $extPermitidas = ['jpg', 'jpeg', 'png'];

                if (!in_array($ext, $extPermitidas)) {
                    echo json_encode(['status' => false, 'msg' => 'Formato de imagen no permitido']);
                    exit;
                }
                if ($file['size'] > 5 * 1024 * 1024) { // 5MB
                    echo json_encode(['status' => false, 'msg' => 'La imagen supera 2MB']);
                    exit;
                }
                $carpetaUploads = "../uploads/productos/";
                if (!is_dir($carpetaUploads)) {
                    @mkdir($carpetaUploads, 0775, true);
                }

                $nombreUnico = uniqid('prod_') . '.' . $ext;
                $rutaFisica  = $carpetaUploads . $nombreUnico;
                $imagen = "uploads/productos/" . $nombreUnico;

                if (!move_uploaded_file($file['tmp_name'], $rutaFisica)) {
                    echo json_encode(['status' => false, 'msg' => 'No se pudo guardar la imagen']);
                    exit;
                }
            }
            $actualizar = $objProducto->actualizar($id_producto, $codigo, $nombre, $detalle, $precio, $stock, $id_categoria, $fecha_vencimiento, $imagen, $id_proveedor);
            if ($actualizar) {
                $arrResponse = array('status' => true, 'msg' => 'Producto actualizado correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error, no se pudo actualizar el producto');
            }
            echo json_encode($arrResponse);
            exit;
        }
    }
}
