<?php
//Aqui pondremos las funciones de validación de los campos

function validarDatos($n, $e, $p, $hc, $f, $g)
{
    return (is_string($n) &
        is_numeric($e) &
        is_numeric($p) &
        is_numeric($hc) &
        is_numeric($f) &
        is_numeric($g));
}

function cryptBlowfish($pass){
    $salt = '$2a$07$hellothereimencriptedsalt$';
    $pass = crypt($pass,$salt);
    return $pass;
}

function recoge($var)
{
    if (isset($_REQUEST[$var]))
        $tmp=strip_tags(sinEspacios($_REQUEST[$var]));
        else
            $tmp= "";
            
            return $tmp;
}

function sinEspacios($frase) {
    $texto = trim(preg_replace('/ +/', ' ', $frase));
    return $texto;
}
?>