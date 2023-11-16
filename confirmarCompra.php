<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("PHP/caixa.php");

    $tipo = 1;
    $valor_total = 0;
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (isset($_POST['tipo']))
        {
            $tipo = $_POST['tipo'];
            $cod_produto = $_POST['cod_produto'];
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="icon" type="image/x-icon" href="Icones/logo-bola-verde.svg">
    <title>Tiny Wood</title>
</head>
<body>
    <script src="../JS/compras.js" defer></script>
    <?php 
        barraNavegacao('', '');
    ?>
    <section id="confirmar_compra" class="container">
        <h1>Confirme seu pedido</h1>
        <div>
            <div id="info_c_h">
                <p></p>
                <p>Código</p>
                <p>Status</p>
                <p>Data efetuada</p>
                <p>Valor total</p>
            </div>
            <div id="info_compra">
            
                <div class="compra enabled">
                    <p></p>
                    <?php 
                    $user = CheckUser();
                    if ($user == 1)
                    {
                        if ($tipo == 2)
                        {
                            $produto = tblProduto($cod_produto);
                            if (isset($produto))
                            {
                                $nome = $produto[0]->getNome();
                                $preco = $produto[0]->getPreco();
                                $valor_total = $preco; 

                                $data_hoje = date('d/m/Y');
                                echo "<p> - </p>";
                                echo "<p>Pendente</p>";
                                echo "<p>$data_hoje</p>";
                                echo "<p>$preco</p>";
                            }
                            else{
                                echo "ERRO";
                            }
                        }
                        else{
                            $compra = tblCompra(1);

                                $cod_compra = $compra[0]->getCodCompra();
                                $status = $compra[0]->getStatus();
                                $valor_total = $compra[0]->getValorTotal();

                                echo "<p>$cod_compra</p>";
                                echo "<p>$status</p>";
                                echo "<p> - Não efetuda - </p>";
                                echo "<p>$valor_total</p>";

                            
                        }
                        
                    
                    }
                    ?>
                    <div>
                        <div id="info_c_h" class="inside">
                            <p>Nome</p>
                            <p>Preco</p>
                            <p>Quantidade</p>
                            <p>Codigo</p>
                        </div>
                        <div id="info_compra" class="inside">
                            <?php 
                            
                            if ($user == 1)
                            {
                                if ($tipo == 2)
                                {
                                    echo "<div>";
                                    echo "<p>$nome</p>";
                                    echo "<p>$preco</p>";
                                    echo "<p>1</p>";
                                    echo "<p>$cod_produto</p>";
                                    echo "</div>";
                                }   
                                else{
                                    
                                    $produtos = $compra[0]->getCompras();
                                    if (isset($produtos)){
                                        foreach($produtos as $produto)
                                        {
                                            $nome = $produto->getNome();
                                            $preco = $produto->getPreco();
                                            $quantidade = $produto->getQuantidade();
                                            $cod_produto = $produto->getCodProduto();

                                            echo "<div>";
                                            echo "<p>$nome</p>";
                                            echo "<p>$preco</p>";
                                            echo "<p>$quantidade</p>";
                                            echo "<p>$cod_produto</p>";
                                            echo "</div>";
                                        }
                                    }
                                    else{
                                        echo "ERRO";
                                        header("Location: ./");
                                    }
                                    
                                }
                            }
                            
                            
                            
                            ?>
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
        
        <?php 
        
        if ($user == 1)
        {
            echo "<h2>Total: $valor_total </h2>";
        }   

        ?>
        
        <p>Um relariorio será gerado com as informações da compra.</p>
        <div id="botoes">
            
        <?php 
        if ($user == 1)
        {
            if ($tipo == 2)
            {
                $funcao = 'comprar';
            }
            else{
                $funcao = 'finalizar';
                $cod_produto = 0;
            }
            echo "<form action='./PHP/insereDadosCarrinho.php' method='post'>
                <input type='hidden' name='funcao' value='$funcao'>
                <input type='hidden' name='cod_produto' value='". $cod_produto ."'>
                <button class='finalizar_compra'><h1>FINALIZAR COMPRA</h1></button>
            </form>";
        }
        else{
            echo "Faça o login para finalizar a compra";
        }
            
        ?>
            <a href='./'>Voltar</a>
        </div>
        
    </section>

    <?php 
        Footer('', '#confirmar_compra');
    ?>
</body>
</html>