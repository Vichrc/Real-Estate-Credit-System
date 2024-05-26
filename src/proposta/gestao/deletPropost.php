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

if(isset($_COOKIE['usuario'])){
    $idUser = $_COOKIE['usuario'];
} elseif(isset($_SESSION['usuario'])){
    $idUser = $_SESSION['usuario'];
}

$id_proposta = intval($_GET['id']);




$sql_userADM = "SELECT * FROM usuarios WHERE id  = $idUser";
$query_userADM = $mysqli->query($sql_userADM) or die($mysqli->error);
$num_userADM = $query_userADM->num_rows;
$usuarioADM = $query_userADM->fetch_assoc();


$sql_MyPropost = "SELECT * FROM db_propostas WHERE id_proposta = $id_proposta";
$query_MyPropost = $mysqli->query($sql_MyPropost) or die($mysqli->error);
$num_MyPropost = $query_MyPropost->num_rows;
$dadosPropost = $query_MyPropost->fetch_assoc();

$cpfComprad = $dadosPropost['cpf_comprador'];

$id_adm_accont = $usuarioADM['id'];
$name_adm_accont = $usuarioADM['nome'];
$activity_adm_AdmAcont = "Proposta de número id = $id_proposta vinculada ao CPF de $cpfComprad foi deletada";
$dataHoraAtual = date("d/m/Y, \à\s H:i:s");


$sql_Log = "INSERT INTO log_adm (id_accont, name_accont, activity, date_and_hour) 
VALUE('$id_adm_accont', '$name_adm_accont', '$activity_adm_AdmAcont', '$dataHoraAtual')";
$deu_certo_log = $mysqli->query($sql_Log) or die($mysqli->error);

    if($deu_certo_log) {
        $sql_code = "DELETE FROM db_propostas WHERE id_proposta = '$id_proposta'"; 
        $sql_query = $mysqli->query($sql_code) or die($mysqli->$error);
        if($sql_query) {
            header ("Location: admPropost.php");
        }
    }

?>