<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("../PHP/caixa.php");

    $nome_produto = null;
    $preco = null;
    $quantidade = null;
    $descricao = null;
    $custo = null;
    $categoria = null;
    $icms = null;
    $excluido = false;
    $cod_produto = null;
    $imagem = '#';
    $funcao = $_POST['funcao'];
    if ($funcao == 'edit')
    {
        $nome_produto = $_POST['nome_produto'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];
        $descricao = $_POST['descricao'];
        $custo = $_POST['custo'];
        $categoria = $_POST['categoria'];
        $icms = $_POST['icms'];
        $excluido = isset($_POST['excluido']) && $_POST['excluido'] == 1;
        $cod_produto = $_POST['cod_produto'];
        $imagem_atual = $_POST['imagem'];
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../index.css">
    <link rel="icon" type="image/x-icon" href="../Icones/logo-bola-verde.svg">

    <title>Cadastro - Tiny Wood</title>
</head>
<body>
    <script src="../JS/index.js" defer></script>
    <script src="../JS/login.js" defer></script>
    <script src="../JS/formProdutos.js" defer></script>
    <?php 
        barraNavegacao('', '../');
    ?>

    <section class="container sec_login" id="topo">
        <div class="cadastro tela_log_cad">
            <h1>
                <?php 
                    if ($funcao == 'add')
                    {
                        echo "Adicionar produto";
                    }
                    else if ($funcao == 'muda')
                    {
                        echo "Alterar o produto '$nome_produto'";
                    }             
                ?>
            </h1>
            <?php 
            ?>

            <form action='../PHP/insereDadosProduto.php' method='post' enctype="multipart/form-data">
                <input type='hidden' name='funcao' value='add'>
                <div class="inp">
                    <?php 
                     echo "<input type='text' required name='nome_produto' maxlength='80' value='".$nome_produto."'>";
                    ?>
                    <p>Nome do produto</p>
                </div>
                <div class="inp">
                    <?php 
                        echo "<input type='number' required name='preco' maxlength='100' value='".$preco."' step='0.01' min='0.01'>";
                    ?>
                    <p>Preço</p>
                </div>
                <div class="inp">
                    <?php 
                        echo "<input type='number' required name='quantidade' maxlength='100' value='".$quantidade."' min='0'>";
                    ?>
                    <p>Quant. em estoque</p>
                </div>
                <div class="inp">
                    <?php 
                        echo "<input type='text' required name='descricao' maxlength='100' value='".$descricao."'>";
                    ?>
                    <p>Descrição</p>
                </div>
                <div class="inp">
                    <?php 
                        echo "<input type='number' required name='custo' maxlength='100' value='".$custo."' step='0.01' min='0.01'>";
                    ?>
                    <p>Custo</p>
                </div>
                <div class="inp">
                    <?php 
                        echo '<select name="categoria">
                        <option value="NONE">- Nenhuma -</option>
                        <option value="Informática">Informática</option>
                        <option value="Mecânica">Mecânica</option>
                        <option value="Eletrônica">Eletrônica</option>
                        <option value="CTI">CTI</option>

                    </select>';
                    ?>
                    <p>Categoria</p>
                </div>
                <div class="inp">
                    <?php 
                        echo "<input type='number' required name='icms' maxlength='100' value='".$icms."' min='1'>";
                    ?>
                    <p>ICMS</p>
                </div>
                <div class="inp excluido">
                    <?php 
                        echo "<div> <input type='radio' required name='excluido' value='1' " . ($excluido ? "checked" : "") . "> Sim </div>";
                        echo "<div> <input type='radio' required name='excluido' value='0' " . (!$excluido ? "checked" : "") . "> Não </div>";
                    ?>
                    <p>Excluido</p>
                </div>
                <div class="inp file">
                    <select name="imagens">
                        <?php 
                        
                        $imagens = tblImagem();
                        foreach($imagens as $imagem)
                        {
                            $cod_imagem = $imagem->getCodImagem();
                            $nome = $imagem->getNomeImg();
                            $caminho_img = $imagem->getImagem();
                            $sel = '';
                            $imagem_C = $imagem->getImagem();
                            if ($imagem_C == $imagem_atual)
                            {
                                
                                echo "<option value='$cod_imagem' name='$caminho_img' selected>$nome</option>";
                            }
                            else{
                                echo "<option value='$cod_imagem' name='$caminho_img'>$nome</option>";
                            }
                            
                        }

                        ?>
                    </select>
                    <p>Imagem</p>
                    <a href='crudImagens.php' target="_blank">Adicionar nova</a>
                </div>
                <div id="crud_produto_img">
                    <img src='#'>
                </div>
                <input type='hidden' name='cod_produto' value=<?php echo $cod_produto; ?>>
                <input type='hidden' name='funcao' value=<?php echo $funcao; ?>>
                <div class="btn">
                    <input type="submit" value="<?php 
                    if ($funcao == 'add')
                    {
                        echo "ADICIONAR";
                    }
                    else if ($funcao == 'edit')
                    {
                        echo "ALTERAR";
                    }
                    ?>" name="submit">
                </div>
            </form>
            <div class="crud_voltar">
                <a href='crudProdutos.php'> VOLTAR </a>
            </div>
        </div>
    </section>
    <?php 
        Footer('../', '#topo');
    ?>
</body>
</html>