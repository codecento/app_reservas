<?php
include ('libs/utils.php');

class Controller
{

    public function error()
    {
        require __DIR__ . '/templates/error.php';
    }

    public function home(){
        require __DIR__ . '/templates/home.php';
    }

    /* Function that checks if login or register were submitted and prepares the session variables. Then calls the index with "index.php?ctl='home'" */
    public function login()
    {
        try{
            if(isset($_REQUEST["register-submit"])){
                $validacion = new Validacion();
            }else if(isset($_REQUEST["login-submit"])){
                /* Sanitize input values and store them */
                $user = Validacion::sanitiza("username");
                $password = Validacion::sanitiza("password");

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

                    if($enabled == 1){
                        if(cryptBlowfish($password) == $passwordDB){
                            header("location:index.php?ctl=home");
                        }else{
                            $notValid = true;
                            require __DIR__ . '/templates/login.php';
                        }
                    }else{
                        $notEnabled = true;
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
        }
            
    }
}

?>
