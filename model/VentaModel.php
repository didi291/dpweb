<?php
require_once("../library/conexion.php");
class VentaModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    public function registrar_temporal($id_producto, $precio, $cantidad)
    {
        $consulta = "INSERT INTO temporal_ventas (id_producto, precio, cantidad) VALUES ('$id_producto', '$precio', '$cantidad')";
        $sql = $this->conexion->query($consulta);
        if ($sql) {
            return $this->conexion->insert_id;
        }
        return 0;
    }
    public function actualizarCantidadTemporal($id_producto, $cantidad)
    {
        $consulta = "UPDATE temporal_ventas SET cantidad='$cantidad' WHERE id_producto='$id_producto'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }
    public function buscarTemporales()
    {
        $arr_temporal = array();
        $consulta = "SELECT * FROM temporal_ventas";
        $sql = $this->conexion->query($consulta);
        while ($objeto = $sql->fetch_object()) {
            array_push($arr_temporal, $objeto);
        }
        return $arr_temporal;
    }
    public function buscarTemporal($id_producto)
    {
        $consulta = "SELECT * FROM temporal_ventas WHERE id_producto='$id_producto'";
        $sql = $this->conexion->query($consulta);
        return $sql->fetch_object();
    }
    public function eliminarTemporal($id)
    {
        $consulta = "DELETE FROM temporal_ventas WHERE id='$id'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }
    public function eliminarTemporales()
    {
        $consulta = "DELETE FROM temporal_ventas";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }
    //---------------------- Ventas Registradas (oficiales) ---------------------//
}
