<?php 
$erro = false;
include('../../conect/conect.php');

if(!isset($_SESSION))
session_start();

if (isset($_COOKIE['usuario']) || isset($_SESSION['usuario'])) {
    if (isset($_COOKIE['permissao_usuario']) && $_COOKIE['permissao_usuario'] == 0) {
        header("Location: ../../logout.php");
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

$sql_code = "DELETE FROM usuarios WHERE id = '$id_usuario'"; 
$sql_query = $mysqli->query($sql_code) or die($mysqli->$error);
if($sql_query) {
    header ("Location: creact_sec_login.php");
}

?>