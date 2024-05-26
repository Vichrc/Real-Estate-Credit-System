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

    $nomeComprador = $_POST['nameComprador'];
    $nascimentoComprador = $_POST['nascimentoComprador'];
    $estadoCivilComprador = $_POST['estadoCivil'];

        $nomeConjComprador = $_POST['nameConjugue'];
        $nascimentoConjComprador = $_POST['nascimentoConjugue'];
        $emailConjComprador = $_POST['emailConjugue'];
        $telefoneConjComprador = $_POST['telefoneConjugue'];
        $rgConjComprador = $_POST['rgConjugue'];
        $orgaoEmissorRGConjComprador = $_POST['emissorConjugue'];
        $dataEmissaoRGConjComprador = $_POST['dataEmissaoConjugue'];
        $cpfConjComprador = $_POST['cpfConjugue'];
        $nomeMaeConjComprador = $_POST['nomeMaeConjugue'];
        $nomePaiConjComprador = $_POST['nomepaiConjugue'];

        if ($_POST['compoerenda'] == "Sim" ){
            $conjComperenda = "sim";
        } else {
            $conjComperenda = "não";
        }
        
        

        $profissaoConjComprador = $_POST['profissaoConj'];
        $dataAdmissaoConjComprador = $_POST['admissaoConj'];
        $pisConjComprador = $_POST['pisConj'];
        $empregadorConjComprador = $_POST['empregadorConj'];
        $cnpjEmpregadorConjComprador = $_POST['cnpjEmpregConj'];
        $tipoRendaConjComprador = $_POST['tipoRendaConjComprador'];
        $rendaBrutaConjComprador = $_POST['rendaBrutaConjComprador'];
        $rendaLiquidaConjComprador = $_POST['rendaLiquidaConjComprador'];
        $bancoConjComprador = $_POST['bancoConju'];
        $agenciaConjComprador = $_POST['agenciaConj'];
        $contaCOnjComprador = $_POST['contaConj'];



    





    $emailComprador = $_POST['emailComprador'];
    $telefoneComprador = $_POST['telefoneComprador'];
    $rgComprador = $_POST['rgComprador'];
    $orgEmissorRGComprador = $_POST['emissorComprador'];
    $dataEmissaoRGComprador = $_POST['dataEmissaoComprador'];
    $cpfComprador = $_POST['cpfComprador'];
    $nomeMaeComprador = $_POST['nomeMaeComprador'];
    $nomePaiComprador = $_POST['nomepaiComprador'];
    $cepComprador = $_POST['cepuser2'];
    $cidadeComprador = $_POST['cidadeuser2'];
    $estadoComprador = $_POST['estadouser2'];
    $ruaComprador = $_POST['ruauser2'];
    $complementoComprador = $_POST['completComprador'];
    $numeroCasaComprador = $_POST['numerocasaComprador'];
    $bairroComprador = $_POST['bairrouser2'];
    $profissaoComprador = $_POST['profissaoComprador'];
    $pisComprador = $_POST['pisComprador'];
    $dataAdmissaoComprador = $_POST['dataAdmissãoComprador'];
    $empregadorComprador = $_POST['empregadorComprador'];
    $cnpjEmpregadorComprador = $_POST['cnpjEmpregadorComprador'];
    $tipoDeRendaComprador = $_POST['tipoRendaComprador'];
    $rendaBrutaComprador = $_POST['rendaBrutaComprador'];
    $rendaLiquidaComprador = $_POST['rendaLiquidaComprador'];
    $bancoComprador = $_POST['bancoComprador'];
    $agenciaComprador = $_POST['agenciaComprador'];
    $contaBancaria = $_POST['contaComprador'];
  
    if($erro){
        echo "<p><b>ERRO: $erro</b></p>";
    } else{

        if($estadoCivilComprador == "casado"){
            if($conjComperenda == "Sim"){
                $sql_code = "INSERT INTO db_comprador (id_corretor, id_proposta, nome_comprador, email_comprador, telefone_comprador, rg_comprador, org_emissor, data_emissao, cpf_comprador, estado_civil__comprador, data_nascimento_comprador, endereco_comprador, complemento_casa_comprador, numero_casa_comprador, bairro_casa_comprador, cidade_casa_comprador, estado_casa_comprador, cep_comprador, nome_mae_comprador, nome_pai_comprador, profissao_comprador, empregador, cnpj_empregador, data_admissao, pis, tipo_renda, renda_bruta_comprador, renda_liquida_comprador, banco_comprador, agencia_comprador, conta_comprador, data, nome_conjuge, nascimento_conjuge, email_conjuge, telefone_conjuge, rg_conjuge, emissor_rg_conjuge, data_emissao_conjuge, cpf_conjuge, nome_mae_conjugue, nome_pai_conjugue, conju_compoe_renda) 
                VALUE('$idUser', '$id_proposta', '$nomeComprador', '$emailComprador', '$telefoneComprador', '$rgComprador', '$orgEmissorRGComprador', '$dataEmissaoRGComprador', '$cpfComprador', '$estadoCivilComprador', '$nascimentoComprador', '$ruaComprador', '$complementoComprador', '$numeroCasaComprador', '$bairroComprador', '$cidadeComprador', '$estadoComprador', '$cepComprador', '$nomeMaeComprador', '$nomePaiComprador', '$profissaoComprador', '$empregadorComprador', '$cnpjEmpregadorComprador', '$dataAdmissaoComprador', '$pisComprador', '$tipoDeRendaComprador', '$rendaBrutaComprador', '$rendaLiquidaComprador', '$bancoComprador', '$agenciaComprador', '$contaBancaria', NOW(), '$nomeConjComprador', '$nascimentoConjComprador', '$emailConjComprador', '$telefoneConjComprador', '$rgConjComprador', '$orgaoEmissorRGConjComprador', '$dataEmissaoRGConjComprador', '$cpfConjComprador', '$nomeMaeConjComprador', '$nomePaiConjComprador', '$conjComperenda')";
                $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
            } else {
                $sql_code = "INSERT INTO db_comprador (id_corretor, id_proposta, nome_comprador, email_comprador, telefone_comprador, rg_comprador, org_emissor, data_emissao, cpf_comprador, estado_civil__comprador, data_nascimento_comprador, endereco_comprador, complemento_casa_comprador, numero_casa_comprador, bairro_casa_comprador, cidade_casa_comprador, estado_casa_comprador, cep_comprador, nome_mae_comprador, nome_pai_comprador, profissao_comprador, empregador, cnpj_empregador, data_admissao, pis, tipo_renda, renda_bruta_comprador, renda_liquida_comprador, banco_comprador, agencia_comprador, conta_comprador, data, nome_conjuge, nascimento_conjuge, email_conjuge, telefone_conjuge, rg_conjuge, emissor_rg_conjuge, data_emissao_conjuge, cpf_conjuge, nome_mae_conjugue, nome_pai_conjugue, conju_compoe_renda, profissao_conjugue, empregador_conjugue, cnpj_empregador_conjugue, data_admissao_conjugue, pis_conjugue, tipoderenda_conjugue, renda_bruta_conjugue, renda_liquida_conjugue, banco_conjugue, agencia_conjugue, conta_conjugue) 
                VALUE('$idUser', '$id_proposta', '$nomeComprador', '$emailComprador', '$telefoneComprador', '$rgComprador', '$orgEmissorRGComprador', '$dataEmissaoRGComprador', '$cpfComprador', '$estadoCivilComprador', '$nascimentoComprador', '$ruaComprador', '$complementoComprador', '$numeroCasaComprador', '$bairroComprador', '$cidadeComprador', '$estadoComprador', '$cepComprador', '$nomeMaeComprador', '$nomePaiComprador', '$profissaoComprador', '$empregadorComprador', '$cnpjEmpregadorComprador', '$dataAdmissaoComprador', '$pisComprador', '$tipoDeRendaComprador', '$rendaBrutaComprador', '$rendaLiquidaComprador', '$bancoComprador', '$agenciaComprador', '$contaBancaria', NOW(), '$nomeConjComprador', '$nascimentoConjComprador', '$emailConjComprador', '$telefoneConjComprador', '$rgConjComprador', '$orgaoEmissorRGConjComprador', '$dataEmissaoRGConjComprador', '$cpfConjComprador', '$nomeMaeConjComprador', '$nomePaiConjComprador', '$conjComperenda', '$profissaoConjComprador', '$empregadorConjComprador', '$cnpjEmpregadorConjComprador', '$dataAdmissaoConjComprador', '$pisConjComprador', '$tipoRendaConjComprador', '$rendaBrutaConjComprador', '$rendaLiquidaConjComprador', '$bancoConjComprador', '$agenciaConjComprador', '$contaCOnjComprador')";
                $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
            }

        } else {
            $sql_code = "INSERT INTO db_comprador (id_corretor, id_proposta, nome_comprador, email_comprador, telefone_comprador, rg_comprador, org_emissor, data_emissao, cpf_comprador, estado_civil__comprador, data_nascimento_comprador, endereco_comprador, complemento_casa_comprador, numero_casa_comprador, bairro_casa_comprador, cidade_casa_comprador, estado_casa_comprador, cep_comprador, nome_mae_comprador, nome_pai_comprador, profissao_comprador, empregador, cnpj_empregador, data_admissao, pis, tipo_renda, renda_bruta_comprador, renda_liquida_comprador, banco_comprador, agencia_comprador, conta_comprador, data) 
            VALUE('$idUser', '$id_proposta', '$nomeComprador', '$emailComprador', '$telefoneComprador', '$rgComprador', '$orgEmissorRGComprador', '$dataEmissaoRGComprador', '$cpfComprador', '$estadoCivilComprador', '$nascimentoComprador', '$ruaComprador', '$complementoComprador', '$numeroCasaComprador', '$bairroComprador', '$cidadeComprador', '$estadoComprador', '$cepComprador', '$nomeMaeComprador', '$nomePaiComprador', '$profissaoComprador', '$empregadorComprador', '$cnpjEmpregadorComprador', '$dataAdmissaoComprador', '$pisComprador', '$tipoDeRendaComprador', '$rendaBrutaComprador', '$rendaLiquidaComprador', '$bancoComprador', '$agenciaComprador', '$contaBancaria', NOW())";
            $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        }
        if($deu_certo) {
            header("Location: ../gestao/gestaopropst.php?id=$id_proposta");
            unset($_POST);
        } 
    }





}
