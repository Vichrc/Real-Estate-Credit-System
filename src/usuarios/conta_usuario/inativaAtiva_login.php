<?php

include('../../conect/conect.php');
$erro = "Usuario não encontrado";

if(!isset($_SESSION))
    session_start();

if(isset($_COOKIE['usuario'])){
    $idUser = $_COOKIE['usuario'];
    $PermiUser = $_COOKIE['permissao_usuario'];
    $NomeUser = $_COOKIE['nome'];
} else {
    $idUser = $_SESSION['usuario'];
    $PermiUser = $_SESSION['permissao_usuario'];
    $NomeUser = $_SESSION['nome'];
}


if (isset($_COOKIE['usuario']) || isset($_SESSION['usuario'])) {
    if (isset($_COOKIE['permissao_usuario']) && $_COOKIE['permissao_usuario'] == 0) {
        header("Location: ../../../logout.php");
        exit();
    }

    if (isset($_SESSION['permissao_usuario']) && $_SESSION['permissao_usuario'] == 0) {
        header("Location: ../../../logout.php");
        exit();
    }
} else {
    header("Location: ../../../login.php");
    exit();
}


$id_usuario = intval($_GET['id']);
$inativo = 5;
$ativo = 1;

$sql_usuario = "SELECT * FROM usuarios WHERE id = '$id_usuario'";
$query_usuario = $mysqli->query($sql_usuario) or die($mysqli->error);
$usuario = $query_usuario->fetch_assoc();


if($usuario["permissao_usuario"] == 0 || $usuario["permissao_usuario"] == 5) {
    $sql_code = "UPDATE usuarios SET permissao_usuario ='$ativo' WHERE id = '$id_usuario'";
    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
    
    header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
    exit;
} elseif($usuario["permissao_usuario"] != 0 || $usuario["permissao_usuario"] != 5){
    $sql_code = "UPDATE usuarios SET permissao_usuario ='$inativo' WHERE id = '$id_usuario'";
    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
    
    header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
    exit;
} else {
    Echo $erro;
}