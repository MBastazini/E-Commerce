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
    <script src="../JS/aparece_img.js" defer></script>

    <?php 
        barraNavegacao('', '../');
    ?>

    
<div id="crud" class="container img">
        <div class="add_img">
            <form action="../PHP/insereDadosProduto.php" method="post" enctype="multipart/form-data" id='form_img' class="add_img">
                <input type='hidden' name='funcao' value='add_img'>
                <a id="btn_crud_produtos" href="crudProdutos.php">CRUD Produtos</a>
                <div>
                    <p>Selecione uma imagem para adicionar (.JPG):</p>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <p style="font-size: small;">(O nome da imagem será o nome do arquivo)</p>
                </div>
                
                <button type="submit">
                        <img src="../Icones/add.svg">
                        Adicionar Imagem
                </button>   
                <p id='aviso_crud_img'>Atenção: o website não possui permissão para deletar arquivos do servidor.
                    É sim possivel adicionar automaticamente imagens clicando no botão acima, porem para deleta-las e necessario
                    clicar no botão 'Excluir' e deletar manualmente o arquivo no servidor.
                </p>
                <div>
                    <p>Preview da imagem:</p>
                    <img src="#" alt='Nenhuma imagem selecionada'>
                </div>
            </form>
            
        </div>
        <?php 
        
        $imagens = tblImagem();
        foreach($imagens as $imagem)
        {
            $cod_imagem = $imagem->getCodImagem();
            $nome = $imagem->getNomeImg();
            $caminho_img = $imagem->getImagem();
            echo"
            <div class='elemento_img'>
                <div>
                    <h1>$nome</h1>
                    <div class='acoes'>
                        <form action='../PHP/insereDadosProduto.php' method='post'>
                            <input type='hidden' name='cod_imagem' value='$cod_imagem'>
                            <input type='hidden' name='funcao' value='del_img'>
                            <button type='submit' name='excluir' value='1' id='del'>
                                <img src='../Icones/delete.svg'>
                                Excluir</button>
                        </form>
                    </div>
                </div>
                <img src='../$caminho_img' alt='IMAGEM NÃO ENCONTRADA NO SERVIDOR. FAVOR DELETAR'>
            </div>
            ";
        }

        ?>
    </div>

    <?php 
        Footer('../', '#conta');
    ?>
</body>
</html>