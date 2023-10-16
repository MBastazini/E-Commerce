<?php
    //Esse
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    session_start();        

    include("caixa.php");

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
   
    $update = $conn -> prepare($sql);
    $update -> execute($linha);
    
    header('Location: ../conta.php');
    
    
?>
