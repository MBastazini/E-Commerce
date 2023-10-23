<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("PHP/caixa.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="icon" type="image/x-icon" href="Icones/logo-bola-verde.svg">
    <title>Tiny Wood</title>
</head>
<body>
    <script src="JS/home.js" defer></script>
    <script src="JS/index.js" defer></script>
    

    <!--<div class="nav_nav nav_sobe container">
        <div class="nav_fundo nf_fixo"></div>
        <a href="index.html"><img src="Icones/logo-verde.svg" class="nav_logo" alt="Logo TINYWOOD"></a>


        <div class="nav_div_pesquisa">
                <div class="nav_pesquisa">
                    <img src="Icones/pesquisa_cinza.svg" class="nav_icon">
                    <input type="text" placeholder="Pesquisar...">
                </div>
                <div class="nav_p_resultados">

                
                </div>
        </div>
        
        <img src="Icones/menu-hamburguer.svg" class="nav_tres_risco" alt="Mais opções">
        <div class="nav_elementos">
            <div class="nav_risco"></div>
     
            <div class="nav_home" id="nav_botao_ativo">
                <img class="nav_icon" src="Icones/home_branco.svg">
                <p>HOME</p>
            </div>
            <a href="produtos.php">
                <div class="nav_produtos">
                    <img class="nav_icon" src="Icones/shopping_preto.svg">
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
                
            </a>
        </div>
        
    </div> -->

    <?php 
        barraNavegacao('home', '');
    ?>
    <section id="telaInicio">
        <div class="tela_inicial_flex">
            <div id="gradiente"></div>
            <div class="tela_inicial container">
                <div class="texto_inicial">
                    <h1>Chaveiros</h1>
                    <div class="tela_madeira">
                        <div class="tela_verde_esquerda">
                        </div>
                        <h1 class="hidden">_</h1>
                    </div>
                    <p>Adquira já! Uma lembrança única com um estilo natural, 
                        ideal para todos os lugares, <br> Tiny Wood, chaveiros de madeira!
                    </p>
                    <a href="produtos.php">
                        <div class="tela_botao">
                            <p>GARANTA O SEU!</p>
                        </div>
                    </a>              
                </div>
            </div>
        </div>
        <div class="tela_scroll_down">
        <a href="#infos" class="a"> 
            <h1>Scrolle para mais</h1> 
            <img src="Icones/arrow.svg">
        </a>
        </div>
    </section>
    <section id="infos">
        <div class="infos_c">
            <div class="info_bolinhas">
                <div id="bola_ativa"></div>
                <div style="order: 1;"></div>
                <div></div>
            </div>
            <div class="info01_container hidden">
                <div class="info01_1 inf1_e">
                    <img src="Imagens/tronco.jpg" alt="Imagem01">
                    <div class="info01_1_div">
                        <h1>Fase 3 - Viva CTI</h1>
                        <p>Por fim, o chaveiro Tiny wood está finalizado! 
                            Pronto para te conectar com a natureza em todos os momentos!</p>
                    </div>
                </div>
                <div class="info01_1 inf1_c">
                    <img src="Imagens/lixa.jpg" alt="Imagem02">
                    <div class="info01_1_div">
                        <h1>Fase 1 - Urbanwood</h1>
                        <p>
                            A escolha cuidadosa da madeira é crucial para a qualidade do produto, 
                            por isso confiamos à Urbanwood, que realiza uma extração ecologicamente sustentável.</p>
                    </div>
                </div>
                <div class="info01_1 inf1_d">
                    <img src="Imagens/folha.jpg" alt="Imagem03">
                    <div class="info01_1_div">
                        <h1>Fase 2 - FabLab</h1>
                        <p>
                            após cortada, a peça de madeira será lixada, uma etapa essencial para realçar a textura e dar seu acabamento, 
                            furada, gravada à laser na FabLab com nossos designs e por fim tratadas com óleo mineral. </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="info_video container">
            <div id="risco"></div>
            <div class="video_texto">
                <h1>Os chaveiros</h1>
                <p>A madeira é um material naturalmente belo, reflete a perfeição na 
                simplicidade, cada peça com um tom e textura única para você! 
                Oferecemos uma lembrança material acessível que te conecta com a natureza, 
                juntamente de nossas identidades visuais para encantar os nossos chaveiros!
                </p>
            </div>
            <div class="video_v">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/jWOetWUeAts?si=M14RkQutcYtTMVAM" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                allowfullscreen></iframe>            
            </div>

        </div>
    </section>

    <section class="produtos">
        <div class="titulo t_esquerda hidden">
            <p id='hrefprod'>PRODUTOS</p>
        </div>
        <div class="area_produtos container">
            <p>Passe o mouse por cima para mais informações</p>
            <div class="produtos_container hidden">
                <span id="produto_padding"></span>
                <?php 
                    $produtos = tblProduto();
                    
                    foreach($produtos as $produto)
                    {
                        $cod_produto = $produto->getCodProduto();
                        $nome = $produto->getNome();
                        $preco = $produto->getPreco();
                        if(estaNoCarrinho($cod_produto))
                        {
                            $icone = 'Check_branco.svg';
                            $funcao = 'ver';
                        }
                        else{
                            $icone = 'shopping_branco.svg';
                            $funcao = 'add++';
                        }
                        echo "<div class='produto'> 
                            <div class='produto_info'>
                                <div class='produto_texto'>
                                    <p> R$ ". $preco."</p>
                                    <h1>".$nome."</h1>
                                </div>
                                <div class='produto_botao'>
                                    <a href='#'>
                                        <div>
                                            <img src='Icones/shopping_branco.svg' alt='Carrinho de compras'>
                                            <p>Comprar</p>
                                        </div>
                                    </a>
                                    <form action='PHP/insereDadosCarrinho.php' method='post'>
                                        <input type='hidden' name='cod_produto' value='". $cod_produto ."'>
                                        <input type='hidden' name='funcao' value='$funcao'>
                                        <button onclick='addCart()'>
                                            <img src='Icones/$icone' alt='Carrinho de compras'>
                                            <p>+ Carrinho</p>
                                        </button>
                                    </form>
                                    <a href='Produtos/#produto_$cod_produto'>
                                        <div>
                                            <img src='Icones/sobre_branco.svg' alt='Carrinho de compras'>
                                            <p>Ver mais</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>";  
                    }
                    
                ?>
                <span id="produto_padding"></span>
            </div>
        </div>
    </section>
    <section class="ler_mais">
        <div class="titulo t_direita">
            <p>SOBRE NÓS</p>
        </div>
        <div class="sobre container">
            <h1>A TINY WOOD</h1>
            <p>A tiny wood é com muoi=to orgulhoema dbela mensgam amla escreita eu ti socm osmeno bnoa quero ter aiula
                isso e so um teste de mensagem nção queria usar o lorem poderia/ claro que sim mas nãio querioa
                depois que mudo uisso se achar que ta m uot grande tambem, nem sei se tem tyanha coisa pras ecsrveer mesmo.
                <br><br>
                Honestamente, nem sei o que por aqui, e se repitir la no footer? fica estranho e a seção é 
                muito pequena, vou seguindo e da pra mudar dps, tudo dá.
            </p>
        </div>
    </section>
    <?php 
        Footer('', '#telaInicio');
    ?>
    <!--<footer>
        <div class="tela_scroll_down up">
            <a href="#telaInicio" class="a"> 
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
    </footer>-->
</body>
</html>



