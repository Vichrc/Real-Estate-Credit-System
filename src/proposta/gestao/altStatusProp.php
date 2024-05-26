<?php
include('../../conect/conect.php');
$errodoc = false;

$idperfil = $mysqli->escape_string($_POST['idUser']);
$idProposta =  $mysqli->escape_string($_POST['idProposta']);
$statusProposta =  $mysqli->escape_string($_POST['statusProposta']);
$bancoAprovador =  $mysqli->escape_string($_POST['bancoAprovador']);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php';

if(!isset($_SESSION))
    session_start();


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


if(isset($_COOKIE['usuario'])){
    $PermissaoUser = $_COOKIE['permissao_usuario'];
} elseif(isset($_SESSION['usuario'])){
    $PermissaoUser = $_SESSION['permissao_usuario'];
}

if($PermissaoUser === "2" || $PermissaoUser === "3"){

} else {
    header("Location: ../../../logout.php");
    exit();
}


if(isset($_COOKIE['usuario'])){
    $idUser = $_COOKIE['usuario'];
} elseif(isset($_SESSION['usuario'])){
    $idUser = $_SESSION['usuario'];
}


$sql_userPrimario = "SELECT * FROM usuarios WHERE id  = $idperfil";
$query_userPrimario = $mysqli->query($sql_userPrimario) or die($mysqli->error);
$num_userPrimario = $query_userPrimario->num_rows;
$usuarioPrimario = $query_userPrimario->fetch_assoc();

$sql_dadosProposta = "SELECT * FROM db_propostas WHERE id_proposta = $idProposta";
$query_dadosProposta = $mysqli->query($sql_dadosProposta) or die($mysqli->error);
$num_dadosProposta = $query_dadosProposta->num_rows;
$dadosProposta = $query_dadosProposta->fetch_assoc();


$nomeComprador = $dadosProposta["nome_comprador"]; 

$id_adm_accont = $usuarioPrimario['id'];
$name_adm_accont = $usuarioPrimario['nome'];
$id_propst = $dadosProposta['id_proposta'];
$activity_adm_AdmAcont = "Status da proposta alterado para $statusProposta no banco $bancoAprovador";
$dataHoraAtual = date("d/m/Y, \à\s H:i:s");


$sql_Log = "INSERT INTO log_propostas (id_proposta, id_user, name_user, activity, date_and_hour) 
            VALUES ('$id_propst', '$id_adm_accont', '$name_adm_accont', '$activity_adm_AdmAcont', '$dataHoraAtual')";
$deu_certo_log = $mysqli->query($sql_Log) or die($mysqli->error);


if(count($_POST) > 0) {
                $data_Att = date('d/m/Y');
                
                $sql_code = "UPDATE db_propostas SET status_proposta = '$statusProposta', banco_aprov = '$bancoAprovador', data_criacao = '$data_Att'
                WHERE id_proposta = '$idProposta'";
                $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
                
                if($deu_certo) {
                    $mail = new PHPMailer(true);
                    $mail->CharSet = "UTF-8";
                
                    try {
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                        $mail->isSMTP();                                            
                        $mail->Host       = 'smtp.gmail.com';                     
                        $mail->SMTPAuth   = true;                                   
                        $mail->Username   = 'notreply.aprovacredi@gmail.com';                    
                        $mail->Password   = 'nuuwqnnehmbbkgkv';     
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                            
                        $mail->Port       = 465;                                    
                
                        //Recipients
                        $mail->setFrom('notreply.aprovacredi@gmail.com', 'Não Responta Este E-mail');
                        $mail->addAddress($usuarioPrimario['email'], '');    
                        $mail->addReplyTo('contato@aprovacredi.com.br', 'Informação');
                
                        //Conteudo
                        $mail->isHTML(true);                                  
                        $mail->Subject = 'Alteração na proposta de ' . $nomeComprador;
                        $mail->Body    = "
                        
                        <h1 style='margin-bottom:-20px;text-align:center;'>Parabéns</h1>
                        <h2 style='margin-top:-20px;text-align:center;'>A proposta de $nomeComprador teve seu status atualizado para $statusProposta</h2>
                        ";
                        $mail->AltBody = "Sua proposta de  $nomeComprador foi atualizada para $statusProposta";
                
                        $mail->send();
                    } catch (Exception $e) {
                        echo "E-mail Não enviado. Error: {$mail->ErrorInfo}";
                    }
                    
                                
                }
             

                    unset($_POST);    
                    echo '
                    <script>
                        window.history.back();
                    </script>';
                    exit();
            }
             


?>