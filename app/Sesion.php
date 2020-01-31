
<?php

class Sesion
{
    private static $instance;
    private static $sesion = null;

    private function __construct()
    {
        if(self::$sesion != true){
            session_start();
            self::$sesion = true;
        }
        $_SESSION["level"] = 0;
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function inicializaVariables($user)
    {
        $_SESSION["user"] = $user;
    }
}

?>