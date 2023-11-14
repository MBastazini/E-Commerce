<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("../PHP/caixa.php");
    
    $valido = false;
    if (isset($_GET['tipo']))
    {
        $tipo = $_GET['tipo'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // "<h1>$tipo</h1>";
        $sql = '';
        if ($tipo == 'data')
        {
            if (isset($_POST['data_i']) && isset($_POST['data_f']))
            {
                $data_i = $_POST['data_i'];
                $data_f = $_POST['data_f'];
                if (!($data_i == '' || $data_f == ''))
                {
                    $sql = "SELECT * FROM tbl_compra WHERE status = 'Concluida' AND  data_compra BETWEEN '$data_i' AND '$data_f'
                    ORDER BY cod_compra";
                    $valido = true;
                }
 
            }

        }
        else if ($tipo == 'cod_u')
        {
            if (isset($_POST['cod_u_i']))
            {
                $cod_u_i = $_POST['cod_u_i'];
                //Remove todos os caracteres que não são numeros
                $cod_u_i = preg_replace("/[^0-9 ]/", '', $cod_u_i);
                if (!($cod_u_i == ''))
                {
                    $cod_u_i = explode(' ', $cod_u_i);
                    $sql = "SELECT * FROM tbl_compra WHERE status = 'Concluida' AND  cod_usuario IN (";
                    for ($i = 0; $i < count($cod_u_i); $i++)
                    {
                        if ($i == count($cod_u_i) - 1)
                        {
                            $sql .= $cod_u_i[$i] . ")";
                        }
                        else{
                            $sql .= $cod_u_i[$i] . ", ";
                        }
                    }
                    $sql .= " ORDER BY cod_compra";
                    $valido = true;
                }
            }
        }
        else if ($tipo == 'cod_c')
        {

            if (isset($_POST['cod_c_i']))
            {
                $cod_c_i = $_POST['cod_c_i'];
                //Remove todos os caracteres que não são numeros
                $cod_c_i = preg_replace("/[^0-9 ]/", '', $cod_c_i);
                if (!($cod_c_i == ''))
                {
                    $cod_c_i = explode(' ', $cod_c_i);
                    $sql = "SELECT * FROM tbl_compra WHERE status = 'Concluida' AND cod_compra IN (";
                    for ($i = 0; $i < count($cod_c_i); $i++)
                    {
                        if ($i == count($cod_c_i) - 1)
                        {
                            $sql .= $cod_c_i[$i] . ")";
                        }
                        else{
                            $sql .= $cod_c_i[$i] . ", ";
                        }
                    }
                    $sql .= " ORDER BY cod_compra";
                    $valido = true;
                }
            }
        }
        else if ($tipo == 'valor')
        {
            if (isset($_POST['valor_i']) && isset($_POST['valor_f']))
            {
                $valor_i = $_POST['valor_i'];
                $valor_f = $_POST['valor_f'];
                if (!($valor_i == '' || $valor_f == ''))
                {
                    $sql = "SELECT * FROM tbl_compra WHERE status = 'Concluida' AND  valor_total BETWEEN '$valor_i' AND '$valor_f'
                    ORDER BY cod_compra";
                    $valido = false;
                }
            }
        }   
    }

    if ($valido)
    {
        $valor_f = 3;
        $sql_f = $sql;
        $compras = tblCompra(3, $sql);
    }
    else{
        $valor_f = 2;
        $sql_f = '';
        $compras = tblCompra(2);
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
    <title>Tiny Wood</title>
</head>
<body>
    <script src="../JS/index.js" defer></script>
    <script src="../JS/relatorios.js" defer></script>
    <script src="../JS/compras.js" defer></script>

    <?php 
        barraNavegacao('', '../');
    ?>

    <section id="relatorios" class="container">
        <form action="" method='post'>
            
            <div id="opcoes">
            
                <div class="filtro">
                    <h1>Filtrar por:</h1>
                    <div>
                        <p class="enabled">Todos</p>
                        <p name="data">Data da compra</p>
                        <p name="cod_u">Codigo de usuario</p>
                        <p name="cod_c">Codigo da compra</p>
                        <!---<p name="valor">Valor da compra</p>-->
                    </div>
                </div>
                <div name="data" class="hidden">
                    <h2>Data da compra</h2>
                    <div>
                            <p>Data inicial:</p>
                            <input type="date" name="data_i">
                            <p>Data final:</p>
                            <input type="date" name="data_f">
                    </div>
                </div>
                <div name="cod_u" class="hidden">
                    <h2>Codigo de usuario</h2>
                    <p>(Para mais de um codigoo de usuario, digite os numeros separados por um espaço apenas. Ex: 10 15 20 1)</p>
                    <div>
                            <input type="text" name="cod_u_i">
                    </div>
                </div>
                <div name="cod_c" class="hidden">
                    <h2>Codigo da compra</h2>
                    <p>(Para mais de um codigoo de compra, digite os numeros separados por um espaço apenas. Ex: 10 15 20 1)</p>
                    <div>
                            <input type="text" name="cod_c_i">
                    </div>
                </div>
                <!---<div name="valor" class="hidden">
                    <h2>Valor da compra</h2>
                    <div>
                            <p>Valor minimo:</p>
                            <input type="number" name="valor_i">
                            <p>Valor maximo:</p>
                            <input type="number" name="valor_f">
                    </div>
                </div>-->

                <input type='hidden' name='funcao' value='relatorio'>
                <div class="submit">
                    <button type="submit">Carregar dados</button>
                </div>

                <a id="btn_crud_produtos" class="cruds" href="./">Voltar</a>
            </form>
            <form action="../PHP/caixa.php" method="post">
                <input type="hidden" name="funcao" value="relatorio">
                <input type="hidden" name="sql_f" value="<?php echo $sql_f; ?>">
                <input type="hidden" name="valor_f" value="<?php echo $valor_f; ?>">
                
                <div class="submit">
                    <button type="submit">Gerar PDF</button>
                </div>
            </form>
            
                

            </div>

            <div id="info_c_h">
                <p>Mais</p>
                <p>Código</p>
                <p>Usuario</p>
                <p>Data efetuada</p>
                <p>Valor total</p>
            </div>
            <div id="info_compra">
                <?php 
                
                if (isset($compras))
                {
                    foreach ($compras as $compra)
                    {
                        $cod_compra = $compra -> getCodCompra();
                        $cod_usuario = $compra -> getCodUsuario();
                    $nome_usuario = tblUsuario(5, $cod_usuario)[0] -> getNome();
                        $data_compra = $compra -> getDataCompra();
                        $valor_total = $compra -> getValorTotal();
                        echo "
                        <div class='compra'>
                            <img src='../Icones/Down_preto.svg'>
                            <p>". $cod_compra ."</p>
                            <p>". $nome_usuario ."</p>
                            <p>". $data_compra ."</p>
                            <p>R$ ". $valor_total ."</p>
                            <div>
                                <div id='info_c_h' class='inside'>
                                    <p>Nome</p>
                                    <p>Preco</p>
                                    <p>Quantidade</p>
                                    <p>Codigo</p>
                                </div>
                                <div id='info_compra' class='inside'>";
                                    $produtos = $compra->getCompras();
                                    foreach($produtos as $produto)
                                    {
                                        $nome = $produto -> getNome();
                                        $preco = $produto -> getPreco();
                                        $quantidade = $produto -> getQuantidade();
                                        $cod_produto = $produto -> getCodProduto();
                                        echo" 
                                        <div>
                                            <p>". $nome ."</p>
                                            <p>". $preco ."</p>
                                            <p>". $quantidade ."</p>
                                            <p>". $cod_produto ."</p>
                                        </div>";
                                    }
                                    echo"
                                </div>
                            </div>
                        </div>";   
                    }
                }
                
                ?>
            </div>
    </section>


    <?php 
        Footer('../', 'conta');
    ?>
    </body>
</html>