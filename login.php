<?php 
    include('src/conect/conect.php');
    $errologin = false;

    if(isset($_COOKIE['usuario'])) {
        header("Location: index.php");

    }

        if(isset($_POST['email']) && isset($_POST['senha'])) {
            $email = $mysqli->escape_string($_POST['email']);
            $senha = $_POST['senha'];
        
            $sql_code = "SELECT * FROM usuarios WHERE email = '$email'";
            $sql_query = $mysqli->query($sql_code) or die($mysqli->$error);
        
            if($sql_query->num_rows == 0) {   
                $errologin = true; 
            } else {
                $usuario = $sql_query->fetch_assoc();

                
                    if(!password_verify($senha, $usuario['senha'])) {
                        $errologin = true;
                    } else {
                        if($_POST['cntLogado'] == true){
                            setcookie("usuario", $usuario['id'], time()+86400);
                            setcookie("permissao_usuario", $usuario['permissao_usuario'], time()+86400);
                            setcookie("nome", $usuario['nome'], time()+86400);
                            if($usuario['permissao_usuario'] != 0 ){
                                header("Location: index.php");
                            } else {
                                header("Location: access_denied.php");
                            }
                        }else {
                        if(!isset($_SESSION))
                                session_start();
                            $_SESSION['usuario'] = $usuario['id'];
                            $_SESSION['permissao_usuario']  = $usuario['permissao_usuario'];
                            $_SESSION['nome']  = $usuario['nome'];
                            if($usuario['permissao_usuario'] != 0 ){
                                header("Location: index.php");
                            } else {
                                header("Location: access_denied.php");
                            }
                        }
                    }
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
    <div class="container">
            
            <div class="row formsarea">
                <div class="col-ms-6 col backgroundimg">
                    <img class="logomarcaaprova" src="css/img/logo-Aprova.png" alt="" sizes="" srcset="">
                </div>
                <div class="col-ms-6 col forms">
                    <a id="inicio" href="#"><i class="fi fi-sr-home"></i> <b>Inicio</b></a>
                    <div class="loginArea">
                        <h2><b>Login</b></h2>
                        <form onsubmit="return validarlogin()" method="POST" action="">
                            <div class="form-floating mb-3">
                                <input value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email" type="email" class="form-control <?php if($errologin === true) {echo "borderdanger";} ?>" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput" <?php if($errologin === true) {echo "colordanger";} ?>>E-mail</label>
                            </div>
                            <div class="form-floating">
                                <input value="<?php if(isset($_POST['senha'])) echo $_POST['senha']; ?>" name="senha" type="password" class="form-control <?php if($errologin === true) {echo "borderdanger";} ?>" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword" <?php if($errologin === true) {echo "colordanger";} ?>>Senha</label>
                            </div>
                            <?php
                            
                             if($errologin === true) {
                                echo '<p id="mensagemErroDoc" class="mensagemErro" style="color: red;"><i class="fi fi-ss-exclamation"></i> E-mail ou senha incorreto</p>';
                             }
                            ?>
                            <div class="buttonclass col-12">

                                <div class="dis-flex col-lg-6 col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="continuarLogado" name="cntLogado">
                                        <label class="form-check-label" for="continuarLogado">Continuar Logado?</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <button type="submit" style=" float: rigth" class="button">Entrar</button>
                                </div>
                            </div>
                        </form>
                        <div class="criarConta">
                            <p>Ainda não tem conta?<br/> crime uma agora mesmo <a href="registro.php"><b>Clicando Aqui</b></a></p>
                        </div>
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
    <script src="/javascript/validation.js"></script>
</body>
<script>