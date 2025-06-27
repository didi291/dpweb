<?php
require_once("../library/conexion.php");
class UsuarioModel{
    private $conexion;
    function __construct(){
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    public function registrar($nro_identidad, $razon_social, $telefono, $correo, $departamento, $provincia, $distrito, $cod_postal, $direccion, $rol, $password){
        $consulta = "INSERT INTO persona (nro_identidad, razon_social, telefono, correo, departamento, provincia,distrito, cod_postal, direccion, rol, password) VALUES ('$nro_identidad', '$razon_social', '$telefono', '$correo', '$departamento', '$provincia', '$distrito', '$cod_postal', '$direccion', '$rol', '$password')";
        $sql = $this->conexion->query();
        if ($sql) {
            $sql = $this->conexion->insert_id;
        }else {
            $sql = 0;
        }
        return $sql;
    }
}

