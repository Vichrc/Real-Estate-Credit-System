<?php
include('../../conect/conect.php');
$errodoc = false;
$erro01Password = false;

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

if(isset($_GET['id'])){
    $idperfil = intval($_GET['id']);
} else {
    header("Location: ../add_user/user_registered.php");
    exit();
}

$sql_userPrimario = "SELECT * FROM usuarios WHERE id  = $idperfil";
$query_userPrimario = $mysqli->query($sql_userPrimario) or die($mysqli->error);
$num_userPrimario = $query_userPrimario->num_rows;
$usuarioPrimario = $query_userPrimario->fetch_assoc();


if(isset($_GET['id'])) {
                $newPassword = substr(uniqid(rand()), 0, 8);
                $passwordUser =  password_hash($newPassword, PASSWORD_DEFAULT);
                $sql_code = "UPDATE usuarios SET senha = '$passwordUser' 
                WHERE id = '$idperfil'";
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
                        $mail->addAddress($usuarioPrimario['email'], 'Teste');    
                        $mail->addReplyTo('contato@aprovacredi.com.br', 'Informação');
                
                        //Conteudo
                        $mail->isHTML(true);                                  
                        $mail->Subject = 'Confirmação de alteração de senha';
                        $mail->Body    = "
                        
                        <h1 style='margin-bottom:-20px;text-align:center;'>Parabéns</h1>
                        <h2 style='margin-top:-20px;text-align:center;'>sua senha foi alterada</h2>
                        <p>Lembre-se, para acessar sua conta com a nova senha, você precisa fazer login <a src='https//aprovacredi.com.br/login'>clicando aqui</a></p>
                        
                        <p><b>A sua nova senha é: </b></p>
                        <p><b>Senha:</b> $newPassword</p>
                        ";
                        $mail->AltBody = "<b>E-mail:</b> <br> <b>Telefone:</b> <br> <b>Mensagem:</b><br> ";
                
                        $mail->send();
                    } catch (Exception $e) {
                        echo "E-mail Não enviado. Error: {$mail->ErrorInfo}";
                    }
                    
                                
                }
             

                    unset($_POST);           
                    echo "
                    <script>
                        alert('Senha alterada com sucesso, nova senha: $newPassword');
                        window.location.href='../add_user/user_registered.php';
                    </script>";
                    exit();  
            }
             


?>