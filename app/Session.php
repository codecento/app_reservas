
<?php

function sessionConf($user)
{
    $_SESSION["user"] = $user;
}

function initalizeSession()
{

    session_start();
}

function closeSession()
{
    session_unset();
    session_destroy();
}

?>