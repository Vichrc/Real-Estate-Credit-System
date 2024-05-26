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



$sql_userPrimario = "SELECT * FROM usuarios WHERE id  = $idUser";
$query_userPrimario = $mysqli->query($sql_userPrimario) or die($mysqli->error);
$num_userPrimario = $query_userPrimario->num_rows;
$usuarioPrimario = $query_userPrimario->fetch_assoc();

$id_comprador = intval($_GET['id']);

$sql_comprador = "SELECT * FROM db_comprador WHERE id_comprador = $id_comprador";
$query_comprador = $mysqli->query($sql_comprador) or die($mysqli->error);
$num_comprador = $query_comprador->num_rows;
$comprador = $query_comprador->fetch_assoc();


if(isset($id_comprador)){
    if($usuarioPrimario['permissao_usuario'] == 2 || $usuarioPrimario['permissao_usuario'] == 3 || $comprador['id_corretor'] == $idUser) {
                $id_proposta = $comprador['id_proposta'];

                $id_adm_accont = $usuarioPrimario['id'];
                $name_adm_accont = $usuarioPrimario['nome'];
                $activity_adm_AdmAcont = "O comprador id = $id_comprador vinculado a proposta id= $id_proposta foi deletado";
                $dataHoraAtual = date("d/m/Y, \à\s H:i:s");


                $sql_Log = "INSERT INTO log_adm (id_accont, name_accont, activity, date_and_hour) 
                VALUE('$id_adm_accont', '$name_adm_accont', '$activity_adm_AdmAcont', '$dataHoraAtual')";
                $deu_certo_log = $mysqli->query($sql_Log) or die($mysqli->error);

                    if($deu_certo_log) {
                        $sql_code = "DELETE FROM db_comprador WHERE id_comprador = '$id_comprador'"; 
                        $sql_query = $mysqli->query($sql_code) or die($mysqli->$error);
                        if($sql_query) {
                            header ("Location: gestaopropst.php?id=$id_proposta");
                        }
                    }

    } else {

    }
}


?>