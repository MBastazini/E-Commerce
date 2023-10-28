<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("../PHP/caixa.php");
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../index.css">
    <link rel="icon" type="image/x-icon" href="../Icones/logo-bola-verde.svg">
    <title>Tiny Wood</title>
</head>
<body>
    <script src="../JS/conta.js" defer></script>
    <script src="../JS/index.js" defer></script>
    <script src="../JS/login.js" defer></script>

    <?php 
        barraNavegacao('', '../');
    ?>

    <div id="crud" class="container">
        <form action="#" method="post">
            <button type="submit">
                <img src="../Icones/add.svg">
                Adicionar produto</button>
        </form>
        <div class="elemento">
            <img src="../Imagens/Produtos/2.jpg">
            <div class="info">
                <div>
                    <p>Nome</p>
                    <h1>JOSOARES</h1>
                </div>
                
                <div>
                    <p>Preco</p>
                    <h1>10000000</h1>
                </div>
                <div>
                    <p>Quantidade em estoque</p>
                    <h1>josoarres</h1>
                </div>
                <div>
                    <p>Descricao</p>
                    <h1>josoares</h1>
                </div>
                <div>
                    <p>Custo</p>
                    <h1>joseees</h1>
                </div>
                <div>
                    <p>Codigo</p>
                    <h1>putinha</h1>
                </div>
                <div>
                    <p>Categoria</p>
                    <h1>capivara</h1>
                </div>
                <div>
                    <p>ICMS</p>
                    <h1>qporraeessaaaaaaaaaaaaaaaa</h1>
                </div>
                <div>
                    <p>Excluido</p>
                    <h1>nao</h1>
                </div>
            </div>
            
            <div class="acoes">
                <form action="#" method="post">
                    
                    <button type="submit" name="editar" value="1">
                        <img src="../Icones/edit.svg">
                        Editar</button>
                </form>
                <form action="#" method="post">
                    <button type="submit" name="excluir" value="1" id="del">
                        <img src="../Icones/delete.svg">
                        Excluir</button>
            </div>
        </div>

        <?php 
        
        $produtos = tblProduto();
        foreach($produtos as $produto)
        {
            echo '<div class="elemento">
                    <img src="../Imagens/Produtos/2.jpg">
                    <div class="info">
                        <div>
                            <p>Nome</p>
                            <h1>'.$produto->getNome().'</h1>
                        </div>
                        
                        <div>
                            <p>Preco</p>
                            <h1>'.$produto->getPreco().'</h1>
                        </div>
                        <div>
                            <p>Quantidade em estoque</p>
                            <h1>'.$produto->getQuantidade().'</h1>
                        </div>
                        <div>
                            <p>Descricao</p>
                            <h1>'.$produto->getDescricao().'</h1>
                        </div>
                        <div>
                            <p>Custo</p>
                            <h1>'.$produto->getCusto().'</h1>
                        </div>
                        <div>
                            <p>Codigo</p>
                            <h1>'.$produto->getCodProduto().'</h1>
                        </div>
                        <div>
                            <p>Categoria</p>
                            <h1>'.$produto->getCategoria().'</h1>
                        </div>
                        <div>
                            <p>ICMS</p>
                            <h1>'.$produto->getIcms().'</h1>
                        </div>
                        <div>
                            <p>Excluido</p>
                            <h1>'.$produto->getExcluido().'</h1>
                        </div>
                    </div>
                    
                <div class="acoes">
                    <form action="#" method="post">
                        
                        <button type="submit" name="editar" value="1">
                            <img src="../Icones/edit.svg">
                            Editar</button>
                    </form>
                    <form action="#" method="post">
                        <button type="submit" name="excluir" value="1" id="del">
                            <img src="../Icones/delete.svg">
                            Excluir</button>
                </div>
            </div>';
        }
        ?>

    </div>

    <?php 
        Footer('../', '#conta');
    ?>
</body>
</html>