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
    $excluido = null;
    $cod_produto = null;

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
        $excluido = $_POST['excluido'];
        $cod_produto = $_POST['cod_produto'];
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

            <form action='../PHP/insereDadosProduto.php' method='post'>
                <input type='hidden' name='funcao' value='cadastro'>
                <div class="inp">
                    <?php 
                     echo "<input type='text' name='nome_produto' maxlength='80' value=".$nome_produto.">";
                    ?>
                    <p>Nome do produto</p>
                </div>
                <div class="inp">
                    <?php 
                        echo "<input type='number' name='preco' maxlength='100' value=".$preco.">";
                    ?>
                    <p>Preço</p>
                </div>
                <div class="inp">
                    <?php 
                        echo "<input type='number' name='quantidade' maxlength='100' value=".$quantidade.">";
                    ?>
                    <p>Quantidade em estoque</p>
                </div>
                <div class="inp">
                    <?php 
                        echo "<input type='text' name='descricao' maxlength='100' value=".$descricao.">";
                    ?>
                    <p>Descrição</p>
                </div>
                <div class="inp">
                    <?php 
                        echo "<input type='number' name='custo' maxlength='100' value=".$custo.">";
                    ?>
                    <p>Custo</p>
                </div>
                <div class="inp">
                    <?php 
                        echo "<input type='text' name='categoria' maxlength='100' value=".$categoria.">";
                    ?>
                    <p>Categoria</p>
                </div>
                <div class="inp">
                    <?php 
                        echo "<input type='number' name='icms' maxlength='100' value=".$icms.">";
                    ?>
                    <p>ICMS</p>
                </div>
                <div class="inp">
                    <?php 
                        echo "<input type='radio' name='excluido' value='1' " . ($excluido ? "checked" : "") . "> Sim";
                        echo "<input type='radio' name='excluido' value='0' " . (!$excluido ? "checked" : "") . "> Não";
                    ?>
                    <p>Excluido</p>
                </div>

                <input type='hidden' name='cod_produto' value=<?php echo $cod_produto; ?>>
                <input type='hidden' name='funcao' value=<?php echo $funcao; ?>>
                <div class="btn">
                    <input type="submit" value="
                    <?php 
                    if ($funcao == 'add')
                    {
                        echo "ADICIONAR";
                    }
                    else if ($funcao == 'edit')
                    {
                        echo "ALTERAR";
                    }
                    ?>
                    ">
                </div>
            </form>
            <div class="btn">
                <a href='crudProdutos.php'>
                    VOLTAR
                </a>
            </div>
        </div>
    </section>
    <?php 
        Footer('../', '#topo');
    ?>
</body>
</html>