<?php 
   // mostra erros do php
   ini_set ( 'display_errors' , 1); 
   error_reporting (E_ALL);

   include("caixa.php");
    
   $conn = coneccao();

   $id = $_GET['id'] ; 


    $sql1 = "select * from tbl_produto where cod_produto = $id";
    $select = $conn->query($sql1); 

    while ($var = $select->fetch() ){
        $cod = $var['cod_produto'];
        $nome = $var['nome'];
        $desc = $var['descricao'];
        $preco = $var['preco'];
        $excluido = $var['excluido'];
        $data_exclusao = $var['data_exclusao'];
        $codigovisual = $var['codigovisual'];
        $custo = $var['custo'];
        $margem_lucro = $var['margem_lucro'];
        $icms = $var['icms'];
    }  
    echo"
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <title>Minha Conta</title>
        <link rel='stylesheet' type='text/css' href='index.css'>
        </head>
    <body>";

   echo"
    <h3>Alterar produto</h3>
        <form action='update.php' method='post'>
        <p>codigo</p>
        <input type='text'  name='cod' value='$cod'> 

        <p>nome</p>
        <input type='text'  name='nome' value='$nome'> 
        
        <p>descricao</p>
        <input type='text'  name='desc' value='$desc'> 
        
        <p>preço</p>
        <input type='text'  name='prec' value='$preco'> 

        <p>excluido</p>
        <input type='text'  name='ex' value='$excluido'> 

        <p>data de exclusão</p>
        <input type='text'  name='dtex' value='$data_exclusao'> 

        <p>codigo visual</p>
        <input type='text'  name='covi' value='$codigovisual'> 

        <p>custo</p>
        <input type='text'  name='custo' value='$custo'> 

        <p>margem de lucro</p>
        <input type='text'  name='lucro' value='$margem_lucro'> 

        <p>icms</p>
        <input type='text'  name='icms' value='$icms'> 

        <input type='submit' value='alterar'>

        </form>
    ";


?>
