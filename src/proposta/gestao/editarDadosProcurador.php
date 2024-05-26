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

$id_procurador = intval($_GET['id']);

$sql_dadosProcurador = "SELECT * FROM db_procurador WHERE id_procurador = $id_procurador";
$query_dadosProcurador = $mysqli->query($sql_dadosProcurador) or die($mysqli->error);
$num_dadosProcurador = $query_dadosProcurador->num_rows;
$dadosProcurador = $query_dadosProcurador->fetch_assoc();




if(count($_POST) > 0) {

        $nomeProcurador = $_POST['nameProcurador'];
        $nascimentoProcurador = $_POST['nascimentoProcurador'];
        $estadoCivilProcurador = $_POST['estadoCivilProcurador'];
        $emailProcurador = $_POST['emailProcurador'];
        $telefoneProcurador = $_POST['telefoneProcurador'];
        $rgProcurador = $_POST['rgProcurador'];
        $orgEmissorRGProcurador = $_POST['emissorProcurador'];
        $dataEmissaoRGProcurador = $_POST['dataEmissaoProcurador'];
        $cpfProcurador = $_POST['cpfProcurador'];
        $nomeMaeProcurador = $_POST['nomeMaeProcurador'];
        $nomePaiProcurador = $_POST['nomepaiProcurador'];
        $cepProcurador = $_POST['cepInput4'];
        $cidadeProcurador = $_POST['cidadeuser4'];
        $estadoProcurador = $_POST['estadouser4'];
        $ruaProcurador = $_POST['ruauser4'];
        $complementoProcurador = $_POST['completProcurador'];
        $numeroCasaProcurador = $_POST['numerocasaProcurador'];
        $bairroProcurador = $_POST['bairrouser4'];

        $sql_code = "UPDATE db_procurador SET 
        nome_procurador = '$nomeProcurador', 
        data_nascimento_procurador = '$nascimentoProcurador', 
        estado_civil_procurador = '$estadoCivilProcurador', 
        email_procurador = '$emailProcurador', 
        telefone_procurador = '$telefoneProcurador', 
        documento_procurador = '$rgProcurador', 
        org_emissor = '$orgEmissorRGProcurador', 
        data_emissao = '$dataEmissaoRGProcurador', 
        cpf_procurador = '$cpfProcurador', 
        nome_mae_procurador = '$nomeMaeProcurador', 
        nome_pai_procurador = '$nomePaiProcurador', 
        endereço_procurador = '$ruaProcurador', 
        complemento_casa_procurador = '$complementoProcurador', 
        numero_casa_procurador = '$numeroCasaProcurador', 
        bairro_casa_procurador = '$bairroProcurador', 
        cidade_casa_procurador = '$cidadeProcurador', 
        estado_casa_procurador = '$estadoProcurador', 
        cep_procurador = '$cepProcurador' 
        WHERE id_procurador = '$id_procurador'";
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
}

    if($deu_certo) {
        header("Location: editarProcurador.php?id=$id_procurador");     
        unset($_POST);     
        exit();        
    }
