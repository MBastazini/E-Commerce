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

    
<div id="crud" class="container img">
        <form action="#" method="post" id="add_img">
            <button type="submit">
                <img src="../Icones/add.svg">
                Adicionar Imagem</button>
        </form>

        <?php 
        
        $imagens = tblImagem();
        foreach($imagens as $imagem)
        {
            $nome = $imagem->getNomeImg();
            $caminho_img = $imagem->getImagem();
            echo"
            <div class='elemento_img'>
                <div>
                    <h1>$nome</h1>
                    <div class='acoes'>
                        <form action='#' method='post'>
                            <button type='submit' name='excluir' value='1' id='del'>
                                <img src='../Icones/delete.svg'>
                                Excluir</button>
                        </form>
                    </div>
                </div>
                <img src='../$caminho_img'>
            </div>
            ";
        }

        ?>
        <div class="elemento_img">
            <div>
                <h1>CARRARO</h1>
                <div class="acoes">
                    <form action="#" method="post">
                        <button type="submit" name="excluir" value="1" id="del">
                            <img src="../Icones/delete.svg">
                            Excluir</button>
                    </form>
                </div>
            </div>
            <img src="../Imagens/Produtos/2.jpg">
            
            
            

        </div>

        <div class="elemento_img">
            <div>
                <h1>CARRARO</h1>
                <div class="acoes">
                    <form action="#" method="post">
                        <button type="submit" name="excluir" value="1" id="del">
                            <img src="../Icones/delete.svg">
                            Excluir</button>
                    </form>
                </div>
            </div>
            <img src="../Imagens/Produtos/2.jpg">
            
            
            

        </div>

        <div class="elemento_img">
            <div>
                <h1>CARRARO</h1>
                <div class="acoes">
                    <form action="#" method="post">
                        <button type="submit" name="excluir" value="1" id="del">
                            <img src="../Icones/delete.svg">
                            Excluir</button>
                    </form>
                </div>
            </div>
            <img src="../Imagens/Produtos/2.jpg">
            
            
            

        </div>
    </div>

    <?php 
        Footer('../', '#conta');
    ?>
</body>
</html>