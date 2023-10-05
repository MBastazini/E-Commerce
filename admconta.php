<?php
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    session_start();        

    $conn = coneccao();

    $sql = "select * from tbl_produto order by nome";

    $select = $conn->query($sql);

    include("caixa.php");
//inicio doc html
    echo "
            <!DOCTYPE html>
            <html lang='pt-br'>
            <head>
                <title>Minha Conta</title>
            </head>
            <body>
        ";

//começo tabela
        echo "<table border='1' id='tabela'>";
        echo "<th>Id</th>
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
          $varId                = $linha['id'];
          $varNome              = $linha['nome'];
          $vardescricao         = $linha['descricao'];
          $varpreco             = $linha['preco'];
          $varexcluido          = $linha['excluido'];
          $vardata_exclusao     = $linha['data_exclusao'];
          $varcodigo_visual     = $linha['codigo_visual'];
          $varcusto             = $linha['custo'];
          $varlucro             = $linha['lucro'];
          $varIcms              = $linha['icms'];
     
          echo "<tr>"; 
          echo "<td>$varId</td>
                <td>$varNome</td>
                <td>$vardescricao</td>
                <td>$varpreco</td>
                <td>$varexcluido</td>  
                <td>$vardata_exclusao</td>
                <td>$varcodigo_visual</td>
                <td>$varcusto</td>
                <td>$varlucro</td>
                <td>$varIcms</td>
                <td><a href='alterarprod.php?id=$varId'><img src='' width=30></a></td>
                <td><a href='excluiprod.php?id=$varId'><img src='' width=30></a></td>";                                            
          echo "</tr>";       
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
