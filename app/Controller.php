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
        require __DIR__ . '/templates/home.php';
    }

    public function classrooms(){
        echo "hola";
    }

    /* Function that checks if login or register were submitted and prepares the session variables. Then calls the index with "index.php?ctl='home'" */
    public function login()
    {
        try{
            if(isset($_REQUEST["register-submit"])){
                //Data from the register form
                $data = $_POST;

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
                        //If the user does not exists in the database, add the user, configure the session and go to home page. Else, load login page and make visible the error
                        if(empty($m->getUser($data["username"]))){
                            $registered = $m->addUser($data["username"],$data["email"],cryptBlowfish($data["password"]));
                            header("location:index.php?ctl=login");
                        }else{
                            $userExists = true;
                            require __DIR__ . '/templates/login.php';
                        }
                        
                    }else{
                        $passwordMatches = false;
                        require __DIR__ . '/templates/login.php';
                    }
                    
                }else{
                    $message = $validation->message;
                    require __DIR__ . '/templates/login.php';
                }
            
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
        echo json_encode($m->getDateReservations($classroom,$date));
    }

    /* Function that get classrooms and send them to the client */
    public function getClassrooms()
    {
        $m = new Model();
        echo json_encode($m->getClassrooms());
    }

    /*  */
    public function addReservation()
    {
        $date = Validation::sanitiza("date");
        $classroom = Validation::sanitiza("classroom");
        $range = Validation::sanitiza("range");
        $m = new Model();
        return $m->addReservation($_SESSION["user"],$classroom,$date,$range) ? true : false;
    }
}

?>
