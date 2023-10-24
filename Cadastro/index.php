<?php 
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);
    include("../PHP/caixa.php");
    
    
    if (isset($_GET['erro']))
    {
        $erro = $_GET['erro'];
    }
    else{
        $erro = 0;
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
           

            <a href="cadastro.html">
                <div class="nav_info_lateral">
                    <img class="nav_icon2" src="../Icones/carrinho_preto.svg">
                    <p>CARRINHO</p>
                </div>
            </a>
            
            <div class="nav_info_lateral"  id="nav_botao_ativo">
                <img class="nav_icon2" src="../Icones/login_branco.svg">
                <p>CADASTRO</p>
            </div>
        </div>
        
    </div> -->

    <?php 
        barraNavegacao('', '../');
    ?>

    <section class="container sec_login" id="topo">
        <div class="cadastro tela_log_cad">
            <h1>CADASTRAR-SE</h1>
            <?php 
            if ($erro == 1)
            {
                echo "<p>Senhas não conhecidem! </p>";
            }
            else if ($erro == 2)
            {
                echo "<p>Esse e-mail já possui conta! </p>";
            }
            ?>

            <form action='../PHP/insereDadosUsuario.php' method='post'>
                <input type='hidden' name='funcao' value='cadastro'>
                <div class="nome inp">
                    <?php 
                     echo "<input type='text' name='nome' maxlength='80'>";
                    ?>
                    <p>Nome</p>
                </div>
                <div class="email inp">
                    <?php 
                        echo "<input type='email' name='email' maxlength='100'>";
                    ?>
                    <p>E-mail</p>
                </div>
                <div class="telefone inp">
                    <?php 
                        echo "<input type='tel' name='telefone' maxlength='13'>";
                    ?>
                    <p>Telefone</p>
                </div>
                <div class="senha inp">
                    <input type="password" name="senha" maxlength="40">
                    <p>Senha</p>
                </div>
                <div class="senha_c inp">
                    <input type="password" name="senha_c" maxlength="40">
                    <p>Confirmar senha</p>
                </div>
                <div class="lembrarme">
                    <input type="radio" name="lembrar" id="lembrar" value='1'>
                    <p>Lembrar-me</p>
                </div>
                <div class="btn">
                    <input type="submit" value="CADASTRE-SE">
                </div>
            </form>
                <div class="troca_log_cad">
                    <a href="../Login">
                    <p id="black_text">Já possuí uma conta?</p>
                    <p>Faça o login.</p>
                </a>
                </div>
        </div>
    </section>
    <?php 
        Footer('../', '#topo');
    ?>
    <!-- <footer>
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