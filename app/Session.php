
<?php

function sessionConf($user)
{
    $_SESSION["user"] = $user;
}

function initalizeSession(){

    session_start();
}

?>