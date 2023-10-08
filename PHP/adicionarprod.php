<?php 
   // mostra erros do php
   ini_set ( 'display_errors' , 1); 
   error_reporting (E_ALL);

   include("caixa.php");

   $conn = coneccao();

   $linha = [   'cod_produto'     => $_POST['cod_produto'],
                'nome'            => $_POST['nome'],
                'descricao'       => $_POST['descricao'],
                'preco'           => $_POST['preco'],
                'excluido'        => $_POST['excluido'],
                'data_exclusao'   => $_POST['data_exclusao'],
                'codigovisual'    => $_POST['codigovisual'],
                'custo'           => $_POST['custo'],
                'margem_lucro'    => $_POST['margem_lucro'],
                'icms'            => $_POST['icms']
];

   $sql = " insert into tbl_produto (cod_produto,nome,descricao,preco,excluido,data_exclusao,codigovisual,custo,margem_lucro,icms)  
            values (:cod_produto,:nome,:descricao,:preco,:excluido,:data_exclusao,:codigovisual,:custo,:margem_lucro,:icms) ";

   $update = $conn->prepare($sql); 
   $update->execute($linha);

   header('Location: admconta.php');     

?>
