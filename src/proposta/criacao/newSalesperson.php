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
    if(isset($_POST['epf'])) {
        $epj = $_POST['epf'];
    } else {
        $epj = "não";
    }
    $nameVendedor = $_POST['nameVendedor'];
    $nascimentoVendedor = $_POST['nascimentoVendedor'];
    $estadoCivilVendedor = $_POST['estadoCivilVendedor'];
    $emailVendedor = $_POST['emailVendedor'];
    $telefoneVendedor = $_POST['telefoneVendedor'];
    $rgVendedor = $_POST['rgVendedor'];
    $emissorVendedor = $_POST['emissorVendedor'];
    $dataEmissaoVendedor = $_POST['dataEmissaoVendedor'];
    $cpfVendedor = $_POST['cpfVendedor'];
    $nomeMaeVendedor = $_POST['nomeMaeVendedor'];
    $nomepaiVendedor = $_POST['nomepaiVendedor'];

        $nomeVendedorPj = $_POST['nomeVendedorPj'];
        $cnpjVendedorPJ = $_POST['cnpjVendedorPJ'];
        $emailVendedorPJ = $_POST['emailVendedorPJ'];
        $telefoneVendedorPj = $_POST['telefoneVendedorPj'];
        $representantePj = $_POST['representantePj'];
        $cpjRepresentanteCNPJ = $_POST['cpjRepresentanteCNPJ'];

        $nameConjugue = $_POST['nameConjugueVendedor'];
        $nascimentoConjugue = $_POST['nascimentoConjugueVendedor'];
        $emailConjugue = $_POST['emailConjugueVendedor'];
        $telefoneConjugue = $_POST['telefoneConjugueVendedor'];
        $rgConjugue = $_POST['rgConjugueVendedor'];
        $emissorConjugue = $_POST['emissorConjugueVendedor'];
        $dataEmissaoConjugue = $_POST['dataEmissaoConjugueVendedor'];
        $cpfConjugue = $_POST['cpfConjugueVendedor'];
        $nomeMaeConjugue = $_POST['nomeMaeConjugueVendedor'];
        $nomepaiConjugue = $_POST['nomepaiConjugueVendedor'];


    $cepuser2 = $_POST['cepuser3'];
    $cidadeuser2 = $_POST['cidadeuser3'];
    $estadouser2 = $_POST['estadouser3'];
    $ruauser2 = $_POST['ruauser3'];
    $completVendedor = $_POST['completVendedor'];
    $numerocasaVendedor = $_POST['numerocasaVendedor'];
    $bairrouser2 = $_POST['bairrouser3'];
    $profissaoVendedor = $_POST['profissaoVendedor'];
    $bancoVendedor = $_POST['bancoVendedor'];
    $agenciaVendedor = $_POST['agenciaVendedor'];
    $contaVendedor = $_POST['contaVendedor'];

    if($erro){
        echo "<p><b>ERRO: $erro</b></p>";
    } else{
        if($epj == "Sim") {
            $sql_code = "INSERT INTO db_vendedor (id_corretor, id_proposta, e_pj, nome_empresarial, cnpj_vendedor, email_cnpj, telefone_cnpj, nome_repre_vendedor, cpf_representante_cnpj, endereço_vendedor, complemento_casa_vendedor, numero_casa_vendedor, bairro_casa_vendedor, cidade_casa_vendedor, estado_casa_vendedor, cep_vendedor, banco_vendedor, agencia_vendedor, conta_vendedor, data) 
                VALUE('$idUser', '$id_proposta', '$epj', '$nomeVendedorPj', '$cnpjVendedorPJ', '$emailVendedorPJ', '$telefoneVendedorPj', '$representantePj', '$cpjRepresentanteCNPJ','$ruauser2', '$completVendedor', '$numerocasaVendedor', '$bairrouser2', '$cidadeuser2', '$estadouser2', '$cepuser2', '$bancoVendedor', '$agenciaVendedor', '$contaVendedor', NOW())";
                $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        } else {

            if($estadoCivilVendedor == "casado"){
                $sql_code = "INSERT INTO db_vendedor (id_corretor, id_proposta, nome_vendedor, data_nascimento_vendedor, estado_civil_vendedor, nome_conjugue, nascimento_conjugue, email_conjugue, telefone_conjugue, rg_conjugue, orgao_emissor_conjugue, data_emissao_conjugue, cpf_conjugue, nome_mae_conjugue, nome_pai_conjugue, email_vendedor, telefone_vendedor, documento_vendedor, org_emissor, data_emissao, cpf_vendedor, nome_mae_vendedor, nome_pai_vendedor, endereço_vendedor, complemento_casa_vendedor, numero_casa_vendedor, bairro_casa_vendedor, cidade_casa_vendedor, estado_casa_vendedor, cep_vendedor, profissao_vendedor, pis_vendedor, data_admissao_vendedor, empregador_vendedor, cnpj_empregador_vendedor, banco_vendedor, agencia_vendedor, conta_vendedor, data) 
                VALUE('$idUser', '$id_proposta', '$nameVendedor', '$nascimentoVendedor', '$estadoCivilVendedor', '$nameConjugue', '$nascimentoConjugue', '$emailConjugue', '$telefoneConjugue', '$rgConjugue', '$emissorConjugue', '$dataEmissaoConjugue', '$cpfConjugue', '$nomeMaeConjugue', '$nomepaiConjugue', '$emailVendedor', '$telefoneVendedor', '$rgVendedor', '$emissorVendedor', '$dataEmissaoVendedor', '$cpfVendedor', '$nomeMaeVendedor', '$nomepaiVendedor', '$ruauser2', '$completVendedor', '$numerocasaVendedor', '$bairrouser2', '$cidadeuser2', '$estadouser2', '$cepuser2', '$profissaoVendedor', '$bancoVendedor', '$agenciaVendedor', '$contaVendedor', NOW())";
                $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);

            } else {
                $sql_code = "INSERT INTO db_vendedor (id_corretor, id_proposta, nome_vendedor, data_nascimento_vendedor, estado_civil_vendedor, email_vendedor, telefone_vendedor, documento_vendedor, org_emissor, data_emissao, cpf_vendedor, nome_mae_vendedor, nome_pai_vendedor, endereço_vendedor, complemento_casa_vendedor, numero_casa_vendedor, bairro_casa_vendedor, cidade_casa_vendedor, estado_casa_vendedor, cep_vendedor, profissao_vendedor, pis_vendedor, data_admissao_vendedor, empregador_vendedor, cnpj_empregador_vendedor, banco_vendedor, agencia_vendedor, conta_vendedor, data) 
                VALUE('$idUser', '$id_proposta', '$nameVendedor', '$nascimentoVendedor', '$estadoCivilVendedor', '$emailVendedor', '$telefoneVendedor', '$rgVendedor', '$emissorVendedor', '$dataEmissaoVendedor', '$cpfVendedor', '$nomeMaeVendedor', '$nomepaiVendedor', '$ruauser2', '$completVendedor', '$numerocasaVendedor', '$bairrouser2', '$cidadeuser2', '$estadouser2', '$cepuser2', '$profissaoVendedor', '$bancoVendedor', '$agenciaVendedor', '$contaVendedor', NOW())";
                $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
            }

        }

        if($deu_certo) {
            header("Location: ../gestao/gestaopropst.php?id=$id_proposta");
            unset($_POST);
        } 
    }


}