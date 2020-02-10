<?php
// web/index.php
// carga del modelo y los controladores
require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Model.php';
require_once __DIR__ . '/../app/Controller.php';
require_once __DIR__ . '/../app/Session.php';

session_start();
if(!isset($_SESSION["level"])){
    $_SESSION["level"] = 0;
}

//routing
$map = array(
    'login' => array('controller' => 'Controller', 'action'=>'login',"level" => 0),
    'home' => array('controller' =>'Controller', 'action' =>'home', "level" => 1),
    'reservations' => array('controller' =>'Controller', 'action' =>'reservations', "level" => 1),
    'classrooms' => array('controller' =>'Controller', 'action' =>'classrooms', "level" => 2),
    'error' => array('controller' =>'Controller', 'action' =>'error', "level" => 0),
    'logout' => array('controller' => 'Controller', 'action' => 'logout', "level" => 1),
    'getDateReservations' => array('controller' => 'Controller', 'action' => 'getDateReservations', "level" => 1),
    'getClassrooms' => array('controller' => 'Controller', 'action' => 'getClassrooms', "level" => 1),
    'addReservation' => array('controller' => 'Controller', 'action' => 'addReservation', "level" => 1)
);

// parsing route
if (isset($_GET['ctl'])){
    if (isset($map[$_GET['ctl']])) {
        /*if($_GET['ctl'] != 'login')
            $ruta = $_GET['ctl'];
        else
            $ruta = 'home';*/
        $ruta = $_GET['ctl'];
    } else {
        $ruta = 'error';
    }
}else{
    $ruta = 'login';
}

$controlador = $map[$ruta];

// Ejecución del controlador asociado a la ruta
if (method_exists($controlador['controller'],$controlador['action'])) {
    if($controlador['level'] > $_SESSION["level"]){
        if($_SESSION["level"] == 0)
            header("location:index.php?ctl=login");
        else 
            header("location:index.php?ctl=home");
    }

    call_user_func(array(new $controlador['controller'],$controlador['action']));
}else {
    header('Status: 404 Not Found');
    echo '<html><body><h1>Error 404: The controller <i>' .
        $controlador['controller'] .
        '->' .
        $controlador['action'] .
        '</i> does not exist.</h1></body></html>';
}
?>