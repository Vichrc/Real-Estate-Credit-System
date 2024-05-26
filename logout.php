<?php
include('src/conect/conect.php');

if(!isset($_SESSION)){
    session_start();
}

setcookie("usuario", '', time()-86400);
setcookie("permissao_usuario", '', time()-86400);
setcookie("nome", '', time()-86400);


session_destroy();
header("Location: login.php");
?>