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
}