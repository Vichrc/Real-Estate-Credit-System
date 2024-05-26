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

$id_comprador = intval($_GET['id']);



if(count($_POST) > 0) {
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


    $sql_code = "UPDATE db_comprador SET 
    nome_comprador = '$nomeComprador', 
    email_comprador = '$emailComprador', 
    telefone_comprador = '$telefoneComprador', 
    rg_comprador = '$rgComprador', 
    org_emissor = '$orgEmissorRGComprador', 
    data_emissao = '$dataEmissaoRGComprador', 
    cpf_comprador = '$cpfComprador', 
    estado_civil__comprador = '$estadoCivilComprador', 
    data_nascimento_comprador = '$nascimentoComprador', 
    complemento_casa_comprador = '$complementoComprador', 
    numero_casa_comprador = '$numeroCasaComprador', 
    bairro_casa_comprador = '$bairroComprador', 
    cidade_casa_comprador = '$cidadeComprador', 
    estado_casa_comprador = '$estadoComprador', 
    cep_comprador = '$cepComprador', 
    nome_mae_comprador = '$nomeMaeComprador', 
    nome_pai_comprador = '$nomePaiComprador', 
    nome_conjuge = '$nomeConjComprador', 
    nascimento_conjuge = '$nascimentoConjComprador', 
    email_conjuge = '$emailConjComprador', 
    telefone_conjuge = '$telefoneConjComprador', 
    rg_conjuge = '$rgConjComprador', 
    emissor_rg_conjuge = '$orgaoEmissorRGConjComprador', 
    data_emissao_conjuge = '$dataEmissaoRGConjComprador', 
    cpf_conjuge = '$cpfConjComprador', 
    nome_mae_conjugue = '$nomeMaeConjComprador', 
    nome_pai_conjugue = '$nomePaiConjComprador', 
    conju_compoe_renda = '$conjComperenda', 
    profissao_conjugue = '$profissaoConjComprador', 
    empregador_conjugue = '$empregadorConjComprador', 
    cnpj_empregador_conjugue = '$cnpjEmpregadorConjComprador', 
    data_admissao_conjugue = '$dataAdmissaoConjComprador', 
    pis_conjugue = '$pisConjComprador', 
    renda_bruta_conjugue = '$rendaBrutaConjComprador', 
    renda_liquida_conjugue = '$rendaLiquidaConjComprador', 
    banco_conjugue = '$bancoConjComprador', 
    agencia_conjugue = '$agenciaConjComprador', 
    conta_conjugue = '$contaCOnjComprador', 
    profissao_comprador = '$profissaoComprador', 
    empregador = '$empregadorComprador', 
    cnpj_empregador = '$cnpjEmpregadorComprador', 
    data_admissao = '$dataAdmissaoComprador', 
    pis = '$pisComprador', 
    tipo_renda = '$tipoDeRendaComprador', 
    renda_bruta_comprador = '$rendaBrutaComprador', 
    renda_liquida_comprador = '$rendaLiquidaComprador', 
    banco_comprador = '$bancoComprador', 
    agencia_comprador = '$agenciaComprador', 
    conta_comprador = '$contaBancaria'
    WHERE id_comprador = '$id_comprador'";
    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
    
    if($deu_certo) {
        header("Location: editarComprador.php?id=$id_comprador");     
        unset($_POST);     
        exit();        
    }
}