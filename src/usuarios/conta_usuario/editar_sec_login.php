<?php
include('../../conect/conect.php');
$erro = false;
$id_usuario = intval($_GET['id']);

if(!isset($_SESSION))
    session_start();

if(isset($_COOKIE['usuario'])){
    $idUser = $_COOKIE['usuario'];
    $PermiUser = $_COOKIE['permissao_usuario'];
    $NomeUser = $_COOKIE['nome'];
} else {
    $idUser = $_SESSION['usuario'];
    $PermiUser = $_SESSION['permissao_usuario'];
    $NomeUser = $_SESSION['nome'];
}

if (isset($_COOKIE['usuario']) || isset($_SESSION['usuario'])) {
    if (isset($_COOKIE['permissao_usuario']) && $_COOKIE['permissao_usuario'] == 0) {
        header("Location: ../../../logout.php");
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


if(count($_POST) > 0) {
    $nomeUser = $mysqli->escape_string($_POST['fullname']);
    $nascimentoUser = $mysqli->escape_string($_POST['nascdate']);
    $telUser = $mysqli->escape_string($_POST['contactuser']);
    $emailUser =  $mysqli->escape_string($_POST['emailuser']);

    $sql_code_email = "SELECT * FROM usuarios WHERE email = '$emailUser'";
    $sql_query_email = $mysqli->query($sql_code_email) or die($mysqli->$error);
    $num_useremail = $sql_query_email->num_rows;

    $sql_code_user = "SELECT * FROM usuarios WHERE id = '$id_usuario'";
    $sql_query_user = $mysqli->query($sql_code_user) or die($mysqli->$error);
    $num_user_user = $sql_query_user->num_rows;
    $UsuarioSecundario = $sql_query_user->fetch_assoc();

        if($num_useremail < 1){
            $sql_code = "UPDATE usuarios SET nome = '$nomeUser', nascimento = '$nascimentoUser', telefone_celular = '$telUser', email = '$emailUser' WHERE id = '$id_usuario'";
            $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
            
            if($deu_certo) {
                header('Location: creact_sec_login.php');     
                unset($_POST);     
                exit();        
            }
        } else {

            if($UsuarioSecundario['email'] == $emailUser){
                $sql_code = "UPDATE usuarios SET nome = '$nomeUser', nascimento = '$nascimentoUser', telefone_celular = '$telUser', email = '$emailUser' WHERE id = '$id_usuario'";
                $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
                
                if($deu_certo) {
                    header('Location: creact_sec_login.php');     
                    unset($_POST);     
                    exit();        
                }
            }else{
                echo "
                <script>
                    alert('E-mail já cadastrado');
                    window.location.href='creact_sec_login.php';
                </script>";
            }
        }  
}