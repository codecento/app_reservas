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
        $m = new Model();
        $data = $m->getUser($_SESSION["user"]);
        if($data["enabled"] == 1){
            require __DIR__ . '/templates/home.php';
        }else{
            header("location:index.php?ctl=notenabled");
        }
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
                if($validation === true){
                    //Check if 'confirmed password' is equals to the 'password'
                    if($data["password"] == $data["confirm-password"]){
                        $m = new Model();
                        //If the user does not exists in the database, add the user, configure the session and go to home page. Else, load login page and make visible the error
                        if(empty($m->getUser($data["username"]))){
                            $userData = $m->addUser($data["username"],$data["email"],cryptBlowfish($data["password"]));
                            sessionConf($data["user"]);
                            header("location:index.php?ctl=home");
                        }else{
                            $userExists = true;
                            require __DIR__ . '/templates/login.php';
                        }
                        
                    }else{
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
                    $passwordDB = $userData["password"];

                    /* Gets the user admin and enabled states and checks if the user is enabled to use the app */
                    $enabled = $userData["enabled"];
                    $admin = $userData["admin"];

                    //Configure the user session
                    sessionConf($user);
                    

                    header("location:index.php?ctl=home");
                }else{
                    $notValid = true;
                    require __DIR__ . '/templates/login.php';
                }
            }else{
                require __DIR__ . '/templates/login.php';
            }
        }catch(Exception $e){
            header("location:index.php?ctl=error");
        }
            
    }

    /* Function that close the session and load the login page */
    public function logout()
    {
        closeSession();
        require __DIR__ . "/templates/login.php";
    }

    public function getReservations()
    {
        $m = new Model();
        $reservations = $m->getReservations();
        echo json_encode($reservations);
    }
}

?>
