<?php
require_once("../library/conexion.php");//carga el archivo de conexion a la base de datos para poder usarlo aqui
class UsuarioModel//define la clase donde estaran todas las funciones relacionadas a los udsuarios
{
    private $conexion; //variable para almacenar la conexion a la base de datos
    //Cuando se crea un objeto de usuariomodel, se conecta a la base de datos
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }
    public function registrar($nro_identidad, $razon_social, $telefono,  $correo, $departamento, $provincia, $distrito, $cod_postal, $direccion, $rol, $password)
    {
        //arma la consulta para insertar un nuevo usuario en la base de datos
        $consulta = "INSERT INTO persona (nro_identidad, razon_social, telefono,  correo, departamento, provincia, distrito, cod_postal, direccion, rol, password) VALUES('$nro_identidad', '$razon_social', '$telefono', '$correo', '$departamento', '$provincia', '$distrito', '$cod_postal', '$direccion', '$rol', '$password')";
        $sql = $this->conexion->query($consulta);//ejecuta la consulta en la base de datos
        //verifica si la consulta se ejecuto correctamente y devuelve el id del nuevo usuario o 0 si fallo
        if ($sql) {
            $sql = $this->conexion->insert_id;
        } else {
            $sql = 0;
        }
        return $sql;
    }
    public function existePersona($nro_identidad)
    {
        //arma la consulta para verificar si ya existe un usuario con el mismo nro_identidad
        $consulta = "SELECT * FROM persona WHERE nro_identidad = '$nro_identidad'";
        $sql = $this->conexion->query($consulta);
        return $sql->num_rows;
    }
    //busca a una persona especifica por su dni y devuelve su información en forma de objeto
    public function buscarPersonaPorNroIdentidad($nro_identidad){
        $consulta = "SELECT id, razon_social, password FROM persona WHERE nro_identidad = '$nro_identidad' LIMIT 1";
        $sql = $this->conexion->query($consulta);
        return $sql->fetch_object();
    }
    //funcion para listar todos los usuarios
    public function verUsuarios(){
        $arr_usuarios = array();
        $consulta = "SELECT * FROM persona";
        $sql = $this->conexion->query($consulta);
        while ($objeto = $sql->fetch_object()) {
            array_push($arr_usuarios, $objeto); //agrega cada usuario encontrado a un array
        }
        return $arr_usuarios;
    }
}
