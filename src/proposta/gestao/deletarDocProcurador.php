<?php

include('../../conect/conect.php');

$id_Proposta = intval($_GET['id']);

$doc = $_GET['doc'];

if(!isset($_SESSION))
    session_start();


if (isset($_COOKIE['usuario']) || isset($_SESSION['usuario'])) {
    if (isset($_COOKIE['permissao_usuario']) && $_COOKIE['permissao_usuario'] == 5 || isset($_COOKIE['permissao_usuario']) && $_COOKIE['permissao_usuario'] == 0) {
        header("Location: ../../../logout.php");
        exit();
    }

    if (isset($_SESSION['permissao_usuario']) && $_SESSION['permissao_usuario'] == 5 || isset($_SESSION['permissao_usuario']) && $_SESSION['permissao_usuario'] == 0) {
        header("Location: ../../../logout.php");
        exit();
    }
} else {
    header("Location: ../../../login.php");
    exit();
}

if(isset($_COOKIE['usuario'])){
    $idUser = $_COOKIE['usuario'];
} elseif(isset($_SESSION['usuario'])){
    $idUser = $_SESSION['usuario'];
}


    $sql_code = "UPDATE  db_doc_proc SET $doc = '' WHERE id_proposta = '$id_Proposta'";
    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
    
    if($deu_certo) {
        header("Location: gestaopropst.php?id=$id_Proposta");     
        unset($_POST);     
        exit();        
    }