<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    include("../PHP/caixa.php");

    $produtos = tblProduto();    
?>





<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../index.css">
    <link rel="icon" type="image/x-icon" href="../Icones/logo-bola-verde.svg">
    
    <title>Produtos - Tiny Wood</title>
</head>
<body class="over_hid">
    <script src="../JS/produtos.js" defer></script>
    <script src="../JS/index.js" defer></script>

    <!--<div class="nav_nav container">
        <div class="nav_fundo nf_fixo"></div>
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
            <div class="nav_produtos"  id="nav_botao_ativo">
                <img class="nav_icon" src="../Icones/shopping_branco.svg">
                <p>PRODUTOS</p>
            </div>
            <a href="sobre.html">
                <div class="nav_sobre">
                    <img class="nav_icon" src="../Icones/sobre_preto.svg">
                    <p>SOBRE</p>
                </div>
            </a>

            <a href="carrinho.html">
                <div class="nav_info_lateral">
                    <img class="nav_icon2" src="../Icones/carrinho_preto.svg">
                    <p>CARRINHO</p>
                </div>
            </a>
            
            <a href="../PHP/usuario.php">
                <div class="nav_info_lateral">
                    <img class="nav_icon2" src="../Icones/login_preto.svg">
                    <p>LOGIN</p>
                </div>
            </a>
        </div>
        
    </div> -->

    <?php 
        barraNavegacao('produtos', '../');
    ?>


    <section id="produtos" class="container">
        <div id="filtro">
            <h1  onclick="abreFiltro()">FILTROS
                <img src="../Icones/Down.svg">
            </h1>
            
            <div>  
                <h1>ATIVOS</h1>
                <div id="ativos">
                    <div id="n_ativo" name="Nenhum">
                        <p>Nenhum</p>
                    </div>
                </div>
                <h1>TIPO</h1>
                <div class="filtro_opcoes">
                    
                    <div onclick="checkFiltro(this)">
                        <input type="checkbox" name="Informática">
                        <p>Informática</p>
                    </div>
                    <div onclick="checkFiltro(this)">
                        <input type="checkbox" name="Mecânica">
                        <p>Mecânica</p>
                    </div>
                    <div onclick="checkFiltro(this)">
                        <input type="checkbox"  name="Eletrônica">
                        <p>Eletrônica</p>
                    </div>
                    <div onclick="checkFiltro(this)">
                        <input type="checkbox"  name="CTI">
                        <p>CTI</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="area_produtos">
            <p id='nenhum-produto-encontrado' style="display: none;">Nenhum produto encontrado com os filtros selecionados</p>

        <?php
        
        
        foreach ($produtos as $produto)
        {
            $excluido = $produto->getExcluido();
            if(!$excluido)
            {
                $estoque = $produto->getEstoque();
                if ($estoque > 0)
                {
                    $cod_produto = $produto->getCodProduto();
                    $nome = $produto->getNome();
                    $preco = $produto->getPreco();
                    $categoria = $produto->getCategoria();
                    $imagem = $produto->getImagem();
                    $descricao = $produto->getDescricao();

                    if ($categoria == null)
                    {
                        $categoria = 'Nenhuma categoria';
                    }
                    if(estaNoCarrinho($cod_produto))
                    {
                        $icone = 'Check_branco.svg';
                        $funcao = 'ver';
                    }
                    else{
                        $icone = 'shopping_branco.svg';
                        $funcao = 'add';
                    }

                    echo "
                    <div class = 'caixa_produto' id='$cod_produto'>
                        <div class='product'>
                            <img src='../$imagem' alt='Produto'>
                            <div>
                                <h1>$nome</h1> <!-- Nome -> H1 --> 
                                <p>$descricao
                                </p>

                                <div><p class='categoria'>$categoria</CTI></p>
                                    <p class='categoria'>$estoque à venda</CTI></p>
                                </div>
                                
                                <h3>$categoria</h3> <!-- Filtro(s) -> H3-->
                                <h3>Nenhum</h3>
                                
                                
                            </div>
                        </div>
                        <div class='product_botoes'>
                            <form action='../confirmarCompra.php' method='post'>
                                <input type='hidden' name='cod_produto' value='". $cod_produto ."'>
                                <input type='hidden' name='tipo' value='2'>
                                <button type='submit'>
                                    <p>COMPRAR</p>
                                </button>
                            </form>
                            <form action='../PHP/insereDadosCarrinho.php' method='post'>
                                <input type='hidden' name='cod_produto' value='". $cod_produto ."'>
                                <input type='hidden' name='funcao' value='$funcao'>
                                <button type='submit' id='add-cart' onclick='addCart(event)'>
                                    <p>+</p>
                                    <img src='../Icones/$icone' alt='carrinho'>
                                </button>
                            </form>

                            <h1>R$ $preco</h1>
                        </div>
                    </div>
                    ";
                }
            }
            
        }

        
        ?>
                
        </div>
    </section>

    <div id="produto_grande">
        <div id="pg_blur"></div>
        <div id="pg_info">
            <h1>Nome-produto</h1>
            <div class="div_img_grande">
                <div class="seta roda180" onclick="mudaImg(1)">
                    <img src="../Icones/Seta-img.svg">
                </div>
                
                <img src="../Imagens/Produtos/Cartas.jpg" id="img_grande">

                <div class="seta" onclick="mudaImg(0)">
                    <img src="../Icones/Seta-img.svg">
                </div>
            </div>

            <h1>R$ 10</h1>
            <h2>- Descricao produto -</h2>
            <div id="info_tipo_estoque"><p class="categoria">Filtro: ---</CTI></p>
                <p class="categoria">- à venda</CTI></p>
            </div>
            <div class="div_img_pequena">
                <img src="../Imagens/Produtos/1/P1.png" id="ativo" onclick="clickMudaImg(this)">
                <img src="../Imagens/Produtos/1/P2.png" onclick="clickMudaImg(this)">
                <img src="../Imagens/Produtos/1/P3.png" onclick="clickMudaImg(this)">
                <img src="../Imagens/Produtos/1/P4.png" onclick="clickMudaImg(this)">
                <div id="img_ativa" style="left: -10px"></div>
            </div>
            <p>Clique fora para fechar</p>
        </div>
    </div>

    <?php 
        Footer('../', '#produtos');
    ?>

    <!--<footer>
        <div class="tela_scroll_down up">
            <a href="#produtos" class="a"> 
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
                    vou colo'car'
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
