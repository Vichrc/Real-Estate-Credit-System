<?php

include('../../conect/conect.php');

$id_vendedor = intval($_GET['id']);
$pasta = "/important/docVendedor/";
$pasta2 = "../../../important/docVendedor/";

if(!isset($_SESSION))
    session_start();

function removerTextoDepoisDoEspaco($texto) {
   // Encontra a posição do primeiro espaço
   $posicaoPrimeiroEspaco = strpos($texto, ' ');

   // Se encontrar um espaço, encontra a posição do segundo espaço
   if ($posicaoPrimeiroEspaco !== false) {
       $posicaoSegundoEspaco = strpos($texto, ' ', $posicaoPrimeiroEspaco + 1);

       // Se encontrar o segundo espaço, remove o texto após o segundo espaço
       if ($posicaoSegundoEspaco !== false) {
           $texto = substr($texto, 0, $posicaoSegundoEspaco);
       }
   }

   return $texto;
}




if (isset($_COOKIE['usuario']) || isset($_SESSION['usuario'])) {
    if (isset($_COOKIE['permissao_usuario']) && $_COOKIE['permissao_usuario'] == 5 || isset($_COOKIE['permissao_usuario']) && $_COOKIE['permissao_usuario'] == 0) {
        header("Location: logout.php");
        exit();
    }

    if (isset($_SESSION['permissao_usuario']) && $_SESSION['permissao_usuario'] == 5 || isset($_SESSION['permissao_usuario']) && $_SESSION['permissao_usuario'] == 0) {
        header("Location: logout.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}

if(isset($_COOKIE['usuario'])){
    $name=removerTextoDepoisDoEspaco($_COOKIE['nome']);
} else {
    $name=removerTextoDepoisDoEspaco($_SESSION['nome']);
}

if(isset($_COOKIE['usuario'])){
    $idUser = $_COOKIE['usuario'];
} elseif(isset($_SESSION['usuario'])){
    $idUser = $_SESSION['usuario'];
}

$sql_userPrimario = "SELECT * FROM usuarios WHERE id  = $idUser";
$query_userPrimario = $mysqli->query($sql_userPrimario) or die($mysqli->error);
$num_userPrimario = $query_userPrimario->num_rows;
$usuarioPrimario = $query_userPrimario->fetch_assoc();

$sql_dadosVendedor = "SELECT * FROM db_vendedor WHERE id_vendedor = $id_vendedor";
$query_dadosVendedor = $mysqli->query($sql_dadosVendedor) or die($mysqli->error);
$num_dadosVendedor = $query_dadosVendedor->num_rows;
$dadosVendedor = $query_dadosVendedor->fetch_assoc();
$id_proposta = $dadosVendedor['id_proposta'];

$sql_docVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
$query_docVendedor = $mysqli->query($sql_docVendedor) or die($mysqli->error);
$num_docVendedor = $query_docVendedor->num_rows;
$docVendedor = $query_docVendedor->fetch_assoc();


    if($usuarioPrimario['permissao_usuario'] != 3){

        if($usuarioPrimario['permissao_usuario'] != 2){
            if($usuarioPrimario['id'] != $dadosVendedor['id_corretor']) {
                header("Location: ../../../logout.php");
                exit();
            }
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES)) {

        if(isset($_FILES['cpf_file'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "comp_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['cpf_file'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_cpf = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_cpf;
            if($extensao_Arqv_cpf != ''){
                if($extensao_Arqv_cpf != "jpg" && $extensao_Arqv_cpf != "jpeg" && $extensao_Arqv_cpf != "pdf" && $extensao_Arqv_cpf != "png") die ("<script>alert('CPF: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
            

                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_cpf);

                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET path_cpf = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                    if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    $sql_code = "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, path_cpf) 
                    VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')";
                    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
                }
            }
        }

        if(isset($_FILES['rg_cnh_file'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "comp_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['rg_cnh_file'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_rg_cnh = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_rg_cnh;
            if($extensao_Arqv_rg_cnh != ''){
                if($extensao_Arqv_rg_cnh != "jpg" && $extensao_Arqv_rg_cnh != "jpeg" && $extensao_Arqv_rg_cnh != "pdf" && $extensao_Arqv_rg_cnh != "png") die ("<script>alert('RG/CNH: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
                
                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();


                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_rg_cnh);

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET path_rg_cnh = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                    if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    $sql_code = "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, path_rg_cnh) 
                    VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')";
                    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
                }
            }
        }

        if(isset($_FILES['comp_resi_file'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "comp_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['comp_resi_file'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_Compr_resi = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_Compr_resi;
            if($extensao_Arqv_Compr_resi != ''){
                if($extensao_Arqv_Compr_resi != "jpg" && $extensao_Arqv_Compr_resi != "jpeg" && $extensao_Arqv_Compr_resi != "pdf" && $extensao_Arqv_Compr_resi != "png") die ("<script>alert('Comprovante de Residencia: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
                
                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();


                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_Compr_resi);

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET path_comp_resi = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                    if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    $sql_code = "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, path_comp_resi) 
                    VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')";
                    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
                }
            }
        }

        if(isset($_FILES['comp_renda_file'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "comp_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['comp_renda_file'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_Compr_renda = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_Compr_renda;
            if($extensao_Arqv_Compr_renda != ''){
                if($extensao_Arqv_Compr_renda != "jpg" && $extensao_Arqv_Compr_renda != "jpeg" && $extensao_Arqv_Compr_renda != "pdf" && $extensao_Arqv_Compr_renda != "png") die ("<script>alert('Comprovante de Renda: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
                
                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();


                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_Compr_renda);

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET path_comp_ren = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                    if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    $sql_code = "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, path_comp_ren) 
                    VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')";
                    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
                }
            }
        }

        if(isset($_FILES['comp_estado_civil_file'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "comp_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['comp_estado_civil_file'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_Compr_estado_civil = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_Compr_estado_civil;
            if($extensao_Arqv_Compr_estado_civil != ''){
                if($extensao_Arqv_Compr_estado_civil != "jpg" && $extensao_Arqv_Compr_estado_civil != "jpeg" && $extensao_Arqv_Compr_estado_civil != "pdf" && $extensao_Arqv_Compr_estado_civil != "png") die ("<script>alert('Comprovante de Estado Civil: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
                
                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();


                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_Compr_estado_civil);

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET path_Comp_estado = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                    if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    $sql_code = "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, path_Comp_estado) 
                    VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')";
                    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
                }
            }
        }

        if(isset($_FILES['impost_Renda_File'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "comp_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['impost_Renda_File'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_imp_renda = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_imp_renda;
            if($extensao_Arqv_imp_renda != ''){
                if($extensao_Arqv_imp_renda != "jpg" && $extensao_Arqv_imp_renda != "jpeg" && $extensao_Arqv_imp_renda != "pdf" && $extensao_Arqv_imp_renda != "png") die ("<script>alert('Imposto de Renda: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
                
                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();


                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_imp_renda);

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET path_imp_renda = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                    if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    $sql_code = "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, path_imp_renda) 
                    VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')";
                    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
                }
            }
        }

        if(isset($_FILES['rg_chh_conj_file'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "comp_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['rg_chh_conj_file'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_rgcnh_conj = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_rgcnh_conj;
            if($extensao_Arqv_rgcnh_conj != ''){        
                if($extensao_Arqv_rgcnh_conj != "jpg" && $extensao_Arqv_rgcnh_conj != "jpeg" && $extensao_Arqv_rgcnh_conj != "pdf" && $extensao_Arqv_rgcnh_conj != "png") die ("<script>alert('RG/CNH: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
                
                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();


                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_rgcnh_conj);

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET path_conjugue_rg_cnh = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                    if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    $sql_code = "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, path_conjugue_rg_cnh) 
                    VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')";
                    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
                }
            }
        }

        if(isset($_FILES['cpf_Cônjuge_file'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "comp_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['cpf_Cônjuge_file'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_cpf_conj = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_cpf_conj;
            if($extensao_Arqv_cpf_conj != ''){ 
                if($extensao_Arqv_cpf_conj != "jpg" && $extensao_Arqv_cpf_conj != "jpeg" && $extensao_Arqv_cpf_conj != "pdf" && $extensao_Arqv_cpf_conj != "png") die ("<script>alert('CPF Conjugue: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
                
                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();


                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_cpf_conj);

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET path_cpf_conjugue = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                    if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    $sql_code = "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, path_cpf_conjugue) 
                    VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')";
                    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
                }
            }
        }

        if(isset($_FILES['comp_ren_conj'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "comp_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['comp_ren_conj'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_comp_renda_conj = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_comp_renda_conj;
            if($extensao_Arqv_comp_renda_conj != ''){ 
                if($extensao_Arqv_comp_renda_conj != "jpg" && $extensao_Arqv_comp_renda_conj != "jpeg" && $extensao_Arqv_comp_renda_conj != "pdf" && $extensao_Arqv_comp_renda_conj != "png") die ("<script>alert('Comprovante de Renda: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
                
                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();


                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_comp_renda_conj);

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET path_comp_ren_conjug = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                    if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    $sql_code = "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, path_comp_ren_conjug) 
                    VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')";
                    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
                }
            }
        }

        if(isset($_FILES['impos_renda_conj'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "vendedor_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['impos_renda_conj'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_imposto_renda_conj = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_imposto_renda_conj;
            if($extensao_Arqv_imposto_renda_conj != ''){ 
                if($extensao_Arqv_imposto_renda_conj != "jpg" && $extensao_Arqv_imposto_renda_conj != "jpeg" && $extensao_Arqv_imposto_renda_conj != "pdf" && $extensao_Arqv_imposto_renda_conj != "png") die ("<script>alert('Imposto de Renda: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
                
                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();


                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_imposto_renda_conj);

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET path_imp_renda_conjug = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                        if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    if($deu_certor) {
                        $mysqli->query(
                            "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, path_imp_renda_conjug) 
                            VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')") or die($mysqli->error);
                        if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                }
            }
        }


        if(isset($_FILES['contrato_social_file'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "vendedor_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['contrato_social_file'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_imposto_renda_conj = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_imposto_renda_conj;
            if($extensao_Arqv_imposto_renda_conj != ''){ 
                if($extensao_Arqv_imposto_renda_conj != "jpg" && $extensao_Arqv_imposto_renda_conj != "jpeg" && $extensao_Arqv_imposto_renda_conj != "pdf" && $extensao_Arqv_imposto_renda_conj != "png") die ("<script>alert('Imposto de Renda: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
                
                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();


                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_imposto_renda_conj);

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET contrato_social = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                        if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    if($deu_certor) {
                        $mysqli->query(
                            "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, contrato_social) 
                            VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')") or die($mysqli->error);
                        if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                }
            }
        }

        if(isset($_FILES['rg_cnh_repre_file'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "vendedor_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['rg_cnh_repre_file'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_imposto_renda_conj = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_imposto_renda_conj;
            if($extensao_Arqv_imposto_renda_conj != ''){ 
                if($extensao_Arqv_imposto_renda_conj != "jpg" && $extensao_Arqv_imposto_renda_conj != "jpeg" && $extensao_Arqv_imposto_renda_conj != "pdf" && $extensao_Arqv_imposto_renda_conj != "png") die ("<script>alert('Imposto de Renda: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
                
                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();


                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_imposto_renda_conj);

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET rg_cnh_repre = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                        if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    if($deu_certor) {
                        $mysqli->query(
                            "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, rg_cnh_repre) 
                            VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')") or die($mysqli->error);
                        if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                }
            }
        }

        if(isset($_FILES['cpf_repre_file'])) {
            $idusuario = $id_vendedor;
            $nomeArquivoNovo = "vendedor_".$id_vendedor."_".uniqid();
            $arq_Upload = $_FILES['cpf_repre_file'];
            $arquivo = $arq_Upload ['name'];
            $extensao_Arqv_imposto_renda_conj = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $path = $pasta . $nomeArquivoNovo . "." . $extensao_Arqv_imposto_renda_conj;
            if($extensao_Arqv_imposto_renda_conj != ''){ 
                if($extensao_Arqv_imposto_renda_conj != "jpg" && $extensao_Arqv_imposto_renda_conj != "jpeg" && $extensao_Arqv_imposto_renda_conj != "pdf" && $extensao_Arqv_imposto_renda_conj != "png") die ("<script>alert('Imposto de Renda: Formato do documento invalido, os formatos aceitos são: png, jpg, jpeg e pdf'); history.go(-1);</script>");
                if($arq_Upload['error']) die ("<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>"); 
                if($arq_Upload['size'] > 9097152) die ("<script>alert('Arquivo muito grande!! Max: 8MB'); history.go(-1);</script>");
                
                $sql_dadosdocVendedor = "SELECT * FROM db_doc_vend WHERE id_vendedor = $id_vendedor";
                $query_dadosdocVendedor = $mysqli->query($sql_dadosdocVendedor) or die($mysqli->error);
                $num_dadosdocVendedor = $query_dadosdocVendedor->num_rows;
                $dadosdocVendedor = $query_dadosdocVendedor->fetch_assoc();


                $deu_certor = move_uploaded_file($arq_Upload["tmp_name"],$pasta2 . $nomeArquivoNovo . "." . $extensao_Arqv_imposto_renda_conj);

                if ($num_dadosdocVendedor > 0) {
                    if($deu_certor) { $mysqli->query(
                        "UPDATE db_doc_vend 
                        SET cpf_repre = '$path' 
                        WHERE id_vendedor = '$id_vendedor'")  or die($mysqli->error);
                        if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                } else {
                    if($deu_certor) {
                        $mysqli->query(
                            "INSERT INTO db_doc_vend (id_corretor, id_proposta, id_vendedor, cpf_repre) 
                            VALUE ('$idUser' ,'$id_proposta' ,'$id_vendedor' , '$path')") or die($mysqli->error);
                        if($deu_certor) echo "<script>window.location.href = 'editarVendedor.php?id=$id_vendedor'</script>"; else echo "<script>alert('ERRO: falha inesperada ao enviar arquivo.'); history.go(-1);</script>";
                    }
                }
            }
        }
    }

?>


<!doctype html>
<html lang="pt-br">
  <head>
    <script src="../../../bootstrap/js/color-modes.js"></script>
    <script src="../../../javascript/jquery.min.js"></script>
    <script src="../../../javascript/jquery.mask.js"></script>
    <script src="../../../javascript/jquery.maskMoney.js"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.3.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aprovacredi - Home</title>
    <link href="../../../bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="icon" href="../../../css/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../../../css/styleprimario.css">
    <link rel="stylesheet" href="../../../css/styleProposta.css">
    <link rel="stylesheet" href="../../../css/planicorretor.css">
    <link rel="stylesheet" href="../../../css/stylegestaoproposta.css">
  </head>
<body>
    <header style="position: relative;z-index: 9999;">
        <!--Navbar-->
        <div id="navbar">
            <nav class="navbar bg-body-ligt" style="background-color: #fff; box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <img src="../../../css/img/logo-Aprova.png" alt="Aprovacredi" width="150" height="60">
                    </a>


                    <div data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: 5.5rem;">
                        <a href="#" class="d-block p-3 link-body-emphasis text-decoration-none" title="AprovaCredi" data-bs-toggle="tooltip" data-bs-placement="right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="53" height="30" fill="currentColor" class="bi bi-justify" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                            </svg>      
                        <span class="visually-hidden">AprovaCredi</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <!--Sidebar-->
        <div id="sidebar">
            <main class="d-flex flex-nowrap">
                <div class="d-flex flex-column flex-shrink-0" style="height: 100vh; background-color: #fff; box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;">
                    <div data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="width: 5.5rem;">
                        <a href="#" class="d-block p-3 link-body-emphasis text-decoration-none" title="AprovaCredi" data-bs-toggle="tooltip" data-bs-placement="right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="53" height="30" fill="currentColor" class="bi bi-justify" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                            </svg>      
                        <span class="visually-hidden">AprovaCredi</span>
                        </a>
                    </div>
                    <hr style="margin:0px;">
                    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
                        <!--Home-->    
                        <div class="dropend">
                            <!--Itens do Dropdown-->
                            <li class="nav-item"  data-bs-toggle="dropdown" aria-expanded="false">
                                <a href="#" class=" nav-link py-3 border-bottom rounded-0" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                        <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z"/>
                                    </svg>
                                </a>
                            </li>
                            <!--Lista do Dropdown-->
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="../../../index.php" class=" dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-grid-1x2-fill" viewBox="0 0 16 16">
                                            <path d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z"/>
                                        </svg>  
                                        Inicio
                                    </a>
                                </li>
                                <li>
                                    <a href="https://api.whatsapp.com/send?phone=5513991080129&text=Ol%C3%A1,%20preciso%20de%20ajuda%20com%20o%20sistema%20Aprovacredi!!" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                        </svg>    
                                        Ajuda
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!--Proposta-->    
                        <div class="dropend">
                            <li class="nav-item"  data-bs-toggle="dropdown" aria-expanded="false">
                                <a href="#" class="active nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                                </svg>
                                </a>
                            </li>
                            <!--Lista do Dropdown-->
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="../criacao/novaProposta.php" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-grid-1x2-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                                        </svg>  
                                        Cadastrar Proposta
                                    </a>
                                </li>
                                <li>
                                    <a href="../gestao/myPropost.php" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                            <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                        </svg>      
                                        Minhas Propostas
                                    </a>
                                </li>
                                <li>
                                    <a href="../gestao/admPropost.php" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                            <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0Zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708ZM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11Z"/>
                                        </svg>    
                                        Gerenciamento de Propostas
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!--Simulador-->  
                        <div class="dropend">
                            <li>
                                <a href="../../../simulador_apro.php" class="nav-link py-3 border-bottom rounded-0" title="Simulador" data-bs-toggle="tooltip" data-bs-placement="right">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" fill="currentColor" class="bi bi-stack" viewBox="0 0 16 16">
                                        <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.598.598 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.598.598 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.598.598 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535L7.733.063z"/>
                                        <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.598.598 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.659z"/>
                                    </svg>
                                </a>
                            </li>
                        </div>

                        <!--Gestão de Usuarios-->
                        <div class="dropend">  
                            <li class="nav-item"  data-bs-toggle="dropdown" aria-expanded="false">
                                <a href="#" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="35" fill="currentColor" class="bi bi-person-fill-gear" viewBox="0 0 16 16">
                                        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"/>
                                    </svg>
                                </a>
                            </li>
                            <!--Lista do Dropdown-->
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="../../usuarios/add_user/solic_cadastro.php" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-grid-1x2-fill" viewBox="0 0 16 16">
                                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>                                
                                        </svg>  
                                        Solicitação de Cadastro
                                    </a>
                                </li>
                                <li>
                                    <a href="../../usuarios/add_user/user_registered.php" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>                                </svg>
                                        </svg>      
                                        Usuarios Cadastrados
                                    </a>
                                </li>
                                <li>
                                    <a href="../../usuarios/add_user/user_bloqueado.php" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                            <path d="M13.879 10.414a2.501 2.501 0 0 0-3.465 3.465l3.465-3.465Zm.707.707-3.465 3.465a2.501 2.501 0 0 0 3.465-3.465Zm-4.56-1.096a3.5 3.5 0 1 1 4.949 4.95 3.5 3.5 0 0 1-4.95-4.95ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
                                        </svg>    
                                        Usuarios Bloqueados
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!--Administração Geral-->
                        <div class="dropend">
                            <li class="nav-item"  data-bs-toggle="dropdown" aria-expanded="false">
                                <a href="#" class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip" data-bs-placement="right">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                        <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                    </svg>
                                </a>
                            </li>
                            <!--Lista do Dropdown-->
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-grid-1x2-fill" viewBox="0 0 16 16">
                                            <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z"/>
                                        </svg>  
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                            <path d="M3 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3v-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V16h3a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H3Zm1 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Z"/>
                                        </svg>      
                                        Funcionarios
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                            <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z"/>
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                                        </svg>    
                                        Financeiro
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                            <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z"/>
                                            <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM9.98 5.356 11.372 10h.128a.5.5 0 0 1 0 1H11a.5.5 0 0 1-.479-.356l-.94-3.135-1.092 5.096a.5.5 0 0 1-.968.039L6.383 8.85l-.936 1.873A.5.5 0 0 1 5 11h-.5a.5.5 0 0 1 0-1h.191l1.362-2.724a.5.5 0 0 1 .926.08l.94 3.135 1.092-5.096a.5.5 0 0 1 .968-.039Z"/>                                
                                        </svg>    
                                        Relatorio
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </ul>
                    <div class="dropdown border-top">
                        <a href="#" class="d-flex align-items-center justify-content-center p-3 link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img 
                            <?php if($usuarioPrimario['nome_arq_ftn_Perfil'] == null) { ?> 
                               src="../../../css/img/fotoperfil.jpg"  
                            <?php } else 
                            { echo 'src="../../usuarios/'.$usuarioPrimario["path_ftn_perfil"].'"';}?> 
                            alt="mdo" width="35" height="35" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class=" dropdown-item" href="../../usuarios/conta_usuario/editar_user_acont.php">Perfil</a></li>
                            <li><a class="dropdown-item" href="../../usuarios/conta_usuario/creact_sec_login.php">Cadastro Corretor</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../../../logout.php">Sair</a></li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
        <!--Menu Lateral-->
        <div class="offcanvas offcanvas-start"  id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="width: 280px;">
                    <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-light" style="width: 279px; height: 100%;">
                        <img src="../../../css/img/logo-Aprova.png" alt="">
                        <hr>
                        <ul class="nav nav-pills flex-column mb-auto mobile">
                            <!--Home Lateral-->  
                            <div class="dropend">
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link link-body-emphasis" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                        <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z"/>
                                    </svg>                                        
                                    Home
                                    </a>
                                    <!--Lista do Dropdown-->
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="../../../index.php" class="dropdown-item" >
                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-grid-1x2-fill" viewBox="0 0 16 16">
                                                    <path d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5z"/>
                                                </svg>  
                                                Inicio
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://api.whatsapp.com/send?phone=5513991080129&text=Ol%C3%A1,%20preciso%20de%20ajuda%20com%20o%20sistema%20Aprovacredi!!" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                                </svg>    
                                                Ajuda
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </div>

                            <!--Propostas Lateral-->  
                            <div class="dropend">
                                <li class="nav-item dropdown">
                                    <a href="#" class=" active nav-link link-body-emphasis" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                                    </svg>                                        
                                    Propostas
                                    </a>
                                    <!--Lista do Dropdown-->
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="../criacao/novaProposta.php" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-grid-1x2-fill" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                                                </svg>  
                                                Cadastrar Proposta
                                            </a>
                                        </li>
                                        <li>
                                            <a href="myPropost.php" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                                    <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                                </svg>
                                                </svg>      
                                                Minhas Propostas
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admPropost.php" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                                    <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0Zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708ZM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11Z"/>
                                                </svg>    
                                                Gerenciamento de Propostas
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </div>

                            <!--Simulador Lateral-->  
                            <li>
                                <a href="../../../simulador_apro.php" class="nav-link link-body-emphasis">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" fill="currentColor" class="bi bi-stack" viewBox="0 0 16 16">
                                        <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.598.598 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.598.598 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.598.598 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535L7.733.063z"/>
                                        <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.598.598 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.659z"/>
                                    </svg>                                    
                                    Simulador
                                </a>
                            </li>

                            <!--Gestão de Usuarios Lateral-->  
                            <div class="dropend">
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link link-body-emphasis" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="45" height="35" fill="currentColor" class="bi bi-person-fill-gear" viewBox="0 0 16 16">
                                            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"/>
                                        </svg>                                    
                                        Gestão de Usuarios
                                    </a>
                                    <!--Lista do Dropdown-->
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="../../usuarios/add_user/solic_cadastro.php" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-grid-1x2-fill" viewBox="0 0 16 16">
                                                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                    <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>                                
                                                </svg>  
                                                Solicitação de Cadastro
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../../usuarios/add_user/user_registered.php" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                    <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>                                </svg>
                                                </svg>      
                                                Usuarios Cadastrados
                                            </a>
                                        </li>
                                        <li>
                                            <a href="../../usuarios/add_user/user_bloqueado.php" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                                    <path d="M13.879 10.414a2.501 2.501 0 0 0-3.465 3.465l3.465-3.465Zm.707.707-3.465 3.465a2.501 2.501 0 0 0 3.465-3.465Zm-4.56-1.096a3.5 3.5 0 1 1 4.949 4.95 3.5 3.5 0 0 1-4.95-4.95ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
                                                </svg>    
                                                Usuarios Bloqueados
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </div>

                            <!--Administração Lateral-->  
                            <div class="dropend">
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link link-body-emphasis" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                            <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                            <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                        </svg>                                   
                                        Administração
                                    </a>
                                    <!--Lista do Dropdown-->
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-grid-1x2-fill" viewBox="0 0 16 16">
                                                    <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z"/>
                                                </svg>  
                                                Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                                    <path d="M3 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3v-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V16h3a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H3Zm1 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5Z"/>
                                                </svg>      
                                                Funcionarios
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                                    <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z"/>
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                    <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                                                </svg>    
                                                Financeiro
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right:10px;" width="25" height="25" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                                    <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z"/>
                                                    <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM9.98 5.356 11.372 10h.128a.5.5 0 0 1 0 1H11a.5.5 0 0 1-.479-.356l-.94-3.135-1.092 5.096a.5.5 0 0 1-.968.039L6.383 8.85l-.936 1.873A.5.5 0 0 1 5 11h-.5a.5.5 0 0 1 0-1h.191l1.362-2.724a.5.5 0 0 1 .926.08l.94 3.135 1.092-5.096a.5.5 0 0 1 .968-.039Z"/>                                
                                                </svg>    
                                                Relatorio
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </div>
                        </ul>
                        <hr>
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <img 
                                <?php if($usuarioPrimario['nome_arq_ftn_Perfil'] == null) { ?> 
                                    src="css/img/fotoperfil.jpg"  
                                <?php } else { echo 'src="../../usuarios/'.$usuarioPrimario["path_ftn_perfil"].'"';}?>
                                alt="" width="32" height="35" class="rounded-circle me-2">
                                <strong><?php echo "$name" ?></strong>
                            </a>
                            <ul class="dropdown-menu text-small shadow">
                                <li><a class="dropdown-item" href="../../usuarios/conta_usuario/editar_user_acont.php">Perfil</a></li>
                                <li><a class="dropdown-item" href="../../usuarios/conta_usuario/creact_sec_login.php">Cadastro Corretor</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../../../logout.php">Sair</a></li>
                            </ul>
                        </div>
                    </div>
        </div>
        </div>
    </header>
    <section class="workspace">
        <div class="container container-workspace containerdados">
            <!--Conteudo da Pagina-->
            <div class="areaInicial">
                <div class="retorno">
                    <a href="gestaopropst.php?id=<?php echo $dadosVendedor['id_proposta'] ?>"><i class="fi fi-sr-undo"></i> Voltar</a>
                </div>
                <div class="btnArea">
                    <button class="btnGestaoProposta excluir" data-bs-toggle="modal" data-bs-target="#modalDeletarComprador"> 
                        <i class="fi fi-ss-trash-xmark"></i></i> <span class="btngrupDados">Excluir</span> 
                    </button>

                    <button class="btnGestaoProposta" data-bs-toggle="modal" data-bs-target="#documentoComprador"> 
                        <i class="fi fi-sr-add-document"></i> <span class="btngrupDados">Documentos</span> 
                    </button>

                </div>
            </div>
            <form action="editarDadosVendedor.php?id=<?php echo $id_vendedor ?>" method="post"> 
                    <?php if($dadosVendedor['e_pj'] != "Sim") { ?>
                        <div >
                            <div class="headerSubDados">
                                <h1><b>Informações Vendedor PF</b></h1>
                                <hr>
                            </div> 
                            <div class="infoArea row">
                                <div class="col-md-6 col-sm-12">
                                    <label for="nameVendedor" class="form-label">Nome</label>
                                    <input value="<?php echo $dadosVendedor['nome_vendedor']; ?>" required name="nameVendedor" type="text" id="nameVendedor" class="form-control">
                                </div>

                                <div class="col-md-3 col-sm-12">
                                    <label for="nascimentoVendedor" class="form-label">Nascimento</label>
                                    <input value="<?php echo $dadosVendedor['data_nascimento_vendedor']; ?>" required name="nascimentoVendedor" type="date" id="nascimentoVendedor" class="form-control">
                                </div>

                                <div class="col-md-3 col-sm-12">
                                    <label class="form-label">Estado Civil</label>
                                    <select onchange="mostrarEsconderConjugueVendedor(this)" name="estadoCivilVendedor" id="estadoCivilVendedor" class="form-select" aria-label="Default select example">
                                        <option value="<?php echo $dadosVendedor['estado_civil_vendedor'] ?>"><?php echo $dadosVendedor['estado_civil_vendedor'] ?></option>
                                        <option value="solteiro">Solteiro</option>
                                        <option value="casado">Casado</option>
                                        <option value="divorciado">Divorciado</option>
                                        <option value="viuvo">Víuvo</option>
                                    </select>                                                    
                                </div>
                            </div>
                            <div class="infoArea row">
                                <div class="col-md-8 col-sm-12">
                                    <label for="emailVendedor" class="form-label">E-mail</label>
                                    <input value="<?php echo $dadosVendedor['email_vendedor'] ?>" required name="emailVendedor" type="email" id="emailVendedor" class="form-control">
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="telefoneVendedor" class="form-label">Telefone</label>
                                    <input value="<?php echo $dadosVendedor['telefone_vendedor'] ?>" required name="telefoneVendedor" type="text" id="telefoneVendedor" class="form-control telefone">
                                </div>
                            </div>
                            <div class="infoArea row">
                                <div class="col-md-3 col-sm-12">
                                    <label for="rgVendedor" class="form-label">RG</label>
                                    <input value="<?php echo $dadosVendedor['documento_vendedor'] ?>" required name="rgVendedor" type="text" id="rgVendedor" class="form-control">
                                </div>

                                <div class="col-md-3 col-sm-12">
                                    <label for="emissorVendedor" class="form-label">Orgão Emissor</label>
                                    <input value="<?php echo $dadosVendedor['org_emissor'] ?>" required name="emissorVendedor" type="text" id="emissorVendedor" class="form-control">
                                </div>

                                <div class="col-md-3 col-sm-12">
                                    <label for="dataEmissaoVendedor" class="form-label">Data Emissor</label>
                                    <input value="<?php echo $dadosVendedor['data_emissao'] ?>" required name="dataEmissaoVendedor" type="date" id="dataEmissaoVendedor" class="form-control">
                                </div>

                                <div class="col-md-3 col-sm-12">
                                    <label for="cpfVendedor" class="form-label">CPF</label>
                                    <input value="<?php echo $dadosVendedor['cpf_vendedor'] ?>" required name="cpfVendedor" type="text" id="cpfVendedor" class="form-control cpfMask">
                                </div>
                            </div>
                            <div class="infoArea row">
                                <div class="col-md-6 col-sm-12">
                                    <label for="nomeMaeVendedor" class="form-label">Nome da Mãe</label>
                                    <input value="<?php echo $dadosVendedor['nome_mae_vendedor'] ?>" required name="nomeMaeVendedor" type="tect" id="nomeMaeVendedor" class="form-control">
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="nomepaiVendedor" class="form-label">Nome do Pai</label>
                                    <input value="<?php echo $dadosVendedor['nome_pai_vendedor'] ?>" name="nomepaiVendedor" type="text" id="nomepaiVendedor" class="form-control">
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div >
                            <div class="headerSubDados">
                                <h1><b>Informações Vendedor PJ</b></h1>
                                <hr>
                            </div> 
                            <div class="infoArea row">
                                <div class="col-md-6 col-sm-12">
                                    <label for="nomeVendedorPj" class="form-label">Razão Social</label>
                                    <input value="<?php echo $dadosVendedor['nome_empresarial'] ?>" name="nomeVendedorPj" type="tect" id="nomeVendedorPj" class="form-control">
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="cnpjVendedorPJ" class="form-label">CNPJ</label>
                                    <input value="<?php echo $dadosVendedor['cnpj_vendedor'] ?>" name="cnpjVendedorPJ" type="text" id="cnpjVendedorPJ" class="cnpjMAsk form-control">
                                </div>
                            </div>
                            <div class="infoArea row">
                                <div class="col-md-6 col-sm-12">
                                    <label for="emailVendedorPJ" class="form-label">E-mail</label>
                                    <input value="<?php echo $dadosVendedor['email_cnpj'] ?>" name="emailVendedorPJ" type="tect" id="emailVendedorPJ" class="form-control">
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="telefoneVendedorPj" class="form-label">Telefone</label>
                                    <input value="<?php echo $dadosVendedor['telefone_cnpj'] ?>" name="telefoneVendedorPj" type="text" id="telefoneVendedorPj" class="telefone form-control">
                                </div>
                            </div>
                            <div class="infoArea row">
                                <div class="col-md-6 col-sm-12">
                                    <label for="representantePj" class="form-label">Nome do Representante do CNPJ</label>
                                    <input value="<?php echo $dadosVendedor['nome_repre_vendedor'] ?>" name="representantePj" type="tect" id="representantePj" class="form-control">
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <label for="cpjRepresentanteCNPJ" class="form-label">CPF do Representante do CNPJ</label>
                                    <input value="<?php echo $dadosVendedor['cpf_representante_cnpj'] ?>" name="cpjRepresentanteCNPJ" type="text" id="cpjRepresentanteCNPJ" class="cpfMask form-control">
                                </div>
                            </div>
                        </div>
                    <?php } ?>


                    <!--Cônjuge-->
                    <div class="conjugueDados" id="conjugueDadosvendedor">
                        <div class="headerSubDados">
                            <h1><b>Informações Cônjuge</b></h1>
                            <hr>
                        </div>

                        <div class="infoArea row">
                            <div class="col-md-8 col-sm-12">
                                <label for="nameConjugueVendedor" class="form-label">Nome</label>
                                <input value="<?php echo $dadosVendedor['nome_conjugue'] ?>" name="nameConjugueVendedor" type="text" id="nameConjugueVendedor" class="form-control">
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <label for="nascimentoConjugueVendedor" class="form-label">Nascimento</label>
                                <input value="<?php echo $dadosVendedor['nascimento_conjugue'] ?>" name="nascimentoConjugueVendedor" type="date" id="nascimentoConjugueVendedor" class="form-control">
                            </div>

                        </div>
                        <div class="infoArea row">
                            <div class="col-md-8 col-sm-12">
                                <label for="emailConjugueVendedor" class="form-label">E-mail</label>
                                <input value="<?php echo $dadosVendedor['email_conjugue'] ?>" name="emailConjugueVendedor" type="email" id="emailConjugueVendedor" class="form-control">
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <label for="telefoneConjugueVendedor" class="form-label">Telefone</label>
                                <input value="<?php echo $dadosVendedor['telefone_conjugue'] ?>" name="telefoneConjugueVendedor" type="text" id="telefoneConjugueVendedor" class="form-control telefone">
                            </div>
                        </div>
                        <div class="infoArea row">
                            <div class="col-md-3 col-sm-12">
                                <label for="rgConjugueVendedor" class="form-label">RG</label>
                                <input value="<?php echo $dadosVendedor['rg_conjugue'] ?>" name="rgConjugueVendedor" type="text" id="rgConjugueVendedor" class="form-control">
                            </div>

                            <div class="col-md-3 col-sm-12">
                                <label for="emissorConjugueVendedor" class="form-label">Orgão Emissor</label>
                                <input value="<?php echo $dadosVendedor['orgao_emissor_conjugue'] ?>" name="emissorConjugueVendedor" type="text" id="emissorConjugueVendedor" class="form-control">
                            </div>

                            <div class="col-md-3 col-sm-12">
                                <label for="dataEmissaoConjugueVendedor" class="form-label">Data Emissor</label>
                                <input value="<?php echo $dadosVendedor['data_emissao_conjugue'] ?>" name="dataEmissaoConjugueVendedor" type="date" id="dataEmissaoConjugueVendedor" class="form-control">
                            </div>

                            <div class="col-md-3 col-sm-12">
                                <label for="cpfConjugueVendedor" class="form-label">CPF</label>
                                <input value="<?php echo $dadosVendedor['cpf_conjugue'] ?>" name="cpfConjugueVendedor" type="text" id="cpfConjugueVendedor" class="form-control cpfMask">
                            </div>
                        </div>
                        <div class="infoArea row">
                            <div class="col-md-6 col-sm-12">
                                <label for="nomeMaeConjugueVendedor" class="form-label">Nome da Mãe</label>
                                <input value="<?php echo $dadosVendedor['nome_mae_conjugue'] ?>" name="nomeMaeConjugueVendedor" type="tect" id="nomeMaeConjugueVendedor" class="form-control">
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label for="nomepaiConjugueVendedor" class="form-label">Nome do Pai</label>
                                <input value="<?php echo $dadosVendedor['nome_pai_conjugue'] ?>" name="nomepaiConjugueVendedor" type="text" id="nomepaiConjugueVendedor" class="form-control">
                            </div>
                        </div>
                    </div>
                    

                    <!--Endereço -->
                    <div class="headerSubDados">
                        <h1 class="direita"><b>Endereço</b></h1>
                        <hr>
                    </div>  
                    <div class="infoArea row">
                        <div disabled class="col-md-4 col-sm-12">
                            <label for="cepInput3" class="form-label">CEP</label>
                            <input value="<?php echo $dadosVendedor['cep_vendedor'] ?>" required name="cepuser3" type="tect" id="cepInput3" class="form-control cepInput">
                        </div>

                        <div disabled class="col-md-4 col-sm-12">
                            <label for="cidadeuser3" class="form-label">Cidade</label>
                            <input value="<?php echo $dadosVendedor['cidade_casa_vendedor'] ?>" required name="cidadeuser3" type="text" id="cidadeuser3" class="form-control">
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <label for="estadouser3" class="form-label">Estado</label>
                            <input value="<?php echo $dadosVendedor['estado_casa_vendedor'] ?>" required name="estadouser3" type="text" id="estadouser3" class="form-control">
                        </div>
                    </div>
                    <div class="infoArea row">
                        <div class="col-md-3 col-sm-12">
                            <label for="ruauser3" class="form-label">Rua</label>
                            <input value="<?php echo $dadosVendedor['endereço_vendedor'] ?>" required name="ruauser3" type="tect" id="ruauser3" class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <label for="completVendedor" class="form-label">Complemento</label>
                            <input value="<?php echo $dadosVendedor['complemento_casa_vendedor'] ?>" name="completVendedor" type="text" id="completVendedor" class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <label for="numerocasaVendedor" class="form-label">Número</label>
                            <input value="<?php echo $dadosVendedor['numero_casa_vendedor'] ?>" required name="numerocasaVendedor" type="text" id="numerocasaVendedor" class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <label for="bairrouser3" class="form-label">Bairro</label>
                            <input value="<?php echo $dadosVendedor['bairro_casa_vendedor'] ?>" required name="bairrouser3" type="text" id="bairrouser3" class="form-control">
                        </div>
                    </div>
                    <?php if($dadosVendedor['e_pj'] != "Sim") { ?>
                        <div class="profissaoVendedorPF">
                            <div class="headerSubDados">
                                <h1 class=""><b>Profissão</b></h1>
                                <hr>
                            </div>  
                            <div class="infoArea row">
                                <div class="col-md-12">
                                    <label for="profissaoVendedor" class="form-label">Profissão</label>
                                    <input value="<?php echo $dadosVendedor['profissao_vendedor'] ?>" required name="profissaoVendedor" type="tect" id="profissaoVendedor" class="form-control">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="headerSubDados">
                            <h1 class="direita"><b>Dados Bancarios</b></h1>
                        <hr>
                    </div>  
                    <div class="infoArea row">
                        <div class="col-md-4 col-sm-12">
                            <label for="bancoVendedor" class="form-label">Banco</label>
                            <select required name="bancoVendedor" class="form-select" id="bancoVendedor" aria-label="Default select example">
                                <option value="<?php echo $dadosVendedor['banco_vendedor'] ?>"><?php echo $dadosVendedor['banco_vendedor'] ?></option>
                                <option value="itau">Itau</option>
                                <option value="bradesco">Bradesco</option>
                                <option value="santander">Santander</option>
                                <option value="caixa">Caixa</option>
                                <option value="inter">Inter</option>
                            </select>  
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <label for="agenciaVendedor" class="form-label">Agencia</label>
                            <input value="<?php echo $dadosVendedor['agencia_vendedor'] ?>" required name="agenciaVendedor" type="text" id="agenciaVendedor" class="form-control">
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <label for="contaVendedor" class="form-label">Conta Bancaria</label>
                            <input value="<?php echo $dadosVendedor['conta_vendedor'] ?>" required name="contaVendedor" type="text" id="contaVendedor" class="form-control">
                        </div>
                    </div>
                    <div class="btnStatusProposta">
                        <button type="submit"  style="margin-left:auto;" class="cta">
                            <span class="hover-underline-animation">Adicionar</span>
                            <svg
                                id="arrow-horizontal"
                                xmlns="http://www.w3.org/2000/svg"
                                width="30"
                                height="10"
                                viewBox="0 0 46 16"
                            >
                                <path
                                id="Path_10"
                                data-name="Path 10"
                                d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z"
                                transform="translate(30)"
                                ></path>
                            </svg>
                        </button>
                    </div>
            </form>
        </div>
    </section>

    <!-- Modal Deletar Comprador -->
    <div class="modal fade" id="modalDeletarComprador" tabindex="-1" aria-labelledby="modalDeletarCompradorLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalDeletarCompradorLabel">Excluir Comprador</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="color:red;text-align:center;"><b>você esta prestes a excluir a um comprador, gostaria de processeguir?</b></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <a href="deletComprador.php?id=<?php echo $dadosVendedor['id_vendedor'];?>">
                    <button type="button" class="btn btn-danger">Excluir</button>
                </a>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Documentos -->
    <div class="modal fade" id="documentoComprador" tabindex="-1" aria-labelledby="documentoCompradorLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="documentoCompradorLabel">Documentos de <?php if($dadosVendedor["e_pj"] == "nao") { echo removerTextoDepoisDoEspaco($dadosVendedor['nome_vendedor']); } else { echo removerTextoDepoisDoEspaco($dadosVendedor['nome_empresarial']); } ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form enctype="multipart/form-data" method="POST">
                    <div class="modal-body">  
                        <?php if($dadosVendedor["e_pj"] == "nao") { ?>
                            <?php if(!isset($docVendedor['path_cpf']) || $docVendedor['path_cpf'] == '') { ?>
                                <div class="inputforms">
                                    <label class="" ><b>CPF</b></label>
                                    <div class="input-group">
                                        <input name="cpf_file" type="file" class="form-control" id="">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div style="margin: 15px 0;text-align:center;">   
                                    <span style="color:green;margin-bottom: 15px;"><b>CPF Já enviado!!!</b></span>
                                </div>
                            <?php } ?>

                            <?php if(!isset($docVendedor['path_rg_cnh']) || $docVendedor['path_rg_cnh'] == '') { ?>
                                <div class="inputforms">
                                    <label class="" ><b>RG/CNH</b></label>
                                    <div class="input-group">
                                        <input name="rg_cnh_file" type="file" class="form-control" id="">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div style="margin: 15px 0;text-align:center;">                                    
                                    <span style="color:green;"><b>RG/CNH Já enviado!!!</b></span>
                                </div>

                            <?php } ?>

                            <?php if(!isset($docVendedor['path_comp_resi']) || $docVendedor['path_comp_resi'] == '' ) { ?>
                                <div class="inputforms">
                                    <label class="" ><b>Comprovante de Residencia</b></label>
                                    <div class="input-group">
                                        <input name="comp_resi_file" type="file" class="form-control" id="">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div style="margin: 15px 0;text-align:center;">                                    
                                    <span style="color:green;"><b>Comprovante de Residencia Já enviado!!!</b></span>
                                </div>

                            <?php } ?>

                            <?php if(!isset($docVendedor['path_Comp_estado']) || $docVendedor['path_Comp_estado'] == '' ) { ?>
                                <div class="inputforms">
                                    <label class="" ><b>Comprovante Estado Civil</b></label>
                                    <div class="input-group">
                                        <input name="comp_estado_civil_file" type="file" class="form-control" id="">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div style="margin: 15px 0;text-align:center;">                                    
                                    <span style="color:green;"><b>Comprovante Estado Civil Já enviado!!!</b></span>
                                </div>

                            <?php } ?>

                            <?php if($dadosVendedor['estado_civil_vendedor'] == 'casado') { ?>

                                <?php if(!isset($docVendedor['path_conjugue_rg_cnh']) || $docVendedor['path_conjugue_rg_cnh'] == '' ) { ?>
                                    <div class="inputforms">
                                        <label class="" ><b>RG/CNH Cônjuge</b></label>
                                        <div class="input-group">
                                            <input name="rg_chh_conj_file" type="file" class="form-control" id="">
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div style="margin: 15px 0;text-align:center;">                                    
                                        <span style="color:green;"><b>RG/CNH Cônjuge Já enviado!!!</b></span>
                                    </div>

                                <?php } ?>

                                <?php if(!isset($dadosVendedor['path_cpf_conjugue']) || $docVendedor['path_cpf_conjugue'] == '') { ?>
                                    <div class="inputforms">
                                        <label class="" ><b>CPF Cônjuge</b></label>
                                        <div class="input-group">
                                            <input name="cpf_Cônjuge_file" type="file" class="form-control" id="">
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div style="margin: 15px 0;text-align:center;">                                    
                                        <span style="color:green;"><b>CPF Cônjuge Já enviado!!!</b></span>
                                    </div>

                                <?php } ?>

                            <?php } ?>    
                        <?php } else { ?>
                            
                            <?php if(!isset($docVendedor['contrato_social']) || $docVendedor['contrato_social'] == '') { ?>
                                <div class="inputforms">
                                    <label class="" ><b>Contrato Social</b></label>
                                    <div class="input-group">
                                        <input name="contrato_social_file" type="file" class="form-control" id="">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div style="margin: 15px 0;text-align:center;">   
                                    <span style="color:green;margin-bottom: 15px;"><b>Contrato Social Já enviado!!!</b></span>
                                </div>
                            <?php } ?>

                            <?php if(!isset($docVendedor['rg_cnh_repre']) || $docVendedor['rg_cnh_repre'] == '') { ?>
                                <div class="inputforms">
                                    <label class="" ><b>RG/CNH do Representante do CNPJ</b></label>
                                    <div class="input-group">
                                        <input name="rg_cnh_repre_file" type="file" class="form-control" id="">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div style="margin: 15px 0;text-align:center;">   
                                    <span style="color:green;margin-bottom: 15px;"><b>RG/CNH do Representante do CNPJ Já enviado!!!</b></span>
                                </div>
                            <?php } ?>

                            <?php if(!isset($docVendedor['cpf_repre']) || $docVendedor['cpf_repre'] == '') { ?>
                                <div class="inputforms">
                                    <label class="" ><b>CPF do Representante do CNPJ</b></label>
                                    <div class="input-group">
                                        <input name="cpf_repre_file" type="file" class="form-control" id="">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div style="margin: 15px 0;text-align:center;">   
                                    <span style="color:green;margin-bottom: 15px;"><b>CPF do Representante do CNPJ Já enviado!!!</b></span>
                                </div>
                            <?php } ?>
                        
                        <?php } ?> 
                    </div>
                    <div class="modal-footer">
                        <button style="margin-left:auto;" type="submit" class="cta">
                            <span class="hover-underline-animation"> Enviar </span>
                                <svg
                                    id="arrow-horizontal"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="30"
                                    height="10"
                                    viewBox="0 0 46 16"
                            >
                            <path
                            id="Path_10"
                            data-name="Path 10"
                            d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z"
                            transform="translate(30)"
                            ></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>






    <footer>
        <p>©AprovaCredi 2024 | Todos os direitos reservados.<br>
                Site Elaborado por: <a target="_blank" href="https://www.linkedin.com/in/victor-hugo-ramiro-cota/"><b>Victor Hugo Ramiro Cota.</b></a>
    </p>
    </footer>
    <div id="whatswidget-pre-wrapper" class="">
    <div id="whatswidget-widget-wrapper" class="whatswidget-widget-wrapper" style="all:revert;">
    <div id="whatswidget-conversation" class="whatswidget-conversation" style="color: revert; font: revert; font-palette: revert; font-synthesis: revert; forced-color-adjust: revert; text-orientation: revert; text-rendering: revert; -webkit-font-smoothing: revert; -webkit-locale: revert; -webkit-text-orientation: revert; -webkit-writing-mode: revert; writing-mode: revert; zoom: revert; accent-color: revert; place-content: revert; place-items: revert; place-self: revert; alignment-baseline: revert; animation-composition: revert; animation: revert; app-region: revert; appearance: revert; aspect-ratio: revert; backdrop-filter: revert; backface-visibility: revert; background: revert; background-blend-mode: revert; baseline-shift: revert; baseline-source: revert; block-size: revert; border-block: revert; border: revert; border-radius: revert; border-collapse: revert; border-end-end-radius: revert; border-end-start-radius: revert; border-inline: revert; border-start-end-radius: revert; border-start-start-radius: revert; inset: revert; box-shadow: revert; box-sizing: revert; break-after: revert; break-before: revert; break-inside: revert; buffered-rendering: revert; caption-side: revert; caret-color: revert; clear: revert; clip: revert; clip-path: revert; clip-rule: revert; color-interpolation: revert; color-interpolation-filters: revert; color-rendering: revert; color-scheme: revert; columns: revert; column-fill: revert; gap: revert; column-rule: revert; column-span: revert; contain: revert; contain-intrinsic-block-size: revert; contain-intrinsic-size: revert; contain-intrinsic-inline-size: revert; container: revert; content: revert; content-visibility: revert; counter-increment: revert; counter-reset: revert; counter-set: revert; cursor: revert; cx: revert; cy: revert; d: revert; display: none; dominant-baseline: revert; empty-cells: revert; fill: revert; fill-opacity: revert; fill-rule: revert; filter: revert; flex: revert; flex-flow: revert; float: revert; flood-color: revert; flood-opacity: revert; grid: revert; grid-area: revert; height: revert; hyphenate-character: revert; hyphenate-limit-chars: revert; hyphens: revert; image-orientation: revert; image-rendering: revert; initial-letter: revert; inline-size: revert; inset-block: revert; inset-inline: revert; isolation: revert; letter-spacing: revert; lighting-color: revert; line-break: revert; list-style: revert; margin-block: revert; margin: revert; margin-inline: revert; marker: revert; mask: revert; mask-type: revert; math-depth: revert; math-shift: revert; math-style: revert; max-block-size: revert; max-height: revert; max-inline-size: revert; max-width: revert; min-block-size: revert; min-height: revert; min-inline-size: revert; min-width: revert; mix-blend-mode: revert; object-fit: revert; object-position: revert; object-view-box: revert; offset: revert; opacity: 0; order: revert; orphans: revert; outline: revert; outline-offset: revert; overflow-anchor: revert; overflow-clip-margin: revert; overflow-wrap: revert; overflow: revert; overscroll-behavior-block: revert; overscroll-behavior-inline: revert; overscroll-behavior: revert; padding-block: revert; padding: revert; padding-inline: revert; page: revert; page-orientation: revert; paint-order: revert; perspective: revert; perspective-origin: revert; pointer-events: revert; position: revert; quotes: revert; r: revert; resize: revert; rotate: revert; ruby-position: revert; rx: revert; ry: revert; scale: revert; scroll-behavior: revert; scroll-margin-block: revert; scroll-margin: revert; scroll-margin-inline: revert; scroll-padding-block: revert; scroll-padding: revert; scroll-padding-inline: revert; scroll-snap-align: revert; scroll-snap-stop: revert; scroll-snap-type: revert; scrollbar-gutter: revert; shape-image-threshold: revert; shape-margin: revert; shape-outside: revert; shape-rendering: revert; size: revert; speak: revert; stop-color: revert; stop-opacity: revert; stroke: revert; stroke-dasharray: revert; stroke-dashoffset: revert; stroke-linecap: revert; stroke-linejoin: revert; stroke-miterlimit: revert; stroke-opacity: revert; stroke-width: revert; tab-size: revert; table-layout: revert; text-align: revert; text-align-last: revert; text-anchor: revert; text-combine-upright: revert; text-decoration: revert; text-decoration-skip-ink: revert; text-emphasis: revert; text-emphasis-position: revert; text-indent: revert; text-overflow: revert; text-shadow: revert; text-size-adjust: revert; text-transform: revert; text-underline-offset: revert; text-underline-position: revert; touch-action: revert; transform: revert; transform-box: revert; transform-origin: revert; transform-style: revert; transition: revert; translate: revert; user-select: revert; vector-effect: revert; vertical-align: revert; view-transition-name: revert; visibility: revert; border-spacing: revert; -webkit-box-align: revert; -webkit-box-decoration-break: revert; -webkit-box-direction: revert; -webkit-box-flex: revert; -webkit-box-ordinal-group: revert; -webkit-box-orient: revert; -webkit-box-pack: revert; -webkit-box-reflect: revert; -webkit-highlight: revert; -webkit-line-break: revert; -webkit-line-clamp: revert; -webkit-mask-box-image: revert; -webkit-mask: revert; -webkit-mask-composite: revert; -webkit-print-color-adjust: revert; -webkit-rtl-ordering: revert; -webkit-ruby-position: revert; -webkit-tap-highlight-color: revert; -webkit-text-combine: revert; -webkit-text-decorations-in-effect: revert; -webkit-text-fill-color: revert; -webkit-text-security: revert; -webkit-text-stroke: revert; -webkit-user-drag: revert; -webkit-user-modify: revert; white-space: revert; widows: revert; width: revert; will-change: revert; word-break: revert; word-spacing: revert; x: revert; y: revert; z-index: revert;"><div class="whatswidget-conversation-header" style="all:revert;">
    <div style="text-aling:center;" id="whatswidget-conversation-title" class="whatswidget-conversation-title" style="all:revert;"> Atendimento Aprovacredi!</div></div><div id="whatswidget-conversation-message" class="whatswidget-conversation-message " style="all:revert;">Está precisando de ajuda?<br/> estamos disponiveis de <b>Segunda</b> a <b> Sexta</b> das <b>08h30</b> às <b>18h00</b> </div><div class="whatswidget-conversation-cta" style="all:revert;"> <a style="all:revert;" id="whatswidget-phone-desktop" target="_blank" href="https://wa.me/5513991080129?text=Ol%C3%A1%2C+sou+um+corretor+usuario+do+sistema+Aprovacredi+e+tenho+um+problema%2C+pode+me+ajudar%3F" class="whatswidget-cta whatswidget-cta-desktop">Enviar Mensagem</a> <a id="whatswidget-phone-mobile" target="_blank" href="https://wa.me/5513991080129" class="whatswidget-cta whatswidget-cta-mobile" style="all:revert;">Enviar Mensagem</a></div></div><div id="whatswidget-conversation-message-outer" class="whatswidget-conversation-message-outer" style="color: revert; font: revert; font-palette: revert; font-synthesis: revert; forced-color-adjust: revert; text-orientation: revert; text-rendering: revert; -webkit-font-smoothing: revert; -webkit-locale: revert; -webkit-text-orientation: revert; -webkit-writing-mode: revert; writing-mode: revert; zoom: revert; accent-color: revert; place-content: revert; place-items: revert; place-self: revert; alignment-baseline: revert; animation-composition: revert; animation: revert; app-region: revert; appearance: revert; aspect-ratio: revert; backdrop-filter: revert; backface-visibility: revert; background: revert; background-blend-mode: revert; baseline-shift: revert; baseline-source: revert; block-size: revert; border-block: revert; border: revert; border-radius: revert; border-collapse: revert; border-end-end-radius: revert; border-end-start-radius: revert; border-inline: revert; border-start-end-radius: revert; border-start-start-radius: revert; inset: revert; box-shadow: revert; box-sizing: revert; break-after: revert; break-before: revert; break-inside: revert; buffered-rendering: revert; caption-side: revert; caret-color: revert; clear: revert; clip: revert; clip-path: revert; clip-rule: revert; color-interpolation: revert; color-interpolation-filters: revert; color-rendering: revert; color-scheme: revert; columns: revert; column-fill: revert; gap: revert; column-rule: revert; column-span: revert; contain: revert; contain-intrinsic-block-size: revert; contain-intrinsic-size: revert; contain-intrinsic-inline-size: revert; container: revert; content: revert; content-visibility: revert; counter-increment: revert; counter-reset: revert; counter-set: revert; cursor: revert; cx: revert; cy: revert; d: revert; display: none; dominant-baseline: revert; empty-cells: revert; fill: revert; fill-opacity: revert; fill-rule: revert; filter: revert; flex: revert; flex-flow: revert; float: revert; flood-color: revert; flood-opacity: revert; grid: revert; grid-area: revert; height: revert; hyphenate-character: revert; hyphenate-limit-chars: revert; hyphens: revert; image-orientation: revert; image-rendering: revert; initial-letter: revert; inline-size: revert; inset-block: revert; inset-inline: revert; isolation: revert; letter-spacing: revert; lighting-color: revert; line-break: revert; list-style: revert; margin-block: revert; margin: revert; margin-inline: revert; marker: revert; mask: revert; mask-type: revert; math-depth: revert; math-shift: revert; math-style: revert; max-block-size: revert; max-height: revert; max-inline-size: revert; max-width: revert; min-block-size: revert; min-height: revert; min-inline-size: revert; min-width: revert; mix-blend-mode: revert; object-fit: revert; object-position: revert; object-view-box: revert; offset: revert; opacity: revert; order: revert; orphans: revert; outline: revert; outline-offset: revert; overflow-anchor: revert; overflow-clip-margin: revert; overflow-wrap: revert; overflow: revert; overscroll-behavior-block: revert; overscroll-behavior-inline: revert; overscroll-behavior: revert; padding-block: revert; padding: revert; padding-inline: revert; page: revert; page-orientation: revert; paint-order: revert; perspective: revert; perspective-origin: revert; pointer-events: revert; position: revert; quotes: revert; r: revert; resize: revert; rotate: revert; ruby-position: revert; rx: revert; ry: revert; scale: revert; scroll-behavior: revert; scroll-margin-block: revert; scroll-margin: revert; scroll-margin-inline: revert; scroll-padding-block: revert; scroll-padding: revert; scroll-padding-inline: revert; scroll-snap-align: revert; scroll-snap-stop: revert; scroll-snap-type: revert; scrollbar-gutter: revert; shape-image-threshold: revert; shape-margin: revert; shape-outside: revert; shape-rendering: revert; size: revert; speak: revert; stop-color: revert; stop-opacity: revert; stroke: revert; stroke-dasharray: revert; stroke-dashoffset: revert; stroke-linecap: revert; stroke-linejoin: revert; stroke-miterlimit: revert; stroke-opacity: revert; stroke-width: revert; tab-size: revert; table-layout: revert; text-align: revert; text-align-last: revert; text-anchor: revert; text-combine-upright: revert; text-decoration: revert; text-decoration-skip-ink: revert; text-emphasis: revert; text-emphasis-position: revert; text-indent: revert; text-overflow: revert; text-shadow: revert; text-size-adjust: revert; text-transform: revert; text-underline-offset: revert; text-underline-position: revert; touch-action: revert; transform: revert; transform-box: revert; transform-origin: revert; transform-style: revert; transition: revert; translate: revert; user-select: revert; vector-effect: revert; vertical-align: revert; view-transition-name: revert; visibility: revert; border-spacing: revert; -webkit-box-align: revert; -webkit-box-decoration-break: revert; -webkit-box-direction: revert; -webkit-box-flex: revert; -webkit-box-ordinal-group: revert; -webkit-box-orient: revert; -webkit-box-pack: revert; -webkit-box-reflect: revert; -webkit-highlight: revert; -webkit-line-break: revert; -webkit-line-clamp: revert; -webkit-mask-box-image: revert; -webkit-mask: revert; -webkit-mask-composite: revert; -webkit-print-color-adjust: revert; -webkit-rtl-ordering: revert; -webkit-ruby-position: revert; -webkit-tap-highlight-color: revert; -webkit-text-combine: revert; -webkit-text-decorations-in-effect: revert; -webkit-text-fill-color: revert; -webkit-text-security: revert; -webkit-text-stroke: revert; -webkit-user-drag: revert; -webkit-user-modify: revert; white-space: revert; widows: revert; width: revert; will-change: revert; word-break: revert; word-spacing: revert; x: revert; y: revert; z-index: revert;"> <span id="whatswidget-text-header-outer" class="whatswidget-text-header-outer" style="all:revert;">Aprovacredi</span><br> <div id="whatswidget-text-message-outer" class="whatswidget-text-message-outer" style="all:revert;">Precisa de ajuda? </div></div><div class="whatswidget-button-wrapper" style="all:revert;"><div class="whatswidget-button" id="whatswidget-button" style="all:revert;"><div style="margin:0 auto;width:38.5px;all:revert;"> <img class="whatswidget-icon" style="all:revert;" src=" data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAXAAAAFkCAYAAAA5XmCyAAAAhnpUWHRSYXcgcHJvZmlsZSB0eXBlIGV4aWYAAHjaVY7tDcMwCET/M0VHOAPBZpxISaRu0PF7Lk2iPAnz/IVO9s/7kNekAeJLH5ERIJ6eulIGCgOaos3Otfh3azSlbLUX05LI0eH3Q8eTBTHi6M7iF1PdLVj2u+QMwYyQ94B+mj3Pw69MleALmvYrSXthNkAAAAoGaVRYdFhNTDpjb20uYWRvYmUueG1wAAAAAAA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pgo8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJYTVAgQ29yZSA0LjQuMC1FeGl2MiI+CiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogIDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiCiAgICB4bWxuczpleGlmPSJodHRwOi8vbnMuYWRvYmUuY29tL2V4aWYvMS4wLyIKICAgIHhtbG5zOnRpZmY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vdGlmZi8xLjAvIgogICBleGlmOlBpeGVsWERpbWVuc2lvbj0iMzY4IgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzU2IgogICB0aWZmOkltYWdlV2lkdGg9IjM2OCIKICAgdGlmZjpJbWFnZUhlaWdodD0iMzU2IgogICB0aWZmOk9yaWVudGF0aW9uPSIxIi8+CiA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAg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"></div></div></div>
    <script id="whatswidget-script" type="text/javascript">document.getElementById("whatswidget-conversation").style.display="none";document.getElementById("whatswidget-conversation").style.opacity="0"; var button=document.getElementById("whatswidget-button");button.addEventListener("click",openChat);var conversationMessageOuter=document.getElementById("whatswidget-conversation-message-outer");conversationMessageOuter.addEventListener("click",openChat);var chatOpen=!1;function openChat(){0==chatOpen?(document.getElementById("whatswidget-conversation").style.display="block",document.getElementById("whatswidget-conversation").style.opacity=100,chatOpen=!0,document.getElementById("whatswidget-conversation-message-outer").style.display="none"):(document.getElementById("whatswidget-conversation").style.opacity=0,document.getElementById("whatswidget-conversation").style.display="none",chatOpen=!1)}</script></div>
    <style id="whatswidget-style">.whatswidget-widget-wrapper{font-family:"Helvetica Neue","Apple Color Emoji",Helvetica,Arial,sans-serif !important;font-size:16px !important;position:fixed !important;bottom:-15px !important;right:45px !important;z-index:1001 !important}.whatswidget-conversation{background-color:#e4dcd4 !important;background-image:url('data:image/png !important;base64,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') !important;background-repeat:repeat !important;box-shadow:rgba(0, 0, 0, 0.16) 0px 5px 40px !important;width:250px !important;height:300px !important;border-radius:10px !important;transition-duration:0.5s !important;margin-bottom:80px !important}.whatswidget-conversation-header{background-color:white !important;padding:10px !important;padding-left:25px !important;box-shadow:0px 1px #00000029 !important;font-weight:600 !important;border-top-left-radius:10px !important;border-top-right-radius:10px !important}.whatswidget-conversation-message{line-height: 1.2em !important;background-color:white !important;padding:10px !important;margin:10px !important;margin-left:15px !important;border-radius:5px !important}.whatswidget-conversation-message-outer{background-color:#FFF !important;padding:10px !important;margin:10px !important;margin-left:0px !important;border-radius:5px !important;box-shadow:rgba(0, 0, 0, 0.342) 0px 2.5px 10px !important;cursor:pointer !important;animation:nudge 2s linear infinite !important;margin-bottom:70px !important}.whatswidget-text-header-outer{font-weight:bold !important;font-size:90% !important}.whatswidget-text-message-outer{font-size:90% !important}.whatswidget-conversation-cta{border-radius:25px !important;width:175px !important;font-size:110% !important;padding:10px !important;margin:0 auto !important;text-align:center !important;background-color:#23b123 !important;color:white !important;font-weight:bold !important;box-shadow:rgba(0, 0, 0, 0.16) 0px 2.5px 10px !important;transition:1s !important;position:absolute !important;top:62% !important;left:10% !important}.whatswidget-conversation-cta:hover{transform:scale(1.1) !important;filter:brightness(1.3) !important}.whatswidget-cta{text-decoration:none !important;color:white !important}.whatswidget-cta-desktop{display:none !important}.whatswidget-cta-mobile{display:inherit !important}@media (min-width: 48em){.whatswidget-cta-desktop{display:inherit !important}
    .whatswidget-cta-mobile{display:none !important}}.whatswidget-button-wrapper{position:fixed !important;bottom:15px !important;right:15px !important}.whatswidget-button{position:relative !important;right:0px !important;background-color:#31d831 !important;border-radius:100% !important;width:50px !important;height:50px !important;box-shadow:2px 1px #0d630d63 !important;transition:1s !important}.whatswidget-icon{width:35px !important;height:35px !important;position:absolute !important; bottom:7px !important; left:8px !important;}.whatswidget-button:hover{filter:brightness(115%) !important;transform:rotate(15deg) scale(1.15) !important;cursor:pointer !important}@keyframes nudge{20%,100%{transform:translate(0,0)}0%{transform:translate(0,5px);transform:rotate(2deg)}10%{transform:translate(0,-5px);transform:rotate(-2deg)}}.whatswidget-link{position:absolute !important;bottom:90px !important;right:5px !important;opacity:0.5 !important}</style>
    </div>

    <script>
        $(function(){
            $('.formatReal').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
        })



        document.addEventListener('DOMContentLoaded', function() {
            var estadoCivilVendedor = document.getElementById('estadoCivilVendedor');
            mostrarEsconderConjugueVendedor(estadoCivilVendedor);  // Chama a função para verificar o estado inicial
        });
    </script>

    <script src="../../../bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../javascript/buscarCEP.js"></script>
    <script src="../../../javascript/masksystem.js"></script>
    <script src="../../../javascript/sidebars.js"></script>
    <script src="../../../javascript/editarInpust.js"></script>
</body>
</html>
