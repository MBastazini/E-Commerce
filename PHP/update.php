<?php

    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    include("caixa.php");
    
    $conn = coneccao();


    $linha = [      'cod_produto'     => $_POST['cod'],
                    'nome'            => $_POST['nome'],
                    'descricao'       => $_POST['desc'],
                    'preco'           => $_POST['prec'],
                    'excluido'        => $_POST['ex'],
                    'data_exclusao'   => $_POST['dtex'],
                    'codigovisual'    => $_POST['covi'],
                    'custo'           => $_POST['custo'],
                    'margem_lucro'    => $_POST['lucro'],
                    'icms'            => $_POST['icms']
    ];


    $sql2 = "update tbl_produto set 
                nome = :nome, 
                descricao = :descricao,   
                preco = :preco, 
                excluido = :excluido,   
                data_exclusao = :data_exclusao, 
                codigovisual = :codigovisual, 
                custo = :custo, 
                margem_lucro = :margem_lucro ,
                icms = :icms 
            where cod_produto = :cod_produto "; 
    
    $update = $conn->prepare($sql2); 
    $update->execute($linha);

    header('Location: admconta.php');
   ?>