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

    $sql_userPrimario = "SELECT * FROM usuarios WHERE id  = $idUser";
    $query_userPrimario = $mysqli->query($sql_userPrimario) or die($mysqli->error);
    $num_userPrimario = $query_userPrimario->num_rows;
    $usuarioPrimario = $query_userPrimario->fetch_assoc();
    if($usuarioPrimario['id_masteraccount'] == NULL) {
        $id_MasterAcont = $idUser;
    } else { $id_MasterAcont = $usuarioPrimario['id_masteraccount']; }


    if(count($_POST) > 0) {
        $id_corretor = $idUser;
        $data_criacao = date('d/m/Y');
        $tipoImovel = $_POST['tipoImovel'];
        $nome_corretor = $name;
        $nomeComprador = $_POST['nomeComprador'];
        $cpfComprador = $_POST['cpfComprador'];
        $estadoImovel = $_POST['estadoImovel'];
        $cidadeImovel = $_POST['cidadeImovel'];
        $valorTotalImo = $_POST['valorTotalImo'];
        $ValorTotalFinan = $_POST['ValorTotalFinan'];

                    if($erro){
                        echo "<p><b>ERRO: $erro</b></p>";
                    } else{
                        $sql_code = "INSERT INTO db_propostas (id_MasterAcont, id_usuario, data_criacao, nome_usuario, nome_comprador, tipo_financiamento, cpf_comprador, cidade_imovel, estado_imovel, valor_imovel, financiado, data) 
                        VALUE('$id_MasterAcont', '$id_corretor', '$data_criacao','$nome_corretor', '$nomeComprador', '$tipoImovel', '$cpfComprador', '$cidadeImovel', '$estadoImovel', '$valorTotalImo', '$ValorTotalFinan', NOW())";
                        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        
                        if($deu_certo) {
                            header("Location: ../gestao/myPropost.php");
                            unset($_POST);
                        } 
                    }
         
    }