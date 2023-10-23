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
    <!--<div class="nav_nav container">
        <div class="nav_fundo"></div>
        <a href="index.html"><img src="../Icones/logo-verde.svg" class="nav_logo" alt="Logo TINYWOOD"></a>


        <div class="nav_div_pesquisa">
                <div class="nav_pesquisa">
                    <img src="../Icones/pesquisa_cinza.svg" class="nav_icon">
                    <input type="text" placeholder="Pesquisar...">
                </div>

                <div class="nav_p_resultados">
                    <a href="produtos.html#1">
                        <div>
                            <p>Chaveiro Engines</p>
                        </div>
                    </a>
                    <a href="produtos.html#2">
                        <div>
                            <p>Chaveiro Lampada</p>
                        </div>
                    </a>
                    <a href="produtos.html#3">
                        <div>
                            <p>Chaveiro CPU</p>
                        </div>
                    </a>
                    <a href="produtos.html#4">
                        <div>
                            <p>Chaveiro CTI</p>
                        </div>
                    </a>
                </div>
        </div>
        
        <img src="../Icones/menu-hamburguer.svg" class="nav_tres_risco" alt="Mais opções">
        <div class="nav_elementos">
            <div class="nav_risco"></div>
            <a href="index.html">
                <div class="nav_home">
                    <img class="nav_icon" src="../Icones/home_preto.svg">
                    <p>HOME</p>
                </div>
            </a>
            
            <a href="produtos.html">
                <div class="nav_produtos">
                    <img class="nav_icon" src="../Icones/shopping_preto.svg">
                    <p>PRODUTOS</p>
                </div>
            </a>
            
            <a href="sobre.html">
                <div class="nav_sobre">
                    <img class="nav_icon" src="../Icones/sobre_preto.svg">
                    <p>SOBRE</p>
                </div>
            </a>
            
            <div class="nav_info_lateral" id="nav_botao_ativo">
                <img class="nav_icon2" src="../Icones/carrinho_branco.svg">
                <p>CARRINHO</p>
            </div>

            <a href="login.html">
                <div class="nav_info_lateral" >
                    <img class="nav_icon2" src="../Icones/login_preto.svg">
                    <p>LOGIN</p>
                </div>
            </a>
        </div>
        
    </div>-->

    <?php 
        barraNavegacao('carrinho', '../');
    ?>

    <section id="grid_carrinho" class="container">
        <div id="produtos_compra">
            <?php 
                $carrinho = tblCarrinho();
                foreach($carrinho as $c) {
                    $cod_produto = $c->getCodProduto();
                    $cod_tmpcompra = $c->getCodTmpCompra();
                    $nome = $c->getNome();
                    $quantidade = $c->getQuantidade();
                    $preco = $c->getPreco();
                    $preco_total = $preco * $quantidade;
                    echo"
                            <div class='produto_compra' id='produto_$cod_produto'>
                                <img src='../Imagens/Produtos/$cod_produto.jpg' alt='Chaveiro img'>
                                <div>
                                    <p>$nome</p>
                                    <div class='produto_compra_div'>
                                        <form action='../PHP/insereDadosCarrinho.php' method='post'>
                                            <input type='hidden' name='cod_tmpcompra' value='$cod_tmpcompra'>
                                            <input type='hidden' value='muda-' name='funcao'>
                                            <input type='submit' value='-'>
                                        </form>
                                        <p id='quantidade'>$quantidade</p>
                                        <form action='../PHP/insereDadosCarrinho.php' method='post'>
                                            <input type='hidden' name='cod_tmpcompra' value='$cod_tmpcompra'>
                                            <input type='hidden' value='muda+' name='funcao'>
                                            <input type='submit' value='+'>
                                        </form>
                                    </div>
                                    <h1>R$ ".$preco_total."</h1>
                                </div>
                            </div>";   
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
                    
                </div>
                <div class="compras_total">
                    <p>TOTAL</p>
                    <h1 id="total">R$ 0,00</h1>
                </div>
                <form action='../PHP/insereDadosCarrinho.php' method='post'>
                    <input type='hidden' name='funcao' value='finalizar'>
                    <button class="finalizar_compra"><h1>FINALIZAR COMPRA</h1></button>
                </form>
            </div>  
        </div>
    </section>
    

    <?php 
        Footer('../', '#grid_carrinho');
    ?>


    <!--<footer>
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