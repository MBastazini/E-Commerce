<?php
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    include("caixa.php");

    session_start();        

    $conn = coneccao();

    $sql = "select * from tbl_produto order by cod_produto";

    $select = $conn->query($sql);

//inicio doc html
    echo "
            <!DOCTYPE html>
            <html lang='pt-br'>
            <head>
                <title>Minha Conta</title>
                <link rel='stylesheet' type='text/css' href='index.css'>
                </head>
            <body>
        ";

//form para adicionar produtos
echo"
<div class='adm'>
<h3>Adicionar produto</h3>
<form action='adicionarprod.php' method='post'>
    codigo
    <input type='text'  name='cod_produto'> 

    nome
    <input type='text'  name='nome'> 
    
    descricao
    <input type='text'  name='descricao'> 
    
    preço
    <input type='text'  name='preco'> 

    excluido(true ou false)
    <input type='text'  name='excluido'> 

    data de exclusão
    <input type='text'  name='data_exclusao'> 

    codigo visual
    <input type='text'  name='codigovisual'> 

    custo
    <input type='text'  name='custo'> 

    margem de lucro
    <input type='text'  name='margem_lucro'> 

    icms
    <input type='text'  name='icms'> 

    <input type='submit' value='adicionar'>
</form>
</div>
    ";



//começo tabela alterar deletar
        echo "<table border='1' id='tabela'>
                <th>Id</th>
                <th>Nome</th>
                <th>descrição</th>
                <th>preço</th>
                <th>excluido</th>
                <th>data de exclusão</th>
                <th>codigo visual</th>
                <th>custo</th>
                <th>lucro</th>
                <th>icms</th>
                <th>alterar</th>
                <th>excluir</th>
              ";
     
        // fetch significa carregar proxima linha
        // qdo nao tiver mais nenhuma retorna FALSE pro while
        while ( $linha = $select->fetch() )  
        {
          // imprime as posicoes de $linha que sao os campos carregados  
          $varId                = $linha['cod_produto'];
          $varNome              = $linha['nome'];
          $vardescricao         = $linha['descricao'];
          $varpreco             = $linha['preco'];
          $varexcluido          = $linha['excluido'];
          $vardata_exclusao     = $linha['data_exclusao'];
          $varcodigo_visual     = $linha['codigovisual'];
          $varcusto             = $linha['custo'];
          $varlucro             = $linha['margem_lucro'];
          $varIcms              = $linha['icms'];
     
          echo "<tr>
                    <td>$varId</td>
                    <td>$varNome</td>
                    <td>$vardescricao</td>
                    <td>$varpreco</td>
                    <td>$varexcluido</td>  
                    <td>$vardata_exclusao</td>
                    <td>$varcodigo_visual</td>
                    <td>$varcusto</td>
                    <td>$varlucro</td>
                    <td>$varIcms</td>
                    <td><a href='alterarprod.php?id=$varId'><img src='Icones/alterar.png' width=30></a></td>
                    <td><a href='excluiprod.php?id=$varId'><img src='Icones/lixo.png' width=30></a></td>
                </tr>";       
        }


//botao logout
    echo "
        <form action='logout.php' method='post'>
            <input class='botao' type='submit' name='L1' value='LOGOUT'>
        </form>
    ";
   
    
    
//final html
echo "
        </body>
        </html>
    ";
    
?>
