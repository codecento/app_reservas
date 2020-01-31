<?php
include ('libs/utils.php');
include ('validacion.php');
include ('Sesion.php');

class Controller
{

    public function inicio()
    {
        $params = array(
            'mensaje' => 'Bienvenido al repositorio de alimentos',
            'fecha' => date('d-m-yyy')
        );
        require __DIR__ . '/templates/inicio.php';
    }

    public function error()
    {
        require __DIR__ . '/templates/error.php';
    }

    public function listar()
    {
        try {
            $m = new Model();
            $params = array(
                'alimentos' => $m->dameAlimentos()
            );

            // Recogemos los dos tipos de excepciones que se pueden producir
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/templates/mostrarAlimentos.php';
    }

    public function insertar()
    {
        try {
            $params = array(
                'nombre' => '',
                'energia' => '',
                'proteina' => '',
                'hc' => '',
                'fibra' => '',
                'grasa' => ''
            );

            if (isset($_POST['insertar'])) {
                
                $datos = $_POST;
                $reglas = array(
                    array('name' => 'nombre', 'regla' => 'no-empty,texto'),
                    array('name' => 'energia', 'regla' => 'no-empty,numeric'),
                    array('name' => 'proteina', 'regla' => 'no-empty,numeric'),
                    array('name' => 'hc', 'regla' => 'no-empty,numeric'),
                    array('name' => 'fibra', 'regla' => 'no-empty,numeric'),
                    array('name' => 'grasa', 'regla' => 'no-empty,numeric')
                );

                //Borra el submit del array
                array_pop($datos);

                //Comprueba campos formulario
                $validador = new Validacion();
                $validaciones = $validador->rules($reglas, $datos,true);

                $nombre = $datos["nombre"];
                $energia = $datos["energia"];
                $proteina = $datos["proteina"];
                $hc = $datos["hc"];
                $fibra = $datos["fibra"];
                $grasa = $datos["grasa"];
                
                if ($validaciones === true) {
                    // Si no ha habido problema creo modelo y hago inserción
                    $m = new Model();
                    if ($m->insertarAlimento($nombre, $energia, $proteina, $hc, $fibra, $grasa)) {
                        header('Location: index.php?ctl=listar');
                    } else {
                        $params = array(
                            'nombre' => $nombre,
                            'energia' => $energia,
                            'proteina' => $proteina,
                            'hc' => $hc,
                            'fibra' => $fibra,
                            'grasa' => $grasa
                        );
                        $params['mensaje'] = 'No se ha podido insertar el alimento. Revisa el formulario';
                    }
                } else {
                    $params = array(
                        'nombre' => $nombre,
                        'energia' => $energia,
                        'proteina' => $proteina,
                        'hc' => $hc,
                        'fibra' => $fibra,
                        'grasa' => $grasa
                    );
                    $params['mensaje'] = 'Hay datos que no son correctos. Revisa el formulario';
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/templates/formInsertar.php';
    }

    public function login()
    {
        try{
            if(isset($_POST["acceder"])){
                $validador = new Validacion();
                $usuario = Validacion::sanitiza("usuario");
                $contraseña = Validacion::sanitiza("contraseña");
                $error = false;
                $m = new Model();
                if($m->validaUsuario($usuario,$contraseña)){
                    Sesion::getInstance()->inicializaVariables($usuario,$m->obtenerNivelUsuario($usuario));
                    header("location:index.php?ctl=inicio");
                }else{
                    $error = true;
                    require __DIR__ . '/templates/login.php';
                }
            }else{
                require __DIR__ . '/templates/login.php';
            }
        
        }catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }
    }

    public function buscarPorEnergia()
    {
        try {
            $params = array(
                'energia' => '',
                'resultado' => array()
            );
            $m = new Model();
            if (isset($_POST['buscarEnergia'])) {
                $energia = Validacion::sanitiza("energia");
                $params['nombre'] = $energia;
                $params['resultado'] = $m->buscarAlimentosPorEnergia($energia);
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/templates/buscarAlimentosPorEnergia.php';
    }

    public function buscarPorNombre()
    {
        try {
            $params = array(
                'nombre' => '',
                'resultado' => array()
            );
            $m = new Model();
            if (isset($_POST['buscar'])) {
                $nombre = Validacion::sanitiza("nombre");
                $params['nombre'] = $nombre;
                $params['resultado'] = $m->buscarAlimentosPorNombre($nombre);
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/templates/buscarPorNombre.php';
    }

    public function buscarCombinada()
    {
        try {
            $params = array(
                'energia' => '',
                'proteina' => '',
                'hcarbono' => '',
                'fibra' => '',
                'grasa' => '',
                'resultado' => array()
            );
            $m = new Model();
            if (isset($_POST['buscarCombinada'])) {
                $energia = Validacion::sanitiza("energia");
                $proteina = Validacion::sanitiza("proteina");
                $hcarbono = Validacion::sanitiza("hcarbono");
                $fibra = Validacion::sanitiza("fibra");
                $grasa = Validacion::sanitiza("grasa");
                $params['energia'] = $energia;
                $params['proteina'] = $proteina;
                $params['hcarbono'] = $hcarbono;
                $params['fibra'] = $fibra;
                $params['grasa'] = $grasa;
                $params['resultado'] = $m->buscarAlimentosCombinada($energia,$proteina,$hcarbono,$fibra,$grasa);
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/templates/buscarAlimentosCombinada.php';
    }

    public function ver()
    {
        try{
        if (! isset($_GET['id'])) {
            throw new Exception('Página no encontrada');
        }
        $id = Validacion::sanitiza("id");
        $m = new Model();
        $alimento = $m->dameAlimento($id);
        $params = $alimento;
        }catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }
        
            
          
        require __DIR__ . '/templates/verAlimento.php';
    }
}

?>
