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

    public function obtenerNivelUsuario($usuario){
        $statement = $this->conexion->prepare('SELECT nivel FROM usuarios WHERE usuario=?');
        $statement->bindParam(1,$usuario);
        $statement->execute();
        $datos = $statement->fetchAll();
        if(!empty($datos)){
            return $datos[0]["nivel"];
        }else{
            return false;
        }
    }

    public function dameAlimentos()
    {
        
            $consulta = "select * from alimentos order by energia desc";
            $result = $this->conexion->query($consulta);
            return $result->fetchAll();
           
       
    }

    public function buscarAlimentosPorNombre($nombre)
    {
       
        $consulta = "select * from alimentos where nombre like :nombre order by energia desc";
        
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':nombre', $nombre);
        $result->execute();
           
        return $result->fetchAll();
        
    }

    public function buscarAlimentosPorEnergia($energia)
    {
       
        $consulta = "select * from alimentos where energia like :energia order by nombre desc";
        
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':energia', $energia);
        $result->execute();
           
        return $result->fetchAll();
        
    }

    public function buscarAlimentosCombinada($energia,$proteina,$hcarbono,$fibra,$grasa)
    {
       
        $consulta = "select * from alimentos where 1 AND energia like ? AND proteina like ? AND hidratocarbono like ? AND fibra like ? AND grasatotal like ? order by nombre desc";
        
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(1, $energia);
        $result->bindParam(2, $proteina);
        $result->bindParam(3, $hcarbono);
        $result->bindParam(4, $fibra);
        $result->bindParam(5, $grasa);
        $result->execute();
           
        return $result->fetchAll();
        
    }
    
    public function dameAlimento($id)
    {
        
            $consulta = "select * from alimentos where id=:id";
            
            $result = $this->conexion->prepare($consulta);
            $result->bindParam(':id', $id);
            $result->execute();
            return $result->fetch();
            
        
    }
    
    
    public function insertarAlimento($n, $e, $p, $hc, $f, $g)
    {
        $consulta = "insert into alimentos (nombre, energia, proteina, hidratocarbono, fibra, grasatotal) values (?, ?, ?, ?, ?, ?)";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(1, $n);
        $result->bindParam(2, $e);
        $result->bindParam(3, $p);
        $result->bindParam(4, $hc);
        $result->bindParam(5, $f);
        $result->bindParam(6, $g);
        $result->execute();
                
        return $result;
    }

    
}
?>
