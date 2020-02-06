<?php
// web/index.php
// carga del modelo y los controladores
require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Model.php';
require_once __DIR__ . '/../app/Controller.php';
require_once __DIR__ . '/../app/Session.php';

initalizeSession();

//routing
$map = array(
    'login' => array('controller' => 'Controller', 'action'=>'login'),
    'home' => array('controller' =>'Controller', 'action' =>'home'),
    'error' => array('controller' =>'Controller', 'action' =>'error'),
    'logout' => array('controller' => 'Controller', 'action' => 'logout'),
    'getReservations' => array('controller' => 'Controller', 'action' => 'getReservations')
);

// parsing route
if (isset($_SESSION["user"])) {
    if (isset($_GET['ctl'])){
        if (isset($map[$_GET['ctl']])) {
            if($_GET['ctl'] != 'login')
                $ruta = $_GET['ctl'];
            else
                $ruta = 'home';
        } else {
            $ruta = 'error';
        }
    }else{
        $ruta = 'home';
    }
    
} else {
    $ruta = 'login';
}
$controlador = $map[$ruta];
// Ejecución del controlador asociado a la ruta
if (method_exists($controlador['controller'],$controlador['action'])) {
    call_user_func(array(new $controlador['controller'],
        $controlador['action']));
}else {
    header('Status: 404 Not Found');
    echo '<html><body><h1>Error 404: The controller <i>' .
        $controlador['controller'] .
        '->' .
        $controlador['action'] .
        '</i> does not exist.</h1></body></html>';
}
?>