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
    <script src="../JS/crudProdutos.js" defer></script>

    <?php 
        barraNavegacao('', '../');
    ?>

    <div id="crud" class="container">

        <?php 
        
        $user = CheckUser();
        if ($user == 1)
        {
            if ($_SESSION['usuario']['adm'])
            {
                echo '<form action="formProdutos.php" method="post">
                <input type="hidden" name="funcao" value="add">
                <button type="submit">
                    <img src="../Icones/add.svg">
                    Adicionar produto</button>
            </form>';
                $produtos = tblProduto();
                foreach($produtos as $produto)
                {
                    if ($produto->getExcluido() == 1)
                    {
                        $excluido = "Sim";
                        $exclido_id = 'res';
                        $excluido_frase = 'Restaurar';
                        $excluido_img = '../Icones/restore.svg';
                        $funcao = 'res';
                    }
                    else{
                        $excluido = "Não";
                        $exclido_id = 'del';
                        $excluido_frase = 'Excluir';
                        $excluido_img = '../Icones/delete.svg';
                        $funcao = 'del';
                    }

                    if (null !== $produto->getCategoria())
                    {
                        $categoria = $produto->getCategoria();
                    }
                    else{
                        $categoria = "Nenhuma";
                    }
                    echo '<div class="elemento" id="';
                    if ($produto->getExcluido() == 1)
                    {
                        echo"excluido";
                    }
                    else{
                        echo"";
                    }
                    echo'">
                            <img src="../Imagens/Produtos/'.$produto->getCodProduto().'.jpg">
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
                                    <h1>'.$categoria.'</h1>
                                </div>
                                <div>
                                    <p>ICMS</p>
                                    <h1>'.$produto->getIcms().'</h1>
                                </div>
                                <div>
                                    <p>Excluido</p>
                                    <h1>'.$excluido.'</h1>
                                </div>
                                <div>
                                    <p>Margin lucro</p>
                                    <h1>'.$produto->getMarginLucro().'</h1>
                                </div>
                            </div>
                            
                        <div class="acoes">
                            <form></form>
                            <form action="formProdutos.php" method="post">

                                <input type="hidden" name="cod_produto" value="'.$produto->getCodProduto().'">
                                <input type="hidden" name="nome_produto" value="'.$produto->getNome().'">    
                                <input type="hidden" name="preco" value="'.$produto->getPreco().'">
                                <input type="hidden" name="quantidade" value="'.$produto->getQuantidade().'">
                                <input type="hidden" name="descricao" value="'.$produto->getDescricao().'">
                                <input type="hidden" name="custo" value="'.$produto->getCusto().'">
                                <input type="hidden" name="categoria" value="'.$produto->getCategoria().'">
                                <input type="hidden" name="icms" value="'.$produto->getIcms().'">
                                <input type="hidden" name="excluido" value="'.$produto->getExcluido().'">
                                <input type="hidden" name="margin_lucro" value="'.$produto->getMarginLucro().'">

                                <input type="hidden" name="funcao" value="edit">
                                
                                <button type="submit" name="editar" value="1">
                                    <img src="../Icones/edit.svg">
                                    Editar
                                </button>

                            </form>

                            <form action="../PHP/insereDadosProduto.php" method="post">

                                <input type="hidden" name="cod_produto" value="'.$produto->getCodProduto().'">
                                <input type="hidden" name="funcao" value="'. $funcao .'">
                                <button type="submit" name="excluir" value="1" id="'.$exclido_id.'">
                                    <img src="'. $excluido_img .'">
                                    '.$excluido_frase.'
                                </button>

                            </form>
                        </div>
                    </div>';
                }
            }
        }
        else{
            echo "<h1>Você não tem permissão para acessar essa página!</h1>";
        }
        ?>

    </div>

    <?php 
        Footer('../', '#conta');
    ?>
</body>
</html>