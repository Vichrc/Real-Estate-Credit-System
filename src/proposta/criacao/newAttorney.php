<?php

$erro = false;

include('../../conect/conect.php');

if(!isset($_SESSION))
session_start();

if(isset($_COOKIE['usuario'])){
    $idUser = $_COOKIE['usuario'];
} elseif(isset($_SESSION['usuario'])){
    $idUser = $_SESSION['usuario'];
}

if(isset($_COOKIE['usuario'])){
    $name=$_COOKIE['nome'];
} else {
    $name=$_SESSION['nome'];
}

if(count($_POST) > 0) {
    $id_proposta = intval($_GET['id']);

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
   
  
    if($erro){
        echo "<p><b>ERRO: $erro</b></p>";
    } else{

        $sql_code = "INSERT INTO db_procurador (id_corretor, id_proposta, nome_procurador, data_nascimento_procurador, estado_civil_procurador, email_procurador, telefone_procurador, documento_procurador, org_emissor, data_emissao, cpf_procurador, nome_mae_procurador, nome_pai_procurador, endereço_procurador, complemento_casa_procurador, numero_casa_procurador, bairro_casa_procurador, cidade_casa_procurador, estado_casa_procurador, cep_procurador, data) 
        VALUE('$idUser', '$id_proposta', '$nomeProcurador', '$nascimentoProcurador', '$estadoCivilProcurador', '$emailProcurador', '$telefoneProcurador', '$rgProcurador', '$orgEmissorRGProcurador', '$dataEmissaoRGProcurador', '$cpfProcurador', '$nomeMaeProcurador', '$nomePaiProcurador', '$ruaProcurador', '$complementoProcurador', '$numeroCasaProcurador', '$bairroProcurador', '$cidadeProcurador', '$estadoProcurador', '$cepProcurador', NOW())";
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
    
        if($deu_certo) {
            header("Location: ../gestao/gestaopropst.php?id=$id_proposta");
            unset($_POST);
        } 
    }





}
