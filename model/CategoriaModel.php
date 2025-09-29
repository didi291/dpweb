<?php
require_once("../library/conexion.php");
class CategoriaModel{
    private $conexion;
    function __construct(){
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    public function registrar($nombre, $detalle) {
        $consulta = "INSERT INTO categoria (nombre, detalle) VALUE('$nombre', '$detalle')";
        $sql = $this->conexion->query($consulta);
        if ($sql) {
            $sql = $this->conexion->insert_id;
        }else{
            $sql = 0;
        }
        return $sql;
    }
    public function existeCategoria($nombre){
        $consulta = "SELECT * FROM categoria WHERE nombre='$nombre'";
        $sql = $this->conexion->query($consulta);
        return $sql->num_rows;

    }
    public function verCategoria(){
        $consulta = "SELECT * FROM categoria WHERE rol='Proveedor'";
        $sql = $this->conexion->query($consulta);
        $data = array();
        if ($sql) {
            while ($row = $sql->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function ver($id_categoria){
        $consulta = "SELECT * FROM categoria WHERE id_categoria='$id_categoria'";
        $sql = $this->conexion->query($consulta);
        if ($sql->num_rows > 0) {
            $data = $sql->fetch_assoc();
        }else{
            $data = 0;
        }
        return $data;
    }
    public function actualizar($id_categoria, $nombre, $detalle){
        $consulta = "UPDATE categoria SET nombre='$nombre', detalle='$detalle' WHERE id_categoria='$id_categoria'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }
    public function eliminar($id)
    {
        $consulta = "DELETE FROM categoria WHERE id = '$id'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }
}