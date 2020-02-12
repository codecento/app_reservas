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
        return $statement->fetchAll();
    }

    /* Function that adds a user to the database */
    public function addUser($user,$email,$password)
    {
        $level = 0;
        $statement = $this->conexion->prepare('INSERT INTO users(user, email, password, level) VALUES (?,?,?,?)');
        $statement->bindParam(1,$user);
        $statement->bindParam(2,$email);
        $statement->bindParam(3,$password);
        $statement->bindParam(4,$level);
        return $statement->execute();
    }

    /* Function that gets reservations from the database with parameters */
    public function getReservations($classroom="%",$date="%")
    {
        $statement = $this->conexion->prepare('SELECT * FROM reservations WHERE date_reservation LIKE ? && name_classroom LIKE ?');
        $statement->bindParam(1, $date);
        $statement->bindParam(2, $classroom);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getUserReservations($user)
    {
        $statement = $this->conexion->prepare('SELECT * FROM reservations WHERE user LIKE ?');
        $statement->bindParam(1, $user);
        $statement->execute();
        return $statement->fetchAll();
    }

    /* Function that get each classroom in the database with it's information*/
    public function getClassrooms()
    {
        $statement = $this->conexion->prepare('SELECT * FROM classrooms');
        $statement->execute();
        return $statement->fetchAll();
    }

    /* Function that adds classroom with all the required parameters */
    public function addClassroom($classroom_name, $description)
    {
        $statement = $this->conexion->prepare('INSERT INTO classrooms(classroom_name,description) VALUES (?,?)');
        $statement->bindParam(1,$classroom_name);
        $statement->bindParam(2,$description);
        return $statement->execute();
    }

    public function addReservation($user,$classroom,$date,$range)
    {
        $statement = $this->conexion->prepare('INSERT INTO reservations(user,name_classroom,date_reservation,range_reservation) VALUES (?,?,?,?)');
        $statement->bindParam(1,$user);
        $statement->bindParam(2,$classroom);
        $statement->bindParam(3,$date);
        $statement->bindParam(4,$range);
        return $statement->execute();
    }

    /* Function that changes user level from the administrator page */
    public function changeUserLevel($user,$level)
    {
        $statement = $this->conexion->prepare("");
    }

    /* Function that deletes a reservation */
    public function deleteReservation($user,$classroom,$date,$range)
    {
        $statement = $this->conexion->prepare('DELETE FROM reservations WHERE user LIKE ? && name_classroom LIKE ? && date_reservation LIKE ? && range_reservation LIKE ?');
        $statement->bindParam(1,$user);
        $statement->bindParam(2,$classroom);
        $statement->bindParam(3,$date);
        $statement->bindParam(4,$range);
        return $statement->execute();
    }
    
    /* Deletes an specific classroom */
    public function deleteClassroom($classroom)
    {
        $statement = $this->conexion->prepare('DELETE FROM classrooms WHERE classroom_name LIKE $classroom');
        $statement->bindParam(1,$classroom);
        return $statement->execute();
    }

    public function getUsers($level)
    {
        $statement = $this->conexion->prepare('SELECT * FROM users WHERE level != ?');
        $statement->bindParam(1, $level);
        $statement->execute();
        return $statement->fetchAll();
    }
}
