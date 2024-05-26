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

$id_vendedor = intval($_GET['id']);

$sql_dadosVendedor = "SELECT * FROM db_vendedor WHERE id_vendedor = $id_vendedor";
$query_dadosVendedor = $mysqli->query($sql_dadosVendedor) or die($mysqli->error);
$num_dadosVendedor = $query_dadosVendedor->num_rows;
$dadosVendedor = $query_dadosVendedor->fetch_assoc();




if(count($_POST) > 0) {



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

    if($dadosVendedor['e_pj'] == "Sim") {

        $nomeVendedorPj = $_POST['nomeVendedorPj'];
        $cnpjVendedorPJ = $_POST['cnpjVendedorPJ'];
        $emailVendedorPJ = $_POST['emailVendedorPJ'];
        $telefoneVendedorPj = $_POST['telefoneVendedorPj'];
        $representantePj = $_POST['representantePj'];
        $cpjRepresentanteCNPJ = $_POST['cpjRepresentanteCNPJ'];


        $sql_code = "UPDATE db_vendedor SET 
        nome_empresarial = '$nomeVendedorPj', 
        cnpj_vendedor = '$cnpjVendedorPJ', 
        email_cnpj = '$emailVendedorPJ', 
        telefone_cnpj = '$telefoneVendedorPj', 
        nome_repre_vendedor = '$representantePj', 
        cpf_representante_cnpj = '$cpjRepresentanteCNPJ', 
        endereço_vendedor = '$ruauser2', 
        complemento_casa_vendedor = '$completVendedor', 
        numero_casa_vendedor = '$numerocasaVendedor', 
        bairro_casa_vendedor = '$bairrouser2', 
        cidade_casa_vendedor = '$cidadeuser2', 
        estado_casa_vendedor = '$estadouser2', 
        cep_vendedor = '$cepuser2', 
        profissao_vendedor = '$profissaoVendedor', 
        banco_vendedor = '$bancoVendedor', 
        agencia_vendedor = '$agenciaVendedor', 
        conta_vendedor = '$contaVendedor'
        WHERE id_vendedor = '$id_vendedor'";
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
    } else {

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

        $sql_code = "UPDATE db_vendedor SET 
        nome_vendedor = '$nameVendedor', 
        data_nascimento_vendedor = '$nascimentoVendedor', 
        estado_civil_vendedor = '$estadoCivilVendedor', 
        email_vendedor = '$emailVendedor', 
        telefone_vendedor = '$telefoneVendedor', 
        documento_vendedor = '$rgVendedor', 
        org_emissor = '$emissorVendedor', 
        data_emissao = '$dataEmissaoVendedor', 
        cpf_vendedor = '$cpfVendedor', 
        nome_mae_vendedor = '$nomeMaeVendedor', 
        nome_pai_vendedor = '$nomepaiVendedor', 
        nome_conjugue = '$nameConjugue', 
        nascimento_conjugue = '$nascimentoConjugue', 
        email_conjugue = '$emailConjugue', 
        telefone_conjugue = '$telefoneConjugue', 
        rg_conjugue = '$rgConjugue', 
        orgao_emissor_conjugue = '$emissorConjugue', 
        data_emissao_conjugue = '$dataEmissaoConjugue', 
        cpf_conjugue = '$cpfConjugue', 
        nome_mae_conjugue = '$nomeMaeConjugue', 
        nome_pai_conjugue = '$nomepaiConjugue', 
        endereço_vendedor = '$ruauser2', 
        complemento_casa_vendedor = '$completVendedor', 
        numero_casa_vendedor = '$numerocasaVendedor', 
        bairro_casa_vendedor = '$bairrouser2', 
        cidade_casa_vendedor = '$cidadeuser2', 
        estado_casa_vendedor = '$estadouser2', 
        cep_vendedor = '$cepuser2', 
        profissao_vendedor = '$profissaoVendedor', 
        banco_vendedor = '$bancoVendedor', 
        agencia_vendedor = '$agenciaVendedor', 
        conta_vendedor = '$contaVendedor'
        WHERE id_vendedor = '$id_vendedor'";
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
    }
    if($deu_certo) {
        header("Location: editarVendedor.php?id=$id_vendedor");     
        unset($_POST);     
        exit();        
    }
}