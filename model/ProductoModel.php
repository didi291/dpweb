<?php

require_once("../library/conexion.php");
class ProductoModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    
    public function verProductos()
    {
        $arr = array();
        $consulta = "SELECT * FROM producto";
        $sql = $this->conexion->query($consulta);
        if ($sql) {
            while ($objeto = $sql->fetch_object()) {
                array_push($arr, $objeto);
            }
        }
        return $arr;
    }

    public function existeCodigo($codigo)
    {
        $codigo = $this->conexion->real_escape_string($codigo);
        $consulta = "SELECT id FROM producto WHERE codigo='$codigo' LIMIT 1";
        $sql = $this->conexion->query($consulta);
        return $sql ? $sql->num_rows : 0;
    }

    public function existeCategoria($nombre)
    {
        $nombre = $this->conexion->real_escape_string($nombre);
        $consulta = "SELECT id FROM producto WHERE nombre='$nombre' LIMIT 1";
        $sql = $this->conexion->query($consulta);
        return $sql ? $sql->num_rows : 0;
    }

    public function registrar($codigo, $nombre, $detalle, $precio, $stock, $id_categoria, $fecha_vencimiento, $imagen, $id_proveedor)
    {
        $codigo            = $this->conexion->real_escape_string($codigo);
        $nombre            = $this->conexion->real_escape_string($nombre);
        $detalle           = $this->conexion->real_escape_string($detalle);
        $precio            = floatval($precio);
        $stock             = intval($stock);
        $id_categoria      = intval($id_categoria);
        $fecha_vencimiento = $this->conexion->real_escape_string($fecha_vencimiento);
        $id_proveedor      = intval($id_proveedor);
        $imagen            = $this->conexion->real_escape_string($imagen);

        $consulta = "INSERT INTO producto (codigo, nombre, detalle, precio, stock, id_categoria, fecha_vencimiento, imagen, id_proveedor)
                     VALUES ('$codigo', '$nombre', '$detalle', $precio, $stock, $id_categoria, '$fecha_vencimiento', '$imagen', $id_proveedor)";
        $sql = $this->conexion->query($consulta);
        if ($sql) {
            return $this->conexion->insert_id;
        }
        return 0;
    }

    public function ver($id)
    {
        $id = intval($id);
        $consulta = "SELECT * FROM producto WHERE id=$id";
        $sql = $this->conexion->query($consulta);
        return $sql ? $sql->fetch_object() : null;
    }

    // CORRECCIÓN: firma para actualizar por id e incluir imagen
    public function actualizar($id_producto, $codigo, $nombre, $detalle, $precio, $stock, $id_categoria, $fecha_vencimiento, $imagen, $id_proveedor) {
        $id_producto       = intval($id_producto);
        $codigo            = $this->conexion->real_escape_string($codigo);
        $nombre            = $this->conexion->real_escape_string($nombre);
        $detalle           = $this->conexion->real_escape_string($detalle);
        $precio            = floatval($precio);
        $stock             = intval($stock);
        $id_categoria      = intval($id_categoria);
        $fecha_vencimiento = $this->conexion->real_escape_string($fecha_vencimiento);
        $imagen            = $this->conexion->real_escape_string($imagen);
        $id_proveedor      = intval($id_proveedor);

        $consulta = "UPDATE producto SET
                        codigo='$codigo',
                        nombre='$nombre',
                        detalle='$detalle',
                        precio=$precio,
                        stock=$stock,
                        id_categoria=$id_categoria,
                        fecha_vencimiento='$fecha_vencimiento',
                        imagen='$imagen',
                        id_proveedor=$id_proveedor
                     WHERE id=$id_producto";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }

    public function eliminar($id){
        $id = intval($id);
        $consulta = "DELETE FROM producto WHERE id=$id";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }
    
}