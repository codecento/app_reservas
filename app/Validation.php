<?php

/**
 * Clase para realizar validaciones en el modelo
 * Es utilizada para realizar validaciones en el modelo de nuestras clases.
 *
 * @author Carlos Belisario
 */
class Validation
{
    protected $_atributos;
    protected $_error;
    public $message;

    /**
     * Metodo para indicar la regla de validacion
     * El método retorna un valor verdadero si la validación es correcta, de lo contrario retorna el objeto
     * actual, permitiendo acceder al atributo Validacion::$message ya que es publico
     */
    public function rules($rule = array(), &$data,$sanitizar=false)
    {
        //Sanitiza si es true
        if($sanitizar == true){
            foreach($data as $key => $value){
                $data[$key] = Validacion::sanitiza($key);
            }
        }   
        
        if (!is_array($rule)) {
            $this->mensaje = "las reglas deben de estar en formato de arreglo";
            return $this;
        }

        $result = true;
        foreach ($rule as $key => $rules) {
            $reglas = explode(',', $rules['regla']);
            if (array_key_exists($rules['name'], $data)) {
                foreach ($data as $indice => $valor) {
                    if ($indice === $rules['name']) {
                        foreach ($reglas as $valores) {
                            $validator = $this->_getInflectedName($valores);
                            if (!is_callable(array($this, $validator))) {
                                throw new BadMethodCallException("No se encontro el metodo actual $valores");
                            }

                            $check = $this->$validator($rules['name'], $valor);

                            if(!$check)
                                $result = $check; //Si hay algún campo que no tenga un valor correcto, esta variable se le asignará false. De la otra forma, machacabas el valor constantemente 
                        }
                        break;
                    }
                }
            } else {
                $this->message[$rules['name']] = "el campo" . $rules["name"] . "no esta dentro de la regla de validación o en el formulario";
            }
        }
        if (!$result) {
            return $this;
        } else {
            return true;
        }
    }

    public static function sanitiza($var)
    {
        if (isset($_REQUEST[$var])){
            $tmp = strip_tags(sinEspacios($_REQUEST[$var]));
        }
        else
            $tmp = "";

        return $tmp;
    }

    /**
     * Metodo inflector de la clase
     * por medio de este metodo llamamos a las reglas de validacion que se generen
     */
    private function _getInflectedName($text)
    {
        $validator = "";
        $_validator = preg_replace('/[^A-Za-z0-9]+/', ' ', $text);
        $arrayValidator = explode(' ', $_validator);
        if (count($arrayValidator) > 1) {
            foreach ($arrayValidator as $key => $value) {
                if ($key == 0) {
                    $validator .= "_" . $value;
                } else {
                    $validator .= ucwords($value);
                }
            }
        } else {
            $validator = "_" . $_validator;
        }
        return $validator;
    }
/*
function campoImagen()
{
    if ($_FILES[$nombre]['error'] != 0) {
        switch ($_FILES[$nombre]['error']) {
            case 1:
                $errores[$nombre] = "Fichero demasiado grande";
                break;
            case 2:
                $errores[$nombre] = 'El fichero es demasiado grande';
                break;
            case 3:
                $errores[$nombre] = 'El fichero no se ha podido subir entero';
                break;
            case 4:
                $errores[$nombre] = 'No se ha podido subir el fichero';
                break;
            case 6:
                $errores[$nombre] = "Falta carpeta temporal";
                break;
            case 7:
                $errores[$nombre] = "No se ha podido escribir en el disco";
                break;
            default:
                $errores[$nombre] = 'Error indeterminado.';
        }
        return false;
    } else {

        $nombreArchivo = $_FILES[$nombre]['name'];
        $directorioTemp = $_FILES[$nombre]['tmp_name'];
        $extension = $_FILES['imagen']['type'];
        if (! in_array($extension, $extensionesValidas)) {
            $errores[$nombre] = "La extensión del archivo no es válida o no se ha subido ningún archivo <br>";
            return 0;
        }

        if (! isset($errores[$nombre])) {
            $nombreArchivo = $dir . $usuario;

            if (is_dir($dir))
                if (move_uploaded_file($directorioTemp, $nombreArchivo)) {
                    return $nombreArchivo;
                } else {
                    $errores[$nombre] = "Error: No se puede mover el fichero a su destino";
                    return 0;
                }
            else
                $errores[] = "Error: No se puede mover el fichero a su destino";
        }
    }
}*/

    /**
     * Metodo de verificacion de que el dato no este vacio o NULL
     * El metodo retorna un valor verdadero si la validacion es correcta de lo contrario retorna un valor falso
     * y llena el atributo validacion::$message con un arreglo indicando el campo que mostrara el mensaje y el
     * mensaje que visualizara el usuario
     */
    protected function _noEmpty($campo, $valor)
    {
        if (isset($valor) && !empty($valor)) {
            return true;
        } else {
            $this->mensaje[$campo][] = "el campo $campo debe de estar lleno";
            return false;
        }
    }
    /**
     * Metodo de verificacion de tipo numerico
     * El metodo retorna un valor verdadero si la validacion es correcta de lo contrario retorna un valor falso
     * y llena el atributo validacion::$message con un arreglo indicando el campo que mostrara el mensaje y el
     * mensaje que visualizara el usuario
     */
    protected function _numeric($campo, $valor)
    {
        if (is_numeric($valor)) {
            return true;
        } else {
            $this->mensaje[$campo] = "el campo $campo debe de ser numerico";
            return false;
        }
    }

    protected function _password($campo, $valor)
    {
        if (! preg_match("/^[A-Za-z0-9]{8,}$/", $valor)){
            $this->mensaje[$campo] = "el campo $campo debe de contener letras y numeros, y tener al menos 8 caracteres";
            return false;
        }
        else
            return true;
    }


    protected function _user($campo, $valor){
        if (! preg_match("/^[A-Za-z0-9]{7,15}$/", $valor)){
            $this->mensaje[$campo] = "el campo $campo debe de contener letras y numeros, y tener entre 7 y 15 caracteres";
            return false;
        }
        else
            return true;
    }

    protected function _text($campo, $valor){
        if (! preg_match("/^[A-Za-z]{7,15}$/", $valor)){
            $this->mensaje[$campo] = "el campo $campo debe de contener letras y tener entre 7 y 15 caracteres";
            return false;
        }
        else
            return true;
    }

    /**
     * Metodo de verificacion de tipo email
     * El metodo retorna un valor verdadero si la validacion es correcta de lo contrario retorna un valor falso
     * y llena el atributo validacion::$message con un arreglo indicando el campo que mostrara el mensaje y el
     * mensaje que visualizara el usuario
     */
    protected function _email($campo, $valor)
    {
        if (preg_match("/^[a-z]+([\.]?[a-z0-9_-]+)*@[a-z]+([\.-]+[a-z0-9]+)*\.[a-z]{2,}$/", $valor)) {
            return true;
        } else {
            $this->mensaje[$campo] = "El email ha de estar en el formato de email usuario@servidor.com";
            return false;
        }
    }
}

/*
$_POST['campo1'] = "v";
$_POST['campo2'] = "usuario@hotmail.com";

$datos = $_POST;

$validacion =  new Validacion();

$regla = array(
    array('name' => 'campo1', 'regla' => 'noempty,numeric'),
    array('name' => 'campo2', 'regla' => 'no-empty,email')
);

try {
    $validaciones = $validacion->rules($regla, $datos);

    if(isset($validaciones->mensaje)){
        foreach($validaciones->mensaje as $campo => $texto){
            echo "<p>$texto</p>";
        }
    }
} catch (BadMethodCallException $e) {
    echo $e->getMessage();
}
*/