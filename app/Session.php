
<?php

function sessionCookieConf()
{
    ini_set("session.cookie_lifetime","900");
    ini_set("session.gc_maxlifetime","10");
    ini_set("session.gc_probability","1");
    ini_set("session.gc_divisor","1");
}

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

function checkSessionTime()
{
    if(isset($_SESSION["time"])){
        if(time() >= $_SESSION["time"]+900){
            closeSession();
            header("location:index.php?ctl=login&timeout=true");
        }else{
            $_SESSION["time"] = time();
        }
    }else{
        $_SESSION["time"] = time();
    }
}

?>