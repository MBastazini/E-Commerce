<?php 
   // mostra erros do php
   ini_set ( 'display_errors' , 1); 
   error_reporting (E_ALL);

   include("caixa.php");
    
   $conn = coneccao();

    $id = $_GET['id'];

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
    <h3>Alterar produto</h3>
        <form action='adicionarprod.php' method='post'>
        <p>codigo</p>
        <input type='type'  name='cod' value='$cod'> 

        <p>nome</p>
        <input type='type'  name='nome' value='$nome'> 
        
        <p>descricao</p>
        <input type='type'  name='descricao' value='$desc'> 
        
        <p>preço</p>
        <input type='type'  name='preco' value='$preco'> 

        <p>excluido</p>
        <input type='type'  name='excluido' value='$excluido'> 

        <p>data de exclusão</p>
        <input type='type'  name='dataexclusao' value='$data_exclusao'> 

        <p>codigo visual</p>
        <input type='type'  name='codvisual' value='$codigovisual'> 

        <p>custo</p>
        <input type='type'  name='custo' value='$custo'> 

        <p>margem de lucro</p>
        <input type='type'  name='lucro' value='$margem_lucro'> 

        <p>icms</p>
        <input type='type'  name='icms' value='$icms'> 

        </form>
    ";

   $linha = [   'cod_produto'     => $linha['cod_produto'],
                'nome'            => $linha['nome'],
                'descricao'       => $linha['descricao'],
                'preco'           => $linha['preco'],
               'excluido'         => $linha['excluido'],
                'data_exclusao'   => $linha['data_exclusao'],
                'codigovisual'    => $linha['codigovisual'],
                'custo'           => $linha['custo'],
                'margem_lucro'    => $linha['margem_lucro'],
                'icms'            => $linha['icms']
];

   $sql2 = "update tbl_produto set 
            cod_produto         = :cod_produto
             nome               = :nome, 
             descricao          = :descricao,   
             preco              = :preco, 
             excluido           = :excluido,   
             data_exclusao      = :data_exclusao 
             codigovisual       = :codigovisual 
             data_exclusao      = :data_exclusao 
             custo              = :custo 
             margem_lucro       = :margem_lucro 
             icms               = :icms 
           where cod_produto = :cod_produto "; 
   
   $update = $conn->prepare($sql2); 
   $update->execute($linha);

   header('Location: admconta.php');     

?>
