<?php
require_once("../model/VentaModel.php");
require_once("../model/ProductoModel.php");

$objProducto = new ProductoModel();
$objVenta = new VentaModel();

$tipo = $_GET['tipo'];

if ($tipo == "registrarTemporal") {
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $id_producto = $_POST['id_producto'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $b_producto = $objVenta->buscarTemporal($id_producto);
    if ($b_producto) {
        $n_cantidad = $b_producto->cantidad + 1;
        $objVenta->actualizarCantidadTemporal($id_producto, $n_cantidad);
        $respuesta = array('status' => true, 'msg' => 'actualizado');
    } else {
        $registro = $objVenta->registrar_temporal($id_producto, $precio, $cantidad);
        $respuesta = array('status' => true, 'msg' => 'registrado');
    }
    echo json_encode($respuesta);
}
if ($tipo=="listar_venta_temporal") {
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $b_producto = $objVenta->buscarTemporales();
    if ($b_producto) {
        $respuesta = array('status' => true, 'data' => $b_producto);
    }else {
       $respuesta = array('status' => false, 'msg' => 'no se encontraron datos');
    }
    echo json_encode($respuesta);
}

if($tipo=="actualizar_cantidad"){
    $id = $_POST['id'];
    $cantidad =  $_POST['cantidad'];
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $consulta = $objVenta->actualizarCantidadTemporalByid($id, $cantidad);
    if ($consulta) {
        $respuesta = array('status' => true, 'msg' => 'success');             
    }else {
        $respuesta = array('status' => false, 'msg' => 'error');
    }
    echo json_encode($respuesta);
}
if($tipo == "registrar_venta"){
    session_start();
    $id_cliente = $_POST['id_cliente'];
    $fecha_venta = $_POST['fecha_venta'];
    $id_vendedor = $_SESSION['ventas_id'];
    $ultima_venta = $objVenta->buscar_ultima_venta();
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    if ($ultima_venta) {
        $correlativo = $ultima_venta->codigo + 1;
    } else {
        $correlativo = 1;
    }
    $venta = $objVenta->registrar_venta($correlativo, $fecha_venta, $id_cliente, $id_vendedor);
    if ($venta) {
        //Registrar detalle de la venta
        $temporales = $objVenta->buscarTemporales();
        foreach ($temporales as $temporal) {
            $objVenta->registrar_detalle_venta($venta, $temporal->id_producto, $temporal->precio, $temporal->cantidad);
        }
        //Eliminar temporales
        $objVenta->eliminarTemporales();
        $respuesta = array('status' => true, 'msg' => 'venta registrada con exito');
    } else {
        $respuesta = array('status' => false, 'msg' => 'error al registrar la venta');
    }
    echo json_encode($respuesta);
}