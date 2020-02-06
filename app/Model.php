<?php
include_once ('Config.php');

class Model extends PDO
{

    protected $conexion;

    public function __construct()
    {
            $this->conexion = new PDO('mysql:host=' . Config::$mvc_bd_hostname . ';dbname=' . Config::$mvc_db_name . '', Config::$mvc_db_user, Config::$mvc_db_pass);
            // Connects with the database
            $this->conexion->exec("set names utf8");
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /* Function that returns the query looking for a user */
    public function getUser($user){
        $statement = $this->conexion->prepare('SELECT * FROM users WHERE user=?');
        $statement->bindParam(1,$user);
        $statement->execute();
        return $statement->fetchAll()[0];
    }

    /* Function that returns the query looking for a user password */
    public function getUserPassword($user){
        $statement = $this->conexion->prepare('SELECT "password" FROM users WHERE user=?');
        $statement->bindParam(1,$user);
        $statement->execute();
        return $statement->fetchAll()[0]["password"];        
    }

    public function addUser($user,$email,$password){
        $admin = false;
        $enabled = false;
        $statement = $this->conexion->prepare('INSERT INTO users(user, email, password, admin, enabled) VALUES (?,?,?,?,?)');
        $statement->bindParam(1,$user);
        $statement->bindParam(2,$email);
        $statement->bindParam(3,$password);
        $statement->bindParam(4,$admin);
        $statement->bindParam(5,$enabled);
        $statement->execute();
    }

    public function getReservations($classroom,$date,$range)
    {
        $statement = $this->conexion->query('SELECT * FROM reservations');
        return $statement->fetchAll();
    }
    
}
