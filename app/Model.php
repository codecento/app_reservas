<?php
include_once ('Config.php');

class Model extends PDO
{

    protected $conexion;

    public function __construct()
    {
            $this->conexion = new PDO('mysql:host=' . Config::$mvc_bd_hostname . ';dbname=' . Config::$mvc_bd_nombre . '', Config::$mvc_bd_usuario, Config::$mvc_bd_clave);
            // Realiza el enlace con la BD en utf-8
            $this->conexion->exec("set names utf8");
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function validaUsuario($usuario,$contraseña){
        $statement = $this->conexion->prepare('SELECT contraseña FROM usuarios WHERE usuario=?');
        $statement->bindParam(1,$usuario);
        $statement->execute();
        $datos = $statement->fetchAll();
        if(!empty($datos)){
            $contraseñaBBDD = $datos[0]["contraseña"];  
            return $contraseña == $contraseñaBBDD ? true : false;
        }else{
            return false;
        }
        
    }
    
}
?>
