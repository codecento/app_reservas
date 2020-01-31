<?php
// web/index.php
// carga del modelo y los controladores
require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Model.php';
require_once __DIR__ . '/../app/Controller.php';
require_once __DIR__ . '/../app/Sesion.php';

Sesion::getInstance();

//routing
$map = array(
    'login' => array('controller' => 'Controller', 'action'=>'login'),
    'inicio' => array('controller' =>'Controller', 'action' =>'inicio'),
    'error' => array('controller' =>'Controller', 'action' =>'error')
);
// parsing route
if (isset($_GET['ctl'])) {
    if (isset($map[$_GET['ctl']])) {
        if($_GET['ctl'] != 'login')
            $ruta = $_GET['ctl'];
        else
            $ruta = 'inicio';
    } else {
        $ruta = 'error';
    }
} else {
    $ruta = 'login';
}
$controlador = $map[$ruta];
// Ejecución del controlador asociado a la ruta
if (method_exists($controlador['controller'],$controlador['action'])) {
    call_user_func(array(new $controlador['controller'],
        $controlador['action']));
} else {
    header('Status: 404 Not Found');
    echo '<html><body><h1>Error 404: El controlador <i>' .
        $controlador['controller'] .
        '->' .
        $controlador['action'] .
        '</i> no existe</h1></body></html>';
}
?>