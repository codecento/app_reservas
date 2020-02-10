
<?php

function sessionConf($user,$level)
{
    $_SESSION["user"] = $user;
    $_SESSION["level"] = $level;
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