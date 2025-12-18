<?php
require_once("../model/ProductoModel.php");
require_once("../model/CategoriaModel.php");
require_once("../model/UsuarioModel.php");  // Parte agregada: Incluir el modelo de Usuario para obtener proveedores

$objProducto = new ProductoModel();
$objCategoria = new CategoriaModel();
$objUsuario = new UsuarioModel();  // Parte agregada: Instanciar el modelo de Usuario

$tipo = $_GET['tipo'];

if ($tipo == "ver_productos") {
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $productos = $objProducto->verProductos();
    $arrProduct = array();
    if (count($productos)) {
        foreach ($productos as $producto) {
            $categoria = $objCategoria->ver($producto->id_categoria);
            $producto->categoria = $categoria->nombre;
            $proveedor = $objUsuario->ver($producto->id_proveedor);  // Parte agregada: Obtener el proveedor
            $producto->proveedor = $proveedor->razon_social ?? 'Desconocido';  // Parte agregada: Asignar el nombre del proveedor (usar 'Desconocido' si no existe)
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
    $extPermitidas = ['jpg', 'jpeg', 'png', 'jfif', 'webp'];

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
        $respuesta['msg'] = 'Error, el producto no existe';
    }
    echo json_encode($respuesta);
}
if ($tipo === "actualizar") {

    //print_r($_POST);

    $id_producto       = $_POST['id_producto'] ?? '';
    $codigo            = $_POST['codigo'] ?? '';
    $nombre            = $_POST['nombre'] ?? '';
    $detalle           = $_POST['detalle'] ?? '';
    $precio            = $_POST['precio'] ?? '';
    $stock             = $_POST['stock'] ?? '';
    $id_categoria      = $_POST['id_categoria'] ?? '';
    $fecha_vencimiento = $_POST['fecha_vencimiento'] ?? '';
    $imagen            = $_POST['imagen'] ?? '';
    $id_proveedor      = $_POST['id_proveedor'] ?? '';

    if ($id_producto === "" || $codigo === "" || $nombre === "" || $detalle === "" || $precio === "" || $stock === "" || $id_categoria === "" || $fecha_vencimiento === "" || $id_proveedor === "") {
        echo json_encode(['status' => false, 'msg' => 'Error, campos vacíos']);
        exit;
    }

    $producto = $objProducto->ver($id_producto);
    if (!$producto) {
        echo json_encode(['status' => false, 'msg' => 'Error, producto no encontrado']);
        exit;
    }

    // Verificar unicidad del codigo excepto si es el mismo del producto actual
    if ($codigo !== $producto->codigo && $objProducto->existeCodigo($codigo) > 0) {
        echo json_encode(['status' => false, 'msg' => 'Error, el código ya existe']);
        exit;
    }

    // Por defecto mantenemos la ruta actual de la imagen
    $rutaRelativaNueva = $producto->imagen;
    $rutaFisicaNueva = '';
    $nuevaImagenSubida = false;

    // Si se envió una nueva imagen, procesarla (validación y mover archivo)
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['imagen'];
        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $extPermitidas = ['jpg', 'jpeg', 'png'];

        if (!in_array($ext, $extPermitidas)) {
            echo json_encode(['status' => false, 'msg' => 'Formato de imagen no permitido']);
            exit;
        }
        if ($file['size'] > 5 * 1024 * 1024) { // 5MB
            echo json_encode(['status' => false, 'msg' => 'La imagen supera 5MB']);
            exit;
        }
        $carpetaUploads = "../uploads/productos/";
        if (!is_dir($carpetaUploads)) {
            @mkdir($carpetaUploads, 0775, true);
        }

        $nombreUnico = uniqid('prod_') . '.' . $ext;
        $rutaFisicaNueva  = $carpetaUploads . $nombreUnico;
        $rutaRelativaNueva = "uploads/productos/" . $nombreUnico;

        if (!move_uploaded_file($file['tmp_name'], $rutaFisicaNueva)) {
            echo json_encode(['status' => false, 'msg' => 'No se pudo guardar la imagen']);
            exit;
        }
        $nuevaImagenSubida = true;
    }

    // Intentar actualizar en base de datos (incluye la ruta de la imagen, ya sea nueva o la antigua)
    $ok = $objProducto->actualizar($id_producto, $codigo, $nombre, $detalle, $precio, $stock, $id_categoria, $fecha_vencimiento, $rutaRelativaNueva, $id_proveedor);

    if ($ok) {
        // Si la BD se actualizó correctamente y subimos una nueva imagen, eliminar la vieja
        if ($nuevaImagenSubida) {
            $rutaFisicaVieja = "../" . $producto->imagen;
            if (!empty($producto->imagen) && file_exists($rutaFisicaVieja)) {
                @unlink($rutaFisicaVieja);
            }
        }
        echo json_encode(['status' => true, 'msg' => 'Actualizado correctamente']);
    } else {
        // Si la actualización falló y subimos una nueva imagen, eliminar la nueva (rollback)
        if ($nuevaImagenSubida && file_exists($rutaFisicaNueva)) {
            @unlink($rutaFisicaNueva);
        }
        echo json_encode(['status' => false, 'msg' => 'Error, falló al actualizar']);
    }
    exit;
}

if ($tipo == "eliminar") {
    //print_r($_POST);
    $respuesta = array('status' => false, 'msg' => 'Fallo el controlador');
    $id_temporal = $_POST['id'];
    
    $resultado = $objVenta->eliminarTemporal($id_temporal);
    if ($resultado) {
        $respuesta = array('status' => true, 'msg' => 'Eliminado Correctamente');
    } else {
        $respuesta = array('status' => false, 'msg' => $resultado);
    }
    echo json_encode($respuesta);
}
if ($tipo == "buscar_producto_venta") {
    $dato = $_POST['dato'];
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $productos = $objProducto->buscarProductoByNombreOrCodigo($dato);
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