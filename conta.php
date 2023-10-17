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
    <title>Tiny Wood</title>
</head>
<body>
    <script src="JS/conta.js" defer></script>
    <script src="JS/index.js" defer></script>
    <script src="JS/login.js" defer></script>

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
     
            <div class="nav_home">
                <img class="nav_icon" src="Icones/home_preto.svg">
                <p>HOME</p>
            </div>
            <a href="produtos.html">
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
                <div class="nav_info_lateral" id="nav_botao_ativo">
                    <img class="nav_icon2" src="Icones/login_branco.svg">
                    <p>LOGIN</p>
                </div>
            </a>
        </div>
        
    </div>

    <section class="container" id="conta">
        <h1>Sua conta</h1>
        <h2>Nomerson de Uzzuario</h2>
        <form action="PHP/minhaconta.php" method="post" id="conta_form">
            <div class="edit_btn disabled">
                <p>Editar informações</p>
                <img src="Icones/edit.svg">
            </div>

            <div class="info_conta">
                <?php 
                    if (isset($_SESSION['conectado'])){
                        $conectado = $_SESSION['conectado'];
                    }
                    else{
                        $conectado = false;
                    }

                    if ($conectado)
                    {
                        $sql = "SELECT * FROM tbl_usuario WHERE cod_usuario = ".$_SESSION['cod_usuario'];
                        $select = $conn->prepare($sql);
                        $select->execute();
                        $resultado = $select->fetch();
                        $nome = $resultado['nome'];
                        $email = $resultado['email'];
                        $telefone = $resultado['telefone'];
                        $senha = $resultado['senha'];
                        echo"<div class='inp disabled'>
                        <input type='text' value='". $nome ."' disabled name='nome'>
                        <p>Nome</p>
                        </div>";

                        echo"<div class='inp disabled'>
                        <input type='email' value='". $email ."' disabled name='email'>
                        <p>E-Mail</p>
                        </div>";

                        echo"<div class='inp disabled'>
                        <input type='tel' value='". $telefone ."' disabled name='telefone'>
                        <p>Telefone</p>
                        </div>";

                        echo"<div class='inp disabled'>
                        <input type='password' value='". $senha ."' disabled name='senha'>
                        <p>Senha</p>
                        </div>";

                        echo"<input type='hidden' value='". $_SESSION['cod_usuario'] ."' name='codigo'>";
                    }
                ?>
            </div>
            <input type="submit" value="Salvar alterações" id="btn_submit">
        </form>
        <a href="PHP/logout.php">
            <div class="edit_btn" id="logout">
                <p>LOGOUT</p>
                <img src="Icones/logout_branco.svg">
            </div>
        </a>

        <h1>Informações de compras efetuadas</h1>
        <div id="info_c_h">
            <p>Nome do produto</p>
            <p>Quantidade</p>
            <p>Preço total</p>
            <p>Data da compra</p>
        </div>
        <div id="info_compra">
            
            <?php 
                if ($conectado)
                {
                    $sql2 = "
                    SELECT p.nome, p.preco, cp.quantidade, c.data_compra, c.status FROM tbl_compra_produto AS cp 
                    INNER JOIN tbl_produto AS p ON p.cod_produto = cp.cod_produto 
                    INNER JOIN tbl_compra AS c ON c.cod_compra = cp.cod_compra
                    WHERE c.status = 'finalizado';
                    ";
                    $select2 = $conn->prepare($sql2);
                    $select2->execute();
                    while ($resultado2 = $select2->fetch()){
                        echo"<div>
                            <p>". $resultado2['nome'] ."</p>
                            <p>". $resultado2['quantidade'] ."</p>
                            <p>". $resultado2['preco'] ."</p>
                            <p>". $resultado2['data_compra'] ."</p>
                        </div>";
                    }
                }   
            ?>
        </div>

        <h1>Sessões ativas</h1>
        <div id="info_c_h" class="token">
            <p>Data da criação</p>
            <p>Ip da maquina de criação</p>
            <p>Deletar / Apagar sessão</p>
        </div>
        <div id="info_compra" class="token">    
            <?php 
                if ($conectado)
                {
                    $sql_token = "SELECT * FROM tbl_token WHERE cod_usuario = :cod_usuario";
                    $select_token = $conn->prepare($sql_token);
                    $select_token->execute(['cod_usuario' => $_SESSION['cod_usuario']]);
                    $info_token = $select_token->fetch();

                    if ($info_token != NULL){
                        echo"
                        <div> 
                        <p>". $info_token['data_criacao'] ."</p>
                        <p>". $info_token['ip_criacao'] ."</p>
                        <form action='PHP/deletatoken.php' method='post' id='form-token'>
                            <button type='submit' name='deletar' value='". $info_token['cod_token'] ."'>
                                <p>DELETAR</p>
                            </button>
                        </form>
                        </div>";
                    }
                    else{
                        echo"<p>Não há sessões ativas</p>";
                    }
                    
                }
            
            ?>
        </div>
    </section>

    <footer>
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
    </footer>
    </body>
</html>