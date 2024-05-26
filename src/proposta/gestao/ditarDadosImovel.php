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



if(count($_POST) > 0) {
    $descricaoImovel = $mysqli->escape_string($_POST['DescrImovel']);
    $matriculaImovel = $mysqli->escape_string($_POST['MatImovel']);
    $cepImovel = $mysqli->escape_string($_POST['cepuser']);
    $logradouroImovel = $mysqli->escape_string($_POST['ruauser']);
    $numeroImovel = $mysqli->escape_string($_POST['numberHome']);
    $bairroImovel = $mysqli->escape_string($_POST['bairrouser']);
    $cidadeImovel = $mysqli->escape_string($_POST['cidadeuser']);
    $estadoImovel = $mysqli->escape_string($_POST['estadouser']);
    $tipoImovel = $mysqli->escape_string($_POST['selectType']);
    $valorImovel = $mysqli->escape_string($_POST['valorImovel']);
    $totalFinanciado = $mysqli->escape_string($_POST['valorFinanciado']);
    $fgtsUsadoImovel = $mysqli->escape_string($_POST['fgtsImovel']);

    $sql_code = "UPDATE db_propostas SET descrição_imovel = '$descricaoImovel', matricula_imovel = '$matriculaImovel', cep_home = '$cepImovel', endereço_imovel = '$logradouroImovel', number_home = '$numeroImovel', cidade_imovel = '$cidadeImovel', estado_imovel = '$estadoImovel', tipo_imovel = '$tipoImovel', bairro_imovel = '$bairroImovel', valor_imovel = '$valorImovel', financiado = '$totalFinanciado', valor_fgts = '$fgtsUsadoImovel' WHERE id_proposta = '$id_proposta'";
    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
    
    if($deu_certo) {
        header("Location: gestaopropst.php?id=$id_proposta");     
        unset($_POST);     
        exit();        
    }
}