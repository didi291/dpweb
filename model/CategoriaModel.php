<?php
require_once("../library/conexion.php");
class CategoriaModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    
    public function verCategorias()
    {
        $arr_categorias = array();
        $consulta = "SELECT * FROM categoria";
        $sql = $this->conexion->query($consulta);
        while ($objeto = $sql->fetch_object()) {
            array_push($arr_categorias, $objeto);
        }
        return $arr_categorias;
    }
    public function existeCategoria($nombre)
    {
        $consulta = "SELECT * FROM categoria WHERE nombre='$nombre'";
        $sql = $this->conexion->query($consulta);
        return $sql->num_rows;
    }
    public function registrar($nombre, $detalle)
    {
        $consulta = "INSERT INTO categoria (nombre,detalle) VALUES ('$nombre', '$detalle')";
        $sql = $this->conexion->query($consulta);
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
    }
    public function ver($id)
    {
        $consulta = "SELECT * FROM categoria WHERE id='$id'";
        $sql = $this->conexion->query($consulta);
        return $sql->fetch_object();
    }

    public function actualizar($id_cat, $nombre, $detalle) {
        $consulta = "UPDATE categoria SET nombre='$nombre', detalle='$detalle' WHERE id='$id_cat'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }
     public function eliminar($id){
        $consulta = "DELETE FROM categoria WHERE id='$id'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }
    
}