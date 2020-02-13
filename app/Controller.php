<?php
//TODO develop notenabled page
//TODO change error page

include ('libs/utils.php');
include ("Session.php");
include ("Validation.php");

class Controller
{

    public function error()
    {
        require __DIR__ . '/templates/error.php';
    }

    /* Function that checks if the user is enabled and loads home page. If the user is note enabled, calls to index aiming to load the 'notenabled' page */
    public function home(){
        if(isset($_GET["admin"])){
            $notAdmin = true;
        }
        require __DIR__ . '/templates/home.php';
    }

    public function administration()
    {
        require __DIR__ . '/templates/administration.php';
    }

    public function reservations()
    {
        require __DIR__ . '/templates/reservations.php';
    }

    /* Function that checks if login or register were submitted and prepares the session variables. Then calls the index with "index.php?ctl='home'" */
    public function login()
    {
        try{
            if(isset($_REQUEST["register-submit"])){
                //Data from the register form
                $data = $_POST;

                $userImages = "user_images/";
                $extenions = ["image/jpeg", "image/png"];

                $validation = new Validation();

                //Rules to validate each form input
                $rules = array(
                    array('name' => 'username', 'regla' => 'noempty,user'),
                    array('name' => 'email', 'regla' => 'no-empty,email'),
                    array('name' => 'password', 'regla' => 'no-empty,password'),
                    array('name' => 'confirm-password', 'regla' => 'no-empty,password')
                );

                $validation = $validation->rules($rules,$data);
                
                //Check if the form is valid
                if(!isset($validation->message)){
                    //Check if 'confirmed password' is equals to the 'password'
                    if($data["password"] == $data["confirm-password"]){
                        $m = new Model();

                        /* Check uploaded image 
                        if ($_FILES["image"]['error'] != 0) {
                            switch ($_FILES["image"]['error']) {
                                case 1:
                                    $image = "Fichero demasiado grande";
                                    break;
                                case 2:
                                    $image = 'El fichero es demasiado grande';
                                    break;
                                case 3:
                                    $image = 'El fichero no se ha podido subir entero';
                                    break;
                                case 4:
                                    $image = 'No se ha podido subir el fichero';
                                    break;
                                case 6:
                                    $image = "Falta carpeta temporal";
                                    break;
                                case 7:
                                    $image = "No se ha podido escribir en el disco";
                                    break;
                                default:
                                    $image = 'Error indeterminado.';
                            }
                        } else {
                            $nombreArchivo = $_FILES["image"]['name'];
                            $directorioTemp = $_FILES["image"]['tmp_name'];
                            $extension = $_FILES['imagen']['type'];
                            if (! in_array($extension, $extensions)) {
                                $image = "Image extension is not valid";
                            }else{
                                $nombreArchivo = $userImages . $data["username"];
                    
                                if (is_dir($userImages))
                                    if (!move_uploaded_file($directorioTemp, $nombreArchivo)) {
                                        $image = "Image can not be uploaded. Try to sign up again.";
                                    }
                                else
                                    $image = "Image can not be uploaded. Try to sign up again.";
                            }
                        }*/

                        /* If there isn't any error with the image, check if the user can be saved on database */
                        //if(!isset($image)){
                            //If the user does not exists in the database, add the user, configure the session and go to home page. Else, load login page and make visible the error
                            if(empty($m->getUser($data["username"]))){
                                $registered = $m->addUser($data["username"],$data["email"],cryptBlowfish($data["password"]));
                            }else{
                                $userExists = true;
                            }
                        //}

                    }else{
                        $passwordMatches = false;
                    }
                    
                }else{
                    $message = $validation->message;
                }

                require __DIR__ ."/templates/login.php";

            }else if(isset($_REQUEST["login-submit"])){ /* Check if login form was submitted */
                /* Sanitize input values and store them */
                $user = Validation::sanitiza("username");
                $password = Validation::sanitiza("password");

                /* Get user data */
                $m = new Model();
                $userData = $m->getUser($user);

                /* Check if the user exists on the database and, in that case, log the user */
                if(!empty($userData)){
                    $passwordDB = $userData[0]["password"];

                    /* Gets the user level and checks if the user is enabled to use the app */
                    $level = $userData[0]["level"];

                    if($passwordDB == cryptBlowfish($password)){
                        sessionCookieConf();

                        //Configure the user session
                        sessionConf($user,$level);

                        header("location:index.php?ctl=home");
                    }else{
                        $notValid = true;
                        require __DIR__ . '/templates/login.php';
                    }

                    
                }else{
                    $notValid = true;
                    require __DIR__ . '/templates/login.php';
                }
            }else{
                require __DIR__ . '/templates/login.php';
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }catch(Exception $e){
            echo $e->getMessage();
        }
            
    }

    /* Function that close the session and load the login page */
    public function logout()
    {
        closeSession();
        header("location:index.php?ctl=login");
    }

    /* Function that get reservations with certain parameters and send them to the client */
    public function getDateReservations()
    {
        $date = Validation::sanitiza("date");
        $classroom = Validation::sanitiza("classroom");
        $m = new Model();
        echo json_encode($m->getReservations($classroom,$date));
    }

    public function getReservations()
    {
        $m = new Model();
        echo json_encode($m->getReservations());
    }

    /* I prefer to use a new function only for specific user resverations */
    public function getUserReservations()
    {
        $m = new Model();
        echo json_encode($m->getUserReservations($_SESSION["user"]));
    }

    /* Function that get classrooms and send them to the client */
    public function getClassrooms()
    {
        $m = new Model();
        echo json_encode($m->getClassrooms());
    }

    /* Add a reservation from client calendar */
    public function addReservation()
    {
        $date = Validation::sanitiza("date");
        $classroom = Validation::sanitiza("classroom");
        $range = Validation::sanitiza("range");
        $m = new Model();
        echo $m->addReservation($_SESSION["user"],$classroom,$date,$range) ? true : false;
    }

    /* Deletes a reservation */
    public function deleteReservation()
    {
        $date = Validation::sanitiza("date");
        $classroom = Validation::sanitiza("classroom");
        $range = Validation::sanitiza("range");
        $m = new Model();
        echo $m->deleteReservation($_SESSION["user"],$classroom,$date,$range);
    }

    /* Get the users to send them to client */
    public function getUsers()
    {
        $level = 2;
        $m = new Model();
        echo json_encode($m->getUsers($level));
    }

    public function deleteClassroom()
    {
        $classroom = Validation::sanitiza("classroom");
        $m = new Model();
        echo $m->deleteClassroom($classroom);
    }

    public function addClassroom()
    {
        $classroom = Validation::sanitiza("classroom");
        $description = Validation::sanitiza("description");
        $m = new Model();
        echo $m->addClassroom();
    }
    
}

?>
