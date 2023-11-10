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
    <!-- Diminuir a qualidade da logo-bola-verde (demora muito pra carregar) -->
    
    <title>Carrinho - Tiny Wood</title>
</head>
<body>
    <script src="../JS/index.js" defer></script>
    <script src="../JS/carrinho.js" defer></script>
    <?php 
        barraNavegacao('carrinho', '../');
    ?>

    <section id="grid_carrinho" class="container">
        <div id="produtos_compra">
            <?php 
                $carrinho = tblCarrinho();
                if ($carrinho)
                {
                    foreach($carrinho as $c) {
                        $cod_produto = $c->getCodProduto();
                        $nome = $c->getNome();
                        $quantidade = $c->getQuantidade();

                        $estoque = tblProduto($cod_produto)[0] -> getEstoque();

                        $valido = true;
                        if ($quantidade > $estoque)
                        {
                            $valido = false;
                        }

                        $preco = $c->getPreco();
                        $imagem = $c->getImagem();
                        $preco_total = $preco * $quantidade;

                        if ($valido)
                        {
                            echo"
                                <div class='produto_compra' id='produto_$cod_produto'>
                                    <img src='../$imagem' alt='Chaveiro img'>
                                    <div>
                                        <p>$nome</p>
                                        <div class='produto_compra_div'>
                                            <form action='../PHP/insereDadosCarrinho.php' method='post'>
                                                <input type='hidden' name='cod_produto' value='$cod_produto'>
                                                <input type='hidden' value='muda-' name='funcao'>
                                                <input type='submit' value='-'>
                                            </form>
                                            <p id='quantidade'>$quantidade</p>
                                            <form action='../PHP/insereDadosCarrinho.php' method='post'>
                                                <input type='hidden' name='cod_produto' value='$cod_produto'>
                                                <input type='hidden' value='muda+' name='funcao'>
                                                <input type='submit' value='+'>
                                            </form>
                                        </div>
                                        <h1>R$ ".$preco_total."</h1>
                                    </div>
                                </div>";   
                        }
                        else{
                            echo"
                                <div class='produto_compra esgotado' id='produto_$cod_produto'>
                                    <p>Não há estoque</p>
                                    <img src='../$imagem' alt='Chaveiro img'>
                                    <div>
                                        <p>$nome</p>
                                        <div class='produto_compra_div'>
                                            <form action='../PHP/insereDadosCarrinho.php' method='post'>
                                                <input type='hidden' name='cod_produto' value='$cod_produto'>
                                                <input type='hidden' value='muda-' name='funcao'>
                                                <input type='submit' value='-'>
                                            </form>
                                            <p id='quantidade'>$quantidade</p>
                                            <form action='#' method='post'>
                                                <input type='hidden' name='cod_produto' value='$cod_produto'>
                                                <input type='hidden' value='muda+' name='funcao'>
                                                <input type='submit' value='+'>
                                            </form>
                                        </div>
                                        <h1>R$ ".$preco_total."</h1>
                                    </div>
                                </div>";   
                        }
                        
                    }   
                }
                else{
                    echo "Não há produtos no carrinho";
                
                }
            ?>
            <!-- Na cração disso com PHP atente-se em colocar o uma STRING concatenada como 'produto_' + $id_produto
            Algo assim, ai o id_produto fica armasenado, mas não temos classes com o nome dela sendo apenas um numero solto -->
            <!--<div class="produto_compra"  id="Produto1">
                <img src="../Icones/quadrado.svg" alt="Chaveiro 1">
                <div>
                    <p>Nome-Produto</p>
                    <div class="produto_compra_div">
                        <p id="quantidade">2</p>
                    </div>
                    <h1>R$ 30,00</h1>
                </div>
            </div>
            
            <div class="produto_compra">
                <img src="../Icones/quadrado.svg" alt="Chaveiro 1">
                <div>
                    <p>Nome-Produto</p>
                    <div class="produto_compra_div">
                        <p id="quantidade">2</p>
                    </div>
                    <h1>R$ 30,00</h1>
                </div>
            </div>-->
        </div>
        <div id="compra_total">
            <h1>CARRINHO</h1>
            <div>
                <div id="compras_efetuadas">
                    <div class="compra_cabecalho">
                        <h1>Quantidade</h1>
                        <h1>Produto</h1>
                        <h1>Preço</h1>
                    </div>
                    
                    <?php 
                    $carrinho = tblCarrinho();
                    if ($carrinho)
                    {
                        foreach($carrinho as $c) {
                            $cod_produto = $c->getCodProduto();
                            $nome = $c->getNome();
                            $quantidade = $c->getQuantidade();
                            $preco = $c->getPreco();
                            $preco_total = $preco * $quantidade;
                            echo"
                                <a class='compra_efetuada' href='#produto_$cod_produto'>
                                <p>". $quantidade."x</p>
                                <p>$nome</p>
                                <h1>R$ ".$preco_total."</h1>
                                </a>        
                            ";   
                        } 
                    }
                    else{
                        echo "Não há produtos no carrinho";
                    }
                     
                    ?>
                </div>
                <div class="compras_total">
                    <p>TOTAL</p>
                    <h1 id="total">R$ 
                        <?php 
                        $soma = getValorTotal();
                        echo $soma;
                        ?>
                    </h1>
                </div>
                <?php 
                    
                    $valido = carrinhoValido();
                    if ($valido)
                    {
                        echo"<form action='../confirmarCompra.php' method='post'>
                        <button class='finalizar_compra'><h1>FINALIZAR COMPRA</h1></button>
                        </form>";
                    }
                    else{
                        echo"<form action='./#carrinho-nao-valido' method='post'>
                            <button class='finalizar_compra'><h1>FINALIZAR COMPRA</h1></button>
                        </form>";
                    }
                    
                    ?>
                
            </div>  
        </div>
    </section>


    <?php 
        Footer('../', '#grid_carrinho');
    ?>


    <!---<footer>
        <div class="tela_scroll_down up">
            <a href="#grid_carrinho" class="a"> 
                <h1>Voltar ao topo</h1> 
                <img src="../Icones/arrow.svg">
            </a>
        </div>

        <div id="f_1"></div>
        <div id="f_2"></div>
        <div id="f_3"></div>
        <div id="f_4"></div>
        <div id="f_5"></div>

        <div class="footer_logo">
            <img src="../Icones/logo-bola-branco.svg" alt="Logo da Tiny Wood">
            <div class="footer_logo_info">
                <h1>TINY WOOD</h1>
                <p>Alguimas informaçoes pq eu vi num lugar e 
                    vou colocar
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vo
                luptate quidem distinctio rerum assumenda quae aut, dicta c</p>
                <div class="footer_logo_info_mais">
                    <div class="footer_logo_info_mais_botao" value="1"></div>
                    <div class="footer_logo_info_mais_botao" value="2"></div>
                    <div class="footer_logo_info_mais_botao" value="3"></div>

                </div>
            </div>
        </div>

        <div class="copyright">
            <p>All copyrights to &copy; TinyWood</p>
        </div>
        <div class="footer_info">
            <div class="footer_div">
                <h1>Desenvolvedores</h1>
                <a href="sobre.html#leticia"><p>Leticia Garcia | N° 21</p></a>
                <a href="sobre.html#luiz"><p>Luiz Felipe | N° 22</p></a>
                <a href="sobre.html#mariana"><p>Mariana Senger | N° 23</p></a>
                <a href="sobre.html#mateus"><p>Mateus Bastazini | N° 24</p></a>
                <a href="sobre.html#matheus"><p>Matheus Trentini | N° 25</p></a>
            </div>
            <div class="footer_div">
                <h1>Contato</h1>
                <a><p>E-mail</p></a>
                <a><p>Telefone</p></a>
                <a><p>sla1</p></a>
                <a><p>sla2</p></a>
            </div>
            <div class="footer_div">
                <h1>Contato</h1>
                <a><p>E-mail</p></a>
                <a><p>Telefone</p></a>
                <a><p>sla1</p></a>
                <a><p>sla2</p></a>
            </div>
        </div>
    </footer> -->
</body>
</html>