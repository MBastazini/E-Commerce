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

    <title>Sobre - Tiny Wood</title>
</head>
<body class="over_hid"></body>
    <script src="../JS/sobre.js" defer></script>
    <script src="../JS/index.js" defer></script>
    <!-- <div class="nav_nav container">
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
            
            <div class="nav_sobre" id="nav_botao_ativo">
                <img class="nav_icon" src="../Icones/sobre_branco.svg">
                <p>SOBRE</p>
            </div>
            
            <a href="carrinho.html">
                <div class="nav_info_lateral">
                    <img class="nav_icon2" src="../Icones/carrinho_preto.svg">
                    <p>CARRINHO</p>
                </div>
            </a>
            
            <a href="login.html">
                <div class="nav_info_lateral">
                    <img class="nav_icon2" src="../Icones/login_preto.svg">
                    <p>LOGIN</p>
                </div>
            </a>
        </div>
        
    </div> -->

    <?php 
        barraNavegacao('sobre', '../');
    ?>

    <section class="container" id="tela_sobre">
        <h1>TINY WOOD</h1>
        <p>“Conectado com a natureza em todos os lugares“</p>
        <div class="sobre_img">
            <img src="../Icones/foto-teste.png">
        </div>
        <div class="info_tiny_wood">
            <h1 class="titulo t_centro">SOBRE NÓS</h1>
            <p>A Tiny Wood é uma empresa LTDA composta por alunos do ensino médio do Colégio Técnico Industrial de Bauru, 
                desenvolvida como um projeto de startup com cunho didático, orientada por nossos professores 
                Jovita Mercedes, Marcelo Cabello, Débora Aires e José Vieira. Confeccionado artesanalmente a 
                criação do produto final e seu canal de vendas online, associados à tecnologia, inovação e 
                sustentabilidade.
            </p>
            <div>
                
            </div>
            <h2 id="contato">CONTATE-NOS</h2>
            <div id="sobre_contato">
                <div onclick="CopyMessage(this)">
                    <img src="../Icones/copy.svg">
                     <p>Telefone</p>
                     <h1>+55 (14) 99794-3704</h1>
                </div>
                <div onclick="CopyMessage(this)">
                    <img src="../Icones/copy.svg">
                     <p>E-mail</p>
                     <h1>tinywood@projetoscti.com.br</h1>
                 </div>
             </div>
        </div>

        <div class="info_tiny_wood">
            <h1 class="titulo t_centro">DESENVOLVEDORES</h1>
            <div id="sobre_devs">
                <div class="dev" id="mateus">
                    <div class="dev_btn enabled"></div>
                    <h1>Mateus Bastazini<br>N°24</h1>
                    <div class="dev_img"></div>
                    <p> Financeiro e lider tecnico, responsavel pelo 
                        CSS / HTML / JavaScript e design do site, ajudou na lixação
                        e corte a laser das madeiras,
                        inclusive é ele quem esta escrevendo isso, Bom dia.

                    </p>
                </div>
                <div class="dev enabled" id="luiz">
                    <div class="dev_btn"></div>
                    <h1>Luiz Felipe<br>N°22</h1>
                    <div class="dev_img"></div>
                    <p> Lider geral, responsavel pelo backend e banco de dados,
                        alem de ser o responsavel pela ideia de chaveiros de madeira,
                        e quem mais ajudou a obte-las e trata-las.

                    </p>
                </div>
                <div class="dev enabled" id="leticia">
                    <div class="dev_btn"></div>
                    <h1>Leticia Garcia<br>N°21</h1>
                    <div class="dev_img"></div>
                    <p> Qualidade, responsavel, juntamente com a Mariana, pelos mapas
                        conceituais e logicos do banco de dados, alem de ajudar
                        na obtenção dos metais para os chaveiros, lixação e no corte a laser.

                    </p>
                </div>
                <div class="dev enabled" id="mariana">
                    <div class="dev_btn"></div>
                    <h1>Mariana Senger<br>N°23</h1>
                    <div class="dev_img"></div>
                    <p> Produção, responsavel, juntamente com a Leticia, pelos mapas
                        conceituais e logicos do banco de dados, alem de montar o design dos chaveiros
                        e ajudar com a lixação.

                    </p>
                </div>
                <div class="dev enabled" id="matheus">
                    <div class="dev_btn"></div>
                    <h1>Matheus Trentini<br>N°25</h1>
                    <div class="dev_img"></div>
                    <p> Marketing, montou o documento necessario para o envio do projeto e conseguiu um patrocinio.

                    </p>
                </div>
            </div>
            <p id='ps'>P. S. O primeiro desenvolvedor esta torto, não acha?<br>
            porque não dá uma ajeitada?</p>
        </div>
        
    </section>

    <?php 
        Footer('../', '#tela_sobre');
    ?>

    <!-- <footer>
        <div class="tela_scroll_down up">
            <a href="#tela_sobre" class="a"> 
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