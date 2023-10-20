<?php
    //Esse
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("caixa.php");

    $conectado = inicioSessao();
    if($conectado){
        if($_SESSION['usuario']['ativo'])
        {
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $linha = [
                    'cod_usuario' => $_POST['codigo'],
                    'nome' => $_POST['nome'],
                    'email' => $_POST['email'],
                    'telefone' => $_POST['telefone'],
                    'senha' => $_POST['senha']
                ];

                $conn = coneccao();

                $sql = 'UPDATE tbl_usuario SET 
                    nome = :nome,
                    email = :email,
                    telefone = :telefone,
                    senha = :senha
                    WHERE cod_usuario = :cod_usuario';

                executaSQL($sql, $linha);

                header('Location: ../Conta');
            }
        }
    }
?>
