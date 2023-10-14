<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    include("PHP/caixa.php");

    inicioSessao();

    $conn = coneccao();
    
?>





<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="icon" type="image/x-icon" href="Icones/logo-bola-verde.svg">
    
    <title>Produtos - Tiny Wood</title>
</head>
<body class="over_hid">
    <script src="JS/produtos.js" defer></script>
    <script src="JS/index.js" defer></script>

    <div class="nav_nav container">
        <div class="nav_fundo nf_fixo"></div>
        <a href="index.html"><img src="Icones/logo-verde.svg" class="nav_logo" alt="Logo TINYWOOD"></a>


        <div class="nav_div_pesquisa">
                <div class="nav_pesquisa">
                    <img src="Icones/pesquisa_cinza.svg" class="nav_icon">
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
        
        <img src="Icones/menu-hamburguer.svg" class="nav_tres_risco" alt="Mais opções">
        <div class="nav_elementos">
            <div class="nav_risco"></div>
            <a href="index.html">
                <div class="nav_home">
                    <img class="nav_icon" src="Icones/home_preto.svg">
                    <p>HOME</p>
                </div>
            </a>
            <div class="nav_produtos"  id="nav_botao_ativo">
                <img class="nav_icon" src="Icones/shopping_branco.svg">
                <p>PRODUTOS</p>
            </div>
            <a href="sobre.html">
                <div class="nav_sobre">
                    <img class="nav_icon" src="Icones/sobre_preto.svg">
                    <p>SOBRE</p>
                </div>
            </a>

            <a href="carrinho.html">
                <div class="nav_info_lateral">
                    <img class="nav_icon2" src="Icones/carrinho_preto.svg">
                    <p>CARRINHO</p>
                </div>
            </a>
            
            <a href="PHP/usuario.php">
                <div class="nav_info_lateral">
                    <img class="nav_icon2" src="Icones/login_preto.svg">
                    <p>LOGIN</p>
                </div>
            </a>
        </div>
        
    </div>




    <section id="produtos" class="container">
        <div id="filtro">
            <h1  onclick="abreFiltro()">FILTROS
                <img src="Icones/Down.svg">
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
                        <input type="checkbox" name="INFORMATICA">
                        <p>INFORMATICA</p>
                    </div>
                    <div onclick="checkFiltro(this)">
                        <input type="checkbox" name="MECANICA">
                        <p>MECANICA</p>
                    </div>
                    <div onclick="checkFiltro(this)">
                        <input type="checkbox"  name="ELETRONICA">
                        <p>ELETRONICA</p>
                    </div>
                    <div onclick="checkFiltro(this)">
                        <input type="checkbox"  name="CTI">
                        <p>CTI</p>
                    </div>
                </div>
            </div>
        </div>

        <?php

        $sql = "select * from tbl_produto order by cod_produto";
        $select = $conn->query($sql);
        
        while($dados = $select->fetch()){
            $id = $dados['cod_produto'];

            if($id == 1){
                $cod1 = $dados['cod_produto'];
                $nome1 = $dados['nome'];
                $descricao1 = $dados['descricao'];
                $preco1 = $dados['preco'];
                $excluido1 = $dados['excluido'];
            }
            if($id == 2){
                $cod2 = $dados['cod_produto'];
                $nome2 = $dados['nome'];
                $descricao2 = $dados['descricao'];
                $preco2 = $dados['preco'];
                $excluido3 = $dados['excluido'];
            }
            if($id == 3){
                $cod3 = $dados['cod_produto'];
                $nome3 = $dados['nome'];
                $descricao3 = $dados['descricao'];
                $preco3 = $dados['preco'];
                $excluido3 = $dados['excluido'];
            }
            if($id == 4){
                $cod4 = $dados['cod_produto'];
                $nome4 = $dados['nome'];
                $descricao4 = $dados['descricao'];
                $preco4 = $dados['preco'];
                $excluido4 = $dados['excluido'];
            }
            if($id == 5){
                $cod5 = $dados['cod_produto'];
                $nome5 = $dados['nome'];
                $descricao5 = $dados['descricao'];
                $preco5 = $dados['preco'];
                $excluido5 = $dados['excluido'];
            }
            if($id == 6){
                $cod6 = $dados['cod_produto'];
                $nome6 = $dados['nome'];
                $descricao6 = $dados['descricao'];
                $preco6 = $dados['preco'];
                $excluido6 = $dados['excluido'];
            }
            if($id == 7){
                $cod7 = $dados['cod_produto'];
                $nome7 = $dados['nome'];
                $descricao7 = $dados['descricao'];
                $preco7 = $dados['preco'];
                $excluido7 = $dados['excluido'];
            }
            if($id == 8){
                $cod8 = $dados['cod_produto'];
                $nome8 = $dados['nome'];
                $descricao8 = $dados['descricao'];
                $preco8 = $dados['preco'];
                $excluido8 = $dados['excluido'];
            }
            if($id == 9){
                $cod9 = $dados['cod_produto'];
                $nome9 = $dados['nome'];
                $descricao9 = $dados['descricao'];
                $preco9 = $dados['preco'];
                $excluido9 = $dados['excluido'];
            }
            if($id == 10){
                $cod10 = $dados['cod_produto'];
                $nome10 = $dados['nome'];
                $descricao10 = $dados['descricao'];
                $preco10 = $dados['preco'];
                $excluido10 = $dados['excluido'];
            }
        };

        if($id >= 1){
            echo" <div id='area_produtos'>
            <!-- Neste caso o ID não é para estetica, mas indica que o id_produto é 1. -->
            <div class='product' id='1'>
                <img src='Icones/quadrados.png' alt='Produto'>

                <div>
                    <h1>$nome1</h1> <!-- Nome -> H1 -->
                    <h2>R$ $preco1</h2> <!--- Preço -> H2 -->
                    <h3>CTI</h3>
                    <h3>INFORMATICA</h3> <!-- Filtro(s) -> H3-->
                    <h3>Nenhum</h3>
                    <p>$descricao1</p>
                    <div class='product_botoes'>
                        <button>
                            <p>COMPRAR</p>
                        </button>
                        <form action='#'>
                            <button type='submit' id='add-cart'>
                                <p>+</p>
                                <img src='Icones/carrinho_branco.svg' alt='carrinho'>
                            </button>
                        </form>
                    </div>
                </div>
            </div> ";

        }
           
        if($id >= 2){
                    echo"
                    <div class='product' id='2'>
                        <img src='Icones/quadrados.png' alt='Produto'>
                        <div>
                            <h1>$nome2</h1> <!-- Nome -> H1 -->
                            <h2>R$ $preco2</h2> <!--- Preço -> H2 -->
                            <h3>CTI</h3> <!-- Filtro(s) -> H3-->
                            <h3>Nenhum</h3>
                            <h3>MECANICA</h3>
                            <p>$descricao2</p>
                            <div class='product_botoes'>
                                <button>
                                    <p>COMPRAR</p>
                                </button>
                                <form action='#'>
                                    <button type='submit' id='add-cart'>
                                        <p>+</p>
                                        <img src='Icones/carrinho_branco.svg' alt='carrinho'>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                ";
        }
        if($id >= 3){
                    echo"
                    <div class='product' id='3'>
                        <img src='Icones/quadrados.png' alt='Produto'>
                        <div>
                            <h1>$nome3</h1> <!-- Nome -> H1 -->
                            <h2>R$ $preco3</h2> <!--- Preço -> H2 -->
                            <h3>CTI</h3> <!-- Filtro(s) -> H3-->
                            <h3>Nenhum</h3>
                            <h3>ELETRONICA</h3>
                            <p>$descricao3</p>
                            <div class='product_botoes'>
                                <button>
                                    <p>COMPRAR</p>
                                </button>
                                <form action='#'>
                                    <button type='submit' id='add-cart'>
                                        <p>+</p>
                                        <img src='Icones/carrinho_branco.svg' alt='carrinho'>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>";
        }if($id >= 4){
                    echo"<div class='product' id='4'>
                    <img src='Icones/quadrados.png' alt='Produto'>
                    <div>
                        <h1>$nome4</h1> <!-- Nome -> H1 -->
                        <h2>R$ $preco4</h2> <!--- Preço -> H2 -->
                        <h3>Nenhum</h3> <!-- Filtro(s) -> H3-->
                        <p>$descricao4</p>
                        <div class='product_botoes'>
                            <button>
                                <p>COMPRAR</p>
                            </button>
                            <form action='#'>
                                <button type='submit' id='add-cart'>
                                    <p>+</p>
                                    <img src='Icones/carrinho_branco.svg' alt='carrinho'>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>";
        }
        if($id >= 5){
                    echo"<div class='product' id='5'>
                    <img src='Icones/quadrados.png' alt='Produto'>
                    <div>
                        <h1>$nome5</h1> <!-- Nome -> H1 -->
                        <h2>R$ $preco5</h2> <!--- Preço -> H2 -->
                        <h3>Nenhum</h3> <!-- Filtro(s) -> H3-->
                        <p>$descricao5</p>
                        <div class='product_botoes'>
                            <button>
                                <p>COMPRAR</p>
                            </button>
                            <form action='#'>
                                <button type='submit' id='add-cart'>
                                    <p>+</p>
                                    <img src='Icones/carrinho_branco.svg' alt='carrinho'>
                                </button>
                            </form>
                        </div>
                    </div>
                </div> ";
        }
        if($id >= 6){
                    echo"<div class='product' id='6'>
                    <img src='Icones/quadrados.png' alt='Produto'>
                    <div>
                        <h1>$nome6</h1> <!-- Nome -> H1 -->
                        <h2>R$ $preco6</h2> <!--- Preço -> H2 -->
                        <h3>Nenhum</h3> <!-- Filtro(s) -> H3-->
                        <p>$descricao6</p>
                        <div class='product_botoes'>
                            <button>
                                <p>COMPRAR</p>
                            </button>
                            <form action='#'>
                                <button type='submit' id='add-cart'>
                                    <p>+</p>
                                    <img src='Icones/carrinho_branco.svg' alt='carrinho'>
                                </button>
                            </form>
                        </div>
                    </div>
                </div> ";
        }
        if($id >= 7){
                    echo"<div class='product' id='7'>
                    <img src='Icones/quadrados.png' alt='Produto'>
                    <div>
                        <h1>$nome7</h1> <!-- Nome -> H1 -->
                        <h2>R$ $preco7</h2> <!--- Preço -> H2 -->
                        <h3>Nenhum</h3> <!-- Filtro(s) -> H3-->
                        <p>$descricao7</p>
                        <div class='product_botoes'>
                            <button>
                                <p>COMPRAR</p>
                            </button>
                            <form action='#'>
                                <button type='submit' id='add-cart'>
                                    <p>+</p>
                                    <img src='Icones/carrinho_branco.svg' alt='carrinho'>
                                </button>
                            </form>
                        </div>
                    </div>
                </div> ";
        }
        if($id >= 8){
                    echo"<div class='product' id='8'>
                    <img src='Icones/quadrados.png' alt='Produto'>
                    <div>
                        <h1>$nome8</h1> <!-- Nome -> H1 -->
                        <h2>R$ $preco8</h2> <!--- Preço -> H2 -->
                        <h3>Nenhum</h3> <!-- Filtro(s) -> H3-->
                        <p>$descricao8</p>
                        <div class='product_botoes'>
                            <button>
                                <p>COMPRAR</p>
                            </button>
                            <form action='#'>
                                <button type='submit' id='add-cart'>
                                    <p>+</p>
                                    <img src='Icones/carrinho_branco.svg' alt='carrinho'>
                                </button>
                            </form>
                        </div>
                    </div>
                </div> ";
        }
        if($id >= 9){
                    echo"<div class='product' id='9'>
                    <img src='Icones/quadrados.png' alt='Produto'>
                    <div>
                        <h1>$nome9</h1> <!-- Nome -> H1 -->
                        <h2>R$ $preco9</h2> <!--- Preço -> H2 -->
                        <h3>Nenhum</h3> <!-- Filtro(s) -> H3-->
                        <p>$descricao9</p>
                        <div class='product_botoes'>
                            <button>
                                <p>COMPRAR</p>
                            </button>
                            <form action='#'>
                                <button type='submit' id='add-cart'>
                                    <p>+</p>
                                    <img src='Icones/carrinho_branco.svg' alt='carrinho'>
                                </button>
                            </form>
                        </div>
                    </div>
                </div> ";
        }
        if($id >= 10){
                    echo"<div class='product' id='10'>
                    <img src='Icones/quadrados.png' alt='Produto'>
                    <div>
                        <h1>$nome10</h1> <!-- Nome -> H1 -->
                        <h2>R$ $preco10</h2> <!--- Preço -> H2 -->
                        <h3>Nenhum</h3> <!-- Filtro(s) -> H3-->
                        <p>$descricao10</p>
                        <div class='product_botoes'>
                            <button>
                                <p>COMPRAR</p>
                            </button>
                            <form action='#'>
                                <button type='submit' id='add-cart'>
                                    <p>+</p>
                                    <img src='Icones/carrinho_branco.svg' alt='carrinho'>
                                </button>
                            </form>
                        </div>
                    </div>
                </div> ";
        }
                
echo"
            </div>
    </section>
        ";

?>

    <div id="produto_grande">
        <div id="pg_blur"></div>
        <div id="pg_info">
            <h1>CHAVEIRO CARRARO</h1>
            <div class="div_img_grande">
                <div class="seta roda180" onclick="mudaImg(1)">
                    <img src="Icones/Seta-img.svg">
                </div>
                
                <img src="Imagens/Produtos/1/produto1.png" id="img_grande">

                <div class="seta" onclick="mudaImg(0)">
                    <img src="Icones/Seta-img.svg">
                </div>
            </div>

            <div class="div_img_pequena">
                <img src="Imagens/Produtos/1/produto1.png" id="ativo" onclick="clickMudaImg(this)">
                <img src="Imagens/Produtos/1/produto2.png" onclick="clickMudaImg(this)">
                <img src="Imagens/Produtos/1/produto3.png" onclick="clickMudaImg(this)">
                <img src="Imagens/Produtos/1/produto4.png" onclick="clickMudaImg(this)">
                <div id="img_ativa" style="left: -10px"></div>
            </div>
            <p>Clique fora para fechar</p>
        </div>
    </div>
    <footer>
        <div class="tela_scroll_down up">
            <a href="#produtos" class="a"> 
                <h1>Voltar ao topo</h1> 
                <img src="Icones/arrow.svg">
            </a>
        </div>
        <div id="f_1"></div>
        <div id="f_2"></div>
        <div id="f_3"></div>
        <div id="f_4"></div>
        <div id="f_5"></div>

        <div class="footer_logo">
            <img src="Icones/logo-bola-branco.svg" alt="Logo da Tiny Wood">
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
    </footer>
</body>
</html>
