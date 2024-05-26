<?php
    $erro = false;
    $erroemail= false;
    $errodoc = false;
    include('src/conect/conect.php');
    $formato = 'd/m/Y';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';
    
    if(count($_POST) > 0) {

        $correctData = $_POST['nascdate'];

        $nomeUser = $mysqli->escape_string($_POST['fullname']);
        $nascimentoUser =  $correctData; 
        $docUser = $mysqli->escape_string($_POST['docuser']);
        $telUser = $mysqli->escape_string($_POST['contactuser']);
        $emailUser =  $mysqli->escape_string($_POST['emailuser']);
        $senha = $_POST['passwordacont'];
        $passwordUser =  password_hash($_POST['passwordacont'], PASSWORD_DEFAULT);


        $sql_code_doc = "SELECT * FROM usuarios WHERE cpf_cnpj = '$docUser'";
        $sql_query_doc = $mysqli->query($sql_code_doc) or die($mysqli->$error);
        $num_userexistente = $sql_query_doc->num_rows;

        $sql_code_email = "SELECT * FROM usuarios WHERE email = '$emailUser'";
        $sql_query_email = $mysqli->query($sql_code_email) or die($mysqli->$error);
        $num_useremail = $sql_query_email->num_rows;

        if($num_userexistente < 1 ){
            if($num_useremail < 1 ){
                $sql_code = "INSERT INTO usuarios (nome, nascimento, cpf_cnpj, telefone_celular, email, senha, data) 
                VALUE('$nomeUser', '$nascimentoUser', '$docUser', '$telUser', '$emailUser', '$passwordUser', NOW())";
                $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
                
                if($deu_certo) {
                    header('Location: login.php');       
                
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
                        $mail->addAddress($emailUser, 'Teste');    
                        $mail->addReplyTo('contato@aprovacredi.com.br', 'Informação');
                
                        //Conteudo
                        $mail->isHTML(true);                                  
                        $mail->Subject = 'Confirmação de criação de conta Aprovacredi';
                        $mail->Body    = "
                        
                        <h1 style='margin-bottom:-20px;text-align:center;'>Parabens</h1>
                        <h2 style='margin-top:-20px;text-align:center;'>Você é o mais novo membro Aprovacredi</h2>
                        <p>Lembre-se, para completar seu cadastro você precisa fazer login <a src='https//aprovacredi.com.br/login'>clicando aqui</a></p>
                        
                        <p><b>Dados de Acesso da conta em nome de: $nomeUser</b></p>
                        <p><b>Login:</b> $emailUser</p>
                        <p><b>Senha:</b> $senha</p>
                        ";
                        $mail->AltBody = "<b>E-mail:</b> <br> <b>Telefone:</b> <br> <b>Mensagem:</b><br> ";
                
                        $mail->send();
                    } catch (Exception $e) {
                        echo "E-mail Não enviado. Error: {$mail->ErrorInfo}";
                    }
                    
                    unset($_POST);             
                }
            } else {
                $erroemail = true;
            }  
        } else {
            $errodoc = true;
        }  


    }
    
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="css/login-register.css">
    <link rel="stylesheet" href="css/responsivo.css">

    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-straight/css/uicons-regular-straight.css'>

    <script src="bootstrap/js/color-modes.js"></script>
    <script src="javascript/jquery.min.js"></script>
    <script src="javascript/jquery.mask.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.1.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styleprimario.css">

    <link rel="icon" href="css/img/favicon.png" type="image/png">
    <title>Aprovacredi - Login</title>
</head>
<body>
    <div id="loaderarea" class="loaderarea dis-hiden">
        <div class="carregar">
            <div class="loader">
                <div class="loader-square"></div>
                <div class="loader-square"></div>
                <div class="loader-square"></div>
                <div class="loader-square"></div>
                <div class="loader-square"></div>
                <div class="loader-square"></div>
                <div class="loader-square"></div>
            </div>
            <h2>
                Carregando
                <span>.</span>
                <span>.</span>
                <span>.</span>
                <!-- Adicione mais spans conforme necessário para o número de letras no seu texto -->
            </h2>
        </div>
    </div>
    <div class="container">  
        <div class="row formsarea">
            <div class="col-ms-6 col backgroundimg">
                <img class="logomarcaaprova" src="css/img/logo-Aprova.png" alt="" sizes="" srcset="">
            </div>
            <div class="col-ms-6 col forms">
                <a id="inicio" href="#"><i class="fi fi-sr-home"></i> <b>Inicio</b></a><br>
                <div class="registerform">
                    <form onsubmit="return handleFormSubmit()" method="POST" action="" class="row g-3">
                        <div class="col-md-6">
                            <label class="inputregister" for="inputfullname" class="form-label">Nome Completo</label>
                            <input value="<?php if(isset($_POST['fullname'])) echo $_POST['fullname'];?>" name="fullname" type="text" class="form-control" id="inputfullname" placeholder="Digite seu nome...">
                            <p id="mensagemErro" class="mensagemErro" style="color: red;"></p>
                        </div>
                
                        <div class="col-md-6">
                            <label class="inputregister" for="inputdate" class="form-label">Data de Nascimento</label>
                            <input value="<?php if(isset($_POST['nascdate'])) echo $_POST['nascdate'];?>" name="nascdate"  type="date" class="form-control" id="inputdate">
                        </div>

                        <div class="col-md-6">
                            <label class="inputregister" for="inputdoc" class="form-label <?php if($errodoc === true){ echo "colordanger"; }; ?>">CPF/CNPJ</label>
                            <input value="<?php if(isset($_POST['docuser'])) echo $_POST['docuser'];?>" name="docuser"   type="text" class="cpfOuCnpj form-control <?php if($errodoc === true){ echo "borderdanger"; }; ?>" id="inputdoc" placeholder="Digite seu documento...">
                            <p id="mensagemErroDoc" class="mensagemErro" style="color: red;"></p>
                            <?php 
                            if($errodoc === true){
                                echo '<p id="mensagemErroDoc" class="mensagemErro" style="color: red;"><i class="fi fi-ss-exclamation"></i> CPF/CNPJ já Cadastrado</p>';
                            };
                            ?>
                        </div>
                            
                        <div class="col-md-6">
                            <label class="inputregister" for="inputnumberphone" class="form-label">telefone</label>
                            <input value="<?php if(isset($_POST['contactuser'])) echo $_POST['contactuser'];?>" name="contactuser"  type="text" class="telefone form-control" id="inputnumberphone" placeholder="(11) 1234-56789">
                            <p id="mensagemErroTel" class="mensagemErro" style="color: red;"></p>
                        </div>   

                        <div class="col-md-12">
                            <label class="inputregister" for="inputemail" class="form-label <?php if($erroemail === true){ echo "colordanger"; }; ?>">E-mail:</label>
                            <input value="<?php if(isset($_POST['emailuser'])) echo $_POST['emailuser'];?>" name="emailuser" type="email" class="form-control <?php if($erroemail === true){ echo "borderdanger"; }; ?>" id="inputemail" placeholder="Digite seu e-mail...">
                            <p id="mensagemErroEmail" class="mensagemErro" style="color: red;"></p>
                            <?php 
                            if($erroemail === true){
                                echo '<p id="mensagemErroDoc" class="mensagemErro" style="color: red;"><i class="fi fi-ss-exclamation"></i> E-mail já Cadastrado</p>';
                            };
                            ?>
                        </div>

                        <div class="col-md-6" style="display: flex; flex-direction: column;">
                            <label  class="inputregister" for="inputsenha" class="form-label">Crie uma senha</label>
                            <input value="<?php if(isset($_POST['passwordacont'])) echo $_POST['passwordacont'];?>" name="passwordacont" type="password" class="form-control" id="inputsenha" placeholder="Digite sua senha...">
                            <img onclick="mostrarSenha()" src="css/img/olho.png" id="imgsenhacadastro" alt="" class="imgocultarsenha">
                            <p id="mensagemErroPassword" class="mensagemErroPassword" style="color: red;"></p>
                        </div>
                            
                        <div class="col-md-6" style="display: flex; flex-direction: column;">
                            <label class="inputregister" for="inputrepetirsenha" class="form-label">Repita sua senha</label>
                            <input type="password" class="form-control" id="inputrepetirsenha" placeholder="Repita sua senha...">
                            <img onclick="mostrarSenha()" src="css/img/olho.png" id="inputconfirmsenha" alt="" class="imgocultarsenha">
                            <p id="mensagemErroPasswordConfirm" class="mensagemErroPassword" style="color: red;"></p>
                        </div>   
                        

                        <div class="inputaceite form-check">
                            <input class="form-check-input" type="checkbox" value="" id="termosdeuso">
                            <label class="termosdeuso" class="form-check-label" for="termosdeuso">
                                <p>Li, e concordo com todos os <a src="#"><a href="#"><b>Termos de Uso!</b></a></p>
                            </label>
                            <p id="mensagemErroCheckbox" class="mensagemErro" style="color: red;"></p>
                        </div>

                        <div class="btnregister">
                            <button type="submit" class="cta">
                                <span>Criar conta</span>
                                <svg width="15px" height="10px" viewBox="0 0 13 10">
                                <path d="M1,5 L11,5"></path>
                                <polyline points="8 1 12 5 8 9"></polyline>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    <footer>
        <p>©AprovaCredi 2024 | Todos os direitos reservados.<br>
                Site Elaborado por: <a href="https://www.linkedin.com/in/victor-hugo-ramiro-cota/"><b>Victor Hugo Ramiro Cota.</b></a>
    </p>
    </footer>
    
    
    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="sidebars.js"></script>
    <script src="javascript/masksystem.js"></script>
    <script src="javascript/validation.js"></script>
</body>
<script>