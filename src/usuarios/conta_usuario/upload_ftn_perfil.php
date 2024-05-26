<?php
    include('../../conect/conect.php'); 
    $fileresult = "picture__input";
    $pasta = 'ftnPerfil/';


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
        $idUser = $_COOKIE['usuario'];
    } elseif(isset($_SESSION['usuario'])){
        $idUser = $_SESSION['usuario'];
    }

        if(isset($_FILES[$fileresult])) {
            $idusuarioPrimario = $idUser;
            $nomearquivoNovoFtnPerfil = "user_".$idUser."_".uniqid();
            $arq_ftnPerfil = $_FILES[$fileresult];
            $nome_arquivo_ftnPerfil = $arq_ftnPerfil ['name'];
            $extensao_ftnPerfil = strtolower(pathinfo($nome_arquivo_ftnPerfil, PATHINFO_EXTENSION));
            $path = $pasta . $nomearquivoNovoFtnPerfil . "." . $extensao_ftnPerfil;
        
            if($extensao_ftnPerfil != "jpg" && $extensao_ftnPerfil != "png") die ("<script>alert('Formato da imagem invalido, os formatos aceitos são: png ou jpg'); history.go(-1);</script>");
            if($arq_ftnPerfil['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
            if($arq_ftnPerfil['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
            
        }

        if(isset($_FILES[$fileresult])) {
            $deu_certorgcnh = move_uploaded_file($arq_ftnPerfil["tmp_name"],"../" . $pasta . $nomearquivoNovoFtnPerfil . "." . $extensao_ftnPerfil);
            if($deu_certorgcnh) { $mysqli->query("UPDATE usuarios 
                SET path_ftn_perfil = '$path', 
                nome_arq_ftn_Perfil = '$nomearquivoNovoFtnPerfil' 
                WHERE id = '$idusuarioPrimario'")  or die($mysqli->error);
        if($deu_certorgcnh) echo "<script>window.location.href = 'editar_user_acont.php'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
    }}